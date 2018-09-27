@extends('common.default')
@section('content')
<div class="container">
<div class="table-responsive">
	<h2>Outlet <small>Station ID: {{$st_id}}</small></h2>
	<table class="table table-bordered" cellspacing="0" width="1500px" id="admin-master-outlet-table">
	<thead>
		 <tr style="background-color: #4E2E28; color: #fff;">
			<th class="text-center no-sort">No</th>
			<th class="text-center ">Outlet</th>
			<th class="text-center">Shop&nbsp;Size</th>
			<th class="text-center ">Business&nbsp;Name</th>
			<th class="text-center ">Owner</th>
			<th class="text-center ">Contact</th>
			<th class="text-center">Outlet&nbsp;Type</th>
			<th class="text-center">Delivery&nbsp;Mode</th>
			<th class="text-center">Address</th>
		</tr>
	</thead>
	<tbody>
		<?php $i=1;?>
		@foreach($outlets as $o)
			<tr>
				<td class="text-center">{{$i}}</td>
				<td class="text-center">{{ucfirst($o->outlet_name)}}</td>
				<td class="text-center">{{$o->shop_size}}</td>
				<td class="text-center">{{ucfirst($o->biz_name)}}</td>
				<td class="text-center">{{ucfirst($o->prop_owner_first_name)." ".ucfirst($o->prop_owner_last_name)}}</td>
				<td class="text-center">{{$o->prop_owner_contact}}</td>
				<td class="text-center">{{''}}</td>
				<td class="text-center">{{ucfirst($o->delivery_mode)}}</td>
				<td class="text-center">
					{{$o->line1}}
					@if($o->line2 != "")
						, {{$o->line1}}
					@endif
					, {{$o->cityname}}, {{$o->statename}}, Malaysia
				</td>
			</tr>
			<?php $i++;?>
		@endforeach
	</tbody>
	</table>
</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$('#admin-master-outlet-table').dataTable({
					"order": [],
					'scrollX':true,
            "columnDefs": [{
                "targets": 'no-sort',
                "orderable": false,
				
            },{ "targets": "large", "width": "120px" },{ "targets": "xlarge", "width": "300px" }],
            "fixedColumns":  true
		});

	});
</script>
@stop