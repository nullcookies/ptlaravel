@extends("emails.common.layout")
<?php use App\Http\Controllers\UtilityController; ?>
@section("content")
<div class="container"><!--Begin main cotainer-->
	<div class="row">
	<table>
		<tr>
			<td align="center";></td>	
		</tr>
	</table>
		<div class="col-sm-11 col-sm-offset-1">
		   

			<div class="col-sm-12 form-horizontal" style="margin: 2% 0;">
				@if(isset($deliveryorder))

		   <div class="col-sm-12">
				<div class="row">
					<div class="col-sm-4 col-sm-offset-4 text-center">
					<b>Merchant Name</b></div>
					<?php
						//$hashed_password = crypt('mypassword');
						//$crypt_pass = crypt($array_delivery[0]['password'], $hashed_password);
						//$password = substr($crypt_pass, 0, 8);
						$password = $array_delivery[0]['password'];
					?>
					<div class="col-sm-4 text-right">
					<b>{{$password or 'No password found'}}</b></div>
					<div class="col-sm-4 col-sm-offset-4 text-center">
					{{$array_delivery[0]['user_address']}}</div>
					<div class="col-sm-4 col-sm-offset-4 text-center">
					{{$array_delivery[0]['line2']}}</div>
					<div class="col-sm-4 col-sm-offset-4 text-center">
					{{$array_delivery[0]['line3']}}</div>
				</div>
			</div>
				@endif

		   <div class="col-sm-12">
				<div class="row">
					<div class="col-sm-4 col-sm-offset-4 text-center"
					style="font-size: 20px;"><br><b>Tax Invoice</b></div>
				</div>
		   </div>
		   <div class="col-sm-12">
				<div class="row">
					<div class="col-sm-4"><b>Date: </b>
					<?php echo date('d-F-Y h:i:s'); ?></div>
					<div class="col-sm-4 text-center">
					GST Reg. No: {{$array_delivery[0]['merchant_gst']}}</div>
				</div>
		   </div>
		   <div class="col-sm-12">
				<div class="row" >
					<div class="col-sm-6" style="padding-bottom: 10px;">
						<div class="" style="">
							<br>
							Invoice No: {{$array_delivery[0]['merchant_gst']}} - {{$array_delivery[0]['invoice_no']}}
						</div>
					</div>
					<div class="col-sm-6 pull-right" >

					</div>
			   </div>
		   </div>

		   <div class="col-sm-12">
			<table class="table">
				<tr style="border-bottom: 1px solid #ddd;background:#666666;color:#ffffff;">
					<th>No</th>
					<th>Product ID</th>
					<th>Description</th>
					<th>Qty</th>
					<th>Unit Price</th>
					<th style="text-align:right;">Amount</th>
				</tr>
				<?php $counter =1; $sum_qty = 0; $sum_amount = 0;?>
				@if(isset($deliveryorder))
				@foreach($deliveryorder as $dos)
					@foreach($dos->products as $product)
				<tr>
					<td>{{ $counter++ }}</td>
					<td>{{ UtilityController::s_id($product->product->id) }}</td>
					<td>{{ $product->product->name }}</td>
					<td>{{ $product->quantity or 0 }}</td>
					<td>
					<?php
					$revenue = number_format(($product->product->retail_price/100),2);
					$amount = number_format((($product->quantity * $product->product->retail_price)/100),2);
					$sum_qty += $product->quantity;
					$sum_amount += $amount;
					$sum_amount = number_format($sum_amount, 2, '.', '');
					?>
					{{$currency}} {{$revenue}}
					</td>
					<td style="text-align:right;">{{$currency}} {{ $amount }}</td>
					<!-- <td><input type="checkbox" value="{{ $product->id }}"></td> -->
				</tr>
					@endforeach
				@endforeach
				<tr style="border-bottom: 1px solid #ddd;border-top: 1px solid #ddd;">
					<td></td>
					<td></td>
					<td></td>
					<td>{{ $sum_qty }}</td>
					<td></td>
					<?php
						$aux = ($sum_amount*6)/100;
						$total = $aux + $sum_amount;
					?>
					<td style="text-align:right;"><b>Total {{$currency}} {{ $total }}</b></td>
				</tr>
				@endif
			</table>
			</div>
			<div class="col-sm-12 text-right" style="padding-bottom: 20px;">
				<table style="float:right;text-align:right;">
					<tr>
						<td style="padding-right: 10px">Total includes {{$gst[0]->gst_rate}}% GST</td>
						<td>{{$currency}} {{$aux}}</td>
					</tr>
					<tr>
						<td style="padding-right: 10px">Items Total</td>
						<td>{{$currency}} {{ $sum_amount }}</td>
					</tr>
				</table>
			</div>
			<div class="col-sm-12 text-right" style="padding-bottom: 20px;">
				<input type="submit" class="btn btn-green" style="font-size: 1.30em;" value="Back To Main Page"/>
			</div>
		</div>
	</div>
</div><!--Begin main cotainer-->

<style>
	.table>tbody>tr>td{
		border-top: 0px solid #ddd;
	}
</style>
<script type="text/javascript">
	function processdelivery()
	{
		var items = [];
		$("input:checkbox:checked").each(function(){
			items.push($(this).attr('value'));
		});
		jQuery.ajax({
			type: "POST",
			url: "{{ url('deliveryorder/process')}}",
			data: { items:items,deliveryid:$('#deliveryid').text(),password:$('#orderpassworld').val() },
			beforeSend: function(){},
			success: function(response){
				console.log(response);
				if(response == 1)
					window.location.assign("{{ url('/') }}");
				else
					alert('Password does not match');
			}
		});
	}
</script>

@stop



