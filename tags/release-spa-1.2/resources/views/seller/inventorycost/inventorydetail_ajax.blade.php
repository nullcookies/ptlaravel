<div class="row">
  <div style="padding-left: 30%; text-align: left;" class="col-md-9 col-sm-9 col-xs-9">
    Quantity Left
  </div>
   <div class="col-md-3 col-sm-3 col-xs-3">
    {{$qtyleft}}
  </div>
  <div style="padding-left: 30%; text-align: left;" class="col-md-9 col-sm-9 col-xs-9">
    Average Cost (Based on Qty Purchased)
  </div>
  <div class="col-md-3 col-sm-3 col-xs-3">
   {{$currentCurrency}} {{number_format($avg/100,2)}}
  </div>

</div>

<br><br>

<table style="width: 100%; " id="einventorydetails" class="table ">
  <thead class="bg-inventory">
    <tr >
      <th class="text-center" scope="col">No</th>
      <th class="text-left" scope="col">Last Purchased</th>
      <th class="text-right" scope="col">Cost ({{$currentCurrency}})</th>
      <th class="text-center" scope="col">Qty Purchased</th>
    </tr>
  </thead>
  <tbody>
    <?php $index =0; ?>
    @foreach($inventorydetails as $inventorydetails)
    <tr style="padding: 8px 18px;">
      <th class="text-center">{{++$index}}</th>
      <td class="text-left">{{date('dMy H:i', strtotime($inventorydetails->created_at))}}</td>
      <td class="text-right">{{number_format($inventorydetails->cost/100,2)}}</td>
      <td class="text-center">{{$inventorydetails->purchaseqty}}</td>
    </tr>
    @endforeach
  </tbody>
</table>
<script type="text/javascript">
 $('#einventorydetails').DataTable({
  "order": [],

}); 

</script>
