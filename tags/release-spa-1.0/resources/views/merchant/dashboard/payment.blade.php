<?php
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\IdController;
use App\Classes;
?>
<div class="table-responsive-removed "> <!-- col-sm-12 -->
<h2>Payment</h2>
<br>
<table style="width:100%"
	class="table text-muted table-bordered counter_table"
	id="payment_detail_products">
	<thead>
	<tr class="bg-info">
		<th class="text-center col-md-4"
			style="vertical-align:middle"
			colspan="4">Payment Details</th>
		<th class="text-center col-md-2"
			style="vertical-align:middle"
			colspan="2">Commission&nbsp;Receivable</th>
		<th class="text-center col-md-2"
			style="vertical-align:middle"
			colspan="2">Payment&nbsp;Gateway</th>
		<th class="text-center col-md-3"
			style="vertical-align:middle"
			colspan="3">Logistics</th>
	</tr>
 {{--    <tr class="bg-info">
	<th colspan="8">Product Details</th>
	<th colspan="2">Time Details</th>
	<th></th>
	</tr> --}}
	<tr class="bg-info">
		<th class='text-center'>No</th>
		{{-- <th class='text-center'>Date</th> --}}
		<th class='text-center'>Order&nbsp;ID</th>
		{{-- <th>Product ID</th> --}}
		<th class='text-center'>Sales</th>
		<th class='text-center'>%</th>
		<th class='text-center'>{{$currentCurrency}}</th>
		<th class='text-center'>%</th>
		<th class='text-center'>{{$currentCurrency}}</th>
		<th class='text-center'>Outstanding</th>
		<th class='text-center' bgcolor="red">Payment</th>
		<th class='text-center'>Due&nbsp;Date</th>
		<th class='text-center'>Date&nbsp;Received&nbsp;</th>
		{{-- <th>Note</th> --}}
	</tr>
	</thead>
	<tbody>
	@if(! empty($orders))
	<?php $i = 0; ?>
	@foreach($orders as $order )
		<tr>
			<td class='text-center'></td>
			{{-- <td>

			{{UtilityController::s_date($order['payment']->created_at)}}
			</td> --}}
			<td>
				@def $order_id = $order['oid']
				@if(isset($order_id))
				<a href='#' class='clickable order_id' data-val="{{ route('Receipt', $order_id) }}"> {{ IdController::nO($order_id) }}
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
			<td class='text-center'><input type="checkbox" /></td>
			<td>
				@def $due_date = $orders[$i]['due_date']
				{{ $due_date }}
			</td>
			<td >
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
