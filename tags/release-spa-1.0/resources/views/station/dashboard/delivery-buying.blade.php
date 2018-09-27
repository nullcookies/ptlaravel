<?php
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\IdController;
?>	
<div class="col-sm-12">
	<h2>Buying Delivery</h2>
	<table class="table table-bordered " id="shipping_details_table">
		<thead>
			<tr style="background-color:rgb(64,49,82); color: white;">
				<th class="text-center no-sort">No</th>
				<th class="text-center">Order&nbsp;ID</th>
				<th>Merchant&nbsp;ID</th>
				<th class="text-center">External&nbsp;Shipping&nbsp;ID</th>
				<th class="text-center">Shipping&nbsp;Company</th>
				<th class="text-center">Status</th>
				<th class="text-center">Days&nbsp;Since&nbsp;Ordered</th>
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
						<td style="text-align: center;"><a href="{{route('Receipt', ['id' => $sh['id']])}}" class="uniqporder" id="uniqporder" data="{{$sh['id']}}">{{IdController::nO($sh['id'])}}</a>
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
						<td style="text-align: center;">														<?php
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