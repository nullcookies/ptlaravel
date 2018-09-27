<?php 
	use App\Http\Controllers\IdController;
?>
<h2>Merchant Consultant Commission Master</h2>
<div class="table-responsive">
	<table class="table table-bordered" cellspacing="0" width="100%" id="grid4c">
		<thead style="background-color: #ff6600; color: #fff;">
			<tr>
				<th class="text-center">No</th>
				<th class="text-center">MC&nbsp;ID</th>
				<th class="text-left large">Name</th>
				<th class="text-center">Target&nbsp;Merchant</th>
				<th class="text-center medium">Target&nbsp;Revenue</th>
				<th class="text-center">Commission</th>
			</tr>
		</thead>
		<tbody>
			@foreach($merchantsconsultant as $merchantc)
			<tr>
				<td class="text-center">
					{{$i++}}
				</td>

				<td class="text-center">
					<?php $formatted_merchantc_id = IdController::nB($merchantc->user_id); ?>
					 <a target="_blank" href="{{route('userPopup', ['id' => $merchantc->user_id])}}">{{$formatted_merchantc_id}}</a>
				</td>

				<td>
					{{$merchantc->first_name}} {{$merchantc->last_name}}
				</td>
				<td class="text-center">
					<p id="mc_tg{{ $merchantc->id }}" class="mc_p1" rel="{{ $merchantc->id }}">{{ $merchantc->target_merchant }}</p>
					<p id="mc_tgi{{ $merchantc->id }}" style="display:none;"><input type="text" rel="{{ $merchantc->id }}" value="{{$merchantc->target_merchant}}" class="mcedit1" id="mc_tgt{{ $merchantc->id }}" size="8"/></p>
				</td>

				<td class="text-right">
					<p id="mc_re{{ $merchantc->id }}" class="mc_p2" rel="{{ $merchantc->id }}">{{$currency}}&nbsp;{{number_format($merchantc->target_revenue/100,2)}}</p>
					<p id="mc_rei{{ $merchantc->id }}" style="display:none;">{{$currency}}&nbsp;<input type="text" rel="{{ $merchantc->id }}" value="{{number_format($merchantc->target_revenue/100,2)}}" class="mcedit2" id="mc_rev{{ $merchantc->id }}" size="8"/></p>
				</td>
				<td class="text-center">
					 <p id="mc_p{{ $merchantc->id }}" class="mc_p" rel="{{ $merchantc->id }}">{{number_format($merchantc->commission,2)}}%</p>
					 <p id="mc_i{{ $merchantc->id }}" style="display:none;"><input type="text" rel="{{ $merchantc->id }}" value="{{number_format($merchantc->commission,2)}}" id="mc_c{{ $merchantc->id }}" class="mcedit" size="2"/>% </p>
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
		'scrollX':true,
		 'autoWidth':false,
		 "order": [],
		 "columns": [
			{ "width": "20px", "orderable": false },
			{ "width": "85px" },
			null,
			null,
			null,
			{ "width": "85px" }
		  ]
	});

	$(document).delegate( '.mc_p2', "click",function (event) {
	//$(".mc_p2").click(function(){
		_this = $(this);
		var mc_id= _this.attr('rel');
		$("#mc_rei" + mc_id).show();
		$("#mc_re" + mc_id).hide();
	});
	
	$(document).delegate( '.mc_p1', "click",function (event) {
	//$(".mc_p1").click(function(){
		_this = $(this);
		var mc_id= _this.attr('rel');
		$("#mc_tg" + mc_id).hide();
		$("#mc_tgi" + mc_id).show();
	});
	
	$(document).delegate( '.mc_p', "click",function (event) {
	//$(".mc_p").click(function(){
		_this = $(this);
		var mc_id= _this.attr('rel');
		$("#mc_p" + mc_id).hide();
		$("#mc_i" + mc_id).show();
	});
	
	$(document).delegate( '.mcedit', "blur",function (event) {
		_this = $(this);
		var log_id= _this.attr('rel');
		var commission = $('#mc_c' + log_id).val();
		if($.isNumeric(commission)){
			var url = '/admin/commission/sales_staffmc/'+ log_id;
			$.ajax({
			  url: url,
			  type: "post",
			  data: {
					'commission': commission
			  },
			  success: function(data){
				//location.reload();
				$("#mc_p" + log_id).show();
				$("#mc_p" + log_id).html(commission + "%");
				$("#mc_i" + log_id).hide();				
				toastr.info("Commission successfully changed!")
			  }
			});
		} else {
			toastr.error(commission + "Invalid Number!");
		}
	});
	
	$(document).delegate( '.mcedit1', "blur",function (event) {
		_this = $(this);
		var log_id= _this.attr('rel');
		var target_merchant = $('#mc_tgt' + log_id).val();
		if($.isNumeric(target_merchant)){
			var url = '/admin/commission/sales_staffmc/targetm/'+ log_id;
			$.ajax({
			  url: url,
			  type: "post",
			  data: {
					'target_merchant': target_merchant
			  },
			  success: function(data){
				//location.reload();
				$("#mc_tg" + log_id).show();
				$("#mc_tg" + log_id).html(target_merchant);
				$("#mc_tgi" + log_id).hide();				
				toastr.info("Target Merchant successfully changed!")
			  }
			});
		} else {
			toastr.error(target_merchant + "Invalid Number!");
		}
	});
	
	$(document).delegate( '.mcedit2', "blur",function (event) {
		_this = $(this);
		var log_id= _this.attr('rel');
		var target_revenue = $('#mc_rev' + log_id).val();
		if($.isNumeric(target_revenue)){
			var url = '/admin/commission/sales_staffmc/targetr/'+ log_id;
			$.ajax({
			  url: url,
			  type: "post",
			  data: {
					'target_revenue': target_revenue
			  },
			  success: function(data){
				//location.reload();
				$("#mc_re" + log_id).show();
				$("#mc_re" + log_id).html("{{$currentCurrency}} " + target_revenue);
				$("#mc_rei" + log_id).hide();				
				toastr.info("Target Revenue successfully changed!")
			  }
			});
		} else {
			toastr.error(target_revenue + "Invalid Number!");
		}
	});

	$('.mc_btnedit').click(function(){
		_this = $(this);
		var mc_id= _this.attr('rel');
		var commission = $('#mc_c' + mc_id).val();
		var revenue = $('#mc_rev' + mc_id).val();
		var target = $('#mc_tgt' + mc_id).val();
		if($.isNumeric(commission) && $.isNumeric(revenue)){
			var url = '/admin/commission/sales_staffmc/'+ mc_id;
			$.ajax({
			  url: url,
			  type: "post",
			  data: {
					'commission': commission,
					'target_revenue': revenue,
					'target_merchant': target
			  },
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
