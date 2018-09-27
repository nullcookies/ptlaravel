<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Company;
use App\Models\DeliveryOrder;
use App\Models\DeliveryOrderStockReport;
use App\Models\DeliveryOrdertProduct;
use App\Models\Employee;
use App\Models\Fairlocation;
use App\Models\LocationProduct;
use App\Models\Member;
use App\Models\Merchant;
use App\Models\NdoID;
use App\Models\Product;
use App\Models\Receipt;
use App\Models\Role;
use App\Models\Stockreport;
use App\Models\Stockreportproduct;
use App\Models\Tproduct;
use App\Models\User;
use App\Models\POrder;
use Carbon\Carbon;
use function Clue\StreamFilter\fun;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Excel;
use DB;
use Session;
use Log;
use Auth;

class DoManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($user_id=null)
    {
        if (!Auth::check()) {
            return view("common.generic")
            ->with("message_type","error")
            ->with("message","Please login to access this view")
            ;
        }
        if ($user_id==null) {
            $user_id = Auth::user()->id;
        }
        $selluser = User::find($user_id);
        $cporders = POrder::join('ordertproduct','ordertproduct.porder_id','=','porder.id')
        ->where('mode','=','gator')
        ->get([
            'porder.id',
            'ordertproduct.porder_id',
            'ordertproduct.quantity',
            'ordertproduct.order_price',
        ])
        ->groupBy('id');
        

        $merchant_id = Merchant::where('user_id',$user_id)->pluck('id');
        $check_tr =  DeliveryOrder::join('deliveryorderstockreport','deliveryorderstockreport.deliveryorder_id','=','deliveryorder.id')
        ->join('stockreport','stockreport.id','=','deliveryorderstockreport.stockreport_id')
        
        ->where('deliveryorder.merchant_id','=',$merchant_id)
        ->where('deliveryorder.status','!=','confirmed')
                // ->where('deliveryorder.final_location_id','=','stockreport.checker_location_id')
        ->get([
            'deliveryorder.id as id',
            'deliveryorder.status',
            'deliveryorder.final_location_id',
            'stockreport.checker_location_id'
        ]);
        
        foreach ($check_tr as $tr) {
            
            if ($tr->final_location_id == $tr->checker_location_id ) {
                $id[]=$tr->id;
            }


        }
        if (isset($id)) {
         DeliveryOrder::whereIn('id',$id)->update([
            'status'=>'confirmed'
        ]);
     }

     $delivery_orders = DeliveryOrder::where('merchant_id',$merchant_id)->whereIn('deliveryorder.source',['gator','jaguar','imported'])
     ->join('ndeliveryorderid','deliveryorder.id','=','ndeliveryorderid.deliveryorder_id')
     ->leftjoin('receipt','receipt.id','=','deliveryorder.receipt_id')
     ->leftjoin('porder','receipt.porder_id','=','porder.id')

     ->leftjoin('fairlocation','fairlocation.id','=','deliveryorder.final_location_id')
     ->leftjoin("deliveryorderstockreport","deliveryorderstockreport.deliveryorder_id","=","deliveryorder.id")
     ->leftjoin("stockreport","stockreport.id","=","deliveryorderstockreport.stockreport_id")
     ->leftjoin('member', function ($join) {
        $join->on('deliveryorder.member_id','=','member.id')
        ->where('member.status','=','active');
    })->leftjoin('users as dlv', function ($join) {
        $join->on('dlv.id','=','member.user_id');
    })
    ->orderby('deliveryorder.created_at','desc')
    ->get([
        DB::raw('deliveryorder.*'),
        'ndeliveryorderid.ndeliveryorder_id as ndid',
        'deliveryorder.id as do_id',
        'member.name as delivery_man_name',
        'member.email as delivery_man_email',
        'dlv.username as delivery_username',
        'dlv.first_name as delivery_firstname',
        'dlv.last_name as delivery_lastname',
        'fairlocation.location as f_location',
        'stockreport.status as stockreport_status',
        'porder.id as porder_id'

    ]);

    $company_id = Company::where('owner_user_id',$user_id)->pluck('id');

    $delivery_men =    DB::select("select m.id,
        m.user_id,
        m.email,
        r.name,
        u.username,
        u.first_name,
        u.last_name from member m,
        role_users ru,
        users u, 
        roles r
        where ru.user_id=u.id 
        and ru.role_id=r.id 
        and m.user_id=u.id 
        and m.company_id=$company_id 
        and m.type='member' 
        and r.slug='dlv'");


    $dils = $all_locations = Fairlocation::where('user_id','=',$user_id)->get();

    return view('seller.logistics.logistics',
        compact('delivery_orders',
            'delivery_men',
            'selluser',
            'cporders',
            'dils',
            'user_id'));
}

public function issueDo(Request $request)
{
//        return $request->all();

    $delivery_order             =  DeliveryOrder::find($request->issue_do_id);
    $delivery_order->status     = 'inprogress';
    $delivery_order->action     = 'issue';
    $delivery_order->member_id  = $request->member_id;

    if ($delivery_order->save()) {
        Session::flash('success','Delivery Order has been issued');
        return redirect()->back();
    } else {
        Session::flash('error_message','Delivery Order can not be Issued');
        return redirect()->back();
    }
}

public function trDo(Request $request)
{
//return $request->all();
     if ($request->user_id==null) {
            $user_id = Auth::user()->id;
        }
        else{
            $user_id = $request->user_id;
        }

    $stock_report_check = DeliveryOrderStockReport::where('deliveryorder_id',$request->tr_do_id)->where('deleted_at','=',null)->first();

    if ($stock_report_check) {
        Session::flash('error_message','Delivery Order has alredy been Converted TR');
        return redirect()->back();
    }

    $delivery_order                         =  DeliveryOrder::find($request->tr_do_id);
    $delivery_order->status                 = 'converted_tr';
    $delivery_order->action                 = 'tr';
    $delivery_order->initial_location_id    = $request->initial_location_id;
    $delivery_order->member_id              = $request->member_id;

    $creator_company_id = Company::where('owner_user_id',$user_id)->pluck('id');

    $stock_report = new Stockreport();

    $stock_report->creator_user_id      = Member::find($request->member_id)->user_id;
    $stock_report->creator_location_id  = $request->initial_location_id;
    $stock_report->creator_company_id   = $creator_company_id;
    $stock_report->status               = 'pending';
    $stock_report->ttype                = 'treport';
    $stock_report->report_no            =  Stockreport::where('creator_company_id',$creator_company_id)->max('report_no') + 1;

    if ($stock_report->save()) {
        if ($delivery_order->save()) {
            $delivery_order_stock_report = new DeliveryOrderStockReport();
            $delivery_order_stock_report->deliveryorder_id  = $delivery_order->id;
            $delivery_order_stock_report->stockreport_id    = $stock_report->id;
            $delivery_order_stock_report->save();


            $products =  DeliveryOrdertProduct::where('do_id',$request->tr_do_id)->get();

            foreach ($products as $product) {

                $stock_report_product = new Stockreportproduct();
                $stock_report_product->product_id = $product->tproduct_id;
                $stock_report_product->quantity = $product->quantity;
                $stock_report_product->stockreport_id = $stock_report->id;
                $stock_report_product->save();
            }

            Session::flash('success','Delivery Order has Converted TR');
            return redirect()->back();
        }
    }
}

public function discardDo(Request $request)
{
    $delivery_order         = DeliveryOrder::find($request->discard_do_id);
    $delivery_order->status = 'discarded';
    $delivery_order->action = 'discard';
    if ($delivery_order->save()) {
        Session::flash('success','Delivery Order has been Dicarded');
        return redirect()->back();
    } else {
        Session::flash('error_message','Delivery Order can not be Dicarded');
        return redirect()->back();
    }

}



public function importDo(Request $request)
{
     if ($request->user_id==null) {
            $user_id = Auth::user()->id;
        }
        else{
            $user_id = $request->user_id;
        }
    if($request->hasFile('file')) {
        $path = $request->file('file')->getRealPath();
        $data = Excel::load($path, function ($reader) {
        })->get();

        if (!empty($data) && $data->count()) {
            foreach ($data->toArray() as $key => $value) {
                if (!empty($value['item_code']) &&
					!empty($value['branch_code'])) {
                    $raw_data['branch_code'] = $value['branch_code'];
                    $raw_data['products'][$key]['sku'] = $value['item_code'];
                    $raw_data['products'][$key]['qty'] = $value['qty'];
                }
            }

			Log::debug($data);

            $merchant_id = Merchant::where('user_id',
				$user_id)->pluck('id');

			//getting location id of the branch
            $location_id = Branch::where('code',
				$raw_data['branch_code'])->
				first()['location_id'];

             /*   if ($location_id == null) {
                    $location = 
                }*/


			if ($location_id) {
				foreach ($raw_data['products'] as $sheet_pro) {
					$check_pro =   DB::select("select tp.id,p.id,p.sku,p.name 
					from product p, tproduct tp, locationproduct lp 
					where p.sku='$sheet_pro[sku]'
					and tp.parent_id=p.id and lp.product_id=p.id
					and lp.location_id='$location_id'
					and lp.quantity >= '$sheet_pro[qty]' ");

					if (!count($check_pro)>0) {

						$errors_msj = "Warning: Product ". $sheet_pro['sku']. " not found in inventory";
						Session::flash('error_message',$errors_msj);
						return redirect()->back();
					}

				}

				foreach ($raw_data['products'] as $pro) {
					$import_sku[] = $pro['sku']; // filter out sku
				}
				foreach ($raw_data['products'] as $r_d) {
					$imported_products_qty[$r_d['sku']] = $r_d['qty'];
				}
				$imported_products_id =  Product::whereIn('sku',$import_sku)->lists('id','sku');

				$new_do =   DeliveryOrder::create([
					'status'=>'pending',
					'source'=>'imported',
					'merchant_id'=>$merchant_id,
					'final_location_id'=>$location_id
				]);

				NdoID::create([
				    'ndeliveryorder_id'=>  UtilityController::generaluniqueid( $new_do->id, '3', '1',  $new_do->created_at, 'ndeliveryorderid', 'ndeliveryorder_id'),
                    'deliveryorder_id'=> $new_do->id
                ]);

				foreach ($import_sku as $i_sku) {
					try {
						DeliveryOrdertProduct::create([
							'do_id'=> $new_do->id,
							'status' => 'pending',
							'tproduct_id' =>   $imported_products_id[$i_sku],
							'quantity' =>     $imported_products_qty[$i_sku],
						]);


					} catch (\Exception $exception) {

						$exc[] = $exception->getMessage();
					}
				}


				Session::flash('success','Succesfully Imported DO');
				return redirect()->back();
			} else {
				$errors[] = 'No Branch Registered against branch code: '. $raw_data['branch_code'];
			}

		} else {
			$errors[] = 'No Data in File';
		}
	}

	if (isset($errors)) {
		if (count($errors)>0) {
//                return $errors;
			Session::flash('error_message',$errors[0]);
			return redirect()->back();
		}
	}
}


    public function exportDo(Request $request)
    {
        if ($request->user_id==null) {
            $user_id = Auth::user()->id;
        }
        else{
            $user_id = $request->user_id;
        }
        $merchant_id = Merchant::where('user_id',$user_id)->pluck('id');

        $for_export =  DeliveryOrder::where('merchant_id',$merchant_id)
        ->whereBetween('deliveryorder.created_at',
			[Carbon::parse($request->from)->startOfDay(),
				Carbon::parse($request->to)->endOfDay()])
        ->whereIn('deliveryorder.source',['gator','jaguar'])
        ->whereNull ('deliveryorder.deleted_at')
        ->join('merchant','merchant.id','=','deliveryorder.merchant_id')
        ->join('receipt','deliveryorder.receipt_id','=','receipt.id')
        ->join('porder','receipt.porder_id','=','porder.id')
        ->join('ordertproduct','porder.id','=','ordertproduct.porder_id')
        ->join('tproduct','ordertproduct.tproduct_id','=','tproduct.id')
		->join('product','product.id','=','tproduct.product_id')
		->join('station','station.user_id','=','porder.user_id')
        ->join('address as station_address','station.address_id','=','station_address.id')
        ->join('address','address.id','=','merchant.address_id')
        ->get( [
            'deliveryorder.created_at as do_date',
            'merchant.company_name as seller_compnay',
            'merchant.business_reg_no as seller_compnay_no',
            'address.line1 as seller_address_1',
            'address.line2 as seller_address_2',
            'address.line3 as seller_address_3',
            'address.postcode as seller_postcode',
            'merchant.gst as seller_gst_no',
            'station.company_name as buyer_company',
            'station.business_reg_no as buyer_company_no',
            'station_address.line1 as buyer_address_1',
            'station_address.line2 as buyer_address_2',
            'station_address.line3 as buyer_address_3',
            'station_address.postcode as buyer_postcode',
            'station.gst as buyer_gst_no',
            'porder.id as order_id',
            'receipt.receipt_no as tax_invoice_no',
            'tproduct.product_id as product_id',
            'product.name as product_name',
            'ordertproduct.quantity as qty',
            'ordertproduct.order_price as unit_price',
            DB::raw('(ordertproduct.quantity * ordertproduct.order_price) as amount')
        ])->toArray();



//
//
//     $import_data = DeliveryOrder::where('merchant_id',$merchant_id)->where('source','imported')
//         ->whereBetween('deliveryorder.created_at',[Carbon::parse($request->from)->startOfDay(),Carbon::parse($request->to)->endOfDay()])
//         ->where('deliveryorder.source','imported')
//         ->whereNull ('deliveryorder.deleted_at')
//         ->join('deliveryordertproduct','deliveryorder.id','=','deliveryordertproduct.do_id')
//         ->join('tproduct','deliveryordertproduct.tproduct_id','=','tproduct.id')
//         ->join('product','tproduct.product_id','=','product.id')
//         ->join('merchant','merchant.id','=','deliveryorder.merchant_id')
//         ->join('address','address.id','=','merchant.address_id')
//            ->get([
//                'merchant.company_name as seller_compnay',
//                'merchant.business_reg_no as seller_compnay_no',
//                'address.line1 as seller_address_1',
//                'address.line2 as seller_address_2',
//                'address.line3 as seller_address_3',
//                'address.postcode as seller_postcode',
//                'merchant.gst as seller_gst_no',
//                'tproduct.product_id as product_id',
//                'product.name as product_name',
//                'deliveryordertproduct.quantity as qty',
//            ])->toArray();
//
//



        $data =   array_map(function ($arr) {
            $set_array['do_date']              = ((isset($arr['do_date'])))         ?date('dMy  H:i:s', strtotime($arr['do_date']))     :"";
            $set_array['seller_compnay']    = ((isset($arr['seller_compnay'])))     ?$arr['seller_compnay']     :"";
            $set_array['seller_compnay_no'] = ((isset($arr['seller_compnay_no'])))  ?$arr['seller_compnay_no']  :"";
            $set_array['seller_address_1']  = ((isset($arr['seller_address_1'])))   ?$arr['seller_address_1']   :"";
            $set_array['seller_address_2']  = ((isset($arr['seller_address_2'])))   ?$arr['seller_address_2']   :"";
            $set_array['seller_address_3']  = ((isset($arr['seller_address_3'])))   ?$arr['seller_address_3']   :"";
            $set_array['seller_postcode']   = ((isset($arr['seller_postcode'])))    ?$arr['seller_postcode']    :"";
            $set_array['seller_gst_no']     = ((isset($arr['seller_gst_no'])))      ?$arr['seller_gst_no']      :"";
            $set_array['buyer_company']     = ((isset($arr['buyer_company'])))      ?$arr['buyer_company']      :"";
            $set_array['buyer_company_no']  = ((isset($arr['buyer_company_no'])))   ?$arr['buyer_company_no']   :"";
            $set_array['buyer_address_1']   = ((isset($arr['buyer_address_1'])))    ?$arr['buyer_address_1']    :"";
            $set_array['buyer_address_2']   = ((isset($arr['buyer_address_2'])))    ?$arr['buyer_address_2']    :"";
            $set_array['buyer_address_3']   = ((isset($arr['buyer_address_3'])))    ?$arr['buyer_address_3']    :"";
            $set_array['buyer_postcode']    = ((isset($arr['buyer_postcode'])))     ?$arr['buyer_postcode']     :"";
            $set_array['buyer_gst_no']      = ((isset($arr['buyer_gst_no'])))       ?$arr['buyer_gst_no']       :"";
            $set_array['order_id']          = ((isset($arr['order_id'])))           ?$arr['order_id']           :"";
            $set_array['tax_invoice_no']    = ((isset($arr['tax_invoice_no'])))     ?$arr['tax_invoice_no']     :"";
            $set_array['product_id']        = ((isset($arr['product_id'])))         ?$arr['product_id']         :"";
            $set_array['product_name']      = ((isset($arr['product_name'])))       ?$arr['product_name']       :"";
            $set_array['qty']               = ((isset($arr['qty'])))                ?$arr['qty']                :"";
            $set_array['unit_price']        = ((isset($arr['unit_price'])))         ?number_format($arr['unit_price']/100, 2)         :"";
            $set_array['amount']            = ((isset($arr['amount'])))             ?number_format($arr['amount']/100, 2)             :"";
            return $set_array;
        },$for_export);

        $doArray[] = ['date',
        'seller company',
        'seller company no',
        'seller address 1',
        'seller address 2',
        'seller address 3',
        'seller postcode',
        'seller gst no',
        'buyer company',
        'buyer company no',
        'buyer address 1',
        'buyer address 2',
        'buyer address 3',
        'buyer postcode',
        'buyer gst no',
        'order id',
        'tax invoice no',
        'product id',
        'product name',
        'qty',
        'unit_price',
        'amount',];

        foreach ($data as $df) {
            $doArray[] = $df;
        }
        ob_end_clean();

        ob_start();
        Excel::create('delivery_orders', function($excel) use ($doArray) {

            // Set the spreadsheet title, creator, and description
            $excel->setTitle('Delivery Orders');
            $excel->setCreator('OpenSupermall')->setCompany('OpenSupermall');
            $excel->setDescription('deliver orders');

            // Build the spreadsheet, passing in the payments array
            $excel->sheet('sheet1', function($sheet) use ($doArray) {
                $sheet->fromArray($doArray, null, 'A1', false, false);
            });

        })->download('xlsx');

        Session::flash('success','Succesfully Exported DO');
        return redirect()->back();

    }

    public function canceltr($id)
    {
        $delivery_order                 =  DeliveryOrder::find($id);
        $delivery_order->status         = 'pending';
        $delivery_order->save();
        $delivery_order_stock_report    = DeliveryOrderStockReport::where('deliveryorder_id','=',$id)
        ->where('deleted_at','=',null)->first();

        $stock_report                   = Stockreport::
        where('id','=',$delivery_order_stock_report->stockreport_id)
        ->where('deleted_at','=',null)->first();
        $stock_report->deleted_at = Carbon::now();
        $stock_report->save();
        $delivery_order_stock_report->deleted_at = Carbon::now();
        $delivery_order_stock_report->save();
        return redirect()->back();
    }
    public function importedstatus($id)
    {
       $delivery_order_stock_report    = DeliveryOrderStockReport::where('deliveryorder_id','=',$id)
       ->join('stockreport','stockreport.id','=','deliveryorderstockreport.stockreport_id')
       ->leftjoin('users','users.id','=','stockreport.checker_user_id')
       ->where('deliveryorderstockreport.deleted_at','=',null)
       ->get([
        'stockreport.created_at',
        'stockreport.report_no',
        'stockreport.status',
        'users.name',
        'stockreport.id'
    ]);
       $rs =  view('seller.logistics.importedstatus_ajax',compact('delivery_order_stock_report',$delivery_order_stock_report))->render();
       return $rs;
   }

}
