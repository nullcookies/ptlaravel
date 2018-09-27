<?php
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\IdController;
use App\Classes;
define('MAX_COLUMN_TEXTvw', 20);
$globals = DB::table('global')->first();
?>
<style>
    .row-centered{text-align:center;margin: 0 auto;margin-top:15px;}
    dl {
  width: 100%;
  overflow: hidden;
  /*background: #ff0;*/
  padding: 0;
  margin: 0
}
dt {
  float: left;
  width: 50%;
  /* adjust the width; make sure the total of both is 100% */
  /*background: #cc0;*/
  padding: 0;
  margin: 0
}
dd {
  float: left;
  width: 50%;
  /* adjust the width; make sure the total of both is 100% */
  /*background: #dd0*/
  padding: 0;
  margin: 0
}

.clock{
	padding:0px;margin-left:-6px;margin-top: 2px;color: #d9534f;
}
</style>
<div class=" " > <!-- col-sm-12 -->
<h2>Sales OrderXXX</h2>
<br>
    <table class="table table-bordered" id="product_details_table">
        <thead>
       {{--  <tr class="bg-black">
            <th colspan="11">Order Details</th>
        </tr> --}}

        <tr class="bg-black" >
       {{--      <th class="no-sort"></th> --}}
            <th class="text-center no-sort">No</th>
            <th class="text-center" width="100px">Order&nbsp;ID</th>
            <th class="text-center" width="100px">Order&nbsp;Received</th>
            <th class="text-center" width="100px">Order&nbsp;Executed</th>
            {{-- <th>SKU</th> --}}
            <th class="text-center" width="150px">Description</th>
            <th class="text-center" width="100px">Order&nbsp;Total</th>
            <th class="text-center" width="150px" style="background:green;">Remarks</th>
            <th class="text-center" width="100px" style="background:green;">Status</th>
            <th class="no-sort" width="135px" style="background:green;">Approval</th>
        </tr>
        </thead>
        <tfoot>
            {{-- <button class="btn btn-success pull-right" style="margin-bottom:10px; background:rgb(140,199,63);" disabled=>Approve</button> --}}
        </tfoot>
        <tbody>
        {{--  --}}
            <?php $i=1;
            //dd($ordersb);
            // dump($ordersb);
            ?>
        
        @if(isset($ordersb))
            @foreach($ordersb as $p)
                <tr>
                    {{-- <td><input type="checkbox" name="process[]" class="process" data-oid="{{$p['oid']}}"></td> --}}
                     <td style="text-align: center;">{{$i}}</td>
                     {{-- Route change--}}
                    <td style="text-align: center;"><a href="{{route('deliverorder', ['id' => $p['oid']])}}" class="uniqporder" id="uniqporder" data="{{$p['oid']}}">{{IdController::nO($p['oid'])}}</a>
                    </td>
                    <td style="text-align: center;">{{UtilityController::s_date($p['rcv_date'])}}</td>
                    <td style="text-align: center;">
                    @if($p['o_exec']=="0000-00-00 00:00:00")
                    --
                    @else
                    {{UtilityController::s_date($p['o_exec'])}}
                    @endif
                    <td style="text-align: center;"><a href="javascript:void(0);" title="{{$p['desc']}}" class="showdesc">{{substr($p['desc'],0,20)}}</a></td>
                    <script type="text/javascript">
                        $(document).ready(function(){
                            // $('.process :checked' ).
                        });
                    </script>
                    <?php $total = number_format($p['total']/100,2); ?>
						<td style="text-align: center;">
								{{$currentCurrency}} {{$total}}
						</td>
{{--  --}}
                          <td id="remarks_column" style="text-align: center;">
                        <?php
                        $remark = DB::table('remark')
                                ->select('remark')
                                ->join('stationremark','stationremark.remark_id','=','remark.id')
                                ->where('stationremark.station_id',$station_id)
                                ->orderBy('remark.created_at', 'desc')
                                ->first();
                        ?>
                        <a href="javascript:void(0)" id="mcrid_{{$station_id}}" class="mcridso" rel="{{$station_id}}">
                            @if($remark)
								<?php
									/* Processed note */
									$pfullnote = null;
									$pnote = null;
									$elipsis = "...";
									$pfullnote = $remark->remark;
									$pnote = substr($pfullnote,0, MAX_COLUMN_TEXTvw);

									if (strlen($pfullnote) > MAX_COLUMN_TEXTvw)
										$pnote = $pnote . $elipsis;
								?> 	
								<span title='{{$pfullnote}}'>{{$pnote}}</span>	
                            @endif
                        </a>
                    </td>

                    <td style="text-align: center;" data-status="{{$p['status']}}" >
                        @if(is_null($p['status']))
                                In Process
                            @elseif($p['status']=='cancelreq')
                                Cancel Requested
                            @elseif($p['status']=='returnreq')
                                Return Requested
                            @elseif($p['status']=="returnrjctd")
                                Return Rejected
                            @elseif($p['status']=="returnaccptd")
                                Return Accepted
                            @else
                                <span id="s{{$p['oid']}}">{{ucfirst($p['status'])}}<span>
                            @endif
                    
                    </td>
                     <td style="text-align: center;">
                     <?php 
						$date = $p['o_exec'];
                        $date = strtotime($date);
						$date1 = new DateTime('now');
						$date2 = new DateTime(date('Y-m-d H:i:s', strtotime("+ $globals->merchant_process_salesorder_window hours", $date)));
						$dDiff = $date1->diff($date2);
						if ($dDiff->format("%r") != '-' && $p['status']=='pending') {
					 ?>
                         <button class="btn btn-success pull-right process_order" rel="{{$p['oid']}}" style="margin-bottom:10px; background:rgb(140,199,63);">Process</button>
						 <span style="text-align:center
                        ;" class="col-md-5 clock"
                        data-cancel="{{UtilityController::cancelTime($p['o_exec'])}}" 
                        data-countdown="{{UtilityController::calculateProcessTime($p['o_exec'])}}"
                        id="countdowntimer{{$p['oid']}}"></span>
					<?php } ?>	 
   
                    </td>
                </tr>
                <?php $i++; ?>
            @endforeach
        @endif
        </tbody>

    </table>
</div>
{{-- <div class="clearfix"> </div> --}}
{{--Remark Modal--}}
<div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 50%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Account Manager</h4>
            </div>
            <div class="modal-body">
                <h3 id="modal-Tittle1"></h3>
                <h3 id="modal-Tittle"></h3>
                <div class="table-responsive">
                    <table id="myTable" class="table table-bordered myTable"></table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>

        </div>
    </div>
</div>
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
{{-- <input type="hidden" id="crereasonshidden" data-array="{{$cre_r_arr}}"> --}}
 <!--CRE_Reason Modal -->
    <div class="modal fade" id="crereason" role="dialog">
        <div class="modal-dialog modal-sm">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">CRE </h4>
                </div>
                <div class="modal-body">
                    <dl style="display:inline;">
                        <dt>Action</dt> <dd class="dd-action"></dd>
                        <dt>Order Id</dt><dd class="dd-oid"></dd>
                        <dt>Status</dt><dd class="dd-status"></dd>
                        {{-- <dt>Product Id</dt><dd class="dd-pid"></dd> --}}
                        <dt>Reason</dt> <dd class="dd-reason"></dd>
                        {{-- Area to add further info if return --}}
                        <span id="add_further"></span>
                        <input type="hidden" class="cre-id">
                    </dl>
                </div>
              {{--   <div class="modal-body">
                    <select id="reason" class="">
                        <option value="" disabled selected>Select reason</option>
                        @if(isset($crereasons))
                            @foreach($crereasons as $reason)
                            <option value="{{$reason->id}}">{{ucwords($reason->reason_text)}}</option>
                            @endforeach
                        @endif
                    </select>
                    <div class="row">
                        <div class="col-md-12 row-centered" style="">
                            <button type="button" style="width:70px;background:#c9302c;color:white" data-dismiss="modal" class="btn-close btn btn-md">Cancel</button>
                            <button type="submit" style="width:70px;background:#337ab7;color:white" class="btn-add btn btn-md save">Save</button>
                        </div>
                    </div>
                </div> --}}
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-status='' id="confirmcre">Confirm</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    {{--END CRE_Reason Modal--}}
{{-- <div class="clearfix"> </div> --}}
<script src= {{asset("js/jquery.countdown.min.js")}}></script>
<script type="text/javascript">
function pad (str, max) {
    str = str.toString();
    return str.length < max ? pad("0" + str, max) : str;
}
	$(document).ready(function(){
		
		$('[data-countdown]').each(function(){
			var $this = $(this), finalDate = $(this).data('countdown');
			 $this.countdown(finalDate, function(event) {
                $this.html(event.strftime('%H:%M:%S')); //$this.html(event.strftime('%D days %H:%M:%S'));
              });
		});
		
		$('body').delegate( ".process_order", "click",function (event) {
			var obj = $(this);
			var rel = $(this).attr("rel");
			var url = JS_BASE_URL+'/admin/station/order_process/'+ rel;
			$.ajax({
					type: "POST",
					url: url,
					dataType: 'json',
					success: function (data) {
						toastr.info("Order successfully updated!");
						obj.hide();
						$("#p" + rel).show();
						$("#countdowntimer" + rel).hide();
						$("#s" + rel).text("Processing");
						
					}
			});
		});
	});
    $('#remarks_column').delegate( ".mcridso", "click",function (event) {
        _this = $(this);
        var id_merchant = _this.attr('rel');
        //console.log('Merchant Id  '+id_merchant);
        $('#modal-Tittle2').html("Remarks");

        var url = JS_BASE_URL+'/admin/master/merchant_remarks/'+ id_merchant;
        $.ajax({
            type: "GET",
            url: url,
            dataType: 'json',
            success: function (data) {
                var html = "<table class='table table-bordered' cellspacing='0' width='100%' ><tr style='background-color: #FF4C4C; color: white;'><th>No</th><th>Merchant ID</th><th>Status</th><th>Admin User ID</th><th>Remarks</th><th>DateTime</th></tr>";
                for (i=0; i < data.length; i++) {
                    var obj = data[i];
                    html += "<tr>";
                    html += "<td>"+(i+1)+"</td>";
                    html += "<td><a href='../../admin/popup/merchant/"+id_merchant+"' class='update' data-id='"+id_merchant+"'>["+pad(id_merchant.toString(),10)+"]</a></td>";
                    html += "<td>"+obj.status+"</td>";
                    html += "<td><a href='../../admin/popup/user/"+obj.user_id+"' class='update' data-id='"+obj.user_id+"'>["+pad(obj.user_id.toString(),10)+"]</td>";
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
</script>
 {{--Cancellation Script--}}
<script type="text/javascript">
    $(".cancellation").click(function (event) {
        // var c=$(this).data('array');
        
        var cre_id=($this).attr('data-cre');
        var r=$('#crereasonshidden').data('array');
        var cre=$.grep(r,function(e){return e.id==cre_id})[0];

        // var crereason=r[index].reason_text;
        // alert(cre[0].reason_text);
        $('#confirmcre').attr('data-status',$(this).data('status'));
        $('.cre-id').attr('cre_id',cre_id);
        $('.dd-action').text(ucfirst(c.type));
        if (c.type=="return") {
            var html_content="";
            var prod_array=$('custom').data('creop');
                for (var i = 0; i < prod_array.length; i++) {
                  html_content="<label style=' display: block;padding-left: 15px;text-indent: -15px;'><input type='checkbox' class='product_accepted_for_return' name=pafr[] style='width: 13px;height: 13px;padding: 0;  margin:0; vertical-align:bottom;  position: relative;  top: -1px;  *overflow: hidden;'> Product ID: "+prod_array[i].product_id+ "</label>"; 
                }
            $('#add_further').html(
                html_content


                );
        }
        $('.dd-oid').text(ucfirst(c.porder_id));
        $('.dd-status').text(ucfirst(c.status));
        $('.dd-reason').text(ucfirst(cre.reason_text));
        $('#crereason').modal('show');
        $this_button = $(this);
    });
    $('#confirmcre').click(function(){
        var action=$(this).data('status');
        var cre_id=$('.cre-id').attr('cre_id');
        var url=JS_BASE_URL+"/merchant/"+action+"/"+cre_id;
        $.ajax({
            type:'GET',
            url:url,
            success:function(r){
                if (r.status=="success") {
                    toastr.info(r.long_message);
                }
            },
            error:function(){toastr.warning("Something went wrong");}
        });
    });
    $('#crereason').on('click','.save' ,function (e) {
        e.preventDefault();
        var reason_id = $("select#reason option:selected").val();
        var id = $this_button.data('id');
        var status = $this_button.data('status');
        var siblings = $this_button.siblings();
        if(status == 'approve'){
            status = 'approve';
        }else if(status == 'reject'){
            status = 'reject';
        }
        var my_url = JS_BASE_URL+'/merchant/'+ status + '/' + cre_id;
        var method = "POST";
        $.ajax({
            type: method,
            url: my_url,
            dataType: 'json',
            success: function (data) {
                $this_button.prop('disabled', true);
                siblings.prop('disabled', true);
                $('#crereason').modal('hide');
                //console.log(data);
            },
            error: function (error) {
                //console.log(error);
            }
         });
    });
    $('.md-so-data-countdown').each(function(){
        var $this = $(this);
        var finalDate = $(this).data('countdown');
        var from=finalDate.split("-");
        var year,month,day;
        year=from[0];month=from[1];day=from[2].split(" ")[0];
        // var finalDate=new Date(year,month,day);
        finalDate=year+"/"+month+"/"+day;

//         $(this).countdown('2020/10/10', function(event) {
//   $(this).html(event.strftime('%D days %H:%M:%S'));
// });

        var status = $this.parent('td').siblings('[data-status]').data('status');
        //console.log(status);
        var ex = $this.data('expired');
        if(status == "cancelled"){
            $this.siblings('.reject').prop('disabled', true);
            $this.siblings('.approve').prop('disabled', true);
        }else if(ex == 'no'){
            $this.countdown(finalDate, function(event) {
                $this.html(event.strftime('%D:%M:%S'));
                $this.siblings('.reject');
                $this.siblings('.approve');
            }).on('finish.countdown', function(event) {
                $this.siblings('.reject').hide();
                $this.siblings('.approve').hide();
            });
        }else if((status == 'cancelreq' || status == 'returnreq')){
                $this.siblings('.reject').hide();
                $this.siblings('.approve').hide();
        }
        //console.log(ex);
    });
</script>
