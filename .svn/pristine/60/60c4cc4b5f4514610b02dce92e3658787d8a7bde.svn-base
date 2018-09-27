@extends("common.default")

@section("content")
<!--
<link href="{{url('assets/jqGrid/ui.jqgrid.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{url('css/datatable.css')}}" rel="stylesheet" type="text/css"/>
-->
<style>
.edit-personal-info-buyer{
	width:50%!important;
}
	
.bg {	
  width: 80%;
  height: 40%;
  /*background-color: #f0f0f0;*/
  object-fit: contain; /* cover works perfectly on Safari */
}

.wrapper {
	/*margin-right: -15px; 
	margin-left: -15px;
   */
	width: 100%;
	min-width: 60%;
	height: auto;
	max-height:60%;
	overflow: hidden;
}
.fvshop{
	display: block;
}
.afin{
	height: 10px;
}
.fvshop:before {
	/*Using a Bootstrap glyphicon as the bullet point*/
	content: "\e014";
	font-family: 'Glyphicons Halflings';
	font-size: 10px;
	float: left;
	margin-top: 4px;
	margin-left: -17px;
}
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
.panel {
    border: 0;
}

table {
	counter-reset: Serial;
}

table.counter_table tr td:first-child:before {
	counter-increment: Serial;      /* Increment the Serial counter */
	content: counter(Serial); /* Display the counter */
}
</style>
<script type="text/javascript" src="{{asset('js/autolink_action.js')}}"></script>
    <section class="">
        <div class="container"><!--Begin main cotainer-->
            <div class="row">
                <div class="col-sm-11 col-sm-offset-1">
                	<div class="row">
                    </div>
                    <hr>
                    <div class="col-sm-12"><h2>Buyer Information</h2></div>
                    {{-- Tabbed Nav --}}
                        <div class="panel with-nav-tabs panel-default">
                         <div class="panel-heading">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#information" data-toggle="tab">Information</a></li>
                            <li><a href="#orders" data-toggle="tab">Orders</a></li>
                            <li><a href="#shipping" data-toggle="tab">Shipping Details</a></li>
                            <li><a href="#voucher" data-toggle="tab">Coupon Details</a></li>
                            <li><a href="#dopenwish" data-toggle="tab">Open Wish</a></li>
                            <li><a href="#dautolink" data-toggle="tab">Autolink</a></li>
                            <li><a href="#smm" data-toggle="tab">Social Media </a></li>
                            <li><a href="#obiz" data-toggle="tab">Open Business</a></li>

                        </ul>
                </div>
                    {{--ENDS  --}}
                    <form class="form-horizontal">
                        <div id="dashboard" class="row" class="panel-body">
                        <div class="tab-content">
                        {{-- Buyer Info --}}
                        	<div id="information" class="tab-pane fade in active">
                        		<div class="col-md-3">
				<div class="wrapper"><img src="{{$image}}" title="profile-image" class=" bg img-responsive"> </div>
					<h3 style="text-align:left;" class="display-4 no-margin"><span class="text-muted">{{$user->salutation}}</span> {{$name}}</h3>
				<h5 class="no-margin"><span class="text-muted">User ID: </span> {{$user_id}}</h5>
				<h5 class="no-margin"><span class="text-muted">Member Since:</span> {{$member_since}}</h5>
				 </div>
				<div class="col-md-4">
					
					<div class="row">
				
						<div class="panel">

							<div class="panel-heading1 panel-title bottom-margin-xs">Personal Details</div>
						
							<div class="panel-body border-con">

								<dl class="dl-horizontal text-muted">
									<dt>Age</dt>
									<dd>{{$age or 'NaN'}}</dd>
									<dt>Occupation:</dt>
									<dd>{{$occupation or 'NaN'}}</dd>
									{{-- <dt>User ID:</dt>
									<dd>{{$user->id}}</dd>
									<dt></dt> --}}
									<dt>Default Address</dt>
									<dd>
										{{$da->line1 or $da}} <br>
										{{$da->line2 or $da}}
										<be>
											{{$da->line3 or $da}} , {{$da->line4 or $da}}
									</dd>
									<dt>Billing Address</dt>
									<dd>
										{{$ba->line1 or "---"}} <br>
										{{$ba->line2 or $ba}}
										<be>
											{{$ba->line3 or $ba}} , {{$ba->line4 or $ba}}
									</dd>
									<dt>Language</dt>
									<dd>{{$language}}</dd>
									<dt>Annual</dt>
									<dd>{{$user->annual_income}}</dd>
									<dt>Potential Industry</dt>
									<dd>{{$buyerinfo->potential_industry or "--"}}</dd>
									<dt>Products</dt>
									<dd>{{$buyerinfo->products or "--"}}</dd>
									<dt>Amount</dt>
									<dd>{{$buyerinfo->amount or "--"}}</dd>
								</dl>
							</div>
							<div class="afin"><span>&nbsp</span></div>
							<div class="panel-heading1"> Interests</div>
						<div class="panel-body border-con text-muted">
							<p class="text-muted"><!-- Electronics, Fashion, Beauty, Health & Cosmatics --> {{$interests}}</p>
						</div>
						</div>

					</div>
				</div>
				<div class="col-md-5 col-xs-12">
					<div class="row" style="text-align:center;">
						 <h3>My Favourite O-Shop</h3>
						<div class="input-group input-group-sm pull-right col-md-6">
						 <input type="text" class="form-control" placeholder="Search"> 
						  <span class="input-group-btn">
							<button class="btn btn-default" type="button"><span class="glyphicon glyphicon-search"></span></button>
						  </span>
						  </div>
					</div>
					<div class="row">
							<div class="clearfix"></div>
							<div id="oshop-favo">
								<ul class="list-unstyled">
									<li><img src="images/favo1.png" class="img-responsive"></li>
									<li><img src="images/favo2.png" class="img-responsive"></li>
									<li><img src="images/favo3.png" class="img-responsive"></li>
									<li><img src="images/favo4.png" class="img-responsive"></li>
									<li><img src="images/favo5.png" class="img-responsive"></li>
									<li><img src="images/favo1.png" class="img-responsive"></li>
									<li><img src="images/favo2.png" class="img-responsive"></li>
									<li><img src="images/favo3.png" class="img-responsive"></li>
									<li><img src="images/favo4.png" class="img-responsive"></li>
									<li><img src="images/favo5.png" class="img-responsive"></li>
								</ul>
							</div>
					</div>
						<div class="panel-heading1" style="margin-left:10px;">My Favourite O-Shop</div>
					   		<ul>
					   		
						   		<li class="fvshop no-margin">Pandora</li>
						   		<li class="fvshop no-margin">Pasificia</li>
						   		<li class="fvshop no-margin">Kaiser Restaurent </li>
						   		<li class="fvshop no-margin"> ZARA City </li>
						   		<li class="fvshop no-margin">574 workwear</li>
				
							</ul>
				  		</div>
		
                        	</div>
                        {{--  --}}
                        {{-- Obiz --}}
                                      <div id="obiz" class="tab-pane fade">
       
			  	<div class="col-md-12">
			  		<div class="row "><a class="btn btn-orange col-md-2 bottom-margin-md" id ="open-biss" href="#"><i class="fa fa-suitcase"></i> Open Business</a>	

			 		</div>  <div class="clearfix"></div>
					 <div class="row">

					 	<div class="col-md-6">
					 		 <h3>Company Details</h3>
					 		 <div class="form-group">
			 {{-- 
					<label class="col-md-12 control-label">&nbsp;</label> --}}
							
							<label class="col-md-4 control-label">Company Name</label>
							<div class="col-md-8">
							  <input type="text" placeholder="if using company account" class="form-control" disabled>
							</div>
							<label class="col-md-4 control-label"> Reg No</label>
							<div class="col-md-8">
							  <input type="text" placeholder="if using company account" class="form-control" disabled>
							</div>
							<label class="col-md-4 control-label">Type</label>
							<div class="col-md-8">
							
							 <select data-style="btn-orange" class="selectpicker show-menu-arrow form-control" disabled>
							  <option>Dealers</option>
							  <option>Merchant Consultant</option>
							  <option>SMM</option>
							  </select>
							  
						  
						</div>
						</div>	
					 	</div>
					 		<div class="col-md-6">
					 		<h3>Bank Details</h3>
							<div class="form-group">  
								  <label class="col-md-4 control-label">Account Name </label>
								    <div class="col-md-8">
								      <input type="text" class="form-control" disabled>
								    </div>
								   
								   <label class="col-md-4 control-label">Account Number </label>
								    <div class="col-md-8">
								      <input type="text" class="form-control" disabled>
								    </div>
								  
								  <label class="col-md-4 control-label">Bank Name</label>
								    <div class="col-md-8">
								      <input type="text" class="form-control" disabled>
								    </div>
								   
								   <label class="col-md-4 control-label">Bank Code </label>
								    <div class="col-md-8">
								      <input type="text" class="form-control" disabled>
								    </div>
								   
								   <label class="col-md-4 control-label">IBAN </label>
								    <div class="col-md-8">
								      <input type="text" class="form-control" disabled>
								    </div>
								    
									<label class="col-md-4 control-label bottom-margin-md">SWIFT </label>
								    <div class="col-md-8">
								      <input type="text" class="form-control" disabled>
								    </div>
									
								    </div>
						</div>
					 	<div class="col-md-6"></div>
					 </div>
			  	</div>			 

			  	</div>
			  	
                        {{-- OBIZends --}}
                        <div id="orders" class="tab-pane fade">
                            <div class="table-responsive col-sm-12 " >

                                <table class="table text-muted " id="product_details_table">
                                    <thead>
                                    <tr class="bg-black">
                                        <th colspan="11">Order Details</th>
                                    </tr>
                                    <?php $i=1;?>
                                    <tr class="bg-black">
                                        <th>No</th>
                                        <th>Order ID</th>
                                        <th>Order Recieved</th>
                                        <th>Order Executed</th>
                                        <th>SKU</th>
                                        <th>User ID(Buyer)</th>
                                        <th>Order Total</th>
                                        <th>Delivery Order</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(isset($products))
                                        @foreach($products as $p)
                                            <tr>
                                                <td>{{$i}}</td>
                                                <td>{{$p['oid']}}</td>
                                                {{-- <td>{{$p['sku']}}</td> --}}
                                                <td>{{$p['o_rcv']}}</td>
                                                <td>{{$p['o_exec']}}</td>
                                                <td>{{$p['sku']}}</td>
                                                <td>{{$p['uid']}}</td>
                                                <td>What here</td>
                                                <td><a href="{{ url('deliveryorder/'.$p['oid']) }}">Delivery Order</a></t></td>
                                            </tr>
                                            <?php $i++; ?>
                                        @endforeach
                                    @endif
     
                                    </tbody>
                                </table>
                            </div>
                           
                            {{-- <div class="clearfix"> </div> --}}
                            </div>
                            {{-- Product Ends --}}
                            <div class="tab-pane fade" id="shipping">
                            <div class="table-responsive col-sm-12">
                                <table class="table text-muted counter_table" id="shipping_details_table">
                                    <thead>
                                    <tr class="bg-move">
                                        <th colspan="10">Shipping Details</th>
                                    </tr>
                                    <tr class="bg-move">
                                        <th>No</th>
                                        {{-- <th>Order ID</th> --}}
                                        <th>Shipping ID</th>
                                        <th>Company</th>
                                        <th>Date since order</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(isset($couriers) and !empty($couriers))
                                    @foreach($couriers as $courier )
										@if(isset($courier) and !empty($courier))
                                        <tr>
                                            <td></td>
                                            {{-- <td>{{$courier->porder_id}}</td> --}}
                                            <td>{{$courier->shipping_id}}</td>
                                            <td>{{$courier->name}}</td>
                                            <td>{{$courier->created_at}}</td>
                                        </tr>
										@endif
                                    @endforeach
                                    @endif
                                    </tbody>
                                </table>

                            </div>

                            </div>
                            {{--  --}}
                            {{-- Voucher --}}
                            <div class="tab-pane fade" id="voucher">
                                <div class="table-responsive col-sm-12">
					<table class="table text-muted ">
					<tr class="bg-parrot">
					  <th colspan="10">Coupon Details</th>
					</tr>
					<tr class="bg-parrot">
					  <th>Order ID</th>
					  <th>Product ID</th>
					  <th>Order Recieved</th>
					  <th>Order Executed</th>
					  <th>SKU</th>
					  <th>Description</th>
					  <th>Quantity</th>
					  <th>Price</th>
					  <th>User ID(Buyer)</th>
					  <th>Source</th>
					</tr>

					</table>

                                </div>


                            </div> 
                            {{-- Coupon Ends --}}
                            <div class="tab-pane fade" id="dopenwish">
                            {{-- Openwish --}}

							<div class="col-md-12">
								<div class="row">
									<label><em>New Wishes:</em></label>
								</div>
								<div class="row">
									<div class="col-md-3 item-box">
										<a href="#"> <img class="img-responsive" src="images/item1.png" alt="item" ></a>
										 <div class="pull-left">Lorem Ipsum 574</div><div class="pull-right">FM380</div>  
							 			<div class="clearfix"></div> 
							 			<div class="pull-left">PAM TTD <span class="bordered">RM300</span></div>
										 <div class="pull-right"><a class="btn-darkgreen">Ask for Help</a></div>
										   <div class="clearfix"> </div>

									     <div class="pull-left">Balance <span class="bordered">BM54</span></div>
										 <div class="pull-right"><a class="btn-darkgreen">Buy Now</a></div>
							
								  		<div class="clearfix"> </div>
									</div>
									<div class="col-md-3 item-box">
									    <a href="#">
									    <img class="img-responsive" src="images/item2.png" alt="item" >
									    </a>
									    <div class="pull-left">Lorem Ipsum 574</div>
									    <div class="pull-right">FM380</div>
									    <div class="clearfix"></div>
									    <div class="pull-left">PAM TTD 
									        <span class="bordered">RM300</span>
									    </div>
									    <div class="pull-right">
									        <a class="btn-darkgreen">Ask for Help</a>
									    </div>
									    <div class="clearfix"></div>
									    <div class="pull-left">Balance 
									        <span class="bordered">BM54</span>
									    </div>
									    <div class="pull-right">
									        <a class="btn-darkgreen">Buy Now</a>
									    </div>
									    <div class="clearfix"></div>
									</div>
									<div class="col-md-3 item-box">
									 
								   		<a href="#">
									    <img class="img-responsive" src="images/item3.png" alt="item" >
									    </a>
									    <div class="pull-left">Lorem Ipsum 574</div>
									    <div class="pull-right">FM380</div>
									    <div class="clearfix"></div>
									    <div class="pull-left">PAM TTD 
									        <span class="bordered">RM300</span>
									    </div>
									    <div class="pull-right">
									        <a class="btn-darkgreen">Ask for Help</a>
									    </div>
									    <div class="clearfix"></div>
									    <div class="pull-left">Balance 
									        <span class="bordered">BM54</span>
									    </div>
									    <div class="pull-right">
									        <a class="btn-darkgreen">Buy Now</a>
									    </div>
									    <div class="clearfix"></div>
									</div>
																		<div class="col-md-3 item-box">
									 
								   		<a href="#">
									    <img class="img-responsive" src="images/item3.png" alt="item" >
									    </a>
									    <div class="pull-left">Lorem Ipsum 574</div>
									    <div class="pull-right">FM380</div>
									    <div class="clearfix"></div>
									    <div class="pull-left">PAM TTD 
									        <span class="bordered">RM300</span>
									    </div>
									    <div class="pull-right">
									        <a class="btn-darkgreen">Ask for Help</a>
									    </div>
									    <div class="clearfix"></div>
									    <div class="pull-left">Balance 
									        <span class="bordered">BM54</span>
									    </div>
									    <div class="pull-right">
									        <a class="btn-darkgreen">Buy Now</a>
									    </div>
									    <div class="clearfix"></div>
									</div>

							
							{{-- Row Ends --}}
							<div class="row"><label><em>History:</em></label></div>
							{{-- Row --}}
							<div class="row">
								<div class="col-md-3 item-box">
										<a href="#"> <img class="img-responsive" src="images/item1.png" alt="item" ></a>
										 <div class="pull-left">Lorem Ipsum 574</div><div class="pull-right">FM380</div>  
							 			<div class="clearfix"></div> 
							 			<div class="pull-left">PAM TTD <span class="bordered">RM300</span></div>
										 <div class="pull-right"><a class="btn-darkgreen">Ask for Help</a></div>
										   <div class="clearfix"> </div>

									     <div class="pull-left">Balance <span class="bordered">BM54</span></div>
										 <div class="pull-right"><a class="btn-darkgreen">Buy Now</a></div>
							
								  		<div class="clearfix"> </div>
								</div>
								<div class="col-md-3 item-box">
									    <a href="#">
									    <img class="img-responsive" src="images/item2.png" alt="item" >
									    </a>
									    <div class="pull-left">Lorem Ipsum 574</div>
									    <div class="pull-right">FM380</div>
									    <div class="clearfix"></div>
									    <div class="pull-left">PAM TTD 
									        <span class="bordered">RM300</span>
									    </div>
									    <div class="pull-right">
									        <a class="btn-darkgreen">Ask for Help</a>
									    </div>
									    <div class="clearfix"></div>
									    <div class="pull-left">Balance 
									        <span class="bordered">BM54</span>
									    </div>
									    <div class="pull-right">
									        <a class="btn-darkgreen">Buy Now</a>
									    </div>
									    <div class="clearfix"></div>
								</div>
								<div class="col-md-3 item-box">
									 
								    <a href="#">
								    <img class="img-responsive" src="images/item3.png" alt="item" >
								    </a>
								    <div class="pull-left">Lorem Ipsum 574</div>
								    <div class="pull-right">FM380</div>
								    <div class="clearfix"></div>
								    <div class="pull-left">PAM TTD 
								        <span class="bordered">RM300</span>
								    </div>
								    <div class="pull-right">
								        <a class="btn-darkgreen">Ask for Help</a>
								    </div>
								    <div class="clearfix"></div>
								    <div class="pull-left">Balance 
								        <span class="bordered">BM54</span>
								    </div>
								    <div class="pull-right">
								        <a class="btn-darkgreen">Buy Now</a>
								    </div>
								    <div class="clearfix"></div>
								</div>
											<div class="col-md-3 item-box">
									 
								    <a href="#">
								    <img class="img-responsive" src="images/item3.png" alt="item" >
								    </a>
								    <div class="pull-left">Lorem Ipsum 574</div>
								    <div class="pull-right">FM380</div>
								    <div class="clearfix"></div>
								    <div class="pull-left">PAM TTD 
								        <span class="bordered">RM300</span>
								    </div>
								    <div class="pull-right">
								        <a class="btn-darkgreen">Ask for Help</a>
								    </div>
								    <div class="clearfix"></div>
								    <div class="pull-left">Balance 
								        <span class="bordered">BM54</span>
								    </div>
								    <div class="pull-right">
								        <a class="btn-darkgreen">Buy Now</a>
								    </div>
								    <div class="clearfix"></div>
								</div>
							{{-- Row --}}
							{{-- </div>  --}}
							{{-- </div> --}}
							{{-- col --}}
							<div class="col-md-12">
								<h1>You may also like</h1>
									<div id="itembrands">
									<div class="col-md-4 col-md-6 item-brands">
										<a href="#"> <img class="img-responsive" src="images/p1.png" alt="item" ></a>
									</div>
									<div class="col-md-4 col-md-6 item-brands">
										<a href="#"> <img class="img-responsive" src="images/p2.png" alt="item" ></a>
									</div>
									<div class="col-md-4 col-md-6 item-brands">
										<a href="#"> <img class="img-responsive" src="images/p3.png" alt="item" ></a>
									</div>
									<div class="col-md-4 col-md-6 item-brands">
										<a href="#"> <img class="img-responsive" src="images/p4.png" alt="item" ></a>
									</div>
									<div class="col-md-4 col-md-6 item-brands">
										<a href="#"> <img class="img-responsive" src="images/p5.png" alt="item" ></a>
									</div>
									<div class="col-md-4 col-md-6 item-brands">
										<a href="#"> <img class="img-responsive" src="images/p6.png" alt="item" ></a>
									</div>
									<div class="col-md-4 col-md-6 item-brands">
										<a href="#"> <img class="img-responsive" src="images/p7.png" alt="item" ></a>
									</div>
									<div class="col-md-4 col-md-6 item-brands">
										<a href="#"> <img class="img-responsive" src="images/p8.png" alt="item" ></a>
									</div>
									<div class="col-md-4 col-md-6 item-brands">
										<a href="#"> <img class="img-responsive" src="images/p9.png" alt="item" ></a>
									</div>
								  </div>
							</div>
							{{-- Col --}}
						</div>	
						</div>
                            {{--  --}}
                            </div>
                            </div>
                            {{-- Openwish ends --}}
                            <div class="tab-pane fade" id="dautolink">

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
                                        <?php $i=1;?>
                                        @if(isset($autoLinks))
                                                            <?php $j=1;?>
                                            @foreach($autoLinks as $link)
                                                <tr>
                                                    <td>{{$j}}</td>
                                                    <td>{{$link['id']}}</td>
                                                    <td>{{$link['mode']}}</td>
                                                    <td>{{$link['iid']}}</td>
                                                    <td>{{$link['iname']}}</td>
                                                    <td>{{$currentCurrency}} {{$link['ibought']}}</td>
                                                    <td>{{$currentCurrency}} {{$link['isold']}}</td>
                                                    <td>{{$link['rid']}}</td>
                                                    <td>{{$link['rname']}}</td>
                                                    <td>{{$currentCurrency}} {{$link['rbought']}}</td>
                                                    <td>{{$currentCurrency}} {{$link['rsold']}}</td>
                                        
                                                </tr>

                                                <?php $j++; ?>
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
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(isset($autoLinks))
                                        @foreach($autoLinks as $link)
                                <tr><td>{{$i}}</td>
                            <td id="autolink" val="{{$link['id']}}">{{$link['id']}}</td>
                            <td>{{$link['iid']}}</td>
                            <td>{{$link['cat']}}</td>
                            <td>{{$link['subcat']}}</td>
                            <td>Target</td>
                            <td>{{$link['l_s']}}</td>
                            <td>{{$link['status']}}</td>
                            <td>{{$link['itype']}}</td>
                            <td>{{$link['remarks']}}</td>


                            <td>
                            {{-- Add a logic to check if iid == userid --}}
                            <span id= "action_area">
                                @if($link['status']=='request') 
                                <button type="button" class="btn btn-primary btn-success" id="accept" data-value="{{$link['id']}}"><span class="glyphicon glyphicon-ok"></span> </button>
                                <button type="button" class="btn btn-primary btn-warning" id="req_delete" data-value=
                                "{{$link['id']}}"><span class="glyphicon glyphicon-trash"></span> </button>
                                @else
                                <button type= "button" class="btn btn-primary btn-danger" id="link_delete" data-value="{{$link['id']}}"><span class="glyphicon glyphicon-remove"></span> </button>
                                @endif
                            </td>
                            </span>
                                <td> 
                                
                                    
                                </td>
                                {{-- <td><button class="btn btn-sm btn-success"><span class="glyphicon glyphicon-check"></span> Approve</button></td> --}}
                            
                            
                        <?php $i++; ?>
                    @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>

					                        	</div>{{--SMM  --}}
					        <div id="smm" class="tab-pane fade">
					       {{-- AMM --}}

				 		 <div class="col-md-12"><a href="#" id ="smm" class="btn btn-blue col-md-3">Access Management</a> </div>	
				 
				 		
				 		<div class="col-md-12 bottom-margin-md">
				 			<h4>Facebook</h4>
				 			<button type="button" class="btn btn-primary  popup_fb_test"><span class="glyphicon glyphicon-thumbs-up"></span> Test</button>
				 				<button type="button" class="btn btn-primary  popup_fb_token"><span class="glyphicon glyphicon-link"></span> Link</button>
				 		</div>
			
					       {{--  --}}
			 	<div class=""> 
				 	<div class=" col-md-12 bottom-margin-md">
				 		<a href="#" id ="smm" class="btn btn-blue col-md-3"><i class="glyphicon glyphicon-tower"></i> Social Media Marketeer</a>	
				 		<div id="clearfix"></div>
				 	</div>
				 	<div class="col-md-12"> 
				 	<div class="col-md-4"> 
			 		   	 <table class="table noborder no-margin">
		                    <tr><th colspan="2">Overall</th></tr>
		                    <tr><td>Shared</td><td>30</td></tr>
		                    <tr><td>Viewed Click</td><td>20000</td></tr>
		                    <tr><td>Bought</td><td>{{$currentCurrency}} 41,000,00</td></tr>
		                    <tr><td></td><td>400</td></tr>
                 		</table>
				 	</div>
			 	 	<div class="col-md-4"> 
			 	 	<table class="table noborder no-margin">
						<tr><th colspan="2">Commision</th></tr>	
						<tr><td>Earned Since</td><td>{{$currentCurrency}} 20,000,00</td></tr>	
						<tr><td>Earned YTD</td><td>{{$currentCurrency}} 10,000,00</td></tr>	
						<tr><td>Pending</td><td>{{$currentCurrency}} 205,00</td></tr>	
						<tr><td>&nbsp</td></tr>
						</table>
			 	 	</div>
		 	 	 	<div class="col-md-4"> 
		 	 	 						<select class="margin-top selectpicker show-menu-arrow form-control" data-style="btn-darkgreen" disabled>
			<option>Great Sales</option></select>
			  <div class="margin-top ">
			  <div class="col-md-5 btn-facebook">
			<div class="checkbox checkbox-danger checkbox-inline">
			<input type="checkbox" class="styled" id="inlineCheckbox1" value="option1" disabled>
			<label class=""> Facebook</label>
			</div>
			</div>
			
			<div class="col-md-5 col-md-offset-2 btn-twitter">
			<div class="checkbox checkbox-danger checkbox-inline">
			<input type="checkbox" class="styled" id="inlineCheckbox1" value="option1" disabled>
			<label class="btn-twitter"> Twitter</label>
			</div>
			</div>
			 <div class="clearfix"> </div>
			 </div>
			 
			  <div class="margin-top ">
			  
			<div class="col-md-5 btn-linkedin">
			<div class="checkbox checkbox-danger checkbox-inline">
			<input type="checkbox" class="styled" id="inlineCheckbox1" value="option1" disabled>
			<label class=""> Linked In</label>
			</div>
			 
			</div>
			
			<div class="col-md-5 col-md-offset-2 btn-gplus">
			<div class="checkbox checkbox-danger checkbox-inline">
			<input type="checkbox" class="styled" id="inlineCheckbox1" value="option1" disabled>
			<label class=""> Google+</label>
			</div>
			</div>
			 <div class="clearfix"> </div>
			  
			  </div>
			 
			    <div class="margin-top ">
				<div class="col-md-5 btn-instagram">
			<div class="checkbox checkbox-danger checkbox-inline">
			<input type="checkbox" class="styled" id="inlineCheckbox1" value="option1" disabled>
			<label class=""> Instagram</label>
			</div>
			</div>
			<div class="col-md-5 col-md-offset-2 btn-wechat">
			<div class="checkbox checkbox-danger checkbox-inline">
			<input type="checkbox" class="styled" id="inlineCheckbox1" value="option1" disabled>
			<label class=""> WeChat</label>
			</div>
			</div>
			 <div class="clearfix"> </div>
			 </div>
			  <div class="margin-top">
			  <div class="col-md-5 btn-weibo">
			<div class="checkbox checkbox-danger checkbox-inline">
			<input type="checkbox" class="styled" id="inlineCheckbox1" value="option1" disabled>
			<label class=""> Weibo</label>
		 	 	 	</div>
				 	</div>
			 	</div>
			 </div>
			 {{--  --}}
			
			 
			  <div class="clearfix"> </div>

                    <?php $block = 0; ?>
                    @if(!empty($smmProducts))
                        @foreach($smmProducts as $product)
                            <?php $block++; ?>
                            <div class="margin-top">
                                <div class="col-md-2 thumbnail">
                                    <img src="{{ asset('/images/product/'.$product->product_id.'/'.$product->photo_1) }}" class="img-responsive">
                                    <h5>{{ $product->product_name }} <strong class="pull-right">{{ $product->original_price }}</strong></h5>
                                </div>
                                <div class="col-md-3">
                                    <table class="table noborder">
                                        <tr><th colspan="2">Overall</th></tr>
                                        <tr><td>Shared</td><td>30</td></tr>
                                        <tr><td>Viewed Click</td><td>{{ $product->view_clicks }}</td></tr>
                                        <tr><td>Bought</td><td>{{$currentCurrency}} {{ $product->buy_clicks * $product->original_priice }}</td></tr>
                                        <tr><td>Unit</td><td>400</td></tr>
                                    </table>
                                    <input type="hidden" name="product_id" value="{{ $product->product_id }}"/>
                                    @if($product->number_shared <= globalSettings('smm_max_post'))
                                        <a class="btn btn-darkgreen pull-right btn-lg smedia-marketer">Send</a>
                                    @else
                                        <span>You have completed the number of shares</span>
                                    @endif
                                </div>
                            </div>
                            @if($block % 2 == 0)
                                <div class="clearfix"></div>
                            @endif
                        @endforeach
                    @endif

			  </div>

			  </div>	
			  </div>
					        </div>
					                        {{--  --}}
					                        {{-- Open Biz --}}
                        
   
                        {{-- Biz endss --}}

        
        </div><!--End main cotainer-->
    </section>


<script src="{{url('js/jquery.dataTables.min.js')}}"></script>



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
        $('#voucher').DataTable();
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
{{-- {{1/0}} --}}
