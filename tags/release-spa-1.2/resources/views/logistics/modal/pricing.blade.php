<?php $i=1;?>
<table class="table bordered" width="100%" id="pricing_details">
	<thead style="background-color: #6D9370;color: white;" >
		<tr>
			<th>No.</th>
			<th>Weight</th>
			<th>Height</th>
			<th>Width</th>
			<th>Length</th>
			<th>Incremental&nbsp;Price</th>
			<th>Incremental&nbsp;Unit</th>
			<th>Coverage&nbsp;Area</th>
		</tr>
	</thead>
	<tbody>
		@foreach($pricings as $p)
		<tr>
			<td>{{$i}}</td>
			<td>{{$p->weight}}</td>
			<td>{{$p->height}}</td>
			<td>{{$p->width}}</td>
			<td>{{$p->length}}</td>
			<td>{{number_format($p->incremental_price/100,2)}}</td>
			<td>{{$p->incremental_unit}}</td>
			<td>{{$p->coverage_area}}</td>
		{{-- 	<td>{{$p->}}</td>
			<td>{{$p->}}</td> --}}
		</tr>
		<?php $i++;?>
		@endforeach
	</tbody>
</table>
<script type="text/javascript">
	$(document).ready(function(){
		var table = $('#pricing_details').DataTable({
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