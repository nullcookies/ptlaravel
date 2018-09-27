<?php  $date = date("Y-m-d"); ?>
<?php  $dateytd = date("Y") . "-01-01"; ?>
<?php  $datemtd = date("Y-m") . "-01"; ?>

<?php $date1 = date("Y-m-d"); 
$datewtd =  date('Y-m-d', strtotime('-1 week', strtotime($date1))); ?>
<?php  $datedaily = $datedaily = date("Y-m-d"); ?>
<?php  $datehourly = date('Y-m-d H:i:s', strtotime('-1 hour')); ?>
<style>
.dataTables_filter input {
	width:300px;
}

</style>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
    <!-- Bootstrap -->
<link rel="stylesheet" href="{{asset('/css/bootstrap.min.css')}}"/>
<link rel="stylesheet" href="{{asset('/css/bootstrapValidator.css')}}"/>
<link rel="stylesheet" href="{{asset('/css/font-awesome.min.css')}}"/>
<link rel="stylesheet" href="{{asset('/jqgrid/ui.jqgrid.min.css')}}"/>
<link rel="stylesheet" href="{{asset('/css/datatable.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{asset('css/jquery.dataTables.min.css')}}">

<script src="{{asset('/js/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jquery-ui.js')}}"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script type="text/javascript" src="{{asset('/js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/bootstrapValidator.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jquery.dataTables.min.js')}}"></script>
<div class="container">
	<div class="row col-md-12">
		<!-- <div class="modal-header" style="margin-bottom:25px;padding-bottom:10px"> -->
			<div class="col-md-12" style="padding-top:20px">
				<h3 class="modal-title"
					style="margin-bottom:0"
					id="myModalLabel">
					Staff Sales</h3>
			</div>
			<div class="col-md-12" style="padding-top: 10px">
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
			</div>	
		   <!--  <button type="button" class="close" data-dismiss="modal">
				&times;</button> -->
			<div class="col-md-12">
				
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


				<div id="staffModalBody" class="modal-body">

				</div>
			</div>
		</div>
	</div>
</div>


<script type="text/javascript">

            $( document ).ready(function() {
            		// event.preventDefault();
			 	staffSalesReport()
			 	// event.preventDefault();
			
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