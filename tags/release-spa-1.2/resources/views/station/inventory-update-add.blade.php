<?php
use App\Classes;
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\IdController;
?>
@extends('common.default')
@section('extra-links')
{{--  <link rel="stylesheet" type="text/css" href="{{asset('css/inventory/inventory.css')}}"> --}}
<script>
	var categoryNameTab='';



function showSubCategory(catId,categoryName){
$(document).ready(function(){
	//var x= $("div[class^='catId_']").html();
	categoryNameTab=categoryName.toUpperCase();
	$("#catSubCatNameTab").text(categoryName.toUpperCase());
	if($(".catId_"+catId).html()==undefined){
		$("#noSubCat").show();
	}else{
		$("#noSubCat").hide();
	}
	$("div[class^='catId_']").hide();
	$(".catId_"+catId).show();
	$("#subcatbox").show();
	$("#productbox").hide();
	$(".pinclass").hide();
	$("#psubcatbox").hide();
});
}
</script>

@stop
@section('content')
@include("common.sellermenu")
{{-- NEW CODE --}}
<div class="container">
	<span id="top"></span>
	<div class="col-xs-12">
	{!! Breadcrumbs::renderIfExists() !!}
	<div class="row">
		<br>
		<h2 style="display:inline; ">Procurement: Add Product</h2>
		<br> <br>
                <div class="table-responsive">
                    <table width="99%"
						class="table table-striped table-bordered"
						id="order_view_list_table">
                        <thead>
                        <tr style="background-color: #444; color: #fff;">
                            <th bgcolor="#303030" style="color:white"
								width="20px" data-orderable="false"
								class="text-center">No.</th>
                            <th bgcolor="#303030" style="color:white"
								width="40px" class="text-center">Product&nbsp;ID</th>
                            <th bgcolor="#303030" style="color:white">Product&nbsp;Name</th>
                            <th bgcolor="black" style="color:white"
								width="20px" class="text-center">Select</th>

                        </tr>
                        </thead>
						@if(!is_null($products))
							<tfoot>
								<tr>
									<th colspan=3></th>
									<th colspan=1 ><button class='btn btn-block btn-success btn-sm add-btn'>Add Products</button></th>
								</tr>
							</tfoot>	
						@endif
                        <tbody>
						<?php $i = 1; ?>
							@if(!is_null($products))
								@foreach($products as $product)
									<tr>
										<td class="text-center">{{$i}}</td>
										<td class="text-center">{{IdController::nP($product->product_id)}}</td>
										<td class="text-left">{{$product->name}}</td>
										<td class="text-center"><input type="checkbox" class="product_selected" value="{{$product->product_id}}" rel="{{$product->product_id}}" srel="{{$selluser->id}}"></td>
										<?php $i++; ?>
									</tr>
								@endforeach
							@endif
                        </tbody>
                    </table>
                </div>
	</div>
</div>
</div>
<br><br>
{{-- NEW CODE ENDS --}}
{{-- < --}}
<script type="text/javascript" src="{{asset('js/inventory/inventory.js')}}"></script>

<script>
$(document).ready(function () {			
	$('.add-btn').click(function (e) {
		$(this).html("Adding...");
		$(this).attr("disabled", true);
		path = window.location.href;
		var url;
		if (path.includes('public'))
		{
		//	url = '/openSupermall/public/cart/addtocart';
		}
		else {
			url = '/inventory/addproduct';
		}	
		$('.product_selected').each(function() {	
			if (this.checked) {
				var rel = $(this).attr("rel");
				var sid = $(this).attr("srel");
				console.log(rel);
				var qty = $("#qty" + rel).val();
				var price = $(".mprice" + rel).text();
				$.ajax({
						url: url,
						type: "post",
						data: {
							'id': rel,
							'sid': sid
						},
						async: false,
						success: function (data) {
							console.log(data);
						}
				});
			}
		});	
		toastr.info("Products Successfully Added");
		location.reload();
	});
	
	$('#order_view_list_table').dataTable({
		"order": [],
		"scrollx": true,
		"columndefs": [
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
@stop



