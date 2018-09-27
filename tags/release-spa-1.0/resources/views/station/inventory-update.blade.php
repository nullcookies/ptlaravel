@extends('common.default')
@section('extra-links')
@section('scripts')
	@parent
	<script src="https://cdnjs.cloudflare.com/ajax/libs/hammer.js/2.0.8/hammer.min.js" id="hammer-js-sript" charset="utf-8"></script>
	<script src="https://cdn.jsdelivr.net/jquery.hammerjs/2.0.0/jquery.hammer.js" id="jquery-hammer-js" charset="utf-8"></script>
@endsection
{{--  <link rel="stylesheet" type="text/css" href="{{asset('css/inventory/inventory.css')}}"> --}}
<script>
	var categoryNameTab='';
function showSubCategory(catId,categoryName){
$(document).ready(function(){
	console.log("fsdsafsafsaf");
	//var x= $("div[class^='catId_']").html();
	resetProductView();
	getProductPage(page = 1, catId);
});
}
</script>
<style type="text/css">
.btn-lg {
    padding: 15px 20px !important;
}
.text{
	font-size: 1.2em;
	text-align: center;
}
.title{
	font-size: 1.3em;
}
.panel{
	border: 1px solid gray;
}
.panel-body{
	padding: 5px;
}
.productbox{
	padding-left: 10px;
}
.name{
	    width:100%;
    height:2.9em;
    display:block;
    border:1px solid red;
    padding:10px;
    overflow:hidden;
}
.text:before{
	content: "\00a0";
}
	.no-display{
		display: none
	}

	.display{
		display: visible;
		color:red !important	;
		size:2.2em;
		font-weight: 100;
	}
.warning{
	border: 1px solid red !important;
	font-weight: 400;
	color: red;

}
.product-column {
	padding: 2px;
}
.product-column .panel {
	margin-bottom: 0;
}
#productbox {
	border: 1px solid;
	border-radius: 4px;
	padding: 10px;
}

.notallowed:hover {
    background-color: #FFF !important;
    color: #555 !important;
}

.notallowed:focus {
    background-color: #FFF !important;
    color: #555 !important;
}

.notallowed:active {
    background-color: #FFF !important;
    color: #555 !important;
}

.glyphicon {
    font-size: 22px;
}
</style>
@stop
@section('content')
@include("common.sellermenu")
{{-- NEW CODE --}}
<div class="container">
	<span id="top"></span>
	<div class="col-xs-12">
	{!! Breadcrumbs::renderIfExists() !!}
	<br><br>
	<div class="row">
		<h2 style="display:inline; ">Retail Inventory Update</h2>
		<div class="pull-right">
			@if(Auth::user()->hasRole('adm'))
				<a href="{{route('admininventory-list',['uid'=> $selluser->id])}}" class="btn btn-info" style="margin-bottom: 15px;font-size:20px"><b> Price Offer </b></a>
			@else
				<a href="{{route('inventory-list')}}" class="btn btn-info" style="margin-bottom: 15px;font-size:20px" ><b> Price Offer </b></a>
			@endif
		</div>
		
	</div>
	<ul class="nav nav-tabs">
	<!-- remove short tag-->
	<?php 
		$i=1; 
		$activei = 0;
	?>
	@forelse($categories as $cat)
		@if($activei==0 && in_array($cat->id, $activelist))
			<li class="active"><a onclick="showSubCategory({{$cat->id}},'{{$cat->name}}')" data-toggle="tab" href="#1a"><b id="">{{$cat->description}}</b></a></li>
			<script type="text/javascript">
				showSubCategory({{$cat->id}},'{{$cat->name}}');
			</script>
			<input type="hidden" value="{{$cat->id}}" id="firstcat" />
			<?php $activei++; ?>
		@else
			@if(in_array($cat->id, $activelist))
				<li><a data-toggle="tab" onclick="showSubCategory({{$cat->id}},'{{$cat->description}}')" href="#1a"><b id="">{{$cat->description}}</b></a></li>
			@else
				<li><a style="color: #555; cursor:not-allowed" class="notallowed" title="This Category have no product available" href="#1a">{{$cat->description}}</a></li>
			@endif
		@endif
		<?php $i++; ?>
    @empty
    <li>No category found</li>
    @endforelse

  </ul>
<br>


	<div class="row">
	<div class="col-xs-12">
		{{-- <div class="panel panel-default no-display" id="productbox"  style="padding-bottom:15px; height: 220px;"> --}}
			{{-- <div class="panel-body"> --}}
				<div class="row" id="productbox">
					<div class="col-xs-3">
						<img src="{{ asset('images/image_not_available.jpg')}}" style="width:250px;height:250px;object-fit:cover;object-position:center top" class="img-responsive" class="img-rounded img-responsive" alt="" id="primage">
					</div>
					<div class="col-xs-9" style="line-height:28px;">
						<table>
							<tr><div class="name"><span class="text" id="name"></span></div></tr>
		 					<tr>
								<td><span class="text">Product ID</span></td>
								<td>: <span class="title" id="product_id"></span> <br></td>
							</tr>
							<tr>
								<td><span class="title" style="font-size:120%">Quantity </span></td>
								<td>: <span class="text" id="quantity" class="label label-lg" style="font-size:200%; font-weight:bold; color:green;"></span></td>
							</tr>
							<br>
							<tr>
								<td>
								<button class="btn btn-green btn-lg" id="add" data="{{$id or ''}}"><i class="glyphicon glyphicon-plus"></i></button>
								</td>
								<td><button class="btn btn-danger del btn-lg" id="del" data="{{$id or ''}}"><i class="glyphicon glyphicon-minus"></i></button></td>
							</tr>
							<tr>
								<span class='text-warning glyphicon glyphicon-alert no-display' id="warning" style="font-size:80%"> </span>
							</tr>
						</table>
					</div>
				</div>
				</div>
			</div>
		{{-- </div> --}}
		{{-- </div> --}}
	{{-- PRODUCT BOX --}}
	<div class="row no-display" id="subcatbox" style="min-height: 185px; max-height:390px; overflow-y:auto;">
	<div class="col-md-3 col-sm-3" id="noSubCat" style="display:none;">
				<div class="panel" style="height:185px;">
					<h3 style="margin-top:35%">&nbsp;&nbsp;No Sub Category</h3>
				</div>
			</div>
	<?php $foundFlag=0;?>
		@foreach($subcats as $s)
		<?php
		if($s->category_id==2){
			$display='';
			$foundFlag=1;
		}
		$display= ($foundFlag==1)?'yy':'display:none1';
		$foundFlag=0;
		$data_products_request = "{\"category_id\": {$s->category_id}, \"subcat_id\": {$s->id}, \"subcat_level\": {$s->level}}";
		?>
			<div class="catId_{{$s->category_id}} col-md-3 col-sm-3" id="" style="{{ $display }}">
				<div class="panel " style="height:185px; border-color:#a9a1a1;">
					<a href="#top" id="{{$s->id}}" rel="c_{{$s->id}}" class="show-products" data-product-request='{{ $data_products_request}}'>
					<img src="{{asset('images/'.$s->logo)}}"
						alt="{{$s->name}}" class="img-responsive"> </a>
				</div>
			</div>
			@endforeach

	</div>
	<input type="hidden" id="station_id" value="{{$station_id}}" />
	<input type="hidden" id="userid" value="{{$selluser->id}}" />
	<div class="row" id="psubcatbox" style="height: auto; min-height: 230px; paddint-bottom: 50px;"> </div>
	
</div>
</div>
<script type="text/javascript">
var resetProductView = function () {
			//preview_image = null;
			$('#product_id').text('');
			$('#primage').attr('src', '');
			$('#name').html('');
			$('#quantity').html('');
		};
		
		function getProductPage(page, cat_id)
		{
			var $psubcatbox = $('#psubcatbox');
			var userid = $("#userid").val();
			console.log("USER" + userid);
			//console.log(1data);
			$.ajax({
				url: JS_BASE_URL + '/inventory/page?page=' + page,
				type: 'POST',
				dataType: 'json',
				data: {category_id: cat_id, userid: userid}
			})
			.success(function (result) {
				console.log(result);
				var htmlItem = '';
				//max_page = result.last_page;
				for(var ii = 0; ii < result.length; ii++){
					var warning_class = '';
					var limit = 0.3 * result[ii].stock;
					if (result[ii].available < limit) warning_class = ' warning';
					htmlItem += '<div class="col-xs-2 product-column">\
									<div class="panel panel-primary' + warning_class + '">\
										<div class="panel-body">\
											<a href="javascript:;" class="get-stock" data-item-fid="'+result[ii].formatted_product_id+'" data-item-id="' + result[ii].parent_id + '">\
												<img src="{{asset('images/product')}}/'+ result[ii].parent_id +'/' + result[ii].product_image + '" style="width:160px;height:160px;object-fit:cover;object-position:center top" class="img-responsive" />\
											</a>\
										</div>\
										<div class="panel-footer">Quantity: <span class="label label-info label-sm quantity-item-' + result[ii].parent_id + '">' + result[ii].available + '</span></div>\
									</div>\
								</div>';
				}
			/*	$.each(result.data, function (index, item) {
					var warning_class = '';
					var limit = 0.3 * item.stock;
					if (item.available < limit) warning_class = ' warning';
					htmlItem += '<div class="col-xs-2 product-column">\
									<div class="panel panel-primary' + warning_class + '">\
										<div class="panel-body">\
											<a href="javascript:;" class="remove-stock" data-item-id="' + item.id + '">\
												<img src="{{asset('images/product')}}/'+ item.id +'/' + item.product_image + '" class="img-responsive" />\
											</a>\
										</div>\
										<div class="panel-footer">Quantity: <span class="label label-info label-sm quantity-item-' + item.id + '">' + item.available + '</span></div>\
									</div>\
								</div>';
				});*/
				$psubcatbox.html(htmlItem);
			});
		}		
	jQuery(document).ready(function($) {
		console.log("fsdsafsafsaf");
		var products_data,
			selected_product = null,
			page = 1,
			max_page = 1,
			preview_image = null;

		

		if($('#firstcat').val()){
			resetProductView();
			getProductPage(page = 1, $('#firstcat').val());
		}		
		
		$('.show-products').click(function () {
			products_data = $(this).data('product-request');
			
			resetProductView();
			getProductPage(page = 1, products_data);
		});

		$('#psubcatbox').on('click', '.get-stock', function () {
			selected_product = this;
			updateStock('neutral');
		});		
		
		$('#psubcatbox').on('click', '.remove-stock', function () {
			selected_product = this;
			updateStock('del');
		});

		$('#del').click(function () {
			updateStock('del');
		});

		$('#add').click(function () {
			updateStock('add');
		});

		var updateStock = function (action) {
			var station_id = $("#station_id").val();
			var $product_id = $(selected_product).data('item-id'),
				$quantity_item = $('.quantity-item-' + $product_id + ', #quantity'),
				route_add = JS_BASE_URL + '/inventory/product/'+station_id+'/' + $product_id + '/' + action;
			$('#add').attr('data',$product_id);
			$('#del').attr('data',$product_id);
			preview_image = $(selected_product).find('img').attr('src');
			$('#primage').attr({
				src: preview_image
			});
			var formatted_product_id=$(selected_product).data('item-fid');
			$('#product_id').text(formatted_product_id);
			$.ajax({
				url: route_add,
				dataType: 'json',
			})
			.success(function (response) {
				console.log(response);
				if (response.status == 'success') {
					$quantity_item.html(response.count);
					$('#name').html(response.product.name);
					if (response.warning == "true") {
						$(selected_product).closest('.panel').addClass('warning');
					}
					else {
						$(selected_product).closest('.panel').removeClass('warning');
					}
					new Audio('{{asset('sounds/beep-08b.mp3')}}').play();
				}else{
					toastr.warning(response.long_message);
				}
			});
		};

		$('#psubcatbox').hammer().on('swipeleft', function () {
			page ++;
			if (page > max_page) page = max_page;
			resetProductView();
			getProductPage(page, products_data);
		})
		.on('swiperight', function () {
			page --;
			if (page <= 1) page = 1;
			resetProductView();
			getProductPage(page, products_data);
		});
	});
</script>
{{-- NEW CODE ENDS --}}
{{-- < --}}
<script type="text/javascript" src="{{asset('js/inventory/inventory.js')}}"></script>

<script>
$("#name").mouseover(function(){
	$(this).css('font-size','13px');
});
$("#name").mouseout(function(){
	$(this).css('font-size','1.2em');
});
	$(document).ready(function() {


		@foreach($subcats as $s)
			$('#{{$s->id}}').on('click', function(event){
				event.preventDefault();
				$("#catSubCatNameTab").text($(this).attr('id').toUpperCase());
				var target = $(this).attr('rel');
				$("#"+target).show().siblings("div").hide();
				$("#subcatbox").hide();
				$("#psubcatbox").show();
				$(".pinclass").show();
				$("#productbox").show();
			$('#productbox').removeClass('no-display');

			});

		@endforeach
	});
</script>

{{-- AJAX FOR PRODUCT --}}
<script type="text/javascript">
	$(document).ready(function(){
		$('.sidr-class-product').click(function(){
			var product_id=$(this).attr('data');
			var root_url="{{asset('images')}}";
			var p_root_url= root_url+'/product/'+product_id+"/";
			var url= JS_BASE_URL+"/inventory/product/"+product_id;
			$.ajax({
				url:url,
				success:function(data){
					if (data.status=="success") {
					$('#productbox').removeClass('no-display');

					$("#primage").attr("src",p_root_url+data.photo);
					$("#primage").hide();$("#primage").show();
					$('#name').text(data.name);
					$('#subcat').text(data.subcat);
					$('#quantity').text(data.available);
					$('#product_id').text('['+zeropad(product_id, 10)+']');
					/*
					$('#oprice').text("MYR "+(data.oprice/100).toFixed(2));
					$('#sprice').text("MYR "+(data.rprice/100).toFixed(2));
					*/
					$('#add').attr('data',data.id);
					$('#del').attr('data',data.id);
					// alert(data.warning);
					if (data.warning=="true") {
						$("#warning").removeClass('no-display');
						$('#warning').text("Low quantity. Please restock");
					}
					else{
						$('#warning').text("");
						$("#warning").addClass('no-display');

					}

					if (data.available==0) {
						$('#del').prop('disabled', true);
						}
					}
					else if(data.status=="illegal_count"){
						alert("The limit for add or del has been achieved");
					}
					else if (data.status=="failure"){
						alert(" Please try later");
						// alert(data.message)
					}

				}
			});
		});
	});
</script>

{{-- AJAX FOR PR ADD --}}
<script type="text/javascript">
	$(document).ready(function(){
		$('#add').click(function(){
			var product_id=$(this).attr('data');
			var url= JS_BASE_URL+"/inventory/product/"+product_id+"/add";
			$.ajax({
				url:url,
				success:function(data){
					if (data.status=="success") {

					$('#quantity').text(data.count);
					if (data.count>0) {
						$('#del').prop('disabled',false);
					};

					var p_name= data.product.name;
					if (data.warning=="false") {
						// alert("False");
						$('#warning').text("");
						$("#warning").addClass('no-display');
						$('.minip_'+p_name).removeClass('warning');
					}
					$('.q_'+p_name).text(data.count);
					$('.q_'+product_id).text(data.count);
						$('.minip_'+product_id).removeClass('warning');


					}
					else{
						alert("Connectivity Problem. Please try later");
					};

				}
			});
		});
	});
</script>
{{-- DEL PR --}}
<script type="text/javascript">
	$(document).ready(function(){
		$('.del ').click(function(event){

			event.preventDefault();
			var product_id=$(this).attr('data');
			var url= JS_BASE_URL+"/inventory/product/"+product_id+"/del";
			$.ajax({
				url:url,
				success:function(data){
					if (data.status=="success") {
						if (data.count==0) {
							$('#del').prop('disabled',true);
						};
					$('#quantity').text(data.count);
					var p_name= data.product.name;
					if (data.warning=="true") {
						// alert("True");
						$("#warning").removeClass('no-display');
						$('#warning').text("Low quantity. Please restock");
						$('.minip_'+p_name).addClass('warning');
						$('.minip_'+product_id).addClass('warning');

					}
					$('.q_'+p_name).text(data.count);
					$('.q_'+product_id).text(data.count);
					var music= "{{asset('sounds/beep-08b.mp3')}}";
					new Audio(music).play();

					}
					else if(data.status=="illegal_count"){
						alert("The limit for add or del has been achieved");
					}
					else if (data.status=="failure"){
						alert(" Please try later");
						// alert(data.message)
					}
					;
					// $('#').data(data.);
					// $('#').data(data.);
					// $('#').data(data.);
					// $('#').data(data.);
				}
			});
		});
	});
</script>

{{-- Pinup --}}
<script type="text/javascript">
	$(document).ready(function(){
		var count=0;
		@foreach($products as $p)
			$('.pinit_{{$p->id}}').click(function(){
				//alert($(this));
				++count;

				var minip=$('.minip_{{$p->id}}').clone(true,true);

				if ($('#pinned #pl_{{$p->id}}').length==0) {
				$('#pinned').prepend("<span id='pl_{{$p->id}}' class='col-xs-4 nopadding' style='padding:0px 15px 0px 15px;'></span>");
				/*var imageUrl=$('#sp_{{$p->id}}').children().find('img').attr('src');
				$('#pinned').prepend("<span id='pl_{{$p->id}}' class='col-xs-4 nopadding' style='padding-right:5px;'>"+
			"<div class='panel' style='margin:0px 0px 4px 1px !important; width:100%; height: 50%'>"+
			"<img src='"+imageUrl+"' class='img-rounded img-responsive' alt='' style='height:95px;'>"+
			"<span class='black'>Qty:</span> <b style='font-size:130%;'>23</b></span></div>");
				*/
				$("#pinned").children('span').eq(6).hide();

				$('#pl_{{$p->id}}').html(minip);
				$('#pl_{{$p->id}}').children().find('img').attr('style','height:95px');
				$('#pinned .pinit_{{$p->id}}').hide();
				$("#pinned").show();
				var x=$("#qty_label_{{$p->id}}").text('Qty: ');
				var x=$("#pl_{{$p->id}}").children('div').find('h4 span').html();
				console.log(x);

				}

			});
		@endforeach

	});
</script>
@stop
