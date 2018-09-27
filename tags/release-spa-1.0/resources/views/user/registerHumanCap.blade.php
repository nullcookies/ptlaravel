<?php
$cf = new \App\lib\CommonFunction();
use App\Http\Controllers\IdController;
$selectListForBusinessType =  $cf->getBusinessType();
use App\Classes;
// {!! Form::select('country', $cf->country(), null, ['class' => 'form-control']) !!}
?>
@extends("common.default")
<style>
	.form-group {
		margin-bottom: 5px !important;
	}
    .overlay{
        background-color: rgba(1, 1, 1, 0.7);
        bottom: 0;
        left: 0;
        position: fixed;
        right: 0;
        top: 0;
        z-index: 1001;
    }
    .overlay p{
        color: white;
        font-size: 72px;
        font-weight: bold;
        margin: 300px 0 0 55%;
    }
    .action_buttons{
        display: flex;
    }
    .role_status_button{
        width: 85px;
    }
</style>
@if((\Illuminate\Support\Facades\Session::has('EditHumanCap')))
<div class="alert alert-success">
    <strong>Success!</strong> Information Updated Successfully.
</div>
@endif
@section("content")
<div class="modal fade" id="myModalRemarks" role="dialog" aria-labelledby="myModalRemarks">
	<div class="modal-dialog" role="remarks" style="width: 50%">
		<div class="modal-content">
			<div class="row" style="padding: 15px;">
				<div class="col-md-12" style="">
					<form id="remarks-form">
						<fieldset>
							<h2>Remarks</h2>
							<br>
							<textarea style="width:100%; height: 250px;" name="name" id="status_remarks" class="text-area ui-widget-content ui-corner-all">
							</textarea>
							<br>
							<input type="button" id="save_remarks" class="btn btn-primary" value="Save Remarks">
							<input type="hidden" id="current_role_roleId" remarks_role="" >
							<input type="hidden" id="current_status" value="" >
						</fieldset>
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>				
		</div>			
	</div>	
</div>
<div class="modal fade" id="myModalSecRemarks" role="dialog" aria-labelledby="myModalRemarks">
	<div class="modal-dialog" role="remarks" style="width: 50%">
		<div class="modal-content">
			<div class="row" style="padding: 15px;">
				<div class="col-md-12" style="">
					<form id="secremarks-form">
						<fieldset>
							<h2>Remarks</h2>
							<br>
							<textarea style="width:100%; height: 250px;" name="name" id="status_secremarks" class="text-area ui-widget-content ui-corner-all">
							</textarea>
							<br>
							<input type="button" id="save_secremarks" class="btn btn-primary" value="Save Remarks">
							<input type="hidden" id="current_secrole_roleId" remarks_role="" >
							<input type="hidden" id="current_secstatus" value="" >
							<input type="hidden" id="current_section" value="" >
						</fieldset>
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>				
		</div>			
	</div>	
</div>
<input type="hidden" value="{{$editing}}" id="editing" />
<div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 44%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Change Password</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        
                        <div class="form-group">

                            <label class="col-sm-4 control-label">Old password:</label>
                            <div class="col-md-8">
                                <input type="password" class="form-control" id="user_oldpass" size="25" />
                                <span class="text-danger" id="user_oldpass_err"></span>
                            </div>
                        </div>
                        <input type="hidden" id="useraid" value="{{$userModel['user']['id']}}" />
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Enter new password:</label>
                            <div class="col-md-8">                 
                                <input type="password" class="form-control" id="user_pass" size="25" />
                                <span class="text-danger" id="user_pass_err"></span>
                            </div>
                        </div>          
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Reconfirm new password:</label>
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
        <div class="container"><!--Begin main cotainer-->
            <div class="row">
                <div data-spy="scroll" class="static-tab" style="display: none;">
                    <div class="text-center tab-arrow">
                        <span class="fa fa-sort"></span>
                    </div>
				<!--	<ul class="nav nav-pills nav-stacked">
                        <li role="presentation" class="active"><a href="#account">Account</a></li>
                        <li role="presentation"><a href="#company">Company</a></li>
                        <li role="presentation"><a href="#contact">Contact</a></li>
                        <li role="presentation"><a href="#shop">Shop</a></li>
                        <li role="presentation"><a href="#bank">Bank</a></li>
                        <li role="presentation"><a href="#note">Note</a></li>
                    </ul> -->
                </div>
                <div class="col-sm-12">
                    {!! Breadcrumbs::renderIfExists() !!}
                    {!! Form::open(array('url'=> $route , 'files' => 'true',
					'method'=>'post', 'id'=>'registe_rForm' ,
					'class'=> 'form-horizontal',
					'style'=>'margin-top:0')) !!}
					<input type="hidden" id="theuserid" name="theuserid" value="{{$userModel['user']['id']}}" />
                    <div id="account" class="row"
						style="margin-left:0;margin-right:0">
                        <h1>Employee Benefit Information</h1>
                        <hr style="margin-top:10px;margin-bottom:10px"/>
                        <p style=" display: none;" id="sucess_pass"
							class="alert alert-success col-md-5">
							Password successfully changed!</p>
                        <div class="col-md-12"
							style="padding-left:0;padding-right:0">
                            <div class="col-md-7"
								style="padding-left:0;padding-right:0">
                                <h2 class="col-sm-7 no-padding">Account Information</h2>
								<div class="col-sm-5">
									&nbsp;
								</div>								
                                <div class="clearfix"></div>
                                @if(count($errors)>0)
                                <div class="alert alert-danger" role="alert">
                                    @foreach($errors->all() as $error)
                                    <p>{{ $error }}</p>
                                    @endforeach
                                </div>
                                @endif
                                <div class="form-group">
                                    {!! Form::label('firstname', '* First Name', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-9">
                                        {!! Form::text('firstname',$userModel['user']['first_name'] , array('placeholder'=>'First Name', 'class' => 'form-control', 'required'))!!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('lastname', '* Last Name', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-9">
                                        {!! Form::text('lastname',$userModel['user']['last_name'] , array('placeholder'=>'Last Name', 'class' => 'form-control  ',  'required'))!!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('email', '* Email', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-9">
                                        <span style="position: relative; color: black;
										display:none; font-size: 24px; font-weight: bold;"
										class="all-filter-fa"
										id="overlay_spinner_email">
										<i class="fa-li fa fa-spinner fa-spin fa fa-fw" ></i></span>
                                        {!! Form::email('email',$userModel['user']['email'],
										array('placeholder'=>'Email',
										'class' => 'form-control  ',
										'id' => 'email_valitation','required'))!!}
                                        <label id="email-error"
										class="error" for="email"
										style="display:none">Invalid Email</label>
                                    </div>
                                </div>
                                
                                @if($userModel['user']['email'] == "")
                                <input type="hidden" id="oldmail" value="" />
								<div class="form-group">
                                    {!! Form::label('password', '* Password', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-9">
                                        {!! Form::password('password', array('placeholder'=>'Password', 'class' => 'form-control  ',  'required', 'id'=>'pass')) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('confirmPassword', '* Confirm Password', array('class' => 'col-sm-3 control-label')) !!}
                                    <div class="col-sm-9">
                                        {!! Form::password('password_confirmation', array('placeholder'=>'Confirm Password', 'class' => 'form-control  ',  'required', 'id'=>'compass')) !!}
                                    </div>
                                </div>
								</div>

                                @else
								<input type="hidden" id="oldmail"
								value="{{$userModel['user']['email']}}" />
								</div>
                                @if($edit)
                                <div class="col-md-3" style="padding-top: 10px;"> 
                                    <div class="form-group">
                                        <div class="col-offset-sm-2 col-sm-4">
                                            <a href="javascript:void(0)"
											style="font-size: 14px;"
											class="btn btn-green btn-mid"
											id="change_pass">Change Password</a> 
                                        </div>
                                    </div> 
                                </div> 
								<div class="col-md-2" style="padding-top: 10px;"> 
									&nbsp;
								</div>
                                @endif  
                                @endif
								<div class="clearfix"></div>
								<div class="form-group">
									<label class="col-sm-2 control-label">*Office </label>
									<div class="col-sm-4" style="padding-left: 0px !important; margin-left: -4px;">
										<input type="text"  name="office" placeholder="Office"  value="{{ $userModel['humancap'][0]['office_no']}}" class="form-control" required="">
									</div>
									<input id='mobileNo' type="text"  name="mobile" value="{{ $userModel['humancap'][0]['mobile_no']}}" class="form-control hidden" required="">
									@def $extension = null
									@def $num  = null;
									@if(isset($userModel['humancap'][0]['mobile_no']))
									@def $wholeNumber = $userModel['humancap'][0]['mobile_no'];
									@def $extension = substr($wholeNumber, 0, 4);
									@def $num = substr($wholeNumber, 4, 11);
									@endif
									<label class="col-sm-1 control-label">*Mobile </label>
									<div class="col-sm-4">
										<div class="col-sm-3">
											<div class="row">
												<input id='ext' type="text" placeholder="ext"   value="{{ $extension }}" class="form-control" required="">
											</div>
										</div>
										<div class="col-sm-1">
											<div class="row text-center" style="font-weight:bold; margin-top: 7px">
											   -
										   </div>
									   </div>
									   <div class="col-sm-7">
										<div class="row">
											<input  id='mobileNumber' type="text" placeholder="Mobile"  value="{{ $num }}" class="form-control mbnumb" name="mobileNumber" required="">
										</div>
									</div>
									<span id="errmsg" style="color:red"></span>
								</div>
							</div>   	
                        </div> 
                          
						
                    </div>
                    <hr>
                    <div id="company">
						<div class="col-sm-4 no-padding">
							<h2>Company Details</h2>
						</div>
						<div class="col-sm-8">
							&nbsp;
						</div>
						 <div class="clearfix"></div>
                        <div class="form-group col-xs-12">
                            {!! Form::label('company_name', '* Company Name') !!}
                            {!! Form::text('company_name',$userModel['humancap'][0]['company_name'],
                            array('placeholder'=>'Company Name', 'class' => 'form-control  ','required'))!!}

                        </div>
                        <div class="form-group">
                            {!! Form::label('domicile', 'Domicile', array('class' => 'col-sm-1 control-label')) !!}
                            <div class="col-sm-3">
                                {{-- {!! Form::select('domicile', [''=>'Country of Origin']+$cf->getCountry(), $userModel['humancap'][0]['country_id'],  'class' => '  form-control']) !!} --}}
                                {!! Form::text('country', 'Malaysia', array('readonly' => 'readonly', 'class' => 'form-control', 'id' => 'country_id')) !!}
                                {{--<select name="domicile" class="form-control"><option value="dom">Company</option></select>--}}
                            </div>
                            {!! Form::label('gst_vat', '* GST/VAT', array('class' => 'col-sm-2 control-label')) !!}
							<?php 
								$checked_nogst = "";
								$disabled_gst = "";
								if(!is_null($userModel['user']['id'])){
									if(is_null($userModel['humancap'][0]['gst']) || $userModel['humancap'][0]['gst'] == ""){
										$disabled_gst = $disabled;
										$checked_nogst = "checked";
									} 									
								}
							?>
                            <div class="col-sm-5">
                                {!! Form::text('gst', $userModel['humancap'][0]['gst'], array(  'placeholder'=>'Input Your GST/VAT Number', 'class' => '  form-control', 'id' => 'gstvat', $disabled_gst))!!}
                            </div>
							<div class="col-sm-1 no-padding" style="margin-top: 7px;">
								<b>No&nbsp;GST</b>
								&nbsp;<input type="checkbox" {{$checked_nogst}} style="vertical-align: middle;" id="nogst" />
							</div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Business Type: </label>
                            <div class="col-sm-3" >
                                {!! Form::select('business_type', $cf->getBusinessType(), $userModel['humancap'][0]['business_type'], ['class' => 'form-control', 'id' => 'bussines_type',  'required']) !!}
                                {{-- {!! Form::select('business_type',
                                    $cf->getBusinessType(), 0,
                                    ['class' => 'form-control',  'required', $disabled])
                                    !!}  --}}
                                </div>
                            </div>                      
                            <div id="dirDetail" >
                                <?php $cco = -1; ?>
                                @if(isset($userModel['directorsInEditView']))
                                @foreach($userModel['directorsInEditView'] as $director)
                                <div class="form-group" >
                                    {!! Form::label('directors', 'Directors', array('class' => 'col-sm-1 control-label','id'=>'form')) !!}
                                    <div class="col-sm-2">
                                        {!! Form::text('directors[]',$director['name'], array(  'placeholder'=>'Type the Name', 'class' => 'form-control  '))!!}
                                    </div>
									<div class="col-sm-3">
										<input type="text" class="form-control validator" name="nric[]" placeholder="Type the NRIC or Passport Number" value="{{$director['nric']}}">
									</div>
									<div class="col-sm-2">
										{!! Form::select('dcountry[]', [''=>'Nationality']+$cf->getCountry(),$director['country_id'], ['class' => 'form-control  ','id' => 'dcountry']) !!}
									</div> 
									<div class="col-sm-4">
										<div class="inputBtnSection">
												<?php 
													$file = asset('/') . 'images/director/' .$director['document_id'] . '/' . $director['doc'];
													$file_headers = @get_headers($file);
													//dd($file_headers); 
													if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found' || $file_headers[0] == 'HTTP/1.0 404 Not Found') {
														$exists = false;
													}
													else {
														$exists = true;
													}
												?>
												<input id="uploadFileDD" name="uploadFile[]" value="{{ $director['doc'] }}" @if (!$exists) rel="" @else rel= "{{asset('/')}}images/director/{{ $director['document_id'] }}/{{ $director['doc'] }}" @endif title="Click to view attached document" class="disableInputField fileview" placeholder="NRIC or Passport Picture" style="cursor:pointer;  color: blue;"/>
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
                                <input type="hidden" id="valaddDD" value="{{$cco}}">
                                @else
                                <div class="form-group" >
                                    {!! Form::label('directors', 'Directors', array('class' => 'col-sm-1 control-label')) !!}
                                   <div class="col-sm-2">
                                        {!! Form::text('directors[]', null, array(  'placeholder'=>'Type the Name', 'class' => '  form-control','required'))!!}
                                    </div> 
									<div class="col-sm-3">
										<input type="text" class="form-control " name="nric[]" placeholder="Type the NRIC or Passport Number">
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
                                @endif
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Business Registration Number </label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control"  name="business_reg_no" value="{{$userModel['humancap'][0]['business_reg_no']}}" placeholder="Type Business Number">
                                </div>
                            </div>
                            <?php $ccd = -1; ?>
                            <?php $ccdi = 0; ?>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Business Registration Form</label>
                                <div class="col-sm-8">
                                    <div class="form-group" id="businessReg">
                                        @if(isset($doc))
                                        @foreach($doc as $DOC)
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
                                        <div class="col-sm-12 pull-left" style="padding-right:0">
                                            <div class="inputBtnSection">
                                                <input id="uploadFileBR{{$ccdi}}" style="cursor: pointer; color: blue;" required="" value="{{ $DOC->path }}" @if (!$exists) rel="" @else rel="{{asset('/')}}images/document/{{ $DOC->id }}/{{ $DOC->path }}" @endif title="Click to view attached document" class="disableInputField fileview" placeholder="Upload Document" />
                                                <input name="uploadFileBRName[]" value="{{ $DOC->path }}" type="hidden"  />
                                                <input name="uploadFileDoc[]" value="{{ $DOC->path }}" type="hidden"  />
                                                <label class="fileUpload">
                                                    <input id="uploadBtnBR{{$ccdi}}" name="Regupload_attachment[]"  type="file" class="upload" />
													<input type="hidden" name="attfilesIDs[]" value="{{ $DOC->id }}"  />
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
                                        </div>
										<script>
										$().ready(function () {
											$("#uploadBtnBR{{$ccdi}}").change(function () {
												var id = $(this).attr('id-attr');
												$("#uploadFileBR{{$ccdi}}").val($(this).val());
												$("#uploadFileBR{{$ccdi}}").removeClass("fileview");
											});
										});
										</script>										
                                        <?php $ccd++; ?>
                                        <?php $ccdi++; ?>

                                        <div style="clear:both;"></div>

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
                                        <input type="hidden" id="valaddBS" value="{{$ccd}}">
                                        @else
                                        <!--<div class="col-sm-4">-->
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
										</div>
                                        <input type="hidden" id="valaddBS" value="0">
                                        @endif
                                    </div> 
                                </div>
                            </div>
                            <!--<div class="form-group">-->
                            <div class="col-sm-7">
                                <div class="form-group">
                                    <label>* Address</label>
                                    <!-- <label class="col-sm-3 control-label">Address Type: </label> -->
                                    <!-- <div class="col-sm-3"> -->
                                    <!-- {!! Form::select('address_type', $cf->getAddressType(), $userModel['address'][0]['type'], ['class' => 'form-control  ',$disabled]) !!} -->
                                    <input type="text" name="line1" id="line1" required="" class="form-control"  value="{{ $userModel['address'][0]['line1']}}" >
                                </div>
                                <div class="form-group">
                                    <input type="text" name="line2" id="line2" class="form-control" value="{{ $userModel['address'][0]['line2']}}">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="line3" id="line3"  class="form-control" value="{{ $userModel['address'][0]['line3']}}">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="line4" id="line4" class="form-control" value="{{ $userModel['address'][0]['line4']}}">
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <label>&nbsp;</label>
                                <div class="form-group">
                                    <label class="col-sm-5 control-label">Country </label>
                                    <div class="col-sm-7">

                                        <input type="hidden" name='country' value='150'>

                                        {!! Form::text('', 'Malaysia', array('value' => 150,'readonly' => 'readonly', 'class' => 'form-control', 'id' => 'country_id')) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-5 control-label">* State: </label>
                                    <div class="col-sm-7">
                                        @if(isset($userModel['address'][0]['state_id']))
                                        {!! Form::select('states', $cf->getState(),$userModel['address'][0]['state_id'], ['class' => 'form-control','required','id'=>'states']) !!}
                                        @else
                                        @def $states = \DB::table('state')->where('country_code', 'MYS')->get()
                                        <select class="form-control" id="states" required="">
                                            <option value="">Choose Option</option>
                                            @foreach($states as $state)
                                            <option value="{!! $state->id !!}">{!! $state->name !!}</option>
                                            @endforeach
                                        </select> 
                                        @endif

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-5 control-label">* City: </label>
                                    <div class="col-sm-7">
                                        @if(isset($userModel['address'][0]['city_id']))
                                        {!! Form::select('city_id', $cf->getCityByState($userModel['address'][0]['state_code']), $userModel['address'][0]['city_id'], ['class' => 'form-control','required','id'=>'cities']) !!}
                                        @else
                                        <select class="form-control  " id="cities" name="city_id" required="" disabled><option value="0">Choose Option</option></select>
                                        @endif

                                    </div>
                                </div>
                                <div class="form-group">                                               
                                    <label class="col-sm-5 control-label">Area: </label>
                                    <div class="col-sm-7">
                                        @if(isset($userModel['address'][0]['city_id']))
                                        {!! Form::select('area_id', ['0' => 'Choose Option' ] + $cf->getAreaByCity($userModel['address'][0]['city_id']), $userModel['address'][0]['area_id'], ['class' => 'form-control','id'=>'areas']) !!}
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
                                        <input type="text" name="zip" class="form-control"  value="{{ $userModel['address'][0]['postcode']}}" required=""><br>
                                    </div>

                                </div>
                            </div>                      
                            <input id="geoip_lat" name="geoip_lat" value="{{ $userModel['address'][0]['latitude']}}" type="hidden" />
                            <input id="geoip_lon" name="geoip_lon" value="{{ $userModel['address'][0]['longitude']}}" type="hidden" />
                        </div>
                        <div class="col-sm-5">
                        </div>
                        <div class="col-sm-7">
                            <div id="map-container" class="custom-container pull-right" style="width:575px; height:435px;">
                              <div id="map-canvas" style="width:540px; height:400px;">
                              </div>

                          </div>
                      </div>  
					<div class="clearfix"></div>
					<div class="g-recaptcha pull-right" data-sitekey="6LcXgyMUAAAAAJe2Qb08ADwEyxK1Dbh35aQbl5U6"></div>
					<input type="hidden" class="hiddenRecaptcha required" name="hiddenRecaptcha" id="hiddenRecaptcha">
					<div class="clearfix"></div>
					<div class="pull-right" id="captchaMessage">
						
					</div>	
					<div class="clearfix"></div>					
                    <div class="pull-right">

                        {!! Form::hidden('indication', $indication, array( 'class' => 'form-control'))!!}
                        {!! Form::submit('Submit', array('class' => 'btn btn-green','id' => 'reg_humancap')) !!}

                        {{--  <input type="submit" class="btn btn-success" value="Save">
                        <input type="submit" class="btn btn-success" value="Submit Registration Form">--}}
                    </div>

                    {{--@endforeach--}}

                    {!! Form::close() !!}

                </div>
        </div><!--End main cotainer-->
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
    </section>
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
    <script src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_MAP')}}"></script>
    <script type="text/javascript" src="{{ url() }}/js/jquery.validate.min.js"></script>
	<!--
	<script type="text/javascript" src="{{ url() }}/js/captcha.js"></script>
	-->
	<script type="text/javascript" src="https://www.google.com/recaptcha/api.js"></script>
    <script>
        $(document).ready(function () {
		window.setInterval(function(){
			if(grecaptcha.getResponse() == ''){
				 $("#reg_humancap").prop('disabled', true);
			} else {
				 $(reg_humancap).prop('disabled', false);
			}
		}, 1000);	
			
		$(document).delegate( '.all_own_toastr', "click",function (event) {
			toastr.info("In order to use own delivery you need to create new Logistic Provider Account!");
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
			
		$(document).delegate( '.brandNames', "change",function (event) {
			console.log("Hello");
			var oshops = [];
			var index = 0;
			$('select[name^="oshop_brand_name"]').each(function() {
				var selected = $(this).val();
				index++;
			//	console.log(oshops);
				var html = "<option value=''>Please Select</option>";
				$( ".brandNames" ).each(function() {
				  // console.log($(this).val());
				   var sel = '';
				   if($(this).val() == selected){
					 var sel = 'selected';  
				   }
				   html += "<option value='" + $(this).val() +"' "+sel+">" + $(this).find('option:selected').text() + "</option>"; 
				});
				$(this).html(html);
				$(this).select2();
			});
			/*console.log(html);
			$(".oshop_brand").html(html);
			for(var kk = 0; kk < oshops.length; kk++){
				console.log(oshops[kk]);
				$("#oshop_brands" + kk).val(oshops[kk]);
			}*/
		});	
		$('body').on('change', '.check_brand', function() {
			console.log("change");
			var checked = this.checked;
			var rel = $(this).attr("rel");
			if(checked){
				$("#checkbrand" + rel).val(1);
			} else {
				$("#checkbrand" + rel).val(0);
			}
		});			
			
            function validateEmail(email) {
                var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(email);
            }

            $(".create_station").on("click",function(){
				$(this).html("Creating...");
				var userid = $("#useraid").val();
				$.ajax({
					type: "POST",
					url: JS_BASE_URL + "/alsostation",
					data: {userid: userid},
					
					success: function (data) {
						toastr.info("Station creation was successful. Please, wait for the webpage refresh to edit Station information");
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
			
			$("#all_system_delivery").on("click",function(){
				var boo = $(this).is(":checked");
				if(boo){
					$("#all_own_delivery").prop('checked', false);
				//	$("#all_own_delivery").prop('disabled', true);
					$("#ilike").prop('checked', false);
				//	$("#ilike").prop('disabled', true);					
				} else {
				//	$("#all_own_delivery").prop('disabled', false);
				//	$("#ilike").prop('disabled', false);
				}
                //Put Spinner
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
			
            $("#all_own_delivery").on("click",function(){
				var boo = $(this).is(":checked");
				if(boo){
					$("#all_system_delivery").prop('checked', false);
				//	$("#all_system_delivery").prop('disabled', true);
					$("#ilike").prop('checked', false);
				//	$("#ilike").prop('disabled', true);							
				} else {
				//	$("#all_system_delivery").prop('disabled', false);
				//	$("#ilike").prop('disabled', false);
				}
                //Put Spinner
            });				
			
            $("#ilike").on("click",function(){
				var boo = $(this).is(":checked");
				if(boo){
					$("#all_system_delivery").prop('checked', false);
				//	$("#all_system_delivery").prop('disabled', true);
					$("#all_own_delivery").prop('checked', false);
				//	$("#all_own_delivery").prop('disabled', true);							
				} else {
				//	$("#all_system_delivery").prop('disabled', false);
				//	$("#all_own_delivery").prop('disabled', false);
				}
                //Put Spinner
            });				
			
            $("#email_valitation").on("keyup",function(){
                //Put Spinner
                $("#overlay_spinner_email").css("display", "block");
                $("#email-error").css("display", "none");
                $("#email_valitation").removeClass("error");
                $("#reg_humancap").prop('disabled', false);
            });
            $('#reg_button').click(function(e){
                e.preventDefault();
                var tcModal_url=JS_BASE_URL+"/tc/modal/hc";
                $('#tcModal').modal('show').find('.modal-body').load(tcModal_url);

            });
            $("#email_valitation").on("blur",function(){
                //Put Spinner
                $("#overlay_spinner_email").css("display", "block");
                $("#email-error").css("display", "none");
                $("#email_valitation").removeClass("error");
                $("#reg_humancap").prop('disabled', false);

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
                                $("#email_validation").addClass("error");
                                $("#email-error").css("display", "block");
                                $("#reg_humancap").prop('disabled', 'disabled');
                            }
                            if (responseData=="1") {
                                 $("#email-error").text("This email is valid");
                                $("#email-error").css("color", "green");
                                $("#email-error").css("display", "block");
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
            var map;
            var infowindow;
            var marker;

            var map_container = $("#map-container");
            var map_canvas = $("#map-canvas");

            $("#station-open-channel").DataTable();

        //$("#states").change();

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

    function changeMarkerLocation() {

            //var street = $("#street").val();
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
         //   var address = city + ',' + state + ',' + " Malaysia";
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

        function changeInfoWindowContent() {
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

        function getFinalWidgetCode(map) {


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

        $("#street").change(function () {
            changeMarkerLocation();
            changeInfoWindowContent();
        });


        $("#cities").change(function () {
            changeMarkerLocation();
            changeInfoWindowContent();
        });

        $("#states").change(function () {
            changeMarkerLocation();
            changeInfoWindowContent();
        });

        $("#countries").change(function () {
            changeMarkerLocation();
            changeInfoWindowContent();
        });
		
		$("#line1").blur(function () {
			console.log("Line1");
            changeMarkerLocation();
            changeInfoWindowContent();
        });
		
		$("#line2").blur(function () {
            changeMarkerLocation();
            changeInfoWindowContent();
        });
		
		$("#line3").blur(function () {
            changeMarkerLocation();
            changeInfoWindowContent();
        });
		
		$("#line4").blur(function () {
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
        

 /*   $('#country_id').on('change', function () {
        var val = $(this).val();
        if (val != "") {
            $.ajax({
                type: "post",
                url: JS_BASE_URL + '/state',
                data: {id: val},
                cache: false,
                success: function (responseData, textStatus, jqXHR) {
                    if (responseData != "") {
                        $('#states').html(responseData);
                    }
                    else {
                        $('#cities').empty();
                        $('#states').empty();
                        $('#select2-states-container').empty();
                        $('#select2-cities-container').empty();
                    }
                },
                error: function (responseData, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
        }
        else {
            $('#cities').html('<option value="" selected>Choose Option</option>');
            $('#states').html('<option value="" selected>Choose Option</option>');
        }
    });*/
    $('#bussines_type').on('change', function () {
        if($('#bussines_type').val() ==  'sole_proprietorship'){
            $("#addDD").hide();
        } else {
            $("#addDD").show();
        }
    });
    $('#mstates').on('change', function () {
        $(this).removeClass('error');
        $(this).siblings('label.error').remove();
        var val = $(this).val();
        if (val != "") {
            var text = $('#mstates option:selected').text();
            $.ajax({
                type: "post",
                url: JS_BASE_URL + '/city',
                data: {id: val},
                cache: false,
                success: function (responseData, textStatus, jqXHR) {
                    if (responseData != "") {
                        $('#mcities').html(responseData);
                        document.getElementById('mcities').disabled = false;
                    }
                    else {
                        $('#mcities').empty();
                        $('#select2-mcities-container').empty();
                        document.getElementById('mcities').disabled = false;
                    }
                },
                error: function (responseData, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
        }
        else {
            $('#select2-mcities-container').empty();
            $('#mcities').html('<option value="" selected>Choose Option</option>');
        }
    });

    $('#mcities').on('change', function () {
        $(this).removeClass('error');
        $(this).siblings('label.error').remove();
        var val = $(this).val();
        if (val != "") {
            var text = $('#mcities option:selected').text();
            $.ajax({
                type: "post",
                url: JS_BASE_URL + '/area',
                data: {id: val},
                cache: false,
                success: function (responseData, textStatus, jqXHR) {
                    if (responseData != "") {
                        document.getElementById('mareas').disabled = false;
                        $('#mareas').html(responseData);
                    }
                    else {
                        document.getElementById('mareas').disabled = false;
                        $('#mareas').empty();
                        $('#select2-mareas-container').empty();
                    }
                },
                error: function (responseData, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
        }
        else {
            $('#select2-areas-container').empty();
            $('#mareas').html('<option value="" selected>Choose Option</option>');
        }
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
	
	/*************** OSHOP ********************/
	$('body').on('click', '.add_oshop', function() {
		var current_outlet = parseInt($("#current_oshop").val());
		current_outlet++;
		$("#current_oshop").val(current_outlet)
		
		var html_add = '<div id="oshop_'+current_outlet+'"><div class="row" id="location_'+current_outlet+'"><hr>';
			html_add += '<div class="col-sm-10">';
			html_add += '<div class="col-sm-10 no-padding">';
			html_add += '<h2 style="margin-top:0px;"class="col-sm-5 no-padding">O-Shop: </h2>';
			html_add += '<div class="col-sm-7">';
			html_add += '<input aria-required="true" placeholder="Please fill in O-Shop Name" class="form-control" required="required" name="oshop_name[]" value="" type="text">';
			html_add += '</div>';
			html_add += '<div class="col-sm-2">&nbsp;</div>';
			html_add += '</div>	';
			html_add += '</div>	';
			html_add += '<div class="col-sm-2"><a href="javascript:void(0);" class="delete_oshop btn btn-danger pull-right" rel="'+current_outlet+'">x</a></div>';
			html_add += '<div class="col-sm-12">';
			html_add += '<h3 style="margin-top:0px;">Location</h3>';
			html_add += '</div>';		
			html_add += '<div class="col-sm-5">';
			html_add += '	<label>&nbsp;</label>';
			html_add += '	<div class="form-group">';
			html_add += '		<label class="col-sm-5 control-label">Country: </label>';
			html_add += '		<div class="col-sm-7">';
			html_add += '		<input aria-required="true" disabled class="form-control" id="oshop_country_id" required="required" name="country_id" value="Malaysia" type="text">';
			html_add += '		</div>';
			html_add += '	</div>';
			html_add += '	<div class="form-group">';
			html_add += '		<label class="col-sm-5 control-label">State </label>';
			html_add += '		<div class="col-sm-7">';
			html_add += '			<select class="form-control oshop_states" rel="'+current_outlet+'" id="oshop_states'+current_outlet+'" name="state_idoshop[]">';
			html_add += '				<option value="">Choose Option</option>';
			html_add += '			</select>';
			html_add += '		</div>';
			html_add += '	</div>';
			html_add += '	<div class="form-group">';
			html_add += '		<label class="col-sm-5 control-label">City </label>';
			html_add += '		<div class="col-sm-7">';
			html_add += '		<select class="form-control oshop_cities" rel="'+current_outlet+'" id="oshop_cities'+current_outlet+'" name="city_idoshop[]" disabled></select>';
			html_add += '		</div>';
			html_add += '	</div>';
			html_add += '	<div class="form-group">';
			html_add += '		<label class="col-sm-5 control-label">Area </label>';
			html_add += '		<div class="col-sm-7">';
			html_add += '		<select class="form-control" id="oshop_areas'+current_outlet+'" rel="'+current_outlet+'" name="area_idoshop[]" disabled></select>';
			html_add += '		</div>';
			html_add += '	</div>';
			html_add += '					<div class="form-group">';
			html_add += '						<label class="col-sm-5 control-label">*Postcode /Zip Code: </label>';
			html_add += '						<div class="col-sm-7">';
			html_add += '							<input type="text" name="zipcodeoshop[]" class="form-control" required="" value="">		';							
			html_add += '						</div>';
			html_add += '					</div>		';		
			html_add += '					<div class="form-group">';
			html_add += '						<label class="col-sm-3 control-label">Address</label>';
			html_add += '						<div class="col-sm-9">';
			html_add += '							<input type="text" name="oshop_line1[]" class="form-control" value="" >';
			html_add += '						</div>	';
			html_add += '					</div>';
			html_add += '					<div class="form-group">';
			html_add += '						<label class="col-sm-3 control-label">&nbsp;</label>';
			html_add += '						<div class="col-sm-9">';
			html_add += '							<input type="text" name="oshop_line2[]" class="form-control" value="">';
			html_add += '						</div>';
			html_add += '					</div>';
			html_add += '					<div class="form-group">';
			html_add += '						<label class="col-sm-3 control-label">&nbsp;</label>';
			html_add += '						<div class="col-sm-9">';
			html_add += '							<input type="text" name="oshop_line3[]" class="form-control" value="">';
			html_add += '						</div>';
			html_add += '					</div>';
			html_add += '					<div class="form-group">';
			html_add += '						<label class="col-sm-3 control-label">&nbsp;</label>';
			html_add += '						<div class="col-sm-9">';
			html_add += '							<input type="text" name="oshop_line4[]" class="form-control" value="">';
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
			html_add += '<input id="oshop_id'+current_outlet+'" name="oshop_ids[]" value="0" type="hidden" />';
			html_add += '<input id="geoip_lat'+current_outlet+'" name="geoip_lats[]" value="0" type="hidden">';
			html_add += '<input id="geoip_lon'+current_outlet+'" name="geoip_lons[]" value="0" type="hidden">';					
			html_add += '<div class="form-group">';
			html_add += '<label for="shop_size" class="col-sm-2 control-label">Brand</label>';
			html_add += '	<div class="col-sm-4">';
			html_add += '		<select name="oshop_brand_name[]" id="oshop_brands'+current_outlet+'" class="form-control oshop_brand" necessary="necessary" ></select>';
			html_add += '	</div>';
			html_add += '</div>';	
			html_add += '<div class="form-group">';
			html_add += '<label for="shop_size" class="col-sm-2 control-label">Shop Size</label>';
			html_add += '	<div class="col-sm-4">';
			html_add += '		<input aria-required="true" class="form-control" required="required" name="shop_size[]" value="" type="text">';
			html_add += '	</div>';
			html_add += '</div>';	
			html_add += '<div class="form-group">';
			html_add += '<label for="shop_size" class="col-sm-2 control-label">Contact</label>';
			html_add += '	<div class="col-sm-4">';
			html_add += '		<input aria-required="true" class="form-control" required="required" name="firstname_oshop[]" value="" type="text">';
			html_add += '	</div>';
			html_add += '	<div class="col-sm-4">';
			html_add += '		<input aria-required="true" class="form-control" required="required" name="lastname_oshop[]" value="" type="text">';
			html_add += '	</div>';			
			html_add += '</div>';				
			html_add += '<div class="form-group">';
			html_add += '	<label for="contact_property" class="col-sm-2 control-label">Contact Mobile No.</label>';
			html_add += '	<div class="col-sm-4">';
			html_add += '		<input aria-required="true" class="form-control" required="required" name="contact_mobile_no[]" value="" type="text">';
			html_add += '	</div>';
			html_add += '</div>';
			html_add += '</div>';
			html_add += '</div>';
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
			html_add += '				<a href="javascript:void(0);" class="add_oshop btn btn-info pull-right">+</a>';
			html_add += '		</div>';
			html_add += '	</div>';
			html_add += '</div>';
			html_add += '	</div>';						
			$("#oshops").append(html_add);
			var cloneStates = $("#oshop_states0 > option").clone();
			var cloneBrands = $("#oshop_brands0 > option").clone();
			$('#oshop_states'+current_outlet).html(cloneStates);
			$('#oshop_brands'+current_outlet).html(cloneBrands);
			$('#oshop_states'+current_outlet).select2();
			$('#oshop_cities'+current_outlet).select2();
			$('#oshop_areas'+current_outlet).select2();
			$('#oshop_brands'+current_outlet).select2();
		
				$('#oshop_states' +current_outlet).on('change', function () {
					var val = $(this).val();
					if (val != "") {
						$.ajax({
							type: "post",
							url: JS_BASE_URL + '/city',
							data: {id: val},
							cache: false,
							success: function (responseData, textStatus, jqXHR) {
								if (responseData != "") {
									$('#oshop_cities' +current_outlet).html(responseData);
									document.getElementById('oshop_cities' +current_outlet).disabled = false;
								}
								else {
									$('#oshop_cities' +current_outlet).empty();
									$('#select2-oshop_cities'+current_outlet+'-container').empty();
									document.getElementById('oshop_cities'+current_outlet).disabled = false;
								}
							},
							error: function (responseData, textStatus, errorThrown) {
								alert(errorThrown);
							}
						});
					}
					else {
						$('#select2-oshop_cities'+current_outlet+'-container').empty();
						$('#oshop_cities'+current_outlet).html('<option value="" selected>Choose Option</option>');
					}
					
					changeMarkerLocationn(current_outlet);
					changeInfoWindowContentn(current_outlet);
				});

				$('#oshop_cities' +current_outlet).on('change', function () {
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
									$('#oshop_areas' +current_outlet).html(responseData);
									document.getElementById('oshop_areas' +current_outlet).disabled = false;
								}
								else {
									$('#oshop_areas0').empty();
									$('#select2-oshop_areas'+current_outlet+'-container').empty();
									document.getElementById('oshop_areas'+current_outlet).disabled = false;
								}
							},
							error: function (responseData, textStatus, errorThrown) {
								alert(errorThrown);
							}
						});
					}
					else {
						$('#select2-oshop_areas'+current_outlet+'-container').empty();
						$('#oshop_areas'+current_outlet).html('<option value="" selected>Choose Option</option>');
					}
					changeMarkerLocationn(current_outlet);
					changeInfoWindowContentn(current_outlet);
				});		
				
				var city_value = $("#oshop_cities"+current_outlet+" option:selected").text();
				var state_value = $("#oshop_states"+current_outlet+" option:selected").text();
				//var station_country_id = $("#station_country_id option:selected").text();
				

				var lat_value = $("#geoip_lat" +current_outlet).val();
				var lot_value = $("#geoip_lon" +current_outlet).val();

				var mapOptions = {
					zoom: 12,
					mapTypeId: google.maps.MapTypeId.ROADMAP,
					center: new google.maps.LatLng(lat_value, lot_value)
				};

				var contentString = city_value + '<br>';+ state_value;

				infowindown[current_outlet] = new google.maps.InfoWindow({
					content: contentString
				});

				mapn[current_outlet] = new google.maps.Map(document.getElementById('map-canvas' +current_outlet), mapOptions);

				markern[current_outlet] = new google.maps.Marker({
					position: new google.maps.LatLng(lat_value, lot_value),
					map: mapn[current_outlet]
				});

				infowindown[current_outlet].open(mapn[current_outlet], markern[current_outlet]);				
	});	
	
	$('body').on('click', '.delete_oshop', function() {
		var outlet = $(this).attr('rel');
		$("#oshop_" + outlet).remove();
		//alert(outlet);
	});
	
    $('#oshop_states0').on('change', function () {
        var val = $(this).val();
        if (val != "") {
            var text = $('#oshop_states0 option:selected').text();
            $.ajax({
                type: "post",
                url: JS_BASE_URL + '/city',
                data: {id: val},
                cache: false,
                success: function (responseData, textStatus, jqXHR) {
                    if (responseData != "") {
                        $('#oshop_cities0').html(responseData);
						document.getElementById('oshop_cities0').disabled = false;
                    }
                    else {
                        $('#oshop_cities0').empty();
                        $('#select2-oshop_cities0-container').empty();
						document.getElementById('oshop_cities0').disabled = false;
                    }
                },
                error: function (responseData, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
        }
        else {
            $('#select2-oshop_cities0-container').empty();
            $('#oshop_cities0').html('<option value="" selected>Choose Option</option>');
        }
    });

    $('#oshop_cities0').on('change', function () {
        var val = $(this).val();
        if (val != "") {
            var text = $('#oshop_cities0 option:selected').text();
            $(this).siblings('span.select2').removeClass('errorBorder');
            $.ajax({
                type: "post",
                url: JS_BASE_URL + '/area',
                data: {id: val},
                cache: false,
                success: function (responseData, textStatus, jqXHR) {
                    if (responseData != "") {
                        $('#oshop_areas0').html(responseData);
						document.getElementById('oshop_areas0').disabled = false;
                    }
                    else {
                        $('#oshop_areas0').empty();
                        $('#select2-oshop_areas0-container').empty();
						document.getElementById('oshop_areas0').disabled = false;
                    }
                },
                error: function (responseData, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
        }
        else {
            $('#select2-oshop_areas0-container').empty();
            $('#oshop_areas0').html('<option value="" selected>Choose Option</option>');
        }
    });	
	
	var mapn = new Array();
	var infowindown  = new Array();
	var markern  = new Array();

	var map_containern = $("#map-container0");
	var map_canvasn = $("#map-canvas0");		


	function changeMarkerLocationn(current) {

		var street = $("#street").val();
		var city = $("#oshop_cities"+current+" option:selected").text();
		var state = $("#oshop_states"+current+" option:selected").text();
		var county = $("#oshop_country_id option:selected").text();

		var address = city + ',' + state + ',' + "Malaysia";

		var geocoder = new google.maps.Geocoder();
		geocoder.geocode({'address': address}, function (data, status) {
			if (status == "OK") {
				var suggestion = data[0];
				var location = suggestion.geometry.location;
				console.debug(location);
				$("#geoip_lat"+current).val(location.lat());
				$("#geoip_lon"+current).val(location.lng());			
				var latLng = new google.maps.LatLng(location.lat(), location.lng());

				markern[current].setPosition(latLng);
				mapn[current].setCenter(latLng);
			}
		});
	}

	function changeInfoWindowContentn(current) {
		
		var street = $("#street").val();
		var city = $("#oshop_cities"+current+" option:selected").text();
		var state = $("#oshop_states"+current+" option:selected").text();
		var county = $("#oshop_country_id option:selected").text();

		var address = city + ',' + state + ',' + "Malaysia";

		var contentString = city + ',' + state + ',' + "Malaysia" + '<br><br>';

		infowindown[current].setContent(contentString);
	}

	function getFinalWidgetCoden(map) {
		
		
		var street = $("#street").val().replace(/'/g, "\\'");;
		var city = $("#oshop_cities0 option:selected").text().replace(/'/g, "\\'");
		var state = $("#oshop_states0 option:selected").text().replace(/'/g, "\\'");
		var county = $("#oshop_country_id option:selected").text().replace(/'/g, "\\'");

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
		$.get('/google-maps-Official Shop/ O-Shop/code.js').success(function (data) {
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

	

	//initSliders(map, marker);

	$("#street").change(function () {
		changeMarkerLocationn();
		changeInfoWindowContentn();
	});


	$("#oshop_cities0").change(function () {
		changeMarkerLocationn(0);
		changeInfoWindowContentn(0);
	});

	$("#oshop_states0").change(function () {
		changeMarkerLocationn(0);
		changeInfoWindowContentn(0);
	});

	$("#oshop_country_id").change(function () {
		changeMarkerLocationn();
		changeInfoWindowContentn();
	});



	function changeMapTypen(map, mapTypeId) {
		map.setMapTypeId(mapTypeId);
	}

	function changeMapZoomn(map, zoom) {
		zoom = zoom * 1;
		map.setZoom(zoom);
	}	
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
						$("#registe_rForm").submit(function(e){
							e.preventDefault();
							var tcModal_url=JS_BASE_URL+"/tc/modal/hc";
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
                  
                    // Above Custom
             
                    
                }//fields
                ,
 

             });
    </script>
@stop
