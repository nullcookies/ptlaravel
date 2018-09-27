@extends('common.default')
<?php use App\Http\Controllers\IdController; ?>
@section('content')
<div class="container">
	<h2>Open Que <small>Station ID: {{IdController::nS($st_id)}}</small></h2>
	<table class="table table-bordered" cellspacing="0" width="100%" id="admin-master-outlet-table">
	<thead>
		<tr style="background-color: #4E2E28; color: #fff;">
			<th colspan="4">OpenQue Analysis</th>
			<th colspan="2">Que Type: Bank</th>
			<th colspan="2" class="text-centre">Company: Mayback</th>
		</tr>
		 <tr style="background-color: #4E2E28; color: #fff;">
			<th class="text-center no-sort">No</th>
			<th class="text-center">Outlet</th>
			<th class="text-center">Que Number Since</th>
			<th class="text-center">Revenue Since</th>
			<th class="text-center">Que Number YTD</th>
			<th class="text-center">Revenue YTD</th>
			<th class="text-center">Que Number/day</th>
			<th class="text-center">Revenue/day</th>
		</tr>
	</thead>
	<tbody>
		<?php $i=1;?>
		@foreach($oqueues as $o)
			<tr>
				<td class="text-center">{{$i}}</td>
				<td class="text-center">{{ucfirst($o->outlet_name)}}</td>
				<td class="text-center">{{$o->shop_size}}</td>
				<td class="text-center">{{ucfirst($o->biz_name)}}</td>
				<td class="text-center">{{ucfirst($o->biz_owner_first_name)." ".ucfirst($o->biz_owner_last_name)}}</td>
				<td class="text-center">{{$o->prop_owner_contact}}</td>
				<td class="text-center">{{''}}</td>
				<td class="text-center">{{ucfirst($o->delivery_mode)}}</td>
			</tr>
			<?php $i++;?>
		@endforeach
	</tbody>
	</table>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$('#admin-master-outlet-table').dataTable({
					"order": [],
            "columnDefs": [{
                "targets": 'no-sort',
                "orderable": false,
            },{ "targets": "large", "width": "120px" },{ "targets": "xlarge", "width": "300px" }],
            "fixedColumns":  true
		});
	});
</script>
@stop