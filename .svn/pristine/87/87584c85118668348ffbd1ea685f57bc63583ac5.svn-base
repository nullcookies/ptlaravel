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
<body style="background-color: #6666FF; width: 100%; height: 100%;">
	<div class="modal-body" id="fairmodalbody">
		<div id="myBody2">
			<div class="col-xs-12" class="nomobile" style="margin-bottom: 10px;">
				<span class="closew" style="border: solid 1px black; padding: 4px; cursor: pointer; color: black; font-size: 30px;">X</span>
			</div>
			<div class="clearfix"></div>
			<div class="col-xs-4 no-padding" class="nomobile">
				<div id="productimg" width="100%" style="background-color: #660066;"></div>
			</div>
			<div class="col-xs-4 no-padding" class="nomobile" height="50px">
				<div id="productqr" width="100%" style="background-color: #262626;"></div>
			</div>
			<div class="col-xs-4 no-padding" id="tspan" class="nomobile" height="50px" style="cursor: pointer;">
				<div id="productscan" width="100%" style="background-color: #604A7B; height: 80px; padding-top: 1px;">
					<h3 style='color: white; margin-top:32px;' align="center">Scanner</h3>
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="col-xs-4 no-padding" class="nomobile">
				<p style='color: white;'>Product&nbsp;ID</p>
			</div>
			<div class="col-xs-8 no-padding">
				<span id="spanpid"></span>
			</div>
			<div class="clearfix"></div>
			<div class="col-xs-4 no-padding" class="nomobile">
				<p style='color: white;'>Name</p>
			</div>
			<div class="col-xs-8 no-padding">
				<span id="spanpname"></span>
			</div>
			<div class="clearfix"></div>
			<div class="col-xs-4 no-padding" class="nomobile">
				<p style='color: white;'>Qty</p>
			</div>
			<div class="col-xs-8 no-padding">
				<span id="spanqty"><input type="text" class="form-control" value="0" id="inputqty" /></span>
			</div>
			<div class="clearfix"></div>
			<div class="col-xs-4 no-padding" class="nomobile">
				<p style='color: white;'>Qty&nbsp;Ordered</p>
			</div>
			<div class="col-xs-8 no-padding">
				<span id="spanpqtyordered"></span>
			</div>
			<div class="clearfix"></div>
			<br>
			<br>
						
			<div class="col-xs-6 no-padding" height="60px">
				<div id="productplus" width="100%" style="background-color: #558ED5;">
					<h2 style='color: #01FE02;' align="center">+</h2>
				</div>
			</div>
			<div class="col-xs-6 no-padding" height="60px">
				<div id="productminus" width="100%" style="background-color: #8EB4E3;">
					<h2 style='color: white;' align="center">-</h2>
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="col-xs-12 no-padding" height="60px">
				<div id="productstock" width="100%" style="background-color: #01FE02; height: 50px; padding-top: 1px;">
					<h3 style='color: white; margin-top: 10px;' align="center">Stock Take</h3>
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
		var width = $( "#productscan" ).width() - 12;
		$( "#productscan" ).height(width);
		console.log(width);
		$("#inputqty").number(true,0);
		$(document).delegate( '#productplus', "click",function (event) {
			var val = parseInt($("#inputqty").val());
			val++;
			$("#inputqty").val(val);
		});
	
		$(document).delegate( '#productminus', "click",function (event) {
			var val = parseInt($("#inputqty").val());
			val--;
			if(val >= 0){
				$("#inputqty").val(val);
			}
		});
		
		$(document).delegate( '#productscan', "click",function (event) {
			$("#myBody2").hide();
			$("#myBodyScann").show();
		});
		
		$(document).delegate( '#merchantproduct', "change",function (event) {
			var val = $(this).val();
			if(val == "0"){
				toastr.warning("Please, choose a product");
			} else {
				$.ajax({
					type: "GET",
					url: JS_BASE_URL + "/stocktake/productinfo/" + val,
					dataType: 'json',
					success: function (data) {
						console.log(data);
						$("#productimg").html("<img style='width: 100%; height: 100%;' src='"+JS_BASE_URL+"/images/product/"+data.id+"/"+data.photo_1+"' />");
						$("#productqr").html("<img style='width: 100%; height: 100%;' src='"+JS_BASE_URL+"/images/qr/product/"+data.id+"/"+data.qrphoto+".png' />");
						$("#spanpid").html(data.nproductid);
						$("#spanpname").html(data.name);
						$("#spanpqtyordered").html(data.qtyordered);
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
			window.close();
		});
		$(document).delegate( '.fairbutton', "click",function (event) {
			console.log("passss");
			var fairbutton = $(this);
			fairbutton.html('Saving...');
			var email = $("#fairemail").val();
			var userid = $("#fairmerchant").val();
			var fairrecruiter = $("#fairrecruiter").val();
			if(svalidateEmail(email) && parseInt(userid) > 0){
				//console.log(lpid);
				$.ajax({
					type: "POST",
					data: {email: email, userid: userid, recruiter: fairrecruiter},
					url: JS_BASE_URL + "/seller/member/add_employee/fair",
					dataType: 'json',
					success: function (data) {
						console.log(data);
						if(data.status == "warning"){
							toastr.warning(data.long_message);
						}
						if(data.status == "error"){
							toastr.error(data.long_message);
						}
						if(data.status == "success"){
							toastr.info(data.long_message);
							var emails={};
							emails[0]=email;
							$.ajax({
								type: "POST",
								data: {emails: emails, userid: userid},
								url: "/seller/member/send_emails/fair",
								dataType: 'json',
								success: function (data) {
									toastr.info("Email successfully sent!");
									//obj.html("Execute");
								},
								error: function (error) {
									toastr.error("An unexpected error ocurred sending the email! Please contact OpenSupport!");
									//obj.html("Execute");
								}

							});	
						}
						$("#fairemail").val("");
						fairbutton.html('Store');
						//$("#myModalFair").modal('toggle');
					},
					error: function (error) {
						fairbutton.html('Store');
						toastr.error("An unexpected error ocurred");
					}

				});				
				
			} else {
				fairbutton.html('Store');
				if(!svalidateEmail(email)){
					if(email != ""){
						toastr.error("Invalid email! Please, type a valid email.");
					} else {
						toastr.error("Please, type in email");
					}
				}
				if(parseInt(userid) == 0){
					toastr.error("Please, select one merchant!");
				}
			}
		});
    });
</script>	

</html>
