@extends('common.default')
@section('content')
<div class="container">
<div class="row">
<div class="col-xs-12">
@include('admin/panelHeading')
                <h2>Delivery Master</h2>
<?php $i=1;
	use App\Http\Controllers\IdController;
        use App\Http\Controllers\UtilityController;
?><table class="table table-bordered" cellspacing="0" width="100%" id="product_details_table">
                                <thead style="background-color:#800080; color:#fff;">
                                {{-- <tr>
                                    <th colspan="4">Social Media Marketeer Master</th>
                                    <th colspan="7">Network Information</th>
                                    <th colspan="3">Geographical</th>
                                    <th colspan="3">Others</th>
                                </tr> --}}
                                <tr>
                                    <th class='no-sort text-center'>No</th>
                                    <th class="text-center">Date</th>
                                    <th class="text-center">Delivery&nbsp;ID</th>
                                    <th class="text-center">Order&nbsp;ID</th>
                                    <th class="text-center">Logistic&nbsp;ID</th>
                                    <th class="text-center">Consignment&nbsp;No.</th>
                                    <th class="text-center">Fee</th>
                                    <th class="text-center">Details</th>
                                    <th class="text-center">O.Status</th>

                                </tr>
                                </thead>
                                <tfoot>
                                	

                                </tfoot>
                                <tbody>
                                </tbody>
                            </table>
                            </div></div></div>

<div id="modalI" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
	<div class="modal-dialog" style="width:60%;">
		<div class="modal-content">
			<div class="modal-header">
			  <span style="font-size:2em;font-weight: bold;">&nbsp;&nbsp;Details</span> <span class="pull-right" id="modalSideTitle" style="font-size: 1em;font-weight: bold;"></span>
              
			</div>
			<div class="modal-body">
			</div>
		 
		</div>
	</div>
</div>
<script type="text/javascript">


</script>
<script type="text/javascript">
    $(document).ready(function(){
		$(document).delegate( '.apopup', "click",function (event) {
      //  $('.apopup').click(function(){
            var status=$(this).attr('rel-status');
            var cn=$(this).attr('rel');
            var t= $(this).attr('rel-type');
            var url="{{url('lp/addresses/')}}"+"/"+cn+"/"+t;
            $('#modalI').modal('show');
            $('#modalSideTitle').html("Delivery Status:"+ucfirst(status)+"&nbsp;&nbsp;&nbsp;");
            $('#modalI').find('.modal-body').load(url);

        });		
		
        $('.view-user-modal').click(function () {
            var user_id= $(this).attr('data-us-id');
            url=JS_BASE_URL+"/admin/popup/user/"+user_id;
            var w= window.open(url,"_blank");
            w.focus();
        });
		
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
 
		var page=$('#product_pagination_page').val();
		var product_dtable=$('#product_details_table').DataTable({
			"serverSide":true,
			"processing":true,
			"paging":true,
			"searching":{"regex":true},
			"ajax":{
				type:"GET",
				pages:5,
				url:JS_BASE_URL+"/paginate/delivery",
				dataSrc:function(json){
				
					var return_data=new Array();
					subcat_pids=[];
					for (var i=0;i <json.data.length;i++) {
						var d=json.data[i];
						subcat_pids.push(d.pid);
						return_data.push({
							'id': i+1,
							'date':d.date,
							'did':d.delivery_id,
							'deliveryorder':"<a href='"+JS_BASE_URL+"/deliveryorder/"+d.id+"' target='_blank'>"+d.porder_id+"</a>",
							'sid':"<a href='"+JS_BASE_URL+"/logistic_dashboard/"+d.uid+"' target='_blank'>"+d.seller_id+"</a>",
							'consignment':d.cn,
							'nfee':js_number_format(parseInt(d.nfee)/100,2,".",""),
							'info':'<a href="javascript:void(0)" class="apopup" rel="'+d.cn+'" rel-type="all" rel-status="'+d.dstatus+'">Info</a>',
							'status':'<a href="javascript:void(0)" role_id="'+d.id+'" class="preventDefault approval">' + ucfirst(d.status) + '</a>'

						});


					}
					return return_data;
				}

			},
			"columns":[
				{data:'id',name:'delivery.created_at',className:'text-center no-sort'},
				{data:"date",name:'date',className:'text-center'},
				{data:"did",name:'did',className:'text-center'},
				{data:"deliveryorder",name:'deliveryorder',className:'text-center no-sort'},
				{data:"sid",name:'sid',className:'text-center'},
				{data:"consignment",name:'consignment',className:'text-center'},
				{data:"nfee",name:'nfee',className:'text-center'},
				{data:"info",name:'info',className:'text-center'},
				{data:"status",name:'status',className:'text-center'}

			]
		});

            $('#product_details_table tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = table.row( tr );

                if ( row.child.isShown() ) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                }
                else {
                    // Open this row
                    row.child( format(tr) ).show();
                    tr.addClass('shown');
                }
            } );		
    });
	
	
	$(document).delegate( '.approval', "click",function (event) {
            //  Paul on 1st May 2017 at 11 55 pm
            //window.open(JS_BASE_URL + "/admin/master/orderapp/" + $(this).attr("role_id"), '_blank');
            window.open(JS_BASE_URL + "/orderapp/" + $(this).attr("role_id"), '_blank');
        });
	/*	$('#product_details_table').on('draw.dt', function () {
			$.ajax({
				'type':'POST',
				'url':JS_BASE_URL+"/subcats/by/pid",
				'data':{'pids':subcat_pids},
				'success':function(r) {
						if (r.status=="success") {
						
							data=r.data;
							for (var i = data.length - 1; i >= 0; i--) {
								$('.subcat_'+data[i].id).text(data[i].subcat_name);
								if (data[i].pstatus=="pending") {
									$('.subcat_'+data[i].id).closest('tr').css("background-color","rgba(240, 255, 0, 0.4)");
								}
							}
						}
				}

			});

	} );*/
	
</script>
@stop