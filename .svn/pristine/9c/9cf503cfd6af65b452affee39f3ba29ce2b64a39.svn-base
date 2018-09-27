



<table class="table table-bordered" id="table-approval" >
  <thead class="aproducts">

    <tr style="background-color: #F29FD7; color: #FFF;">
      <th class="text-center no-sort" width="20px" style="width: 20px !important;">No</th>
      <th class="text-center">Credit Note No</th>
      <th class="text-center">Product Name</th>
      <th class="text-center">Status</th>


    </tr>
  </thead>
  <tbody>
    <?php  $count=1; ?>
    @foreach($returnofgoodrequest as $returnofgoodrequest)
     <?php $price = $returnofgoodrequest->order_price; 
           $p_price = number_format($price/100,2);
         ?>
    <tr>
      <td style="text-align: center;">{{$count}}</td>
      <td style="text-align: center;">
        <a href="#" data-toggle="modal" data-target="#myModal{{$returnofgoodrequest->creditnote_id}}">{{$returnofgoodrequest->creditnote_no}}</a>
      </td>
      <td style="text-align: center;">{{$returnofgoodrequest->name}}</td>
      <td style="text-align: center;">{{$returnofgoodrequest->status}}</td>

    </tr>
    <?php  $count++; ?>

    <div id="myModal{{$returnofgoodrequest->creditnote_id}}" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="start-loader "></div>
        <div class="pleasewait hide "><h4>Please Wait</h4></div>
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Credit Note </h4>
          </div>
          <div class="modal-body">

            <div class="center smaller" ">Intermedius OpenSupermall Sdn. Bhd<br>
              1144993-D<br>
              A-2-6, Block A, Jalan 2/142A<br>
              Megan Cheras<br>
              GST Reg No 1234657890<br>

            </div>
            <div class="smaller">
              4 Jalan Wawasan 4/10<br>
              Taman Wawasan 4<br>
              Pusat Bandar Puchong<br>
              Malysia- 47160<br>
              Date: <br>
              
            </div>
            <div>
              <div style="width: 35%; float: left; margin-top: 10px;font-weight: bold;">
                Order ID: {{$returnofgoodrequest->porder_id}}
              </div>
              <div style="width: 35%;float: left; margin: 0px"><h4>Credit Note</h4></div>

              <div  style="width: 30%;  margin-top: 10px; float: left; font-weight: bold;">
                Credit Note No: {{$returnofgoodrequest->creditnote_no}}
              </div>
              <div>
              </div>
              <div class="tableheader">
               <div class="center" style="width:10%; float: left;" >No</div>
               <div class="center" style="width:21%; float: left;">Product ID</div>
               <div class="center" style="width:25%; float: left;">Description</div>
               <div class="center" style="width:20%; float: left;">Qty</div>
               <div class="center" style="width:20%; float: left;">Unit Price</div>
               
             </div>
             <br>
             <div>
              <div class="center" style="width:10%; float: left;" >{{$count}}</div>
              <div class="center" style="width:21%; float: left;">{{$returnofgoodrequest->productid}}</div>
              <div class="center" style="width:25%; float: left;">&nbsp{{$returnofgoodrequest->description}}</div>
              <div class="center" style="width:20%; float: left;">{{$returnofgoodrequest->quantity}}</div>
              <div class="center" style="width:20%; float: left;">{{$returnofgoodrequest->order_price}}</div>

            </div>
          </div>
          <br>
          <br>
          <br>
          <div style="margin-left: 35%;">
            <button data-dismiss="modal" onclick="updatereturnproductstatus({{$returnofgoodrequest->creditnote_id}},'Approved')"class="btn btn-primary">Approve</button>
            <button data-dismiss="modal" onclick="updatereturnproductstatus({{$returnofgoodrequest->creditnote_id}},'Rejected')"class="btn btn-danger">Reject</button>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>

    </div>
  </div>


  @endforeach
</tbody>

</table>
<script type="text/javascript">
 $('#table-approval').DataTable({
  "order": [],

}); 
</script>