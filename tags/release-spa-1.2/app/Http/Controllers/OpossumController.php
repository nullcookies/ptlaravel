<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\OposSpaCustomer;
use App\Models\Product;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Merchant;
use App\Models\Currency;
use App\Models\Globals;
use App\Models\OposSparoom;
use App\Models\OposReceiptproduct;
use App\Models\OposReceipt;
use App\Models\OposDiscount;
use App\Models\OposMerchantterminal;
use App\Models\OposTerminal;
use Auth;
use DB;
use Log;
use Carbon;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UtilityController;
use App\Models\User;
use App\Models\Address;
use App\Models\OposSave;


class OpossumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        DB::enableQueryLog();
    }
    public function index($terminal_id=null)
    {
        
        if (!Auth::check()) {
            return view("common.generic")
            ->with("message","Please login to access this page.")
            ->with("message_type","error");
        }

        $user_id = Auth::user()->id;
		$staff_user_id = null;

		if (Auth::user()->hasRole("byr")) {
			$staff_user_id = $user_id;
			Log::info('Staff: OPOSsum via Buyer Dashboard');
			Log::info('Staff user_id='.$staff_user_id);
 			$user_id = DB::table('role_users')->
				join('roles','roles.id','=','role_users.role_id')->
				join('company','company.id','=','role_users.company_id')->
				where('user_id',$user_id)->
				whereIn('roles.slug',['opu','opm'])->
				pluck('company.owner_user_id');
		}
		Log::info('Merchant user_id='.$user_id);
        $merchant_id = $user_id;
		/* Getting the company from a regular merchant user */
        $company=Company::where('company.owner_user_id',$user_id)->
			join("merchant","merchant.user_id","=","company.owner_user_id")->
			join("users","users.id","=","merchant.user_id")->
			leftJoin('address','merchant.address_id','=','address.id')->
			leftJoin('city','address.city_id','=','city.id')->
			leftJoin('state','city.state_code','=','state.code')->
			select('address.line1','address.line2','address.line3',
				'city.name','state.name','address.postcode',
				'company.dispname','company.id','merchant.gst',
				'users.first_name as first_name',
				'users.last_name as last_name',
				'users.name','users.id as user_id')->
			first();
		Log::debug('***** OPOSsum Controller: company *****');
		Log::debug($company);
                
        $company_id = !empty($company->id)?$company->id:"0";
		//dump('company_id='.$company_id);

		/* Overwrite Staff ID if real staff actually logs in from BD */
		if (!empty($staff_user_id)) {
			$company->user_id = $staff_user_id;

			/* Get the name of the staff */
			$u = DB::table('users')->
				where('id',$staff_user_id)->
				first();

			if (empty($u->name)) {
				Log::debug('first_name='.$u->first_name);
				Log::debug('last_name ='.$u->last_name);
				
				if (empty($u->first_name) and empty($u->last_name)) {
					$company->name = $u->email;
				} else {
					$company->name = $u->first_name." ".$u->last_name;
				}
			} else {
				$company->name = $u->name;
			}
                        
		} else {
			/* Merchant user account */
//			Log::debug('name      ='.!empty($company->name)?$company->name:"");
//			Log::debug('first_name='.!empty($company->first_name)?$company->first_name:"");
//			Log::debug('last_name ='.!empty($company->last_name)?$company->last_name:"");
		if(!empty($company->name)){	
                    if (empty($company->name)) {
				$company->name = $company->first_name." ".$company->last_name;
			}
                }
        }
        
        
        $currentCurrency = Currency::where('active',1)->pluck('code');
        $gst_rate = Globals::pluck('gst_rate');
        $cache_reload_time = Globals::pluck('opossum_product_cache_expiry');
      /*  $sparooms = OposSparoom::orderBy('room_no','ASC')->get();*/
        $sparoomquery=$this->sparoomquery();
        $sparooms=DB::select(DB::raw($sparoomquery));
            //sparooms);
        $lockerkeyquery=$this->lockerkeyquery();
        $hotelroomquery=$this->hotelroomquery();
        $hotelroomquery=DB::select(DB::raw($hotelroomquery));
        $lockerkeys=DB::select(DB::raw($lockerkeyquery));
        /*$ftype=$data=[
                "checkin_tstamp"=>$checkin_tstamp,
                "receipt_id"=>$receipt_id,
                "ref_no"=>$r->ref_no,
                "ftype_id"=>$r->id,
                "ftype"=>$ftype,
                "txn_id"=>$txn_id
            ];

*/      
            /*DataQUery should be seperate out*/
       
        /*dd($data);*/
        $table = $this->table();

		$sparoom_validation  = DB::table("opos_ftype")->where("ftype","sparoom")->whereNull("deleted_at")->lists('fnumber');       
        $lockerkey_validation=DB::table("opos_ftype")->where("ftype","lockerkey")->whereNull("deleted_at")->lists('fnumber');   
        $table_validation=DB::table("opos_ftype")->where("ftype","table")->whereNull("deleted_at")->lists('fnumber');   

        $staff_members = DB::select(
			"select
				u.id,
				 CONCAT(u.first_name,' ',u.last_name) as staff_name,
				 n.nbuyer_id as staff_id
			from
				users u,
				roles r,
				member m,
				nbuyerid n,
				role_users ru 
			where
				m.user_id=u.id AND
				ru.user_id=u.id and
				ru.role_id=r.id and
				m.user_id=n.user_id and
				(r.slug='spm' or
				r.slug='spu' or r.slug='mas') and				
				m.type='member' and
				m.company_id=$company_id
			group by
				u.id;
        ");
         $member=\App\Models\OposTerminalUsers::leftJoin("users","users.id","=","opos_terminalusers.user_id")
                ->where("users.id","=",$user_id)->first();
         $bdata = DB::table('merchant')
                    ->select('bfunction')
                     ->orderby('id','desc')
                    ->first();
        $bfunction = $bdata->bfunction;
        return view('opposum.trunk.newindex',
			compact('barcodearr','currentCurrency','gst_rate',
				'cache_reload_time','company','sparooms','staff_members',
				'sparoom_validation','lockerkeys','table',
				'lockerkey_validation','bfunction',
				'table_validation', 'merchant_id',"member","hotelroomquery"));
    }

	public function getMemberLocationData(Request $request){
		$user_id = Auth::user()->id;
		$merchant_user=[];
		$member=\App\Models\OposTerminalUsers::select(
			"opos_terminalusers.terminal_id as terminal_id",
			"fairlocation.location as branch_name",
			"users.id as staffid",
			"users.first_name as first_name",
			"users.last_name as last_name",
			"fairlocation.company_name as company_name", "fairlocation.id as location_id")
				->leftJoin("users","users.id","=","opos_terminalusers.user_id")
				->leftJoin("merchant","merchant.user_id","=","opos_terminalusers.user_id")
				->leftJoin("opos_locationterminal as oplt","oplt.terminal_id","=",
					"opos_terminalusers.terminal_id")       
				->leftJoin("fairlocation","oplt.location_id","=","fairlocation.id")
				->where("opos_terminalusers.terminal_id", "=", $request->terminal_id);

		if(!Auth::user()->hasRole("byr")){
			$member=$member->first();
		}
                
		if(Auth::user()->hasRole("byr")){
			$member->where("opos_terminalusers.user_id","=",$user_id)->first();

		} else if(Auth::user()->hasRole("adm")){

			/* Admin cannot use it's user_id, you must pass in the user_id */
			$merchant_user= Merchant::select("fairlocation.location as branch_name",
				"users.id as staffid",
				"users.first_name",
				"fairlocation.location as branch_name",
				"users.last_name",
				"fairlocation.company_name as company_name",
				"fairlocation.id as location_id")
					->leftJoin("users","users.id","=","merchant.user_id")
					/* Admin accessing the merchant users, should not need to be in locationusers */
					->leftJoin("locationusers","locationusers.user_id","=","users.id")
					->leftJoin("fairlocation","fairlocation.id","=",
						"locationusers.location_id")
					->where('merchant.user_id','=',$request->merchant_id)->first();   



			Log::debug('*********** ADMIN ACCESS ************');
			Log::debug($merchant_user);

			$merchant_user->terminal_id=$member->terminal_id;
			if(count($merchant_user)>0){
				$merchant_user->staffname = $merchant_user->first_name." ".$merchant_user->last_name;
				if(!empty($merchant_user->terminal_id)){
					$terminal_id=$request->input("terminal_id");
					if(empty($terminal_id)){
						$merchant_user->terminal_id=sprintf("%05d",$merchant_user->terminal_id);
					} else {
						$merchant_user->terminal_id=sprintf("%05d",$terminal_id);
					}   
				}

				if(!empty($merchant_user->staffid)){
					$merchant_user->staffid=sprintf("%010d",$merchant_user->staffid);
				}
				
			} else {
				$merchant_user = array();
			}

			return response()->json($merchant_user);

		} else {
			/* This is the merchant user accessing */
			$merchant_user= Merchant::select("fairlocation.location as branch_name",
				"users.id as staffid",
				"users.first_name",
				"users.last_name",
				"fairlocation.location as branch_name",
				"fairlocation.company_name as company_name",
				"fairlocation.id as location_id")
					->leftJoin("users","users.id","=","merchant.user_id")
					// Merchant users should not be locationusers 
					/*
					->leftJoin("locationusers","locationusers.user_id","=","users.id")
					->leftJoin("fairlocation","fairlocation.id","=",
						"locationusers.location_id")
					*/
					->leftJoin("fairlocation","fairlocation.user_id","=",
						"merchant.user_id")
					->leftJoin("opos_locationterminal","opos_locationterminal.location_id","=",
						"fairlocation.id")
					->where('users.id','=',$user_id)->first();  

			Log::debug('*********** MERCHANT ACCESS ************');
			Log::debug($merchant_user);

			$merchant_user->terminal_id=$member->terminal_id;
			if(count($merchant_user)>0){
				$merchant_user->staffname = $merchant_user->first_name." ".$merchant_user->last_name;
				if(!empty($merchant_user->terminal_id)){
					$terminal_id=$request->input("terminal_id");

					if(empty($terminal_id)){
						$merchant_user->terminal_id=sprintf("%05d",$merchant_user->terminal_id);
					} else {
						$merchant_user->terminal_id=sprintf("%05d",$terminal_id);
					}   
				}

				if(!empty($merchant_user->staffid)){
					$merchant_user->staffid=sprintf("%010d",$merchant_user->staffid);
				}
            
			} else {
				$merchant_user = array();
			}

			return response()->json($merchant_user);      
		}

		return response()->json($member);
	}


    public function operation_hours_variables(Request $request){
        $array=[];
         $user_id     = Auth::user()->id;
        $terminal_id=$request->input("terminal_id");
        $member=\App\Models\OposTerminalUsers::leftJoin("users","users.id","=","opos_terminalusers.user_id")
                ->where("opos_terminalusers.terminal_id","=",$terminal_id);
         if(Auth::user()->hasRole("adm")){
             $member->where("opos_terminalusers.user_id","=",$request->merchant_id);
         }
         else if(Auth::user()->hasRole("byr")){  
             $member->where("opos_terminalusers.user_id","=",$user_id);
         }
         $member=$member->first();
        if(!empty($member->terminal_id)){
            
        $terminal=\App\Models\OposTerminal::where("id","=",$member->terminal_id)
                ->first();
		$array["start_time"] = $this->convertToEpoch(
			$terminal->start_work,
			$terminal->start_work,
			$terminal->end_work
		);
		$array["end_time"] = $this->convertToEpoch($terminal->end_work);
		$array["current_time"]=$this->convertToEpoch(date("H:i:s"));
        }else{
            $array["start_time"] ="00:00:01";
            $array["end_time"]="00:00:02";
            $array["current_time"]=$this->convertToEpoch(date("H:i:s"));
        }
		return response()->json($array);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function notEmpty($dat){
        return !empty($dat)?$dat:0;
	}

	public function convertToEpoch($date,$start_time="",$end_time="",$start=true){
		$converted=explode(":",$date);
		//0 for hours, 1 for minutes , 2 for seconds
		$time= $converted[0].$converted[1].$converted[2];
		$day=date("j");
		$months=date("n");    
		$year=date("Y");
		if(!empty($start_time) && !empty($end_time)){
			if(strtotime($start_time)>strtotime($end_time)){
				if($start){
					$day=date("j",strtotime("-1 day"));
				}
			}
		}
		return mktime(
			$this->notEmpty($converted[0]),
			$this->notEmpty($converted[1]),
			$this->notEmpty($converted[2]),
			$months,$day,$year);
	}

    public function skulist()
    {
        $user_id     = Auth::user()->id;
        $merchant = Merchant::where('user_id','=',$user_id)->first();
        return   $products =   $merchant->products()
			->leftjoin('nproductid','nproductid.product_id','=','product.id')
            ->leftJoin('productbc', function ($leftJoin) {
				$leftJoin->on('productbc.product_id', '=', 'product.id')
				->where('productbc.id', '=',
					DB::raw("(select max(`id`) from productbc)"));
			})
			->leftjoin('bc_management','bc_management.id','=',
				'productbc.bc_management_id')
            ->join('merchantproduct as mp','mp.product_id','=','product.id')
            ->whereNull('mp.deleted_at')
            ->where('product.status','!=','transferred')
            ->whereNull('product.deleted_at')
			->orderBy('product.created_at','DESC') ->get([
                'product.id as id',
                'product.sku as sku',
                'bc_management.barcode',
                'product.name as name',
                'product.retail_price as price',
                'nproductid.nproduct_id as npid',
                'product.description as description',
                'product.thumb_photo as thumb_photo',
            ]);
		return Response()->json($products);
    }

    public function skulist_since()
    {
        $user_id     = Auth::user()->id;     


          $user_info1 = DB::table('opos_receiptproduct')
             ->select('product_id', DB::raw("SUM(quantity) as quantity"))
             ->groupBy('product_id')
             ->get();
             $user_info2 = DB::table('opos_receiptproduct')
             ->select('product_id', DB::raw("SUM(price) as pricesum,SUM(discount) as discount"))
             ->groupBy('product_id')
             ->get();


            $user_info = array();
            foreach ($user_info1 as $key => $value){
                $user_info[] = (object)array_merge((array)$user_info2[$key], (array)$value);
            }
         
         $merchant = Merchant::where('user_id','=',$user_id)->first();
         $products =   $merchant->products()
            ->leftjoin('nproductid','nproductid.product_id','=','product.id')
            ->leftJoin('productbc', function ($leftJoin) {
                $leftJoin->on('productbc.product_id', '=', 'product.id')
                ->where('productbc.id', '=',
                    DB::raw("(select max(`id`) from productbc)"));
            })
             ->leftjoin('bc_management','bc_management.id','=',
                'productbc.bc_management_id')


            ->orderBy('product.created_at','DESC') ->get([
                'product.id as id',
                'product.sku as sku',
                'bc_management.barcode',
                'product.name as name',
                'product.retail_price as price',
                'nproductid.nproduct_id as npid',
                'product.description as description',
                'product.thumb_photo as thumb_photo',
            ]);
          

            foreach ($products as $key1 => $value1) {
                foreach ($user_info as $key2 => $value2) {
                    //echo "<pre>";print_r($value2);
					if ($value1->id  ==  $value2->product_id) {
                        $nn = array('pricesum' => $value2->pricesum , 'quantity' => $value2->quantity, 'discount' => $value2->discount );
                        
                        $newArry[] = array_merge((array)$value1['original'], (array)$nn);
                    }
                }
            }
          /* echo "<pre>";
           print_r($newArry);
           exit;*/
            $sum = 0;

            foreach($newArry as $num => $values) {
                $sum += $values[ 'price' ];
            }
            
            
            $price = array();
            foreach ($newArry as $key => $row)
            {
                $price[$key]['pricesum1']= $row['pricesum'] - $row['discount'];
                $price[$key]['quantity']= $row['quantity'];
                 $price[$key]['discount']= $row['discount'];
                $price[$key]['pricesum']= number_format( $price[$key]['pricesum1']/100,2);
                $price[$key]['price']= $row['price'];
                $price[$key]['pricedata']= number_format($row['price']/100,2);
                $price[$key]['id']= $row['id'];
                $price[$key]['totalProduct']= $sum;
                $price[$key]['sku']= $row['sku'];
                $price[$key]['barcode']= $row['barcode'];
                $price[$key]['name']= $row['name'];

                //$price[$key]['price']= $row['price'];
                $price[$key]['npid']= $row['npid'];
                $price[$key]['description']= $row['description'];
                $price[$key]['description']= $row['description'];
                $price[$key]['thumb_photo']= $row['thumb_photo'];
                $price[$key]['pivot_merchant_id']= $row['pivot_merchant_id'];
                $price[$key]['pivot_product_id']= $row['pivot_product_id'];
                $price[$key]['pivot_created_at']= $row['pivot_created_at'];
                $price[$key]['pivot_updated_at']= $row['pivot_updated_at'];


            }
            array_multisort($price, SORT_DESC, $newArry);
               /*echo "<pre>";
               print_r($price);
               exit;*/
        return Response()->json($price);
       
    }
           
    public function skulist_ytd()
    /*{
        $user_id     = Auth::user()->id;     

        
             $user_info1 = DB::table('opos_receiptproduct')
             ->select('product_id', DB::raw("SUM(quantity) as quantity"))
             ->groupBy('product_id')
             ->get();
             $user_info2 = DB::table('opos_receiptproduct')
             ->select('product_id', DB::raw("SUM(price) as pricesum,SUM(discount) as discount"))
             ->groupBy('product_id')
             ->get();
           
            $user_info = array();
            foreach ($user_info1 as $key => $value){
                $user_info[] = (object)array_merge((array)$user_info2[$key], (array)$value);
            }

         $merchant = Merchant::where('user_id','=',$user_id)->first();
         $products =   $merchant->products()
            ->leftjoin('nproductid','nproductid.product_id','=','product.id')
            ->leftJoin('productbc', function ($leftJoin) {
                $leftJoin->on('productbc.product_id', '=', 'product.id')
                ->where('productbc.id', '=',
                    DB::raw("(select max(`id`) from productbc)"));
            })
             ->leftjoin('bc_management','bc_management.id','=',
                'productbc.bc_management_id')

            ->orderBy('product.created_at','DESC') ->get([
                'product.id as id',
                'product.sku as sku',
                'bc_management.barcode',
                'product.name as name',
                'product.retail_price as price',
                'nproductid.nproduct_id as npid',
                'product.description as description',
                'product.thumb_photo as thumb_photo',
            ]);
          
            foreach ($products as $key1 => $value1) {
				$pdate = explode(' ', $value1['original']['pivot_created_at']);
				$dateytd = date("Y") . "-01-01";
             
				if($pdate['0'] > $dateytd ) {
					foreach ($user_info as $key2 => $value2) {
                    
                      if ($value1->id  ==  $value2->product_id) {
                        $nn = array('pricesum' => $value2->pricesum , 'quantity' => $value2->quantity, 'discount' => $value2->discount );
                        $newArry[] = array_merge((array)$value1['original'], (array)$nn);
                        } 
                    }
                }
            } 
         
            $sum = 0;
            foreach($newArry as $num => $values) {
                $sum += $values[ 'price' ];
            }

            $price = array();
            foreach ($newArry as $key => $row) {
                $price[$key]['pricesum1']= $row['pricesum'] - $row['discount'];
                $price[$key]['quantity']= $row['quantity'];
                $price[$key]['discount']= $row['discount'];
                $price[$key]['pricesum']= number_format( $price[$key]['pricesum1']/100,2);
                $price[$key]['price']= $row['price'];

                $price[$key]['pricedata']= number_format($row['price']/100,2);
                $price[$key]['totalProduct']= $sum;
                $price[$key]['id']= $row['id'];
                $price[$key]['sku']= $row['sku'];
                $price[$key]['barcode']= $row['barcode'];
                $price[$key]['name']= $row['name'];
                $price[$key]['npid']= $row['npid'];
                $price[$key]['description']= $row['description'];
                $price[$key]['description']= $row['description'];
                $price[$key]['thumb_photo']= $row['thumb_photo'];
                $price[$key]['pivot_merchant_id']= $row['pivot_merchant_id'];
                $price[$key]['pivot_product_id']= $row['pivot_product_id'];
                $price[$key]['pivot_created_at']= $row['pivot_created_at'];
                $price[$key]['pivot_updated_at']= $row['pivot_updated_at'];
            }
            array_multisort($price, SORT_DESC, $newArry); 
           
        return Response()->json($price);
    }*/
     {
        $user_id     = Auth::user()->id;     

         $user_info1 = DB::table('opos_receiptproduct')
             ->select('product_id','updated_at','created_at', DB::raw("SUM(quantity) as quantity"))
             ->groupBy('product_id')
             ->get();
         $user_info2 = DB::table('opos_receiptproduct')
             ->select('product_id', DB::raw("SUM(price) as pricesum,SUM(discount) as discount"))
             ->groupBy('product_id')
             ->get();
           
            $user_info = array();
            foreach ($user_info1 as $key => $value){
                $user_info[] = (object)array_merge((array)$user_info2[$key], (array)$value);
            }

            
         $merchant = Merchant::where('user_id','=',$user_id)->first();
         $products =   $merchant->products()
            ->leftjoin('nproductid','nproductid.product_id','=','product.id')
            ->leftJoin('productbc', function ($leftJoin) {
                $leftJoin->on('productbc.product_id', '=', 'product.id')
                ->where('productbc.id', '=',
                    DB::raw("(select max(`id`) from productbc)"));
            })
             ->leftjoin('bc_management','bc_management.id','=',
                'productbc.bc_management_id')


            ->orderBy('product.created_at','DESC') ->get([
                'product.id as id',
                'product.sku as sku',
                'bc_management.barcode',
                'product.name as name',
                'product.retail_price as price',
                'nproductid.nproduct_id as npid',
                'product.description as description',
                'product.thumb_photo as thumb_photo',
            ]);
           
            foreach ($products as $key1 => $value1) {
          
               $pdate = explode(' ', $value1['original']['pivot_created_at']);
               $dateytd = date("Y") . "-01-01";
                foreach ($user_info as $key2 => $value2) {
              
                      if ($value1->id  ==  $value2->product_id) {
                        $nn = array('pricesum' => $value2->pricesum , 'quantity' => $value2->quantity, 'discount' => $value2->discount,'created_at' => $value2->created_at );
                        $newArry[] = array_merge((array)$value1['original'], (array)$nn);
                        } 
                    }
                   
                   
                    $sum = 0;
                    foreach($newArry as $num => $values) {
                        $sum += $values[ 'price' ];
                    }
                    $price = array();
                    foreach ($newArry as $key => $row)
                    {
                    	if($dateytd <  $row['created_at']){
                        $price[$key]['pricesum1']= $row['pricesum'] - $row['discount'];
                        $price[$key]['quantity']= $row['quantity'];
                        $price[$key]['discount']= $row['discount'];
                        $price[$key]['pricesum']= number_format( $price[$key]['pricesum1']/100,2);
                        $price[$key]['price']= $row['price'];

                        $price[$key]['pricedata']= number_format($row['price']/100,2);
                        $price[$key]['totalProduct']= $sum;
                        $price[$key]['id']= $row['id'];
                        $price[$key]['sku']= $row['sku'];
                        $price[$key]['barcode']= $row['barcode'];
                        $price[$key]['name']= $row['name'];
                        $price[$key]['npid']= $row['npid'];
                        $price[$key]['description']= $row['description'];
                        $price[$key]['description']= $row['description'];
                        $price[$key]['thumb_photo']= $row['thumb_photo'];
                        $price[$key]['pivot_merchant_id']= $row['pivot_merchant_id'];
                        $price[$key]['pivot_product_id']= $row['pivot_product_id'];
                        $price[$key]['pivot_created_at']= $row['pivot_created_at'];
                        $price[$key]['pivot_updated_at']= $row['pivot_updated_at'];
                      
                       //array_multisort($price, SORT_DESC, $newArry);
                       }


                else
                {
                    $price = "No data available";
                }
             }
           }
            
           
        return Response()->json($price);
       
    }

    public function skulist_mtd()
    {
        $user_id     = Auth::user()->id;     

         $user_info1 = DB::table('opos_receiptproduct')
             ->select('product_id','updated_at','created_at', DB::raw("SUM(quantity) as quantity"))
             ->groupBy('product_id')
             ->get();
         $user_info2 = DB::table('opos_receiptproduct')
             ->select('product_id', DB::raw("SUM(price) as pricesum,SUM(discount) as discount"))
             ->groupBy('product_id')
             ->get();
           
            $user_info = array();
            foreach ($user_info1 as $key => $value){
                $user_info[] = (object)array_merge((array)$user_info2[$key], (array)$value);
            }

            
         $merchant = Merchant::where('user_id','=',$user_id)->first();
         $products =   $merchant->products()
            ->leftjoin('nproductid','nproductid.product_id','=','product.id')
            ->leftJoin('productbc', function ($leftJoin) {
                $leftJoin->on('productbc.product_id', '=', 'product.id')
                ->where('productbc.id', '=',
                    DB::raw("(select max(`id`) from productbc)"));
            })
             ->leftjoin('bc_management','bc_management.id','=',
                'productbc.bc_management_id')


            ->orderBy('product.created_at','DESC') ->get([
                'product.id as id',
                'product.sku as sku',
                'bc_management.barcode',
                'product.name as name',
                'product.retail_price as price',
                'nproductid.nproduct_id as npid',
                'product.description as description',
                'product.thumb_photo as thumb_photo',
            ]);
           
            foreach ($products as $key1 => $value1) {
          
               $pdate = explode(' ', $value1['original']['pivot_created_at']);
               $datemtd = date("Y-m") . "-01";
                    
                	 	
                	
                foreach ($user_info as $key2 => $value2) {
              
                      if ($value1->id  ==  $value2->product_id) {
                        $nn = array('pricesum' => $value2->pricesum , 'quantity' => $value2->quantity, 'discount' => $value2->discount,'created_at' => $value2->created_at );
                        $newArry[] = array_merge((array)$value1['original'], (array)$nn);
                        } 
                    }
                   
                   
                    $sum = 0;
                    foreach($newArry as $num => $values) {
                        $sum += $values[ 'price' ];
                    }
                    $price = array();
                    foreach ($newArry as $key => $row)
                    {
                    	if($datemtd <  $row['created_at']){
                        $price[$key]['pricesum1']= $row['pricesum'] - $row['discount'];
                        $price[$key]['quantity']= $row['quantity'];
                        $price[$key]['discount']= $row['discount'];
                        $price[$key]['pricesum']= number_format( $price[$key]['pricesum1']/100,2);
                        $price[$key]['price']= $row['price'];

                        $price[$key]['pricedata']= number_format($row['price']/100,2);
                        $price[$key]['totalProduct']= $sum;
                        $price[$key]['id']= $row['id'];
                        $price[$key]['sku']= $row['sku'];
                        $price[$key]['barcode']= $row['barcode'];
                        $price[$key]['name']= $row['name'];
                        $price[$key]['npid']= $row['npid'];
                        $price[$key]['description']= $row['description'];
                        $price[$key]['description']= $row['description'];
                        $price[$key]['thumb_photo']= $row['thumb_photo'];
                        $price[$key]['pivot_merchant_id']= $row['pivot_merchant_id'];
                        $price[$key]['pivot_product_id']= $row['pivot_product_id'];
                        $price[$key]['pivot_created_at']= $row['pivot_created_at'];
                        $price[$key]['pivot_updated_at']= $row['pivot_updated_at'];
                      
                       //array_multisort($price, SORT_DESC, $newArry);
                       }


                else
                {
                    $price = "No data available";
                }
             }
           }
            
           
        return Response()->json($price);
       
    }
    public function skulist_wtd()
    {
        $user_id     = Auth::user()->id;     

         $user_info1 = DB::table('opos_receiptproduct')
             ->select('product_id','updated_at','created_at', DB::raw("SUM(quantity) as quantity"))
             ->groupBy('product_id')
             ->get();
         $user_info2 = DB::table('opos_receiptproduct')
             ->select('product_id', DB::raw("SUM(price) as pricesum,SUM(discount) as discount"))
             ->groupBy('product_id')
             ->get();
           
            $user_info = array();
            foreach ($user_info1 as $key => $value){
                $user_info[] = (object)array_merge((array)$user_info2[$key], (array)$value);
            }

            
         $merchant = Merchant::where('user_id','=',$user_id)->first();
         $products =   $merchant->products()
            ->leftjoin('nproductid','nproductid.product_id','=','product.id')
            ->leftJoin('productbc', function ($leftJoin) {
                $leftJoin->on('productbc.product_id', '=', 'product.id')
                ->where('productbc.id', '=',
                    DB::raw("(select max(`id`) from productbc)"));
            })
             ->leftjoin('bc_management','bc_management.id','=',
                'productbc.bc_management_id')


            ->orderBy('product.created_at','DESC') ->get([
                'product.id as id',
                'product.sku as sku',
                'bc_management.barcode',
                'product.name as name',
                'product.retail_price as price',
                'nproductid.nproduct_id as npid',
                'product.description as description',
                'product.thumb_photo as thumb_photo',
            ]);
           
            foreach ($products as $key1 => $value1) {
          
               $pdate = explode(' ', $value1['original']['pivot_created_at']);
               $date1 = date("Y-m-d"); 
                $datewtd =  date('Y-m-d', strtotime('last monday', strtotime($date1)));
                	 	
                	
                foreach ($user_info as $key2 => $value2) {
              
                      if ($value1->id  ==  $value2->product_id) {
                        $nn = array('pricesum' => $value2->pricesum , 'quantity' => $value2->quantity, 'discount' => $value2->discount,'created_at' => $value2->created_at );
                        $newArry[] = array_merge((array)$value1['original'], (array)$nn);
                        } 
                    }
                   
                   
                    $sum = 0;
                    foreach($newArry as $num => $values) {
                        $sum += $values[ 'price' ];
                    }
                    $price = array();
                    foreach ($newArry as $key => $row)
                    {
                    	if($datewtd <  $row['created_at']){
                        $price[$key]['pricesum1']= $row['pricesum'] - $row['discount'];
                        $price[$key]['quantity']= $row['quantity'];
                        $price[$key]['discount']= $row['discount'];
                        $price[$key]['pricesum']= number_format( $price[$key]['pricesum1']/100,2);
                        $price[$key]['price']= $row['price'];

                        $price[$key]['pricedata']= number_format($row['price']/100,2);
                        $price[$key]['totalProduct']= $sum;
                        $price[$key]['id']= $row['id'];
                        $price[$key]['sku']= $row['sku'];
                        $price[$key]['barcode']= $row['barcode'];
                        $price[$key]['name']= $row['name'];
                        $price[$key]['npid']= $row['npid'];
                        $price[$key]['description']= $row['description'];
                        $price[$key]['description']= $row['description'];
                        $price[$key]['thumb_photo']= $row['thumb_photo'];
                        $price[$key]['pivot_merchant_id']= $row['pivot_merchant_id'];
                        $price[$key]['pivot_product_id']= $row['pivot_product_id'];
                        $price[$key]['pivot_created_at']= $row['pivot_created_at'];
                        $price[$key]['pivot_updated_at']= $row['pivot_updated_at'];
                      
                       //array_multisort($price, SORT_DESC, $newArry);
                       }


                else
                {
                    $price = "No data available";
                }
             }
           }
            
           
        return Response()->json($price);
       
    }
    public function skulist_daily()
    /*{
        $user_id     = Auth::user()->id;     

         $user_info1 = DB::table('opos_receiptproduct')
             ->select('product_id', DB::raw("SUM(quantity) as quantity"))
             ->groupBy('product_id')
             ->get();
             $user_info2 = DB::table('opos_receiptproduct')
             ->select('product_id', DB::raw("SUM(price) as pricesum,SUM(discount) as discount"))
             ->groupBy('product_id')
             ->get();
           
            $user_info = array();
            foreach ($user_info1 as $key => $value){
                $user_info[] = (object)array_merge((array)$user_info2[$key], (array)$value);
            }

         $merchant = Merchant::where('user_id','=',$user_id)->first();
         $products =   $merchant->products()
            ->leftjoin('nproductid','nproductid.product_id','=','product.id')
            ->leftJoin('productbc', function ($leftJoin) {
                $leftJoin->on('productbc.product_id', '=', 'product.id')
                ->where('productbc.id', '=',
                    DB::raw("(select max(`id`) from productbc)"));
            })
             ->leftjoin('bc_management','bc_management.id','=',
                'productbc.bc_management_id')


            ->orderBy('product.created_at','DESC') ->get([
                'product.id as id',
                'product.sku as sku',
                'bc_management.barcode',
                'product.name as name',
                'product.retail_price as price',
                'nproductid.nproduct_id as npid',
                'product.description as description',
                'product.thumb_photo as thumb_photo',
            ]);
          

            foreach ($products as $key1 => $value1) {
               $pdate = explode(' ', $value1['original']['pivot_created_at']);
               $datedaily =  date("Y-m-d");
                
             
               if($pdate['0'] > $datedaily )
                {
                foreach ($user_info as $key2 => $value2) {
                    
                      if ($value1->id  ==  $value2->product_id) {
                        $nn = array('pricesum' => $value2->pricesum , 'quantity' => $value2->quantity, 'discount' => $value2->discount );
                        $newArry[] = array_merge((array)$value1['original'], (array)$nn);
                        } 
                    }
                 $sum = 0;
                foreach($newArry as $num => $values) {
                        $sum += $values[ 'price' ];
                    }
                $price = array();
                foreach ($newArry as $key => $row)
                {
                    $price[$key]['pricesum1']= $row['pricesum'] - $row['discount'];
                    $price[$key]['quantity']= $row['quantity'];
                    $price[$key]['discount']= $row['discount'];
                    $price[$key]['pricesum']= number_format( $price[$key]['pricesum1']/100,2);
                    $price[$key]['price']= $row['price'];

                    $price[$key]['pricedata']= number_format($row['price']/100,2);
                    $price[$key]['totalProduct']= $sum;
                    $price[$key]['id']= $row['id'];
                    $price[$key]['sku']= $row['sku'];
                    $price[$key]['barcode']= $row['barcode'];
                    $price[$key]['name']= $row['name'];
                    $price[$key]['npid']= $row['npid'];
                    $price[$key]['description']= $row['description'];
                    $price[$key]['description']= $row['description'];
                    $price[$key]['thumb_photo']= $row['thumb_photo'];
                    $price[$key]['pivot_merchant_id']= $row['pivot_merchant_id'];
                    $price[$key]['pivot_product_id']= $row['pivot_product_id'];
                    $price[$key]['pivot_created_at']= $row['pivot_created_at'];
                    $price[$key]['pivot_updated_at']= $row['pivot_updated_at'];


                }
                array_multisort($price, SORT_DESC, $newArry);
                  }
                else
                {
                    $price = "No data available";
                }
            }    
        return Response()->json($price);
       
    }*/
     {
        $user_id     = Auth::user()->id;     

         $user_info1 = DB::table('opos_receiptproduct')
             ->select('product_id','updated_at','created_at', DB::raw("SUM(quantity) as quantity"))
             ->groupBy('product_id')
             ->get();
         $user_info2 = DB::table('opos_receiptproduct')
             ->select('product_id', DB::raw("SUM(price) as pricesum,SUM(discount) as discount"))
             ->groupBy('product_id')
             ->get();
           
            $user_info = array();
            foreach ($user_info1 as $key => $value){
                $user_info[] = (object)array_merge((array)$user_info2[$key], (array)$value);
            }


         $merchant = Merchant::where('user_id','=',$user_id)->first();
         $products =   $merchant->products()
            ->leftjoin('nproductid','nproductid.product_id','=','product.id')
            ->leftJoin('productbc', function ($leftJoin) {
                $leftJoin->on('productbc.product_id', '=', 'product.id')
                ->where('productbc.id', '=',
                    DB::raw("(select max(`id`) from productbc)"));
            })
             ->leftjoin('bc_management','bc_management.id','=',
                'productbc.bc_management_id')


            ->orderBy('product.created_at','DESC') ->get([
                'product.id as id',
                'product.sku as sku',
                'bc_management.barcode',
                'product.name as name',
                'product.retail_price as price',
                'nproductid.nproduct_id as npid',
                'product.description as description',
                'product.thumb_photo as thumb_photo',
            ]);
           
            foreach ($products as $key1 => $value1) {
          
               $pdate = explode(' ', $value1['original']['pivot_created_at']);
               $datedaily =  date("Y-m-d");
                foreach ($user_info as $key2 => $value2) {
              
                      if ($value1->id  ==  $value2->product_id) {
                        $nn = array('pricesum' => $value2->pricesum , 'quantity' => $value2->quantity, 'discount' => $value2->discount,'created_at' => $value2->created_at );
                        $newArry[] = array_merge((array)$value1['original'], (array)$nn);
                        } 
                    }
                   
                   
                    $sum = 0;
                    foreach($newArry as $num => $values) {
                        $sum += $values[ 'price' ];
                    }
                    
                    $price = array();
                    foreach ($newArry as $key => $row)
                    {
                    	if($datedaily <  $row['created_at']){
                        $price[$key]['pricesum1']= $row['pricesum'] - $row['discount'];
                        $price[$key]['quantity']= $row['quantity'];
                        $price[$key]['discount']= $row['discount'];
                        $price[$key]['pricesum']= number_format( $price[$key]['pricesum1']/100,2);
                        $price[$key]['price']= $row['price'];

                        $price[$key]['pricedata']= number_format($row['price']/100,2);
                        $price[$key]['totalProduct']= $sum;
                        $price[$key]['id']= $row['id'];
                        $price[$key]['sku']= $row['sku'];
                        $price[$key]['barcode']= $row['barcode'];
                        $price[$key]['name']= $row['name'];
                        $price[$key]['npid']= $row['npid'];
                        $price[$key]['description']= $row['description'];
                        $price[$key]['description']= $row['description'];
                        $price[$key]['thumb_photo']= $row['thumb_photo'];
                        $price[$key]['pivot_merchant_id']= $row['pivot_merchant_id'];
                        $price[$key]['pivot_product_id']= $row['pivot_product_id'];
                        $price[$key]['pivot_created_at']= $row['pivot_created_at'];
                        $price[$key]['pivot_updated_at']= $row['pivot_updated_at'];
                      
                       //array_multisort($price, SORT_DESC, $newArry);
                       }


                else
                {
                    $price = "No data available";
                }
             }
           }
            
           
        return Response()->json($price);
       
    }
    
    public function staff_Sales()
    {
        $user_id     = Auth::user()->id;
        $merchant = Merchant::where('user_id','=',$user_id)->first();
        

        $totalsales  = DB::select(DB::raw(
                "
                SELECT 
                porder.id as id,
                porder.user_id as uid,
                member.name as name,
                users.avatar as image,
                op.product_id as proId,
                
                SUM((opr.price* opr.quantity)) as sales,
                SUM((opr.quantity)) as sales_quantity,
                DATE_FORMAT(porder.updated_at,'%d%b%y %h:%m') as date

                FROM

                porder

                JOIN member on member.user_id = porder.user_id
                
                LEFT JOIN nporderid on nporderid.porder_id = porder.id
                JOIN orderproduct as op on op.porder_id = porder.id

                JOIN product on product.id = op.product_id
                JOIN merchantproduct as mp on mp.product_id=product.parent_id
                
                JOIN users on users.id= porder.user_id
                JOIN opos_receiptproduct as opr on opr.product_id = op.product_id
                JOIN address on users.default_address_id=address.id
                JOIN city on address.city_id = city.id
                JOIN state on city.state_code = state.code

                AND mp.merchant_id = ".$merchant['id']. " 
                GROUP BY users.id
                
            "
        ));
        
        $sum = 0;
        foreach ($totalsales as $key => $values) {
            $sum +=$values->sales; 
        }

        $sales_stff = array();
        foreach ($totalsales as $key => $row)
        {
        
            $sales_stff[$key]['id'] = $row->id;
            $sales_stff[$key]['uid'] = $row->uid;
            $sales_stff[$key]['name'] = $row->name;
            $sales_stff[$key]['image'] = $row->image;
            $sales_stff[$key]['proId'] = $row->proId;
            $sales_stff[$key]['salesall'] = $sum;
            $sales_stff[$key]['sales'] = $row->sales;
            $sales_stff[$key]['sales_quantity'] = $row->sales_quantity;
            $sales_stff[$key]['date'] = $row->date;
        }
        return $sales_stff;

        

               /* $user_id     = Auth::user()->id;
        $merchant = Merchant::where('user_id','=',$user_id)->first();
        return   $products =   $merchant->products()
            ->leftjoin('nproductid','nproductid.product_id','=','product.id')
            ->leftJoin('productbc', function ($leftJoin) {
                $leftJoin->on('productbc.product_id', '=', 'product.id')
                ->where('productbc.id', '=',
                    DB::raw("(select max(`id`) from productbc)"));
            })
            ->leftjoin('bc_management','bc_management.id','=',
                'productbc.bc_management_id')
            ->join('merchantproduct as mp','mp.product_id','=','product.id')
            ->whereNull('mp.deleted_at')
            ->where('product.status','!=','transferred')
            ->whereNull('product.deleted_at')
            ->orderBy('product.created_at','DESC') ->get([
                'product.id as id',
                'product.sku as sku',
                'bc_management.barcode',
                'product.name as name',
                'product.retail_price as price',
                'nproductid.nproduct_id as npid',
                'product.description as description',
                'product.thumb_photo as thumb_photo',
            ]);
        return Response()->json($products);*/
    }
    public function staff_Sales_Ytd()
    {
    	$user_id     = Auth::user()->id;
        $merchant = Merchant::where('user_id','=',$user_id)->first();
        

        $totalsales  = DB::select(DB::raw(
                "
                SELECT 
                porder.id as id,
                porder.user_id as uid,
                member.name as name,
                users.avatar as image,
                op.product_id as proId,
                
                SUM((opr.price* opr.quantity)) as sales,
                SUM((opr.quantity)) as sales_quantity,
                DATE_FORMAT(porder.updated_at,'%d%b%y %h:%m') as date

                FROM

                porder

                JOIN member on member.user_id = porder.user_id
                
                LEFT JOIN nporderid on nporderid.porder_id = porder.id
                JOIN orderproduct as op on op.porder_id = porder.id

                JOIN product on product.id = op.product_id
                JOIN merchantproduct as mp on mp.product_id=product.parent_id
                
                JOIN users on users.id= porder.user_id
                JOIN opos_receiptproduct as opr on opr.product_id = op.product_id
                JOIN address on users.default_address_id=address.id
                JOIN city on address.city_id = city.id
                JOIN state on city.state_code = state.code
                WHERE YEAR(opr.updated_at) = YEAR(CURDATE()) 
                AND mp.merchant_id = ".$merchant['id']. " 
                GROUP BY users.id
                
            "
        ));
        
        $sum = 0;
        foreach ($totalsales as $key => $values) {
            $sum +=$values->sales; 
        }

        $sales_stff = array();
        foreach ($totalsales as $key => $row)
        {
        
            $sales_stff[$key]['id'] = $row->id;
            $sales_stff[$key]['uid'] = $row->uid;
            $sales_stff[$key]['name'] = $row->name;
            $sales_stff[$key]['image'] = $row->image;
            $sales_stff[$key]['proId'] = $row->proId;
            $sales_stff[$key]['salesall'] = $sum;
            $sales_stff[$key]['sales'] = $row->sales;
            $sales_stff[$key]['sales_quantity'] = $row->sales_quantity;
            $sales_stff[$key]['date'] = $row->date;
        }
        return $sales_stff;
    }
    public function staff_Sales_Mtd()
    {
    	$startmonth =  Carbon::now()->startOfMonth()->toDateString();
        $endmonth = Carbon::now()->toDateString();

    	$user_id     = Auth::user()->id;
        $merchant = Merchant::where('user_id','=',$user_id)->first();


        $totalsales  = DB::select(DB::raw(
                "
                SELECT 
                porder.id as id,
                porder.user_id as uid,
                member.name as name,
                users.avatar as image,
                op.product_id as proId,
                
                SUM((opr.price* opr.quantity)) as sales,
                SUM((opr.quantity)) as sales_quantity,
                DATE_FORMAT(opr.updated_at,'%d%b%y %h:%m') as date

                FROM

                porder

                JOIN member on member.user_id = porder.user_id
                
                LEFT JOIN nporderid on nporderid.porder_id = porder.id
                JOIN orderproduct as op on op.porder_id = porder.id

                JOIN product on product.id = op.product_id
                JOIN merchantproduct as mp on mp.product_id=product.parent_id
                
                JOIN users on users.id= porder.user_id
                JOIN opos_receiptproduct as opr on opr.product_id = op.product_id
                JOIN address on users.default_address_id=address.id
                JOIN city on address.city_id = city.id
                JOIN state on city.state_code = state.code

                WHERE DATE(opr.updated_at) BETWEEN  '". $startmonth. "' AND '" . $endmonth ."'
                AND mp.merchant_id = ".$merchant['id']. " 
                GROUP BY users.id
                
            "
        ));
        
        $sum = 0;
        foreach ($totalsales as $key => $values) {
            $sum +=$values->sales; 
        }

        $sales_stff = array();
        foreach ($totalsales as $key => $row)
        {
        
            $sales_stff[$key]['id'] = $row->id;
            $sales_stff[$key]['uid'] = $row->uid;
            $sales_stff[$key]['name'] = $row->name;
            $sales_stff[$key]['image'] = $row->image;
            $sales_stff[$key]['proId'] = $row->proId;
            $sales_stff[$key]['salesall'] = $sum;
            $sales_stff[$key]['sales'] = $row->sales;
            $sales_stff[$key]['sales_quantity'] = $row->sales_quantity;
            $sales_stff[$key]['date'] = $row->date;
        }

        return $sales_stff;
    }
    public function staff_Sales_Wtd()
    {
        $fromDate =  Carbon::now()->startOfWeek()->toDateString();
        $toDate = Carbon::now()->toDateString();
    	$user_id     = Auth::user()->id;
        $merchant = Merchant::where('user_id','=',$user_id)->first();


        $totalsales  = DB::select(DB::raw(
                "
                SELECT 
                porder.id as id,
                porder.user_id as uid,
                member.name as name,
                users.avatar as image,
                op.product_id as proId,
                
                SUM((opr.price* opr.quantity)) as sales,
                SUM((opr.quantity)) as sales_quantity,
                DATE_FORMAT(opr.updated_at,'%d%b%y %h:%m') as date

                FROM

                porder

                JOIN member on member.user_id = porder.user_id
                
                LEFT JOIN nporderid on nporderid.porder_id = porder.id
                JOIN orderproduct as op on op.porder_id = porder.id

                JOIN product on product.id = op.product_id
                JOIN merchantproduct as mp on mp.product_id=product.parent_id
                
                JOIN users on users.id= porder.user_id
                JOIN opos_receiptproduct as opr on opr.product_id = op.product_id
                JOIN address on users.default_address_id=address.id
                JOIN city on address.city_id = city.id
                JOIN state on city.state_code = state.code

                WHERE DATE(opr.updated_at) BETWEEN  '". $fromDate. "' AND '" . $toDate ."'
                AND mp.merchant_id = ".$merchant['id']. " 
                GROUP BY users.id
                
            "
        ));
        
        $sum = 0;
        foreach ($totalsales as $key => $values) {
            $sum +=$values->sales; 
        }

        $sales_stff = array();
        foreach ($totalsales as $key => $row)
        {
        
            $sales_stff[$key]['id'] = $row->id;
            $sales_stff[$key]['uid'] = $row->uid;
            $sales_stff[$key]['name'] = $row->name;
            $sales_stff[$key]['image'] = $row->image;
            $sales_stff[$key]['proId'] = $row->proId;
            $sales_stff[$key]['salesall'] = $sum;
            $sales_stff[$key]['sales'] = $row->sales;
            $sales_stff[$key]['sales_quantity'] = $row->sales_quantity;
            $sales_stff[$key]['date'] = $row->date;
        }

        return $sales_stff;
    }
    public function staff_Sales_Today()
    {
    	$toDate = Carbon::now()->toDateString();
    	$user_id     = Auth::user()->id;
        $merchant = Merchant::where('user_id','=',$user_id)->first();


        $totalsales  = DB::select(DB::raw(
                "
                SELECT 
                porder.id as id,
                porder.user_id as uid,
                member.name as name,
                users.avatar as image,
                op.product_id as proId,
                
                SUM((opr.price* opr.quantity)) as sales,
                SUM((opr.quantity)) as sales_quantity,
                DAY(opr.updated_at) as date

                FROM

                porder
                
                JOIN member on member.user_id = porder.user_id
                
                LEFT JOIN nporderid on nporderid.porder_id = porder.id
                JOIN orderproduct as op on op.porder_id = porder.id

                JOIN product on product.id = op.product_id
                JOIN merchantproduct as mp on mp.product_id=product.parent_id
                
                JOIN users on users.id= porder.user_id
                JOIN opos_receiptproduct as opr on opr.product_id = op.product_id
                
                JOIN address on users.default_address_id=address.id
                JOIN city on address.city_id = city.id
                JOIN state on city.state_code = state.code
                
                WHERE DATE(opr.created_at) = '".$toDate."'

                AND mp.merchant_id = ".$merchant['id']. " 
                GROUP BY users.id
                
            "
        ));
        
        $sum = 0;
        foreach ($totalsales as $key => $values) {
            $sum +=$values->sales; 
        }

        $sales_stff = array();
        foreach ($totalsales as $key => $row)
        {
        
            $sales_stff[$key]['id'] = $row->id;
            $sales_stff[$key]['uid'] = $row->uid;
            $sales_stff[$key]['name'] = $row->name;
            $sales_stff[$key]['image'] = $row->image;
            $sales_stff[$key]['proId'] = $row->proId;
            $sales_stff[$key]['salesall'] = $sum;
            $sales_stff[$key]['sales'] = $row->sales;
            $sales_stff[$key]['sales_quantity'] = $row->sales_quantity;
            $sales_stff[$key]['date'] = $row->date;
        }

        return $sales_stff;
    }
    public function listproduct()
    {

        if (!Auth::check()) {
            # code...
            return response()->json(["error"=>"User not logged in"]);
        }
        $user_id     = Auth::user()->id;

		/* This only works when user_id is the merchant_user_id */
        $user_id  = Auth::user()->id;
		//Log::debug('listproduct: user_id='.$user_id);

 		$staff_user_id = null;

		if (Auth::user()->hasRole("byr")) {
			$staff_user_id = $user_id;
			Log::info('Staff: OPOSsum via Buyer Dashboard');
			Log::info('Staff user_id='.$staff_user_id);

 			$user_id = DB::table('role_users')->
				join('roles','roles.id','=','role_users.role_id')->
				join('company','company.id','=','role_users.company_id')->
				where('user_id',$user_id)->
				whereIn('roles.slug',['opu','opm'])->
				pluck('company.owner_user_id');
		}
 
		/* If user_id is a staff, then $merchant will be NULL */

        $merchant = Merchant::where('user_id','=',$user_id)->first();

        if (empty($merchant)) {
            # code...
            return response()->json(["error"=>"User not merchant"]);
        }
          $barcodes = Product::join('productbc','productbc.product_id','=','product.id')
                    ->join('bc_management','bc_management.id','=','productbc.bc_management_id')
                     ->join('merchantproduct as mp','mp.product_id','=','product.id')
                     ->join('merchantproduct','merchantproduct.product_id','=','product.id')
                     ->where('merchantproduct.merchant_id',$merchant->id)
                    ->whereNull('mp.deleted_at')
                    ->get([
                        'product.id',
                        'bc_management.barcode',
                        'product.thumb_photo as thumb_photo',
                        'product.name as name',
                        'product.retail_price as retail_price',
                    ]);
 
		//Log::debug('listproduct: merchant_id='.$merchant->id);


		$barcodes = Product::join('productbc','productbc.product_id','=','product.id')
		->join('bc_management','bc_management.id','=','productbc.bc_management_id')
		->join('merchantproduct as mp','mp.product_id','=','product.id')
		->join('merchantproduct','merchantproduct.product_id','=','product.id')
		->where('merchantproduct.merchant_id',$merchant->id)
		->whereNull('mp.deleted_at')
		->get([
			'product.id',
			'bc_management.barcode',
			'product.thumb_photo as thumb_photo',
			'product.name as name',
			'product.retail_price as retail_price',
		]);

		$barcodearr = Array();
        foreach ($barcodes as $barcode){
			$barcodearr[$barcode->barcode] = array(
				"id"=>$barcode->id,
				"name"=>$barcode->name,
				"retail_price"=>$barcode->retail_price,
				"thumb_photo"=>$barcode->thumb_photo
			);
        }

//        return $barcodearr;
        $products =   $merchant->products()
            ->join('merchantproduct as mp','mp.product_id','=','product.id')
            ->whereNull('mp.deleted_at')
            ->leftjoin('nproductid','nproductid.product_id','=','product.id')
            ->where('product.status','!=','transferred')
            ->whereNull('product.deleted_at')->orderBy('product.created_at','DESC') ->get([
                'product.id as id',
                'product.parent_id as tprid',
                'product.id as prid',
                'product.discounted_price as discounted_price',
                'product.name as name',
                'product.description as description',
                'product.thumb_photo as thumb_photo',
                'product.parent_id as parent_id',
                'product.retail_price as retail_price',
                'nproductid.nproduct_id as nproductid'
            ]);

            return Response()->json(array($products,$barcodearr));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function savesparoom(Request $request)
    {

        $type=$request->type;
        $fnumber=$request->fnumber;
        $check    = DB::table("opos_ftype")->where('fnumber','=',$fnumber)->where("ftype",$request->ftype)->whereNull("deleted_at")->pluck('fnumber');
        if ($check == $request->fnumber) {
            return -1;
        }
        $does_exist=DB::table("opos_ftype")->where("fnumber",$fnumber)
        ->where("ftype",$type)->whereNull("deleted_at")->first();
        if (!empty($does_exist)) {
            # code...
            return -2;
        }
        $d=DB::table("opos_ftype")
        ->insertgetId([
            "ftype"=>$type,
            "fnumber"=>$fnumber,
            "created_at"=>Carbon::now(),
            "updated_at"=>Carbon::now()
        ]);

        $ret=DB::table("opos_ftype")->where("id",$d)->first();
        return  response()->json($ret);
    }

    public function savetable(Request $request){
        $type=$request->type;
        $fnumber = $request->fnumber;

        $check = DB::table("opos_ftype")
        ->where("fnumber", $fnumber)
        ->where("ftype",$type)
        ->whereNull("deleted_at")
        ->get();


        if (count($check) == 1) {
            return -1;
        } 
        else{
            $d=DB::table("opos_ftype")
            ->insertgetId([
                "ftype"=>$type,
                "fnumber"=>$fnumber,
                "created_at"=>Carbon::now(),
                "updated_at"=>Carbon::now()
            ]);

            $ret=DB::table("opos_ftype")->where("id",$d)->first();
            return  response()->json($ret);
        }

    }
    
    public function savehotelroom(Request $request){
        $type=$request->type;
        $fnumber = $request->fnumber;

        $check = DB::table("opos_ftype")
        ->where("fnumber", $fnumber)
        ->where("ftype",$type)
        ->whereNull("deleted_at")
        ->get();


        if (count($check) == 1) {
            return -1;
        } 
        else{
            $d=DB::table("opos_ftype")
            ->insertgetId([
                "ftype"=>$type,
                "fnumber"=>$fnumber,
                "created_at"=>Carbon::now(),
                "updated_at"=>Carbon::now()
            ]);

            $ret=DB::table("opos_ftype")->where("id",$d)->first();
            return  response()->json($ret);
        }

    }


    //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    
    public function lockerkeyquery($type="lockerkey")
    {
        return "
            SELECT
            of.*,
            ol.checkout_tstamp,
            ol.checkin_tstamp

            FROM 
            opos_ftype of 

            LEFT JOIN (
                SELECT * from opos_lockerkeytxn
                WHERE checkout_tstamp IS NULL 
                AND checkin_tstamp IS NOT NULL
                AND deleted_at IS NULL 


            ) ol on ol.lockerkey_ftype_id=of.id
            WHERE 
            of.ftype='$type' AND 
            of.deleted_at is NULL
            AND of.deleted_at IS NULL
            ORDER BY of.fnumber ASC
        ";
    }
    public function hotelroomquery($type="hotelroom")
    {
        return "
            SELECT
            of.*,
            ol.checkout_tstamp,
            ol.checkin_tstamp

            FROM 
            opos_ftype of 

            LEFT JOIN (
                SELECT * from opos_hotelroomtxn
                WHERE checkout_tstamp IS NULL 
                AND checkin_tstamp IS NOT NULL
                AND deleted_at IS NULL 


            ) ol on ol.hotelroom_ftype_id=of.id
            WHERE 
            of.ftype='$type' AND 
            of.deleted_at is NULL
            AND of.deleted_at IS NULL
            ORDER BY of.fnumber ASC
        ";
    }
    

    //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    
    public function sparoomquery($type='sparoom')
    {
        return "
            SELECT
            of.*,
            ol.sparoom_checkout,
            ol.sparoom_checkin

            FROM 
            opos_ftype of 

            LEFT JOIN (
                SELECT * from opos_lockerkeytxnsparoom
                WHERE sparoom_checkout IS NULL 
                AND sparoom_checkin IS NOT NULL
                AND deleted_at IS NULL 


            ) ol on ol.sparoom_ftype_id=of.id
            WHERE 
            of.ftype='$type' AND
            of.deleted_at is NULL
            AND of.deleted_at IS NULL
            ORDER BY of.fnumber ASC

        ";
    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function sparooms($type="sparoom")
    {

        $query=$this->sparoomquery();
        return DB::select(DB::raw($query));
        /*return $sparoom = DB::table("opos_ftype")
        ->leftJoin("opos_lockerkeytxnsparoom","opos_lockerkeytxnsparoom.sparoom_ftype_id","=","opos_ftype.id")
        ->whereNull("opos_ftype.deleted_at")
      
   /*     ->whereNull("opos_lockerkeytxnsparoom.sparoom_checkout")*/
     /*   ->whereNotNull("opos_lockerkeytxnsparoom.sparoom_checkin")*/
        /*->where("opos_ftype.ftype",$type)

        ->orderBy('opos_ftype.fnumber','ASC')
        ->select("opos_ftype.*","opos_lockerkeytxnsparoom.sparoom_checkin","opos_lockerkeytxnsparoom.sparoom_checkout")
        ->get();*/
    }
    public function lockerkeys($type="lockerkey")
    {
        $query=$this->lockerkeyquery();
        return DB::select(DB::raw($query));
    }
	
	public function table($type="table", $fnumber = 0)
    {
        // if($fnumber > 0){
        //     return DB::table("opos_ftype")
        //     ->whereNull("deleted_at")
        //     ->where("fnumber", $fnumber)
        //     ->where("ftype",$type)
        //     ->orderBy('fnumber','ASC')->get();
        // } else{
            return DB::table("opos_ftype")
            ->whereNull("deleted_at")
            ->where("ftype",$type)
            ->orderBy('fnumber','ASC')->get();
        // }
    }
	public function hotelroom($type="hotelroom", $fnumber = 0)
    {
        $query=$this->hotelroomquery();
        return DB::select(DB::raw($query));
    }

    public function check_existance($type="", $fnumber = 0){
        return DB::table("opos_ftype")
        ->whereNull("deleted_at")
        ->where("fnumber", $fnumber)
        ->where("ftype",$type)
        ->orderBy('fnumber','ASC')->get();
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function checkin(Request $request)
    {

        $sparoom_ftype_id=$request->sparoom_id;

        $opos_customer =new OposSpaCustomer();
        $opos_customer->name = $request->customer_name;
        $opos_customer->email = $request->customer_email;
        $opos_customer->address_id   = 111;
        $opos_customer->save();


        DB::table("opos_lockerkeytxnsparoom")
        
        ->insert([
            "sparoom_ftype_id"=>$sparoom_ftype_id,
            "created_at"=>Carbon::now(),
            "updated_at"=>Carbon::now(),
            "sparoom_checkin"=>Carbon::now()
        ]);
        return date('Y-m-d H:i:s');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function checkoutsparoom(Request $request)
    {
        $sparoom_ftype_id=$request->ftype_id;
        Log::debug(compact('sparoom_ftype_id'));
        DB::table("opos_lockerkeytxnsparoom")
        ->where("sparoom_ftype_id",$sparoom_ftype_id)
        ->whereNull("sparoom_checkout")
        ->whereNull("deleted_at")
        ->update([
            "updated_at"=>Carbon::now(),
            "sparoom_checkout"=>Carbon::now()
        ]);
    /*    $sparoom    =   OposSparoom::find($request->id);
        $sparoom->checkin_tstamp   =  "0000-00-00 00:00:00";
        $sparoom->save();*/
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteroom($id)
    {   

        DB::table("opos_ftype")
        ->where("id",$id)
        ->update([
            "deleted_at"=>Carbon::now()
        ]);
        return $id;
    }

    public function saverec(Request $request)
    {
        $merchant_id = Merchant::where('user_id', Auth::user()->id)->
			first()->id;

        $opos_rec = new OposReceipt();
        $opos_rec->cash_received = $request->cashreceive;
        $opos_rec->merchant_id =   $merchant_id;
        $opos_rec->location_id =   $request->locationid;
        $opos_rec->payment_type =  $request->paymenttype;

        // $opos_rec->points =   $request->points;
        $opos_rec->room_no   = $request->roomno;
        $opos_rec->receipt_no =  Merchant::find($merchant_id)->
			max('opossum_receipt_no') + 1;

		//Log::debug('saverec='.json_encode($opos_rec));

        if ($opos_rec->save()) {
            Merchant::find($merchant_id)->
				update(['opossum_receipt_no'=> $opos_rec->receipt_no]);

            foreach ($request->rec as $key => $row) {
				$opos_rec_product = new OposReceiptproduct();

				$opos_rec_product->receipt_id = $opos_rec->id;    
				$opos_rec_product->product_id = $row['product'];    
				$opos_rec_product->quantity = $row['quantity'];    
				$opos_rec_product->price = $row['price'];    
				$opos_rec_product->discount = $row['discount'];  
				$opos_rec_product->save();  
            }
        }
    }

    public function savediscountbtn(Request $request)
    {
        $check = OposDiscount::where('value','=',$request->discount)
                            ->where('type',$request->type)
                            ->pluck('value');
        if ($check ==$request->discount) {
            return -1;
        }
        $discountbtn = new  OposDiscount();
        $discountbtn->value = $request->discount; 
        $discountbtn->type = $request->type; 
        if ($discountbtn->save()) {
            return  $this->getdiscountbtn();
        }

    }

    public function getdiscountbtn()
    {
        return  $discountbtn =    OposDiscount::orderBy('value','ASC')->get();
    }


    public function list_terminal(Request $request,$uid=NULL)
    {
        if (!Auth::check()) {
            return "";
        }
        $user_id = Auth::user()->id;
        if (!empty($uid) and Auth::user()->hasRole("adm")) {
            # code...
            $user_id=$uid;
        }
        $merchant_id = Merchant::where('user_id',$user_id)->pluck('id');
        $month=(int)$request->month;
        $emonth=(string)$month+1;
        $smonth=(string)$month;
        $year=$request->year;
        $id = $request->user_id;
        $fromDate=$year."-".$smonth.'-01';
        $toDate=$year."-".$emonth."-01";
		$terminals  = OposMerchantterminal::join('opos_terminal','opos_merchantterminal.terminal_id','=','opos_terminal.id')
			->join('opos_receipt','opos_terminal.id','=','opos_receipt.terminal_id')
			->join('fairlocation','opos_terminal.location_id','=','fairlocation.id')
			->where('opos_merchantterminal.merchant_id','=',$merchant_id)
			 ->whereBetween('opos_receipt.created_at',[$fromDate,$toDate])
			->get([
				'opos_terminal.id',
				'opos_terminal.name',
				'fairlocation.location as code',

			])
			->groupBy('id');

        $monthly_sale_query="
            SELECT 
            sum(rp.price*rp.quantity) as sale
            FROM 
            opos_receiptproduct rp 
            JOIN  opos_receipt r on rp.receipt_id=r.id
            JOIN  opos_terminal t on r.terminal_id=t.id
            JOIN  opos_merchantterminal m on m.terminal_id=t.id

            WHERE 
            m.merchant_id=$merchant_id
            AND r.created_at BETWEEN '$fromDate' AND '$toDate'
       
            AND r.deleted_at IS NULL
            AND t.deleted_at IS NULL
            AND m.deleted_at IS NULL
        ";

       /* return $monthly_sale_query;*/
        $monthly=DB::select(DB::raw($monthly_sale_query))[0];
        if (empty($monthly)) {
            # code...
            $monthly=(object)array();
            $monthly->sale=0;
        }   
   
        $today_sale_query="
            SELECT 
            sum(rp.price*rp.quantity) as sale
            FROM 
            opos_receiptproduct rp 
            JOIN  opos_receipt r on rp.receipt_id=r.id
            JOIN  opos_terminal t on r.terminal_id=t.id
            JOIN  opos_merchantterminal m on m.terminal_id=t.id

            WHERE 
            m.merchant_id=$merchant_id
            AND r.created_at >=CURDATE()
  
            AND r.deleted_at IS NULL
            AND t.deleted_at IS NULL
            LIMIT 1
        ";
        $today=DB::select(DB::raw($today_sale_query))[0];
        if (empty($today)) {
            # code...
            $today=(object)array();
            $today->sale=0;
        }
        
        return view('seller.opossum_document.terminals',compact('terminals','fromDate','toDate','today','monthly'));
    }

    public function showreceipt($fromDate,$toDate,$terminal_id){
        $user_id = Auth::user()->id;
        $merchant_id = Merchant::where('user_id',$user_id)->pluck('id');
        $receipts  = OposMerchantterminal::join('opos_terminal','opos_merchantterminal.terminal_id','=','opos_terminal.id')
            ->join('opos_receipt','opos_terminal.id','=','opos_receipt.terminal_id')
            ->join('fairlocation','opos_terminal.location_id','=','fairlocation.id')
            ->where('opos_merchantterminal.merchant_id','=',$merchant_id)
            ->where('opos_merchantterminal.terminal_id','=',$terminal_id)
            ->whereBetween('opos_receipt.created_at',[$fromDate,$toDate])
            ->get([
                'opos_receipt.*'

            ]);

        $monthly_sale_query="
            SELECT 
            sum(rp.price*rp.quantity) as sale
            FROM 
            opos_receiptproduct rp 
            JOIN  opos_receipt r on rp.receipt_id=r.id
            JOIN  opos_terminal t on r.terminal_id=t.id
            JOIN  opos_merchantterminal m on m.terminal_id=t.id

            WHERE 
            m.merchant_id=$merchant_id
            AND r.created_at BETWEEN '$fromDate' AND '$toDate'
            AND t.id=$terminal_id
       
            AND r.deleted_at IS NULL
            AND t.deleted_at IS NULL
            AND m.deleted_at IS NULL
          
        ";
       /* return $monthly_sale_query;*/
        $monthly=DB::select(DB::raw($monthly_sale_query))[0];
        if (empty($monthly)) {
            # code...
            $monthly=(object)array();
            $monthly->sale=0;
        }   
   
        $today_sale_query="
            SELECT 
            sum(rp.price*rp.quantity) as sale
            FROM 
            opos_receiptproduct rp 
            JOIN  opos_receipt r on rp.receipt_id=r.id
            JOIN  opos_terminal t on r.terminal_id=t.id
            JOIN  opos_merchantterminal m on m.terminal_id=t.id

            WHERE 
            m.merchant_id=$merchant_id
            AND r.created_at >=CURDATE()
            AND t.id=$terminal_id
            AND r.deleted_at IS NULL
            AND t.deleted_at IS NULL
        ";
        $today=DB::select(DB::raw($today_sale_query))[0];
        return view('seller.opossum_document.opossumreceipt',compact('receipts','monthly','today'));

    }

    public function receiptproducts($receipt_id)
    {
        $gst_rate = Globals::pluck('gst_rate');
        $receipts  = OposReceipt::join('opos_receiptproduct','opos_receiptproduct.receipt_id','=','opos_receipt.id')
            ->join('product','opos_receiptproduct.product_id','=','product.id')
            ->where('opos_receipt.id',$receipt_id)
            ->whereNull("opos_receiptproduct.deleted_at")
            ->get([
                'opos_receiptproduct.*',
                'product.name',
                'product.description',
            ]);
        return compact('receipts','gst_rate');
    }

    public function showreceiptproduct($receipt_id){

        $data=$this->receiptproducts($receipt_id);
		Log::debug("receipt_id=".$receipt_id);

		if (!empty($receipt_id)) {
		$receiptInfo = DB::table('opos_receipt')->
			select('opos_receipt.*','users.id as staff_id','users.name as staff_name',
                DB::raw("CONCAT(users.first_name,' ',users.last_name) as staff_name_concat"))->
			leftJoin('users','users.id','=','opos_receipt.staff_user_id')->
			where('opos_receipt.id',$receipt_id)->first();
		}

		if (!empty($receiptInfo)) {
        $location  = DB::table('opos_locationterminal')->
			select('fairlocation.*','opos_locationterminal.terminal_id')->
			join('fairlocation','opos_locationterminal.location_id','=','fairlocation.id')->
			where('opos_locationterminal.terminal_id',$receiptInfo->terminal_id)->first();
            
        $key=DB::table("opos_lockerkeytxnref")->
			join("opos_lockerkeytxn","opos_lockerkeytxn.id","=","opos_lockerkeytxnref.lockerkeytxn_id")->
			join("opos_ftype","opos_ftype.id","=","opos_lockerkeytxn.lockerkey_ftype_id")->
			where("opos_lockerkeytxnref.ref_no",$receiptInfo->ref_no)->
			select("opos_ftype.*")->first();
		}else{
            $key="";
        }

		if (!empty($location)) {
        $company=DB::table("company")->
			join("fairlocation","fairlocation.user_id","=","company.owner_user_id")->
			join("merchant","merchant.user_id","=","company.owner_user_id")->
			join("address","address.id","=","merchant.address_id")->
			where("fairlocation.id",$location->id)->first();
		}else{
            $location="";
        }
        
        $bfunction="";
		if (!empty($company)) {
        $bfunction=DB::table("merchant")->
			where("user_id",$company->owner_user_id)->
			whereNull("deleted_at")->
			pluck("bfunction");
		}else{
            $company="";
        }
        
        return view('seller.opossum_document.opossumreceiptproducts',$data)->
			with('receiptInfo',$receiptInfo)->
			with('location',$location)->
			with('company',$company)->
			with("key",$key)->
			with("bfunction",$bfunction);
    }

    //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    
    public function product(Request $r,$uid=NULL)
    {
        $ret=array();
        $ret["status"]="failure";
        if(!Auth::check()){return "";}
        $user_id=Auth::user()->id;
        if(!empty($uid) and Auth::user()->hasRole("adm")){
            $user_id=$uid;
        }
        /*if (empty($r->ref_no)) {
            # code...
            $ret["error"]="No ref_no";
            return response()->json($ret);
        }*/
        try{
            switch ($r->action) {
                case 'save':
                    return $this->save_product($r);
                    break;
                case 'update':
                    return $this->update_product($r);
                    break;
                case 'delete':
                    return $this->delete_product($r);
                    # code...
                    break;
                case 'update_discount':
                    # code...
                    return $this->update_discount($r);
                    break;
                default:
                    # code...
                    break;
            }
        } catch(\Exception $e){
            $ret["short_message"]=$e->getMessage();
            Log::error("Error @ ".$e->getLine()." file ".
				$e->getFile()." ".$e->getMessage());
        }
        return response()->json($ret);
    }


    //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    
    public function update_discount(Request $r,$uid=NULL)
    {
        $ret=array();
        $ret["status"]="failure";
        if(!Auth::check()){return "";}
        $user_id=Auth::user()->id;
        if(!empty($uid) and Auth::user()->hasRole("adm")){
            $user_id=$uid;
        }
        try{
            $receipt_id=$r->receipt_id;
            $discount_pct=$r->discount;//The discount percentage
            $discount_pct_float=floatval($discount_pct);

            $receiptproducts=DB::table("opos_receiptproduct")
            ->where("receipt_id",$receipt_id)
            ->whereNull("deleted_at")
            ->get();
            
            foreach ($receiptproducts as $pro) {
                $discount_amt=(int)($discount_pct_float*$pro->price)/100;
                DB::table("opos_receiptproduct")
                ->where("id",$pro->id)
                ->update([
                    "discount"=>$discount_pct,
                    "actual_discounted_amt"=>$discount_amt,
                    "updated_at"=>Carbon::now()

                ]);
            }


            $ret["data"]=$discount_pct_float;
            $ret["status"]="success";
        }
        catch(\Exception $e){
            $ret["short_message"]=$e->getMessage();
            Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
        }
        return response()->json($ret);
    }
    


    //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    
    public function delete_product(Request $r,$uid=NULL)
    {
        $ret=array();
        $ret["status"]="failure";
        if(!Auth::check()){return "";}
        $user_id=Auth::user()->id;
        if(!empty($uid) and Auth::user()->hasRole("adm")){
            $user_id=$uid;
        }
        try{
            $table="opos_receiptproduct";
            $data=DB::table($table)
            ->where($table.".receipt_id",$r->receipt_id)  
            ->where("product_id",$r->product_id)      
            ->whereNull($table.".deleted_at")
            ->update([
                "deleted_at"=>Carbon::now()
            ]);
            /*Rollback*/
            DB::table("locationproduct");
            $ret["status"]="success";
            $ret["data"]=$data;

        } catch(\Exception $e){
            $ret["short_message"]=$e->getMessage();
            Log::error("Error @ ".$e->getLine()." file ".
				$e->getFile()." ".$e->getMessage());
        }
        return response()->json($ret);
    }
    

    //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    
    public function pettycash(Request $r,$uid=NULL)
    {
        $ret=array();
        $ret["status"]="failure";
        if(!Auth::check()){return "";}
        $user_id=Auth::user()->id;
        if(!empty($uid) and Auth::user()->hasRole("adm")){
            $user_id=$uid;
        }
        try{

        
            /******************/
            $op=explode(".",$r->amount);
        
            try {
                $int=$op[0];
            } catch (\Exception $e) {
                $int="00";
            }
            try {
                $dec=$op[1];
            } catch (\Exception $e) {
                $dec="00";
            }
            /*Need to lookout for .
                if 13.5
                13*100 + 5*10
                13.100
                if 13.51

            */ 
            if (strlen($dec)==1) {
                $dec=(int)($dec)*10;
            }else{
                $dec=(int)($dec);
            }
            $amount=(int)$int*100+$dec;
            /*Validation*/
            $terminal=$r->terminal_id;
            $validation_query="
                SELECT 
                SUM(CASE 
                WHEN mode='in' THEN amount
                ELSE -amount
                END)as diff
                FROM 
                opos_pettycash
                WHERE
                terminal_id=$terminal
                AND deleted_at IS NULL

            ";
            $validation=DB::select(DB::raw($validation_query));
            $balance=(int)$validation[0]->diff;

            Log::debug($balance);
            Log::debug($amount);
            if ($balance <$amount and $r->mode=="out") {
                $ret['short_message']="Out amount is more than available balance";
                return response()->json($ret);
            }
            $to_insertpettycash=[
                "staff_user_id"=>$user_id,
                "amount"=>$amount,
                "pcreason_id"=>$r->pcreason_id,
                "mode"=>$r->mode,
                "terminal_id"=>$r->terminal_id,
                "created_at"=>Carbon::now(),
                "updated_at"=>Carbon::now()
            ];
            $table="opos_pettycash";
            
            $data=DB::table($table)
            ->insert($to_insertpettycash);
    /*\App\Models\OposCashMgmtLedger::insert([
        "terminal_id"=>$r->terminal_id,
        "pcreason_id"=>$r->pcreason_id,
        "location_id"=>$r->location_id,
       "amount"=>$amount 
    ]);*/
            
            $ret["status"]="success";
            $ret["data"]=$data;
        }
        catch(\Exception $e){
            $ret["short_message"]=$e->getMessage();
            Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
        }
        return response()->json($ret);
    }
    

    //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    
    public function update_product($r,$uid=NULL)
    {
        $ret=array();
        $ret["status"]="failure";
        if(!Auth::check()){return "";}
        $user_id=Auth::user()->id;
        if(!empty($uid) and Auth::user()->hasRole("adm")){
            $user_id=$uid;
        }
        try{
            $table="opos_receiptproduct";
			

            $price = $r->price * 100;
            
            $update_data=[
                "updated_at"=>Carbon::now(),
                "quantity"=>$r->quantity,
                "price"=>$price

            ];

            /*LOCATION PRODUCT LOGIC */
            $receipt=DB::table("opos_receipt")
            ->where("id",$r->receipt_id)
            ->whereNull("deleted_at")
            ->first();

            if (empty($receipt)) {
                return response()->json($ret);
            }

            /*Get location_id*/
            $terminal=DB::table("opos_locationterminal")
            ->where("terminal_id",$receipt->terminal_id)
            ->orderBy("id","DESC")
            ->first();
            if (empty($terminal)) {
                return response()->json($ret);
            }
            $location_id=$terminal->location_id;
            Log::debug("Update Location ID ".$terminal->location_id);

            $record=DB::table($table)
                ->where("product_id",$r->product_id)
                ->where("receipt_id",$r->receipt_id)
                ->whereNull("deleted_at")
                ->first();
            if (empty($record)) {
                return response()->json($ret);
            }
            $old_quantity=$record->quantity;
            $new_quantity=$r->quantity;
            $diff_quantity=$new_quantity-$old_quantity;
            $action="minus";

            if ($new_quantity<$old_quantity) {
                # Subtract the Difference
                $diff_quantity=$old_quantity-$new_quantity;
                $action="add";
            }
            /*ENDS*/
            DB::table($table)
				->where("product_id",$r->product_id)
				->where("receipt_id",$r->receipt_id)
				->update($update_data);  
            $product=DB::table("product")
            ->where("id",$r->product_id)
            ->first();
            if ($product->type!="service") {
                # code...
                UtilityController::locationproduct($location_id,$r->product_id,$diff_quantity,$action); 
            }
                 
			Log::debug('product_id='.$r->product_id);
			Log::debug('receipt_id='.$r->receipt_id);
            
            $ret["status"]="success";
            $ret["data"]=[$r->receipt_id];
        }
        catch(\Exception $e){
            $ret["short_message"]=$e->getMessage();
            Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
        }
        return response()->json($ret);
    }
    

    //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    
    public function save_product($r,$uid=NULL)
    {
        $ret=array();
        $ret["status"]="failure";
        try{
			$price = $r->price;
			$receipt_id = $r->receipt_id;
            Log::debug("save product receipt_id: ".$receipt_id);
            Log::debug("save product price: ".$price);
            Log::debug("save product actual_discounted_amt: ".$r->discount);

            $table="opos_receiptproduct";
            /*Get Discount*/
            $first_record=DB::table($table)->where("receipt_id",$r->receipt_id)
            ->whereNull("deleted_at")->orderBy("id","ASC")
            ->first();
            $discount="0.00";
            if (!empty($first_record)) {
                # code...
                $discount=$first_record->discount;
            }
             $receipt=DB::table("opos_receipt")
            ->where("id",$r->receipt_id)
            ->whereNull("deleted_at")
            ->first();

            if (empty($receipt)) {
                return response()->json($ret);
            }

            /*Get location_id*/
            $terminal=DB::table("opos_locationterminal")
            ->where("terminal_id",$receipt->terminal_id)
            ->orderBy("id","DESC")
            ->first();
            if (empty($terminal)) {
                return response()->json($ret);
            }
            $location_id=$terminal->location_id;
            Log::debug("Save Location ID ".$terminal->location_id);
            $discount_pct_float=floatval($discount);
            $actual_discounted_amt=(int)($discount_pct_float*$price)/100;
            $insert_data=[
                "receipt_id"=>$receipt_id,
                "product_id"=>$r->product_id,
                "quantity"=>$r->quantity,
                "price"=>$price,
                "actual_discounted_amt"=>$actual_discounted_amt,
                "discount"=>$discount,
                "created_at"=>Carbon::now(),
                "updated_at"=>Carbon::now()
            ];

            $data=DB::table($table)->insertgetId($insert_data);
			Log::debug('***** Inserted product to opos_receiptproduct *****');
			Log::info(json_encode($data));

            $product=DB::table("product")
            ->where("id",$r->product_id)
            ->first();
            if ($product->type!="service") {
                # code...
                UtilityController::locationproduct($location_id,$r->product_id,$r->quantity,"minus"); 
            }
            $ret["status"]="success";
            $ret["data"]=$data;
        }

        catch(\Exception $e){
            $ret["short_message"]=$e->getMessage();
            Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
        }
        return response()->json($ret);
    }

    //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    
    public function transaction(Request $r,$action,$uid=NULL)
    {
        $ret=array();
        $ret["status"]="failure";
        
        if(!Auth::check()){return "";}
        $user_id=Auth::user()->id;
        if(!empty($uid) and Auth::user()->hasRole("adm")){
            $user_id=$uid;
        }

        try{
           switch ($action) {
               case 'start':
                   return $this->start_transaction($r);
                   break;
               case 'end':
                   # code...
                    return $this->end_transaction($r);
                   break;
                case 'delete':
                    # code...
                    break;
                case 'linkroom':
                    return $this->linkroom($r);
                    # code...
                    break;
                case 'payment':
                    # code...
                    //Will return data for receipt.
                    return $this->handle_payment($r);
                    break;
                case 'sparoom_checkout':
                    return $this->sparoom_checkout($r);
                    # code...
                    break;
                case 'lockerkey_checkout':

                    return $this->lockerkey_checkout($r);
                    # code...
                    break;
                case 'linkedproducts':
                    return $this->linkedproducts($r);
                    # code...
                    break;
                case 'records':
                    # code...
                    return $this->transaction_records($r);
                    break;
                case 'pettycash':
                    return $this->pettycash($r);
                    # code...
                    break;
                case 'receiptvoid':
                    # code...
                    return $this->receiptvoid($r);
                case 'starthotelroom':
                    # code...
                    return $this->starthotelroom($r);
                    break;
                case 'hotelroom_checkout':
                    # code...
                    return $this->hotelroom_checkout($r);
                    break;
                case 'stockreport':
                    return $this->do_stockreport($r);
                    break;
                case 'create_receipt':
                    return $this->create_receipt($r);
                    break;
               default:
                   # code...
                   break;
           }
        }
        catch(\Exception $e){
            $ret["short_message"]=$e->getMessage();
            Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
        }
        return response()->json($ret);
    }





    //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    
    public function receiptvoid(Request $r,$uid=NULL)
    {
        $ret=array();
        $ret["status"]="failure";
        if(!Auth::check()){return "";}
        $user_id=Auth::user()->id;
        if(!empty($uid) and Auth::user()->hasRole("adm")){
            $user_id=$uid;
        }
        try{
            $table="opos_receipt";
            $data=DB::table($table)
            ->select("*")
            ->where("id","=",$r->receipt_id)
            ->first();

            if(!empty($data)){
            $data->id="";
            $data->status="voided";
            $data->cash_received=-($data->cash_received);

            DB::table($table)->insert((array)$data);
           
    }
                       
            
           $this->handle_inventory($r,"add");
            $ret["status"]="success";
            $ret["data"]=$data;
        }
        catch(\Exception $e){
            echo $ret["short_message"]=$e->getMessage();
exit;

            Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
        }
        if(count($data)>0){
        echo "Success Voiding Receipt";
        }else{
        echo "Unable to update or no receipt found";
        }
    }
    
    //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    
    public function transaction_records(Request $r,$uid=NULL)
    {
        $ret=array();
        $ret["status"]="failure";
        if(!Auth::check()){return "";}
        $user_id=Auth::user()->id;
        if(!empty($uid) and Auth::user()->hasRole("adm")){
            $user_id=$uid;
        }
        try{
            $dataquery="
            SELECT
            olt.checkin_tstamp,
            olkt.ref_no,
            olt.lockerkey_ftype_id as ftype_id,
            opr.id as receipt_id,
            'lockerkey' as ftype,
            olt.id as txn_id

            FROM 
            opos_receipt opr
            JOIN opos_lockerkeytxnref olkt on olkt.ref_no=opr.ref_no
            JOIN (SELECT * from opos_lockerkeytxn 
            WHERE deleted_at IS NULL AND checkout_tstamp IS NULL
            AND checkin_tstamp IS NOT NULL

            )olt on olt.id=olkt.lockerkeytxn_id
            WHERE 
            opr.deleted_at IS NULL


            ";
            $data=DB::select(DB::raw($dataquery));
            
            $ret["status"]="success";
            $ret["data"]=$data;
        }
        catch(\Exception $e){
            $ret["short_message"]=$e->getMessage();
            Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
        }
        return response()->json($ret);
    }
    

    //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    
    public function linkedproducts(Request $r,$uid=NULL)
    {
        $ret=array();
        $ret["status"]="failure";
        $data=[];
        if(!Auth::check()){return "";}
        $user_id=Auth::user()->id;
        if(!empty($uid) and Auth::user()->hasRole("adm")){
            $user_id=$uid;
        }
        try{
            $table="opos_lockerkeytxn";
            $txn=DB::table($table)
				->where($table.".lockerkey_ftype_id",$r->ftype_id)        
				->whereNull($table.".deleted_at")
                //->whereNull($table.".checkout_tstamp")
				->orderBy($table.".created_at","DESC")
				->first();
			Log::debug('txn='.json_encode($txn));

            if (empty($txn)) {
                $ret["status"]="success";
                $ret["data"]=$data;
                return response()->json($ret);
            }

            $ref_no=DB::table("opos_lockerkeytxnref")
				->where("lockerkeytxn_id",$txn->id)
				->whereNull("deleted_at")
				->orderBy("created_at","DESC")
				->pluck("ref_no");
			Log::debug('ref_no='.json_encode($ref_no));

            $receipt=DB::table("opos_receipt")
                ->where("ref_no",$ref_no)
                ->whereNull("deleted_at")
                ->first();
            $receipt_id=$receipt->id;
			Log::debug('receipt_id='.json_encode($receipt_id));

			/* receipt_id will be null if products have not been selected */
			if (!empty($receipt_id)) {
				$query="
					SELECT 
					p.id as product_id,
					p.name,
					p.thumb_photo,
					rp.quantity,
					rp.price,
                    rp.discount,
					rp.actual_discounted_amt as discount_amt,
					(CASE 
						WHEN rp.actual_discounted_amt IS NOT NULL
						THEN ROUND(((rp.actual_discounted_amt/rp.price)*100),2)
						ELSE 0.00
					END) as discount

					FROM opos_receiptproduct rp
					JOIN opos_receipt r on r.id=rp.receipt_id
					JOIN opos_lockerkeytxnref okf on r.ref_no =okf.ref_no
					JOIN opos_lockerkeytxn ol on okf.lockerkeytxn_id=ol.id
					JOIN product p on p.id=rp.product_id

					WHERE rp.deleted_at IS NULL and r.status = 'active'
					AND p.deleted_at IS NULL
					AND rp.receipt_id=$receipt_id 
					-- AND ol.checkout_tstamp IS NULL
					-- AND ol.checkin_tstamp IS NOT NULL
					AND ol.deleted_at IS NULL
				";

				$data=DB::select(DB::raw($query));
				Log::info(json_encode($data));

				$ret["status"]="success";
				$ret["data"]=$data;
                $ret['receipt']=$receipt;

			} else {
				Log::debug('$receipt_id = NULL!');

				$ret["status"]="error";
				$ret["data"]="no product";
			}

        } catch(\Exception $e){
            $ret["short_message"]=$e->getMessage();
            Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
        }
        return response()->json($ret);
    }


    //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    
    public function handle_payment($r,$uid=NULL)
    {
		Log::debug('***** handle_payment() *****');
        $ret=array();
        $ret["status"]="failure";
        if(!Auth::check()){return "";}
        $user_id=Auth::user()->id;
        if(!empty($uid) and Auth::user()->hasRole("adm")){
            $user_id=$uid;
        }
        try{
            $table="opos_receipt";
            $payment_type="cash";
            if (!empty($r->creditcard_no) && $r->creditcard_no!=0 && $r->creditcard_no!="0" ) {
                # code...
                $payment_type="creditcard";
            }
			Log::debug('payment_type='.$payment_type);

            //$receipt=DB::table('merchant')->where("user_id",$user_id)->first();
            $receipt=DB::table('opos_receipt')->where("staff_user_id",$user_id)->orderby('receipt_no','desc')->first();
            //$receipt_no=1;
            if (empty($receipt)) {
                $ret["short_message"]="Receipt is not valid";
                return response()->json($ret);
            }else{
				/* You gotta get last count receipt_no from merchant.receipt_no */
                if (!empty($receipt->receipt_no)) {
                    $receipt_no=$receipt->receipt_no + 1;
                } else {
					$receipt_no = 1;
				}
            }
            DB::table('merchant')
            ->where("user_id",$user_id)        
            ->update(array('receipt_no'=>$receipt_no));
            $update_data=[
                "terminal_id"=>$r->terminal_id,
                "updated_at"=>Carbon::now(),
                "receipt_no"=>$receipt_no,
                'cash_received'=>$r->cash_received,
                'cash_10k'=>$r->cash_10000,
                'cash_1k'=>$r->cash_1000,
                'cash_100'=>$r->cash_100,
                'cash_50'=>$r->cash_50,
					/* You gotta get last count receipt_no from merchant.receipt_no */
                'cash_20'=>$r->cash_20,
                'cash_10'=>$r->cash_10,
                'cash_5'=>$r->cash_5,
                'cash_2'=>$r->cash_2,
                'cash_1'=>$r->cash_1,
                'cents_1'=>$r->cents_1,
                'cents_5'=>$r->cents_5,
                'cents_10'=>$r->cents_10,
                'cents_20'=>$r->cents_20,
                'cents_50'=>$r->cents_50,
                'creditcard_no'=>$r->creditcard_no,
                'payment_type'=>$payment_type,
                'points'=>$r->points,
                'status'=>'completed'
            ];

            $data=DB::table($table)
            ->where($table.".id",$r->receipt_id)        
            ->whereNull($table.".deleted_at")
            ->update($update_data);

			Log::debug('***** Update data *****');
			Log::debug($data);
    
            $ret["status"]="success";
            $ret["data"]=$data;

        } catch(\Exception $e){
            $ret["short_message"]=$e->getMessage();
            Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
        }
        return response()->json($ret);
    }
    

    //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    
    public function linkroom($r,$uid=NULL)
    {
        $ret=array();
        $ret["status"]="failure";
        if(!Auth::check()){return "";}
        $user_id=Auth::user()->id;
        if(!empty($uid) and Auth::user()->hasRole("adm")){
            $user_id=$uid;
        }
        try{
            $ftype=DB::table("opos_ftype")
            ->where("id",$r->id)->first();
            $checkin_tstamp=Carbon::now();
            $insert_data=[
            "lockerkey_ftype_id"=>$r->lockerkey_id,
            "sparoom_ftype_id"=>$ftype->id,
            "sparoom_checkin"=>$checkin_tstamp,
            "updated_at"=>Carbon::now(),
            "created_at"=>Carbon::now()
            ];
            $txn_id=DB::table("opos_lockerkeytxnsparoom")
            ->insertgetId($insert_data);
            $ret["status"]="success";
            $data=[
                "checkin_tstamp"=>$checkin_tstamp,
                

                "ftype_id"=>$r->id,
                "ftype"=>$ftype,
                "txn_id"=>$txn_id
            ];
            $ret["data"]=$data;
        }
        catch(\Exception $e){
            $ret["short_message"]=$e->getMessage();
            Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
        }
        return response()->json($ret);
    }

    //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    
    public function lockerkey_checkout(Request $r,$uid=NULL)
    {
        $ret=array();
        $ret["status"]="failure";
        if(!Auth::check()){return "";}
        $user_id=Auth::user()->id;
        if(!empty($uid) and Auth::user()->hasRole("adm")){
            $user_id=$uid;
        }
        try{
            $table="opos_lockerkeytxn";

            $update_data=[
                "checkout_tstamp"=>Carbon::now(),
                "updated_at"=>Carbon::now()

            ];
            Log::debug($r->ftype_id);
            
            $is_transact=DB::table("opos_lockerkeytxn")
            ->where("lockerkey_ftype_id",$r->ftype_id)
            ->whereNull("checkout_tstamp")
            ->whereNull("deleted_at")
            ->first();
            if(!empty($is_transact)){
                $is_lockerkeytxnref=DB::table("opos_lockerkeytxnref")
                ->where("lockerkeytxn_id",$is_transact->id)
                ->first();
                if(!empty($is_lockerkeytxnref)){
                    $is_receipt=DB::table("opos_receipt")
                    ->where("ref_no",$is_lockerkeytxnref->ref_no)
                    ->first();
                    if(!empty($is_receipt)){
                        DB::table('opos_receiptproduct')->where('receipt_id', $is_receipt->id)->delete();
                        DB::table('opos_save')->where('receipt_id', $is_receipt->id)->delete();
                    }
                }
            }
            
            
            
            $data=DB::table($table)
            ->where($table.".lockerkey_ftype_id",$r->ftype_id)        
            ->whereNull($table.".deleted_at")
            ->whereNull($table.".checkout_tstamp")
            ->update($update_data); 
            
            
            
            $ret["status"]="success";
            $ret["data"]=$data;
            
        }
        catch(\Exception $e){
            $ret["short_message"]=$e->getMessage();
            Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
        }
        return response()->json($ret);
    }
    public function hotelroom_checkout(Request $r,$uid=NULL)
    {
        $ret=array();
        $ret["status"]="failure";
        if(!Auth::check()){return "";}
        $user_id=Auth::user()->id;
        if(!empty($uid) and Auth::user()->hasRole("adm")){
            $user_id=$uid;
        }
        try{
            $table="opos_hotelroomtxn";

            $update_data=[
                "checkout_tstamp"=>Carbon::now(),
                "updated_at"=>Carbon::now()

            ];
            Log::debug($r->ftype_id);
            $data=DB::table($table)
            ->where($table.".hotelroom_ftype_id",$r->ftype_id)        
            ->whereNull($table.".deleted_at")
            ->whereNull($table.".checkout_tstamp")
            ->update($update_data);
    
            
            $ret["status"]="success";
            $ret["data"]=$data;
        }
        catch(\Exception $e){
            $ret["short_message"]=$e->getMessage();
            Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
        }
        return response()->json($ret);
    }

    //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    
    public function sparoom_checkout(Request $r,$uid=NULL)
    {
        $ret=array();
        $ret["status"]="failure";
        if(!Auth::check()){return "";}
        $user_id=Auth::user()->id;
        if(!empty($uid) and Auth::user()->hasRole("adm")){
            $user_id=$uid;
        }
        try{
            $table="opos_lockerkeytxnsparoom";
            $update_data=[
                "sparoom_checkout"=>Carbon::now(),
                "updated_at"=>Carbon::now()
            ];
            $data=DB::table($table)
            ->where($table.".sparoom_ftype_id",$r->ftype_id)

            ->whereNull($table.".deleted_at")

            ->whereNull($table.".sparoom_checkout")
            ->update($update_data);
    
            
            $ret["status"]="success";
            $ret["data"]=$data;
        }
        catch(\Exception $e){
            $ret["short_message"]=$e->getMessage();
            Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
        }
        return response()->json($ret);
    }
    
    
    //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    
    public function end_transaction(Request $r,$uid=NULL)
    {
        $ret=array();
        $ret["status"]="failure";
        if(!Auth::check()){return "";}
        $user_id=Auth::user()->id;
        if(!empty($uid) and Auth::user()->hasRole("adm")){
            $user_id=$uid;
        }

        try{
            $this->handle_payment($r);
            $this->sparoom_checkout($r);
            $this->lockerkey_checkout($r);
            $this->handle_inventory($r);
            $ret["status"]="success";
            $ret["data"]=$r->ftype_id;
        }
        catch(\Exception $e){
            $ret["short_message"]=$e->getMessage();
            Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
        }
        return response()->json($ret);
    }
    
    //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    
    public function handle_inventory(Request $r,$action="minus",$uid=NULL)
    {
        $ret=array();
        $ret["status"]="failure";
        if(!Auth::check()){return "";}
        $user_id=Auth::user()->id;
        if(!empty($uid) and Auth::user()->hasRole("adm")){
            $user_id=$uid;
        }
        try{
            $location_id=DB::table("opos_locationterminal")
            ->where("terminal_id",$r->terminal_id)
          /*  ->whereNull("deleted_at")*/
            ->pluck("location_id");
            $table="opos_receiptproduct";
            $rps=DB::table($table)
            ->where($table.".receipt_id",$r->receipt_id)      
            ->whereNull($table.".deleted_at")
            ->orderBy($table.".created_at","DESC")
            ->get();
    
            foreach ($rps as $r) {
                # code...
                UtilityController::locationproduct($location_id,$r->product_id,$r->quantity,$action);
            }
            $ret["status"]="success";
            $ret["data"]="success";
        }
        catch(\Exception $e){
            $ret["short_message"]=$e->getMessage();
            Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
        }
        return response()->json($ret);
    }
    //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    
    public function create_receipt(Request $r,$uid=NULL)
    {
        $ret=array();
        $ret["status"]="failure";
        if(!Auth::check()){return "";}
        $user_id=Auth::user()->id;
        if(!empty($uid) and Auth::user()->hasRole("adm")){
            $user_id=$uid;
        }
        try{
            $insert_data=[
                "ref_no"=>$r->ref_no,
                "terminal_id"=>$r->terminal_id,
                "staff_user_id"=>$user_id,
                "created_at"=>Carbon::now(),
                "updated_at"=>Carbon::now()
            ];
            $table="opos_receipt";
            $receipt_id=DB::table($table)
            ->insertgetId($insert_data);
    
            
            $ret["status"]="success";
            $ret["receipt_id"]=$receipt_id;
        }
        catch(\Exception $e){
            $ret["short_message"]=$e->getMessage();
            Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
        }
        return response()->json($ret);
    }
    
    //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    
    public function start_transaction(Request $r,$uid=NULL)
    {
        $ret=array();
        $ret["status"]="failure";
        if(!Auth::check()){return "";}
        $user_id=Auth::user()->id;
        if(!empty($uid) and Auth::user()->hasRole("adm")){
            $user_id=$uid;
        }
        try{

            $checkin_tstamp=Carbon::now();
            $ftype=DB::table("opos_ftype")->where("id",$r->id)->first();
            if (empty($ftype)) {
                # code...
                return "";
            }
            /*Check if a transaction is already happening*/
            $is_transact=DB::table("opos_lockerkeytxn")
            ->where("lockerkey_ftype_id",$ftype->id)
            ->whereNull("checkout_tstamp")
            ->whereNotNull("checkin_tstamp")
            ->whereNull("deleted_at")
            ->first();
            if (!empty($is_transact)) {
                $ret["short_message"]="Transaction already in progress";
                return response()->json($ret);
            }
            $txn_data=[
                "lockerkey_ftype_id"=>$r->id,
                "checkin_tstamp"=>$checkin_tstamp,
                "created_at"=>Carbon::now(),
                "updated_at"=>Carbon::now()
            ];
            $txn_id=DB::table("opos_lockerkeytxn")
            ->insertgetId($txn_data);
            $txn_ref_data=[
                "lockerkeytxn_id"=>$txn_id,
                "ref_no"=>$r->ref_no,
               
                "created_at"=>Carbon::now(),
                "updated_at"=>Carbon::now()
            ];
            DB::table("opos_lockerkeytxnref")
            ->insertgetId($txn_ref_data);
            /**/
            
            $insert_data=[
                "ref_no"=>$r->ref_no,
                "terminal_id"=>$r->terminal_id,
                "staff_user_id"=>$user_id,
                "created_at"=>Carbon::now(),
                "updated_at"=>Carbon::now()
            ];
            $table="opos_receipt";
            $receipt_id=DB::table($table)
            ->insertgetId($insert_data);
            
            $ret["status"]="success";
            $data=[
                "checkin_tstamp"=>$checkin_tstamp,
                "receipt_id"=>$receipt_id,
                "ref_no"=>$r->ref_no,
                "ftype_id"=>$r->id,
                "ftype"=>$ftype,
                "txn_id"=>$txn_id
            ];
            $ret["data"]=$data;
        }
        catch(\Exception $e){
            $ret["short_message"]=$e->getMessage();
            Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
        }
        return response()->json($ret);
    }
    public function starthotelroom(Request $r,$uid=NULL)
    {
        $ret=array();
        $ret["status"]="failure";
        if(!Auth::check()){return "";}
        $user_id=Auth::user()->id;
        if(!empty($uid) and Auth::user()->hasRole("adm")){
            $user_id=$uid;
        }
        try{

            $checkin_tstamp=Carbon::now();
            $ftype=DB::table("opos_ftype")->where("id",$r->id)->first();
            if (empty($ftype)) {
                # code...
                return "";
            }
            /*Check if a transaction is already happening*/
            $is_transact=DB::table("opos_hotelroomtxn")
            ->where("hotelroom_ftype_id",$ftype->id)
            ->whereNull("checkout_tstamp")
            ->whereNotNull("checkin_tstamp")
            ->whereNull("deleted_at")
            ->first();
            if (!empty($is_transact)) {
                $ret["short_message"]="Transaction already in progress";
                return response()->json($ret);
            }
            $txn_data=[
                "hotelroom_ftype_id"=>$r->id,
                "checkin_tstamp"=>$checkin_tstamp,
                "created_at"=>Carbon::now(),
                "updated_at"=>Carbon::now()
            ];
            $txn_id=DB::table("opos_hotelroomtxn")
            ->insertgetId($txn_data);
               
            $insert_data=[
                "ref_no"=>$r->ref_no,
                "terminal_id"=>$r->terminal_id,
                "staff_user_id"=>$user_id,
                "created_at"=>Carbon::now(),
                "updated_at"=>Carbon::now()
            ];
            $table="opos_receipt";
            $receipt_id=DB::table($table)
            ->insertgetId($insert_data);
    
            
            $ret["status"]="success";
            $data=[
                "checkin_tstamp"=>$checkin_tstamp,
                "receipt_id"=>$receipt_id,
                "ref_no"=>$r->ref_no,
                "ftype_id"=>$r->id,
                "ftype"=>$ftype,
                "txn_id"=>$txn_id
            ];
            $ret["data"]=$data;
        }
        catch(\Exception $e){
            $ret["short_message"]=$e->getMessage();
            Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
        }
        return response()->json($ret);
    }
    
    //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    
    public function support($type,$uid=NULL)
    {
        $ret=array();
        $ret["status"]="failure";
        if(!Auth::check()){return "";}
        $user_id=Auth::user()->id;
        if(!empty($uid) and Auth::user()->hasRole("adm")){
            $user_id=$uid;
        }
        try{
            switch ($type) {
                case 'pettycashreasons':
                    # code...
                    return $this->pettycashreasons();
                    break;
                case 'terminals':
                    # code...
                    return $this->terminals();
                    break;
                default:
                    # code...
                    break;
            }
            
        }
        catch(\Exception $e){
            $ret["short_message"]=$e->getMessage();
            Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
        }
        return response()->json($ret);
    }
    
    //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    
    public function terminals($uid=NULL)
    {
        $ret=array();
        $ret["status"]="failure";
        if(!Auth::check()){return "";}
        $user_id=Auth::user()->id;
        if(!empty($uid) and Auth::user()->hasRole("adm")){
            $user_id=$uid;
        }

        try{
            $query="
                SELECT
                    oplt.location_id,
                    oplt.id,
                    oplt.terminal_id,
                    f.location
                FROM 
                    opos_locationterminal oplt

                    JOIN fairlocation f on f.id=oplt.location_id

                WHERE
                    f.user_id=$user_id
                    AND f.deleted_at IS NULL
                    

            ";
            $data=DB::select(DB::raw($query));
            
            $ret["status"]="success";
            $ret["data"]=$data;
        }
        catch(\Exception $e){
            $ret["short_message"]=$e->getMessage();
            Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
        }
        return response()->json($ret);
    }
    

    //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    
    public function pettycashreasons($uid=NULL)
    {
        $ret=array();
        $ret["status"]="failure";
        if(!Auth::check()){return "";}
        $user_id=Auth::user()->id;
        if(!empty($uid) and Auth::user()->hasRole("adm")){
            $user_id=$uid;
        }
        try{
            $table="opos_pcreason";
            $data=DB::table($table)
           /* ->where($table.".","")  */      
            ->whereNull($table.".deleted_at")
            ->orderBy($table.".name","ASC")
            ->get();
    
            
            $ret["status"]="success";
            $ret["data"]=$data;
        }
        catch(\Exception $e){
            $ret["short_message"]=$e->getMessage();
            Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
        }
        return response()->json($ret);
    }

    /**********************RECEIPT********************************************/

    //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    
    public function receipt($action="",$receipt_id,$uid=NULL)
    {
        $ret=array();
        $ret["status"]="failure";
        if(!Auth::check()){return "";}
        $user_id=Auth::user()->id;
        if(!empty($uid) and Auth::user()->hasRole("adm")){
            $user_id=$uid;
        }
        try{
            switch ($action) {
                case 'generate':

                    return $this->generate_receipt($receipt_id,$uid);
                    break;
                
                default:
                    # code...
                    break;
            }
        }
        catch(\Exception $e){
            $ret["short_message"]=$e->getMessage();
            Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
        }
        return response()->json($ret);
    }

    //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    
    public function generate_receipt($receipt_id,$uid=NULL)
    {
        /*Returns JSON data for receipt*/
        $ret=array();
        $ret["status"]="failure";
        if(!Auth::check()){return "";}
        $user_id=Auth::user()->id;
        if(!empty($uid) and Auth::user()->hasRole("adm")){
            $user_id=$uid;
        }
        try{
            $data=$this->receiptproducts($receipt_id);

            return view('modals.opossumreceipt',$data);

        }
        catch(\Exception $e){
            $ret["short_message"]=$e->getMessage();
            Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
        }
        return view('common.generic');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function stockin($terminal_id)
    {
        $user_id     = Auth::user()->id;
        $location_id=DB::table("opos_locationterminal")->where("terminal_id",$terminal_id)->orderBy("id","DESC")->pluck("location_id");
        if (empty($location_id)) {
            return "Invalid Terminal ID";
        }
        $merchant = Merchant::where('user_id','=',$user_id)->first();
        $merchant_pro = $merchant->products()
        ->whereNull('product.deleted_at')
        ->leftJoin('product as productb2b', function($join) {
            $join->on('product.id', '=', 'productb2b.parent_id')
            ->where('productb2b.segment','=','b2b');
        })
        ->leftJoin('product as producthyper', function($join) {
            $join->on('product.id', '=', 'producthyper.parent_id')
            ->where('producthyper.segment','=','hyper');
        })
        ->leftJoin('tproduct as tproduct', function($join) {
            $join->on('product.id', '=', 'tproduct.parent_id');
        })
        ->leftJoin('productbc','product.id','=','productbc.product_id')
        ->leftJoin('bc_management','bc_management.id','=','productbc.bc_management_id')
        ->select(DB::raw('
            product.id,
            product.parent_id,
            bc_management.id as bc_management_id,
            productbc.deleted_at as pbdeleted_at,
            product.name,
            product.thumb_photo as photo_1,
            product.available,
            productb2b.available as availableb2b,
            producthyper.available as availablehyper,
            tproduct.available as warehouse_available,
            product.sku'))
        ->groupBy('product.id')
            ->where("product.status","!=","transferred")
            ->where("product.status","!=","deleted")
            ->where("product.status","!=","")
            ->orderBy('product.created_at','DESC')
            ->get();
        foreach ($merchant_pro as $product) {
            /*Get available quantity*/
            $available_quantity=DB::table("locationproduct")
            ->where("product_id",$product->id)
            ->where("location_id",$location_id)
            ->orderBy("id","DESC")
            ->pluck("quantity");
            if (empty($available_quantity)) {
                # code...
                $available_quantity=0;
            }
            $product->available_quantity=$available_quantity;
        }
        return $merchant_pro;
		return Response()->json($products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function stockout($terminal_id)
    {
        $user_id     = Auth::user()->id;
        $merchant = Merchant::where('user_id','=',$user_id)->first();
        $location_id=DB::table("opos_locationterminal")->where("terminal_id",$terminal_id)->orderBy("id","DESC")->pluck("location_id");
        if (empty($location_id)) {
            return "Invalid Terminal ID";
        }
         $merchant_pro = $merchant->products()
        ->whereNull('product.deleted_at')
        ->leftJoin('product as productb2b', function($join) {
            $join->on('product.id', '=', 'productb2b.parent_id')
            ->where('productb2b.segment','=','b2b');
        })
        ->leftJoin('product as producthyper', function($join) {
            $join->on('product.id', '=', 'producthyper.parent_id')
            ->where('producthyper.segment','=','hyper');
        })
        ->leftJoin('tproduct as tproduct', function($join) {
            $join->on('product.id', '=', 'tproduct.parent_id');
        })
        ->join("locationproduct","locationproduct.product_id","=","product.id")
        ->leftJoin('productbc','product.id','=','productbc.product_id')
        ->leftJoin('bc_management','bc_management.id','=','productbc.bc_management_id')
        ->select(DB::raw('
            product.id,
            product.parent_id,
            bc_management.id as bc_management_id,
            productbc.deleted_at as pbdeleted_at,
            product.name,
            product.thumb_photo as photo_1,
            product.available,
            productb2b.available as availableb2b,
            producthyper.available as availablehyper,
            tproduct.available as warehouse_available,
            product.sku'))
        ->groupBy('product.id')
            ->where("product.status","!=","transferred")
            ->where("product.status","!=","deleted")
            ->where("product.status","!=","")
            ->where("locationproduct.location_id",$location_id)
            ->orderBy('product.created_at','DESC')
            ->get();
        foreach ($merchant_pro as $product) {
            /*Get available quantity*/
            $available_quantity=DB::table("locationproduct")
            ->where("product_id",$product->id)
            ->where("location_id",$location_id)
            ->orderBy("id","DESC")
            ->pluck("quantity");
            $product->available_quantity=$available_quantity;
        }
        return $merchant_pro;
		//return Response()->json($products);
    }
    

    public function showreceiptlist(Request $request,$terminal_id){

        $user_id=Auth::user()->id;

        $month = Carbon::today()->format('F');
        $year = Carbon::now()->year;
        $terminalId = '0';

        $formdate = Carbon::today()->format('jS');

        if (!Auth::check()) {
            return response()->json(["error"=>"Not Logged In"],403);
        }

        $merchant = DB::table('merchant')->where('user_id',$user_id)->first();

        $selluser = User::find($user_id);

        $merchant_address = Address::where('id',!empty($merchant->address_id)?$merchant->address_id:"")
        ->first(array('line1','line2','line3','line4'));
        
$user_id=360;
        // $terminalId = DB::table('opos_terminalusers')->select('opos_terminalusers.terminal_id')->where('opos_terminalusers.user_id', $user_id)->first();

        // if(count($terminalId) <= 0){
        //     echo "<h4'>Terminal not found!</h4>";
        //     exit();
        // }

        if($terminal_id > 0)
        {
            $terminalId = $terminal_id;
        }
        else{
            echo "<h4'>Terminal not found!</h4>";
            exit();
        }

        $location  = DB::table('opos_locationterminal')
                ->select('fairlocation.*','opos_locationterminal.terminal_id')
                ->join('fairlocation','opos_locationterminal.location_id','=','fairlocation.id')
                ->where('opos_locationterminal.terminal_id',$terminalId)->first();

        $currency= DB::table('currency')->where('active', 1)->first()->code;

        $reports = DB::table("opos_receipt")
        ->join("opos_receiptproduct","opos_receiptproduct.receipt_id","=","opos_receipt.id")
        ->join('opos_locationterminal','opos_receipt.terminal_id','=','opos_locationterminal.terminal_id')
        ->join('fairlocation','fairlocation.id','=','opos_locationterminal.location_id')
        ->leftJoin('users as usercheck','usercheck.id','=','opos_receipt.staff_user_id')
        ->select('opos_receipt.id','opos_receipt.staff_user_id','opos_receipt.created_at','usercheck.first_name',
            'usercheck.last_name','opos_receipt.receipt_no','opos_receipt.terminal_id','opos_receipt.cash_received',
            'fairlocation.location',DB::raw(
                "SUM(opos_receiptproduct.quantity*opos_receiptproduct.price) as amount"
            )
        );
      
        $reports = $reports->whereRaw('opos_receipt.terminal_id = '.$terminalId)
                       ->whereRaw('opos_receipt.status = "completed"');
                       
        $report1 = $reports->toSql();
        $report2 = $reports->toSql();

        $monthlyAmount = DB::select($report2.' and opos_receipt.created_at like "'.date('Y-m',strtotime(Carbon::today())).'%"');
        
        $todayAmount = DB::select($report1.' and opos_receipt.created_at like "'.date('Y-m-d',strtotime(Carbon::today())).'%"');

        $reports->whereRaw('Date(opos_receipt.created_at) = CURDATE()')
                ->groupBy("opos_receipt.id")
                ->orderBy("opos_receipt.id", "desc");
       $reports = $reports->orderBy("opos_receipt.created_at","DESC")
                          ->get();

        // $start = Carbon::now()->startOfMonth()->format('Y-m-d H:i:s');
        // $end = Carbon::now()->endOfMonth()->format('Y-m-d H:i:s');
        
        $s= $merchant_address;
        $name = !empty($merchant->company_name)?$merchant->company_name:"";    
        $monthNum=Carbon::now()->month;
		$monthName = $month; // March        
		$year=Carbon::now()->year;


		return view('opposum.trunk.oposumreceiptlist')
		->with('reports' ,$reports)
		->with('location' ,$location)
		->with('monthlyAmount' ,$monthlyAmount)
		->with('todayAmount' ,$todayAmount)
		->with('terminalId' ,$terminalId)
		->with('selluser' ,$selluser)
		->with('merchant' , $merchant)
		->with('currency' , $currency)
		->with('merchant_address' , $merchant_address)
		->with('name' ,$name)
		->with('s' , $s)
        ->with('id' , $user_id)
        ->with('month',$monthName)
        ->with('year',$year)
        ->with('today', $formdate);        
    }

    public function showopossumreceipt($receipt_id){
        $user_id = Auth::user()->id;
        $receiptInfo = OposReceipt::find($receipt_id);
        $data=$this->receiptproducts($receipt_id);

        $staff_user_id = "";
        if(isset($receiptInfo)){
            $staff_user_id = $receiptInfo->staff_user_id;
        }

        if($staff_user_id !== "" && $staff_user_id == 0 ) {
            $staff_user_id = $user_id;
        }

        $company=Company::where('company.owner_user_id',$user_id)->
            join("merchant","merchant.user_id","=","company.owner_user_id")->
            join("users","users.id","=","merchant.user_id")->
            leftJoin('address','merchant.address_id','=','address.id')->
            leftJoin('city','address.city_id','=','city.id')->
            leftJoin('state','city.state_code','=','state.code')->
            select('address.line1','address.line2','address.line3',
                'city.name','state.name','address.postcode',
                'company.dispname','company.id','merchant.gst',
                'users.first_name as first_name',
                'users.last_name as last_name',
                'users.name','users.id as user_id')->
            first();

        
        $staff = DB::table('users')
                ->select('users.first_name','users.last_name')
                ->join('opos_receipt','opos_receipt.staff_user_id','=','users.id')
                ->where('staff_user_id',$staff_user_id)
                ->first();    

        return view('opposum.trunk.receipts',$data)
        ->with('receiptInfo',$receiptInfo)
        ->with('company',$company)
        ->with('staff',$staff);
    }
        

    public function savelokersession(Request $request){
        $lokerdata = (object) $request->all();
        if($lokerdata->ftype_id != '') {
			//get locker key no.
			$lockerkeyno = DB::table('opos_ftype')
				->select('fnumber')
				->where('id',$lokerdata->ftype_id)
				->where('ftype','lockerkey')
				->orderby('id','desc')
				->first();
               
			//get transaction reference number
			$lockerkeydata = DB::table('opos_lockerkeytxn')
				->select('*')
				->where('lockerkey_ftype_id',$lokerdata->ftype_id)
				->whereNull("deleted_at")
				->orderby('id','desc')
				->first();
            if (empty($lockerkeydata)) {
                return response()->json([
                    "status"=>"failure"
                ]);
            }
			 //get receipt id
			$lockerkeytxn_id =  $lockerkeydata->id;
			$receiptdata = DB::table('opos_lockerkeytxnref')
				->join('opos_receipt','opos_receipt.ref_no','=','opos_lockerkeytxnref.ref_no')
				->select('opos_lockerkeytxnref.*','opos_receipt.id')
				->where('opos_lockerkeytxnref.lockerkeytxn_id',$lockerkeytxn_id)
				->whereNull("opos_lockerkeytxnref.deleted_at")
				->orderby('opos_lockerkeytxnref.id','desc')
				->first();

			// $sparoom = DB::table('opos_lockerkeytxnsparoom')
			//  ->select('*')
			//  ->where('lockerkey_ftype_id',$ftypelocarkeydata->id)
			//  ->orderby('id','desc')
			//  ->first();

			$table="opos_save";
			$insert_data=[
				"receipt_id"=>isset($receiptdata->id) ? $receiptdata->id: null,
				"lockerkey_start"=>isset($lockerkeydata->checkin_tstamp) ? $lockerkeydata->checkin_tstamp: null,
				"lockerkey_end"=>isset($lockerkeydata->checkout_tstamp) ? $lockerkeydata->checkout_tstamp: null,
				"lockerkey_no"=>$lockerkeyno->fnumber,
				// "sparoom_no"=>$sparoom->sparoom_ftype_id,
				"created_at"=>Carbon::now(),
				"updated_at"=>Carbon::now()
			];

			try {
				$data=DB::table($table)->insertgetId($insert_data);              

			} catch(\Exception $e){
				$ret["short_message"]=$e->getMessage();
				Log::error("Error @ ".$e->getLine()." file ".
				$e->getFile()." ".$e->getMessage());
			} 
		} 

        return  response()->json(["status" => true]);
    }

    public function showSavedData()
    {
        $lokerdata = DB::table('opos_save')
                    ->select('*')
                    ->get();

        return view('opposum.trunk.oposumsavedata',compact('lokerdata'));
    }


    public function deletelokersession(Request $request){
        $lokerdata = (object) $request->all();

        if($lokerdata->type == "endlockerid")
        {
            $ftypeid = DB::table('opos_ftype')
                ->select('fnumber')
                ->where('id',$lokerdata->id)
                ->where('ftype','lockerkey')
                ->whereNull("deleted_at")
                ->orderby('id','desc')
                ->first();

            $opos = OposSave::select('id')
                            ->where('lockerkey_no',$ftypeid->fnumber)
                            ->first();
            if(count($opos) > 0)
            {
             $lokerdata->id = $opos->id;
            }
        }
        $delete = OposSave::findOrFail($lokerdata->id);
        $status =  $delete->delete();
        return  response()->json(["status" => $status]);
    } 

    public function getftypeid(Request $request){
        $lokerdata = (object) $request->all();

        $ftypeid = DB::table('opos_ftype')
                ->select('id')
                ->where('fnumber',$lokerdata->lockerkey)
                ->where('ftype','lockerkey')
                ->orderby('id','desc')
                ->first();
       
        return  response()->json(["ftypeid" => $ftypeid->id]);
    } 
    function lokerkeydata(Request $request){
        $lokerdata = (object) $request->all();
        $lockerkey = (int) $lokerdata->lockerkey;
        
        $pacustlockerkeydata = DB::table('opos_spacustlockerkey')
                    ->select('*')
                    ->where('lockerkey_id',$lockerkey)
                     ->orderby('id','desc')
                    ->first();
        $pacustdata = array();
        if(isset($pacustlockerkeydata->spacust_id)){
        $pacustdata = DB::table('opos_spacust')
                    ->select('*')
                    ->where('lockerkey_id',$pacustlockerkeydata->spacust_id)
                     ->orderby('id','desc')
                    ->first();
        }
        $ftypedata = DB::table('opos_ftype')
                    ->select('*')
                    ->where('fnumber',$lockerkey)
                    ->where('ftype','lockerkey')
                     ->orderby('id','desc')
                    ->first();
        $locarkeydata = DB::table('opos_lockerkeytxn')
                    ->select('*')
                    ->where('lockerkey_ftype_id',$ftypedata->id)
                     ->orderby('id','desc')
                    ->first();
        $locarkeydata->checkin_tstamp=UtilityController::s_date($locarkeydata->checkin_tstamp);
        $locarkeydata->checkout_tstamp=UtilityController::s_date($locarkeydata->checkout_tstamp);
        return view('opposum.trunk.lokerkeydata',compact('pacustdata','locarkeydata'));
    }
      
    function setbfunction(Request $request){
        $user_id=Auth::user()->id;
        $table="merchant";
        $requestdata = (object) $request->all();
        $update_data=[
                "bfunction"=>$requestdata->ftype,
                "updated_at"=>Carbon::now()
            ];
            $data=DB::table($table)
            ->update($update_data);
        return  $requestdata->ftype;
    }

    function getbfunction(){
        $bdata = DB::table('merchant')
                    ->select('bfunction')
                     ->orderby('id','desc')
                    ->first();
        return $bdata->bfunction;
    }

    function digitalclock(){
        echo date('D dMy H:i:s');
    }

    //-----------------------------------------
    // Created by Zurez
    //-----------------------------------------
    
    public function do_stockreport(Request $r,$uid=NULL)
    {
        $ret=array();
        $ret["status"]="failure";
        if(!Auth::check()){return "";}
        $user_id=Auth::user()->id;
        if(!empty($uid) and Auth::user()->hasRole("adm")){
            $user_id=$uid;
        }
        try{
            /*Create a stockreport*/
            $ttype=$r->ttype;
            if (empty($ttype) or !in_array($ttype,["tin","tout"])) {
                $ret["short_message"]="Incorrect ttype";
                return response()->json($ret);
            }
            $products=$r->products;
            if (empty($products)) {
                # code...
                $ret["short_message"]="No product specified";
                return response()->json($ret);
            }
            $action="minus";
            if ($ttype=="tin") {
                $action="add";
            }
            $terminal_id=$r->terminal_id;
            $location_id=DB::table("opos_locationterminal")
            ->where("terminal_id",$terminal_id)
            ->whereNull("deleted_at")
            ->orderBy("id","DESC")
            ->pluck("location_id");
            if (empty($location_id)) {
                $ret["short_message"]="No location found for the terminal";
                return response()->json($ret);
            }
            $company_id=DB::table("fairlocation")
            ->where("fairlocation.id",$location_id)
            ->join("company","company.owner_user_id","=","fairlocation.user_id")
            ->whereNull("company.deleted_at")
            ->whereNull("fairlocation.deleted_at")
            ->pluck("company.id");

            if (empty($company_id)) {
                # code...
                $ret["short_message"]="No company found for the terminal";
                return response()->json($ret);
            }
            $method=$r->method;

            $table="stockreport";
            $insert_data=[
            "created_at"=>Carbon::now(),
            "updated_at"=>Carbon::now(),
            "creator_user_id"=>$user_id,
            "checker_user_id"=>$user_id,
            "checker_company_id"=>$company_id,
            "creator_company_id"=>$company_id,
            "checker_location_id"=>$location_id,
            "creator_location_id"=>$location_id,
            "ttype"=>$ttype,
            "method"=>$method,
            "status"=>"confirmed"
            ];
            $stockreport_id=DB::table($table)
            ->insertGetId($insert_data);
            foreach ($products as $product) {
                $quantity=$product['quantity'];
                $product_id=$product['product_id'];
                if ($quantity<1 or $product_id<1) {
                    Log::debug("Incorrect quantity or product_id");
                }else{

                    UtilityController::locationproduct($location_id,$product_id,$quantity,$action);
                    $insert_data=[
                    "created_at"=>Carbon::now(),
                    "updated_at"=>Carbon::now(),
                    "stockreport_id"=>$stockreport_id,
                    "product_id"=>$product_id,
                    "quantity"=>$quantity,
                    "received"=>$quantity,
                    "status"=>"checked",
                    ];
                    DB::table("stockreportproduct")->insert($insert_data);
                }
                
            }
            
        
            
            $ret["status"]="success";

            $ret["short_message"]="SISO created successfully";
        }
        catch(\Exception $e){
            $ret["short_message"]=$e->getMessage();
            Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
        }
        return response()->json($ret);
    }
    
}
