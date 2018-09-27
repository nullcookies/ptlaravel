@extends("common.default")
<?php
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\IdController;
use App\Classes;
define('MAX_COLUMN_TEXT', 95);
define('MAX_COLUMN_TEXT2', 20);
?>
@section("content")
<style type="text/css">
    .action_buttons{
        display: flex;
    }
    .role_status_button_autolink{
        margin: 10px 0 0 10px;
        width: 85px;
    }
</style>
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
							<input type="button" id="save_remarks_autolink" class="btn btn-primary" value="Save Remarks">
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

<div style="display: none;" class="removeable alert">
    <strong id='alert_heading'></strong><span id='alert_text'></span>
</div>
<div class="container" style="margin-top:30px;">
    @include('admin/panelHeading')
		<div class='row'>		
			<div class='col-xs-6'><h2>Autolink Master: Approval</h2></div>
			<div class='col-xs-6'>
				@foreach($autolinkeds as $m)
					<a class="btn btn-default role_status_button pull-right add_remark" role="autolink" do_status="add_remark" current_role_id="{{$m->id}}" style="width: 110px !important;" href="javascript:void(0)"> Add Remark </a>
				@endforeach
			</div>	
		</div>	

         <div class="equal_to_sidebar_mrgn">

                <table id="autoLinkgri" class="table table-bordered" width="1380px">

                    <thead style="color: white;background-color:  rgb(0,100,100)">
                        <tr>
                        <th class="no-sort bsmall" style="text-align: center">No</th>
                        <th class="text-center bmedium">AutoLink&nbsp;ID</th>
                      <!--  <th class="text-center bmedium">Initiator&nbsp;ID</th>
                        <th class="text-center blarge">Initiator&nbsp;Name</th>
                        <th class="text-center bmedium">Merchant&nbsp;ID</th>
                        <th class="text-center blarge">Merchant&nbsp;Name</th>
                        <th class="text-center bmedium">Linked&nbsp;Since</th>-->
						<th class="text-center xlarge" style="background-color: #008000; color: #fff;">Remarks</th> 
						<th class="text-center approv" style="background-color: #008000; color: #fff;">Approval</th> 
                    </tr>
                    </thead>
                    <tbody>
					<?php $ii = 1; ?>
                    @if(isset($autolinkeds) && !empty($autolinkeds))
                        @foreach($autolinkeds as $m)
                        <?php
                        /* Convert date time in to Carbon format */
                            // $time = strtotime($m->linked_since);
                            // $linked_since = Carbon::create(date('Y',$time),date('m',$time),date('d',$time),date('h',$time),date('i',$time),date('s',$time));
                            $linked_since=UtilityController::s_date($m->linked_since);
                        ?>
                            <tr>
                                <td style="text-align: center">{{$ii}}</td>
                                <td style="text-align: center"> 
                                                 {{IdController::nA($m->id)}}
                              </td>
                            <!--      <td style="text-align: center">

				                    @if($m->type == 's')
										<a target="_blank" href="{{route('stationPopup', ['id' => $m->myid])}}">
											{{IdController::nS($m->myid)}}
										</a>
									@else
										<a target="_blank" href="{{route('userPopup', ['id' => $m->user_id])}}">
											{{IdController::nB($m->user_id)}}
										</a>
									@endif
                              </td>
                                <td style="text-align: left">
									<?php
										/* Processed note */
										$pfullnote = null;
										$pnote = null;
											$elipsis = "...";
											$pfullnote = $m->name;
											$pnote = substr($pfullnote,0, MAX_COLUMN_TEXT2);

											if (strlen($pfullnote) > MAX_COLUMN_TEXT2)
												$pnote = $pnote . $elipsis;
									?> 								
									<span title='{{$pfullnote}}'>{{$pnote}}</span>
								</td>
                                <td style="text-align: center"><a target="_blank" href="{{route('merchantPopup', ['id' => $m->merchant_id])}}">{{IdController::nM($m->merchant_id)}}</a></td>
                                <td style="text-align: left">
									<?php
										/* Processed note */
										$pfullnote = null;
										$pnote = null;
											$elipsis = "...";
											$pfullnote = $m->company_name;
											$pnote = substr($pfullnote,0, MAX_COLUMN_TEXT2);

											if (strlen($pfullnote) > MAX_COLUMN_TEXT2)
												$pnote = $pnote . $elipsis;
									?> 								
									<span title='{{$pfullnote}}'>{{$pnote}}</span>									
								</td>
                                <td style="text-align: center">
									@if($m->status == "linked")
										{{$linked_since}}
                                    @else 
                                    Not Linked
									@endif
								</td>-->
                              <td id="remarks_column" class="text-center">
                                    <?php
                                        $remark = DB::table('remark')
                                        ->select('remark')
                                        ->join('autolinkremark','autolinkremark.remark_id','=','remark.id')
                                        ->where('autolinkremark.autolink_id',$m->id)
                                        ->orderBy('remark.created_at', 'desc')
                                        ->first();
                                    ?>
                                    <a href="javascript:void(0)" id="mcrid_{{$m->id}}" class="mcrid" rel="{{$m->id}}">
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
                                </td> 
                               <td class="text-center">
                                    <div class="action_buttons">
                                        <?php
                                            echo Classes\Approval::autolink($m->status, 'autolink',$m->id);
                                        ?>
                                    </div>
                                </td> 
                            </tr>
							<?php $ii++; ?>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
    </div>

    {{--Model Form Start--}}
                        <!-- Button trigger modal -->
            </div>
            {{--Model Form End--}}
        </div>
    </div>
    {{--</div>--}}
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
    <meta name="_token" content="{!! csrf_token() !!}"/>
    <script type="text/javascript">
        $(document).ready(function () {

            function pad (str, max) {
                str = str.toString();
                return str.length < max ? pad("0" + str, max) : str;
            }

            $('#autoLinkgri').DataTable({
                "scrollX": true,
                "order":[],
                "columnDefs": [
                {  "targets": 'no-sort',
                    "orderable": false },				
				{"targets": "medium", "width": "80px"},
				{"targets": "bmedium", "width": "100px"},
				{"targets": "large",  "width": "120px"},
				{"targets": "bsmall",  "width": "20px"},
				{"targets": "approv", "width": "180px"}, //Approval buttons
				{"targets": "blarge", "width": "200px"}, // *Names
				{"targets": "clarge", "width": "250px"},
				{"targets": "xlarge", "width": "300px"}, //Remarks + Notes 
                ]
             });

            var formSubmitType = null;

            //Handle Check Box Change
//            $("input[type='checkbox']").on("change", function () {
//                if ($(this).is(":checked"))
//                    $(this).val("1");
//                else
//                    $(this).val("0");
//            });

            //Function To handle add button action
            $("#btn-add").click(function () {
                formSubmitType = "add";
                $(".modal-title").text("Add Auto Linked");
                $("#addOccupation").trigger("reset");
                $("#myModal").modal("show");

            })

            //Function To Handle Edit Button action
            $(".btn-edit").click(function () {
                $("#addOccupation").trigger("reset");
                $("#myModal").modal("hide");

                var val = $(this).attr('value');
                console.log(val);
                var url = "/admin/general/occupations/" + val + "/edit";
                formSubmitType = "edit";
                $(".modal-title").text("Edit Auto Linked");

                $.ajax({
                    type: "GET",
                    url: url,
                    dataType: 'json',
                    success: function (data) {
                        console.log(data);
                        $("#occupation-name").val(data["name"]);
                        $("#occupation-description").val(data["description"]);
                        $("#occupation-occupation-id").val(data["id"]);

                        $("#myModal").modal("show");
                    },
                    error: function (error) {
                        console.log("Error :" + error);
                    }

                });

            })

            //Delete Recored
            $(".btn-delete").click(function () {
                if (confirm('Are you sure you want to remove auto linked Record?')) {
                    var id = $(this).attr("value");
                    var my_url = '/admin/master/autolink/' + id;
                    var method = "DELETE";

                    $.ajax({
                        type: method,
                        url: my_url,
                        dataType: 'json',
                        success: function (data) {
                            $(".success-msg").fadeIn();
                            $(".success-msg").text("Auto Linked successfully removed.");
                            $(".success-msg").fadeOut(4000);
                            location.reload();
                        },
                        error: function (error) {
                            console.log("Error :" + error);
                        }

                    });

                }


            })

            //Handle Form Submit For Bothh Add and Edit
            $("#addOccupation").on('submit', function (event) {

                var method = null;
                var my_url = null;
                var id = null;


                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                })
                event.preventDefault();


                if (formSubmitType == null) {
                    return false;
                }

                if (formSubmitType == "edit") {
                    id = $("#occupation-occupation-id").val();
                    method = 'PUT';
                    my_url = '/admin/general/occupations/' + id;
                }

                if (formSubmitType == "add") {
                    method = 'POST';
                    my_url = '/admin/general/occupations';
                }

                var formData = {
                    name: $("#occupation-name").val(),
                    description: $("#occupation-description").val(),

                }
                console.log(formData);
                $.ajax({
                    type: method,
                    url: my_url,
                    data: formData,
                    dataType: 'json',
                    success: function (data) {
//                        console.log(data);

                        $('#myModal').modal('hide');
                        $(".success-msg").fadeIn();
                        if (formSubmitType == 'edit') {
                            $(".success-msg").text("Occupation successfully updated.");
                        } else {
                            $(".success-msg").text("Occupation successfully added.");
                        }
                        $(".success-msg").fadeOut(4000);
                        formSubmitType = null;
                    },
                    error: function (error) {
                        console.log("Error :" + error);
                    }

                });

            });

            var signal = 'red';
            var intervalId = 1;
            var currentElement;
            var url;
            $(document).on("click", ".role_status_button_autolink", function () {
                currentElement = $(this);
                var doStatus = $(currentElement).attr('do_status');
                var role = $(currentElement).attr('role');

                if (role == 'autolink') {
                    url = JS_BASE_URL + '/admin/master/approveAutolink';
                }

                var role_id = $(currentElement).attr('current_role_id');

                $('#current_role_roleId').val(role_id);
                $('#current_status').val(doStatus);
                $('#current_role_roleId').attr('remarks_role', role);

                $("#myModalRemarks").modal('toggle');

            });

            function approveAutolink(role_id, doStatus, role, url, currentElement) {
                        $.ajax({
                            url: url,
                            type: 'POST',
                            dataType: 'json',
                            data: {id: role_id, doStatus: doStatus, role: role},
                            success: function (response) {
                                if (response.success == 'TRUE') {
                                    var statusColumn = $(currentElement).parent('.action_buttons').parent('td').siblings('#status_column').children('#status_column_text');
                                    $(currentElement).parent('.action_buttons').fadeOut(2000, function () {
                                        $(currentElement).parent('.action_buttons').html(response.view);
                                        $(statusColumn).fadeOut('fast');
                                        doStatus = doStatus.toLowerCase().replace(/\b[a-z]/g, function (letter) {
                                            return letter.toUpperCase();
                                        });
                                        $(statusColumn).text(doStatus);
                                        $(statusColumn).fadeIn(2000);
                                        $('#overlay_spinner_'+role_id).hide();
                                        $('#alert_heading').text('Success! ');
                                        $('#alert_text').text('Status Changed Successfully');
                                        $('.removeable').removeClass('alert-danger');
                                        $('.removeable').addClass('alert-success');
                                    });
                                    $(currentElement).parent('.action_buttons').fadeIn(2000);
                                } else if (response.success == 'False') {
                                    $('#alert_heading').text('Error!');
                                    $('#alert_text').text('Unable to change stauts');
                                    $('.removeable').removeClass('alert-success');
                                    $('.removeable').addClass('alert-danger');
                                }

                            }, complete: function () {
                                $('.removeable').show();
                                setTimeout(removeMessage, 5000);
                            }
                        });
                    //}
                //}, 500);
            }

            function suspendOrRejectAutolink(role_id, doStatus, role, url, currentElement) {
                //dialog.dialog("open");
                //intervalId = setInterval(function () {
                    //console.log("pas2s");
                    checkSignalAutolink(role_id, doStatus, role, url, currentElement)
                //}, 500);
            }

            function checkSignalAutolink(role_id, doStatus, role, url, currentElement) {
                //if (signal == 'green') {
                    //clearInterval(id);

                    $.ajax({
                        url: url,
                        type: 'POST',
                        dataType: 'json',
                        data: {id: role_id, doStatus: doStatus, role: role},
                        error: function(response){
                            console.log(response);
                        },
                        success: function (response) {

                            if (response.success == 'TRUE') {
                                var statusColumn = $(currentElement).parent('.action_buttons').parent('td').siblings('#status_column').children('#status_column_text');
                                var remarksColumn = $(currentElement).parent('.action_buttons').parent('td').siblings('#remarks_column').children('#remarks_text');
                                $(currentElement).parent('.action_buttons').fadeOut(2000, function () {
                                    $(currentElement).parent('.action_buttons').html(response.view);
                                    $(statusColumn).fadeOut('fast');
                                    $(remarksColumn).fadeOut('fast');
                                    doStatus = doStatus.toLowerCase().replace(/\b[a-z]/g, function (letter) {
                                        return letter.toUpperCase();
                                    });
                                    $(statusColumn).text(doStatus);
                                    $(remarksColumn).text(response.roleData.remarks);
                                    $(statusColumn).fadeIn(2000);
                                    $(remarksColumn).fadeIn(2000);
                                    $('#overlay_spinner_'+role_id).hide();
                                    $('#alert_heading').text('Success!');
                                    $('#alert_text').text('Staus Changed Successfully');
                                    $('.removeable').removeClass('alert-danger');
                                    $('.removeable').addClass('alert-success');
                                });
                                $(currentElement).parent('.action_buttons').fadeIn(2000);
                            } else if (response.success == 'False') {
                                $('#alert_heading').text('Error!');
                                $('#alert_text').text('Unable to change stauts');
                                $('.removeable').removeClass('alert-success');
                                $('.removeable').addClass('alert-danger');
                            }

                        }, complete: function () {
                            $('.removeable').show();
                            setTimeout(removeMessage, 5000);
                            //signal = 'red';
                        }
                    });
                //}
            }

            function removeMessage() {
                $('.removeable').hide();
            }

            $('#save_remarks_autolink').click(function () {
                if (!$.trim($('#status_remarks').val())) {
                    alert('Enter Remarks Please');
                    return false;
                } else {
                    var roleId = $('#current_role_roleId').val();
                    var dostatus = $('#current_status').val();
                    var role = $('#current_role_roleId').attr('remarks_role');
                    var remarks = $('#status_remarks').val();
                    var url2;
                    if (role == 'autolink') {
                        url2 = JS_BASE_URL + '/admin/master/saveAutolinkRemarks';
                    }
                    $.ajax({
                        url: url2,
                        type: 'POST',
                        dataType: 'json',
                        data: {id: roleId, remarks: remarks, role: role, status: dostatus},
                        success: function (response) {
                            $("#myModalRemarks").modal('toggle');
                          //  $('#overlay_spinner_'+roleId).show();
                            //signal = 'green';
                            $('#mcrid_'+roleId).html(remarks);
                            $('#remarks-form')[0].reset();
                        }
                    });
                    if (dostatus == 'unlinked') {
                        suspendOrRejectAutolink(roleId, dostatus, role, url, currentElement);
                    } else {
                        approveAutolink(roleId, dostatus, role, url, currentElement);
                    }

                }
            });

            $(document).on('click', '.ui-dialog-titlebar-close', function () {
                $('#overlay_spinner').hide();
                $('#remarks-form')[0].reset();
            });

            $(document).delegate( '.mcrid', "click",function (event) {
                _this = $(this);
                var id_autolink= _this.attr('rel');

                $('#modal-Tittle2').html("Remarks");

                var url = '/admin/master/autolink_remarks/'+ id_autolink;
                $.ajax({
                    type: "GET",
                    url: url,
                    dataType: 'json',
                    success: function (data) {
                        console.log(data);
                        var html = "<table class='table table-bordered' cellspacing='0' width='100%' ><tr style='background-color: rgb(0,100,100); color: white;'><th class='text-center'>No</th><th class='text-center'>Merchant&nbsp;ID</th><th class='text-center'>Status</th><th class='text-center'>Admin&nbsp;User&nbsp;ID</th><th class='text-center'>Remarks</th><th class='text-center'>DateTime</th></tr>";
                        for (i=0; i < data.length; i++) {
                            var obj = data[i];
                            html += "<tr>";
                            html += "<td class='text-center'>"+(i+1)+"</td>";
                            html += "<td class='text-center'><a href='../../admin/popup/merchant/"+obj.merchant_id+"' class='update' data-id='"+obj.merchant_id+"'>"+obj.nseller_id+"</a></td>";
                            html += "<td class='text-center'>"+ucfirst(obj.status)+"</td>";
                            html += "<td class='text-center'><a href='../../admin/popup/user/"+obj.user_id+"' class='update' data-id='"+obj.user_id+"'>"+obj.nbuyer_id+"</td>";
                            html += "<td>"+obj.remark+"</td>";
                            html += "<td class='text-center'>"+obj.created_at+"</td>";
                            html += "</tr>";
                        }
                        html = html + "</table>";
                        $('#myBody2').html(html);
                        $("#myModal2").modal("show");
                    }
                });
            });
        });
    </script>


@stop



