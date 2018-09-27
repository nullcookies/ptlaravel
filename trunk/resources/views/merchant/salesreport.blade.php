@extends("common.default")

@section("content")
@include("common.sellermenu")
<style>
.dataTables_filter input {
	width:300px;
}

</style>

<div class="container" id="sales-analysis" style="margin-top:30px;">   
	<input type="hidden" id="merchant_id" value="{{$merchant_id}}" />    
	{!! Breadcrumbs::renderIfExists() !!}

    <div class="row">
        <div class="col-sm-12">
        	<div class="panel with-nav-tabs panel-default" id="TabId">
               <div class="panel-heading">
                    <ul class="nav nav-tabs">
                        <li class="active" id="tb-online-product">
						<a href="#online-detail" data-toggle="tab"
							style="margin-left: -15px; margin-right: 0px;">
							Online</a></li>
                        <li id="tb-opossum-detail"><a href="#opossum-detail"
							style="margin-left:0;margin-right:0;padding-left: 10px; padding-right: 10px;"
							data-toggle="tab">OPOSsum</a></li>
					</ul>
				</div>
			</div>
        </div>
    </div>
	<div class="margin-top">
	 	<div class="tab-content">
	 		<div id="opossum-detail" class="tab-pane fade">
	 			<div class="col-xs-12" style="margin-bottom:15px;">
	    			<div class="col-xs-1" style="">
						<a target="_blank" type="button" class="btn btn-info sellerbutton2" id="psales"  href="{{URL('/merchant/productsales')}}">Product</br>Sales
						</a>
				    </div>	
					<div class="col-xs-1" style="">
						<a target="_blank" class="btn btn-info sellerbutton2 staffSales"  href="{{URL('/merchant/staffsales')}}">Staff</br>Sales</a>
					</div>	
				</div>
			</div>
			<div id="online-detail" class='tab-pane fade in active'>
				<!--<div class="col-xs-12" id="label" >
						<div class='col-xs-3'>
							<label>Consumer</label>
						</div>
					</div>
					<div class="col-xs-12" id="consumers-main-container" >
						<div class='col-xs-6 consumer-merchant-select-container'>
							{!! Form::select('consumer', array('' => 'Select...','merchant'=>'Merchant','station'=>'Station','buyer'=>'Buyer'), null, ['class' => 'consumer-merchant-field col-xs-12']) !!}
						</div>		
					</div>	 -->


				<div class="col-xs-12" id="label" style="margin-top: 15px;">
					<div class='col-xs-3'>
						<label>Country</label>
					</div>
					<div class='col-xs-3'>
						<label>State</label>
					</div>
					<div class='col-xs-3'>
						<label>City</label>
					</div>
					<div class='col-xs-3'>
						<label>Area</label>
					</div>
				</div>
				<div class="col-xs-12" id="countries-main-container" >
					<div class='col-xs-3 countries-merchant-select-container'>
						{!! Form::select('country', array('' => 'Select...') + $data['countries'], null, ['class' => 'country-merchant-field col-xs-12']) !!}
					</div>
					<div class='col-xs-3 state-merchant-select-container'>
						{!! Form::select('state', array(), null, ['class' => 'state-merchant-field col-xs-12']) !!}
					</div>
					<div class='col-xs-3 city-merchant-select-container'>
						{!! Form::select('city', array(), null, ['class' => 'city-merchant-field col-xs-12']) !!}
					</div>
					<div class='col-xs-3 area-merchant-select-container'>
						{!! Form::select('area', array(), null, ['class' => 'area-merchant-field col-xs-12']) !!}
					</div>			
				</div>
				<div class="col-xs-12" id="label" style="margin-top: 15px;">
					<div class='col-xs-3'>
						<label>Category</label>
					</div>
					<div class='col-xs-3'>
						<label>SubCategory</label>
					</div>
					<div class='col-xs-3'>
						<label>Brand</label>
					</div>

					<div class='col-xs-3'>
						<label>Product</label>
					</div>
				</div>

				<div class="col-xs-12" id="field-main-container" >

					<div class='col-xs-3 category-merchant-select-container'>
						{!! Form::select('category', array('' => 'Select...') + $data['categories'], null, ['class' => 'category-merchant-field col-xs-12']) !!}
					</div>
					<div class='col-xs-3 area-merchant-select-container'>
						{!! Form::select('subcategory', array(), null, ['class' => 'subcategory-merchant-field col-xs-12']) !!}
					</div>	
					<div class='col-xs-3 brand-merchant-select-container'>
						{!! Form::select('brand', array('' => 'Select...') + $data['brands'], null, ['class' => 'brand-merchant-field col-xs-12']) !!}
					</div>			
					<div class='col-xs-3 product-merchant-select-container'>
						{!! Form::select('product', array(), null, ['class' => 'product-merchant-field col-xs-12']) !!}
					</div>			
				</div>

				<div class="col-xs-12" id="label" style="margin-top: 15px;">
					<div class='col-xs-3'>		  
						<label>Channel</label>
					</div>
				</div>

				<div class="col-xs-12" id="channels-main-container" >
				
					<div class='col-xs-3 channel-merchant-select-container'>
						<select name="Statuses" class = "channel-merchant-field col-xs-12">
						<option value="">Select</option>
						<option value="all2loc">All Locations</option>
						<option value="overall2sales">Overall Sales</option>
						<option value="b2c">Online Retail</option>
						<option value="b2b">Online B2B</option>
						<option value="hyper">Online Hyper</option>
						<option value="smm">Online SMM</option>
						<option value="openwish">Online OpenWish</option>
						@foreach ($channel as $value)
						<option value="{{ $value->id }}">{{ $value->location }}</option>
						@endforeach
						</select>
					</div>
					<!--<div class='col-xs-6 channel-merchant-select-container'>
						{!! Form::select('channel', array('' => 'Select...','b2c'=>'Retail','b2b'=>'B2B','hyper'=>'Hyper','smm'=>'SMM','openwish'=>'OpenWish'), null, ['class' => 'channel-merchant-field col-xs-12']) !!}
					</div>-->
				</div>	
					<!--<div class='col-xs-6 channel-merchant-select-container'>
						{!! Form::select('channel', array(
						'' => 'Select...',
						'b2c'=>'Online Retail',
						'b2b'=>'Online B2B',
						'hyper'=>'Online Hyper',
						'smm'=>'Online SMM',
						'openwish'=>'Online OpenWish'), null,
						['class' => 'channel-merchant-field col-xs-12'])
						!!}
					</div>-->		
				<!-- <div  class='col-xs-6'>
					<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Product Sales</button>
					<button type="button" class="btn btn-info btn-lg">Staff Sales</button>
				</div>	 -->		
			
	
				<script>
					var chart;
					var xaxis_categories = new Array();
					var months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun","Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
					var index = 0;
					for(var k = 10; k < 30;k++){
						for(var aa = 0; aa < 12; aa++){
							xaxis_categories[index] = months[aa] + " " + k;
							index++;
						}
					}
					
					//console.log(xaxis_categories);
					$(document).ready(function() {


					chart = new Highcharts.Chart({
							chart: {
							   renderTo: 'container',
							 // type: 'bar' // change this to column if want to show the column chart
							},
							title: {
								text: 'Merchant Sales Report',
								x: -20 //center
							},
							subtitle: {
								text: '',
								x: -20
							},
							xAxis: {
								
								categories: xaxis_categories,

							/*	labels: {
									formatter: function () {
										return 
											this.value;
									}
								}*/
							},
							yAxis: {
								title: {
									text: 'Revenue'
								},
								min:0,
								plotLines: [{
									value: 0,
									width: 1,
									color: '#718DA3'
								}]
							},
							tooltip: {
								valueSuffix: '',
								formatter: function() {
									return "{{$currentCurrency}} " + this.point.y;
								}
							},
							legend: {
								layout: 'vertical',
								align: 'right',
								verticalAlign: 'middle',
								borderWidth: 0
							},
							series:[{
								//showInLegend: false,
								   name: 'Sales',
								   data: [],
								   dataLabels: {
									enabled: true,
									}
								}],
							exporting: {
								enabled: false
							}

						});
					});
				</script>
				<div class='col-xs-12' id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
				<div class="col-xs-12">
				
					<?php  $date = date("Y-m-d"); ?>
					<?php  $dateytd = date("Y") . "-01-01"; ?>
					<?php  $datemtd = date("Y-m") . "-01"; ?>

					<?php $date1 = date("Y-m-d"); 
					$datewtd =  date('Y-m-d', strtotime('-1 week', strtotime($date1))); ?>
					<?php  $datedaily = $datedaily = date("Y-m-d"); ?>
					<?php  $datehourly = date('Y-m-d H:i:s', strtotime('-1 hour')); ?>
					
					<div class="col-xs-1">
						<a href="javascript:void(0)" class="btn btn-info since_ytd sellerbutton1" id="graph-merchant-since" from="<?php echo $since; ?>" to="<?php echo date("d-M-Y", strtotime($date)); ?>" rel-type="since">Since</a>
					</div>
					<div class="col-xs-1">
						<a href="javascript:void(0)" class="btn btn-info ytd_btn sellerbutton1" id="graph-merchant-ytd" from="<?php echo date("d-M-Y", strtotime($dateytd)); ?>" to="<?php echo date("d-M-Y", strtotime($date)); ?>" rel-type="ytd">YTD</a>
					</div>
					<div class="col-xs-1">
						<a href="javascript:void(0)" class="btn btn-info mtd_btn sellerbutton1" id="graph-merchant-mtd" from="<?php echo date("d-M-Y", strtotime($datemtd)); ?>" to="<?php echo date("d-M-Y", strtotime($date)); ?>" rel-type="mtd">MTD</a>
					</div>
					<div class="col-xs-1">
						<a href="javascript:void(0)" class="btn btn-info wtd_btn sellerbutton1" id="graph-merchant-wtd" from="<?php echo date("d-M-Y", strtotime($datewtd)); ?>" to="<?php echo date("d-M-Y", strtotime($date)); ?>" rel-type="wtd">WTD</a>
					</div>
					<div class="col-xs-1">
						<a href="javascript:void(0)" class="btn btn-info daily_btn sellerbutton1" id="graph-merchant-daily" from="<?php echo date("d-M-Y", strtotime($datedaily)); ?>" to="<?php echo date("d-M-Y", strtotime($date)); ?>" rel-type="daily">Today</a>
					</div>
					
					<div class="col-xs-3">
						&nbsp;
					</div>
					<!-- <div class="col-xs-1" style="">
						<a type="button" class="btn btn-info sellerbutton2"
						style=""
						data-toggle="modal" id="psales"
						data-target="#skumodel">Product</br>Sales</a>
				   </div>	
					<div class="col-xs-1" style="">
						<a type="button" class="btn btn-info sellerbutton2 staffSales"
						style=""
						data-toggle="modal"
						data-target="#staffSales1">Staff</br>Sales</a>
					</div>	 -->		
				</div>	
				<div class="col-xs-12 sales-analysis-graph-info">
					<table class="table table-bordered col-xs-12">
						<tr>
							<td>Custom Date Range</td>
							<td>
								<label>From</label>
								<?php  $date = date("Y-m-d"); ?>
								<input type='text' id="from_date" class='pull-right datepicker' value="<?php echo date("d-M-Y",strtotime('-1 year',  strtotime($date))); ?>"/>
							</td>
							<td>
								<label>To</label>
								<input type='text' id="to_date" class='pull-right datepicker' value="<?php echo date("d-M-Y", strtotime($date)); ?>"/>
							</td>
							<td>
								<button type="button" style="width: 100% !important;" class="btn btn-success" id="graph-search-merchant">Search</button>
							</td>
						</tr>
					</table>
					<div class="col-xs-2">

					</div>
					<div class="col-xs-12">
						<table class="table table-condensed table-hover table-responsive table-striped " id="each-month-max-min-table">
							<tbody>

							</tbody>
						</table>
					</div>
				</div>		

			</div>
		</div>
	</div>
	<div class="modal fade" id="skumodel" role="dialog" aria-labelledby="myModalLabel" >
		<div class="modal-dialog modal-lg " role="document">

			<div class="modal-content modal-content-sku">
	            <div class="modal-header" style="margin-bottom:25px;padding-bottom:10px">
	                <button type="button" class="close" data-dismiss="modal">
						&times;</button>
					<h3 class="modal-title"
						style="margin-bottom:0"
						id="myModalLabel">
						Product Sales</h3>
					<a href="javascript:void(0)"
						class="btn btn-info since_ytd sellerbutton1" 
						onclick="fetch_products_code()"
						style="margin-top:20px;"
						id="graph-merchant-since"
						from="<?php echo $since; ?>"
						to="<?php echo date("d-M-Y", strtotime($date)); ?>"
						rel-type="since">Since</a>

	     			<a href="javascript:void(0)"
						class="btn btn-info ytd_btn sellerbutton1"
						style="margin-top:20px;"
						onclick="fetch_products_ytd()"
						id="graph-merchant-ytd"
						rel-type="ytd">YTD</a>

		    		<a href="javascript:void(0)"
						class="btn btn-info mtd_btn sellerbutton1"
						style="margin-top:20px;"
						onclick="fetch_products_code_mtd()"
						id="graph-merchant-mtd"
						rel-type="mtd">MTD</a>

			    	<a href="javascript:void(0)"
						class="btn btn-info wtd_btn sellerbutton1"
						style="margin-top:20px;"
						onclick="fetch_products_code_wtd()"
						id="graph-merchant-wtd"
						from="<?php echo date("d-M-Y", strtotime($datewtd)); ?>"
						to="<?php echo date("d-M-Y", strtotime($date)); ?>"
						rel-type="wtd">WTD</a>

					<a href="javascript:void(0)"
						class="btn btn-info daily_btn sellerbutton1"
						style="margin-top:20px;"
						onclick="fetch_products_code_daily()"
						id="graph-sales-daily"
						from="<?php echo date("d-M-Y", strtotime($datedaily)); ?>"
						to="<?php echo date("d-M-Y", strtotime($date)); ?>"
						rel-type="daily">Today</a>

					
	            </div>
				
				<div id="skumodalbody" class="modal-body">
				</div>
			</div>
		</div>
	</div>
	<!-- <div class="modal fade" id="staffSales156" role="dialog" aria-labelledby="myModalLabel" >
		<div class="modal-dialog modal-lg " role="document">
			<div class="modal-content modal-content-sku">
            <div class="modal-header"
				style="margin-bottom:25px;padding-bottom:10px">

                <button type="button" class="close" data-dismiss="modal">
					&times;</button>
				<h3 class="modal-title"
					style="margin-bottom:0"
					id="myModalLabel">
					Staff Sales</h3>
				<a href="javascript:void(0)"
					class="btn btn-info since_ytd sellerbutton1" 
					onclick="staffSalesReport()"
					style="margin-top:20px;"
					id="graph-merchant-since"
					from="<?php echo $since; ?>"
					to="<?php echo date("d-M-Y", strtotime($date)); ?>"
					rel-type="since">Since</a>

     			<a href="javascript:void(0)"
					class="btn btn-info ytd_btn sellerbutton1"
					style="margin-top:20px;"
					onclick="staffSalesReportYtd()"
					id="graph-merchant-ytd"
					rel-type="ytd">YTD</a>

	    		<a href="javascript:void(0)"
					class="btn btn-info mtd_btn sellerbutton1"
					style="margin-top:20px;"
					onclick="staffSalesReportMtd()"
					id="graph-merchant-mtd"
					rel-type="mtd">MTD</a>

		    	<a href="javascript:void(0)"
					class="btn btn-info wtd_btn sellerbutton1"
					style="margin-top:20px;"
					onclick="staffSalesReportWtd()"
					id="graph-merchant-wtd"
					from="<?php echo date("d-M-Y", strtotime($datewtd)); ?>"
					to="<?php echo date("d-M-Y", strtotime($date)); ?>"
					rel-type="wtd">WTD</a>

				<a href="javascript:void(0)"
					class="btn btn-info daily_btn sellerbutton1"
					style="margin-top:20px;"
					onclick="staffSalesReportToday()"
					id="graph-sales-daily"
					from="<?php echo date("d-M-Y", strtotime($datedaily)); ?>"
					to="<?php echo date("d-M-Y", strtotime($date)); ?>"
					rel-type="daily">Today</a>
            </div>
			
            <div id="staffModalBody" class="modal-body">
			<script type="text/javascript">

            	$(".staffSales").on('click',function(event){
            		event.preventDefault();
			 	staffSalesReport()
			 	event.preventDefault();
			
				/*$("#graph-merchant-ytd").on('click',function(){
					fetch_products_code1()
				});*/
				var since = $("#graph-merchant-since").attr('rel-type');
				var ytd = $("#graph-merchant-ytd").attr('rel-type');
				var mtd = $("#graph-merchant-mtd").attr('rel-type');
				var wtd = $("#graph-merchant-wtd").attr('rel-type');
				var daily = $("#graph-sales-daily").attr('rel-type');
				var hourly = $("#graph-merchant-hourly").attr('rel-type');
				//alert(test1);

				if(since == "since" && ytd != "ytd" && mtd != 'mtd' && wtd != 'wtd' && daily != 'daily' && hourly != 'hourly')
				{
					staffSalesReport()
				}
				else if(ytd == "ytd" && since != "since" && mtd != 'mtd' && wtd != 'wtd' && daily != 'daily' && hourly != 'hourly')
				{
			 		staffSalesReportYtd()
				}
				else if(mtd == 'mtd' && ytd != "ytd" && since != "since" && wtd != 'wtd' && daily != 'daily' && hourly != 'hourly' )
				{
			 		staffSalesReportMtd()
				}
				else if(wtd == 'wtd' && mtd != 'mtd' && ytd != "ytd" && since != "since" && daily != 'daily' && hourly != 'hourly'  )
				{
			 		staffSalesReportWtd()
				}
				else if(daily == 'daily' && wtd == 'wtd' && mtd != 'mtd' && ytd != "ytd" && since != "since" && hourly != 'hourly'  )
				{
			 		staffSalesReportToday()
				}
				/*else if(hourly == 'hourly' && daily == 'daily' && wtd == 'wtd' && mtd != 'mtd' && ytd != "ytd" && since != "since"   )
				{
			 		fetch_products_code_hourly()
				}*/
				
        });
			 	
				
				
        	
            	 function staffSalesReport(message = null) {

            	 	var id = $(this).attr("merchantrel");
					var filter = $(this).attr("rel");
			        
			        var fromDate = $('#from_date').val();
			        var toDate = $('#to_date').val();
					var country = $('.country-merchant-field').val();
					var state = $('.state-merchant-field').val();
					var city = $('.city-merchant-field').val();
					var marea = $('.area-merchant-field').val();
					var product = $('.product-merchant-field').val();
					var brand = $('.brand-merchant-field').val();
					var category = $('.category-merchant-field').val();
					var subcategory = $('.subcategory-merchant-field').val();
					var consumer = $('.consumer-merchant-field').val();
					var channel = $('.channel-merchant-field').val();

	            if (message) {
	                alert(message);
	                return;
	            }
	            $.ajax({
	            	
	                type: "GET",
	                url: "{{URL('/staffSales')}}",
	                data: { 
	                	fromDate: fromDate,
	                	toDate: toDate,
	                	toDate: toDate,
	                	country:country,
	                	state:state,
	                	city:city,
	                	marea:marea,
	                	product:product,
	                	brand:brand,
	                	category:category,
	                	subcategory:subcategory,
	                	consumer:consumer,
					    channel: channel
					    
					  },
	                success: function( list_staff_sales ) {
	                    setskuStaffSales(list_staff_sales);

	                }
	            });
	            
	        	}
            	function setskuStaffSales(list_staff_sales) {
            		
	        	jQuery(this).removeData();
	            var stafftablerow =` <table style="width: 100%; " id="stafftbl" class="table skutable">
     			
			
	              <thead class="bg-inventory">
	                <tr >
	                  <th class="text-left" scope="col" style="background-color:#0F71BA">Staff</th>
	                  <th class="text-center" scope="col">Barcode</th>
	                  <th class="text-right" scope="col">Sku</th>
	                  <th class="text-right" scope="col">npid</th>
	                  <th class="text-right" scope="col">total</th>
	                </tr>
	              </thead>
	              <tbody id="skutable-body">
	               `;
	            if(list_staff_sales == "No Data available"){
	            	
	            }
	            else
	            {




	            
	             var i = 0
	             
	            var k = list_staff_sales['0'].sales1 / list_staff_sales['0'].salesall * 100;
	            
	            jQuery.each( list_staff_sales, function( key, list_staff_sales ) {
	           
	            
	            bar1 = list_staff_sales.sales1 / list_staff_sales.salesall * 100;
	            if(i == 0 )
	            {
	            	
	            	bar = 600;
	            }
	            else
	            {
	            	
	            	bar2 = list_staff_sales.sales1 / list_staff_sales.salesall * 100;
	            	bar = 600/k*bar2;
	            }
	            i++;	            
	         	if(list_staff_sales.image == '')
	         	{
	         			stafftablerow+= `<tr>
	                        <td class="text-left"><img style="object-fit:cover;" width="30"  height="30" src="{{url()}}/placecards/dummy.jpg">
	                        <div class="progress1" style="margin: -3% 0% 1% 5%;">
							    <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="50" style="width:`+bar+`px; background-color: #84727a;">
							      <span class="sr-only">70% Complete</span>
							    </div> 
							    MYR  `+list_staff_sales.sales+`
							  </div> `+list_staff_sales.name+`&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							  </td></td>
	                        <td>`+list_staff_sales.uid+`</td>
	                        <td>`+list_staff_sales.sales_quantity+`</td>
	                        <td>`+list_staff_sales.date+`</td>
	                        <td>`+list_staff_sales.sales+`</td>
	                    </tr>
	                  `;
	         		}
	         		else
	         		{
	         			stafftablerow+= `<tr>
	                        <td class="text-left"><img style="object-fit:cover;" width="30"  height="30" src="{{url()}}/placecards/`+list_staff_sales.image+`">
	                        <div class="progress1" style="margin: -3% 0% 1% 5%;">
							    <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="50" style="width:`+bar+`px; background-color: #84727a;">
							      <span class="sr-only">70% Complete</span>
							    </div> 
							    MYR  `+list_staff_sales.sales+`
							  </div> `+list_staff_sales.name+`&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							  </td></td>
	                       <td>`+list_staff_sales.uid+`</td>
	                        <td>`+list_staff_sales.sales_quantity+`</td>
	                        <td>`+list_staff_sales.date+`</td>
	                        <td>`+list_staff_sales.sales+`</td>
	                    </tr>
	                  `;
	         		}
	                
	            });
	         } 

	            stafftablerow += ` </tbody>
	            </table>`;
	            $('#staffModalBody').html(stafftablerow);
	            $('#stafftbl').DataTable({
	                "aaSorting": [[ 4, 'desc' ]],
	                "columnDefs": [
	                    { "visible": false, "targets": 1 },
	                    { "visible": false, "targets": 2 },
	                    { "visible": false, "targets": 3 },
	                    { "visible": false, "targets": 4 }

	                ],
	                    language: {
	                       
	                        searchPlaceholder: "Staff ID, Staff Name"
	                }

	            });

	           /*Finesh*/
	        	
			
	        }
	        /*Staff Sales YTD Start*/
	        function staffSalesReportYtd(message = null) {
	        	var id = $(this).attr("merchantrel");
					var filter = $(this).attr("rel");
			        
			        var fromDate = $('#from_date').val();
			        var toDate = $('#to_date').val();
					var country = $('.country-merchant-field').val();
					var state = $('.state-merchant-field').val();
					var city = $('.city-merchant-field').val();
					var marea = $('.area-merchant-field').val();
					var product = $('.product-merchant-field').val();
					var brand = $('.brand-merchant-field').val();
					var category = $('.category-merchant-field').val();
					var subcategory = $('.subcategory-merchant-field').val();
					var consumer = $('.consumer-merchant-field').val();
					var channel = $('.channel-merchant-field').val();
            	 	
	            if (message) {
	                alert(message);
	                return;
	            }
	            $.ajax({

	                type: "GET",
	                url: "{{URL('/staffSalesYtd')}}",
	                data: { 
	                	fromDate: fromDate,
	                	toDate: toDate,
	                	toDate: toDate,
	                	country:country,
	                	state:state,
	                	city:city,
	                	marea:marea,
	                	product:product,
	                	brand:brand,
	                	category:category,
	                	subcategory:subcategory,
	                	consumer:consumer,
					    channel: channel
					    
					  },
	                success: function( list_staff_sales ) {
	                    setskuStaffSalesYtd(list_staff_sales);

	                }
	            });
	            
	        	}
            	function setskuStaffSalesYtd(list_staff_sales) {
            		
	        	jQuery(this).removeData();
	            var stafftablerow =` <table style="width: 100%; " id="stafftbl" class="table skutable">
     			
			
	              <thead class="bg-inventory">
	                <tr >
	                  <th class="text-left" scope="col" style="background-color:#0F71BA">Staff</th>
	                  <th class="text-center" scope="col">Barcode</th>
	                  <th class="text-right" scope="col">Sku</th>
	                  <th class="text-right" scope="col">npid</th>
	                  <th class="text-right" scope="col">total</th>
	                </tr>
	              </thead>
	              <tbody id="skutable-body">
	               `;
	            if(list_staff_sales == "No Data available"){
	            	
	            }
	            else
	            {
	            var i = 0
	            var k = list_staff_sales['0'].sales1 / list_staff_sales['0'].salesall * 100;

	            jQuery.each( list_staff_sales, function( key, list_staff_sales ) {
	           
	            
	            bar1 = list_staff_sales.sales1 / list_staff_sales.salesall * 100;
	            if(i == 0 )
	            {
	            	bar = 600;
	            }
	            else
	            {
	            	bar2 = list_staff_sales.sales1 / list_staff_sales.salesall * 100;
	            	bar = 600/k*bar2;
	            }
	            i++;	            
	         	if(list_staff_sales.image == '')
	         	{
	         			stafftablerow+= `<tr>
	                        <td class="text-left"><img style="object-fit:cover;" width="30"  height="30" src="{{url()}}/placecards/dummy.jpg">
	                        <div class="progress1" style="margin: -3% 0% 1% 5%;">
							    <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="50" style="width:`+bar+`px; background-color: #84727a;">
							      <span class="sr-only">70% Complete</span>
							    </div> 
							    MYR  `+list_staff_sales.sales+`
							  </div> `+list_staff_sales.name+`&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							  </td></td>
	                        <td>`+list_staff_sales.uid+`</td>
	                        <td>`+list_staff_sales.sales_quantity+`</td>
	                        <td>`+list_staff_sales.date+`</td>
	                        <td>`+list_staff_sales.sales+`</td>
	                    </tr>
	                  `;
	         		}
	         		else
	         		{
	         			stafftablerow+= `<tr>
	                        <td class="text-left"><img style="object-fit:cover;" width="30"  height="30" src="{{url()}}/placecards/`+list_staff_sales.image+`">
	                        <div class="progress1" style="margin: -3% 0% 1% 5%;">
							    <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="50" style="width:`+bar+`px; background-color: #84727a;">
							      <span class="sr-only">70% Complete</span>
							    </div> 
							    MYR  `+list_staff_sales.sales+`
							  </div> `+list_staff_sales.name+`&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							  </td></td>
	                        <td>`+list_staff_sales.uid+`</td>
	                        <td>`+list_staff_sales.sales_quantity+`</td>
	                        <td>`+list_staff_sales.date+`</td>
	                        <td>`+list_staff_sales.sales+`</td>
	                    </tr>
	                  `;
	         		}
	                
	            });
	         } 

	            stafftablerow += ` </tbody>
	            </table>`;
	            $('#staffModalBody').html(stafftablerow);
	            $('#stafftbl').DataTable({
	                "aaSorting": [[ 4, 'desc' ]],
	                "columnDefs": [
	                    { "visible": false, "targets": 1 },
	                    { "visible": false, "targets": 2 },
	                    { "visible": false, "targets": 3 },
	                    { "visible": false, "targets": 4 }

	                ],
	                    language: {
	                       
	                        searchPlaceholder: "Staff ID, Staff Name"
	                }

	            });

	           /*Finesh*/
	        	
			
	        }
	        /*Staff Sales YTD END*/

	        /*Staff Sales MTD Start*/
	        function staffSalesReportMtd(message = null) {

            	 var id = $(this).attr("merchantrel");
					var filter = $(this).attr("rel");
			        
			        var fromDate = $('#from_date').val();
			        var toDate = $('#to_date').val();
					var country = $('.country-merchant-field').val();
					var state = $('.state-merchant-field').val();
					var city = $('.city-merchant-field').val();
					var marea = $('.area-merchant-field').val();
					var product = $('.product-merchant-field').val();
					var brand = $('.brand-merchant-field').val();
					var category = $('.category-merchant-field').val();
					var subcategory = $('.subcategory-merchant-field').val();
					var consumer = $('.consumer-merchant-field').val();
					var channel = $('.channel-merchant-field').val();	
	            if (message) {
	                alert(message);
	                return;
	            }
	            $.ajax({

	                type: "GET",
	                url: "{{URL('/staffSalesMtd')}}",
	                data: { 
	                	fromDate: fromDate,
	                	toDate: toDate,
	                	toDate: toDate,
	                	country:country,
	                	state:state,
	                	city:city,
	                	marea:marea,
	                	product:product,
	                	brand:brand,
	                	category:category,
	                	subcategory:subcategory,
	                	consumer:consumer,
					    channel: channel
					    
					  },
	                success: function( list_staff_sales ) {
	                    setskuStaffSalesMtd(list_staff_sales);

	                }
	            });
	            
	        	}
            	function setskuStaffSalesMtd(list_staff_sales) {
            		
	        	jQuery(this).removeData();
	            var stafftablerow =` <table style="width: 100%; " id="stafftbl" class="table skutable">
     			
			
	              <thead class="bg-inventory">
	                <tr >
	                  <th class="text-left" scope="col" style="background-color:#0F71BA">Staff</th>
	                  <th class="text-center" scope="col">Barcode</th>
	                  <th class="text-right" scope="col">Sku</th>
	                  <th class="text-right" scope="col">npid</th>
	                  <th class="text-right" scope="col">total</th>
	                </tr>
	              </thead>
	              <tbody id="skutable-body">
	               `;
	            if(list_staff_sales == "No Data available"){
	            	
	            } else {
				var i = 0
	            var k = list_staff_sales['0'].sales1 / list_staff_sales['0'].salesall * 100;

	            jQuery.each( list_staff_sales, function( key, list_staff_sales ) {
	            
	            bar1 = list_staff_sales.sales1 / list_staff_sales.salesall * 100;
	            if(i == 0 ) {
	            	bar = 600;
	            } else {
	            	bar2 = list_staff_sales.sales1 / list_staff_sales.salesall * 100;
	            	bar = 600/k*bar2;
	            }
	            i++;	            
	         	if(list_staff_sales.image == '') {
	         			stafftablerow+= `<tr>
	                        <td class="text-left"><img style="object-fit:cover;" width="30"  height="30" src="{{url()}}/placecards/dummy.jpg">
	                        <div class="progress1" style="margin: -3% 0% 1% 5%;">
							    <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="50" style="width:`+bar+`px; background-color: #84727a;">
							      <span class="sr-only">70% Complete</span>
							    </div> 
							    MYR  `+list_staff_sales.sales+`
							  </div> `+list_staff_sales.name+`&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							  </td></td>
	                        <td>`+list_staff_sales.uid+`</td>
	                        <td>`+list_staff_sales.sales_quantity+`</td>
	                        <td>`+list_staff_sales.date+`</td>
	                        <td>`+list_staff_sales.sales+`</td>
	                    </tr>
	                  `;
	         		} else {
	         			stafftablerow+= `<tr>
	                        <td class="text-left"><img style="object-fit:cover;" width="30"  height="30" src="{{url()}}/placecards/`+list_staff_sales.image+`">
	                        <div class="progress1" style="margin: -3% 0% 1% 5%;">
							    <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="50" style="width:`+bar+`px; background-color: #84727a;">
							      <span class="sr-only">70% Complete</span>
							    </div> 
							    MYR  `+list_staff_sales.sales+`
							  </div> `+list_staff_sales.name+`&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							  </td></td>
	                        <td>`+list_staff_sales.uid+`</td>
	                        <td>`+list_staff_sales.sales_quantity+`</td>
	                        <td>`+list_staff_sales.date+`</td>
	                        <td>`+list_staff_sales.sales+`</td>
	                    </tr>
	                  `;
	         		}
	            });
	         } 

			stafftablerow += ` </tbody>
			</table>`;
			$('#staffModalBody').html(stafftablerow);
			$('#stafftbl').DataTable({
				"aaSorting": [[ 4, 'desc' ]],
				"columnDefs": [
					{ "visible": false, "targets": 1 },
					{ "visible": false, "targets": 2 },
					{ "visible": false, "targets": 3 },
					{ "visible": false, "targets": 4 }

				],
					language: {
						searchPlaceholder: "Staff ID, Staff Name"
				}

			});

		   /*Finesh*/
			
			
	        }
	        /*Staff Sales MTD END*/

	        /*Staff Sales WTD Start*/
	        function staffSalesReportWtd(message = null) {

            	var id = $(this).attr("merchantrel");
					var filter = $(this).attr("rel");
			        
			        var fromDate = $('#from_date').val();
			        var toDate = $('#to_date').val();
					var country = $('.country-merchant-field').val();
					var state = $('.state-merchant-field').val();
					var city = $('.city-merchant-field').val();
					var marea = $('.area-merchant-field').val();
					var product = $('.product-merchant-field').val();
					var brand = $('.brand-merchant-field').val();
					var category = $('.category-merchant-field').val();
					var subcategory = $('.subcategory-merchant-field').val();
					var consumer = $('.consumer-merchant-field').val();
					var channel = $('.channel-merchant-field').val();

	            if (message) {
	                alert(message);
	                return;
	            }
	            $.ajax({

	                type: "GET",
	                url: "{{URL('/staffSalesWtd')}}",
	                data: { 
	                	fromDate: fromDate,
	                	toDate: toDate,
	                	toDate: toDate,
	                	country:country,
	                	state:state,
	                	city:city,
	                	marea:marea,
	                	product:product,
	                	brand:brand,
	                	category:category,
	                	subcategory:subcategory,
	                	consumer:consumer,
					    channel: channel
					},
					success: function( list_staff_sales ) {
	                    setskuStaffSalesWtd(list_staff_sales);

	                }
	            });
	            
	        	}
            	function setskuStaffSalesWtd(list_staff_sales) {
            		
	        	jQuery(this).removeData();
	            var stafftablerow =` <table style="width: 100%; " id="stafftbl" class="table skutable">
     			
			
	              <thead class="bg-inventory">
	                <tr >
	                  <th class="text-left" scope="col" style="background-color:#0F71BA">Staff</th>
	                  <th class="text-center" scope="col">Barcode</th>
	                  <th class="text-right" scope="col">Sku</th>
	                  <th class="text-right" scope="col">npid</th>
	                  <th class="text-right" scope="col">total</th>
	                </tr>
	              </thead>
	              <tbody id="skutable-body">
	               `;
	            if(list_staff_sales == "No Data available"){
	            	
	            } else {
				var i = 0
	            var k = list_staff_sales['0'].sales1 / list_staff_sales['0'].salesall * 100;

	            jQuery.each( list_staff_sales, function( key, list_staff_sales ) {
	            
	            bar1 = list_staff_sales.sales1 / list_staff_sales.salesall * 100;
	            if(i == 0 ) {
	            	bar = 600;
	            } else {
	            	bar2 = list_staff_sales.sales1 / list_staff_sales.salesall * 100;
	            	bar = 600/k*bar2;
	            }
	            i++;	            
	         	if(list_staff_sales.image == '') {
	         			stafftablerow+= `<tr>
	                        <td class="text-left"><img style="object-fit:cover;" width="30"  height="30" src="{{url()}}/placecards/dummy.jpg">
	                        <div class="progress1" style="margin: -3% 0% 1% 5%;">
							    <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="50" style="width:`+bar+`px; background-color: #84727a;">
							      <span class="sr-only">70% Complete</span>
							    </div> 
							    MYR  `+list_staff_sales.sales+`
							  </div> `+list_staff_sales.name+`&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							  </td></td>
	                       <td>`+list_staff_sales.uid+`</td>
	                        <td>`+list_staff_sales.sales_quantity+`</td>
	                        <td>`+list_staff_sales.date+`</td>
	                        <td>`+list_staff_sales.sales+`</td>
	                    </tr>
	                  `;
	         		} else {
	         			stafftablerow+= `<tr>
	                        <td class="text-left"><img style="object-fit:cover;" width="30"  height="30" src="{{url()}}/placecards/`+list_staff_sales.image+`">
	                        <div class="progress1" style="margin: -3% 0% 1% 5%;">
							    <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="50" style="width:`+bar+`px; background-color: #84727a;">
							      <span class="sr-only">70% Complete</span>
							    </div> 
							    MYR  `+list_staff_sales.sales+`
							  </div> `+list_staff_sales.name+`&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							  </td></td>
	                        <td>`+list_staff_sales.uid+`</td>
	                        <td>`+list_staff_sales.sales_quantity+`</td>
	                        <td>`+list_staff_sales.date+`</td>
	                        <td>`+list_staff_sales.sales+`</td>
	                    </tr>
	                  `;
	         		}
	            });
	         } 

	            stafftablerow += ` </tbody>
	            </table>`;
	            $('#staffModalBody').html(stafftablerow);
	            $('#stafftbl').DataTable({
	                "aaSorting": [[ 4, 'desc' ]],
	                "columnDefs": [
	                    { "visible": false, "targets": 1 },
	                    { "visible": false, "targets": 2 },
	                    { "visible": false, "targets": 3 },
	                    { "visible": false, "targets": 4 }

	                ],
	                    language: {
	                        searchPlaceholder: "Staff ID, Staff Name"
	                }
	            });

	           /*Finesh*/
	        }
	        /*Staff Sales WTD END*/

	        /*Staff Sales Today Start*/
	        function staffSalesReportToday(message = null) {

            	 var id = $(this).attr("merchantrel");
					var filter = $(this).attr("rel");
			        
			        var fromDate = $('#from_date').val();
			        var toDate = $('#to_date').val();
					var country = $('.country-merchant-field').val();
					var state = $('.state-merchant-field').val();
					var city = $('.city-merchant-field').val();
					var marea = $('.area-merchant-field').val();
					var product = $('.product-merchant-field').val();
					var brand = $('.brand-merchant-field').val();
					var category = $('.category-merchant-field').val();
					var subcategory = $('.subcategory-merchant-field').val();
					var consumer = $('.consumer-merchant-field').val();
					var channel = $('.channel-merchant-field').val();
	            if (message) {
	                alert(message);
	                return;
	            }
	            $.ajax({

	                type: "GET",
	                url: "{{URL('/staffSalesToday')}}",
	                data: { 
	                	fromDate: fromDate,
	                	toDate: toDate,
	                	toDate: toDate,
	                	country:country,
	                	state:state,
	                	city:city,
	                	marea:marea,
	                	product:product,
	                	brand:brand,
	                	category:category,
	                	subcategory:subcategory,
	                	consumer:consumer,
					    channel: channel
					    
					  },
	                success: function( list_staff_sales ) {
	                    setskuStaffSalesToday(list_staff_sales);

	                }
	            });
	            
	        	}
            	function setskuStaffSalesToday(list_staff_sales) {
            		
	        	jQuery(this).removeData();
	            var stafftablerow =` <table style="width: 100%; " id="stafftbl" class="table skutable">
     			
			
	              <thead class="bg-inventory">
	                <tr >
	                  <th class="text-left" scope="col" style="background-color:#0F71BA">Staff</th>
	                  <th class="text-center" scope="col">Barcode</th>
	                  <th class="text-right" scope="col">Sku</th>
	                  <th class="text-right" scope="col">npid</th>
	                  <th class="text-right" scope="col">total</th>
	                </tr>
	              </thead>
	              <tbody id="skutable-body">
	               `;
	            if(list_staff_sales == "No Data available"){
	            	
	            } else {
				var i = 0
	            var k = list_staff_sales['0'].sales1 / list_staff_sales['0'].salesall * 100;

	            jQuery.each( list_staff_sales, function( key, list_staff_sales ) {
	           
	            
	            bar1 = list_staff_sales.sales1 / list_staff_sales.salesall * 100;
	            if(i == 0 ) {
	            	bar = 600;
	            } else {
	            	bar2 = list_staff_sales.sales1 / list_staff_sales.salesall * 100;
	            	bar = 600/k*bar2;
	            }
	            i++;	            
	         	if(list_staff_sales.image == '') {
	         			stafftablerow+= `<tr>
	                        <td class="text-left"><img style="object-fit:cover;" width="30"  height="30" src="{{url()}}/placecards/dummy.jpg">
	                        <div class="progress1" style="margin: -3% 0% 1% 5%;">
							    <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="50" style="width:`+bar+`px; background-color: #84727a;">
							      <span class="sr-only">70% Complete</span>
							    </div> 
							    MYR  `+list_staff_sales.sales+`
							  </div> `+list_staff_sales.name+`&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							  </td></td>
	                        <td>`+list_staff_sales.uid+`</td>
	                        <td>`+list_staff_sales.sales_quantity+`</td>
	                        <td>`+list_staff_sales.date+`</td>
	                        <td>`+list_staff_sales.sales+`</td>
	                    </tr>
	                  `;
	         		} else {
	         			stafftablerow+= `<tr>
	                        <td class="text-left"><img style="object-fit:cover;" width="30"  height="30" src="{{url()}}/placecards/`+list_staff_sales.image+`">
	                        <div class="progress1" style="margin: -3% 0% 1% 5%;">
							    <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="50" style="width:`+bar+`px; background-color: #84727a;">
							      <span class="sr-only">70% Complete</span>
							    </div> 
							    MYR  `+list_staff_sales.sales+`
							  </div> `+list_staff_sales.name+`&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							  </td></td>
	                        <td>`+list_staff_sales.uid+`</td>
	                        <td>`+list_staff_sales.sales_quantity+`</td>
	                        <td>`+list_staff_sales.date+`</td>
	                        <td>`+list_staff_sales.sales+`</td>
	                    </tr>
	                  `;
	         		}
	            });
	         } 

	            stafftablerow += ` </tbody>
	            </table>`;
	            $('#staffModalBody').html(stafftablerow);
	            $('#stafftbl').DataTable({
	                "aaSorting": [[ 4, 'desc' ]],
	                "columnDefs": [
	                    { "visible": false, "targets": 1 },
	                    { "visible": false, "targets": 2 },
	                    { "visible": false, "targets": 3 },
	                    { "visible": false, "targets": 4 }

	                ],
	                    language: {
	                        searchPlaceholder: "Staff ID, Staff Name"
	                }
	            });

	           /*Finesh*/
	           //  $('#skumodel').modal('show');
	        }
	       
	</script>
            </div>
        </div>
		</div>
	</div>  -->
</div>
<script>

	// function staffSales1()
	// {
	// 	 $.ajax({
 //                type: "GET",
 //                url: JS_BASE_URL+"/merchant/staffsales",
               
 //                success: function( data ) {
 //                    // console.log(data)
 //                }
 //            });
	// }
	// function staffSales1()
	// {
	// 	 $.ajax({
 //                type: "GET",
 //                url: JS_BASE_URL+"/merchant/productsales",
 //                success: function( data ) {
 //                    // console.log(data)
 //                }
 //            });
	// }
</script>
<!-- <script type="text/javascript">
			//$(document).on('click','#skumodel',function(){
			$("#skumodel").on('click',function(event){
				event.preventDefault();
				
					/*$("#graph-merchant-ytd").on('click',function(){
						fetch_products_code1()
					});*/
					var since = $("#graph-merchant-since").attr('rel-type');
					var ytd = $("#graph-merchant-ytd").attr('rel-type');
					var mtd = $("#graph-merchant-mtd").attr('rel-type');
					var wtd = $("#graph-merchant-wtd").attr('rel-type');
					var daily = $("#graph-sales-daily").attr('rel-type');
					var hourly = $("#graph-merchant-hourly").attr('rel-type');
					//alert(test1);

					if(since == "since" && ytd != "ytd" && mtd != 'mtd' && wtd != 'wtd' && daily != 'daily' && hourly != 'hourly') {
						fetch_products_code()		
					} else if(ytd == "ytd" && since != "since" && mtd != 'mtd' && wtd != 'wtd' && daily != 'daily' && hourly != 'hourly') {
				 		fetch_products_ytd()
					} else if(mtd != 'mtd' && ytd != "ytd" && since != "since" && wtd != 'wtd' && daily != 'daily' && hourly != 'hourly' ) {
				 		fetch_products_code_mtd()
					} else if(wtd == 'wtd' && mtd != 'mtd' && ytd != "ytd" && since != "since" && daily != 'daily' && hourly != 'hourly'  ) {
				 		fetch_products_code_wtd()
					} else if(daily == 'daily' && wtd == 'wtd' && mtd != 'mtd' && ytd != "ytd" && since != "since" && hourly != 'hourly'  ) {
				 		fetch_products_code_daily()
					} else if(hourly == 'hourly' && daily == 'daily' && wtd == 'wtd' && mtd != 'mtd' && ytd != "ytd" && since != "since"   ) {
				 		fetch_products_code_hourly()
					}
	        });


		 	function fetch_products_code(message = null) {
		            if (message) {
		                alert(message);
		                return;
		            }
	                var since = $("#graph-merchant-since").attr('rel-type');
					var ytd = $("#graph-merchant-ytd").attr('rel-type');
					var mtd = $("#graph-merchant-mtd").attr('rel-type');
					var wtd = $("#graph-merchant-wtd").attr('rel-type');
					var daily = $("#graph-sales-daily").attr('rel-type');



					    var id = $(this).attr("merchantrel");
	                    var filter = $(this).attr("rel");
	                    
	                    var fromDate = $('#from_date').val();
	                    var toDate = $('#to_date').val();
	                    var country = $('.country-merchant-field').val();
	                    var state = $('.state-merchant-field').val();
	                    var city = $('.city-merchant-field').val();
	                    var marea = $('.area-merchant-field').val();
	                    var product = $('.product-merchant-field').val();
	                    var brand = $('.brand-merchant-field').val();
	                    var category = $('.category-merchant-field').val();
	                    var subcategory = $('.subcategory-merchant-field').val();
	                    var channel = $('.channel-merchant-field').val();
					if(since == "since")
					{
						$.ajax({
		                type: "GET",
		                url: "{{URL('/skulist_since')}}",
		                 data: {
	                        fromDate: fromDate,
	                        toDate: toDate,
	                        toDate: toDate,
	                        country:country,
	                        state:state,
	                        city:city,
	                        marea:marea,
	                        product:product,
	                        brand:brand,
	                        category:category,
	                        subcategory:subcategory,
	                       channel: channel

	                        
	                      },

		                success: function( listproducts ) {
		                    setskudatatable(listproducts);

		                }
		            });
					}
					else if(ytd == "ytd")
					{
				 		
				 		$.ajax({
		                type: "GET",
		                url: "{{URL('/skulist_ytd')}}",

		                 data: {
	                        fromDate: fromDate,
	                        toDate: toDate,
	                        toDate: toDate,
	                       country:country,
	                        state:state,
	                        city:city,
	                       marea:marea,
	                        product:product,
	                        brand:brand,
	                        category:category,
	                        subcategory:subcategory,
	                       channel: channel

	                        
	                      },

		                success: function( listproducts1 ) {
		                    setskudatatable1(listproducts1);

		                }
		            });
					}
					else if(mtd == "mtd")
					{
				 		 var channel = $('.channel-merchant-field').val();
				 		$.ajax({
		                type: "GET",
		                url: "{{URL('/skulist_mtd')}}",
		                 data: {
	                        fromDate: fromDate,
	                        toDate: toDate,
	                        toDate: toDate,
	                        country:country,
	                        state:state,
	                        city:city,
	                        marea:marea,
	                        product:product,
	                        brand:brand,
	                        category:category,
	                        subcategory:subcategory,
	                        channel: channel
	                     
	                        
	                      },
		                success: function( listproducts_mtd ) {
		                    setskudatatable1(listproducts_mtd);

		                }
		            });
					}
					else if(wtd == "wtd")
					{
				 		
				 		$.ajax({
		                type: "GET",
		                url: "{{URL('/skulist_wtd')}}",
		                 data: {
	                        fromDate: fromDate,
	                        toDate: toDate,
	                        toDate: toDate,
	                       country:country,
	                        state:state,
	                        city:city,
	                       marea:marea,
	                        product:product,
	                        brand:brand,
	                        category:category,
	                        subcategory:subcategory,
	                       channel: channel

	                        
	                      },
		                success: function( listproducts_wtd ) {
		                    setskudatatable1(listproducts_wtd);

		                }
		            });
					}
					
					else if(daily == "daily")
					{
				 		
				 		$.ajax({
		                type: "GET",
		                url: "{{URL('/skulist_daily')}}",
		                 data: {
	                        fromDate: fromDate,
	                        toDate: toDate,
	                        toDate: toDate,
	                       country:country,
	                        state:state,
	                        city:city,
	                       marea:marea,
	                        product:product,
	                        brand:brand,
	                        category:category,
	                        subcategory:subcategory,
	                       channel: channel

	                        
	                      },
		                success: function( listproducts_daily ) {
		                    setskudatatable1(listproducts_daily);

		                }
		            });
					}
		            
		        }
		      
			function setskudatatable(listproducts) {

		            var skutablerow =` <table style="width: 100%;" id="skutbl" class="table1 skutable">
		            
		              <thead class="bg-inventory">
		                <tr >
		                  <th class="text-left no-sort" scope="col">Product</th>
		                  <th class="text-center" scope="col">Barcode</th>
		                  <th class="text-right" scope="col">Sku</th>
		                  <th class="text-right" scope="col">npid</th>
		                  <th class="text-right" scope="col">price</th>
		                </tr>
		              </thead>
		              <tbody id="skutable-body">
		               `;
		          /*  if(listproducts_wtd == "No data available"){

		            	
		            }
		            else
		            {*/
		            	var pricesum1 = '';
		            	var totalProduct = '';
		             
		            jQuery.each( listproducts, function( key, listproduct ) {
		            	console.log(listproduct);
		             	if(pricesum1 == '' && totalProduct == '')
		             	{
		             		
		            	    pricesum1 = listproducts.pricesum1; 
		            	    totalProduct = listproducts.totalProduct; 	
		             	}
		            });
		           
		            var i = 0;
		            var k = pricesum1 / totalProduct * 100; 	
		            jQuery.each( listproducts, function( key, listproduct ) {
		            	/*alert(listproduct.price)*/
		            	//alert(listproduct.name)

						console.log(listproduct);

		            
			            bar1 = listproduct.pricesum1 / listproduct.totalProduct * 100;
			            if(i == 0 )
			            {
			            	bar = 600;
			            }
			            else
			            {
			            	bar2 = listproduct.pricesum1 / listproduct.totalProduct * 100;
			            	bar = 600/k*bar2;
			            }
			            i++;
			            
			                skutablerow+= `<tr>
			                        <td class="text-left"><img style="object-fit:cover;" width="30"  height="30" src="{{url()}}/images/product/`+listproduct.id+`/thumb/`+listproduct.thumb_photo+`">
			                        <div class="progress1" style="margin: -3% 0% 1% 5%; ">
									    <div class="progress-bar" role="progress1" aria-valuenow="70" aria-valuemin="0" aria-valuemax="50" style="width:`+bar+`%; /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#b4ddb4+0,83c783+17,52b152+33,008a00+67,005700+83,002400+100;Green+3D+%231 */
										background: #b4ddb4; /* Old browsers */
										background: -moz-linear-gradient(-45deg, #b4ddb4 0%, #83c783 17%, #52b152 33%, #008a00 67%, #005700 83%, #002400 100%); /* FF3.6-15 */
										background: -webkit-linear-gradient(-45deg, #b4ddb4 0%,#83c783 17%,#52b152 33%,#008a00 67%,#005700 83%,#002400 100%); /* Chrome10-25,Safari5.1-6 */
										background: linear-gradient(135deg, #b4ddb4 0%,#83c783 17%,#52b152 33%,#008a00 67%,#005700 83%,#002400 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
										filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#b4ddb4', endColorstr='#002400',GradientType=1 ); /* IE6-9 fallback on horizontal gradient */">
									 </div><span style="color:red;"> MYR  `+ listproduct.pricedata +`</span>								     
									  </div> `+listproduct.name+`</td>
			                        <td>`+listproduct.barcode+`</td>
			                        <td>`+listproduct.sku+`</td>
			                        <td>`+listproduct.npid+`</td>
			                        <td>`+listproduct.pricesum+`</td>
			                    </tr>
			                  `;
		            });
		      	// }
		            skutablerow += ` </tbody>
		            </table>`;
		            $('#skumodalbody').html(skutablerow);
		            $('#skutbl').DataTable({
		            	//"order": [[ 4, 'desc' ]],
		            	"aaSorting": [[ 4, 'desc' ]],
		                "columnDefs": [
		                    { "visible": false, "targets": 1 },
		                    { "visible": false, "targets": 2 },
		                    { "visible": false, "targets": 3 },
		                    { "visible": false, "targets": 4 }

		                ],
		                    language: {
		                        searchPlaceholder: "Product Name, Product ID, Barcode or SKU"
		                },
		                 


		            });

		           /*Finesh*/
		             $('#skumodel').modal('show');

		     }
	        function fetch_products_ytd(message = null) {

	            if (message) {
	                alert(message);
	                return;
	            }
	                var id = $(this).attr("merchantrel");
	                var filter = $(this).attr("rel");
	                
	                var fromDate = $('#from_date').val();
	                var toDate = $('#to_date').val();
	                var country = $('.country-merchant-field').val();
	                var state = $('.state-merchant-field').val();
	                var city = $('.city-merchant-field').val();
	                var marea = $('.area-merchant-field').val();
	                var product = $('.product-merchant-field').val();
	                var brand = $('.brand-merchant-field').val();
	                var category = $('.category-merchant-field').val();
	                var subcategory = $('.subcategory-merchant-field').val();
	                var channel = $('.channel-merchant-field').val();
	            $.ajax({

	                type: "GET",
	                url: "{{URL('/skulist_ytd')}}",
	                 data: {
	                    country:country,
	                    state:state,
	                    city:city,
	                   marea:marea,
	                    product:product,
	                    brand:brand,
	                    category:category,
	                    subcategory:subcategory,
	                   channel: channel

	                    
	                  },
	                success: function( listproducts_ytd ) {
	                    setskudatatable(listproducts_ytd);

	                }
	            });
	        }

		        function setskudatatable(listproducts_ytd) {
		        	jQuery(this).removeData();
		            var skutablerow =` <table style="width: 100%; " id="skutbl" class="table1 skutable">
	     			
				
		              <thead class="bg-inventory">
		                <tr >
		                  <th class="text-left" scope="col">Product</th>
		                  <th class="text-center" scope="col">Barcode</th>
		                  <th class="text-right" scope="col">Sku</th>
		                  <th class="text-right" scope="col">npid</th>
		                  <th class="text-right" scope="col">price</th>
		                </tr>
		              </thead>
		              <tbody id="skutable-body">
		               `;
		            if(listproducts_ytd == "No data available"){

		            	
		            }
		            else
		            {
		            	var pricesum1 = '';
		            	var totalProduct = '';
		             jQuery.each( listproducts_ytd, function( key, listproducts_ytd ) {
		             	if(pricesum1 == '' && totalProduct == '')
		             	{
		            	//alert(listproducts_ytd.pricesum1;)
		            		pricesum1 = listproducts_ytd.pricesum1; 
		            		totalProduct = listproducts_ytd.totalProduct; 
		            		//alert(pricesum1)
		             	}
		            	
		            });
		            
		             
		            var i = 0;
		            var k = pricesum1 / totalProduct * 100;
		            
		            jQuery.each( listproducts_ytd, function( key, listproducts_ytd ) {
		            //alert(listproducts_ytd.pricesum)
		            
		            bar1 = listproducts_ytd.pricesum1 / listproducts_ytd.totalProduct * 100;
		            if(i == 0 )
		            {
		            	bar = 600;
		            	//alert(bar)
		            }
		            else
		            {
		            	bar2 = listproducts_ytd.pricesum1 / listproducts_ytd.totalProduct * 100;
		            	bar = 600/k*bar2;
		            	//alert(bar)
		            }
		            i++;
		            
		                skutablerow+= `<tr>
		                        <td class="text-left"><img style="object-fit:cover;" width="30"  height="30" src="{{url()}}/images/product/`+listproducts_ytd.id+`/thumb/`+listproducts_ytd.thumb_photo+`">
		                        <div class="progress1" style="margin: -3% 0% 1% 5%;">
								    <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="50" style="width:`+bar+`px; /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#b4ddb4+0,83c783+17,52b152+33,008a00+67,005700+83,002400+100;Green+3D+%231 */
										background: #b4ddb4; /* Old browsers */
										background: -moz-linear-gradient(-45deg, #b4ddb4 0%, #83c783 17%, #52b152 33%, #008a00 67%, #005700 83%, #002400 100%); /* FF3.6-15 */
										background: -webkit-linear-gradient(-45deg, #b4ddb4 0%,#83c783 17%,#52b152 33%,#008a00 67%,#005700 83%,#002400 100%); /* Chrome10-25,Safari5.1-6 */
										background: linear-gradient(135deg, #b4ddb4 0%,#83c783 17%,#52b152 33%,#008a00 67%,#005700 83%,#002400 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
										filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#b4ddb4', endColorstr='#002400',GradientType=1 ); /* IE6-9 fallback on horizontal gradient */">
								    </div> <span style="color:red;"> MYR  `+ listproducts_ytd.pricesum +`</span>
								  </div> `+listproducts_ytd.name+` </td>
		                        <td>`+listproducts_ytd.barcode+`</td>
		                        <td>`+listproducts_ytd.sku+`</td>
		                        <td>`+listproducts_ytd.npid+`</td>
		                        <td>`+listproducts_ytd.pricesum+`</td>
		                    </tr>
		                  `;
		            });
		        }
		            skutablerow += ` </tbody>
		            </table>`;
		            $('#skumodalbody').html(skutablerow);
		            $('#skutbl').DataTable({
		              // "order": [[ 4, 'desc' ]],
		               "aaSorting": [[ 4, 'desc' ]],
		                "columnDefs": [
		                    { "visible": false, "targets": 1 },
		                    { "visible": false, "targets": 2 },
		                    { "visible": false, "targets": 3 },
		                    { "visible": false, "targets": 4 }

		                ],
		                    language: {
		                       
		                        searchPlaceholder: "Product Name, Product ID, Barcode or SKU"
		                }

		            });

		           /*Finesh*/
		             $('#skumodel').modal('show');

		        }

				/*MTD button code*/
		        function fetch_products_code_mtd(message = null) {

		            if (message) {
		                alert(message);
		                return;
		            }

		                var id = $(this).attr("merchantrel");
	                    var filter = $(this).attr("rel");
	                    
	                    var fromDate = $('#from_date').val();
	                    var toDate = $('#to_date').val();
	                    var country = $('.country-merchant-field').val();
	                    var state = $('.state-merchant-field').val();
	                    var city = $('.city-merchant-field').val();
	                    var marea = $('.area-merchant-field').val();
	                    var product = $('.product-merchant-field').val();
	                    var brand = $('.brand-merchant-field').val();
	                    var category = $('.category-merchant-field').val();
	                    var subcategory = $('.subcategory-merchant-field').val();
	                    var channel = $('.channel-merchant-field').val();
		            $.ajax({

		                type: "GET",
		                url: "{{URL('/skulist_mtd')}}",
		                data: {
	                        fromDate: fromDate,
	                        toDate: toDate,
	                        toDate: toDate,
	                       country:country,
	                        state:state,
	                        city:city,
	                        marea:marea,
	                        product:product,
	                        brand:brand,
	                        category:category,
	                        subcategory:subcategory,
	                        channel: channel
	                     
	                        
	                      },
		                success: function( listproducts_mtd ) {
		                    setskudatatable1(listproducts_mtd);

		                }
		            });
		        }

		        function setskudatatable1(listproducts_mtd) {
		        	jQuery(this).removeData();
		            var skutablerow =` <table style="width: 100%; " id="skutbl" class="table1 skutable">
	     			
				
		              <thead class="bg-inventory">
		                <tr >
		                  <th class="text-left" scope="col">Product</th>
		                  <th class="text-center" scope="col">Barcode</th>
		                  <th class="text-right" scope="col">Sku</th>
		                  <th class="text-right" scope="col">npid</th>
		                  <th class="text-right" scope="col">price</th>
		                </tr>
		              </thead>
		              <tbody id="skutable-body">
		               `;
		            if(listproducts_mtd == "No data available"){
		            	
		            	
		            }
		            else
		            {

		             var pricesum1 = '';
		             var totalProduct = '';
		             jQuery.each( listproducts_mtd, function( key, listproducts_mtd ) {
		             if(pricesum1 == '' && totalProduct == '')
		             {
		            		 pricesum1 = listproducts_mtd.pricesum1; 
		            		 totalProduct = listproducts_mtd.totalProduct; 
		             		
		            }
		            });
		             
		            var i = 0;
		            var k = pricesum1 / totalProduct * 100;

		           
		            
		            jQuery.each( listproducts_mtd, function( key, listproducts_mtd ) {
		            
		            bar1 = listproducts_mtd.pricesum1 / listproducts_mtd.totalProduct * 100;
		            if(i == 0 )
		            {
		            	
		            	bar = 600;
		            }
		            else
		            {
		            	          	
		            	
		            	bar2 = listproducts_mtd.pricesum1 / listproducts_mtd.totalProduct * 100;
		            	bar = 600/k*bar2;
		            }
		            i++;
		         
		                skutablerow+= `<tr>
		                        <td class="text-left"><img style="object-fit:cover;" width="30"  height="30" src="{{url()}}/images/product/`+listproducts_mtd.id+`/thumb/`+listproducts_mtd.thumb_photo+`">
		                        <div class="progress1" style="margin: -3% 0% 1% 5%;">
								    <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="50" style="width:`+bar+`px; /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#b4ddb4+0,83c783+17,52b152+33,008a00+67,005700+83,002400+100;Green+3D+%231 */
										background: #b4ddb4; /* Old browsers */
										background: -moz-linear-gradient(-45deg, #b4ddb4 0%, #83c783 17%, #52b152 33%, #008a00 67%, #005700 83%, #002400 100%); /* FF3.6-15 */
										background: -webkit-linear-gradient(-45deg, #b4ddb4 0%,#83c783 17%,#52b152 33%,#008a00 67%,#005700 83%,#002400 100%); /* Chrome10-25,Safari5.1-6 */
										background: linear-gradient(135deg, #b4ddb4 0%,#83c783 17%,#52b152 33%,#008a00 67%,#005700 83%,#002400 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
										filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#b4ddb4', endColorstr='#002400',GradientType=1 ); /* IE6-9 fallback on horizontal gradient */">
								     </div><span style="color:red;"> MYR  `+ listproducts_mtd.pricesum +`</span>
								  </div> `+listproducts_mtd.name+` </td>
		                        <td>`+listproducts_mtd.barcode+`</td>
		                        <td>`+listproducts_mtd.sku+`</td>
		                        <td>`+listproducts_mtd.npid+`</td>
		                        <td>`+listproducts_mtd.pricesum+`</td>
		                    </tr>
		                  `;
		            });
		         } 

		            skutablerow += ` </tbody>
		            </table>`;
		            $('#skumodalbody').html(skutablerow);
		            $('#skutbl').DataTable({
		                "aaSorting": [[ 4, 'desc' ]],
		                "columnDefs": [
		                    { "visible": false, "targets": 1 },
		                    { "visible": false, "targets": 2 },
		                    { "visible": false, "targets": 3 },
		                    { "visible": false, "targets": 4 }

		                ],
		                    language: {
		                       
		                        searchPlaceholder: "Product Name, Product ID, Barcode or SKU"
		                }

		            });

		           /*Finesh*/
		             $('#skumodel').modal('show');

		        }


			/*WTD button code*/
		        function fetch_products_code_wtd(message = null) {

		            if (message) {
		                alert(message);
		                return;
		            }
		               var id = $(this).attr("merchantrel");
	                    var filter = $(this).attr("rel");
	                    
	                    var fromDate = $('#from_date').val();
	                    var toDate = $('#to_date').val();
	                    var country = $('.country-merchant-field').val();
	                    var state = $('.state-merchant-field').val();
	                    var city = $('.city-merchant-field').val();
	                    var marea = $('.area-merchant-field').val();
	                    var product = $('.product-merchant-field').val();
	                    var brand = $('.brand-merchant-field').val();
	                    var category = $('.category-merchant-field').val();
	                    var subcategory = $('.subcategory-merchant-field').val();
	                    var channel = $('.channel-merchant-field').val();
		            $.ajax({

		                type: "GET",
		                url: "{{URL('/skulist_wtd')}}",
		                 data: {
	                        fromDate: fromDate,
	                        toDate: toDate,
	                        toDate: toDate,
	                       country:country,
	                        state:state,
	                        city:city,
	                       marea:marea,
	                        product:product,
	                        brand:brand,
	                        category:category,
	                        subcategory:subcategory,
	                       channel: channel

	                        
	                      },
		                success: function( listproducts_wtd ) {
		                    setskudatatable1(listproducts_wtd);

		                }
		            });
		        }

		        function setskudatatable1(listproducts_wtd) {
		        	jQuery(this).removeData();
		            var skutablerow =` <table style="width: 100%; " id="skutbl" class="table1 skutable">
	     			
				
		              <thead class="bg-inventory">
		                <tr >
		                  <th class="text-left" scope="col">Product</th>
		                  <th class="text-center" scope="col">Barcode</th>
		                  <th class="text-right" scope="col">Sku</th>
		                  <th class="text-right" scope="col">npid</th>
		                  <th class="text-right" scope="col">price</th>
		                </tr>
		              </thead>
		              <tbody id="skutable-body">
		               `;
		            if(listproducts_wtd == "No data available"){

		            	
		            }
		            else
		            {

		             var pricesum1 = '';
		             var totalProduct = '';
		             jQuery.each( listproducts_wtd, function( key, listproducts_wtd ) {
		             if(pricesum1 == '' && totalProduct == '')
		             {
		            		 pricesum1 = listproducts_wtd.pricesum1; 
		            		 totalProduct = listproducts_wtd.totalProduct; 
		             		
		            }
		            });
		             
		            var i = 0;
		            var k = pricesum1 / totalProduct * 100;

		            
		            
		            jQuery.each( listproducts_wtd, function( key, listproducts_wtd ) {
		            
		          
		            bar1 = listproducts_wtd.pricesum1 / listproducts_wtd.totalProduct * 100;
		            if(i == 0 )
		            {
		            	bar = 600;
		            }
		            else
		            {
		            	bar2 = listproducts_wtd.pricesum1 / listproducts_wtd.totalProduct * 100;
		            	bar = 600/k*bar2;
		            }
		            i++;
		                skutablerow+= `<tr>
		                        <td class="text-left"><img style="object-fit:cover;" width="30"  height="30" src="{{url()}}/images/product/`+listproducts_wtd.id+`/thumb/`+listproducts_wtd.thumb_photo+`">
		                        <div class="progress1" style="margin: -3% 0% 1% 5%;">
								    <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="50" style="width:`+bar+`px; /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#b4ddb4+0,83c783+17,52b152+33,008a00+67,005700+83,002400+100;Green+3D+%231 */
										background: #b4ddb4; /* Old browsers */
										background: -moz-linear-gradient(-45deg, #b4ddb4 0%, #83c783 17%, #52b152 33%, #008a00 67%, #005700 83%, #002400 100%); /* FF3.6-15 */
										background: -webkit-linear-gradient(-45deg, #b4ddb4 0%,#83c783 17%,#52b152 33%,#008a00 67%,#005700 83%,#002400 100%); /* Chrome10-25,Safari5.1-6 */
										background: linear-gradient(135deg, #b4ddb4 0%,#83c783 17%,#52b152 33%,#008a00 67%,#005700 83%,#002400 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
										filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#b4ddb4', endColorstr='#002400',GradientType=1 ); /* IE6-9 fallback on horizontal gradient */">
								    <span style="color:red;"> MYR  `+ listproducts_wtd.pricesum +`</span>
								    </div> 
								  </div> `+listproducts_wtd.name+`</td>
		                        <td>`+listproducts_wtd.barcode+`</td>
		                        <td>`+listproducts_wtd.sku+`</td>
		                        <td>`+listproducts_wtd.npid+`</td>
		                        <td>`+listproducts_wtd.pricesum+`</td>
		                    </tr>
		                  `;
		            });
		         } 

		            skutablerow += ` </tbody>
		            </table>`;
		            $('#skumodalbody').html(skutablerow);
		            $('#skutbl').DataTable({
		                "aaSorting": [[ 4, 'desc' ]],
		                "columnDefs": [
		                    { "visible": false, "targets": 1 },
		                    { "visible": false, "targets": 2 },
		                    { "visible": false, "targets": 3 },
		                    { "visible": false, "targets": 4 }

		                ],
		                    language: {
		                       
		                        searchPlaceholder: "Product Name, Product ID, Barcode or SKU"
		                }

		            });

		           /*Finesh*/
		             $('#skumodel').modal('show');

		        }

				/*Daily button code*/
		        function fetch_products_code_daily(message = null) {

		            if (message) {
		                alert(message);
		                return;
		            }
		            var id = $(this).attr("merchantrel");
	                    var filter = $(this).attr("rel");
	                    
	                    var fromDate = $('#from_date').val();
	                    var toDate = $('#to_date').val();
	                    var country = $('.country-merchant-field').val();
	                    var state = $('.state-merchant-field').val();
	                    var city = $('.city-merchant-field').val();
	                    var marea = $('.area-merchant-field').val();
	                    var product = $('.product-merchant-field').val();
	                    var brand = $('.brand-merchant-field').val();
	                    var category = $('.category-merchant-field').val();
	                    var subcategory = $('.subcategory-merchant-field').val();
	                    var channel = $('.channel-merchant-field').val();
		            $.ajax({

		                type: "GET",
		                url: "{{URL('/skulist_daily')}}",
		                 data: {
	                        fromDate: fromDate,
	                        toDate: toDate,
	                        toDate: toDate,
	                       country:country,
	                        state:state,
	                        city:city,
	                       marea:marea,
	                        product:product,
	                        brand:brand,
	                        category:category,
	                        subcategory:subcategory,
	                       channel: channel

	                        
	                      },
		                success: function( listproducts_daily ) {
		                    setskudatatable1(listproducts_daily);

		                }
		            });
		        }

		        function setskudatatable1(listproducts_daily) {
		        	jQuery(this).removeData();
		            var skutablerow =` <table style="width: 100%; " id="skutbl" class="table1 skutable">
	     			
				
		              <thead class="bg-inventory">
		                <tr >
		                  <th class="text-left" scope="col">Product</th>
		                  <th class="text-center" scope="col">Barcode</th>
		                  <th class="text-right" scope="col">Sku</th>
		                  <th class="text-right" scope="col">npid</th>
		                  <th class="text-right" scope="col">price</th>
		                </tr>
		              </thead>
		              <tbody id="skutable-body">
		               `;
		            if(listproducts_daily == "No data available"){
		            	
		            }
		            else
		            {

		            var pricesum1 = '';
		             var totalProduct = '';
		             jQuery.each( listproducts_daily, function( key, listproducts_daily ) {
		             if(pricesum1 == '' && totalProduct == '')
		             {
		            		 pricesum1 = listproducts_daily.pricesum1; 
		            		 totalProduct = listproducts_daily.totalProduct; 
		             		
		            }
		            });
		             
		            var i = 0;
		            var k = pricesum1 / totalProduct * 100;

		           /* var i = 0
		            var k = listproducts_daily['0'].pricesum1 / listproducts_daily['0'].totalProduct * 100;*/

		            jQuery.each( listproducts_daily, function( key, listproducts_daily ) {
		            
		            bar1 = listproducts_daily.pricesum1 / listproducts_daily.totalProduct * 100;
		            if(i == 0 )
		            {
		            	bar = 600;
		            }
		            else
		            {
		            	bar2 = listproducts_daily.pricesum1 / listproducts_daily.totalProduct * 100;
		            	bar = 600/k*bar2;
		            }
		            i++;
		             	         
		                skutablerow+= `<tr>
		                        <td class="text-left"><img style="object-fit:cover;" width="30"  height="30" src="{{url()}}/images/product/`+listproducts_daily.id+`/thumb/`+listproducts_daily.thumb_photo+`">
		                        <div class="progress1" style="margin: -3% 0% 1% 5%;">
								    <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="50" style="width:`+bar+`px; /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#b4ddb4+0,83c783+17,52b152+33,008a00+67,005700+83,002400+100;Green+3D+%231 */
									background: #b4ddb4; /* Old browsers */
									background: -moz-linear-gradient(-45deg, #b4ddb4 0%, #83c783 17%, #52b152 33%, #008a00 67%, #005700 83%, #002400 100%); /* FF3.6-15 */
									background: -webkit-linear-gradient(-45deg, #b4ddb4 0%,#83c783 17%,#52b152 33%,#008a00 67%,#005700 83%,#002400 100%); /* Chrome10-25,Safari5.1-6 */
									background: linear-gradient(135deg, #b4ddb4 0%,#83c783 17%,#52b152 33%,#008a00 67%,#005700 83%,#002400 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
									filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#b4ddb4', endColorstr='#002400',GradientType=1 ); /* IE6-9 fallback on horizontal gradient */">
							   </div> <span style="color:red;"> MYR  `+ listproducts_daily.pricesum +`</span> 
								  </div> `+listproducts_daily.name+`</td>
		                        <td>`+listproducts_daily.barcode+`</td>
		                        <td>`+listproducts_daily.sku+`</td>
		                        <td>`+listproducts_daily.npid+`</td>
		                        <td>`+listproducts_daily.pricesum+`</td>
		                    </tr>
		                  `;
		            });
		         } 

		            skutablerow += ` </tbody>
		            </table>`;
		            $('#skumodalbody').html(skutablerow);
		            $('#skutbl').DataTable({
		               "aaSorting": [[ 4, 'desc' ]],
		                "columnDefs": [
		                    { "visible": false, "targets": 1 },
		                    { "visible": false, "targets": 2 },
		                    { "visible": false, "targets": 3 },
		                    { "visible": false, "targets": 4 }

		                ],
		                    language: {
		                       
		                        searchPlaceholder: "Product Name, Product ID, Barcode or SKU"
		                }

		            });

		           /*Finesh*/
		             $('#skumodel').modal('show');

		        }
</script> -->
<style type="text/css">
.sellerbutton1 {
    width: 90px;
    height: 35px;
    padding-top: 8px !important;
    text-align: center !important;
    vertical-align: middle !important;
    float: left;
    font-size: 13px !important;
    cursor: pointer !important;
    margin-right: 5px !important;
    margin-bottom: 20px !important;
    border-radius: 5px !important;
}
.sellerbutton2 {
    width: 70px !important;
    height: 70px !important;
    padding-top: 16px !important;
    text-align: center;
    vertical-align: middle;
    float: left;
    font-size: 13px !important;
    cursor: pointer;
    margin-right: 5px !important;
    margin-bottom: 5px !important;
    border-radius: 5px !important;
}
.progress1 {
    height: 20px;
    width:100%;
    margin-bottom: 20px;
    border-radius: 4px;
    box-sizing: border-box;
}
.table1 > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
    padding: 8px;
    line-height: 1.42857143;
    vertical-align: top;
    /*border-top: 1px solid #ddd;*/
}
</style>

@stop


<!-- kjhk-->
