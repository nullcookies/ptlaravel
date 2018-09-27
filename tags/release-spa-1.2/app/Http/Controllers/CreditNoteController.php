<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\POrder;
use App\Models\OrdertProduct;
use App\Models\ReturnOfGood;
use App\Models\MerchanttProduct;
use App\Models\Merchant;
use App\Models\CreditNote;
use App\Models\Globals;
use App\Models\Currency;
use App\Models\User;
use Session;


use Auth;
class CreditNoteController extends Controller
{
	
	/*public function returnGoods()
	{

		$user_id   = Auth::user()->id; 
		$orderlist = POrder::where('user_id',$user_id)->where('mode','=','term')->get();
		$returnGoodsTable = view('seller.credit_note_views.return_goods_ajax',compact('orderlist',$orderlist))->render();

		return $returnGoodsTable;
		
	}*/

	public function returnStatus()
	{

		$station_id     = Auth::user()->id;
//		$station_id     = 487;

		$returnofgoodrequest = ReturnOfGood::where('station_id' ,'=',		$station_id)
		->join('ordertproduct','ordertproduct.id'				,'=',		'return_of_goods.order_tproduct_id')
		->join('tproduct','tproduct.id'							,'=',		'ordertproduct.tproduct_id')
		->join('creditnote','creditnote.return_of_goods_id'		,'=',		'return_of_goods.id')
		->select('creditnote.status as status',
			'creditnote_no as c_no',
			'return_of_goods.id as return_of_goods_id',
			'return_of_goods.order_tproduct_id as order_tproduct_id',
			'return_of_goods.quantity as quantity',
			'return_of_goods.station_id as station_id',
			'return_of_goods.merchant_id as merchant_id',
			'return_of_goods.returnofgoods_no as returnofgoods_no',
			'tproduct.name as name')->get();
		

		$returnGoodsTable = view('seller.credit_note_views.return_status_ajax',compact('returnofgoodrequest',$returnofgoodrequest))->render();
		return $returnGoodsTable;
	}

	public function returnMerchantAproval()
	{
		$currency = Currency::where('active','=',1)->first();
		$user     = Auth::user()->id;
		$merchant = Merchant::where('user_id','=',$user)->first();

		$returnofgoodrequest = ReturnOfGood::where('merchant_id'		,'=',		$merchant->id)
		->join('creditnote','creditnote.return_of_goods_id'				,'=',		'return_of_goods.id')
		->where('creditnote.status'										,'=',		'Pending')
		->join('users as stationuser','return_of_goods.station_id'		,'=',		'stationuser.id')
		->join('station','return_of_goods.station_id'					,'=',		'station.user_id')
		->join('merchant','return_of_goods.merchant_id'					,'=',		'merchant.id')
		->join('address','address.id'									,'=',		'merchant.address_id')
		->join('address as stationaddress','station.address_id'			,'=',		'stationaddress.id')
		->join('ordertproduct','ordertproduct.id'						,'=',		'return_of_goods.order_tproduct_id')
		->join('nporderid','ordertproduct.porder_id'						,'=',		'nporderid.porder_id')
		->join('tproduct','tproduct.id'									,'=',		'ordertproduct.tproduct_id')
		->join('ntproductid','tproduct.id'								,'=',		'ntproductid.tproduct_id')
		
		//->select()
		//->distinct('creditnote_no')
		->get(
			[
				'creditnote.status as status',
				'creditnote.creditnote_no as creditnote_no',
				'creditnote.id as creditnote_id',
				'return_of_goods.order_tproduct_id as order_tproduct_id',
				'return_of_goods.quantity as quantity',
				'return_of_goods.station_id as station_id',
				'return_of_goods.merchant_id as merchant_id',
				'tproduct.name as name',
				'creditnote.created_at as created_at',
				'stationuser.first_name as station_first_name',
				'stationuser.last_name as station_last_name',
				'tproduct.description as description',
				'ordertproduct.order_price as order_price',
				'ntproductid.ntproduct_id as productid',
				'nporderid.nporder_id as porder_id',
				'address.line1 as line1',
				'address.line2 as line2',
				'address.line3 as line3',
				'address.line4 as line4',
				'stationaddress.line1 as stationline1',
				'stationaddress.line2 as stationline2',
				'stationaddress.line3 as stationline3',
				'stationaddress.line4 as stationline4',
				'merchant.gst as gst'
			]
		);
		

		$returnGoodsTable = view('seller.credit_note_views.return_merchant_approval_ajax',compact('returnofgoodrequest',$returnofgoodrequest),compact('currency',$currency))->render();
		return $returnGoodsTable;
	}

	public function returnordertproduct()
	{
		$user_id   = Auth::user()->id; 
		$ordertproductlist =   OrdertProduct::join('porder','ordertproduct.porder_id','=','porder.id')
		->where('porder.user_id'						,'=',		$user_id)
		->where('mode'									,'=',		'term')
		->join('tproduct','tproduct.id'					,'=',		'ordertproduct.tproduct_id')
		->join('ntproductid','tproduct.id'				,'=',		'ntproductid.tproduct_id')
		->get([
			'tproduct.id as t_id' ,
			'tproduct.name as name',
			'ordertproduct.id as ordertproductid',
			'ordertproduct.quantity as quantity',
			'tproduct.description as description',
			'ordertproduct.order_price as order_price',
			'ordertproduct.quantity as qty',
			'ntproductid.ntproduct_id as ntproduct_id',
			//'ntproductid.tproduct_id as tproduct_id'
		])
		->groupBy('t_id');
		
		foreach ($ordertproductlist as $key => $value) {
			$data[$key] = $value->groupBy('order_price');
		}

		/*foreach ($data as $key => $value) {

			foreach ($value as $k => $val) {
                     return $val[$key]->tproduct_id; 
                    $p_price = number_format($price/100,2);
                }
            }*/



            $currency = Currency::where('active','=',1)->first();
            $tableorderdproducts = view('seller.credit_note_views.return_ordertproductlist_ajax',compact('data'),compact('currency',$currency))->render();

            return $tableorderdproducts;
        }

        public function returnquantity(Request $request)
        {




        	if (!$request->has('product')) {
        		Session::flash('error','Please Select atleast one product');
        		return redirect()->back();
        	}
        	$products = $request->product;

        	foreach ($products as $key => $value) {

        		$creditnote_no = CreditNote::orderBy('id','desc')->first();
        		if ($creditnote_no) {
        			$sequence_no = $creditnote_no->creditnote_no;
        			$sequence_no = ++$sequence_no;
        			$sequence_no = str_pad($sequence_no,10,'0',STR_PAD_LEFT);
        		}
        		else{
        			$global = Globals::first();
        			$sequence_no = $global->creditnote_sequence;
        			$sequence_no = ++$sequence_no;
        			$sequence_no = str_pad($sequence_no,10,'0',STR_PAD_LEFT);
        		}

        		$returnofgoods_no = ReturnOfGood::orderBy('id','desc')->first();
        		if ($returnofgoods_no) {
        			$rog_sequence_no = $returnofgoods_no->returnofgoods_no;
        			$rog_sequence_no =++$rog_sequence_no;
        			$rog_sequence_no = str_pad($rog_sequence_no,10,'0',STR_PAD_LEFT);

        		}
        		else{
        			$global = Globals::first();
        			$rog_sequence_no = $global->returnofgoods_no;
        			$rog_sequence_no =++$rog_sequence_no;
        			$rog_sequence_no = str_pad($rog_sequence_no,10,'0',STR_PAD_LEFT);
        		}


        		$ordertproduct  = OrdertProduct::select('ordertproduct.tproduct_id')->where('id',$key)->first();
        		$merchantid     = MerchanttProduct::where('tproduct_id','=',$ordertproduct->tproduct_id)->select('merchant_id')->first();

        		$station_id     = Auth::user()->id; 
        		$returnofgoods  = new ReturnOfGood();
        		$returnofgoods->order_tproduct_id = $key;
        		$returnofgoods->quantity    = $request->productqty[$key];
        		$returnofgoods->station_id    = $station_id;
        		$returnofgoods->merchant_id =  $merchantid->merchant_id;
        		$returnofgoods->returnofgoods_no =  $rog_sequence_no;
        		if ($returnofgoods->save()) {

        			$creditnote = new CreditNote();
        			$creditnote->creditnote_no = $sequence_no;
        			$creditnote->return_of_goods_id = $returnofgoods->id;
        			$creditnote->quantity = $returnofgoods->quantity;
        			$creditnote->status   =	"Pending";
        			$creditnote->save();

        		}

        		return redirect()->back();
        	}
        }
        public function updatereturnproductstatus($creditnote_id,$status)
        {

        	$creditnote = CreditNote::where('creditnote.id','=',$creditnote_id)
        	->join('return_of_goods','return_of_goods.id','=','creditnote.return_of_goods_id')->select('creditnote.*','return_of_goods.quantity as returnofgoodsqty')->first();
        	$creditnote->quantity = $creditnote->returnofgoodsqty;
        	$creditnote->status = $status;

        	if ($creditnote->save()) {
        		return "Status Updated to ".$status;
        	}
        }
        public function creditnotedocument($id)
        {
        	$currency = Currency::where('active','=',1)->first();
        	$selluser = User::find(Auth::user()->id);
        	 $creditnote = CreditNote::where('creditnote.id','=',$id)
        	->join('return_of_goods','return_of_goods.id','=','creditnote.return_of_goods_id')
        	->join('users as stationuser','return_of_goods.station_id'	,'=',  'stationuser.id')
        	->join('station','return_of_goods.station_id'				,'=',  'station.user_id')
        	->join('merchant','return_of_goods.merchant_id'				,'=',  'merchant.id')
        	->join('address','address.id'								,'=',  'merchant.address_id')
        	->join('address as stationaddress','station.address_id'		,'=',  'stationaddress.id')
        	->join('ordertproduct','ordertproduct.id'					,'=',  'return_of_goods.order_tproduct_id')
        	->join('nporderid','ordertproduct.porder_id'				,'=',  'nporderid.porder_id')
        	->join('tproduct','tproduct.id'								,'=',  'ordertproduct.tproduct_id')
        	->join('ntproductid','tproduct.id'							,'=',  'ntproductid.tproduct_id')
        	->get(
        		[
        			'creditnote.status as status',
        			'creditnote.creditnote_no as creditnote_no',
        			'creditnote.id as creditnote_id',
        			'return_of_goods.order_tproduct_id as order_tproduct_id',
        			'return_of_goods.quantity as quantity',
        			'return_of_goods.station_id as station_id',
        			'return_of_goods.merchant_id as merchant_id',
        			'tproduct.name as name',
					'merchant.company_name as mcompany_name',
					'merchant.business_reg_no as mbusiness_reg_no',
					'station.company_name as scompany_name',
					'station.business_reg_no as sbusiness_reg_no',
        			'creditnote.created_at as created_at',
        			'stationuser.first_name as station_first_name',
        			'stationuser.last_name as station_last_name',
        			'tproduct.description as description',
        			'ordertproduct.order_price as order_price',
        			'ntproductid.ntproduct_id as productid',
        			'nporderid.nporder_id as porder_id',
        			'address.line1 as line1',
        			'address.line2 as line2',
        			'address.line3 as line3',
        			'address.line4 as line4',
        			'address.postcode as mpostcode',
        			'stationaddress.line1 as stationline1',
        			'stationaddress.line2 as stationline2',
        			'stationaddress.line3 as stationline3',
        			'stationaddress.line4 as stationline4',
        			'stationaddress.postcode as spostcode',
        			'merchant.gst as mgst',
        			'station.gst as sgst',
        		]
        	);
        	return view('seller.credit_note_views.creditnotedocument',compact('selluser'))->with('returnofgoodrequest',$creditnote)->with('currency',$currency);
        }
        public function returnofgoodsdocument($id)
        	{
        		$currency = Currency::where('active','=',1)->first();
        	$selluser = User::find(Auth::user()->id);
        	 $creditnote = CreditNote::where('creditnote.id','=',$id)
        	->join('return_of_goods','return_of_goods.id','=','creditnote.return_of_goods_id')
        	->join('users as stationuser','return_of_goods.station_id'	,'=',  'stationuser.id')
        	->join('station','return_of_goods.station_id'				,'=',  'station.user_id')
        	->join('merchant','return_of_goods.merchant_id'				,'=',  'merchant.id')
        	->join('address','address.id'								,'=',  'merchant.address_id')
        	->join('address as stationaddress','station.address_id'		,'=',  'stationaddress.id')
        	->join('ordertproduct','ordertproduct.id'					,'=',  'return_of_goods.order_tproduct_id')
        	->join('nporderid','ordertproduct.porder_id'				,'=',  'nporderid.porder_id')
        	->join('tproduct','tproduct.id'								,'=',  'ordertproduct.tproduct_id')
        	->join('ntproductid','tproduct.id'							,'=',  'ntproductid.tproduct_id')
        	->get(
        		[
        			'creditnote.status as status',
        			'return_of_goods.returnofgoods_no as creditnote_no',
        			'creditnote.id as creditnote_id',
        			'return_of_goods.order_tproduct_id as order_tproduct_id',
        			'return_of_goods.quantity as quantity',
        			'return_of_goods.station_id as station_id',
        			'return_of_goods.merchant_id as merchant_id',
        			'tproduct.name as name',
        			'creditnote.created_at as created_at',
        			'stationuser.first_name as station_first_name',
        			'stationuser.last_name as station_last_name',
        			'tproduct.description as description',
        			'ordertproduct.order_price as order_price',
        			'ntproductid.ntproduct_id as productid',
        			'nporderid.nporder_id as porder_id',
        			'address.line1 as line1',
        			'address.line2 as line2',
        			'address.line3 as line3',
        			'address.line4 as line4',
        			'stationaddress.line1 as stationline1',
        			'stationaddress.line2 as stationline2',
        			'stationaddress.line3 as stationline3',
        			'stationaddress.line4 as stationline4',
        			'merchant.gst as gst'
        		]
        	);
        	return view('seller.credit_note_views.returnofgoodsdocument',compact('selluser'))->with('returnofgoodrequest',$creditnote)->with('currency',$currency);
        	}
    }
