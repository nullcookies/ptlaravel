<h2>Commission Summary</h2>
<span id="merchant-error-messages"></span>
<div class="table-responsive">
	<table class="table table-bordered" cellspacing="0" width="100%" id="gridcomm">
		<thead>
			<tr>
				<th class="text-center"
					style="background-color: #FF4C4C; color: #fff;"
					colspan="5">Account Information</th>
				<th style="background-color: #FB0000; color: #fff;"></th>
				<th class="text-center"
					colspan="6" style="background-color: #ff6600; color: #fff;">
					Merchant Consultant</th>
				<th class="text-center"
					colspan="6" style="background-color: #604a7b; color: #fff;">
					Merchant Professional</th>
				<!--<th style="background-color: #cc99ff; color: #fff;"></th>-->
				<th style="background-color: #800000; color: #fff;"></th>
				<th style="background-color: #558ed5; color: #fff;"></th>
			</tr>
			<tr>
				<th style="background-color: #FF4C4C; color: #fff;"
					class="text-center no-sort">No</th>
				<th style="background-color: #FF4C4C; color: #fff;"
					class="text-center">Merchant&nbsp;ID</th>
				<th style="background-color: #FF4C4C; color: #fff;"
					class="blarge">Company&nbsp;Name</th>
				<th style="background-color: #FF4C4C; color: #fff;"
					class="text-center">Commission</th>
				<th style="background-color: #FF4C4C; color: #fff;"
					class="text-center">Net&nbsp;Comm</th>
				<th style="background-color: #FB0000; color: #fff;"
					class="text-center">OpenSupermall</th>
				<th style="background-color: #ff6600; color: #fff;"
					class="text-center">MC&nbsp;ID</th>
				<th style="background-color: #ff6600; color: #fff;"
					class="text-center">Main</th>
				<th style="background-color: #ff6600; color: #fff;"
					class="text-center">%</th>
				<th style="background-color: #ff6600; color: #fff;"
					class="text-center">MC&nbsp;ID</th>
				<th style="background-color: #ff6600; color: #fff;"
					class="text-center">Referral</th>
				<th style="background-color: #ff6600; color: #fff;"
					class="text-center">%</th>
				<th style="background-color: #604a7b; color: #fff;"
					class="text-center">MP&nbsp;ID</th>
				<th style="background-color: #604a7b; color: #fff;"
					class="text-center">MP1</th>
				<th style="background-color: #604a7b; color: #fff;"
					class="text-center">%</th>
				<th style="background-color: #604a7b; color: #fff;"
					class="text-center">MP&nbsp;ID</th>
				<th style="background-color: #604a7b; color: #fff;"
					class="text-center">MP2</th>
				<th style="background-color: #604a7b; color: #fff;"
					class="text-center">%</th>
			<!--	<th style="background-color: #cc99ff; color: #fff;"
					class="text-center">PUSHER</th> -->
				<th style="background-color: #800000; color: #fff;"
					class="text-center">Station&nbsp;Recruiter</th>
				<th style="background-color: #558ed5; color: #fff;"
					class="text-center">SMM</th>
			</tr>
		</thead>
		<tbody>
			@foreach($summary as $summary)
			<?php
				

				$total = $summary->total;
				if(!is_numeric($total)){
					$total=0;
				}
				$total = number_format(($total/100),2);
				$ctotal = $total;
				$company=100;
				$ccom=100;
				$iscom=0;
				$mc = false;
				$ref = false;
				$p1 = false;
				$p2 = false;
				$psh = false;
				$rct = false;
				$smm = false;

				if(isset($summary->mc_sales_staff_commission)){
					if(isset($summary->referral_sales_staff_id)){
						$mccom = number_format($summary->mc_sales_staff_commission*$global->mc_with_ref_sales_staff_commission,2);
					} else {
						$mccom = number_format($summary->mc_sales_staff_commission,2);
					}
					$mctotal=number_format(($total*$mccom)/100,2);
					$ccom=$ccom-$summary->mc_sales_staff_commission;
					$iscom=$iscom+$summary->mc_sales_staff_commission;
					$ctotal=$ctotal+$mctotal;
					$mc = true;
				}
				if(isset($summary->referral_sales_staff_id)){
					$refcom = number_format($summary->mc_sales_staff_commission*$global->referral_sales_staff_commission,2);
					$reftotal=number_format(($total*$refcom)/100,2);
					$ref = true;
				}
				if(isset($summary->mcp1_sales_staff_commission)){
					$mp1com = number_format($summary->mcp1_sales_staff_commission,2);
					$mp1total=number_format(($total*$mp1com)/100,2);
					$ctotal=$ctotal-$mp1total;
					$ccom=$ccom-$mp1com;
					$iscom=$iscom+$summary->mcp1_sales_staff_commission;
					$company=$company-$summary->mcp1_sales_staff_commission;
					$p1 = true;
				}
				if(isset($summary->mcp2_sales_staff_commission)){
					$mp2com = number_format($summary->mcp2_sales_staff_commission,2);
					$mp2total=number_format(($total*$mp2com)/100,2);
					$ctotal=$ctotal-$mp2total;
					$ccom=$ccom-$mp2com;
					$iscom=$iscom+$summary->mcp2_sales_staff_commission;
					$company=$company-$summary->mcp2_sales_staff_commission;
					$p2 = true;
				}
				$psh_com = 0;
				if(isset($summary->psh_com) && ($summary->psh_com > 0)){
					$psh_total = number_format($summary->psh_com/100,2);
					$ctotal=$ctotal-$psh_total;
					$psh_com = ($psh_total*100)/$total;
					$psh_com = number_format($psh_com,2);
					$ccom=$ccom-$psh_com;
					$iscom=$iscom+$summary->mcp2_sales_staff_commission;
					$company=$company-$summary->psh_sales_staff_commission;
					$psh = true;
				}
				if(isset($summary->str_sales_staff_commission)){
					$strcom = number_format($summary->str_sales_staff_commission,2);
					$strtotal=number_format(($total*$strcom)/100,2);
					$ctotal=$ctotal-$strtotal;
					$ccom=$ccom-$strcom;
					$iscom=$iscom+$summary->str_sales_staff_commission;
					$company=$company-$summary->str_sales_staff_commission;
					$str = true;
				}
				if(isset($summary->smm_com) && ($summary->smm_com > 0)){
					$smm_total = number_format($summary->smm_com/100,2);
					$ctotal=$ctotal-$smm_total;
					$iscom=$iscom+$summary->smm_com;
					$smm_com = ($smm_total*100)/$total;
					$smm_com = number_format($smm_com,2);
					$ccom=$ccom-$smm_com;
					$smm = true;
				}

				$iscom = (($ccom+$psh_com)*$summary->osmall_commission)/100;
				$iscom = number_format($iscom,2);
				$constraint = $global->pri_commission_constraint;
				$constraint_val = 100- $ccom;
			?>
			<tr>
				<td class="text-center">
					{{$i++}}
				</td>

				<td class="text-center">
					<?php $formatted_summary_id = str_pad($summary->id, 10, '0', STR_PAD_LEFT); ?>
					<!--<a target="_blank" href="{{route('merchantPopup', ['id' => $summary->id])}}" class="update" data-id="{{ $summary->id }}">[{{$formatted_summary_id}}]</a>-->
				<a href="javascript:void(0)" class="view-merchID-modal" data-id="{{$summary->id }}"> 
				[{{$formatted_summary_id}}]</a> 

				</td>

				<td class="blarge">
					{{$summary->company_name}}
				</td>

				<td class="text-center">
					{{$summary->osmall_commission}}%
				</td>

				<td class="text-center" style="<?php
					if($constraint_val > $constraint){
						echo "";} ?>">
					{{$iscom}}%
				</td>

				<td class="text-center">
					{{$ccom}}%
				</td>

				<td class="text-center">
					@if($mc)
						<?php $formatted_mc_id = str_pad($summary->mc_sales_staff_id, 10, '0', STR_PAD_LEFT); ?>
						<!--<a target="_blank" href="{{route('userPopup', ['id' => $summary->mc_sales_staff_id])}}" class="update" data-id="{{ $summary->mc_sales_staff_id }}">[{{ $formatted_mc_id }}]</a>-->
<a href="javascript:void(0)" class="view-merchID-modal" data-id="{{$summary->mc_sales_staff_id }}"> 
				[{{$formatted_mc_id}}]</a> 

					@endif
				</td>

				<td>
					@if($mc)
						{{$summary->first_name1}} {{$summary->last_name1}}
					@endif
				</td>

				<td class="text-center">
					@if($mc)
						{{$mccom}}%
					@endif
				</td>

				<td class="text-center">
					@if($ref)
						<?php $formatted_ref_id = str_pad($summary->referral_sales_staff_id, 10, '0', STR_PAD_LEFT); ?>
						<!--<a target="_blank" href="{{route('userPopup', ['id' => $summary->referral_sales_staff_id])}}" class="update" data-id="{{ $summary->referral_sales_staff_id }}">[{{ $formatted_ref_id }}]</a>-->
<a href="javascript:void(0)" class="view-merchID-modal" data-id="{{$summary->referral_sales_staff_id }}"> 
				[{{$formatted_ref_id}}]</a>

					 @endif
				</td>

				<td>
					@if($ref)
						{{$summary->first_name2}} {{$summary->last_name2}}
					 @endif
				</td>

				<td class="text-center">
					@if($ref)
						{{$refcom}}%
					 @endif
				</td>

				<td class="text-center">
					@if($p1)
						<input type="hidden" id="id_p1{{ $summary->id }}" value="{{$summary->mcp1_sales_staff_id}}" />
						<input type="hidden" id="com_p1{{ $summary->id }}" value="{{$summary->mcp1_sales_staff_commission}}" />
						<?php $formatted_p1_id = str_pad($summary->mcp1_sales_staff_id, 10, '0', STR_PAD_LEFT); ?>
						<!--<a target="_blank" href="{{route('userPopup', ['id' => $summary->mcp1_sales_staff_id])}}" class="update" data-id="{{ $summary->mcp1_sales_staff_id }}">[{{ $formatted_p1_id }}]</a>-->
<a href="javascript:void(0)" class="view-merchID-modal" data-id="{{$summary->mcp1_sales_staff_id }}"> 
				[{{$formatted_p1_id}}]</a>

					@endif
				</td>

				<td>
					@if($p1)
						{{$summary->first_name3}} {{$summary->last_name3}}
					@endif
				</td>

				<td class="text-right">
					@if($p1)
						<p id="s_p1{{ $summary->id }}">{{ $summary->mcp1_sales_staff_commission }}%</p>
						<p id="s_i1{{ $summary->id }}" style="display:none;"><input type="text" value="{{$summary->mcp1_sales_staff_commission}}" id="s_c1{{ $summary->id }}" size="2"/>% <a class="btn btn-primary s1_btnedit" href="javascript:void(0)" rel="{{ $summary->id }}" > Save</a></p>
					@endif
				</td>

				<td class="text-center">
					@if($p2)
						<input type="hidden" id="id_p2{{ $summary->id }}" value="{{$summary->mcp2_sales_staff_id}}" />
						<?php $formatted_p2_id = str_pad($summary->mcp2_sales_staff_id, 10, '0', STR_PAD_LEFT); ?>
						<!--<a target="_blank" href="{{route('userPopup', ['id' => $summary->mcp2_sales_staff_id])}}" class="update" data-id="{{ $summary->mcp2_sales_staff_id }}">[{{ $formatted_p2_id }}]</a>-->
<a href="javascript:void(0)" class="view-merchID-modal" data-id="{{$summary->mcp2_sales_staff_id }}"> 
				[{{$formatted_p2_id}}]</a>

					@endif
				</td>

				<td>
					@if($p2)
						{{$summary->first_name4}} {{$summary->last_name4}}
					@endif
				</td>

				<td class="text-center">
					@if($p2)
						<p id="s_p2{{ $summary->id }}">{{ $summary->mcp2_sales_staff_commission }}%</p>
						<p id="s_i2{{ $summary->id }}" style="display:none;"><input type="text" value="{{$summary->mcp2_sales_staff_commission}}" id="s_c2{{ $summary->id }}" size="2"/>% <a class="btn btn-primary s2_btnedit" href="javascript:void(0)" rel="{{ $summary->id }}" > Save</a></p>
					@endif
				</td>

				<!--<td class="text-center">
					@if($psh)
						{{$psh_com}}%
					@endif
				</td>-->

				<td class="text-center">
					@if($str)
						{{$strcom}}%
					@endif
				</td>

				<td class="text-center">
					@if($smm)
						{{$smm_com}}%
					@endif
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
<script type="text/javascript">
	
	$(document).ready(function () {
		var table = $('#gridcomm').DataTable({
			"order": [],
			"scrollX":true,
			"columnDefs": [
				{ "targets": "no-sort", "orderable": false },
				{ "targets": "medium", "width": "95px" },
				{ "targets": "large",  "width": "120px" },
				{ "targets": "blarge", "width": "200px" },
				{ "targets": "xlarge", "width": "280px" }
			],
			"fixedColumns":   {
				"leftColumns": 2
			}
				});

		$(".sum_edit").click(function(){
			_this = $(this);
			var s_id= _this.attr('rel');
			$("#s_p1" + s_id).hide();
			$("#s_i1" + s_id).show();
			$("#s_p2" + s_id).hide();
			$("#s_i2" + s_id).show();
		});

		$('.s1_btnedit').click(function(){
			_this = $(this);
			var s_id= _this.attr('rel');
			var commission = $('#s_c1' + s_id).val();
			var id = $('#id_p1' + s_id).val();
			if($.isNumeric(commission)){
				var url = '/admin/commission/sales_staff/'+ id;
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

		$('.s2_btnedit').click(function(){
			_this = $(this);
			var s_id= _this.attr('rel');
			var commission = $('#s_c2' + s_id).val();
			var comp1 = $('#com_p1' + s_id).val();
			var id = $('#id_p2' + s_id).val();

			if($.isNumeric(commission)){
				if(commission < comp1){
				var url = '/admin/commission/sales_staff/'+ id;
				$.ajax({
				  url: url,
				  type: "post",
				  data: {'commission': commission},
				  success: function(data){
					location.reload();
				  }
				});
				} else {
					alert("MP2 Commission can't be greater than MP1!");
				}
			} else {
				alert(commission + "Invalid Number!");
			}
		});
	});

$('.view-merchID-modal').click(function(){

var id=$(this).attr('data-id');
var check_url=JS_BASE_URL+"/admin/popup/lx/check/user/"+id;
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
window.setInterval(function(){
              $('#merchant-error-messages').empty();
            }, 10000);

</script>
