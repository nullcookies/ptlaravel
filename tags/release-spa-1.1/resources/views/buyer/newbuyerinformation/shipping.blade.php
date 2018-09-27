<?php
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\IdController;
use App\Classes;
?>
<div class="table-responsive col-sm-12">
<h2>Delivery Details</h2>
	<table  class="table table-bordered" id="shipping_details_table">
		<thead>
			<tr style="background-color:rgb(64,49,82); color: white;">
				<td class="no-sort">No.</td>
				<td>Order&nbsp;ID</td>
				<th>Merchant&nbsp;ID</th>
				<td>External&nbsp;Delivery&nbsp;ID</td>
				<td>Courier&nbsp;Company</td>
				<td>Status</td>
				<td>Days&nbsp;Since&nbsp;Ordered</td>
				<th style="background-color:rgb(41,135,177); color: white;">Date&nbsp;Received</th>
				<th style="background-color:rgb(41,135,177); color: white;">Due&nbsp;Date</th>
			</tr>
		</thead>
		<?php $i=1;?>
		<tbody>
			@if(isset($shipping))
				@foreach($shipping as $sh)
					<tr>
						<td style="text-align: center;">{{$i}}</td>
						<td style="text-align: center;"><a href="{{route('deliverorder', ['id' => $sh['id']])}}" class="uniqporder" id="uniqporder" data="{{$sh['id']}}">{{IdController::nO($sh['id'])}}</a>
						</td>
						<td style="text-align: center;"><a href="{{route('merchantPopup', ['id' => $sh['merchant_id']])}}" class="uniqporder" id="uniqporder" data="{{$sh['merchant_id']}}">
						{{IdController::nM($sh['merchant_id'])}}</a>
						</td>
						<td style="text-align: center;">{{UtilityController::s_id($sh['shipping_id'])}}</td>
						<td style="text-align: center;">{{$sh['shipping_company']}}</td>
						<td style="text-align: center;">{{$sh['payment_status']}}</td>
						<td style="text-align: center;">
						<?php
						$date=date_create($sh['created_at']);
						echo date_format($date,"Y-m-d h:i:s");
						?>
						 </td>
						<td style="text-align: center;">
						<?php
						$date=date_create($sh['created_at']);
						echo date_format($date,"Y-m-d h:i:s");
						?>
						</td>
						<td style="text-align: center;">
						<?php
						$date=date_create($sh['created_at']);
						echo date_format($date,"Y-m-d h:i:s");
						?>
						</td>

					</tr>
					<?php $i++; ?>
				@endforeach
			@endif
		</tbody>
	</table>
</div>