<?php 
use App\Http\Controllers\IdController;
$global_vars = DB::table('global')->first(); ?>
@extends("common.default")

@section("content")
<style type="text/css">
    .overlay{
        background-color: rgba(1, 1, 1, 0.7);
        bottom: 0;
        left: 0;
        position: fixed;
        right: 0;
        top: 0;
        z-index: 1001;
    }
    .overlay p{
        color: white;
        font-size: 18px;
        font-weight: bold;
        margin: 365px 0 0 610px;
    }
</style>
<?php $i=1; ?>
<div class="overlay" style="display:none;">
    <p>Please Wait...</p>
</div>
<div style="display: none;" class="removeable alert">
    <strong id='alert_heading'></strong><span id='alert_text'></span>
</div>
<div class="container" style="margin-top:30px;">
<h2>Merchant ID: {{IdController::nM($mid)}}</h2>
	<span  id="merchant-error-messages">
    </span>
	<div class="table-responsive">
		<table id="myTable" class="table table-bordered myTable">
			<thead style="background-color: #FF8B91; color: #fff;">
				<th class="text-center">No</th>
				<th class="text-center">Product&nbsp;ID</th>
				<th class="text-center">Name</th>
				<th class="text-center">B2B&nbsp;Commission</th>
			</thead>
			<tbody>
				@def $i = 0
				@foreach($merchantscom as $merchantsc)
					<?php 
						
						$i++;
					?>				
					<tr>
						<td class="text-center">{{$i}}</td>
						<td class="text-center"><a href="http://{{$_SERVER['SERVER_NAME']}}/album/{{$merchantsc->parent_id}}">{{IdController::nP($merchantsc->pid)}}</a></td> 
						<td>{{$merchantsc->pname}}</td>
						<td class="text-center">
							@if($merchantsc->b2b_osmall_commission > 0)
								<p id="mv_p{{$merchantsc->parent_id}}" class="regp_edit" rel="{{$merchantsc->parent_id}}">{{number_format($merchantsc->b2b_osmall_commission,2,'.','')}}%</p><p id="mv_i{{$merchantsc->parent_id}}" style="display:none;"><input type="text" class="regp_input" rel="{{$merchantsc->parent_id}}" value="{{number_format($merchantsc->b2b_osmall_commission,2,'.','')}}" id="mv_c{{$merchantsc->parent_id}}" size="2"/>% <a class="btn btn-primary mv_btnedit" href="javascript:void(0)" rel="{{$merchantsc->parent_id}}" > Save</a></p>
							@else
								<p id="mv_p{{$merchantsc->parent_id}}" class="regp_edit" rel="{{$merchantsc->parent_id}}">{{number_format($global_vars->b2b_osmall_commission,2,'.','')}}%</p><p id="mv_i{{$merchantsc->parent_id}}" style="display:none;"><input type="text" class="regp_input" rel="{{$merchantsc->parent_id}}" value="{{number_format($global_vars->b2b_osmall_commission,2,'.','')}}" id="mv_c{{$merchantsc->parent_id}}" size="2"/>% <a class="btn btn-primary mv_btnedit" href="javascript:void(0)" rel="{{$merchantsc->parent_id}}" > Save</a></p>								
							@endif
						</td>
					</tr>
				@endforeach
			</tbody>			
		</table>

	</div>	
</div>
<meta name="_token" content="{!! csrf_token() !!}"/>
<script type="text/javascript">
$(document).ready(function () {
	table_modal = $('#myTable').DataTable({
		'autoWidth':false,
		 "order": [],
		 "iDisplayLength": 10,
		 "columns": [
			{ "width": "10px", "orderable": false },
			{ "width": "50px" },
			{ "width": "150px" },
			{ "width": "30px" }
		  ]
	});

	$(document).delegate( '.regp_edit', "click",function (event) {
	//$(".b2b_s_edit").click(function(){
		_this = $(this);
		var s_id= _this.attr('rel');
		_this.hide();
		$("#mv_p" + s_id).hide();
		$("#mv_i" + s_id).show();
	});
	
	
	$(document).delegate( '.regp_input', "blur",function (event) {
	//$('.b2b_s_btnedit').click(function(){
		_this = $(this);
		var mv_id= _this.attr('rel');
		var fee = $('#mv_c' + mv_id).val();
		//var annual_fee = $('#annual_fee_c' + s_id).val();
		if($.isNumeric(fee)){
			var url = JS_BASE_URL + '/admin/b2bcommission/productedit/'+ mv_id;
			$.ajax({
			  url: url,
			  type: "post",
			  data: {'commission': fee},
			  success: function(data){
				toastr.info("Commission Successfully Updated!");
				$("#mv_p" + mv_id).html(fee + "%");
				$("#mv_p" + mv_id).show();
				$("#mv_i" + mv_id).hide();
			  }
			});
		} else {
			alert(fee + "Invalid Number!");
		}
	});		
	
	$(document).delegate( '.mv_btnedit', "click",function (event) {
	//$('.mv_btnedit').click(function(){
		_this = $(this);
		var mv_id= _this.attr('rel');
		var commission = $('#mv_c' + mv_id).val();
		if($.isNumeric(commission)){
			var url = '/admin/b2bcommission/productedit/'+ mv_id;
			$.ajax({
			  url: url,
			  type: "post",
			  data: {'commission': commission},
			  success: function(data){
				$("#mv_p" + mv_id).show();
				$("#mv_i" + mv_id).hide();
				$("#mv_p" + mv_id).text(commission + "%");
			  }
			});				
		} else {
			alert("Invalid Number!");
		}      
	});	
});
</script>
@yield("left_sidebar_scripts")
@stop
