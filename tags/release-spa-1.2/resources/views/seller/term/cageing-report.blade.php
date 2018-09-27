<?php
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\IdController;
use App\Classes;
 $cStatus=["completed","reviewed","commented"];
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
<div class=" col-sm-6 no-padding">
	<h2>Creditor Ageing Report Details</h2>
</div>
<div class=" col-sm-6 no-padding">

</div>
<?php 
	$e=1;
	$totalamt=0;
?>
		<div class="row">
			<div class=" col-sm-12">
				<table class="table table-bordered"
					id="cinvoices-table" width="100%">
					<thead>
					
					<tr style="background-color: #F29FD7; color: #FFF;">
						<th class="text-center bsmall">No.</th>
						<th class="text-center">Document&nbsp;No.</th>
						<th class="large text-center">Merchant&nbsp;ID</th>
						<th class="large text-center">Name</th>
						<th class="text-center">Payable</th>
						<th class="text-center">Mode</th>
						<th class="text-center">Payment</th>
						<th  style="background-color: green;" class="text-center">Status</th>
						<th class="text-center" style="background-color: #FF6600">Balance</th>
					</tr>
					</thead>					
					<tbody>
						@if(isset($dtcrediter))
							@foreach($dtcrediter as $dtcredit)
							<tr>
								<td class="text-center">{{$e}}</td>
								<td class="text-center">
									
								</td>
								<td class=""> 
									{{IdController::nM($dtcredit->merchant_id)}}
								</td>
								<td class="text-center">
									{{$dtcredit->name}}
								</td>
								<td class="text-right">
									-MYR <?php echo number_format((($dtcredit->order_price/100)*$dtcredit->quantity),2);  ?>
								</td>
								<td class="text-center">
									Credit Note
								</td>
								<td class="text-center">
									<a href="{{ url('/') }}/seller/balance/{{$dtcredit->porder_id}}/{{$dtcredit->station_id}}" target="_blank"> 
										{{ ucfirst($dtcredit->status)}}
									</a>
									
								</td>
								<td class="text-center">
									
								</td>
								<td class="text-right">
									
								</td>
							</tr>
							<?php $e++;?>
							@endforeach
						@endif 
						@if(isset($gatorcrediter))
							@foreach($gatorcrediter as $gatorcrediter)
							<tr>
								<td class="text-center">{{$e}}</td>
								<td class="text-center">
									
								</td>
								<td class=""> 
									{{IdController::nM($gatorcrediter->merchant_id)}}
								</td>
								<td class="text-center">
									{{$gatorcrediter->name}}
								</td>
								<td class="text-right">
									MYR <?php echo number_format((($gatorcrediter->order_price/100)*$gatorcrediter->quantity),2);  ?>
								</td>
								<td class="text-center">
									Gator
								</td>
								<td class="text-center">
									<a href="{{ url('/') }}/seller/balance/{{$gatorcrediter->porder_id}}/{{$gatorcrediter->station_id}}" target="_blank"> 
										{{ ucfirst($gatorcrediter->status)}}
									</a>
									
								</td>
								<td class="text-center">
									
								</td>
								<td class="text-right">
									
								</td>
							</tr>
							<?php $e++;?>
							@endforeach
						@endif
					@foreach($invoicessto as $inv)
						<tr>
							<td class="text-center">{{$e}}</td>
							<td class="text-center">
								<a href="{{ url('/') }}/invoice/{{$inv['oid']}}" target="_blank">{{str_pad($inv['invoice_no'],10,"0",STR_PAD_LEFT)}}</a>
							</td>
							<td class=""> 
								{{IdController::nM($inv['merchant_id'])}}
							</td>
							<td class="text-center">
								{{$inv['merchant_name']}}
							</td>
							<td class="text-right">
								MYR {{ number_format($inv['total']/100,2) }}
							</td>
							<td class="text-center">
								{{ ucfirst($inv['mode']) }}
							</td>
							<td class="text-center">
								<a href="{{ url('/') }}/seller/balance/{{$inv['oid']}}/{{$inv['uid']}}" target="_blank"> 
									{{ ucfirst($inv['invoice_payment']) }}
								</a>
							</td>
							<td class="text-center">
								<a href="{{ url('/') }}/seller/ageing/{{$inv['oid']}}/{{$inv['uid']}}" target="_blank"> 
									{{ ucfirst($inv['invoice_status']) }}
								</a>
							</td>
							<td class="text-right">
								<a href="{{ url('/') }}/seller/creditor_balance/{{$inv['oid']}}/{{$inv['uid']}}" target="_blank">
									MYR {{ number_format(($inv['total'] - $inv['paid'])/100,2) }}
									<?php $totalamt += ($inv['total'] - $inv['paid'])/100; ?>
								</a>
							</td>
						</tr>
					<?php $e++;?>
					@endforeach
					

					</tbody>
				</table>
				<input type="hidden" value="{{$e}}" id="nume" /> 
				<input type="hidden" value="{{$selluser->id}}" id="lpeid" />
				<input type="hidden" value="{{$totalamt}}" id="totalamt" />
		</div>
		</div>  
</div>
<script type="text/javascript">
    $(document).ready(function(){
		var ramt = js_number_format(parseFloat($("#totalamt").val()),2,'.',',');
		$("#toamt").html(ramt);
		var emp_table = $('#cinvoices-table').DataTable({
            "order": [],
			 "columns": [
					{ "width": "20px", "orderable": false },
					{ "width": "120px" },
					{ "width": "120px" },
					{ "width": "120px" },
					{ "width": "120px" },
					{ "width": "120px" },
					{ "width": "120px" },
					{ "width": "120px" },
					{ "width": "120px" },
				]
			});		

		$(document).delegate( '.memberchek', "click",function (event) {
			if($(this).prop('checked')){
				$('.memberchek').prop('checked',false);
				$(this).prop('checked',true);
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
