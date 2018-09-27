@extends("common.default")
<?php
use App\Http\Controllers\UtilityController;
use App\Classes;
?>
@section("content")
<!--
<link href="{{url('assets/jqGrid/ui.jqgrid.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{url('css/datatable.css')}}" rel="stylesheet" type="text/css"/>
-->

<style>

    #errmsg{
        color: red;
    }
    td{
        padding: 2px !important;
    }
    .tab-pane{
        margin-top: 4em;
    }
/*Butto*/
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

    /*.rotate {*/
        /*transform:rotate(180deg);*/
        /*transition:all 0.5s;*/
    /*}*/
    /*.rotate.in {*/
        /*transform:rotate(720deg);*/
        /*transition:all 2.5s;*/
    /*}*/

    canvas {
        border: groove;
        /*border-color: black;*/
        border-color: #00008B;
        border-width: thick;
        cursor: pointer;
        display : block;
        margin : auto;
    }

    .action_buttons{
        display: flex;
    }
    .role_status_button{
        margin: 10px 0 0 10px;
    }
/*
Search
*/
    .search-bar{
        background-color: #006464;
        font-size: 1.2em;
        color: white;
        padding: 10px;
    }
    .details-control, .details-control-2 {
        cursor: pointer;
    }
    .textCenter{
        text-align: center;
    }
    .textRight{
        text-align: right;
    }
    td{
        min-width: 10%;
    }
    td.streched{
        min-width: 100px;
    }
    td.details-control:after ,td.details-control-2:after {
        font-family: 'FontAwesome';
        content: "\f0da";
        color: #303030;
        font-size: 17px;
        float: right;
        padding-right: 25px;
    }
    tr.shown td.details-control:after, tr.shown td.details-control-2:after {
        content: "\f0d7";
    }
    table td.absorbing-column {
    width: 50%;
}

    .child_table {
        margin-left: 78px;
        width: 920px;;
    }
    .panel {
    border: 0;
}

.top-margin{
    margin-top: -30px;
}
    table
    {
        counter-reset: Serial;
        table-layout: auto;
    }

    table.counter_table tr td:first-child:before
    {
        counter-increment: Serial;      /* Increment the Serial counter */
        content: counter(Serial); /* Display the counter */
    }

    .modal-fullscreen{
      margin: 0;
      margin-right: auto;
      margin-left: auto;
      width: 95% !important;
    }


    @media (min-width: 768px) {
      .modal-fullscreen{
        width: 750px;
      }
    }
    @media (min-width: 992px) {
      .modal-fullscreen{
        width: 970px;
      }
    }
    @media (min-width: 1200px) {
      .modal-fullscreen{
         width: 1170px;}
    }
    table#product_details_table,#payment_detail_products
    {
        table-layout: fixed;
        max-width: none;
        width: auto;
        min-width: 100%;
    }
    .bg-yellow
    {
        background:#d7e748;
        color: #fff;
    }
    .bg-black
    {
        background:#000;
        color: #fff;
    }
    .bg-light-green
    {
        background:#6d9370;
        color: #fff;
    }
    .bg_voilet
    {
        background:#6b013b;
        color: #fff;
    }
    .start_col{
        background: red;
        color: white;
    }
    .address_lines{
        margin-bottom: 6px !important;
    }
</style>
    <section class="">
        <div class="container"><!--Begin main cotainer-->
            <div class="alert alert-success alert-dismissible hidden cart-notification" role="alert" id="alert">
                <button type="button" class="close"
					data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;
				</span></button>
                <strong class='cart-info'></strong>
            </div>
            <div class="row">
                <div class="col-sm-12">
					{{-- {!! Breadcrumbs::render('logistic.dashboard') !!} --}}
                    <div class="col-sm-6">
						<h2>Logistics Dashboard</h2>
					</div>
					<div class="col-sm-6">
						<h2 class='pull-right'><i>
							{{$logistic->company_name}}&nbsp;</i><h2>
					</div>
                    {{-- Tabbed Nav --}}
						<div class="panel with-nav-tabs panel-default ">
							<div class="panel-heading">
								<ul class="nav nav-tabs">
								<li class="active"><a href="#sales-order"
									data-toggle="tab">Order</a></li>

								@if($logistic->professional == true)
									<li class=""><a href="#pricing-table"
										data-toggle="tab">Price</a></li>
								@endif
								<li class=""><a href="#auto-link"
									data-toggle="tab">Autolink</a></li>
								<li class=""><a href="#lstatement"
									data-toggle="tab">Documents</a></li>
								<li class=""><a href="#employees"
									data-toggle="tab">Member&nbsp;List</a></li>

								@if($logistic->professional == false)
									<li class=""><a href="#delivery-control"
										data-toggle="tab">
										Delivery&nbsp;Control</a></li>
									<li class=""><a href="#manual-order"
										data-toggle="tab">
										Manual&nbsp;Order</a></li>
								</ul>
								@endif
							</div>
						</div>
                    {{--ENDS  --}}

                        <div id="dashboard" class="row panel-body " >
						@include('logistics.dashboard.sales-order')
						@include('logistics.dashboard.pricing')
						<div class="tab-pane fade" id="auto-link">
							@include('seller.dashboard.sautolink')
						</div>
						@include('logistics.dashboard.lstatement')
						@include('logistics.dashboard.employees')
                            
                            <div id="payment" class="tab-pane fade in">
    							<div class="row">
                                    <div class="col-md-12">
                                        <form id="frm_logistics_company">
                                        <table width="100%" class="table table-bordered"  id="tbl_logistics_company">
                                            <thead>
                                            
                                            <tr class="bg-light-green">
                                                <th class="text-center">No </th>
                                                <th class="text-center">Logistic ID</th>
                                                <th class="text-center">Name</th>
                                                <th class="text-center">Capability</th>
                                                <th class="text-center">Price</th>
                                                <th colspan="2" class="text-center">Delivery Order</th>
                                                <th colspan="2" class="text-center">Total</th>
                                                <th  class="text-center">Payment</th>
                                            </tr>
                                            <tr class="bg-light-green">
                                                <th colspan="4" class="text-center"></th>
                                                <th class="text-center">Outstanding</th>
                                                <th class="text-center">Completed</th>
                                                <th class="text-center">DO</th>
                                                <th class="text-center">Amount</th>
                                                <th class="text-center">Outstanding</th>
                                                <th class="text-center">Delivery Order</th>
                                            </tr>
                                            </thead>

                                                <tbody id="pricing-table-body">
                                            
                                                    <tr>
                                                        <td class="text-center">1</td>
                                                        <td class="text-right">225114</td>
                                                        <td class="text-left">data</td>
                                                        <td class="text-left"><a href="javascript:viod">Details</a></td>
                                                        <td class="text-left"><a href="javascript:viod">Details</a></td>
                                                        <td class="text-right">25</td>
                                                        <td class="text-right">74</td>
                                                        <td class="text-right">100</td>
                                                        <td class="">
                                                                <span class="pull-left">$</span>
                                                                <span class="pull-right">20000</span>
                                                        </td>
                                                        <td class="text-right">29500</td>
                                                        
                                                    </tr>
                                                
                                                </tbody>
                                           
                                            
                                        </table>
                                        </form>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <form id="frm_logistics_company">
                                        <table width="100%" class="table table-bordered"  id="tbl_delivery_master">
                                            <thead>
                                            
                                            <tr class="bg_voilet">
                                                <th class="text-center">No </th>
                                                <th class="text-center">Date</th>
                                                <th class="text-center">Order ID</th>
                                                <th class="text-center">Merchant ID</th>
                                                <th bgcolor="#6d9370" class="text-center">Logistics ID</th>
                                                <th class="text-center">Dimension</th>
                                                <th class="text-center">Sender</th>
                                                <th class="text-center">Recepient</th>
                                                <th  class="text-center">Status</th>
                                                <th  class="text-center">fee</th>
                                            </tr>
                                            
                                            </thead>

                                                <tbody id="">
                                            
                                                    <tr>
                                                        <td class="text-center">1</td>
                                                        <td class="text-right">225114</td>
                                                        <td class="text-right"><a href="">2514</a></td>
                                                        <td class="text-right"><a href="javascript:viod">7415</a></td>
                                                        <td class="text-left">1-98536412</td>
                                                        <td class="text-left"><a href="javascript:viod" onclick="delivery_dimension_popup()">Details</a></td>
                                                        <td class="text-right"><a href="javascript:void" onclick="delivery_sender_popup()">Subang jaya</a></td>
                                                        <td class="text-right"><a href="javascript:void" onclick="delivery_receiver_popup()">Puchong</a></td>
                                                        <td class="text-right"><a href="javascript:void" onclick="delivery_status_popup()">Active</a></td>
                                                        <td class="">
                                                                <span class="pull-left">{{$currentCurrency}}</span>
                                                                <span class="pull-right">20000</span>
                                                        </td>
                                                        
                                                    </tr>
                                                
                                                </tbody>
                                           
                                            
                                        </table>
                                        </form>
                                    </div>
                                </div>  
                            </div>

                        </div>
                        

				</div>
            </div>
        </div>
    </section>
    
        <div class="modal fade myModal" id="Modal" role="dialog">
        <div class="modal-dialog modal-fullscreen">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button id='orderClose' type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">
                        <h3>Payment</h3>
                    </h4>
                </div>
                <div class='modal-body'>

                </div>
                <div class="modal-footer" style='border:none'>
                </div>
            </div>
        </div>
    </div>
<!-- start Popups -->    
    <div id="modal-sender" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h2>Sender Details</h2>
                        </div>
                        <div class="modal-body" style="padding: 0 20px 20px 20px;">
                          <div class="row">
                              <div class="col-md-12">
                                 <form class="form-horizontal">
                                    <div class="col-md-7">
                                        <div class="form-group">
                                          <strong class="col-sm-3">Name:</strong>
                                          <div class="col-sm-9">
                                            <span>Hamza </span>
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <strong class="col-sm-3">Contact:</strong>
                                          <div class="col-sm-9">
                                            <span>034255514 </span>
                                          </div>
                                        </div>
                                        <div class="form-group address_lines">
                                          <strong class="col-sm-3">Address:</strong>
                                          <div class="col-sm-9">
                                            <span>line 1 </span>
                                          </div>
                                        </div>
                                         <div class="form-group address_lines">
                                          <div class="col-sm-9 col-sm-offset-3">
                                            <span>line 2 </span>
                                          </div>
                                        </div>
                                        <div class="form-group address_lines">
                                          <div class="col-sm-9 col-sm-offset-3">
                                            <span>line 3 </span>
                                          </div>
                                        </div>
                                        <div class="form-group address_lines">
                                          <div class="col-sm-9 col-sm-offset-3">
                                            <span>line 4 </span>
                                          </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                          <strong class="col-sm-4">Country:</strong>
                                          <div class="col-sm-8">
                                            <span>pakistan </span>
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <strong class="col-sm-4">State:</strong>
                                          <div class="col-sm-8">
                                            <span>Punjab </span>
                                          </div>
                                        </div>
                                        <div class="form-group" style="">
                                          <strong class="col-sm-4">City:</strong>
                                          <div class="col-sm-8">
                                            <span>lahore </span>
                                          </div>
                                        </div>
                                    </div>
                                  </form>
                          </div>
                          </div>
                         
                        </div>
                      </div>
                    </div>
                  </div>
                <!-- receiver popup -->
                <div id="modalI" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h2>Details</h2>
                        </div>
                        <div class="modal-body" style="padding: 0 20px 20px 20px;">
                         {{-- zxc --}}
                          </div>
                         
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- end receiver popup -->

                   <div id="modal-receiver-delivery" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h2>Receiver</h2>
                        </div>
                        <div class="modal-body" style="padding: 0 20px 20px 20px;">
                          <div class="row">
                              <div class="col-md-12">
                                 <table class="table table-bordered" >
                                     <thead class="bg_voilet">
                                         <tr>
                                             <th>Name</th>
                                             <th>Contact</th>
                                             <th>Address</th>
                                         </tr>
                                     </thead>
                                     <tbody>
                                         <tr>
                                             <td>test</td>
                                             <td>test</td>
                                             <td>test</td>
                                         </tr>
                                     </tbody>
                                 </table>
                          </div>
                          </div>
                         
                        </div>
                      </div>
                    </div>
                  </div>
                  <div id="modal-sender-delivery" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h2>Sender</h2>
                        </div>
                        <div class="modal-body" style="padding: 0 20px 20px 20px;">
                          
                           
                         
                         
                        </div>
                      </div>
                    </div>
                  </div>

                  <div id="modal-dimension-delivery" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h2>Dimension</h2>
                        </div>
                        <div class="modal-body" style="padding: 0 20px 20px 20px;">
                          <div class="row">
                              <div class="col-md-12">
                                 <table class="table table-bordered" >
                                     <thead class="bg_voilet">
                                         <tr>
                                             <th>Width</th>
                                             <th>Length</th>
                                             <th>Height</th>
                                             <th>Weight</th>
                                         </tr>
                                     </thead>
                                     <tbody>
                                         <tr>
                                             <td>2521</td>
                                             <td>14.00</td>
                                             <td>29</td>
                                             <td>5</td>
                                         </tr>
                                     </tbody>
                                 </table>
                          </div>
                          </div>
                         
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- end receiver popup -->

<!-- end Popups -->    



{{-- <script type="text/javascript" src="{{asset('js/autolink.js')}}"></script> --}}
{{-- <script src="{{url('js/jquery.min.js')}}"></script> --}}
{{-- <script src="{{url('js/bootstrap.js')}}"></script> --}}
{{-- <script src="{{url('js/jquery.dataTables.min.js')}}"></script> --}}
{{-- <script src="{{url('jqgrid/jquery.jqGrid.min.js')}}"></script> --}}


<script>
    function open_sender_popup() {
        $("#modal-sender").modal('show');
    }
    function open_receiver_popup() {
        $("#modal-receiver").modal('show');
    }
    function open_status_popup() {
        $("#modal-receiver").modal('show');
    }
    count_pricing_row=1;
    function add_row_pricing_table() {
        
        
    }

    function hasDecimalPlace(value, x) {
        var pointIndex = value.indexOf('.');
        return  pointIndex >= 0 && pointIndex < value.length - x;
    }

    /*Delivery master view popups*/

    function delivery_receiver_popup() {
        $("#modal-receiver-delivery").modal('show');
    }
    function delivery_sender_popup() {
        $("#modal-sender-delivery").modal('show');
    }
    function delivery_status_popup() {
        $("#modal-status-delivery").modal('show');
    }function delivery_dimension_popup() {
        $("#modal-dimension-delivery").modal('show');
    }
</script>

<script type="text/javascript">
	function firstToUpperCase( str ) {
		return str.substr(0, 1).toUpperCase() + str.substr(1);
	}
    $(document).ready(function(){
        $('.apopup').click(function(){
            var cn=$(this).attr('rel');
            var t= $(this).attr('rel-type');
            var url="{{url('lp/addresses/')}}"+"/"+cn+"/"+t;
            $('#modalI').modal('show');
            $('#modalI').find('.modal-body').load(url);

            

        });
		$(document).delegate( '.userrole', "click",function (event) {
			var rel = $(this).attr('rel');
			$(this).hide();
			$("#userrolesel" + rel).show();
		});
		
		$(document).delegate( '.key_employee', "blur",function (event) {
			var email = $(this).val();
			var rel = $(this).attr('rel');
			$("#mailspin").show();
			var lpid = $("#lpeid").val();
			if(validateEmail(email)){
				$.ajax({
					type: "POST",
					data: {email: email, lpid: lpid},
					url: "/lp/add_employee",
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
							if(parseInt(data.employee['user_id']) > 0){
								$("#usera" + rel).html("<a href='javascript:void(0)' class='view-employee-modal' data-id='"+data.employee['user_id']+"'>"+data.employee['id']+"</a>");
							}
							$("#username" + rel).html(data.employee['name']);
							if(data.employee['status'] == 'tagged'){	
								$("#userrole" + rel).html('<a href="javascript:void(0)" class="member_role" rel="'+data.employee['user_id']+'">Roles</a>');
							} else {
								$("#userrole" + rel).html("&nbsp;&nbsp;&nbsp;&nbsp;");
							}
							if(data.employee['status'] == 'tagged'){
								$("#usertop" + rel).html("<a target='blank' href='"+JS_BASE_URL+"/lp/employees/"+data.employee['user_id']+"' >" + firstToUpperCase(data.employee['status'])+"</a>");
							} else {
								$("#usertop" + rel).html(firstToUpperCase(data.employee['status']));
							}
							$("#useremail" + rel).html(data.employee['email']);
							$("#useremail" + rel).show();
							$("#userkey" + rel).hide();
							$("#usercheck" + rel).html("<input type='checkbox' class='sender' rel='"+data.employee['email']+"' />");
							$("#userdelete" + rel).html("<a  href='javascript:void(0);' class='text-danger delete_member' rel='"+data.employee['email']+"'><i class='fa fa-minus-circle fa-2x'></i></a>");
						/*	var e = parseInt($("#nume").val());
							var rowNode = emp_table.row.add( [ "<p align='center'>" + e + "</p>", "<p align='center'><a href='javascript:void(0)' class='view-employee-modal' data-id='"+data.employee['user_id']+"'>"+data.employee['id']+"</a></p> ","<p align='center'>" + data.employee['name'] + "</p>", "<p align='center'>" + firstToUpperCase(data.employee['role']) + "</p>", "<p align='center'>" + "<a href='javascript:void(0)' >" + firstToUpperCase(data.employee['status'])+ '</a>' + "</p>", "<p align='center'>" + data.employee['email'] + "</p>", "<p align='center'>" + "<input type='checkbox' class='sender' rel='"+data.employee['email']+"' />" + "</p>" ] ).draw();
							$( rowNode )
							.css( 'text-align', 'center');
							e++;
							$("#nume").val(e);*/
						}
						$(".key_employee").val("");
						$("#mailspin").hide();
					},
					error: function (error) {
						$("#mailspin").hide();
						toastr.error("An unexpected error ocurred");
					}

				});				
				
			} else {
				$("#mailspin").hide();
				if(email != ""){
					toastr.error("Invalid email! Please, type a valid email.");
				}
			}
				//alert($(this).is(":checked"));
         });		
	$('#sales-order-table').DataTable({
            "order": [],
            "columnDefs": [
                { "targets": "no-sort", "orderable": false },
                { "targets": "large", "width": "120px" },
                { "targets": "smallestest", "width": "55px" },
                { "targets": "medium", "width": "95px" },
                { "targets": "xlarge", "width": "280px" }
            ]
        }); 
    $('#tbl_logistics_company').DataTable({
            "order": [],
            "columnDefs": [
                { "targets": "no-sort", "orderable": false },
                { "targets": "large", "width": "120px" },
                { "targets": "smallestest", "width": "55px" },
                { "targets": "medium", "width": "95px" },
                { "targets": "xlarge", "width": "280px" }
            ]
        }); 
    $('#tbl_delivery_master').DataTable({
            "order": [],
            "columnDefs": [
                { "targets": "no-sort", "orderable": false },
                { "targets": "large", "width": "120px" },
                { "targets": "smallestest", "width": "55px" },
                { "targets": "medium", "width": "95px" },
                { "targets": "xlarge", "width": "280px" }
            ]
        });
    $('#pricing-table-table-test').DataTable({
            "order": [],
            "columnDefs": [
                { "targets": "no-sort", "orderable": false },
                { "targets": "large", "width": "120px" },
                { "targets": "smallestest", "width": "55px" },
                { "targets": "medium", "width": "95px" },
                { "targets": "xlarge", "width": "280px" }
            ]
        });
		
    $("#pricing-table-table").on('click', '#pricing_add_row', function(event) {
        count_pricing_row++;
        $("#pricing-table-body").append('<tr><td class="text-center">'+count_pricing_row+'</td>'+
                            '<td><input class="numOnly" type="text" name="row_'+count_pricing_row+'_width"></td>'+
                            '<td><input  class="numOnly" type="text" name="row_'+count_pricing_row+'_length"></td>'+
                            '<td><input class="numOnly"  type="text" name="row_'+count_pricing_row+'_height"></td>'+
                            '<td><input class="numOnly"  type="text" name="row_'+count_pricing_row+'_weight"></td>'+
                            '<td><select name="row_'+count_pricing_row+'_location"><option value="">--select--</option></select></td>'+
                            '<td><input class="numOnly"  type="text" name="row_'+count_pricing_row+'_price"></td></tr>'
        );
        $('select').select2();

    });
    $('#pricing-table').on('click','#save_pricing_table', function(event) {
        var jsonObj=  [];   
            for(var i=1; i<=count_pricing_row; i++)
            {
                item = {};
                item ['row_'+i+'_width'] = $('input[name=row_'+i+'_width]').val();
                item ['row_'+i+'_length'] = $('input[name=row_'+i+'_length]').val();
                item ['row_'+i+'_height'] = $('input[name=row_'+i+'_height]').val();
                item ['row_'+i+'_weight'] = $('input[name=row_'+i+'_weight]').val();
                item ['row_'+i+'_location'] = $('input[name=row_'+i+'_location]').val();
                item ['row_'+i+'_price'] = $('input[name=row_'+i+'_price]').val();
                jsonObj.push(item);  
            }
            console.log(JSON.stringify(jsonObj));
        console.log(jsonObj);
    });
    
		$('#pricing-table').on('keypress', '.numOnly', function(e) {
			if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
			event.preventDefault();
		  } else {
			   var entered_value = $(this).val();
			  var regexPattern = /^\d{0,8}(\.\d{1,2})?$/; 
			  if(regexPattern.test(entered_value)) {
				  $(this).css('background-color', 'white');
				  $('.err-msg').html('');
			  } else {
				  $(this).css('background-color', 'red');
				  $('.err-msg').html('Enter a valid Decimal Number');
			  }
		  }
		});	
		$(".dataTables_empty").attr("colspan","100%");	
    });
</script>
@stop

