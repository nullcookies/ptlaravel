<?php use App\Http\Controllers\IdController;?>
<div class="table-responsive col-sm-12 ">
	<h2>OpenWish</h2>
	<br>
	<table class="table table-bordered text-muted counter_table" id="open_wish_table" width="1200px">
		<thead>
		<tr class="bg-yellow" style="color: #000;">
			<th colspan="5">Product Details</th>
			<th colspan="2">Time Detail</th>
			<th colspan="5">Payment Detail</th>
		</tr>
		<tr class="bg-yellow" style="color: #000;">
			<th class="textCenter">No</th>
			<th class="textCenter">OpenWish&nbsp;ID</th>
			<th class="textCenter">Product&nbsp;ID</th>
			<th class="textCenter">Date&nbsp;Started</th>
			<th class="textRight">Price</th>
			<th class="textCenter">Time</th>
			<th class="textCenter">Time&nbsp;Left</th>
			<th class="textRight">Pledge</th>
			<th class="textRight">Balance</th>
			<th class="textCenter">Status</th>
			<th class="ttextRight">Merchant Help</th>
			<th></th>
		</tr>
		</thead>
		<tbody>
		@if(isset($openwish))
			<?php $i=1; ?>
			@foreach($openwish as $o)
				<?php $product_id = $o->product_id;
				$ow_id = $o->id;
				?>
				<tr>
					<td class="textCenter"></td>
					<td class="textCenter">{{' ['.sprintf('%010d', $o->id).']  '}}</td>
					<td class="textCenter">{{IdController::nP( $o->product_id)}}</td>
					<td class="textCenter">{{\Carbon\Carbon::parse($o->created_at)->format("dMy h:m:s")}}</td>
					<td class="textRight">{{$currency_code .' '.number_format(($o->retail_price / 100) , 2,'.',',')}}</td>
					<td class="textCenter">{{$o->duration}} Days</td>
					{{-- Time Left --}}
					<?php
					$current_date = Carbon::now();
					$created_at = \Carbon\Carbon::parse($o->created_at);
					$days_left = abs($current_date->day - $created_at->day + $o->duration)."d ";
					$hour_left = abs($current_date->hour - $created_at->hour)."h ";
					$minute_left = abs($current_date->minute - $created_at->minute)."m ";
					$help = abs($o->pledged_amt / 100 - $o->retail_price / 100);
					?>
					<td class="textCenter">{{$days_left.$hour_left.$minute_left}}</td>
					<td class="textRight">{{$currency_code .' '.number_format(($o->pledged_amt / 100) , 2,'.',',')}}</td>
					<td class="textRight">{{$currency_code .' '.number_format((($o->retail_price-$o->pledged_amt) / 100) , 2,'.',',')}}</td>
					<td class="textCenter">{{ucfirst($o->status)}}</td>
					<td class="textRight">{{$currency_code.' '.number_format($help, 2,'.',',')}}</td>
					<td class="textCenter">
						<a onclick='addToCart({{$product_id}}{{','}}{{$ow_id}} {{','}}{{$help}})'><span class="badge badge-help" style="background: #00FF01;">Pay</span></a>
						{{--<a onclick="$(this).parent().parent().remove();" class="pull-right"><i class="glyphicon glyphicon-remove text-danger"></i></a>--}}
					</td>
				</tr>
				<?php $i++;?>
			@endforeach

		@endif
		</tbody>
	</table>
</div>