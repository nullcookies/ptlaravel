@extends("common.default")
<?php 
define('MAX_COLUMN_TEXT', 20);
use App\Http\Controllers\IdController;
use App\Models\Currency;

$total_smm_army=0;
$channels = array(
	array('id'=> 1, 'description' => 'Email', 'checked' => true),
	array('id'=> 2, 'description'=> 'SMM Army', 'checked' => true));
$currency =   $currency = Currency::where('active', 1)->first();
$currencyCode = $currency->code;
?>
@section("content")
@include('common.sellermenu')

<script type="text/javascript" src="{{asset('js/canvas.js')}}"></script>


<link rel="stylesheet" type="text/css" href="{{asset("css/rangeslider.css")}}">

<script src="https://files.codepedia.info/files/uploads/iScripts/html2canvas.js"></script>

<script type="text/javascript" src="<?php echo e(asset('js/qr.js')); ?>"></script>
<style>
.form-group{
	padding: 10px !important
	;
}
.dataTables_empty 
{ text-align: center !important; }
	/*.storebutton{
		background-color: #FF3333 !important;
		}*/
	/*.nav-tabs>li.active>a, .nav-tabs>li.active>a:focus, .nav-tabs>li.active>a:hover, .nav-tabs>li>a:hover{
		color: white;
		background-color: #ffcc00;
		}*/

	</style>


	<style type="text/css">
	/*.nav li a:focus, .nav li a:hover {
   		background-color: transparent !important;
    	color: #fff;
    	}*/
    </style>
    <section class="">
    	<div class="container">
    		<div class="row">
    			<div class="col-sm-12">  
    				{{-- Tabbed Nav --}}

    				<div class="panel with-nav-tabs panel-default ">
    					<div class="panel-heading">
    						<h2>Warehouse Management</h2>
    						@if(count($warehouses) > 0 )
    						<ul class="nav nav-tabs">
    							<?php $e=1; ?>
    							@foreach($warehouses as $warehouse)
    							<?php $class = "active"; if($e > 1){ $class =  ''; } ?>

    							<li class='{{ $class }}'><a href="#w_{{$warehouse->warehouse_id}}" data-toggle="tab">{{$warehouse->branch_name}}</a></li>
    							<?php $e++;?>
    							@endforeach
    						</ul>
    						@endif
    						@if(count($warehouses) <= 0 )
    						<div>{{' No warehouse found '}}</div>
    						@endif
    					</div>
    				</div>
    				{{--ENDS  --}}
    				<div id="dashboard" class="row panel-body " >
    					<div class="tab-content top-margin" style="margin-top:-30px">
    						@if(count($warehouses) > 0 )
    						<?php $e=1; ?>
    						@foreach($warehouses as $w)
    						<?php $class = "active"; if($e > 1	){ $class =  ""; } ?>
    						<div id="w_{{$w->warehouse_id}}" class="tab-pane fade in {{$class}}">
    							<!-- <div id="warehouse" class="tab-pane fade in active"> -->
    								<div class="row">
    									<div class=" col-sm-12">
    										<h3>{{$w->branch_name}}
    											<small>
    												<div class="sellerbutton pull-right" id='' style="background-color:#ffcc00">
    													<span
    													style="
    													margin-top:15px;
    													"
    													>
    													<a 
    													href="javascript:void(0)" 
    													style="color:white;
    													font-size:15px;
    													" 
    													class="saverack" rel-warehouseid={{$w->warehouse_id}}>
    													+ Rack
    												</a>
    											</span>
    										</div>



    									</small>
    								</h3>
    							</div>
    						</div>
    						<table id="table_{{$w->warehouse_id}}" class="warehousedatatable" cellspacing="0" class="table table-bordered" width="100%">
    							<thead>
    								<tr class="bg-warehouse">
    									<th class="text-center" >No.</th>
    									<th class="text-center" >Rack No.</th>
    									<th class="text-center" >Products</th>
    									<!-- <th class="text-center" >Barcode/QR</th> -->
    									<th class="text-center" >Next Expiry</th>


    								</tr>
    							</thead>
    							<tbody id="tbody_{{$w->warehouse_id}}">

    							</tbody>
    						</table>
    					</div>
    					<?php $e++;?>
    					@endforeach
    					@endif
    				</div>
    			</div>
    		</div>
    	</div>
    </div>

</section>
<!-- Modal -->
<div id="rackModal" class="modal fade" role="dialog" data-backdrop="false">
	<div style="width: 90% !important" class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Rack No <span id="racknomodal"></span></h4>
			</div>
			<div class="rack_modal-body">

				@include('seller.qrsetting_rack_ajax')
			</div>
      {{-- 
        <form id="rackform">
        	<input type="hidden" name="warehouse_id" value="" id="warehouse_id">
        	<!-- Text input-->
			<div class="form-group">
			  <label class="col-md-4 control-label" for="rack_no">Rack No</label>  
			  <div class="col-md-5">
			  <input id="rack_no" name="rack_no" placeholder="eg:0001" class="form-control input-md" required="" type="number">
			    
			  </div>
			</div>
			<!-- Text input-->
			<div class="form-group">
			  <label class="col-md-4 control-label" for="description">Description</label>  
			  <div class="col-md-5">
			  <input id="description" name="description" placeholder="eg:left rack by the end" class="form-control input-md" type="text">
			    
			  </div>
			</div>
			<!-- Text input-->
			<div class="form-group">
			  <label class="col-md-4 control-label" for="name">Name</label>  
			  <div class="col-md-5">
			  <input id="name" name="name" placeholder="eg:WhiteRack" class="form-control input-md"  type="text">
			    
			  </div>
			</div>
			<!-- Text input-->
			<!-- Button (Double) -->
			<div class="form-group" style="margin-top:30px !important;">
			  <label class="col-md-4 control-label" for="button1id"></label>
			  <div class="col-md-8">
			    <button  type="button" id="saverack" name="button1id" class="btn btn-success">Save</button>
			    <button id="cancelrack" name="cancelrack" class="btn btn-danger" data-dismiss="modal">Cancel</button>
			  </div>
			</div>
			
		</form> --}}
	</div>
	<div class="modal-footer">

	</div>
</div>

</div>
</div>
<!-- Modal -->
<div id="productModal" class="modal fade" role="dialog">
	<div class="modal-dialog" style="width:80% !important">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Products</h4>
			</div>
			<div class="modal-body">

				<table class="table" id="rackproducts"
				style="width:100% !important;">
				<thead>
					<tr class="bg-warehouse">
						<th class="text-center">No.</th>
						<th class="text-center">Product Name</th>
						<th class="text-center">Qty</th>
						<th class="text-center">Expiry Date</th>
					</tr>
				</thead>
				<tbody id="tbody_rp">

				</tbody>
			</table>
      {{-- 
        <form id="rackform">
        	<input type="hidden" name="warehouse_id" value="" id="warehouse_id">
        	<!-- Text input-->
			<div class="form-group">
			  <label class="col-md-4 control-label" for="rack_no">Rack No</label>  
			  <div class="col-md-5">
			  <input id="rack_no" name="rack_no" placeholder="eg:0001" class="form-control input-md" required="" type="number">
			    
			  </div>
			</div>
			<!-- Text input-->
			<div class="form-group">
			  <label class="col-md-4 control-label" for="description">Description</label>  
			  <div class="col-md-5">
			  <input id="description" name="description" placeholder="eg:left rack by the end" class="form-control input-md" type="text">
			    
			  </div>
			</div>
			<!-- Text input-->
			<div class="form-group">
			  <label class="col-md-4 control-label" for="name">Name</label>  
			  <div class="col-md-5">
			  <input id="name" name="name" placeholder="eg:WhiteRack" class="form-control input-md"  type="text">
			    
			  </div>
			</div>
			<!-- Text input-->
			<!-- Button (Double) -->
			<div class="form-group" style="margin-top:30px !important;">
			  <label class="col-md-4 control-label" for="button1id"></label>
			  <div class="col-md-8">
			    <button  type="button" id="saverack" name="button1id" class="btn btn-success">Save</button>
			    <button id="cancelrack" name="cancelrack" class="btn btn-danger" data-dismiss="modal">Cancel</button>
			  </div>
			</div>
			
		</form> --}}
	</div>
	<div class="modal-footer">

	</div>
</div>

</div>
</div>
<script>



</script>
@stop

@section("scripts")


<script type="text/javascript">
	$("#rackModal").modal("show");
	$("#rackModal").css('display','none');
	$(document).ready(function(){
		$("#rackModal").modal("hide");
		$("#rackModal").css('display','block');


var element = $("#qrcode-container-download"); // global variable
var getCanvas; // global variable

$("#btn-Preview-Image").on('click', function () {
      //toastr.info('Please Wait Converting');
      html2canvas(element, {
      	onrendered: function (canvas) {
                //$("#previewImage").append(canvas);
                getCanvas = canvas;
                $('#btn-Convert-Html2Image').removeClass("nonebtn");

                toastr.success('Convertd Ready for download');

            }
        });
  });

$("#btn-Convert-Html2Image").on('click', function () {

	var imgageData = getCanvas.toDataURL("image/png");
    // Now browser starts downloading it instead of just showing it
    var newData = imgageData.replace(/^data:image\/png/, "data:application/octet-stream");
    $("#btn-Convert-Html2Image").attr("download", "12.png").attr("href", newData);
});

});


	$('#print').click(function(){
		window.print();

	});

	$(document).ready(function(){
		var newqrcode = function() {

			$('.productname').css("width", $("#bar-width").val()*2);
			$('.productexpiry').css("width", $("#bar-width").val());
			$('.productname').css("font-size", $("#bar-fontSize").val()+"px");
			$('.productexpiry').css("font-size", $("#bar-fontSize").val()+"px");



			$("#bar-width-display").text($("#bar-width").val());
			$("#bar-height-display").text($("#bar-height").val());
			$("#bar-fontSize-display").text($("#bar-fontSize").val());
			$("#bar-margin-display").text($("#bar-margin").val());
			$("#bar-text-margin-display").text($("#bar-text-margin").val());


			var margin =   $("#bar-text-margin").val();
			$('.productname').css("margin-bottom", margin+"px");
			$('.productexpiry').css("margin-top", margin+"px");
			var value=$("#userInput").val();
			$('#qrcode').html('');


			$('#qrcode').qrcode({height:parseInt($("#bar-height").val()),width:parseInt($("#bar-width").val()),text:value});

		};




		$("#description").change(function(){
			$('.productname').html($('#description').val());
		});
		$("#userInput").on('input',newqrcode);
		$("#price").on('input',function(){

			$('.qrprice').html($("#price").val());
		});
		$("#description").on('input',function(){

		});


		$(".text-align").click(function(){
			$(".text-align").removeClass("btn-primary");
			$(this).addClass("btn-primary");
			$('.productname').css("text-align", $(this).val());
			$('.productexpiry').css("text-align", $(this).val());

		});

		$(".font-option").click(function(){
			if($(this).hasClass("btn-primary")){
				$(this).removeClass("btn-primary");
				$('.productname').css("font-weight","");
				$('.productexpiry').css("font-weight","");
			} else {
				$(this).addClass("btn-primary");
				$('.productname').css("font-weight", $(this).val());
				$('.productexpiry').css("font-weight", $(this).val());
			}


		});

		$(".italic").click(function(){
			if(!$('.italic').hasClass("btn-primary")){
				$('.italic').removeClass("btn-primary");
				$('.productname').css("font-style","");
				$('.productexpiry').css("font-style","");
			} else {
				$('.italic').addClass("btn-primary");
				$('.productname').css("font-style", $(this).val());
				$('.productexpiry').css("font-style", $(this).val());
			}


		});

		$(".display-text").click(function(){
			$(".display-text").removeClass("btn-primary");
			$(this).addClass("btn-primary");

			if($(this).val() == "true"){
				$("#font-options").slideDown("fast");

				$("#font-options").css("display", 'block');
			} else {
				$("#font-options").slideUp("fast");
			}
			newqrcode();
		});

		$("#font").change(function(){
			$(this).css({"font-family": $(this).val()});
			$('.productname').css("font-family", $(this).val());
			$('.productexpiry').css("font-family", $(this).val());
		});
		$("#background-color").change(function(){
			newqrcode();
		});

		$('input[type="range"]').rangeslider({
			polyfill: false,
			rangeClass: 'rangeslider',
			fillClass: 'rangeslider__fill',
			handleClass: 'rangeslider__handle',
			onSlide: newqrcode,
			onSlideEnd: newqrcode
		});
		newqrcode();
	});





	var dts={}
	var productdatatable=$("#rackproducts").DataTable({});
	function pad($n) {
		var str = "" + $n
		var pad = "00000"
		var ans = pad.substring(0, pad.length - str.length) + str
		return ans
	}
	function get_rack_product_data($rack_no,$warehouse_id) {
		var url="{{url("warehouse/rack/products",$selluser->id)}}";
		productdatatable.destroy();
		data={warehouse_id:$warehouse_id,rack_no:$rack_no};
		$.ajax({
			url:url,
			type:"POST",
			data:data,
			success:function(r){

				if (r.status=="success") {

					data=r.data;
					var html="";
					var serial_number=0;
					for (var i =0;i<data.length;i++) {
						d=data[i];
						serial_number=i+1;
						if (d.name!=null) {
							html+=`
							<tr>
							<td class="text-center">`+serial_number+`</td>
							<td class="text-left">
							<img 
							style='height:30px;width:30px;object-fit:"contain"'
							src="`+JS_BASE_URL+`/images/product/`+d.id+`/thumb/`+d.thumb_photo+`"/>
							<a class="" rel-data="`+d.id+`"
							href="`+JS_BASE_URL+`/productconsumer/`+d.id+`"
							target="_blank"
							>`+d.name+`</a></td>
							<td class="text-center"><a href="javascript:void(0)">`+d.quantity+`</a></td>
							<td class="text-center">`+d.expiry_date+`</td>

							</tr>
							`;
						}
					}
					
					
					
					$("#tbody_rp").text("");
					$("#tbody_rp").append(html);
					productdatatable=$("#rackproducts").DataTable({});
					
				}
			}
		})
	}
	function get_rack_data($warehouse_id) {
		var post="{{$selluser->id}}";
		var url="{{url("warehouse/rack")}}"+"/"+$warehouse_id;
		url+="/"+post;
		$.ajax({
			url:url,
			type:"GET",
			success:function(r){
				if (r.status=="success") {
					data=r.data;
					var html="";
					var serial_number=0;
					for (var i =0;i<data.length;i++) {
						d=data[i];
						serial_number+=1;
						html+=`
						<tr>
						<td class="text-center">`+serial_number+`</td>
						<td class="text-center"><a class="showqrrackmodal" rel-data="`+d.rack_no+`">`+pad(d.rack_no)+`</a></td>
						<td class="text-center"><a class='show_product_names'
						rel-warehouseid="`+$warehouse_id+`"
						rel-rackno="`+d.rack_no+`"
						href="javascript:void(0)">`+d.product_count+`</a></td>
						<td class="text-center">`+d.expiry_date+`</td>

						</tr>
						`;
					}
					if (serial_number==0) {
						html=`<tr>
						<td></td>
						<td class="" style="width:43%;text-align:right !important">No records found...</td>
						<td></td>
						<td></td>


						</tr>;
						`
					}
					$("#tbody_"+$warehouse_id).append(html);
					tmp=$("#table_"+$warehouse_id).DataTable({
						autoWidth:false
					});
				
					dts[$warehouse_id]=tmp;
				}
			}
		})
	}
	$(document).ready(function(){
		@foreach($warehouses as $warehouse)
		get_rack_data({{$warehouse->warehouse_id}})
		@endforeach
		
		$("body").on("click",".showqrrackmodal",function(){

			$rack_no=$(this).attr("rel-data");


			$('#userInput').attr('value',pad($rack_no));
			$('#description').attr('value','Rack No. ' + pad($rack_no));
            $('.productname').html(('Rack No. ' + pad($rack_no)).bold());
			$("#racknomodal").text($rack_no);
			$("#rackModal").modal("show");
			/*$.ajax({
			type: "GET",
			url: JS_BASE_URL+"/seller/warehouse/qr/"+$rack_no,
			success: function( data ) {
				$('.rack_modal-body').html(data);
				$("#rackModal").modal("show");
			}
		});*/



			/*$('#qrcode').qrcode(
				{width:110,height:110,text:$rack_no}
			);
			
			canvas=document.querySelector('canvas');
		
			var ctx=canvas.getContext("2d");

 			ctx.font="18px Arial";
 			ctx.fillText("Rack No. 123",0,130);
 			
 			
			$("#racknomodal").text($rack_no);
			$("#rackModal").modal("show");*/

		});
		$("body").on("click",".show_product_names",function(){
			$rack_no=$(this).attr("rel-rackno");
			$warehouse_id=$(this).attr("rel-warehouseid");
			get_rack_product_data($rack_no,$warehouse_id);
			$("#productModal").modal("show");

		});
		$(".saverack").click(function(){
			var url ="{{url("seller/rack",$selluser->id)}}";
			/*var rack_no=$("#rack_no").val();
			if (!rack_no) {
				alert("Rack Number is required");
				return;
			}*/
			var data={
				warehouse_id:$(this).attr("rel-warehouseid")
			};

			$.ajax({
				url:url,
				type:"POST",
				data:data,
				success:function(r){
					if (r.status=="success") {
						/*				$("#rackModal").modal("hide");*/
						toastr.info("Rack added!");
						$("#tbody_"+data.warehouse_id).text("");

						dts[data.warehouse_id].clear().destroy();
						get_rack_data(data.warehouse_id);

					}else{
						toastr.warning(r.long_message);
					}
				},
				error:function(){
					toastr.warning("Could not connect to server!");
				}
			});
		});
		/*$('.warehousedatatable').DataTable({});*/
	});
</script>
<script type="text/javascript" src="{{asset('js/rangeslider.js')}}"></script>

@stop
