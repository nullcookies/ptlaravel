@extends("common.default")
<?php 
define('MAX_COLUMN_TEXT', 20);
use App\Http\Controllers\IdController;
$totalamt = 0;
?>
@section("content")
@include('common.sellermenu')
<section class="">
  <div class="container">
	<div class="row">
	<div class="col-sm-12">  
	<div id="employees">
		<div class="row">
			<div class=" col-sm-6">
				<h2>Debtor Ageing Report Details</h2>
				@if(!is_null($station))
					<h3>Station ID: {{IdController::nSeller($station->user_id)}}</h3>
					<h3>Station Name: {{$station->company_name}}</h3>
				@endif
			</div>
			<div class=" col-sm-6">
				&nbsp;
			</div>
		</div>
		<?php $e=1;?>
		<div class="row">
			<div class=" col-sm-12">
				<table class="table table-bordered"
					id="invoices-table" width="100%">
					<thead>
					<tr style="background-color: #F29FD7; color: #FFF;">
						<th class="text-center bsmall">No.</th>
						<th class="text-center">Document&nbsp;No.</th>
						@if(is_null($station))
							<th class="large text-center">Station&nbsp;ID</th>
							<th class="large text-center">Name</th>
						@endif
						<th class="text-center">Receivable</th>
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
								@if(is_null($station))
									<td class=""> 
										{{IdController::nSeller($dtcredit->station_id)}}
									</td>
									<td class="text-center">
										{{$dtcredit->name}}
									</td>
								@endif
								
								
								<td class="text-right">
									-MYR <?php echo number_format((($dtcredit->order_price/100)*$dtcredit->quantity),2);  ?>
								</td>
								<td class="text-center">
									Credit Note
								</td>
								<td class="text-center">
									<a href="{{ url('/') }}/seller/balance/{{$dtcredit->porder_id}}/{{$dtcredit->station_id}}/{{$selluser->id}}" target="_blank"> 
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
					@foreach($invoices as $inv)
						<tr>
							<td class="text-center">{{$e}}</td>
							<td class="text-center">
								<a href="{{ url('/') }}/merchantinvoice/{{$inv['oid']}}" target="_blank">{{str_pad($inv['invoice_no'],10,"0",STR_PAD_LEFT)}}</a>
							</td>
							@if(is_null($station))
								<td class=""> 
									{{IdController::nSeller($inv['uid'])}}
								</td>
								<td class="text-center">
									{{$inv['name']}}
								</td>
							@endif
							<td class="text-right">
								{{$currentCurrency}}&nbsp;{{ number_format($inv['total']/100,2) }}
							</td>
							<td class="text-center">
								{{ ucfirst($inv['mode']) }}
							</td>
							<td class="text-center">
								<a href="{{ url('/') }}/seller/balance/{{$inv['oid']}}/{{$inv['uid']}}/{{$selluser->id}}" target="_blank"> 
									{{ ucfirst($inv['invoice_payment']) }}
								</a>
							</td>
							<td class="text-center">
								<a href="{{ url('/') }}/seller/ageing/{{$inv['oid']}}/{{$inv['uid']}}/{{$selluser->id}}" target="_blank"> 
									{{ ucfirst($inv['invoice_status']) }}
								</a>
							</td>
							<td class="text-right">
								<a href="{{ url('/') }}/seller/debtor_balance/{{$inv['oid']}}/{{$inv['uid']}}/{{$selluser->id}}" target="_blank">
									{{$currentCurrency}}&nbsp;{{ number_format(($inv['total'] - $inv['paid'])/100,2) }}
									<?php $totalamt += ($inv['total'] - $inv['paid'])/100; ?>
								</a>
							</td>
						</tr>
					<?php $e++;?>
					@endforeach
					</tbody>
				</table>
				<br>
				<input type="hidden" value="{{$e}}" id="nume" /> 
				<input type="hidden" value="{{$selluser->id}}" id="lpeid" />
		</div>
		</div>    
	</div>
	</div>
	</div>
 </div>
</section>
<script type="text/javascript">
	function firstToUpperCase( str ) {
		return str.substr(0, 1).toUpperCase() + str.substr(1);
	}

	function validateEmail(email) {
		var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return re.test(email);
	}
	
    $(document).ready(function(){
		@if(is_null($station))
		var emp_table = $('#invoices-table').DataTable({
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
		@else
			var emp_table = $('#invoices-table').DataTable({
            "order": [],
			 "columns": [
					{ "width": "20px", "orderable": false },
					{ "width": "120px" },
					{ "width": "120px" },
					{ "width": "120px" },
					{ "width": "120px" },
					{ "width": "120px" },
					{ "width": "120px" },
				]
			});	
		@endif
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
						var msg="<div class=' alert alert-danger'>"+
							r.long_message+"</div>";
						$('#employee-error-messages').html(msg);
					}
				}
			});
		});		
    });
</script>
@stop
