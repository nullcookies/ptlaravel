<div class="col-sm-12">
	<h2>Voucher</h2>
	<div class="row" >
	@if(count($buyerVoucher)>0)
	@foreach($buyerVoucher as $voucher)
	<div class="row">
		<div class="col-md-12 col-xs-12" style="padding-bottom: 10px;">
			
		<div class="col-md-10" style="padding-left:0">
			@if($voucher->status == 'active')
				<a href="{{url().'/productconsumer/'.$voucher->id }}" >
			@else
				<a href="javascript:void(0);" >
			@endif

			<div class="col-md-8" style="background-color: #f00;
				 height:  200px;
				 background-image: url({{url()}}/images/product/{{$voucher->parent_id}}/{{$voucher->photo_1}});
				 background-size: cover;" >
			</div>
			
			<div class="col-md-4" style="background-color: #808080; height: 200px;color: white; font-size:20px">
				<div style="padding-left:0;padding-right:0" class="col-md-12" >
					<span>Merchant Voucher Coupon</span><br>
					<span class="pull-left"
						title="{{$voucher->name}}"
						style="font-size: 13px; display: inline-flex;
							line-height: 16px;">
						{{substr($voucher->name, 0,25)}}
					</span>
					<span class="pull-right"
						style="margin-top: 0; font-size: 30px;">
						{{$currentCurrency}} {{number_format($voucher->order_price * $voucher->quantity/100, 2)}}
					</span>
					
				</div>
				<div id="bottom_link">
					<?php 
						$ddesc = $voucher->description;
						if(strlen($ddesc) > 150){
							$ddesc = substr($ddesc,0,150) . "...";
						}
					?>
					<span title="{{$voucher->description}}">{{$ddesc}}</span>
			   </div>
			</div>
			</a>
		</div>
		</div>
	</div>
	@endforeach
	<br>	 
	@else
		<p>No Vouchers are available</p>
	@endif	
	</div>
</div>
