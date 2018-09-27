@extends('common.default')
<?php
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\IdController;
?>
@section('content')
<style>
label{
	display: inline-block;
	max-width: 100%;
}  
</style>
	<div class="container" style="margin-top:30px;">
	@include('admin.panelHeading')
	<h3>Delivery Master</h3>
	<p class="bg-success success-msg" style="display:none;padding: 15px;"></p>
	<table id="adminmasterdel" class="table table-bordered" style="width:1120px;background-color:#6b013b;color:white;">
		<thead>
			<tr>
				<th class="no-sort text-center bsmall">No</th>
				<th class="text-center medium">Date</th>
				<th class="text-center medium">Order&nbsp;ID</th>
				<th class="text-center medium">Merchant&nbsp;ID</th>
				<th class="text-center medium" style="background-color:#6D9370;">Logistics&nbsp;ID</th>
				<th class="text-center medium">Dimension</th>
				<th class="text-center large">Sender</th>
				<th class="text-center large">Receipient</th>
				<th class="text-center medium">O.Status</th>
				<th class="text-center medium">D.Status</th>
				<th class="text-center medium">Fee</th>
			</tr>
		</thead>
		<tbody>
			@if(isset($delivery))
				<?php
					$no=1;
				?>
				@foreach($delivery as $d)
					
						<tr style="color:black;">
							<td class="text-center">{{$no}}</td>
							<td class="text-center">{{UtilityController::s_date($d->delivery_tstamp)}}</td>
							<td class="text-center"><a href="javascript:void(0)" class="view-orderid-modal" data-id="{{$d->porder_id }}">{{IdController::nO($d->porder_id)}}</a></td> 
							<td class="text-center"><a href="javascript:void(0)" class="view-merchant-modal" data-id="{{$d->merchant_id }}">{{IdController::nM($d->merchant_id)}}</a></td> 
							<td class="text-center">{{UtilityController::s_id($d->logistic_id)}}</td> 
							<td class="text-center"></td>
							<td class="text-center">
								@if(is_null($d->station_address_id))
									<!-- <a href="javascript:void(0)" class="sender_address" data-id="{{$d->merchant_address_id }}"> -->				{{$d->merchant_city_name}}
									<!--</a> -->
								@else
									<!--<a href="javascript:void(0)" class="sender_address" data-id="{{$d->station_address_id }}"> -->
										{{$d->station_city_name}}
									<!--</a> -->
								@endif
							</td>
							<td class="text-center"><!--<a href="javascript:void(0)" class="buyer_address" data-id="{{$d->buyer_address_id }}"> -->	{{$d->buyer_city_name}}<!--</a> --></td>
							<td class="text-center">{{$d->status}}</td>
							<td class="text-center">{{$d->dstatus}}</td>
							<td class="text-center"><!--<a href="javascript:void(0)" class="fee" data-fee="{{$d->fee }}" data-comm="{{$global->logistic_commission }}"> -->{{number_format((1+($global->logistic_commission/100)) * $d->fee,2)}}<!--</a> --></td>

						</tr>
						<?php $no++; ?>
					
				@endforeach
			@endif
		</tbody>
	</table>
	</div>
@stop
<script src="{{url('js/jquery.min.js')}}"></script>
<script src="{{url('js/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript">
	$(document).ready(function(){
		 $(document).delegate( '.view-orderid-modal', "click",function (event) {
		//$('.view-orderid-modal').click(function(){

		var porder_id=$(this).attr('data-id');
		var check_url=JS_BASE_URL+"/admin/popup/lx/check/order/"+porder_id;
		$.ajax({
			url:check_url,
			type:'GET',
			success:function (r) {
			console.log(r);
			
			if (r.status=="success") {
				var url=JS_BASE_URL+"/deliveryorder/"+porder_id;
				
				var w=window.open(url,"_blank");
				w.focus();
			}
			if (r.status=="failure") {
			var msg="<div class=' alert alert-danger'>"+r.long_message+"</div>";
			$('#orderid-error-messages').html(msg);
			}
			}
			});
		});		
		
		$(document).delegate( '.view-merchant-modal', "click",function (event) {
		//$('.view-merchant-modal').click(function(){

		var id=$(this).attr('data-id');
		var check_url=JS_BASE_URL+"/admin/popup/lx/check/merchant/"+id;
		$.ajax({
			url:check_url,
			type:'GET',
			success:function (r) {
			console.log(r);
			
			if (r.status=="success") {
			var url=JS_BASE_URL+"/admin/popup/merchant/"+id;
				var w=window.open(url,"_blank");
				w.focus();
			}
			if (r.status=="failure") {
			var msg="<div class=' alert alert-danger'>"+r.long_message+"</div>";
			$('#merchant-error-messages').html(msg);
			}
			}
			});
		});		
		
		$('#adminmasterdel').DataTable({
			"order": [],
		"scrollX": true,
		"columnDefs": [
			{"targets": "no-sort", "orderable": false},
			{"targets": "bsmall", "width": "20px"},
			{"targets": "medium", "width": "100px"},
			{"targets": "large",  "width": "200px"},
			{"targets": "approv", "width": "180px"},
			{"targets": "blarge", "width": "200px"},
			{"targets": "clarge", "width": "250px"},
			{"targets": "xlarge", "width": "300px"},
		],
		});
	});
</script>