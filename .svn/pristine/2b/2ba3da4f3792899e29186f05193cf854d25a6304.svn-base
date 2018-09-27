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
<div class="row">
	<div class="col-md-12">
		<h2>Staff Page</h2>
		<div class="col-md-1"><label>Company</label></div>
		<div class="col-md-3">
			<select id="fairmerchant">
				<option value="0">Choose Merchant</option>
				@foreach($fairmerchant as $merchant)
					<option value="{{$merchant->user_id}}">{{$merchant->company_name}}</option>
				@endforeach
			</select>
		</div>
		<div class="col-md-3">
			<select id="companylocation">
				<option value="0">Choose Location</option>
				
			</select>

		</div>
		<div class="col-md-1">
		<span class="oncemerchantselected" style="display: none;">
			Function:</span>
		</div>

		<div class="col-md-2">
			<div class="oncemerchantselected" style="display: none;">
				<select id="modeselect" >
					<option value="0">Choose Function</option>
					// opossum_mgr, opossum_usr
					// sparoom_mgr, sparoom_usr
 					@if(Auth::user()->hasRole('opu') or
						Auth::user()->hasRole('opm') or
						Auth::user()->hasRole('spu') or
						Auth::user()->hasRole('spm'))
						<option value="opossum">OPOSsum</option>
					@endif
					// warehouse_mgr, warehouse_usr
					// caiman_mgr, caiman_usr
  					@if(Auth::user()->hasRole('whm') or
						Auth::user()->hasRole('whu') or
						Auth::user()->hasRole('cmg') or
						Auth::user()->hasRole('cur'))
						<option value="warehosue">Warehouse</option>
					@endif
 
					<option value="fairmode">Fair Mode</option>
					<option value="salesmemo">Sales Memo</option>
					<!--
					<option value="trackingreport">Tracking Report</option>
					<option value="productmapper">Product Mapper</option>
					-->

                                       
					<!--
					<option value="invoiceproforma">Invoice Pro-Forma</option>
					<option value="stocktable">Stock Take</option>
					<option value="deliveryman">Delivery Man</option>
					-->
				</select>
			</div>
		</div>
		
	<input type="hidden" id="fairrecruiter" value="{{$user_id}}" />
	</div>
	<div class="clearfix"></div>
	<div class="col-md-12" id="mode_html">
	</div>
</div>
<div class="modal fade" id="myModalFair" role="dialog" aria-labelledby="myModalFair">
    <div class="modal-dialog" role="document" id="fairmodaldiag">
        <div class="modal-content">
            <div class="modal-body" id="fairmodalbody">
                <h3 id="modal-Tittle2"></h3>
                <div id="myBody2">
					<div class="col-md-3">
						&nbsp;
					</div>
					<div class="col-md-6">
						<p align='center'><img src="{{asset('images/category/OpenSupermall Official Logo PNG.png')}}" class="img-responsive" alt="Logo"></p>
					</div>
					<div class="col-md-3">
						&nbsp;
					</div>
					<div class="clearfix"></div>
					<div class="col-md-2">
						&nbsp;
					</div>
					<div class="col-md-8">
						<input type="text" id="fairemail" placeholder="Please, enter email" class="form-control">
					</div>
					<div class="col-md-2">
						&nbsp;
					</div>
					<div class="clearfix"></div>
					<div class="col-md-2">
						&nbsp;
					</div>
					<div class="col-md-8">
						<p align="center"><a href="javascript:void(0)" class='btn btn-info fairbutton'>Store</a></p>
					</div>
					<div class="col-md-2">
						&nbsp;
					</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>

        </div>
    </div>
</div>
<br> <br>
<script type="text/javascript">
	function get_location($merchant_user_id) {
		$.ajax({
			url:JS_BASE_URL+"/buyer/companylocation",
			type:"POST",
			data:{user_id:$merchant_user_id,type:"user_id"},
			success:function (r) {
				var htmlrow="";
				if (r.status==="success") {
					for (var i = r.data.length - 1; i >= 0; i--) {
						row=r.data[i]
						htmlrow+=`
							<option
							value="`+row.id+`"
							>
							`+row.location+`
							</option>

						`;
					}
					$("#companylocation").html(htmlrow);
				}
			}
		})
	}
	function svalidateEmail(email) {
		var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return re.test(email);
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
					url: JS_BASE_URL+"/buyer/staff/function/" + selected,
					success: function (data) {
						console.log(data);
						$("#mode_html").html(data);
					},
					error: function (error) {
                                            console.log(error)
//						fairbutton.html('Store');
//						toastr.error("An unexpected error ocurred");
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
				get_location(userid);
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
					url: JS_BASE_URL+"/seller/member/add_employee",
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
