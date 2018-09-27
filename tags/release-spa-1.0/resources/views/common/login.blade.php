<?php 
	$cf = new \App\lib\CommonFunction();
	use App\Http\Controllers\IdController;
	$selectListForBusinessType =  $cf->getBusinessType();
	use App\Classes;

	define("EMPLOYEE_BENEFIT_COVER", "employee_benefit_cover.png");
	define("FAIRMODE_COVER", "fairmode_cover.png");

?>
<style>
#registe_rForm_log .has-error .control-label,
#registe_rForm_log .has-error .help-block,
#registe_rForm_log .has-error .form-control-feedback {
    color: yellow;
	font-weight: bold;
}

#registe_rForm_log .has-success .control-label,
#registe_rForm_log .has-success .help-block,
#registe_rForm_log .has-success .form-control-feedback {
    color: #00f300;
	font-weight: bold;
}
 

.signInBtnnew {
    background: #0BEDC0;
    border-radius: 5px !important;
    color: #fff;
    padding: 8px 25px;
	width: 100%;
	font-size: 25px;
}

.signInBtnmerch22 {
    background: #0BEDC0;
    border-radius: 5px !important;
    color: #fff;
    padding: 8px 25px;
	width: 100%;
	font-size: 25px;
}


/* The Modal (background) */
.modalwow, .modalwsmm, .modalwow_mob, .modalwsmm_mob, .modalwep, .modalwfm {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 10000; /* Sit on top */
    padding-top: 45px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(20,20,20); /* Fallback color */
    background-color: rgba(20,20,20,0.9); /* Black w/ opacity */
}

/* Modal Content (Image) */
.modal-contentwow, .modal-contentwsmm, .modal-contentwow_mob, .modal-contentwsmm_mob, .modal-contentwep, .modal-contentwfm{
    margin: auto;
    display: block;
    width: 1020px;
	background-color: #000 !important;
	border-radius: 20px !important;
}

@-webkit-keyframes zoom {
    from {-webkit-transform:scale(0)} 
    to {-webkit-transform:scale(1)}
}

@keyframes zoom {
    from {transform:scale(0)} 
    to {transform:scale(1)}
}

/* The Close Button */
.closewow, .closewsmm, .closewow_mob, .closewsmm_mob, .closewep, .closewfm {
    position: absolute;
    top: 15px;
    right: 35px;
    color: #fefefe;
    font-size: 40px;
    font-weight: bold;
    transition: 0.3s;
}

.closewow:hover,
.closewow:focus {
    color: #fff;
    text-decoration: none;
    cursor: pointer;
}

.closewsmm:hover,
.closewsmm:focus {
    color: #fff;
    text-decoration: none;
    cursor: pointer;
}

.closewow_mob:hover,
.closewow_mob:focus {
    color: #fff;
    text-decoration: none;
    cursor: pointer;
}

.closewsmm_mob:hover,
.closewsmm_mob:focus {
    color: #fff;
    text-decoration: none;
    cursor: pointer;
}

.closewep:hover,
.closewep:focus {
    color: #fff;
    text-decoration: none;
    cursor: pointer;
}

.closewfm:hover,
.closewfm:focus {
    color: #fff;
    text-decoration: none;
    cursor: pointer;
}


/* 100% Image Width on Smaller Screens */
@media only screen and (max-width: 700px){
    .modal-contentwow, .modal-contentwsmm, .modal-contentwep, .modal-contentwfm {
        width: 100%;
    }
}
</style>
<script>
$(document).ready(function(){
	$('.what_ow').on('click', function(){
		console.log("WHAT");
		var modal = document.getElementById('myModalwow');
		modal.style.display = "block";
		
		var span = document.getElementById("closemodalwowimg");

		span.onclick = function() { 
			modal.style.display = "none";
		}
	});
	
	$('.what_ow_mob').on('click', function(){
		console.log("WHAT");
		var modal = document.getElementById('myModalwow_mob');
		modal.style.display = "block";
		
		var span = document.getElementById("closemodalwowimg_mob");

		span.onclick = function() { 
			modal.style.display = "none";
		}
	});	
	
	$('.showlogin').on('click', function(){
		$('.modal-inside').css('background-color', 'rgba(26,188,156,0.7)');
		$("#registerFormDeskto").hide();
		$("#loginFormDeskto").show();
	});
	
	$('.showregister').on('click', function(){
		var relrole = $(this).attr('rel');
		$("#reg_role").val(relrole);
		console.log(relrole);
		if(relrole == 'buyer'){
			$('.onlybuyer').show();
			$('.onlystation').hide();
			$('.modal-inside').css('background-color', 'rgba(26,188,156,0.7)');
		} else if(relrole == 'station') {
			$('.onlybuyer').hide();
			$('.onlystation').show();
			$('.modal-inside').css('background-color', 'rgba(78, 46, 40,0.9)');
		}
		$("#registerFormDeskto").show();
		$("#loginFormDeskto").hide();
	});	
	
	$('.what_smm').on('click', function(){
		var modal = document.getElementById('myModalwsmm');
		modal.style.display = "block";
		
		var span = document.getElementById("closemodalwsmmimg");

		span.onclick = function() { 
			modal.style.display = "none";
		}
	});
	
	$('.show_ep').on('click', function(){
		var modal = document.getElementById('myModalwep');
		modal.style.display = "block";
		
		var span = document.getElementById("closemodalwepimg");

		span.onclick = function() { 
			modal.style.display = "none";
		}
	});
	
	$('.hide_ep').on('click', function(){
		var modal = document.getElementById('myModalwep');
		modal.style.display = "none";
	});
	
	$('.hide_fm').on('click', function(){
		var modal = document.getElementById('myModalwfm');
		modal.style.display = "none";
	});

	$('.show_fm').on('click', function(){
		var modal = document.getElementById('myModalwfm');
		modal.style.display = "block";
		
		var span = document.getElementById("closemodalwfmimg");

		span.onclick = function() { 
			modal.style.display = "none";
		}
	});	
	
	$('.what_smm_mob').on('click', function(){
		var modal = document.getElementById('myModalwsmm_mob');
		modal.style.display = "block";
		
		var span = document.getElementById("closemodalwsmmimg_mob");

		span.onclick = function() { 
			modal.style.display = "none";
		}
	});	

	$('#termslogin').on('click', function(){
		var tcModal_url=JS_BASE_URL+"/tc/modal/buy";
		$('#tcModal').modal('show').find('.modal-body').load(tcModal_url);
	});
	
	$('#merchnextf').on('click', function(){
		var mfirstname = $("#mfirstname").val();
		var mlastname = $("#mlastname").val();
		var memail = $("#memail").val();
		var mmobile = $("#mmobile").val();
		var mpassword = $("#mpassword").val();
		var mconfirm_password = $("#mconfirm_password").val();
		//var firstname = $("#mfirstname").val();
		if(mfirstname == "" || mlastname == "" || memail == "" || mmobile == "" || mpassword == "" || mconfirm_password == "" ){
			toastr.error("All fields are mandatory");
		} else {
			if(mpassword != mconfirm_password){
				toastr.error("Passwords don't match");
			} else {
				var formData = {
					email: memail,
					mfirstname: mfirstname,
					mlastname: mlastname,
					mmobile: mmobile,
				}
				$.ajax({
					type: "post",
					url: JS_BASE_URL + '/create_new_user_wizard',
					cache: false,
					data: formData,
					//dataType: 'json',
					success: function (data) {
						console.log(data);				
					},
					error: function (responseData, textStatus, errorThrown) {
						console.log(errorThrown);
					}
				});	
				$(".login-content-first").hide();
				$(".login-content-second").show();
			}
		}
	});
	
	$('#merchbackf').on('click', function(){
		$(".login-content-first").show();
		$(".login-content-second").hide();
	});
	
	$('#merchnexts').on('click', function(){
		$(".login-content-third").show();
		$(".login-content-second").hide();
	});
	
	$('#merchbacks').on('click', function(e){
		console.log("SUBMITTTT 2");
		e.stopPropagation();
        e.preventDefault();
		$('#registerMerchantModal').modal('toggle');
		var formData = new FormData($("#registe_rForm_log")[0]);
		console.log(formData);
		$.ajax({
			type: "post",
			url: JS_BASE_URL + '/disagree_new_user_log',
			data: formData,
			processData: false,
			contentType: false,
			success: function (data) {							
			},
			error: function (responseData) {
				toastr.error('An unexpected error ocurred, please, contact OpenSupport.');	
			}
		});	
	});
	
	$('#merchnextt').on('click', function(e){
		$('#merchnextt').html("Saving...");
		console.log("SUBMITTTT");
		e.stopPropagation();
        e.preventDefault();
		var formData = new FormData($("#registe_rForm_log")[0]);
		console.log(formData);
		$.ajax({
			type: "post",
			url: JS_BASE_URL + '/create_new_user_log',
			data: formData,
			processData: false,
			contentType: false,
			success: function (data) {
				toastr.info('You were successfully registered. Please, check your email for the confirmation link.');	
				$('#merchnextt').html("Agree");
				$('#registerMerchantModal').modal('toggle');
				
			},
			error: function (responseData) {
				toastr.error('An unexpected error ocurred, please, contact OpenSupport.');	
			}
		});			
		/*$("#registe_rForm_log").submit(function(e){
			console.log("passs 2");
			e.preventDefault();
			$(".login-content-third").show();
			$(".login-content-second").hide();
		});*/
	});	
	
	$('#termslogin4').on('click', function(){
		var tcModal_url=JS_BASE_URL+"/tc/modal/buy";
		$('#tcModal').modal('show').find('.modal-body').load(tcModal_url);
	});
});
$(window).scroll(function() {
	 /*var scroll = $(window).scrollTop();
	if(scroll > 100){
		$('#ahr').show(1000);
	}if(scroll <= 100){
		$('#ahr').hide(1000);
	}
*/
});
    
</script>

<div id="myModalwsmm" class="modalwsmm">
  <span class="closewsmm" id="closemodalwsmmimg">&times;</span>
  <a href="{{URL::to('/')}}/show_register"><img class="modal-contentwsmm" src="{{asset('images/what_is_smm.jpg')}}"></a>
  
</div>

<div id="myModalwow" class="modalwow">
  <span class="closewow" id="closemodalwowimg">&times;</span>
  <a href="{{URL::to('/')}}/show_register"><img class="modal-contentwow" src="{{asset('images/what_is_openwish.jpg')}}"></a>
</div>

<div id="myModalwfm" class="modalwfm">
  <span class="closewfm" id="closemodalwfmimg">&times;</span>
  <a href="#" data-toggle="modal" class="role_type_log hide_fm" rel="fairmode"
	data-target="#registerMerchantModal">
	<img class="modal-contentwfm"
	src="{{asset('images/'.FAIRMODE_COVER)}}"></a>
</div>

<div id="myModalwep" class="modalwep">
  <span class="closewep" id="closemodalwepimg">&times;</span>
  <a href="#" data-toggle="modal" class="role_type_log hide_ep" rel="humancap"
  	data-target="#registerMerchantModal">
	<img class="modal-contentwep"
	src="{{asset('images/'.EMPLOYEE_BENEFIT_COVER)}}"></a>
</div>

<div id="myModalwsmm_mob" class="modalwsmm_mob">
  <span class="closewsmm_mob"
	id="closemodalwsmmimg_mob">&times;</span>
  <img class="modal-contentwsmm_mob"
  	style="width:93%;margin-top:15px"
  	src="{{asset('images/what_is_smm_mob.png')}}">
</div>

<div id="myModalwow_mob" class="modalwow_mob">
  <span class="closewow_mob" id="closemodalwowimg_mob">&times;</span>
  <img class="modal-contentwow_mob"
  	style="width:93%;margin-top:15px"
  	src="{{asset('images/what_is_openwish_mob.png')}}">
</div>

<div class='form-modal '>
    <div class="modal fade" id='registerMerchantModal'>
        <div class="modal-dialog" style="width: 1250px !important">
            <div class="modal-content" >
                <div class="modal-body">
				    <?php 
						$routem = route('create-new-user-plog');
						$indication = "merchant";					
					?>
					{!! Form::open(array('url'=> $routem , 'files' => 'true',
					'method'=>'post', 'id'=>'registe_rForm_log' ,
					'class'=> 'form-horizontal',
					'style'=>'margin-top:0')) !!}
                    <button class="close" data-dismiss="modal" type="button"><span>&times;</span></button>
					
                    <div class="col-md-12 modal-inside-merchant" style="padding: 15px;">
						<div class="login-content-first">
						   <p align="center">
						   <img style="margin-left:-20px"
							src="{{asset('images/logo-white.png')}}"
							alt="Logo" width="250px"
							style=""></p>
							<br>
                                <div id="error-msg-reg"
								style="color: #FFD6D6;"
								class="text-center text-danger error-msg-reg">
								 </div>
								<div id="success-msg-reg"
								style="color: #0fff6d;"
								class="text-center text-danger success-msg-reg">
                                                            
                                </div>
                                <div class="form-group">
								<div class="col-md-3">
									</div>
                                    <div class="col-md-6" style='padding-left:0;padding-right:0'>
                                        <input class="form-control input-sm" name="firstname" id="mfirstname"
											placeholder="First Name" type="text" style="height: 40px;"
											data-bv-trigger="keyup" required
											data-bv-notempty-message="First Name is required" >
                                    </div>
									<div class="col-md-3">
									</div>
									<div class="clearfix"></div>
									<br>
									<div class="col-md-3">
									</div>
                                    <div class="col-md-6" style='padding-left:0;padding-right:0'>
                                        <input class="form-control input-sm" name="lastname" id="mlastname"
											placeholder="Last Name" type="text" style="height: 40px;"
											data-bv-trigger="keyup" required
											data-bv-notempty-message="Last Name is required" >
                                    </div>
									<div class="col-md-3">
									</div>
									<div class="clearfix"></div>
									<br>
									<div class="col-md-3">
									</div>
                                    <div class="col-md-6" style='padding-left:0;padding-right:0'>
                                        <input class="form-control input-sm" name="email" id="memail"
											placeholder="abc@yourmail.com" type="text" style="height: 40px;"
											data-bv-trigger="keyup" required
											data-bv-notempty-message="Email is required" >
											
											<span style="position: relative; color: black;
												display:none; font-size: 24px; font-weight: bold;"
												class="all-filter-fa"
												id="overlay_spinner_email_log">
												<i class="fa-li fa fa-spinner fa-spin fa fa-fw" ></i></span>
												
												<label id="email-error_log"
												class="error" for="email"
												style="display:none">Invalid Email</label>
                                    </div>
									<div class="col-md-3">
									</div>
									<div class="clearfix"></div>
                                </div>

								
                              <!--  <div class="height-gap"></div> -->
                                <div class="form-group">
									<div class="col-md-3">
									</div>
                                    <div class="col-md-6" style='padding-left:0;padding-right:0'>
                                        <input type='password' name="mpassword" id="mpassword" style="height: 40px;"
											class="form-control input-sm"  placeholder="Type your Password"
											data-bv-trigger="keyup" required
											data-bv-notempty-message="Password is required">
                                     </div>
									 <div class="col-md-3">
									</div>
									<div class="clearfix"></div>
									<div class="col-md-3">
									</div>
									 <div class="col-md-6" style='padding-left:0;padding-right:0'>
                                        <input type='password' name="mconfirm_password" id="mconfirm_password" style="height: 40px; margin-top: 15px;"
											class="form-control input-sm"  placeholder="Confirm your Password"
											data-bv-trigger="keyup" required
											data-bv-notempty-message="Password is required">
                                     </div>
									 <div class="col-md-3">
									</div>
									<div class="clearfix"></div>
									<div class="col-md-3">
									</div>
									 <div class="col-md-6" style='padding-left:0;padding-right:0'>
                                        <input type='text' name="mobile" id="mmobile" style="height: 40px; margin-top: 15px;"
											class="form-control input-sm"  placeholder="Mobile"
											data-bv-trigger="keyup" required
											data-bv-notempty-message="Mobile is required">
                                     </div>
									 <div class="col-md-3">
									</div>	
									<div class="clearfix"></div>
									<br>
									<div class="col-md-3">
									</div>	
									<div class="col-xs-6" style="padding-left:0;padding-right:0">
										<a href="javascript:void(0)" class='btn signInBtnmerch22' id="merchnextf">Next</a>
									</div>
									<div class="col-md-3">
									</div>										
                                </div>							
						</div>
						<input type="hidden" name="role_type" id="role_type_log" value="merchant" />
						<div class="login-content-second"
							style="display: none; color: white;">
							<div class="col-sm-10 no-padding">
								<h2>A. Company Details</h2>
							</div>
							<div class="clearfix"></div>
							<div class="form-group">
							{!! Form::label('company_name', '* Company Name',
								array('class' => 'col-sm-3 control-label')) !!}
							<div class="col-sm-4">	
							{!! Form::text('company_name','',
								array('placeholder'=>'Company Name',
								'class' => 'form-control  ','required'))!!}
							</div>
							</div>
							<div class="clearfix"></div>
							<div class="form-group">
							{!! Form::label('domicile', 'Domicile',
								array('class' => 'col-sm-3 control-label')) !!}
							<div class="col-sm-4">
							{!! Form::text('country', 'Malaysia',
								array('readonly' => 'readonly',
								'class' => 'form-control', 'id' => 'country_id')) !!}
							</div>
							</div>
							<div class="clearfix"></div>
								<div class="form-group">
									<label class="col-sm-3 control-label">Business Registration Number: </label>
									<div class="col-sm-4">
										<input type="text" class="form-control"  name="business_reg_no" value="" placeholder="Type Business Number">
									</div>
								</div>
								<div class="clearfix"></div>
						
								<div class="form-group">
									<label class="col-sm-3 control-label">Business Registration Form</label>
									<div class="col-sm-8">
										<div class="form-group" id="businessReg">
											<div class="col-sm-12 pull-left">	
											<div class="inputBtnSection">
												<input id="uploadFileBR" class="disableInputField" required="" style="color: black !important;" placeholder="Upload Document"  />
												<label class="fileUpload">
													<input name="uploadFileBRName[]" value="0" type="hidden"  />
													<span class="uploadBtn">Upload </span>
													<input id="uploadBtnBR" name="Regupload_attachment[]"  type="file" class="upload" />
												</label>
												<input name="uploadFileDoc[]" value="0" type="hidden"  />
											</div>
											<a  href="javascript:void(0);" id="addBS" class="text-green"><i class="fa fa-plus-circle fa-2x"></i></a>
											<input type="hidden" id="valaddBS" value="0">                                   
											</div>
										</div> 
									</div>
								</div>	
							<div class="clearfix"></div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Business Type: </label>
								<div class="col-sm-4" >
									{!! Form::select('business_type', $cf->getBusinessType(), null, ['class' => 'form-control', 'id' => 'bussines_type',  'required']) !!}
									</div>
							</div>    
							<div class="clearfix"></div>
							<div class="form-group">
								{!! Form::label('gst_vat', '* GST/VAT', array('class' => 'col-sm-3 control-label')) !!}
								<div class="col-sm-4">
									{!! Form::text('gst', '', array(  'placeholder'=>'Input Your GST/VAT Number', 'class' => '  form-control', 'id' => 'gstvat'))!!}
								</div>
								<div class="col-sm-1 no-padding" style="margin-top: 7px;">
									<b>No&nbsp;GST</b>
									&nbsp;<input type="checkbox" style="vertical-align: middle;" id="nogst" />
								</div>
							</div>
							
							<div class="clearfix"></div>
							
							
							
								<div id="dirDetail" >
									<div class="form-group" >
										{!! Form::label('directors', '*Directors', array('class' => 'col-sm-1 control-label')) !!}
									   <div class="col-sm-2">
											{!! Form::text('directors[]', null, array(  'placeholder'=>'Type the Name', 'class' => '  form-control','required'))!!}
										</div> 
										<div class="col-sm-3">
											<input type="text" class="form-control " name="nric[]" placeholder="Type the NRIC or Passport Number">
										</div>
										<div class="col-sm-2">
											{!! Form::select('dcountry[]',  [''=>'Nationality']+$cf->getCountry(), null, ['class' => 'form-control  ',  'required', 'id' => 'dcountry']) !!}
										</div>
										<div class="col-sm-4">
											<div class="inputBtnSection">
												<input id="uploadFileDD" class="disableInputField  " placeholder="NRIC or Passport Photo" required="" style="color: black !important;" />
												<label class="fileUpload">
													<input id="uploadBtnDD" style="color: black !important;" name="directorImages[]" type="file" class="upload  " />
													<span class="uploadBtn">Upload </span>
												</label>
											</div>
											<input name="uploadFileid[]" value="0" type="hidden"  />
											<a  href="javascript:void(0);" id="addDD" class="text-green"><i class="fa fa-plus-circle fa-2x"></i></a>
											<input type="hidden" id="valaddDD" value="0">
										</div>
									</div>
								</div>
								<div class="clearfix"></div>
								<br>

								<!--<div class="form-group">-->
								<div class="form-group">
									<label class="col-sm-3">* Address</label>
									<div class="col-sm-4">
										<input type="text" name="line1" id="line1" required="" class="form-control"  value="" >
									</div>
								</div>
								<div class="clearfix"></div>
								<div class="form-group">
									<label class="col-sm-3">&nbsp;&nbsp;</label>
									<div class="col-sm-4">
										<input type="text" name="line2" id="line2" class="form-control" value="">
									</div>
								</div>
								<div class="clearfix"></div>
								<div class="form-group">
								<label class="col-sm-3">&nbsp;&nbsp;</label>
									<div class="col-sm-4">
										<input type="text" name="line3" id="line3"  class="form-control" value="">
									</div>
								</div>
								<div class="clearfix"></div>
								<div class="form-group">
									<label class="col-sm-3">&nbsp;&nbsp;</label>
									<div class="col-sm-4">
										<input type="text" name="line4" id="line4" class="form-control" value="">
									</div>
								</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Country: </label>
										<div class="col-sm-4">

											<input type="hidden" name='country' value='150'>

											{!! Form::text('', 'Malaysia', array('value' => 150,'readonly' => 'readonly', 'class' => 'form-control', 'id' => 'country_id')) !!}
										</div>
									</div>
									<div class="clearfix"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label">* State: </label>
										<div class="col-sm-4">
											@def $states = \DB::table('state')->where('country_code', 'MYS')->get()
											<select class="form-control" id="states" required="">
												<option value="">Choose Option</option>
												@foreach($states as $state)
												<option value="{!! $state->id !!}">{!! $state->name !!}</option>
												@endforeach
											</select> 
										</div>
									</div>
									<div class="clearfix"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label">* City: </label>
										<div class="col-sm-4">
											@if(isset($userModel['address'][0]['city_id']))
											{!! Form::select('city_id', [], null, ['class' => 'form-control','required','id'=>'cities']) !!}
											@else
											<select class="form-control  " id="cities" name="city_id" required="" disabled><option value="0">Choose Option</option></select>
											@endif

										</div>
									</div>
									<div class="clearfix"></div>
									<div class="form-group">                                               
										<label class="col-sm-3 control-label">Area: </label>
										<div class="col-sm-4">
											<select class="form-control" id="areas" name="area_id" disabled>
												<option value="0">Choose Option</option>
											</select>
										</div>                          
									</div>         
									<div class="clearfix"></div>									
									<div class="form-group">
										<label class="col-sm-3 control-label">*Postcode /Zip Code</label>
										<div class="col-sm-4">
											<input type="text" name="zip" class="form-control"  value="" required="">
										</div>

									</div>                     
								<input id="geoip_lat" name="geoip_lat" value="" type="hidden" />
								<input id="geoip_lon" name="geoip_lon" value="" type="hidden" />
						  <div class="clearfix"></div>
						  <div class="form-group">
							<label class="col-sm-3 control-label">Website:</label>
							<div class="col-sm-4 col-xs-10">                                
								<input type="url" name="website[]" class="form-control" value=""  placeholder="http://www.abc.com.my">
							</div>  
							 <div class="col-xs-1" style="padding-left:0">								
								<a  href="javascript:void(0);" id="addWSlog" class="text-green" ><i class="fa fa-plus-circle fa-2x"></i></a>
							</div>
							
						  </div>
						  <div id="website"></div>
						  <div class="form-group">
							<label class="col-sm-3 control-label">Social Media:</label>
							<div class="col-sm-4 col-xs-10">                                    
								<input type="url" name="social[]" class="form-control" value=""  placeholder="http://www.abc.com.my">
							</div>
							<div class="col-xs-1" style="padding-left:0">
								
								<a  href="javascript:void(0);" id="addSMlog" class="text-green"><i class="fa fa-plus-circle fa-2x"></i></a>
							
							</div>
						</div> 
						<div id="socialMedia">  </div>
						<div class="form-group">
							<label class="col-sm-3 control-label">E-Commerce Site:</label>
							<div class="col-sm-4 col-xs-10">
								<input type="url" name="ecom_site[]" class="form-control" value=""  placeholder="http://www.abc.com.my">
							</div>
							<div class="col-xs-1" style="padding-left:0">
								<a  href="javascript:void(0);" id="addEcomlog" class="text-green"><i class="fa fa-plus-circle fa-2x"></i></a>
							</div>
						</div> 
						<div id="currEcom"> </div>	
						<div class="clearfix">&nbsp;</div>	
						<div class="col-sm-10 no-padding">
								<h2>B. Potential Product Listing Details</h2>
							</div>
							<div class="clearfix"></div>
						<div class="form-group">
							<label class="col-sm-3 control-label">How many products/SKU you plan to sell? </label>
							<div class="col-sm-4">
								{!! Form::select('sell_plan', ['' => 'Choose Option',
								'50' => '<50', '500' => '51-500', '2000' => '501-2000', '5000'=>'2000-5000','10000'=>'5001-10000','20000'=>'10001-20000','50000'=>'20001-50000','100000'=>'>50000'],null, ['class' => 'form-control'] ) !!}
							</div>
                        </div>
						<hr>
						<div class="clearfix"></div>
						<div class="col-sm-10 no-padding">
								<h2>C. Bank Details</h2>
							</div>
						<div class="clearfix"></div>
                        <div class="form-group">
                            {!! Form::label('account_name', '*Account Name', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-4">
                                {!! Form::text('account_name','', array('class' => 'form-control'))!!}
                            </div>
                        </div>
						<div class="clearfix"></div>
                        <div class="form-group">
                            {!! Form::label('account_number', '*Account Number', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-4">
                                {!! Form::text('account_number', '', array('class' => 'form-control'))!!}
                            </div>
                        </div>
						<div class="clearfix"></div>
                        <div class="form-group">

                            {!! Form::label('bank', 'Bank', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-4">
                                {!! Form::select('bank', ['0' => 'Choose Option' ]+$cf->getBank(), '', ['class' => 'form-control' ,'id' => 'bank_id']) !!}
                            </div>
                        </div>
						<div class="clearfix"></div>
                        <div class="form-group">
                            {!! Form::label('ibn', 'IBAN', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-4">
                                {!! Form::text('ibn', '', array('class' => 'form-control'))!!}
                            </div>
                        </div>
						<div class="clearfix"></div>
                        <div class="form-group">
                            {!! Form::label('swift', 'SWIFT', array('class' => 'col-sm-3 control-label')) !!}
                            <div class="col-sm-4">
                                {!! Form::text('swift', '', array('class' => 'form-control'))!!}
                            </div>
                        </div>						
						<div class="clearfix"></div>
						<div class="g-recaptcha pull-right" data-sitekey="6LcXgyMUAAAAAJe2Qb08ADwEyxK1Dbh35aQbl5U6"></div>
						<input type="hidden" class="hiddenRecaptcha required" name="hiddenRecaptcha" id="hiddenRecaptcha">
						<div class="clearfix"></div>
						<div class="pull-right" id="captchaMessage">
							
						</div>	
						<div class="clearfix"></div>						
						<br>
							<div class="col-xs-3" style="padding-left:0;padding-right:0">
								<a href="javascript:void(0)" class='btn signInBtnmerch22' id="merchbackf">Back</a>
							</div>	
							<div class="col-sm-3">
							</div>
							<div class="col-sm-3">
							</div>		
							<div class="col-xs-3" style="padding-left:0;padding-right:0">
								{!! Form::submit('Next', array('class' => 'btn signInBtnmerch22','id' => 'reg_merchant_log')) !!}
								<!--<a href="javascript:void(0)" class='btn signInBtnmerch22' id="merchnexts">Next</a> -->
							</div>								
					</div>
					<div class="login-content-third" style="display: none; color: white;">
						<?php
							$content=DB::table('global')->first()->merchant_agreement;
						?>
						{!! $content !!}
							<div class="col-xs-3" style="padding-left:0;padding-right:0">
								<a href="javascript:void(0)" class='btn signInBtnmerch22' id="merchbacks">I Disagree</a>
							</div>	
							<div class="col-sm-3">
							</div>
							<div class="col-sm-3">
							</div>		
							<div class="col-xs-3" style="padding-left:0;padding-right:0">
								<a href="javascript:void(0)" class='btn signInBtnmerch22' id="merchnextt">I Agree</a>
							</div>	
					</div>
				</div>
				{!! Form::hidden('indication', $indication, array( 'class' => 'form-control'))!!}
				
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>

<div class='form-modal '>
    <div class="modal fade" id='loginModal'>
        <div class="modal-dialog" style="width: 450px !important">
            <div class="modal-content" >
                <div class="modal-body">
                    <button class="close" data-dismiss="modal" type="button"><span>&times;</span></button>

                    <div class="col-md-12 modal-inside">
                        <form  id="loginFormDeskto" class="login_form" action="{{ URL::to('LoginUser') }}" method="post"
                              data-bv-message="This value is not valid"
                              data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
                              data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
                              data-bv-feedbackicons-validating="glyphicon glyphicon-refresh">
                        <div class="row" style="padding-bottom: 0px !important;">
                            <div class="login-content">
                               <p align="center">
							   <img style="margin-left:-20px"
							    src="{{asset('images/logo-white.png')}}"
								alt="Logo" width="250px"
								style=""></p>
								<br>
                                <div id="error-msg"
								style="color: #FFD6D6;"
								class="text-center text-danger error-msg">
                                                            
                                </div>
                                <div class="form-group">
                                   
                                    <div class="col-md-12" style='padding-left:0;padding-right:0'>
                                        <input class="form-control input-sm" name="username"
											placeholder="abc@yourmail.com" type="text" style="height: 40px;"
											data-bv-trigger="keyup" required
											data-bv-notempty-message="Email is required" >

                                    </div>
                                </div>
								<br>
								<br>
                              <!--  <div class="height-gap"></div> -->
                                <div class="form-group">
                                   
                                    <div class="col-md-12" style='padding-left:0;padding-right:0'>
                                        <input type='password' name="password" style="height: 40px;"
											class="form-control input-sm"  placeholder="Type your Password"
											data-bv-trigger="keyup" required
											data-bv-notempty-message="Password is required">
                                     </div>
                                    <div class="col-md-6 "
									style='padding-left: 0px;margin-top:5px'>
										<a style="color:#fff;text-decoration: none !important;"
										href="javascript:void(0)" class="showregister" rel='buyer'>
										New Member</a>
									</div>
                                    <div class="col-md-6 "
									style='padding-right: 0px;margin-top:5px'>
                                        <a href="#"
										style='color:#fff; text-decoration:none !important;'
										data-toggle="modal"
										data-target="#forgotModal">
										Forgot your password?</a>
                                    </div>
                                </div>
                            </div>
                        </div>
						<br>
                        <div class="row" style="padding-top: 0px !important;">
                            <div class="m-footer">
                                <div class="col-xs-12" style="padding-left:0;padding-right:0">
                                    <button type="submit" class='btn signInBtnnew'>Sign In</button>
                                </div>
								 <div class="col-xs-12"
								 style='text-align: left; padding-left:0;padding-right:0'>
									<p align="center"
									style="margin-top:10px;font-size: 20px;">Or</p>
                                </div>
								<div class="col-xs-12" style='text-align: left; padding-left:0;padding-right:0'>
									<p align="center"><a style="color:#fff;" href="{{ route('oauth.login', ['facebook']) }}" id="facebooklogin">
                                                <img alt="" src="{{asset('images/fb.png')}}" style='width:60px; height:60px;'>
                                    </a></p>
                                </div>
								
								 <div class="col-xs-12" style='text-align: left; padding-left:0;padding-right:0'>
									<hr>
									<p align="center" style="font-size: 20px;">What is?</p>
                                </div>
								<div class="col-xs-3" style='text-align: left; padding-left:0;padding-right:0'>
								</div>
								<div class="col-xs-3"
								style='text-align: center; padding-left: 0px;padding-right:0'>
									 <a href="javascript:void(0)"
									 class="what_ow">
									 <img alt=""
									 src="{{asset('images/openwish_button.png')}}"
									 style='width:55px; height:55px; border-radius: 5px;'></a>
									 <p align="center"
									 style="margin-top:3px;font-size: 16px;">OpenWish</p>
								</div>
								<div class="col-xs-3"
								style='text-align: center; padding-left: 0px;padding-right:0'>
									 <a href="javascript:void(0)"
									 class="what_smm">
									 <img alt=""
									 src="{{asset('images/smm_button.png')}}"
									 style='width:55px; height:55px; border-radius: 5px;'></a>
									 <p align="center"
									 style="margin-top:3px;font-size: 16px;">SMM</p>
								</div>
								<div class="col-xs-3" style='text-align: left; padding-left: 0px'>
								</div>
                            </div>
							
							</div> 
							<!-- Autolink Message -->
							<p style="color: #FFF; display: none; font-size: 15px;" id="modal_autolink_message"><b>Use AutoLink to request a link to our merchant to be a distributor or dealer. Dealership or distributorship request has to be approved by the merchant first.</b></p>						
							<p style="color: #FFF; display: none; font-size: 15px;" id="modal_smm_message"><b>Social Media Marketeer is a wonderful way to earn extra cash by helping merchants to market their products via your social media network. Register and try it out!</b></p>						
                        </form>
                        <form  id="registerFormDeskto" style="display: none;" class="reg_form" action="{{ URL::to('RegisterUser') }}" method="post"
                              data-bv-message="This value is not valid"
                              data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
                              data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
                              data-bv-feedbackicons-validating="glyphicon glyphicon-refresh">
							<div class="row" style="padding-bottom: 0px !important;">
                            <div class="login-content">
								<input type="hidden" value="buyer" name="reg_role" id="reg_role" />
                               <p align="center">
							   <img style="margin-left:-20px"
							    src="{{asset('images/logo-white.png')}}"
								alt="Logo" width="250px"
								style=""></p>
								<p align="center" style="font-size: 25px;" class="onlystation"> Station Registration</p>
								<br>
                                <div id="error-msg-reg"
								style="color: #FFD6D6;"
								class="text-center text-danger error-msg-reg">
								 </div>
								<div id="success-msg-reg"
								style="color: #0fff6d;"
								class="text-center text-danger success-msg-reg">
                                                            
                                </div>
                                <div class="form-group">
                                   
                                    <div class="col-md-12" style='padding-left:0;padding-right:0'>
                                        <input class="form-control input-sm" name="username"
											placeholder="abc@yourmail.com" type="text" style="height: 40px;"
											data-bv-trigger="keyup" required
											data-bv-notempty-message="Email is required" >
                                    </div>
                                </div>
								<br>
								<br>
                              <!--  <div class="height-gap"></div> -->
                                <div class="form-group">
                                   
                                    <div class="col-md-12" style='padding-left:0;padding-right:0'>
                                        <input type='password' name="password" style="height: 40px;"
											class="form-control input-sm"  placeholder="Type your Password"
											data-bv-trigger="keyup" required
											data-bv-notempty-message="Password is required">
                                     </div>
									 
									 <div class="col-md-12" style='padding-left:0;padding-right:0'>
                                        <input type='password' name="confirm_password" style="height: 40px; margin-top: 15px;"
											class="form-control input-sm"  placeholder="Confirm your Password"
											data-bv-trigger="keyup" required
											data-bv-notempty-message="Password is required">
                                     </div>
                                    <div class="col-md-6 "
									style='padding-left: 0px;margin-top:5px'>
										<a style="color:#fff;"
										href="javascript:void(0)" class="showlogin onlybuyer">
										<u>Login</u></a>
									</div>
                                    <div class="col-md-6 "
									style='padding-right: 0px;margin-top:5px'>
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
						<br>
                        <div class="row" style="padding-top: 0px !important;">
                            <div class="m-footer">
                                <div class="col-xs-12" style="padding-left:0;padding-right:0">
                                    <button type="submit" class='btn signInBtnnew'>Register</button>
                                </div>
								 <div class="col-xs-12 onlybuyer"
								 style='text-align: left; padding-left:0;padding-right:0'>
									<p align="center"
									style="margin-top:10px;font-size: 20px;">Or</p>
                                </div>
								<div class="col-xs-12 onlybuyer" style='text-align: left; padding-left:0;padding-right:0'>
									<p align="center"><a style="color:#fff;" href="{{ route('oauth.login', ['facebook']) }}" id="facebooklogin">
                                                <img alt="" src="{{asset('images/fb.png')}}" style='width:60px; height:60px;'>
                                    </a></p>
                                </div>
								
								
								 <div class="col-xs-12 onlybuyer" style='text-align: left; padding-left:0;padding-right:0'>
									<hr>
									<p align="center" style="font-size: 20px;">What is?</p>
                                </div>
								<div class="col-xs-3 onlybuyer" style='text-align: left; padding-left:0;padding-right:0'>
								</div>
								<div class="col-xs-3 onlybuyer"
								style='text-align: center; padding-left: 0px;padding-right:0'>
									 <a href="javascript:void(0)"
									 class="what_ow">
									 <img alt=""
									 src="{{asset('images/openwish_button.png')}}"
									 style='width:55px; height:55px;'></a>
									 <p align="center"
									 style="margin-top:3px;font-size: 16px; border-radius: 5px;">OpenWish</p>
								</div>
								<div class="col-xs-3 onlybuyer"
								style='text-align: center; padding-left: 0px;padding-right:0'>
									 <a href="javascript:void(0)"
									 class="what_smm">
									 <img alt=""
									 src="{{asset('images/smm_button.png')}}"
									 style='width:55px; height:55px; border-radius: 5px;'></a>
									 <p align="center"
									 style="margin-top:3px;font-size: 16px;">SMM</p>
								</div>
								<div class="col-xs-3 onlybuyer" style='text-align: left; padding-left: 0px'>
								</div>
								<div class="col-xs-12" style='text-align: left; padding-left:0;padding-right:0'>
									<p align="center">By registering you are accepting OpenSupermall's <p align="center">
									<p align="center"> <a style="color:blue;" href="{{URL::to('/')}}/terms_cond" target="_blank" id="">
                                     Terms & Conditions
                                    </a> and <a style="color:blue;" href="{{URL::to('/')}}/privacy" target="_blank">Privacy Policy</a></p>
                                </div>
                            </div>
							
							</div> 
							<!-- Autolink Message -->
							<p style="color: #FFF; display: none; font-size: 15px;" id="modal_autolink_message"><b>Use AutoLink to request a link to our merchant to be a distributor or dealer. Dealership or distributorship request has to be approved by the merchant first.</b></p>						
							<p style="color: #FFF; display: none; font-size: 15px;" id="modal_smm_message"><b>Social Media Marketeer is a wonderful way to earn extra cash by helping merchants to market their products via your social media network. Register and try it out!</b></p>						
                        </form>						
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>

<!-- Modal -->
<div id="tcModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
 
      <div class="modal-body">
       {{--  --}}
      </div>
    </div>

  </div>
</div>

<div class='form-modal'>
    <div class="modal fade" id='forgotModal'>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <button class="close" data-dismiss="modal" type="button"><span>&times;</span></button>

                    <div class="col-md-12 modal-inside">
                        <div class="row">
                            <div class="login-content">
                                <h3 style='font-weight: 900'>Support</h3>

                                <h5>Forgot your password?</h5><br>

                                <div class="form-group">
                                    <label class='col-md-4' style='padding-left: 0px'>Provide your email:</label>
                                    <div class="col-md-8" style='padding-left: 0px'>
                                        <span style="position: relative; color: black; display:none; font-size: 24px; font-weight: bold;" class="all-filter-fa" id="overlay_spinner_email_forgot" ><i class="fa-li fa fa-spinner fa-spin fa fa-fw" ></i></span>
										<input class="form-control input-sm" name="username" id="forgotemail" placeholder="Type your email" type="text"
                                               data-bv-trigger="keyup" required data-bv-notempty-message="Username is required">
										<label id="email-forgot-error" class="error" for="email" style="display:none">Invalid Email</label>
										<label id="email-forgot-check" style="display:none; color: #FFF;">Please, check your email for further instruction to recover your password.</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6" style='text-align: right; padding-left: 0px'>
                                <button class='btn  signInBtn forgotpassBtn' id="forgot_email">Send</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>

<div class='form-modal'>
    <div class="modal fade" id='editModel'>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body" style="background:#fff !important;" id="editbody">

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>

<div class='form-modal'>
    <div class="modal fade" id='AlertModel'>
        <div class="modal-dialog">
            <div class="modal-content" style="background:#fff !important;">
                <div class="modal-header">
                    <h4 class="modal-title"><strong>Alert!</strong></h4>
                </div>
                <div class="modal-body">
                    <p>Are you sure?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="yes-del" data-dismiss="modal">Yes</button>
                    <button type="button" class="btn btn-primary" id="no-del" data-dismiss="modal">No</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
<div class='form-modal'>
    <div class="modal fade" id='MessageModel'>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body" style="background:#fff !important;" id="Messagebody">

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
<input type="hidden" id="oldmail_log" value="" />
<script type="text/javascript" src="https://www.google.com/recaptcha/api.js"></script>
<script>
 $(document).ready(function () {
            $("#memail").on("blur",function(){
                //Put Spinner
                $("#overlay_spinner_email_log").css("display", "block");
                $("#email-error_log").css("display", "none");
                $("#memail").removeClass("error");
                $("#reg_merchant_log").prop('disabled', false);

                //JS Email Valitation (Required and Well Format)
                var email_v = $("#memail").val();
                var email_old = $("#oldmail_log").val();
                if (validateEmail2(email_v) && email_v != email_old) {
                    // $("#email-error").text(email_v + " is valid :)");
                    // $("#email-error").css("color", "green");
                    // $("#email-error").css("display", "block");
                    $.ajax({
                        type: "get",
                        url: JS_BASE_URL + '/validate_email/' + email_v,
                        cache: false,
                        success: function (responseData, textStatus, jqXHR) {
                            if (responseData == "0") {
                                $("#email-error_log").text("This email is already in use");
                                $("#email-error_log").attr(
									"style","color:#ffc2f6;font-weight:bold !important");
                                $("#email_validation_log").addClass("error");
                                $("#email-error_log").css("display", "block");
                                $("#reg_merchant_log").prop('disabled', 'disabled');
                            }
                            if (responseData=="1") {
                                 $("#email-error_log").text("This email is valid");
                                $("#email-error_log").attr(
									"style","color:#00f300;font-weight:bold !important");
                                $("#email-error_log").css("display", "block");
                            }
                            $("#overlay_spinner_email_log").css("display", "none");
                        },
                        error: function (responseData, textStatus, errorThrown) {
                            console.log(errorThrown);
                        }
                    });

                } else {
					$("#overlay_spinner_email_log").css("display", "none");
                    /*$("#email-error").text("Invalid format email");
                    $("#email-error").css("color", "red");
                   /* $("#email_valitation").addClass("error");
                   // $("#email-error").css("display", "block");
                    $("#overlay_spinner_email").css("display", "none");
                    $("#submit_button").prop('disabled', 'disabled');*/
                }
            });	 
	 
	$("#memail").on("keyup",function(){
		//Put Spinner
		$("#overlay_spinner_email").css("display", "block");
		$("#email-error").css("display", "none");
		$("#email_valitation").removeClass("error");
		$("#reg_merchant").prop('disabled', false);
	});	 
	 
	function validateEmail2(email) {
		var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return re.test(email);
	}	 
	
	window.setInterval(function(){
		if(grecaptcha.getResponse() == ''){
			 $("#reg_merchant_log").prop('disabled', true);
		} else {
			 $("#reg_merchant_log").prop('disabled', false);
		}
	}, 1000);		
	 
	$(document).delegate( '#nogst', "click",function (event) {
			var checked = this.checked;
			if(checked){
				$("#gstvat").val("");
				$("#gstvat").attr('disabled',true);
			} else {
				$("#gstvat").attr('disabled',false);
			}
		});	 
	 
	$("#forgotemail").on("blur",function(){
		//Put Spinner
		$("#overlay_spinner_email_forgot").css("display", "block");
		$("#email-forgot-error").css("display", "none");
		$("#forgotemail").removeClass("error");

		//JS Email Valitation (Required and Well Format)
		var email_v = $("#forgotemail").val();
		if (validateEmail2(email_v)) {
			// $("#email-error").text(email_v + " is valid :)");
			// $("#email-error").css("color", "green");
			// $("#email-error").css("display", "block");
			$.ajax({
				type: "get",
				url: JS_BASE_URL + '/validate_email/' + email_v,
				cache: false,
				success: function (responseData, textStatus, jqXHR) {
					if (responseData != "0") {
						$("#email-forgot-error").text("This email could not be found");
						$("#email-forgot-error").attr(
							"style","color:#ffc2f6;font-weight:bold !important");
						$("#forgotemail").addClass("error");
						$("#email-forgot-error").css("display", "block");
					}
					 $("#overlay_spinner_email_forgot").css("display", "none");
				},
				error: function (responseData, textStatus, errorThrown) {
					console.log(errorThrown);
				}
			});

		} else {
			$("#email-forgot-error").text("Invalid format email");
			$("#email-forgot-error").css("color", "red");
			$("#forgotemail").addClass("error");
			$("#email-forgot-error").css("display", "block");
			$("#overlay_spinner_email_forgot").css("display", "none");
		}
	});
	$("#forgot_email").on("click",function(){
		var email = $("#forgotemail").val();
		var formData = {
			email: email
		}
		$.ajax({
			type: "post",
			url: JS_BASE_URL + '/forgot_password',
			cache: false,
			data: formData,
			dataType: 'json',
			success: function (data) {
				console.log(data);
				$("#email-forgot-check").css("display", "block");
				setTimeout(function(){
					$("#email-forgot-check").css("display", "none");
					$('#forgotModal').modal('toggle');
				}, 5000);					
			},
			error: function (responseData, textStatus, errorThrown) {
				console.log(errorThrown);
			}
		});		
		
	});
	
	$("#forgotemail2").on("blur",function(){
		//Put Spinner
		$("#overlay_spinner_email_forgot2").css("display", "block");
		$("#email-forgot-error2").css("display", "none");
		$("#forgotemail2").removeClass("error");

		//JS Email Valitation (Required and Well Format)
		var email_v = $("#forgotemail2").val();
		if (validateEmail2(email_v)) {
			// $("#email-error").text(email_v + " is valid :)");
			// $("#email-error").css("color", "green");
			// $("#email-error").css("display", "block");
			$.ajax({
				type: "get",
				url: JS_BASE_URL + '/validate_email/' + email_v,
				cache: false,
				success: function (responseData, textStatus, jqXHR) {
					if (responseData != "0") {
						$("#email-forgot-error2").text("This email could not be found");
						$("#email-forgot-error2").attr(
							"style","color:#ffc2f6;font-weight:bold !important");
						$("#forgotemail2").addClass("error");
						$("#email-forgot-error2").css("display", "block");
					}
					 $("#overlay_spinner_email_forgot2").css("display", "none");
				},
				error: function (responseData, textStatus, errorThrown) {
					console.log(errorThrown);
				}
			});

		} else {
			$("#email-forgot-error2").text("Invalid format email");
			$("#email-forgot-error2").css("color", "red");
			$("#forgotemail2").addClass("error");
			$("#email-forgot-error2").css("display", "block");
			$("#overlay_spinner_email_forgot2").css("display", "none");
		}
	});
	$("#forgot_email2").on("click",function(){
		var email = $("#forgotemail2").val();
		var formData = {
			email: email
		}
		$(this).html("Sending...");
		var _this = $(this);
		$.ajax({
			type: "post",
			url: JS_BASE_URL + '/forgot_password',
			cache: false,
			data: formData,
			dataType: 'json',
			success: function (data) {
				console.log(data);
				$("#email-forgot-check2").css("display", "block");
				_this.html("Send");
				setTimeout(function(){
					$("#email-forgot-check2").css("display", "none");
					$('.dropdown-content-forgot').hide();
				}, 5000);					
			},
			error: function (responseData, textStatus, errorThrown) {
				console.log(errorThrown);
			}
		});		
		
	});	
	
});			
</script>

 <script type="text/javascript">
        $('#registe_rForm_log').bootstrapValidator({
                framework: 'bootstrap',
                // Feedback icons
                icon: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                onSuccess:function(){
					$("#registe_rForm_log").submit(function(e){
						e.preventDefault();
						$(".login-content-third").show();
						$(".login-content-second").hide();
					});
                }
                ,
                // fields
                fields: {
                    firstname:{
                        validators:{
                            notEmpty:{
                                message:"First name is necessary"
                            }
                        }
                    },
                    lastname:{
                        validators:{
                            notEmpty:{
                                message:"Last name is necessary"
                            }
                        }
                    },
                    email:{
                        validators:{
                            notEmpty:{
                                message:"Email is necessary"
                            },
                            emailAddress:{
                                message:"The email is invalid"
                            },
                            regexp: {
                                regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$',
                                message: 'The value is not a valid email address'
                            }
                        }
                    },
                    password: {
                        validators: {
                            notEmpty: {
                                message: "Password cannot be left empty"
                            },
                            stringLength: {
                                min: 7,
                                max: 20,
                                message: "The Password must be more than 7 and less than 20 characters"
                            },
                           identical: {
                                    field: 'confirmPassword',
                                    message: 'The password and its confirm are not the same'
                            }
                        }
                    }
                    ,
                    confirmPassword: {
                        validators: {
                            notEmpty: {
                                message: "This field cannot be left empty"
                            },
                            stringLength: {
                                min: 7,
                                max: 20,
                                message: "The password must be more than 7 and less than 20 characters"
                            },
                           identical: {
                                    field: 'password',
                                    message: 'The password and its confirm are not the same'
                            }
                        }
                    },
                    company_name:{
                        validators:{
                            notEmpty:{
                                message:"Company Name is necessary"
                            },
                            stringLength:{
                                min:3,
                                message:"Company Name must be more than 3 characters"
                            }
                        }
                    },
                    line1:{
                        validators:{
                            notEmpty:{
                                message:"Station address is necessary"
                            },
                            stringLength:{
                                min:5,
                                message:"Invalid Address"
                            }
                        }
                    },
                    zip:{
                        validators:{
                            notEmpty:{
                                message:"Postcode/zip is necessary"
                            },
                            digits:{
                                message:"Postcode/zip can only consist digits"
                            }
                        }
                    },
                    contact:{
                        validators:{
                            notEmpty:{
                                message:"The name of Contact Person is necessary"
                            },
                            stringLength:{
                                min:3,
                                message:"Invalid contact person's name"
                            }
                        }
                    },
                    line1c:{
                        validators:{
                            notEmpty:{
                                message:"Contact person's address is necessary"
                            },
                            stringLength:{
                                min:5,
                                message:"Invalid Address"
                            }
                        }
                    },
                    statesc:{
                        validators:{
                            notEmpty:{
                                message:"State is necessary"
                            }
                        }
                    },
                    city_id:{
                        validators:{
                            notEmpty:{
                                message:"City is necessary"
                            }
                        }
                    },
                    station_name:{
                        validators:{
                            notEmpty:{
                                message:"Station Name is necessary"
                            },
                            stringLength:{
                                min:5,
                                message:"Station Name must be above 5 characters"
                            }
                        }
                    },
					/*
                    account_name:{
                        validators:{
                            notEmpty:{
                                message:"Account Name is necessary"
                            }
                        }
                    },
                    account_number:{
                        validators:{
                            notEmpty:{
                                message:"Account Number is necessary"
                            }
                        }
                    },
					*/
                    'outlet_name[]':{
                        validators:{
                            notEmpty:{
                                message:"Outlet Name is necessary"
                            }
                        }
                    },
                    'state_idst[]':{
                        validators:{
                            notEmpty:{
                                message:"Outlet state is necessary"
                            }
                        }
                    },
                    'city_idst[]':{
                        validators:{
                            notEmpty:{
                                message:"Outlet city is necessary"
                            }
                        }
                    },
                    'shop_size':{
                        validators:{
                            notEmpty:{
                                message:"Shop size is necessary"
                            }
                        }
                    },
                    'biz_name[]':{
                        validators:{
                            notEmpty:{
                                message:"Business name for the outlet is necessary"
                            }
                        }
                    },
                    'firstname_property[]':{
                        validators:{
                            notEmpty:{
                                message:"Owner's firstname is necessary"
                            }
                        }
                    },
                    'lastname_property[]':{
                        validators:{
                            notEmpty:{
                                message:"Owner's lastname is necessary"
                            }
                        }
                    },
                    'contact_property[]':{
                        validators:{
                            notEmpty:{
                                message:"Owner's contact is necessary"
                            }
                        }
                    },
					/*
                    'contactname[]':{
                    	validators:{
                    		notEmpty:{
                    			message:"Contact name required"
                    		}
                    	}
                    }
					*/
                  
                    // Above Custom
             
                    
                }//fields
                ,
 

             });
    </script>
