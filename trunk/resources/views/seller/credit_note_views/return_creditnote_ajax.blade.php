<table class="table table-bordered" id="table-id" >
    <thead class="aproducts">

    <tr style="background-color: #F29FD7; color: #FFF;">
        <th class="text-center no-sort" width="20px" style="width: 20px !important;">No</th>
        <th class="text-center">Date</th>
        <th class="text-center">Credit Note No</th>
        <th class="text-center">Amount (MYR)</th>
    </tr>
    </thead>
    <tbody>
<?php  $count=1; ?>
    @foreach($creditnote as $creditnote)
    {{--*/ $created_at = new Carbon\Carbon($creditnote->created_at); /*--}}

    <?php
	$total =$creditnote->quantity*$creditnote->price/100;
	$dt = date('dMy H:i', strtotime($created_at));
	?>
    <tr>
        <td style="text-align: center;">{{$count}}</td>
        <td style="text-align: center;">{{$dt}} </td>
        <td style="text-align: center;"><a target="_blank"
		href="{{route('creditnotedocument',$creditnote->id)}}">
		{{sprintf('%05d', $creditnote->creditnote_no)}}</a></td>
        <td style="text-align: center;">{{number_format($total,2)}}</td>

    </tr>
    <?php  $count++; ?>
    @endforeach
    </tbody>

</table>
<script type="text/javascript">
     $('#table-id').DataTable({
                "order": [],
                
            }); 
</script>
