
<div style="padding: 15px;" id="download">
<br>
<div >
	<div style="text-align: center;width: 100%;">
	<strong>{{$merchantaddress[0]->company_name}}</strong></div>

    <div  style="
    display: flex;
    flex-direction: column;
    width: 70%;
    padding-left: 30%;
    float: left;
    align-items: center;
    margin: 0;">
    <p style="margin: 0px">{{$merchantaddress[0]->business_reg_no}}</p>
    <p style="margin: 0px">{{$merchantaddress[0]->line1}}</p>
    <p style="margin: 0px">{{$merchantaddress[0]->line2}}</p>
    <p style="margin: 0px">{{$merchantaddress[0]->line3}}</p>
    <p style="margin: 0px">{{$merchantaddress[0]->line4}}</p>
    <p style="margin: 0px">GST Reg No: {{$merchantaddress[0]->gst}}</p>

  </div>
 <div style="    width: 70px;
  height: 70px;
  float: right;" class="qrcode"></div>

  <div style="    width: 70px; 
  height: 70px;
  float: right;"><button onclick="genPDF()" style="
    width: 70px;
    border-radius: 5px;
    height: 70px;
    padding: 0px;
    margin-right: 5px;" class="btn btn-primary btn-info pull-right">Download</button></div>
 

  <div style="width: 100%; display: flex; justify-content: space-between;">
   <div>
    <p style="margin: 0px"><strong>Buyer:</strong> </p>
    <p style="margin: 0px">{{$buyeraddress[0]->company_name}}</p>
    <p style="margin: 0px">{{$buyeraddress[0]->business_reg_no}}</p>
    <p style="margin: 0px">{{$buyeraddress[0]->line1}}</p>
    <p style="margin: 0px">{{$buyeraddress[0]->line2}}</p>
    <p style="margin: 0px">{{$buyeraddress[0]->line3}}</p>
    <p style="margin: 0px">
      @if(isset($buyeraddress[0]->line4))
      {{$buyeraddress[0]->line4}}
      @endif
    </p>
    <p style="margin: 0px">
     <strong>Date:</strong>
     {{date('dMy H:i', strtotime($merchantaddress[0]->created_at))}}</p>
   </div>

   <div style="padding-top:35px">
    <p style="margin: 0px"><strong>Staff ID: </strong>
     {{$merchantaddress[0]->user_id}}</p>
     <p style="margin: 0px"><strong>Staff Name: </strong>
       {{$merchantaddress[0]->first_name}} {{$merchantaddress[0]->last_name}}</p>
       <p style="margin: 0px"><strong>Creation Date: </strong>
        {{date('dMy H:i', strtotime($merchantaddress[0]->created_at))}}</p>
      </div>

    </div>

    <div style="display: flex; justify-content: space-between" >
     @if(isset($nid))
     <h5><strong>DO ID: </strong>{{$nid}}</h5>
     @else
     <h5><strong>Order ID: </strong>{{$nporder_id}}</h5>
     @endif
     @if(isset($heading))
     <h4 style="margin-right: 10px;"><strong>{{$heading}}</strong></h4>
     @else
     <h4 style="margin-right: 10px;"><strong>Sales Order</strong></h4>
     @endif
     <h5 style="margin-right: 35px;"><strong>Sales Order No: </strong>{{sprintf('%010d', $merchantaddress[0]->salesorder_no)}}</h5>
   </div>
</div>
   <div>
    <table class="table" style="margin-bottom: 0px;">
      <thead>
       <tr style="border-bottom:1pxsolid#ddd;background:black;color:white;">
        <th class="text-center">No</th>
        <th class="text-center">Product&nbsp;ID</th>
        <th>Description</th>
        <th class="text-center">Qty</th>
        <th class="text-right">Price ({{$currentCurrency}})</th>
        <th class="text-right">Amount ({{$currentCurrency}})</th>
      </tr>
    </thead>
    <tbody>
      <?php   $index = 1;$totalc=0; ?>
      @foreach($invoice as $invoice)
      <?php $price = $invoice->order_price; 
      $p_price = $price/100;
      $totalc  += $invoice->quantity*$p_price;
      ?>
      <tr>
        <td  class="text-center">{{$index++}}</td>
        <td  class="text-center">{{$invoice->ntproduct_id}}</td>
        <td style="width: 33%;">{{substr($invoice->description,0,40)}}
          @if(strlen($invoice->description) > 40))
          ...
          @endif
        </td>
        <td class="text-center">{{$invoice->quantity}}</td>
        <td style="width: 13%;" class="text-right">{{number_format($invoice->order_price/100,2)}}</td>
        <td   class="text-right">{{number_format($invoice->order_price/100*$invoice->quantity,2)}}</td>
      </tr>
      @endforeach

      <?php  
      $total  = number_format($totalc,2);
      $gst   = $totalc*6/100;
      $itmtotalprice = $totalc-$gst;
      $gst   = number_format($gst,2);
      $itmtotalprice   = number_format($itmtotalprice,2);
      ?>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td style="text-align: right; font-weight: bold;">Total {{$currency}}&nbsp&nbsp&nbsp{{$total}}</td>

      </tr>

  </tbody>
</table>
</div>
<hr style="margin: 0px;">
<div style="text-align: right; padding-right: 8px;">
  Total include 6% GST &nbsp&nbsp {{$currentCurrency}}&nbsp{{$gst}}<br><span>Item Total &nbsp&nbsp {{$currentCurrency}}&nbsp{{$itmtotalprice}}</span>

</div>
</div>
<script type="text/javascript" src="<?php echo e(asset('js/qr.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/html2pdf.js')); ?>"></script>
<script type="text/javascript">
  function genPDF() {
    var element = document.getElementById('download');
      html2pdf(element);
  }
 
  $(document).ready(function(){


    $('.qrcode').qrcode({height:70,width:70,text:{{sprintf('%06d', $merchantaddress[0]->salesorder_no)}} });
  });
</script>
