@extends('common.default')
@section('content')
<div class="container">
<div class="row">
<div class="col-xs-12">
@include('admin/panelHeading')
                <h2>Delivery Master</h2>
<?php $i=1;
	use App\Http\Controllers\IdController;
        use App\Http\Controllers\UtilityController;
?><table class="table table-bordered" cellspacing="0" width="100%" id="product_details_table">
                                <thead style="background-color:#800080; color:#fff;">
                                {{-- <tr>
                                    <th colspan="4">Social Media Marketeer Master</th>
                                    <th colspan="7">Network Information</th>
                                    <th colspan="3">Geographical</th>
                                    <th colspan="3">Others</th>
                                </tr> --}}
                                <tr>
                                    <th class='no-sort text-center'>No</th>
                                    <th class="text-center">Date</th>
                                    <th class="text-center">Delivery&nbsp;ID</th>
                                    <th class="text-center">Order&nbsp;ID</th>
                                    <th class="text-center">Logistic&nbsp;ID</th>
                                    <th class="text-center">Consignment&nbsp;No.</th>
                                    <th class="text-center">Fee</th>
                                    <th class="text-center">Details</th>
                                    <th class="text-center">Status</th>
                                </tr>
                                </thead>
                                <tfoot>
                                	

                                </tfoot>
                                <tbody>
                                @foreach($deliverys as $d)
                                <tr>
                                	<td class="text-center">{{$i}}</td>
                                	<td>{{UtilityController::s_date($d->date)}}</td>
                                	<td class="text-center">{{IdController::nDel($d->did)}}</td>
                                	<td class="text-center"><a href="{{url('deliveryorder',$d->id)}}" target="_blank">{{IdController::nO($d->id)}}</a></td>
                                	<td class="text-center">{{IdController::nS($d->sid)}}</td>
                                	<td class="text-center">{{$d->cn}}</td>
                                    <td class="text-right">{{$currentCurrency}}&nbsp;{{number_format($d->nfee/100,2)}}</td>
                                	<td class="text-center"><a href="javascript:void(0)" class="apopup" rel="{{$d->cn}}" rel-type="all">Info</a></td>
                                	<td class="text-center">{{ucfirst($d->status)}}</td>
                                </tr>
                                {{-- Hidden Row --}}
                                {{-- <table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">
                              		<tr>
                              			<td>Dimension</td>
                              			<td><a href="">Dimensions & Weight</a></td>
	                                	
	                                	<td>Price</td>
	                                	<td>100</td>
	                                	<td>Merchant&nbsp;ID</td>
	                                	<td>{{IdController::nM(100)}}</td>
	                                	<td>Buyer&nbsp;ID</td>
	                                	<td>{{IdController::nB(100)}}</td>
	                                	<td>Receipent</td>
	                                	<td>{{$d->buyername or "mm"}}</td>
                              		</tr>
                              	</table> --}}
								<?php $i++; ?>
                                @endforeach
                                </tbody>
                            </table>
                            </div></div></div>

<div id="modalI" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
			  <h2>Details</h2>
			</div>
			<div class="modal-body" style="padding: 0 20px 20px 20px;">
			</div>
		 
		</div>
	</div>
</div>
<script type="text/javascript">


</script>
<script type="text/javascript">
    $(document).ready(function(){
		$(document).delegate( '.apopup', "click",function (event) {
      //  $('.apopup').click(function(){
            var cn=$(this).attr('rel');
            var t= $(this).attr('rel-type');
            var url="{{url('lp/addresses/')}}"+"/"+cn+"/"+t;
            $('#modalI').modal('show');
            $('#modalI').find('.modal-body').load(url);

        });		
		
        $('.view-user-modal').click(function () {
            var user_id= $(this).attr('data-us-id');
            url=JS_BASE_URL+"/admin/popup/user/"+user_id;
            var w= window.open(url,"_blank");
            w.focus();
        });
		
                var table = $('#product_details_table').DataTable({
                //"scrollX": true,
                "order": [],
                "columnDefs": [{
                "targets": 'no-sort',
                "orderable": false,
                    },{ "targets": "large", "width": "120px" },{ "targets": "xlarge", "width": "300px" }],
                "fixedColumns":  true
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
    });
</script>
@stop