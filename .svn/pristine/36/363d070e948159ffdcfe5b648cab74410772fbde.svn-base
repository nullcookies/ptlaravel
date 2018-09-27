<h2>Debit Note: Status</h2>
<table class="table table-bordered" id="rogdocument" >
    <thead class="aproducts">

    <tr style="background-color: #F29FD7; color: #FFF;">
        <th class="text-center">No</th>
        <th class="text-center">Debit Note No</th>
        <th style="text-align: left;">Product Name</th>
        <th class="text-center">Status</th>
        

    </tr>
    </thead>
    <tbody>
<?php  $count=1; ?>
    @foreach($returnofgoodrequest as $returnofgoodrequest)
    <tr>
        <td style="text-align: center;">{{$count}}</td>
        <td style="text-align: center;">{{$returnofgoodrequest->returnofgoods_no}}</td>
        <td style="text-align: left;">{{$returnofgoodrequest->name}}</td>
        <td style="text-align: center; text-transform: capitalize;">{{$returnofgoodrequest->status}}</td>

    </tr>
    <?php  $count++; ?>
    @endforeach
    </tbody>

</table>
<script type="text/javascript">
     $('#rogdocument').DataTable({
                "order": [],
                
            }); 
</script>
