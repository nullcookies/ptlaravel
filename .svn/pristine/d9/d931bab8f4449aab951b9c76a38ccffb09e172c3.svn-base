<?php
use App\Classes;
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\IdController;
?>
@extends('common.default')

@section('this-styles')
<link rel="stylesheet" href="{{asset('/css/datatable.css')}}"/>
@endsection

@section('content')
@include("common.sellermenu")
<style type="text/css">
.btn-css {
	color: #fff;
	background-color: #5bc0de;
	border-color: #46b8da;
	padding: 6px 9px !important;
}
.btn-subcatn{
	border: none;
	background: #fff;
	padding-left: 0px;
}	
#tproduct_wrapper{
	width: 76%;
}
@media only screen and (max-width: 768px) {
	#tproduct_wrapper{
		font-size: 10px;
	}
	.modal-fullscreen{
		width: 100% !important;
	}
}
@media only screen and (max-width: 530px) {
	#tproduct_wrapper{
		font-size: 8px;


	}

	td{
		padding:8px;
	}
	th{
		padding-left: 8px;
	}
}
@media only screen and (max-width: 430px) {
	
	.table>caption+thead>tr:first-child>td, .table>caption+thead>tr:first-child>th, .table>colgroup+thead>tr:first-child>td, .table>colgroup+thead>tr:first-child>th, .table>thead:first-child>tr:first-child>td, .table>thead:first-child>tr:first-child>th{
		padding:10px;
	}

	
}
.btn-sub{
	border: none;
}		

.btn-css:hover {
	color: #fff;
	background-color: #31b0d5;
	border-color: #269abc;
}

.badge1 {
	background-color: #1abc9c !important;
}
.badge1[data-badge]:after {
	content:attr(data-badge);
	position:absolute;
	top:-10px;
	right:5px;
	font-size:.7em;
	background:red;
	color:white;
	width:18px;height:18px;
	text-align:center;
	line-height:18px;
	border-radius:50%;
	box-shadow:0 0 1px #333;
}	

.badge1[data-badge=””]:after {
	content: none;
}	

.ui-tooltip {
	white-space: pre-line;
}	
</style>		
<div class="modal fade myModal" id="Modal" role="dialog">
	<div class="modal-dialog modal-fullscreen" style="width: 80%">
		<!-- Modal content-->
		<div class="modal-content" style="max-width: 950px;min-width: 950px;">
			<div class="modal-header">
				<button id='orderClose' type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">
					<h3>Purchase Order List</h3>
				</h4>
			</div>
			<div class='modal-body'>
				<div id="purchasebody">
				</div>
			</div>
			<div class="modal-footer" style='border:none'>
			</div>
		</div>
	</div>
</div>
<section class="">
	<div class="container"><!--Begin main cotainer-->
		<div class="row" style="margin-top: 10px;">
			<div class="col-sm-6">
				<h2 class="heading">Procurement List: Credit Term</h2>
			</div>
			<div class="col-sm-4"> 						
				&nbsp;
			</div>
			<div class="col-sm-2 cart-holder"
			style="padding-right:0;margin-top:10px;margin-bottom:5px">
			<?php 
			$purorders = DB::table('porder')->
			join('ordertproduct',
				'ordertproduct.porder_id','=','porder.id')->
			join('merchanttproduct',
				'ordertproduct.tproduct_id','=',
				'merchanttproduct.tproduct_id')->
			where('mode','term')->
			leftJoin('invoice','invoice.porder_id','=',
				'porder.id')->
			select('porder.*')->distinct()->
			where('user_id',Auth::user()->id)->
			whereNull('invoice.id')->get();
						//dd($purorders);
			?>
			@if( $purorders < 1)
			<div class="cart-po">
				<a href="javascript:void(0)" target="_blank"
				class='cart-link' id="badgelink"> PO is Empty  </a>
				<i class="fa fa-list-alt"></i>
				<span
				style="right:-10px"
				class="badge badge-cart" id="badgeqty"> 0 </span>

			</div>
			@else
			<div class="cart-po">
				<a href="javascript:void(0)" target=""
				class='cart-link' id="badgelink"> View POs  </a>
				<i class="fa fa-list-alt"></i>
				<span
				style="right:-10px"
				class="badge badge-cart" id="badgeqty">
			{!! count($purorders) !!} </span>
		</div>
		@endif
	</div>
	<br>			
</div>
<input type="hidden" id="purorders" value="{!! count( $purorders) !!}" />

<div class="row">
	<div class="table-responsive" style="padding-left:15px">
		<table class="table table-bordered" id="order_view_list_table" width="100%">
			<thead>
				<tr class="bg-b2b">
					<th width="20px" class="text-center">No</th>
					<th width="60px" class="text-center">Product&nbsp;ID</th>
					<th width="200px">Product&nbsp;Name</th>
					<th width="60px" class="text-center">Qty</th>
					<th width="80px" class="text-center">
						Total ({{$currentCurrency}})</th>
					<th width="60px" class="text-center">Select</th>

				</tr>
			</thead>
			@if(!is_null($orderst))
			<tfoot>
				<tr>
					<th colspan="5" rowspan="1"></th>
					<th colspan="1" rowspan="1" class="text-center">
						<button class="btn-sub add-invoicebtn" style="width: 50px !important; height: 40px !important; background-color: #F29FD7 !important; color: #FFF;">
							<span><i class="fa fa-list-alt fa-2x" style="margin-top: 3px;"
								>
							</i></span>
						</button></th>
					</tr>
				</tfoot>	
				@endif
				<tbody>
					<?php $i = 1;

							//dd($orderst);?>
					@if(!is_null($orderst))
					@foreach($orderst as $product)
					<?php 

					$first_price = DB::table('tproductdealer')->where('tproduct_id', $product->product_id)->where('dealer_id', $selluser->id)->orderBy('special_price','DESC')->select("special_funit as funit", "special_unit as unit", "special_price as price")->first();
					if(!is_null($first_price)){
						$all_price = DB::table('tproductdealer')->where('tproduct_id', $product->product_id)->where('dealer_id', $selluser->id)->orderBy('special_price','DESC')->select("special_funit as funit","special_unit as unit", "special_price as price")->get();
					} else {
						$first_price = DB::table('twholesale')->where('tproduct_id', $product->product_id)->orderBy('price','DESC')->first();
						$all_price = DB::table('twholesale')->where('tproduct_id', $product->product_id)->orderBy('price','DESC')->get();
					}
									//dump($product);
					if(!is_null($first_price)){
						$chdisabled = "";
						$chtitle = "";
						$style = "vertical-align: middle;";
						if(is_null($product->credit_limit) ||
							is_null($product->tokenqty)     ||
							is_null($product->sellerfacilityid)){
							$chdisabled = "disabled";
						if(is_null($product->credit_limit)){
							$chtitle = "No term available for this product. You don't have credit to buy from this Merchant!";
						} elseif(is_null($product->tokenqty)){
							$chtitle = "No term available for this product. Merchant don't have enough tokens!";
						}elseif(is_null($product->sellerfacilityid)){
							$chtitle = "No term available for this product. Merchant cannot longer sell Credit Term products.";
						} else {
							$chtitle = "No term available for this product. Unexpected Error.";
						}											 
						$style .= " background-color: #efefef;";												 
					} else {
						if($facilityadmin >= $product->tokenqty){
							$chdisabled = "disabled";
							$chtitle = "No term available for this product. Merchant don't have enough tokens!";												 
							$style .= " background-color: #efefef;";
						}
					}
					$styles = "vertical-align: middle; background-color: #efefef;";

					?>													
					<tr>
						<td class="text-center" style="vertical-align:middle;">{{$i}}</td>
						<td class="text-center" style="vertical-align:middle;">{{IdController::nTp($product->product_id)}}</td>
						<?php 
						$pname = $product->name;
						if(strlen($pname) > 35){
							$pname = substr($pname, 0 , 32);
							$pname .= "...";
						}
						?>										
						<td class="text-left" style="vertical-align:middle;"><span style="vertical-align: middle;">
							@if($product->parent_id > 0)
							<img src="{{asset('/')}}images/product/{{$product->parent_id}}/{{$product->photo_1}}" width="30" height="30" style="padding-top:0;margin-top:4px">
							@endif
							{{$pname}}
						</td>
						<td class="text-center" style="vertical-align:middle;"><input name="price[]" rel="{{$product->product_id}}" id="qty{{$product->product_id}}" class="form-control pricesn" type="number" value="1" min="1" max="{{$product->available}}" /></td>
						<?php 
						$counter = 1;
										//	dd($all_price);
						$all_wholesalescounter = count($all_price);
						$wtitle = "";
						?>
						<td class="text-right tablet" style="vertical-align:middle;">
							{{-- popover view --}}
							<div class="hide" id="price-{{ $product->product_id }}">
								<div class="row">
									<div class="table-responsive" style="border:0px">
										<table class="priceTable table">
											<thead>
												<tr>
													<th class='text-left'>Tier</th>
													<th class='text-right'>Price/Unit</th>
												</tr>
											</thead>
											<tbody>
												@foreach($all_price as $wholesale)
												<tr>
													<td class='text-left'>
														@if($all_wholesalescounter == $counter)
														<span> {{ $wholesale->funit }} </span>
														<input type="hidden" id="funit{{$product->product_id}}-{{$counter}}" value="{{ $wholesale->funit }}" />
														<input type="hidden" id="unit{{$product->product_id}}-{{$counter}}" value="100000000" />
														<input type="hidden" id="wprice{{$product->product_id}}-{{$counter}}" class="wprice{{$product->product_id}}" value="{{ $wholesale->price/100 }}" />													
														@else
														<span> {{ $wholesale->funit }} </span> -
														<span> {{ $wholesale->unit }} </span>
														<input type="hidden" id="funit{{$product->product_id}}-{{$counter}}" value="{{ $wholesale->funit }}" />
														<input type="hidden" id="unit{{$product->product_id}}-{{$counter}}" value="{{ $wholesale->unit }}" />
														<input type="hidden" id="wprice{{$product->product_id}}-{{$counter}}" class="wprice{{$product->product_id}}" value="{{ $wholesale->price/100 }}" />
														@endif
													</td>
													<td class='text-right'>
														<span> {{ number_format($wholesale->price/100,2) }} </span>
													</td>
												</tr>

												<?php $counter++; ?>
												@endforeach
												<input type="hidden" id="counter" value="{{ $counter }}" />
											</tbody>
										</table>
									</div>
								</div>
							</div>
							<span tabindex="0"  data-toggle="popover" data-trigger="hover" data-container="body" data-placement="top" type="button" data-html="true"  id="{{ $product->product_id }}" class="mprice{{$product->product_id}}">{{number_format($first_price->price/100,2, '.', '')}}</span></td>
							<td class="text-center" style="{{$style}}" title='{{$chtitle}}'>
								<input style="width: 20px;  height: 20px;" title='{{$chtitle}}' type="checkbox" class="invoice_selected" value="{{$product->product_id}}" rel="{{$product->product_id}}" trel="{{$product->product_id}}" {{$chdisabled}} merrel="{{$product->responder}}">
							</td>
							<?php $i++; ?>
							<?php } ?>
						</tr>
						@endforeach
						@endif							
					</tbody>
				</table>
			</div>
		</div>
	</div>
</section>
<input type="hidden" id="selluser" value="{{$selluser->id}}" />
<script type="text/javascript" src="{{url('js/bootstrap-number-input-orderview.js')}}"></script>
<script src={{asset("https://cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js")}}></script>
<script type="text/javascript">
	$(document).ready(function () {
		$("[data-toggle=popover]").popover({
			html: true,
			content: function() {
				id = $(this).attr('id');
				return $('#price-'+id).html();
			}
		});			
			//$('.tablet').tooltip();
			function number_format2(number, decimals, dec_point, thousands_sep)
			{
				number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
				var n = !isFinite(+number) ? 0 : +number,
				prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
				sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
				dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
				s = '',
				toFixedFix = function (n, prec) {
					var k = Math.pow(10, prec);
					return '' + (Math.round(n * k) / k).toFixed(prec);
				};
				// Fix for IE parseFloat(0.55).toFixed(0) = 0;
				s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
				if (s[0].length > 3) {
					s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
				}
				if ((s[1] || '')
					.length < prec) {
					s[1] = s[1] || '';
				s[1] += new Array(prec - s[1].length + 1).join('0');
			}
			return s.join(dec);
		}				

		$('.pricesn').bootstrapNumber();
		/*	$('.pricesn').change(function (e) {				
				var rel = $(this).attr("rel");
			});*/
			
			$('.cart-link').click(function (e) {
				var user_id = $("#selluser").val();
				$(".cart-link").html("Loading...");
				$.ajax({
					url: JS_BASE_URL + "/purchase_order/" + user_id,
					type: "GET",
					async: false,
					success: function (data) {
						$("#purchasebody").html(data);
						$("#Modal").modal('show');
						$(".cart-link").html("View POs");
					//	
				}
			});				

			});
			
			$('.add-invoicebtn').click(function (e) {
				console.log("AAAA");
				var thisbtn = $(this);
				var cont = 0;
				thisbtn.attr("disabled", true);
				var jsonData = {};
				$('.invoice_selected').each(function() {
					if (this.checked) {
						var merrel = $(this).attr('merrel');
						var prodid = $(this).attr('rel');
						var tdid = $(this).attr('trel');
						var qty = $("#qty" + prodid).val();
						var price = $(".mprice" + prodid).text();
						if(!jsonData.hasOwnProperty($(this).attr('merrel'))){
							jsonData[merrel] = [{ id : tdid, qty:  qty, price: parseFloat(price)*100}];
						} else {
							jsonData[merrel].push(
								{id: tdid, qty:  qty, price: parseFloat(price)*100}
								);
						}
						cont++;
					}
				});
				console.log(jsonData);
				if(cont == 0){
					toastr.warning("No term product selected!");
					thisbtn.attr("disabled", false);
					
				} else {
					$.ajax({
						url: JS_BASE_URL + "/add_invoices",
						type: "post",
						data: {json: jsonData},
						dataType: 'json',
						async: false,
						success: function (data) {
							console.log(data);
							if(data.response == "OK"){
								toastr.info("item(s) added into view P.O");
							//	var purorders = parseInt($("#purorders").val());
							//	purorders++;
							$("#badgeqty").html(data.purorders);
							$("#badgelink").html("View POs");
								//location.reload();
							}
							if(data.response == "WARN"){
								toastr.warning("You are exceeding your credit balance!");
							}
							if(data.response == "ERROR"){
								toastr.warning("You can't buy with this account!");
							}
							thisbtn.attr("disabled", false);
						//	
					}
				});
				}
				
			});
			
			$('.add-btn').click(function (e) {
			//	$(this).html("Adding...");
			$(this).attr("disabled", true);
			path = window.location.href;
			var url;
			if (path.includes('public'))
			{
				url = '/openSupermall/public/cart/addtocart';
			}
			else {
				url = '/cart/addtocart';
			}	
			$('.product_selected').each(function() {	
				if (this.checked) {
					console.log("HOLA");
					var rel = $(this).attr("rel");
					console.log(rel);
					var qty = $("#qty" + rel).val();
					var price = $(".mprice" + rel).text();
					$.ajax({
						url: url,
						type: "post",
						data: {
							'quantity': qty,
							'delivery_price': 0,
							'id': rel,
							'price': (parseFloat(price)/parseInt(qty))*100,
							'page': 'b2b'
						},
						async: false,
						success: function (data) {
							console.log(data);
						}
					});
				}
			});	
			toastr.info("Products successfully added to cart");
			location.reload();
		});
			
			$('#order_view_list_table').dataTable({
				"order": [],
				"scrollX": false,
			});
		});
	</script>
	<br><br>

	@endsection
