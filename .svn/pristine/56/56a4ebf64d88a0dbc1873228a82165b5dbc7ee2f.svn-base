<?php
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\IdController;
use App\Classes;
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
    .hide_mobile_op_overlay{
        text-decoration: none;
        color: inherit;
    }
    .mobile_table_op{
      /*  background: #000000 !important;*/
    }
    .vcenter {
            display: inline-block;
            vertical-align: middle;
            float: none;
        }
    table-borderless td,
    .table-borderless th {
        border: 0;
    }

</style>
{{-- MOBILE --}}
<span class="visible-xs">
    <div class="row show_details_mobile" style="background:#ffffff;position: absolute;z-index: 9999999999;width: 100%; display:none;height: 100%;">
        <div class="col-xs-12" >
            <a href="javascript:void(0);"  style="font-size: 1.4em;font-weight: bold;text-align: center;text-decoration: none;color: inherit;"><span class="text-center">Sales Order</span></a> <a class='pull-right hide_mobile_op_overlay' style="font-size: 1.4em;">X</a>
            <span id="formatted_op_for_mobile"></span>
        </div>
    </div>
    <div class="row">
       <div class="col-xs-12">
           <table class="table table-striped"  id="product_details_table_mobile">
               <thead>
                   <tr>
                       <th>Order&nbsp;ID</th>
                       <th>Status</th>
                   </tr>
               </thead>
               <tbody>
                   @if(isset($orders))
                        @foreach($orders as $p)
                            <tr>
                                
                                <td><a href="javascript:void(0);" class="get_details_mobile" oid="{{$p['oid']}}">{{IdController::nO($p['oid'])}}</a></td>
                                <td>{{ucfirst($p['status'])}}</td>
                                
                            </tr>
                        @endforeach
                    @endif
               </tbody>
           </table>
       </div>
    </div>
<script type="text/javascript">
    $(document).ready(function(){
        $('.get_details_mobile').click(function(){
            var oid=$(this).attr('oid');
            var url=JS_BASE_URL+"/mobile/formatted/op/"+oid;
            $.ajax({
                type:'GET',
                url:url,
                success:function(r){
                         $('#formatted_op_for_mobile').empty();
                        $('#formatted_op_for_mobile').append(r);
                        $('.show_details_mobile').show(1000);
                   
                },
                error:function(){
                    toastr.warning("Server Error");
                }
            });
        });
        $('body').on('click','.hide_mobile_op_overlay',function(){
            $('.show_details_mobile').hide();
        });
    });
</script>
</span>
{{--  MOB ENDS--}}
<span class="hidden-xs">
<h2>{{$title or 'Orders'}}</h2>
<table class="table table-bordered" id="product_details_table" width="100%">
    <thead>
    <?php $i=1;?>
    <tr class="bg-black">
        <th class="text-center no-sort">No</th>
        <th class="text-center medium">Order&nbsp;ID</th>
        <th class="text-center mediums">Order&nbsp;Received</th>
        <th class="text-center medium">Order&nbsp;Completed</th>
        <th class="text-center medium">Segment</th>
        <th class="text-center medium">Order&nbsp;Total</th>
        <th class="text-centermedium" >Status</th>
        <th class="no-sort text-center large"  style="background:green;" width="135px">Action</th>
    </tr>
    </thead>
    <tbody>
        @if(isset($orders))
            @foreach($orders as $p)
                <tr>
                    <td style="text-align: center;">{{$i}}</td>
                    <td style="text-align: center;">
						@if($p['mode'] == 'cash')
							<a href="{{route('Receipt', ['id' => $p['oid']])}}"
                            class="uniqporder" id="uniqporder_{{$p['oid']}}" data="{{$p['oid']}}"
                            target="_blank">{{IdController::nO($p['oid'])}}</a>
						@endif
						@if($p['mode'] == 'term')
							<a href="{{route('Invoice', ['id' => $p['oid']])}}"
                            class="uniqporder" id="uniqporder_{{$p['oid']}}" data="{{$p['oid']}}"
                            target="_blank">{{IdController::nO($p['oid'])}}</a>
						@endif
                    </td>

                    <td style="text-align: center;">
                        @if(isset($p['o_exec']))
                            {{UtilityController::s_date($p['o_exec'])}}
                        @endif

                    </td>
                    <?php 
                    $cStatus=["completed","reviewed","commented"];
                    ?>
                    <td style="text-align: center;">
                       @if(isset($p['o_rcv']))
                            @if($p['o_rcv'] !="0000-00-00 00:00:00"
                             and in_array($p['status'],$cStatus))
                                
                            {{UtilityController::s_date($p['o_rcv'])}}
                            @else --
                            @endif
                        @endif
                    </td>
                    <td style="text-align: center;">{{strtoupper($p['segment'])}}</td>
                    <?php $total = number_format($p['total']/100,2); ?>
                    <td style="text-align: right;">
                        {{$currentCurrency}} {{$total}}</td>
                    <?php $cE="nC";
                        $cTest=UtilityController::cE($p['oid']);
                        // dump($cTest);
                        if ($cTest[0]==1) {
                            $cE='cE';
                        }
                     ?>

                    <td style="text-align: center;" data-status="{{$p['status']}}" class="order-status-bd {{$cE}}"
                        id="order-status-bd_{{$p['oid']}}">
                        {{-- Paul on 1 MAY 2017 AT 11 30 pm removed href='#' and added role_id... --}}
                    <a href="javascript:void(0)" role_id="{{$p['oid']}}" class="preventDefault approval"

                    <?php

                    if ($cE=="cE") {
                        $ceid=$cTest[1]->complaint_reason_id;
                
                        // $ceid=1;
                        $reason="#ComplaintID: ".$cTest[1]->id."". DB::table('buyercomplaintreason')->where('id',$ceid)->first()->description ."";
                        // dump($reason);
                        echo "title='Complaint Filed' data-toggle='popover' data-placement='bottom' data-content='".$reason."'";
                    }
                    ?>
                    >
                    @if(is_null($p['status']))
                        In Process
                 {{--    @elseif($p['status']=='returnreq')
                        Return Requested
                    @elseif($p['status']=='m-approved1')
                        Return Approved
                    @elseif($p['status']=='b-returning2')
                        Return Approved & Paid
                    @elseif($p['status']=="m-processing1")
                        Order Processed
                    @elseif($p['status']=="m-processing2")
                        Order Scheduled for Delivery
                    @elseif($p['status']=="returnaccptd")
                        Return Accepted --}}
                    @else
                        {{ucfirst($p['status'])}}
                    @endif
                    </a>
                    </td>
                    <td style="text-align: center;">
                        <?php 
                            $date = $p['o_exec'];
                            $date = strtotime($date);
                            $date1 = new DateTime('now');
                            $date2 = new DateTime(date('Y-m-d H:i:s', strtotime("+ 3 days", $date)));
                            $dDiff = $date1->diff($date2);
                           /* dump($date1);
                            dump($date2);
                            dump($p['totaldiff']);*/
							if(strtoupper($p['segment']) == 'TOKEN'){
								$p['status'] = "completed";
							}
					//		dump($p['o_exec']);
                         ?>
                        {{-- @if($p['status']=='executed')
                            <button style="width: 65px;padding: 2px 5px !important;" data-status="{{$p['status']}}" type="button" class="showComplainForm btn btn-xs btn-danger" rel-order={{$p['oid']}}>Feedback</button>
                        @endif --}}



                  {{-- @if($p['status']!="cancelled") --}}
				  
  @if($p['totaldiff'] == "yes" and
                            $p['status']=='pending' )
                        <button style="width: 65px;padding: 2px 5px !important;" data-status="{{$p['status']}}" type="button" class="cancel pull-right btn btn-xs btn-cancel" data-id={{$p['oid']}}>Cancel</button>
                      
    @elseif ($p['status'] =="completed")
                        <button  class="btn btn-feedback  fdb showFeedbackForm" data-oid={{$p['oid']}}><span class="glyphicon glyphicon-bullhorn"></span> Feedback</button>

  @elseif ($p['status'] =='b-collected')
        <?php 

        ?>
                    <button s data-status="{{$p['status']}}" type="button" class=" btn btn-block btn-return order-return-button" data-id={{$p['oid']}}>Return</button>

                    
@elseif ($p['status'] == "m-approved1" or $p['status'] == "returnpartiallyaccepted" )
                    <a href="javascript:void(0);" class="btn btn-block btn-info showprfee"
                    rel-oid="{{$p['oid']}}"
                    >Return</a>
@elseif ($p['status'] == "request-goods")
    <button  data-oid="{{$p['oid']}}" class="btn btn-info cll"><span class="glyphicon glyphicon-earphone" ></span> Logistic</button>
                   
          
              

@elseif($p['status']=="call-logistic1" or $p['status']=="l-processing1")  
<a href="{{url('label/download',[$p['oid'],"b2m"])}}" class="btn " title="Print Label" alt="Print Label" style="background: #2BD52B!important;color: white;"><span class="glyphicon glyphicon-print"></span></a>&nbsp  
  @endif
{{-- @endif --}}  

                      @if(isset($p['o_exec']) && isset($p['o_receipt']))
                         
                                                <span style="font-size:0.8em;text-align: center;"  
                        class="col-md-5 clock text-center" data-receipt="{{UtilityController::calculateReturnTime($p['delivery_timestamp'])}}" 
                        data-cancel="{{UtilityController::cancelTime($p['o_exec'])}}" 
                        data-countdown="{{UtilityController::calculateCancelTime($p['o_exec'])}}"
                        data-return="{{UtilityController::returnTime($p['delivery_timestamp'])}}"  
                        id="countdowntimer"></span>
                      @endif
                      {{-- Complain Button --}}
                   {{--  @if($canComplain==1)
                        <button  class="btn btn-primary btn-danger" id="showComplainForm" rel-order="{{$p['oid']}}"><span class="glyphicon glyphicon-envelope"></span> Complain</button>
                    @endif --}}
                    </td>
                    
                </tr>
                <?php $i++; ?>
            @endforeach
        @endif
    </tbody>
</table>
</span>
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
{{--Remark Modal--}}
{{-- <script src="{{url('js/jquery.dataTables.min.js')}}"></script> --}}
<script src= "{{asset("js/jquery.countdown.min.js")}}"></script>
<script type="text/javascript">
    $(document).ready(function(){

		 var table = $('#product_details_table').DataTable({
			 "order": [],
		 /* 	"scrollX":true,*/
			"columnDefs": [
				{ "targets": "no-sort", "width": "20px", "orderable": false },
				{ "targets": "large", "width": "120px" },
				{ "targets": "smallestest", "width": "55px" },
				{ "targets": "medium", "width": "95px" },
				{ "targets": "xlarge", "width": "280px" }
			]
		});

	
        /*  Paul on 1 May 2017 at 11 30 pm to enable MRT  */
        $(document).delegate( '.approval', "click",function (event) {
            //  Paul on 1st May 2017 at 11 55 pm
            //window.open(JS_BASE_URL + "/admin/master/orderapp/" + $(this).attr("role_id"), '_blank');
            window.open(JS_BASE_URL + "/orderapp/" + $(this).attr("role_id"), '_blank');
        });
        /*  Ended  */

        $('.showprfee').click(function () {
            var oid = $(this).attr('rel-oid');
            var url="{{url('cre/status')}}"+"/"+oid;
            $('#sModal').find('.modal-body').load(url);
            $('#sModal').modal('show');
        })
        $('.cll').click(function(){
           
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
        $('.nclose').click(function(){
            
            var ref = $(this).attr('rel');
            $('#'+ref).modal('hide');
            // $('.nclose').removeAttr('id');

            // $('.nclose').trigger('click');
            location.reload();
        });

 

		$('.confCL').click($.debounce(500,function(){
			$('.btn-calll').hide();
            $('#cllModal').modal('hide');
				var url="{{url('call/logistic')}}";
				var oid= $('#confOID').val();
				var count=$('#tP').val();
				var isotime=$('#pD').val();
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
				// console.log(JSON.stringify(data));
				$.ajax({
					type:'POST',
					url: url,
					data:{"pd":data,
						"ts":isotime,
						"count":count,
						"oid":oid,
						"type":"b2m"
					},
					success:function(r){
						if (r.status=="success") {
							// toastr.info(r.long_message);
							$('#clB').empty();
							$('#clB').text(r.long_message);
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
			}));

        $('.date').datetimepicker({
              inline: true,
                sideBySide: true,
                format:'YYYY-MM-DD HH:mm'
              
                // Sorry for bad naming above
            });
        $('.cll').click(function(){
           
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
        $('#clNxt').click(function(){
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

    $('.order-return-button').click(function(){
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
    
    $(".cancel").click(function () {
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
                    $this.html(event.strftime('%D:%H:%M:%S')); //$this.html(event.strftime('%D days %H:%M:%S'));
                }).on('finish.countdown', function(event) {

                    // This line will kill the [Cancel] button on expiry
                    $this.siblings('.return').remove();
                    $('#countdowntimer').html("");
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
        $('.showFeedbackForm').click(function(){
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
