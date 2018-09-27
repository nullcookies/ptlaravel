<?php
use App\Http\Controllers\UtilityController;
use App\Classes;
$ii = 1;
?>
<div class="row">
	<div class=" col-sm-12">
		<a class="add_row_crm btn btn-danger pull-right" style=" margin-right: 5px; width: 120px;"
							href="javascript:void(0)">+ Prospect</a>
	</div>
	<div class="clearfix"></div>
	<br>
	<div class=" col-sm-12">
		<table class="table table-bordered"  id="crm-table" width="98%">
			<thead>
			
			<tr style="background-color: red; color: white;">
				<th class="bsmall">No</th>
				<th class="text-center">Name</th>
				<th class="text-center">Email</th>
				<th class="text-center">Mobile</th>
			</tr>
			</thead>						
			<tbody>
			@foreach($customers as $customer)
				<tr>
					<td class="text-center">{{$ii}}</td>
					<td class="text-center">
					<?php
					/* Processed note */
					$pfullnote = null;
					$pnote = null;
					$elipsis = "...";
					if($customer->name == "" || is_null($customer->name)){
						$pfullnote = $customer->first_name ." ".
						$customer->last_name;
					} else {
						$pfullnote = $customer->name;
					}
						
					$pnote = substr($pfullnote,0, 20);

					if (strlen($pfullnote) > 20)
						$pnote = $pnote . $elipsis;
					?> 		
					<span title='{{$pfullnote}}' class="customer_name" id="customer_name{{$customer->id}}" rel="{{$customer->id}}">&nbsp;&nbsp;{{$pnote}}&nbsp;&nbsp;</span>	
					<span id="sinputcustomer_name{{$customer->id}}" style="display: none;">
						<input type="text" value="{{$pfullnote}}" rel="{{$customer->id}}" class="customer_name_input" id="inputcustomer_name{{$customer->id}}" />
					</span>	
						
					</td>
					<td class="text-center">											
						{{$customer->email}}	
					</td>
					<td class="text-center">	
						<span title='{{$customer->mobile}}' class="customer_mobile" id="customer_mobile{{$customer->id}}" rel="{{$customer->id}}">&nbsp;&nbsp;{{$customer->mobile}}&nbsp;&nbsp;</span>
						<span id="sinputcustomer_mobile{{$customer->id}}" style="display: none;">
							<input type="text" value="{{$customer->mobile}}" rel="{{$customer->id}}" class="customer_mobile_input" id="inputcustomer_mobile{{$customer->id}}" />
						</span>	
					</td>
				</tr>
				<?php $ii++; ?>
			@endforeach
			</tbody>
		</table>
	</div>
	<input type="hidden" value="{{$ii}}" id="numecrm" />
</div>
<div class="clearfix"></div>
<script type="text/javascript">
	function newfirstToUpperCase( str ) {
		return str.substr(0, 1).toUpperCase() + str.substr(1);
	}

	function newvalidateEmail(email) {
		var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return re.test(email);
	}
	
    $(document).ready(function(){		
		var camp_table = $('#crm-table').DataTable({
		"order": [],
		 "columns": [
				{ "width": "20px", "orderable": false },
				{ "width": "300px" },
				{ "width": "300px" },
				{ "width": "300px" },
			]
		});		
		$(document).delegate( '.add_row_crm', "click",function (event) {
			var e = parseInt($("#numecrm").val());
			var rowNode = camp_table.row.add( ["<p align='center'>"+ e + "</p>","<p align='center' id='username"+e+"'></p>", "<p align='center' id='useremail"+e+"' style='display: none;'></p><p align='center' id='userkey"+e+"'><input type='text' class='form-control key_customer' placeholder='Enter employee email...' rel='"+e+"' /></p>","<p align='center' id='usermobile"+e+"'></p>"] ).draw();
			$( rowNode )
			.css( 'text-align', 'center');
			e++;
			$("#numecrm").val(e);						
	
		});	

		$(document).delegate( '.key_customer', "blur",function (event) {
			var keyemployee = $(this);
			var email = $(this).val();
			var rel = $(this).attr('rel');
			var recruiter = $("#userjust_id").val();
			if(newvalidateEmail(email)){
				$.ajax({
					type: "POST",
					data: {email: email,recruiter: recruiter},
					url: "/buyer/crm/customers/add",
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
							$("#username" + rel).html(data.employee['name']);	
							$("#usermobile" + rel).html(data.employee['mobile']);	
							$("#useremail" + rel).html(data.employee['email']);
							$("#useremail" + rel).show();
							$(".key_customer").hide();
						}
						$(".key_customer").val("");
						
						$("#mailspin").hide();
					},
					error: function (error) {
						$("#mailspin").hide();
						toastr.error("An unexpected error ocurred");
					}

				});				
				
			} else {
				if(email != ""){
					toastr.error("Invalid email! Please, type a valid email.");
				}
			}			
		});	
		$(".dataTables_empty").attr("colspan","100%");
    });
</script>