<?php
 $global_vars = DB::table('global')->first();
use App\Http\Controllers\IdController;
 ?>
<h2>Merchant Commission Master</h2>
<span  id="merchant-error-messages">
    </span>
<div class="table-responsive">
	<table class="table table-bordered" cellspacing="0" width="100%" id="grid5c">
		<thead style="background-color: #ff6666; color: #fff;">
			<tr>
				<th class="text-center" colspan="3">Merchant</th>
				<th class="text-center" colspan="2">Retail/Hyper</th>
				<th class="text-center" colspan="2">B2B</th>
				<th class="text-center" colspan="2">Fee</th>
			</tr>
			<tr>
				<th class="text-center">No</th>
				<th class="text-center">Merchant&nbsp;ID</th>
				<th class="text-center">Company&nbsp;Name</th>
				<th class="text-center">Type</th>
				<th class="text-center">Commission</th>
				<th class="text-center">Type</th>
				<th class="text-center">Commission</th>	
				<th class="text-center">Admin</th>
				<th class="text-center">Annual</th>				
			</tr>
		</thead>
		<tbody>
			@foreach($merchants as $merchant)
			<tr>
				<td class="text-center">
					{{$i++}}
				</td>

				<td class="text-center">
					<?php $formatted_merchant_id =IdController::nM($merchant->id); ?>
					<!--<a target="_blank" href="{{route('merchantPopup', ['id' => $merchant->id])}}" class="update" data-id="{{ $merchant->id }}">[{{$formatted_merchant_id}}]</a>-->
				<a href="javascript:void(0)" class="view-merchant-modal" data-id="{{$merchant->id }}"> 
				{{$formatted_merchant_id}}</a> 
				</td>

				<td>
					{{$merchant->company_name}}
				</td>
				<?php if($merchant->commission_type != 'std' && $merchant->commission_type != 'var'){
							$merchant->commission_type = $global_vars->commission_type;
					  } 
				?>
				<td class="text-center">
					<p id="m_pt{{ $merchant->id }}" class="mp_type" rel="{{ $merchant->id }}">@if($merchant->commission_type == 'std') Standard @else Variable @endif</p>
					<p id="m_ps{{ $merchant->id }}" style="display: none;" rel="{{ $merchant->id }}"><select id="m_s{{ $merchant->id }}" rel="{{ $merchant->id }}" class="m_s" rel="{{$merchant->id}}"><option value="Standard" @if($merchant->commission_type == 'std') selected @endif >Standard</option><option value="Variable" @if($merchant->commission_type == 'var') selected @endif>Variable</option></select></p>
				</td>

				<td class="text-center">
					@if($merchant->osmall_commission > 0)	
						<p id="m_p{{ $merchant->id }}" class="reg_edit" rel="{{ $merchant->id }}" @if($merchant->commission_type == 'var') style="display:none;" @endif>
							{{number_format($merchant->osmall_commission,2,'.','')}}%
						</p>
						<p id="m_i{{ $merchant->id }}" style="display:none;"><input type="text" class="reg_input" rel="{{ $merchant->id }}" value="{{number_format($merchant->osmall_commission,2,'.','')}}" id="m_c{{ $merchant->id }}" size="4"/>%
						</p>	
					@else
						<p id="m_p{{ $merchant->id }}" class="reg_edit" rel="{{ $merchant->id }}" @if($merchant->commission_type == 'var') style="display:none;" @endif>
							{{number_format($global_vars->osmall_commission,2,'.','')}}%
						</p>
						<p id="m_i{{ $merchant->id }}" style="display:none;"><input type="text" class="reg_input" rel="{{ $merchant->id }}" value="{{number_format($global_vars->osmall_commission,2,'.','')}}" id="m_c{{ $merchant->id }}" size="4"/>%
						</p>							
					@endif
					<p id="m_a{{ $merchant->id }}" @if($merchant->commission_type == 'std') style="display:none;" @endif><a class="btn btn-primary variation" id="{{$merchant->id}}" href="javascript:void(0)">Variable</a></p>

				</td>
				<?php if($merchant->b2b_commission_type != 'std' && $merchant->b2b_commission_type != 'var'){
							$merchant->b2b_commission_type = $global_vars->b2b_commission_type;
					  } 
				?>
				<td class="text-center">
					<p id="b2b_m_pt{{ $merchant->id }}" class="b2b_mp_type" rel="{{ $merchant->id }}">@if($merchant->b2b_commission_type == 'std') Standard @else Variable @endif</p>
					<p id="b2b_m_ps{{ $merchant->id }}" style="display: none;"><select id="b2b_m_s{{ $merchant->id }}" class="b2b_m_s" rel="{{$merchant->id}}"><option value="Standard" @if($merchant->b2b_commission_type == 'std') selected @endif >Standard</option><option value="Variable" @if($merchant->b2b_commission_type == 'var') selected @endif>Variable</option></select></p>
				</td>

				<td class="text-center">
					@if($merchant->b2b_osmall_commission > 0)
						<p id="b2b_m_p{{ $merchant->id }}" class="b2b_edit" rel="{{ $merchant->id }}" @if($merchant->b2b_commission_type == 'var') style="display:none;" @endif>{{number_format($merchant->b2b_osmall_commission,2,'.','')}}%</p>
						<p id="b2b_m_i{{ $merchant->id }}" style="display:none;"><input type="text" rel="{{ $merchant->id }}" class="b2b_input" value="{{number_format($merchant->b2b_osmall_commission,2,'.','')}}" id="b2b_m_c{{ $merchant->id }}" size="4"/>%</p>									
						<p id="b2b_m_a{{ $merchant->id }}" @if($merchant->b2b_commission_type == 'std') style="display:none;" @endif><a class="btn btn-primary b2b_variation" id="{{$merchant->id}}" href="javascript:void(0)">Variable</a></p>
					@else
						<p id="b2b_m_p{{ $merchant->id }}" class="b2b_edit" rel="{{ $merchant->id }}" @if($merchant->b2b_commission_type == 'var') style="display:none;" @endif>{{number_format($global_vars->b2b_osmall_commission,2,'.','')}}%</p>
						<p id="b2b_m_i{{ $merchant->id }}" style="display:none;"><input type="text" class="b2b_input" rel="{{ $merchant->id }}" value="{{number_format($global_vars->b2b_osmall_commission,2,'.','')}}" id="b2b_m_c{{ $merchant->id }}" size="4"/>%</p>									
						<p id="b2b_m_a{{ $merchant->id }}" @if($merchant->b2b_commission_type == 'std') style="display:none;" @endif><a class="btn btn-primary b2b_variation" id="{{$merchant->id}}" href="javascript:void(0)">Variable</a></p>						
					@endif
				</td>		

				<td class="text-center">
					@if($merchant->order_administration_fee > 0)
						<p id="order_fee{{ $merchant->id }}" class="order_edit" rel="{{ $merchant->id }}">{{number_format($merchant->order_administration_fee/100,2,'.','')}}</p>
						<p id="order_fee_i{{ $merchant->id }}" style="display:none;"><input type="text" rel="{{ $merchant->id }}" class="order_input" value="{{number_format($merchant->order_administration_fee/100,2,'.','')}}" id="order_fee_c{{ $merchant->id }}" size="6"/> </p>
					@else
						<p id="order_fee{{ $merchant->id }}" class="order_edit" rel="{{ $merchant->id }}">{{number_format($global_vars->order_administration_fee/100,2,'.','')}}</p>
						<p id="order_fee_i{{ $merchant->id }}" style="display:none;"><input type="text" rel="{{ $merchant->id }}" class="order_input" value="{{number_format($global_vars->order_administration_fee/100,2,'.','')}}" id="order_fee_c{{ $merchant->id }}" size="6"/></p>						
					@endif
				</td>

				<td class="text-center">
					@if($merchant->order_administration_fee > 0)
						<p id="annual_fee{{ $merchant->id }}" class="annual_edit" rel="{{ $merchant->id }}">{{number_format($merchant->annual_subscription_fee/100,2,'.','')}}</p>
						<p id="annual_fee_i{{ $merchant->id }}" style="display:none;"><input type="text" class="annual_input" rel="{{ $merchant->id }}" value="{{number_format($merchant->annual_subscription_fee/100,2,'.','')}}" id="annual_fee_c{{ $merchant->id }}" size="6"/> </p>
					@else
						<p id="annual_fee{{ $merchant->id }}" class="annual_edit" rel="{{ $merchant->id }}">{{number_format($global_vars->merchant_annual_subscription_fee/100,2,'.','')}}</p>
						<p id="annual_fee_i{{ $merchant->id }}" style="display:none;"><input type="text" class="annual_input" value="{{number_format($global_vars->merchant_annual_subscription_fee/100,2,'.','')}}" rel="{{ $merchant->id }}" id="annual_fee_c{{ $merchant->id }}" size="6"/> </p>						
					@endif

				</td>			
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 50%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Products</h4>
            </div>
            <div class="modal-body">
                <h3 id="modal-Tittle"></h3>
                <div class="table-responsive">
                    <table id="myTable" class="table table-bordered myTable"></table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>

        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function () {
	function pad (str, max) {
	  str = str.toString();
	  return str.length < max ? pad("0" + str, max) : str;
	}	
	
	$('#grid5c').DataTable({
		'scrollX':true,
		 'autoWidth':false,
		 "order": [],
		 "columns": [
			{ "width": "20px", "orderable": false },
			{ "width": "85px" },
			null,
			{ "width": "85px" },
			{ "width": "85px" },
			{ "width": "85px" },
			{ "width": "85px" },
			{ "width": "85px" },
			{ "width": "85px" }
		  ]
	});
	
	$(document).delegate( '.m_s', "change",function (event) {
	//$(".m_s").change(function(){
		_this = $(this);
		var m_id= _this.attr('rel');
		var type = 'var';
		if(_this.val()=="Standard"){
			type = 'std';
		}
		var url = '/admin/commission/merchanttype/'+ m_id;
		$.ajax({
		  url: url,
		  type: "post",
		  data: {'type': type},
		  success: function(data){
			  toastr.info('Commission type changed!');
				if(_this.val()=="Standard"){
				//	$("#m_i" + m_id).show();
					$("#m_p" + m_id).show();
					$("#m_a" + m_id).hide();
				} else {
					$("#m_i" + m_id).hide();
					$("#m_p" + m_id).hide();
					$("#m_a" + m_id).show();			
				}
		  }
		});			

	});	
	
	$(document).delegate( '.b2b_m_s', "change",function (event) {
//	$(".b2b_m_s").change(function(){
		_this = $(this);
		var m_id= _this.attr('rel');	
		var type = 'var';
		if(_this.val()=="Standard"){
			type = 'std';
		}
		var url = '/admin/b2bcommission/merchanttype/'+ m_id;
		$.ajax({
		  url: url,
		  type: "post",
		  data: {'type': type},
		  success: function(data){
			toastr.info('Commission type changed!');	
			if(_this.val()=="Standard"){
				//$("#b2b_m_i" + m_id).show();
				$("#b2b_m_p" + m_id).show();
				$("#b2b_m_a" + m_id).hide();
			} else {
				//$("#b2b_m_i" + m_id).hide();
				$("#b2b_m_p" + m_id).hide();
				$("#b2b_m_a" + m_id).show();			
			}
		  }
		});			

	});	
	
	$(document).delegate( '.mp_type', "click",function (event) {
	//$(".mc_p").clik(function(){
		_this = $(this);
		var mer_id= _this.attr('rel');
		$("#m_pt" + mer_id).hide();
		$("#m_ps" + mer_id).show();
	});
	
	$(document).delegate( '.b2b_mp_type', "click",function (event) {
	//$(".mc_p").clik(function(){
		_this = $(this);
		var mer_id= _this.attr('rel');
		$("#b2b_m_pt" + mer_id).hide();
		$("#b2b_m_ps" + mer_id).show();
	});
	
	var table_modal;

	$(document).delegate( '.variation', "click",function (event) {
	//$(".variation").click(function () {

		$('#modal-Tittle').html("");

		if(table_modal){
			table_modal.destroy();
			$('#myTable').empty();
		}

		_this = $(this);

		var id_merchant= _this.attr('id');
		
		var url = '/admin/commission/merchanttype/'+ id_merchant;
		$.ajax({
		  url: url,
		  type: "post",
		  data: {'type': 'var'},
		  success: function(data){
			console.log(data);
		  }
		});			
		
		var url=JS_BASE_URL+'/admin/commission/merchant/'+id_merchant;
		var w=window.open(url,"_blank");
		w.focus();


	});	
	
	$(document).delegate( '.order_edit', "click",function (event) {
	//$(".b2b_s_edit").click(function(){
		_this = $(this);
		var s_id= _this.attr('rel');
		_this.hide();
		$("#order_fee" + s_id).hide();
		$("#order_fee_i" + s_id).show();
	});
	
	
	$(document).delegate( '.order_input', "blur",function (event) {
	//$('.b2b_s_btnedit').click(function(){
		_this = $(this);
		var s_id= _this.attr('rel');
		var order_fee = $('#order_fee_c' + s_id).val();
		console.log(order_fee);
		//var annual_fee = $('#annual_fee_c' + s_id).val();
		if($.isNumeric(order_fee)){
			var url = JS_BASE_URL + '/admin/commission/merchant/order_fee/'+ s_id;
			$.ajax({
			  url: url,
			  type: "post",
			  data: {'order_fee': order_fee},
			  success: function(data){
				toastr.info("Fee Successfully Updated!");
				$("#order_fee" + s_id).show();
				$("#order_fee_i" + s_id).hide();
			  }
			});
		} else {
			alert(order_fee + "Invalid Number!");
		}
	});	
	
	$(document).delegate( '.annual_edit', "click",function (event) {
	//$(".b2b_s_edit").click(function(){
		_this = $(this);
		var s_id= _this.attr('rel');
		_this.hide();
		$("#annual_fee" + s_id).hide();
		$("#annual_fee_i" + s_id).show();
	});
	
	
	$(document).delegate( '.annual_input', "blur",function (event) {
	//$('.b2b_s_btnedit').click(function(){
		_this = $(this);
		var s_id= _this.attr('rel');
		var annual_fee = $('#annual_fee_c' + s_id).val();
		//var annual_fee = $('#annual_fee_c' + s_id).val();
		if($.isNumeric(annual_fee)){
			var url = JS_BASE_URL + '/admin/commission/merchant/annual_fee/'+ s_id;
			$.ajax({
			  url: url,
			  type: "post",
			  data: {'annual_fee': annual_fee},
			  success: function(data){
				toastr.info("Fee Successfully Updated!");
				$("#annual_fee" + s_id).show();
				$("#annual_fee_i" + s_id).hide();
			  }
			});
		} else {
			alert(annual_fee + "Invalid Number!");
		}
	});	
	
	$(document).delegate( '.b2b_edit', "click",function (event) {
	//$(".b2b_s_edit").click(function(){
		_this = $(this);
		var s_id= _this.attr('rel');
		_this.hide();
		$("#b2b_m_p" + s_id).hide();
		$("#b2b_m_i" + s_id).show();
	});
	
	
	$(document).delegate( '.b2b_input', "blur",function (event) {
	//$('.b2b_s_btnedit').click(function(){
		_this = $(this);
		var s_id= _this.attr('rel');
		var b2b_fee = $('#b2b_m_c' + s_id).val();
		//var annual_fee = $('#annual_fee_c' + s_id).val();
		if($.isNumeric(b2b_fee)){
			var url = JS_BASE_URL + '/admin/commission/merchant/b2b_fee/'+ s_id;
			$.ajax({
			  url: url,
			  type: "post",
			  data: {'b2b_fee': b2b_fee},
			  success: function(data){
				toastr.info("Commission Successfully Updated!");
				$("#b2b_m_p" + s_id).html(b2b_fee + "%");
				$("#b2b_m_p" + s_id).show();
				$("#b2b_m_i" + s_id).hide();
			  }
			});
		} else {
			alert(b2b_fee + "Invalid Number!");
		}
	});		
	
	$(document).delegate( '.reg_edit', "click",function (event) {
	//$(".b2b_s_edit").click(function(){
		_this = $(this);
		var s_id= _this.attr('rel');
		_this.hide();
		$("#m_p" + s_id).hide();
		$("#m_i" + s_id).show();
	});
	
	
	$(document).delegate( '.reg_input', "blur",function (event) {
	//$('.b2b_s_btnedit').click(function(){
		_this = $(this);
		var s_id= _this.attr('rel');
		var fee = $('#m_c' + s_id).val();
		//var annual_fee = $('#annual_fee_c' + s_id).val();
		if($.isNumeric(fee)){
			var url = JS_BASE_URL + '/admin/commission/merchant/reg_fee/'+ s_id;
			$.ajax({
			  url: url,
			  type: "post",
			  data: {'fee': fee},
			  success: function(data){
				toastr.info("Commission Successfully Updated!");
				$("#m_p" + s_id).html(fee + "%");
				$("#m_p" + s_id).show();
				$("#m_i" + s_id).hide();
			  }
			});
		} else {
			alert(fee + "Invalid Number!");
		}
	});		

	$(document).delegate( '.fee_edit', "click",function (event) {
	//$(".b2b_s_edit").click(function(){
		_this = $(this);
		var s_id= _this.attr('rel');
		_this.hide();
		$("#annual_fee" + s_id).hide();
		$("#order_fee" + s_id).hide();
		$("#order_fee_i" + s_id).show();
		$("#annual_fee_i" + s_id).show();
		$("#fee_btnedit" + s_id).show();
	});		
	
	$(document).delegate( '.m_edit', "click",function (event) {
	//$(".m_edit").click(function(){
		_this = $(this);
		var m_id= _this.attr('rel');
		$("#m_p" + m_id).hide();
		if($("#m_s" + m_id).val() == "Standard"){
			$("#m_i" + m_id).show();
		}	
		$("#m_pt" + m_id).hide();
		$("#m_ps" + m_id).show();		
	});
	
	
	$(document).delegate( '.m_btnedit', "click",function (event) {
	//$('.m_btnedit').click(function(){
		_this = $(this);
		var m_id= _this.attr('rel');
		var commission = $('#m_c' + m_id).val();
		if($.isNumeric(commission)){
			var url = '/admin/commission/merchanttype/'+ m_id;
			$.ajax({
			  url: url,
			  type: "post",
			  data: {'type': 'std'},
			  success: function(data){
				console.log(data);
			  }
			});		
		
			var url = '/admin/commission/merchantedit/'+ m_id;
			$.ajax({
			  url: url,
			  type: "post",
			  data: {'commission': commission},
			  success: function(data){
				location.reload();
			  }
			});				
		} else {
			alert("Invalid Number!");
		}      
	});		

	$(document).delegate( '.b2b_variation', "click",function (event) {
	//$(".b2b_variation").click(function () {

		$('#modal-Tittle').html("");

		if(table_modal){
			table_modal.destroy();
			$('#myTable').empty();
		}

		_this = $(this);

		var id_merchant= _this.attr('id');
		
		var url = '/admin/b2bcommission/merchanttype/'+ id_merchant;
		$.ajax({
		  url: url,
		  type: "post",
		  data: {'type': 'var'},
		  success: function(data){
			console.log(data);
		  }
		});			
		
		var url=JS_BASE_URL+'/admin/b2bcommission/merchant/'+id_merchant;
		var w=window.open(url,"_blank");
		w.focus();


	});	
	
	$(document).delegate( '.b2b_m_edit', "click",function (event) {
	//$(".b2b_m_edit").click(function(){
		_this = $(this);
		var m_id= _this.attr('rel');
		$("#b2b_m_p" + m_id).hide();
		if($("#b2b_m_s" + m_id).val() == "Standard"){
			$("#b2b_m_i" + m_id).show();
		}	
		$("#b2b_m_pt" + m_id).hide();
		$("#b2b_m_ps" + m_id).show();		
	});

	
	$(document).delegate( '.b2b_m_btnedit', "click",function (event) {
	//$('.b2b_m_btnedit').click(function(){
		_this = $(this);
		var m_id= _this.attr('rel');
		var commission = $('#b2b_m_c' + m_id).val();
		if($.isNumeric(commission)){
			var url = '/admin/b2bcommission/merchanttype/'+ m_id;
			$.ajax({
			  url: url,
			  type: "post",
			  data: {'type': 'std'},
			  success: function(data){
				console.log(data);
			  }
			});		
		
			var url = '/admin/b2bcommission/merchantedit/'+ m_id;
			$.ajax({
			  url: url,
			  type: "post",
			  data: {'commission': commission},
			  success: function(data){
				location.reload();
			  }
			});				
		} else {
			alert("Invalid Number!");
		}      
	});		
	
});

$(document).delegate( '.view-merchant-modal', "click",function (event) {
//$('.view-merchant-modal').click(function(){

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
