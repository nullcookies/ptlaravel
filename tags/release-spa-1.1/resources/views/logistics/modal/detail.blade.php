<?php $i=1;?>
<table class="table bordered" width="100%">
	<thead>
		<tr>
			<th>No.</th>
			<th>Weight</th>
			<th>Height</th>
			<th>Width</th>
			<th>Length</th>
			
		</tr>
	</thead>
	<tbody>
	@if(isset($dimension))
		@foreach($dimension as $p)
		<tr>
			<td>{{$i}}</td>
			<td>{{$p->weight}}</td>
			<td>{{$p->height}}</td>
			<td>{{$p->width}}</td>
			<td>{{$p->length}}</td>
		
		{{-- 	<td>{{$p->}}</td>
			<td>{{$p->}}</td> --}}
		</tr>
		<?php $i++;?>
		@endforeach
	@else
	<tr>Nothing to show ...</tr>
	@endif
	</tbody>
</table>