<style type="text/css">
    .table-nonfluid {
        width: 57% !important;
    }
</style>
@extends("common.default")
<?php use App\Http\Controllers\UtilityController;
use App\Http\Controllers\IdController;
?>
@section("content")
    <div class="container"><!--Begin main cotainer-->
        <div class="row">
            <div class="col-sm-12" style="padding-top:20px;">
                <div class="col-sm-12" style="">
                    <p style="font-size:20px;"><span>Home </span> > <span> Station</span> ><span style="color:#777"
                                                                                                 class='title'>Purchase Order</span>
                    </p>
                </div>
            </div>
            {{--<div class="col-sm-11 col-sm-offset-1">--}}
                <div class="col-sm-12">
                    {{-- <div class="row">
                        <h1 class='title'>Delivery Order</h1>
                     <hr>
                </div> --}}
                </div>
                <div class="col-sm-12 form-horizontal" style="margin: 2% 0;">
                @if(isset($deliveryorder))
                        <input type="hidden" value="{{$deliveryorder->id}}" id="deliveryid"/>
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-4 col-sm-offset-4 text-center">
                                    <b>{{$array_delivery[0]['oshop_name']}}</b></div>
                                <div class="col-sm-2"></div>
                                <div class="col-sm-2">

                                    <a href="{{url()."/download/podi/pdf/".$deliveryorderid}}"
                                       class="btn btn-primary btn-info pull-right"><span
                                                class="glyphicon glyphicon-download-alt"></span> Download</a>

                                </div>
                            </div>
                            <div class="row">
                                {{-- Buyer --}}
                                <div class="col-sm-4"></div>
                                {{--B ENDS  --}}
                                <div class="col-sm-4">
                                    <p style="text-align: center;">
                                        {{$array_delivery[0]['merchant_name']}}
                                        <br>
                                        {{$array_delivery[0]['mbiz']}}
                                        <br>
                                        @if($array_delivery[0]['oshop_address_id'] == 0)
                                            @if($array_delivery[0]['user_address'] != "")
                                                {{$array_delivery[0]['user_address']}}
                                                <br>
                                            @endif
                                            @if($array_delivery[0]['line2'] != "")
                                                {{$array_delivery[0]['line2']}}
                                                <br>
                                            @endif
                                            @if($array_delivery[0]['line3'] != "")
                                                {{$array_delivery[0]['line3']}}
                                            @endif
                                        @else

                                            @if($array_delivery[0]['muser_address'] != "")
                                                {{$array_delivery[0]['muser_address']}}
                                                <br>
                                            @endif
                                            @if($array_delivery[0]['mline2'] != "")
                                                {{$array_delivery[0]['mline2']}}
                                                <br>
                                            @endif
                                            @if($array_delivery[0]['mline3'] != "")
                                                {{$array_delivery[0]['mline3']}}
                                            @endif


                                        @endif
                                        <br>GST Reg. No:
                                        {{$array_delivery[0]['merchant_gst']}}
                                    </p>
                                </div>
								<div class="col-sm-4">
									<br>
									<?php 
										
										$qr = DB::table('deliveryinvoiceqr')->join('qr_management','qr_management.id','=','deliveryinvoiceqr.qr_management_id')
										->where('deliveryinvoice_id',$array_delivery[0]['original_id'])->orderBy('deliveryinvoiceqr.id','DESC')->first();
									?>
									@if(!is_null($qr))
										<img src="{{URL::to('/')}}/images/qr/deliveryinvoice/{{$array_delivery[0]['original_id']}}/{{$qr->image_path}}.png" style="margin-right:-10px;" class="pull-right"  width="120px" />
									@endif									
								</div>
                            </div>
                            @endif
                        </div>
                        {{-- EXTRA DIV --}}
                        <div class="row">
                            {{-- <div class="col-sm-5"></div> --}}


                        </div>
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-4" style="padding-right: 23px !important; padding-left: 23px !important;">
                                    @if($buyer->name != ""){{$buyer->name}}
                                    <br>
                                    @endif
                                    @if($buyer->line1 != "")
                                        {{$buyer->line1}}
                                        <br>
                                    @endif
                                    @if($buyer->line2 != "")
                                        {{$buyer->line2}}
                                        <br>
                                    @endif
                                    @if($buyer->line3 != "")
                                        {{$buyer->line3}}
                                    @endif
                                    <br>
                                    Malaysia - {{$buyer->postcode}}


                                </div>
                            </div>
                            {{--<div class="row">--}}
                                {{--<div class="col-sm-4 col-sm-offset-4 text-center"--}}
                                     {{--style="font-size: 20px;"><br>--}}
                                    {{--<b>Delivery Order</b></div>--}}
                            {{--</div>--}}
                        </div>
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-12" style="padding-right: 23px !important; padding-left: 23px !important;">

                                    <b>Date: </b>
                                    {{UtilityController::s_date($array_delivery[0]['orderdate'])}}
                                    {{--<span class="pull-right">--}}
                                        {{--<b>Tax&nbsp;Invoice&nbsp;No:</b>&nbsp;{{str_pad($array_delivery[0]['merchantrecno'],10,"0",STR_PAD_LEFT)}}--}}
                                    {{--</span>--}}
                                </div>
                            </div>

                        </div>

						{{--
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-6" style="padding-bottom: 10px;">
                                    <div class="" style="vertical-align: middle;margin-top: 10px;">

                                        &nbsp;
                                    </div>

                                </div>
                                @if(isset($deliveryorder))
                                    @if($deliveryorder->status != 'b-collected')
                                        <div class="col-sm-6 pull-right">
                                            <div class="">
                                                <div class="col-sm-6 col-md-offset-4">
                                                    <div class="row">
                                                        <input type="password" class="form-control"
                                                               name="orderpassworld" id="orderpassworld"
                                                               placeholder="Order Password"/ style="margin-left:-15px;">
                                                    </div>
                                                </div>
                                                <div class="col-sm-2" style="padding-right: 23px !important; padding-left: 23px !important;">
                                                    <div class="row">
                                                        <input type="submit" id="submitpassword" class="btn btn-green pull-right"
                                                               style="font-size: 1.0em; margin-left:-8px;margin-bottom:10px;"
                                                               value="Confirm" onclick="processdelivery();"/>
                                                    </div>

                                                </div>
                                                <div class="col-sm-6 col-sm-offset-6">
                                                    <p style="color: red; display: none;" id="wrong">
                                                        Wrong password, please try again.</p>
                                                    <p style="color: green; display: none;" id="success">
                                                        Order successfully confirmed!</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
						--}}

                        <input type="hidden" id="mporder_id" value="{{$deliveryorderid}}"/>
                        <div class="col-sm-12">

                            <table class="table">
                                <tr>
                                    <td colspan="2" class="text-left" style="height: 50px; vertical-align: inherit">
                                        <b>Order ID:</b>{{IdController::nO($deliveryorderid) }}
                                    </td>
                                    <td colspan="2" class="text-center" style="font-size: 25px; vertical-align: inherit">
                                        <b>Purchase Order</b>
                                    </td>
									
                                    <td  style="height: 50px; vertical-align: inherit">
                                        <b class="pull-right">Purchase Order&nbsp;No:</b>&nbsp;<br>
                                    </td>
									<td class="text-right" style="height: 50px; vertical-align: inherit">
										{{str_pad($array_delivery[0]['merchantrecno'],10,"0",STR_PAD_LEFT)}}
									</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;background:#666666;color:#ffffff;">
                                    <th class="text-center">No</th>
                                    <th class="text-center">Product&nbsp;ID</th>
                                    <th>Description</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-right">Unit&nbsp;Price</th>
                                    <th class="text-right">Amount</th>
                                </tr>
                                <?php $counter = 1; $sum_qty = 0;
                                $sum_amount = 0;
                                $glob = DB::table('global')->first()->gst_rate;
								$tproducts = DB::table('ordertproduct')->where('porder_id',$deliveryorderid)->get();
                                ?>

                                @if(isset($tproducts))
                                    @foreach($tproducts as $product)
                                            <tr>
                                                <?php
                                                $prime_product = DB::table('tproduct')->where('id', $product->tproduct_id)->first();
                                                //$parent_product = DB::table('product')->where('id', $prime_product->parent_id)->first();
                                                ?>
                                                <td class="text-center">{{ $counter++ }}</td>
                                                <td class="text-center">{{ IdController::nTp($product->tproduct_id) }}</td>
                                                <td>{{ $prime_product->name }}</td>
                                                <td class="text-center">{{ $product->quantity or 0 }}</td>
                                                <td class="text-right">

                                                    <?php
                                                    //$op = DB::table('orderproduct')->where('porder_id', $deliveryorderid)->where('product_id', $prime_product->id)->first();

                                                  //  if (!is_null($op)) {


                                                        $delp = $product->order_delivery_price;
                                                        $opc = $product->order_price;
                                                        $tempTotal = $delp + ($opc * $product->quantity);
                                                        $revenue = number_format($tempTotal / 100, 2);

                                                        $totalPaid = ($product->quantity * $opc);
                                                        $amount = number_format($totalPaid / 100, 2);
                                                /*    } else {
                                                        $revenue = number_format(($parent_product->retail_price / 100), 2, ".", "");
                                                        $amount = number_format((($product->quantity * $parent_product->retail_price) / 100), 2, ".", "");
                                                    }*/
                                                    $sum_qty += $product->quantity;
                                                    $sum_amount += $tempTotal;
                                                    // $sum_amount = number_format($sum_amount, 2, '.', '');
                                                    ?>
                                                    {{$currency}} {{number_format($opc/100,2)}}
                                                </td>
                                                <td class="text-right">{{$currency}} {{ number_format($totalPaid/100,2)}}</td>
                                                <?php

                                                $status = DB::table('deliveryinvoicetproduct')->
                                                where('tproduct_id', $prime_product->id)->
                                                where('di_id', $deliveryorder->id)->first();


                                                $checked = "";
                                                $disabled = "";
                                                if ($status == "b-collected") {
                                                    $checked = "checked";
                                                    $disabled = "disabled";
                                                }
                                                ?>

                                            </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td class="pull-left">Delivery</td>
                                            <td></td>
                                            <td></td>
                                            <td class="pull-right">{{$currency}}
                                                &nbsp;{{number_format($delp/100,2)}}</td>
                                        </tr>
                                    @endforeach
                                    <tr style="border-bottom: 1px solid #ddd;border-top: 1px solid #ddd;">
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        {{-- <td></td> --}}
                                        <?php
                                        // $aux = ($sum_amount*6)/100;
                                        $total = $sum_amount;
                                        $rawTotal = $total / (1 + ($glob / 100));
                                        $gstTotal = $total - $rawTotal;
                                        ?>
                                        <td class="pull-right">
                                            <b>Total&nbsp;{{$currency}}&nbsp;{{number_format($sum_amount/100,2) }}
                                            </b></td>

                                    </tr>
                                @endif
                            </table>
                        </div>
                        <div class="col-sm-12 text-right" style="padding-right: 23px !important; padding-left: 23px !important; padding-bottom: 20px;">
                            <table style="float:right;text-align:right;">
                                <tr>
                                    <td style="padding-right: 10px">
                                        Total&nbsp;includes&nbsp;{{$gst[0]->gst_rate}}% GST
                                    </td>
                                    <td>{{$currency}}&nbsp;{{number_format($gstTotal/100,2)}}</td>
                                </tr>
                                <tr>
                                    <td style="padding-right: 10px">Items&nbsp;Total</td>
                                    <td>{{$currency}}&nbsp;{{ number_format($rawTotal/100,2) }}</td>
                                </tr>
                            </table>
                        </div>
            </div>

        </div>
    </div><!--Begin main cotainer-->
    <style>
        .table > tbody > tr > td {
            border-top: 0px solid #ddd;
        }
    </style>


    <script type="text/javascript">

        /*	Paul on 07 April 2017 at 12AM	*/
        $("#chkSelectAll").click(function () {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });

        function processdelivery() {
            var items = [];
            $("input:checkbox:checked").each(function () {
                items.push($(this).attr('value'));
            });

            console.log(items);
            if (items.length > 0) {
                jQuery.ajax({
                    type: "POST",
                    url: "{{ url('deliveryinvoice/process')}}",
                    data: {
                        items: items,
                        porder_id: $('#mporder_id').val(),
                        password: $('#orderpassworld').val().trim()
                    },
                    beforeSend: function () {
                    },
                    success: function (response) {
                        console.log(response);
                        if (response == 1) {
                            toastr.info("Password matched. Thank you for the purchase");
                            window.location.reload();

                        } else if (response == -1) {
                            toastr.warning("Password do not match. Please try again");
                        } else {
                            toastr.error("An unexpected error ocurred. Please try again or contact OpenSupermall Support");
                        }
                    }
                });
            } else {
                toastr.warning("Please select the products!");
            }

        }

    </script>

@stop
