<?php
use App\Classes;
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\IdController;
?>
@extends('common.default')
@section('extra-links')
    <style type="text/css">
		.btn-css {
			color: #fff;
			background-color: #5bc0de;
			border-color: #46b8da;
		}
	
		.btn-css:hover {
			color: #fff;
			background-color: #31b0d5;
			border-color: #269abc;
		}
    </style>
{{--  <link rel="stylesheet" type="text/css" href="{{asset('css/inventory/inventory.css')}}"> --}}
<script>
	var categoryNameTab='';



function showSubCategory(catId,categoryName){
$(document).ready(function(){
	//var x= $("div[class^='catId_']").html();
	categoryNameTab=categoryName.toUpperCase();
	$("#catSubCatNameTab").text(categoryName.toUpperCase());
	if($(".catId_"+catId).html()==undefined){
		$("#noSubCat").show();
	}else{
		$("#noSubCat").hide();
	}
	$("div[class^='catId_']").hide();
	$(".catId_"+catId).show();
	$("#subcatbox").show();
	$("#productbox").hide();
	$(".pinclass").hide();
	$("#psubcatbox").hide();
});
}
</script>

@stop
@section('content')
@include("common.sellermenu")
{{-- NEW CODE --}}
<div class="container">
	<span id="top"></span>
	<div class="col-xs-12">
	{!! Breadcrumbs::renderIfExists() !!}
	<div class="row">
		<br>
		<h2 style="display:inline; ">Price Offer</h2>
		<br> <br>
                <div class="table-responsive">
                    <table width="99%"
						class="table table-bordered"
						id="order_view_list_table">
                        <thead>
                        <tr style="background-color: #444; color: #fff;">
                            <th bgcolor="#303030" style="color:white"
								width="20px" data-orderable="false"
								class="text-center">No.</th>
                            <th bgcolor="#303030" style="color:white"
								width="40px" class="text-center">Product&nbsp;ID</th>
                            <th bgcolor="#303030" style="color:white">Name</th>
                            <th class="text-center" bgcolor="#303030" style="color:white">Qty</th>
                            <th class="text-center" bgcolor="#303030" style="color:white">Price</th>
                            <th class="text-center" bgcolor="#FD1919" style="color:white">Max</th>
                            <th class="text-center" bgcolor="#FDD074" style="color:white">Cost&nbsp;Price</th>

                        </tr>
                        </thead>
                        <tbody>
						<?php $i = 1; ?>
							@if(!is_null($products))
								@foreach($products as $product)
									<?php 
										$style="";
										$title="";
										if($product->av <= 0){
											$style="background-color: #CCC;";
											$title="This product is no longer available";
										}
									?>
									<tr style="{{$style}}" title="{{$title}}">
										<td class="text-center">{{$i}}</td>
										<td class="text-center">{{IdController::nP($product->product_id)}}</td>
										<?php $pname = $product->name;
											if(strlen($pname) > 20){
												$pname = substr($pname,0,17);
												$pname .= "...";
											}
										?>
										<td class="text-left"><p title="{{$product->name}}"><img src="{{asset('/')}}images/product/{{$product->parent_id}}/{{$product->photo_1}}" width="30" height="30" style="padding-top:0;margin-top:4px"><span style="vertical-align: middle;">{{$pname}}</p></td>
										
										<td class="text-center"><span class="qty_span" id="qtyspan{{$product->product_id}}" rel="{{$product->product_id}}">{{$product->available}}</span><input sspid="{{$product->sspid}}" style="display: none;" rel="{{$product->product_id}}" value="{{$product->available}}" id="qty{{$product->product_id}}" stationid="{{$product->product_id}}" class="text-center sproductqty" type="text" size="6" /></td>
										<td class="text-right">
											<?php
												if(is_null($product->discounted_price) || $product->discounted_price <= 0){
													$theprice = $product->retail_price;
												} else {
													$theprice = $product->discounted_price;
												}
											?>
												{{$currentCurrency}}&nbsp;{{number_format($theprice/100,2,".","")}}
										</td>
										<?php
											if(!is_null($product->product_commission) && $product->product_commission > 0){
												$maxoffer = $theprice * (1 - $product->product_commission/100);
											} else {
												if(!is_null($product->merchant_commission) && $product->merchant_commission > 0){
													$maxoffer = $theprice * (1 - $product->product_commission/100);
												} else {
													$maxoffer = $theprice * (1 - $global_vars->osmall_commission/100);
												}
											}
										?>
										<td class="text-right">{{$currentCurrency}}&nbsp;{{number_format($maxoffer/100,2,".","")}}</td>
										<?php 
											if(is_null($product->fair_commission)){
												$offer = 0;
											} else {
												$offer = $theprice * (1 - $product->fair_commission/100);
											}
										?>
										<td class="text-right"><span class="offer_span" rel="{{$product->product_id}}" id="offerspan{{$product->product_id}}">{{$currentCurrency}}&nbsp;{{number_format($offer/100,2,".","")}}</span><input style="display: none;" rel="{{$product->product_id}}" value='{{number_format($offer/100,2,".","")}}' id="offer{{$product->product_id}}" sspid="{{$product->sspid}}" max='{{number_format($maxoffer/100,2,".","")}}' theprice='{{number_format($theprice/100,2,".","")}}' stationid="{{$product->product_id}}" class="text-center sproductoffer" type="text" size="6" /></td>
										<?php $i++; ?>
									</tr>
								@endforeach
							@endif
                        </tbody>
                    </table>
                </div>
	</div>
</div>
</div>
<br><br>
{{-- NEW CODE ENDS --}}
{{-- < --}}
<script type="text/javascript" src="{{asset('js/inventory/inventory.js')}}"></script>
<script type="text/javascript" src="{{url('js/bootstrap-number-input2.js')}}"></script>
<script>
$(document).ready(function () {	
	$(".sproductoffer").number(true,2,".","");
	$(document).delegate( '.sproductoffer', "blur",function (event) {
		var id = $(this).attr("sspid");
		var pid = $(this).attr("rel");
		var offer = $(this).val();
		var max = $(this).attr("max");
		
		if(parseFloat(offer) >= parseFloat(max)){
			toastr.error("Offer cannot be grater or equal than maximum");			
		} else {
			var theprice = parseFloat($(this).attr("theprice"));
			var theoffer = (parseFloat(offer)*100)/theprice;
			/*console.log(theprice);
			console.log(offer);
			console.log(theoffer);*/
			var obd = $(this);
			$.ajax({
					url: JS_BASE_URL + "/inventory/addoffer",
					type: "post",
					data: {
						'id': id,
						'offer': 100 - theoffer.toFixed(2)
					},
					async: false,
					success: function (data) {
						console.log(data);
						obd.hide();
						var txt = parseFloat(offer).toFixed(2);
						$("#offerspan" + pid).html("{{$currentCurrency}} " + txt);
						$("#offerspan" + pid).show();
						toastr.info("Offer successfully added");
					}
			});				
		}
		
	
	});

	$(document).delegate( '.offer_span', "click",function (event) {
	//$('.qty_span').click(function (e) {
		$(this).hide();
		var id = $(this).attr("rel");
		$("#offer" + id).show();
	});
		
	$(document).delegate( '.sproductqty', "blur",function (event) {
		var id = $(this).attr("sspid");
		var pid = $(this).attr("rel");
		var qty = $(this).val();
		var obd = $(this);
		$.ajax({
				url: JS_BASE_URL + "/inventory/updateinv",
				type: "post",
				data: {
					'id': id,
					'qty': qty
				},
				async: false,
				success: function (data) {
					console.log(data);
					obd.hide();
					$("#qtyspan" + pid).html(qty);
					$("#qtyspan" + pid).show();
					toastr.info("Quantity successfully updated");
				}
		});		
	});

	$(document).delegate( '.qty_span', "click",function (event) {
	//$('.qty_span').click(function (e) {
		$(this).hide();
		var id = $(this).attr("rel");
		$("#qty" + id).show();
	});		
		
	$('.add-btn').click(function (e) {
		$(this).html("Adding...");
		$(this).attr("disabled", true);
		path = window.location.href;
		var url;
		if (path.includes('public'))
		{
		//	url = '/openSupermall/public/cart/addtocart';
		}
		else {
			url = '/inventory/addproduct';
		}	
		
		
		$('.product_selected').each(function() {	
			if (this.checked) {
				var rel = $(this).attr("rel");
				console.log(rel);
				var qty = $("#qty" + rel).val();
				var price = $(".mprice" + rel).text();
				$.ajax({
						url: url,
						type: "post",
						data: {
							'id': rel,
						},
						async: false,
						success: function (data) {
							console.log(data);
						}
				});
			}
		});	
		toastr.info("Products Successfully Added");
		location.reload();
	});
	$('.pricesn').bootstrapNumber();
	$('#order_view_list_table').dataTable({
		"order": [],
		"scrollx": true,
		"columndefs": [
			{"targets": "medium", "width": "80px"},
			{"targets": "large",  "width": "120px"},
			{"targets": "approv", "width": "180px"},
			{"targets": "blarge", "width": "200px"},
			{"targets": "clarge", "width": "250px"},
			{"targets": "xlarge", "width": "300px"},
		],
	});	
});
</script>
@stop



