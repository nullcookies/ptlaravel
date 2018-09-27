<?php
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\IdController;
?>
	<h2>Payment Details</h2>
	<br>
<div class="table-responsive col-sm-12 ">
	<table class="table text-muted table-bordered" id="payment_detail_products" width="1160px">
		<thead>
		<tr class="bg-info">
			<th colspan="4">Payment Details</th>
			<th colspan="2">Commission Receivable</th>
			<th colspan="2">Payment Gateway</th>
			<th colspan="3">Logistics</th>
		</tr>
		<tr class="bg-info">
			<th class='text-center bsmall'>No</th>
			<th class='text-center bmedium'>Order ID</th>
			<th class='text-center bmedium'>Sales</th>
			<th class='text-center bsmall'>%</th>
			<th class='text-center bmedium'>{{$currentCurrency}}</th>
			<th class='text-center bsmall'>%</th>
			<th class='text-center bmedium'>{{$currentCurrency}}</th>
			<th class='text-center bmedium'>Outstanding</th>
			<th class='text-center blarge'>Due Date</th>
			<th class='text-center blarge'>Date Received</th>
		</tr>
		</thead>
		<tbody>
		@if(! empty($orders))
		<?php $i = 0; ?>
		@foreach($orders as $order )
			<tr>
				<td class='text-center'></td>
				{{-- <td>

				{{ UtilityController::s_date($order['payment']->created_at) }}
				</td> --}}
				<td>
					@def $order_id = $order['oid']
					@if(isset($order_id))
					<a class='clickable order_id' data-val="{{ route('deliverorder', $order_id) }}"> {{ IdController::nO($order_id) }}
					</a>
					@endif
				</td>
				{{-- <td>{{$order['sku']}}</td> --}}
				<td class='streched'>
					<span class='pull-left'>
					{{ $currency_code }}
					</span>
					<span class='pull-right'>
						@def $y = $order['payment']->receivable
						@if(isset($y))
						{{ number_format($y/100,2) }}
						@endif
					 </span>
				</td>
				<td>
					@def $x = (($order['comm']* $order['payment']->receivable)/$order['payment']->receivable)*100
					@if(isset($x))
					{{ $x/100 }}%
					@endif
				</td>
				<td class='streched'>
					<span class='pull-left'> {{ $currency_code }} </span>
					<span class='pull-right'>
						@def $rec = ($order['comm']* $order['payment']->receivable)/100
						@if(isset($rec))
						{{ number_format($rec/100,2) }}
						@endif
					</span>
				</td>
				<td>
				@if(isset($bank))
				{{$bank}}%
				@endif
				</td>
				<?php $b_com= ($bank/100)*$order['payment']->receivable;?>
				<td  style="min-width:100px">
					<span class='pull-left'> {{ $currency_code }} </span>
					<span class='pull-right'>
						@if(isset($b_com))
						{{ number_format($b_com/100,2) }}
						@endif
					</span>
				</td>
				<td class='streched'>
					<span class='pull-left'> {{ $currency_code }} </span>
					<span class='pull-right'>
						@def $rec_bcom = ($y-$rec-$b_com)
						@if(isset($rec_bcom))
						{{ number_format($rec_bcom/100,2) }}
						@endif
					</span>
				</td>
				<td>
					@def $due_date = $orders[$i]['due_date']
					{{ $due_date }}
				</td>
				<td>
					@def $rcv_date = $orders[$i]['rcv_date']
					{{ $rcv_date }}
				</td>
				{{-- <td>{{$order['payment']->note}}</td> --}}
			</tr>
		<?php $i++; ?>
		@endforeach
		@endif
		</tbody>

	</table>

</div>