<h2>Station Recruiter Commission Master</h2>
<span id ="user-error-messages"></span>
<div class="table-responsive">
	<table class="table table-bordered" cellspacing="0" width="100%" id="grid4c">
		<thead style="background-color: #ffff00; color: #000;">
			<tr>
				<th class="text-center">No</th>
				<th class="text-center">SR&nbsp;ID</th>
				<th class="text-left">Name</th>
				<th class="text-center">Target&nbsp;Merchant</th>
				<th class="text-center medium">Target&nbsp;Revenue</th>
				<th class="text-center">Commission</th>
				<th class="text-center">Edit</th>
			</tr>
		</thead>
		<tbody>
			@foreach($stationrecruiter as $stationr)
			<tr>
				<td class="text-center">
					{{$i++}}
				</td>

				<td class="text-center">
					<?php $formatted_stationr_id = str_pad($stationr->id, 10, '0', STR_PAD_LEFT); ?>
					<!--<a target="_blank" href="{{route('userPopup', ['id' => $stationr->user_id])}}">[{{$formatted_stationr_id}}]</a>-->
				<a href="javascript:void(0)" class="view-user-modal" data-id="{{$stationr->user_id }}"> 
					[{{$formatted_stationr_id}}]</a> 
				</td>

				<td>
					{{$stationr->first_name}} {{$stationr->last_name}}
				</td>

				<td class="text-center">
					<p id="sr_tg{{ $stationr->id }}">{{ $stationr->target_merchant }}</p>
					<p id="sr_tgi{{ $stationr->id }}" style="display:none;"><input type="text" value="{{$stationr->target_merchant}}" id="sr_tgt{{ $stationr->id }}" size="8"/></p>
				</td>

				<td class="text-right">
					<p id="sr_re{{ $stationr->id }}">{{$currency}}&nbsp;{{number_format($stationr->target_revenue/100,2)}}</p>
					<p id="sr_rei{{ $stationr->id }}" style="display:none;">{{$currency}}&nbsp;<input type="text" value="{{$stationr->target_revenue/100}}" id="sr_rev{{ $stationr->id }}" size="8"/></p>
				</td>

				<td class="text-center">
					 <p id="sr_p{{ $stationr->id }}">{{number_format($stationr->commission,2)}}%</p>
					 <p id="sr_i{{ $stationr->id }}" style="display:none;"><input type="text" value="{{$stationr->commission}}" id="sr_c{{ $stationr->id }}" size="2"/>%</p>
				</td>
				<td class="text-center">
					<a rel="{{ $stationr->id }}" class="sr_edit" id="sr_edit{{ $stationr->id }}" href="javascript:void(0)">Edit</a>
					<a class="btn btn-primary sr_btnedit" style="display: none;" id ="sr_btnedit{{ $stationr->id }}" href="javascript:void(0)" rel="{{ $stationr->id }}" > Save</a>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	<br>
</div>
<script type="text/javascript">
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
			{ "width": "85px" },
			{ "width": "55px", "orderable": false}
		  ]
	});

	$(".sr_edit").click(function(){
		_this = $(this);
		var sr_id= _this.attr('rel');
		$("#sr_btnedit" + sr_id).show();
		$("#sr_edit" + sr_id).hide();
		$("#sr_p" + sr_id).hide();
		$("#sr_tg" + sr_id).hide();
		$("#sr_re" + sr_id).hide();
		$("#sr_i" + sr_id).show();
		$("#sr_rei" + sr_id).show();
		$("#sr_tgi" + sr_id).show();
	});

	$('.sr_btnedit').click(function(){
		_this = $(this);
		var sr_id= _this.attr('rel');
		var commission = $('#sr_c' + sr_id).val();
		var revenue = $('#sr_rev' + sr_id).val();
		var target = $('#sr_tgt' + sr_id).val();
		if($.isNumeric(commission) && $.isNumeric(revenue)){
			var url = '/admin/commission/sales_staffmc/'+ sr_id;
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
			alert("Invalid Number!");
		}
	});

});
$('.view-user-modal').click(function(){

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
	$('#user-error-messages').html(msg);
	}
	}
	});
});
window.setInterval(function(){
              $('#user-error-messages').empty();
            }, 10000);

</script>
