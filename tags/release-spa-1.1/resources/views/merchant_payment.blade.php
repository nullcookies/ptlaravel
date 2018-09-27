@extends("common.default")
<?php use App\Http\Controllers\IdController;?>
@section('css')
    .paymentTable{ background : #30849B; color : #fff; }
    table.dataTable tfoot th, table.dataTable tfoot td {
        padding: 10px 8px 6px 9px !important;
        border:none;
    }

    .paymentTable th { text-align : center !important }

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
         width: 1170px;
    }

    .com, .pay, .ocom, .opay, .osales {
        width: 170px ;
    }

    table#merchantTable
    {
        table-layout: fixed;
        max-width: none;
        width: auto;
        min-width: 100%;
    }

@stop

@section("content")
    <div class="container" style="margin-top:30px;">
        <div class="row">
            <div class="col-sm-12">
                @include('admin/panelHeading')
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div id="main">
                    <div class="">
                        <div>
                            <div class="row payment-area">
                                <div class="col-md-12">
                                    @if(Session::has('error_msg'))
                                    <div class="alert alert-danger"></span><strong> {!! session('error_msg') !!}</strong></div><br>
                                    @elseif(Session::has('success_msg'))
                                    <div class="alert alert-success"></span><strong> {!! session('success_msg') !!}</strong></div><br>
                                    @endif
                                    {{-- Merchant View Table --}}
                                    <h2>Payment: Merchant/Station</h2>
									<span  id="merchant-error-messages"></span>
                                    <br>
									@def $total_payment = 0
                                    {!! Form::open(array('url'=>'/paymerchant')) !!}
                                    <div class="tableData">
                                    <div class="table-responsive">
                                    <table class="table table-bordered" cellspacing="0" width="100%" id='merchantTable'>
                                        <thead>
                                            <tr class='paymentTable' style="background-color: black!important">
                                                <th class="nosort">No</th>
                                                <th class="nosort">User&nbsp;ID</th>
                                                <th class="text-center">Name</th>
                                                <th class="text-center">Details</th>
                                                <th class='sum nosort'>Outstanding</th>
                                                <th>Due&nbsp;Date</th>
                                                <th class="nosort" bgcolor="red">Payment</th>
                                                <th>Date Paid</th>
                                            </tr>
											@if(isset($merchants) and !is_null($merchants) and count($merchants) > 0)
												<tr class="border-less-tr">
													<th ></th>
													<th >Total</th>
													<th ></th>
													<th ></th>
													<th  class= 'nosort pay' id='pay'></th>
													<th >
														<span class="pull-left hidden subtotal">Subtotal :</span>
														<span class="pull-right hidden subtotal_amount"></span>
													</th>
													<th ></th>
													<th ></th>
													
												</tr>
											@endif
                                        </thead>
                                        @if(isset($merchants) and !is_null($merchants) and count($merchants) > 0)
                                        <input type="hidden" class='curr' value="{{$currentCurrency}}">
                                        <tfoot>
                                            <tr>
                                                <th></th>
                                                <th></th>
                                                <th ></th>
                                                <th ></th>
                                                <th ></th>
                                                <th colspan=1 >
                                                    <span class="pull-left hidden subtotal">Subtotal :</span>
                                                    <span class="pull-right hidden subtotal_amount"></span>
                                                </th>
                                                <th colspan=2 ><button class='btn btn-block btn-danger btn-sm'>Consolidate</button></th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            @def $i = 1
                                            @foreach($merchants as $merchant)
                                                <tr>
                                                    <td class='text-center'>{!! $i++ !!}</td>
                                                    
                                                    <td>
													<span class=''>
														<!--<a href="{!! route('merchantPopup', $merchant->mid) !!}">
														   [{!! IdController::nM($merchant->mid) !!}]
														</a>-->
														<a href="javascript:void(0)" class="view-merchant-modal" data-id="{{$merchant->user_id }}" data-mid="{{$merchant->mid }}"> 
                                                         
															{!! IdController::nB($merchant->user_id) !!}
														</a> 
													</span>
                                                        {{--<span class='pull-right'>{!! $merchant->name !!} </span> &nbsp; --}}
                                                    </td>
                                                    <td class='text-left'>{!! $merchant->name !!}</td>
                                                    <td class='text-center'><a target="_blank" href="{{url('/admin/payment/merchant_single/'.$merchant->mid)}}" >Details</a></td>
                                                    
                                                    <td class='pay text-right'>
														<?php 
														/*	$mc_pay = 0;
															if($merchant->mc_id > 0){
																if($merchant->mc_commission > 0){
																	$mc_pay = $merchant->mc_commission;
																} else {
																	$mc_pay = $global->mc_sales_staff_commission;
																}
															}
															$referral_pay = 0;
															if($merchant->referral_id > 0){
																if($merchant->referral_commission > 0){
																	$referral_pay = $merchant->referral_commission;
																} else {
																	$referral_pay = $global->referral_sales_staff_commission;
																}
															}
															$mcp1_pay = 0;
															if($merchant->mcp1_id > 0){
																if($merchant->mcp1_commission > 0){
																	$mcp1_pay = $merchant->mcp1_commission;
																} else {
																	$mcp1_pay = $global->mcp1_sales_staff_commission;
																}
															}															
															$mcp2_pay = 0;
															if($merchant->mcp2_id > 0){
																if($merchant->mcp2_commission > 0){
																	$mcp2_pay = $merchant->mcp2_commission;
																} else {
																	$mcp2_pay = $global->mcp2_sales_staff_commission;
																}
															}															
															$gateway_pay = $global->payment_gateway_commission;
															$logistic_pay = $global->logistic_commission;
															$payable = $merchant->payable -
																((($mc_pay/100)*$merchant->net_payable) +
																(($mcp1_pay/100)*$merchant->net_payable) +
																(($referral_pay/100)*$merchant->net_payable) +
																(($mcp2_pay/100)*$merchant->net_payable) +
																(($gateway_pay/100)*$merchant->net_payable));*/
															$total_payment += round($merchant->payable/100,2);
														?>
														<span class="pull-left">MYR</span>
                                                        {!! number_format(round($merchant->payable/100,2),2) !!}
                                                    </td>
                                                    <td class='text-center'>{!! $merchant->due !!}</td>
                                                    <td class='text-center'>
														<input 
                                                        @if(!$merchant->can_consolidate)
															@if($merchant->partial > 0)
																disabled title="Expected payment of MYR {{number_format($merchant->payable/100,2)}} has not been received. (Only a partial payment of MYR {{number_format($merchant->partial/100,2)}} has been received)"
															@else 
																disabled title="Expected payment of MYR {{number_format($merchant->payable/100,2)}} has not been received."
															@endif 
                                                        @endif 
                                                        type="checkbox" name="merchant_checked[]" value="{{$merchant->user_id}}_{{number_format($merchant->payable,0,'.','')}}_3" />
														<input type="hidden" name="merchant_payment[]" value="{{number_format($merchant->payable,0,'.','')}}" />
														<input type="hidden" name="merchant_id[]" value="{{$merchant->mid}}" />
													</td>
                                                    <td class='text-center'>{!! $merchant->rcv !!}</td>

                                                </tr>
                                            @endforeach
											
                                            @if(!empty($stations))
                                             @foreach($stations as $station)
                                                <tr>
                                                    <td class='text-center'>{!! $i++ !!}</td>
                                                    
                                                    <td>
													<span class=''>
														<!--<a href="{!! route('merchantPopup', $merchant->mid) !!}">
														   [{!! str_pad($merchant->mid, 10, '0', STR_PAD_LEFT) !!}]
														</a>-->
														<a href="javascript:void(0)" class="view-station-modal" data-id="{{$station->user_id }}" data-sid="{{$station->mid }}"> 
															[{!! str_pad($station->user_id, 10, '0', STR_PAD_LEFT) !!}]
														</a> 
													</span>
                                                        {{--<span class='pull-right'>{!! $station->name !!} </span> &nbsp; --}}
                                                    </td>
                                                    <td class='text-left'>{!! $station->name !!}</td>
                                                    <td class='text-center'><a target="_blank" href="{{url('/admin/payment/station_single/'.$station->mid)}}" >Details</a></td>
                                                    
                                                    <td class='pay text-right'>
														<?php 
														/*	$mc_pay = 0;
															if($station->mc_id > 0){
																if($station->mc_commission > 0){
																	$mc_pay = $station->mc_commission;
																} else {
																	$mc_pay = $global->mc_sales_staff_commission;
																}
															}
															$referral_pay = 0;
															if($station->referral_id > 0){
																if($station->referral_commission > 0){
																	$referral_pay = $station->referral_commission;
																} else {
																	$referral_pay = $global->referral_sales_staff_commission;
																}
															}
															$mcp1_pay = 0;
															if($station->mcp1_id > 0){
																if($station->mcp1_commission > 0){
																	$mcp1_pay = $station->mcp1_commission;
																} else {
																	$mcp1_pay = $global->mcp1_sales_staff_commission;
																}
															}															
															$mcp2_pay = 0;
															if($station->mcp2_id > 0){
																if($station->mcp2_commission > 0){
																	$mcp2_pay = $station->mcp2_commission;
																} else {
																	$mcp2_pay = $global->mcp2_sales_staff_commission;
																}
															}															
															$gateway_pay = $global->payment_gateway_commission;
															$logistic_pay = $global->logistic_commission;
															$payable = $station->payable -
																((($mc_pay/100)*$station->net_payable) +
																(($mcp1_pay/100)*$station->net_payable) +
																(($referral_pay/100)*$station->net_payable) +
																(($mcp2_pay/100)*$station->net_payable) +
																(($gateway_pay/100)*$station->net_payable));*/
															$total_payment += $station->payable;
														?>
														<span class="pull-left">MYR</span>
                                                        {!! number_format($station->payable/100,2) !!}
                                                    </td>
                                                    <td class='text-center'>{!! $station->due !!}</td>
                                                    <td class='text-center'>
														<input 
														@if(!$station->can_consolidate)
															@if($station->partial > 0)
																disabled title="Expected payment of MYR {{number_format($station->payable/100,2)}} has not been received. (Only a partial payment of MYR {{number_format($station->partial/100,2)}} has been received)"
															@else 
																disabled title="Expected payment of MYR {{number_format($station->payable/100,2)}} has not been received."
															@endif 
                                                        @endif 
														type="checkbox" name="merchant_checked[]" value="{{$station->user_id}}_{{number_format($station->payable,0,'.','')}}_11" />
														<input type="hidden" name="merchant_payment[]" value="{{number_format($station->payable,0,'.','')}}" />
														<input type="hidden" name="merchant_id[]" value="{{$station->mid}}" />
													</td>
                                                    <td class='text-center'>{!! $station->rcv !!}</td>
                                                    
                                                    
                                                </tr>
                                            @endforeach
                                            @endif
                                        </tbody>
                                        @endif
                                    </table>
                                    </div>
                                    </div>
                                    {!! Form::close() !!}
									<input type="hidden" id="total_payment" value="{{number_format($total_payment,2)}}" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br><br>
    </div>

    <!-- Order Modal -->
    <div class="modal fade myModal" id="orderModal" role="dialog">
        <div class="modal-dialog modal-fullscreen">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button id='orderClose' type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">
                        <h3>Order</h3>
                    </h4>
                </div>
                <div class='modal-body'>

                </div>
                <div class="modal-footer" style='border:none'>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Modal -->
    <div class="modal fade myModal" id="productModal" role="dialog">
        <div class="modal-dialog modal-fullscreen">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button id='productClose' type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">
                        <h3>Product/Voucher</h3>
                    </h4>
                </div>
                <div class='modal-body'>

                </div>
                <div class="modal-footer" style='border:none'>
                </div>
            </div>
        </div>
    </div>

    <style type="text/css">
        .border-less-tr th{
            border: 0 !important; 
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('#merchantTable, #orderTable').DataTable({
                'aoColumnDefs': [ { "bSortable": false, "aTargets": [] } ],
                "orderCellsTop": true
            });

            $('table th:first').removeClass('sorting_asc');

            var currency = $('.curr').val();
			var total_payment = $("#total_payment").val();
            $('.com, #pay').append("<span class='pull-left'>"+ currency +"</span><span class='pull-right'>"+ total_payment +"</span>");

            $('.uid').on('change', function(){
                total = 0;
                $('.uid:checked').each(function(){
                    amount = parseFloat($(this).attr('data'));
                    total = total + parseFloat(amount);
                })

                if(total > 0){
                    $('.subtotal').removeClass('hidden');
                    $('.subtotal_amount').removeClass('hidden').text(currency + ' ' + total);
                }else{
                    $('.subtotal').addClass('hidden');
                    $('.subtotal_amount').addClass('hidden');
                }
            })

            $('.merchant_id').click(function(){
                $('body').css('padding','0px');
                var route = $(this).attr('data-val');
                $.ajax({
                    type : "GET",
                    url : route,
                    success : function(response){
                        $('#orderModal').find('.modal-body').html(response);
                        $('#orderModal').modal('show');
                    }
                })
            });
			
			setTimeout(function(){
				$('.alert').hide("slow");
			}, 4000);
        });

$('.view-merchant-modal').click(function(){

var id=$(this).attr('data-id');
var mid=$(this).attr('data-mid');
var check_url=JS_BASE_URL+"/admin/popup/lx/check/merchant/"+mid;
$.ajax({
	url:check_url,
	type:'GET',
	success:function (r) {
	console.log(r);
	
	if (r.status=="success") {
	var url=JS_BASE_URL+"/admin/popup/merchant/"+mid;
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

$('.view-station-modal').click(function(){

var id=$(this).attr('data-id');
var sid=$(this).attr('data-sid');
var check_url=JS_BASE_URL+"/admin/popup/lx/check/station/"+sid;
$.ajax({
	url:check_url,
	type:'GET',
	success:function (r) {
	console.log(r);
	
	if (r.status=="success") {
	var url=JS_BASE_URL+"/admin/popup/station/"+sid;
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

    @yield('left_sidebar_scripts')

@stop


