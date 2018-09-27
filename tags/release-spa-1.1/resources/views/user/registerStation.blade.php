<?php
$cf = new \App\lib\CommonFunction();
use App\Http\Controllers\IdController;
$selectListForBusinessType =  $cf->getBusinessType();
// {!! Form::select('country', $cf->country(), null, ['class' => 'form-control']) !!}
$hide_log = "";
if($type == "logistic"){
	$hide_log = "display: none;";
}
?>
@extends("common.default")
<style>
.form-group {
    margin-bottom: 5px !important;
}
</style>
@if((\Illuminate\Support\Facades\Session::has('EditStation')))
    <div class="alert alert-success">
        <strong>Success!</strong> Information Updated Successfully.
    </div>
@endif

@section("content")
@if($edit)
	@include("common.sellermenu")
@endif
<input type="hidden" value="{{$editing}}" id="editing" />
	<div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document" style="width: 44%">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
								aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Reset Your Password</h4>
				</div>
				<div class="modal-body">
                    <form class="form-horizontal">
                        
                        <div class="form-group">
                            
                            <label class="col-md-4">Old password:</label>
                            <div class="col-md-8">    
                                <input type="password" class="form-control" id="user_oldpass" size="25" />
                                <span class="text-danger" id="user_oldpass_err"></span>
                            </div>
                        </div>
                        <input type="hidden" id="useraid" value="{{$userModel['user']['id']}}" />
                        <div class="form-group">
                                            
                            <label class="col-md-4">Enter new password:</label>
                            <div class="col-md-8"> 
                                <input type="password" class="form-control" id="user_pass" size="25" />
                                <span class="text-danger" id="user_pass_err"></span>
                            </div>
                        </div>          
                        <div class="form-group">
                                                   
                                <label class="col-md-4">Reconfirm new password:</label>
                            <div class="col-md-8">  
                                <input type="password" class="form-control" id="user_passc" size="25" />
                                <span class="text-danger" id="user_passc_err"></span>        
                            </div>
                        </div>  
                        <div class="form-group">
                            <div class="col-md-12">                     
                                <input type="button" id="change_password" class="btn btn-primary pull-right" value="Save" style="margin-top: 10px;">
                                <p style="color: red; display: none;" id="wrong_passold" style="margin-top: 10px;">Wrong password.</p>
                                <p style="color: red; display: none;" id="wrong_pass" style="margin-top: 10px;">Passwords don't match.</p>
                                
                            </div>
                        </div>  
                    </form>
				</div>
			</div>
		</div>
	</div>
    <section class="">
	  <div class="container mobile" style="min-height: 400px;">
			<div class="row">
				 <div class="col-sm-12">
				 @if($userModel['user']['email'] != "")
					<h3 align="center">Please, use a bigger device to Update your account. </h3>
				 @else
					<h3 align="center">Please, use a bigger device to Create your account. </h3>
				 @endif
				 </div>
			 </div>
		</div>
        <div class="container nomobile"><!--Begin main cotainer-->
            <div class="row">
                <div data-spy="scroll" class="static-tab" style="display: none;">
                    <div class="text-center tab-arrow">
                        <span class="fa fa-sort"></span>
                    </div>
                <!--   <ul class="nav nav-pills nav-stacked">
                        <li role="presentation" class="active"><a href="#account">Account</a></li>
                        <li role="presentation"><a href="#company">Company</a></li>
                        <li role="presentation"><a href="#contact">Contact</a></li>
                        <li role="presentation"><a href="#station">Station</a></li>
                        <li role="presentation"><a href="#bank">Bank</a></li>
                        <li role="presentation"><a href="#location">Location</a></li>
                        <li role="presentation"><a href="#property">Property</a></li>
                        <li role="presentation"><a href="#business">Business</a></li>
                        <li role="presentation"><a href="#remark">Remarks</a></li>
                    </ul> -->
                </div>
                <div class="col-sm-12">
					{!! Breadcrumbs::renderIfExists() !!}
                    {!! Form::open(array('url'=> $route , 'files' => 'true',
					'method'=>'post', 'id'=>'registe_rForm',
					'class'=> 'form-horizontal',
					'style'=>'margin-top:0')) !!}
                    {{-- @foreach($userModel as $user)--}}
					<input type="hidden" id="theuserid" name="theuserid" value="{{$userModel['user']['id']}}" />
                    <div id="account" class="row"
					style="margin-left:0;margin-right:0">
                        <h1>Station Information</h1>
                        <hr style="margin-top:10px;margin-bottom:10px"/>
                        <p style=" display: none;" id="sucess_pass"
							class="alert alert-success col-md-5">
							Password successfully changed!</p>
                        <div class="col-md-12"
							style="padding-left:0;padding-right:0">
                            <div class="col-md-7"
								style="padding-left:0;padding-right:0"> 
                                <h2>Account Information</h2>
                                @if(count($errors)>0)
                                    <div class="alert alert-danger" role="alert">
                                        @foreach($errors->all() as $error)
                                            <p>{{ $error }}</p>
                                        @endforeach
                                    </div>
                                @endif
                                <div class="form-group">
                                    {!! Form::label('firstname', 'First Name', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-9">
                                        {{-- {!! Form::text('firstname', $userModel['user']['first_name'], array('placeholder'=>'First Name', 'class' => 'form-control', 'required' ))!!} --}}
                                        <input type="text"  value="{{$userModel['user']['first_name']}}" name="firstname" class="form-control" placeholder="First Name" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('lastname', 'Last Name', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-9">
                                        {!! Form::text('lastname',$userModel['user']['last_name'] , array('placeholder'=>'Last Name', 'class' => 'form-control', 'required' ))!!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('email', 'Email', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-9">
        								<span style="position: relative; color: black; display:none; font-size: 24px; font-weight: bold;" class="all-filter-fa" id="overlay_spinner_email" ><i class="fa-li fa fa-spinner fa-spin fa fa-fw" ></i></span>
                                        {!! Form::email('email',$userModel['user']['email'] , array('placeholder'=>'Email',  'id' => 'email_valitation', 'class' => 'form-control', 'required'))!!}
        								<label id="email-error" class="error" for="email" style="display:none">Invalid Email</label>
                                    </div>
                                </div>
                            
						@if($userModel['user']['email'] == "")
						<input type="hidden" id="oldmail" value="" />
							<div class="form-group">
								{!! Form::label('password', null, array('class' => 'col-sm-3 control-label')) !!}
								<div class="col-sm-9">
									{!! Form::password('password', array('placeholder'=>'Password', 'class' => 'form-control', 'required' ,'id'=>'pass')) !!}
								</div>
							</div>
							<div class="form-group">
								{!! Form::label('confirmPassword', 'Confirm Password', array('class' => 'col-sm-3 control-label')) !!}
								<div class="col-sm-9">
									{!! Form::password('password_confirmation', array('placeholder'=>'Confirm Password', 'class' => 'form-control', 'required' ,'id'=>'compass')) !!}
								</div>
							</div>
							</div>

						@else
						<input type="hidden" id="oldmail" value="{{$userModel['user']['email']}}" />
						</div>
							@if($edit)
                                <div class="col-md-3" style="padding-top: 10px;"> 
    								<div class="form-group">
    									<div class="col-sm-6">
    										<a href="javascript:void(0)" class="btn btn-green btn-mid" id="change_pass">Change Password</a>	
    									</div>
    								</div>	
                                </div>
								<div class="col-md-2" style="padding-top: 10px;"> 
									<?php 
										$qr = DB::table('stationqr')->join('qr_management','qr_management.id','=','stationqr.qr_management_id')
										->where('station_id',$userModel['station'][0]['id'])->orderBy('stationqr.id','DESC')->first();
									?>
									&nbsp;
									@if(!is_null($qr))
										<img src="{{URL::to('/')}}/images/qr/station/{{$userModel['station'][0]['id']}}/{{$qr->image_path}}.png" class='pull-right' width="120px" />
									@endif
								</div>
							@endif

						@endif
						<div class="clearfix"></div>
						<div class="form-group">
                            <label class="col-sm-2 control-label">*Office: </label>
                            <div class="col-sm-4" style="padding-left: 0px !important; margin-left: -4px;">
                                <input type="text"  name="office" placeholder="Office"  value="{{ $userModel['station'][0]['office_no']}}" class="form-control">
                            </div>
                            <input id='mobileNo' type="text" name="mobile" value="{{ $userModel['station'][0]['mobile_no']}}" class="form-control hidden">
                            @def $extension = null
                            @def $num  = null;
                            @if(isset($userModel['station'][0]['mobile_no']))
                                @def $wholeNumber = $userModel['station'][0]['mobile_no'];
                                @def $extension = substr($wholeNumber, 0, 4);
                                @def $num = substr($wholeNumber, 4, 11);
                            @endif
                            <label class="col-sm-1 control-label">*Mobile: </label>
                            <div class="col-sm-4">
                                <div class="col-sm-3">
                                    <div class="row">
                                        @if (isset($extension) && !empty($extension))
                                        <input id='ext' type="text" required=""  value="{{ $extension }}" class="form-control">
                                        @else
                                        <input id='ext' type="text" placeholder="ext" required="" class="form-control">
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-1">
                                    <div class="row text-center" style="font-weight:bold; margin-top: 7px">
                                         -
                                    </div>
                                </div>
                                <div class="col-sm-7">
                                    <div class="row">
                                        @if (isset($num) && !empty($num))
                                        <input  id='mobileNumber' required="" type="text"  value="{{ $num }}" class="form-control mbnumb">
                                        @else
                                        <input  id='mobileNumber' placeholder="Mobile" required="" type="text" class="form-control mbnumb">
                                        @endif
                                    </div>
                                </div>
                                <span id="errmsg" style="color:red"></span>
                            </div>
                        </div>
                        </div>
                    </div>
					<hr>
                    <div id="contact">
						<div class="col-sm-6 no-padding">
							<h2>Contact Information </h2>
							<b>	All transaction related matters shall be sent to the following addresses. </b>
						</div>
						<div class="col-sm-8 no-padding">
							
						</div>
						<?php
							$ccci = 0;
							
						?>
						<div class="clearfix"></div>
						<div  id="emailenable">
							<div class="col-sm-1 no-padding" >
								<p align="center"><b>	Enable </b></p>
							</div>
							<div class="col-sm-3 no-padding" >
								<p align=""><b>	Name </b></p>
							</div>
							<div class="col-sm-3 no-padding" >
								<p align=""><b>	Email </b></p>
							</div>
							<div class="col-sm-5 no-padding" >
								<p align=""></p>
							</div>
						</div>
						<div class="clearfix"></div>
						<div >
							@if( ! is_null($userModel['contactemail'] ) && count($userModel['contactemail'] ) > 0)
								@foreach($userModel['contactemail'] as $contact)
									<div class="form-group" id="ci{{$ccci}}"> 
										<label class="col-sm-1">
											<?php 
												$checkedemail = "";
												if($contact['enable'] == 1){
													$checkedemail = "checked";
												}
											?>
											<p align="center">
												<input type="checkbox" {{$checkedemail}} name="checkemail[]" style="width: 20px;  height: 20px;" value="{{$ccci}}" class="check_email" rel="{{$ccci}}"  />
											</p>
										</label>   
										<div class="col-sm-3">
											<input type="text" value="{{$contact['name']}}" class="form-control validator" name="contactname[]" placeholder="John Doe">    
										</div>  
										<div class="col-sm-3"> 
											<input type="email" value="{{$contact['email']}}" class="form-control validator" name="contactemail[]" placeholder="eg: test@opensupermall.com">    
										</div>    
										<div class="col-sm-1"> 
											@if($ccci==0)  
												<a href="javascript:void(0);" class="addCI text-green" rel="{{$ccci}}"><i class="fa fa-plus-circle fa-2x"></i></a>
											@else
												<a href="javascript:void(0);" class="remCI text-danger" rel="{{$ccci}}"><i class="fa fa-minus-circle fa-2x"></i></a>
											@endif    
										</div>
										<div class="clearfix"></div> 
									</div>
									<?php $ccci++; ?>
								@endforeach
							@else
							 <div class="form-group" id="ci1"> 
								<label class="col-sm-1">
									<?php 
										$checkedemail = "";
										if(1 == 1){
											$checkedemail = "checked";
										}
									?>
									<p align="center">
										<input type="checkbox" {{$checkedemail}} name="checkemail[]" style="width: 20px;  height: 20px;" value="1" class="check_email" rel="1"  />
									</p>
								</label>   
								<div class="col-sm-3">
									<input type="text"  class="form-control validator" name="contactname[]" placeholder="John Doe">    
								</div>  
								<div class="col-sm-3"> 
									<input type="email"  class="form-control validator" name="contactemail[]" placeholder="eg: test@opensupermall.com">    
								</div>    
								<div class="col-sm-1">   
									<a href="javascript:void(0);" class="addCI text-green" rel="1"><i class="fa fa-plus-circle fa-2x"></i></a>    
								</div>
								<div class="clearfix"></div> 
								</div>
							 <?php $ccci+=1;?>
							@endif
							<span id="ciDetail"></span>
						</div>
						<input type="hidden" id="valaddCI" value="{{$ccci}}">
					</div>
					<hr>					
                        <h2>Company Details</h2>
						@if($type == "logistic")
							<div class="form-group">
								<label class="col-sm-3 control-label">Professional Logistics Company:</label>
								<div class="col-sm-1 col-xs-10">
									<input type="checkbox" class="logtype" name="professional" {{$checkprofessional}} value='1' style="width: 20px;  height: 20px;" />
								</div>
								<label class="col-sm-2 control-label">Merchant Own Use:</label>
								<div class="col-sm-1 col-xs-10">
									<input type="checkbox" class="logtype" name="merchantown" {{$checkown}} value='1' style="width: 20px;  height: 20px;" />
								</div>
							</div>
							<br>
						@endif
                        <div class="form-group col-xs-12">
                            {!! Form::label('company_name', 'Company Name') !!}
                            {!! Form::text('company_name',$userModel['station'][0]['company_name'], array( "data-bv-trigger" => "keyup" , "required" => "required",
                            'placeholder'=>'Company Name', 'class' => 'form-control', 'required'))!!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('domicile', 'Domicile', array('class' => 'col-sm-1 control-label')) !!}
                            <div class="col-sm-3">
                                {{-- {!! Form::select('domicile', [''=>'Country of Origin']+$cf->getCountry(), $userModel['station'][0]['country_id'], [ "data-bv-trigger" => "keyup" , "required" => "required", 'class' => 'validator form-control']) !!} --}}

                                {!! Form::text('country', 'Malaysia', array('readonly' => 'readonly', 'class' => 'form-control', 'id' => 'country_id')) !!}

                                {{--<select name="domicile" class="form-control"><option value="dom">Company</option></select>--}}
                            </div>
                            {!! Form::label('gst_vat', '*GST/VAT', array('class' => 'col-sm-2 control-label')) !!}
							<?php 
								$checked_nogst = "";
								$disabled_gst = "";
								if(!is_null($userModel['user']['id'])){
									if(is_null($userModel['station'][0]['gst']) || $userModel['station'][0]['gst'] == ""){
										$disabled_gst = $disabled;
										$checked_nogst = "checked";
									} 									
								}
							?>							
                            <div class="col-sm-5">
                                {!! Form::text('gst', $userModel['station'][0]['gst'], array( "data-bv-trigger" => "keyup" , 'placeholder'=>'Input Your GST/VAT Number', 'class' => 'form-control' , 'id' => 'gstvat', $disabled_gst))!!}
                            </div>
							<div class="col-sm-1 no-padding" style="margin-top: 7px;">
								<b>No&nbsp;GST</b>
								&nbsp;<input type="checkbox" {{$checked_nogst}} style="vertical-align: middle;" id="nogst" />
							</div>						
                        </div>
						<div class="form-group">
                            <label class="col-sm-3 control-label">Business Type: </label>
                            <div class="col-sm-3">
                                {!! Form::select('business_type',
                                    $cf->getBusinessType(), 0,
                                    ['class' => 'form-control', 'required'])
                                 !!}
                            </div>
                        </div>
                        <div id="dirDetail" >
						<?php $cco = -1; ?>
                            @if(isset($userModel['directorsInEditView']))
                                @foreach($userModel['directorsInEditView'] as $director)
                                    <div class="form-group" >
										{!! Form::label('directors', 'Directors', array('class' => 'col-sm-1 control-label','id'=>'form')) !!}
										<div class="col-sm-2">
											{!! Form::text('directors[]',$director['name'], array(  'placeholder'=>'Type the Name', 'class' => 'form-control  ',  'required'))!!}
										</div>
										<div class="col-sm-3">
											<input type="text" class="form-control validator" name="nric[]" placeholder="Type the NRIC or Passport Number" value="{{$director['nric']}}">
										</div>
										<div class="col-sm-2">
											{!! Form::select('dcountry[]', [''=>'Nationality']+$cf->getCountry(),$director['country_id'], ['class' => 'form-control  ','id' => 'dcountry',  'required']) !!}
										</div> 
										<div class="col-sm-4">
											<div class="inputBtnSection">
													<?php 
														/*$file = asset('/') . 'images/director/' .$director['document_id'] . '/' . $director['doc'];
														$file_headers = @get_headers($file);
														//dd($file_headers); 
														if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found' || $file_headers[0] == 'HTTP/1.0 404 Not Found') {
															$exists = false;
														}
														else {
															$exists = true;
														}*/
                                                $exists = true;
													?>
													<input id="uploadFileDD" name="uploadFile[]" value="{{ $director['doc'] }}" @if (!$exists) rel="" @else rel= "{{asset('/')}}images/director/{{ $director['document_id'] }}/{{ $director['doc'] }}" @endif title="Click to view attached document" class="disableInputField fileview" placeholder="NRIC or Passport Picture" style="cursor:pointer;  color: blue;" />
												<input name="uploadFileid[]" value="{{ $director['document_id'] }}" type="hidden"  />
												<label class="fileUpload">
													<input id="uploadBtnDD" name="directorImages[]"  type="file" class="upload" />
													@if($edit)
													<span class="uploadBtn">Upload </span>
													@endif
												</label>
											</div>
											@if($edit)
											@if($cco == -1)
											<a  href="javascript:void(0);" id="addDD" class="text-green"><i class="fa fa-plus-circle fa-2x"></i></a>
											@else
											<a href="javascript:void(0);" class="remDD text-danger"><i class="fa fa-minus-circle fa-2x"></i></a> 
											@endif
											@endif
										</div>
                                    </div>
									<?php $cco++; ?>
                                @endforeach
								<input type="hidden" id="valaddDD" value="{{$cco}}" />
                            @else
                                <div class="form-group" >
                                    {!! Form::label('directors', 'Directors', array('class' => 'col-sm-1 control-label')) !!}
                                   <div class="col-sm-2">
                                        {!! Form::text('directors[]', null, array(  'placeholder'=>'Type the Name', 'class' => '  form-control','required'))!!}
                                    </div> 
									<div class="col-sm-3">
										<input type="text" class="form-control validator" name="nric[]" placeholder="Type the NRIC or Passport Number">
									</div>
									<div class="col-sm-2">
										{!! Form::select('dcountry[]', [''=>'Nationality']+$cf->getCountry(), null, ['class' => 'form-control  ',  'required', 'id' => 'dcountry']) !!}
									</div>
									<div class="col-sm-4">
										<div class="inputBtnSection">
											<input id="uploadFileDD" class="disableInputField  " placeholder="NRIC or Passport Photo" {{$disabled}} required="" />
											<label class="fileUpload">
												<input id="uploadBtnDD" name="directorImages[]" type="file" class="upload  " />
												@if($edit)
												<span class="uploadBtn">Upload </span>
												@endif
											</label>
										</div>
										<input name="uploadFileid[]" value="0" type="hidden"  />
										@if($edit)
										<a  href="javascript:void(0);" id="addDD" class="text-green"><i class="fa fa-plus-circle fa-2x"></i></a>
										@endif
										<input type="hidden" id="valaddDD" value="0">
									</div>
                                </div>
								<input type="hidden" id="valaddDD" value="0">
                            @endif
                        </div>
						                        <div class="form-group">
                            <label class="col-sm-3 control-label">Business Registration Number: </label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="business_reg_no" value="{{$userModel['station'][0]['business_reg_no']}}" placeholder="Type Business Number">
                            </div>
                        </div>
                            <div class="form-group">
								<label class="col-sm-3 control-label">Business Registration Form</label>
							
                            <div class="col-sm-8">
                            <div class="form-group" id="businessReg">
							<?php $ccd = -1; ?>
							<?php $ccdi = 0; ?>
                                @if(isset($doc))
                                    @foreach($doc as $DOC)
                                        {{--<h1>{{ $DOC->id }}</h1>--}}
                                        @if($DOC['name'] == 'registration')
											<?php 
													$file = asset('/') . 'images/document/' . $DOC->id . '/' . $DOC->path;
													$file_headers = @get_headers($file);
													if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
														$exists = false;
													}
													else {
														$exists = true;
													}
												?>
                                            <div class="col-sm-12 pull-left">
                                                <div class="inputBtnSection">
                                                    <input id="uploadFileBR{{$ccdi}}" style="cursor: pointer; color: blue;" required="" value="{{ $DOC->path }}" @if (!$exists) rel="" @else rel="{{asset('/')}}images/document/{{ $DOC->id }}/{{ $DOC->path }}" @endif title="Click to view attached document" class="disableInputField fileview" placeholder="Upload Document" />
													<input type="hidden" name="attfilesIDs[]" value="{{ $DOC->id }}"  />
													<input name="uploadFileBRName[]" value="{{ $DOC->path }}" type="hidden"  />
													<input name="uploadFileDoc[]" value="{{ $DOC->path }}" type="hidden"  />
                                                    <label class="fileUpload">
                                                        <input  id="uploadBtnBR{{$ccdi}}" name="Regupload_attachment[]"  type="file" class="upload" />
														@if($edit)
															<span class="uploadBtn">Upload </span>
														@endif
                                                    </label>
                                                </div>
												@if($edit)
												@if($ccd == -1)
												<a  href="javascript:void(0);" id="addBS" class="text-green"><i class="fa fa-plus-circle fa-2x"></i></a>
												@else   
												<a  href="javascript:void(0);"  class="remBS text-danger"><i class="fa fa-minus-circle fa-2x"></i></a>
												@endif
												@endif
												<script>
												$().ready(function () {
													$("#uploadBtnBR{{$ccdi}}").change(function () {
														var id = $(this).attr('id-attr');
														$("#uploadFileBR{{$ccdi}}").val($(this).val());
														$("#uploadFileBR{{$ccdi}}").removeClass("fileview");
													});
												});
												</script>
                                            </div>

                                            <div style="clear:both;"></div>
											<?php $ccd++; ?>
											<?php $ccdi++; ?>
                                        @endif
										
                                    @endforeach
									@if($ccd == -1)
									<div class="col-sm-12 pull-left">	
									<div class="inputBtnSection">
										<input id="uploadFileBR" class="disableInputField" required="" placeholder="Upload Document" {{$disabled}} />
										<label class="fileUpload">
											<input name="uploadFileBRName[]" value="0" type="hidden"  />
											<input id="uploadBtnBR" name="Regupload_attachment[]"  type="file" class="upload" />
											@if($edit)
											<span class="uploadBtn">Upload </span>
											@endif
										</label>
										<input name="uploadFileDoc[]" value="0" type="hidden"  />
									</div>
									@if($edit)
									<a  href="javascript:void(0);" id="addBS" class="text-green"><i class="fa fa-plus-circle fa-2x"></i></a>
									@endif
									<input type="hidden" id="valaddBS" value="0">                                   
									<?php $ccd++; ?>
									</div>
									@endif									
                                @else
                                    <!--<div class="col-sm-4">-->
									<div class="col-sm-12 pull-left">
                                        <div class="inputBtnSection">
                                            <input id="uploadFileBR" class="disableInputField"  placeholder="Upload Document" {{$disabled}} />
                                            <label class="fileUpload">
												<input name="uploadFileBRName[]" value="0" type="hidden"  />
                                                <input id="uploadBtnBR" name="Regupload_attachment[]"  type="file" class="upload" />
												@if($edit)
													<span class="uploadBtn">Upload </span>
												@endif
                                            </label>
                                         </div>
										  <input name="uploadFileDoc[]" value="0" type="hidden"  />
										@if($edit)
											<a  href="javascript:void(0);" id="addBS" class="text-green"><i class="fa fa-plus-circle fa-2x"></i></a>
										@endif
                                     </div>
                                     </div>
                                @endif
                            </div>
                         </div>
                        <div class="col-sm-7" style="margin-top: 10px; margin-bottom: 10px;">
                            <div class="form-group">
                                <label>Station Address</label>
                                <input type="text" name="line1" id="line1" class="form-control" required="" value="{{ isset($stationAddress->line1) && !empty($stationAddress->line1) ? $stationAddress->line1 : '' }}" >
                            </div>
                            <div class="form-group">
                                <input type="text" name="line2" id="line2" class="form-control" value="{{ isset($stationAddress->line2) && !empty($stationAddress->line2) ? $stationAddress->line2 : '' }}">
                            </div>
                            <div class="form-group">
                                <input type="text" name="line3" id="line3" class="form-control" value="{{ isset($stationAddress->line3) && !empty($stationAddress->line3) ? $stationAddress->line3 : '' }}">
                            </div>
                            <div class="form-group">
                                <input type="text" name="line4" id="line4" class="form-control" value="{{ isset($stationAddress->line4) && !empty($stationAddress->line4) ? $stationAddress->line4 : '' }}">
                            </div>
                        </div>

                        <div class="col-sm-5">
                            <label>&nbsp;</label>
                            <div class="form-group">
                                <label class="col-sm-5 control-label">Country: </label>
                                <div class="col-sm-7">
                                    {{-- {!! Form::select('country', [''=>'Country of Origin']+$cf->getCountry(), $userModel['address'][0]['city_id'], ['class' => 'form-control', 'necessary' ,'id' => 'country_id']) !!} --}}

                                    {!! Form::text('country_id', 'Malaysia', array('readonly' => 'readonly', 'class' => 'form-control', 'id' => 'country_id')) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-5 control-label">State: </label>
                                <div class="col-sm-7">
                                    {{-- @if(isset($userModel['address'][0]['city_id']))
                                     {!! Form::select('state', $cf->getState(),$userModel['address'][0]['state_id'], ['class' => 'form-control']) !!}
                                    @else
                                        <select class="form-control" id="states"></select>

                                    @endif --}}

                                    @def $states = \DB::table('state')->where('country_code', 'MYS')->get()
                                    <select class="form-control"" id="states">
                                        <option value="">Choose Option</option>
                                        @foreach($states as $state)
                                            <?php
                                                $selected = "";
                                                if($state->id == $state_id){
                                                   $selected = "selected";
                                                }
                                            ?>
                                            <option value="{!! $state->id !!}" {{ $selected  }}>{!! $state->name !!}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-5 control-label">City: </label>
                                <div class="col-sm-7">
                                    @if(isset($userModel['address'][0]['city_id']))
                                        {!! Form::select('city_id',$cf->getCityByState($userModel['address'][0]['state_code']), $userModel['address'][0]['city_id'], ['class' => 'form-control', 'id'=>'cities']) !!}
                                    @else
                                        <select class="form-control" id="cities" name="city_id" disabled></select>
                                    @endif

                                </div>
                            </div>
							 <div class="form-group">												
								<label class="col-sm-5 control-label">Area: </label>
								<div class="col-sm-7">
									@if(isset($userModel['address'][0]['city_id']))
										{!! Form::select('area_id', $cf->getAreaByCity($userModel['address'][0]['city_id']), $userModel['address'][0]['area_id'], ['class' => 'form-control', 'id'=>'areas']) !!}
									@else
										<select class="form-control" id="areas" name="area_id" disabled>
											<option value="0">Choose Option</option>
										</select>
									@endif
								</div>							
							</div>								
                            <div class="form-group">
                                <label class="col-sm-5 control-label">*Postcode /Zip Code</label>
                                <div class="col-sm-7">
                                    <input type="text" name="zip" class="form-control" required="" value="{{ $userModel['address'][0]['postcode']}}"><br>
                                </div>

                            </div>
                        </div>
						<input id="geoip_lat" name="geoip_lat" value="{{ $userModel['address'][0]['latitude']}}" type="hidden" />
						<input id="geoip_lon" name="geoip_lon" value="{{ $userModel['address'][0]['longitude']}}" type="hidden" />
						<div class="col-sm-5">
						</div>
						<div class="col-sm-7">
							<div id="map-container" class="custom-container pull-right" style="width:575px; height:435px;">
								  <div id="map-canvas" style="width:540px; height:400px;">
								  </div>

							</div>
						</div>						
                        <div class="clearfix"> </div>
					@if($type == "logistic")
						<div class="form-group">
							<label class="col-sm-2 control-label">Support API:</label>
							<div class="col-sm-4 col-xs-10">
								<input type="checkbox" name="support_api" {{$checkapi}} value='1' style="width: 20px;  height: 20px;" />
							</div>
						</div>
					@endif
                    <?php $webcount = 0;?>
                    @if( !is_null($userModel['websites'] ))
                    @foreach($userModel['websites'] as $websites)                           
                    @if($websites['type'] == "website" || $websites['type'] == null)
                    <div class="form-group">
                        @if($webcount > 0)
                        <label class="col-sm-2 control-label">&nbsp; </label>
                        @else
                        <label class="col-sm-2 control-label">Website:</label>
                        @endif                                  
                        <div class="col-sm-4 col-xs-10">                                
                            @if($websites['type'] == "website")
                            <input type="hidden" name="websiteRow" class="form-control" value="{{ $websites['id']}}">
                            <input type="url" name="website[]" class="form-control" value="{{ $websites['url']}}"  placeholder="http://www.abc.com.my">
                            <?php $webcount++;?>
                            @else
                            @if($websites['type'] == null)
                            <input type="url" name="website[]" class="form-control" value=""  placeholder="http://www.abc.com.my">
                            <?php $webcount++;?>
                            @endif
                            @endif
                        </div>                                      
                        @if($webcount > 1)
                        <div class="col-xs-1" style="padding-left:0"> 
                            @if($edit)
                            <a  href="javascript:void(0);"  class="remWS text-danger"><i class="fa fa-minus-circle fa-2x"></i></a>  
                            @endif
                        </div>
                        @else
                        <div class="col-xs-1" style="padding-left:0">
                            @if($edit)
                            <a  href="javascript:void(0);" id="addWS" class="text-green" ><i class="fa fa-plus-circle fa-2x"></i></a>
                            @endif
                        </div>
                        @endif
                    </div>
                    @endif
                    @endforeach
                    @if($webcount == 0)
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Website:</label>
                        <div class="col-sm-4 col-xs-10">        
                            <input type="url" name="website[]" class="form-control" value=""  placeholder="http://www.abc.com.my">
                            <?php $webcount++;?>
                        </div>
                        <div class="col-xs-1" style="padding-left:0">
                            @if($edit)
                            <a  href="javascript:void(0);" id="addWS" class="text-green" ><i class="fa fa-plus-circle fa-2x"></i></a>
                            @endif
                        </div>                                          
                    </div>                                                      
                    @endif
                    @else
                    <?php $webcount++;?>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Website:</label>
                        <div class="col-sm-4 col-xs-10">                                    
                            <input type="url" name="website[]" class="form-control" value=""  placeholder="http://www.abc.com.my">
                        </div>
                        <div class="col-xs-1" style="padding-left:0">
                            @if($edit)
                            <a  href="javascript:void(0);" id="addWS" class="text-green"><i class="fa fa-plus-circle fa-2x"></i></a>
                            @endif
                        </div>
                    </div>                          
                    @endif                                                
                    <div id="website"></div>

                    <?php $socialcount = 0;?>
                    @if( !is_null($userModel['websites'] ))
                    @foreach($userModel['websites'] as $websites)
                    @if($websites['type'] == "socialmedia" || $websites['type'] == null)
                    <div class="form-group">
                        @if($socialcount > 0)
                        <label class="col-sm-2 control-label">&nbsp; </label>
                        @else
                        <label class="col-sm-2 control-label">Social Media:</label>
                        @endif                                  
                        <div class="col-sm-4 col-xs-10">
                            @if($websites['type'] == "socialmedia")
                            <input type="hidden" name="socialRow" class="form-control" value="{{ $websites['id']}}">
                            <input type="text" name="social[]" class="form-control" value="{{ $websites['url']}}"  placeholder="http://www.abc.com.my">
                            <?php $socialcount++;?>
                            @else   
                            @if($websites['type'] == null)
                            <input type="url" name="social[]" class="form-control" value=""  placeholder="http://www.abc.com.my">
                            <?php $socialcount++;?>
                            @endif
                            @endif      
                        </div>
                        @if($socialcount > 1)
                        <div class="col-xs-1" style="padding-left:0">   
                            @if($edit)
                            <a  href="javascript:void(0);"  class="remSM text-danger"><i class="fa fa-minus-circle fa-2x"></i></a>   
                            @endif
                        </div>
                        @else
                        <div class="col-xs-1" style="padding-left:0">
                            @if($edit)
                            <a  href="javascript:void(0);" id="addSM" class="text-green" ><i class="fa fa-plus-circle fa-2x"></i></a>
                            @endif
                        </div>
                        @endif  
                    </div>
                    @endif
                    @endforeach
                    @if($socialcount == 0)
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Social Media:</label>
                        <div class="col-sm-4 col-xs-10">                                    
                            <input type="url" name="social[]" class="form-control" value=""  placeholder="http://www.abc.com.my">
                        </div>
                        <div class="col-xs-1" style="padding-left:0">
                            @if($edit)
                            <a  href="javascript:void(0);" id="addSM" class="text-green"><i class="fa fa-plus-circle fa-2x"></i></a>
                            @endif
                        </div>
                    </div>
                    <?php $socialcount++;?>
                    @endif                                  
                    @else
                    <?php $socialcount++;?>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Social Media:</label>
                        <div class="col-sm-4 col-xs-10">                                    
                            <input type="url" name="social[]" class="form-control" value=""  placeholder="http://www.abc.com.my">
                        </div>
                        <div class="col-xs-1" style="padding-left:0">
                            @if($edit)
                            <a  href="javascript:void(0);" id="addSM" class="text-green"><i class="fa fa-plus-circle fa-2x"></i></a>
                            @endif
                        </div>
                    </div>                          
                    @endif
                    <div id="socialMedia">  </div>
                    <?php $ecomcount = 0;?>
                    @if( ! is_null($userModel['websites'] ))
                    @foreach($userModel['websites'] as $websites)
                    @if($websites['type'] == "ecommerce" || $websites['type'] == null)
                    <div class="form-group">
                        @if($ecomcount > 0)
                        <label class="col-sm-2 control-label">&nbsp; </label>
                        @else
                        <label class="col-sm-2 control-label">Current eCommerce Site:</label>
                        @endif                                      
                        <div class="col-sm-4 col-xs-10">
                            @if($websites['type'] == "ecommerce")
                            <input type="hidden" name="ecom_siteRow" class="form-control" value="{{ $websites['id']}}">
                            <input type="text" name="ecom_site[]" class="form-control"  value="{{ $websites['url']}}" placeholder="http://www.abc.com">
                            <?php $ecomcount++;?>
                            @else   
                            @if($websites['type'] == null)
                            <input type="url" name="ecom_site[]" class="form-control" value=""  placeholder="http://www.abc.com.my">
                            <?php $ecomcount++;?>
                            @endif                                          
                            @endif
                        </div>
                        @if($ecomcount > 1)
                        <div class="col-xs-1" style="padding-left:0">   
                            @if($edit)
                            <a  href="javascript:void(0);"  class="remEcom text-danger"><i class="fa fa-minus-circle fa-2x"></i></a>  
                            @endif
                        </div>
                        @else
                        <div class="col-xs-1" style="padding-left:0">
                            @if($edit)
                            <a  href="javascript:void(0);" id="addEcom" class="text-green" ><i class="fa fa-plus-circle fa-2x"></i></a>
                            @endif
                        </div>
                        @endif  
                    </div>
                    @endif                                      
                    @endforeach
                    @if($ecomcount == 0)
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Current eCommerce Site:</label>
                        <div class="col-sm-4 col-xs-10">                                    
                            <input type="url" name="ecom_site[]" class="form-control" value=""  placeholder="http://www.abc.com.my">
                        </div>
                        <div class="col-xs-1" style="padding-left:0">
                            @if($edit)
                            <a  href="javascript:void(0);" id="addEcom" class="text-green"><i class="fa fa-plus-circle fa-2x"></i></a>
                            @endif
                        </div>
                    </div>
                    <?php $ecomcount++;?>
                    @endif
                    @else
                    <?php $ecomcount++;?>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Current eCommerce Site:</label>
                        <div class="col-sm-4 col-xs-10">
                            <input type="url" name="ecom_site[]" class="form-control" value=""  placeholder="http://www.abc.com.my">
                        </div>
                        <div class="col-xs-1" style="padding-left:0">
                            @if($edit)
                            <a  href="javascript:void(0);" id="addEcom" class="text-green"><i class="fa fa-plus-circle fa-2x"></i></a>
                            @endif
                        </div>
                    </div>                          
                    @endif                          
                    <div id="currEcom"> </div>						
					@if($type == "logistic")
						<?php $capcount = 0;?>
						@if( ! is_null($logcapabilities ))
							@foreach($logcapabilities as $capabilities)
								<div class="form-group">
									@if($capcount > 0)
									<label class="col-sm-2 control-label">&nbsp; </label>
									@else
									<label class="col-sm-2 control-label">Capabilities:</label>
									@endif                                      
									<div class="col-sm-4 col-xs-10">
										<select name='capabilities[]' id='capabilities{{$capcount}}' class='capabilities'>
											<option value="">Please Select</option>
											<?php $selected_cap = ''; ?>
											@foreach($system_capabilities as $system_capability)
												@if($logcapabilities->capability_id == $system_capability->id)
													<?php $selected = 'selected_cap'; ?>
												@endif
												<option value='{{$system_capability->id}}' {{$selected_cap}}>{{$system_capability->description}}</option>
											@endforeach
										</select>
										<?php $capcount++;?>
									</div>
									@if($capcount > 1)
									<div class="col-xs-1" style="padding-left:0">   
										@if($edit)
										<a  href="javascript:void(0);"  class="remCap text-danger"><i class="fa fa-minus-circle fa-2x"></i></a>  
										@endif
									</div>
									@else
									<div class="col-xs-1" style="padding-left:0">
										@if($edit)
										<a  href="javascript:void(0);" id="addCap" class="text-green" ><i class="fa fa-plus-circle fa-2x"></i></a>
										@endif
									</div>
									@endif  
								</div>                                    
							@endforeach
							@if($capcount == 0)
							<div class="form-group">
								<label class="col-sm-2 control-label">Capabilities:</label>
								<div class="col-sm-4 col-xs-10">                                    
									<select name='capabilities[]' id='capabilities0' class='capabilities'>
										<option value="">Please Select</option>
										@foreach($system_capabilities as $system_capability)
											<option value='{{$system_capability->id}}'>{{$system_capability->description}}</option>
										@endforeach
									</select>
								</div>
								<div class="col-xs-1" style="padding-left:0">
									@if($edit)
									<a  href="javascript:void(0);" id="addCap" class="text-green"><i class="fa fa-plus-circle fa-2x"></i></a>
									@endif
								</div>
							</div>
							<?php $capcount++;?>
							@endif
						@else
						<div class="form-group">
							<label class="col-sm-2 control-label">Capabilities:</label>
							<div class="col-sm-4 col-xs-10">                                    
								<select name='capabilities[]' id='capabilities0' class='capabilities'>
									<option value="">Please Select</option>
									@foreach($system_capabilities as $system_capability)
										<option value='{{$system_capability->id}}'>{{$system_capability->description}}</option>
									@endforeach
								</select>
							</div>
							<div class="col-xs-1" style="padding-left:0">
								@if($edit)
								<a  href="javascript:void(0);" id="addCap" class="text-green"><i class="fa fa-plus-circle fa-2x"></i></a>
								@endif
							</div>
						</div>
						<?php $capcount++;?>                       
						@endif         
						<input id="currentCap"  value="{{$capcount}}" type='hidden' />
						<div id="currCap"> </div>						
					@endif
                    <hr>
                    <div class="bankdetail" id="bank">
                        <h2>Bank Details</h2>
                        @def $bank_account_name =  isset($bankDetails->account_name1) && !empty($bankDetails->account_name1) ? $bankDetails->account_name1 : ''
                        @def $bank_account_number = isset($bankDetails->account_number1) && !empty($bankDetails->account_number1) ? $bankDetails->account_number1 : ''
                        @def $bank_name =  isset($bankDetails->name) && !empty($bankDetails->name) ? $bankDetails->name : ''
                        @def $bank_id = isset($bankDetails->bank_id) && !empty($bankDetails->bank_id) ? $bankDetails->bank_id : ''
                        @def $bank_iban = isset($bankDetails->iban) && !empty($bankDetails->iban) ? $bankDetails->iban : ''
                        @def $bank_swift = isset($bankDetails->swift) && !empty($bankDetails->swift) ? $bankDetails->swift : ''
                        <div class="formform-group" style="padding-left: 0; ">
                            {!! Form::label('account_name', '*Account Name', array('class' => 'col-sm-2 control-label', 'style'=>'padding-left: 0;  padding-right: 20px;')) !!}
                            <div class="col-sm-4" style="padding-left: 0;">
                                {!! Form::text('account_name',$bank_account_name, array('class' => 'form-control'))!!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('account_number', '*Account Number', array('class' => 'col-sm-2 control-label')) !!}
                            <div class="col-sm-4" >
                                {!! Form::text('account_number', $bank_account_number, array('class' => 'form-control'))!!}
                            </div>
                        </div>
                        <div class="form-group">

                            {!! Form::label('bank', '*Bank', array('class' => 'col-sm-2 control-label')) !!}
                            <div class="col-sm-4" >
                            @if(isset($bank_name))
                            {!! Form::select('bank', ['' => 'Choose Option' ]+$cf->getBank(), $bank_id, ['class' => 'form-control' ,'id' => 'bank']) !!}
                            @else
                                {!! Form::select('bank', $bankArray, ['id' => 'bank_id', 'class' => 'form-control'] ) !!}
                            @endif
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('ibn', 'IBAN', array('class' => 'col-sm-2 control-label')) !!}
                            <div class="col-sm-4">
                                {!! Form::text('ibn', $bank_iban, array('class' => 'form-control'))!!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('swift', 'SWIFT', array('class' => 'col-sm-2 control-label')) !!}
                            <div class="col-sm-4">
                                {!! Form::text('swift', $bank_swift, array('class' => 'form-control'))!!}
                            </div>
                        </div>
                    </div> {{--end bank detail--}}			
					<hr>
                    <div id="station">
                        <h2>Station Description</h2>
						@if($edit)
						<textarea class="form-control" id="info-textarea2"
						name="description">
						{{$userModel['station'][0]['description']}}
						</textarea>
						@else
						{!! $userModel['station'][0]['description'] !!}
						@endif
						
						<?php $brandcount = 0;?>
						<div id="brandss" style="{{$hide_log}}">
						<div class="row" style="margin-bottom: 10px;">
							<label class="col-sm-4 control-label">What brands do you sell?</label>
							<div class="clearfix"></div>
							<label class="col-sm-3 control-label">Brand</label>
							<label class="col-sm-2 control-label">Relationship</label>
							<label class="col-sm-3 control-label">Subcategory</label>
							<label class="col-sm-3 control-label">Brand Authorization Letter</label>
						</div>
						@if( ! is_null($userModel['brand'] ) && count($userModel['brand'] ) > 0)
						@foreach($userModel['brand'] as $brandm)
							@if(!is_null($brandm['id']))
							
							<div class="form-group">   
								<div class="col-sm-3 col-xs-10" style="padding-left: 5px !important; padding-right: 5px !important;">
								@if(isset($brand_table))
								<select name="brand_name[]" class="form-control" id="brandNames">
									@foreach($brand_table as $brand)
										<?php 
											$selected_m = "";
											if($brandm['id'] == $brand['id']){
												$selected_m = "selected";
											}
										?>
										<option value="{{$brand['id']}}" {{$selected_m}}>{{$brand['name']}}</option>
									@endforeach
								</select>
								@endif
								<input type="hidden" name="brand_ids[]" value="{{$brandm['id']}}" />
								</div>
								<div class="col-sm-2 col-xs-10" style="padding-left: 5px !important; padding-right: 5px !important;">
									<select name="brand_relationship[]" class="form-control" id="brandRelationship">
										<option value="">Please Select</option>
										<option @if($brandm['relationship'] == 'Manufacturer') selected @endif value="Manufacturer">Manufacturer</option>
										<option @if($brandm['relationship'] == 'Main Distributor') selected @endif   value="Main Distributor">Main Distributor</option>
										<option @if($brandm['relationship'] == 'Distributor') selected @endif  value="Distributor">Distributor</option>
										<option @if($brandm['relationship'] == 'Sub-Distributor') selected @endif  value="Sub-Distributor">Sub-Distributor</option>
										<option @if($brandm['relationship'] == 'Retailer') selected @endif  value="Retailer">Retailer</option>
									</select>
								</div>	
							<div class="col-sm-3 col-xs-10" style="padding-left: 5px !important; padding-right: 5px !important;">							
								<select name="subcat_name[]" class="form-control" id="subcatNames">
									<option value="0-0">Various</option>
									@if(isset($subcats))
										@foreach($subcats as $subcat)
										<?php 
											$selected_m = "";
											if($brandm['subcat_id'] == $subcat->id && $brandm['subcat_level'] == $subcat->levelsub){
												$selected_m = "selected";
											}
										?>
										<option value="{{$subcat->id}}-{{$subcat->levelsub}}" {{$selected_m }}>{{$subcat->description}}</option>
										@endforeach
									@endif	
								</select>
							</div>									
								<div class="col-sm-3 col-xs-10" style="padding-left: 5px !important; padding-right: 5px !important;">
									<input type="hidden" name="brandIDs[]" value="{{ $brandm['id'] }}"  />
									<div class="inputBtnSection">
												<?php 
													/*$file = asset('/') . 'images/document/' . $brandm['document_id'] . '/' .  $brandm['doc'];
													$file_headers = @get_headers($file);
													if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
														$exists = false;
													}
													else {
														$exists = true;
													}*/
                                        $exists = true;
												?>											
										<input id="uploadFileBrand" name="uploadFileBrand[]" value="{{ $brandm['doc'] }}" @if (!$exists) rel="" @else rel="{{asset('/')}}images/document/{{ $brandm['document_id'] }}/{{ $brandm['doc'] }}" @endif title="Click to view attached document" class="disableInputField fileview" placeholder="Upload Document" style="cursor:pointer;  color: blue;" size="15" />
										<label class="fileUpload">
										<input name="uploadBrandFileid[]" value="{{ $brandm['document_id'] }}" type="hidden"  />
											<input id="uploadBtnBrand" name="Brandsupload_attachment[]"  type="file" class="upload" />
											@if($edit)
												<span class="uploadBtn">Upload </span>
											@endif
										</label>										
									</div>						
								</div>								
								
							@if($brandcount >= 1)
							<div class="col-xs-1" style="padding-left:0">
								@if($edit)
								<a  href="javascript:void(0);" id="remBD" class="text-danger"><i class="fa fa-minus-circle fa-2x"></i></a>
								@endif
							</div>				
							@else
							<div class="col-xs-1" style="padding-left:0">
								@if($edit)
								<a  href="javascript:void(0);" id="addBD" class="text-green"><i class="fa fa-plus-circle fa-2x"></i></a>
								@endif
							</div>									
							@endif
							</div>
							<?php $brandcount++; ?>
							@endif
						@endforeach
						<input type="hidden" id="valaddBD" value="{{$brandcount}}"> 
						@if($brandcount == 0)
						<div class="form-group">
							<div class="col-sm-3 col-xs-10" style="padding-left: 5px !important; padding-right: 5px !important;">
								<?php $aup = false; ?>
								@if($isbrand)
								<select name="brand_name[]" class="form-control" id="brandNames">
									@if(isset($brand_table) and isset($userModel['brand']))
									@foreach($brand_table as $brand)
									<?php $aup = false; ?>
									@foreach($userModel['brand'] as $brands)
									@if($brands['id'] == $brand['id'])
										<?php $aup = true; ?>
										<option value="{{$brand['id']}}" selected>{{$brand['name']}}</option>
									@endif
									@endforeach
									@if(!$aup)
										<option value="{{$brand['id']}}" >{{$brand['name']}}</option>
									@endif
									@endforeach
									@endif
								</select>

								@else
								@if(isset($brand_table))
								<select name="brand_name[]" class="form-control" id="brandNames">
									@foreach($brand_table as $brand)
										<option value="{{$brand['id']}}">{{$brand['name']}}</option>
									@endforeach
								</select>
								@endif
								@endif
							</div>
							<input type="hidden" name="brand_ids[]" value="0" />
							<div class="col-sm-2 col-xs-10" style="padding-left: 5px !important; padding-right: 5px !important;">
								<select name="brand_relationship[]" class="form-control" id="brandRelationship">
									<option value="">Please Select</option>
									<option value="Manufacturer">Manufacturer</option>
									<option value="Main Distributor">Main Distributor</option>
									<option value="Distributor">Distributor</option>
									<option value="Sub-Distributor">Sub-Distributor</option>
									<option value="Retailer">Retailer</option>
								</select>
							</div>
							<div class="col-sm-3 col-xs-10" style="padding-left: 5px !important; padding-right: 5px !important;">							
								<select name="subcat_name[]" class="form-control" id="subcatNames">
									<option value="0-0">Various</option>
									@if(isset($subcats))
										@foreach($subcats as $subcat)
										<option value="{{$subcat->id}}-{{$subcat->levelsub}}" >{{$subcat->description}}</option>
										@endforeach
									@endif										
								</select>
								
							</div>							
							<div class="col-sm-3 col-xs-10" style="padding-left: 5px !important; padding-right: 5px !important;">
								<div class="inputBtnSection">
									<input id="uploadFileBrand" class="disableInputField  " value="" placeholder="Upload Document" size="15" />
									<label class="fileUpload">
										<input id="uploadBtnBrand" name="Brandsupload_attachment[]"  type="file" class="upload" />
										<span class="uploadBtn">Upload </span>
									</label>
								</div>						
							</div>
							<input type="hidden" id="valaddBD" value="0">  
							<div class="col-xs-1" style="padding-left:0">
								@if($edit)
								<a  href="javascript:void(0);" id="addBD" class="text-green"><i class="fa fa-plus-circle fa-2x"></i></a>
								@endif
							</div>
						</div>						
						@endif
						@else
						<div class="form-group">
							<label class="col-sm-4 control-label">What brand do you sell? </label>
							<div class="clearfix"></div>
							<label class="col-sm-3 control-label">Brand</label>
							<label class="col-sm-2 control-label">Relationship</label>
							<label class="col-sm-3 control-label">Subcategory</label>
							<label class="col-sm-3 control-label">Brand Authorization Letter</label>
							<div class="col-sm-4 col-xs-10">
								<?php $aup = false; ?>
								@if($isbrand)
								<select name="brand_name[]" class="form-control" id="brandNames">
									@if(isset($brand_table) and isset($userModel['brand']))
									@foreach($brand_table as $brand)
									<?php $aup = false; ?>
									@foreach($userModel['brand'] as $brands)
									@if($brands['id'] == $brand['id'])
										<?php $aup = true; ?>
										<option value="{{$brand['id']}}" selected>{{$brand['name']}}</option>
									@endif
									@endforeach
									@if(!$aup)
										<option value="{{$brand['id']}}" >{{$brand['name']}}</option>
									@endif
									@endforeach
									@endif
								</select>

								@else
								@if(isset($brand_table))
								<select name="brand_name[]" class="form-control" id="brandNames">
									@foreach($brand_table as $brand)
									<option value="{{$brand['id']}}">{{$brand['name']}}</option>
									@endforeach
								</select>
								@endif
								@endif
							</div>
							<input type="hidden" name="brand_ids[]" value="0" />
							<div class="col-sm-3 col-xs-10">
								<div class="inputBtnSection">
									<input id="uploadFileBrand" class="disableInputField  " size="15" value="" placeholder="Upload Document"  />
									<label class="fileUpload">
										<input id="uploadBtnBrand" name="Brandsupload_attachment[]"  type="file" class="upload" />
										<span class="uploadBtn">Upload </span>
									</label>
								</div>						
							</div>
							<input type="hidden" id="valaddBD" value="0">  
							<div class="col-xs-1" style="padding-left:0">
								@if($edit)
									<a  href="javascript:void(0);" id="addBD" class="text-green"><i class="fa fa-plus-circle fa-2x"></i></a>

								@endif
							</div>
						</div>							
						@endif

						<div id="brandDetail"> </div>
					<br>						
						
                        <div class="form-group">
                            <label class="col-sm-6 control-label">How many products/SKU you plan to sell? </label>
                            <div class="col-sm-6">
                                {!! Form::select('sell_plan', ['' => 'Choose Option',
                                '50' => '<50', '500' => '51-500', '2000' => '501-2000', '5000'=>'2000-5000','10000'=>'5001-10000','20000'=>'10001-20000','50000'=>'20001-50000','100000'=>'>50000'],$userModel['station'][0]['planned_sales'], ['class' => 'form-control'] ) !!}
                            </div>
							<div class="clearfix">&nbsp;</div>
                        </div>
                     <!--   <hr>
						
                        <h2>Brand Details</h2>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">What brand do you sell? </label>
                            <div class="col-sm-6 col-xs-10">

                                @if(isset($isbrand))
                                    <select name="brand_name[]" class="form-control" id="brandNames">
                                        @if(isset($brand_table) and isset($userModel['brand']))
                                            @foreach($brand_table as $brand)
                                                @foreach($userModel['brand'] as $brands)
                                                    @if($brands['id'] == $brand['id'])
                                                        <option value="{{$brand['id']}}" selected>{{$brand['name']}}</option>
                                                    @else
                                                        <option value="{{$brand['id']}}">{{$brand['name']}}</option>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        @endif
                                    </select>

                                @else
                                    @if(isset($brand_table))
                                        <select name="brand_name[]" class="form-control" id="brandNames">
                                            @foreach($brand_table as $brand)
                                                <option value="{{$brand['id']}}">{{$brand['name']}}</option>
                                            @endforeach
                                        </select>
                                    @endif
                                @endif
                            </div>
                            <div class="col-xs-1">
								@if($edit)
									<a  href="javascript:void(0);" id="addBD" class="text-green"><i class="fa fa-plus-circle fa-2x"></i></a>
								@endif
                            </div>
                        </div> -->
                        <div id="brandDetail"> </div>
                    </div>
                    </div>

                    <hr>
					@if($type != "logistic")
						@if(!is_null($outlets) && count($outlets) > 0)
							<?php $outleti = 0; ?>
							@foreach($outlets as $outlet)
							<div id="outlets">
								<div class="row" id="location">
									<div class="col-sm-8">
										<div class="col-sm-10 no-padding">
											<h2 style="margin-top:0px;" class="col-sm-3 no-padding">Outlet: </h2>
											<div class="col-sm-7">
												{!! Form::text('outlet_name[]',$outlet->outlet_name , array('class' => 'form-control','placeholder'=>'Please fill in Outlet Name'))!!}
											</div>
											<div class="col-sm-2">
												&nbsp;
											</div>
										</div>									
									</div>	
									<div class="col-sm-4">
										&nbsp;
									</div>
									<div class="col-sm-12">
										<h3 style="margin-top:0px;">Location</h3>
									</div>								
									<div class="col-sm-5">
										<label>&nbsp;</label>
										<div class="form-group">
											<label class="col-sm-5 control-label">Country: </label>
											<div class="col-sm-7">
											  {{--       {!! Form::text('country_id', 'Malaysia',
													array('readonly' => 'readonly',
													'class' => 'form-control',
													'id' => 'station_country_id',
													'necessary')) !!} --}}
													{{-- cop --}}
												{!! Form::text('country_id', 'Malaysia',
													array(
													'class' => 'form-control',
													'id' => 'station_country_id', 'disabled')) !!}
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-5 control-label">State: </label>
											<div class="col-sm-7">
												@def $states = \DB::table('state')->where('country_code', 'MYS')->get()
												<select class="form-control station_states" rel="{{$outleti}}" id="station_states{{$outleti}}" name="state_idst[]">
													<option value="">Choose Option</option>
													@foreach($states as $state)
														<?php

															$selected = "";
															if($state->id == $outlet->state_id){
															   $selected = "selected";
															}

														?>
														<option value="{!! $state->id !!}" {{ $selected }}>{!! $state->name !!}</option>
													@endforeach
												</select>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-5 control-label">City: </label>
											<div class="col-sm-7">
													<?php
														$cities = $cf->getCityByState($outlet->state_code);
													?>
													<select class="form-control station_cities" rel="{{$outleti}}" id="station_cities{{$outleti}}" name="city_idst[]">
													<option value="">Choose Option</option>
													@foreach($cities as $key => $value)
														<?php 
															$sci = "";
															if($outlet->city_id == $key){
																$sci = "selected";
															}
														?>													
														<option value="{!! $key !!}" {{$sci}}>{!! $value !!}</option>
													@endforeach
													</select>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-5 control-label">Area: </label>
											<div class="col-sm-7">
												<?php 
													$areas = $cf->getAreaByCity($outlet->city_id);
												?>
												<select class="form-control" id="station_areas{{$outleti}}" rel="{{$outleti}}" name="area_idst[]">
												@foreach($areas as $key => $value)
													
														<option value="">Choose Option</option>
														<?php 
															$sar = "";
															if($outlet->area_id == $key){
																$sar = "selected";
															}
														?>													
														<option value="{!! $key !!}" {{$sar}}>{!! $value !!}</option>														
													
												@endforeach	
												</select>											
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-5 control-label">Postcode /Zip Code: </label>
											<div class="col-sm-7">
												<input type="text" name="zipcode[]" class="form-control" value="{{$outlet->postcode}}">									
											</div>
										</div>									
										<div class="form-group">
											<label class="col-sm-3 control-label">Address</label>
											<div class="col-sm-9">
												<input type="text" name="outlet_line1[]" id="station_line1{{$outleti}}" class="form-control" value="{{$outlet->line1}}" >
											</div>	
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label">&nbsp;</label>
											<div class="col-sm-9">
												<input type="text" name="outlet_line2[]" id="station_line2{{$outleti}}" class="form-control" value="{{$outlet->line2}}">
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label">&nbsp;</label>
											<div class="col-sm-9">
												<input type="text" name="outlet_line3[]" id="station_line3{{$outleti}}" class="form-control" value="{{$outlet->line3}}">
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label">&nbsp;</label>
											<div class="col-sm-9">
												<input type="text" name="outlet_line4[]" id="station_line4{{$outleti}}" class="form-control" value="{{$outlet->line4}}">
											</div>	
										</div>								
									</div>
									<div class="col-sm-7">
										<div id="map-container{{$outleti}}" class="custom-container" style="width:575px; height:435px;">
											  <div id="map-canvas{{$outleti}}" style="width:540px; height:400px;">
											  </div>

										</div>
									</div>
								</div>
														
								<div class="row" id="property">
									<div class="col-sm-12">
										<input id="geoip_lat{{$outleti}}" name="geoip_lats[]" value="0" type="hidden" />
										<input id="geoip_lon{{$outleti}}" name="geoip_lons[]" value="0" type="hidden" />									
										<input name="biz_owner_contact[]" value="" type="hidden" />					
										<input name="biz_owner_first_name[]" value="" type="hidden" />					
										<input name="biz_owner_last_name[]" value="" type="hidden" />					
										<div class="form-group">
											{!! Form::label('shop_size', 'Shop Size', array('class' => 'col-sm-2 control-label')) !!}
											<div class="col-sm-4">
												{!! Form::text('shop_size[]',$outlet->shop_size , array('class' => 'form-control'))!!}
											</div>
										</div>
										<div class="form-group">
											{!! Form::label('biz_name', 'Business Name', array('class' => 'col-sm-2 control-label')) !!}
											<div class="col-sm-4">
												{!! Form::text('biz_name[]',$outlet->biz_name, array('class' => 'form-control',))!!}
											</div>
										</div>								
										<div class="form-group" >
											{!! Form::label('owner', 'Owner',array('class' => 'col-sm-2 control-label')) !!}
											<div class="col-sm-4">
												{!! Form::text('firstname_property[]',$outlet->prop_owner_first_name, array( "data-bv-trigger" => "keyup", 'placeholder'=>'First Name', 'class' => 'form-control' ))!!}
											</div>
											<div class="col-sm-4">
												{!! Form::text('lastname_property[]',$outlet->prop_owner_last_name, array( "data-bv-trigger" => "keyup", 'placeholder'=>'Last Name', 'class' => 'form-control'))!!}
											</div>
										</div>
										<div class="form-group">
											{!! Form::label('contact_property', 'Contact', array('class' => 'col-sm-2 control-label')) !!}
											<div class="col-sm-4">
												{!! Form::text('contact_property[]',$outlet->prop_owner_contact, array('class' => 'form-control'))!!}
											</div>
										</div>
									</div>
								</div>
								<div class="row" id="business">
									<div class="col-sm-12">
										<div class="form-group">
											<label class="col-sm-2 control-label">Outlet </label>
											<div class="col-sm-4">
												{!! Form::select('outlet_business[]', ['' => 'Choose Option' ]+$cf->getOutlet(), $outlet->outlet_id, ['class' => 'form-control', 'id' => 'outlet_business0']) !!}
											</div>
										</div>
										<div class="form-group">
											{!! Form::label('delivery_business', 'Delivery', array('class' => 'col-sm-2 control-label')) !!}
											<div class="col-sm-4">
												{!! Form::select('delivery_business[]', ['pickup;sys_delivery'=>'Pickup & Delivery','pickup'=>'Pickup','pickup;own_delivery'=>'Pickup & Self Delivery'], $outlet->delivery_mode, ['class' => 'form-control', 'id' => 'delivery_business0' ]) !!}
											</div>
											<div class="col-sm-6">
												@if($edit)
													<a href="javascript:void(0);" class="add_outlet btn btn-info pull-right">+</a>
												@endif
											</div>
										</div>
									</div>
								</div>
							</div>	
							<input name="outlet_id[]" value="{{$outlet->id}}" type="hidden" />
							<?php $outleti++; ?>
							@endforeach
							<input id="current_outlet" value="{{$outleti}}" type="hidden" />
							
						@else
							<div id="outlets">
								<div class="row" id="location">
									<div class="col-sm-8">
										<div class="col-sm-10 no-padding">
											<h2 style="margin-top:0px;" class="col-sm-3 no-padding">Outlet: </h2>
											<div class="col-sm-7">
												{!! Form::text('outlet_name[]',null , array('class' => 'form-control','placeholder'=>'Please fill in Outlet Name'))!!}
											</div>
											<div class="col-sm-2">
												&nbsp;
											</div>
										</div>									
									</div>	
									<div class="col-sm-4">
										&nbsp;
									</div>
									<div class="col-sm-12">
										<h3 style="margin-top:0px;">Location</h3>
									</div>								
									<div class="col-sm-5">
										<label>&nbsp;</label>
										<div class="form-group">
											<label class="col-sm-5 control-label">Country: </label>
											<div class="col-sm-7">
											  {{--       {!! Form::text('country_id', 'Malaysia',
													array('readonly' => 'readonly',
													'class' => 'form-control',
													'id' => 'station_country_id',
													'necessary')) !!} --}}
													{{-- cop --}}
												{!! Form::text('country_id', 'Malaysia',
													array(
													'class' => 'form-control',
													'id' => 'station_country_id', 'disabled')) !!}
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-5 control-label">State: </label>
											<div class="col-sm-7">
												@def $states = \DB::table('state')->where('country_code', 'MYS')->get()
												<select class="form-control station_states" rel="0" id="station_states0" name="state_idst[]">
													<option value="">Choose Option</option>
													@foreach($states as $state)
														<?php

															$selected = "";
															if($state->id == $state_id){
															   $selected = "selected";
															}

														?>
														<option value="{!! $state->id !!}" {{ $selected }}>{!! $state->name !!}</option>
													@endforeach
												</select>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-5 control-label">City: </label>
											<div class="col-sm-7">

													<select class="form-control station_cities" rel="0" id="station_cities0" name="city_idst[]" disabled></select>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-5 control-label">Area: </label>
											<div class="col-sm-7">
													<select class="form-control" id="station_areas0" rel="0" name="area_idst[]" disabled></select>

											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-5 control-label">Postcode /Zip Code: </label>
											<div class="col-sm-7">
												<input type="text" name="zipcode[]" class="form-control" value="">									
											</div>
										</div>									
										<div class="form-group">
											<label class="col-sm-3 control-label">Address</label>
											<div class="col-sm-9">
												<input type="text" name="outlet_line1[]" id="station_line10" class="form-control" value="" >
											</div>	
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label">&nbsp;</label>
											<div class="col-sm-9">
												<input type="text" name="outlet_line2[]" id="station_line20" class="form-control" value="">
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label">&nbsp;</label>
											<div class="col-sm-9">
												<input type="text" name="outlet_line3[]" id="station_line30" class="form-control" value="">
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label">&nbsp;</label>
											<div class="col-sm-9">
												<input type="text" name="outlet_line4[]" id="station_line40" class="form-control" value="">
											</div>	
										</div>								
									</div>
									<div class="col-sm-7">
										<div id="map-container0" class="custom-container" style="width:575px; height:435px;">
											  <div id="map-canvas0" style="width:540px; height:400px;">
											  </div>

										</div>
									</div>
								</div>
														
								<div class="row" id="property">
									<div class="col-sm-12">
										<input id="geoip_lat0" name="geoip_lats[]" value="0" type="hidden" />
										<input id="geoip_lon0" name="geoip_lons[]" value="0" type="hidden" />									
										<input name="biz_owner_contact[]" value="" type="hidden" />					
										<input name="biz_owner_first_name[]" value="" type="hidden" />					
										<input name="biz_owner_last_name[]" value="" type="hidden" />					
										<div class="form-group">
											{!! Form::label('shop_size', 'Shop Size', array('class' => 'col-sm-2 control-label')) !!}
											<div class="col-sm-4">
												{!! Form::text('shop_size[]',null , array('class' => 'form-control'))!!}
											</div>
										</div>
										<div class="form-group">
											{!! Form::label('biz_name', 'Business Name', array('class' => 'col-sm-2 control-label')) !!}
											<div class="col-sm-4">
												{!! Form::text('biz_name[]',null, array('class' => 'form-control'))!!}
											</div>
										</div>								
										<div class="form-group" >
											{!! Form::label('owner', 'Owner',array('class' => 'col-sm-2 control-label')) !!}
											<div class="col-sm-4">
												{!! Form::text('firstname_property[]',null, array( "data-bv-trigger" => "keyup", 'placeholder'=>'First Name', 'class' => 'form-control' ))!!}
											</div>
											<div class="col-sm-4">
												{!! Form::text('lastname_property[]',null, array( "data-bv-trigger" => "keyup", 'placeholder'=>'Last Name', 'class' => 'form-control' ))!!}
											</div>
										</div>
										<div class="form-group">
											{!! Form::label('contact_property', 'Contact', array('class' => 'col-sm-2 control-label')) !!}
											<div class="col-sm-4">
												{!! Form::text('contact_property[]',null, array('class' => 'form-control'))!!}
											</div>
										</div>
									</div>
								</div>
								<div class="row" id="business">
									<div class="col-sm-12">
										<div class="form-group">
											<label class="col-sm-2 control-label">Outlet </label>
											<div class="col-sm-4">
												{!! Form::select('outlet_business[]', ['' => 'Choose Option' ]+$cf->getOutlet(), null, ['class' => 'form-control', 'id' => 'outlet_business0']) !!}
											</div>
										</div>
										<div class="form-group">
											{!! Form::label('delivery_business', 'Delivery', array('class' => 'col-sm-2 control-label')) !!}
											<div class="col-sm-4">
												{!! Form::select('delivery_business[]', ['pickup;sys_delivery'=>'Pickup & Delivery','pickup'=>'Pickup','pickup;own_delivery'=>'Pickup & Self Delivery'], null, ['class' => 'form-control', 'id' => 'delivery_business0' ]) !!}
											</div>
											<div class="col-sm-6">
												@if($edit)
													<a href="javascript:void(0);" class="add_outlet btn btn-info pull-right">+</a>
												@endif
											</div>
										</div>
									</div>
								</div>
							</div>	
							<input name="outlet_id" value="0" type="hidden" />
							<input id="current_outlet" value="0" type="hidden" />
						@endif
                    @else
					<div id="outlets">
						<div class="row" id="location">
							<div class="col-sm-10">
								<div class="col-sm-10 no-padding">
									<h2 style="margin-top:0px;" class="col-sm-5 no-padding">Distribution Center: </h2>
									<div class="col-sm-7">
										{!! Form::text('dc_name[]',null , array('class' => 'form-control', 'necessary','placeholder'=>'Please fill in Distribution Name'))!!}
									</div>
								</div>									
							</div>	
							<div class="col-sm-2">
								&nbsp;
							</div>
							<div class="col-sm-12">
								<h3 style="margin-top:0px;">Location</h3>
							</div>								
							<div class="col-sm-5">
								<label>&nbsp;</label>
								<div class="form-group">
									<label class="col-sm-5 control-label">Country: </label>
									<div class="col-sm-7">
									  {{--       {!! Form::text('country_id', 'Malaysia',
											array('readonly' => 'readonly',
											'class' => 'form-control',
											'id' => 'station_country_id',
											'necessary')) !!} --}}
											{{-- cop --}}
										{!! Form::text('country_id', 'Malaysia',
											array(
											'class' => 'form-control',
											'id' => 'station_country_id',
											'necessary', 'disabled')) !!}
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-5 control-label">State: </label>
									<div class="col-sm-7">
										@def $states = \DB::table('state')->where('country_code', 'MYS')->get()
										<select class="form-control station_states" rel="0" id="station_states0" name="state_idst[]" necessary>
											<option value="">Choose Option</option>
											@foreach($states as $state)
												<?php

													$selected = "";
													if($state->id == $state_id){
													   $selected = "selected";
													}

												?>
												<option value="{!! $state->id !!}" {{ $selected }}>{!! $state->name !!}</option>
											@endforeach
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-5 control-label">City: </label>
									<div class="col-sm-7">

										@if(isset($stationAddress['city_id']))
											{!! Form::select('city_idst[]',
												$cf->getCity(),
												$stationAddress['address']['city_id'],
												['class' => 'form-control', 'required'])
											!!}
										@else
											<select class="form-control station_cities" rel="0" id="station_cities0" name="city_idst[]" necessary disabled></select>
										@endif
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-5 control-label">Area: </label>
									<div class="col-sm-7">

										 @if(isset($stationAddress['area_id']))
											{!! Form::select('area_id',
												$cf->getArea(),
												$stationAddress['area_id'],
												['class' => 'form-control', 'id' => 'areas'])
											!!}
										@else
											<select class="form-control" id="station_areas0" rel="0" name="area_idst[]" disabled></select>
										@endif

									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-5 control-label">Postcode /Zip Code: </label>
									<div class="col-sm-7">
										<input type="text" name="zipcode[]" class="form-control" necessary="" value="">									
									</div>
								</div>									
								<div class="form-group">
									<label class="col-sm-3 control-label">Address</label>
									<div class="col-sm-9">
										<input type="text" name="outlet_line1[]" id="station_line10" class="form-control" value="" >
									</div>	
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label">&nbsp;</label>
									<div class="col-sm-9">
										<input type="text" name="outlet_line2[]" id="station_line20" class="form-control" value="">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label">&nbsp;</label>
									<div class="col-sm-9">
										<input type="text" name="outlet_line3[]" id="station_line30" class="form-control" value="">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label">&nbsp;</label>
									<div class="col-sm-9">
										<input type="text" name="outlet_line4[]" id="station_line40" class="form-control" value="">
									</div>	
								</div>								
							</div>
							<div class="col-sm-7">
								<div id="map-container0" class="custom-container" style="width:575px; height:435px;">
									  <div id="map-canvas0" style="width:540px; height:400px;">
									  </div>

								</div>
							</div>
						</div>
							<input id="geoip_lat0" name="geoip_lats[]" value="0" type="hidden" />
							<input id="geoip_lon0" name="geoip_lons[]" value="0" type="hidden" />				
                        <div class="row" id="business">
							<div class="col-sm-12">
								<div class="form-group">
									<div class="col-sm-2">
										&nbsp;
									</div>
									<div class="col-sm-4">
										&nbsp;
									</div>
									<div class="col-sm-6">
										@if($edit)
											<a href="javascript:void(0);" class="add_dist btn btn-info pull-right">+</a>
										@endif
									</div>
								</div>
                            </div>
                        </div>
					</div>	
					<input id="current_dist" value="0" type="hidden" />						
					@endif
					<hr>
                    <div id="remark">
                        <h2 style="margin-left:-15px">Notes</h2>
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="form-group">
                                    <!--{!! Form::label('','', array('class' => 'col-sm-2 control-label')) !!}-->

                                    <div class="col-sm-10" style="padding:0">
                                        {!! Form::textarea('notes_station',$userModel['station'][0]['note'], array('class' => 'form-control'))!!}
                                    </div>
                                </div>
                                <div class="form-group" style="margin-left:1px;">
                                    <div class="col-sm-13">
                                        <div class="checkbox">
											<?php 
												$disabled = "";
												$checked = "";
												if($type == "cafe"){
													$disabled = "disabled";
													$checked = "checked";													
												}
											?>
											<input type="hidden" value="0" name="all_system_delivery" />
											<input type="hidden" value="0" name="all_own_delivery" />
											@if(is_null($userModel['user']['id']))
												@if($type != "logistic")
												<input name="sign_up_merchant_from_station" type="checkbox" title="The hybrid account created is not reversible, any Cancelation or changes in merchant/station status, please contact OpenSupermall administration through OpenSupport" value="1" {{$checked}} />
												<label>
													I am interested in becoming an OpenSupermall merchant, so that I can have an online O-Shop!<br>Sign me up!!
												</label>
												@endif
											@endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
						<div id="remarksattach" class="col-sm-6">
                            <div class="form-group">
                            <label class="col-sm-3 control-label">Attachment </label>	
						<?php
							$gi = 0;
						?>
                        @if(isset($mer_doc))
						@if(count($mer_doc) > 0)
							@foreach($mer_doc as $mer_Doc)
                                @if($mer_Doc->name != 'registration')
                                    @if($gi == 0)
                                        <div class="col-sm-9 col-xs-12">
                                    @else
                                        <div class="col-sm-offset-3  col-sm-9 col-xs-12">
                                    @endif
									    <div class="inputBtnSection">
												<?php 
													/*$file = asset('/') . 'images/document/' . $mer_Doc->document_id . '/' .  $mer_Doc->path;
													$file_headers = @get_headers($file);
													if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
														$exists = false;
													}
													else {
														$exists = true;
													}*/
                                                    $exists = true;
												?>											
											<input id="uploadFileRem{{$gi}}" name="uploadFileRem[]" value="{{ $mer_Doc->path }}" @if (!$exists) rel="" @else rel="{{asset('/')}}images/document/{{ $mer_Doc->document_id }}/{{ $mer_Doc->path }}" @endif title="Click to view attached document" class="disableInputField fileview" placeholder="Add New Attachment" style="cursor:pointer;  color: blue;"  />							
										<label class="fileUpload">
											<input id="uploadBtnRem{{$gi}}" id-attr="{{$gi}}" name="Remarksupload_attachment[]" type="file" class="upload  " />
											<input type="hidden" name="attfilesIDs[]" value="{{ $mer_Doc->document_id }}"  />
											@if($edit)
											<span class="uploadBtn">Upload </span>
											@endif
										</label>
									</div>
									@if($edit)
										@if($gi == 0)
										<a  href="javascript:void(0);" id="addRem" class="text-success"><i class="fa fa-plus-circle fa-2x"></i></a>
										@else
										<a  href="javascript:void(0);" id="remRem" class="text-danger remRemn"><i class="fa fa-minus-circle fa-2x"></i></a>
										@endif
									@endif
								</div>
							<?php $gi++; ?>
                                            @endif
							@endforeach
							@if($gi == 0)
								<div class="col-sm-9 col-xs-12">
									<div class="inputBtnSection">
										<input id="uploadFileRem" name="uploadFileRem[]" class="disableInputField" placeholder="Add New Attachment" />
										<label class="fileUpload">
											<input id="uploadBtnRem" name="Remarksupload_attachment[]" type="file" class="upload  " />
											@if($edit)
											<span class="uploadBtn">Upload </span>
											@endif
										</label>
									</div>
									@if($edit)
									<a  href="javascript:void(0);" id="addRem" class="text-success"><i class="fa fa-plus-circle fa-2x"></i></a>
									@endif
								</div>									
							@endif
							@else
								<div class="col-sm-9 col-xs-12">
									<div class="inputBtnSection">
										<input id="uploadFileRem"  name="uploadFileRem[]" class="disableInputField" placeholder="Add New Attachment" />
										<label class="fileUpload">
											<input id="uploadBtnRem" name="Remarksupload_attachment[]" type="file" class="upload  " />
											@if($edit)
											<span class="uploadBtn">Upload </span>
											@endif
										</label>
									</div>
									@if($edit)
									<a  href="javascript:void(0);" id="addRem" class="text-success"><i class="fa fa-plus-circle fa-2x"></i></a>
									@endif
								</div>								
							@endif
                        @else
							<div class="col-sm-9 col-xs-12">
								<div class="inputBtnSection">
									<input id="uploadFileRem" class="disableInputField" name="uploadFileRem[]" placeholder="Add New Attachment" />
									<label class="fileUpload">
										<input id="uploadBtnRem" name="Remarksupload_attachment[]" type="file" class="upload  " />
										@if($edit)
										<span class="uploadBtn">Upload </span>
										@endif
									</label>
								</div>
								@if($edit)
								<a  href="javascript:void(0);" id="addRem" class="text-success"><i class="fa fa-plus-circle fa-2x"></i></a>
								@endif
							</div>
                        @endif
                            </div>
                        </div>
						<input type="hidden" value="{{$gi}}" id="remfiles" />
						<input id="mytype" name="mytype" value="{{$type}}" type="hidden" />
                    </div>
                    <div class="clearfix"> </div>
					@if(isset($selluser))
						@if($edit && Auth::check() && !is_null($selluser))
							@if(!$selluser->hasRole('mer') && !$selluser->hasRole('log'))
								@if($type != "logistic")
									<div class="pull-right">
										<a href="javascript:void(0)" title="The hybrid account created is not reversible, any Cancelation or changes in merchant/station status, please contact OpenSupermall administration through OpenSupport" class="create_merchant btn btn-info">I also want to be a Merchant</a>
									</div>	<br><br>
								@endif	
							@else
								<div class="pull-right">
									<p>The hybrid account created is not reversible, any Cancelation or changes in merchant/station status, please contact OpenSupermall administration through OpenSupport</p>
								</div>
							@endif							
						@endif							
					@endif							
					<div class="clearfix"></div>		
					<div class="g-recaptcha pull-right" data-sitekey="6LcXgyMUAAAAAJe2Qb08ADwEyxK1Dbh35aQbl5U6"></div>
					<input type="hidden" class="hiddenRecaptcha required" name="hiddenRecaptcha" id="hiddenRecaptcha">
					<div class="clearfix"></div>
					<div class="pull-right" id="captchaMessage">
						
					</div>	
					<div class="clearfix"></div>					
                    <div class="pull-right">

                        {!! Form::hidden('indication', $indication, array( 'class' => 'form-control'))!!}
                        {!! Form::submit('Submit', array('class' => 'btn btn-green',
							'id' => 'reg_station', 'style'=>'margin-bottom:10px')) !!}

                        {{--  <input type="submit" class="btn btn-success" value="Save">
                          <input type="submit" id='submitStation' class="btn btn-success" value="Submit Registration Form">--}}
                    </div>

                    {{--@endforeach--}}

                    {!! Form::close() !!}
            </div>
        </div><!--End main cotainer-->
    </section>
    <!-- Modal -->
<div id="tcModal" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width: 50%">

    <!-- Modal content-->
    <div class="modal-content">
 
      <div class="modal-body">
       {{--  --}}
      </div>
    </div>

  </div>
</div>
@stop

@section('scripts')
@if(!$edit)
<script>
$(document).ready(function () {
	$("#registe_rForm :input").attr("disabled", true);
	$(".fileview").attr("disabled", false);
	$('.summernote').summernote('disable');
})
</script>
@endif
    {{-- <script src="https://maps.googleapis.com/maps/api/js?v=3"></script> --}}
    <script src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_MAP')}}"></script>
    <script>
$(document).ready(function () {
		window.setInterval(function(){
			if(grecaptcha.getResponse() == ''){
				 $("#reg_station").prop('disabled', true);
			} else {
				 $("#reg_station").prop('disabled', false);
			}
		}, 1000);
		
		$(document).delegate( '.lgrades', "click",function (event) {
			$(".lgrades").prop('checked',false);
			$(this).prop('checked',true);
		});
		$(document).delegate( '#nogst', "click",function (event) {
			var checked = this.checked;
			if(checked){
				$("#gstvat").val("");
				$("#gstvat").attr('disabled',true);
			} else {
				$("#gstvat").attr('disabled',false);
			}
		});		
		
		$(".fileview").on("click",function(){
					var url = $(this).attr("rel");
					if(url == ''){
						toastr.error("Sorry, we could not find the file you requested");
					} else {
						window.open(
						  url,
						  '_blank' // <- This is what makes it open in a new window.
						);						
					}

		});
			 
	$('body').on('change', '.checkparcel', function() {
		var checked = this.checked;
		var rel = $(this).attr("rel");
		if(checked){
			$("#real_parcel" + rel).val(1);
		} else {
			$("#real_parcel" + rel).val(0);
		}
	});
	
		$(".create_merchant").on("click",function(){
			$(this).html("Creating...");
			var userid = $("#useraid").val();
			$.ajax({
				type: "POST",
				url: JS_BASE_URL + "/alsomerchant",
				data: {userid: userid},
				
				success: function (data) {
					toastr.info("Merchant creation was successful. Please, wait for the webpage refresh to edit Merchant information");
					//$(this).html("Created");
					setTimeout(function(){
						location.reload();
						
					}, 4000);   
									  
				},
				error: function (response) {
					toastr.error("An unexpected error occurred! Plase contact OpenSupport");
				}

			});				
		});	
	
	$('body').on('change', '.checkcontainer', function() {
		var checked = this.checked;
		var rel = $(this).attr("rel");
		if(checked){
			$("#real_container" + rel).val(1);
		} else {
			$("#real_container" + rel).val(0);
		}
	});

	$('body').on('change', '.checkpalette', function() {
		var checked = this.checked;
		var rel = $(this).attr("rel");
		if(checked){
			$("#real_palette" + rel).val(1);
		} else {
			$("#real_palette" + rel).val(0);
		}
	});
	$('body').on('change', '.checkperishable', function() {
		var checked = this.checked;
		var rel = $(this).attr("rel");
		if(checked){
			$("#real_perishable" + rel).val(1);
		} else {
			$("#real_perishable" + rel).val(0);
		}
	});
	
	$('body').on('click', '.add_outlet', function() {
		var current_outlet = parseInt($("#current_outlet").val());
		current_outlet++;
		$("#current_outlet").val(current_outlet)
		
		var html_add = '<div id="oulet_'+current_outlet+'"><div class="row" id="location_'+current_outlet+'"><hr>';
			html_add += '<div class="col-sm-8">';
			html_add += '<div class="col-sm-10 no-padding">';
			html_add += '<h2 style="margin-top:0px;"class="col-sm-3 no-padding">Outlet: </h2>';
			html_add += '<div class="col-sm-7">';
			html_add += '<input aria-required="true" placeholder="Please fill in Outlet Name" class="form-control" required="required" name="outlet_name[]" value="" type="text">';
			html_add += '</div>';
			html_add += '<div class="col-sm-2">&nbsp;</div>';
			html_add += '</div>	';
			html_add += '</div>	';
			html_add += '<div class="col-sm-4"><a href="javascript:void(0);" class="delete_outlet btn btn-danger pull-right" rel="'+current_outlet+'">x</a></div>';
			html_add += '<div class="col-sm-12">';
			html_add += '<h3 style="margin-top:0px;">Location</h3>';
			html_add += '</div>';		
			html_add += '<div class="col-sm-5">';
			html_add += '	<label>&nbsp;</label>';
			html_add += '	<div class="form-group">';
			html_add += '		<label class="col-sm-5 control-label">Country: </label>';
			html_add += '		<div class="col-sm-7">';
			html_add += '		<input aria-required="true" disabled class="form-control" id="station_country_id" required="required" name="country_id" value="Malaysia" type="text">';
			html_add += '		</div>';
			html_add += '	</div>';
			html_add += '	<div class="form-group">';
			html_add += '		<label class="col-sm-5 control-label">State: </label>';
			html_add += '		<div class="col-sm-7">';
			html_add += '			<select class="form-control station_states" rel="'+current_outlet+'" id="station_states'+current_outlet+'" name="state_idst[]">';
			html_add += '				<option value="">Choose Option</option>';
			html_add += '			</select>';
			html_add += '		</div>';
			html_add += '	</div>';
			html_add += '	<div class="form-group">';
			html_add += '		<label class="col-sm-5 control-label">City: </label>';
			html_add += '		<div class="col-sm-7">';
			html_add += '		<select class="form-control station_cities" rel="'+current_outlet+'" id="station_cities'+current_outlet+'" name="city_idst[]" disabled></select>';
			html_add += '		</div>';
			html_add += '	</div>';
			html_add += '	<div class="form-group">';
			html_add += '		<label class="col-sm-5 control-label">Area: </label>';
			html_add += '		<div class="col-sm-7">';
			html_add += '		<select class="form-control" id="station_areas'+current_outlet+'" rel="'+current_outlet+'" name="area_idst[]" disabled></select>';
			html_add += '		</div>';
			html_add += '	</div>';
			html_add += '					<div class="form-group">';
			html_add += '						<label class="col-sm-5 control-label">Postcode /Zip Code: </label>';
			html_add += '						<div class="col-sm-7">';
			html_add += '							<input type="text" name="zipcode[]" class="form-control" required="" value="">		';							
			html_add += '						</div>';
			html_add += '					</div>		';		
			html_add += '					<div class="form-group">';
			html_add += '						<label class="col-sm-3 control-label">Address</label>';
			html_add += '						<div class="col-sm-9">';
			html_add += '							<input type="text" name="outlet_line1[]" id="station_line1'+current_outlet+'" class="form-control" value="" >';
			html_add += '						</div>	';
			html_add += '					</div>';
			html_add += '					<div class="form-group">';
			html_add += '						<label class="col-sm-3 control-label">&nbsp;</label>';
			html_add += '						<div class="col-sm-9">';
			html_add += '							<input type="text" name="outlet_line2[]" id="station_line2'+current_outlet+'" class="form-control" value="">';
			html_add += '						</div>';
			html_add += '					</div>';
			html_add += '					<div class="form-group">';
			html_add += '						<label class="col-sm-3 control-label">&nbsp;</label>';
			html_add += '						<div class="col-sm-9">';
			html_add += '							<input type="text" name="outlet_line3[]" id="station_line3'+current_outlet+'" class="form-control" value="">';
			html_add += '						</div>';
			html_add += '					</div>';
			html_add += '					<div class="form-group">';
			html_add += '						<label class="col-sm-3 control-label">&nbsp;</label>';
			html_add += '						<div class="col-sm-9">';
			html_add += '							<input type="text" name="outlet_line4[]" id="station_line4'+current_outlet+'" class="form-control" value="">';
			html_add += '						</div>	';
			html_add += '					</div>		';	
			html_add += '</div>';
			html_add += '<div class="col-sm-7">';
			html_add += '	<div id="map-container'+current_outlet+'" class="custom-container" style="width:575px; height:435px;">';
			html_add += '		  <div id="map-canvas'+current_outlet+'" style="width: 540px; height: 400px; position: relative; background-color: rgb(229, 227, 223); overflow: hidden;"></div>';
			html_add += '	</div>';
			html_add += '</div>';
			html_add += '</div>';			
			html_add += '<div class="row" id="property">';
			html_add += '			<div class="col-sm-12">';
			html_add += '<input id="geoip_lat'+current_outlet+'" name="geoip_lats[]" value="0" type="hidden">';
			html_add += '<input id="geoip_lon'+current_outlet+'" name="geoip_lons[]" value="0" type="hidden">';			
			html_add += '<input name="biz_owner_contact[]" value="0" type="hidden" />';					
			html_add += '<input name="biz_owner_first_name[]" value="0" type="hidden" />';				
			html_add += '<input name="biz_owner_last_name[]" value="0" type="hidden" />';			
			html_add += '<div class="form-group">';			
			html_add += '	<label for="shop_size" class="col-sm-2 control-label">Shop Size</label>';
			html_add += '	<div class="col-sm-4">';
			html_add += '		<input aria-required="true" class="form-control" required="required" name="shop_size[]" value="" type="text">';
			html_add += '	</div>';
			html_add += '</div>';
			html_add += '<div class="form-group">';
			html_add += '<label for="shop_size" class="col-sm-2 control-label">Business Name</label>';
			html_add += '	<div class="col-sm-4">';
			html_add += '		<input aria-required="true" class="form-control" required="required" name="biz_name[]" value="" type="text">';
			html_add += '	</div>';
			html_add += '</div>';				
			html_add += '<div class="form-group">';
			html_add += '	<label for="owner" class="col-sm-2 control-label">Owner</label>';
			html_add += '	<div class="col-sm-4">';
			html_add += '		<input aria-required="true" data-bv-trigger="keyup" required="required" placeholder="First Name" class="form-control" name="firstname_property" value="" type="text">';
			html_add += '	</div>';
			html_add += '	<div class="col-sm-4">';
			html_add += '		<input aria-required="true" data-bv-trigger="keyup" required="required" placeholder="Last Name" class="form-control" name="lastname_property[]" value="" type="text">';
			html_add += '	</div>';
			html_add += '</div>';
			html_add += '<div class="form-group">';
			html_add += '	<label for="contact_property" class="col-sm-2 control-label">Contact</label>';
			html_add += '	<div class="col-sm-4">';
			html_add += '		<input aria-required="true" class="form-control" required="required" name="contact_property[]" value="" type="text">';
			html_add += '	</div>';
			html_add += '</div>';
			html_add += '</div>';
			html_add += '</div>';
			html_add += '	<div class="row" id="business">';
			html_add += '	<div class="col-sm-12">';
			html_add += '		<div class="form-group">';
			html_add += '			<label class="col-sm-2 control-label">Outlet </label>';
			html_add += '			<div class="col-sm-4">';
			html_add += '			<select class="form-control" name="outlet_business[]" id="outlet_business'+current_outlet+'"></select>';
			html_add += '			</div>';
			html_add += '		</div>';
			html_add += '		<div class="form-group">';
			html_add += '			<label for="delivery_business" class="col-sm-2 control-label">Delivery</label>';
			html_add += '			<div class="col-sm-4">';
			html_add += '			<select class="form-control" name="delivery_business[]" id="delivery_business'+current_outlet+'"></select>';			
			html_add += '			</div>';
			html_add += '			<div class="col-sm-6">';
			html_add += '				<a href="javascript:void(0);" class="add_outlet btn btn-info pull-right">+</a>';
			html_add += '			</div>';
			html_add += '		</div>';
			html_add += '	</div>';			
			html_add += '	</div>';			
			html_add += '	</div>';			
			html_add += '	<input name="outlet_id" value="0" type="hidden" />';			
			$("#outlets").append(html_add);
			var cloneStates = $("#station_states0 > option").clone();
			var cloneBussiness = $("#outlet_business0 > option").clone();
			var cloneDelivery = $("#delivery_business0 > option").clone();
			$('#station_states'+current_outlet).html(cloneStates);
			$('#outlet_business'+current_outlet).html(cloneBussiness);
			$('#delivery_business'+current_outlet).html(cloneDelivery);
			$('#station_states'+current_outlet).select2();
			$('#station_cities'+current_outlet).select2();
			$('#station_areas'+current_outlet).select2();
			$('#outlet_business'+current_outlet).select2();
			$('#delivery_business'+current_outlet).select2();
		
				$('#station_states' +current_outlet).on('change', function () {
					var val = $(this).val();
					if (val != "") {
						$.ajax({
							type: "post",
							url: JS_BASE_URL + '/city',
							data: {id: val},
							cache: false,
							success: function (responseData, textStatus, jqXHR) {
								if (responseData != "") {
									$('#station_cities' +current_outlet).html(responseData);
									document.getElementById('station_cities' +current_outlet).disabled = false;
								}
								else {
									$('#station_cities' +current_outlet).empty();
									$('#select2-station_cities'+current_outlet+'-container').empty();
									document.getElementById('station_cities'+current_outlet).disabled = false;
								}
							},
							error: function (responseData, textStatus, errorThrown) {
								alert(errorThrown);
							}
						});
					}
					else {
						$('#select2-station_cities'+current_outlet+'-container').empty();
						$('#station_cities'+current_outlet).html('<option value="" selected>Choose Option</option>');
					}
					
					changeMarkerLocation(current_outlet);
					changeInfoWindowContent(current_outlet);
				});

				$('#station_cities' +current_outlet).on('change', function () {
					var val = $(this).val();
					if (val != "") {
						$(this).siblings('span.select2').removeClass('errorBorder');
						$.ajax({
							type: "post",
							url: JS_BASE_URL + '/area',
							data: {id: val},
							cache: false,
							success: function (responseData, textStatus, jqXHR) {
								if (responseData != "") {
									$('#station_areas' +current_outlet).html(responseData);
									document.getElementById('station_areas' +current_outlet).disabled = false;
								}
								else {
									$('#station_areas0').empty();
									$('#select2-station_areas'+current_outlet+'-container').empty();
									document.getElementById('station_areas'+current_outlet).disabled = false;
								}
							},
							error: function (responseData, textStatus, errorThrown) {
								alert(errorThrown);
							}
						});
					}
					else {
						$('#select2-station_areas'+current_outlet+'-container').empty();
						$('#station_areas'+current_outlet).html('<option value="" selected>Choose Option</option>');
					}
					changeMarkerLocation(current_outlet);
					changeInfoWindowContent(current_outlet);
				});	

				$("#station_line1" + current_outlet).blur(function () {
					console.log("Line1")
					changeMarkerLocation(current_outlet);
					changeInfoWindowContent(current_outlet);
				});
				
				$("#station_line2" + current_outlet).blur(function () {
					changeMarkerLocation(current_outlet);
					changeInfoWindowContent(current_outlet);
				});
				
				$("#station_line3" + current_outlet).blur(function () {
					changeMarkerLocation(current_outlet);
					changeInfoWindowContent(current_outlet);
				});
				
				$("#station_line4" + current_outlet).blur(function () {
					changeMarkerLocation(current_outlet);
					changeInfoWindowContent(current_outlet);
				});				
				
				var city_value = $("#station_cities"+current_outlet+" option:selected").text();
				var state_value = $("#station_states"+current_outlet+" option:selected").text();
				//var station_country_id = $("#station_country_id option:selected").text();
				

				var lat_value = $("#geoip_lat" +current_outlet).val();
				var lot_value = $("#geoip_lon" +current_outlet).val();

				var mapOptions = {
					zoom: 14,
					mapTypeId: google.maps.MapTypeId.ROADMAP,
					center: new google.maps.LatLng(lat_value, lot_value)
				};

				var contentString = city_value + '<br>';+ state_value;

				infowindow[current_outlet] = new google.maps.InfoWindow({
					content: contentString
				});

				map[current_outlet] = new google.maps.Map(document.getElementById('map-canvas' +current_outlet), mapOptions);

				marker[current_outlet] = new google.maps.Marker({
					position: new google.maps.LatLng(lat_value, lot_value),
					map: map[current_outlet]
				});

				infowindow[current_outlet].open(map[current_outlet], marker[current_outlet]);				
		
	});
	
	$('body').on('click', '.add_dist', function() {
		var current_outlet = parseInt($("#current_dist").val());
		current_outlet++;
		$("#current_dist").val(current_outlet)
		
		var html_add = '<div id="dist_'+current_outlet+'"><div class="row" id="location_'+current_outlet+'"><hr>';
			html_add += '<div class="col-sm-10">';
			html_add += '<div class="col-sm-10 no-padding">';
			html_add += '<h2 style="margin-top:0px;"class="col-sm-5 no-padding">Distribution Center: </h2>';
			html_add += '<div class="col-sm-7">';
			html_add += '<input aria-required="true" placeholder="Please fill in Outlet Name" class="form-control" required="required" name="dc_name[]" value="" type="text">';
			html_add += '</div>';
			html_add += '<div class="col-sm-2">&nbsp;</div>';
			html_add += '</div>	';
			html_add += '</div>	';
			html_add += '<div class="col-sm-2"><a href="javascript:void(0);" class="delete_dist btn btn-danger pull-right" rel="'+current_outlet+'">x</a></div>';
			html_add += '<div class="col-sm-12">';
			html_add += '<h3 style="margin-top:0px;">Location</h3>';
			html_add += '</div>';		
			html_add += '<div class="col-sm-5">';
			html_add += '	<label>&nbsp;</label>';
			html_add += '	<div class="form-group">';
			html_add += '		<label class="col-sm-5 control-label">Country: </label>';
			html_add += '		<div class="col-sm-7">';
			html_add += '		<input aria-required="true" disabled class="form-control" id="station_country_id" required="required" name="country_id" value="Malaysia" type="text">';
			html_add += '		</div>';
			html_add += '	</div>';
			html_add += '	<div class="form-group">';
			html_add += '		<label class="col-sm-5 control-label">State: </label>';
			html_add += '		<div class="col-sm-7">';
			html_add += '			<select class="form-control station_states" rel="'+current_outlet+'" id="station_states'+current_outlet+'" name="state_idst[]">';
			html_add += '				<option value="">Choose Option</option>';
			html_add += '			</select>';
			html_add += '		</div>';
			html_add += '	</div>';
			html_add += '	<div class="form-group">';
			html_add += '		<label class="col-sm-5 control-label">City: </label>';
			html_add += '		<div class="col-sm-7">';
			html_add += '		<select class="form-control station_cities" rel="'+current_outlet+'" id="station_cities'+current_outlet+'" name="city_idst[]" disabled></select>';
			html_add += '		</div>';
			html_add += '	</div>';
			html_add += '	<div class="form-group">';
			html_add += '		<label class="col-sm-5 control-label">Area: </label>';
			html_add += '		<div class="col-sm-7">';
			html_add += '		<select class="form-control" id="station_areas'+current_outlet+'" rel="'+current_outlet+'" name="area_idst[]" disabled></select>';
			html_add += '		</div>';
			html_add += '	</div>';
			html_add += '					<div class="form-group">';
			html_add += '						<label class="col-sm-5 control-label">Postcode /Zip Code: </label>';
			html_add += '						<div class="col-sm-7">';
			html_add += '							<input type="text" name="zipcode[]" class="form-control" required="" value="">		';							
			html_add += '						</div>';
			html_add += '					</div>		';		
			html_add += '					<div class="form-group">';
			html_add += '						<label class="col-sm-3 control-label">Address</label>';
			html_add += '						<div class="col-sm-9">';
			html_add += '							<input type="text" name="outlet_line1[]" id="station_line1'+current_outlet+'" class="form-control" value="" >';
			html_add += '						</div>	';
			html_add += '					</div>';
			html_add += '					<div class="form-group">';
			html_add += '						<label class="col-sm-3 control-label">&nbsp;</label>';
			html_add += '						<div class="col-sm-9">';
			html_add += '							<input type="text" name="outlet_line2[]" id="station_line2'+current_outlet+'" class="form-control" value="">';
			html_add += '						</div>';
			html_add += '					</div>';
			html_add += '					<div class="form-group">';
			html_add += '						<label class="col-sm-3 control-label">&nbsp;</label>';
			html_add += '						<div class="col-sm-9">';
			html_add += '							<input type="text" name="outlet_line3[]" id="station_line3'+current_outlet+'" class="form-control" value="">';
			html_add += '						</div>';
			html_add += '					</div>';
			html_add += '					<div class="form-group">';
			html_add += '						<label class="col-sm-3 control-label">&nbsp;</label>';
			html_add += '						<div class="col-sm-9">';
			html_add += '							<input type="text" name="outlet_line4[]" id="station_line4'+current_outlet+'" class="form-control" value="">';
			html_add += '						</div>	';
			html_add += '					</div>		';	
			html_add += '</div>';
			html_add += '<div class="col-sm-7">';
			html_add += '	<div id="map-container'+current_outlet+'" class="custom-container" style="width:575px; height:435px;">';
			html_add += '		  <div id="map-canvas'+current_outlet+'" style="width: 540px; height: 400px; position: relative; background-color: rgb(229, 227, 223); overflow: hidden;"></div>';
			html_add += '	</div>';
			html_add += '</div>';
			html_add += '</div>';			
			html_add += '<input id="geoip_lat'+current_outlet+'" name="geoip_lats[]" value="0" type="hidden">';
			html_add += '<input id="geoip_lon'+current_outlet+'" name="geoip_lons[]" value="0" type="hidden">';					
			html_add += '<div class="row" id="business">';
			html_add += '	<div class="col-sm-12">';
			html_add += '		<div class="form-group">';
			html_add += '		<div class="col-sm-2">';
			html_add += '				&nbsp;';
			html_add += '		</div>';
			html_add += '		<div class="col-sm-4">';
			html_add += '				&nbsp;';
			html_add += '		</div>';			
			html_add += '		<div class="col-sm-6">';
			html_add += '				<a href="javascript:void(0);" class="add_dist btn btn-info pull-right">+</a>';
			html_add += '		</div>';
			html_add += '	</div>';
			html_add += '</div>';
			html_add += '	</div>';						
			$("#outlets").append(html_add);
			var cloneStates = $("#station_states0 > option").clone();
			var cloneBussiness = $("#outlet_business0 > option").clone();
			var cloneDelivery = $("#delivery_business0 > option").clone();
			$('#station_states'+current_outlet).html(cloneStates);
			$('#outlet_business'+current_outlet).html(cloneBussiness);
			$('#delivery_business'+current_outlet).html(cloneDelivery);
			$('#station_states'+current_outlet).select2();
			$('#station_cities'+current_outlet).select2();
			$('#station_areas'+current_outlet).select2();
			$('#outlet_business'+current_outlet).select2();
			$('#delivery_business'+current_outlet).select2();
		
				$('#station_states' +current_outlet).on('change', function () {
					var val = $(this).val();
					if (val != "") {
						$.ajax({
							type: "post",
							url: JS_BASE_URL + '/city',
							data: {id: val},
							cache: false,
							success: function (responseData, textStatus, jqXHR) {
								if (responseData != "") {
									$('#station_cities' +current_outlet).html(responseData);
									document.getElementById('station_cities' +current_outlet).disabled = false;
								}
								else {
									$('#station_cities' +current_outlet).empty();
									$('#select2-station_cities'+current_outlet+'-container').empty();
									document.getElementById('station_cities'+current_outlet).disabled = false;
								}
							},
							error: function (responseData, textStatus, errorThrown) {
								alert(errorThrown);
							}
						});
					}
					else {
						$('#select2-station_cities'+current_outlet+'-container').empty();
						$('#station_cities'+current_outlet).html('<option value="" selected>Choose Option</option>');
					}
					
					changeMarkerLocation(current_outlet);
					changeInfoWindowContent(current_outlet);
				});

				$('#station_cities' +current_outlet).on('change', function () {
					var val = $(this).val();
					if (val != "") {
						$(this).siblings('span.select2').removeClass('errorBorder');
						$.ajax({
							type: "post",
							url: JS_BASE_URL + '/area',
							data: {id: val},
							cache: false,
							success: function (responseData, textStatus, jqXHR) {
								if (responseData != "") {
									$('#station_areas' +current_outlet).html(responseData);
									document.getElementById('station_areas' +current_outlet).disabled = false;
								}
								else {
									$('#station_areas0').empty();
									$('#select2-station_areas'+current_outlet+'-container').empty();
									document.getElementById('station_areas'+current_outlet).disabled = false;
								}
							},
							error: function (responseData, textStatus, errorThrown) {
								alert(errorThrown);
							}
						});
					}
					else {
						$('#select2-station_areas'+current_outlet+'-container').empty();
						$('#station_areas'+current_outlet).html('<option value="" selected>Choose Option</option>');
					}
					changeMarkerLocation(current_outlet);
					changeInfoWindowContent(current_outlet);
				});		
				
				$("#station_line1" + current_outlet).blur(function () {
					console.log("Line1")
					changeMarkerLocation(current_outlet);
					changeInfoWindowContent(current_outlet);
				});
				
				$("#station_line2" + current_outlet).blur(function () {
					changeMarkerLocation(current_outlet);
					changeInfoWindowContent(current_outlet);
				});
				
				$("#station_line3" + current_outlet).blur(function () {
					changeMarkerLocation(current_outlet);
					changeInfoWindowContent(current_outlet);
				});
				
				$("#station_line4" + current_outlet).blur(function () {
					changeMarkerLocation(current_outlet);
					changeInfoWindowContent(current_outlet);
				});			
		
				var city_value = $("#station_cities"+current_outlet+" option:selected").text();
				var state_value = $("#station_states"+current_outlet+" option:selected").text();
				//var station_country_id = $("#station_country_id option:selected").text();
				

				var lat_value = $("#geoip_lat" +current_outlet).val();
				var lot_value = $("#geoip_lon" +current_outlet).val();

				var mapOptions = {
					zoom: 14,
					mapTypeId: google.maps.MapTypeId.ROADMAP,
					center: new google.maps.LatLng(lat_value, lot_value)
				};

				var contentString = city_value + '<br>';+ state_value;

				infowindow[current_outlet] = new google.maps.InfoWindow({
					content: contentString
				});

				map[current_outlet] = new google.maps.Map(document.getElementById('map-canvas' +current_outlet), mapOptions);

				marker[current_outlet] = new google.maps.Marker({
					position: new google.maps.LatLng(lat_value, lot_value),
					map: map[current_outlet]
				});

				infowindow[current_outlet].open(map[current_outlet], marker[current_outlet]);				
		
	});	
	
	$('body').on('click', '.logtype', function() {
		var logtype = $(this).prop('checked');
		if(logtype){
			$('.logtype').prop('checked',false);
			$(this).prop('checked',true);
		} else {
			$('.logtype').prop('checked',true);
			$(this).prop('checked',false);
		}
		//alert(outlet);
	});
	
	$('body').on('click', '.delete_outlet', function() {
		var outlet = $(this).attr('rel');
		$("#oulet_" + outlet).remove();
		//alert(outlet);
	});
	
	$('body').on('click', '.delete_dist', function() {
		var outlet = $(this).attr('rel');
		$("#dist_" + outlet).remove();
		//alert(outlet);
	});	
	
    $('#station_states0').on('change', function () {
        var val = $(this).val();
        if (val != "") {
            var text = $('#station_states0 option:selected').text();
            $.ajax({
                type: "post",
                url: JS_BASE_URL + '/city',
                data: {id: val},
                cache: false,
                success: function (responseData, textStatus, jqXHR) {
                    if (responseData != "") {
                        $('#station_cities0').html(responseData);
						document.getElementById('station_cities0').disabled = false;
                    }
                    else {
                        $('#station_cities0').empty();
                        $('#select2-station_cities0-container').empty();
						document.getElementById('station_cities0').disabled = false;
                    }
                },
                error: function (responseData, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
        }
        else {
            $('#select2-station_cities0-container').empty();
            $('#station_cities0').html('<option value="" selected>Choose Option</option>');
        }
    });

    $('#station_cities0').on('change', function () {
        var val = $(this).val();
        if (val != "") {
            var text = $('#station_cities0 option:selected').text();
            $(this).siblings('span.select2').removeClass('errorBorder');
            $.ajax({
                type: "post",
                url: JS_BASE_URL + '/area',
                data: {id: val},
                cache: false,
                success: function (responseData, textStatus, jqXHR) {
                    if (responseData != "") {
                        $('#station_areas0').html(responseData);
						document.getElementById('station_areas0').disabled = false;
                    }
                    else {
                        $('#station_areas0').empty();
                        $('#select2-station_areas0-container').empty();
						document.getElementById('station_areas0').disabled = false;
                    }
                },
                error: function (responseData, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
        }
        else {
            $('#select2-station_areas0-container').empty();
            $('#station_areas0').html('<option value="" selected>Choose Option</option>');
        }
    });	

	$("#station_line10").blur(function () {
		console.log("Line1")
		changeMarkerLocation(0);
		changeInfoWindowContent(0);
	});
	
	$("#station_line20").blur(function () {
		changeMarkerLocation(0);
		changeInfoWindowContent(0);
	});
	
	$("#station_line30").blur(function () {
		changeMarkerLocation(0);
		changeInfoWindowContent(0);
	});
	
	$("#station_line40").blur(function () {
		changeMarkerLocation(0);
		changeInfoWindowContent(0);
	});	
	
	var map = new Array();
	var infowindow  = new Array();
	var marker  = new Array();

	var map_container = $("#map-container0");
	var map_canvas = $("#map-canvas0");

	$("#station-open-channel").DataTable();

	@if(!is_null($outlets) && count($outlets) > 0)
		<?php 
			$outleti = 0;
		?>
			
		@foreach($outlets as $outlet)
			
				$('#station_states{{$outleti}}').on('change', function () {
					var val = $(this).val();
					if (val != "") {
						$.ajax({
							type: "post",
							url: JS_BASE_URL + '/city',
							data: {id: val},
							cache: false,
							success: function (responseData, textStatus, jqXHR) {
								if (responseData != "") {
									$('#station_cities{{$outleti}}').html(responseData);
									document.getElementById('station_cities{{$outleti}}').disabled = false;
								}
								else {
									$('#station_cities{{$outleti}}').empty();
									$('#select2-station_cities{{$outleti}}-container').empty();
									document.getElementById('station_cities{{$outleti}}').disabled = false;
								}
							},
							error: function (responseData, textStatus, errorThrown) {
								alert(errorThrown);
							}
						});
					}
					else {
						$('#select2-station_cities{{$outleti}}-container').empty();
						$('#station_cities{{$outleti}}').html('<option value="" selected>Choose Option</option>');
					}
					
					changeMarkerLocation({{$outleti}});
					changeInfoWindowContent({{$outleti}});
				});

				$('#station_cities{{$outleti}}').on('change', function () {
					var val = $(this).val();
					if (val != "") {
						$(this).siblings('span.select2').removeClass('errorBorder');
						$.ajax({
							type: "post",
							url: JS_BASE_URL + '/area',
							data: {id: val},
							cache: false,
							success: function (responseData, textStatus, jqXHR) {
								if (responseData != "") {
									$('#station_areas{{$outleti}}').html(responseData);
									document.getElementById('station_areas{{$outleti}}').disabled = false;
								}
								else {
									$('#station_areas0').empty();
									$('#select2-station_areas{{$outleti}}-container').empty();
									document.getElementById('station_areas{{$outleti}}').disabled = false;
								}
							},
							error: function (responseData, textStatus, errorThrown) {
								alert(errorThrown);
							}
						});
					}
					else {
						$('#select2-station_areas{{$outleti}}-container').empty();
						$('#station_areas{{$outleti}}').html('<option value="" selected>Choose Option</option>');
					}
					changeMarkerLocation({{$outleti}});
					changeInfoWindowContent({{$outleti}});
				});		
				
				$("#station_line1{{$outleti}}").blur(function () {
					console.log("Line1")
					changeMarkerLocation({{$outleti}});
					changeInfoWindowContent({{$outleti}});
				});
				
				$("#station_line2{{$outleti}}").blur(function () {
					changeMarkerLocation({{$outleti}});
					changeInfoWindowContent({{$outleti}});
				});
				
				$("#station_line3{{$outleti}}").blur(function () {
					changeMarkerLocation({{$outleti}});
					changeInfoWindowContent({{$outleti}});
				});
				
				$("#station_line4{{$outleti}}").blur(function () {
					changeMarkerLocation({{$outleti}});
					changeInfoWindowContent({{$outleti}});
				});	
				
				var city_value = $("#station_cities{{$outleti}} option:selected").text();
				var state_value = $("#station_states{{$outleti}} option:selected").text();
				//var station_country_id = $("#station_country_id option:selected").text();
				

				var lat_value = $("#geoip_lat{{$outleti}}").val();
				var lot_value = $("#geoip_lon{{$outleti}}").val();

				var mapOptions = {
					zoom: 14,
					mapTypeId: google.maps.MapTypeId.ROADMAP,
					center: new google.maps.LatLng(lat_value, lot_value)
				};

				var contentString = city_value + '<br>';+ state_value;

				infowindow[{{$outleti}}] = new google.maps.InfoWindow({
					content: contentString
				});

				map[{{$outleti}}] = new google.maps.Map(document.getElementById('map-canvas' +{{$outleti}}), mapOptions);

				marker[{{$outleti}}] = new google.maps.Marker({
					position: new google.maps.LatLng(lat_value, lot_value),
					map: map[{{$outleti}}]
				});

				infowindow[{{$outleti}}].open(map[{{$outleti}}], marker[{{$outleti}}]);	
			console.log("CHAO {{$outleti}}")
			function initializen{{$outleti}}() {

				//var title_value = $("#title").attr('placeholder');
				var street_value = $("#street").attr('placeholder');
				var city_value = $("#station_cities{{$outleti}} option:selected").text();
				var state_value = $("#station_states{{$outleti}} option:selected").text();
				//var station_country_id = $("#station_country_id option:selected").text();
				

				var lat_value = $("#geoip_lat{{$outleti}}").val();
				var lot_value = $("#geoip_lon{{$outleti}}").val();

				var mapOptions = {
					zoom: 14,
					mapTypeId: google.maps.MapTypeId.ROADMAP,
					center: new google.maps.LatLng(lat_value, lot_value)
				};

				var contentString = city_value + '<br>';+ state_value;

				infowindow[{{$outleti}}] = new google.maps.InfoWindow({
					content: contentString
				});

				map[{{$outleti}}] = new google.maps.Map(document.getElementById('map-canvas{{$outleti}}'), mapOptions);

				marker[{{$outleti}}] = new google.maps.Marker({
					position: new google.maps.LatLng(lat_value, lot_value),
					map: map[{{$outleti}}]
				});

				infowindow[{{$outleti}}].open(map[{{$outleti}}], marker[{{$outleti}}]);
			}

			google.maps.event.addDomListener(window, 'load', initializen{{$outleti}});		
			changeMarkerLocation({{$outleti}});
			<?php $outleti++;?>
		@endforeach
	@else
		function initializen() {

			//var title_value = $("#title").attr('placeholder');
			var street_value = $("#street").attr('placeholder');
			var city_value = $("#station_cities0 option:selected").text();
			var state_value = $("#station_states0 option:selected").text();
			//var station_country_id = $("#station_country_id option:selected").text();
			

			var lat_value = $("#geoip_lat0").val();
			var lot_value = $("#geoip_lon0").val();

			var mapOptions = {
				zoom: 14,
				mapTypeId: google.maps.MapTypeId.ROADMAP,
				center: new google.maps.LatLng(lat_value, lot_value)
			};

			var contentString = city_value + '<br>';+ state_value;

			infowindow[0] = new google.maps.InfoWindow({
				content: contentString
			});

			map[0] = new google.maps.Map(document.getElementById('map-canvas0'), mapOptions);

			marker[0] = new google.maps.Marker({
				position: new google.maps.LatLng(lat_value, lot_value),
				map: map[0]
			});

			infowindow[0].open(map[0], marker[0]);
		}
		google.maps.event.addDomListener(window, 'load', initializen);
	@endif	
	


	function changeMarkerLocation(current) {

		var city = $("#station_cities"+current+" option:selected").text();
		var state = $("#station_states"+current+" option:selected").text();
		var county = $("#station_country_id option:selected").text();
		var line1 = $("#station_line1"+current).val();
		var line2 = $("#station_line2"+current).val();
		var line3 = $("#station_line3"+current).val();
		var line4 = $("#station_line4"+current).val();
		var address = "";
		if(line1 != ""){
			address += line1 + " ";
		}
		if(line2 != ""){
			address += line2 + " ";
		}
		if(line3 != ""){
			address += line3 + " ";
		}
		if(line4 != ""){
			address += line4 + " ";
		}
		if(city != "" && city != "Choose Option"){
			address += city + " ";
		}
		if(state != "" && state != "Choose Option"){
			address += state + " ";
		}
		
		var geocoder = new google.maps.Geocoder();
		geocoder.geocode({'address': address}, function (data, status) {
			if (status == "OK") {
				var suggestion = data[0];
				var location = suggestion.geometry.location;
				console.debug(location);
				$("#geoip_lat"+current).val(location.lat());
				$("#geoip_lon"+current).val(location.lng());			
				var latLng = new google.maps.LatLng(location.lat(), location.lng());

				marker[current].setPosition(latLng);
				map[current].setCenter(latLng);
			}
		});
	}

	function changeInfoWindowContent(current) {
		
		var city = $("#station_cities"+current+" option:selected").text();
		var state = $("#station_states"+current+" option:selected").text();
		var county = $("#station_country_id option:selected").text();
		var line1 = $("#station_line1"+current).val();
		var line2 = $("#station_line2"+current).val();
		var line3 = $("#station_line3"+current).val();
		var line4 = $("#station_line4"+current).val();
		var address = "";
		if(line1 != ""){
			address += line1 + " ";
		}
		if(line2 != ""){
			address += line2 + " ";
		}
		if(line3 != ""){
			address += line3 + " ";
		}
		if(line4 != ""){
			address += line4 + " ";
		}
		if(city != "" && city != "Choose Option"){
			address += city + " ";
		}
		if(state != "" && state != "Choose Option"){
			address += state + " ";
		}

		var contentString = address + '<br><br>';

		infowindow[current].setContent(contentString);
	}

	function getFinalWidgetCode(map) {
		
		
		var street = $("#street").val().replace(/'/g, "\\'");;
		var city = $("#station_cities0 option:selected").text().replace(/'/g, "\\'");
		var state = $("#station_states0 option:selected").text().replace(/'/g, "\\'");
		var county = $("#station_country_id option:selected").text().replace(/'/g, "\\'");

		var center = map.getCenter();
		var lat = center.lat();
		var lon = center.lng();

		var mapType = map.getMapTypeId();
		var mapTypeStr = "";

		switch (mapType) {
			case "roadmap":
				mapTypeStr = "google.maps.MapTypeId.ROADMAP";
				break;
			case "satellite":
				mapTypeStr = "google.maps.MapTypeId.SATELLITE";
				break;
			case "hybrid":
				mapTypeStr = "google.maps.MapTypeId.HYBRID";
				break;
			case "terrain":
				mapTypeStr = "google.maps.MapTypeId.TERRAIN";
				break;
		}

		$.ajaxSetup({
			async: false
		});

		var hashId = '';
		var finalWidgetCode = '';

		/*var lbCode = "<a href='http://maps-generator.com/'>Maps Generator</a>\n";
		$.get('/google-maps-authorization/code.js').success(function (data) {
			if(data != null && data != '' && data != 'Something Went Wrong!') {
				lbCode = data;
				regExpMatches = data.match(/id=(.*)'/i);
				hashId = regExpMatches[1];
			}
		});

		var finalWidgetCode = "<script src='https://maps.googleapis.com/maps/api/js?v=3.exp'><\/script>" +
			"<div style='overflow:hidden;height:" + height + "px;width:" + width + "px;'><div id='gmap_canvas' style='height:" + height + "px;width:" + width + "px;'></div>" +
			"<style>#gmap_canvas img{max-width:none!important;background:none!important}</style></div>" +
			lbCode +
			"<script type='text/javascript'>function init_map(){" +
			"var myOptions = {" +
			"zoom:" + zoom + ",center:new google.maps.LatLng(" + lat + "," + lon + ")," +
			"mapTypeId: " + mapTypeStr + "};" +
			"map = new google.maps.Map(document.getElementById('gmap_canvas'), myOptions);" +
			"marker = new google.maps.Marker({map: map,position: new google.maps.LatLng(" + lat + "," + lon + ")});" +
			"infowindow = new google.maps.InfoWindow({" +
			"content:'" + street + "<br>" + city + "<br>';" +
			"});" +
			"google.maps.event.addListener(marker, 'click', function(){" +
			"infowindow.open(map,marker);" +
			"});" +
			"infowindow.open(map,marker);" +
			"}" +
			"google.maps.event.addDomListener(window, 'load', init_map);" +
			"<\/script>";

		// send to server post request with finalWidgetCode
		if(hashId != '')
		{
			$.post('/save-widget-code', { uniqid: hashId, code: finalWidgetCode })
			 .success(function (data) {
				//
			});
		}*/

		return finalWidgetCode;
	}

	//google.maps.event.addDomListener(window, 'load', initialize);

	//initSliders(map, marker);

	$("#street").change(function () {
		changeMarkerLocation();
		changeInfoWindowContent();
	});


	$("#station_cities0").change(function () {
		changeMarkerLocation(0);
		changeInfoWindowContent(0);
	});

	$("#station_states0").change(function () {
		changeMarkerLocation(0);
		changeInfoWindowContent(0);
	});

	$("#station_country_id").change(function () {
		changeMarkerLocation();
		changeInfoWindowContent();
	});



	function changeMapType(map, mapTypeId) {
		map.setMapTypeId(mapTypeId);
	}

	function changeMapZoom(map, zoom) {
		zoom = zoom * 1;
		map.setZoom(zoom);
	}
});
	
	</script>
    <script type="text/javascript" src="{{ url() }}/js/jquery.validate.min.js"></script>
	<!--
	<script type="text/javascript" src="{{ url() }}/js/captcha.js"></script>
	-->
	<script type="text/javascript" src="https://www.google.com/recaptcha/api.js"></script>

    <script>
        $(document).ready(function () {
            function validateEmail(email) {
                var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(email);
            }			
			
            $("#email_valitation").on("keyup",function(){
                //Put Spinner
                $("#overlay_spinner_email").css("display", "block");
                $("#email-error").css("display", "none");
                $("#email_valitation").removeClass("error");
                $("#reg_station").prop('disabled', false);
			});
			
            $("#email_valitation").on("blur",function(){
                //Put Spinner
                $("#overlay_spinner_email").css("display", "block");
                $("#email-error").css("display", "none");
                $("#email_valitation").removeClass("error");
                $("#reg_station").prop('disabled', false);

                //JS Email Valitation (Required and Well Format)
                var email_v = $("#email_valitation").val();
				var email_old = $("#oldmail").val();
                if (validateEmail(email_v) && email_v != email_old) {
                    // $("#email-error").text(email_v + " is valid :)");
                    // $("#email-error").css("color", "green");
                    // $("#email-error").css("display", "block");
                    $.ajax({
                        type: "get",
                        url: JS_BASE_URL + '/validate_email/' + email_v,
                        cache: false,
                        success: function (responseData, textStatus, jqXHR) {
                            if (responseData == "0") {
                                $("#email-error").text("This email is already in use");
                                $("#email-error").css("color", "red");
                                $("#email_valitation").addClass("error");
                                $("#email-error").css("display", "block");
                                $("#reg_station").prop('disabled', 'disabled');
                            }
                             $("#overlay_spinner_email").css("display", "none");
                        },
                        error: function (responseData, textStatus, errorThrown) {
                            console.log(errorThrown);
                        }
                    });

                } else {
					$("#overlay_spinner_email").css("display", "none");
                    /*$("#email-error").text("Invalid format email");
                    $("#email-error").css("color", "red");
                   /* $("#email_valitation").addClass("error");
                   // $("#email-error").css("display", "block");
                    $("#overlay_spinner_email").css("display", "none");
                    $("#submit_button").prop('disabled', 'disabled');*/
                }
            });			
			
			$(document).delegate( '#change_pass', "click",function (event) {
				$("#myModal").modal("show");			
			});			
			
			 $(document).delegate( '#change_password', "click",function (event) {
				//console.log("passs");
				var userid = $("#useraid").val();
				var oldpassword = $("#user_oldpass").val();
				var password = $("#user_pass").val();
				var cpassword = $("#user_passc").val();
				$("#user_passc_err").html(""); 
                $("#user_pass_err").html(""); 
                $("#user_oldpass_err").html("");
						var formData = {
							userid: userid,
							password: password,
                            password_confirmation : cpassword,
						    old_password: oldpassword
                        }
						$.ajax({
							type: "POST",
							url: JS_BASE_URL + "/changepassword",
							data: formData,
							
							success: function (data) {
								$("#sucess_pass").show();
                                $('#myModal').modal('toggle');
                                $("#user_oldpass").val("");
                                $("#user_pass").val("");
                                $("#user_passc").val("");						
								setTimeout(function(){
									$("#sucess_pass").hide();
								}, 3000);	
                                						
							},
							error: function (response) {
								console.log(response.responseJSON.password);
                                $("#user_pass_err").html(response.responseJSON.password);
                                $("#user_oldpass_err").html(response.responseJSON.old_password);
                                $("#user_passc_err").html(response.responseJSON.password_confirmation);
							}

						});
					 				
				});
            $("#registe_rForm").validate(function(){
                ignore: []
            });
            jQuery.validator.addClassRules('url', {
                required: true,
                url : true
            });

            $.ajax({
                type : "POST",
                url : "{!! route('state') !!}",
                success : function(response){
                    $('#station_states').append(response);
                }
            })

            $('.select2-hidden-accessible').on('change', function(){
                $(this).siblings('label.error').remove();
                $(this).removeClass('error');
            })

            $("#ext").keypress(function (e) {
                value = $(this).val();
                if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                    $("#errmsg").html("Digits Only").show().fadeOut("slow");
                        return false;
                } else {
                    if(value.length>=4){
                        $("#errmsg").html("Not more than 4").show().fadeOut("slow");
                        if (e.which == 8 || e.which == 37 || e.which == 39)
                            return true;
                        else
                            return false;
                    }
                }
            });

            $("#mobileNumber").on('keypress',function (e) {
                value = $(this).val();
                if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                    $("#errmsg").html("Digits Only").show().fadeOut("slow");
                    return false;
                } else {
                    if (value.length>=8) {
                        $("#errmsg").html("Not more than 8").show().fadeOut("slow");
                        if(e.which == 8 || e.which == 37 || e.which == 39)
                            return true;
                        else
                            return false;
                    }
                }
            });

            $("#mobileNumber").on('change', function(e){
                ext = $('#ext').val();
                number = $(this).val();
                if ((0 < ext.length && ext.length < 5) && (0 < number.length && number.length < 9 )) {
                    mobile = ext+number;
                    $('#mobileNo').val(mobile);
                }
            })
			
			var map;
			var infowindow;
			var marker;

			var map_container = $("#map-container");
			var map_canvas = $("#map-canvas");

			function initialize() {

			//var title_value = $("#title").attr('placeholder');
			//var street_value = $("#street").attr('placeholder');
			var city_value = $("#cities option:selected").text();
			var state_value = $("#states option:selected").text();
			//var station_country_id = $("#station_country_id option:selected").text();


			var lat_value = $("#geoip_lat").val();
			var lot_value = $("#geoip_lon").val();

			var mapOptions = {
			zoom: 14,
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			center: new google.maps.LatLng(lat_value, lot_value)
			};

			var contentString = city_value + '<br>'+ state_value;

			infowindow = new google.maps.InfoWindow({
			content: contentString
			});

			map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

			marker = new google.maps.Marker({
			position: new google.maps.LatLng(lat_value, lot_value),
			map: map
			});

			infowindow.open(map, marker);
			}
			changeMarkerLocation1();
			function changeMarkerLocation1() {

				var city = $("#cities option:selected").text();
				var state = $("#states option:selected").text();
				var county = $("#station_country_id option:selected").text();
				var line1 = $("#line1").val();
				var line2 = $("#line2").val();
				var line3 = $("#line3").val();
				var line4 = $("#line4").val();
				var address = "";
				if(line1 != ""){
					address += line1 + " ";
				}
				if(line2 != ""){
					address += line2 + " ";
				}
				if(line3 != ""){
					address += line3 + " ";
				}
				if(line4 != ""){
					address += line4 + " ";
				}
				if(city != "" && city != "Choose Option"){
					address += city + " ";
				}
				if(state != "" && state != "Choose Option"){
					address += state + " ";
				}
				var geocoder = new google.maps.Geocoder();
				geocoder.geocode({'address': address}, function (data, status) {
				if (status == "OK") {
					var suggestion = data[0];
					var location = suggestion.geometry.location;
					console.debug(location);
					$("#geoip_lat").val(location.lat());
					$("#geoip_lon").val(location.lng());
					var latLng = new google.maps.LatLng(location.lat(), location.lng());

					marker.setPosition(latLng);
					map.setCenter(latLng);
				}
			});
			}

			function changeInfoWindowContent1() {

            var city = $("#cities option:selected").text();
            var state = $("#states option:selected").text();
            var county = $("#station_country_id option:selected").text();
            var line1 = $("#line1").val();
            var line2 = $("#line2").val();
            var line3 = $("#line3").val();
            var line4 = $("#line4").val();
			var address = "";
			if(line1 != ""){
				address += line1 + " ";
			}
			if(line2 != ""){
				address += line2 + " ";
			}
			if(line3 != ""){
				address += line3 + " ";
			}
			if(line4 != ""){
				address += line4 + " ";
			}
			if(city != "" && city != "Choose Option"){
				address += city + " ";
			}
			if(state != "" && state != "Choose Option"){
				address += state + " ";
			}

			var contentString = address + '<br><br>';

			infowindow.setContent(contentString);
			}

			function getFinalWidgetCode1(map) {


			var street = $("#street").val().replace(/'/g, "\\'");;
			var city = $("#cities option:selected").text().replace(/'/g, "\\'");;
			var state = $("#states option:selected").text().replace(/'/g, "\\'");;
			var county = $("#station_country_id option:selected").text().replace(/'/g, "\\'");;

			var center = map.getCenter();
			var lat = center.lat();
			var lon = center.lng();

			var mapType = map.getMapTypeId();
			var mapTypeStr = "";

			switch (mapType) {
			case "roadmap":
				mapTypeStr = "google.maps.MapTypeId.ROADMAP";
				break;
			case "satellite":
				mapTypeStr = "google.maps.MapTypeId.SATELLITE";
				break;
			case "hybrid":
				mapTypeStr = "google.maps.MapTypeId.HYBRID";
				break;
			case "terrain":
				mapTypeStr = "google.maps.MapTypeId.TERRAIN";
				break;
			}

			$.ajaxSetup({
			async: false
			});

			var hashId = '';
			var finalWidgetCode = '';

			/*var lbCode = "<a href='http://maps-generator.com/'>Maps Generator</a>\n";
			$.get('/google-maps-authorization/code.js').success(function (data) {
			if(data != null && data != '' && data != 'Something Went Wrong!') {
				lbCode = data;
				regExpMatches = data.match(/id=(.*)'/i);
				hashId = regExpMatches[1];
			}
			});

			var finalWidgetCode = "<script src='https://maps.googleapis.com/maps/api/js?v=3.exp'><\/script>" +
			"<div style='overflow:hidden;height:" + height + "px;width:" + width + "px;'><div id='gmap_canvas' style='height:" + height + "px;width:" + width + "px;'></div>" +
			"<style>#gmap_canvas img{max-width:none!important;background:none!important}</style></div>" +
			lbCode +
			"<script type='text/javascript'>function init_map(){" +
			"var myOptions = {" +
			"zoom:" + zoom + ",center:new google.maps.LatLng(" + lat + "," + lon + ")," +
			"mapTypeId: " + mapTypeStr + "};" +
			"map = new google.maps.Map(document.getElementById('gmap_canvas'), myOptions);" +
			"marker = new google.maps.Marker({map: map,position: new google.maps.LatLng(" + lat + "," + lon + ")});" +
			"infowindow = new google.maps.InfoWindow({" +
			"content:'" + street + "<br>" + city + "<br>'" +
			"});" +
			"google.maps.event.addListener(marker, 'click', function(){" +
			"infowindow.open(map,marker);" +
			"});" +
			"infowindow.open(map,marker);" +
			"}" +
			"google.maps.event.addDomListener(window, 'load', init_map);" +
			"<\/script>";

			// send to server post request with finalWidgetCode
			if(hashId != '')
			{
			$.post('/save-widget-code', { uniqid: hashId, code: finalWidgetCode })
			 .success(function (data) {
				//
			});
			}*/

			return finalWidgetCode;
			}

			google.maps.event.addDomListener(window, 'load', initialize);

			//initSliders(map, marker);

				$("#line1").blur(function () {
					console.log("Line1")
					changeMarkerLocation1();
					changeInfoWindowContent1();
				});
				
				$("#line2").blur(function () {
					changeMarkerLocation1();
					changeInfoWindowContent1();
				});
				
				$("#line3").blur(function () {
					changeMarkerLocation1();
					changeInfoWindowContent1();
				});
				
				$("#line4").blur(function () {
					changeMarkerLocation1();
					changeInfoWindowContent1();
				});
			$("#cities").change(function () {
				changeMarkerLocation1();
				changeInfoWindowContent1();
			});

			$("#states").change(function () {
				changeMarkerLocation1();
				changeInfoWindowContent1();
			});

			$("#countries").change(function () {
				changeMarkerLocation1();
				changeInfoWindowContent1();
			});		

			$('#statesc').on('change', function () {
				$(this).removeClass('error');
				$(this).siblings('label.error').remove();
				var val = $(this).val();
				if (val != "") {
					var text = $('#statesc option:selected').text();
					$.ajax({
						type: "post",
						url: JS_BASE_URL + '/city',
						data: {id: val},
						cache: false,
						success: function (responseData, textStatus, jqXHR) {
							if (responseData != "") {
								$('#citiesc').html(responseData);
								document.getElementById('citiesc').disabled = false;
							}
							else {
								$('#citiesc').empty();
								$('#select2-citiesc-container').empty();
								document.getElementById('citiesc').disabled = false;
							}
						},
						error: function (responseData, textStatus, errorThrown) {
							alert(errorThrown);
						}
					});
				}
				else {
					$('#select2-citiesc-container').empty();
					$('#citiesc').html('<option value="" selected>Choose Option</option>');
				}
			});

			$('#citiesc').on('change', function () {
				$(this).removeClass('error');
				$(this).siblings('label.error').remove();
				var val = $(this).val();
				if (val != "") {
					var text = $('#citiesc option:selected').text();
					$.ajax({
						type: "post",
						url: JS_BASE_URL + '/area',
						data: {id: val},
						cache: false,
						success: function (responseData, textStatus, jqXHR) {
							if (responseData != "") {
								$('#areasc').html(responseData);
								document.getElementById('areasc').disabled = false;
							}
							else {
								$('#areasc').empty();
								$('#select2-areasc-container').empty();
								document.getElementById('areasc').disabled = false;
							}
						},
						error: function (responseData, textStatus, errorThrown) {
							alert(errorThrown);
						}
					});
				}
				else {
					$('#select2-areasc-container').empty();
					$('#areasc').html('<option value="" selected>Choose Option</option>');
				}
			});			
        });
    </script>
    <script type="text/javascript">
        $('#registe_rForm').bootstrapValidator({
                framework: 'bootstrap',
                // Feedback icons
                icon: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                onSuccess:function(){
					var editing = parseInt($("#editing").val());
					if(editing == 0){
						console.log(editing);					
						$("#registe_rForm").submit(function(e){
							e.preventDefault();
							var tcModal_url=JS_BASE_URL+"/tc/modal/sta";
							$('#tcModal').modal('show').find('.modal-body').load(tcModal_url);
						});
					} else {
					}

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
                    'directors[]':{
                        validators:{
                            notEmpty:{
                                message:"Director Name is necessary"
                            },
                            stringLength:{
                                min:3,
                                message:"Director's name must be more than 3 characters"
                            }
                        }
                    },
                    'nric[]':{
                        validators:{
                            notEmpty:{
                                message:"Enter the NRIC number"
                            },
                            stringLength:{
                                min:1,
                                message:"Invalid NRIC number"
                            }

                        }
                    },
                    'dcountry[]':{
                        validators:{
                            notEmpty:{
                                message:"Country is necessary"
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
                    }
                  
                    // Above Custom
             
                    
                }//fields
                ,
 

             });
    </script>
@stop
