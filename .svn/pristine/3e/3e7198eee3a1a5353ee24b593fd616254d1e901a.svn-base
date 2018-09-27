<?php $i = 1; ?>
<?php
use App\Classes;
define('MAX_COLUMN_TEXT', 20);
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\IdController;
?>
<h2>Logistic Commission Master</h2>
<div class="table-responsive">
	<table class="table table-bordered" cellspacing="0" width="100%" id="grid4c">
		<thead style="background-color: #6D9370; color: #fff;">
			<tr>
				<th class="text-center">No</th>
				<th class="text-center">Logistics&nbsp;ID</th>
				<th class="text-left" style="width:400px">Name</th>
				<th class="text-center" style="width:200px">Commission</th>
			</tr>
		</thead>
		<tbody>
			@foreach($logistic as $log)
			<tr>
				<td class="text-center">
					{{$i++}}
				</td>

				<td class="text-center">
					<?php
						$station = DB::table('station')->
							where('id',$log->station_id)->first();
						$uid = 0;
						if(!is_null($station)){
							$uid = $station->user_id;
						}
					?>
					<?php $formatted_logistic_id = IdController::nS($log->station_id); ?>
					<a href="{{ route('logistic_dashboard', ['id' => $uid]) }}" 
						target="_blank"> {{$formatted_logistic_id}} </a>
				</td>

				<td>
					{{$log->company_name}}
				</td>
				<td class="text-center">
					 <p id="log_p{{ $log->id }}" class="log_edit"
					 	rel="{{ $log->id }}">
							{{number_format($log->logistic_commission,2)}}%</p>
					 <p id="log_i{{ $log->id }}" style="display:none;">
					 	<input type="text"
						value="{{number_format($log->logistic_commission,2)}}"
						id="log_c{{ $log->id}}"
						rel="{{ $log->id }}" class="logedit"
						size="4"/>% </p>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
<script type="text/javascript">
/*ready*/
$(document).ready(function () {
	$('#grid4c').DataTable({
		//'scrollX':true,
		 'autoWidth':false,
		 "order": [],
		 "columns": [
			{ "width": "20px", "orderable": false },
			{ "width": "85px" },
			null,
			{ "width": "85px" }
		  ]
	});
	
	$(document).delegate( '.log_edit', "click",function (event) {
	//$(".log_edit").click(function(){
		_this = $(this);
		var log_id= _this.attr('rel');
		$("#log_btnedit_" + log_id).show();
		$("#log_edit_" + log_id).hide();
		$("#log_p" + log_id).hide();
		$("#log_i" + log_id).show();

	});
	
	$(document).delegate( '.logedit', "blur",function (event) {
	//$(".log_edit").click(function(){
		_this = $(this);
		var log_id= _this.attr('rel');
		var commission = $('#log_c' + log_id).val();
		if($.isNumeric(commission)){
			var url = '/admin/commission/logistic/'+ log_id;
			$.ajax({
			  url: url,
			  type: "post",
			  data: {
					'commission': commission
			  },
			  success: function(data){
				//location.reload();
				$("#log_btnedit_" + log_id).hide();
				$("#log_edit_" + log_id).show();
				$("#log_p" + log_id).show();
				$("#log_p" + log_id).html(commission + "%");
				$("#log_i" + log_id).hide();				
				toastr.info("Commission successfully changed!")
			  }
			});
		} else {
			toastr.error(commission + "Invalid Number!");
		}		

	});	
});
</script>
