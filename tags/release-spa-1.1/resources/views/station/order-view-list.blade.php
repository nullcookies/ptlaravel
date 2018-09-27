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

    <section class="">
        <div class="container"><!--Begin main cotainer-->
			<div class="row" style="margin-top: 10px;">
                <div class="col-sm-6">
					<h2 class="heading">Procurement List: Payment Gateway</h2>
                </div>
				<div class="col-sm-6"> 						
				<?php
						
							if($products > 0){
								$addtile = "There are " . $products ." products to add";
							} else {
								$addtile = "There are no products to add";
							}
						?>				
					@if(Auth::user()->hasRole('adm'))

						<a href="{{route('admininventory-add',['uid'=> $selluser->id])}}" target="_blank" title="{{$addtile}}" class="btn btn-info pull-right badge1" style="margin-bottom: 25px;" @if($products > 0) data-badge="{{$products}}" @endif > Add New Product </a>
					@else
						<a href="{{route('inventory-add')}}" target="_blank" @if($products > 0) data-badge="{{$products}}" @endif class="btn btn-info pull-right badge1" title="{{$addtile}}" style="margin-bottom: 25px;" > Add New Product </a>
					@endif
					</div>
				<br>			
			</div>
            <div class="row">
                <div class="table-responsive" style="padding-left:15px">
                    <table class="table table-bordered" id="order_view_list_table" width="100%">
                        <thead>
                        <tr style="background-color: #202020; color: #fff;">
                            <th width="20px" class="text-center">No</th>
                            <th width="40px" class="text-center">Product&nbsp;ID</th>
                            <th width="180px">Product&nbsp;Name</th>
                            <th width="60px;" class="text-center">Qty</th>
                            <th width="120px;" class="text-center">Price</th>
                            <th width="80px" class="text-center">Select</th>

                        </tr>
                        </thead>
						@if(!is_null($orders))
							<tfoot>
								<tr>
									<th colspan="5" rowspan="1"></th>
									<th colspan="1" rowspan="1" class="text-center">
									<button class="btn-subcatn add-btn">
									<img src="{{asset('images/shopping_cart_button.png')}}"
									alt="Add to Cart"
									style="width:50px;height:40px;">
									</button>
									</th>
								</tr>
							</tfoot>	
						@endif
                        <tbody>
						<?php $i = 1; ?>
							@if(!is_null($orders))
								@foreach($orders as $product)
									 <?php 
										 $chdisabled = "";
										 $htitle = "";
										 $style = "";
										 $islow = App\Models\POrder::isLowItem($selluser->id, $product->parent_id);
										 if($islow > 0){
											$htitle = "Stock is low!";
											$style .= " background-color: #ffb366;"; 
										 }
										/* if(is_null($product->credit_limit) || is_null($product->tid) || is_null($product->tokenqty) || is_null($product->sellerfacilityid)){
											 $chdisabled = "disabled";
											 $chtitle = "No term available for this product";												 
											 $style .= " background-color: #efefef;";												 
										 } else {
											 if($facilityadmin >= $product->tokenqty){
												 $chdisabled = "disabled";
												$chtitle = "No term available for this product";												 
												$style .= " background-color: #efefef;";
											 }
										 }*/
									 ?>							
									<tr style="{{$style}}" title="{{$htitle}}">
										<td class="text-center" style="vertical-align:middle;">{{$i}}</td>
										<td class="text-center" style="vertical-align:middle;"><a href="{{URL::to('/')}}/productconsumer/{{$product->parent_id}}" target="_blank" data-id="{{$product->parent_id }}">{{IdController::nP($product->product_id)}}</a></td>
										<?php 
											$pname = $product->name;
											if(strlen($pname) > 20){
												$pname = substr($pname, 0 , 17);
												$pname .= "...";
											}
										?>										
										<td class="text-left" style="vertical-align:middle;"><img src="{{asset('/')}}images/product/{{$product->parent_id}}/{{$product->photo_1}}" width="30" height="30" style="padding-top:0;margin-top:4px"><span style="vertical-align: middle;">{{$pname}}</td>
										<td class="text-center" style="vertical-align:middle;"><input name="price[]" rel="{{$product->product_id}}" id="qty{{$product->product_id}}" class="form-control pricesn" type="number" value="1" min="1" max="{{$product->available}}" /></td>
										<?php 
											$first_price = DB::table('productdealer')->where('product_id', $product->product_id)->where('dealer_id', $selluser->id)->orderBy('special_price','DESC')->select("special_funit as funit", "special_unit as unit", "special_price as price")->first();
											if(!is_null($first_price)){
												$all_price = DB::table('productdealer')->where('product_id', $product->product_id)->where('dealer_id', $selluser->id)->orderBy('special_price','DESC')->select("special_funit as funit","special_unit as unit", "special_price as price")->get();
											} else {
												$first_price = DB::table('wholesale')->where('product_id', $product->product_id)->orderBy('price','DESC')->first();
												$all_price = DB::table('wholesale')->where('product_id', $product->product_id)->orderBy('price','DESC')->get();
											}
											$counter = 1;
											$all_wholesalescounter = count($all_price);
											$wtitle = "";
										?>
										<td class="text-center tablet" style="vertical-align:middle;">
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
																			<span> > {{ $wholesale->funit }} </span>
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
																		<span> {{$currentCurrency}} </span>
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
										
										{{$currentCurrency}} <span tabindex="0"  data-toggle="popover" data-trigger="hover" data-container="body" data-placement="top" type="button" data-html="true"  id="{{ $product->product_id }}" class="mprice{{$product->product_id}}">{{number_format($first_price->price/100,2, '.', '')}}</span></td>
										<td class="text-center" style="vertical-align:middle;"><input style="width: 20px;  height: 20px;" type="checkbox" class="product_selected" value="{{$product->product_id}}" rel="{{$product->product_id}}"></td>
										<?php $i++; ?>
									</tr>
								@endforeach
							@endif						
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

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
			
			$('.add-invoicebtn').click(function (e) {
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
						async: false,
						success: function (data) {
							console.log(data);
							toastr.info("Invoice(s) successfully created!");
							thisbtn.attr("disabled", false);
							location.reload();
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

            });
        });
    </script>
	<br><br>

@endsection
