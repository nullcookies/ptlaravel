@extends("common.default")
<?php 
use App\Http\Controllers\IdController;
use App\Http\Controllers\UtilityController;
?>
@section("content")
<style>
table#gridwish
{
    table-layout: fixed;
    max-width: none;
    width: auto;
    min-width: 100%;
}
</style>
<div class="container" style="margin-top:30px;">
        @include('admin/panelHeading')
            <div class="">
                 <h3>OpenWish Master</h3>
		<span id ="buyer-error-messages"></span>
                 <p class="bg-success success-msg" style="display:none;padding: 15px;"></p>
                 <table id="gridwish" class="table table-bordered">
                     <thead>
                         <tr style="color: black; background-color: #d7e748">
                             <th class="no-sort" style="text-align: center">No</th>
                            <th class="large">OpenWish&nbsp;ID</th>
                            <th class="large">Product&nbsp;ID</th>
                            <th class="large">Due</th>

                            <th class="large">OpenWisher</th>
                          
                            <th class="large">Balance</th>
                            <th style="background-color:green;color:white">Status</th>
<!--                        <th>Action</th>-->
                        </tr>
                     </thead>
                     <tbody>
                         <?php $index = 1; $current = date("d-m-Y H:i:s");//Carbon::now(); ?>
                            @foreach($openwish as $value)
                                <?php
                                    $timLeft=UtilityController::getOpenWishLeftDuration($value->created_at);
                                    $time = strtotime($value->created_at);
                                    $po_created_at = strtotime($value->po_created_at);
                                    $created_at = Carbon::create(date('Y',$time),date('m',$time),date('d',$time),date('h',$time),date('i',$time),date('s',$time));
                                    $current_date = Carbon::now();
                                    $days_left = abs($current_date->day - $created_at->day + $value->duration)."d ";
                                    $hour_left = abs($current_date->hour - $created_at->hour)."h ";
                                    $minute_left = abs($current_date->minute - $created_at->minute)."m ";
                                    $sec_left = abs($current_date->second - $created_at->second)."sec ";
                                    $due_date = Carbon::create($created_at->year,$created_at->month,$created_at->day,$created_at->hour,$created_at->minute,$created_at->second);
                                    $due_date->addDays($value->duration);
                                    $porder_created_at = Carbon::create(date('Y',$po_created_at),date('m',$po_created_at),date('d',$po_created_at),date('h',$po_created_at),date('i',$po_created_at),date('s',$po_created_at));
                                    $price = number_format(($value->discounted_price / 100) , 2,'.',',');
                                    $pledged = number_format($value->pledged_amt / 100 , 2);
                                    $balance = number_format(($value->discounted_price - $value->pledged_amt) / 100 , 2);
								
                                    ?>
                            <tr>

                                <td style="text-align: center">{{$index++}}</td>
                                <td class="owID" value={{$value->id}} rel="{{(!empty($value->id)) ? IdController::nOw($value->id) : null}}"><a class="owpDetails">{{(!empty($value->id)) ? IdController::nOw($value->id) : null}}</a></td>
                                <td><a target="_blank" href="{{ route('productconsumer', $value->product_id)}}"> {{IdController::nP($value->product_id)}}</a></td>

                                <td><a href="javascript:void(0);" class="duedate" rel-start="{{(!empty($value->created_at)) ? $created_at->format("dMy H:i") : null}}" rel-left="{{$timLeft}}">
                                {{(!empty($value->created_at)) ? $due_date->format('dMy H:i') : null}}
                                </a></td>
                                {{--"End Time Details"--}}

                          
                                <td class="userId" value="{{$value->user_id}}">
				<!--<a target="_blank" href="{{route('userPopup', ['id' => $value->user_id])}}">
				{{(!empty($value->user_id)) ? '['.sprintf('%010d', $value->user_id).'] ': null}} 
				</a>-->

				<a href="javascript:void(0)" class="view-buyer-modal" data-id="{{$value->user_id }}">
				{{(!empty($value->user_id)) ? IdController::nB($value->user_id): null}}
 				 </a>

{{(!empty($value->user_id)) ? $value->first_name.' '.$value->last_name : null}}
</td>

                      
                                <td><a href="javascript:void(0);" class="balance" rel-price="{{(!empty($value->discounted_price)) ? $currency->code.' '.$price : 0}}" rel-bought="{{(!empty($value->pledged_amt)) ? $currency->code.'  '.$pledged : 0}}">
                                {{(!empty($value->pledged_amt)) ? $currency->code.'  '.$balance: $currency->code." 0"}}</td>
                                <td>{{ucfirst($value->status)}}</td>
                            <!-- Action Menu Comment off 4/25/2016 -->
<!--                                <td>
                                    <button type="button" class="btn btn-primary btn-sm btn-edit"
                                            id="data-edit-{{$value->id}}"
                                            value="{{$value->id}}">
                                        <span class="glyphicon glyphicon-pencil"></span>
                                    </button>

                                    <button type="button" class="btn btn-danger btn-sm btn-delete"
                                            id="data-delete-{{$value->id}}"
                                            value="{{$value->id}}">
                                        <span class="glyphicon glyphicon-trash"></span>
                                    </button>
                                </td>-->
                     </tr>
                     @endforeach
                     </tbody>
                    </table>
                </div>
             {{--Model Form Start--}}
                        <!-- Button trigger modal -->

                <!--Edit Modal comment off 4/25/2016 -->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document" style="width: 80%">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title" id="myModalLabel">OpenWish Details</h4>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal" action="#" id="openwish">

                                    <div class="form-group">

                                         <label for="emp-position" class="col-sm-2 control-label">User Name</label>
                                        <div class="col-sm-4">

                                            <select class="bootstrap-select" id="user_id">
                                                @foreach($openwish as $user)
                                                    <option value="{{$user->user_id}}" >
                                                        {{$user->first_name}} {{$user->last_name}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                         <label for="emp-socso-no" class="col-sm-2 control-label">Product Name</label>
                                        <div class="col-sm-4">
                                             <select class="bootstrap-select" id="product_id">
                                                 @foreach($openwish as $product)
                                                <option value="{{$product->product_id}}" >
                                                    {{ $product->product_name }}
                                                </option>
                                            @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                         <label for="emp-socso-no" class="col-sm-2 control-label">Link ID</label>
                                        <div class="col-sm-4">
                                            <input type="number" min="0" type="text" class="form-control" id="link_id"
                                                placeholder="Link ID">
                                        </div>
                                        <label for="emp-epf-no" class="col-sm-2 control-label">Duration</label>
                                        <div class="col-sm-4">
                                            <input type="number" min="0" type="text" class="form-control" id="duration"
                                                   placeholder="Duration">
                                        </div>
                                    </div>

                                    {{--<button type="submit" class="btn btn-default">Save</button>--}}
                                    <input type="hidden" id="staff-staff-id" value="">


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
                      {{--Model Table Start openwishpledge --}}
                        <!-- Button trigger modal -->

                <!-- Modal -->
                <div class="modal fade" id="owpModal" tabindex="-1" role="dialog" aria-labelledby="owpModalLabel">
                    <div class="modal-dialog" role="document" style="width: 80%">
                        <div class="modal-content">
                            <div class="modal-header">

                                <h4 class="modal-title" id="owpModalLabel">OpenWish Pledge:</h4>
                            </div>
                            <div class="modal-body">
                                <table class="table table-bordered counter_table" id="owpTable" width="100%">
								<thead>
								<tr style="color: black; background-color: #d7e748">
									<th class="text-center">No.</th>
									<th class="text-center">OpenWisher</th>
									<th class="text-center">Source</th>
									<th>Wisher Friend</th>
									<th class="text-center">Source IP</th>
									<th class="text-center">Bought Date</th>
									<th class="text-center">Amount</th>
								</tr>
								</thead>
								<tbody id="t_body">
								</tbody>
								<tfoot id="t_foot">
									<tr>
										<td colspan="5"></td>
										<td  id="totalDates">Total</td>
										<td style="text-align:right" id="total_pledged_amt">Total</td>
									</tr>
								</tfoot>
								</table>
                                    {{--<button type="submit" class="btn btn-default">Save</button>--}}

							<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<!--<button type="submit" class="btn btn-primary btn-title">Save</button>-->
							</div>

                    </div>
                    </div>
                </div>
            </div>
            {{--Model Table End--}}
</div>
{{-- New Modals --}}
<div id="owModal" class="modal fade" role="dialog">
<div class="modal-dialog">

<!-- Modal content-->
<div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
   
  </div>
  <div class="modal-body">
    <table class="table">
        <thead>
            <tr style="color: black; background-color: #d7e748;" id="owModalTHeader"></tr>
        </thead>
        <tbody>
            <tr id="owModalTBody"></tr>
        </tbody>
    </table>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
  </div>
</div>

</div>
</div>
    <meta name="_token" content="{!! csrf_token() !!}"/>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.duedate').click(function(){
                $('#owModal').find('#owModalTHeader').empty();
                $('#owModal').find('#owModalTBody').empty();
                var start=$(this).attr('rel-start');
                var left=$(this).attr('rel-left');
                var header="<th>Start</th><th>Left</th>";
                var body="<td>"+start+"</td><td>"+left+"</td>";
                $('#owModal').find('#owModalTHeader').append(header);
                $('#owModal').find('#owModalTBody').append(body);
                $('#owModal').modal('show');
            });
            $('.balance').click(function(){
                $('#owModal').find('#owModalTHeader').empty();
                $('#owModal').find('#owModalTBody').empty();
                var openwish_id=$(this).attr('rel-owid');
                var openwish_id=39;
                url=JS_BASE_URL+"/owish/trans/"+openwish_id;
                $.ajax({
                    url:url,
                    type:'GET',
                    success:function(r){
                        if (r.status=="success") {
                            var header="<th>No</th><th>Product</th><th>Message</Message><th>Price</th><th>Bought</th>";
                            $('#owModal').find('#owModalTHeader').append(header);
                            var tbbody="";
                            for (var i = 0; i < r.data.length; i++) {
                                var temp=r.data[i];
                                tbbody+="<td>"+(i+1)+"</td><td>"+r.data[i].productname+"</td><td>"+r.data[i].message+"</td><td>"+r.data[i].productprice/100+"</td><td>"+r.data[i].bought+"</td>";
                                $('#owModal').find('#owModalTBody').append(tbbody);
                                $('#owModal').modal('show');
                            }
                        }
                        else{
                            toastr.warning(r.long_message);
                        }
                    }
                });
                // var price=$(this).attr('rel-price');
                // var bought="MYR "+$(this).attr('rel-bought');
                
                // var body="<td>"+price+"</td><td>"+bought+"</td>";
                
                
            });
            // ENDS
            $('#gridwish').DataTable({
                "order": [],
                "scrollX": true,
                "columnDefs": [{
                    "targets": 'no-sort',
                    "orderable": false
                },{ "targets": "large", "width": "120px" },{ "targets": "xlarge", "width": "300px" }],
                "fixedColumns":   {
                    "leftColumns": 2
                }
            });


         firstTime = 1;
            function parseDate(s) {
                var months = new Array("","Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
                var p = s.split('-');
                year = p[0].split('',4);
                month = p[1];
                d = p[2].split(' ' , 2);
                day = d[0];
                time = d[1].split(':' ,2);
                if(month < 10)
                   month = month % 10;
               console.log(year);
               // console.log(day + months[month] + year);
                return (day + months[month] + year[2] + year[3] +" "+ time[0]+":"+time[1]);
            }
            var formSubmitType = null;
            //Function To display Open wish Pledge details
            $(".owpDetails").click(function () {
                $('#t_body').html(" ");
                $("#owpModal").trigger("reset");
                val = $(this).parent('.owID').attr('value');
                valid = $(this).parent('.owID').attr('rel');
                userID = $(".userId").attr('value');
                function pad(num, size) {
                    var s = num+"";
                    while (s.length < size) s = "0" + s;
                    return s;
                }
                var url = JS_BASE_URL+"/admin/master/general/openwish/" + val;
                // console.log(url);
                val = pad(Number(val) , 10);
                formSubmitType = "show";
                $(".modal-title").text("OpenWish Discount Coupons: " + valid);
                $.ajax({
                    type: "GET",
                    url: url,
                    dataType: 'json',
                    success: function (data) {

                        // console.log(data['owp'])

                        var i , j;
                        total = 0;
                        total_dates = 0;
                        console.log(data);
                        for(i in data){
                            for(j in data[i]){
                                if(i === "currency")
                                    currency_code = data[i][j]["code"];
                            if(i === "owp"){
                                left_of = (data[i][j]["pledged_amt"] / 100);
                                left_of = left_of.toFixed(2);
                                left_of = left_of.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
                                created_at = parseDate(data[i][j]["created_at"]);
                                $("#owpTable tbody")
                                .append($('<tr>').attr("id" , "row"+j));
                                $('#row'+j)
                                    .append($('<td>').attr("class" ,"center").text(Number(j)+1))
                                    .append($('<td>').attr("class" ,"center").text(userID))
                                    .append($('<td>').attr("class" ,"center").text(data[i][j]["name"]))
                                    .append($('<td>').attr("class" ,"center").text(data[i][j]["smedia_account"]))
                                    .append($('<td>').attr("class" ,"center").text(data[i][j]["source_ip"]))
                                    .append($('<td>').attr("class" ,"center").text(created_at))
                                    .append($('<td>').attr("class" ,"currency").text(currency_code+ " " + left_of));
                                total += (data[i][j]["pledged_amt"] / 100);
                                total_dates++;
                            }


                            }
                            $(".currency").css("text-align","right");
                            $(".center").css("text-align","center");
                        }
                        total = Number(total).toFixed(2);
                        total = total.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
                        $('#totalDates').text((isNaN(total_dates)) ? 0 :"Total " + total_dates);
                        $('#total_pledged_amt').text("Total " + currency_code + "  " +(total));

                        if(firstTime){
                        $('#owpTable').DataTable({
                        "order":[],
                            "columnDefs": [
                            { "targets": [0],"bSort":false, "orderable": false,"searchable": false }
                            ]
                        });
                        firstTime = 0;
                        }
                        $("#owpModal").modal("show");
                    },
                    error: function (error) {
                        console.log(error);
                    }

                });
            });
            //Function To Handle Edit Button action
            $(".btn-edit").click(function () {
                $("#openwish").trigger("reset");
                $("#myModal").modal("show");
                ID = $(this).attr('value');
                formSubmitType = "edit";
                $(".modal-title").text("Openwish Edit");

            });
            $(".btn-details").click(function () {

            });

            //Delete Recored
            $(".btn-delete").click(function () {

                if (confirm('Are you sure you want to remove Staff Record?')) {
                    var id = $(this).attr("value");
                    var my_url = JS_BASE_URL+'/admin/master/general/openwish/' + id;
                    var method = "DELETE";
                    $.ajax({
                        type: method,
                        url: my_url,
                        dataType: 'json',
                        success: function (data) {
                            $(".success-msg").fadeIn();
                            $(".success-msg").text("Sale Staff successfully removed.");
                            $(".success-msg").fadeOut(4000);
                        },
                        error: function (error) {
                            console.log(error);
                        }

                    });

                }
            });

            //Handle Form Submit For Bothh Add and Edit
            $("#openwish").on('submit', function (event) {
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

                if (formSubmitType === "edit") {
                //    id = $("#owId").val();
                    method = 'GET';
                    my_url = JS_BASE_URL+'/admin/master/general/openwish/'+ID+'/edit';
                }

                if (formSubmitType === "add") {
                    method = 'POST';
                }
                var formData = {
                    id: Number(ID),
                    user_id: Number($("#user_id").val()),
                    product_id: Number($("#product_id").val()),
                    link_id: Number($("#link_id").val()),
                    duration: Number($("#duration").val())

                };
                console.log(formData);
                $.ajax({
                    type: method,
                    url: my_url,
                    data: formData,
                    dataType: 'json',
                    success: function (data) {
                        console.log(data);
                        data = null;
                        $('#myModal').modal('hide');
                        $(".success-msg").fadeIn();
                        if (formSubmitType === 'edit') {
                            $(".success-msg").text("Open Wish successfully updated.");
                        } else {
                            $(".success-msg").text("Open Wish  successfully added.");
                        }
                        $(".success-msg").fadeOut(4000);
                        formSubmitType = null;
                    },
                    error: function (error) {
                        console.log( error);
                    }

                });

            });
        });


$('.view-buyer-modal').click(function(){

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
	$('#buyer-error-messages').html(msg);
	}
	}
	});
});

window.setInterval(function(){
              $('#buyer-error-messages').empty();
            }, 10000);

    </script>

@stop
