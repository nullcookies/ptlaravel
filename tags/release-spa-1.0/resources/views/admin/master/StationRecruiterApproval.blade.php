<?php
use App\Classes;
define('MAX_COLUMN_TEXT', 95);
define('MAX_COLUMN_TEXT2', 20);
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\IdController;
?>
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
    .action_buttons{
        display: flex;
    }
    .role_status_button{
        margin: 10px 0 0 10px;
        width: 85px;
    }
    /*dialoguebox*/
  /*  label, input { display:block; } commented due to search label error */
    /*textArea {height: 200px;margin-bottom: 28px;width: 100%;}*/
    fieldset { padding:0; border:0; margin-top:25px; }
    h1 { font-size: 1.2em; margin: .6em 0; }
    .ui-dialog .ui-state-error { padding: .3em; }
    .ui-dialog{z-index: 10001}
    .ui-widget-overlay{z-index: 1000}
    table#station_recruiter_master_table
    {
        table-layout: fixed;
        max-width: none;
        width: auto;
        min-width: 100%;
    }
</style>

<div class="modal fade" id="myModalRemarks" role="dialog" aria-labelledby="myModalRemarks">
	<div class="modal-dialog" role="remarks" style="width: 50%">
		<div class="modal-content">
			<div class="row" style="padding: 15px;">
				<div class="col-md-12" style="">
					<form id="remarks-form">
						<fieldset>
							<h2>Remarks</h2>
						<br>
							<textarea style="width:100%; height: 250px;" name="name" id="status_remarks" class="text-area ui-widget-content ui-corner-all">
							</textarea>
							<br>
							<input type="button" id="save_remarks" class="btn btn-primary" value="Save Remarks">
							<input type="hidden" id="current_role_roleId" remarks_role="" >
							<input type="hidden" id="current_status" value="" >
						</fieldset>
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>				
		</div>			
	</div>	
</div>

<div class="overlay" style="display:none;">
    <p>Please Wait...</p>
</div>
<div style="display: none;" class="removeable alert">
    <strong id='alert_heading'></strong><span id='alert_text'></span>
</div>

<div class="container" style="margin-top-30px;">
    @include('admin/panelHeading')
    <h3>Station Recruiter Master</h3>
        <span id="stationR-error-messages"></span>
        <span id="recruiter-error-message"></span>
<div class="table-responsive">
            <table id="station_recruiter_master_table" class="table table-bordered" width="1160px">
                <thead>
                    <tr style="background-color: yellow; color: black;">
                        <th class="text-center no-sort">No</th>
                        <th class="text-center bmedium">SR&nbsp;ID</th>
                        <th class="text-center blarge">Name</th>
                      <!--  <th class="text-center bmedium">Nationality</th>
                        <th class="text-center bmedium">Recruiter&nbsp;ID</th>
                        <th class="text-center medium">Commission</th>-->
                        <th class="text-center xlarge"
							style="background-color:#008000;color:#fff">Remarks</th> 
                        <th class="text-center medium"
							style="background-color:#008000;color:#fff">Status</th>
                          <th class="text-center approv"
							style="background-color:#008000;color:#fff">Approval</th> 
                    </tr>
                </thead>
                <tbody>
                     @foreach($salestaffs as $key => $salestaff)
                        <tr>
                            <td class="text-center">{{($key+1)}}</td>
                            <td class="text-center">
								<?php $formatted_str_id = str_pad($salestaff->user_id, 10, '0', STR_PAD_LEFT); ?>
								<a target="_blank" href="{{route('userPopup', ['id' => $salestaff->user_id])}}">{{IdController::nB($salestaff->user_id)}} </a>
							</td>
                            <td>
					<?php
                        /* Processed remark */
                        $pfullremark = null;
                        $premark = null;
						$elipsis = "...";
						$pfullremark = $salestaff->first_name . " " . $salestaff->last_name;
						$premark = substr($pfullremark,0, MAX_COLUMN_TEXT2);

						if (strlen($pfullremark) > MAX_COLUMN_TEXT2)
							$premark = $premark . $elipsis;
					?>								
								<span title='{{$pfullremark}}'>{{$premark}}</span>
							</td>
                   <!--         <td class="text-center">{{ $salestaff->nationality }}</td>
                            <td class="text-center"><?php $formatted_rec_id = str_pad($salestaff->recruiter_user_id, 10, '0', STR_PAD_LEFT); ?>
		<a target="_blank" href="{{route('userPopup',['id' => $salestaff->user_id])}}">[{{$formatted_rec_id}}]
<a href="javascript:void(0)" class="view-recruiter-modal" data-id="{{ $salestaff->user_id }}">
{{IdController::nB($salestaff->user_id)}} </a>

</td>
                            <td class="text-center">
                                <a rel="{{ $salestaff->id }}"
                                class="commission" href="javascript:void(0)">
                                Details</a>
                                <input id="target_{{ $salestaff->id }}" type="hidden" value="{{$salestaff->target_station}}" />

                                <?php
                                $revenue = number_format(($salestaff->target_revenue/100),2);
                                ?>
                                <input id="revenue_{{ $salestaff->id }}" type="hidden" value="{{$currency->code}}&nbsp;{{number_format($salestaff->target_revenue/100,2)}}" />
                                <?php
                                if($salestaff->target_revenue > 0){
                                    $bonus_salestaff = ((float)($salestaff->bonus)*1000)/(float)($salestaff->target_revenue);
                                } else {
                                    $bonus_salestaff = "0.00%";
                                }
                                ?>
                                <input id="bonus_{{ $salestaff->id }}" type="hidden" value="{{$bonus_salestaff}}%" />
                            </td>-->

                              <td id="remarks_column">
                            <?php
                                $remark = DB::table('remark')
                                ->select('remark')
                                ->join('sales_staffremark','sales_staffremark.remark_id','=','remark.id')
                                ->where('sales_staffremark.sales_staff_id',$salestaff->id)
                                ->orderBy('remark.created_at', 'desc')
                                ->first();

                                /* Processed remark */
                                $pfullremark = null;
                                $premark = null;

                                if ($remark) {
                                    $elipsis = "...";
                                    $pfullremark = $remark->remark;
                                    $premark = substr($pfullremark,0, MAX_COLUMN_TEXT);

                                    if (strlen($pfullremark) > MAX_COLUMN_TEXT)
                                        $premark = $premark . $elipsis;
                                }
                            ?>
                                <a href="javascript:void(0)" id="mcrid_{{$salestaff->id}}" class="mcrid" rel="{{$salestaff->id}}">
                                    <span title='{{$pfullremark}}'>{{$premark}}</span>
                                </a>
                            </td>

                            <td id="status_column" class="text-center">
                                <span id="status_column_text">
                                    {{ucfirst($salestaff->status)}}
                                </span>
                            </td>

                              <td>
                                <div class="action_buttons">
                                    <?php
                                    $approve = new Classes\Approval('sales_staff', $salestaff->id);
                                    if ($salestaff->status == 'active') {
                                        $approve->getSuspendButton();
                                    } else if ($salestaff->status == 'suspended' || $salestaff->status == 'rejected') {
                                        $approve->getReactivateButton();
                                    }
                                    echo $approve->view;
                                    ?>
                                </div>
                            </td> 
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
</div>

<div class="modal fade" id="myModal2" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 50%">
        <div class="modal-content" style='max-height: 500px; overflow-y: scroll;'>
            <div class="modal-body">
                <h3 id="modal-Tittle2"></h3>
                <div id="myBody2">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>

        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalcommission" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 50%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Commission Details</h4>
            </div>
            <div class="modal-body">
                <h3 id="modal-Tittle"></h3>
                <div id="myBody">
                    <table id="myTableSR" class="table table-bordered myTable"></table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>

        </div>
    </div>
</div>

<br>

<script src="{{url('js/jquery.dataTables.min.js')}}"></script>
<script src="{{url('jqgrid/jquery.jqGrid.min.js')}}"></script>
<script>
    $(document).ready(function () {
        var table = $('#station_recruiter_master_table').DataTable({
		'scrollX':true,
		 'autoWidth':true,
		 "order": [],
		 "columnDefs": [
				{ "targets": "no-sort", "orderable": false },
				{"targets": "medium", "width": "80px"},
				{"targets": "bmedium", "width": "100px"},
				{"targets": "large",  "width": "120px"},
				{"targets": "bsmall",  "width": "20px"},
				{"targets": "approv", "width": "180px"}, //Approval buttons
				{"targets": "blarge", "width": "200px"}, // *Names
				{"targets": "clarge", "width": "250px"},
				{"targets": "xlarge", "width": "300px"}, //Remarks + Notes 
			]
        });
        function pad (str, max) {
            str = str.toString();
            return str.length < max ? pad("0" + str, max) : str;
        }

        $('.commission').click(function(){
            _this = $(this);
            var staff_id= _this.attr('rel');

            $('#modal-Tittle').html("Commission");
            $('#myTableSR').empty();
            $('#myTableSR').append("<thead style='background-color: yellow; color: #000;'><th>Target&nbsp;Merchant</th><th>Target&nbsp;Revenue</th><th>Bonus&nbsp;%</th></thead>");
            var target = $('#target_'+staff_id).val();
            var revenue = $('#revenue_'+staff_id).val();
            var bonus = $('#bonus_'+staff_id).val();
            $('#myTableSR').append('<tbody><tr><td>'+target+'</td><td>'+revenue+'</td><td>'+bonus+'</td></tr></tbody>');

            $("#modalcommission").modal("show");

        });

	$('.view-statrecruiter-modal').click(function(){

	var user_id=$(this).attr('data-id');
	var check_url=JS_BASE_URL+"/admin/popup/check/user/"+user_id;
	$.ajax({
		url:check_url,
		type:'GET',
		success:function (r){
		console.log(r);
	
		if (r.status=="success") {
		var url=JS_BASE_URL+"/admin/popup/user/"+user_id;
		var w=window.open(url,"_blank");
		w.focus();
	}
	if (r.status=="failure") {
	var msg="<div class='alert alert-danger'>"+r.long_message+"</div>";
	$('#stationR-error-messages').html(msg);
	}
	}
	});
	});

	$('.view-recruiter-modal').click(function(){
	
	var user_id=$(this).attr('data-id');
	var check_url=JS_BASE_URL+"/admin/popup/check/user/"+user_id;
	$.ajax({
		url:check_url,
		type:'GET',
		success:function (r){
		console.log(r);

		if (r.status=="success") {
		var url=JS_BASE_URL+"/admin/popup/user/"+user_id;
		var w=window.open(url,"_blank");
		w.focus();
	}
	if (r.status=="failure") {
	var msg="<div class='aler alert-danger'>"+r.long_message+"</div>";
	$('#recruiter-error-message').html(msg);
	}
	}
	});
	});
	

        // $(".mcrid").click(function () {
        $(document).delegate( '.mcrid', "click",function (event) {
            _this = $(this);
            var id_sales_staff= _this.attr('rel');

            $('#modal-Tittle2').html("Remarks");

            var url = '/admin/master/sales_staff_remarks/'+ id_sales_staff;
            $.ajax({
                type: "GET",
                url: url,
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    var html = "<table class='table table-bordered' cellspacing='0' width='100%' ><tr style='background-color: yellow; color: #000;'><th class='text-center'>No</th><th class='text-center'>Station ID</th><th class='text-center'>Status</th><th class='text-center'>Admin User ID</th><th class='text-center'>Remarks</th><th class='text-center'>DateTime</th></tr>";
                    for (i=0; i < data.length; i++) {
                        var obj = data[i];
                        html += "<tr>";
                        html += "<td class='text-center'>"+(i+1)+"</td>";
                        html += "<td class='text-center'><a href='../../admin/popup/user/"+id_sales_staff+"' class='update' data-id='"+id_sales_staff+"'>["+pad(id_sales_staff.toString(),10)+"]</a></td>";
                        html += "<td class='text-center'>"+ucfirst(obj.status)+"</td>";
                        html += "<td class='text-center'><a href='../../admin/popup/user/"+obj.user_id+"' class='update' data-id='"+obj.user_id+"'>["+pad(obj.user_id.toString(),10)+"]</td>";
                        html += "<td>"+obj.remark+"</td>";
                        html += "<td class='text-center'>"+obj.created_at+"</td>";
                        html += "</tr>";
                    }
                    html = html + "</table>";
                    $('#myBody2').html(html);
                    $("#myModal2").modal("show");
                }
            });
        });
		
		$(window).resize();
    });
</script>
<script type="text/javascript">
	window.setInterval(function(){
	$('#stationR-error-messages').empty();
	}, 10000);
</script>
<script type="text/javascript">
	window.setInterval(function(){
	$('#recruiter-error-message').empty();
	}, 10000);
	
</script>
@endsection
