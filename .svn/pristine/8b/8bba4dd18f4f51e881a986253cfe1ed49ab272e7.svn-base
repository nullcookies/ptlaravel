`<style>
.btn-mid {
    padding: 5px 12px;
    font-size: 14px;
    line-height: 1.3333333;
    border-radius: 0px;
	margin-right: 15px;
}

.select2-selection--single {
  overflow: hidden;
  text-overflow: ellipse;
}
</style>
<div class="row" style="margin-top: -15px;">
	<div class="col-sm-6" >
		<h2>Performance</h2>
	</div>

	<div class="col-sm-5">
		<!--
		@if($arrperformace['totali'] > 0)
			<a href="javascript:void(0)" class="payslip" style="margin-top: 20px; float: right;">Payslip</a>&nbsp;
		@endif
			-->
	</div>
	<div class="col-sm-1">
		<a href="javascript:void(0)" class="crm_management btn btn-danger" style="margin-top: 10px; float: right; ">CRM</a>
	</div>
</div>
<!--
<div class="col-sm-12" style="padding-left:0;padding-right:0">
	@if($arrperformace['totali'] > 0)
	<table id="performance_table" style="width: 100%;" class="table table-bordered">
	 <thead>
		<tr style="background-color: red; color: #FFF;">
			<th class="no-sort"></th>
			@if($arrperformace['mci'] > 0)
				<th style="vertical-align:middle" class="text-center">Merchant Consultant</th>
			@endif
			@if($arrperformace['stri'] > 0)
				<th style="vertical-align:middle" class="text-center">Station Recruiter</th>
			@endif
			@if($arrperformace['refi'] > 0)
				<th style="vertical-align:middle" class="text-center">Referral</th>
			@endif
			@if($arrperformace['smmi'] > 0)
				<th style="vertical-align:middle" class="text-center">Social Media Marketeer</th>
			@endif	
			@if($arrperformace['mpi'] > 0)
				<th style="vertical-align:middle" class="text-center">Merchant Professional</th>
			@endif
			{{--<th class="text-center">Pusher</th>--}}
			<th style="vertical-align:middle" class="text-center" style="background-color: black;">Total</th>
		</tr>
	 </thead>
	 <tbody>
		<tr>
			<td>Target</td>
			@if($arrperformace['mci'] > 0)
				<td class="text-right">{{$currency_code or 'MYR' }}
				{{number_format($arrperformace['mcr']/100,2)}}</td>
			@endif	
			@if($arrperformace['stri'] > 0)
				<td class="text-right">{{$currency_code or 'MYR' }}
				{{number_format($arrperformace['strr']/100,2)}}</td>
			@endif	
			@if($arrperformace['refi'] > 0)
				<td class="text-right">{{$currency_code or 'MYR' }}
				{{number_format($arrperformace['refr']/100,2)}}</td>
			@endif	
			@if($arrperformace['smmi'] > 0)
				<td class="text-right">{{$currency_code or 'MYR' }}
				{{number_format($arrperformace['smmr']/100,2)}}</td>
			@endif		
			@if($arrperformace['mpi'] > 0)
				<td class="text-right">{{$currency_code or 'MYR' }}
				{{number_format($arrperformace['mpr']/100,2)}}</td>
			@endif		
			{{--<td class="text-right">{{$currency_code or 'MYR' }}
				{{number_format($arrperformace['pshr']/100,2)}}</td>--}}
			<td class="text-right">{{$currency_code or 'MYR' }}
				{{number_format($arrperformace['totalr']/100,2)}}</td>
		</tr>
		<tr>
			<td>Sales</td>
			@if($arrperformace['mci'] > 0)
				<td class="text-right">{{$currency_code or 'MYR' }}
				{{number_format($arrperformace['mcs']/100,2)}}</td>
			@endif	
			@if($arrperformace['stri'] > 0)
				<td class="text-right">{{$currency_code or 'MYR' }}
				{{number_format($arrperformace['strs']/100,2)}}</td>
			@endif	
			@if($arrperformace['refi'] > 0)
				<td class="text-right">{{$currency_code or 'MYR' }}
				{{number_format($arrperformace['refs']/100,2)}}</td>
			@endif	
			@if($arrperformace['smmi'] > 0)
				<td class="text-right">{{$currency_code or 'MYR' }}
				{{number_format($arrperformace['smms']/100,2)}}</td>
			@endif	
			@if($arrperformace['mpi'] > 0)			
				<td class="text-right">{{$currency_code or 'MYR' }}
				{{number_format($arrperformace['mps']/100,2)}}</td>
			@endif		
			{{--<td class="text-right">{{$currency_code or 'MYR' }}
				{{number_format($arrperformace['pshs']/100,2)}}</td>--}}
			<td class="text-right">{{$currency_code or 'MYR' }}
				{{number_format($arrperformace['totals']/100,2)}}</td>
		</tr>
		<tr>
			<td>Commissions</td>
			@if($arrperformace['mci'] > 0)
				<td class="text-right">{{$currency_code or 'MYR' }}
				{{number_format($arrperformace['mc']/100,2)}}</td>
			@endif
			@if($arrperformace['stri'] > 0)
				<td class="text-right">{{$currency_code or 'MYR' }}
				{{number_format($arrperformace['str']/100,2)}}</td>
			@endif	
			@if($arrperformace['refi'] > 0)
				<td class="text-right">{{$currency_code or 'MYR' }}
				{{number_format($arrperformace['ref']/100,2)}}</td>
			@endif	
			@if($arrperformace['smmi'] > 0)
				<td class="text-right">{{$currency_code or 'MYR' }}
				{{number_format($arrperformace['smm']/100,2)}}</td>
			@endif		
			@if($arrperformace['mpi'] > 0)
				<td class="text-right">{{$currency_code or 'MYR' }}
				{{number_format($arrperformace['mp']/100,2)}}</td>
			@endif		
			{{--<td class="text-right">{{$currency_code or 'MYR' }}
				{{number_format($arrperformace['psh']/100,2)}}</td>--}}
			<td class="text-right">{{$currency_code or 'MYR' }}
				{{number_format($arrperformace['total']/100,2)}}</td>
		</tr>
	</tbody>
	</table>
	@else
	<p style="color: red">This facility records the performance of your participation in various interesting roles and activities. It will be enabled once you have registered. Contact OpenSupport for more details.</p>
	<table id="performance_table" style="width: 100%;" class="table table-bordered">
	 <thead>
		<tr style="background-color: red; color: #FFF;">
			<th class="no-sort"></th>
				<th style="vertical-align:middle" class="text-center"></th>
				<th style="vertical-align:middle" class="text-center"></th>
				<th style="vertical-align:middle" class="text-center"></th>
				<th style="vertical-align:middle" class="text-center"></th>
				<th style="vertical-align:middle" class="text-center"></th>
			<th style="vertical-align:middle" class="text-center" style="background-color: black;"></th>
		</tr>
	 </thead>
	 <tbody>
		<tr>
			<td>Target</td>
				<td class="text-right">{{$currency_code or 'MYR' }}
				0.00</td>
				<td class="text-right">{{$currency_code or 'MYR' }}
				0.00</td>
				<td class="text-right">{{$currency_code or 'MYR' }}
				0.00</td>	
				<td class="text-right">{{$currency_code or 'MYR' }}
				0.00</td>		
				<td class="text-right">{{$currency_code or 'MYR' }}
				0.00</td>	
				<td class="text-right">{{$currency_code or 'MYR' }}
				0.00</td>
		</tr>
		<tr>
			<td>Sales</td>
				<td class="text-right">{{$currency_code or 'MYR' }}
				0.00</td>
				<td class="text-right">{{$currency_code or 'MYR' }}
				0.00</td>
				<td class="text-right">{{$currency_code or 'MYR' }}
				0.00</td>	
				<td class="text-right">{{$currency_code or 'MYR' }}
				0.00</td>		
				<td class="text-right">{{$currency_code or 'MYR' }}
				0.00</td>	
				<td class="text-right">{{$currency_code or 'MYR' }}
				0.00</td>
		</tr>
		<tr>
			<td>Commissions</td>
				<td class="text-right">{{$currency_code or 'MYR' }}
				0.00</td>
				<td class="text-right">{{$currency_code or 'MYR' }}
				0.00</td>
				<td class="text-right">{{$currency_code or 'MYR' }}
				0.00</td>	
				<td class="text-right">{{$currency_code or 'MYR' }}
				0.00</td>		
				<td class="text-right">{{$currency_code or 'MYR' }}
				0.00</td>	
				<td class="text-right">{{$currency_code or 'MYR' }}
				0.00</td>
		</tr>
	</tbody>
	</table>		
	@endif
	
	@if($arrperformace['mci'] > 0 || $arrperformace['stri'] > 0)
		<br>
		<a href="javascript:void(0)" class="btn btn-green btn-mid pull-right" id="portfolio">Portfolio</a>
	@endif
</div>
-->
@if($ismc > 0)
<!--
<div class="col-sm-12" style="padding-left:0">
	<h2 style="margin-top:30px">Link</h2>
</div>
<div class="col-sm-12" style="padding-left:0">
	<div class="col-sm-11" style="padding-left:0">
		<div class="col-sm-4" style="padding-left:0">
			@if($merchants_c > 0)
				<p>Merchant: 
				
					<select id="merchant_link" style="width:100%">
						<option value="0">None Selected</option>
						@for($oo = 0; $oo < count($merchantsarr); $oo++)
							<option value="{{$merchantsarr[$oo]['id']}}">{{$merchantsarr[$oo]['name']}}</option>
						@endfor
					</select>
				</p>
			@else
				<p>Merchant: 
					<select id="merchant_link" disabled />
						<option value="0">None Selected</option>
					</select>
				</p>
				<p style="color: red;">You have no merchant to select.</p>
			@endif
			<input type="hidden" id="userid_link" value="{{$userjust_id}}" />
		</div>
		<div class="col-sm-4" style="padding-left:0">
			<p>MP1: 
				<select id="mp1_link" style="width:100%">
					<option value="0">None Selected</option>
					@for($oo = 0; $oo < count($buyersmprr); $oo++)
						<option value="{{$buyersmprr[$oo]['id']}}">{{$buyersmprr[$oo]['name']}}</option>
					@endfor
				</select>
			</p>
		</div>
		<div class="col-sm-4" style="padding-left:0">
			<p>MP2: 
				<select id="mp2_link" style="width:100%">
					<option value="0">None Selected</option>
					@for($oo = 0; $oo < count($buyersmprr); $oo++)
						<option value="{{$buyersmprr[$oo]['id']}}">{{$buyersmprr[$oo]['name']}}</option>
					@endfor
				</select>
			</p>
		</div>
	</div>
	<div class="col-sm-1" style="padding-left:0">
		@if($merchants_c > 0)
			<a id="send_link" class="btn btn-green btn-xs"
			href="javascript:void(0)"
			style="margin-top: 22px; font-size: 15px;">Send</a>
		@endif	
	</div>
</div>

<div class="col-sm-12" style="padding-left:0">
	<p style="color: red; display: none; font-size:100%;" id="link_error">
		Error: Merchant ID and MP1 are mandatory!</p>
</div>
<div class="col-sm-12" style="margin-top:30px;padding-left:0;padding-right:0">
	<h3>Link Status</h3>
	<table style="width: 100%;" class="table table-bordered" id="tablemcmp">
		<thead>
		<tr style="background-color: #604A7B; color: #FFF;">
			<th style="width:50px" class="text-center no-sort">No</th>
			<th class="text-center">Merchant&nbsp;ID</th>
			<th class="text-center">MP1</th>
			<th class="text-center">MP2</th>
			<th class="text-center">Status</th>
		</tr>
		</thead>
		<?php $t = 1; ?>
		<tbody>
		@foreach($mcmp as $mps)
		<tr>
			<td>{{$t++}}</td>
			<td><a href="{{route('merchantPopup', ['id' => $mps->merchant_id])}}">[{{str_pad($mps->merchant_id, 10, '0', STR_PAD_LEFT)}}]</a></td>
			<td><a href="{{route('userPopup', ['id' => $mps->buyer1_uid])}}">[{{str_pad($mps->buyer1_id, 10, '0', STR_PAD_LEFT)}}]</a></td>
			<td><a href="{{route('userPopup', ['id' => $mps->buyer2_uid])}}">[{{str_pad($mps->buyer2_id, 10, '0', STR_PAD_LEFT)}}]</a></td>
			<td>Completed</td>
		</tr>
		@endforeach
		</tbody>
		<?php $t--; ?>
	</table>
</div> -->
<input type="hidden" id="t" value="{{$t}}" />
@endif
	<div class="modal fade" id="myModalPortfolio" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document" style="width: 50%">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
								aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">My Portfolio</h4>
				</div>
				<div class="modal-body">
					<table style="width: 100%;" class="table table-bordered" id="tableportfolio">
						<thead>
						<tr style="background-color: #604A7B; color: #FFF;">
							<th style="width:50px" class="text-center no-sort">No</th>
							<th class="text-center">Merchant&nbsp;ID</th>
							<th class="text-center">Merchant&nbsp;Name</th>
						</tr>
						</thead>
						<?php $ty = 1; ?>
						<tbody>
							@foreach($portfolios as $portfolio)
							<tr>
								<td>{{$ty++}}</td>
								<td><a href="{{route('merchantPopup', ['id' => $portfolio->merchant_id])}}">[{{str_pad($portfolio->merchant_id, 10, '0', STR_PAD_LEFT)}}]</a></td>
								<td>{{$portfolio->merchant_name}}</td>
							</tr>
							@endforeach						
						</tbody>
					</table>			
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="myModalCRM" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document" style="width: 50%">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
								aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">CRM</h4>
				</div>
				<div class="modal-body">
					<div id="myBodyCRM">
					</div>
				</div>
			</div>
		</div>
	</div>	
<script type="text/javascript">
	$(document).ready(function(){	
		$(document).delegate( '.customer_name', "click",function (event) {
			var id = $(this).attr('rel');
			$(this).hide();
			$("#sinputcustomer_name" + id).show();
		});		
		
		$(document).delegate( '.customer_mobile', "click",function (event) {
			var id = $(this).attr('rel');
			$(this).hide();
			$("#sinputcustomer_mobile" + id).show();
		});		
		
		
		$(document).delegate( '.customer_name_input', "blur",function (event) {
			var id = $(this).attr('rel');
			var value = $(this).val();
			$.ajax({
				type: "POST",
				data: {data: value},
				url: JS_BASE_URL + "/seller/osmallmember/name/" + id,
				dataType: 'json',
				success: function (data) {
					$("#sinputcustomer_name" + id).hide();
					$("#customer_name" + id).html(value);
					$("#customer_name" + id).show();
					//obj.html("Send");
				},
				error: function (error) {
					toastr.error("An unexpected error ocurred");
				}

			});			
		});	
		
		$(document).delegate( '.customer_mobile_input', "blur",function (event) {
			var id = $(this).attr('rel');
			var value = $(this).val();
			$.ajax({
				type: "POST",
				data: {data: value},
				url: JS_BASE_URL + "/seller/osmallmember/mobile/" + id,
				dataType: 'json',
				success: function (data) {
					$("#sinputcustomer_mobile" + id).hide();
					$("#customer_mobile" + id).html(value);
					$("#customer_mobile" + id).show();
					//obj.html("Send");
				},
				error: function (error) {
					toastr.error("An unexpected error ocurred");
				}

			});			
		});			
});	
</script>
