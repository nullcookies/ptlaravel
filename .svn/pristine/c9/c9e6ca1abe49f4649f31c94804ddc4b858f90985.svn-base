<?php
$cf = new \App\lib\CommonFunction();
$selectListForBusinessType =  $cf->getBusinessType();
// {!! Form::select('country', $cf->country(), null, ['class' => 'form-control']) !!}
?>
@extends("common.default")
@if((\Illuminate\Support\Facades\Session::has('EditMerchant')))
    <div class="alert alert-success">
        <strong>Success!</strong> Information Updated Successfully.
    </div>
@endif
@section("content")
    <section class="">
        <div class="container"><!--Begin main cotainer-->
            <div class="row">
                <div data-spy="scroll" class="static-tab" style="display: none;">
                    <div class="text-center tab-arrow">
                        <span class="fa fa-sort"></span>
                    </div>
                    <ul class="nav nav-pills nav-stacked">
                        <li role="presentation" class="active"><a href="#account">Account</a></li>
                        <li role="presentation"><a href="#company">Company</a></li>
                        <li role="presentation"><a href="#contact">Contact</a></li>
                        <li role="presentation"><a href="#shop">Shop</a></li>
                        <li role="presentation"><a href="#bank">Bank</a></li>
                        <li role="presentation"><a href="#remark">Remarks</a></li>
                    </ul>
                </div>
                <div class="col-sm-11 col-sm-offset-1">
                    {!! Form::open(array('url'=> $route , 'files' => 'true', 'method'=>'post', 'id'=>'registe_rForm' , 'class'=> 'form-horizontal')) !!}
                    {{--                    @foreach($userModel as $user)--}}

                    <div id="account">
                        <h1>Merchant</h1>
                        <hr/>
                        <h2>Account Information</h2>
                        @if(count($errors)>0)
                            <div class="alert alert-danger" role="alert">
                                @foreach($errors->all() as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif
                        <div class="form-group">
                            {!! Form::label('firstname', 'First Name', array('class' => 'col-sm-2 control-label')) !!}
                            <div class="col-sm-6">
                                {!! Form::text('firstname',$userModel['user']['first_name'] , array('placeholder'=>'First Name', 'class' => 'form-control validator'))!!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('lastname', 'Last Name', array('class' => 'col-sm-2 control-label')) !!}
                            <div class="col-sm-6">
                                {!! Form::text('lastname',$userModel['user']['last_name'] , array('placeholder'=>'Last Name', 'class' => 'form-control validator'))!!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('email', 'Email', array('class' => 'col-sm-2 control-label')) !!}
                            <div class="col-sm-6">
                                {!! Form::email('email',$userModel['user']['email'] , array('placeholder'=>'Email', 'class' => 'form-control validator',$disabled))!!}
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div id="company">
                        <h2>Company Details</h2>
                        <div class="form-group col-xs-12">
                            {!! Form::label('company_name', 'Company Name') !!}
                            {!! Form::text('company_name',$userModel['merchant'][0]['company_name'], array( "data-bv-trigger" => "keyup" , "required" => "required",
                            'placeholder'=>'Company Name', 'class' => 'form-control validator',$disabled))!!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('domicile', 'Domicile', array('class' => 'col-sm-1 control-label')) !!}
                            <div class="col-sm-3">
                                {!! Form::select('domicile', [''=>'Country of Origin']+$cf->getCountry(), $userModel['merchant'][0]['country_id'], [ "data-bv-trigger" => "keyup" , "required" => "required", 'class' => 'validator form-control',$disabled]) !!}
                                {{--<select name="domicile" class="form-control"><option value="dom">Company</option></select>--}}
                            </div>
                            {!! Form::label('gst_vat', 'GST/VAT', array('class' => 'col-sm-2 control-label')) !!}
                            <div class="col-sm-5">
                                {!! Form::text('gst', $userModel['merchant'][0]['gst'], array( "data-bv-trigger" => "keyup" , "required" => "required", 'placeholder'=>'Input Your GST/VAT Number', 'class' => 'validator form-control',$disabled))!!}
                            </div>
                        </div>
                        <div id="dirDetail" >
                            @if(isset($userModel['directorsInEditView']))
                                @foreach($userModel['directorsInEditView'] as $director)
                                    <div class="form-group" >
                                        {!! Form::label('directors', 'Directors', array('class' => 'col-sm-1 control-label')) !!}
                                        <div class="col-sm-2">
                                            {!! Form::text('directors[]',$director['name'], array( "data-bv-trigger" => "keyup" , "required" => "required", 'placeholder'=>'Type the Name', 'class' => 'form-control validator',$disabled))!!}
                                        </div>
                                        <div class="col-sm-3">
                                            {!! Form::text('nric[]', $director['nric'], array('placeholder'=>'Type the NRIC or Passport Number', 'class' => 'form-control validator',$disabled))!!}
                                        </div>
                                        <div class="col-sm-2">
                                            {!! Form::select('dcountry[]', [''=>'Nationality']+$cf->getCountry(),$director['country_id'], ['class' => 'form-control validator','id' => 'dcountry',$disabled]) !!}
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="inputBtnSection">
                                                <input id="uploadFileDD" value="{{ $director['doc'] }}" class="disableInputField validator" placeholder="NRIC or Passport Picture" {{$disabled}} />
                                                <label class="fileUpload">
                                                    <input id="uploadBtnDD" name="directorImages[]"  type="file" class="upload" {{$disabled}} required />
                                                    <span class="uploadBtn">Upload </span>
                                                </label>
                                            </div>
                                            <a  href="javascript:void(0);" id="addDD" class="text-green"><i class="fa fa-plus-circle"></i></a>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="form-group" >
                                    {!! Form::label('directors', 'Directors', array('class' => 'col-sm-1 control-label')) !!}
                                    <div class="col-sm-2">
                                        {!! Form::text('directors[]', null, array( "data-bv-trigger" => "keyup" , "required" => "required", 'placeholder'=>'Type the Name', 'class' => 'validator form-control'))!!}
                                    </div>
                                    <div class="col-sm-3">
                                        {!! Form::text('nric[]', null, array('placeholder'=>'Type the NRIC or Passport No.', 'class' => 'form-control validator'))!!}
                                    </div>
                                    <div class="col-sm-2">
                                        {!! Form::select('dcountry[]', [''=>'Nationality']+$cf->getCountry(), null, ['class' => 'form-control validator','id' => 'dcountry']) !!}
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="inputBtnSection">
                                            <input id="uploadFileDD" class="disableInputField validator" placeholder="NRIC or Passport Photo" {{$disabled}} />
                                            <label class="fileUpload">
                                                <input id="uploadBtnDD" name="directorImages[]" type="file" class="upload validator" required/>
                                                <span class="uploadBtn">Upload </span>
                                            </label>
                                        </div>
                                        <a  href="javascript:void(0);" id="addDD" class="text-green"><i class="fa fa-plus-circle"></i></a>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Business Type: </label>
                            <div class="col-sm-3">
                                {!! Form::select('business_type', $cf->getBusinessType(), $userModel['merchant'][0]['business_type'], ['class' => 'form-control validator',$disabled]) !!}
                            </div>
                        </div>

                    <!--<div class="form-group">-->
                        <div class="col-sm-7">
                        <div class="form-group">
                        <label>Address</label>
                            <!-- <label class="col-sm-3 control-label">Address Type: </label> -->
                            <!-- <div class="col-sm-3"> -->
                               <!-- {!! Form::select('address_type', $cf->getAddressType(), $userModel['address'][0]['type'], ['class' => 'form-control validator',$disabled]) !!} -->
                            <input type="text" name="line1" class="form-control validator" value="{{ $userModel['address'][0]['line1']}}" >
                            </div>
                            <div class="form-group">
                                <input type="text" name="line2" class="form-control" value="{{ $userModel['address'][0]['line2']}}">
                            </div>
                            <div class="form-group">
                                <input type="text" name="line3" class="form-control" value="{{ $userModel['address'][0]['line3']}}">
                            </div>
                            <div class="form-group">
                                <input type="text" name="line4" class="form-control" value="{{ $userModel['address'][0]['line4']}}">
                            </div>
                            </div>

        <div class="col-sm-5">
                        <div class="form-group">
                            <label class="col-sm-5 control-label">Business Registration Number: </label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control validator" name="business_reg_no" value="{{$userModel['merchant'][0]['business_reg_no']}}" placeholder="Type Business Number" {{$disabled}}>
                            </div>
                            </div>
                            <div class="form-group">
                            <label class="col-sm-5 control-label">Business Registration Form</label>
                            <div class="col-sm-7">
                            <div class="form-group">
                            @if(isset($mer_doc))
                                @foreach($doc as $Doc)
                                    @foreach($mer_doc as $mer_Doc)
                                        @if($mer_Doc->merchant_id == $userModel['merchant'][0]['id'])
                                            @if($mer_Doc->document_id == $Doc->id && $Doc->name == 'registrtion')
                                                <div class="col-sm-7 pull-right">
                                                    <div class="inputBtnSection">
                                                        <input id="uploadFileBR" class="disableInputField validator" value="{{ $Doc->path }}" placeholder="Upload Document" {{$disabled}} />
                                                        <label class="fileUpload">
                                                            <input id="uploadBtnBR" name="upload_attachment[]"  type="file" class="upload" />
                                                            <span class="uploadBtn">Upload </span>
                                                        </label>
                                                    </div>
                                                    <a  href="javascript:void(0);" id="addBS" class="text-green"><i class="fa fa-plus-circle"></i></a>
                                                </div>

                                                <div style="clear:both;"></div>
                                            @endif
                                        @endif
                                    @endforeach
                                @endforeach
                            @else
                                <!--<div class="col-sm-4">-->
                                    <div class="inputBtnSection">
                                        <input id="uploadFileBR" class="disableInputField validator" placeholder="Upload Document" {{$disabled}} />
                                        <label class="fileUpload">
                                            <input id="uploadBtnBR" name="Regupload_attachment[]"  type="file" class="upload validator" required/>
                                            <span class="uploadBtn">Upload </span>
                                        </label>
                                       </div>
                                    <a  href="javascript:void(0);" id="addBS" class="text-green"><i class="fa fa-plus-circle"></i></a>
                                 </div>
                            @endif

                        <div id="businessReg" class="form-group"> </div>
                        </div>
                         </div>
                        </div>
                    </div>
                    <hr>
                        <div class="clearfix"></div>
                    <div id="contact">
                        <h2>Contact Details</h2>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Contact Person: </label>
                            <div class="col-sm-4">
                                <input type="text " required="" name="contact" value="{{ $userModel['merchant'][0]['contact_person']}}" class="form-control validator" >
                            </div>
                            <label class="col-sm-1 control-label">Office: </label>
                            <div class="col-sm-2">
                                <input type="text" required="" name="office"  value="{{ $userModel['merchant'][0]['office_no']}}" class="form-control">
                            </div>
                            <label class="col-sm-1 control-label">Mobile: </label>
                            <div class="col-sm-2">
                                <input type="text" required="" name="mobile"  value="{{ $userModel['merchant'][0]['mobile_no']}}" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Website: </label>

                            <div class="col-sm-4 col-xs-10">

                                @if( !is_null($userModel['websites'] ))
                                    @foreach($userModel['websites'] as $websites)

                                        @if($websites['type'] == "website")
                                            <input type="hidden" name="websiteRow[]" class="form-control" value="{{ $websites['id']}}">
                                            <input type="url" required="" name="website[]" class="form-control" value="{{ $websites['url']}}"  placeholder="http://www.abc.com.my">
                                            <br/>
                                        @elseif(count($userModel['websites']) <= 1 && $websites['type'] == null )
                                            <input type="url" required="" name="website[]" class="form-control" value="{{ $websites['url']}}"  placeholder="http://www.abc.com.my">
                                        @endif
                                    @endforeach
                                @else
                                    <input type="url" required="" name="website[]" class="form-control" value=""  placeholder="http://www.abc.com.my">
                                @endif
                            </div>
                            <div class="col-xs-1">
                                <a  href="javascript:void(0);" id="addWS" class="text-green" ><i class="fa fa-plus-circle"></i></a>
                            </div>
                        </div>
                        <div id="website"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Social Media: </label>
                            <div class="col-sm-4 col-xs-10">
                                @if( !is_null($userModel['socialmedia'] ))
                                    @foreach($userModel['socialmedia'] as $websites)
                                        @if($websites != "")
                                            <input type="hidden" name="socialRow[]" class="form-control" value="{{ $websites['id']}}">
                                            <input type="text" required="" name="social[]" class="form-control" value="{{ $websites['url']}}"  placeholder="http://www.facebook.com/my">
                                            <br/>
                                        @elseif(count($userModel['socialmedia']) <= 1)
                                            <input type="url" required="" name="social[]" class="form-control" value="{{ $websites['url']}}"  placeholder="http://www.abc.com.my">
                                        @endif
                                    @endforeach
                                @else
                                    <input type="url" required="" name="social[]" class="form-control" value=""  placeholder="http://www.abc.com.my">
                                @endif
                            </div>
                            <div class="col-xs-1">
                                <a  href="javascript:void(0);" id="addSM" class="text-green"><i class="fa fa-plus-circle"></i></a>
                            </div>
                        </div>
                        <div id="socialMedia">  </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Current eCommerce Site: </label>
                            <div class="col-sm-4 col-xs-10">
                                @if( ! is_null($userModel['websites'] ))
                                    @foreach($userModel['websites'] as $websites)
                                        @if($websites['type'] == "ecommerce")
                                            <input type="hidden" name="ecom_siteRow[]" class="form-control" value="{{ $websites['id']}}">
                                            <input type="text" name="ecom_site[]" class="form-control"  value="{{ $websites['url']}}" placeholder="http://www.abc.com">  <br/>
                                        @elseif(count($userModel['websites']) <= 1 && $websites['type'] == null )
                                            <input type="url" required="" name="ecom_site[]" class="form-control" value="{{ $websites['url']}}"  placeholder="http://www.abc.com.my">
                                        @endif
                                    @endforeach
                                @else
                                    <input type="url" required="" name="ecom_site[]" class="form-control" value=""  placeholder="http://www.abc.com.my">
                                @endif
                            </div>
                            <div class="col-xs-1">
                                <a  href="javascript:void(0);" id="addEcom" class="text-green"><i class="fa fa-plus-circle"></i></a>
                            </div>
                        </div>
                        <div id="currEcom"> </div>


                        <div class="col-sm-7">
                            <div class="form-group">
                                <label>Address</label>
                                <input type="text" name="line1" class="form-control validator" value="{{ $userModel['address'][0]['line1']}}" >
                            </div>
                            <div class="form-group">
                                <input type="text" name="line2" class="form-control" value="{{ $userModel['address'][0]['line2']}}">
                            </div>
                            <div class="form-group">
                                <input type="text" name="line3" class="form-control" value="{{ $userModel['address'][0]['line3']}}">
                            </div>
                            <div class="form-group">
                                <input type="text" name="line4" class="form-control" value="{{ $userModel['address'][0]['line4']}}">
                            </div>
                        </div>


                        <div class="col-sm-5">
                            <label>&nbsp;</label>
                            <div class="form-group">
                                <label class="col-sm-5 control-label">Country: </label>
                                <div class="col-sm-7">
                                    {!! Form::select('country', [''=>'Country of Origin']+$cf->getCountry(), $userModel['address'][0]['city_id'], ['class' => 'form-control validator','id' => 'country_id']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-5 control-label">State: </label>
                                <div class="col-sm-7">
                                    @if(isset($userModel['address'][0]['city_id']))
                                     {!! Form::select('state', $cf->getState(),$userModel['address'][0]['city_id'], ['class' => 'form-control']) !!}
                                    @else
                                        <select class="form-control validator" id="states" required></select>

                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-5 control-label">City: </label>
                                <div class="col-sm-7">
                                    @if(isset($userModel['address'][0]['city_id']))
                                        {!! Form::select('city_id', $cf->getCity(), $userModel['address'][0]['city_id'], ['class' => 'form-control']) !!}
                                    @else
                                        <select class="form-control validator" id="cities" name="city_id" required></select>
                                    @endif

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-5 control-label">Postcode /Zip Code</label>
                                <div class="col-sm-7">
                                    <input type="text" name="zip" class="form-control validator" value="{{ $userModel['address'][0]['postcode']}}"><br>
                                </div>

                            </div>
                        </div>
                        <div class="clearfix"> </div>
                        <hr>
                    </div>

                    <div id="shop">
                        <h2>Shop Details</h2>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">O-Shop Name: </label>
                            <div class="col-sm-6">
                                <input type="text" name="shop_name" class="form-control validator" value="{{$userModel['merchant'][0]['oshop_name']}}" placeholder="Input your O-Shop Name"  {{$disabled}}>
                            </div>
                            <div class="clearfix">&nbsp;</div>
                            <label class="col-sm-3 control-label">O-Shop Description: </label>
                            <div class="col-sm-9">
                               <!-- <p class="text-muted">Provide us with a brief description of your business to help us</p> -->
                                {!! $userModel['merchant'][0]['description'] !!}


                            </div>
                            <div class="clearfix">&nbsp;</div>
                            <label class="col-sm-6 control-label">Do you have a license to sell/ or distribute the products/ services? </label>
                            <div class="col-sm-6">
                                {!! Form::select('have_license', ['' => 'Choose Option',
                                '1' => 'Yes', '0' => 'No'],$userModel['merchant'][0]['license'], ['class' => 'form-control'] ) !!}
                            </div>
                            <div class="clearfix">&nbsp;</div>
                            <label class="col-sm-6 control-label">How do you supply Geographically? </label>
                            <div class="col-sm-6">
                                {!! Form::select('supply_method', ['' => 'Choose Option',
                                'klang_valley' => 'Klang Valley', 'peninsula_malaysia' => 'Peninsula Malaysia' , 'east_malaysia'=> 'East Malaysia',
                                'internationally'=>'Internationally'],$userModel['merchant'][0]['coverage'], ['class' => 'form-control'] ) !!}
                            </div>
                            <div class="clearfix">&nbsp;</div>
                            <label class="col-sm-6 control-label">Do you own the brands for the products/services you are selling? </label>
                            <div class="col-sm-6">
                                {!! Form::select('have_brand', ['' => 'Choose Option',
                                '1' => 'Yes', '0' => 'No'],$userModel['merchant'][0]['ownership'], ['class' => 'form-control'] ) !!}
                            </div>
                            <div class="clearfix">&nbsp;</div>
                            <label class="col-sm-6 control-label">What is the category of the products you are selling? </label>
                            <div class="col-sm-6">
                                {!! Form::select('category', $cf->category(), $userModel['merchant'][0]['category_id'], ['class' => 'form-control']) !!}
                            </div>
                            <div class="clearfix">&nbsp;</div>
                            <label class="col-sm-6 control-label">How many products you plan to sell? </label>
                            <div class="col-sm-6">
                               <!-- {!! Form::select('sell_plan', ['' => 'Choose Option',
                                '50' => 'Less than 50', '500' => 'Less than 500'],$userModel['merchant'][0]['planned_sales'], ['class' => 'form-control'] ) !!} -->
                                {!! Form::select('sell_plan', ['' => 'Choose Option',
                                '50' => '<50', '500' => '51-500', '2000' => '501-2000', '5000'=>'>2000'],$userModel['merchant'][0]['planned_sales'], ['class' => 'form-control'] ) !!}
                            </div>
                            <div class="clearfix">&nbsp;</div>
                        </div>
                        <hr>

                        <h2>Brand Details</h2>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">What brand do you sell? </label>
                            <div class="col-sm-6 col-xs-10">

                                @if($isbrand)
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
                                <a  href="javascript:void(0);" id="addBD" class="text-green"><i class="fa fa-plus-circle"></i></a>
                            </div>
                        </div> &nbsp;
                        <div id="brandDetail"> </div>
                    </div>

                    <hr>

                    <div class="bankdetail" id="bank">
                        <h2>Bank Details</h2>
                        <div class="form-group">
                            {!! Form::label('account_name', 'Account Name', array('class' => 'col-sm-2 control-label')) !!}
                            <div class="col-sm-4">
                                {!! Form::text('account_name',$userModel['bank'][0]['account_name1'], array('class' => 'form-control',$disabled))!!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('account_number', 'Account Number', array('class' => 'col-sm-2 control-label')) !!}
                            <div class="col-sm-4">
                                {!! Form::text('account_number', $userModel['bank'][0]['account_number1'], array('class' => 'form-control',$disabled))!!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('bank', 'Bank', array('class' => 'col-sm-2 control-label')) !!}
                            <div class="col-sm-4">
                                {!! Form::text('bank', $userModel['bank'][0]['name'], array('class' => 'form-control',$disabled))!!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('bank_code', 'Bank Code', array('class' => 'col-sm-2 control-label')) !!}
                            <div class="col-sm-4">
                                {!! Form::text('bank_code', $userModel['bank'][0]['code'], array('class' => 'form-control',$disabled))!!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('ibn', 'IBAN', array('class' => 'col-sm-2 control-label')) !!}
                            <div class="col-sm-4">
                                {!! Form::text('ibn', $userModel['bank'][0]['iban'], array('class' => 'form-control',$disabled))!!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('swift', 'SWIFT', array('class' => 'col-sm-2 control-label')) !!}
                            <div class="col-sm-4">
                                {!! Form::text('swift', $userModel['bank'][0]['swift'], array('class' => 'form-control',$disabled))!!}
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div id="remark">
                        <h2>Remarks</h2>
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="form-group">
                                    {!! Form::label('remarks', 'Remarks', array('class' => 'col-sm-2 control-label')) !!}
                                    <div class="col-sm-10">
                                        {!! Form::textarea('remarks', $userModel['merchant'][0]['remarks'], array('class' => 'form-control'))!!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if(isset($mer_doc))
                            @foreach($doc as $Doc)
                                @foreach($mer_doc as $mer_Doc)
                                    @if($mer_Doc->merchant_id == $userModel['merchant'][0]['id'])
                                        @if($mer_Doc->document_id == $Doc->id && $Doc->name == 'remarks')
                                            <div class="col-sm-6 pull-right">
                                                    <div class="inputBtnSection">
                                                        <input id="uploadFileRem" class="disableInputField validator" value="{{ $Doc->path }}" placeholder="Upload Document" {{$disabled}} />
                                                        <label class="fileUpload">
                                                            <input id="uploadBtnRem" name="Remarksupload_attachment[]"  type="file" class="upload" />
                                                            <span class="uploadBtn">Upload </span>
                                                        </label>
                                                    </div>
                                                    <a  href="javascript:void(0);" id="addRem" class="text-green"><i class="fa fa-plus-circle"></i></a>
                                                </div>
                                                <div style="clear:both;"></div>
                                        @endif
                                    @endif
                                @endforeach
                            @endforeach
                        @else
                            <div id="remarksattach" class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Attachment </label>
                                    <div class="col-sm-9 col-xs-12">
                                        <div class="inputBtnSection">
                                            <input id="uploadFileRem" class="disableInputField validator" placeholder="Add New Attachment" />
                                            <label class="fileUpload">
                                                <input id="uploadBtnRem" name="Remarksupload_attachment[]" type="file" class="upload validator" required/>
                                                <span class="uploadBtn">Upload </span>
                                            </label>
                                        </div>
                                        <a  href="javascript:void(0);" id="addRem" class="text-success"><i class="fa fa-plus-circle"></i></a>
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>
                    <div class="clearfix"> </div>
                    <div class="pull-right">

                        {!! Form::hidden('indication', $indication, array( 'class' => 'form-control'))!!}
                    </div>

                    {{--@endforeach--}}

                    {!! Form::close() !!}

                </div>
            </div>
        </div><!--End main cotainer-->
    </section>
<script type="text/javascript">
    $(document).ready(function () {
		$("#registe_rForm :input").prop("disabled", true);
	});
</script>
@stop
