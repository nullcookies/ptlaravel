<?php
use App\Http\Controllers\IdController;
use App\Http\Controllers\UtilityController;

//$cStatus = ["l-processing", "l-collected", "b-collected", "l-processing2", "l-collected1", "m-collected"];

/*  Paul on 19 April 2017 at 10 am
    When we will have table for Porder.Status, we will remove this $Status Hardcoded array
    and attach these Status values as array via Controller...
*/
//$Status = ["pending", "m-processing1", "m-processing2", "l-processing", "l-collected", "b-collected",
 //"b-returning1", "m-approved1", "b-paid1", "b-returning2", "l-processing2",
 //"l-collected1", "m-collected", "m-approved2", "reviewed", "commented"];

$porder_status =
        ["active", "pending", "hyper", "openwish", "smm", "manual", "cancelreq", "returnreq", "undelivered",
        "processing", "deliveryinprogress", "complained", "executed", "cancelled", "returned", "partial", "delivered",
        "m-processing1", "m-processing2", "l-processing", "l-collected", "b-collected", "b-returning1", "m-approved1",
        "b-paid1", "b-returning2", "l-processing2", "l-collected1", "m-collected", "m-approved2", "reviewed", "commented", "completed"];

/*  As to_show_to_logistic is the subset of Status
    so instead of using Statuses in the subset,
    I am using the Keys/Ids of Statuses that will
    be used to Show To Logistics for better
    implementing my Logic for column (th)
    Status (the second last column)
*/

//$to_show_to_logistic = ["l-processing", "l-collected", "b-collected", "l-processing2", "l-collected1", "m-collected"];
//  Use Indices from $porder_status instead of Values in $to_logistic_status

$to_logistic_status = [19, 20, 21, 26, 27, 28, 32];
?>
<div class="tab-content top-margin" style="margin-top:-50px">
    <div id="sales-order" class="tab-pane fade in active">
        <h2>Sales Order</h2>
        <?php $yy = 1; ?>
        <div class="row">
            <div class=" col-sm-12">
                <table class="table table-bordered" id="sales-order-table" width="100%">
                    <thead>

                    <tr class="bg-black">
                        <th class="text-center">No</th>
                        <th class="text-center">Consignment&nbsp;No</th>
                        <th class="text-center">Delivery&nbsp;ID</th>
                        <th class="text-center">Details</th>
                        <th class="text-center">Received</th>
                        <th class="text-center">Completed</th>
                        <th class="text-center" style="background-color: green;">O.Status</th>
                        <th class="text-center" style="background-color: green;">D.Status</th>
                        <th class="text-center" style="background-color: green;">Action</th>
                        <!--<th>Length</th>
                        <th>Height</th>
                        <th>Weight</th>
                        <th class="text-center" style="min-width: 120px;">Sender</th>
                        <th>Recepient</th>
                        -->
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($deliverys as $d)
                        <tr>
                            <td class="text-center">{{$yy}}</td>
                            <?php
                            $cncp = true;
                            $pos = false;
							
                            if ($d->status == "delivered") {
                                // $class="";
                                $cncp = false;
                            }

                            if ($d->pstatus == "l-collected" || $d->pstatus == "l-collected1")
                                $pos = true;

                            ?>
                            <td class="text-center">
                                <a
                                        @if($cncp== true)
										@if($logistic->lgrade_id == 2 && ($d->pstatus == "l-collected" || $d->pstatus == "l-collected1"))
                                        class="cncpb" rel-cn="{{$d->consignment_number}}"
                                        @else
										class="cncp" rel-cn="{{$d->consignment_number}}"
										@endif
                                        @else
                                        class="infod"
                                        @endif

                                        @if($pos== true)
                                        pos="1"
                                        @else
                                        pos="0"
                                        @endif
                                >
                                    {{$d->consignment_number}}
                                </a>
                            </td>
                            <td class="text-center">{{IdController::nDel($d->id)}}</td>
                            <td class="text-center"><a class="apopup" rel="{{$d->consignment_number}}" rel-type="{{$d->type}}">Details</a>
                            </td>
                            <td class="text-center">{{UtilityController::s_date($d->created_at)}}</td>
                            <td class="text-center">
                            
                                @if(!is_null($d->delivered_date))
                                    {{UtilityController::s_date($d->delivered_date)}}
                                @else
                                    --
                                @endif

                            </td>
                            <td class="text-center">

                                {{-- Coding for Showing Status to the Logistics --}}
                                <?php
                                $show_status = "";

                                $index_to_status = array_search($d->pstatus, $porder_status);
                                $loop_size = sizeof($to_logistic_status) - 1;

                                if ($index_to_status === false)
                                    $show_status = "Invalid";
                                else {
                                    for ($i = $loop_size; $i >= 0; $i--) {
                                        if ($to_logistic_status[$i] <= $index_to_status) {
                                            $show_status = $porder_status[$to_logistic_status[$i]];
                                            break;
                                        } else
                                            $show_status = $porder_status[$to_logistic_status[0]];
                                    }
                                }
                                ?>
                                {{ucfirst($d->pstatus)}}
                            </td>
                            {{--<td>--}}
                        <!--Commented by Paul on 19 April 2017 at 10 am-->
                            <?php

                            /*$index = array_search($d->pstatus, $Status);


                            $size = sizeof($Status);
                            $status = "";
                            if (!$index) {
                                $status = $d->pstatus;
                                //dd("HOLA");
                            } else {
                                //dd($index);
                                if (in_array($d->pstatus, $cStatus)) {
                                    $status = $d->pstatus;
                                } else {
                                    while ($status == "") {
                                        $index--;
                                        if ($index < 0) {
                                            break;
                                        } else {
                                            if (in_array($Status[$index], $cStatus) && $index > 0) {
                                                $status = $Status[$index];
                                                break;
                                            }
                                        }
                                    }
                                }
                            }
                            if ($status == "b-collected" or $status == "m-collected") {
                                $status = "Completed";
                            }*/
                            ?>

                            {{--{{ucfirst($status)}}--}}
                            {{--</td>--}}
                            <td class="text-center">{{ucfirst($d->status)}}</td>
                            <td class="text-center">
                                @if(($d->pstatus=="m-processing2" or$d->pstatus == "b-returning2" ) and $d->status ==
                                "active")

                                    <a class="btn pull-right process " rel="{{$d->consignment_number}}"
                                       style="background: red;color: white">Start</a>
                                @endif
                            </td>
                        </tr>
                        <?php $yy++; ?>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Modal --}}
    <div id="cpcnModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    {{-- <h4 class="modal-title">Modal H</h4> --}}
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    {{-- Paul removed Reload --}}
                    <a href="javascript:void(0);" class="btn btn-default pull-left"
                       data-dismiss="modal">Close</a>
                    {{--Paul on 12 April 2017 at 12 55 am--}}
                    {{--
                    <button type="button" id="btnUpload" class="btn btn-info">Upload</button>
                    --}}
                    {{--
                    <button id="btnSign" type="button" class="btn btn-info">Sign</button>
                    --}}
                    <a id="btnSign" data-toggle="modal" href="#signModal" class="btn btn-info">Sign</a>
                    {{--Ends Here--}}
                    <a href="javascript:void(0);" class="btn btn-info pull-right" id="confcpPass">Confirm</a>
                </div>
            </div>

        </div>
    </div>
	
    {{-- Modal --}}
    <div id="cpcnModalb" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    {{-- <h4 class="modal-title">Modal H</h4> --}}
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    {{-- Paul removed Reload --}}
                    <a href="javascript:void(0);" class="btn btn-default pull-left"
                       data-dismiss="modal">Close</a>
                    {{--Paul on 12 April 2017 at 12 55 am--}}
                    {{--
                    <button type="button" id="btnUpload" class="btn btn-info">Upload</button>
                    --}}
                    {{--
                    <button id="btnSignb" type="button" class="btn btn-info">Sign</button>
                    --}}
                    <a id="btnSignb" data-toggle="modal" href="#signModal" class="btn btn-info">Sign</a>
                    {{--Ends Here--}}
                    <a href="javascript:void(0);" class="btn btn-info pull-right" id="confcpPassb">Confirm</a>
                </div>
            </div>

        </div>
    </div>	

    {{--Paul on 13 April 2017 at 11 pm--}}
    {{-- Modal --}}
    <div id="signModal" class="modal fade rotate" role="dialog">
        <div class="modal-dialog" style="width: 100%;margin: 0;padding: 0;">
            <!-- Modal content-->
            <div class="modal-content" style="height: auto;min-height: 50%;border-radius: 0;">
                <div class="modal-header">
                    {{--
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    --}}
                    <h4 class="modal-title">Please sign below:</h4>
                </div>
                <div id="sign-modal-body">
                    <div id="canvasDiv" style="border:inherit; border-color:black;border-width:thick">
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="javascript:void(0);" class="btn btn-default"
                       data-dismiss="modal">Confirm</a>
                    <button id="btnClear" type="button" class="btn btn-warning">Clear</button>
                </div>
            </div>
        </div>
    </div>
	

    <script type="text/javascript">
        $(document).ready(function () {
            // Paul on 13 April 2017
            //  Defined in Canvas.js
            var canvasVisible = false;
            var emptyCanvas;

            //  Sign should only be displayed if status is L Collected or L Accepted
            $("#btnSign").hide();
            $("#btnSignb").hide();
            //  Disabling Confirm button on Popup...
            $('#confcpPass').attr("disabled", "disabled");
            $('#confcpPassb').attr("disabled", "disabled");

           $(document).delegate( '.process', "click",function (event) {
                
                var cn = $(this).attr('rel');
                var $this = $(this);
                var url = "{{url('lp/start/')}}" + "/" + cn;
                $.ajax({
                    type: 'GET',
                    url: url,
                    success: function (r) {
                        if (r.status == "success") {
                            toastr.info(r.long_message);
                            $this.remove();

                        }
                    }
                });
            });
			$(document).delegate( '.cncp', "click",function (event) {
         //   $('.cncp').click(function () {
                var oid = $(this).attr('rel-cn');

                //  Paul on 14 April 2017
                var pos = $(this).attr('pos');

                if (pos == 1) {
                    prepareCanvas();
                    emptyCanvas = canvas.toDataURL();
                    canvasVisible = true;
                    $("#btnSign").show();
                }
                else {
                    removeCanvas();
                    canvasVisible = false;
                    $("#btnSign").hide();
                }

                // Ends Here

                var url = "{{url('lp/collect/package')}}" + "/" + oid;

                $('#cpcnModal').find('.modal-body').load(url);
                $(window).scrollTop(0);
                $('#cpcnModal').modal('show');
               
            });
			var isb = false;
			$(document).delegate( '.cncpb', "click",function (event) {
         //   $('.cncp').click(function () {
                var oid = $(this).attr('rel-cn');
				isb = true;
                //  Paul on 14 April 2017
                var pos = $(this).attr('pos');

                if (pos == 1) {
                    prepareCanvas();
                    emptyCanvas = canvas.toDataURL();
                    canvasVisible = true;
                    $("#btnSignb").show();
                }
                else {
                    removeCanvas();
                    canvasVisible = false;
                    $("#btnSignb").hide();
                }

                // Ends Here

                var url = "{{url('lp/collect/package')}}" + "/" + oid;

                $('#cpcnModalb').find('.modal-body').load(url);
                $(window).scrollTop(0);
                $('#cpcnModalb').modal('show');
               
            });


            //  Confirm button will be Enabled if:
            //  1) Key is entered into the Textbox
            //  2) Something is Drawn on the Canvas
            //  1st validation is coded below and
            //  2nd is coded under $('#signModal').on('hidden.bs.modal', function (e)
            $(document).on('input', function () {
                if (canvasVisible) {
                    //  No key & No Signs, Disable Confirm button
                    if ($("#skey").val() ==null || $("#skey").val().trim() == "" || !Validate())  //  Disable
                        $('#confcpPass').attr("disabled", "disabled");
                    else    //  Enable
                        $('#confcpPass').removeAttr("disabled");
						
					if ($("#skeyb").val() ==null || $("#skeyb").val().trim() == "" || !Validate()){  //  Disable
					//	if ($("#dname").val() ==null || $("#dname").val().trim() == ""){ 
							$('#confcpPassb').attr("disabled", "disabled");
					//	}
                    }else  { 
						if ($("#dname").val() ==null || $("#dname").val().trim() == ""){ 
							$('#confcpPassb').attr("disabled", "disabled");
						} else {
							if ($("#nric").val() ==null || $("#nric").val().trim() == "" || !ValidateNRIC($("#nric").val())){ 
							} else {
								$('#confcpPassb').removeAttr("disabled");
							}
						}
                       // $('#confcpPass').removeAttr("disabled");
					}
                }
                else {
                    if ($("#skey").val() == null || $("#skey").val().trim() == ""){  //  Disable
                        $('#confcpPass').attr("disabled", "disabled");
					}else  {  //  Enable
                        $('#confcpPass').removeAttr("disabled");
					}
					
					if ($("#skeyb").val() ==null || $("#skeyb").val().trim() == ""){  //  Disable
					//	if ($("#dname").val() ==null || $("#dname").val().trim() == ""){ 
							$('#confcpPassb').attr("disabled", "disabled");
					//	}
                    }else  { 
						if ($("#dname").val() ==null || $("#dname").val().trim() == ""){ 
							$('#confcpPassb').attr("disabled", "disabled");
						} else {
							if ($("#nric").val() ==null || $("#nric").val().trim() == "" || !ValidateNRIC($("#nric").val())){ 
							} else {
								$('#confcpPassb').removeAttr("disabled");
							}
						}
                       // $('#confcpPass').removeAttr("disabled");
					}
                }
            });

            // Canvas on close
            $('#signModal').on('hidden.bs.modal', function (e) {
                //  No key & No Signs, Disable Confirm button
				if(!isb){
					if ($("#skey").val().trim() == "" || !Validate())  //  Disable
						$('#confcpPass').attr("disabled", "disabled");
					else    //  Enable
						$('#confcpPass').removeAttr("disabled");
				} else {	
					if ($("#skeyb").val().trim() == "")  //  Disable
						$('#confcpPassb').attr("disabled", "disabled");
					else    //  Enable
						$('#confcpPassb').removeAttr("disabled");
				}
            });
			
			// Canvas on close
            $('#signModalb').on('hidden.bs.modal', function (e) {
                //  No key & No Signs, Disable Confirm button
                if ($("#skeyb").val().trim() == "" || !Validate())  //  Disable
                    $('#confcpPassb').attr("disabled", "disabled");
                else    //  Enable
                    $('#confcpPassb').removeAttr("disabled");
            });

            // on close
            $('#cpcnModal').on('hidden.bs.modal', function (e) {
                if (canvasVisible)
                    clearCanvas();
            });
			$(document).delegate( '#btnClear', "click",function (event) {
            //  Canvas is visible
        //    $('#btnClear').click(function () {
                clearCanvas();
            });
			$(document).delegate( '.reload', "click",function (event) {
     //       $('.reload').click(function () {
                location.reload();
            });

			$(document).delegate( '#confcpPass', "click",function (event) {
        //    $('#confcpPass').click(function () {
                if ($(this).attr('disabled') != null)
                    return false;

                var oid = $('#cncpoid').val();
                var skey = $('#skey').val();
                var type = $('#cncptype').val();
                var cn = $('#cn').val();
                var dataURL;

                //  if Canvas is visible, make sure it has Signs...
                if (canvasVisible) {
                    if (!Validate()) {
                        alert("Canvas is Empty");
                        return;
                    }

                    //  Paul on 30 April 2017 at 3 pm to Crop Canvas Image
                    //dataURL = canvas.toDataURL();

                    //  take image from canvas
                    var data = context.getImageData(0, 0, canvas.width, canvas.height);
                    //alert(data.width);
                    // store the current globalCompositeOperation
                    var compositeOperation = context.globalCompositeOperation;
                    // set to draw behind current content
                    context.globalCompositeOperation = "destination-over";

                    var croppedCanvas = document.createElement("canvas");
                    croppedCanvas.width = 200;
                    croppedCanvas.height = 100;

                    var tCtx = croppedCanvas.getContext("2d");
                    //tCtx.putImageData(data, 0, 0);
                    //tCtx.drawImage(canvas, 0, 0);

                    //  s=source, d=destination
                    //tCtx.drawImage(image,sx, sy, sw, sh,dx, dy, dw, dh);
                    tCtx.drawImage(canvas, 0, 0, canvas.width, canvas.height, 0, 0, croppedCanvas.width, croppedCanvas.height);

                    // write on screen
                    //var img = tempCanvas.toDataURL("image/png");
                    //document.write('<a href="' + img + '"><img src="' + img + '"/></a>');

                    var dataURL = croppedCanvas.toDataURL();

                } else
                    dataURL = null;


                var oid = $('#cncpoid').val();

                url = "{{url('app/v1/lscanb')}}";

                if (skey == "" || oid == "") {
                    alert("Please enter a valid Security Key");
                } else {
                    $.ajax({
                        type: "POST",
                        data: {
                            "oid": oid,
                            "skey": skey.trim(),
                            "cn": cn,
                            "type": type,
                            "imgBase64": dataURL
                        },
                        url: url,
                        success: function (r) {
                            if (r.status == "success") {
                                $('#confcpPass').remove();
                                $('#cpcnModal').find('.modal-body')
                                        .empty();
                                $('#cpcnModal').find('.modal-body')
                                        .text(r.long_message);
                                $("#btnSign").hide();
								setTimeout(function(){ 
									location.reload();
								}, 2000);

                            }
                            if (r.status == "failure") {
                                toastr.warning(r.long_message);
                            }
                        },
                        error: function () {
                            toastr.warning("Some erroor happened. Please contact OpenSupport");
                        }
                    });
                }
            });
			
			$(document).delegate( '#confcpPassb', "click",function (event) {
        //    $('#confcpPass').click(function () {
                if ($(this).attr('disabled') != null)
                    return false;

                var oid = $('#cncpoid').val();
                var skey = $('#skeyb').val();
                var dname = $('#dname').val();
                var nric = $('#nric').val();
                var type = $('#cncptype').val();
                var cn = $('#cn').val();
                var dataURL;

                //  if Canvas is visible, make sure it has Signs...
                if (canvasVisible) {
                    if (!Validate()) {
                        alert("Canvas is Empty");
                        return;
                    }

                    //  Paul on 30 April 2017 at 3 pm to Crop Canvas Image
                    //dataURL = canvas.toDataURL();

                    //  take image from canvas
                    var data = context.getImageData(0, 0, canvas.width, canvas.height);
                    //alert(data.width);
                    // store the current globalCompositeOperation
                    var compositeOperation = context.globalCompositeOperation;
                    // set to draw behind current content
                    context.globalCompositeOperation = "destination-over";

                    var croppedCanvas = document.createElement("canvas");
                    croppedCanvas.width = 200;
                    croppedCanvas.height = 100;

                    var tCtx = croppedCanvas.getContext("2d");
                    //tCtx.putImageData(data, 0, 0);
                    //tCtx.drawImage(canvas, 0, 0);

                    //  s=source, d=destination
                    //tCtx.drawImage(image,sx, sy, sw, sh,dx, dy, dw, dh);
                    tCtx.drawImage(canvas, 0, 0, canvas.width, canvas.height, 0, 0, croppedCanvas.width, croppedCanvas.height);

                    // write on screen
                    //var img = tempCanvas.toDataURL("image/png");
                    //document.write('<a href="' + img + '"><img src="' + img + '"/></a>');

                    var dataURL = croppedCanvas.toDataURL();

                } else
                    dataURL = null;


                var oid = $('#cncpoid').val();

                url = "{{url('app/v1/blscanb')}}";

                if (skey == "" || oid == "" || dname == "" || nric == "") {
                    alert("Please enter a valid Security Key");
                } else {
                    $.ajax({
                        type: "POST",
                        data: {
                            "oid": oid,
                            "skey": skey.trim(),
                            "dname": dname.trim(),
                            "nric": nric.trim(),
                            "cn": cn,
                            "type": type,
                            "imgBase64": dataURL
                        },
                        url: url,
                        success: function (r) {
                            if (r.status == "success") {
                                $('#confcpPassb').remove();
                                $('#cpcnModalb').find('.modal-body')
                                        .empty();
                                $('#cpcnModalb').find('.modal-body')
                                        .text(r.long_message);
                                $("#btnSignb").hide();
								setTimeout(function(){ 
									location.reload();
								}, 2000);
                            }
                            if (r.status == "failure") {
                                toastr.warning(r.long_message);
                            }
                        },
                        error: function () {
                            toastr.warning("Some erroor happened. Please contact OpenSupport");
                        }
                    });
                }
            });			

            function Validate() {
                if (emptyCanvas == canvas.toDataURL())
                    return false;
                return true;
            }
			
			 function ValidateNRIC(text) {
				 return true;
			 }

            $('.infod').click(function () {
                toastr.warning("This order has been delivered");
            });
        });
    </script>
