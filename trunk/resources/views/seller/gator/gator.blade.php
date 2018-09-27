<?php
use App\Classes;
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\IdController;
?>
@extends("common.default")
@section('content')

@if (Session::has('error'))
<div class="alert alert-danger">
	<strong>Danger!</strong> Please Select a Station.
</div>
@endif
<script type="text/javascript">

    $(document).ready(function(){
        $("#gatortable").keypress(function (evt) {
            var charCode = evt.charCode || evt.keyCode;
            if (charCode  >=48 && charCode <=57 || charCode==13 ) { 
                
            }
            else{
                evt.preventDefault();
            }
        });
    });

 /*   var wholesaleprices = JSON.parse('<?= $wholesaleprices; ?>');*/

    var quantitiy=0;
    function qtyupdate(index,id,max) {

       /*var wholesaleprices = JSON.parse('<?= $wholesaleprices; ?>');*/

       var quantity = $('#d'+index).val();
       quantity = quantity.replace(/^0+/, '');
       if (quantity<max) {
       var qtyfield = '<input  onchange="qtyupdate('+index+','+id+','+max+');"  type="text" id="d'+index+'" name="quantity'+id+'" class="form-control text-center input-number" value="'+quantity+'" min="0" max="1000000">';
     }
     else{
        var qtyfield = '<input  onchange="qtyupdate('+index+','+id+','+max+');"  type="text" id="d'+index+'" name="quantity'+id+'" class="form-control text-center input-number" value="'+max+'" min="0" max="1000000">';
     }
       $('#qtyfield'+index).html(qtyfield);
       var price =0;
       var pprice=0;

       $('#is'+index).attr("value", quantity);

       wholesaleprices.forEach(function(wp){

        if (id==wp.id) 
        {

            pprice = wp.price/100;
            if (quantity>=wp.funit && quantity<=wp.unit)
            {

                price = wp.price/100;

            }

        }
    });
       if (price==0) 
       {

        price = pprice;

    }
           // var price = $('#priceget'+index).html();

            //total = parseInt(total)+parseInt(price);
            //$('.totalget').html(total);
            // $('.total').html(total.toFixed(2));
            finalPrice = price*quantity;
            $('#pricetotal'+index).html(finalPrice.toFixed(2));
            if (quantity!=0) 
            {
                $('#price'+index).html(price.toFixed(2));
            }

        }
        function plus(index,id,max) {
          var wholesaleprices = JSON.parse('<?= $wholesaleprices; ?>');

          var quantity = $('#d'+index).val();

          var price =0;
          var pprice =0;

          var qtyfield = '<input  onchange="qtyupdate('+index+','+id+','+max+');"  type="text" id="d'+index+'" name="quantity'+id+'" class="form-control text-center input-number" value="0" min="0" max="1000000">';
          $('#qtyfield'+index).html(qtyfield);
          if (quantity<max) {
              quantity = ++quantity;
            }
          $('#d'+index).attr("value", quantity);
          $('#is'+index).attr("value", quantity);

          wholesaleprices.forEach(function(wp){

           if (id==wp.id) 
           {
            pprice = wp.price/100;
            if (quantity>=wp.funit && quantity<=wp.unit) {

                price = wp.price/100;

            }

        }
    });
          if (price==0) 
          {

           price = pprice;

       }
           // var price = $('#priceget'+index).html();

            //total = parseInt(total)+parseInt(price);
            //$('.totalget').html(total);
            // $('.total').html(total.toFixed(2));
            finalPrice = price*quantity;
            $('#pricetotal'+index).html(finalPrice.toFixed(2));
            if (quantity!=0) 
            {
            	$('#price'+index).html(price.toFixed(2));
            }

              


            // Increment

        }

        function minus(index,id,max) {
            // Stop acting like a button
            var wholesaleprices = JSON.parse('<?= $wholesaleprices; ?>');

            // Get the field name
            var quantity = $('#d'+index).val();

            // If is not undefined
            var price =0;
            var pprice =0;
            // Increment
            var qtyfield = '<input  onchange="qtyupdate('+index+','+id+','+max+');"  type="text" id="d'+index+'" name="quantity'+id+'" class="form-control text-center input-number" value="0" min="0" max="1000000">';
            $('#qtyfield'+index).html(qtyfield);
            if(quantity>0){

            	$('#d'+index).attr("value", --quantity);
                //$('#i'+index).attr("value", quantity);
                $('#is'+index).attr("value", quantity);
                //var total = $('.totalget').html();
                wholesaleprices.forEach(function(wp){

                	if (id==wp.id) 
                	{
                		pprice = wp.price/100;
                        if (quantity>=wp.funit && quantity<=wp.unit) {

                            price = wp.price/100;

                        }

                    }
                });
                if (price==0) 
                {
                	
                	price = pprice;

                }
                //var price = $('#priceget'+index).html();
                //total = parseInt(total)-parseInt(price);
                //$('.totalget').html(total);
                //$('.total').html(total.toFixed(2));
                finalPrice = price*quantity;

                $('#pricetotal'+index).html(finalPrice.toFixed(2));
                if (quantity!=0) {
                	$('#price'+index).html(price.toFixed(2));
                }
            }
        }


    </script>
    <style>
    .float-right{
    	float: right;
    }
    .round{
    	width: 34px;
    	border-radius: 20px;
    	padding: 6px;
    }
    .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
    	padding: 8px;
    	line-height: 1.42857143;
    	vertical-align: middle;
    	border-top: 1px solid #ddd;
    }
    .red{
    	background-color:#d9534f;
    }
    .red:hover{

    	background-color: #bf1510;
    	color: white;
    }
    .skyblue:hover{
    	background-color: #377482;
    	color: white;
    }
    .blue:hover{

    	background-color: #0b34ff;
    	color: white;
    }
    .form-group5{
    	margin-bottom: 5px;
    }
    .controlbtn{
    	width: 70px;
    	height: 70px;
    	padding-top: 15px;
    	text-align: center;
    	vertical-align: middle;
    	font-size: 13px;
    	cursor: pointer;
    	margin-right: 5px;
    	margin-bottom: 5px;
    	border-radius: 5px
    }
    .blue{
    	background-color:#0725B9;
    }
    .skyblue{
    	background-color: #0CC0E8;
      color:white;
  }
  .redblue{
     background-color:#C9302C ;
 }

 .hide{
     display: none;
 }
 .pointer:hover{
     cursor: pointer;
 }
 @-webkit-keyframes spin {
     0% { -webkit-transform: rotate(0deg); }
     100% { -webkit-transform: rotate(360deg); }
 }

 @keyframes spin {
     0% { transform: rotate(0deg); }
     100% { transform: rotate(360deg); }
 }
</style>
@include("common.sellermenu")
<meta name="_token" content="{{ csrf_token() }}" />
<script type="text/javascript">
	function selectedstation(id,isemerchant,name,company_name) {
			/*
        	alert(id);
        	alert(isemerchant);
        	*/
        	$('#myModal').modal('toggle');

        	$('input[name=setbuyer]').val(id);
        	$('input[name=isbuyer]').val(isemerchant);
        	$("#showselectedbuyer").html(company_name).html();
        }
    </script>

    <div class="blur">
    	<form method="POST"  id="gatorform"  >
        <input hidden="" id="" type="text" value="{{$user_id}}" name="user_id">
    		<input hidden="" id="setbuyer" type="text" value="" name="setbuyer">
    		<input hidden="" id="isbuyer" type="text" value="" name="isbuyer">
    		<div class="table-responsive" style="margin-bottom: 28px;">

    		</div>

    		{{-- TABS --}}

    		<div  class="container">
    			<div class="start-loader-main "></div>
    			<div style="float: right;color: white; padding-top: 19px; margin-right: 0px !important; " type="button" id="previewso" class=" skyblue sellerbutton" >Preview<br>SO</div>
    			<div style="background-color:green;float: right;color: white;padding-top: 17px;" type="button" id="newbuyerbtn" class="sellerbutton" data-toggle="newbuyer" data-target="#newbuyer">New<br>Merchant</div>

    			<div style="float: right;color: white;padding-top:28px"
    			type="button"
    			id="stationbtn" class="bg-black sellerbutton "
    			onclick="gatorBuyer()">Merchant</div>

    			<h2 style=" width: 40%;float: left; padding-top: 5px;">Sales Order Generator</h2>
    			<div><h4 class="text-center"
    				style="color:#3c24ff;width:30%;height:60px;float:left;padding-top: 15px;"
    				id="showselectedbuyer"></h4></div>
    				<!-- Modal -->


    			</div>
    			<div class="tab-content">
    				<div id="maingatortable" >
    					<div class="container">
    						<table id="gatortable" class="table table-bordered">
    							<thead class="bg-gator" style="font-weight:bold">
    								<tr>
                      <td>TEst</td>
                      <td class='text-center bsmall'>No</td>
    									<td class='text-center bmedium'>Product ID</td>
    									<td class='text-left bmedium'>Product Name</td>
                      
    									<td class='text-center bmedium'>Price&nbsp;({{$currentCurrency}})</td>
    									<td style="width: 20% !important;"
    									class='text-center bmedium'>Qty</td>
    									<td style="width: 15%;"
    									class='text-center bmedium'>
    								Total ({{$currentCurrency}})</td>
    							</tr>
    						</thead>
    						<tbody>
    							<?php $index = 0; $save = $products ;?>
    							@foreach($products as $product)
                                <?php
                                    $disable="disable";
                                    $price=$product->retail_price;
                                    if ($product->consignment_total>0 and $product->wid!=NULL) {
                                        # code...
                                        $disable="";
                                    }
                                    if ($product->consignment_total<1 and $product->retail_price>0) {
                                      # code...
                                      /*Product has b2b price but no quantity*/
                                      $disable="disable_input";
                                      $price=0;
                                    }
                  if($product->consignment_total>0 and $product->retail_price>0)
                  {

                  ?>
    							<tr style="vertical-align: middle;" class="{{$disable}}">
                    <td ><?php echo $product->consignment_total; ?></td>
    								<td class='text-center bmedium'>{{++$index}}</td>
                                    <td class='text-center bmedium'><a target="_blank" href="{{URL::to("productconsumer/$product->parent_id")}}">{{$product->nproductid}}</a></td>

                                    <td style="text-align: left;" class=' bmedium'>
                                     <div style="width: 100%;float: left;display: flex;justify-content: space-between;align-items: center;">
                                      @if(File::exists(URL::to("images/product/$product->prid/thumb/$product->thumb_photo")))
                                      <img width="30" height="30" src="{{URL::to("images/product/$product->prid/thumb/$product->thumb_photo")}}">
                                      @else
                                      <img width="30" height="30" src="{{URL::to("images/product/$product->parent_id/thumb/$product->thumb_photo")}}">
                                      @endif
                                      <div style="width: 90%;float: right;">{{$product->name}}</div>
                                  </div>
                              </td>
                              <td style="text-align: right;"  class='  bmedium'><span id="price{{$index}}">{{number_format($product->retail_price/100,2)}}</span></td>
                              <span style="display: none;" id="priceget{{$index}}">{{$price/100}}</span>


                              <td>
                                 <div style="margin-left: 10%;" class="col-lg-10">
                                  <div class="input-group">
                                   <span class="input-group-btn">
                                 <button @if($product->consignment_total == 0 || $product->segment!='b2b') disabled="disabled"   @endif onclick="plus({{$index}},{{$product->id}},{{$product->consignment_total}})" type="button" class="quantity-right-plus btn-css btn btn-primary btn-number" data-type="plus" data-field="">
                                     <span class="glyphicon glyphicon-plus"></span>
                                 </button>
                             </span>
                             <span id="qtyfield{{$index}}">
                                 <input @if($product->consignment_total == 0 || $product->segment!='b2b') disabled="disabled"   @endif  onchange="qtyupdate({{$index}},{{$product->id}},{{$product->consignment_total}});"  type="text" id="d{{$index}}" name="quantity{{$product->id}}" class="form-control text-center input-number" value="0" min="0" max="1000000">
                             </span>
                             <span class="input-group-btn">
                                <button @if($product->consignment_total == 0 || $product->segment!='b2b') disabled="disabled"   @endif onclick="minus({{$index}},{{$product->id}},{{$product->consignment_total}})" type="button" class="quantity-left-minus btn-css btn btn-primary btn-number"  data-type="minus" data-field="">
                                 <span class="glyphicon glyphicon-minus"></span>
                             </button>
                         </span>
                     </div>
                 </div>
             </td>
             <td style="text-align: right;" class=' bmedium'><span  id="pricetotal{{$index}}" >{{number_format(0/100,2)}}</span></td>

         </tr>

         <?php } else { ?>
          
         <tr style="vertical-align: middle; background-color:lightgray;" class="{{$disable}}">
          <td >0</td>
                    <td class='text-center bmedium'>{{++$index}}</td>
                                    <td class='text-center bmedium'><a target="_blank" href="{{URL::to("productconsumer/$product->parent_id")}}">{{$product->nproductid}}</a></td>

                                    <td style="text-align: left;" class=' bmedium'>
                                     <div style="width: 100%;float: left;display: flex;justify-content: space-between;align-items: center;">
                                      @if(File::exists(URL::to("images/product/$product->prid/thumb/$product->thumb_photo")))
                                      <img width="30" height="30" src="{{URL::to("images/product/$product->prid/thumb/$product->thumb_photo")}}">
                                      @else
                                      <img width="30" height="30" src="{{URL::to("images/product/$product->parent_id/thumb/$product->thumb_photo")}}">
                                      @endif
                                     
                                      <div style="width: 90%;float: right;">{{$product->name}}</div>
                                  </div>
                              </td>
                              <td style="text-align: right;"  class='  bmedium'><span id="price{{$index}}">{{number_format($price/100,2)}}</span></td>
                              <span style="display: none;" id="priceget{{$index}}">{{$price/100}}</span>


                              <td>
                                 <div style="margin-left: 10%;" class="col-lg-10">
                                  <div class="input-group">
                                   <span class="input-group-btn">
                                    <button @if($product->consignment_total == 0 || $product->segment!='b2b') disabled="disabled"   @endif onclick="plus({{$index}},{{$product->id}},{{$product->consignment_total}})" type="button" class="quantity-right-plus btn-css btn btn-primary btn-number" data-type="plus" data-field="">
                                     <span class="glyphicon glyphicon-plus"></span>
                                 </button>
                             </span>
                             <span id="qtyfield{{$index}}">
                                 <input @if($product->consignment_total == 0 || $product->segment!='b2b') disabled="disabled"   @endif  onchange="qtyupdate({{$index}},{{$product->id}},{{$product->consignment_total}});"  type="text" id="d{{$index}}" name="quantity{{$product->id}}" class="form-control text-center input-number" value="0" min="0" max="1000000">
                             </span>
                             <span class="input-group-btn">
                                <button @if($product->consignment_total == 0 || $product->segment!='b2b') disabled="disabled"   @endif onclick="minus({{$index}},{{$product->id}},{{$product->consignment_total}})" type="button" class="quantity-left-minus btn-css btn btn-primary btn-number"  data-type="minus" data-field="">
                                 <span class="glyphicon glyphicon-minus"></span>
                             </button>
                         </span>
                     </div>
                 </div>
             </td>
             <td style="text-align: right;" class=' bmedium'><span  id="pricetotal{{$index}}" >{{number_format(0/100,2)}}</span></td>

         </tr>
          <?php  }  ?>
         @endforeach

     </tbody>
 </table>
</div>
</div>
<?php $count = 1; ?>
			<!-- <div id="consignment" class="tab-pane fade">
		<h3>Gator</h3>
		<p>Content goes here</p>
	</div> -->
</div>
<?php $index=0;  $products = $save  ;?>
@foreach($products as $product)
<input  type="hidden" id="is{{++$index}}" name="product[{{$product->id}}]" class="form-control input-number" value="0" min="1" max="100">

@endforeach

</form>


<style>
.myform {
	display: flex;
	align-items: center;
}

.myform label {
	order: 1;
	width: 12em;
	padding-right: 0.5em;
}

.myform input {
	order: 2;
	flex: 1 1 auto;
	margin-bottom: 0.2em;
}
</style>
@include('seller.gator.newbuyer')

<div class="modal fade" id="confirmmodel" role="dialog">
  <div class="modal-dialog modal-lg">

   <!-- Modal content-->
   <div class="modal-content">

    <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal">&times;</button>
     <h3 class="text-left">Preview Sales Order</h3>
 </div>
 <div style="padding:10px;" class="modal-footer-confirm">

 </div>
 <div class="modal-footer">
     <button style="padding-top:8px;" id="submitform"
     style="color:white"
     type="button" class="btn skyblue controlbtn">Confirm</button>
 </div>
</div>

</div>
</div>
</div>


<div class="modal fade" id="myModal" role="dialog">
	<div style="width: 80%;"  class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">


			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h3>Select Existing Merchant</h3>
			</div>
			<div class="modal-body">
				<div id="gator-buyer"></div>

			</div>
			<div class="modal-footer">
				<br>
				<br>
				<br>
			</div>
		</div>

	</div>
</div>
<div class="modal fade" id="soModal" role="dialog">
  <div style="width: 80%;"  class="modal-dialog">

   <!-- Modal content-->
   <div class="modal-content">


    <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal">&times;</button>
     <h3>Sales Order</h3>
 </div>
 <div class="modal-body">
     <div id="sodisp"></div>

 </div>
 <div class="modal-footer">
     <br>
     <br>
     <br>
 </div>
</div>

</div>
</div>

<div class="modal fade" id="emerchantdetailModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">


            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3>Merchant Details</h3>
            </div>

            <div class="modal-footer">
                <div id="emerchantdt">

                </div>
            </div>
            <div style="height: 77px;" class="modal-footer">

            </div>
        </div>

    </div>
</div>


<script>
	function gatorBuyer() {
		$.ajax({
			type: "GET",
			url: "{{url()}}"+"/seller/gatorbuyer/modal/{{$user_id}}",
			success: function( data ) {
				$("#gator-buyer").html(data);

				$('#myModal').modal('show');
			}
		});
	}


	function displayso(id) {
		$.ajax({
			type: "GET",
			url: JS_BASE_URL+"/seller/gator/saleorder/"+id,
			success: function( data ) {

				$("#sodisp").html(data);
				$('#soModal').modal('show');
			}
		});
	}


	$("#btnsavebuyer").click(function(){
		formdata = $('#savebuyer').serialize();
		//console.log(formdata);
		$.ajaxSetup({
			header:$('meta[name="_token"]').attr('content')
		})
		$.ajax({
			type: "POST",
			url: JS_BASE_URL+"/seller/gatornewbuyer",
			data:formdata,
			success: function( data ) {
				$('#newbuyer').modal('hide');

				$("#showselectedbuyer").html(data.company_name);
				$('input[name=setbuyer]').val(data.id);
				$('input[name=isbuyer]').val(1);
				console.log(data);
			}
		});

	});
	$('#previewso').click(function(){

		formdata = $('#gatorform').serialize();
		//console.log(formdata);
		$.ajaxSetup({
			header:$('meta[name="_token"]').attr('content')
		})
		$.ajax({
			type: "POST",
			url: JS_BASE_URL+"/seller/gatorconfirm",
			data:formdata,
			success: function( data ) {

				if (data == 0) {
					toastr.error('Please Select Merchant');
				} else if (data == 1) {
					toastr.error('Please add quantity');
				} else {
					$('#confirmmodel').modal('toggle');
					$('.modal-footer-confirm').html(data);
				}

				console.log(data);
			}
		});
	});

	$('#submitform').click(function(){

		formdata = $('#gatorform').serialize();
    $('#submitform').prop("disabled", true);
          $('#confirmmodel').modal('hide');
    
		//console.log(formdata);
		$.ajaxSetup({
			header:$('meta[name="_token"]').attr('content')
		})
		$.ajax({
			type: "POST",
			url: JS_BASE_URL+"/seller/checkoutgator",
			data:formdata,
			success: function( data ) {
    $('#submitform').prop("disabled", false);

				if (data == 0) {
					toastr.error('Please Select Station');
				} else {
					toastr.success('Sales Order Created');
          $("#showselectedbuyer").html("");
          $('input[type=text]').attr('value','0');
          $('input[type=hidden]').attr('value','');

          $('input[name=setbuyer]').attr('value','');
          $('input[name=isbuyer]').attr('value','');
          $('#gatorform').trigger("reset");
					displayso(data);
				}

				console.log(data);
			}
		});
	});

	$('#newbuyerbtn').click(function(){
		$('#newbuyer').modal('toggle');
	});
//        $('#stationbtn').click(function(){
//            $('#myModal').modal('toggle');
//        });

var types = {treport:"Tracking Report", tin:"Stock In", tout:"Stock Out", tou:"Stock Out", smemo:"Sales Memo", stocktake:"Stock Take"};

$(document).ready(function(){
	var c_table = $('#consignment-open-channel').DataTable({
		'autoWidth':false,
		"columnDefs": [
    {"bSort":  false, },
		{"targets": 'no-sort', "orderable": false, },
		{"targets": "medium", "width": "80px" },
		{"targets": "bmedium", "width": "10px" },
		{"targets": "large",  "width": "120px" },
		{"targets": "approv", "width": "180px"},
		{"targets": "blarge", "width": "200px"},
		{"targets": "bsmall",  "width": "20px"},
		{"targets": "clarge", "width": "250px"},
		{"targets": "xlarge", "width": "300px" }
		]
	});
  $('#gatortable').DataTable({
                //"order": [[ 4, 'desc' ]],
    "order": [[ 5, 'asc' ]],
      "columnDefs": [
          { "visible": false, "targets": 0 },
      ],
  });
	/*$('#gatortable').DataTable({
		//"order": [],
    "columnDefs": [
            {
                "targets": [2],
                "visible": false,
                "searchable": false
                "aaSorting" : [2,'desc']
            },
            
        ]

	});*/

	var table = $('#supplier-open-channel').DataTable({
		'scrollX':true,
		'bScrollCollapse': true,
		'scrollX':true,
		'autoWidth':false,
		"columnDefs": [

		{"targets": 'no-sort', "orderable": false, },
		{"targets": "medium", "width": "80px" },
		{"targets": "bmedium", "width": "10px" },
		{"targets": "large",  "width": "120px" },
		{"targets": "approv", "width": "180px"},
		{"targets": "blarge", "width": "200px"},
		{"targets": "bsmall",  "width": "20px"},
		{"targets": "clarge", "width": "250px"},
		{"targets": "xlarge", "width": "300px" }
		]
	});
	$(".dataTables_empty").attr("colspan","100%");


$(".disable").find('input, textarea, button, select').attr('disabled','disabled');
$(".disable_input").find('input, textarea, button, select').attr('disabled','disabled');
$(".disable").css("background-color","#e0e0e0")

});
$('link[href="{{asset('/css/select2.min.css')}}"]').remove();
</script>
@yield("left_sidebar_scripts")
@stop
