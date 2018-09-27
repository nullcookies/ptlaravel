<?php 
	use App\Http\Controllers\IdController;
?>
<h2>Merchant Professional Commission Master</h2>
<span id="mercprof-error-messages"></span>
<div class="table-responsive">
	<table class="table table-bordered" cellspacing="0" width="100%" id="grid7c">
		<thead style="background-color: #604a7b; color: #fff;">
			<tr>
				<th class="text-center">No</th>
				<th class="text-center">MP&nbsp;ID</th>
				<th class="text-center">Name</th>
				<th class="text-center">Commission</th>
			</tr>
		</thead>
		<tbody>
			@foreach($merchantsprofessional as $merchantpr)
			<tr>
				<td class="text-center">
					{{$i++}}
				</td>

				<td class="text-center">
					<?php $formatted_merchantpr_id = IdController::nB($merchantpr->user_id); ?>
					<!--<a target="_blank" href="{{route('userPopup', ['id' => $merchantpr->user_id])}}">[{{$formatted_merchantpr_id}}]</a>-->
<a href="javascript:void(0)" class="view-MercProf-modal" data-id="{{ $merchantpr->user_id}}">{{$formatted_merchantpr_id}}</a>
			
				</td>

				<td>
					{{$merchantpr->first_name}} {{$merchantpr->last_name}}
				</td>

				<td class="text-center">
					<a rel="{{ $merchantpr->id }}"
					class="commission" href="javascript:void(0)">
					Details</a>
				</td>
			</tr>
			@endforeach
			</tbody>
	</table>
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
					<table id="myTableC" class="table table-bordered myTable"></table>
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

	$('#grid7c').DataTable({
		'scrollX':true,
		 'autoWidth':false,
		 "order": [],
		 "columns": [
			{ "width": "20px", "orderable": false },
			{ "width": "85px" },
			{ "width": "120px" },
			{ "width": "85px" }
		  ]
	});

	$('.commission').click(function(){
		_this = $(this);
		var staff_id= _this.attr('rel');

		$('#modal-Tittle').html("Commission");

		var url = '/admin/commission/professional_commission/'+ staff_id;
		$.ajax({
			type: "GET",
			url: url,
			dataType: 'json',
			success: function (data) {
				//console.log(data);
				$('#myTableC').html("<thead style='background-color: #604a7b; color: #fff;'><th>No</th><th>Merchant ID</th><th>Name</th><th>Commission</th><th>MP1/MP2</th><th>MC ID</th></thead>");
				$('#myTableC').append('<tbody>');
				for (i=0; i < data.length; i++) {
					var mpn = "MP";
					if(data[i].id == data[i].mp1_id){
						mpn = "MP1";
					}
					if(data[i].id == data[i].mp2_id){
						mpn = "MP2";
					}
					$('#myTableC').append("<tr><td>"+ (parseInt(i+1)) +"</td><td><a target='_blank' href='/admin/popup/merchant/"+data[i].merchant_id+"'>["+ pad(data[i].merchant_id,10) +"]</a></td><td>"+ data[i].merchant_name +"</td><td>"+ data[i].commission +"%</td><td>"+ mpn +"</td><td><a target='_blank' href='/admin/popup/user/"+data[i].mc_id+"'>["+ pad(data[i].mc_id,10) +"]</a></td></tr>");
				}
				$('#myTableC').append('</tbody>');
				$("#modalcommission").modal("show");
		  	}
		});

	});
});
$('.view-MercProf-modal').click(function(){

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
	$('#mercprof-error-messages').html(msg);
}
}
});
});
</script>
<script type="text/javascript">
window.setInterval(function(){
$('#mercprof-error-messages').empty();
}, 10000);
</script>
