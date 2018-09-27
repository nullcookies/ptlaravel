<!DOCTYPE html>
<html>
@include('common.head')
<style>
	.fairbutton{
		font-size: 45px;
		background-color: #FF3333 !important;
		padding: 40px 30px 40px 30px;
		margin-top: 15px;
		font-weight: bold;
	}
	#fairemail{
		height: 50px !important;
		background-color: #F8F2F1 !important;
	}
</style>
<body style="background-color: #FFFFFF; width: 100%; height: 100%;">
	<div class="modal-body" id="fairmodalbody">
		<div id="myBody" style="display: none;">
			<div class="col-xs-12" class="nomobile" style="margin-bottom: 10px;">
				<span class="closew" style="border: solid 1px black; padding: 4px; cursor: pointer; color: black; font-size: 30px;">X</span>
			</div>		
			<div id="products">
				<div class="col-xs-4 no-padding" class="nomobile">
					<p ><b>Sales&nbsp;Memo</b></p>
				</div>
				<div class="col-xs-4 no-padding" class="nomobile">
					<p class="pull-right"><b>Qty</b></p>
				</div>
				<div class="col-xs-4 no-padding" class="nomobile">
					<p class="pull-right"><b>Price</b></p>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="clearfix"></div>
			<div class="col-xs-4 no-padding" class="nomobile">
				&nbsp;
			</div>
			<div class="col-xs-4 no-padding" class="nomobile">
				<p class="pull-right"><b>Total</b></p>
			</div>
			<div class="col-xs-4 no-padding" class="nomobile">
				<p class="pull-right"><b id="btotal">0.00</b></p>
			</div>
			<br>
			<br>
			<br>
			<br>
			<div class="clearfix"></div>
			<div class="col-xs-12 no-padding" height="60px">
				<div id="addmore" onclick="" width="100%" style="background-color: #01FE02; height: 50px; padding-top: 1px;">
					<h3 style='color: white; margin-top: 10px;' align="center">Add More</h3>
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="col-xs-12 no-padding" height="60px">
				<div id="createsalesmemo" onclick="" width="100%" style="background-color: #6666FF; height: 50px; padding-top: 1px;">
					<h3 style='color: white; margin-top: 10px;' align="center">Create Sales Memo</h3>
				</div>
			</div>			
		</div>
		<div id="myBody2" style="">
			<div class="col-xs-12" class="nomobile" style="margin-bottom: 10px;">
				<span class="closew" style="border: solid 1px black; padding: 4px; cursor: pointer; color: black; font-size: 30px;">X</span>
			</div>
			<div class="clearfix"></div>
			<div class="row no-padding" style="height: 80px !important;">
				<div class="col-xs-4 no-padding" class="nomobile" height="50px">
					<div id="productimg" width="100%" style="background-color: #660066;"></div>
				</div>
				<div class="col-xs-4 no-padding" class="nomobile" height="50px">
					<div id="productqr" width="100%" style="background-color: #262626;"></div>
				</div>
				<div class="col-xs-4 no-padding" id="tspan" class="nomobile" height="50px" style="cursor: pointer; height: 50px !important;">
					<div id="productscan" onclick="" style="background-color: #604A7B; height: 80px !important; padding-top: 1px;">
						<h3 style='color: white; margin-top:22px;' align="center">Scanner</h3>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="col-xs-4 no-padding" class="nomobile">
				<p >Product&nbsp;ID</p>
			</div>
			<div class="col-xs-8 no-padding">
				<span id="spanpid" ></span>
			</div>
			<div class="clearfix"></div>
			<div class="col-xs-4 no-padding" class="nomobile">
				<p >Name</p>
			</div>
			<div class="col-xs-8 no-padding">
				<span id="spanpname" ></span>
			</div>
			<div class="clearfix"></div>
			<div class="col-xs-4 no-padding" class="nomobile">
				<p >Qty</p>
			</div>
			<div class="col-xs-8 no-padding">
				<span id="spanqty"><input type="text" class="form-control" value="1" id="inputqty" /></span>
			</div>
			<div class="clearfix"></div>
			<div class="col-xs-4 no-padding" class="nomobile">
				<p >Qty&nbsp;Ordered</p>
			</div>
			<div class="col-xs-8 no-padding">
				<span id="spanpqtyordered" ></span>
			</div>
			<div class="clearfix"></div>
			<div class="col-xs-4 no-padding" class="nomobile">
				<p >Price</p>
			</div>
			<div class="col-xs-8 no-padding">
				<span id="spanprice"><input type="text" class="form-control" value="0" id="inputprice" /></span>
			</div>			
			<div class="clearfix"></div>
			<br>
			<br>
						
			<div class="col-xs-12 no-padding" height="60px">
				<div id="addproduct" onclick="" width="100%" style="background-color: #01FE02; height: 50px; padding-top: 1px;">
					<h3 style='color: white; margin-top: 10px;' align="center">Add To Sales Memo</h3>
				</div>
			</div>
			<input type="hidden" id="fairrecruiter" value="{{$recruiter}}" />
			<input type="hidden" id="fairmerchant" value="{{$merchant}}" />
			<input type="hidden" id="fairlocation" value="{{$location}}" />
		</div>
		<div id="myBodyScann" style="display: none;">
			<div class="col-xs-12 no-padding" style="margin-top: 25px;">
				<p align="center" style="color: white">We don't have scanning available yet, please select your product manually
			</div>
			<div class="col-xs-12 no-padding">
				<select id="merchantproduct">
					<option value="0">Choose Option...</option>
					@foreach($products as $product)
						<option value="{{$product->id}}">{{$product->name}}</option>
					@endforeach
				</select>
			</div>
		</div>
	</div>	
</body>	
<script type="text/javascript">
	function svalidateEmail(email) {
		var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return re.test(email);
	}
    $(document).ready(function(){
		$(document).delegate( '#addmore', "click",function (event) {
			$("#myBody").hide();
			$("#myBody2").show();
			$( "body" ).css('background-color','#FFFFFF');
		});
		
	//	var width = $( "#productscan" ).width() - 12;
	//	$( "#productscan" ).height(width);
		//console.log(width);
		$("#inputqty").number(true,0);
		$("#inputprice").number(true,2,'.','');
		
		$(document).delegate( '#productscan', "click",function (event) {
			$("#myBody2").hide();
			$("#myBodyScann").show();
		});
		
		var auxproduct;
		$(document).delegate( '#addproduct', "click",function (event) {
			$("#products").append('<div class="col-xs-4 no-padding" class="nomobile"><img style="width: 100%;" src="'+JS_BASE_URL+'/images/product/'+auxproduct.id+'/'+auxproduct.photo_1+'" /></div><div class="col-xs-4 no-padding" class="nomobile"><p class="pull-right">'+$("#inputqty").val()+'</p><br><br><p style="margin-left: 3px;">'+auxproduct.name+'</p></div><div class="col-xs-4 no-padding" class="nomobile"><p class="pull-right">'+js_number_format($("#inputprice").val(),2,'.','')+'</p></div><input type="hidden" name="id[]" value="'+auxproduct.id+'" /><input type="hidden" name="qty[]" value="'+$("#inputqty").val()+'" /><input type="hidden" name="price[]" value="'+$("#inputprice").val()+'" /><div class="clearfix"></div>');
			var n = $("input[name^='price']").length;
			var array = $("input[name^='price']");
			var arrayq = $("input[name^='qty']");
			var total = 0;
			for(i=0;i<n;i++)
			{
				 price =  parseFloat(array.eq(i).val());
				 qty =  parseInt(arrayq.eq(i).val());
				 total += (price * qty);
				 console.log(price);
			}
			$("#btotal").html(js_number_format(total,2,'.',''));
			$("#myBody").show();
			$("#myBody2").hide();
			$( "body" ).css('background-color','#FFFFFF');
		});
		
		$(document).delegate( '#merchantproduct', "change",function (event) {
			var val = $(this).val();
			if(val == "0"){
				toastr.warning("Please, choose a product");
			} else {
				$.ajax({
					type: "GET",
					url: JS_BASE_URL + "/salesmemo/productinfo/" + val,
					dataType: 'json',
					success: function (data) {
						console.log(data);
						auxproduct = data;
						$("#productimg").html("<img style='width: 100%; height: 100%;' src='"+JS_BASE_URL+"/images/product/"+data.id+"/"+data.photo_1+"' />");
						$("#productqr").html("<img style='width: 100%; height: 100%;' src='"+JS_BASE_URL+"/images/qr/product/"+data.id+"/"+data.qrphoto+".png' />");
						$("#spanpid").html(data.nproductid);
						$("#spanpname").html(data.name);
						$("#spanpqtyordered").html(data.qtyordered);
						$("#inputprice").val(data.retail_price);
						//$("#inputqty").val(data.available);
						$("#myBody2").show();
						$("#myBodyScann").hide();
					},
					error: function (error) {
						fairbutton.html('Store');
						toastr.error("An unexpected error ocurred");
					}

				});					
			}
		});
		$(document).delegate( '#fairmerchant', "change",function (event) {
			if($(this).val() == "0"){
				
			} else {
				var userid = $("#fairmerchant").val();
				var fairrecruiter = $("#fairrecruiter").val();
				window.open(JS_BASE_URL + '/fairmode/' + userid + '/' + fairrecruiter);
			}
		});
		$(document).delegate( '.closew', "click",function (event) {
			console.log("HOLA");
			window.location = JS_BASE_URL + '/buyer/mobstaff/' + $("#fairrecruiter").val(); 
		});
		$(document).delegate( '#createsalesmemo', "click",function (event) {
			console.log("passss");
			var salesmemo = $(this);
			salesmemo.html("<h3 style='color: white; margin-top: 10px;' align='center'>Saving...</h3>");
			var userid = $("#fairmerchant").val();
			var fairrecruiter = $("#fairrecruiter").val();
			var fairlocation = $("#fairlocation").val();
			var array = $("input[name^='price']");
			var arrayq = $("input[name^='qty']");
			var arrayi = $("input[name^='id']");
			var n = $("input[name^='price']").length;
			var total = 0;
			var pricesarr = [];
			var qtyarr = [];
			var idsarr = [];
			for(i=0;i<n;i++)
			{
				 pricesarr[i] =  parseFloat(array.eq(i).val());
				 qtyarr[i] =  parseInt(arrayq.eq(i).val());
				 idsarr[i] =  parseInt(arrayi.eq(i).val());
			}
			console.log(pricesarr);
			$.ajax({
				type: "POST",
				data: {userid: userid, recruiter: fairrecruiter, location: fairlocation, prices: pricesarr, qty: qtyarr, ids: idsarr},
				url: JS_BASE_URL + "/salesmemo/createsalesmemo",
				dataType: 'json',
				success: function (data) {
					toastr.info("Sales Memo succesfully saved!");
					console.log(data);
					setTimeout(function(){ window.location = JS_BASE_URL + '/salesmemo/' + data.id }, 1000)
					//$("#myModalFair").modal('toggle');
				},
				error: function (error) {
					salesmemo.html("<h3 style='color: white; margin-top: 10px;' align='center'>Create Sales Memo</h3>");
					toastr.error("An unexpected error ocurred");
				}

			});				
				
		});
    });
</script>	

</html>
