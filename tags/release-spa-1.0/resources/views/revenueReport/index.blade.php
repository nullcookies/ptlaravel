@extends('common.default')
@section('content')
<style type="text/css">
	.instr{
		font-size: 1.2em;
		font-weight: normal;
	}
</style>
<div class="container">
@include('admin.panelHeading')
	<div class="row">
		<div class="col-md-4">
			<label ><span class="instr">Please choose a Revenue Type:</span>
				<select class="form-control" id="chose">
					<option id="no-act" selected>Select Revenue Type</option>
					
					<option id="category">Category Revenue</option>
					<option id="subcategory">SubCategory Revenue</option>
					<option id="merchant">Merchant Revenue</option>
					<option id="productA">Product A Revenue</option>
					<option id="productB">Product B Revenue</option>
					<option id="overall">Overall Revenue</option>
				</select>
			</label>
		</div>
	</div>
	<div class="row">
	<div class="col-md-12" id="headingopt"></div>
	</div>
	<div class="row staging_area">
		<div class="col-md-12 ">
		
		</div>
	</div>
</div>
<br><br>
<script type="text/javascript">
	function load(route) {
		$.ajax({
			url:"",
			type:'GET',
			success:function(response){

			}
		});
	}
	$(document).ready(function(){
		$('#chose').change(function(){
			$('#headingopt').empty();
			// $('#headingopt').highcharts().destroy();
			// // Highcharts.destroy();
			// if (typeof(chart)!=='undefined') {
			// 	chart.destroy();
			// }
			var v=$('option:selected', $(this)).attr('id');
			// alert(v);
			var url="";
			if (v=="no-act") {
				return false;
			}
			if (v=="overall") {
				url="{{url('overallRevenue')}}";
				$('#headingopt').append("<h2>Overall Revenue</h2>");
			}
			if (v=="category") {
				url="{{url('categoryRevenue')}}";
				$('#headingopt').append("<h2>Category Revenue</h2>");
			}
			if (v=="subcategory") {
				url="{{url('subCategoryRevenue')}}";
				$('#headingopt').append("<h2>SubCategory Revenue</h2>");
			}
			if(v=="merchant"){
				url="{{url('merchantRevenue')}}";
				$('#headingopt').append("<h2>Merchant Revenue</h2>");
			}
			if (v=="productA") {
				url="{{url('productARevenue')}}";
				$('#headingopt').append("<h2>Product A Revenue</h2>");
			}
			if (v=="productB") {
				url="{{url('productBRevenue')}}";
				$('#headingopt').append("<h2>Product B Revenue</h2>");
			}
			$.ajax({
				url:url,
				type:'GET',
				success:function(response){
					$('.staging_area').empty();

					$('.staging_area').append(response);
				}
			});
		});
	});
</script>
@stop
