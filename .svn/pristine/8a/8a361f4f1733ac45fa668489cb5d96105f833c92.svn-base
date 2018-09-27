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
	                <!-- <button type="button" class="close" data-dismiss="modal">
						&times;</button> -->
					<div class="col-md-12" style="padding-top: 20px;">
						<h3 class="modal-title"
						style="margin-bottom:0"
						id="myModalLabel">
						Product Sales</h3>
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
						<div class='col-xs-3 category-merchant-select-container'>
							{!! Form::select('category', array('' => 'Select...') + $data['categories'], null, ['class' => 'category-merchant-field col-xs-12']) !!}
						</div>
						<div class='col-xs-3 area-merchant-select-container'>
							{!! Form::select('subcategory', array(), null, ['class' => 'subcategory-merchant-field col-xs-12']) !!}
						</div>
					</div>
					<div class="col-md-12" style="padding-top: 10px">
						<div class='col-xs-3 brand-merchant-select-container'>
							{!! Form::select('brand', array('' => 'Select...') + $data['brands'], null, ['class' => 'brand-merchant-field col-xs-12']) !!}
						</div>	
						<div class='col-xs-3 product-merchant-select-container'>
							{!! Form::select('product', array(), null, ['class' => 'product-merchant-field col-xs-12']) !!}
						</div>
					</div>
					<div class="col-xs-12" id="countries-main-container" style="padding-top: 10px">
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
				
				<div id="skumodalbody" class="modal-body">
				</div>
		<!-- </div> -->
	</div>
</div>
<script type="text/javascript">
			//$(document).on('click','#skumodel',function(){
			 $( document ).ready(function() {
				// event.preventDefault();
				fetch_products_code();
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
</script>