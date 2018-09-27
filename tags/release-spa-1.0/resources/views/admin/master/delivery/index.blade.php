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
                                    <th class='no-sort'>No</th>
                                    <th>Date</th>
                                    <th>Delivery&nbsp;ID</th>
                                    <th>Order&nbsp;ID</th>
                                    <th>Logistic&nbsp;ID</th>
                                    <th>Consignment&nbsp;No.</th>
                                    <th>Fee</th>
                                    <th>Information</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tfoot>
                                	

                                </tfoot>
                                <tbody>
                                @foreach($deliverys as $d)
                                <tr>
                                	<td>{{$i}}</td>
                                	<td>{{UtilityController::s_date($d->date)}}</td>
                                	<td>{{UtilityController::s_id($d->did)}}</td>
                                	<td><a href="{{url('deliveryorder',$d->id)}}" target="_blank">{{IdController::nO($d->id)}}</a></td>
                                	<td>{{$d->lid}}</td>
                                	<td>{{$d->cn}}</td>
                                    <td>{{$d->fee}}</td>
                                	<td><a href="#" class="btn btn-primary btn-default"><span class="glyphicon glyphicon-info-sign"></span> Click</a></td>
                                	<td>{{strtoupper($d->status)}}</td>
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
                                @endforeach
                                </tbody>
                            </table>
                            </div></div></div>


<script type="text/javascript">
                var table = $('#product_details_table').DataTable({
                "scrollX": true,
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

</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('.view-user-modal').click(function () {
            var user_id= $(this).attr('data-us-id');
            url=JS_BASE_URL+"/admin/popup/user/"+user_id;
            var w= window.open(url,"_blank");
            w.focus();
        });
    });
</script>
@stop