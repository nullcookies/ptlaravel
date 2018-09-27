<?php
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\IdController;
use App\Classes;
$globals = DB::table('global')->first();
?>
<style>
    .disabled{
        color:#fff;
        border: none;
        background-color: grey;
        border-color:grey;
    }
    .row-centered{text-align:center;margin: 0 auto;margin-top:15px;}
    .clock{
        padding:0px;margin-left:-6px;margin-top: 2px;color: #d9534f;
    }
    .return-area{
        width: 800px;
    }
	 table#product_details_table
    {
        table-layout: fixed;
        max-width: none;
        width: auto;
        min-width: 100%;
    }
</style>
<h2>{{$title or 'Orders'}}</h2>
<table class="table table-bordered" id="product_details_table" width="100%">
    <thead>
    <?php $i=1;?>
    <tr class="bg-black">
        <th class="text-center no-sort">No</th>
        <th class="text-center">Order&nbsp;ID</th>
        <th class="text-center">Order&nbsp;Received</th>
        <th class="text-center">Order&nbsp;Completed</th>
        <th class="text-center">Segment</th>
        <th class="text-center">Order&nbsp;Total</th>
        <th class="text-center" >Status</th>
        <th class="no-sort text-center large"  style="background:green;" width="135px">Action</th>
    </tr>
    </thead>
    <tbody>
    </tbody>
</table>

{{-- <div class="clearfix"> </div> --}}
{{-- Complain Modal --}}
<style type="text/css">
 .modal-body{
    width: 100%;
 }
}
</style>

        <!--Return Modal-->
<div class="modal fade" id="cllModal" role="dialog" aria-labelledby="cllLabel">
    <div class="modal-dialog" role="document" style="width: 50%">
        <div class="modal-content">
            <div class="modal-header">
                <a type="a" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></a>
               
            </div>
            <div class="modal-body" id="clB">
               
                
            </div>
            <div class="modal-footer">
               {{--  <a class="btn btn-primary btn-info" id="clNxt">Next <span class="glyphicon glyphicon-arrow-right"></span></a> --}}
                <a type="a" class="btn btn-approval pull-right confCL">Confirm</a>
                <a type="a" class="btn btn-default pull-left" data-dismiss="modal">Close</a>
            </div>
            </form>

        </div>
    </div>
</div>
{{-- Status Modal --}}
        <!--Return Modal-->
<div class="modal fade" id="sModal" role="dialog" aria-labelledby="cllLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <a type="a" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></a>
               
            </div>
            <div class="modal-body" id="clB">
               
                
            </div>


        </div>
    </div>
</div>
<input type="hidden" value="{{$globals->merchant_process_salesorder_window}}" id="dateglobal" />
<input type="hidden" value="{{$globals->buyer_cancellation_window}}" id="buyerwindow" />
<input type="hidden" value="{{$globals->buyer_return_window}}" id="buyerwindowreturn" />
<input type="hidden" value="{{$globals->merchant_process_salesorder_window}}" id="merchantwindow" />
{{--Remark Modal--}}
{{-- <script src="{{url('js/jquery.dataTables.min.js')}}"></script> --}}
<script src= "{{asset("js/jquery.countdown.min.js")}}"></script>
<script type="text/javascript">
    $(document).ready(function(){

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
		var product_dtable=$('#product_details_table').DataTable({
			"serverSide":true,
			"paging":true,
			"order": [],
		 /* 	"scrollX":true,*/
			"columnDefs": [
				{ "targets": "no-sort", "orderable": false },
				{ "targets": "large", "width": "120px" },
				{ "targets": "smallestest", "width": "55px" },
				{ "targets": "medium", "width": "95px" },
				{ "targets": "xlarge", "width": "280px" }
			],
			"searching":{"regex":true},
			"ajax":{
				type:"GET",
				pages:5,
				url:JS_BASE_URL+"/paginate/buyerorder/" + $("#userjust_id").val(),
				dataSrc:function(json){
				
					var return_data=new Array();
					subcat_pids=[];
					for (var i=0;i <json.data.length;i++) {
						var d=json.data[i];
						subcat_pids.push(d.pid);
						var completed = "--";
						if(d.status == "completed" || d.status == "reviewed" || d.status == "commented" ){
							var completed = d.completed;
						}
						var date1 = new Date(d.created_at);
						var datetoc = new Date(d.created_at);
						var datetocomp = new Date(d.created_at);
						var datetocomp2 = new Date(d.created_at);
						var datetest = formatDateJs(datetocomp);
						//console.log(datetest);
						var date2 = new Date(dateglobal);
						var datenow = new Date();
						var timeDiff = date2.getTime() - date1.getTime();
						var h = parseInt($("#merchantwindow").val());
						var hr = parseInt($("#buyerwindowreturn").val()) * 24;
						var approval = "";
						var cancel = "no";
						var mreturn = "no";
						var receipt = "";
						datetoc.setMinutes(datetoc.getMinutes() + parseInt($("#buyerwindow").val()));
						if(datetoc.getTime()> datenow.getTime()){
							cancel = "yes";
						}
						if (cancel == "yes" && d.status=='pending') {
							datetocomp.setTime(datetocomp.getTime() + (h*60*60*1000));
							datetocomp2.setTime(datetocomp.getTime() + (hr*60*60*1000));
							var defdate = formatDateJs(datetocomp);
							var defdate2 = formatDateJs(datetocomp2);
							if(datetocomp2.getTime()> datenow.getTime()){
								mreturn = "yes";
							}
							approval = '<button style="width: 65px;padding: 2px 5px !important;" data-status="'+d.status+'" type="button" class="cancel btn btn-xs btn-cancel" data-id='+d.id+'>Cancel</button>';
							approval +='<span style="text-align:center ;" class="col-md-5 clock" data-receipt="'+datetocomp2+'" data-return="'+mreturn+'" data-cancel="'+cancel+'" data-countdown="'+defdate+'" id="countdowntimer'+d.id+'"></span>'
						}
						if(d.status=='completed'){
							approval = '<button  class="btn btn-feedback  fdb showFeedbackForm" data-oid="'+d.id+'"><span class="glyphicon glyphicon-bullhorn"></span> Feedback</button>';
						}else if(d.status == "b-collected"){
							approval = '<button style="width: 65px;padding: 2px 5px !important;" data-status="'+d.status+'" type="button" class=" btn btn-xs btn-return order-return-button" data-id="'+d.id+'">Return</button>';
						}else if(d.status =='m-approved1' || d.status == "returnpartiallyaccepted"){
							approval = '<a href="javascript:void(0);" class="btn btn-info showprfee" rel-oid="'+d.id+'" >Return</a>';
						}else if (d.status=='request-goods'){
							approval = '<a href="'+JS_BASE_URL+'/label/download'+d.id+'" class="btn btn-label" title="Print Label" alt="Print Label"><span class="glyphicon glyphicon-print"></span></a>&nbsp;<button  data-oid="'+d.id+'" class="btn btn-info cll"><span class="glyphicon glyphicon-earphone" ></span> Logistic</button>';
						}
						
						return_data.push({
							'id': i+1,
							'order_id':'<a href="javascript:void(0)" class="view-orderid-modal" data-id="'+d.id+'">'+d.order_id+'</a>',
							'received':d.received,
							'completed': completed,
							'segment':d.source.toUpperCase(),
							'total':"{{$currentCurrency}} "+js_number_format(parseInt(d.total)/100,2,".",""),
							'status':'<a href="javascript:void(0)" role_id="'+d.id+'" class="preventDefault approval">'+ucfirst(d.status)+'</a>',
							'approval':approval

						});


					}
					return return_data;
				}

			},
			"columns":[
				{data:'id',name:'created_at',className:'text-center no-sort'},
				{data:"order_id",name:'order_id',className:'text-center'},
				{data:"received",name:'received',className:'text-center'},
				{data:"completed",name:'completed',className:'text-center no-sort'},
				{data:"segment",name:'segment',className:'text-center'},
				{data:"total",name:'total',className:'text-center'},	
				{data:"status",name:'status',className:'text-center'},
				{data:"approval",name:'approval',className:'text-center'}

			]
		});

	
        /*  Paul on 1 May 2017 at 11 30 pm to enable MRT  */
        $(document).delegate( '.approval', "click",function (event) {
            //  Paul on 1st May 2017 at 11 55 pm
            //window.open(JS_BASE_URL + "/admin/master/orderapp/" + $(this).attr("role_id"), '_blank');
            window.open(JS_BASE_URL + "/orderapp/" + $(this).attr("role_id"), '_blank');
        });
        /*  Ended  */

		$(document).delegate( '.showprfee', "click",function (event) {
       // $('.showprfee').click(function () {
            var oid = $(this).attr('rel-oid');
            var url="{{url('cre/status')}}"+"/"+oid;
            $('#sModal').find('.modal-body').load(url);
            $('#sModal').modal('show');
        });
		$(document).delegate( '.cll', "click",function (event) {
      //  $('.cll').click(function(){
           
            var oid=$(this).attr('data-oid');

            var type="b2m";
            var cllurl="{{url('call/logistic')}}/"+oid+"/"+type;
            $('#cllModal').find('.modal-body').empty();
            $('#cllModal').modal('show');
            $('#cllModal').find('.modal-body').load(cllurl);
            $('#clNxt').prop('disabled',false);
            $('.confCL').prop('disabled',true);
            data={
                "oid":oid,
                "pdate":$('#date').val(),
                "pck":$('#pck').val(),
                "type":type
            }


        });
    });
</script>
<script type="text/javascript">

    $(document).ready(function(){
		$(document).delegate( '.nclose', "click",function (event) {
     //   $('.nclose').click(function(){
            console.log("nclose");
            var ref = $(this).attr('rel');
            $('#'+ref).modal('hide');
            // $('.nclose').removeAttr('id');

            // $('.nclose').trigger('click');
            location.reload();
        });
		$(document).delegate( '.confCL', "click",function (event) {
      //   $('.confCL').click(function(){
            var bt=$(this);
                var url="{{url('call/logistic')}}";
                var oid= $('#confOID').val();
                var count=$('#tP').val();
                var isotime=$('#timestamp').attr('ts');
                var data=[];
                $('.Input').each(function(i,elem){
                            temp={};
                          $(elem).find(".form-control").each(function(x,obj){
                            {
                                key=$(obj).attr('name');
                                value=$(obj).val();
                                temp[key]=value;
                            }
                          });
                          console.log(temp);
                          data.push(temp);
                });
                console.log(JSON.stringify(data));
                $.ajax({
                    type:'POST',
                    url: url,
                    data:{"pd":data,
                        "ts":isotime,
                        "count":count,
                        "oid":oid,
                        'type':'b2m'
                    },
                    success:function(r){
                        if (r.status=="success") {
                            // toastr.info(r.long_message);
                            $('#clB').empty();
                            $('#clB').text(r.long_message);
                            bt.remove();
                            location.reload(true);

                        }
                        if (r.status=="failure") {
                            toastr.warning(r.long_message);
                        }
                    },
                    error:function(){
                        toastr.warning("Please try again later");
                    }
                });
            });
        $('.date').datetimepicker({
              inline: true,
                sideBySide: true,
                format:'YYYY-MM-DD HH:mm'
              
                // Sorry for bad naming above
            });
			$(document).delegate( '.cll', "click",function (event) {
    //    $('.cll').click(function(){
           
            var oid=$(this).attr('data-oid');

       
            var cllurl="{{url('call/logistic')}}/"+oid;
            $('#cllModal').find('.modal-body').empty();
            $('#cllModal').modal('show');
            $('#cllModal').find('.modal-body').load(cllurl);
            $('#clNxt').prop('disabled',false);
            $('.confCL').prop('disabled',true);
            data={
                "oid":oid,
                "pdate":$('#date').val(),
                "pck":$('#pck').val()
            }


        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function(){
		$(document).delegate( '#clNxt', "click",function (event) {
    //    $('#clNxt').click(function(){
            // Validate.
            var tp=$('#tP').val();
            var isN=$.isNumeric(tp);
            var errors=0;
            counter=1;
            if (isN == true){
                if (Math.floor(tp) == tp) {
                    $(this).prop('disabled',true);
                    $('.confCL').prop('disabled',false);
                    $('.timedate').hide();
                    $('.dimension').show();
                    for (var i = 0; i < tp; i++) {
                        var content=' <tr class="Input">\
                <td class="no">'+counter+'.</td>\
                <span class="groupInput">\
                <td class="eachInput">\
                  <input type="text" name="weight" class="form-control weight" value=0 min="10">\
                </td>\
                <td class="eachInput">\
                  <input type="text" name="length" class="form-control length" min="10" value=0></td>\
                <td class="eachInput">\
                  <input type="text" name="width" class="form-control width" min="10" value=0>\
                </td>\
                <td class="eachInput">\
                  <input type="text" name="height" class="form-control height" min="10" value=0>\
                </td></span>\
             ';
             counter ++;
            $('.content').append(content);
                    }
                }else{
                    errors+=1;
                }
                
            }
            if (errors == 0) {

            }
        });
        

        
    });
</script>
<script type="text/javascript">
    var fileInput = new Array();var index = 0;
    $('.field_wrapper').delegate('input[type=file]','change', prepareUpload);

    // Grab the files and set them to our variable
    function prepareUpload(event) {
        var file = event.target.files[0];
        $(this).parent().siblings('.disableInputField').val( event.target.files[0].name);
        fileInput[index] = event.target.files[0];
      ++index;
    }
    var maxField = 10; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var fieldHTML = '<div>'+
            '<div class="inputBtnSection">'+
                    '<input id="uploadFile" class="disableInputField  " placeholder="Add New Attachment" />'+
                    '<label class="fileUpload">'+
                      '<input id="uploadBtn" name="field_name[]" type="file" class="upload"/>'+
                      '<span style="margin-top:0px" class="uploadBtn">Upload </span>'+
                    ' </label>'+
                  '</div>'+
            ' <a href="javascript:void(0);" class="remove_button" title="Remove field"><i class="fa fa-minus-circle"></i></a>'+
            '</div>'; //New input field html
     currentField = 1; //Initial field counter is 1
      $(wrapper).on('click', '.add_button', function() { //Once add button is clicked
        if(currentField <= maxField){ 
            ++currentField;
            $(wrapper).append(fieldHTML); // Add field html
        }
      //  //console.log('currentField  ' + currentField);
    });
    $(wrapper).on('click', '.remove_button', function(e){ //Once remove button is clicked
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        --currentField; //Decrement field counter
    });
    $('body').on('click', 'button.return', function(e) {
        $this = $(this);
        countdown = $this.siblings('span');
        porder_id = $(this).data('id');
        status = $(this).data('status');
        $('#returnModal').modal('show');
        form = document.getElementById('returnDetails');
    });
    $('#returnDetails').on('submit', function(e) {
        $.ajaxSetup({
            header:$('meta[name="_token"]').attr('content')
        });
        e.preventDefault();
        var formData = new FormData(form);
        i = 1;files = new Array();
        $.each(fileInput, function(key, value)
        {
            formData.append("img"+i++, value);
        });
        formData.append("len", i-1);
        formData.append("id", porder_id);
        formData.append("status" , status);
        //console.log("id" +" "+ porder_id);
        var id = '';
        var my_url = JS_BASE_URL+'/returndetails';
        var method = "POST";
        $.ajax({
            type: method,
            url: my_url,
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                $('#returnModal').modal('hide');
                $this.prop('disabled', true);
                $this.prop('disabled', true)
                countdown.countdown('stop');
                //console.log(response);
            },
            error: function (error) {
                //console.log(error);
            }

        });
    });
</script>
<div class="modal fade modal-transparent fade"" id="complainModal" role="dialog">
    <div class="modal-dialog modal-sm-12">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Feedback</h4>
            </div>
            <div class="modal-body container-fluid" id="complainModalBody">
            </div>
          
        </div>
    </div>
</div>
<script type="text/javascript">

    $(document).delegate( '.order-return-button', "click",function (event) {
//	$('.order-return-button').click(function(){
        // Create a return form
        var order_id=$(this).attr('data-id');
        var modal_url=JS_BASE_URL+"/return/init/modal/"+order_id;
        $('.return-area').empty();
          BootstrapDialog.show({
           title:'Return Form',
            message:$('<div class="return-area"></div>').load(modal_url)
          });
    });
    
    // $(".complain").click(function () {
    //  var $this= $(this);
    //  var status = $this.attr('data-status');
    //  var id = $(this).data('id');
    //  var my_url = JS_BASE_URL+'/complainorder/'+id;
    //  var method = "GET";
    //  // alert('ajax');
    //  $.ajax({
    //      type: method,
    //      url: my_url,
    //      // dataType: 'json',
    //      success: function (data) {
    //          if (data.status=="success" && data.short_message==1) {
    //              toastr.info(data.long_message);
    //              $this.text('Complained');
    //              $this.css('visibility','hidden');
    //              $this.css('background-color','grey');
    //              $('#order-status-bd_'+id).text('Complained');
    //              timer.css('visibility','hidden');
    //              // timer.countdown('stop');
    //          }
    //          if (data.status=="success" && data.short_message==2) {
    //              toastr.info(data.long_message);
    //              $this.text('Complained');
    //              $this.css('visibility','hidden');
    //              $this.css('background-color','grey');
    //              $('#order-status-bd_'+id).text('Complained');
    //              timer.css('visibility','hidden');
    //          }
    //          if (data.status=="failure") {
    //              toastr.warning(data.long_message);
    //          }
    //          // $this.addClass('disabled');
                
                
    //      },
    //      error: function (error) {
    //          $this.addClass('disabled');
    //          //console.log(error);
    //      }

    //  });     
    // });
     $(document).delegate( '.cancel', "click",function (event) {
//    $(".cancel").click(function () {
          // BootstrapDialog.alert("what");
        // alert('yeyy');
        var $this= $(this);
        var status = $this.attr('data-status');
        // alert(status);
        var timer = $this.closest('tr').find('.clock');
        //console.log(timer);
        // lol
        // alert("lol");
        if(status == 'unb-collected' || status == 'partial' || status == 'pending' || status=='') {
            var id = $(this).data('id');
            var my_url = JS_BASE_URL+'/cancelorder/'+id;
            var method = "GET";
            // alert('ajax');
            $.ajax({
                type: method,
                url: my_url,
                // dataType: 'json',
                success: function (data) {
                    if (data.status=="success" && data.short_message==1) {
                        toastr.info(data.long_message);
                        $this.text('Cancelled');
                        $this.prop('disabled',true);
                        $this.css('background-color','grey');
                        $('#order-status-bd_'+id).text('Cancelled');
                        timer.css('visibility','hidden');
                        // timer.countdown('stop');
                    }
                    if (data.status=="success" && data.short_message==2) {
                        toastr.info(data.long_message);
                        // $this.text('Cancelled');
                        $this.prop('disabled',true);
                        $this.css('background-color','grey');
                        $('#order-status-bd_'+id).text('Cancel Requested');
                        timer.css('visibility','hidden');
                    }
                    if (data.status=="failure") {
                        toastr.warning(data.long_message);
                    }
                    // $this.addClass('disabled');
                    
                    
                },
                error: function (error) {
                    $this.addClass('disabled');
                    //console.log(error);
                }

            });
        }

    });

/*
$("#limit").countdown("2015-07-02 19:40:00", function(event) {
    $(this).text(event.strftime('%D days %H:%M:%S')); 
}).on('finish.countdown', function() {
   $(this).hide();
});
*/



    $('[data-countdown]').each(function(){
        var status = $(this).parent().siblings().closest('[data-status]').data('status');
        var $this = $(this), finalDate = $(this).data('countdown');
        var ex = $(this).data('cancel');
        var re = $(this).data('return');

        if(status == 'b-collected' ){
            finalDate = $(this).data('receipt');
            $this.siblings('button').text('Return');
            $this.siblings('button').removeClass('cancel');
            if(re == 'yes'){
                $this.siblings('button').addClass('return');
                $this.countdown(finalDate, function(event) {
                    $this.html(event.strftime('%D:%M:%S')); //$this.html(event.strftime('%D days %H:%M:%S'));
                });
            }else{
                // $this.siblings('button').addClass('disabled');

                $this.siblings('button').removeClass('cancel');
                $this.siblings('button').remove();
            }
        } else if((status == 'unb-collected' ||
                    status == 'partial' ||
                    status == 'pending') &&
                    ex == 'yes') {

            /*
            if ($('#countdowntimer').html() != "") {
                $this.siblings('.cancel').remove();
                $('#countdowntimer').html("");
            }
            */
            $this.countdown(finalDate, function(event) {
                $this.html(event.strftime('%M:%S'));
                // console.log('bar'+event.strftime('%M:%S'));

            }).on('finish.countdown', function(event) {

                    // This line will kill the [Cancel] button on expiry
                    $this.siblings('.cancel').remove();
                    $('#countdowntimer').html("");
                });

        }else if(status == 'cancelled'){
              $this.siblings('button').text('Cancelled');
              $this.siblings('button').addClass('disabled');
              $this.siblings('button').removeClass('cancel');
              $this.siblings('button').css('background-color','grey');
            //  $this.siblings('button').siblings('[data-countdown]').countdown('stop');
        }else if(status == "cancelreq"){
            $this.siblings('button').addClass('disabled');
            $this.siblings('button').removeClass('cancel');
            $this.siblings('button').removeClass('return');
        }else if(status == "returnreq"){
            $this.siblings('button').text('Returnreq');
            $this.siblings('button').addClass('disabled');
            $this.siblings('button').removeClass('cancel');
            $this.siblings('button').removeClass('return');
        }else if(status == "returned"){
            $this.siblings('button').text('Returned');
            $this.siblings('button').addClass('disabled');
            $this.siblings('button').removeClass('cancel');
            $this.siblings('button').removeClass('return');
        }
    });
</script>

<script type="text/javascript">
    $(document).ready(function(){
		$(document).delegate( '.showFeedbackForm', "click",function (event) {
   //     $('.showFeedbackForm').click(function(){
            var oid= $(this).attr('data-oid');

            $('#complainModal').modal('show');
            $('#complainModalBody').load("{{url('buyer/feedback/')}}"+"/"+oid);
        });

        $('.prfee').click(function(){
            var oid=$(this).attr('rel-oid');
            $.ajax({
                type:'POST',
                url:"{{url('buyer/pay/rfee')}}",
                data:{"oid":oid},
                success:function(r){
                    if (r.status=="failure") {
                        toastr.warning(r.long_message);
                    }
                    if (r.status == "success") {
                        toastr.success(r.long_message);
                    }
                    $('.badge').text(r.cartTotalItems);
                },
                error:function(){
                    toastr.warning("Some error happened. Please contact OpenSupport");
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function(){
        $('.preventDefault').click(function(e){e.preventDefault();});
        $('[data-toggle="popover"]').popover();  
            $('.order-return-button').prop('disabled',false); 
    });
</script>
