@extends('common.default')
@section('content')
<?php
use App\Http\Controllers\UtilityController;
 ?>
<div class="container">
	<h2>Details <small>Station ID: {{$st_id}}</small></h2>
	<table class="table table-bordered" cellspacing="0" width="100%" id="admin-master-outlet-table">
	<thead>
	
		 <tr style="background-color: #4E2E28; color: #fff;">
			<th class="text-center no-sort">No</th>
			<th class="text-center">SR ID</th>
			<th class="text-center">SR&nbsp;Name</th>
		</tr>
	</thead>
	<tbody>
		<?php $i=1;?>
		@foreach($strs as $o)
			<tr>
				<td class="text-center">{{$i}}</td>
				<td class="text-center">{{UtilityController::s_id($o->user_id)}}</td>
				<td class="text-center">{{ucfirst($o->first_name." ".$o->last_name)}}</td>

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