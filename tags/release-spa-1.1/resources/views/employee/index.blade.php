@extends("common.default")
<?php
use App\Classes;
define('MAX_COLUMN_TEXT', 20);
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\IdController;
?>
{{--
@section('breadcrumbs', Breadcrumbs::render('Employees'))
--}}

@section("content")
<style type="text/css">
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
        margin: 10px 0 0 10px;
        width: 85px;
    }

</style><?php $i=1; ?>
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
    <div style="display: none;" class="overlay" >
        <p><span style="position: relative;" class="all-filter-fa"><i class="fa-li fa fa-spinner fa-spin fa fa-fw"></i></span></p>
    </div>

    <div style="display: none;" class="removeable alert">
        <strong id='alert_heading'></strong><span id='alert_text'></span>
    </div>
    <div class="container" style="margin-top:30px;">
	@include('admin/panelHeading')
            <div class="equal_to_sidebar_mrgn">

                <h2>Employee Master</h2>
		<span  id="recruiter-error-messages">
    		</span>
		<span  id="employee-error-messages">
	        </span>

                <!-- <hr/> -->
                <p class="bg-success success-msg" style="display:none;padding: 15px;"></p>
                <br/>
                <br/>
                <!-- <hr> -->
                <form class="form-horizontal" style="display:none;">

                    <!-- Form Name -->
                    <legend>Toggle columns</legend>

                    <!-- Multiple Checkboxes  -->
                    <div class="form-group">
                      <div class="col-md-3">
                        <p>
                          <input class="switch-state" type="checkbox" data-label-text="Name" data-column="1" checked>
                        </p>
                        <p>
                          <input class="switch-state" type="checkbox" data-label-text="Position" data-column="2" checked>
                        </p>
                        <p>
                          <input class="switch-state" type="checkbox" data-label-text="Visa No" data-column="3" checked>
                        </p>
                        <p>
                          <input class="switch-state" type="checkbox" data-label-text="Socso No" data-column="4" checked>
                        </p>
                      </div>
                      <div class="col-md-3">
                        <p>
                          <input class="switch-state" type="checkbox" data-label-text="EPF No" data-column="5" checked>
                        </p>
                        <p>
                          <input class="switch-state" type="checkbox" data-label-text="PCB" data-column="6" checked>
                        </p>
                        <p>
                          <input class="switch-state" type="checkbox" data-label-text="Monthly Salary" data-column="7" checked>
                        </p>
                        <p>
                          <input class="switch-state" type="checkbox" data-label-text="Has Open Wish" data-column="8" checked>
                        </p>
                      </div>
                      <div class="col-md-3">
                        <p>
                          <input class="switch-state" type="checkbox" data-label-text="Has SMM" data-column="9" checked>
                        </p>
                        <p>
                          <input class="switch-state" type="checkbox" data-label-text="Has Auction" data-column="10" checked>
                        </p>
                        <p>
                          <input class="switch-state" type="checkbox" data-label-text="Has Open Business" data-column="11" checked>
                        </p>
                        <p>
                          <input class="switch-state" type="checkbox" data-label-text="Recruiter ID" data-column="12" checked>
                        </p>
                      </div>
                      <div class="col-md-3">
                        <p>
                          <input class="switch-state" type="checkbox" data-label-text="Payment Method" data-column="13" checked>
                        </p>
                        <p>
                          <input class="switch-state" type="checkbox" data-label-text="Payment Credential" data-column="14" checked>
                        </p>
                        <p>
                          <input class="switch-state" type="checkbox" data-label-text="Bank A/C" data-column="15" checked>
                        </p>
                        <p>
                          <input class="switch-state" type="checkbox" data-label-text="Action" data-column="16" checked>
                        </p>
                      </div>
                    </div>
                </form>

                <div class="table-wrapper">
                    <table class="table table-striped display cell-border" cellspacing="0" width="100%" id="employee_grid">
                        <thead>
                            <tr>
                                <th class="text-center bsmall"
									style="background-color: black; color: white;">No</th>
								@if($isapprover == 1)
									<th class="text-center bsmall" style="background-color: black; color: white;">Top </th>
								@endif								
                                <th class="text-center medium" style="background-color: black; color: white;">Employee&nbsp;ID</th>
                                <th style="background-color: black; color: white;" class="blarge">Name</th>
								<!-- <th class="text-center medium" style="background-color: black; color: white;">Recruiter&nbsp;ID</th> -->
                                <th class="text-center medium" style="background-color: black; color: white;">Position</th>
								<th class="text-center medium" style="background-color: black; color: white;">Payment</th>
								<th class="text-center medium" style="background-color: black; color: white;">Document</th>
								<th class="text-center medium" style="background-color: black; color: white;">PCB </th>
								<!-- <th style="background-color: #008000; color: white;" class="text-center xlarge">Remark</th> -->
                                <th style="background-color: #008000; color: white;" class="text-center medium">Status</th>
                                <!-- <th style="background-color: #008000; color: white;" class="text-center approv">Action</th> -->
                            </tr>
                        </thead>
                        <tbody>
							<?php $i=1; ?>
                            @if(isset($employees) && !empty($employees))
                                {{--{{dd($employees)}}--}}
                                @foreach($employees as $employee)

                                    <tr>
                                        <td style='vertical-align:middle;'>{{$i++}}</td>
										@if($isapprover == 1)
										<?php 
											$admin = DB::table("role_users")->join("roles","roles.id","=","role_users.role_id")->where("role_users.user_id",$employee->user_id)->where("roles.name","adminstrator")->get();
											$isadmin = "";
											if(count($admin)>0){
												$isadmin = "CHECKED";
											}											
										?>
										<td style='vertical-align:middle;'>
											<input type="checkbox" class="isadmin" id="isadmin{{$employee->user_id}}" rel="{{$employee->user_id}}" {{$isadmin}} />
										</td>
										@endif										
										<td style='vertical-align:middle;'>
										<!--<a target="_blank" href="/admin/popup/user/{{$employee->user_id}}">
										[{{str_pad($employee->id, 10, '0', STR_PAD_LEFT)}}]</a>-->
										<?php $formatted_buyer_id = IdController::nB($employee->user_id); ?>
										<a href="javascript:void(0)" class="view-employee-modal" data-id="{{$employee->user_id }}"> 
													{{$formatted_buyer_id}}</a> 
										</td>
                                        <td style="vertical-align:middle;text-align:left;">
											<?php
												/* Processed note */
												$pfullnote = null;
												$pnote = null;
													$elipsis = "...";
													$pfullnote = $employee->users['first_name']." ".$employee->users['last_name'];
													$pnote = substr($pfullnote,0, MAX_COLUMN_TEXT);

													if (strlen($pfullnote) > MAX_COLUMN_TEXT)
														$pnote = $pnote . $elipsis;
											?> 
											<span title='{{$pfullnote}}'>{{$pnote}}</span>										
										</td>
										<!--<td style='vertical-align:middle;'>
										<!--<a target="_blank" href="/admin/popup/user/{{$employee->source_user_id}}">[{{str_pad($employee->source_user_id, 10, '0', STR_PAD_LEFT)}}]</a>
										<?php $formatted_buyer_ide = IdController::nB($employee->source_user_id); ?>
										<a href="javascript:void(0)" class="view-recruiter-modal" data-id="{{ $employee->source_user_id }}">
										{{$formatted_buyer_ide}}</a>
										</td>-->
                                        <td style='vertical-align:middle;'><a rel="{{ $employee->user_id }}" class="position" href="javascript:void(0)">Details</a></td>
                                        <td style='vertical-align:middle;'><a rel="{{ $employee->id }}" class="payment" href="javascript:void(0)">Details</a></td>
                                        <td style='vertical-align:middle;'><a rel="{{ $employee->id }}" class="employeedocument" href="javascript:void(0)">Details</a></td>
                                        <td style='vertical-align:middle;'><a rel="{{ $employee->id }}" class="employeepcb" href="javascript:void(0)">Details</a></td>	
                                       <!-- <td style='vertical-align:middle;'>
											<?php
												$remark = DB::table('remark')
												->select('remark')
												->join('employeeremark','employeeremark.remark_id','=','remark.id')
												->where('employeeremark.employee_id',$employee->id)
												->orderBy('remark.created_at', 'desc')
												->first();
											?>
												<a href="javascript:void(0)" id="mcrid_{{$employee->id}}" class="emprid" rel="{{$employee->id}}">
													@if($remark)
													<?php
														/* Processed note */
														$pfullnote = null;
														$pnote = null;
															$elipsis = "...";
															$pfullnote = $remark->remark;
															$pnote = substr($pfullnote,0, MAX_COLUMN_TEXT);

															if (strlen($pfullnote) > MAX_COLUMN_TEXT)
																$pnote = $pnote . $elipsis;
													?> 
													<span title='{{$pfullnote}}'>{{$pnote}}</span>															
													@endif
												</a>
										</td> -->
                                        <td id="status_column" class="text-center" style="vertical-align:middle;">
											<a target="_blank"  href="{{route('employeeApproval', ['id' => $employee->id])}}">
												<span id="status_column_text">
													{{ucfirst($employee->status)}}
												</span>
											</a>
                                        </td>
                                       <!-- <td>
                                            <div class="action_buttons">
                                                <?php
                                                $approve = new Classes\Approval('employee', $employee->id);
                                                if ($employee->status == 'active') {
                                                    $approve->getSuspendButton();
                                                } else if ($employee->status == 'suspended' || $employee->status == 'rejected') {
                                                    $approve->getReactivateButton();
                                                }
                                                echo $approve->view;
                                                ?>
                                            </div>
                                        </td>-->
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>

                {{--Model Form Start--}}
<div class="modal fade" id="myModal2" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 50%">
        <div class="modal-content" style='max-height: 500px; overflow-y: scroll;'>
            <div class="modal-body">
                <h3 id="modal-Tittle2"></h3>
                <div id="myBody2">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>

        </div>
    </div>
</div>
<div class="modal fade" id="myModalDocument" role="dialog" aria-labelledby="myModalDocument">
    <div class="modal-dialog" role="document" style="width: 60%">
        <div class="modal-content" style='max-height: 500px; overflow-y: scroll;'>
            <form class="form-horizontal" action="#" method="post" id="updateDocuments" enctype="multipart/form-dataaa">
                <input type="hidden" value="" id="document_emp_id" name="id" />
                <div class="modal-body">
                    <h3 id="modal-TittleDocument"></h3>
                        <div id="myBodyDocument"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" id="updateDocumentsButton" class="btn btn-primary btn-title">Save</button>
                </div>
            </form>

        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modalposition" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 50%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Position/Roles Details</h4>
            </div>
            <div class="modal-body">
                <h3 id="modal-Tittle"></h3>
                <div id="myBody">

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
<div class="modal fade" id="modalpayment" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 50%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Payment Details</h4>
            </div>
            <div class="modal-body">
                <h3 id="modal-Tittle"></h3>
				<input type="hidden" value="0" id="payment_employee" />
				<input type="hidden" value="0" id="bank_account_id" />
                <table class='table table-bordered' cellspacing='0' width='100%' >
                        <tr>
                            <td style='background-color: #000; color: #fff;'>Monthly Salary</td>
                            <td>
                                <input class="form-control" type="text" value="0.00" id="salary">
                            </td>
                        </tr>
                        <tr>
                            <td style='background-color: #000; color: #fff;'>Account Name</td>
                            <td>
                                <input class="form-control" type="text" value="" id="account_name" placeholder="Enter Account Name">
                            </td>
                        </tr>
                        <tr>
                            <td style='background-color: #000; color: #fff;'>Account Number</td>
                            <td>
								<input class="form-control" type="text" value="" id="account_number" placeholder="Enter Account Number">
                            </td>
                        </tr>
                        <tr>
                            <td style='background-color: #000; color: #fff;'>Bank</td>
                            <td>
								<select id="bank">
									
								</select>
                            </td>
                        </tr>
                        <tr>
                            <td style='background-color: #000; color: #fff;'>IBAN</td>
                            <td>
								<input class="form-control" type="text" value="" id="iban" placeholder="Enter IBAN">
                            </td>
                        </tr>
                        <tr>
                            <td style='background-color: #000; color: #fff;'>SWIFT</td>
                            <td>
								<input class="form-control" type="text" value="" id="swift" placeholder="Enter SWIFT">
                            </td>
                        </tr>
                    </tbody>
                </table>
				<button type="submit" id="save_payment" class="btn btn-primary pull-right">Save</button>
				<br><br>
            </div>
			
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>

        </div>
    </div>
</div>

<div class="modal fade" id="modalpcb" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 80%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">PCB Details</h4>
            </div>
            <div class="modal-body">
                <h3 id="modal-Tittle"></h3>
			<form class="form-horizontal" action="#" id="pcbEmployee">
				<input type="hidden" name="user_id_edit" id="user_id_edit" value="0">
				<div class="form-group">

					<label for="disabled" class="col-sm-3 control-label">
						Disabled person?</label>
					<div class="col-sm-3">
						<input type="checkbox" name="disabled_edit" id="disabled_edit" value="disabled_edit">
					</div>
				</div>		

				<div class="form-group">

					<label for="marital_status_edit" class="col-sm-3 control-label">Marital Status</label>
					<div class="col-sm-3">
						<select class="bootstrap-select" id="marital_status_edit">
							<option value="single">Single</option>
							<option value="married">Married</option>
							<option value="divorced">Divorced</option>
							<option value="widowed">Widowed</option>
						</select>														
					</div>

					<label for="child" class="col-sm-3 control-label">Number of Child
						</label>
					<div class="col-sm-3">
						<select class="bootstrap-select" id="child_edit">
							<option value="0">0</option>
							@for($p=1;$p<30;$p++)
								<option value="{{$p}}">{{$p}}</option>
							@endfor
						</select>							   
					</div>
				</div>		

				<div class="form-group">

					<label for="spouse" class="col-sm-3 control-label">Number of Spouses</label>
					<div class="col-sm-3">
						<input type="text" class="form-control" id="spouse_edit"
							   placeholder="Enter Number of Spouses">								
						
					</div>

					<label for="child_underage" class="col-sm-3 control-label">Number of Child Underage
						</label>
					<div class="col-sm-3">
						<input type="text" class="form-control" id="child_underage_edit"
							   placeholder="Enter Number of Childs Underage">
					</div>
				</div>		

				<div class="form-group">

					<label for="spouse_no_income" class="col-sm-3 control-label">Number of Spouses with No Income</label>
					<div class="col-sm-3">
						<input type="text" class="form-control" id="spouse_no_income_edit"
							   placeholder="Enter Number of Spouses No Income">								
						
					</div>

					<label for="child_above" class="col-sm-3 control-label">Number of Child 18 and above studying at tertiary level
						</label>
					<div class="col-sm-3">
						<input type="text" class="form-control" id="child_above_edit"
							   placeholder="Enter Number of Childs at tertiary level">
					</div>
				</div>		

				<div class="form-group">

					<label for="spouse_disabled" class="col-sm-3 control-label">Number of Spouses Disabled</label>
					<div class="col-sm-3">
						<input type="text" class="form-control" id="spouse_disabled_edit"
							   placeholder="Enter Number of Spouses Disabled">								
						
					</div>

					<label for="child_adopted" class="col-sm-3 control-label">Number of Child Adopted
						</label>
					<div class="col-sm-3">
						<input type="text" class="form-control" id="child_adopted_edit"
							   placeholder="Enter Number of Childs Adopted">
					</div>
				</div>	
				<button type="submit" id="save_edit_pcb" class="btn btn-primary">Save</button>
            </div>
			
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>

        </div>
    </div>
</div>


                <!-- Modal  -->
                <div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document" style="width: 80%">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Add Employee</h4>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal" action="#" id="addEmployee">

                                    <div class="form-group">
                                        <label for="emp-user-id" class="col-sm-3 control-label">User ID</label>
                                        <div class="col-sm-3">

                                            <select class="bootstrap-select" id="emp-user-id">
                                                @foreach($users as $user)
                                                    <option value="{{$user->id}}">{{$user->first_name}} {{$user->last_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <label for="emp-position" class="col-sm-3 control-label">Position</label>
                                        <div class="col-sm-3">
                                            <select class="bootstrap-select" id="emp-position">
                                                @foreach($positions as $position)
                                                    <option value="{{$position->id}}">{{$position->description}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label for="emp-monthly-salary" class="col-sm-3 control-label">Monthly
                                            Salary</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="emp-monthly-salary"
                                                   placeholder="Enter monthly salary">
                                        </div>


                                        <label for="emp-socso-no" class="col-sm-3 control-label">SOCSO No</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="emp-socso-no"
                                                   placeholder="Enter SOCSO No">
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label for="emp-bank-id" class="col-sm-3 control-label">Bank</label>
                                        <div class="col-sm-3">
                                            <select id="emp-bank-id" class="bootstrap-select">
                                                @foreach($banks as $bank)
                                                    <option value="{{$bank->id}}">{{$bank->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>


                                        <label for="emp-pcb" class="col-sm-3 control-label">PCB</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="emp-pcb"
                                                   placeholder="Enter pcb">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="emp-account-name" class="col-sm-3 control-label">Account
                                            Name</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="emp-account-name"
                                                   placeholder="Enter Account Name">
                                        </div>
                                        <label for="emp-epf-no" class="col-sm-3 control-label">EPF No</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="emp-epf-no"
                                                   placeholder="Enter EPF No">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="emp-ban" class="col-sm-3 control-label">
                                            IBAN</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="emp-iban"
                                                   placeholder="Enter IBAN">
                                        </div>
                                        <label for="emp-visa-no" class="col-sm-3 control-label">VISA No</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="emp-visa-no"
                                                   placeholder="Enter VISA No">
                                        </div>
                                    </div>

                                    <div class="form-group">

                                        <label for="emp-account-no" class="col-sm-3 control-label">Account
                                            No</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="emp-account-no"
                                                   placeholder="Enter Account No">
                                        </div>

                                        <label for="emp-source-user-id" class="col-sm-3 control-label">Recruiter
                                            ID</label>
                                        <div class="col-sm-3">
                                            <select class="bootstrap-select" id="emp-source-user-id">
                                                @foreach($users as $user)
                                                    <option value="{{$user->id}}">{{$user->first_name}} {{$user->last_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>


                                    <div class="form-group">

                                        <label for="emp-swift" class="col-sm-3 control-label">
                                            SWIFT</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="emp-swift"
                                                   placeholder="Enter SWIFT">
                                        </div>
                                    </div>
									
									<hr>
									
									<h3>PCB Form</h3>
									
                                    <div class="form-group">

                                        <label for="disabled" class="col-sm-3 control-label">
                                            Disabled person?</label>
                                        <div class="col-sm-3">
											<input type="checkbox" name="disabled" id="disabled" value="disabled">
                                        </div>
                                    </div>		

                                    <div class="form-group">

                                        <label for="marital_status" class="col-sm-3 control-label">Marital Status</label>
                                        <div class="col-sm-3">
                                            <select class="bootstrap-select" id="marital_status">
                                                <option value="single">Single</option>
                                                <option value="married">Married</option>
                                                <option value="divorced">Divorced</option>
                                                <option value="widowed">Widowed</option>
                                            </select>										
                                            
                                        </div>

                                        <label for="child" class="col-sm-3 control-label">Number of Child
                                            </label>
                                        <div class="col-sm-3">
                                            <select class="bootstrap-select" id="child">
                                                <option value="0">0</option>
                                                @for($p=1;$p<30;$p++)
													<option value="{{$p}}">{{$p}}</option>
												@endfor
                                            </select>
                                        </div>
                                    </div>		

                                    <div class="form-group">

                                        <label for="spouse" class="col-sm-3 control-label">Number of Spouses</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="spouse"
                                                   placeholder="Enter Number of Spouses" disabled>								
                                            
                                        </div>

                                        <label for="child_underage" class="col-sm-3 control-label">Number of Child Underage
                                            </label>
                                        <div class="col-sm-3">
											<input type="text" class="form-control" id="child_underage"
                                                   placeholder="Enter Number of Childs Underage" disabled>
                                        </div>
                                    </div>		

                                    <div class="form-group">

                                        <label for="spouse_no_income" class="col-sm-3 control-label">Number of Spouses with No Income</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="spouse_no_income"
                                                   placeholder="Enter Number of Spouses No Income" disabled>								
                                            
                                        </div>

                                        <label for="child_above" class="col-sm-3 control-label">Number of Child 18 and above studying at tertiary level
                                            </label>
                                        <div class="col-sm-3">
											<input type="text" class="form-control" id="child_above"
                                                   placeholder="Enter Number of Childs at tertiary level" disabled>
                                        </div>
                                    </div>		

                                    <div class="form-group">

                                        <label for="spouse_disabled" class="col-sm-3 control-label">Number of Spouses Disabled</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="spouse_disabled"
                                                   placeholder="Enter Number of Spouses Disabled" disabled>								
                                            
                                        </div>

                                        <label for="child_adopted" class="col-sm-3 control-label">Number of Child Adopted
                                            </label>
                                        <div class="col-sm-3">
											<input type="text" class="form-control" id="child_adopted"
                                                   placeholder="Enter Number of Childs Adopted" disabled>
                                        </div>
                                    </div>										


<!--                                     <div class="form-group">
                                        <div class="col-sm-offset-1 col-sm-2">
                                            <div class="checkbox-inline">
                                                <label>
                                                    <input type="checkbox" id="emp-has-open-wish"> Has Open
                                                    Wish
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-sm-offset-1 col-sm-2">
                                            <div class="checkbox-inline">
                                                <label>
                                                    <input type="checkbox" id="emp-has-smm"> Has SMM
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-sm-offset-1 col-sm-2">
                                            <div class="checkbox-inline">
                                                <label>
                                                    <input type="checkbox" id="emp-has-auction"> Has Auction
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-sm-offset-1 col-sm-2">
                                            <div class="checkbox-inline">
                                                <label>
                                                    <input type="checkbox" id="emp-has-open-business"> Has Open
                                                    Business
                                                </label>
                                            </div>
                                        </div>
                                    </div> -->

                                    {{--<button type="submit" class="btn btn-default">Save</button>--}}
                                    <input type="hidden" id="emp-emp-id" value="">
                            {{--</div>--}}
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary btn-title">Save</button>
                                    </div>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
            {{--Model Form End--}}

            <div class="modal fade" id="modalManageEmployeeAttachment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabelEmployeeAttachment">Manage Attachments</h4>
                        </div>
                        <div class="modal-body">
                            <div id="alert-info"></div>
                            <div class="well">
                                <table class="table table-hover">
                                    <tbody><tr>
                                      <th>Type</th>
                                      <th>Name</th>
                                      <th>Date</th>
                                      <th>Description</th>
                                    </tr>
                                    <tr>
                                      <td><span class="label label-success">PNG</span></td>
                                      <td>Picture</td>
                                      <td>11-7-2014</td>
                                      <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                                    </tr>
                                    <tr>
                                      <td><span class="label label-warning">ZIP</span></td>
                                      <td>Project</td>
                                      <td>11-7-2014</td>
                                      <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                                    </tr>
                                    <tr>
                                      <td><span class="label label-primary">PDF</span></td>
                                      <td>CV</td>
                                      <td>11-7-2014</td>
                                      <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                                    </tr>
                                    <tr>
                                      <td><span class="label label-danger">DOC</span></td>
                                      <td>Letter</td>
                                      <td>11-7-2014</td>
                                      <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                                    </tr>
                                  </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>

                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
        </div>
    </div>
	<div id="admindialog" title="Top Management Approver" style="display:none">
		<p>Enter password</p>
		<input type="password" id="user_pass" size="25" />
		<input type="hidden" id="useradmin" value="0" />
		<input type="button" id="change_admin" class="btn btn-primary" value="Confirm" style="margin-top: 10px;">
		<p style="color: red; display: none;" id="wrong_pass" style="margin-top: 10px;">Wrong password, please, try again.</p>
		<p style="color: green; display: none;" id="sucess_pass" style="margin-top: 10px;">Status successfully changed!</p>
	</div>	
    <meta name="_token" content="{!! csrf_token() !!}"/>
    <script type="text/javascript">
        $(document).ready(function () {
			$('.hover-long-text').tooltip();
			function pad (str, max) {
				str = str.toString();
				return str.length < max ? pad("0" + str, max) : str;
			}

			 $(document).delegate( '#change_admin', "click",function (event) {
				console.log("passs");
				var userid = $("#useradmin").val();
				var password = $("#user_pass").val();
				var formData = {
                    userid: userid,
                    password: password
				}
				$.ajax({
					type: "POST",
					url: JS_BASE_URL + "/changeadmin",
					data: formData,
					dataType: 'json',
					success: function (data) {
						if(data.response == 0){
							$("#wrong_pass").show();
							setTimeout(function(){
								$("#wrong_pass").hide();
							}, 4000);
							setTimeout(function(){
								$("#user_pass").val("");
							}, 10000);							
						} else {
							var ischecked = $("#isadmin" + userid).is(":checked");
							$("#isadmin" + userid).prop("checked", !ischecked);
							$("#sucess_pass").show();						
							setTimeout(function(){
								$("#user_pass").val("");
								$("#sucess_pass").hide();
								$("#admindialog").dialog("close");
							}, 3000);							
						}
						/*$(".success-msg").fadeIn();
						$(".success-msg").text("Employee successfully removed.");
						$(".success-msg").fadeOut(4000);*/
					},
					error: function (error) {
						console.log(error);
					}

				});				
			});
			
            $(document).delegate( '.isadmin', "click",function (event) {
				var userid = $(this).attr("rel");
				$("#useradmin").val(userid);
				var ischecked = $(this).is(":checked");
				$(this).prop("checked", !ischecked);			
				$( "#admindialog" ).dialog();
				//alert($(this).is(":checked"));
            })
			
			var formSubmitType = null;
            $("#emp-payment-id").change(function () {
                $('#emp-bank-id').attr('disabled', true);
                $('#emp-account-name').attr('disabled', true);
                $('#emp-account-no').attr('disabled', true);
                $('#emp-swift').attr('disabled', true);
                $('#emp-iban').attr('disabled', true);
            });
            $('#emp-bank-id').change(function () {
                $('#emp-payment-id').attr('disabled', true);
                $('#emp-payment-credential').attr('disabled', true);
            })
            //Handle Check Box Change
            $("input[type='checkbox']").on("change", function () {
                if ($(this).is(":checked"))
                    $(this).val("1");
                else
                    $(this).val("0");
            });

            //Function To handle add button action
            $(document).delegate( '#btn-add', "click",function (event) {
                console.log('adding');
                formSubmitType = "add";
                $(".modal-title").text("Add Employee");
                $("#addEmployee").trigger("reset");
                $("#myModal").modal("show");

            })

            //Function To Handle Edit Button action
            $(document).delegate( '#btn-edit', "click",function (event) {
                $("#addEmployee").trigger("reset");
                $("#myModal").modal("hide");

                var val = $(this).attr('value');
                console.log(val);
                var url = "../../admin/general/employees/" + val + "/edit";
                formSubmitType = "edit";
                $(".modal-title").text("Edit Employee");

                $.ajax({
                    type: "GET",
                    url: url,
                    dataType: 'json',
                    success: function (data) {
                        console.log(data);


                        $("#emp-user-id").val(data[0]["user_id"]);
                        $("#emp-position").val(data[0]["position"]);
                        $("#emp-visa-no").val(data[0]["visa_no"]);
                        $("#emp-socso-no").val(data[0]["socso_no"]);
                        $("#emp-epf-no").val(data[0]["epf_no"]);
                        $("#emp-pcb").val(data[0]["pcb"]);
                        $("#emp-monthly-salary").val(data[0]["monthly_salary"]);
                        $("#emp-has-open-wish").val(parseInt(data[0]["has_openwish"])).prop("checked", parseInt(data[0]["has_openwish"]) == 1 ? true : false);
                        $("#emp-has-smm").val(data[0]["has_smm"]).prop("checked", parseInt(data[0]["has_smm"]) == 1 ? true : false);
                        $("#emp-has-auction").val(data[0]["has_auction"]).prop("checked", parseInt(data[0]["has_auction"]) == 1 ? true : false);
                        $("#emp-has-open-business").val(data[0]["has_openbusiness"]).prop("checked", parseInt(data[0]["has_openbusiness"]) == 1 ? true : false);
                        $("#emp-source-user-id").val(data[0]["source_user_id"]);
                        $("#emp-payment-id").val(data[0]["payment_id"]);
                        $("#emp-payment-credential").val(data[0]["payment_credential"]);

                        $("#emp-bank-id").val(data[1]["bank_id"]);
                        $("#emp-account-no").val(data[1]["account_number1"]);
                        $("#emp-account-name").val(data[1]["account_name1"]);
                        $("#emp-iban").val(data[1]["iban"]);
                        $("#emp-swift").val(data[1]["swift"]);

                        $("#emp-emp-id").val(data[0]["id"]);


                        if (data[0]['payment_id'] == null) {
                            $('#emp-payment-id').attr('disabled', true);
                        }

                        if (data[0]['bankaccount_id'] == null) {
                            $('#emp-bank-id').attr('disabled', true);
                            $('#emp-account-name').attr('disabled', true);
                            $('#emp-account-no').attr('disabled', true);
                            $('#emp-swift').attr('disabled', true);
                            $('#emp-iban').attr('disabled', true);
                        }

                        $("#myModal").modal("show");
                    },
                    error: function (error) {
                        console.log(error);
                    }

                });

            })

            //Delete Recored
            $(document).delegate( '#btn-delete', "click",function (event) {
                if (confirm('Are you sure you want to remove Employee Record?')) {
                    var id = $(this).attr("value");
                    var my_url = '../../admin/general/employees/' + id;
                    var method = "DELETE";

                    $.ajax({
                        type: method,
                        url: my_url,
                        dataType: 'json',
                        success: function (data) {
                            $(".success-msg").fadeIn();
                            $(".success-msg").text("Employee successfully removed.");
                            $(".success-msg").fadeOut(4000);
                        },
                        error: function (error) {
                            console.log(error);
                        }

                    });

                }


            })

            //Handle Form Submit For Bothh Add and Edit
            $(document).delegate( '#addEmployee', "submit",function (event) {


                var method = null;
                var my_url = null;
                var id = null;


                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                event.preventDefault();


                if (formSubmitType == null) {
                    return false;
                }

                if (formSubmitType == "edit") {
                    id = $("#emp-emp-id").val();
                    method = 'PUT';
                    my_url = '../../admin/general/employees/' + id;
                }

                if (formSubmitType == "add") {
                    method = 'POST';
                    my_url = '../../admin/general/employees';
                }

                var formData = {
                    user_id: $("#emp-user-id").val(),
                    position: $("#emp-position").val(),
                    visa_no: $("#emp-visa-no").val(),
                    socso_no: $("#emp-socso-no").val(),
                    epf_no: $("#emp-epf-no").val(),
                    pcb: $("#emp-pcb").val(),
                    monthly_salary: $("#emp-monthly-salary").val(),
                    has_openwish: parseInt($("#emp-has-open-wish").val()),
                    has_smm: parseInt($("#emp-has-smm").val()),
                    has_auction: parseInt($("#emp-has-auction").val()),
                    has_openbusiness: parseInt($("#emp-has-open-business").val()),
                    source_user_id: $("#emp-source-user-id").val(),
                    payment_id: $("#emp-payment-id").val(),
                    payment_credential: $("#emp-payment-credential").val(),

                    bank_id: $("#emp-bank-id").val(),
                    account_no: $("#emp-account-no").val(),
                    account_name: $("#emp-account-name").val(),
                    iban: $("#emp-iban").val(),
                    swift: $("#emp-swift").val(),
					
                    disabled: $("#disabled").is(':checked'),
                    marital_status: $("#emp-marital_status-id").val(),
                    child: $("#child").val(),
                    spouse: $("#spouse").val(),
                    spouse_disabled: $("#spouse_disabled").val(),
                    spouse_no_income: $("#spouse_no_income").val(),
					child_underage: $("#child_underage").val(),					
					child_above: $("#child_above").val(),					
					child_adopted: $("#child_adopted").val()					
                }
                console.log(formData);
                $.ajax({
                    type: method,
                    url: my_url,
                    data: formData,
                    dataType: 'json',
                    success: function (data) {
//                        console.log(data);


                        $('#emp-payment-id').attr('disabled', false)
                        $('#emp-bank-id').attr('disabled', false);
                        $('#emp-account-name').attr('disabled', false);
                        $('#emp-account-no').attr('disabled', false);
                        $('#emp-swift').attr('disabled', false);
                        $('#emp-iban').attr('disabled', false);

                        $('#myModal').modal('hide');
                        $(".success-msg").fadeIn();
                        if (formSubmitType == 'edit') {
                            $(".success-msg").text("Employee successfully updated.");
                        } else {
                            $(".success-msg").text("Employee successfully added.");
                        }
                        $(".success-msg").fadeOut(4000);
                        formSubmitType = null;
                    },
                    error: function (error) {
                        console.log(error);
                    }

                });

            })

			$(".switch-state").bootstrapSwitch();
			var image_table = $('#employee_grid').DataTable({
				order: [],
				'scrollX':true,
				"columnDefs": [
					{ "orderable": false, "targets": 0 },
					{"targets" : 0, "orderable": false, "defaultContent": "" },
					{"targets": "no-sort", "orderable": false},
					{"targets": "medium", "width": "80px"},
					{"targets": "large",  "width": "120px"},
					{"targets": "bsmall",  "width": "20px"},
					{"targets": "approv", "width": "180px"}, //Approval buttons
					{"targets": "blarge", "width": "200px"}, // *Names
					{"targets": "clarge", "width": "250px"},
					{"targets": "xlarge", "width": "300px"}, //Remarks + Notes   
					{ className: "dt-center", "targets": [ 0,1,2,3,4,5,6,7,8 ] },
				],
				// 'colReorder': true,
				// 'scrollY':true,
				// 'autoWidth':false,
				// "fixedHeader": true,
				"fnDrawCallback":function(){
					table_rows = this.fnGetNodes();
					$.each(table_rows, function(index){
						$("td:first", this).html(index+1);
					});
				}
			});
			 $('.switch-state').on('switchChange.bootstrapSwitch', function(event, state) {
				event.preventDefault();

				// Get the column API object
				var column = image_table.column( $(this).attr('data-column') );

				// Toggle the visibility
				column.visible( ! column.visible() );
			} );

		    $(document).delegate( '.emprid', "click",function (event) {
				_this = $(this);
				var id_employee= _this.attr('rel');

				$('#modal-Tittle2').html("Remarks");

				var url = '/admin/master/employee_remarks/'+ id_employee;
				$.ajax({
					type: "GET",
					url: url,
					dataType: 'json',
					success: function (data) {
						console.log(data);
						var html = "<table class='table table-bordered' cellspacing='0' width='100%' style='text-align:center;'><tr style='background-color: #000; color: white;'><th>No</th><th>Merchant ID</th><th>Status</th><th>Admin User ID</th><th>Remarks</th><th>DateTime</th></tr>";
						for (i=0; i < data.length; i++) {
							var obj = data[i];
							html += "<tr>";
							html += "<td>"+(i+1)+"</td>";
							html += "<td><a href='../../admin/popup/merchant/"+id_employee+"' class='update' data-id='"+id_employee+"'>["+pad(id_employee.toString(),10)+"]</a></td>";
							html += "<td>"+obj.status+"</td>";
							html += "<td><a href='../../admin/popup/user/"+obj.user_id+"' class='update' data-id='"+obj.user_id+"'>["+pad(obj.user_id.toString(),10)+"]</a></td>";
							html += "<td>"+obj.remark+"</td>";
							html += "<td>"+obj.created_at+"</td>";
							html += "</tr>";
						}
						html = html + "</table>";
						$('#myBody2').html(html);
						$("#myModal2").modal("show");
					}
				});
			});
        });

	$(document).delegate( '#save_edit_pcb', "click",function (event) {
		event.preventDefault();
		$("#save_edit_pcb").html("Saving...");
		var formData = {
			user_id: $("#user_id_edit").val(),			
			disabled: $("#disabled_edit").is(':checked'),
			marital_status: $("#marital_status_edit").val(),
			child: $("#child_edit").val(),
			spouse: $("#spouse_edit").val(),
			spouse_disabled: $("#spouse_disabled_edit").val(),
			spouse_no_income: $("#spouse_no_income_edit").val(),
			child_underage: $("#child_underage_edit").val(),					
			child_above: $("#child_above_edit").val(),					
			child_adopted: $("#child_adopted_edit").val()					
		}	
		console.log(formData);
		$.ajax({
			type: "POST",
			url: JS_BASE_URL + "/edit_employee_pcb",
			data: formData,
			success: function (data) {
               console.log(data);
			   $("#save_edit_pcb").html("Saved!");
			   setTimeout(function(){
				   $("#save_edit_pcb").html("Save");
				   $("#modalpcb").modal("hide");
				}, 3000);
			},
			error: function (error) {
				console.log(error);
			}

		});		
	});
		
		
    $(document).delegate( '.position', "click",function (event) {
        _this = $(this);
		var employer_id= _this.attr('rel');

		$('#modal-Tittle').html("Position");

		var url = '/admin/master/employee_roles/'+ employer_id;
		$.ajax({
			type: "GET",
			url: url,
			dataType: 'json',
			success: function (data) {
				//console.log(data);
				var html = "<table class='table table-bordered' cellspacing='0' width='100%'' >";
                html = html + "<tr><th style='background-color: black; color: #fff;' width='50%'>Position</th><td><select id='position_select'><option value='0'>None Selected</option>";
				var selected_position = "";
				for (i=0; i < data.positions.length; i++) {
					selected_position = "";
					if(data.position_id == data.positions[i].id){
						selected_position = "selected";
					}
					html = html + "<option value="+ data.positions[i].id +" "+selected_position+">"+data.positions[i].description+"</option>";
				}
				html = html + "</select></td></tr>";
				html = html + "</table>";
				html = html + '<button type="button" id="save_position" class="btn btn-primary btn-title pull-right" >Save</button><br><br>';
				$('#myBody').html(html);
				$("#position_select").select2();
				$('#save_position').click(function (event) {
					$("#save_position").html("Saving...");
					var url = '/admin/master/employee_position/'+ employer_id + '/' + $("#position_select").val();
					console.log(url);
					$.ajax({
						type: "POST",
						url: url,
						success: function (data) {
							$("#modalposition").modal("hide");
						}
					});
				});				
				$("#modalposition").modal("show");
		  	}
		});

	});
	
	$(document).delegate( '#marital_status', "change",function (event) {
		if($(this).val()=='married'){
			$("#spouse_disabled").prop('disabled', false);
			$("#spouse").prop('disabled', false);
			$("#spouse_no_income").prop('disabled', false);			
		} else {
			$("#spouse_disabled").prop('disabled', true);
			$("#spouse").prop('disabled', true);
			$("#spouse_no_income").prop('disabled', true);
			$("#spouse_disabled").val("");
			$("#spouse").val("");
			$("#spouse_no_income").val("");			
		}
	});
	
	$(document).delegate( '#child', "change",function (event) {
		if($(this).val()=='0'){
			$("#child_adopted").prop('disabled', true);
			$("#child_underage").prop('disabled', true);
			$("#child_above").prop('disabled', true);	
			$("#child_adopted").val("");
			$("#child_underage").val("");
			$("#child_above").val("");				
		} else {
			$("#child_adopted").prop('disabled', false);
			$("#child_underage").prop('disabled', false);
			$("#child_above").prop('disabled', false);
		
		}
	});	

    $(document).delegate( '.employeepcb', "click",function (event) {
		_this = $(this);
		var employer_id= _this.attr('rel');
		$("#user_id_edit").val(employer_id);
		$('#modal-Tittle').html("PCB");

		var url = '/admin/master/employee_pcb/'+ employer_id;
		$.ajax({
			type: "GET",
			url: url,
			dataType: 'json',
			success: function (data) {
				//console.log(data);
				if (data != null){
					if(data.disabled){
						$("#disabled_edit").prop('checked', true);
					} else {
						$("#disabled_edit").prop('checked', false);
					}
					$("#marital_status_edit").val(data.status);
					$("#marital_status_edit").change();
					$("#child_edit").val(data.child);
					$("#child_edit").change();
					$("#child_adopted_edit").val(data.child_adopted);
					$("#child_underage_edit").val(data.child_underage);
					$("#child_above_edit").val(data.child_aboveage);
					$("#spouse_edit").val(data.spouse);
					$("#spouse_no_income_edit").val(data.spouse_no_income);
					$("#spouse_disabled_edit").val(data.spouse_disabled);
					$("#modalpcb").modal("show");					
				} else {
					$("#disabled_edit").prop('checked', false);
					$("#marital_status_edit").val("single");
					$("#marital_status_edit").change();
					$("#child_edit").val("0");
					$("#child_edit").change();
					$("#child_adopted_edit").val("0");
					$("#child_underage_edit").val("0");
					$("#child_above_edit").val("0");
					$("#spouse_edit").val("0");
					$("#spouse_no_income_edit").val("0");
					$("#spouse_disabled_edit").val("0");
					$("#modalpcb").modal("show");					
				}

		  	}
		});
	});	
	
	$(document).delegate( '#save_payment', "click",function (event) {
		event.preventDefault();
		var employeee_id = $("#payment_employee").val();
		var url = '/admin/master/employee_payment/'+ employeee_id;
		var formData = {
			bank_account_id: $("#bank_account_id").val(),			
			account_name: $("#account_name").val(),
			account_number: $("#account_number").val(),
			bank_code: $("#bank_code").val(),
			iban: $("#iban").val(),
			swift: $("#swift").val(),
			salary: $("#salary").val(),					
			bank: $("#bank").val()				
		}	
		console.log(formData);
		$.ajax({
			type: "POST",
			url: url,
			data: formData,
			success: function (data) {
				$("#modalpayment").modal("hide");
			}
		});
	});
	
    $(document).delegate( '.payment', "click",function (event) {
		_this = $(this);
		var employer_id= _this.attr('rel');

		$('#modal-Tittle').html("Payment");

		var url = '/admin/master/employee_payment/'+ employer_id;
		$.ajax({
			type: "GET",
			url: url,
			dataType: 'json',
			success: function (data) {
				console.log(data);
				$('#payment_employee').val(employer_id);
				$('#bank').html('');
				$("#bank_account_id").val(data[8]);
				$("#account_name").val(data[0]);
				$("#account_number").val(data[1]);
			//	$("#bank").text(data[2]);
				var bank_selected = "";
				for (i=0; i < data[7].length; i++) {
					bank_selected = "";
					if(data[7][i].id == data[2]){
						bank_selected = "selected";
					}
					$("#bank").append("<option value='"+data[7][i].id+"' "+bank_selected+">"+data[7][i].name+"</option>")
				}
				$("#iban").val(data[4]);
				$("#swift").val(data[5]);
				$("#salary").val(data[6]).number(true, 2);
				$("#modalpayment").modal("show");
		  	}
		});
	});
    var num = 0;
    $(document).delegate( '.employeedocument', "click",function (event) {// <-- notice where the selector and event is
        _this = $(this);
        var employer_id= _this.attr('rel');

        $('#modal-TittleDocument').html("Documents");

        var url = '/admin/master/employee_document/'+ employer_id;
        $.ajax({
            type: "GET",
            url: url,
            dataType: 'json',
            success: function (data) {
                console.log(data);
                $("#document_emp_id").val(employer_id);
                var html = "<table id='tableDocument' class='table table-bordered' cellspacing='0' width='100%''><tr style='background-color:black;color:white;'><th class='text-center'>No</th><th class='text-center'>Documents</th><th class='text-center'>Number</th><th class='text-center'>Attachment</th><th></th></tr>";
                if(data.length == 0){
                    html = html + "<tr> <td class='text-center' style='vertical-align:middle'>1</td> <td style='vertical-align:middle'>VISA File No.<input type='hidden' value='No VISA File' name='name[]' /></td> <td><input type='text' value='' name='number[]' /></td> <td class='text-center' style='vertical-align:middle'><input type='file' class='uploadDocument' name='document[]' /></td> <td></td> </tr>";
                    html = html + "<tr> <td class='text-center style='vertical-align:middle'>2</td> <td style='vertical-align:middle'>SOCSO&nbsp;File&nbsp;No.<input type='hidden' value='No SOCSO File' name='name[]' /></td> <td><input type='text' value='' name='number[]' /></td> <td class='text-center' style='vertical-align:middle'><input type='file' class='uploadDocument' name='document[]' /></td> <td></td> </tr>";
                    html = html + "<tr> <td class='text-center' style='vertical-align:middle'>3</td> <td style='vertical-align:middle'>EPF File No.<input type='hidden' value='EPF File No.' name='name[]' /></td> <td><input type='text' value='' name='number[]' /></td> <td class='text-center' style='vertical-align:middle'><input type='file' class='uploadDocument' name='document[]' /></td> <td></td> </tr>";
                    html = html + "<tr> <td class='text-center' style='vertical-align:middle'>4</td> <td style='vertical-align:middle'>PCB File No.<input type='hidden' value='PCB File No.' name='name[]' /></td> <td><input type='text' value='' name='number[]' /></td> <td><input type='file' class='uploadDocument' name='document[]' /></td> <td> <a href='javascript:void(0);' id='addrowDocument' class='form-control text-center text-green'> <i class='fa fa-plus-circle'></i> </a> </td> </tr>";
                    num = 4;
                }else{
                    for (i=0; i < data.length; i++) {
                        var obj = data[i];
                        var link = "";
                        if(obj.path != '')
                        {
                            link = "<a href='"+JS_BASE_URL+"/images/employee/"+employer_id+"/"+obj.path+"' target='_blank'>["+obj.path+"]</a>";
                        }

                        if (i<3){
                            html = html + "<tr> <td class='text-center' style='vertical-align:middle'>"+(i+1)+"</td> <td style='vertical-align:middle'>"+obj.name+"<input type='hidden' value='"+obj.name+"' name='name[]' /></td> <td style='vertical-align:middle'><input type='text' value='"+obj.number+"' name='number[]' /></td> <td style='vertical-align:middle'>"+link+"<input type='file' class='uploadDocument' value='' name='document[]' /><input type='hidden' value='"+obj.path+"' name='document_old[]' /></td> <td></td> </tr>";
                        }else if (i==3){
                            html = html + "<tr> <td class='text-center' style='vertical-align:middle'>"+(i+1)+"</td> <td style='vertical-align:middle'>"+obj.name+"<input type='hidden' value='"+obj.name+"' name='name[]' /></td> <td style='vertical-align:middle'><input type='text' value='"+obj.number+"' name='number[]' /></td> <td style='vertical-align:middle'>"+link+"<input type='file' class='uploadDocument' value='' name='document[]' /><input type='hidden' value='"+obj.path+"' name='document_old[]' /></td> <td style='vertical-align:middle'> <a href='javascript:void(0);' id='addrowDocument' class='form-control text-center text-green'> <i class='fa fa-plus-circle'></i> </a> </td> </tr>";
                        }else{
                            html = html + "<tr> <td class='text-center' style='vertical-align:middle'>"+(i+1)+"</td> <td style='vertical-align:middle'><input type='text' value='"+obj.name+"' name='name[]' /></td> <td style='vertical-align:middle'><input type='text' value='"+obj.number+"' name='number[]' /></td> <td style='vertical-align:middle' class='textPreview' id='rowDoc_"+num+"'>"+link+"<input type='file' class='uploadDocument' value='' name='document[]' /><input type='hidden' value='"+obj.path+"' name='document_old[]' /> </td> <td style='vertical-align:middle'> <a href='javascript:void(0);' class='remspp form-control text-center text-danger'> <i class='fa fa-minus-circle'></i> </a> </td> </tr>";
                        }
                        num++;
                    }
                }

                html = html + "</table>";
                $('#myBodyDocument').html(html);
                $("#myModalDocument").modal("show");
            }
        });
    });

    $(document).delegate( '#addrowDocument', "click",function (event) {// <-- notice where the selector and event is
        num++;
        var html = "<tr> <td class='text-center' style='vertical-align:middle'>"+num+"</td> <td style='vertical-align:middle'><input type='text' value='' value='' name='name[]' /></td> <td style='vertical-align:middle'><input type='text' value='' name='number[]' /></td> <td style='vertical-align:middle' class='textPreview' id='rowDoc_"+num+"'> <input type='file' class='uploadDocument' value='' name='document[]' /> </td> <td style='vertical-align:middle'> <a href='javascript:void(0);' class='remspp form-control text-center text-danger'> <i class='fa fa-minus-circle'></i> </a> </td> </tr>";
        $('#tableDocument').append(html);

    });
    $(document).delegate( '.remspp', "click",function (event) {// <-- notice where the selector and event is
        num--;
        $(this).parent().parent().remove();
    });
    // $(document).delegate( '.uploadDocument', "change",function (event) {// <-- notice where the selector and event is
        // id=$(this).attr('id');
        // var files=""
        // var files = !!this.files ? this.files : [];
        // if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support

        // var reader = new FileReader(); // instance of the FileReader
        // reader.readAsDataURL(files[0]); // read the local file
        // reader.onloadend = function () { // set image data as background of divjquery ajax post multiple files upload
        //     $("#"+id).html("["+this.result+"]");
        // }

    // });

               //Handle Form Submit For Bothh Add and Edit
    // $("#updateDocuments").on('submit', function (event) {
    $(document).delegate( '#updateDocumentsButton', "click",function (event) {// <-- notice where the selector and event is

        var employer_id= $("#document_emp_id").val();
        var url = JS_BASE_URL + '/admin/master/employee_update_document';

        var formData = new FormData($("#updateDocuments")[0]);

        $.ajax({
            url: url,
            type:'post',
            data: formData,
            dataType:'json',
            processData: false,
            contentType: false,
            success: function (data) {
                //console.log(data);
                $('#myModalDocument').modal('hide');
                $(".success-msg").text("Documents Employee successfully updated.");
                $(".success-msg").fadeOut(4000);
            },
            error: function (error) {
                console.log(error);
            }
        });

    });
$('.view-employee-modal').click(function(){

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

$('.view-recruiter-modal').click(function(){

            var recruiter_id=$(this).attr('data-id');
            var check_url=JS_BASE_URL+"/admin/popup/lx/check/user/"+recruiter_id;
            $.ajax({
                url:check_url,
                type:'GET',
                success:function (r) {
                console.log(r);

                    if (r.status=="success") {
                    var url=JS_BASE_URL+"/admin/popup/user/"+recruiter_id;
                        var w=window.open(url,"_blank");
                        w.focus();
			}
	if (r.status=="failure") {
        var msg="<div class=' alert alert-danger'>"+r.long_message+"</div>";
        $('#recruiter-error-messages').html(msg);
        }
        }
        });
});


    </script>
<script type="text/javascript">
window.setInterval(function(){
              $('#employee-error-messages').empty();
            }, 10000);
window.setInterval(function(){
              $('#recruiter-error-messages').empty();
            }, 10000);
</script>
@stop

@section("extra-links")
<!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/u/bs/fc-3.2.2/datatables.min.css"/> -->
<style type="text/css">
    .my_class {
        vertical-align: middle;
    }
</style>
<link rel="stylesheet" href="{{asset('/css/bootstrap-switch.min.css')}}"/>
    <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/u/bs/b-1.2.0/datatables.min.css"/> -->
@stop

@section("scripts")

<script type="text/javascript" src="{{asset('/js/bootstrap-switch.min.js')}}"></script>
<!-- <script type="text/javascript" src="https://cdn.datatables.net/u/bs/fc-3.2.2/datatables.min.js"></script> -->
<!-- <script type="text/javascript" src="https://cdn.datatables.net/u/bs/b-1.2.0/datatables.min.js"></script> -->
@stop
