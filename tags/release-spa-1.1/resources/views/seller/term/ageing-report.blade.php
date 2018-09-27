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
	<h2>Debtor Ageing Report</h2>
</div>
<div class=" col-sm-6 no-padding">
	<h3 align="right">
		@if(Auth::user()->hasRole('adm'))
			<a href="{{ url('/') }}/seller/debtorageing/{{$selluser->id}}" target="_blank" class="btn btn-primary btn-danger pull-right allTransactions">
			All Transactions
			</a>
		@else
			<a href="{{ url('/') }}/seller/debtorageing" target="_blank" class="btn btn-primary btn-danger pull-right allTransactions">
			All Transactions
			</a>
		@endif
	 </h3>
</div>
<?php 
	$e=1;
	$totalamt=0;
?>
		<div class="row">
			<div class=" col-sm-12">
				<table class="table table-bordered"
					id="invoices-table" width="100%">
					<thead>
					
					<tr style="background-color: #F29FD7; color: #FFF;">
						<th class="text-center bsmall">No.</th>
						<th class="text-center">Station&nbsp;ID</th>
						<th class="large text-center">Name</th>
						<th class="text-center">Total&nbsp;Outstanding</th>
					</tr>
					</thead>					
					<tbody>
					@foreach($dtdebtor as $dtdebtor)
						<tr>
							<td class="text-center">{{$e}}</td>
							<td class="text-center">
								{{IdController::nSeller($dtdebtor->station_id)}}
							</td>
							<td class=""> 
								Credit Note ({{$dtdebtor->status}})
							</td>
							<td class="text-right">
								@if(Auth::user()->hasRole('adm'))
									<a href="{{ url('/') }}/seller/debtorageing/{{$selluser->id}}/{{$dtdebtor->station_id}}" target="_blank">
										-{{$currentCurrency}} <?php echo number_format((($dtdebtor->order_price/100)*$dtdebtor->quantity),2);  ?>
										
									</a>
								@else
									<a href="{{ url('/') }}/seller/debtorageing/0/{{$dtdebtor->station_id}}" target="_blank">
										
										-{{$currentCurrency}} <?php echo number_format((($dtdebtor->order_price/100)*$dtdebtor->quantity),2);  ?>
									</a>
								
								@endif
							</td>
						</tr>
					<?php $e++;?>
					@endforeach
				@foreach($gatordebtor as $gatordebtor)
						<tr>
							<td class="text-center">{{$e}}</td>
							<td class="text-center">
								{{IdController::nSeller($gatordebtor->station_id)}}
							</td>
							<td class="text-center"> 
								Gator 
							</td>
							<td class="text-right">
								@if(Auth::user()->hasRole('adm'))
									<a href="{{ url('/') }}/seller/debtorageing/{{$selluser->id}}/{{$gatordebtor->station_id}}" target="_blank">
										{{$currentCurrency}} <?php echo number_format((($gatordebtor->order_price/100)*$gatordebtor->quantity),2);  ?>
										
									</a>
								@else
									<a href="{{ url('/') }}/seller/debtorageing/0/{{$gatordebtor->station_id}}" target="_blank">
										
										{{$currentCurrency}} <?php echo number_format((($gatordebtor->order_price/100)*$gatordebtor->quantity),2);  ?>
									</a>
								
								@endif
							</td>
						</tr>
					<?php $e++;?>
					@endforeach
					@foreach($invoices_total as $totalinv)
						<tr>
							<td class="text-center">{{$e}}</td>
							<td class="text-center">
								{{IdController::nSeller($totalinv->user_id)}}
							</td>
							<td class=""> 
								{{$totalinv->company_name}}
							</td>
							<td class="text-right">
								@if(Auth::user()->hasRole('adm'))
									<a href="{{ url('/') }}/seller/debtorageing/{{$selluser->id}}/{{$totalinv->user_id}}" target="_blank">
										{{$currentCurrency}}&nbsp;{{ number_format(($totalinv->totalb - $totalinv->totalp)/100,2) }}
										<?php $totalamt += ($totalinv->totalb - $totalinv->totalp)/100; ?>
									</a>
								@else
									<a href="{{ url('/') }}/seller/debtorageing/0/{{$totalinv->user_id}}" target="_blank">
										{{$currentCurrency}}&nbsp;{{ number_format(($totalinv->totalb - $totalinv->totalp)/100,2) }}
										<?php $totalamt += ($totalinv->totalb - $totalinv->totalp)/100; ?>
									</a>
								
								@endif
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
	function firstToUpperCase( str ) {
		return str.substr(0, 1).toUpperCase() + str.substr(1);
	}

	function validateEmail(email) {
		var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return re.test(email);
	}
	
	
	
    $(document).ready(function(){
		var ramt = js_number_format(parseFloat($("#totalamt").val()),2,'.',',');
		$("#toamt").html(ramt);
		var emp_table = $('#invoices-table').DataTable({
            "order": [],
			 "columns": [
					{ "width": "20px", "orderable": false },
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
