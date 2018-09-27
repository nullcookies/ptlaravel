<?php $currency = $currentCurrency;
use App\Http\Controllers\IdController;
 ?>
<h2>SMM Commission Master</h2>
<div class="table-responsive">
	<table class="table table-bordered" cellspacing="0" width="100%" id="grid4c">
		<thead style="background-color: #558ed5; color: #fff;">
			<tr>
				<th style="vertical-align:middle"
					class="text-center no-sort">No</th>
				<th style="vertical-align:middle"
					class="text-center">Merchant&nbsp;ID</th>
				<th style="vertical-align:middle"
					class="text-center xlarge">SMM Derived Sales</th>
				<th style="vertical-align:middle"
					class="text-center medium">Revenue</th>
				<th style="vertical-align:middle"
					class="text-center large">SMM Allocation %</th>
				<th style="vertical-align:middle"
					class="text-center large">SMM Allocation</th>
				<th style="vertical-align:middle"
					class="text-center xlarge">Successful Sales Click/Bought</th>
				<th style="vertical-align:middle"
					class="text-center">Average</th>
				<th style="vertical-align:middle"
					class="text-center">Edit</th>
			</tr>
		</thead>
		<tbody>
			@foreach($smm as $issmm)
			<tr>
				<td class="text-center">
					{{$i++}}
				</td>

				<td class="text-center">
					<?php $formatted_merchant_id = IdController::nM($issmm->id); ?>
					 <a target="_blank" href="{{route('merchantPopup', ['id' => $issmm->id])}}">{{$formatted_merchant_id}}</a>
				</td>

				<td class="text-right">
					<?php $formatted_smmtotal = number_format(($issmm->smmtotal/100),2);?>
					<p>{{$currency}} {{$formatted_smmtotal}}</p>
				</td>

				<td style="text-align: right;">
					<?php $revenue = number_format(($formatted_smmtotal * $issmm->osmall_commission)/100,2); ?>
					<p>{{$currency}} {{$revenue}}</p>
				</td>

				<td class="text-center">
					<p id="smm_p{{ $issmm->id }}">{{$issmm->smm_sales_staff_commission}}%</p>
					<p id="smm_i{{ $issmm->id }}" style="display:none;"><input type="text" value="{{$issmm->smm_sales_staff_commission}}" id="smm_c{{ $issmm->id }}" size="2"/>% <a class="btn btn-primary smm_btnedit" href="javascript:void(0)" rel="{{ $issmm->id }}" > Save</a></p>
				</td>

				<td class="text-right">
					<?php $smmtt = number_format(($revenue * $issmm->smm_sales_staff_commission)/100,2); ?>
					<p>{{ $smmtt }}</p>
				</td>

				<td class="text-center">
					<p>{{ $issmm->smmcount }}</p>
				</td>

				<td class="text-center">
					<?php $avgsmmtt = number_format(($smmtt/$issmm->smmcount),2);  ?>
					<p>{{ $avgsmmtt }}</p>
				</td>

				<td class="text-center">
					<a rel="{{ $issmm->id }}" class="smm_edit" href="javascript:void(0)">Edit</a>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
<script type="text/javascript">
$(document).ready(function () {
	$('#grid4c').DataTable({
		'scrollX':true,
		 "order": [],
		 "columnDefs": [
				{ "targets": "no-sort", "orderable": false },
				{ "targets": "large", "width": "130px" },
				{ "targets": "smallestest", "width": "55px" },
				{ "targets": "medium", "width": "95px" },
				{ "targets": "xlarge", "width": "280px" }
			]
	});

	$(".smm_edit").click(function(){
		_this = $(this);
		var smm_id= _this.attr('rel');
		$("#smm_p" + smm_id).hide();
		$("#smm_i" + smm_id).show();
	});

	$('.smm_btnedit').click(function(){
		_this = $(this);
		var smm_id= _this.attr('rel');
		var commission = $('#smm_c' + smm_id).val();
		if($.isNumeric(commission)){
			var url = '/admin/commission/merchantsmm/'+ smm_id;
			$.ajax({
			  url: url,
			  type: "post",
			  data: {'commission': commission},
			  success: function(data){
				location.reload();
			  }
			});
		} else {
			alert(commission + "Invalid Number!");
		}
	});
});
</script>
