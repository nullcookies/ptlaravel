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
                                    <th>Name</th>
                                    <th>Friends</th>
                                    <th>Share&nbsp;Item</th>
                                    <th>Share&nbsp;Time</th>
                                    <th>Clicked</th>
                                    <th>Item&nbsp;Sold</th>

                                </tr>
                                <thead>
                                <tbody>
                                @foreach($smmastereport as $report)
                                @if($report->buyer_id==null)
                                <?php continue;?>
                                @endif
                                <tr>

                                    <td style="text-align: center;">
                                        {{$i++}}
                                    </td>
                                    <td>
                                        <?php
                                        $smm_id = str_pad($report->id, 10, '0', STR_PAD_LEFT);
                                        ?>
                                            <a href="javascript:void(0);" class="view-user-modal" data-us-id="{{$report->buyer_id}}">[{{$smm_id}}]</a>
                                    </td>
                                    <td>
                                        {{$report->first_name}} {{$report->last_name}}
                                    </td>
                                    <td style="text-align: center;">
                                        {{$report->friends}}
                                    </td>
                                    <td style="text-align: center;">
                                        {{$report->share_item}}
                                    </td>
                                    <td style="text-align: center;">
                                       {{$report->share_time}}
                                    </td>
                                    <td style="text-align: center;">
                                        {{$report->click}}
                                    </td>

                                    <td style="text-align: center;">
                                        {{$report->buy}}
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