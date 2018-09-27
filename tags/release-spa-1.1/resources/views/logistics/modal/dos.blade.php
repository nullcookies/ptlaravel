<?php
use App\Http\Controllers\IdController;
?>
<?php $i=1;?>
<table class="table bordered" width="100%" id="dos_details">
	<thead style="background-color: #6D9370;color: white;">
		<tr>
			<th class="text-center">No</th>
			<th class="text-center">DeliveryOrder&nbsp;ID</th>
			<th class="text-center">Total</th>
		</tr>
	</thead>
	<tbody>
		@foreach($dos as $do)
		<tr>
			<td class="text-center">{{$i}}</td>
			<td class="text-center"><a target="_blank"  href="{{route('deliverorder', ['id' => $do->porder_id])}}">{{IdController::nO($do->porder_id)}}</a></td>
			<td class="text-center">{{number_format($do->total_delivery/100,2)}}</td>
		</tr>
		<?php $i++;?>
		@endforeach
	</tbody>
</table>
<script type="text/javascript">
	$(document).ready(function(){
		var table = $('#dos_details').DataTable({
			"order": [],
			"scrollX": true,
			"columnDefs": [
				{"targets": "no-sort", "orderable": false},
			],
			"fixedColumns": {
				"leftColumns": 2
			}
		});		
	});
</script>	