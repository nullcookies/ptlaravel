<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\OposReceipt;
use App\Models\OposReceiptproduct;
use DB;
use App\Models\Product;
use Auth;

class SalesController extends Controller
{

    public function viewSales()
    {
        $selluser = \App\Models\User::find(Auth::user()->id);
        $sellerData = OposReceipt::join('opos_receiptproduct','opos_receipt.id','=','opos_receiptproduct.receipt_id')
                    ->leftjoin('product','opos_receiptproduct.product_id','=','product.id')
                    ->leftjoin('rawmaterial','rawmaterial.item_product_id','=','opos_receiptproduct.product_id')
                    ->leftjoin('users','users.id','=','opos_receipt.staff_user_id')
                    ->select('product.id as pid','product.name as pname','product.thumb_photo','opos_receipt.id','opos_receiptproduct.product_id','opos_receipt.receipt_no','opos_receipt.created_at','opos_receipt.staff_user_id','opos_receiptproduct.price','opos_receiptproduct.discount','opos_receiptproduct.quantity',DB::raw('SUM(opos_receiptproduct.price + opos_receiptproduct.discount) as amount'),'users.name as staffname',DB::raw('COUNT(rawmaterial.id) as raw_count'))
                    ->whereNull("opos_receiptproduct.deleted_at")
                    ->groupby('opos_receiptproduct.id')
                    ->orderby('opos_receipt.id','desc')
                    ->get();

        return view('seller.saleslist',compact('sellerData','selluser'));
    }

    public function viewRawMaterial($product_id)
    {
        $rawMaterials = DB::table('rawmaterial')
                      ->join('product','rawmaterial.raw_product_id','=','product.id')
                      ->select('rawmaterial.*','product.name')
                      ->where('rawmaterial.item_product_id',$product_id)
                      ->get();

        $productDetail = Product::select('id','name','thumb_photo')
                                ->where('id',$product_id)
                                ->first();

        return view('seller.saleslist_ajax',compact('rawMaterials','productDetail'));
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
