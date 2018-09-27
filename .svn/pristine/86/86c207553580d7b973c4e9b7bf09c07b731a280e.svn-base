@extends("common.default")
@section("content")
<style>
@media only screen and (max-width: 599px){
   .fairbutton{
		font-size: 25px;
		background-color: #FF3333 !important;
		padding: 20px 12px 20px 12px;
		margin-top: 15px;
	}
	#fairmodalbody{
		margin-left: 0px !important;
		height: 100%;
	}
	 #fairmodaldiag{
		width: 100%; 
		height: 465px;
		margin-left: 0px !important;
	}

}
@media only screen and (max-width: 899px) and (min-width: 600px) {
   .fairbutton{
		font-size: 25px;
		background-color: #FF3333 !important;
		padding: 20px 12px 20px 12px;
		margin-top: 15px;
	}
	#fairmodalbody{
		margin-left: 0px !important;
	}
	 #fairmodaldiag{
		width: 70%; 
		height: 465px;
	}

}
@media only screen and (min-width: 900px) {
    #fairmodaldiag{
		width: 50%; 
		height: 465px;
	}
	#fairmodalbody{
		height: 270px;
	}
	.fairbutton{
		font-size: 25px;
		background-color: #FF3333 !important;
		padding: 20px 12px 20px 12px;
		margin-top: 15px;
	}
}
</style>
<div class="row" style='min-height: 480px; margin: 0 !important;'>
	
	<div class="col-md-12">
		<h2>Staff Page</h2>
		<div class="col-md-1"><label>Company</label></div>
		<div class="col-md-4">
			<select id="fairmerchant">
				<option value="0">Choose Merchant</option>
				@foreach($fairmerchant as $merchant)
					<option value="{{$merchant->user_id}}">{{$merchant->company_name}}</option>
				@endforeach
			</select>
		</div>
		<div class="col-md-2">
		</div>
		<div class="col-md-1">
			<span class="oncemerchantselected" style="display: none;">Function:</span>
		</div>
		<div class="col-md-2">
			<div class="oncemerchantselected" style="display: none;">
				<select id="modeselect" >
					<option value="0">Choose Function</option>
					<option value="fairmode">Fair Mode</option>
					<option value="salesmemo">Sales Memo</option>
					<option value="invoiceproforma">Invoice Pro-Forma</option>
					<option value="stocktable">Stock Take</option>
					<option value="deliveryman">Delivery Man</option>
				</select>
			</div>
		</div>
		
		<input type="hidden" id="fairrecruiter" value="{{$user_id}}" />
	</div>
	<div class="clearfix"></div>
	<div class="col-md-12" id="mode_html">
	</div>
</div>
<div class="modal fade" id="salesmemoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document" style="width:94%">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h2 class="modal-title" id="myModalLabel2">Sales Memo</h2>
			</div>
			<div class="modal-body" id="salesmemomodalbody" style="margin-left: 0px !important;">
			<textarea class="form-control" id="long-remark"></textarea>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal" id="initajax" style="min-width: 60px;">Close</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	function svalidateEmail(email) {
		var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return re.test(email);
	}

	function statementmemo(id,year,month) {
		//get the merchant data from the backend and render on the modal
		console.log(month);
		$("#hsa" + year + "-" + month).hide();
		$("#isa" + year + "-" + month).show();
		$.ajax({
			type: "POST",
			url: JS_BASE_URL+"/salesmemo/buyerdetail/" + $("#fairrecruiter").val(),
			data: { id:id,year:year,month:month },
			beforeSend: function(){},
			success: function(response){
				$('#salesmemomodalbody').html(response);
				$('#salesmemoModal').modal('toggle');
				$("#hsa" + year + "-" + month).show();
				$("#isa" + year + "-" + month).hide();
			}
		});
	}	
	
    $(document).ready(function(){
		$(document).delegate( '#modeselect', "change",function (event) {
			var selected = $(this).val();
			if(selected == "0"){
				$("#mode_html").html("");
			} else {
				var userid = $("#fairmerchant").val();
				var fairrecruiter = $("#fairrecruiter").val();
				$.ajax({
					type: "GET",
					data: {userid: userid, recruiter: fairrecruiter},
					url: "/buyer/staff/mobile/function/" + selected,
					success: function (data) {
						console.log(data);
						$("#mode_html").html(data);
					},
					error: function (error) {
						fairbutton.html('Store');
						toastr.error("An unexpected error ocurred");
					}

				});	
				
				//$("#modeselect").select2();
				//window.open(JS_BASE_URL + '/fairmode/' + userid + '/' + fairrecruiter, '_blank');
			}
		});
		$(document).delegate( '#fairmerchant', "change",function (event) {
			if($(this).val() == "0"){
				$("#mode_html").html("");
				$("#modeselect").val('0').trigger('change');
				$(".oncemerchantselected").hide();
			} else {
				var userid = $("#fairmerchant").val();
				var fairrecruiter = $("#fairrecruiter").val();
				$(".oncemerchantselected").show();
				
				//$("#modeselect").select2();
				//window.open(JS_BASE_URL + '/fairmode/' + userid + '/' + fairrecruiter, '_blank');
			}
		});

		$(document).delegate( '.fairbutton', "click",function (event) {
			console.log("passss");
			var fairbutton = $(this);
			fairbutton.html('Saving...');
			var email = $("#fairemail").val();
			var rel = $(this).attr('rel');
			$("#mailspin").show();
			var userid = $("#fairmerchant").val();
			var fairrecruiter = $("#fairrecruiter").val();
			if(svalidateEmail(email) && parseInt(userid) > 0){
				//console.log(lpid);
				$.ajax({
					type: "POST",
					data: {email: email, userid: userid, recruiter: fairrecruiter},
					url: "/seller/member/add_employee",
					dataType: 'json',
					success: function (data) {
						console.log(data);
						if(data.status == "warning"){
							toastr.warning(data.long_message);
						}
						if(data.status == "error"){
							toastr.error(data.long_message);
						}
						if(data.status == "success"){
							toastr.info(data.long_message);
						}
						$("#fairemail").val("");
						fairbutton.html('Store');
						$("#myModalFair").modal('toggle');
					},
					error: function (error) {
						fairbutton.html('Store');
						toastr.error("An unexpected error ocurred");
					}

				});				
				
			} else {
				fairbutton.html('Store');
				if(!svalidateEmail(email)){
					if(email != ""){
						toastr.error("Invalid email! Please, type a valid email.");
					} else {
						toastr.error("Please, type in email");
					}
				}
				if(parseInt(userid) == 0){
					toastr.error("Please, select one merchant!");
				}
			}
		});
    });
</script>
@stop
