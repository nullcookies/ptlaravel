@extends("common.default")

@section("content")
@include("common.sellermenu")
<style type="text/css">
    div.dataTables_wrapper {
/*        width: 800px;
*/        
margin: 0 auto;
    }
</style>

    <div class="container" style="margin-top:30px;">
        <div class="row">
            
            <div class="col-md-12 equal_to_sidebar_mrgn">
				{!! Breadcrumbs::renderIfExists() !!}
               <h2>Station Inventory Report & Analysis</h2>    
            <br>   
                <table id="test" class="table table-bordered" cellspacing="0" width="100%">
                <thead style="background-color: #AAA; color: white">
                    <tr>
                        <th colspan="4" style="background-color: #AAA; color: white; text-align: center;">&nbsp;</th>
                        <th colspan="4" style="background-color: #AAA; color: white;">Accumulated Sales</th>
                        <th colspan="1" style="background-color: #AAA; color: white;">In</th>
                        <th colspan="3" style="background-color: #604a7b; color: white;t">WholeSale</th>
                        <th colspan="2" style="background-color: #008000; color: white;">&nbsp;</th>
                    </tr>
                    <tr>
                        <th class="no-sort" style="background-color: #AAA; color: white; text-align: center;">No</th>
                        <th class="large" style="background-color: #AAA; color: white; text-align: center;">Product&nbsp;ID</th>
                        <th class="large" style="background-color: #AAA; color: white; text-align: center;">Merchant&nbsp;ID</th>
                        <th class="medium" style="background-color: #AAA; color: white; text-align: center;">Name</th>
                        <th class="medium" style="background-color: #AAA; color: white; text-align: center;">High/Low</th>
                        <th class="medium" style="background-color: #AAA; color: white; text-align: center;">%</th>
                        <th class="medium" style="background-color: #AAA; color: white; text-align: center;">QTY&nbsp;Carry&nbsp;FWD</th>
						<th class="medium" style="background-color: #AAA; color: white;text-align: center;">Qty&nbsp;Left</th>
                        <th class="medium" style="background-color: #AAA; color: white;text-align: center;">Last&nbsp;Average&nbsp;Price</th>
                        
                        <th class="medium" style="background-color: #604a7b; color: white;text-align: center;">WholeSale</th>
                        <th class="medium" style="background-color: #604a7b; color: white;text-align: center;">Delivery&nbsp;Cost</th>
                        <th class="medium" style="background-color: #604a7b; color: white;text-align: center;">Order&nbsp;Qty</th>
                        <th class="medium" style="background-color: #008000; color: white;text-align: center;">Total&nbsp;Qty</th>
                        <th class="medium" style="background-color: #008000; color: white;text-align: center;">New&nbsp;Average&nbsp;Price</th>						
                    </tr>
                </thead>
                <tbody>
                  <?php $i = 1;?>
                     @foreach($inventoryResults as $inventory)            
					<tr>
					   <td class="text-center">{{$i++}}</td>
					   <td class="text-left"><a href="{{ route('productconsumer', $inventory->id) }}" rel="{{ $inventory->id }}" class="inventory_id">
						[{{str_pad($inventory->id,10,'0',STR_PAD_LEFT)}}]</a>
					   </td>
					   <td class="text-left"><a href="{{ route('merchantPopup', ['id' => $inventory->merchant_id]) }}" rel="{{ $inventory->id }}" class="inventory_merchant">
						[{{str_pad($inventory->merchant_id,10,'0',STR_PAD_LEFT)}}]</a>
					   </td>					   
					   <td class="text-left"><a href="javascript:void(0)" rel="{{ $inventory->id }}" class="inventory_orders">{{$inventory->name}}</a>
					   </td>
						<?php
							$highlow = "High";
							if($inventory->available < $inventory->stock*0.3){
								$highlow = "Low";
							}
							$percentage = $inventory->available*100/$inventory->stock;
						?>
					   <td class="text-center">{{$highlow}}</td>
					   <td class="text-right">{{number_format($percentage,2)}}</td>
					   <td class="text-center"></td>
					   <td class="text-center">{{$inventory->available}}</td>
					   <td class="text-center"></td>
					   <td class="text-center"><a href="javascript:void(0)" rel="{{ $inventory->id }}" class="inventory_wprices">Price</a></td>
					   <td class="text-center">{{(!empty($inventory->b2b_available)) ? $inventory->b2b_available : 'N/A'}}</td>
					   
					   <td class="text-center"></td>
					   <td class="text-center"></td>
					   <td class="text-center"></td>
                 </tr>
             @endforeach
				</tbody>
            </table>
            </div>
        </div>
    </div>
                
    <script type="text/javascript">
      
    $(document).ready(function () {
        var oTable = $('#test').dataTable({
        "order": [],
        "scrollX": true,
        "columnDefs": [{
                "targets": 'no-sort',
                "orderable": false,
			},{ "targets": "large", "width": "120px" },{ "targets": "xlarge", "width": "300px" },{ "targets": "medium", "width": "90px" }],
        "info":           true,
        "paging":         true,
        "iDisplayLength": 10
		});

});    

    
    </script>
@stop