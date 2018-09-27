<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal"
	aria-label="Close">
	<span aria-hidden="true">&times;</span>
</button>
<h4 class="modal-title" id="myModalLabel">Please Select Barcode</h4>
</div>
<table class="table">
	<tbody>
		<tr>
			{{-- <td style="width: 10%;"></td> --}}
			<td style="padding-left:20px">
				Default Barcode 
			</td>

			<td>
				<a href="{{url("barcode/generate",$product->id)}}" target="_blank">
					<span class="pmd_message">
						<canvas id="barcode1"
						style="width:265px;height:120px;padding-left:10px;padding-right:10px">
						</canvas>
						{{--<img src="{{asset('images/barcode/'.$product->id.'/'.$product->bcpath)}}"--}}
						{{--class="" mode="bc" rel-pid="{{$product->id}}"--}}
						{{--style="height:50px;width:150px;vertical-align: middle;">--}}
						<br>
						<span style="font-weight:bold;font-size:0.8em;"
						class="text-center">Default Barcode
					</span>
				</span>
			</a>
		</td>
	</tr>
	@if(!empty($barcodes))
	@def $i=1;
	@foreach($barcodes as $barcode)
	<tr>
		<td style="padding-left:20px">
			<span class=""><b>Barcode {{$i}}</b> for {{$product->name}}</span>
		</td>
		<td>
			<a href="{{url("barcode/generate",[$product->id,$barcode->bcode])}}" target="_blank" style="height:50px;width:100px;">
			<span class="pmd_message">
			<svg class="pbarcode"
			  jsbarcode-format="upc"
			  jsbarcode-value="{{$barcode->bcode}}"
			  jsbarcode-textmargin="0"
			  jsbarcode-fontoptions="bold">
			</svg>
			{{-- <canvas class="productbarcodes" id="bc_{{$barcode->bcode}}" rel-bc="{{$barcode->bcode}}"></canvas> --}}
			<br>
			<span style="font-weight:bold;font-size:0.8em;"
						class="text-center">
			{{$barcode->bcode." (".$barcode->bcode_type.")"}}
			</span>
		</td>
	</tr>
	<?php $i++;?>
	@endforeach
	@else
	<span class="text-warning">Product has not been mapped.</span>
	@endif

</tbody>
</table>
<script type="text/javascript">
	$(document).ready(function(){
		@foreach($barcodes as $b)
		$(".pbarcode").JsBarcode("{{$b->bcode}}",{
			displayValue:"false",
			
		});
		@endforeach
	})
</script>
