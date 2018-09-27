


<style type="text/css">
.grandtotal{
  margin: 0px;
  width: 100%;
  padding-right: 15px;
  text-align: right;
  padding-bottom: 10px;
  margin-top: 7px;
  float: right;
  border-bottom: 1px solid #E5E5E5;
  margin-bottom: 6px;
}
.divrow{
  width: 100%;
  float: left;
  height: 51px;
  padding-top: 15px;
  padding-bottom: 0px;
  border-bottom: 1px solid #E5E5E5;
}
.modal{
  font-style: sans-serif;
}
.gst{
  width: 30%;
  float: right;
  text-align: right;
  font-size: 12px;
  padding-right: 15px;
}
</style>
<h2>Merchant Approval</h2>
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
    $totalc  = $returnofgoodrequest->quantity*$p_price;
    $total  = number_format($returnofgoodrequest->quantity*$p_price,2);
    $gst   = $totalc*6/100;
    $itmtotalprice = $totalc-$gst;
    $gst   = number_format($gst,2);
    $itmtotalprice   = number_format($itmtotalprice,2);
    ?>
    <tr>
      <td style="text-align: center; ">{{$count}}</td>
      <td style="text-align: center;">
        <a href="#" data-toggle="modal" data-target="#myModal{{$returnofgoodrequest->creditnote_id}}">{{$returnofgoodrequest->creditnote_no}}</a>
      </td>
      <td style="text-align: left;">{{$returnofgoodrequest->name}}</td>
      <td style="text-align: center;">{{ucfirst($returnofgoodrequest->status)}}</td>

    </tr>
    

    <div id="myModal{{$returnofgoodrequest->creditnote_id}}" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="start-loader "></div>
        <div class="pleasewait hide "><h4>Please Wait</h4></div>
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title te">Credit Note </h4>
          </div>
          <div class="modal-body">

            <div class="center smaller"margin:0px;  ">{{$returnofgoodrequest->line1}}<br>
              {{$returnofgoodrequest->line2}}<br>
              {{$returnofgoodrequest->line3}}<br>
              {{$returnofgoodrequest->line4}}<br>
              {{$returnofgoodrequest->gst}}<br>

            </div>
            {{--*/ $created_at = new Carbon\Carbon($returnofgoodrequest->created_at); /*--}}
            <div class="smaller">
             {{$returnofgoodrequest->stationline1}}<br>
             {{$returnofgoodrequest->stationline2}}<br>
             {{$returnofgoodrequest->stationline3}}<br>
             {{$returnofgoodrequest->stationline4}}<br>
             Date: {{$created_at->day}}{{$created_at->format('M')}}{{$created_at->format('y')}} <br>

           </div>
           <div>
            <div style="width: 33%; float: left; margin-top: 10px;font-weight: bold;">
            
            </div>
            <div style="width: 35%;float: left;     text-align: center; margin: 0px"><h4>Credit Note</h4></div>

            <div  style="width: 32%;      padding-right: 15px;   text-align: right;  margin-top: 10px; float: right; font-weight: bold;">
              Credit Note No: {{str_pad($returnofgoodrequest->creditnote_no,10,'0',STR_PAD_LEFT)}}
            </div>
            <div>
            </div>
            <div style="    padding-top: 7px;    height: 35px;" class="tableheader">
             <div class="" style="width:4%; margin-left: 5px; float: left;" >No</div>
             <div class="center" style="margin:0px; width:23%; float: left;">Product ID</div>
             <div style="width:25%; text-align: left;     padding-left: 10px; float: left;">Description</div>
             <div class="center" style="margin:0px; width:8%; float: left;">Qty</div>
             <div class="" style="width:18%; text-align: right; float: left;">Unit Price</div>
             <div class="" style="width:20%; text-align: right; float: left;">Amount</div>

           </div>
           <br>
           <div class="divrow">
            <div class="" style="width:4%;padding-left: 5px; margin-left: 5px; float: left;" >{{$count}}</div>
            <div class="center" style="margin:0px; width:23%; float: left;">{{$returnofgoodrequest->productid}}</div>
            <div class="center" style="margin:0px; width:25%;     padding-left: 10px; text-align: left; white-space: nowrap; overflow: hidden; float: left;">&nbsp{{$returnofgoodrequest->description}}</div>
            <div class="center" style="margin:0px; width:8%; float: left;">{{$returnofgoodrequest->quantity}}</div>
            <div class="center" style="margin:0px; width:18%; text-align: right; float: left;">{{$currency->code}}&nbsp&nbsp&nbsp {{$p_price}}</div>
            <div class="center" style="margin:0px; width:20%; text-align: right; float: left;">{{$currency->code}}&nbsp&nbsp&nbsp{{$total}}</div>

          </div>
          <div style="width: 100%;">

            <div class="center grandtotal" >Total {{$currency->code}}&nbsp&nbsp&nbsp{{$total}}</div>

          </div>
          <div class="gst " >Total include 6% GST &nbsp&nbsp {{$currency->code}}&nbsp{{$gst}}
                              <br>Item Total {{$currency->code}}&nbsp{{$itmtotalprice}}
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <div style="  margin-top: 10px;  margin-left: 43%;float: left;">
          <button style=" width: 74px;border-radius: 5px;" data-dismiss="modal" onclick="updatereturnproductstatus({{$returnofgoodrequest->creditnote_id}},'Approved')" class="btn btn-primary">Approve</button>
          <button style=" width: 74px; border-radius: 5px;" data-dismiss="modal" onclick="updatereturnproductstatus({{$returnofgoodrequest->creditnote_id}},'Rejected')" class="btn btn-danger">Reject</button>
        </div>
      </div>
    </div>

  </div>
</div>

<?php  $count++; ?>
@endforeach
</tbody>

</table>
<script type="text/javascript">
 $('#table-approval').DataTable({
  "order": [],

}); 
</script>
<style type="text/css">

.modal-dialog{
  width: 80%;
}
</style>
