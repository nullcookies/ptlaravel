@extends("common.default")
<?php
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\IdController;
use App\Classes;
$i = 1;
?>
@section("content")
<!--
<link href="{{url('assets/jqGrid/ui.jqgrid.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{url('css/datatable.css')}}" rel="stylesheet" type="text/css"/>
-->
<style>

    .tab-pane{
        margin-top: 4em;
    }


	.top-margin{
		margin-top: -30px;
	}
	
	table#notproduct_details_table
    {
      /*  table-layout: fixed;*/
        max-width: none;
        width: auto;
        min-width: 100%;
    }
	
    table#product_details_table
    {
        table-layout: fixed;
        max-width: none;
        width: auto;
        min-width: 100%;
    }
	.aproducts{
		width: 100% !important;
	}
	.no-sort{
		width: 20px !important;
	}
</style>
	@include('common.sellermenu')
    <section class="">
        <div class="container"><!--Begin main cotainer-->
            <div class="alert alert-success alert-dismissible hidden cart-notification" role="alert" id="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong class='cart-info'></strong>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="col-sm-12"><h2> Caiman</h2></div>
                    {{-- Tabbed Nav --}}
						<div class="panel with-nav-tabs panel-default ">
							<div class="panel-heading">
								<ul class="nav nav-tabs">
									<li id="tb-list-product" class="active"><a href="#list-product" data-toggle="tab">Overall</a></li>
									<li id="tb-product-list" ><a href="#product-list" data-toggle="tab">Consignment</a></li>
								</ul>
							</div>
						</div>
                    {{--ENDS  --}}
					
					<div id="dashboard" class="row panel-body " >
						
					</div>

				</div>
            </div>
        </div>
    </section>


<script>
var thetable;
		function resetnotProductList(data){
			var html = "";
			console.log("Reset");
			var products = data.data;
			console.log(products);
		//	product_table.destroy();
			var i = 1;
			html += '<table class="table table-bordered" id="notproduct_details_table">';
			html += '	<thead>';
			html += '	<tr style="background-color: #F29FD7; color: #FFF;">';
			html += '		<th class="text-center no-sort bsmall" width="20px" style="width: 20px !important;">No</th>';
			html += '		<th class="text-center" >Product&nbsp;ID</th>';
			html += '		<th class="text-center">Name</th>';
			html += '		<th class="text-center">&nbsp;<input type="checkbox" class="allnotproducts" />&nbsp;</th>';
			html += '	</tr>';
			html += '	</thead><tbody>';		
				//console.log(products);
			if (typeof products != 'undefined'){
			for(var jk = 0; jk < products.length; jk++){
				var product = products[jk];
				//console.log(product);
				if (typeof product != 'undefined'){
				//console.log(product);
				var pname = product.name;
				html += '<tr>';
				html += '<td class="text-center">'+ i +'</td>';
				html += '<td class="text-center">'+ product.formatted_product_id +'</td>';
				html += '<td class="text-left"><img src="'+JS_BASE_URL+'/images/product/'+product.parent_id+'/'+product.real_photo_1+'" width="30" height="30" style="padding-top:0;margin-top:4px">&nbsp;<span style="vertical-align: middle;" title="'+product.name+'">'+ pname +'</span></td>';
				html += '<td class="text-center"><input type="checkbox" class="notproducts" rel="'+ product.id +'" /></td>';
				html += '</tr>';
				i++;
				}
			} 
		} else {
			html += '<tr><td colspan="4"><p align="center">No data Available</p></td></tr>';
		}
			html += '</tbody></table>';
			//for()
		/*	$html += '<tr class="'profile_product->id.''	*/
	//	console.log(html);
			$("#thetable2").html(html);
				$('#notproduct_details_table').DataTable({
				"order": [],
				"scrollX":true,
				"columnDefs": [
					{ "targets": "no-sort", "width": "120px", "orderable": false },
					{ "targets": "large", "width": "120px" },
					{ "targets": "bsmall", "width": "20px" },
					{ "targets": "smallestest", "width": "55px" },
					{ "targets": "medium", "width": "95px" },
					{ "targets": "xlarge", "width": "280px" }
				],
				"fixedColumns":   {
					"leftColumns": 2
				}
			});	
		}

		function resettProductList(data){
			var html = "";
			console.log("Reset");
			var products = data.data;
		//	console.log(products);
		//	product_table.destroy();
			var i = 1;
			html += '<table class="table table-bordered" id="product_details_table">';
			html += '	<thead>';
			html += '	<tr style="background-color: #F29FD7; color: #FFF;">';
			html += '		<th class="text-center no-sort bsmall" width="20px" style="width: 20px !important;">No</th>';
			html += '		<th class="text-center" >Product&nbsp;ID</th>';
			html += '		<th class="text-center">Name</th>';
			html += '		<th class="text-center">B2B</th>';
			html += '		<th class="text-center">Special</th>';
			html += '		<th class="text-center">Quantity</th>';
			html += '		<th class="text-center">&nbsp;</th>';
			html += '	</tr>';
			html += '	</thead><tbody>';		
				//console.log(products);
			if (typeof products != 'undefined'){
			for(var jk = 0; jk < products.length; jk++){
				var product = products[jk];
				//console.log(product);
				if (typeof product != 'undefined'){
					//console.log(product);
					var pname = product.name;
					html += '<tr>';
					html += '<td class="text-center">'+ i +'</td>';
					
					html += '<td class="text-center">'+ product.formatted_product_id +'</td>';
					html += '<td class="text-center"><span class="tp_name" id="tp_namespan'+product.id+'" rel="'+product.id+'">'+product.name+'</span> <input style="display:none;" type="text" size="30" class="tp_name_input form-control" id="tp_name'+product.id+'" rel="'+product.id+'" value="'+product.name+'" /> </td>';
					html += '<td class="text-center"><a href="'+JS_BASE_URL+'/tproduct/wholesale/'+ product.id +'/'+$('#mmerchant_id').val()+'/'+$('#msell_id').val()+'" target="_blank">B2B</a></td>';
					html += '<td class="text-center"><a href="'+JS_BASE_URL+'/tproduct/special/'+ product.id +'/'+$('#mmerchant_id').val()+'/'+$('#msell_id').val()+'" target="_blank">Special</a></td>';
					html += '<td class="text-center"><span class="tp_qty" id="tp_qtyspan'+product.id+'" rel="'+product.id+'">'+product.available+'</span> <input style="display:none;" type="text" size="6" class="tp_qty_input form-control" id="tp_qty'+product.id+'" rel="'+product.id+'" value="'+product.available+'" /> </td>';
					html += '<td class="text-center"><a href="javascript:void(0)" rel="'+product.id+'" class="delete_tp text-danger"><i class="fa fa-minus-circle fa-2x"></i></a></td>';
					html += '</tr>';
					i++;
				}
			} 
		} else {
			html += '<tr><td colspan="4"><p align="center">No Data Available</p></td></tr>';
		}
			html += '</tbody></table>';
			//for()
		/*	$html += '<tr class="'profile_product->id.''	*/
	//	console.log(html);
			thetable = $("#thetable").html(html);
				$('#product_details_table').DataTable({
				"order": [],
				"scrollX":true,
				"columnDefs": [
					{ "targets": "no-sort", "width": "120px", "orderable": false },
					{ "targets": "large", "width": "120px" },
					{ "targets": "bsmall", "width": "20px" },
					{ "targets": "smallestest", "width": "55px" },
					{ "targets": "medium", "width": "95px" },
					{ "targets": "xlarge", "width": "280px" }
				],
				"fixedColumns":   {
					"leftColumns": 2
				}
			});	
		}
    //    $('#auto_link_table').dataTable().fnDestroy();
    $(document).ready(function(){
		 $(document).delegate( '.delete_tp', "click",function (event) {
		// $(".delete_payment").on("click",function(){
				var obj=$(this);
				var id=$(this).attr("rel");
				$.ajax({
					type: "post",
					url: JS_BASE_URL + '/deletetp',
					data: {
						id: id
					},
					cache: false,
					success: function (responseData, textStatus, jqXHR) {
						toastr.info('Product successfully deleted!');
						$.ajax({
							url: '{{ route('getmerchanttproducts') }}',
							cache: false,
							method: 'GET',
							data: {merchant_id: $('#mmerchant_id').val()},
							dataType: 'json',
							success: function(result, textStatus, errorThrown) {
								console.log(result);
								resettProductList(result);
							},
							error: function (responseData, textStatus, errorThrown) {
								resettProductList("");	
							}
						});	
					},
					error: function (responseData, textStatus, errorThrown) {
						toastr.error('An unexpected error occurred!');
					}
				});	
		 });	
		 
		$(document).delegate( '.addTproduct', "click",function (event) {
				var id=$("#mmerchant_id").val();
				var _obj=$(this);
				$.ajax({
					type: "post",
					url: JS_BASE_URL + '/addtp',
					data: {
						merchant_id: id
					},
					cache: false,
					success: function (responseData, textStatus, jqXHR) {
						toastr.info('Product successfully added!');
						$.ajax({
							url: '{{ route('getmerchanttproducts') }}',
							cache: false,
							method: 'GET',
							data: {merchant_id: $('#mmerchant_id').val()},
							dataType: 'json',
							success: function(result, textStatus, errorThrown) {
								console.log(result);
								resettProductList(result);
								_obj.removeClass("addTproduct");
								_obj.addClass("naddTproduct");
							},
							error: function (responseData, textStatus, errorThrown) {
								resettProductList("");	
							}
						});	
					},
					error: function (responseData, textStatus, errorThrown) {
						toastr.error('An unexpected error occurred!');
					}
				});	
		 }); 
		
		$(document).delegate( '.tp_qty_input', "blur",function (event) {
			var objThis = $(this);
			
			var id = objThis.attr('rel');
			var value = parseFloat(objThis.val());
			var qty = parseFloat($("#tp_qty" + id).val());
			$.ajax({
					url: JS_BASE_URL + '/tproduct_qty',
					cache: false,
					method: 'POST',
					data: {id: id, qty: qty},
					success: function(result, textStatus, errorThrown) {
					//	objThis.hide();
						$("#tp_qty" + id).hide();
						$("#tp_qtyspan" + id).text(result.result);
						$("#tp_qtyspan" + id).show();
					}
			});		
		});
		
		$(document).delegate( '.tp_qty', "click",function (event) {
			var objThis = $(this);
			objThis.hide();
			var id = objThis.attr('rel');
			$("#tp_qty" + id).show();
		});		
		
		$(document).delegate( '.tp_name_input', "blur",function (event) {
			var objThis = $(this);
			var _obj = $('.naddTproduct');
			
			_obj.addClass("addTproduct");
			_obj.removeClass("naddTproduct");
			var id = objThis.attr('rel');
			var value = parseFloat(objThis.val());
			var name = $("#tp_name" + id).val();
			console.log(name);
			$.ajax({
					url: JS_BASE_URL + '/tproduct_name',
					cache: false,
					method: 'POST',
					data: {id: id, name: name},
					success: function(result, textStatus, errorThrown) {
					//	objThis.hide();
						$("#tp_name" + id).hide();
						$("#tp_namespan" + id).text(result.result);
						$("#tp_namespan" + id).show();
					}
			});		
		});
		
		$(document).delegate( '.tp_name', "click",function (event) {
			var objThis = $(this);
			objThis.hide();
			var id = objThis.attr('rel');
			$("#tp_name" + id).show();
		});			
		//resetnotProductList("");
		//s$("#list-product").css('display','none');
		var nptable = $('#notproduct_details_table').DataTable({
			"order": [],
			"scrollX":true,
			"columnDefs": [
				{ "targets": "no-sort", "width": "120px", "orderable": false },
				{ "targets": "large", "width": "120px" },
				{ "targets": "bsmall", "width": "20px" },
				{ "targets": "smallestest", "width": "55px" },
				{ "targets": "medium", "width": "95px" },
				{ "targets": "xlarge", "width": "280px" }
			],
			"fixedColumns":   {
				"leftColumns": 2
			},
			"fnInitComplete": function(oSettings, json) {
			 // $("#list-product").removeClass('active');
			}
        });		
		
        var table = $('#product_details_table').DataTable({
			"order": [],
			"scrollX":true,
			"columnDefs": [
				{ "targets": "no-sort", "width": "120px", "orderable": false },
				{ "targets": "large", "width": "120px" },
				{ "targets": "bsmall", "width": "20px" },
				{ "targets": "smallestest", "width": "55px" },
				{ "targets": "medium", "width": "95px" },
				{ "targets": "xlarge", "width": "280px" }
			],
			"fixedColumns":   {
				"leftColumns": 2
			}
        });
	
			$('.add-btn').click(function (e) {
				var thisbtn = $(this);
				var cont = 0;
				thisbtn.attr("disabled", true);
				var pattr = [];
				var thisttr = [];
				$('.notproducts').each(function() {
					if (this.checked) {
						thisttr[cont] = $(this);
						/*var row = nptable.row( $(this).parents('tr') );
						row.remove();*/
						var prodid = $(this).attr('rel');
						pattr[cont] = prodid;
						cont++;
					}
				});
				//console.log(jsonData);
				if(cont == 0){
					toastr.warning("No product selected!");
					thisbtn.attr("disabled", false);
					
				} else {
					$.ajax({
						url: JS_BASE_URL + "/add_tproducts",
						type: "post",
						data: {pattr: pattr, merchant_id: $("#thesell").val()},
						async: false,
						success: function (data) {
							console.log(data);
							$.ajax({
								url: '{{ route('getmerchantnotproducts') }}',
								cache: false,
								method: 'GET',
								data: {merchant_id: $('#mmerchant_id').val()},
								dataType: 'json',
								success: function(result, textStatus, errorThrown) {
									console.log(result);
									resetnotProductList(result);
								},
								error: function (responseData, textStatus, errorThrown) {
									resetnotProductList("");	
								}
							});	
							toastr.info("Product(s) successfully added!");
							thisbtn.attr("disabled", false);
						}
					});
				}
				
			});	
			
			$(document).delegate( '.allnotproducts', "click",function (event) {
				if(this.checked){
					//console.log("HOLA");
					$(".notproducts").prop('checked', true);
				} else{
					//console.log("CHAO");
					$(".notproducts").prop('checked', false);
				}
			});
			$(document).delegate( '#tb-product-list', "click",function (event) {
				$("#product_details_table").remove();
				$("#myspinner").show();			
				$.ajax({
					url: '{{ route('getmerchanttproducts') }}',
					cache: false,
					method: 'GET',
					data: {merchant_id: $('#mmerchant_id').val()},
					dataType: 'json',
					success: function(result, textStatus, errorThrown) {
						console.log(result);
						resettProductList(result);
					},
					error: function (responseData, textStatus, errorThrown) {
						resettProductList("");	
					}
				});	
				
			});			

			$(document).delegate( '#tb-list-product', "click",function (event) {
				$("#notproduct_details_table").remove();		
				$.ajax({
					url: '{{ route('getmerchantnotproducts') }}',
					cache: false,
					method: 'GET',
					data: {merchant_id: $('#mmerchant_id').val()},
					dataType: 'json',
					success: function(result, textStatus, errorThrown) {
						console.log(result);
						resetnotProductList(result);
					},
					error: function (responseData, textStatus, errorThrown) {
						resetnotProductList("");	
					}
				});	
				
			});				
	
	$(".dataTables_empty").attr("colspan","100%");
	$(window).resize();
	$(window).trigger('resize');
	//
});

</script>
@stop

