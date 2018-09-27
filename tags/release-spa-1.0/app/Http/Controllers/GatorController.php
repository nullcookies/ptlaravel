<?php

namespace App\Http\Controllers;

use App\Models\DeliveryOrder;
use App\Models\MerchantEmerchant;
use App\Models\NdoID;
use App\Models\Receipt;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Station;
use App\Models\OrderProduct;
use App\Models\SOrder;
use App\Models\Sorderproduct;
use App\Models\POrder;
use Illuminate\Support\Facades\Session;
use App\Models\Merchant;
use App\Models\Currency;
use App\Models\Emerchant;
use App\Models\User;
use App\Models\wholesale;
use App\Models\Autolink;
use App\NPorderid;
use Mail;

use DB;
use Auth;

class GatorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($uid=null)
    {
        if (!Auth::check()) {
            # code...
            return view("common.generic")
            ->with("message_type","error")
            ->with("message","Please login to access this page.")
            ;
        }
        $user_id=Auth::user()->id;
        if (!empty($uid) and Auth::user()->hasRole("adm")) {
            # code...
            $user_id=$uid;
        }
       
        $selluser = User::find($user_id);

    
        $merchant = Merchant::where('user_id','=',$user_id)->first();
        $merchant_id=$merchant->id;
    /*    $products = DB::table("product")
        
        ->join('merchantproduct as mp','mp.product_id','=','product.id')
        ->leftJoin('wholesale','wholesale.product_id','=','product.id')

        ->whereNull('mp.deleted_at')
        ->where("mp.merchant_id",$merchant->id)
        ->join('nproductid','nproductid.product_id','=','product.id')
        ->where('product.status','!=','transferred')
        // ->where('wholesale.funit','=',1)
        ->whereNull('product.deleted_at')->orderBy('product.created_at','DESC') ->get([
            'product.id as id',
            'product.parent_id as tprid',
            'product.id as prid',
            'product.segment as segment',
            'product.name as name',
            'product.thumb_photo as thumb_photo',
            'product.parent_id as parent_id',
            'wholesale.price as retail_price',
            'wholesale.product_id as product_id',
            'nproductid.nproduct_id as nproductid',
            'product.consignment as consignment_total'
        ]);*/
        $query="
            SELECT
            DISTINCT 
            pp.parent_id as tprid,
            product.id as id,
            product.id as prid,
            product.segment as segment,
            product.name as name,
            product.thumb_photo as thumb_photo,
            product.parent_id as parent_id,
            product.private_available as offlineProd,
            product.private_retail_price as offlinePrice,
            
            wholesale.price as retail_price,
            wholesale.id as wid,
           
            product.id as product_id,
            np.nproduct_id as nproductid

            FROM 
            product 
            join product parent on parent.id=product.parent_id
            join merchantproduct mp on mp.product_id=product.parent_id
            join nproductid np on np.product_id=product.id
            inner join (
                select parent_id ,MAX(created_at) as created_at
                from 
                product
                group by parent_id
            ) pp on pp.parent_id=product.parent_id AND pp.created_at=product.created_at
            left join wholesale on wholesale.product_id=product.id

            WHERE
            mp.merchant_id=$merchant_id
            AND product.status != 'transferred'
            AND product.status != 'deleted'
            AND product.status !=''
            AND product.deleted_at IS NULL
            AND parent.status != 'transferred'
            AND parent.status != 'deleted'
            AND parent.status !=''
            AND parent.deleted_at IS NULL
            
            GROUP BY tprid
            ORDER BY offlinePrice DESC
         
           

        ";
        
        $products=DB::select(DB::raw($query));
        
       /* dd($products);*/
        $index=0;
     
        foreach($products as $prods){

            /* Consignment */ 

            $pr=new ProductController;
            $offline=$pr->consignment($prods->tprid,$user_id);
            $prods->consignment_total=$offline;
            
        }

  /*      dd($products);*/
        $currency = Currency::where('active','=',1)->first();
        //$emerchant =  Emerchant::select('business_reg_no','company_name as first_name')->get();

         $wholesaleprices = Product::join('wholesale','wholesale.product_id','=','product.id')
        ->join('merchantproduct','product.parent_id','=','merchantproduct.product_id')
        ->where('merchantproduct.merchant_id','=',$merchant->id)
        ->orderBy('wholesale.price','desc')
        ->get([
            'wholesale.funit',
            'wholesale.unit',
            'wholesale.price',
            'wholesale.product_id as id',
        ]);

        if(!is_null($merchant)){
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
                /*->where('product.id',2699)*/
            // ->whereNull('bc_management.deleted_at')
            ->groupBy('product.id')

            //->limit(2) //danger Danger , to be commented in production
            ->where("product.status","!=","transferred")
            ->where("product.status","!=","deleted")
            ->where("product.status","!=","")
            
            ->orderBy('product.created_at','DESC')
            ->get();

            /* Use $merchant_pro to find out which product also has a record
             * in tproduct, related via:
             * $merchant_pro->id = $tproduct->parent_id */
             /*
            foreach($merchant_pro as $prod){
            }
            */

            foreach($merchant_pro as $prods){
              /*   $stockreport = DB::table('stockreport')->select('stockreport.*')->
                    join('stockreportproduct','stockreport.id','=',
                        'stockreportproduct.stockreport_id')->
                    where('stockreportproduct.product_id',$prods->id)->
                    where('stockreport.status','confirmed')->
                    orderBy('stockreport.checked_on', 'DESC')->
                    first();

                 if(!is_null($stockreport)){
                    $sttime = strtotime($stockreport->checked_on);
                    if($sttime == 0){
                       $prods->last_updated = null;
                   } else {
                       $prods->last_updated = $stockreport->checked_on;
                   }
                 } else {
                   $prods->last_updated = null;
                 }
*/
    
                $pr=new ProductController;
                $prods->consignment_total=$pr->consignment($prods->id,$user_id);
             /*   dump($prods->consignemt);*/
            }
          /*  exit();*/
            // dump($merchant_pro);
            $merchant_prot = DB::table('product')
            ->join('merchantproduct','merchantproduct.product_id','=','product.id')
            ->join('twholesale','twholesale.tproduct_id','=','product.id')
            ->leftJoin('product as tproduct','product.id','=','product.id')
            ->leftJoin('product as parent','product.parent_id','=','parent.id')
            ->where('product.status', '=', 'active')
            ->whereNull('product.id')
            ->where('merchantproduct.merchant_id',$merchant_id)
            ->select('product.*')
            ->distinct()
            ->get();
        }      
        
        return view('seller.gator.gator',compact('selluser','products','stations','currency','wholesaleprices','user_id','merchant_pro'));
    }


    public function gatorBuyer($source=null,$user_id=null)
    {
         if ($user_id==null) {
            $user_id = Auth::user()->id;
        }
       
        $merchant = Merchant::where('user_id','=',$user_id)->first();
        $stations = DB::select("
           select
           m.id as 'merchant_id',
           m.company_name,
           concat(u.first_name,' ',u.last_name) as name,
           u.email,
           a.initiator,
           a.status,
           m.business_reg_no,
           n.nseller_id,
           m.created_at
           from
           autolink a,
           merchant m,
           nsellerid n,
           users u
           where
           a.initiator=u.id and
           m.user_id=a.initiator and
           a.status='linked' and
           n.user_id=m.user_id and
           a.responder=$merchant->id
           UNION select
           m.id as 'merchant_id',
           m.company_name,
           concat(u1.first_name,' ',u1.last_name) as name,
           u1.email,
           a.responder,
           a.status,
            m.business_reg_no,
           n.nseller_id,
           a.created_at
           from
           autolink a,
           merchant m,
           nsellerid n,
           users u,
           users u1
           where
           a.initiator=$user_id and
           u.id=a.initiator and
           a.responder=m.id and
           u1.id=m.user_id and
            n.user_id=m.user_id and 
           a.status='linked'
           UNION SELECT 
           g.id as 'merchant_id',
           g.company_name,
           concat(g.first_name,' ',g.last_name) as name,
           g.email,
           g.id,
           g.company_name,
           g.business_reg_no,
           (null),
           g.created_at
           FROM 
           emerchant g,
           merchantemerchant m
           WHERE 
           m.merchant_id=$merchant->id AND 
           g.id=m.emerchant_id
           ORDER BY created_at DESC 
           "
       );

        return view('seller.gator.gator-buyer',compact('stations','user_id'))->
			with('source',$source);
    }


    public function displaySaleOrder($id)
    {
       // return $id
        $merchantaddress = POrder::join('orderproduct','orderproduct.porder_id','=','porder.id')
        ->join('merchantproduct','merchantproduct.product_id','=','orderproduct.product_id')
        ->join('merchant','merchantproduct.merchant_id','=','merchant.id')
        ->join('address','merchant.address_id','=','address.id')
        ->join('nbuyerid','nbuyerid.user_id','=','merchant.user_id')
        ->join('users','merchant.user_id','=','users.id')
        ->where('porder.id','=',$id)
        ->get([
            'merchant.company_name',
            'merchant.gst',
            'merchant.business_reg_no',
            'address.line1',
            'address.line2',
            'address.line3',
            'address.line4',
            'users.first_name',
            'users.last_name',
            'nbuyerid.nbuyer_id as user_id',
            'porder.created_at',
            'porder.salesorder_no'
        ]);
        $emerchant = POrder::where('porder.id','=',$id)
        ->pluck('is_emerchant');
        if ($emerchant==1) 
        {
            $buyeraddress = POrder::join('emerchant','porder.user_id','=','emerchant.id')
            ->get([
                'emerchant.company_name',
                'emerchant.business_reg_no', 
                'emerchant.address_line1 as line1',
                'emerchant.address_line2 as line2',
                'emerchant.address_line3 as line3',
            ]);
        }
        else
        {
            $buyeraddress = POrder::join('station','station.user_id','=','porder.user_id')
            ->join('address','station.address_id','=','address.id')
            ->where('porder.id','=',$id)
            ->get([
                'station.company_name',
                'station.business_reg_no', 
                'address.line1',
                'address.line2',
                'address.line3',
                'address.line4',
            ]);
        }
                   // return $buyeraddress;
        $invoice    =   POrder::join('orderproduct','orderproduct.porder_id','=','porder.id')
        ->join('nproductid','nproductid.product_id','=','orderproduct.product_id')
        ->join('product','orderproduct.product_id','=','product.id')
        ->where('porder.id','=',$id)
        ->get([
            'nproductid.nproduct_id',
            'product.description',
            'orderproduct.quantity',
            'orderproduct.order_price',

        ]);
        $currency = Currency::where('active','=',1)->pluck('code');
        $nporder_id = NPorderid::where('porder_id','=',$id)->pluck('nporder_id');
       /* $html =  view('seller.gator.salesorderdocument',compact('selluser'))->with('merchantaddress',$merchantaddress)->with('buyeraddress',$buyeraddress)->with('invoice',$invoice)->with('currency',$currency)->with('nporder_id',$nporder_id)->render();*/

       /* Mail::send($html, ['emailBody'=>'<h1>sale order</h1>'], function($message)
        {
           $message->to($buyeraddress->email)->subject('Sales Order');
       });*/
       
        return view('seller.gator.saleorder')->with('merchantaddress',$merchantaddress)->with('buyeraddress',$buyeraddress)->with('invoice',$invoice)->with('currency',$currency)->with('nporder_id',$nporder_id);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function productdetail($id)
    {
        $product= Product::find($id);

        $returnproductTable = view('seller.gator.gator-product-ajax',compact('product',$product))->render();

        return $returnproductTable;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
    {
        if ($request->user_id==null) {
           $user_id = Auth::user()->id;
        }
        else{
            $user_id= $request->user_id;
        }
        if ($request->isbuyer=="") {
            return 0;
        }
        $productsrequest =   $request->product;
        $productsrequest = array_filter($productsrequest,function($value){
            return $value>0;
        });
        $counproduct =  array_sum($productsrequest);

       // $salesorder_no = POrder::where('user_id','=',)

        $order = new POrder;
        if ($counproduct>0) {

            if ($request->isbuyer==0) {
                $merchant = $request->setbuyer;
                $merchant_user_id = Merchant::where('id','=',$merchant)->pluck('user_id');
            }
            else
            {
                $merchant_user_id = $request->setbuyer;
                $order->is_emerchant = 1;
            }

            $s_no = Merchant::where('user_id',$user_id)->max('salesorder_no');
            $order->salesorder_no = $s_no+1;
            Merchant::where('user_id',$user_id)->update([
                'salesorder_no'=> $s_no+1
            ]);


            $order->user_id = (int) $merchant_user_id;
            $order->logistic_id = NULL;
            $order->courier_id    = 0;
            $order->payment_id    = 0;
            $order->order_administration_fee    = NULL;
            $order->osmall_comm_percent    = 0;
            $order->smm_comm_percent    = 0;
            $order->log_comm_percent    = 0;
            $order->description    = NULL;
            $order->source    = "b2b";
            $order->status    = "completed";
            $order->delivery_mode    = "own";
            $order->cre_count    = 0;
            $order->mode    = "gator";
            $order->prev_m_approved    = "b-returning";
            $order->prev_completed    = "b-approved";

            if ($order->save()) {
                foreach ($productsrequest as $key => $value) {
                    /*$retailprice = product::join('product','product.id','=','product.product_id')
                        ->where('product.id','=',$key)
                        ->pluck('retail_price');*/
					$wholesaleprice  =  wholesale::where('product_id','=',$key)
                        ->where('unit','>=',$value)
                        ->where('funit','<=',$value)
                        ->pluck('price');
                        $Orderproduct                          = new OrderProduct;
                        $Orderproduct->porder_id               = $order->id;
                        $Orderproduct->product_id             = $key;
                        $Orderproduct->order_price             = $wholesaleprice;
                        $Orderproduct->order_delivery_price    = 0;
                        $Orderproduct->payment_gateway_fee     = 0;
                        $Orderproduct->quantity                = $value;
                        $Orderproduct->actual_delivery_price   = 0;
                        $Orderproduct->shipping_cost           = 0;
                        $Orderproduct->crereason_id            = 0;

                        $Orderproduct->save();



                    }

                    $receipt = Receipt::create([
                        'porder_id'=> $order->id,
                        'receipt_no'=> Receipt::max('receipt_no') +1
                    ]);

                $new_do =  DeliveryOrder::create([
                        'receipt_id'=> $receipt->id,
                        'status'=>'pending',
                        'source'=>'gator',
                        'merchant_id'=>  Merchant::where('user_id','=',$user_id)->pluck('id')

                    ]);

                NdoID::create([
                    'ndeliveryorder_id'=>  UtilityController::generaluniqueid( $new_do->id, '3', '1',  $new_do->created_at, 'ndeliveryorderid', 'ndeliveryorder_id'),
                    'deliveryorder_id'=> $new_do->id
                ]);

                }
            }


            $newpoid = UtilityController::generaluniqueid($order->id,
                '1','1', $order->created_at, 'nporderid', 'nporder_id');

            DB::table('nporderid')->insert(['nporder_id'=>$newpoid,
                'porder_id'=>$order->id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')]);


            return $order->id;
        }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        //return    $request->all();

        if ($request->isbuyer=="") {
            return 0;
        }
        $productsrequest =   $request->product;
        $productsrequest = array_filter($productsrequest,function($value){
            return $value>0;
        });
        if (!count($productsrequest)) {
            return "1";
        }
        $productsrequest = array_filter($productsrequest,function($value){
            return $value>0;
        });
        $counproduct =  array_sum($productsrequest);

        foreach ($productsrequest as $key => $value) {


            $confirmproduct = Product::where('product.id','=',$key)->get(['product.name']);
            $wholesaleprice  =  wholesale::where('product_id','=',$key)
            ->where('unit','>=',$value)
            ->where('funit','<=',$value)
            ->pluck('price');

            $product[$key]['name']      =   $confirmproduct[0]->name;
            $product[$key]['quantity']  =   $value;
            $product[$key]['id']        =   $key;
            $product[$key]['price']     =   $wholesaleprice;
            $product[$key]['total']     =   $wholesaleprice*$value;






        }

        return view('seller.gator.confirm-ajax',compact('product'))->render();
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function savebuyer(Request $request)
    {
        $emerchant = new emerchant();
        $emerchant->company_name       =  $request->company_name;
        $emerchant->business_reg_no    =  $request->br;
        $emerchant->gst_reg_no         =  $request->gst;
        $emerchant->address_line1      =  $request->address1;
        $emerchant->address_line2      =  $request->address2;
        $emerchant->address_line3      =  $request->address3;
        $emerchant->country_id         =  $request->country;
        $emerchant->state              =  $request->state;
        $emerchant->city               =  $request->city;
        $emerchant->postcode           =  $request->postcode;
        $emerchant->first_name         =  $request->fname;
        $emerchant->last_name          =  $request->lname;
        $emerchant->designation        =  $request->designation;
        $emerchant->mobile_no          =  $request->mobile;
        $emerchant->email              =  $request->email;
        $emerchant->save();
        $user_id = Auth::user()->id;
        MerchantEmerchant::create([
            'merchant_id'   => Merchant::where('user_id','=',$user_id)->pluck('id'),
            'emerchant_id'     => $emerchant->id
        ]);
        return $emerchant = Emerchant::find($emerchant->id);
    }

    public function testview()
    {
        $currency = Currency::where('active','=',1)->first();

        return view('viewtest',compact('currency'));
    }


    public function displaysalesorderdocument($id,$nid = null,$heading =null)
    {
//        dd($id,$nid,$heading);

       // return $id
        $merchantaddress = POrder::join('orderproduct','orderproduct.porder_id','=','porder.id')
        ->join('merchantproduct','merchantproduct.product_id','=','orderproduct.product_id')
        ->join('merchant','merchantproduct.merchant_id','=','merchant.id')
        ->join('address','merchant.address_id','=','address.id')
        ->join('nbuyerid','nbuyerid.user_id','=','merchant.user_id')
        ->join('users','merchant.user_id','=','users.id')
        ->where('porder.id','=',$id)
        ->get([
            'merchant.company_name',
            'merchant.gst',
            'merchant.business_reg_no',
            'address.line1',
            'address.line2',
            'address.line3',
            'address.line4',
            'users.first_name',
            'users.last_name',
            'nbuyerid.nbuyer_id as user_id',
            'porder.created_at',
            'porder.salesorder_no'
        ]);
        $emerchant = POrder::where('porder.id','=',$id)
        ->pluck('is_emerchant');

        if ($emerchant==1) {
            $buyeraddress = POrder::join('emerchant','porder.user_id','=','emerchant.id')
            ->get([
                'emerchant.company_name',
                'emerchant.email',
                'emerchant.business_reg_no', 
                'emerchant.address_line1 as line1',
                'emerchant.address_line2 as line2',
                'emerchant.address_line3 as line3',
            ]);

        } else {
            $buyeraddress = POrder::join('station','station.user_id','=','porder.user_id')
            ->join('address','station.address_id','=','address.id')
            ->join('users','users.id','=','station.user_id')
            ->where('porder.id','=',$id)
            ->get([
                'station.company_name',
                'station.business_reg_no', 
                'users.email', 
                'address.line1',
                'address.line2',
                'address.line3',
                'address.line4',
            ]);
        }
                   // return $buyeraddress;
        $invoice    =   POrder::join('orderproduct','orderproduct.porder_id','=','porder.id')
        ->join('nproductid','nproductid.product_id','=','orderproduct.product_id')
        ->join('product','orderproduct.product_id','=','product.id')
        ->where('porder.id','=',$id)
        ->get([
            'nproductid.nproduct_id',
            'product.description',
            'orderproduct.quantity',
            'orderproduct.order_price',

        ]);
        $currency = Currency::where('active','=',1)->pluck('code');
        $selluser = User::find(Auth::user()->id);
        $nporder_id = NPorderid::where('porder_id','=',$id)->
			pluck('nporder_id');

        return view('seller.gator.salesorderdocument',
			compact('selluser','nid','heading'))->
			with('merchantaddress',$merchantaddress)->
			with('buyeraddress',$buyeraddress)->
			with('invoice',$invoice)->
			with('currency',$currency)->
			with('nporder_id',$nporder_id);
    }

    public function deletegatorbuyer($id)
    {
        $emerchant = Emerchant::find($id);
        $emerchant->delete();
        return  $this->gatorBuyer();
    }

    public function unlinkgatorbuyer($id,$user_id=null)
    {
         if ($user_id==null) {
            $user_id = Auth::user()->id;
        }
        
        $merchant = Merchant::find($id);
        $merchantid = Merchant::where('user_id','=',$user_id)->pluck('id');
        $autolink = Autolink::where('initiator','=',$merchant->user_id)
        ->where('responder','=',$merchantid)->first();
		if (isset($autolink)) {
           $autolink->status='requested';
           $autolink->save();
		} else {
           $autolink = Autolink::where('initiator','=',$user_id)
           ->where('responder','=',$id)->first();
           $autolink->status='requested';
           $autolink->save();
       }
       return  $this->gatorBuyer();
   }

   public function emerchantdetail($id)
   {
        $emerchant = Emerchant::find($id);
        $emerchantdetails = view('seller.gator.emerchantdetail',
			compact('emerchant'))->render();
        return $emerchantdetails;
   }
}
