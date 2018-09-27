<?php 
use App\Classes\Approval;
use App\Http\Controllers\IdController;
?>
<?php $i=1;?><table class="table table-bordered" cellspacing="0" width="100%" id="product_details_table">
                                <thead style="background-color:#558ED5; color:#fff;">
                                {{-- <tr>
                                    <th colspan="4">Social Media Marketeer Master</th>
                                    <th colspan="7">Network Information</th>
                                    <th colspan="3">Geographical</th>
                                    <th colspan="3">Others</th>
                                </tr> --}}
                                <tr>
                                    <th class='no-sort'>No</th>
                                    <th>SMM&nbsp;ID</th>
                                    <th style="width:200px;">Name</th>
                                    <th>Friends</th>
                                    <th>Share&nbsp;Item</th>
                                    <th>Share&nbsp;Time</th>
                                    <th>Clicked</th>
                                    <th>Item&nbsp;Sold</th>
                                    <th>Bought</th>
                                    <th>Last&nbsp;Share</th>
                                    <th>Source</th>
                                    <th>Country</th>
                                    <th>State</th>
                                    <th>City</th>
                                    <th>Area</th>
                               <!--     <th class="xlarge" style="background-color:#008000;color:#fff">Remarks</th> -->
                                    <th style="background-color:#008000;color:#fff">Status</th>
                               <!--      <th style="background-color:#008000;color:#fff">Approval</th> -->
                                </tr>
                                <thead>
                                <tbody>
                                @foreach($smmastereport as $report)
                                @if($report['user_id']==null)
                                <?php continue;?>
                                @endif
                                <tr>

                                    <td style="text-align: center;">
                                        {{$i++}}
                                    </td>
                                    <td>
                                        <?php
                                        $smm_id = str_pad($report['user_id'], 10, '0', STR_PAD_LEFT);
                                        ?>
                                            <a href="javascript:void(0);" class="view-user-modal" data-us-id="{{$report['user_id']}}">{{IdController::nB($report['user_id'])}}</a>
                                    </td>
                                    <td>
                                        {{$report['first_name']}} {{$report['last_name']}}
                                    </td>
                                    <td style="text-align: center;">
                                        {{$report['trans']['friends']}}
                                    </td>
                                    <td style="text-align: center;">
                                        {{$report['trans']['share_item']}}
                                    </td>
                                    <td style="text-align: center;">
                                       {{$report['share_time']}}
                                    </td>
                                    <td style="text-align: center;">
                                        {{$report['trans']['click']}}
                                    </td>

                                    <td style="text-align: center;">
                                        {{$report['trans']['bought']}}
                                    </td>

                                    <td style="text-align: center;">
                                        {{$report['trans']['money']}}
                                    </td>

                                    <td style="text-align: center;">
                                    {{ date('dMy h:m', strtotime($report['trans']['last_share'])) }}
                                    </td>

                                    <td style="text-align: center;">
                                        {{$report['trans']['sme']}}
                                    </td>

                                    <td style="text-align: center;">
                                        {{$report['geo']['country']}}
                                    </td>

                                    <td style="text-align: center;">
                                        {{$report['geo']['state']}}
                                    </td>
                                     <td style="text-align: center;">
                                        {{$report['geo']['city']}}
                                    </td>
                                    <td style="text-align: center;">
                                      {{$report['geo']['area']}}
                                    </td>

                                    <td id="remarks_column" class="text-center">
                                    <?php
                                        $remark = DB::table('remark')
                                        ->select('remark')
                                        ->join('sales_staffremark','sales_staffremark.remark_id','=','remark.id')
                                        ->where('sales_staffremark.sales_staff_id',$report['sst_id'])
                                        ->orderBy('remark.created_at', 'desc')
                                        ->first();
                                    ?>
                                        <a href="javascript:void(0)" id="mcrid_{{$report['sst_id']}}" class="mcrid" rel="{{$report['sst_id']}}">
                                            @if($remark)
                                                {{$remark->remark}}
                                            @endif
                                        </a>
                                    </td>

                                    <td id="status_column" class="text-center">
                                        <span id="status_column_text">
                                            <a target="_blank"  href="{{route('smmApproval', ['id' => $report['user_id']])}}">{{ucfirst($report['status'])}}</a>
                                        </span>
                                    </td>

                                    <td>
                                        <div class="action_buttons">
                                            <?php
                                            $approve = new Approval('sales_staff', $report['sst_id']);
                                            if ($report['status'] == 'active') {
                                                $approve->getSuspendButton();
                                            } else if ($report['status'] == 'suspended' || $report['status'] == 'rejected') {
                                                $approve->getReactivateButton();
                                            }
                                            echo $approve->view;
                                            ?>
                                        </div>
                                    </td>

                                </tr>
                                @endforeach
                                </tbody>
                            </table>

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