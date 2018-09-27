<?php $global_vars = DB::table('global')->first();
use App\Http\Controllers\IdController;
 ?>
<h2>Station Commission Master</h2>
<span  id="station-error-messages">
    </span>
<div class="table-responsive">
	<table class="table table-bordered" cellspacing="0" width="1400px" id="grid5c">
		<thead style="background-color: #4E2E28; color: #fff;">
			<tr>
				<th class="text-center" colspan="3">Station</th>
				<th class="text-center" colspan="2">Retail</th>
				<th class="text-center" colspan="2">B2B&nbsp;for&nbsp;SubDealers</th>
				<th class="text-center" colspan="2">Fee</th>
			</tr>
			<tr>
				<th class="text-center">No</th>
				<th class="text-center">Station&nbsp;ID</th>
				<th class="text-center">Name</th>
				<th class="text-center">Type</th>
				<th class="text-center">Commission</th>
				<th class="text-center">Type</th>
				<th class="text-center">Commission</th>	
				<th class="text-center">Admin</th>
				<th class="text-center">Annual</th>			
			</tr>
		</thead>
		<tbody>
			@foreach($stations as $station)
			<tr>
				<td class="text-center">
					{{$i++}}
				</td>

				<td class="text-center">
					<?php $formatted_station_id = IdController::nS($station->id); ?>
					 <!--<a target="_blank" href="{{route('stationPopup', ['id' => $station->id])}}" class="update" data-id="{{ $station->id }}">[{{$formatted_station_id}}]</a>-->
				<a href="javascript:void(0)" class="view-station-modal" data-id="{{ $station->id }}">
				{{$formatted_station_id}}</a>

				</td>

				<td>
					{{$station->company_name}}
				</td>
				<?php if($station->commission_type != 'std' && $station->commission_type != 'var'){
							$station->commission_type = $global_vars->commission_type;
					  } 
				?>
				<td class="text-center">
					<p id="s_pt{{ $station->id }}" class="mp_type" rel="{{ $station->id }}">@if($station->commission_type == 'std') Standard @else Variable @endif</p>
					<p id="s_ps{{ $station->id }}" style="display: none;"><select id="s_s{{ $station->id }}" class="s_s" rel="{{$station->id}}"><option value="Standard" @if($station->commission_type == 'std') selected @endif>Standard</option><option value="Variable" @if($station->commission_type == 'var') selected @endif>Variable</option></select></p>
				</td>

				<td class="text-center">
					@if($station->osmall_commission > 0)
						<p id="s_p{{ $station->id }}" class="reg_edit" rel="{{ $station->id }}" @if($station->commission_type == 'var') style="display:none;" @endif>{{number_format($station->osmall_commission,2,'.','')}}%</p>
						<p id="s_i{{ $station->id }}" style="display:none;"><input type="text" class="reg_input" rel="{{ $station->id }}" value="{{number_format($station->osmall_commission,2,'.','')}}" id="s_c{{ $station->id }}" size="4"/>%</p>
					@else
						<p id="s_p{{ $station->id }}" class="reg_edit" rel="{{ $station->id }}" @if($station->commission_type == 'var') style="display:none;" @endif>{{number_format($global_vars->osmall_commission,2,'.','')}}%</p>
						<p id="s_i{{ $station->id }}" style="display:none;"><input type="text" class="reg_input" rel="{{ $station->id }}" value="{{number_format($global_vars->osmall_commission,2,'.','')}}" id="s_c{{ $station->id }}" size="4"/>%</p>						
					@endif
					<p id="s_a{{ $station->id }}" @if($station->commission_type == 'std') style="display:none;" @endif><a class="btn btn-primary variation_station" id="{{$station->id}}" href="javascript:void(0)">Variable</a></p>

				</td>
				<?php if($station->b2b_commission_type != 'std' && $station->b2b_commission_type != 'var'){
							$station->b2b_commission_type = $global_vars->b2b_commission_type;
					  } 
				?>
				<td class="text-center">
					<p id="b2b_s_pt{{ $station->id }}" class="b2b_mp_type" rel="{{ $station->id }}">@if($station->b2b_commission_type == 'std') Standard @else Variable @endif</p>
					<p id="b2b_s_ps{{ $station->id }}" style="display: none;"><select id="b2b_s_s{{ $station->id }}" class="b2b_s_s" rel="{{$station->id}}"><option value="Standard" @if($station->b2b_commission_type == 'std') selected @endif>Standard</option><option value="Variable" @if($station->b2b_commission_type == 'var') selected @endif>Variable</option></select></p>
				</td>

				<td class="text-center">
					@if($station->b2b_osmall_commission > 0)
						<p id="b2b_s_p{{ $station->id }}" class="b2b_edit" rel="{{ $station->id }}" @if($station->b2b_commission_type == 'var') style="display:none;" @endif>{{number_format($station->b2b_osmall_commission,2,'.','')}}%</p>
						<p id="b2b_s_i{{ $station->id }}" style="display:none;"><input type="text" class="b2b_input" rel="{{ $station->id }}" value="{{number_format($station->b2b_osmall_commission,2,'.','')}}" id="b2b_s_c{{ $station->id }}" size="4"/>%</p>
					@else
						<p id="b2b_s_p{{ $station->id }}" class="b2b_edit" rel="{{ $station->id }}" @if($station->b2b_commission_type == 'var') style="display:none;" @endif>{{number_format($global_vars->b2b_osmall_commission,2,'.','')}}%</p>
						<p id="b2b_s_i{{ $station->id }}" style="display:none;"><input type="text" class="b2b_input" rel="{{ $station->id }}" value="{{number_format($global_vars->b2b_osmall_commission,2,'.','')}}" id="b2b_s_c{{ $station->id }}" size="4"/>%</p>						
					@endif
					<p id="b2b_s_a{{ $station->id }}" @if($station->b2b_commission_type == 'std') style="display:none;" @endif><a class="btn btn-primary b2b_variation_station" id="{{$station->id}}" href="javascript:void(0)">Variable</a></p>

				</td>
				
				<td class="text-center">
					@if($station->order_administration_fee > 0)
						<p id="order_fee{{ $station->id }}" class="order_edit" rel="{{ $station->id }}">{{number_format($station->order_administration_fee/100,2,'.','')}}</p>
						<p id="order_fee_i{{ $station->id }}" style="display:none;"><input type="text" class="order_input" value="{{number_format($station->order_administration_fee/100,2,'.','')}}" rel="{{ $station->id }}" id="order_fee_c{{ $station->id }}" size="6"/> </p>
					@else
						<p id="order_fee{{ $station->id }}" class="order_edit" rel="{{ $station->id }}">{{number_format($global_vars->order_administration_fee/100,2,'.','')}}</p>
						<p id="order_fee_i{{ $station->id }}" style="display:none;"><input type="text" class="order_input" value="{{number_format($global_vars->order_administration_fee/100,2,'.','')}}" rel="{{ $station->id }}" id="order_fee_c{{ $station->id }}" size="6"/></p>						
					@endif
				</td>

				<td class="text-center">
					@if($station->order_administration_fee > 0)
						<p id="annual_fee{{ $station->id }}" class="annual_edit" rel="{{ $station->id }}">{{number_format($station->annual_subscription_fee/100,2,'.','')}}</p>
						<p id="annual_fee_i{{ $station->id }}" style="display:none;"><input type="text" class="annual_input" value="{{number_format($station->annual_subscription_fee/100,2,'.','')}}" rel="{{ $station->id }}" id="annual_fee_c{{ $station->id }}" size="6"/> </p>
					@else
						<p id="annual_fee{{ $station->id }}" class="annual_edit" rel="{{ $station->id }}">{{number_format($global_vars->station_annual_subscription_fee/100,2,'.','')}}</p>
						<p id="annual_fee_i{{ $station->id }}" style="display:none;"><input type="text" class="annual_input" value="{{number_format($global_vars->station_annual_subscription_fee/100,2,'.','')}}" rel="{{ $station->id }}" id="annual_fee_c{{ $station->id }}" size="6"/> </p>						
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
			{ "width": "85px", "orderable": false },
			null,
			{ "width": "85px" },
			{ "width": "85px" },
			{ "width": "85px" },
			{ "width": "85px" },
			{ "width": "85px" },
			{ "width": "85px" }				
		  ]
	});

	var table_modal;

	$(document).delegate( '.variation_station', "click",function (event) {
	//$(".b2b_variation_station").click(function () {

		$('#modal-Tittle').html("");

		if(table_modal){
			table_modal.destroy();
			$('#myTable').empty();
		}

		_this = $(this);

		var id_station= _this.attr('id');

		var url = '/admin/commission/stationtype/'+ id_station;
		$.ajax({
		  url: url,
		  type: "post",
		  data: {'type': 'var'},
		  success: function(data){
			console.log(data);
		  }
		});

		var url = '/admin/commission/station/'+id_station;

		var url=JS_BASE_URL+'/admin/commission/station/'+id_station;
		var w=window.open(url,"_blank");
		w.focus();

	});
	
	$(document).delegate( '.fee_btnedit', "click",function (event) {
	//$('.b2b_s_btnedit').click(function(){
		_this = $(this);
		var s_id= _this.attr('rel');
		var order_fee = $('#order_fee_c' + s_id).val();
		var annual_fee = $('#annual_fee_c' + s_id).val();
		if($.isNumeric(order_fee) && $.isNumeric(annual_fee)){
			var url = JS_BASE_URL + '/admin/commission/station/fees/'+ s_id;
			$.ajax({
			  url: url,
			  type: "post",
			  data: {'order_fee': order_fee, 'annual_fee': annual_fee},
			  success: function(data){
				location.reload();
			  }
			});
		} else {
			alert(commission + "Invalid Number!");
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
	
	$(document).delegate( '.s_edit', "click",function (event) {
	//$(".b2b_s_edit").click(function(){
		_this = $(this);
		var s_id= _this.attr('rel');
		$("#s_p" + s_id).hide();
		if($("#s_s" + s_id).val() == "Standard"){
			$("#s_i" + s_id).show();
		}
		$("#s_pt" + s_id).hide();
		$("#s_ps" + s_id).show();
	});

	$(document).delegate( '.s_btnedit', "click",function (event) {
	//$('.b2b_s_btnedit').click(function(){
		_this = $(this);
		var s_id= _this.attr('rel');
		var commission = $('#s_c' + s_id).val();
		if($.isNumeric(commission)){
			var url = '/admin/commission/stationtype/'+ s_id;
			$.ajax({
			  url: url,
			  type: "post",
			  data: {'type': 'std'},
			  success: function(data){
				console.log(data);
			  }
			});

			var url = '/admin/commission/stationedit/'+ s_id;
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
	
	$(document).delegate( '.b2b_variation_station', "click",function (event) {
	//$(".b2b_variation_station").click(function () {

		$('#modal-Tittle').html("");

		if(table_modal){
			table_modal.destroy();
			$('#myTable').empty();
		}

		_this = $(this);

		var id_station= _this.attr('id');

		var url = '/admin/b2bcommission/stationtype/'+ id_station;
		$.ajax({
		  url: url,
		  type: "post",
		  data: {'type': 'var'},
		  success: function(data){
			console.log(data);
		  }
		});

		var url = '/admin/b2bcommission/station/'+id_station;

		var url=JS_BASE_URL+'/admin/b2bcommission/station/'+id_station;
		var w=window.open(url,"_blank");
		w.focus();

	});
	
	$(document).delegate( '.mp_type', "click",function (event) {
	//$(".mc_p").clik(function(){
		_this = $(this);
		var mer_id= _this.attr('rel');
		$("#s_pt" + mer_id).hide();
		$("#s_ps" + mer_id).show();
	});

	$(document).delegate( '.s_s', "change",function (event) {
	//$(".b2b_s_s").change(function(){
		_this = $(this);
		var m_id= _this.attr('rel');
		var type = 'var';
		if(_this.val()=="Standard"){
			type = 'std';
		}
		var url = '/admin/commission/stationtype/'+ m_id;
		$.ajax({
		  url: url,
		  type: "post",
		  data: {'type': type},
		  success: function(data){
			  toastr.info('Commission type changed!');
			if(_this.val()=="Standard"){
				$("#s_p" + m_id).show();
				$("#s_a" + m_id).hide();
			} else {
				$("#s_p" + m_id).hide();
				$("#s_a" + m_id).show();
			}
		  }
		});
		
	});	
	
	$(document).delegate( '.reg_edit', "click",function (event) {
	//$(".b2b_s_edit").click(function(){
		_this = $(this);
		var s_id= _this.attr('rel');
		_this.hide();
		$("#s_p" + s_id).hide();
		$("#s_i" + s_id).show();
	});
	
	
	$(document).delegate( '.reg_input', "blur",function (event) {
	//$('.b2b_s_btnedit').click(function(){
		_this = $(this);
		var s_id= _this.attr('rel');
		var fee = $('#s_c' + s_id).val();
		//var annual_fee = $('#annual_fee_c' + s_id).val();
		if($.isNumeric(fee)){
			var url = JS_BASE_URL + '/admin/commission/station/reg_fee/'+ s_id;
			$.ajax({
			  url: url,
			  type: "post",
			  data: {'fee': fee},
			  success: function(data){
				toastr.info("Commission Successfully Updated!");
				$("#s_p" + s_id).html(fee + "%");
				$("#s_p" + s_id).show();
				$("#s_i" + s_id).hide();
			  }
			});
		} else {
			alert(fee + "Invalid Number!");
		}
	});		
	
	$(document).delegate( '.b2b_mp_type', "click",function (event) {
	//$(".mc_p").clik(function(){
		_this = $(this);
		var mer_id= _this.attr('rel');
		$("#b2b_s_pt" + mer_id).hide();
		$("#b2b_s_ps" + mer_id).show();
	});	
	
	$(document).delegate( '.b2b_s_s', "change",function (event) {
	//$(".b2b_s_s").change(function(){
		_this = $(this);
		var m_id= _this.attr('rel');
		var type = 'var';
		if(_this.val()=="Standard"){
			type = 'std';
		}		
		var url = '/admin/b2bcommission/stationtype/'+ m_id;
		$.ajax({
		  url: url,
		  type: "post",
		  data: {'type': type},
		  success: function(data){
				toastr.info('Commission type changed!');
				if(_this.val()=="Standard"){
					$("#b2b_s_p" + m_id).show();
					$("#b2b_s_a" + m_id).hide();
				} else {
					$("#b2b_s_p" + m_id).hide();
					$("#b2b_s_a" + m_id).show();
				}
		  }
		});		

	});
	
	$(document).delegate( '.b2b_edit', "click",function (event) {
	//$(".b2b_s_edit").click(function(){
		_this = $(this);
		var s_id= _this.attr('rel');
		_this.hide();
		$("#b2b_s_p" + s_id).hide();
		$("#b2b_s_i" + s_id).show();
	});
	
	
	$(document).delegate( '.b2b_input', "blur",function (event) {
	//$('.b2b_s_btnedit').click(function(){
		_this = $(this);
		var s_id= _this.attr('rel');
		var b2b_fee = $('#b2b_s_c' + s_id).val();
		//var annual_fee = $('#annual_fee_c' + s_id).val();
		if($.isNumeric(b2b_fee)){
			var url = JS_BASE_URL + '/admin/commission/station/b2b_fee/'+ s_id;
			$.ajax({
			  url: url,
			  type: "post",
			  data: {'b2b_fee': b2b_fee},
			  success: function(data){
				toastr.info("Commission Successfully Updated!");
				$("#b2b_s_p" + s_id).html(b2b_fee + "%");
				$("#b2b_s_p" + s_id).show();
				$("#b2b_s_i" + s_id).hide();
			  }
			});
		} else {
			alert(b2b_fee + "Invalid Number!");
		}
	});		

	$(document).delegate( '.b2b_s_btnedit', "click",function (event) {
	//$('.b2b_s_btnedit').click(function(){
		_this = $(this);
		var s_id= _this.attr('rel');
		var commission = $('#b2b_s_c' + s_id).val();
		if($.isNumeric(commission)){
			var url = '/admin/b2bcommission/stationtype/'+ s_id;
			$.ajax({
			  url: url,
			  type: "post",
			  data: {'type': 'std'},
			  success: function(data){
				console.log(data);
			  }
			});

			var url = '/admin/b2bcommission/stationedit/'+ s_id;
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
			var url = JS_BASE_URL + '/admin/commission/station/order_fee/'+ s_id;
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
			var url = JS_BASE_URL + '/admin/commission/station/annual_fee/'+ s_id;
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
});

$(document).delegate( '.view-station-modal', "click",function (event) {
//$('.view-station-modal').click(function(){

            var station_id=$(this).attr('data-id');
            var check_url=JS_BASE_URL+"/admin/popup/lx/check/station/"+station_id;
            $.ajax({
                url:check_url,
                type:'GET',
                success:function (r) {
                    if (r.status=="success") {
                    var url=JS_BASE_URL+"/admin/popup/station/"+station_id;
                    var w=window.open(url,"_blank");
                    w.focus();
                    }
                    if (r.status=="failure") {
                        var msg="<div class='alert alert-danger'>"+r.long_message+"</div>";
                        $('#station-error-messages').html(msg);
                    }
                }
            });


        });
    



window.setInterval(function(){
              $('#station-error-messages').empty();
            }, 10000);


</script>
