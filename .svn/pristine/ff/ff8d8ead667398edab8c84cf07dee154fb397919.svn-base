<?php
use App\Classes;
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\IdController;
?>
@extends("common.default")
@section('content')


@include("common.sellermenu")



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
   *
  font-style: sans-serif;
  */
}
.gst{
  width: 30%;
  float: right;
  text-align: right;
  font-size: 12px;
  padding-right: 15px;
}
</style>

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
	$rogr = $returnofgoodrequest;
    ?>
        <div class="modal-content">
		{{--
          <div class="modal-header"></div>
		 --}}
          <div class="modal-body">
            <div class="center" style="margin:0px;">
			  <b>{{$rogr->mcompany_name}}</b>
			  <?php
 			  if (!empty($rogr->mbusiness_reg_no)) {echo "<br>".$rogr->mbusiness_reg_no;}
 			  if (!empty($rogr->line1)) {echo "<br>".$rogr->line1;}
              if (!empty($rogr->line2)) {echo "<br>".$rogr->line2;}
              if (!empty($rogr->line3)) {echo "<br>".$rogr->line3;}
              if (!empty($rogr->line4)) {echo "<br>".$rogr->line4;}
              if (!empty($rogr->mpostcode)) {echo "<br>".$rogr->mpostcode;}
              if (!empty($rogr->mgst)) {echo "<br>GST Reg. No: ".$rogr->mgst;}
			  ?>

            </div>
            {{--*/ $created_at = new Carbon\Carbon($rogr->created_at); /*--}}
            <div class="">
             {{$rogr->stationline1}}<br>
             {{$rogr->stationline2}}<br>
             {{$rogr->stationline3}}<br>
             {{$rogr->stationline4}}<br>
             Date: {{$created_at->day}}{{$created_at->format('M')}}{{$created_at->format('y')}} <br>

           </div>
           <div>
            <div style="width: 33%; float: left; margin-top: 10px;font-weight: bold;">
            
            </div>
            <div style="width: 35%;float: left;     text-align: center; margin: 0px"><h4>Credit Info</h4></div>

            <div  style="width: 32%;      padding-right: 15px;   text-align: right;  margin-top: 10px; float: right; font-weight: bold;">
              Credit Note No: {{str_pad($rogr->creditnote_no,10,'0',STR_PAD_LEFT)}}
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
            <div class="center" style="margin:0px; width:23%; float: left;">{{$rogr->productid}}</div>
            <div class="center" style="margin:0px; width:25%;     padding-left: 10px; text-align: left; white-space: nowrap; overflow: hidden; float: left;">&nbsp{{$rogr->description}}</div>
            <div class="center" style="margin:0px; width:8%; float: left;">{{$rogr->quantity}}</div>
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
        
      </div>
    </div>

 

<?php  $count++; ?>
@endforeach



<style type="text/css">

.modal-dialog{
  width: 80%;
}
</style>
	@yield("left_sidebar_scripts")
	@stop
