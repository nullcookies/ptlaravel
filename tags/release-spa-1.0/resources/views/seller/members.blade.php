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
<style>
	.storebutton{
		background-color: #FF3333 !important;
	}
	

</style>
<section class="">
  <div class="container">
	<div class="row">
	<div class="col-sm-12">  
	{{-- Tabbed Nav --}}
	<h2>Data Management</h2>
	<div class="panel with-nav-tabs panel-default ">
		<div class="panel-heading">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#customers"
					data-toggle="tab">Customer</a></li>
				<li><a href="#employees" data-toggle="tab">Staff</a></li>
				<li><a href="#merchantOpenchannel" id="merchantOpenchannellink" 
					data-toggle="tab">Dealer</a></li>
				<li><a href="#stationOpenchannel" id="stationOpenchannellink"
					data-toggle="tab">Supplier</a></li>
			</ul>
		</div>
	</div>
	{{--ENDS  --}}
	<div id="dashboard" class="row panel-body " >
		<div class="tab-content top-margin" style="margin-top:-30px">
			<!-- CUSTOMER LIST -->
			<div id="customers" class="tab-pane fade in active">
				<div class="row">
					<div class=" col-sm-6">
						<h3>Customer List</h3>
					</div>
					<div class=" col-sm-6">
						<a class="add_row_c btn btn-info pull-right" style="margin-left: 5px; width: 120px;"
							href="javascript:void(0)">+ Customer</a>&nbsp;
						@if(Auth::user()->hasRole('adm'))
							<a class=" btn btn-danger pull-right" style="margin-left: 5px; width: 120px;"
							href="{{URL::to('/')}}/seller/member/campaign/{{$selluser->id}}"> Campaign</a>&nbsp;
						@else
							<a class=" btn btn-danger pull-right" style="margin-left: 5px; width: 120px;"
							href="{{URL::to('/')}}/seller/member/campaign"> Campaign </a>&nbsp;
						@endif
						<a class="channel_managment btn btn-info pull-right" 
							style="margin-left: 5px; width: 120px; background-color: #948A54 
							!important; border-color: #948A00 !important"
							href="javascript:void(0)">+ Channel</a>&nbsp;
						<a class="segment_managment btn btn-info pull-right"
							style="margin-left: 5px; width: 120px; background-color: #595959 !important; border-color: #696969 !important"
							href="javascript:void(0)">+ Segment</a>&nbsp;							
					</div>
				</div>
				<?php $e=1;?>
				<div class="row">
					<div class=" col-sm-12">
						<table class="table table-bordered"
							id="customer-table" width="100%">
							<thead>
							
							<tr class="bg-black">
								<th class="text-center bsmall">No.</th>
								
								<th class="large text-center" style="width: 130px !important;">Name</th>
								<th class="text-center">Roles</th>
								<th  style="background-color: #31859C;" class="text-center" >Action</th>
								<th class="text-center">Campaign</th>
								<th  style="background-color: green;" class="text-center">Status</th>
								<th class="text-center">Email</th>
								<th class="bsmall text-center">
									<input type='checkbox' class='allsender_c' />
								</th>
								<th class="bsmall text-center">&nbsp;</th>
								<th class="bsmall text-center">&nbsp;</th>
							</tr>
							</thead>
							<tfoot>
								<tr>
									<th colspan=6 ></th>
									<th colspan=4 >										
										@if($campaignexists)
											@if($campaign_tosend->status == 'active')
												<a class="send_email_c btn btn-danger storebutton"
												style="width:100%"
												href="javascript:void(0)">Execute</a>
												<p align="center" class="nocampaign" style="display: none;">Please, create a new campaign</p>
											@else
												@if($campaign_tosend->status == 'pending')
													<p align="center">Please, wait for campaign approval</p>
												@else
													<p align="center">This campaign was suspendend/rejected.</p>
												@endif	
											@endif	
										@else
											<p align="center">Please, create a new campaign</p>
										@endif											
									</th>
								</tr>
							</tfoot>					
							<tbody>
							@foreach($customers as $emps)
								<tr>
									<td class="text-center">{{$e}}</td>
									<td class="text-center"> 
									<?php
									/* Processed note */
									$pfullnote = null;
									$pnote = null;
									$elipsis = "...";
									if($emps->name == "" || is_null($emps->name)){
										$pfullnote = $emps->users_first_name ." ".
										$emps->users_last_name;
									} else {
										$pfullnote = $emps->name;
									}
										
									$pnote = substr($pfullnote,0, MAX_COLUMN_TEXT);

									if (strlen($pfullnote) > MAX_COLUMN_TEXT)
										$pnote = $pnote . $elipsis;
									?> 
									<span title='{{$pfullnote}}' class="customer_name" id="customer_name{{$emps->id}}" rel="{{$emps->id}}">&nbsp;&nbsp;{{$pnote}}&nbsp;&nbsp;</span>	
									<span id="sinputcustomer_name{{$emps->id}}" style="display: none;">
										<input type="text" value="{{$pfullnote}}" rel="{{$emps->id}}" class="customer_name_input" id="inputcustomer_name{{$emps->id}}" />
									</span>	
									</td>
									<?php
									$sysrole = "";
									$pursel = "";
									$memsel = "";
									$ebusel = "";
									$sysquery = DB::table('roles')->
										join('role_users','roles.id','=',
											'role_users.role_id')->
										where('role_users.user_id',$emps->user_id)->
										whereIn('roles.id',[15,18,20])->
										first();

									if(!is_null($sysquery)){
										if($sysquery->name == 'purchaser'){
											$pursel = "selected";
										}
										if($sysquery->name == 'member'){
											$memsel = "selected";
										}
										if($sysquery->name == 'emp_benefit_user'){
											$ebusel = "selected";
										}
										$sysrole = $sysquery->description;
									}
									?>
									<td class="text-center">
										@if($emps->member_status == 'not exists')
										@else
											<a href="javascript:void(0)" class="customer_role" rel="{{$emps->user_id}}">Roles</a>
										@endif
									</td>
									<td class="text-center" >				
										<a  class="" data-toggle="modal" data-target="#myModal">
											Details
										</a>
									</td>
									<td class="text-center">
										<a href="javascript:void(0)" class="customer_campaign" rel="{{$emps->id}}">{{$emps->countcamp}}</a>
									</td>									
									<td class="text-center">
											{{--{{ucfirst($emps->member_status)}}--}}
											<a  class="" data-toggle="modal" data-target="#activeModal">
											Active
										</a>
									</td>
									<td class="text-center">{{$emps->email}}</td>
									<td class="text-center">
										<input type='checkbox' class='sender_c'
										rel='{{$emps->email}}' /></td>
									<td class="text-center">
										<a  href="javascript:void(0);" class="text-danger delete_member_c" rel='{{$emps->email}}'><i class="fa fa-minus-circle fa-2x"></i></a>
									</td>	
									<td class="text-center"><span id="segments{{$emps->id}}">{{$emps->segments}}</span></td>
								</tr>
							<?php $e++;?>
							@endforeach
							</tbody>
						</table>
						<input type="hidden" value="{{$e}}" id="nume_c" /> 

					</div>
				</div> 				
			</div>
			<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style=" font-family: sans-serif;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" style="    font-family: sans-serif;" id="myModalLabel">User Name</h4>
      </div>
      <div class="modal-body">
      <form action="post" id="action_form_data" >
      <div> <label></label></div>
       <div class="col-md-12"> <label class="col-md-6">  Customer ID</label> </div>
       <div class="col-md-12"> <label class="col-md-6"> Segment</label> </div>
       <div class="col-md-12"> <label class="col-md-6"> Roles</label> </div>
       <div class="col-md-12"> <label class="col-md-6"> Action</label> </div>
       <div class="col-md-12"> <label class="col-md-6"> Stage</label> <lable class="col-md-6"><input type="text" name="stage"/></lable></div>
   		 <div class="col-md-12"> <label class="col-md-6"> Remark</label> <lable class="col-md-6"><textarea type="text" name="remark"></textarea></lable></div>
         <div class="clearfix" ></div> 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" onclick="return action_form('action_form_data');" class="btn btn-primary">Save changes</button>
      </div>
    </form>
    </div>
  </div>
</div>
<style>
.text_box_css{
    margin: 0px 110px;
    }
 .form-control, .btn {
    margin: 5px;
    height: 30px;
}
</style>
<div class="modal fade" id="activeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="    font-family: sans-serif;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" style="    font-family: sans-serif;" id="myModalLabel"></h4>
      </div>
      <form action="post" id="status_form_data" >
      <div class="modal-body">
      <div class="col-md-12"> <label class="col-md-6"> Company</label> <lable class="col-md-6">
      		 <input type="text" class="form-control"  name="company_name"/></lable>
      </lable></div>
       <div class="col-md-12"> <label class="col-md-6">Brand</label><lable class="col-md-6">
       	<input type="text" class="form-control" name="brand"/>
       </lable></div>
       <div class="col-md-12"> <label class="col-md-6">Category</label>
        <lable class="col-md-6">
         {!! Form::select('category_id',$categorys,null,['class' => 'form-control','id' =>'category']) !!}
        </lable>
        </div>
       <div class="col-md-12"> <label class="col-md-6"> Sub</label> <lable class="col-md-6">
       		<input type="text" class="form-control" name="subcat_level_1"/></lable>
       </div>
       <div class="col-md-12"> <label class="col-md-6">No products </label> <lable class="col-md-6">
      		 <input type="text" class="form-control" name="no_products"/>
       </lable></div>
       <div class="col-md-12"> <label class="col-md-6">No Employee</label> <lable class="col-md-6">
       		<input type="text" class="form-control" name="no_employees"/>
       </lable></div>
       <div class="col-md-12"> <label class="col-md-6">Annual Revenue</label> <lable class="col-md-6">
       		<input type="text" class="form-control" name="annual_revenue"/>
       </lable></div>
      <div class="clearfix" ></div> 
       <div class="col-md-12" style="margin-top:20px;"> <label class="col-md-6">Name</label> <lable class="col-md-6">
       	<input type="text" class="form-control" name="first_name"/>
       </lable></div>
       {{--<div class="col-md-12"> <label class="col-md-6">Position</label> <lable class="col-md-6">
       	<input type="text" class="form-control" name="position"/>
       </lable></div>--}}
       <div class="col-md-12"> <label class="col-md-6">Mobile</label> <lable class="col-md-6">
      	 <input type="text" class="form-control" name="mobile_no"/>
       </lable></div>
       <div class="col-md-12"> <label class="col-md-6">Office Number</label> <lable class="col-md-6">
       <input type="text" class="form-control" name="office_number"/></lable></div>
       <div class="clearfix" ></div> 
       <div class="col-md-12" > <label class="col-md-6">No of station</label> <lable class="col-md-6">
       		<input type="text" class="form-control" name="no_stations"/>
       </lable></div>
       <div class="col-md-12"> <label class="col-md-6">Website</label> <lable class="col-md-6">
       		<input type="text" class="form-control" name="website"/>
       </lable></div>
       <div class="col-md-12"> <label class="col-md-6">Relationship</label> <lable class="col-md-6">
       		<input type="text" class="form-control" name="relationship"/>
       </lable></div>
     	
       {{--<div class="col-md-12"> <label class="col-md-6">Own Delivery</label> <lable class="col-md-6"><input type="text" name="own_delivery"/></lable></div>--}}
      <div class="clearfix" style="margin-top:10px;"></div> 
        <div class="col-md-12" style="margin-top:20px;"> <label class="col-md-6">Subscription</label> <lable class="col-md-6">
        		<input type="text" class="form-control" name="subscription_fee"/>
        </lable></div>
         <div class="col-md-12"> <label class="col-md-6">Commision %</label> <lable class="col-md-6">
         <input type="text" class="form-control" name="commission_percent"/></lable></div>
          <div class="col-md-12"> <label class="col-md-6">Admin Fee</label> <lable class="col-md-6">
          <input type="text" class="form-control" name="admin_fee"/></lable></div>
       <div class="clearfix" style="margin-top:10px;"></div> 
           <div class="col-md-12" style="margin-top:20px;"> 
           	<label class="col-md-6">Office address1</label>
            <lable class="col-md-6">
            		 {!! Form::select('address_line1',$line1,null,['class' => 'form-control','id' =>'category']) !!}
            </lable>
        </div>
        <div class="clearfix" style="margin-top:10px;"></div> 
           <div class="col-md-12" style="margin-top:20px;"> 
           	<label class="col-md-6">Office address2</label>
            <lable class="col-md-6">
            		{!! Form::select('address_line2',$line2,null,['class' => 'form-control','id' =>'category']) !!}
            </lable>
        </div>
        <div class="clearfix" style="margin-top:10px;"></div> 
           <div class="col-md-12" style="margin-top:20px;"> 
           	<label class="col-md-6">Office address3</label>
            <lable class="col-md-6">
            		{!! Form::select('address_line3',$line3,null,['class' => 'form-control','id' =>'category']) !!}
            </lable>
        </div>
       <div class="col-md-12" > <label class="col-md-6">Country</label> <lable class="col-md-6">
       <input value="Malaysia" readonly="readonly" class="form-control" id="country_id" name="" type="text" aria-invalid="false">
        </lable></div>
         <div class="col-md-12"> <label class="col-md-6">State</label> <lable class="col-md-6">
         {!! Form::select('state',$states,null,['class' => 'form-control','id' =>'states']) !!}
         
         </lable></div>
          <div class="col-md-12"> <label class="col-md-6">City</label> <lable class="col-md-6">
          {!! Form::select('city',['0' => 'Choose Option' ]+$citys,null, ['class' => 'form-control','required','id'=>'cities']) !!}
          </lable></div>
           {{--<div class="col-md-12"> <label class="col-md-6">Area
           
           </label> <lable class="col-md-6">
            {!! Form::select('area_id', ['0' => 'Choose Option' ],null, ['class' => 'form-control','id'=>'areas']) !!}
           </lable></div>--}}
           {{-- <div class="col-md-12"> <label class="col-md-6">MC ID</label> <lable class="col-md-6">MC Name</lable></div>
           <div class="clearfix" style="margin-top:10px;"></div> --}}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" onclick="status_form();" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>

			<!-- MEMBER LIST -->
			<div id="stationOpenchannel" class="tab-pane fade">					
				<div class="table-responsive" style="margin-bottom: 28px;">
					{{--{!! Breadcrumbs::render('station.open-channel') !!}--}}
						<h3 class="testo">Station OpenChannel: Supplier</h3>
						<table class="table table-bordered" style="width:1820px ;" id="supplier-open-channel">
							<thead style="background-color: #101010; color: white;">
							<tr>
								<td class="text-center" colspan="3">Merchant/Supplier</td>
								<td class="text-center" colspan="3">Sales</td>
								<td class="text-center" colspan="3">Inventory</td>
								<td class="text-center" colspan="1">Geographical</td>
								@if(Auth::user()->hasRole('sto'))
									<td class="text-center medium" style="background-color: #F29FD7">Term</td>
								@endif
							</tr>
							<tr>
								<td class='text-center no-sort bsmall'>No</td>
								<td class='text-center bmedium'>Merchant&nbsp;ID</td>
								<td class='text-center blarge'>Name</td>
								<td class='text-center bmedium'>Since</td>
								<td class='text-center bmedium'>YTD</td>
								<td class='text-center bmedium'>MTD</td>
								<td class='text-center bmedium'>Items</td>
								<td class='text-center bmedium'>High>30%</td>
								<td class='text-center bmedium'>Low<30%</td>
								<td class='text-center bmedium'>State</td>
								@if(Auth::user()->hasRole('sto'))
									<td class="text-center medium" style="background-color: #F29FD7">&nbsp;</td>
								@endif
							</tr>
							</thead>
							<tbody>
							<?php $num = 1; ?>
							@foreach($suppliers as $supplier)
									<tr>
										<td align="center">{{ $num }}</td>
										<td align="center">
											{{ IdController::nM($supplier->merchantid) }}	
										</td>
										<td>@if(Auth::user()->hasRole('adm')) <a href="javascript:void(0)" class="station-termsmerchant" data-id="{{ $supplier->supplier_user_id}}"> @endif {{ $supplier->name }} @if(Auth::user()->hasRole('adm'))</a> @endif </td>
										<td align="right"> {{$currencyCode}} {{number_format($supplier->since_sum/100 , 2) }}</td>
										<td align="right">{{$currencyCode}} {{number_format($supplier->YTD/100 , 2) }}</td>
										<td align="right">{{$currencyCode}} {{number_format($supplier->MTD/100 , 2) }}</td>
										<td align="center"><a href="{{route('inventoryAll', ['merchantid' => $supplier->merchantid,'stationid'=>$station_id])}}" target="_blank" id="{{$station_id}}">{{ \App\Models\POrder::getItemsOfmStation($station_id, $supplier->merchantid) }}</a></td>
										<td align="center"><a href="{{route('inventoryHigh', ['merchantid' => $supplier->merchantid,'stationid'=>$station_id])}}" target="_blank" id="{{$station_id}}">{{ \App\Models\POrder::getmHighItems($station_id, $supplier->merchantid) }}</a></td>
										<td align="center"><a href="{{route('inventoryLow', ['merchantid' => $supplier->merchantid,'stationid'=>$station_id])}}" target="_blank" id="{{$station_id}}">{{ \App\Models\POrder::getmLowItems($station_id, $supplier->merchantid) }}</a></td>
										<?php
											$addretxt = $supplier->line1; 
											if($supplier->line2 != "" && !is_null($supplier->line2) && sizeof($supplier->line2) > 0){
												$addretxt .= $supplier->line2;
											}
											$addretxt .= "," . $supplier->cityname . "," . $supplier->statename . ", Malaysia";
										?>
										<td align="center"><a href="javascript:void(0)" class="openchannel_addressmerchant" rel-address="{{$addretxt}}" country="Malaysia" state="{{ $supplier->statename }}" city="{{ $supplier->cityname }}" marea="{{ $supplier->areaname }}">{{ $supplier->statename }}</a></td>
										@if(Auth::user()->hasRole('sto'))
											<td align="center"><a href="javascript:void(0)" class="station-termsmerchant" data-id="{{ $supplier->supplier_user_id}}">Term</a></td>
										@endif
									</tr>
									<?php $num++; ?>
							@endforeach
							</tbody>
					</table>
				</div>


				<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="merchantModalLabel">
					<div class="modal-dialog" style="width: 75%">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title">Statement C</h4>
							</div>
							<div class="table-responsive">
								<div class="panel-group" id="accordion">
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a id="modal-Tittle1" data-toggle="collapse" data-parent="#accordion" href="#collapse1"></a>
											</h4>
										</div>
										<div id="collapse1" class="panel-collapse collapse">
											<div class="modal-body" style="padding: 15px;">
												<div class="table-responsive">
													<table id="myTable1" class="table table-bordered myTable"></table>
												</div>
											</div>
										</div>
									</div>
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a id="modal-Tittle2" data-toggle="collapse" data-parent="#accordion" href="#collapse2"></a>
											</h4>
										</div>
										<div id="collapse2" class="panel-collapse collapse">
											<div class="modal-body" style="padding: 15px;">
												<div class="table-responsive">
													<table id="myTable2" class="table table-bordered myTable"></table>
												</div>
											</div>
										</div>
									</div>
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a id="modal-Tittle3" data-toggle="collapse" data-parent="#accordion" href="#collapse3"></a>
											</h4>
										</div>
										<div id="collapse3" class="panel-collapse collapse in">
											<div class="modal-body" style="padding: 15px;">
												<div class="table-responsive">
													<table id="myTable3" class="table table-bordered myTable"></table>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							</div>
						</div><!-- /.modal-content -->
					</div><!-- /.modal-dialog -->
				</div><!-- /.modal -->


			<!-- Modal -->
			<div class="modal fade" id="myModal2" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog" role="document" style="width: 50%">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
										aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="myModalLabel">Statement D</h4>
						</div>
						<div class="modal-body">
							<h3 id="modal-Tittle"></h3>
							<div class="table-responsive">
								<table id="myTable4" style="width: 100%" class="table table-bordered myTable"></table>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						</div>
						</form>

					</div>
				</div>
			</div>
			
			<div id="termsModal" class="modal fade" role="dialog">
			  <div class="modal-dialog" style="width:600px;">

				<!-- Modal content-->
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Terms (termsModal)</h4>
				  </div>
				  <div class="modal-body" style="height: 170px !important;">
					<div class="form-group">
						<label class="col-sm-4">Credit Term</label>
						<div class="col-sm-6">
							<input type="text" id="term_days"
								value="" class="form-control"
								placeholder="Credit Term" /></div>
						<div class="col-sm-2">days</div>
					</div>
					<div class="form-group" >
						<label class="col-sm-4"
							style="margin-top: 15px;">Credit Limit (MYR)</label>
						<div class="col-sm-6" style="margin-top: 15px;">
							<input type="text" id="term_limit" value=""
								class="form-control"
								placeholder="Credit Limit (MYR)" /></div>
						<div class="col-sm-2" style="margin-top: 15px;">
							&nbsp;</div>
					</div>
					<input type="hidden" id="term_station_id" value="0" />
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default"
						data-dismiss="modal">Close</button>
				  </div>
				</div>
			  </div>
			</div>

			<input type="hidden" id="selluser" value="{{$selluser->id}}" />

			<?php $ostation_id = DB::table('station')->
				where('user_id',$selluser->id)->first()->id; ?>
			<input type="hidden" id="ostation_id" value="{{$ostation_id}}" />
					<div id="addressModal" class="modal fade" role="dialog">
					  <div class="modal-dialog" style="width:800px;">

						<!-- Modal content-->
						<div class="modal-content">
						  <div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Address</h4>
						  </div>
						  <div class="modal-body">
								<table id="myTable" class="table table-bordered myTable">
									<tr style="background-color: black; color: white;">
										<th>Country</th>
										<th>State</th>
										<th>City</th>
										
										<th>Area</th>
									</tr>
									<tr>
										<td id="modalcountry"></td>
										<td id="modalstate"></td>
										<td id="modalcity"></td>
										
										<td id="modalarea"></td>						
									</tr>
								</table>
						  </div>
						  <div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						  </div>
						</div>

					  </div>
					</div>			

				<script src="{{url('js/jquery.dataTables.min.js')}}"></script>
				<script src="{{url('jqgrid/jquery.jqGrid.min.js')}}"></script>
<script>
function action_form() {
	    var form_data = $("#action_form_data").serialize();
	    $.ajax({
	        url: JS_BASE_URL + "/action_form_data",
	        type: "POST",
	        data: form_data,
			success: function (response)
			{
				
				
			}
	    });
	}
function status_form() {
   var form_data = $("#status_form_data").serialize();
  // var form_data = '';
    $.ajax({
        url: JS_BASE_URL + "/status_form_data",
        type: "POST",
        data: form_data,
		success: function (response)
		{
			
			
		}
    });
}
</script>
				<script>
					$(document).ready(function(){
					$("#term_days").number(true,0,".","");
					$("#term_limit").number(true,2,".","");
					$('.station-termsmerchant').click(function(){
						console.log("HOLAAAA");
						var selluser = $(this).attr('data-id');
						var ostation_id = $("#ostation_id").val();
						$.ajax({
							url: JS_BASE_URL + "/stationterm",
							type:'GET',
							data: {station_id: ostation_id, selluser: selluser},
							success:function (r) {
								$("#term_limit").val(r.term_limit/100);
								$("#term_days").val(r.term_days);
							//	$("#term_station_id").val(ostation_id);
								$("#termsModal").modal('show');
							}
						});			
					});		
					
						$(document).delegate( '.openchannel_addressmerchant', "click",function (event) {
							var country = $(this).attr('country');
							var state = $(this).attr('state');
							var city = $(this).attr('city');
							var area = $(this).attr('marea');
							$("#modalcountry").html(country);
							$("#modalcity").html(city);
							$("#modalstate").html(state);
							$("#modalarea").html(area);
							$("#addressModal").modal('show');
						});		
					
						function pad (str, max) {
							str = str.toString();
							return str.length < max ? pad("0" + str, max) : str;
						}

						var table_modal;

				$(".prid").click(function () {


					$('#modal-Tittle').html("");

					if(table_modal){
						table_modal.destroy();
						$('#myTable4').empty();
					}

					_this = $(this);

					var id_merchant= _this.attr('id');
					var pname= $('#pname' + id_merchant).val();
					var url = '/admin/master/getmerchantproduct/'+id_merchant;

					var urlbase = $('meta[name="base_url"]').attr('content');

					$.ajax({
						type: "GET",
						url: url,
						async:false,
						dataType: 'json',
						success: function (data) {
							//	console.log(data);

							$('#myTable4').append('<tbody>');
							for(i=0;i<data.length;i++){

								var pr = "";
									pr = '[' + pad(data[i].id,10) + ']';

								var urlid = data[i].id;

								$('#myTable4').append('<tr><td align="center">'+ (i+1) +'</td><td align="center"><a href="'+urlbase+'/productconsumer/'+urlid+'">'+ pr +'</a></td><td>'+data[i].name+'</td><td align="center">'+data[i].available+'</td></tr>');
							}
							$('#myTable4').append('</tbody>');


						},
						error: function (error) {
							console.log(error);
						}
					});

					$('#modal-Tittle').append("Merchant ID: "+id_merchant);
					$('#myTable4').append('<thead style="background-color: #604a7b; color: #fff;"><th class="no-sort">No</th><th>Product ID</th><th>Item</th><th>Left</th></thead>');


					table_modal = $('#myTable4').DataTable({
						'scrollX':false,
						"order": [],
						"columnDefs": [
						{ "targets": 'no-sort', "orderable": false},
						{ "targets": "large", "width": "120px" },
						{ "targets": "xlarge", "width": "300px" }],
						"fixedColumns":  true
					});

					$("#myModal2").modal("show");
				});

						var sutable = $('#supplier-open-channel').DataTable({
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
						
						

						var table_modal;
						var table_modal2;
						var table_modal3;

						$('#stationOpenchannellink').on('click', function () {
							setTimeout(function(){ 
								//alert("Hello"); 
								console.log("WTF0");
								sutable.columns.adjust();
							}, 500);						
						});
						
						$('.station-name').on('click', function () {

							if(table_modal){
								table_modal.destroy();
								$('#myTable1').empty();
								$('#modal-Tittle1').empty();
							}
							if(table_modal2){
								table_modal2.destroy();
								$('#myTable2').empty();
								$('#modal-Tittle2').empty();
							}
							if(table_modal3){
								table_modal3.destroy();
								$('#myTable3').empty();
								$('#modal-Tittle3').empty();
							}

							var id = $(this).attr("value");
							var year=new Date().getFullYear();
							var year1=year;
							$('#modal-Tittle3').append(year1);
							--year;
							var year2=year;
							$('#modal-Tittle2').append(year2);
							--year;
							var year3=year;
							$('#modal-Tittle1').append(year3);

							var my_url='/station/ochannel-supplier/statement/'+id;
							var method = 'GET';
							$.ajax({
								type: method,
								url: my_url,
								dataType: 'json',
								success: function (data) {
									$('#myTable1').append("<thead style='background-color: #FF0000; color: #fff;'><th colspan='3'>Product</th> <th colspan='2'>In</th><th colspan='2'>Out</th><tr><th>No</th><th>Product ID</th><th>Item</th><th>Average Price</th><th>Qty</th><th>Average Price</th><th>Qty</th></tr></thead>");
									$('#myTable1').append('<tbody>');
									$('#myTable2').append("<thead style='background-color: #FF0000; color: #fff;'><th colspan='3'>Product</th> <th colspan='2'>In</th><th colspan='2'>Out</th><tr><th>No</th><th>Product ID</th><th>Item</th><th>Average Price</th><th>Qty</th><th>Average Price</th><th>Qty</th></tr></thead>");
									$('#myTable2').append('<tbody>');
									$('#myTable3').append("<thead style='background-color: #FF0000; color: #fff;'><th colspan='3'>Product</th> <th colspan='2'>In</th><th colspan='2'>Out</th><tr><th>No</th><th>Product ID</th><th>Item</th><th>Average Price</th><th>Qty</th><th>Average Price</th><th>Qty</th></tr></thead>");
									$('#myTable3').append('<tbody>');
									var h=1;
									var j=1;
									var k=1;
									for (var i=0; i<data.length; i++) {
										var array_fecha = data[i].date.split("-");
										var ano = parseInt(array_fecha[0]);
										console.log(year);
										if(year3==ano){
											if(data[i].B!=0) {
												var average = data[i].A/data[i].B;
											}else{
												average=0;
											}
											if(data[i].Y!=0) {
												var averageout = data[i].X / data[i].Y;
											}else{
												averageout=0;
											}
											$('#myTable1').append("<tr><td>"+h+"</td><td align='center'>["+pad(data[i].id,10)+"]</td><td>"+data[i].name+"</td><td align='center'>"+average.toFixed(2)+"</td><td align='center'>"+data[i].B+"</td><td align='center'>"+averageout.toFixed(2)+"</td><td align='center'>"+data[i].Y+"</td></tr>");
											h++;
										}
										if(year2==ano){
											if(data[i].B!=0) {
												var average = data[i].A/data[i].B;
											}else{
												average=0;
											}
											if(data[i].Y!=0) {
												var averageout = data[i].X / data[i].Y;
											}else{
												averageout=0;
											}
											$('#myTable2').append("<tr><td>"+j+"</td><td align='center'>["+pad(data[i].id,10)+"]</td><td>"+data[i].name+"</td><td align='center'>"+average.toFixed(2)+"</td><td align='center'>"+data[i].B+"</td><td align='center'>"+averageout.toFixed(2)+"</td><td align='center'>"+data[i].Y+"</td></tr>");
											j++;
										}
										if(year1==ano){
											if(data[i].B!=0) {
												var average = data[i].A/data[i].B;
											}else{
												average=0;
											}
											if(data[i].Y!=0) {
												var averageout = data[i].X / data[i].Y;
											}else{
												averageout=0;
											}
											$('#myTable3').append("<tr><td>"+k+"</td><td align='center'>["+pad(data[i].id,10)+"]</td><td>"+data[i].name+"</td><td align='center'>"+average.toFixed(2)+"</td><td align='center'>"+data[i].B+"</td><td align='center'>"+averageout.toFixed(2)+"</td><td align='center'>"+data[i].Y+"</td></tr>");
											k++;
										}
									}

									$('#myTable1').append('</tbody>');
									$('#myTable2').append('</tbody>');
									$('#myTable3').append('</tbody>');

									table_modal = $('#myTable1').DataTable({
										'scrolly':false,
										'autoWidth':false,
										"order": [],
										"iDisplayLength": 10,
										"columns": [
											{ "width": "20px", "orderable": false },
											{ "width": "65px" },
											{ "width": "105px" },
											{ "width": "55px" },
											{ "width": "20px" },
											{ "width": "55px" },
											{ "width": "20px" }
										]
									});

									table_modal2 = $('#myTable2').DataTable({
										'scrolly':false,
										'autoWidth':false,
										"order": [],
										"iDisplayLength": 10,
										"columns": [
											{ "width": "20px", "orderable": false },
											{ "width": "65px" },
											{ "width": "105px" },
											{ "width": "55px" },
											{ "width": "20px"},
											{ "width": "55px"},
											{ "width": "20px"}

										]
									});

									table_modal3 = $('#myTable3').DataTable({
										'autoWidth':false,
										"order": [],
										"iDisplayLength": 10,
										"columns": [
											{ "width": "20px", "orderable": false },
											{ "width": "65px" },
											{ "width": "105px" },
											{ "width": "55px" },
											{ "width": "20px" },
											{ "width": "55px" },
											{ "width": "20px" }
										]
									});

									$("#myModal").modal("show");
								},
								error: function (error) {
									console.log( error);
								}
							});
						});
					});

				</script>				
			</div>
			<div id="merchantOpenchannel" class="tab-pane fade">
				<div class="table-responsive" style="margin-bottom: 28px;">
					<h3>Merchant OpenChannel: Dealer</h3>
							<table class="table table-bordered" cellspacing="0" id="merchant-open-channel" style="width:1820px !important;">
								<thead style="background-color: #db4249; color: white;">
								<tr>
									<td class="text-center" colspan="3">Station/Dealer</td>
									@if(Auth::user()->hasRole('adm'))
										<td class="text-center" colspan="3">Sales</td>
									@endif
									<td class="text-center" colspan="3">Inventory</td>
									<td class="text-center" colspan="1">Connection</td>
									<td class="text-center" colspan="1">Geographical</td>
									@if(Auth::user()->hasRole('mer'))
										<td class="text-center medium" style="background-color: #F29FD7">Term</td>
									@endif
								</tr>
								<tr style="background-color: #db4249; color: white;">
									<td class="text-center bsmall no-sort">No.</td>
									<td class="text-center large">Station&nbsp;ID</td>
									<td class="text-center blarge">Name</td>
									@if(Auth::user()->hasRole('adm'))
										<td class="text-center medium">Since</td>
										<td class="text-center medium">YTD</td>
										<td class="text-center medium">MTD</td>
									@endif
									<td class="text-center bsmall">Item</td>
									<td class="text-center bsmall">High>30%</td>
									<td class="text-center bsmall">Low<30%</td>
									<td class="text-center medium">Distributor</td>
									<td class="text-center large">State</td>
									@if(Auth::user()->hasRole('mer'))
										<td class="text-center medium" style="background-color: #F29FD7">&nbsp;</td>
									@endif
								</tr>
								</thead>
								<tbody>
								<?php $num = 1; ?>
								@foreach($stations as $station)
								<tr>
									<td align="center">{{ $num }}</td>
									<td align="center">
										@if(Auth::user()->hasRole('adm'))
											<a href="javascript:void(0)" class="view-station-modal" data-id="{{ $station['id']}}">
										@endif
										 {{IdController::nS($station['id'])}}
										 @if(Auth::user()->hasRole('adm'))
											 </a>
										@endif
									</td>
									<td align="left">@if(Auth::user()->hasRole('adm'))<a href="javascript:void(0)" class="station-terms" data-id="{{ $station['id']}}">@endif{{ $station['station_name'] }}@if(Auth::user()->hasRole('adm'))</a>@endif</td>
									@if(Auth::user()->hasRole('adm'))
										<td align="right">MYR {{ number_format($station['since_sum'],2,".","") }}</td>
										<td align="right">MYR {{ number_format($station['YTD'],2,".","") }}</td>
										<td align="right">MYR {{ number_format($station['MTD'],2,".","") }}</td>
									@endif
									<td align="center"><a href="{{route('inventoryAll', ['merchantid' => $station['merchantid'],'stationid'=>$station['id']])}}" target="_blank" id="{{$station['id']}}">{{ \App\Models\POrder::getItemsOfmStation($station['id'], $station['merchantid']) }}</a></td>
									<td align="center"><a href="{{route('inventoryHigh', ['merchantid' => $station['merchantid'],'stationid'=>$station['id']])}}" target="_blank" id="{{$station['id']}}">{{ \App\Models\POrder::getmHighItems($station['id'], $station['merchantid']) }}</a></td>
									<td align="center"><a href="{{route('inventoryLow', ['merchantid' => $station['merchantid'],'stationid'=>$station['id']])}}" target="_blank" id="{{$station['id']}}">{{ \App\Models\POrder::getmLowItems($station['id'], $station['merchantid']) }}</a></td>
									<td align="center">{{ \App\Models\POrder::getStationDistributorType($station['user_id']) }}</td>
										<?php
											$addretxt = $station['line1']; 
											if($station['line2'] != "" && !is_null($station['line2']) && sizeof($station['line2']) > 0){
												$addretxt .= $station['line2'];
											}
											$addretxt .= "," . $station['cityname'] . "," . $station['statename'] . ", Malaysia";
										?>
										<td align="center"><a href="javascript:void(0)" class="openchannel_address" rel-address="{{$addretxt}}" country="Malaysia" state="{{ $station['statename'] }}" city="{{ $station['cityname'] }}" marea="{{ $station['areaname'] }}">{{ $station['statename'] }}</a></td>
									@if(Auth::user()->hasRole('mer'))
										<td align="center"><a href="javascript:void(0)" class="station-terms" data-id="{{ $station['id']}}">Term</a></td>
									@endif
								</tr>
								<?php $num++; ?>
								@endforeach
								</tbody>
							</table>
							</div>
				</div>

				<div id="termsModalstation" class="modal fade" role="dialog">
				  <div class="modal-dialog" style="width:600px;">

					<!-- Modal content-->
					<div class="modal-content">
					  <div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Terms</h4>
					  </div>
					  <div class="modal-body" style="height: 170px !important;">
						<div class="form-group">
							<label class="col-sm-4">Credit Term</label>
							<div class="col-sm-6">
							<input type="text" id="term_days1" value=""
							class="form-control" placeholder="Credit Term" /></div>
							<div class="col-sm-2">days</div>
						</div>
						<div class="form-group" >
							<label class="col-sm-4"
							style="margin-top: 15px;">
							Credit Limit (MYR)</label>
							<div class="col-sm-6" style="margin-top: 15px;">
							<input type="text" id="term_limit1" value=""
								class="form-control"
								placeholder="Credit Limit (MYR)" /></div>
							<div class="col-sm-2" style="margin-top: 15px;">&nbsp;</div>
						</div>
						<br><br>
						<div class="form-group">
							<div class="col-sm-4">&nbsp;</div>
							<div class="col-sm-4 text-center">
							<a href="javascript:void(0);"
								style="background-color: #27a98a !important; border-color: #27a98a !important; margin-top: 15px;"
								class="btn btn-primary btn-success"
								id="saveTerms">&nbsp;&nbsp;&nbsp;Save&nbsp;&nbsp;&nbsp;</a></div>
							<div class="col-sm-4">&nbsp;</div>
						</div>
						<br><br>
						<input type="hidden" id="term_station_id" value="0" />
					  </div>
					  <div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					  </div>
					</div>

				  </div>
				</div>

						<input type="hidden" id="selluser" value="{{$selluser->id}}" />
						<div id="addressModalstation" class="modal fade" role="dialog">
						  <div class="modal-dialog" style="width:800px;">

							<!-- Modal content-->
							<div class="modal-content">
							  <div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">Address</h4>
							  </div>
							  <div class="modal-body">
									<table id="myTable" class="table table-bordered myTable">
										<tr style="background-color: #db4249; color: white;">
											<th>Country</th>
											<th>State</th>
											<th>City</th>
											
											<th>Area</th>
										</tr>
										<tr>
											<td id="modalcountrystation"></td>
											<td id="modalstatestation"></td>
											<td id="modalcitystation"></td>
											<td id="modalareastation"></td>						
										</tr>
									</table>
							  </div>
							  <div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							  </div>
							</div>

					</div>

					<script>
						$(document).ready(function(){
							$("#term_days1").number(true,0,".","");
							$("#term_limit1").number(true,2,".","");
							$(document).delegate( '.openchannel_address', "click",function (event) {
								var country = $(this).attr('country');
								var state = $(this).attr('state');
								var city = $(this).attr('city');
								var area = $(this).attr('marea');
								$("#modalcountrystation").html(country);
								$("#modalcitystation").html(city);
								$("#modalstatestation").html(state);
								$("#modalareastation").html(area);
								$("#addressModalstation").modal('show');
							});		
						
						$('#saveTerms').click(function(){
							var selluser = $("#selluser").val();
							var station_id = $("#term_station_id").val();
							var term_limit = $("#term_limit1").val();
							var term_days = $("#term_days1").val();

							console.log('**********************************');
							console.log('selluser='+selluser);
							console.log('station_id='+station_id);
							console.log('term_days='+term_days);
							console.log('term_limit='+term_limit);

							$("#saveTerms").html("Saving...");
							if(term_limit == "" ||
							   term_days == ""  ||
							   parseInt(term_limit) == 0 ||
							   parseInt(term_days) == 0){
								toastr.warning("Plase assign valid values to credit term and limit!");
							} else {
								$.ajax({
									type: "POST",
									data: {
										selluser: selluser,
										station_id: station_id,
										term_limit: term_limit,
										term_days: term_days},
									url: "/terms/create",
									dataType: 'json',
									success: function (data) {
										toastr.info("Terms Successfully Created!");
										$("#termsModal").modal('toggle');
										$("#saveTerms").html("&nbsp;&nbsp;&nbsp;Save&nbsp;&nbsp;&nbsp;");
										//obj.html("Send");
									},
									error: function (error) {
										toastr.error("An unexpected error ocurred");
									}

								});				
							}
						})
						
						$('.station-terms').click(function(){
							console.log("CHAOOO");
							var station_id = $(this).attr('data-id');
							var selluser = $("#selluser").val();

							console.log('++++++++++++++++++++++++++++++++++');
							console.log('station_id='+station_id);
							console.log('selluser='+selluser);

							$.ajax({
								url: JS_BASE_URL + "/stationterm",
								type:'GET',
								data: {
									station_id: station_id,
									selluser: selluser
								},
								success:function (r) {

									console.log('term_limit='+r.term_limit);
									console.log('term_days='+r.term_days);

									$("#term_limit1").val(r.term_limit/100);
									$("#term_days1").val(r.term_days);
									$("#term_station_id").val(station_id);
									$("#termsModalstation").modal('show');
								}
							});			

							
						});
						
						$('.view-station-modal').click(function(){

							var station_id=$(this).attr('data-id');
							var check_url=JS_BASE_URL+"/admin/popup/lx/check/station/"+station_id;
							$.ajax({
								url:check_url,
								type:'GET',
								success:function (r) {
									if (r.status=="success") {
									var url=JS_BASE_URL+"/admin/popup/station/"+station_id;
									var w=window.open(url,"_blank");
									w.focus();
									}
									if (r.status=="failure") {
										var msg="<div class='alert alert-danger'>"+r.long_message+"</div>";
										$('#station-error-messages').html(msg);
									}
								}
							});


						});

						var mertable = $('#merchant-open-channel').DataTable({
							'bScrollCollapse': true,
							'scrollX':true,
							'autoWidth':false,
							"order": [],
							"columnDefs": [
								{"targets": 'no-sort', "orderable": false, },
								{"targets": "medium", "width": "80px" },
								{"targets": "large",  "width": "120px" },
								{"targets": "approv", "width": "180px"},
								{"targets": "blarge", "width": "200px"},
								{"targets": "bsmall",  "width": "20px"},
								{"targets": "clarge", "width": "250px"},
								{"targets": "xlarge", "width": "300px" }
							],
							"fixedColumns":  false
						});
						
						$('#merchantOpenchannellink').on('click', function () {
							setTimeout(function(){ 
								//alert("Hello"); 
								console.log("WTF0");
								mertable.columns.adjust();
							}, 500);						
						});
					});
				 
					</script>			
			</div>
			<div id="employees" class="tab-pane fade">
				<div class="row">
					<div class=" col-sm-6">
						<h3>Staff List</h3>
					</div>
					<div class=" col-sm-6">
						<a class="add_row btn btn-info pull-right" style="margin-left: 5px; width: 120px;"
							href="javascript:void(0)">+ Staff</a>
					</div>
				</div>
				<?php $e=1;?>
				<div class="row">
					<div class=" col-sm-12">
						<table class="table table-bordered"
							id="employee-table" width="100%">
							<thead>
							
							<tr class="bg-black">
								<th class="text-center bsmall">No.</th>
								<th class="text-center">Staff&nbsp;ID</th>
								<th class="large text-center" style="width: 130px !important;">Name</th>
								<th class="text-center">Roles</th>
								<th  style="background-color: #31859C;" class="text-center">Info</th>
								<th  style="background-color: #558ED5;" class="text-center">SMM&nbsp;Army</th>
								<th  style="background-color: green;" class="text-center">Status</th>
								<th class="text-center">Email</th>
								<th class="bsmall text-center">
									<input type='checkbox' class='allsender' />
								</th>
								<th class="bsmall text-center">&nbsp;</th>
							</tr>
							</thead>
							<tfoot>
								<tr>
									<th colspan=7 ></th>
									<th colspan=3 >
										<a class="send_email btn btn-danger storebutton"
											style="width:100%"
											href="javascript:void(0)">Execute</a>
									</th>
								</tr>
							</tfoot>					
							<tbody>
							@foreach($members as $emps)
								<?php 
									$staffstyle = "";
									if($emps->status != 'active'){
										$staffstyle = "background-color: #EDEDED;";
									}
								?>
								<tr style="{{$staffstyle}}">
									<td class="text-center">{{$e}}</td>
									<td class="text-center">
										<?php $formatted_buyer_id =
											IdController::nB($emps->user_id); ?>
										@if(Auth::user()->hasRole('adm'))
											<a target="_blank"
											href="{{route('employeeLogistic',
												['id' => $emps->user_id, 'user_id' => $selluser->id])}}">
												<span id="status_column_text">
													{{$formatted_buyer_id}}
												</span>
											</a>
										@else
											{{$formatted_buyer_id}}
										@endif
										</a> 
									</td>
									<td class=""> 
									<?php
									/* Processed note */
									$pfullnote = null;
									$pnote = null;
									$elipsis = "...";
									if($emps->name == "" || is_null($emps->name)){
										$pfullnote = $emps->users_first_name ." ".
										$emps->users_last_name;
									} else {
										$pfullnote = $emps->name;
									}
										
									$pnote = substr($pfullnote,0, MAX_COLUMN_TEXT);

									if (strlen($pfullnote) > MAX_COLUMN_TEXT)
										$pnote = $pnote . $elipsis;
									?> 
									<span title='{{$pfullnote}}' class="customer_name" id="customer_name{{$emps->id}}" rel="{{$emps->id}}">&nbsp;&nbsp;{{$pnote}}&nbsp;&nbsp;</span>	
									<span id="sinputcustomer_name{{$emps->id}}" style="display: none;">
										<input type="text" value="{{$pfullnote}}" rel="{{$emps->id}}" class="customer_name_input" id="inputcustomer_name{{$emps->id}}" />
									</span>	
									</td>
									<?php
									$sysrole = "";
									$pursel = "";
									$memsel = "";
									$ebusel = "";
									$sysquery = DB::table('roles')->
										join('role_users','roles.id','=',
											'role_users.role_id')->
										where('role_users.user_id',$emps->user_id)->
										whereIn('roles.id',[15,18,20])->
										first();

									if(!is_null($sysquery)){
										if($sysquery->name == 'purchaser'){
											$pursel = "selected";
										}
										if($sysquery->name == 'member'){
											$memsel = "selected";
										}
										if($sysquery->name == 'emp_benefit_user'){
											$ebusel = "selected";
										}
										$sysrole = $sysquery->description;
									}

									$total_smm_army+=(int)$emps->connections;
									?>
									<td class="text-center">
										@if($emps->member_status == 'not exists')
										@else
											<a href="javascript:void(0)" class="member_role" rel="{{$emps->user_id}}">Roles</a>
										@endif
									</td>
									<td class="text-center"><a href="javascript:void(0)" class="member_info">Info</a></td>
									<td class="text-center">
										<a href="javascript:void(0)" class="member_smm smmarmy_exposer" uid="{{$emps->user_id}}">{{$emps->connections or '0'}}</a>
									</td>
									<td class="text-center">
										{{ucfirst($emps->status)}}
									</td>
									<td class="text-center">{{$emps->email}}</td>
									<td class="text-center">
										<input type='checkbox' class='sender'
										rel='{{$emps->email}}' /></td>
									<td class="text-center">
										<a  href="javascript:void(0);" class="text-danger delete_member" rel='{{$emps->email}}'><i class="fa fa-minus-circle fa-2x"></i></a>
									</td>	
								</tr>
							<?php $e++;?>
							@endforeach
							</tbody>
						</table>
						<input type="hidden" value="{{$e}}" id="nume" /> 
						<input type="hidden" value="{{$selluser->id}}" id="lpeid" />
						<input type="hidden" value="{{number_format($total_smm_army)}}" id="total_smm_army">
				</div>
				</div>    
			</div>
		</div>
	</div>
	</div>
	</div>
 </div>
<!-- Modal -->
<div class="modal fade" id="myModalCustCamp" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 50%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Customer Campaigns</h4>
            </div>
            <div class="modal-body">
                <div id="myBodyCustCamp">
					
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>

        </div>
    </div>
</div> 

<div class="modal fade" id="myModalSegment" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 20%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Segments</h4>
            </div>
            <div class="modal-body">
                <div id="myBodySegmentCus">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>

        </div>
    </div>
</div> 

<div class="modal fade" id="myModalChannel" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 20%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
					aria-label="Close">
				<span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Channels</h4>
            </div>
            <div class="modal-body">
                <div id="myBodyChannel">
					@foreach($channels as $channel)
						<?php
							$channelchecked = "";
							if($channel['checked']){
								$channelchecked = "checked";
							}
						?>
						<div class="row" id="channel{{$channel['id']}}">
							<div class="col-sm-12">
								<input type="checkbox"
								class="channel_desc" 
								name="channels"
								value="{{$channel['id']}}"
									{{$channelchecked}} />&nbsp;<b>
								{{$channel['description']}}</b>
							</div>	
							<div class="clearfix"></div>
						</div>	
					@endforeach				
                </div>
            </div>
            <div class="modal-footer">
                <button type="button"
				class="btn btn-default save_channel"
				>
				Save</button>
            </div>
            </form>

        </div>
    </div>
</div> 

<div class="modal fade" id="myModal_m" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 40%">
        <div class="modal-content">
            
            <div class="modal-body">

                <div id="myBody">
                <h3>Role Assignment</h3>
                	<div class="row">
					@foreach($memberroles as $memberrole)
						<div class="col-sm-6">
							<p><input type="checkbox" class="memberchek"
							rel="{{$memberrole->id}}"/>
							{{$memberrole->description}}</p>
						</div>
					@endforeach
					</div>
					<div class="row">
					<input type="hidden" value="0" id="user_idrole" />
                	</div>
					<hr/>
					<h3>Branch Assignment</h3>
					<div class="row">
					@foreach($locations as $location)
						<div class="col-sm-6">
							<p><input type="checkbox" class="memberlocation"
							rel="{{$location->id}}" />
							{{$location->location}}</p>
						</div>
					@endforeach
					</div>
					<input type="hidden" value="{{$selluser->id}}"
						id="merchant_user_id" />
					<div class="row">
					<a class='btn btn-primary saveroles pull-right' href='javascript:void(0)' > Save</a>
					<br/>
					<br/>
                	</div>
					
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
            </div>
            </form>

        </div>
    </div>
</div> 
</div>
<!-- Modal -->
<div class="modal fade" id="myModalSMM" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 40%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">SMM Army</h4>
            </div>
            <div class="modal-body">
                <table class="table table-bordered" width="100%" id="smm_army_table">
					<thead>				
						<tr style="background-color: #558ed5; color: white;">
							<th class="text-center" style="width: 20px;">No</th>
							<th class="large text-center" style="width: 130px !important;">Name</th>
							<th class="text-center">Exposure</th>
						</tr>
					</thead>
					<tbody id="smmarmy_exposer">
					</tbody>
				</table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div> 

<!-- Modal -->
<div class="modal fade" id="myModal_c" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 20%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Roles</h4>
            </div>
            <div class="modal-body">
                <div id="myBody">
					@foreach($customerroles as $customerrole)
						<p><input type="checkbox" class="customerchek" rel="{{$customerrole->id}}" /> {{$customerrole->description}}</p>
					@endforeach
					<a class='btn btn-primary saveroles_c pull-right' href='javascript:void(0)' > Saves</a>
					<br>
					<br>
					<input type="hidden" value="0" id="user_idrole_c" />
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>

        </div>
    </div>
</div> 

<div class="modal fade" id="myModalSegmentChange" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 20%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Segments</h4>
            </div>
            <div class="modal-body">
                <div id="myBodySegment">
					
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>

        </div>
    </div>
</div> 

<div class="modal fade" id="myModalTemplate" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 98%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Campaign Template</h4>
            </div>
            <div class="modal-body">
                <div id="myBodyTemplate">
					
                </div>
				<div class="clearfix">
				</div>
				<a class='btn btn-primary send_email_c_def pull-right' href='javascript:void(0)' > Send Campaign </a>
				<div class="clearfix">
				</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>

        </div>
    </div>
</div> 

<!-- Modal -->
<div class="modal fade" id="myModal_details" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 70%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Staff Details</h4>
            </div>
            <div class="modal-body">
                <table class="table table-bordered" width="100%">
					<thead>				
						<tr class="bg-black">
							<th class="text-center">Staff&nbsp;ID</th>
							<th class="large text-center" style="width: 130px !important;">Name</th>
							<th class="text-center">Position</th>
							<th class="text-center">Payment</th>
							<th class="text-center">Document</th>
							<th class="text-center">PCB</th>
							<th  style="background-color: green;" class="text-center">Status</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td class="text-center"><span id="st_id"></span></td>
							<td class="text-center"><span id="st_name"></span></td>
							<td><span id="st_position"></span></td>
							<td><span id="st_payment"></span></td>
							<td><span id="st_document"></span></td>
							<td><span id="st_pcb"></span></td>
							<td class="text-center"><span id="st_status"></span></td>
						</tr>
					</tbody>
				</table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>

        </div>
    </div>
</div>

</section>
<script type="text/javascript">
	function firstToUpperCase( str ) {
		return str.substr(0, 1).toUpperCase() + str.substr(1);
	}

	function validateEmail(email) {
		var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return re.test(email);
	}
	
	var cust_table = null;
	
    $(document).ready(function(){
		$('.dataTables_empty').attr('colspan', '100%')
		
		$(document).delegate( '.customer_name', "click",function (event) {
			var id = $(this).attr('rel');
			$(this).hide();
			$("#sinputcustomer_name" + id).show();
		});		
		
		$(document).delegate( '.customer_name_input', "blur",function (event) {
			var id = $(this).attr('rel');
			var value = $(this).val();
			$.ajax({
				type: "POST",
				data: {data: value},
				url: "/seller/member/name/" + id,
				dataType: 'json',
				success: function (data) {
					$("#sinputcustomer_name" + id).hide();
					$("#customer_name" + id).html(value);
					$("#customer_name" + id).show();
					//obj.html("Send");
				},
				error: function (error) {
					toastr.error("An unexpected error ocurred");
				}

			});			
		});			
		
		var emp_table = $('#employee-table').DataTable({
            "order": [],
			 "columns": [
					{ "width": "20px", "orderable": false },
					{ "width": "120px" },
					{ "width": "180px" },
					{ "width": "80px" },
					{ "width": "80px" },
					{ "width": "80px" },
					{ "width": "80px" },
					{ "width": "180px" },
					{ "width": "20px", "orderable": false },
					{ "width": "20px", "orderable": false },
				]
			});		
			
			var cust_table = $('#customer-table').DataTable({
            "order": [],
			 "columns": [
					{ "width": "20px", "orderable": false },
					{ "width": "120px" },
					{ "width": "180px" },
					{ "width": "80px" },
					{ "width": "80px" },
					{ "width": "180px" },
					{ "width": "180px" },
					{ "width": "20px", "orderable": false },
					{ "width": "20px", "orderable": false },
					{ "width": "0px", "visible": false},
				]
			});	
			
		$(document).delegate( '.customer_campaign', "click",function (event) {
			var obj = $(this);
			var userid = obj.attr('rel');
			var lpid = $("#lpeid").val();
			$.ajax({
				type: "GET",
				url: JS_BASE_URL + "/seller/member/campaings/" + userid + "/" + lpid,
				success: function (data) {
					$("#myBodyCustCamp").empty();
					$("#myBodyCustCamp").html(data);
					$("#myModalCustCamp").modal('show');
					//obj.html("Send");
				},
				error: function (error) {
					toastr.error("An unexpected error ocurred");
				}

			});				
		});			
			
		$(document).delegate( '.savesegments', "click",function (event) {
			var obj = $(this);
			obj.html('Saving...');
			var userid = $("#user_idrolesegment").val();
			var lpid = $("#lpeid").val();
			var data={};
			var table = cust_table;
			console.log(table);
			var countdata = 0
			$('.customersegment').each(function () {
				var key= $(this).attr('rel');
                if (this.checked) {
                    data[key]=true;
					countdata++;
                } else {
					data[key]=false;
				}
            });
		//	console.log(data);
			$.ajax({
				type: "POST",
				data: {data: data},
				url: "/seller/member/segment/" + userid + "/" + lpid,
				dataType: 'json',
				success: function (data) {
				//	console.log(data);
					toastr.info('Segment successfully changed!');
					obj.html('Save');
					$("#segments" + userid).html(data.description);
					$("#user_idrolesegment").val(userid);
					$("#myModalSegment").modal('toggle');
					cust_table
					.draw(false);
				},
				error: function (error) {
					toastr.error("An unexpected error ocurred");
				}

			});
		});			
			
		$(document).delegate( '.customer_segment', "click",function (event) {
			var obj = $(this);
			var userid = obj.attr('rel');
			var lpid = $("#lpeid").val();
			$.ajax({
				type: "GET",
				url: "/seller/member/segment/" + userid + "/" + lpid,
				success: function (data) {
					$("#myBodySegmentCus").html(data);
					$("#myModalSegment").modal('show');
					//obj.html("Send");
				},
				error: function (error) {
					toastr.error("An unexpected error ocurred");
				}

			});			
		});
		
		$(document).delegate( '.delete_segment', "click",function (event) {
			var id = $(this).attr('rel');
			$.ajax({
				type: "POST",
				data: {id: id},
				url: "/seller/companysegment/delete",
				dataType: 'json',
				success: function (data) {
					if(data.status == "success"){
						toastr.info("Segment successfully deleted");
						$("#segment" + id).remove();
					} else {
						toastr.error("You cannot delete this Segment, one or more members are tagged");
					}
				},
				error: function (error) {
					toastr.error("An unexpected error ocurred");
				}
			});
		});
		$(document).delegate( '.add_segment', "click",function (event) {
			$("#inputsegmentnew").show();
		});
		
		$(document).delegate( '#inputsegmentnew', "blur",function (event) {
			var description = $("#inputsegmentnew").val();
			var owner_id = $("#owner_id").val();
			if(description == ""){
				toastr.warning("Segment name cannot be empty");
			} else {
				$.ajax({
					type: "POST",
					data: {description: description, owner_id: owner_id},
					url: "/seller/companysegment/add",
					dataType: 'json',
					success: function (data) {
						if(data.status == 'success'){
							toastr.info("Segment successfully added!");
							console.log(data.html);
							$("#newsegments").append(data.html);
							$("#inputsegmentnew").val("");
							$("#inputsegmentnew").hide();
						} else {
							toastr.warning("Segment name cannot be the same as other segment!");
						}
					},
					error: function (error) {
						toastr.error("An unexpected error ocurred");
					}

				});		
			}			
		});

		$(document).delegate( '.segment_input', "blur",function (event) {
			var id = $(this).attr('rel');
			var value = $(this).val();
			var owner_id = $("#owner_id").val();
			if(value == ""){
				toastr.warning("Segment name cannot be empty");
			} else {
				$.ajax({
					type: "POST",
					data: {data: value, owner_id: owner_id},
					url: "/seller/companysegment/name/" + id,
					dataType: 'json',
					success: function (data) {
						if(data.status == 'success'){
							$("#inputsegment" + id).hide();
							$("#spansegment" + id).html(value);
							$("#spansegment" + id).show();
						} else {
							toastr.warning("Segment name cannot be the same as other segment!");
						}
						//obj.html("Send");
					},
					error: function (error) {
						toastr.error("An unexpected error ocurred");
					}

				});	
			}			
		});	
		$(document).delegate( '.segment_name', "click",function (event) {
			var id = $(this).attr('rel');
			$(this).hide();
			$("#inputsegment" + id).show();
		});			
		
		$(document).delegate( '.segment_managment', "click",function (event) {
			//console.log("HOLA");
			var lpid = $("#lpeid").val();
			$.ajax({
				type: "GET",
				url: "/seller/member/segments/" + lpid,
				success: function (data) {
					$("#myBodySegment").empty();
					$("#myBodySegment").html(data);
					$("#myModalSegmentChange").modal('show');
				},
				error: function (error) {
					toastr.error("An unexpected error ocurred");
				//	obj.html("Execute");
				}

			});				
		});			
			
		$(document).delegate( '.channel_managment', "click",function (event) {
			$("#myModalChannel").modal('show');
		});	
		
		$(document).delegate( '.customerchek', "click",function (event) {
			if($(this).prop('checked')){
				$('.customerchek').prop('checked',false);
				$(this).prop('checked',true);
			}
		});				
			
		$(document).delegate( '.allsender', "click",function (event) {
			if($(this).prop('checked')){
				$(".sender").prop('checked',true);
			} else {
				$(".sender").prop('checked',false);
			}
		});
		
		$(document).delegate( '.allsender_c', "click",function (event) {
			if($(this).prop('checked')){
				$(".sender_c").prop('checked',true);
			} else {
				$(".sender_c").prop('checked',false);
			}
		});

		$(document).delegate( '.saveroles_c', "click",function (event) {
			var obj = $(this);
			obj.html('Saving...');
			var userid = $("#user_idrole_c").val();
			/*var isstaff = 0;
			var isadmin = 0;
			if($('#staff').prop('checked')){
				isstaff = 1;
			}
			if($('#adminstaff').prop('checked')){
				isadmin = 1;
			}*/
			var data={};
			var countdata = 0
			$('.customerchek').each(function () {
				var key= $(this).attr('rel');
                if (this.checked) {
                    data[key]=true;
					countdata++;
                } else {
					data[key]=false;
				}
				console.log(data);
            });

			$.ajax({
				type: "POST",
				data: {data: data},
				url: JS_BASE_URL+"/seller/member/roles/" + userid,
				dataType: 'json',
				success: function (data) {
					console.log(data);
					toastr.info('Roles successfully changed!');
					obj.html('Save');
					$("#user_idrole_c").val(userid);
					$("#myModal_c").modal('toggle');
					//obj.html("Send");
				},
				error: function (error) {
					toastr.error("An unexpected error ocurred");
				}

			});
		});
		
		$(document).delegate( '.saveroles', "click",function (event) {
			var obj = $(this);
			obj.html('Saving...');
			var userid = $("#user_idrole").val();
			var data = {};
			var muid = {};
			var countdata = 0
			$('.memberchek').each(function () {
				var key= $(this).attr('rel');
                if (this.checked) {
                    data[key]=true;
					countdata++;
                } else {
					data[key]=false;
				}
            });

			muid['muid'] = $('#merchant_user_id').val();
			console.log('****** Saving Member Roles ******');
			console.log('merchant_user_id='+muid['muid']);
			
			var locationdata={};
			var countdata = 0
			$('.memberlocation').each(function () {
				var key= $(this).attr('rel');
                if (this.checked) {
                    locationdata[key]=true;
					countdata++;
                } else {
					locationdata[key]=false;
				}
            });

			$.ajax({	
				type: "POST",
				data: {data: data,locationdata:locationdata,muid:muid},
				url: JS_BASE_URL+"/seller/member/roles/" + userid,
				dataType: 'json',
				success: function (data) {
					console.log(data);
					toastr.info('Roles successfully changed!');
					obj.html('Save');
					$("#user_idrole").val(userid);
					$("#myModal_m").modal('toggle');
					//obj.html("Send");
				},
				error: function (error) {
					toastr.error("An unexpected error ocurred");
				}

			});
		});
		$(document).delegate( '.savelocations', "click",function (event) {
			var obj = $(this);
			obj.html('Saving...');
			var userid = $("#user_idrole").val();
			/*var isstaff = 0;
			var isadmin = 0;
			if($('#staff').prop('checked')){
				isstaff = 1;
			}
			if($('#adminstaff').prop('checked')){
				isadmin = 1;
			}*/
			var data={};
			var countdata = 0
			$('.memberlocation').each(function () {
				var key= $(this).attr('rel');
                if (this.checked) {
                    data[key]=true;
					countdata++;
                } else {
					data[key]=false;
				}
            });
		
			$.ajax({
				type: "POST",
				data: {data: data},
				url: JS_BASE_URL+"/seller/member/locations/" + userid,
				dataType: 'json',
				success: function (data) {
					console.log(data);
					toastr.info('Locations successfully changed!');
					obj.html('Save');
					$("#user_idrole").val(userid);
					$("#myModal_m").modal('toggle');
					//obj.html("Send");
				},
				error: function (error) {
					toastr.error("An unexpected error ocurred");
				}

			});
		});
		$(document).delegate( '.customer_role', "click",function (event) {
			var obj = $(this);
			var userid = obj.attr('rel');
			$.ajax({
				type: "GET",
				url: JS_BASE_URL+"/seller/member/roles/" + userid,
				dataType: 'json',
				success: function (data) {
					console.log(data.asroles);
					var roles = data.asroles;
					if (typeof roles != 'undefined'){
						$.each(roles, function(index, value) {
							//console.log(index);
							//console.log(value);
							if(value == 1){
								$(".customerchek[rel="+index+"]").prop('checked',true);
							} else {
								$(".customerchek[rel="+index+"]").prop('checked',false);
							}
						}); 
					}
					$("#user_idrole_c").val(userid);
					$("#myModal_c").modal('show');
					//obj.html("Send");
				},
				error: function (error) {
					toastr.error("An unexpected error ocurred");
				}

			});
		});	
	
		$(document).delegate( '.member_details', "click",function (event) {
			var obj = $(this);
			var userid = obj.attr('rel');
			var status = obj.attr('statusrel');
			var pnote = obj.attr('pnoterel');
			var pfullnote = obj.attr('pfullnote');
			var id = obj.attr('idrel');
			if(parseInt(userid) > 0){
				$("#st_id").html(id);
			}
			$("#st_name").html(pnote);
			$("#st_name").attr('title',pfullnote);
			$("#st_status").html(status);
			$("#myModal_details").modal('show');
		});
		
		$(document).delegate( '.member_role', "click",function (event) {
			var obj = $(this);
			var userid = obj.attr('rel');
			$.ajax({
				type: "GET",
				url: JS_BASE_URL+"/seller/member/roles/" + userid,
				dataType: 'json',
				success: function (data) {
					var roles = data.asroles;
					var locations=data.locations;
					if (typeof roles != 'undefined'){
						$.each(roles, function(index, value) {
							//console.log(index);
							//console.log(value);
							if(value == 1){
								$(".memberchek[rel="+index+"]").prop('checked',true);
							} else {
								$(".memberchek[rel="+index+"]").prop('checked',false);
							}
						}); 
					}
					if (typeof locations != 'undefined'){
						$.each(locations, function(index, value) {
							console.log(index,value.location_id);
							$(".memberlocation[rel="+value.location_id+"]").prop('checked',true);
						}); 
					}
					$("#user_idrole").val(userid);
					$("#myModal_m").modal('show');
					//obj.html("Send");
				},
				error: function (error) {
					toastr.error("An unexpected error ocurred");
				}
			});
		});	
		
		$(document).delegate( '.delete_member', "click",function (event) {
			console.log("HI");
			var r = confirm("Are you sure you want to delete this member?");
			if (r == true) {
				var obj = $(this);
				var email = $(this).attr('rel');
				var lpid = $("#lpeid").val();
				$.ajax({
					type: "POST",
					data: {email: email, userid: lpid},
					url: JS_BASE_URL+"/seller/member/delete",
					dataType: 'json',
					success: function (data) {
						emp_table
							.row( obj.parents('tr') )
							.remove()
							.draw();
						toastr.info("Member successfully deleted!");
						//obj.html("Send");
					},
					error: function (error) {
						toastr.error("An unexpected error ocurred");
					}

				});
			} else {
				//Nothing to do here
			}
			
		} );		
		
		$(document).delegate( '.delete_member_c', "click",function (event) {
			console.log("HI");
			var r = confirm("Are you sure you want to delete this customer?");
			if (r == true) {
				var obj = $(this);
				console.log(obj.parents('tr'));
				var email = $(this).attr('rel');
				var lpid = $("#lpeid").val();
				$.ajax({
					type: "POST",
					data: {email: email, userid: lpid},
					url: JS_BASE_URL+"/seller/member/delete",
					dataType: 'json',
					success: function (data) {
						cust_table
							.row( obj.parents('tr') )
							.remove()
							.draw();
						toastr.info("Customer successfully deleted!");
						//obj.html("Send");
					},
					error: function (error) {
						toastr.error("An unexpected error ocurred");
					}

				});
			} else {
				//Nothing to do here
			}
		} );		
		
		$(document).delegate( '.userroleselect', "change",function (event) {
			var val = $(this).val();
			var user = $(this).attr('urel');
			var rel = $(this).attr('rel');
			var lpid = $("#lpeid").val();
			if(val == ""){
				toastr.error("You must select a role!");
			} else {
				if(user == "" || user == "0"){
					toastr.error("You can't assign a role to an unexisting user!");
				} else {
					console.log(user);
					$.ajax({
						type: "POST",
						data: {val: val, user_id: user, userid: lpid},
						url: JS_BASE_URL+"/seller/member/add_role",
						dataType: 'json',
						success: function (data) {
							console.log(data);
							$("#userrole" + rel).html(data.response.description);
							$("#userrole" + rel).show();
							$("#userrolesel" + rel).hide();
							toastr.info("Role successfully assigned!");
							//obj.html("Send");
						},
						error: function (error) {
							toastr.error("An unexpected error ocurred");
						}

					});				
				}
					
			}
		});
		
		$(document).delegate( '.add_row', "click",function (event) {
			var e = parseInt($("#nume").val());
				var rowNode = emp_table.row.add( [ "<p align='center'>" + e + "</p>", "<p align='center' id='usera"+e+"'></p> ","<p align='center' id='username"+e+"'></p>", "<p align='center' id='userrole"+e+"' rel='"+e+"'></p>", "<p align='center' id='userinfo"+e+"'></p>", "<p align='center' id='usersmm"+e+"'></p>", "<p align='center' id='usertop"+e+"'></p>", "<p align='center' id='useremail"+e+"' style='display: none;'></p><p align='center' id='userkey"+e+"'><input type='text' class='form-control key_employee' placeholder='Place employee email...' rel='"+e+"' /></p>", "<p align='center' id='usercheck"+e+"'></p>", "<p align='center' id='userdelete"+e+"'></p>"] ).draw();
			$( rowNode )
			.css( 'text-align', 'center');
			e++;
			$("#nume").val(e);			
		});
		
		$(document).delegate( '.add_row_c', "click",function (event) {
			var e = parseInt($("#nume_c").val());
			console.log(cust_table);
				var rowNode = cust_table.row.add( [ "<p align='center'>" + e + "</p>","<p align='center' id='c_username"+e+"'></p>", "<p align='center' id='c_userrole"+e+"' rel='"+e+"'></p>", "<p align='center' id='c_usersegment"+e+"' rel='"+e+"'></p>", "<p align='center' id='c_usercamp"+e+"' rel='"+e+"'></p>", "<p align='center' id='c_usertop"+e+"'></p>", "<p align='center' id='c_useremail"+e+"' style='display: none;'></p><p align='center' id='c_userkey"+e+"'><input type='text' class='form-control key_employee_c' placeholder='Place employee email...' rel='"+e+"' /></p>", "<p align='center' id='c_usercheck"+e+"'></p>", "<p align='center' id='c_userdelete"+e+"'></p>", "<p align='center' id='c_usersegments"+e+"' rel='"+e+"'></p>"] ).draw();
			$( rowNode )
			.css( 'text-align', 'center');
			e++;
			$("#nume_c").val(e);			
		});		
		
		$(document).delegate( '.send_email', "click",function (event) {
			var emails={};
			var obj = $(this);
			obj.html("Sending...");
			var count_emails = 0;
            $('.sender').each(function () {
				var email= $(this).attr('rel');
                if (this.checked) {
                    emails[count_emails]=email;
					count_emails++;
                } 
            });
			var key_employee = $('.key_employee').val();
			console.log(key_employee);
			if (typeof key_employee != 'undefined'){
				if(validateEmail(key_employee)){
					emails[count_emails]=key_employee;
					count_emails++;
				}
			}
			var lpid = $("#lpeid").val();
			console.log(emails);
			if(count_emails == 0){
				toastr.warning('No email selected. Please select emails you wish to send');
				obj.html("Execute");
			} else {
				$.ajax({
					type: "POST",
					data: {emails: emails, userid: lpid},
					url: JS_BASE_URL+"/seller/member/send_emails",
					dataType: 'json',
					success: function (data) {
						toastr.info("Email(s) successfully sent!");
						obj.html("Execute");
					},
					error: function (error) {
						toastr.error("An unexpected error ocurred");
						obj.html("Execute");
					}

				});				
			}
		});
		
		$(document).delegate( '.send_email_c', "click",function (event) {
			var lpid = $("#lpeid").val();
			$.ajax({
				type: "GET",
				url: "/seller/member/lasttemplate/" + lpid,
				success: function (data) {
					$("#myBodyTemplate").html(data);
					$("#myModalTemplate").modal('show');
					//obj.html("Execute");
				},
				error: function (error) {
					toastr.error("An unexpected error ocurred");
					//obj.html("Execute");
				}

			});				
		});		
		
		$(document).delegate( '.send_email_c_def', "click",function (event) {
			var emails={};
			var obj = $(this);
			obj.html("Sending...");
			var count_emails = 0;
            $('.sender_c').each(function () {
				var email= $(this).attr('rel');
                if (this.checked) {
                    emails[count_emails]=email;
					count_emails++;
                } 
            });
			var key_employee = $('.key_employee_c').val();
			console.log(key_employee);
			if (typeof key_employee != 'undefined'){
				if(validateEmail(key_employee)){
					emails[count_emails]=key_employee;
					count_emails++;
				}
			}
			var lpid = $("#lpeid").val();
			console.log(emails);
			if(count_emails == 0){
				toastr.warning('No email selected. Please select emails you wish to send');
				obj.html("Execute");
			} else {
				$.ajax({
					type: "POST",
					data: {emails: emails, userid: lpid},
					url: JS_BASE_URL+"/seller/member/send_emails_c",
					dataType: 'json',
					success: function (data) {
						toastr.info("Campaign Successfully sent!");
						$(".send_email_c").hide();
						$(".nocampaign").show();
						$("#myModalTemplate").modal('toggle');
					},
					error: function (error) {
						toastr.error("An unexpected error ocurred");
						obj.html("Execute");
					}

				});				
			}
		});		
			
		$(document).delegate( '.view-employee-modal', "click",function (event) {
	//	$('.view-employee-modal').click(function(){

		var user_id=$(this).attr('data-id');
		var check_url=JS_BASE_URL+"/admin/popup/lx/check/user/"+user_id;
		$.ajax({
				url:check_url,
				type:'GET',
				success:function (r) {
				console.log(r);

				if (r.status=="success") {
				var url=JS_BASE_URL+"/admin/popup/user/"+user_id;
						var w=window.open(url,"_blank");
						w.focus();
				}
				if (r.status=="failure") {
				var msg="<div class=' alert alert-danger'>"+r.long_message+"</div>";
				$('#employee-error-messages').html(msg);
				}
				}
				});
		});
		
		$(document).delegate( '.userrole', "click",function (event) {
			var rel = $(this).attr('rel');
			$(this).hide();
			$("#userrolesel" + rel).show();
		});
		
		$(document).delegate( '.key_employee', "blur",function (event) {
			var keyemployee = $(this);
			var email = $(this).val();
			var rel = $(this).attr('rel');
			$("#mailspin").show();
			var lpid = $("#lpeid").val();
			if(validateEmail(email)){
				console.log(lpid);
				$.ajax({
					type: "POST",
					data: {email: email, userid: lpid},
					url: JS_BASE_URL+"/seller/member/add_employee",
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
							if(parseInt(data.employee['user_id']) > 0){
								$("#usera" + rel).html("<a href='javascript:void(0)' class='view-employee-modal' data-id='"+data.employee['user_id']+"'>"+data.employee['id']+"</a>");
							}
							$("#username" + rel).html(data.employee['name']);
							$("#userrole" + rel).html('<a href="javascript:void(0)" class="member_role" rel="'+data.employee['user_id']+'">Roles</a>');
							$("#usertop" + rel).html(firstToUpperCase(data.employee['status']));
							$("#userinfo" + rel).html('<a href="javascript:void(0)" class="member_info" rel="'+data.employee['user_id']+'">Info</a>');
							$("#usersmm" + rel).html('<a href="javascript:void(0)" class="member_smm" rel="'+data.employee['user_id']+'">0</a>');
							$("#useremail" + rel).html(data.employee['email']);
							$("#useremail" + rel).show();
							$("#userkey" + rel).hide();
							$("#usercheck" + rel).html("<input type='checkbox' class='sender' rel='"+data.employee['email']+"' />");
							$("#userdelete" + rel).html("<a  href='javascript:void(0);' class='text-danger delete_member' rel='"+data.employee['email']+"'><i class='fa fa-minus-circle fa-2x'></i></a>");
						/*	var e = parseInt($("#nume").val());
							var rowNode = emp_table.row.add( [ "<p align='center'>" + e + "</p>", "<p align='center'><a href='javascript:void(0)' class='view-employee-modal' data-id='"+data.employee['user_id']+"'>"+data.employee['id']+"</a></p> ","<p align='center'>" + data.employee['name'] + "</p>", "<p align='center'>" + firstToUpperCase(data.employee['role']) + "</p>", "<p align='center'>" + "<a href='javascript:void(0)' >" + firstToUpperCase(data.employee['status'])+ '</a>' + "</p>", "<p align='center'>" + data.employee['email'] + "</p>", "<p align='center'>" + "<input type='checkbox' class='sender' rel='"+data.employee['email']+"' />" + "</p>" ] ).draw();
							$( rowNode )
							.css( 'text-align', 'center');
							e++;
							$("#nume").val(e);*/
						}
						$(".key_employee").val("");
						$("#mailspin").hide();
					},
					error: function (error) {
						$("#mailspin").hide();
						toastr.error("An unexpected error ocurred");
					}

				});				
				
			} else {
				$("#mailspin").hide();
				if(email != ""){
					toastr.error("Invalid email! Please, type a valid email.");
				}
			}
				//alert($(this).is(":checked"));
         });		
		 
		$(document).delegate( '.key_employee_c', "blur",function (event) {
			var keyemployee = $(this);
			var email = $(this).val();
			var rel = $(this).attr('rel');
			$("#mailspin").show();
			var lpid = $("#lpeid").val();
			if(validateEmail(email)){
				console.log(lpid);
				$.ajax({
					type: "POST",
					data: {email: email, userid: lpid},
					url: JS_BASE_URL+"/seller/member/add_employee/customer",
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
							$("#c_usera" + rel).html('<a href="javascript:void(0)" class="customer_info">Info</a>');
							$("#c_username" + rel).html(data.employee['name']);
							if(data.employee['status'] == 'tagged'){	
								$("#c_userrole" + rel).html('<a href="javascript:void(0)" class="customer_role" rel="'+data.employee['user_id']+'">Roles</a>');
							} else {
								$("#c_userrole" + rel).html("&nbsp;&nbsp;&nbsp;&nbsp;");
							}
							$("#c_usertop" + rel).html(firstToUpperCase(data.employee['status']));
						//	if(parseInt(data.employee['user_id']) > 0){	
								$("#c_usersegment" + rel).html('<a href="javascript:void(0)" class="customer_segment" rel="'+data.employee['member_id']+'"><span id="segmentspan'+data.employee['user_id']+'">Details</span></a>');
						//	}
							$("#c_usersegment" + rel).html('<span id="segments' + data.employee['id'] + '"></span>');
							$("#c_useremail" + rel).html(data.employee['email']);
							$("#c_useremail" + rel).show();
							$("#c_userkey" + rel).hide();
							$("#c_usercheck" + rel).html("<input type='checkbox' class='sender' rel='"+data.employee['email']+"' />");
							$("#c_userdelete" + rel).html("<a  href='javascript:void(0);' class='text-danger delete_member_c' rel='"+data.employee['email']+"'><i class='fa fa-minus-circle fa-2x'></i></a>");
						}
						$(".key_employee_c").val("");
						$("#mailspin").hide();
					},
					error: function (error) {
						$("#mailspin").hide();
						toastr.error("An unexpected error ocurred");
					}

				});				
				
			} else {
				$("#mailspin").hide();
				if(email != ""){
					toastr.error("Invalid email! Please, type a valid email.");
				}
			}
				//alert($(this).is(":checked"));
         });	

         $('.smmarmy_exposer').click(function(){
         	uid=$(this).attr('uid');
         	url=JS_BASE_URL+"/smmarmy_exposer/"+uid;
         	$.ajax({
         		url:url,
         		type:'GET',
         		success:function(r){
         			$('#smmarmy_exposer').empty();
         			$('#smmarmy_exposer').append(r);
         			$('#myModalSMM').modal('show');
         		},
         		error:function(){
         			toastr.warning('Failed to get resource.');
         		}
         	});
         });	 
		
    });
</script>
<script type="text/javascript">
	$(document).ready(function(){
		var total=$('#total_smm_army').val();

		var html='<label style="text-align:center;margin-left:300px;font-weight:light">Total SMM Army: <a href="javascript:void(0);">'+total+'</a></label>';
		$('#employee-table_length').append(html);

		$('.save_channel').click(function(){
         	$channel_array={};
         	$('.channel_desc').each(function(i,elem){
         		if ($(elem).is(":checked")) {
         			$channel_array[$(elem).val()]="active";
         		}
         		else{
         			$channel_array[$(elem).val()]="suspended";
         		}         		
         	});
         	url="{{url('campaign/channel/save')}}";
         	data={
				'channel_array':$channel_array
			};
			         		
         	$.ajax({
				url:url,
				data:data,
				type:'POST',
				success:function(r){
					toastr.info(r.long_message);
					location.reload();
				},
				error:function(){toastr.warning("A server error happened.")}
			});
		});	
	});
</script>
@stop
