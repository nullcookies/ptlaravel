@extends("common.default")
<?php
use App\Http\Controllers\UtilityController;
?>
@section('content')
<style type="text/css">
    .textCenter{
        text-align: center;
    }
    .textRight{
        text-align: right;
    }
	 li >a{

		 margin-left: -5px;}
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
    }
    table#product_details_table,#ordersb_details_table,#payment_detail_products
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
</style>
	<div class="container">
        <div class="alert alert-success alert-dismissible hidden cart-notification" role="alert" id="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong class='cart-info'></strong>
        </div>
		<div class="row">
			<div class="col-sm-11 col-sm-offset-1">
				{!! Breadcrumbs::render('station.dashboard') !!}
				<div class="col-sm-12"><h2>Station Dashboard</h2></div>
					{{-- Panel --}}
					<div class="panel with-nav-tabs panel-default ">
					{{-- Nav --}}
						<div class="panel-heading ">
							<ul class="nav nav-tabs">
                                <li class="active"><a href="#sales-order" data-toggle="tab">SalesOrder</a></li>
                                 {{--<li><a href="#delivery-sales" data-toggle="tab">SalesDelivery</a></li>--}}
								<li><a href="#voucher" data-toggle="tab">Voucher</a></li>
                                 {{--<li><a href="#payment" data-toggle="tab">Payment</a></li>--}}
								<li><a href="#buying-order" data-toggle="tab">BuyingOrder</a></li>
								 {{--<li><a href="#delivery-buying" data-toggle="tab">BuyingDelivery</a></li>--}}
                                 {{--<li><a href="#cre" data-toggle="tab">CRE</a></li>--}}
                                <li><a href="#open-wish" data-toggle="tab">OpenWish</a></li>
                                <li><a href="#auto-link" data-toggle="tab">AutoLink</a></li>
                                <li><a href="#hyper" data-toggle="tab">Hyper</a></li>
                                <li><a href="#likes" data-toggle="tab">Likes</a></li>
                                {{-- <li><a href="#loyalty" data-toggle="tab">Loyalty </a></li> --}}
                                {{-- <li><a href="#auction" data-toggle="tab">Auction</a></li> --}}
							</ul>
						</div>
					{{-- Nav-Ends --}}
					</div>
					{{-- Panel Ends --}}
					{{-- Content --}}
						<div id="dashboard" class="row" class="panel-body " >
							<div class="tab-content top-margin">

									<div id="sales-order" class="tab-pane fade in active">
										@include('station.dashboard.sales-order')
									</div>

									<div id="buying-order" class="tab-pane fade">
										@include('station.dashboard.buyer-order')
									</div>

									<div id="delivery-buying" class="tab-pane fade">
										@include('station.dashboard.delivery-buying')
									</div>
									<div id="delivery-sales" class="tab-pane fade ">
										@include('station.dashboard.delivery-sales')
									</div>
									<div class="tab-pane fade " id="payment">
										@include('station.dashboard.payment')
									</div>
									{{-- payment ends --}}
									<div id="voucher" class="tab-pane fade "> 
										@include('station.dashboard.voucher')
									</div>
									<div id="cre" class="tab-pane fade"> 
										@include('station.dashboard.cre')
									</div>
                                    {{-- OpenWish START --}}
									<div class="tab-pane fade" id="open-wish">
										@include('station.dashboard.open-wish')
									</div>
									{{-- Openwish ends --}}
									 <div id="auto-link" class="tab-pane fade">
										@include('station.dashboard.autolink')
									</div>
									{{-- Autolink ENDS --}}
									<div id="hyper" class="tab-pane fade"> 
                                    {{-- <h2>Hyper</h2> --}}
										@include('station.dashboard.hyper')
									</div>
									<div class="tab-pane fade " id="likes">
										@include('merchant.dashboard.likes')
									</div>										

							</div>

						</div>
					{{-- Content Ends --}}
			   <!-- squidster -->
			</div>
		</div>
    </div>

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
		{{-- All SCRIPTS BELOW THIS POINT --}}
	<script src="{{url('js/jquery.dataTables.min.js')}}"></script>
	<script src="{{url('jqgrid/jquery.jqGrid.min.js')}}"></script>
	<script>
        function addToCart(product_id , amount,ow_id){
            console.log(product_id);
            jQuery.ajax({
                type: "POST",
                url: "{{ url('merchant/help')}}",
                data: { product_id:product_id , amount:amount,ow_id:ow_id},
                beforeSend: function(){},
                success: function(response){
                    $('.cart-link').text('View Cart');
                    $('.badge-cart').text(response.total_items);
                    $('#alert').removeClass('hidden').fadeIn(3000).delay(5000).fadeOut(5000);
                    $('.cart-info').text(response.product_name + "  Successfully added to the cart");
                }
            });
        }

        $(document).ready(function(){

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
			"order": [],
		//	"scrollX":true,
			"columnDefs": [
				{ "targets": "no-sort", "orderable": false },
				{ "targets": "large", "width": "120px" },
				{ "targets": "smallestest", "width": "55px" },
				{ "targets": "medium", "width": "95px" },
				{ "targets": "xlarge", "width": "280px" }
			],
			"fixedColumns":   {
				"leftColumns": 2
			}
        });
		
        var table = $('#product_details_table2').DataTable({
			"order": [],
		//	"scrollX":true,
			"columnDefs": [
				{ "targets": "no-sort", "orderable": false },
				{ "targets": "large", "width": "120px" },
				{ "targets": "smallestest", "width": "55px" },
				{ "targets": "medium", "width": "95px" },
				{ "targets": "xlarge", "width": "280px" }
			],
			"fixedColumns":   {
				"leftColumns": 2
			}
        });		

        var table = $('#ordersb_details_table').DataTable({
			"order": [],
		//	"scrollX":true,
			"columnDefs": [
				{ "targets": "no-sort", "orderable": false },
				{ "targets": "large", "width": "120px" },
				{ "targets": "smallestest", "width": "55px" },
				{ "targets": "medium", "width": "95px" },
				{ "targets": "xlarge", "width": "280px" }
			],
			"fixedColumns":   {
				"leftColumns": 2
			}
        });

        var table = $('#shipping_details_table').DataTable({
			"order": [],
			"scrollX":true,
			"columnDefs": [
				{ "targets": "no-sort", "orderable": false },
				{"targets": "medium", "width": "80px" },
				{"targets": "large",  "width": "120px" },
				{"targets": "approv", "width": "180px"},
				{"targets": "blarge", "width": "200px"},
				{"targets": "bsmall",  "width": "20px"},
				{"targets": "clarge", "width": "250px"},
				{"targets": "xlarge", "width": "300px" }
			],
			"fixedColumns":   {
				"leftColumns": 2
			}
        });

        var table = $('#shippings_details_table').DataTable({
			"order": [],
			"scrollX":true,
			"columnDefs": [
				{ "targets": "no-sort", "orderable": false },
				{ "targets": "large", "width": "120px" },
				{ "targets": "smallestest", "width": "55px" },
				{ "targets": "medium", "width": "95px" },
				{ "targets": "xlarge", "width": "280px" }
			],
			"fixedColumns":   {
				"leftColumns": 2
			}
        });

        $('#lower_product_detail_table').DataTable();
        $('#payment_detail_products').DataTable({
			"order": [],
			"scrollX":true,
			"columnDefs": [
				{ "targets": "no-sort", "orderable": false },
				{ "targets": "large", "width": "120px" },
				{ "targets": "smallestest", "width": "55px" },
				{ "targets": "medium", "width": "95px" },
				{ "targets": "xlarge", "width": "280px" }
			],
			"fixedColumns":   {
				"leftColumns": 2
			}
        });
        $('#voucher_payment_detail').DataTable();
		$('#auto_link_table').DataTable({
			"order": [],
			"columnDefs": [
				{"targets" : 0, "orderable": false, },
				{"targets" : 5, "orderable": false, }
			]
		});
		$('#open_wish_table').DataTable({
			"order": [],
			"scrollX": true,
			"columnDefs": [ {
				"targets" : 0,
				"data": null,
				"orderable": false,
				"defaultContent": ""
			}]
		});

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

		// $('.uniqporder').click(function(event){

		// 	event.preventDefault();
		// 	var porder_id= $(this).attr('data');
		// 	var url= JS_BASE_URL+"/order/product/"+porder_id;
		// 	newwindow = window.open(url, 'Order Details', 'height=500,width=800');
		// 	if (window.focus) {newwindow.focus()}
		// 	setTimeout(function () {newwindow.close();}, 30000);
		// });

		$('.order_id').on('click',function(){
		    $('body').css('padding','0px');
		    var route = $(this).attr('data-val');
		    $.ajax({
		        type : "GET",
		        url : route,
		        success : function(response){
		            $('#Modal').find('.modal-body').html(response);
		            $('#Modal').modal('show');
		            $('.title').text('Payment');
		        }
		    })
		    return false;
		})
		
		$(".dataTables_empty").attr("colspan","100%");
    });
</script>
<script type="text/javascript">
$(document).ready(function() {
  longString="This is has been bypassed";
var contentDiv = $(".longname");
contentDiv.html(longString.substr(0,12) + "...");
contentDiv.mouseover(function(){
     this.html(longString);
});

contentDiv.mouseout(function(){
     this.html(longString.substr(0,12) + "...");
});
});

function activaTab(tab){
	$('.nav-tabs a[href="#' + tab + '"]').tab('show');
};</script>

@if(isset($_GET['tab']))

<script type="text/javascript">
	tagID = "{{$_GET['tab']}}";
	activaTab(tagID);
</script>
@endif
@stop
