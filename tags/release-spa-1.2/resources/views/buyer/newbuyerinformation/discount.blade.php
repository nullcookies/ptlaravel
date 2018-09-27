<?php $www = 0; ?>
<style>
	#bottom_link{
	   position:absolute; 
	   bottom:0;
	   left:2px;
	   font-size: 12px;
	}
</style>
<div class="col-sm-12" style="padding-left:0">
	<h2>Merchant Discount Coupon</h2>
	@if(count($buyerDiscount)>0)
	@foreach($buyerDiscount as $discount)
	<?php
		$exp_date = date("d-M-Y H:s:i", strtotime($discount->created_atnew . "+ " . $discount->duration_days . ' days'));
		if((time()-(60*60*24)) < strtotime($exp_date)){
			$www++;
	 ?>
	<div class="row">
		<div class="col-md-12 col-xs-12" style="padding-bottom: 10px;">
			
		<div class="col-md-10" style="padding-left:0">
			@if($discount->discstatus == 'active')
				<a href="{{url().'/productconsumer/'.$discount->product_id }}" >
			@else
				<a href="javascript:void(0);" >
			@endif

			<div class="col-md-8" style="background-color: #f00;
				 height:  200px;
				 background-image: url({{url()}}/images/discount/{{$discount->discount_id}}/{{$discount->image}});
				 background-size: cover;" >
			</div>
			
			<div class="col-md-4" style="background-color: #808080; height: 200px;color: white; font-size:20px">
				<div style="padding-left:0;padding-right:0" class="col-md-12" >
					<span>Merchant Discount Coupon</span><br>
					<span class="pull-left"
						title="{{$discount->product_name}}"
						style="font-size: 13px; display: inline-flex;
							line-height: 16px;">
						{{substr($discount->product_name, 0,25)}}
					</span>
					<span class="pull-right"
						style="margin-top: 0; font-size: 30px;">
						@if($discount->discstatus == 'executed')
							<span style="color:red;">USED</span>
						@else
							{{$discount->discount_percentage}}%
						@endif
					</span>
					
				</div>
				<div id="bottom_link">
					<?php 
						$ddesc = $discount->remarks;
						if(strlen($ddesc) > 150){
							$ddesc = substr($ddesc,0,150) . "...";
						}
					?>
					<span title="{{$discount->remarks}}">{{$ddesc}}</span>
			   </div>
			</div>
			</a>
		</div>
		</div>
	</div>
	<?php
		}
	?>
	@endforeach
	<br>
	@if($www == 0)
	<h4>0 <small>active discount found</small></h4>
	@endif		 
	@else
	<p>No Discounts are available</p>
	@endif

</div>
