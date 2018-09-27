@extends("common.default")

@section("content")
<!--
<link href="{{url('assets/jqGrid/ui.jqgrid.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{url('css/datatable.css')}}" rel="stylesheet" type="text/css"/>
-->
<style>
    .details-control, .details-control-2 {
        cursor: pointer;
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

    .child_table {
        margin-left: 78px;
        width: 920px;;
    }

    table
    {
        counter-reset: Serial;
    }

    table.counter_table tr td:first-child:before
    {
        counter-increment: Serial;      /* Increment the Serial counter */
        content: counter(Serial); /* Display the counter */
    }
</style>
    <section class="">
        <div class="container"><!--Begin main cotainer-->
            <div class="row">
                <div data-spy="scroll" style="display: none;" class="static-tab">
                    <div class="text-center tab-arrow">
                        <span class="fa fa-sort"></span>
                    </div>
                    <ul class="nav nav-pills nav-stacked">
                        <li role="presentation" class="active floor-navigation"><a href="#dashboard">Dashboard</a></li>
                        <li role="presentation" class="floor-navigation"><a href="#autolink">AutoLink</a></li>
                        <li role="presentation" class="floor-navigation"><a href="#auctions">Auctions</a></li>
                        <li role="presentation" class="floor-navigation"><a href="#loyalty">Loyalty</a></li>
                        <li role="presentation" class="floor-navigation"><a href="#sales">Sales</a></li>
                        <li role="presentation" class="floor-navigation"><a href="#inventory">Inventory</a></li>
                    </ul>
                </div>
                <div class="col-sm-11 col-sm-offset-1">
                    <img src="/images/banner.png" title="banner" class="img-responsive banner">
                    <hr>

                    <form class="form-horizontal">
                        <div id="dashboard" class="row">

                            <div class="col-sm-12"><h1>STATION DASHBOARD</h1></div>
                            <div class="table-responsive col-sm-12 ">

                                <table class="table text-muted " id="product_details_table">
                                    <thead>
                                    <tr class="bg-black">
                                        <th colspan="11">Product Details</th>
                                    </tr>
                                    <tr class="bg-black">
                                        <th>No</th>
                                        <th>Order ID</th>
                                        <th>Product ID</th>
                                        <th>Order Received</th>
                                        <th>Order Executed</th>
                                        <th>SKU</th>
                                        <th>Description</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>User ID</th>
                                        <th>Source</th>
                                    </tr>
                                    <thead>
                                    <tbody>
                                    @if(! empty($orders))
                                
                                    @foreach($orders as $order )
                                        <tr
										{{ ($i = 0) ? '': '' }}
                                        @foreach($order->products as $pro)
											{{$i++}}
                                            data-id-{{$i}}="{{$pro->id}}"
                                            data-name-{{$i}}="{{$pro->name}}"
                                            data-des-{{$i}}="{{$pro->category->description}}"
                                            data-qty-{{$i}}="{{$pro->pivot->quantity}}"
                                            data-price-{{$i}}="{{$pro->retail_price}}"
                                            data-total-{{$i}}="{{$pro->retail_price*$pro->pivot->quantity}}"
                                        @endforeach
                                                data-last="{{$i}}"
                                        >
                                            <td>1</td>
                                            <td>{{$order->id}}</td>
                                            <td>{{$order->created_at}}</td>
                                            <td>{{$order->checkout_tstamp}}</td>
                                            <td>{{$order->products[rand(1, 3)]->specification->first()->name}}</td>
                                            <td>{{$order->user->first_name.' '.$order->user->last_name}}</td>
                                            <td>{{$order->orderTotal($order)}}</td>
                                        </tr>
                                    @endforeach
                                    @endif
                                    
                                    </tbody>
                                </table>
                            </div>

                            <div class="table-responsive col-sm-5 ">
                                <table class="table text-muted counter_table" id="shipping_details_table">
                                    <thead>
                                    <tr class="bg-move">
                                        <th colspan="10">Shipping Details</th>
                                    </tr>
                                    <tr class="bg-move">
                                        <th>No</th>
                                        <th>Order ID</th>
                                        <th>Shipping ID</th>
                                        <th>Company</th>
                                        <th>Date since order</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(! empty($orders))

                                    @foreach($orders as $order )
                                        <tr>
                                            <td></td>
                                            <td>{{$order->id}}</td>
                                            <td>S{{$order->courier->shipping_id}}</td>
                                            <td>{{$order->courier->name}}</td>
                                            <td>{{$order->courier->created_at}}</td>
                                        </tr>
                                    @endforeach
                                    @endif
                                    </tbody>
                                </table>

                            </div>


                            <div class="table-responsive col-sm-7 ">
                                <table class="table text-muted counter_table" id="payment_detail_products">
                                    <thead>
                                    <tr class="bg-info">
                                        <th colspan="10">Product Payment Details</th>
                                    </tr>
                                    <tr class="bg-info">
                                        <th>No</th>
                                        <th>Order ID</th>
                                        <th>Receivable</th>
                                        <th>Commission</th>
                                        <th>%</th>
                                        <th>Day since Consignment</th>
                                        <th>Note</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(! empty($orders))

                                    @foreach($orders as $order )
                                        <tr>
                                            <td></td>
                                            <td>{{$order->id}}</td>
                                            <td>{{$order->payment->receivable}}</td>
                                            <td>{{$order->payment->osmall_commission}}</td>
                                            <td></td>
                                            <td>{{$order->payment->consignment}}</td>
                                            <td>{{$order->payment->note}}</td>
                                        </tr>
                                    @endforeach
                                    @endif
                                    </tbody>

                                </table>

                            </div>
                            <div class="clearfix"> </div>



                            <div class="table-responsive col-sm-12 ">
                                <table class="table text-muted counter_table" id="open_wish_table">
                                    <thead>
                                    <tr class="bg-pink">
                                        <th colspan="14">Open Wish Database</th>
                                    </tr>
                                    <tr class="bg-pink">
                                        <th colspan="8">Product Details</th>
                                        <th colspan="2">Time Detail</th>
                                        <th colspan="4">Payment Detail</th>
                                    </tr>
                                    <tr class="bg-pink">
                                        <th>No</th>
                                        <th>OpenWish ID</th>
                                        <th>UserID (Buyer)</th>
                                        <th>User</th>
                                        <th>Product ID</th>
                                        <th>Date Stated</th>
                                        <th>Description</th>
                                        <th>Price</th>
                                        <th>Time</th>
                                        <th>Time Left</th>
                                        <th>Pledge</th>
                                        <th>Balance</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(! empty($openWishes))
                                    @foreach($openWishes as $openWish)
                                    <tr>
                                        <td></td>
                                        <td>{{$openWish->id}}</td>
                                        <td>{{$openWish->user_id}}</td>
                                        <td>{{$openWish->user->first_name.' '.$openWish->user->last_name}}</td>
                                        <td>{{$openWish->product_id}}</td>
                                        <td>{{$openWish->created_at}}</td>
                                        <td></td>
                                        <td>{{$openWish->product->retail_price}}</td>
                                        <td>{{$openWish->duration}} days</td>
                                        <td>{{dateDiff(\Carbon\Carbon::now(), \Carbon\Carbon::parse($openWish->created_at)->addDays($openWish->duration))}}</td>
                                        <td>{{$currency->code}} {{$openWish->pledgeAmount()}}</td>
                                        <td>{{$currency->code}} {{$openWish->pledgeAmount() - $openWish->product->retail_price}}</td>
                                        <td>Pending</td>
                                        <td width="80">
                                            <span class="badge badge-help">Help</span>
                                            <a onclick="$(this).parent().parent().remove();" class="pull-right"><i class="glyphicon glyphicon-remove text-danger"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>

                            <div class="table-responsive col-sm-12">
                                <table class="table text-muted counter_table " id="auto_link_table">
                                    <thead>
                                    <tr class="bg-darkgreen">
                                        <th colspan="3">AutoLink Database</th>
                                        <th colspan="4">initiator</th>
                                        <th colspan="4">Responder</th>
                                    </tr>
                                    <tr class="bg-darkgreen">
                                        <th>NO</th>
                                        <th>AutoLink ID</th>
                                        <th>Mode</th>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Bought</th>
                                        <th>Sold</th>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Bought</th>
                                        <th>Sold</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(! empty($autoLinks))
                                    @foreach($autoLinks as $autolink)

                                    <tr>
                                        <td></td>
                                        <td>{!! $autolink->id !!}</td>
                                        <td>{!! $autolink->mode !!}</td>

                                        <td>{!! $autolink->user_id !!}</td>
                                        <td>@if($autolink->type === 'merchant')
                                                @foreach($autolink->user->merchant as $name)
                                                {!! $name->oshop_name!!}
                                                @endforeach
                                            @else
                                                {!! $autolink->user->first_name !!}
                                                {!! $autolink->user->last_name !!}
                                            @endif</td>
                                        <td>{!! $autolink->bought !!}</td>
                                        <td>{!! $autolink->sold !!}</td>
                                        <td>
                                            <h6 style="display: none">{{$res = findResponder($autolink->id)}}</h6>

                                            {!! $res->id !!}
                                        </td>
                                        <td>{!! $res->user->first_name !!}
                                            {!! $res->user->last_name !!}
                                        </td>

                                        <td>{!! $res->bought !!}</td>
                                        <td>{!! $res->sold !!}</td>
                                    </tr>

                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="table-responsive col-sm-12 ">
                                <table class="table text-muted counter_table" id="auto_link_table_2">
                                    <thead>
                                    <tr class="bg-darkgreen">
                                        <th colspan="11">AutoLink Database</th>
                                    </tr>
                                    <tr class="bg-darkgreen">
                                        <th>No</th>
                                        <th>AutoLink ID</th>
                                        <th>ID</th>
                                        <th>Category</th>
                                        <th>SubCategory</th>
                                        <th>Target</th>
                                        <th>Linked Since</th>
                                        <th>Status</th>
                                        <th colspan="2">Type</th>
                                        <th>Merchant Remarks</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(! empty($autoLinks))
                                        @foreach($autoLinks as $autolink)
                                        @foreach($autolink->wholesales as $wholesale)
                                    <tr>
                                    <td></td>
                                    <td>{!! $autolink->id !!}</td>
                                    <td>{!! $wholesale->id!!}</td>
                                    <td>{!! $wholesale->product->category->name !!}</td>

                                    <td>{!! $wholesale->product->subCategory->name or 'Spare Parts'  !!}</td>
                                    <td>{!! $wholesale->unit !!}</td>
                                    <td>{!! $autolink->created_at !!}</td>
                                    <td>{!! $autolink->status !!}</td>
                                    <td>{!! $autolink->type !!} </td>
                                    <td><a class="btn-darkgreen">Unlink</a> <i onclick="$(this).parent().parent().remove();" class="glyphicon glyphicon-remove text-danger"></i></td>
                                    <td>{!! $autolink->remarks !!}</td>
                                    </tr>
                                        @endforeach
                                    @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>

                        </div>

                        <hr>
                        <div id="autolink" class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <a class="btn btn-darkgreen" href="#" style="float:left;"><i
                                            class="bt glyphicon glyphicon-link" style="padding: 6px 0"></i> AutoLink</a>
                                <div class="input-group input-group-sm btn btn-darkgreen">
                                    <input type="text" placeholder="Tech_" class="form-control">
                                      <span class="input-group-btn">
                                        <button type="button" class="btn btn-darkgreen"><span class="glyphicon glyphicon-triangle-right"></span></button>
                                      </span>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                {{--<a class="btn btn-darkgreen" href="#" style="float:left;"><i--}}
                                            {{--class="bt glyphicon glyphicon-link" style="padding: 6px 0"></i> Others:</a>--}}
                                {{--<div class="input-group input-group-sm btn btn-darkgreen">--}}
                                        {{--<input type="text" placeholder="fill in the blank" class="form-control">--}}
                                      {{--<span class="input-group-btn">--}}
                                        {{--<button type="button" class="btn btn-darkgreen"><span class="glyphicon glyphicon-triangle-right"></span></button>--}}
                                      {{--</span>--}}
                                {{--</div>--}}
                                {{--<div class="clearfix margin-top"></div>--}}
                                {{--<select multiple class="select-darkgreen  form-control" style="font-family: FontAwesome">--}}
                                    {{--<option class="active" onclick="$(this).remove();">&#xf00d; Architect</option>--}}
                                    {{--<option onclick="$(this).remove();">&#xf00d; Interior Designer</option>--}}
                                {{--</select>--}}
                            </div>

                            <div class="clearfix"></div>

                        </div>


                        <hr>

                        <div id="sales" class="row">
                            <div class="col-xs-12 margin-top">
                                <a class="btn btn-sale col-sm-3" href="#"><i class="fa fa-line-chart"></i> Sales Report</a>
                            </div>  <div class="clearfix"></div>

                            <div class="col-xs-12 margin-top">
                                <script>

                                    $(function () {
                                        $('#container').highcharts({
                                            title: {
                                                text: 'Monthly Sales Report',
                                                x: -20 //center
                                            },
                                            subtitle: {
                                                text: '2015',
                                                x: -20
                                            },
                                            xAxis: {
                                                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                                                    'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
                                            },
                                            yAxis: {
                                                title: {
                                                    text: 'Sales'
                                                },
                                                plotLines: [{
                                                    value: 0,
                                                    width: 1,
                                                    color: '#718DA3'
                                                }]
                                            },
                                            tooltip: {
                                                valueSuffix: ''
                                            },
                                            legend: {
                                                layout: 'vertical',
                                                align: 'right',
                                                verticalAlign: 'middle',
                                                borderWidth: 0
                                            },
                                            series: [{
                                                name: '',
                                                data: [
                                                    @if(! empty($all))
                                                        @foreach(amountCountMonthly(2015,$all) as $key => $val)
                                                            {!! $val !!},
                                                        @endforeach
                                                    @endif
                                                    ]
                                            }]
                                        });
                                    });

                                </script>
                                <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                            </div>
                            <div class="col-sm-7">
                                <div class="table-responsive">
                                    <table class="table table-striped ">
                                        <tr>
                                            <th nowrap>Custom Date Range</th>
                                            <th>From</th>
                                            <th><input type="text" placeholder="yy/mm/dd" id="datetimepicker" class="date form-control bg-sale"></th>
                                            <th>To</th>
                                            <th><input type="text" placeholder="yy/mm/dd" id="datetimepickerr" class="date form-control bg-sale"></th>
                                        </tr>
                                        <tr>
                                            <td>Since</td>
                                            <td><span id="dateSince"></span></td>
                                            @if(! empty($currency)) 
                                            <td colspan="3">{{$currency->code}} <span id="amountSince"></span></td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td>Year to Date</td>
                                            <td></td>
                                            @if(! empty($currency))
                                            <td colspan="3">{{$currency->code}} <span id="amountBetween"></span></td>
                                            @endif
                                        </tr>

                                    </table>


                                </div>

                                <div class="faqs col-sm-8 row">
                                    <h4>Years</h4>
                                    <div class="faqs-head">
                                        <span class="col-xs-3">2015</span>
                                        <span class="col-xs-6">@if(! empty($currency)){{$currency->code}}@endif @if(! empty($all)){!! amountCountYear(2015,$all) !!}@endif</span>
                                        <span class="col-xs-3"> <a data-target="#faqs1" data-toggle="collapse" class="btn btn-search pull-right collapsed" aria-expanded="false">
                                                <span class="glyphicon glyphicon-collapse-down"></span>
                                            </a> </span>
                                        <div class="clearfix"></div>

                                    </div>
                                    <div id="faqs1" class="collapse in" style="" aria-expanded="true">

                                        <table class="table">
                                            @if(! empty($all))
                                            @foreach(amountCountMonthly(2015,$all) as $key => $val)
                                                <tr><td>{!! date("F", mktime(0, 0, 0, $key, 10)) !!} </td><td>{!! $val !!}</td></tr>
                                            @endforeach
                                            @endif
                                        </table>
                                    </div>

                                    <div class="faqs-head">
                                        <span class="col-xs-3">2016</span>
                                        <span class="col-xs-6">@if(! empty($currency)){{$currency->code}}@endif @if(! empty($all)){!! amountCountYear(2016,$all) !!}@endif</span>
                                        <span class="col-xs-3"> <a data-target="#faqs2" data-toggle="collapse" class="btn btn-search pull-right collapsed" aria-expanded="false">
                                                <span class="glyphicon glyphicon-collapse-down"></span>
                                            </a> </span>
                                        <div class="clearfix"></div>

                                    </div>
                                    <div class="collapse" id="faqs2" aria-expanded="false" style="height: 0px;">

                                        <table class="table">
                                            @if(! empty($all))
                                            @foreach(amountCountMonthly(2016,$all) as $key => $val)
                                                <tr><td>{!! date("F", mktime(0, 0, 0, $key, 10)) !!} </td><td>{!! $val !!}</td></tr>
                                            @endforeach
                                            @endif
                                        </table>
                                    </div>
                                    <div class="faqs-head">
                                        <span class="col-xs-3">2017</span>
                                        <span class="col-xs-6">@if(! empty($currency)){{$currency->code}}@endif @if(! empty($all)){!! amountCountYear(2017,$all) !!}@endif</span>
                                        <span class="col-xs-3"> <a data-target="#faqs3" data-toggle="collapse" class="btn btn-search pull-right collapsed" aria-expanded="false">
                                                <span class="glyphicon glyphicon-collapse-down"></span>
                                            </a> </span>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="collapse" id="faqs3" aria-expanded="false" style="height: 0px;">
                                        <table class="table">
                                            @if(! empty($all))@foreach(amountCountMonthly(2017,$all) as $key => $val)
                                                <tr><td>{!! date("F", mktime(0, 0, 0, $key, 10)) !!} </td><td>{!! $val !!}</td></tr>
                                            @endforeach
                                            @endif
                                        </table>
                                    </div>
                                    <div class="faqs-head">
                                        <span class="col-xs-3">2018</span>
                                        <span class="col-xs-6">@if(! empty($currency)){{$currency->code}}@endif @if(! empty($all)){!! amountCountYear(2018,$all) !!}@endif</span>
                                        <span class="col-xs-3"> <a data-target="#faqs4" data-toggle="collapse" class="btn btn-search pull-right collapsed" aria-expanded="false">
                                                <span class="glyphicon glyphicon-collapse-down"></span>
                                            </a> </span>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="collapse" id="faqs4" aria-expanded="false" style="height: 0px;">
                                        <table class="table">
                                            @if(! empty($all))
                                            @foreach(amountCountMonthly(2018,$all) as $key => $val)
                                                <tr><td>{!! date("F", mktime(0, 0, 0, $key, 10)) !!} </td><td>{!! $val !!}</td></tr>
                                            @endforeach
                                            @endif
                                        </table>
                                    </div>



                                </div>
                            </div>
                            <div class="col-sm-4 col-sm-offset-1" >

                                <div style="border:1px solid #718DA3">
                                    <div class="col-xs-6" >
                                        <p>Max</p>
                                        <p>Min</p>
                                        <p>Average/Day</p>
                                        <p>Average/Deal</p>
                                        <p>Viewed</p>
                                    </div>
                                    <div class="col-xs-6 bg-sale " style="text-align: right;">
                                        <p>@if(! empty($currency)){{$currency->code}}@endif @if(! empty($all)){{Helper::getMaxVal(amountCountMonthly(2015,$all))}}@endif</p>
                                        <p>@if(! empty($currency)){{$currency->code}}@endif @if(! empty($all)){{Helper::getMinVal(amountCountMonthly(2015,$all))}}@endif</p>
                                        <p>@if(! empty($currency)){{$currency->code}}@endif @if(! empty($all)){{Helper::getAvgDaySale(2015, amountCountMonthly(2015,$all))}}@endif</p>
                                        <p>@if(! empty($currency)){{$currency->code}}@endif @if(! empty($all_pro)){{Helper::getAvgDeal($all_pro)}}@endif</p>
                                        <p>@if(! empty($all_pro)){{Helper::getTotalView($all_pro)}}@endif</p>

                                    </div>
                                    <div class="clearfix"></div>

                                </div>
                            </div>
                        </div>
                        <hr>

                        <div id="inventory" class="row">

                            <div class="col-xs-12 margin-top">
                                <a class="btn btn-gold col-sm-3" href="#"><i class="fa fa-line-chart"></i> Inventory Report</a>
                            </div>  <div class="clearfix"></div>

                            <div class="table-responsive col-sm-12">
                                <table class="table text-muted counter_table" id="lower_product_detail_table">
                                    <thead>
                                    <tr class="bg-gold">
                                        <th colspan="10">Products Details</th>
                                        <th class="bg-lightgold" colspan="2">Wholesale</th>
                                        <th class="bg-lightgold" colspan="5">&nbsp;</th>
                                    </tr>

                                    <tr class="bg-gold"> 
                                        <th style="vertical-align:middle">No</th>
                                        <th style="vertical-align:middle">SKU</th>
                                        <th style="vertical-align:middle">Name</th>
                                        <th style="vertical-align:middle">Category</th>
                                        <th style="vertical-align:middle">SubCategory</th>
                                        <th style="vertical-align:middle">Description</th>
                                        <th style="vertical-align:middle">Quantity</th>
                                        <th style="vertical-align:middle">Retail Price&nbsp;(RM)</th>
                                        <th style="vertical-align:middle">Original Price&nbsp;(RM)</th>
                                        <th style="vertical-align:middle">Discount%</th>

                                        <th class="bg-lightgold">Price</th>
                                        <th class="bg-lightgold">Unit</th>

                                        <th class="bg-lightgold">Viewed</th>
                                        <th class="bg-lightgold">Bought</th>
                                        <th class="bg-lightgold">Type</th>
                                        <th class="bg-lightgold">Source</th>
                                        <th class="bg-lightgold">Dealers</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @if(! empty($all_pro))
                                        @foreach($all_pro as $product)
                                    <?php
                                      $rp = ($product->retail_price) /100;
                                      $op = ($product->original_price) /100;
                                    ?>
                                        <tr>
                                            <td></td>
                                            <td>{{$product->specification->first()->name}}</td>
                                            <td>{{$product->name}}</td>
                                            <td>{{$product->category->description}}</td>
                                            <td>{{$product->category->name}}</td>
                                            <td>{{$product->name}}</td>
                                            <td>{{$product->available}}</td>
                                            <td style="text-align:right">
												{{number_format($rp, 2)}}</td>
                                            <td style="text-align:right">
												{{number_format($op, 2)}}</td>
                                            <td style="text-align:right">
                                            @if ($product->original_price > 0)
                                                {{number_format((($op-$rp)/$op)*100,2)}}%
                                            @else
                                                0%
                                            @endif
										   </td>

                                            @if(count($product->wholesale))
                                                <td>
                                                    @foreach($product->wholesale as $wholesale)

                                                        RM{!! $wholesale->price !!}<br>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @foreach($product->wholesale as $wholesale)

                                                        {!! $wholesale->unit !!}<br>
                                                    @endforeach
                                                </td>
                                            @else
                                                <td></td>
                                                <td></td>
                                            @endif

                                            <?php
                                            try{
                                                $hits = $product->adSlotProduct->hits;
                                            }catch (\Exception $e){
                                                $hits = null;
                                            }
                                            ?>
                                            @if(!is_null($hits))
                                                <td>{{$hits->views}}</td>
                                                <td>{{$hits->buy}}</td>
                                                <td>{{$product->type}}</td>
                                                <td>{{$hits->user_agent}}</td>
                                                <td>{{ $product->dealers()->first()->user->first_name or 'dealer' }}</td>
                                            @else
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            @endif

                                        </tr>
                                    @endforeach
                                    @endif
                                    </tbody>
                                </table>

                            </div>

                        </div>


                    </form>


                </div>
            </div>
        </div><!--End main cotainer-->
    </section>


<script src="{{url('js/jquery.dataTables.min.js')}}"></script>
<script src="{{url('assets/jqGrid/jquery.jqGrid.min.js')}}"></script>


<script>
    (function(){

        function format ( tr ) {

            var j = tr.attr('data-last');

            var table='<table class="table child_table" cellspacing="0" width="100%">';
            table+='<thead>';
            table+='<tr><th>Id</th><th>Name</th><th>Description</th><th>Quantity</th><th>Price</th><th>Sub Total</th></tr>';
            table+='</thead>';
            table+='<tbody>';

            for (i = 1;i<=j;i++){
                var id = tr.attr('data-id-'+i);
                var name = tr.attr('data-name-'+i);
                var qty = tr.attr('data-qty-'+i);
                var price = tr.attr('data-price-'+i);
                var des = tr.attr('data-des-'+i);
                var total = tr.attr('data-total-'+i);
                table+='<tr><td>'+id+'</td><td>'+name+'</td><td>'+des+'</td><td>'+qty+'</td><td>'+price+'</td><td>'+total+'</td></tr>';
            }

            table+='</tbody>';
            table+='</table>';

            return table;
        }

        var table = $('#product_details_table').DataTable({
            "columnDefs": [ {
                "targets": 0,
                "data": null,
                "className":      'details-control',
                "orderable":      false,
                "defaultContent": ""
            } ]
        });

        $('#product_details_table tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = table.row( tr );

            if ( row.child.isShown() ) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            }
            else {
                // Open this row
                row.child( format(tr) ).show();
                tr.addClass('shown');
            }
        } );


        $('#shipping_details_table').DataTable();
        $('#lower_product_detail_table').DataTable();
        $('#payment_detail_products').DataTable();
        $('#voucher_payment_detail').DataTable();
        $('#open_wish_table').DataTable();
        $('#auto_link_table').DataTable();
        $('#auto_link_table_2').DataTable();


        var vtable = $('#voucher_detail_table').DataTable({
            "columnDefs": [ {
                "targets": 0,
                "data": null,
                "className":      'details-control-2',
                "orderable":      false,
                "defaultContent": ""
            } ]
        });

        $('td.details-control-2').on('click', function () {
            console.log('clicked');
            var tr = $(this).closest('tr');
            var row = vtable.row( tr );

            if ( row.child.isShown() ) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            }
            else {
                // Open this row
                row.child( format(tr) ).show();
                tr.addClass('shown');
            }
        } );


        $('#datetimepicker , #datetimepickerr').on('change',function(){
            var date1 = $('#datetimepicker').val();
            var date2 = $('#datetimepickerr').val();

            $('#dateSince').html(date1);

            $.ajax({
               url: '{{url('/merchant/calc-sale')}}',
               data: {'date1': date1, 'date2' : date2},
               headers: { 'X-XSRF-TOKEN' : '{{\Illuminate\Support\Facades\Crypt::encrypt(csrf_token())}}' },
               error: function() {

               },
               success: function(response) {
                  $('#amountSince').html(response.payment);
                  $('#amountBetween').html(response.paymentSince);
               },
               type: 'POST'
            });
        });
    })();
</script>
@stop
