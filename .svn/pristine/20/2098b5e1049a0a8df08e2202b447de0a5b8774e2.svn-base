@if(count($productDetail) > 0)
<div class="row">
	<div class="col-md-12" style="margin-bottom:10px">
		<div class="col-md-2">
	   		<img src="/images/product/{{$productDetail->id}}/thumb/{{$productDetail->thumb_photo}}" style="height:50px;width:50px;vertical-align: middle;">
		</div>
		<div class="col-md-10">
			<h4 class="text-left"><a target="_blank" href="{{ route('productconsumer', $productDetail['id']) }}">{{ $productDetail->name }}</a></h4>
		</div>
	</div>
</div>
@endif

<table id="raw-datatable" class="table table-bordered" style="width:100%">
	<thead>
		<tr>
		    <td scope="col" class="bg-primaryorange">No</td>
		    <td scope="col" class="bg-primaryorange">Raw Material ID</td>
		    <td scope="col" class="bg-primaryorange">Raw Material</td>
		    <td scope="col" class="bg-primaryorange">Qty</td>
		</tr>
	</thead>
	<tbody id="new-terminal">
	<?php $index = 0;?>
	@if(count($rawMaterials) > 0)
	@foreach($rawMaterials as $rawMaterial)
		<tr>
		    <td class="text-center">{{++$index}}</td>
		    <td class="text-center">{{$rawMaterial->raw_product_id}}</td>
		    <td class="text-center">{{$rawMaterial->name}}</td>
		    <td class="text-center">{{$rawMaterial->raw_qty}}</td>
		</tr>
	@endforeach
	@endif
	</tbody>
</table>


<script>
    $(document).ready(function() {
		$('#raw-datatable').DataTable();
    });
</script>