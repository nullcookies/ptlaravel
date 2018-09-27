<?php 
use App\Http\Controllers\IdController;
?>
<style type="text/css">
	.autoclass_mobile {
		font-size: 1.2em !important;
		height: 52px;
		background:rgb(0,99,98);color:#fff;margin-bottom:3px;
	}
	.openwish_mobile{
		font-size: 2em !important;
	}
	.btn-pill{
		font-size: 0.98em !important;
		font-family: Lato
		border: 0.5px solid #C0EBE2;
		 font-family: 'Lato', sans-serif;

    	height: 50px;
		border-right:none; 
		text-align: center;
		line-height: 2em;
		/*font-weight: bold;*/
		color: #01B18B;
	}
	.btn-like-mobile{
		font-size: 2em !important;
	}
	.specification_mobile{
		display: none;
	}
	.active_border{
		border:2px solid #01B18B;
	}
	
	.dropdown-content-pmenu {
		display: none;
		position: absolute;
		background-color: rgba(0,0,0,0.8);
		width: 99%;
		margin-top: -2px;
		box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
		z-index: 6;
	}
	.paddingt{
		padding: 0 !important;
	}
</style>
<input type="hidden" id="pills_value" value="1">
<div class="container-fluid visible-xs" style="padding: 0 !important">
	<div class="col-xs-12 mobile no"style="background-color: white; margin-top: -2px;">
		<p style="color: #73D2C6; float: left; font-size: 22px;">Product Information</p><span style="color: #73D2C6; font-size: 22px;" class="glyphicon glyphicon-triangle-bottom pull-right pmobilemenu" onclick=""></span>
	</div>
	<div class="clearfix"></div>
	<div class="dropdown-content-pmenu">
	<div class="col-xs-12 no-padding" style="padding: 2px !important; text-center">
		<p style="color: #73D2C6 !important; font-size: 18px;" id="retail_nid">Product&nbsp;ID <b style="color: #FFF !important;">{{IdController::nP($product['pro']->id)}}</b></p>				
	</div>
	<div class="clearfix"></div>
	<div class="col-xs-4 no-padding" style="padding: 2px !important; text-center">
		@if(!is_null($qr))
			<img src="{{URL::to('/')}}/images/qr/product/{{$product['pro']->id}}/{{$qr->image_path}}.png"  width="100px" />
		@endif
	</div>
	<div class="clearfix"></div>
	<div class="mobilebotmenu2" style="padding: 5px 5px 0px 5px;">
		<hr class="mobilemenuhr">
	</div>
	<div class="col-xs-12 no-padding" style="padding: 2px !important; text-center">
		@if(!is_null($oshop_id) && $issingle == 0)
			<h3 style="color: #73D2C6 !important; margin-top: 0px !important;" href="javascript:void(0)">
					<a style="color: #73D2C6 !important;"  href="{{route('oshop.one', ['url' => $oshop_url])}}">O-Shop</a>
			</h3>
		@endif
		<h3 style="color: #73D2C6 !important; margin-top: 0px !important; font-weight: bold;" class="segment_title" id="title_retail" href="javascript:void(0)">
				<a style="color: #73D2C6 !important;"  href="javascript:void(0)" class="segment_change" rel="retail">Retail</a>
		</h3>	
		@if(!is_null($productb2b) || $countsp > 0)		
			<h3 style="color: #73D2C6 !important; margin-top: 0px !important;" href="javascript:void(0)" class="segment_title" id="title_b2b">
					<a style="color: #73D2C6 !important;"   href="javascript:void(0)" class="segment_change" rel="b2b">B2B</a>
			</h3>
		@else
			<h3 style="color: #2F4F4F !important; margin-top: 0px !important;"href="javascript:void(0)">
					<a style="color: #2F4F4F !important;"   href="javascript:void(0)">B2B</a>
			</h3>			
		@endif
		@if(!is_null($hyper))
			<h3 style="color: #73D2C6 !important; margin-top: 0px !important;" href="javascript:void(0)" class="segment_title" id="title_hyper">
					<a style="color: #73D2C6 !important;" href="javascript:void(0)" class="segment_change" rel="hyper">Hyper</a>
			</h3>
		@else
			<h3 style="color: #2F4F4F !important; margin-top: 0px !important;"href="javascript:void(0)">
					<a style="color: #2F4F4F !important;"   href="javascript:void(0)">Hyper</a>
			</h3>			
		@endif		
	</div>
	<div class="clearfix"></div>
	<div class="mobilebotmenu2" style="padding: 5px 5px 0px 5px;">
		<hr class="mobilemenuhr">
	</div>	
	<h3 style="color: #73D2C6 !important; margin-top: 0px !important; font-weight: bold;" class="productdelivery" href="javascript:void(0)">
		<a style="color: #73D2C6 !important;"  href="#">Delivery</a>
	</h3>
	<div class="col-xs-12">
		<table class="table" style="color: #73D2C6 !important; font-size: 16px;">
			<tr><th class="paddingt">Country</th><td class="paddingt">{{ $product['pro']->country ? $product['pro']->country->name : "-" }}</td></tr>
			<tr><th class="paddingt">State</th><td class="paddingt">{{ $product['pro']->state ? $product['pro']->state->name : "-" }}</td></tr>
			<tr><th class="paddingt">City</th><td class="paddingt">{{ $product['pro']->city ? $product['pro']->city->name : "-" }}</td></tr>
			<tr><th class="paddingt">Area</th><td class="paddingt">{{ $product['pro']->area ? $product['pro']->area->name : "-" }}</td></tr>
			<tr><th class="paddingt">Delivery</th><td class="paddingt">
				
				@if($product['pro']->del_option == "own")
								{{$currentCurrency}} {{number_format($delivery,2)}}
									@if($product['pro']->flat_delivery == 1)
										<b>[Flat Price]</b>
									@else
										<b>[Price Per Unit]</b>
									@endif
								</p>
							@else
								@if($product['pro']->del_option == "system")
									{{$currentCurrency}} {{number_format($delivery,2)}}
								@else
									Pick up Only Product
								@endif
							@endif
							@if($product['pro']->free_delivery_with_purchase_qty > 0 && $product['pro']->free_delivery == 0)
								<b>Free Delivery</b>&nbsp;&nbsp;&nbsp;&nbsp; Buy more than {{$currentCurrency}} {{number_format($product['pro']->free_delivery_with_purchase_qty/100,2,'.',',')}}
							@endif
						</td></tr>
			</table>
	</div>	
	<div class="clearfix"></div>
	<div class="mobilebotmenu2" style="padding: 5px 5px 0px 5px;">
		<hr class="mobilemenuhr">
	</div>	
	<h3 style="color: #73D2C6 !important; margin-top: 0px !important; font-weight: bold;" class="productdelivery" href="javascript:void(0)">
		<a style="color: #73D2C6 !important;"  href="#">Specification</a>
	</h3>	
	<div class="col-xs-12" style="color: #73D2C6 !important;">
		<div class="form-group">
		@if(!is_null($product['subcat_level2']))
		<label for="product_specification_2" class="col-xs-4 no-padding control-label">Product</label>
		<div class="col-xs-8">
			<p>{{$product['subcat_level2']->description}}</p>
		</div>
		<div class="clearfix"></div>
		@endif
		@if(!is_null($product['subcat_level3']))
		<label for="product_specification_2" class="col-xs-4 no-padding control-label">SubProduct</label>
		<div class="col-xs-8">
			<p>{{$product['subcat_level3']->description}}</p>
		</div>
		<div class="clearfix"></div>
		@endif
		<style>
			.wColorPicker-button {
				position: relative;
				border-radius: 5px;
				border: solid #CACACA 1px;
				padding: 1px;
				cursor: pointer;
				width: 75px !important;
				height: 25px !important;
				margin-top: -4px !important;
			}
			.wColorPicker-button-color {
				position: relative;
				border-radius: 5px;
				height: 20px !important;
			}
		</style>
		@if(!is_null($product['colors']))
			<label for="product_specification_2" class="col-xs-4 control-label no-padding">Colour</label>
			<?php $colors = $product['colors'];
				$cc=0;							
			?>
			@foreach($colors as $colordef)
				<div class="col-xs-4 mt "
					style="margin-bottom: 5px;">
					<div class="wColorPicker-button">
						<div class="wColorPicker-button-color" style="background-color: {{$colordef->hex}}; height: 4px;"></div> 
					</div>
				</div>	
				<div class="col-xs-4 mt">
					<span style="float:left;">{{$colordef->description}}</span>
				</div>	
					
				<div class="clearfix"></div>
				<?php $cc++;?>
			@endforeach
			<div class="clearfix"></div>
		@endif
		
		<label for="product_specification_2" class="col-xs-4 control-label no-padding">(LxWxH)</label>
		<div class="col-xs-8">
			<p>{{$product['pro']->length}}x{{$product['pro']->width}}x{{$product['pro']->height}} cm</p>
		</div>
		<div class="clearfix"></div>
		<label for="product_specification_2" class="col-xs-4 control-label no-padding">Weight</label>
		<div class="col-xs-8">
			<p>{{$product['pro']->weight}} kg</p>
		</div>
		<div class="clearfix"></div>	
		<label for="product_specification_2" class="col-xs-4 control-label no-padding">Delivery&nbsp;Time</label>
		<div class="col-xs-8">
			<p>{{$product['pro']->delivery_time}} to {{$product['pro']->delivery_time_to}} working days</p>
		</div>
		<div class="clearfix"></div>
	</div>
	</div>
</div>	
</div>
<div class="container p_retail p_mobile_view mobile">
<div class="row">
	<div class="col-xs-12" style="">
		<img src="{{asset('/')}}images/product/{{$product['pro']->id}}/{{$product['pro']->photo_1}}"
					title="product-image"
					class="img-responsive" style="margin-bottom: 5px;">
		{{-- AutoLink Button --}}
	
	</div>
</div>
<div class="row">
	<div class="col-xs-12">
		{{-- LIKE --}}
					{{-- Likes --}}
			@if($product['liked'] == 0)
				<span class="btn btn-lg btn-pink btn-block  btn-like btn-like-mobile likesmedia" style="margin-right:0">
					<a href="javascript:void(0)" id="r-like" rel="nofollow"
						class="product_like" style="color:white;"
						data-item-id="{{ $product['pro']->id }}" title="Remember&nbsp;the&nbsp;products&nbsp;that&nbsp;you like!&nbsp;It's&nbsp;stored&nbsp;in&nbsp;Buyer&nbsp;Dashboard, at the [Like] tab"> 
						<img style="height:50px;width:20px;visibility:hidden" src="/images/bike-chain.png"><span class="likes_number">{{$product['likes']}}</span> Likes <i class="fa fa-heart"></i> 
					</a>
				</span>
			@else
				<span class="btn btn-lg btn-pink btn-block  btn-like btn-like-mobile pull-right likesmedia" style="color: rgb(255,0,128); border-color: rgb(255,0,128); background: rgb(255,255,255);margin-right:0">
					<a href="javascript:void(0)" id="r-like" rel="nofollow"
						class="product_like" style="color:rgb(255,0,128);"
						data-item-id="{{ $product['pro']->id }}" title="Remember&nbsp;the&nbsp;products&nbsp;that&nbsp;you like!&nbsp;It's&nbsp;stored&nbsp;in&nbsp;Buyer&nbsp;Dashboard, at the [Like] tab"> 
						<img style="height:50px;width:20px;visibility:hidden" src="/images/bike-chain.png"><span class="likes_number">{{$product['likes']}}</span> Likes <i class="fa fa-heart"></i> 
					</a>
				</span>						
			@endif
		{{-- /L --}}
	</div>
</div>



<div class="row">
	<div class="col-xs-12">
		<h2>{{$product['pro']->name ? $product['pro']->name : "-" }}</h2>
	</div>
</div>
<div class="row" style="font-size: 1.2em;font-weight: bold;">
	<div class="col-xs-6 pull-left">
		<span>Retail&nbsp;Price</span>
	</div>
	<div class="col-xs-6 pull-right">
		{{$currentCurrency}}
		@if(!empty($discount_detail))
							
		<span class="amt"
		amount={{$discount_detail['discounted_price_dis']}}>
		{{$discount_detail['discounted_price_dis']}}</span>


		@else
	
			<span class="amt" amount=>
			{{ number_format($amount,2) }}
			</span>
		
		@endif
	</div>
</div>
<div class="row" style="font-size: 1.2em;font-weight: bold;">
	<div class="col-xs-6 pull-left">
		<span>Available</span>
	</div>
	<div class="col-xs-6 pull-right">
		{{$product['pro']->available?$product['pro']->available:"0"}}
	</div>
</div>
{{-- SPACE FOR BOX --}}
<div class="row">
	<div class="col-xs-12">
		<table class="table noborder">
							<input type="hidden" value="{{$product['pro']->free_delivery_with_purchase_amt ? $product['pro']->free_delivery_with_purchase_amt : '0'}}" id="free_delivery_with_purchase_qty" />
							<input type="hidden" value="{{$product['pro']->free_delivery ? $product['pro']->free_delivery : '0'}}" id="free_delivery" />
							<input type="hidden" value="{{ number_format($delivery,2) }}" id="mydelprice" />
							<input type="hidden" value="{{ number_format($delivery,2) }}" id="mycart_delprice" />
							<tr><th style="padding-bottom:0">Amount</th>
								<td style="padding-bottom:0">{{ $currency }}</td>
								@if(!empty($discount_detail))
								<td style="padding-bottom:0">
									<span class="amt"
									amount={{$discount_detail['discounted_price_dis']}}>
									{{$discount_detail['discounted_price_dis']}}</span>


								</td>
								@else
								<td style="padding-bottom:0">
									<span class="amt" amount={{ $amount }}>
									{{ number_format($amount,2) }}
									</span>
								</td>
								@endif
							</tr>
							<tr>
								<th style="padding-bottom:0">Delivery</th>
								<td style="padding-bottom:0">{{ $currency }}</td>
								<td style="padding-bottom:0">
								<span class="del_price">
								{{ number_format($delivery,2) }}
									</span>
								</td>
							</tr>
							<tr><td colspan="3"><hr></td></tr>
							<tr>
								<th style="padding-bottom:0;padding-top:0">Total @if($showGST==1) 
								(Incl. {{$gst_tax_rate}}% GST) 
								@endif</th>
								<td style="padding-bottom:0;padding-top:0">{{$currency}}</td>
								<td style="padding-bottom:0;padding-top:0">
									@if(!empty($discount_detail))
									<span class="total">
										{{ number_format($discount_detail['discounted_price_dis']+$delivery,2) }}
									</span>
									@else
									<span class="total">
										{{ number_format($amount+$delivery,2) }}
									</span>
									@endif

								</td>
							</tr>
							
						</table><!-- AutoLink validation was removed -->	
	</div>
</div>
{{-- ENDS --}}
<div class="row no-gutter">
	<div class="col-xs-12">
					@if(Auth::check())
							@if($autolink_status == 0  && $immerchant != $merchant_id)
								@if($autolink_requested == 0)
									<button type="button"
										data-button="{{$merchant_id}}"
										class="btn btn-lg btn-success autoclass_mobile btn-block pull-left pull-left autolink_btn logged_in"
										id="autolink_btn "
										style="" title="Press to get B2B and Special pricing">
										<img style="height:30px;width:30px;" src="/images/bike-chain.png">AutoLink
									</button>
									<button type="button"
										data-button="{{$merchant_id}}"
										class="btn pull-left btn-success  autoclass_mobile btn-block pull-left cancel_autolink"
										id="cancel_autolink"
										style="background:#fff;color:rgb(0,99,98); display: none;" title="You have an outstanding AutoLink&nbsp;&nbsp;&nbsp; Request">
										<img style="height:30px;width:30px;" src="/images/bike-chain.png">AutoLink
									</button> 							
									
								@else
									<button type="button"
										data-button="{{$merchant_id}}"
										class="btn btn-default btn-success  autoclass_mobile btn-block pull-left cancel_autolink"
										id="cancel_autolink"
										style="background:#fff;color:rgb(0,99,98);" title="You have an outstanding AutoLink&nbsp;&nbsp;&nbsp; Request">
									<img style="height:30px;width:30px;" src="/images/bike-chain.png">AutoLink
									</button>
								 	<button type="button"
										data-button="{{$merchant_id}}"
										class="btn btn-default btn-success autolink_btn btn btn-default-success btn btn-default-lg autoclass_mobile btn-block pull-left"
										id="autolink_btn btn-default"
										style="background:rgb(0,99,98);color:#fff; display: none;" title="Press to get B2B and Special pricing">
										<img style="height:30px;width:30px;" src="/images/bike-chain.png">AutoLink
									</button>						
									&nbsp;							
								@endif
								<input type="hidden" id="autolink_user_id" value="{{Auth::user()->id}}" />
								<input type="hidden" id="autolink_merchant_id" value="{{$merchant_id}}" />
							@else
								@if($immerchant == $merchant_id)
									<button type="button"
										disabled
										data-button="{{$merchant_id}}"
										class="btn btn-default btn-success btn btn-default-success btn btn-default-lg btn-block badge1"
										id="autolink_merchant"
										style="background:#fff;color:rgb(0,99,98);right:0;margin-top:4px; right: 0px; margin-top: 4px; padding-bottom: 7px; padding-top: 7px;"
										title="Warning: A merchant cannot AutoLink&nbsp;&nbsp;&nbsp; with yourself"
										@if($badge_num > 0)
											data-badge="{{$badge_num}}"
										@endif
										>
										<span><img height="27" width="27"
											src="/images/bike-chain.png">&nbsp;</span>
										AutoLink&nbsp;&nbsp;&nbsp;
									</button>&nbsp;								
								@else	
									<button type="button"
										data-button="{{$merchant_id}}"
										class="btn btn-default btn-success btn btn-default-success btn btn-default-lg autoclass_mobile btn-block pull-left"
										id="cancel_autolink"
										style="background:#fff;color:rgb(0,99,98);" title="You are AutoLink&nbsp;&nbsp;&nbsp;ed">
										<img style="height:30px;width:30px;" src="/images/bike-chain.png">AutoLink
									</button>
									<button type="button"
										data-button="{{$merchant_id}}"
										class="btn btn-default btn btn-default-success btn btn-default-lg autoclass_mobile btn-block pull-left"
										id="autolink_btn btn-default"
										style="background:rgb(0,99,98);color:#fff;right:0;margin-top:4px; right: 0px; margin-top: 4px; padding-bottom: 7px; padding-top: 7px; display: none;" title="Press to get B2B and Special pricing">
										<span><img height="27" width="27"
											src="/images/bike-chain.png">&nbsp;</span>
										AutoLink&nbsp;&nbsp;&nbsp;
									</button>						
									&nbsp;	
									<input type="hidden" id="autolink_user_id" value="{{Auth::user()->id}}" />
									<input type="hidden" id="autolink_merchant_id" value="{{$merchant_id}}" />						
								@endif					
							@endif
							
			@else				
				{{-- <a href="javascript:void(0)" data-toggle="modal" data-target="#loginModal" class="autolink_validation" style="padding: 0px;"> --}}
			<button type="button"
									class="btn btn-default btn btn-default-success btn btn-default-lg autoclass_mobile btn-block pull-left not_logged_in"
									id="autolink_btn"
									style="background:rgb(0,99,98);color:#fff;" title="Press to get B2B and Special pricing">
									<span><img style="height:30px;width:30px;"
										src="/images/bike-chain.png">&nbsp;</span>
									AutoLink&nbsp;&nbsp;&nbsp;
								</button>
							{{-- </a> --}}
			@endif
			{{-- AutoLink Ends --}}
	</div>
</div>
<div class="row">
	<div class="col-xs-12">
		<div class="input-group" style="margin-bottom:2px; @if(!empty($discount_detail)) display: none; @endif">
								<span class="input-group-btn">
									<button @if(!empty($discount_detail)) disabled="" @endif type="button" class="btn btn-green btn-number" data-action="plus" style="height: 50px;width: 75px;">
											 <span class="glyphicon glyphicon-plus"></span>
									</button>
								</span>
								<input @if(!empty($discount_detail)) readonly="" @endif style="text-align: center; padding-left: 0px; padding-right: 0px;width:100%; height: 50px;font-size: 2em;"
										type="text" name="quant[2]" class="form-control input-number quantity"
										value="1" min="1" max={{ $product['pro']->available ? $product['pro']->available : "0"}}>
										<span class="input-group-btn">
									<button @if(!empty($discount_detail)) disabled="" @endif type="button" class="btn btn-green btn-number btn-lg" data-action="minus" style="height: 50px;width: 75px;">
											 <span class="glyphicon glyphicon-minus"></span>
									</button>
								</span>
							</div>
	</div>
</div>
<div class="row">
	<div class="col-xs-12">
		{!! Form::hidden('quantity', 1) !!}
										{!! Form::hidden('id', $product['pro']->id) !!}
										@if(!empty($discount_detail))
											{!! Form::hidden('price', $discount_detail["discounted_price_dis"] * 100) !!}
											<input type="hidden" id="cartpage" value="productconsumerdisc" />  
										@else
											{!! Form::hidden('price', $amount * 100) !!}
											<input type="hidden" id="cartpage" value="" /> 
										@endif
										<input type="hidden" id="delivery_price" value="first" />
										<input type="hidden" id="delivery_price2" value="first" />
		<button  class='btn  btn-block add_to_cart' title="Adds a product into your Shopping Cart" type='submit'  style="font-size: 1.2em;background-color:#28A98A;color: white;">
			<img src="{{asset('images/shopping_cart_button.png')}}" alt="Add to Cart" style="width:50px;height:50px;">
		Add Cart</button>
		</form>
		<button  class='btn btn-warning btn-block show_openwish_modal' title="Adds a product into your Shopping Cart" type='button'  style="font-size: 1.2em;background-color:#D6E940;color: white;border:none !important;" id="r-owish"  data-item-id="{{ $product['pro']->id }}" data-item-type="new">
		<img src="{{asset('images/openwish_button.png')}}" class="" alt="Open Wish" style="width:50px;height:50px;">
		OpenWish</button>
		<button  class='btn btn-success btn-block blast-none' title="Adds a product into your Shopping Cart" type='button'  style="font-size: 1.2em;background-color:#1498EA;color: white;" data-pid="{{$product['pro']->id}}"><img src="{{asset('images/smm_button.png')}}" alt="SMM" style="width:50px;height:50px;vertical-align: middle;">SMM</button>
	</div>
</div>
<hr>
{{-- Description --}}
<div class="row">
	<div class="col-xs-12">
		<h3>Product Description</h3>
	</div>
	<div class="col-xs-12">
		<table class="table table-striped">
		<tr>
			<th>
				Product&nbsp;ID
			</th>
			<td>
				{{IdController::nP($product['pro']->id)}}
			</td>
		</tr>
		<tr>
			<th>
				Name
			</th>
			<td>
				{{$product['pro']->name ? $product['pro']->name : "-" }}
			</td>
		</tr>
		<tr>
			<th>
				Brand
			</th>
			<td>
				{{$product['pro']->brand ? $product['pro']->brand->name : "-" }}
			</td>
		</tr>
		<tr>
			<th>
				Category
			</th>
			<td>
				{{$product['pro']->category ? $product['pro']->category->description : "-" }}
			</td>
		</tr>
		<tr>
			<th>
				Sub Category
			</th>
			<td>
				{{$product['subcat_level1'] ? htmlentities($product['subcat_level1']->description) : "-" }}
			</td>
		</tr>
		<tr>
			<th>
				O-Shop
			</th>
			<td>
				@if(!is_null($oshop_id) && $issingle == 0)
					<a href="{{route('oshop.one', ['url' => $oshop_url])}}" >{{ $oshopname }}</a>
				@else
					{{ $oshopname }}
				@endif
			</td>
		</tr>
		<tr>
			<th>
				Description
			</th>
			<td>
				{{$product['pro']->description}}
			</td>
		</tr>
		</table>
	</div>	
</div>
<hr>
<div class="row">
	<div class="col-xs-12">
		<h3>Product Details</h3>
	</div>
	<div class="col-xs-12"
		style=" min-height: 20px;" id="product_description_summernote">
		<!-- <iframe width="100%" style="border: none; min-height: 300px;" src="{{URL::to('/')}}/mobile/productdetails/{{$product['pro']->productdetail_id}}"></iframe> -->
		{!! $product['pro']->product_details ? $product['pro']->product_details : "-" !!}
	</div>	
</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$(document).delegate( '.segment_change', "click",function (event) {
			var segment=$(this).attr('rel');
			$(".p_mobile_view").hide();
			$(".segment_title").css("font-weight","normal");
			$("#title_" + segment).css("font-weight","bold");
			if(segment == "retail"){
				$('.p_retail').show();
			} else if(segment == "b2b"){
				$('.p_b2b').show();
			}else if(segment == "hyper"){
				$('.p_hyper').show();
			}
			$(".dropdown-content-pmenu").hide();
			$(".cmobilemenu").addClass('glyphicon-triangle-bottom');
			$(".cmobilemenu").removeClass('glyphicon-triangle-top');
			$(".cmobilemenu").addClass('pmobilemenu');
			$(".cmobilemenu").removeClass('cmobilemenu');
		});
		$(document).delegate( '.pmobilemenu', "click",function (event) {
			// console.log("CLOSE");
			$(".dropdown-content-pmenu").show();
			$(this).removeClass('glyphicon-triangle-bottom');
			$(this).addClass('glyphicon-triangle-top');
			$(this).removeClass('pmobilemenu');
			$(this).addClass('cmobilemenu');
		});
		$(document).delegate( '.cmobilemenu', "click",function (event) {
			// console.log("CLOSE");
			$(".dropdown-content-pmenu").hide();
			$(this).addClass('glyphicon-triangle-bottom');
			$(this).removeClass('glyphicon-triangle-top');
			$(this).addClass('pmobilemenu');
			$(this).removeClass('cmobilemenu');
		});
		
		$('.btn-pill').click(function(){
			$tog=$(this).attr('tog');

			if ($tog==0) {
				$('.specification_mobile').hide();
				$('.delivery_mobile').hide();
				$('.description_mobile').show();
			}
			else if($tog==1){
				$('.specification_mobile').hide();
				$('.delivery_mobile').show();
				$('.description_mobile').hide();
			}else{
				$('.specification_mobile').show();
				$('.delivery_mobile').hide();
				$('.description_mobile').hide();

			}
		});
		$('.not_logged_in').click(function(){
			toastr.warning("Please login to access this feature.");
		});
	});
</script>