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
<body style="background-color: #A9C9CA; width: 100%; height: 100%;">
	<div class="modal-body" id="fairmodalbody">
		<div id="myBody2">
			<div class="col-md-12" class="nomobile">
				<span class="closew" style="border: solid 1px black; padding: 4px; cursor: pointer; color: black; font-size: 30px;">X</span>
			</div>
			<div class="clearfix"></div>
			<div class="col-md-3" class="nomobile">
				&nbsp;
			</div>
			<div class="col-md-6">
				
				<p style="float: left"><img src="{{asset('images/category/OpenSupermall Official Logo PNG.png')}}" width="100%" alt="Logo">
					
				</p>
			</div>
			<div class="col-md-3" class="nomobile">
				&nbsp;
			</div>
			<div class="clearfix"></div>
			<br>
			<br>
			<br>
			<br>
			<br>
			<div class="col-md-2" class="nomobile">
				&nbsp;
			</div>
			<div class="col-md-8">
				<label style="font-size: 30px;">Fair Mode</label>
				<input type="text" id="fairemail" placeholder="Please, enter email" class="form-control">
			</div>
			<div class="col-md-2" class="nomobile">
				&nbsp;
			</div>
			<div class="clearfix"></div>
			<div class="col-md-2" class="nomobile">
				&nbsp;
			</div>
			<div class="col-md-8">
				<p align="center"><a href="javascript:void(0)" class='btn btn-info fairbutton'>Store</a></p>
			</div>
			<div class="col-md-2" class="nomobile">
				&nbsp;
			</div>
			<input type="hidden" id="fairrecruiter" value="{{$recruiter}}" />
			<input type="hidden" id="fairmerchant" value="{{$merchant}}" />
		</div>
	</div>	
<script type="text/javascript">
	function svalidateEmail(email) {
		var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return re.test(email);
	}
    $(document).ready(function(){
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
</body>
</html>
