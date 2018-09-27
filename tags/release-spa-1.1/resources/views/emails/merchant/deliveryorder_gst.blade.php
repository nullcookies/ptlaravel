<style type="text/css">
	.table-nonfluid {
	   width: 57% !important;
	}
</style>
@extends("common.default")
<?php use App\Http\Controllers\UtilityController; ?>
@section("content")
		<div class="container"><!--Begin main cotainer-->
			<div class="row">
                <div class="col-sm-11 col-sm-offset-1">
               		<div class="col-sm-12">
               			<div class="row">
		                   	<h1 class='title'>Delivery Order</h1>
		                    <hr>
		               </div>
	               </div>

		            <div class="col-sm-12 form-horizontal" style="margin: 2% 0;">
		            	@if(isset($deliveryorder))
		            		@if($deliveryorder->employee != null)
		            			<!-- <div class="col-sm-3">{{ $deliveryorder->employee->users->station->first()->id or '' }}</div> -->
			            	@else
			            	@endif
							<input type="hidden"
								value="{{$deliveryorder->id}}"
								id="deliveryid" />
		           <div class="col-sm-12">
		           		<div class="row">
		           			<div class="col-sm-4 col-sm-offset-4 text-center">
								<b>{{$array_delivery[0]['oshop_name']}}</b></div>
		           			<div class="col-sm-4 col-sm-offset-4 text-center">
								{{$array_delivery[0]['merchant_name']}}</div>

							@if($array_delivery[0]['oshop_address_id'] == 0)
							<div class="col-sm-4 col-sm-offset-4 text-center">
								{{$array_delivery[0]['user_address']}}</div>

							<div class="col-sm-4 col-sm-offset-4 text-center">
								{{$array_delivery[0]['line2']}}</div>

							<div class="col-sm-4 col-sm-offset-4 text-center">
								{{$array_delivery[0]['line3']}}</div>

							@else
							<div class="col-sm-4 col-sm-offset-4 text-center">
								{{$array_delivery[0]['muser_address']}}</div>

							<div class="col-sm-4 col-sm-offset-4 text-center">
								{{$array_delivery[0]['mline2']}}</div>

							<div class="col-sm-4 col-sm-offset-4 text-center">
								{{$array_delivery[0]['mline3']}}</div>
							@endif

						</div>
					</div>
					@endif

		           <div class="col-sm-12">
		           		<div class="row">
		           			<div class="col-sm-4 col-sm-offset-4 text-center"
							style="font-size: 20px;"><br>
							<b>Tax Invoice</b></div>
		           		</div>
		           </div>
		           <div class="col-sm-12">
		           		<div class="row">
		           			<div class="col-sm-4">
							<b>Date: </b>
							<?php echo date('F d, Y'); ?></div>

		           			<div class="col-sm-4 text-center">GST Reg. No:
							{{$array_delivery[0]['merchant_gst']}}</div>
		           		</div>
		           </div>
                   <div class="col-sm-12">
               			<div class="row" >
               				<div class="col-sm-6" style="padding-bottom: 10px;">
		                   		<div class="" style="">

			                   		<b>Tax Invoice No/Order ID:</b>
									[{{ str_pad($deliveryorderid,10,0,
										STR_PAD_LEFT) }}]
		                   		</div>
		                   	</div>

							<div class="col-sm-6 pull-right" >
		                   		<div class="">
			                   		<div class="col-sm-4 col-md-offset-6">
									<div class="row">
										<input type="password" class="form-control"
											name="orderpassworld" id="orderpassworld"
											placeholder="Order Password"/>
									</div></div>
			                   		<div class="col-sm-2">
										<div class="row">
											<input type="submit" id="submitpassword" class="btn btn-green"
											style="font-size: 1.0em; margin-bottom:10px"
											value="Confirm" onclick="processdelivery();"/>
										</div>

			                   		</div>
									<div class="col-sm-6 col-sm-offset-6">
										<p style="color: red; display: none;" id="wrong">
											Wrong password, please try again.</p>
										<p style="color: green; display: none;" id="success">
											Order successfully confirmed!</p>
									</div>
		                   		</div>
		                   	</div>
		               </div>
	               </div>

	               <div class="col-sm-12">

	               		 	<table class="table">
	               		 		<tr style="border-bottom: 1px solid #ddd;background:#666666;color:#ffffff;">
	               		 			<th class="text-center">No</th>
	               		 			<th class="text-center">Product&nbsp;ID</th>
	               		 			<th>Description</th>
	               		 			<th class="text-center">Qty</th>
	               		 			<th class="text-right">Unit&nbsp;Price</th>
	               		 			<th class="text-right">Amount</th>
									<th></th>
	               		 		</tr>
	               		 		<?php $counter =1; $sum_qty = 0;
									$sum_amount = 0;?>

	               		 		@if(isset($deliveryorder))
	               		 		@foreach($deliveryorder->products as $product)
	               		 		<tr>
	               		 			<td class="text-center">{{ $counter++ }}</td>
	               		 			<td class="text-center">{{ UtilityController::s_id($product->product->id) }}</td>
	               		 			<td>{{ $product->product->name }}</td>
	               		 			<td class="text-center">{{ $product->quantity or 0 }}</td>
	               		 			<td class="text-right">
									
	               		 			<?php
									$op = DB::table('orderproduct')->
										where('porder_id',$deliveryorderid)->
										where('product_id',$product->product->id)->
										first();

									if(!is_null($op)){
										$revenue = number_format((($op->order_price + $op->shipping_cost)/100),2);
										$amount = number_format((($op->quantity * ($op->order_price + $op->shipping_cost))/100),2);
									} else {
										$revenue = number_format(($product->product->retail_price/100),2);
										$amount = number_format((($product->quantity * $product->product->retail_price)/100),2);
									}								
									
									$sum_qty += $product->quantity;
									$sum_amount += $amount;
									$sum_amount = number_format($sum_amount, 2, '.', '');
			            			?>
									{{$currency}} {{$revenue}}
									</td>
	               		 			<td class="text-right">{{$currency}} {{ $amount }}</td>
									<?php
										$status = DB::table('deliveryordersproduct')->
											where('product_id',$product->product->id)->
											where('do_id',$deliveryorder->id)->first();

										//dd($product->product->id);
										$checked = "";
										$disabled = "";
										if($status == "b-collected"){
											$checked = "checked";
											$disabled = "disabled";
										}
									?>
	               		 			<td><input type="checkbox" value="{{ $product->id }}"
										{{$checked}} {{$disabled}}></td>
	               		 		</tr>
	               		 		@endforeach
	               		 		<tr style="border-bottom: 1px solid #ddd;border-top: 1px solid #ddd;">
	               		 			<td></td>
	               		 			<td></td>
	               		 			<td></td>
	               		 			<td class="text-center">{{ $sum_qty }}</td>
	               		 			<td></td>
	               		 			<?php
	               		 				$aux = ($sum_amount*6)/100;
	               		 				$total = $aux + $sum_amount;
	               		 			?>
	               		 			<td style="text-align:right;">
										<b>Total {{$currency}}
											{{ number_format($sum_amount,2) }}
										</b></td>
	               		 		</tr>
	               		 		@endif
	               		 	</table>
		            </div>
		            <div class="col-sm-12 text-right" style="padding-bottom: 20px;">
		            	<table style="float:right;text-align:right;">
		            		<tr>
		            			<td style="padding-right: 10px">
									Total includes {{$gst[0]->gst_rate}}% GST</td>
		            			<td>{{$currency}} {{number_format($sum_amount * ($gst[0]->gst_rate/100),2)}}</td>
		            		</tr>
		            		<tr>
		            			<td style="padding-right: 10px">Items Total</td>
		            			<td>{{$currency}} {{ number_format($sum_amount,2) }}</td>
		            		</tr>
		            	</table>
		            </div>
		            <div class="col-sm-12 text-right"
						style="padding-bottom: 20px;">
		            	<input type="submit" class="btn btn-green"
							style="font-size: 1.30em;"
							value="Back To Main Page"/>
		            </div>
                </div>
			</div>

		</div>
	</div><!--Begin main cotainer-->
		<style>
			.table>tbody>tr>td{
				border-top: 0px solid #ddd;
			}
		</style>

@stop
