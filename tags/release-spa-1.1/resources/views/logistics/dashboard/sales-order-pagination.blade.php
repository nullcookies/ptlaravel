<?php
use App\Http\Controllers\IdController;
use App\Http\Controllers\UtilityController;

//$cStatus = ["l-processing", "l-collected", "b-collected", "l-processing2", "l-accepted", "m-collected"];

/*  Paul on 19 April 2017 at 10 am
    When we will have table for Porder.Status, we will remove this $Status Hardcoded array
    and attach these Status values as array via Controller...
*/
//$Status = ["pending", "m-processing1", "m-processing2", "l-processing", "l-collected", "b-collected",
 //"b-returning1", "m-approved1", "b-paid1", "b-returning2", "l-processing2",
 //"l-accepted", "m-collected", "m-approved2", "reviewed", "commented"];

$porder_status =
        ["active", "pending", "hyper", "openwish", "smm", "manual", "cancelreq", "returnreq", "undelivered",
        "processing", "deliveryinprogress", "complained", "executed", "cancelled", "returned", "partial", "delivered",
        "m-processing1", "m-processing2", "l-processing", "l-collected", "b-collected", "b-returning1", "m-approved1",
        "b-paid1", "b-returning2", "l-processing2", "l-accepted", "m-collected", "m-approved2", "reviewed", "commented", "completed"];

/*  As to_show_to_logistic is the subset of Status
    so instead of using Statuses in the subset,
    I am using the Keys/Ids of Statuses that will
    be used to Show To Logistics for better
    implementing my Logic for column (th)
    Status (the second last column)
*/

//$to_show_to_logistic = ["l-processing", "l-collected", "b-collected", "l-processing2", "l-accepted", "m-collected"];
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
                        <th class="text-center" style="background-color: green;">Status</th>
                        {{--<th class="text-center" style="background-color: green;">Previous Status</th>--}}
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
	<input type="hidden" value="{{$logistic->id}}" id="log_id" />
    <script type="text/javascript">
        $(document).ready(function () {
			
		$.fn.dataTable.pipeline = function ( opts ) {
	    // Configuration options
	    var conf = $.extend( {
	        pages: 5,     // number of pages to cache
	        url: '',      // script url
	        data: null,   // function or object with parameters to send to the server
	                      // matching how `ajax.data` works in DataTables
	        method: 'GET' // Ajax HTTP method
	    }, opts );
	 
	    // Private variables for storing the cache
	    var cacheLower = -1;
	    var cacheUpper = null;
	    var cacheLastRequest = null;
	    var cacheLastJson = null;
 
    return function ( request, drawCallback, settings ) {
        var ajax          = false;
        var requestStart  = request.start;
        var drawStart     = request.start;
        var requestLength = request.length;
        var requestEnd    = requestStart + requestLength;
         
        if ( settings.clearCache ) {
            // API requested that the cache be cleared
            ajax = true;
            settings.clearCache = false;
        }
        else if ( cacheLower < 0 || requestStart < cacheLower || requestEnd > cacheUpper ) {
            // outside cached data - need to make a request
            ajax = true;
        }
        else if ( JSON.stringify( request.order )   !== JSON.stringify( cacheLastRequest.order ) ||
                  JSON.stringify( request.columns ) !== JSON.stringify( cacheLastRequest.columns ) ||
                  JSON.stringify( request.search )  !== JSON.stringify( cacheLastRequest.search )
        ) {
            // properties changed (ordering, columns, searching)
            ajax = true;
        }
         
        // Store the request for checking next time around
        cacheLastRequest = $.extend( true, {}, request );
 
        if ( ajax ) {
            // Need data from the server
            if ( requestStart < cacheLower ) {
                requestStart = requestStart - (requestLength*(conf.pages-1));
 
                if ( requestStart < 0 ) {
                    requestStart = 0;
                }
            }
             
            cacheLower = requestStart;
            cacheUpper = requestStart + (requestLength * conf.pages);
 
            request.start = requestStart;
            request.length = requestLength*conf.pages;
 
            // Provide the same `data` options as DataTables.
            if ( $.isFunction ( conf.data ) ) {
                // As a function it is executed with the data object as an arg
                // for manipulation. If an object is returned, it is used as the
                // data object to submit
                var d = conf.data( request );
                if ( d ) {
                    $.extend( request, d );
                }
            }
            else if ( $.isPlainObject( conf.data ) ) {
                // As an object, the data given extends the default
                $.extend( request, conf.data );
            }
 
            settings.jqXHR = $.ajax( {
                "type":     conf.method,
                "url":      conf.url,
                "data":     request,
                "dataType": "json",
                "cache":    false,
                "success":  function ( json ) {
                    cacheLastJson = $.extend(true, {}, json);
 
                    if ( cacheLower != drawStart ) {
                        json.data.splice( 0, drawStart-cacheLower );
                    }
                    if ( requestLength >= -1 ) {
                        json.data.splice( requestLength, json.data.length );
                    }
                     
                    drawCallback( json );
                }
            } );
        }
        else {
            json = $.extend( true, {}, cacheLastJson );
            json.draw = request.draw; // Update the echo for each response
            json.data.splice( 0, requestStart-cacheLower );
            json.data.splice( requestLength, json.data.length );
 
            drawCallback(json);
        }
    }
};
 
		// Register an API method that will empty the pipelined data, forcing an Ajax
		// fetch on the next draw (i.e. `table.clearPipeline().draw()`)
		$.fn.dataTable.Api.register( 'clearPipeline()', function () {
		    return this.iterator( 'table', function ( settings ) {
		        settings.clearCache = true;
		    } );
		} );
 
		var page=$('#gridmerchant_page').val();
		var product_dtable=$('#sales-order-table').DataTable({
			"serverSide":true,
			"processing":true,
			"paging":true,
			"searching":{"regex":true},
			"order": [],
			"scrollX":true,
			"columnDefs": [
				{ "targets": "no-sort", "orderable": false },
				{ "targets": "large", "width": "120px" },
				{ "targets": "smallestest", "width": "55px" },
				{ "targets": "medium", "width": "95px" },
				{ "targets": "xlarge", "width": "280px" }
			],
			"ajax":{
				type:"GET",
				pages:5,
				url:JS_BASE_URL+"/paginate/lsalesorder/" + $("#log_id").val(),
				dataSrc:function(json){
					
					var return_data=new Array();
					subcat_pids=[];
					for (var i=0;i <json.data.length;i++) {
						var d=json.data[i];
						subcat_pids.push(d.pid);
						var completed = "--";
						if(d.status == "b-collected" ){
							var completed = d.completed;
						}
						var consignment = d.consignment_number;
						var cncp = true;
                        var pos = false;
						if (d.status == "delivered") {
							
						}
						if (d.pstatus == "l-collected" || d.pstatus == "l-accepted"){
                            pos = true;
						}
						
						var consignment_text = "<a ";
                        if(cncp== true){
                          consignment_text += ' class="cncp" rel-cn="'+consignment+'" ';
                        } else {
						  consignment_text += ' class="infod" ';	
						}
                                        

						if(pos== true){
							consignment_text += ' pos="1" ';
						} else {
							consignment_text += ' pos="0" ';
						}
                            consignment_text += '>' + consignment + '</a>';
						action_text = '';	
						if((d.pstatus=="m-processing2" || d.pstatus == "b-returning2" ) && d.status == "active"){
							action_text = '<a class="btn pull-right process " rel="'+consignment+'" style="background: red;color: white">Start</a>';
						}
						
						var porder_status = ["active", "pending", "hyper", "openwish", "smm", "manual", "cancelreq", "returnreq", "undelivered", "processing", "deliveryinprogress", "complained", "executed", "cancelled", "returned", "partial", "delivered", "m-processing1", "m-processing2", "l-processing", "l-collected", "b-collected", "b-returning1", "m-approved1", "b-paid1", "b-returning2", "l-processing2", "l-accepted", "m-collected", "m-approved2", "reviewed", "commented", "completed"];
						
						var to_logistic_status = [19, 20, 21, 26, 27, 28, 32];
						
						var show_status = "";

						var index_to_status = porder_status.indexOf(d.pstatus);
						var loop_size = to_logistic_status.lenght - 1;

						if (index_to_status == -1){
							$show_status = "Invalid";
						}else {
							for (ii = loop_size; ii >= 0; ii--) {
								if (to_logistic_status[ii] <= index_to_status) {
									show_status = porder_status[to_logistic_status[ii]];
									break;
								} else {
									show_status = porder_status[to_logistic_status[0]];
								}
							}
						}						
						return_data.push({
							'id': i+1,
							'consignement':consignment_text,							
							'delivery_id':d.delivery_id,
							'details':'<a class="apopup" rel="'+consignment+'" rel-type="all">Details</a>',
							'received':d.received,
							'completed': completed,
							'status': show_status,
							'action':action_text

						});


					}
					return return_data;
				}

			},
			"columns":[
				{data:'id',name:'created_at',className:'text-center no-sort'},
				{data:"consignement",name:'order_id',className:'text-center'},
				{data:"delivery_id",name:'mode',className:'text-center'},
				{data:"details",name:'received',className:'text-center'},
				{data:"received",name:'received',className:'text-center'},
				{data:"completed",name:'completed',className:'text-center no-sort'},							
				{data:"status",name:'status',className:'text-center'},
				{data:"action",name:'approval',className:'text-center'}

			]
		});		
            // Paul on 13 April 2017
            //  Defined in Canvas.js
            var canvasVisible = false;
            var emptyCanvas;

            //  Sign should only be displayed if status is L Collected or L Accepted
            $("#btnSign").hide();
            //  Disabling Confirm button on Popup...
            $('#confcpPass').attr("disabled", "disabled");

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
                }
                else {
                    if ($("#skey").val() == null || $("#skey").val().trim() == "")  //  Disable
                        $('#confcpPass').attr("disabled", "disabled");
                    else    //  Enable
                        $('#confcpPass').removeAttr("disabled");
                }
            });

            // Canvas on close
            $('#signModal').on('hidden.bs.modal', function (e) {
                //  No key & No Signs, Disable Confirm button
                if ($("#skey").val().trim() == "" || !Validate())  //  Disable
                    $('#confcpPass').attr("disabled", "disabled");
                else    //  Enable
                    $('#confcpPass').removeAttr("disabled");
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

            $('.infod').click(function () {
                toastr.warning("This order has been delivered");
            });
        });
    </script>
