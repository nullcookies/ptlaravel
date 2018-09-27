<table class="table table-bordered" id="notproduct_details_table" >
    <thead class="aproducts">

    <tr style="background-color: #F29FD7; color: #FFF;">
        <th class="text-center no-sort" width="20px" style="width: 20px !important;">No</th>
        <th class="text-center" >Order&nbsp;ID</th>
        
        <th class="text-center">Status</th>
        <th class="text-center">Purchase Date</th>
        <th class="text-center">Action</th>

        
    </tr>
    </thead>
    <?php  $count = 1; ?>
    <tbody>
        @foreach($orderlist as $orderlist)
    <tr>
        <td style="text-align: center;">{{$count}}</td>
        <td style="text-align: center;">{{$orderlist->id}}</td>
        <td style="text-align: center; text-transform: capitalize;">{{$orderlist->status}}</td>
        <td style="text-align: center;">{{$orderlist->created_at}}</td>
        <td style="text-align: center;"><BUTTON onclick="orderselected({{$orderlist->id}})" class="btn btn-primary">Return From this Order</BUTTON></td>
        
    </tr>
    <?php  $count++; ?>
    @endforeach
    </tbody>

</table>

<br>
<button class="btn-sub add-btn pull-right" style="height: 40px !important; background-color: #F29FD7 !important; color: #FFF;">
    Add Products
</button>
    <style>
        .naddTproduct:hover {
            background-color: #CCC !important;
            border-color: #CCC !important;
        }

        .naddTproduct {
            background-color: #CCC !important;
            border-color: #CCC !important;
        }
    </style>
    