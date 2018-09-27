
<script type="text/javascript">

    $('#doc_no').on('input', function() {
    });
 function saveinventorycost() {
   var doc_no = $('#doc_no').val();
   var doc_date = $('#doc_date').val();
   var merchant = $('#setbuyer').val();
   var isemerchant = $('#isbuyer').val();
   if(doc_no!="" && doc_date!="")
   {
    
    $.ajax({
      type: "GET",
      url: JS_BASE_URL+"/seller/saveinventorycost/"+merchant+"/"+isemerchant+"/"+doc_no+"/"+doc_date,
      success: function( data ) {
       if (data==0) {
          toastr.error('Document Number already Exist !');
       } else{
        $('input[name=doc_no]').val(doc_no);
        $('input[name=doc_date]').val(doc_date);
           document.getElementById('submitform').disabled = false;
       }
      }
    });
  }
  else
  {

  }

}
</script>

<form id="docnovalidate" method="post">
<div class="row">
  <div class="col-md-6 col-sm-6 col-xs-6">
    <label class="pull-left">Document No: </label>
<input onblur="saveinventorycost()" type="text" required="required" class="form-control" id="doc_no" name="">
  </div>

</div>

<div style="margin-top: 10px;" class="row">
   <div class="col-md-6 col-sm-6 col-xs-6">
    <label class="pull-left">Document Date: </label>
<input onblur="saveinventorycost()" type="date" required="required" max="{{date('Y-m-d')}}" class="form-control" id="doc_date" name="">


  </div>
</div>
</form>
<br><br>

<table style="width: 100%; " id="einventoryconfirm" class="table ">
  <thead class="bg-inventory">
    <tr >
      <th class="text-center" scope="col">No</th>
      <th class="text-left" scope="col">Product&nbsp;Name</th>
      <th class="text-right" scope="col">Price (MYR)</th>
      <th class="text-center" scope="col">Qty</th>
      <th class="text-right" scope="col">Total (MYR)</th>
    </tr>
  </thead>
  <tbody>
    <?php $index =0; ?>
    @foreach($product as $product)
      <tr style="padding: 8px 18px;">
      <th class="text-center">{{++$index}}</th>
      <td class="text-left">
        <div style="width: 100%;float: left;">
                @if(File::exists(URL::to("images/product/$product[id]/thumb/$product[thumb]")))
                <img width="30" height="30" src="{{URL::to("images/product/$product[id]/thumb/$product[thumb]")}}">
                @else
                <img width="30" height="30" src="{{URL::to("images/product/$product[id]/thumb/$product[thumb]")}}">
                @endif
                &nbsp
                {{$product['name']}}
              </div>



      </td>
      <td class="text-right">{{number_format($product['price'],2)}}</td>
      <td class="text-center">{{$product['quantity']}}</td>
      <td class="text-right">{{number_format($product['price']*$product['quantity'],2)}}</td>
    </tr>
    @endforeach
  </tbody>
</table>
<script type="text/javascript">
 $('#einventoryconfirm').DataTable({
  "order": [],

});




</script>
