<?php 
define('MAX_COLUMN_TEXT', 20);
use App\Http\Controllers\IdController;
?>
<style>
	.storebutton{
		background-color: #FF3333 !important;
	}
</style>
	<div id="employees" class="tab-pane fade">
		<div class="row">
			<div class=" col-sm-6">
				<h2>Member List</h2>
			</div>
			<div class=" col-sm-6">
				<a class="add_row btn btn-info pull-right"
					href="javascript:void(0)">+ Add Member</a>
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
						<th class="text-center">Member&nbsp;ID</th>
						<th class="large text-center" style="width: 130px !important;">Name</th>
						<th class="text-center">Roles</th>
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
							<th colspan=5 ></th>
							<th colspan=3 >
								<a class="send_email btn btn-info storebutton"
									style="width:100%"
									href="javascript:void(0)">Store</a>
							</th>
						</tr>
					</tfoot>					
					<tbody>
					@foreach($members as $emps)
						<tr>
							<td class="text-center">{{$e}}</td>
							<td class="text-center">
								<?php $formatted_buyer_id =
									IdController::nB($emps->user_id); ?>
								<a href="javascript:void(0)"
								class="view-employee-modal"
								data-id="{{$emps->user_id }}"> 
								@if($emps->user_id > 0)
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
							$pfullnote = $emps->users_first_name ." ".
								$emps->users_last_name;
							$pnote = substr($pfullnote,0, MAX_COLUMN_TEXT);

							if (strlen($pfullnote) > MAX_COLUMN_TEXT)
								$pnote = $pnote . $elipsis;
							?> 
							<span title='{{$pfullnote}}'>{{$pnote}}</span>	
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
								@if($emps->status == 'not exists')
								@else
									<a href="javascript:void(0)" class="member_role" rel="{{$emps->user_id}}">Roles</a>
								@endif
							</td>
							<td class="text-center">
								@if($emps->status == 'not exists')
									{{ucfirst($emps->status)}}
								@else
									@if(Auth::user()->hasRole('adm'))
										<a target="_blank"
										href="{{route('employeeLogistic',
											['id' => $emps->user_id])}}">
											<span id="status_column_text">
												{{ucfirst($emps->status)}}
											</span>
										</a>
									@else
										<span id="status_column_text">
											{{ucfirst($emps->status)}}
										</span>
									@endif
								@endif
							</td>
							<td class="text-center">{{$emps->email}}</td>
							<td class="text-center">
								<input type='checkbox' class='sender'
								rel='{{$emps->email}}' /></td>
							<td class="text-center">
								<a  href="javascript:void(0);" class="text-danger delete_member" rel='{{$emps->email}}'><i class="fa fa-minus-circle fa-2x"></i></a>	
						</tr>
					<?php $e++;?>
					@endforeach
					</tbody>
				</table>
				<input type="hidden" value="{{$e}}" id="nume" /> 
				<input type="hidden" value="{{$logistic->id}}" id="lpeid" />
		</div>
		</div>    
	</div>
<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 20%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Roles</h4>
            </div>
            <div class="modal-body">
                <div id="myBody">
					@foreach($memberroles as $memberrole)
						<p><input type="checkbox" class="memberchek" rel="{{$memberrole->id}}" /> {{$memberrole->description}}</p>
					@endforeach
					<a class='btn btn-primary saveroles pull-right' href='javascript:void(0)' > Save</a>
					<br>
					<br>
					<input type="hidden" value="0" id="user_idrole" />
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>

        </div>
    </div>
</div> 	
<script type="text/javascript">
	function validateEmail(email) {
		var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return re.test(email);
	}
	
    $(document).ready(function(){
		var emp_table = $('#employee-table').DataTable({
            "order": [],
			 "columns": [
					{ "width": "20px", "orderable": false },
					{ "width": "120px" },
					{ "width": "180px" },
					{ "width": "80px" },
					{ "width": "80px" },
					{ "width": "180px" },
					{ "width": "20px" },
					{ "width": "20px" }
				]
			});		
			
		$(document).delegate( '.allsender', "click",function (event) {
			if($(this).prop('checked')){
				$(".sender").prop('checked',true);
			} else {
				$(".sender").prop('checked',false);
			}
		});			
			
		$(document).delegate( '.memberchek', "click",function (event) {
			if($(this).prop('checked')){
				$('.memberchek').prop('checked',false);
				$(this).prop('checked',true);
			}
		});	
			
		$(document).delegate( '.saveroles', "click",function (event) {
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
			$('.memberchek').each(function () {
				var key= $(this).attr('rel');
                if (this.checked) {
                    data[key]=true;
					countdata++;
                } else {
					data[key]=false;
				}
            });
			console.log(data);
			$.ajax({
				type: "POST",
				data: {data: data},
				url: "/seller/member/roles/" + userid,
				dataType: 'json',
				success: function (data) {
					console.log(data);
					toastr.info('Roles successfully changed!');
					obj.html('Save');
					$("#user_idrole").val(userid);
					$("#myModal").modal('toggle');
					//obj.html("Send");
				},
				error: function (error) {
					toastr.error("An unexpected error ocurred");
				}

			});
		});
			
		$(document).delegate( '.member_role', "click",function (event) {
			var obj = $(this);
			var userid = obj.attr('rel');
			$.ajax({
				type: "GET",
				url: "/seller/member/roles/" + userid,
				dataType: 'json',
				success: function (data) {
					console.log(data.asroles);
					var roles = data.asroles;
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
					$("#user_idrole").val(userid);
					$("#myModal").modal('show');
					//obj.html("Send");
				},
				error: function (error) {
					toastr.error("An unexpected error ocurred");
				}

			});
		});			
			
		$(document).delegate( '.delete_member', "click",function (event) {
			console.log("HI");
			var obj = $(this);
			var email = $(this).attr('rel');
			var lpid = $("#lpeid").val();
			$.ajax({
				type: "POST",
				data: {email: email, lpid: lpid},
				url: "/lp/member/delete",
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
						data: {val: val, user_id: user, lpid: lpid},
						url: "/lp/add_role",
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
			var rowNode = emp_table.row.add( [ "<p align='center'>" + e + "</p>", "<p align='center' id='usera"+e+"'></p> ","<p align='center' id='username"+e+"'></p>", "<p align='center' id='userrole"+e+"' rel='"+e+"'></p>", "<p align='center' id='usertop"+e+"'></p>", "<p align='center' id='useremail"+e+"' style='display: none;'></p><p align='center' id='userkey"+e+"'><input type='text' class='form-control key_employee' placeholder='Place employee email...' rel='"+e+"' /></p>", "<p align='center' id='usercheck"+e+"'></p>", "<p align='center' id='userdelete"+e+"'></p>" ] ).draw();
			$( rowNode )
			.css( 'text-align', 'center');
			e++;
			$("#nume").val(e);			
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
			} else {
				$.ajax({
					type: "POST",
					data: {emails: emails, lpid: lpid},
					url: "/lp/send_emails",
					dataType: 'json',
					success: function (data) {
						toastr.info("Email(s) successfully sent!");
						obj.html("Send");
					},
					error: function (error) {
						toastr.error("An unexpected error ocurred");
						obj.html("Send");
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
    });
</script>
