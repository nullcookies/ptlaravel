@extends('common.default')
<?php
use App\Http\Controllers\UtilityController;
?>
@section('content')
<style>
label{
	display: inline-block;
	max-width: 100%;
}  
</style>
	<div class="container" style="margin-top:30px;">
	@include('admin.panelHeading')
	<h3>Hyper Master</h3>
	<p class="bg-success success-msg" style="display:none;padding: 15px;"></p>
	<table id="adminmasterhyper" class="table table-bordered" style="width:100%;background-color:#2F4177;color:white;">
		<thead>
			<tr>
				<th class="no-sort text-center">No</th>
				{{-- <th>Product ID</th> --}}
				<th class="text-center">MOQ</th>
				<th class="text-center">MOQ/Location</th>
				<th class="text-center">Price</th>
				<th class="text-center">Discount</th>
				<th class="text-center">Left</th>
				<th class="text-center">Time Left</th>
				<th class="text-center">Due Date</th>
				<th class="text-center">Bought </th>
				<th class="text-center">Status</th>
			</tr>
		</thead>
		<tbody>
			@if(isset($hypers))
				<?php
					$no=1;
				?>
				@foreach($hypers as $h)
					<tr style="color:black;">
						<td>{{$no}}</td>
						{{-- <td>{{UtilityController::s_id($h['product_id'])}}</td> --}}
						<td class="text-center">{{$h['moq']}}</td>
						<td class="text-center">{{$h['moqpax']}}</td>
						<td class="text-right">{{$currentCurrency}}&nbsp{{$h['price']}}</td>
						<td class="text-right">{{number_format($h['discount'],0)."%"}}</td>
						<td class="text-center">{{$h['left']}}</td>
						<td class="text-center">{{$h['time_left']}}</td>
						<td class="text-center"><a href="javacript:void" rel="{{UtilityController::s_date($h['due_date'])}}" drel="{{UtilityController::s_date($h['created_at'])}}">{{UtilityController::s_date($h['due_date'])}}</a></td>
						<td class="text-right">{{$currentCurrency}} {{$h['pledged']}}</td>
						<td>{{ucfirst($h['status'])}}</td>

					</tr>
					<?php $no++; ?>
				@endforeach
			@endif
		</tbody>
	</table>
	</div>
@stop
<script src="{{url('js/jquery.min.js')}}"></script>
<script src="{{url('js/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#adminmasterhyper').DataTable({
			"order": [],
		"scrollX": true,
		"columnDefs": [
			{"targets": "no-sort", "orderable": false},
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