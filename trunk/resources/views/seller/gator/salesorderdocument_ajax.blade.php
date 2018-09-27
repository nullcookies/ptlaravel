<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close"
        style="margin-top:0;padding-top:10px"
        data-dismiss="modal"
        aria-label="Close">
        <span aria-hidden="true">&times;
        </span></button>

        <h2 class="modal-title"
        id="smModalLabel2">Sales Order

        <!-- START STATS Table -->
        <span style="font-size:14px !important;"
        class="pull-right">
        <table>
            <tr>
                <td class="text-right">Monthly:</td>
                <td class="text-center">
                &nbsp;{{$currentCurrency}}&nbsp;</td>
                <td class="text-right">
                    <span class="monthlysales">0</span></td>
                </tr>
                <tr>
                    <td class="text-right">Today:</td>
                    <td class="text-center">
                    &nbsp;{{$currentCurrency}}&nbsp;</td>
                    <td style="text-align:right">
                        <span class="todaysales" >0</span></td>
                    </tr>
                </table>
            </span>
            <!-- END STATS Table -->
        </h2>
    </div>
    <div class="modal-body" >
        <h3 id="setmonthyear"></h3>
        <span >
            <table class="table table-bordered" id="table-id" >
                <thead class="aproducts">
                    <tr class="bg-gator">
                        <th class="text-center no-sort" width="20px"
                        style="width: 20px !important;">No</th>
                        <th class="text-center">Sales Order No </th>
                        <th class="text-center">Date</th>
                        <!-- <th class="text-center">Total</th> -->
                        <th class="text-center">Company Name</th>
                        <th class="text-center">Amount (MYR)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php  $count=1; ?>
                    @foreach($porder as $porder)
                    {{--*/ $created_at = new Carbon\Carbon($porder->created_at); /*--}}

                    <?php $total =$porder->quantity*$porder->price/100;  ?>
                    <tr>
                        <td class="text-center">{{$count}}</td>

                        <td class="text-center">
                         <a target="_blank"
                         href="{{URL::to('DO/displaysalesorderdocument',$porder->id)}}">
                         {{sprintf('%010d', $porder->salesorder_no)}}</a></td>
                         <td class="text-center">{{date('dMy H:i', strtotime($porder->created_at))}}</td>
                         <td class="text-left">@if($porder->is_emerchant == 1)
                            {{\App\Models\Emerchant::find($porder->user_id)['company_name']}}
                            @else
                            {{\App\Models\Merchant::where('user_id',$porder->user_id)->pluck('company_name')}}
                        @endif</td>
                        <td style="text-align: right;">{{number_format($porderprice[$porder->id]/100,2)}}</td>

                    </tr>
                    <?php  $count++; ?>
                    @endforeach
                </tbody>

            </table>
        </span>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" style="min-width: 60px;">Close</button>
    </div>
</div>
<script type="text/javascript">
 $('#table-id').DataTable({
    "order": [],

}); 
 $(".monthlysales").text("{{number_format($monthsaleorder[$porder->created_at->format('m-Y')]/100,2)}}");
 $(".todaysales").text("{{number_format($todaysales/100,2)}}");
</script>
