@extends('common.default')
@section('extra-links')
<link rel="stylesheet" type="text/css" href="{{asset('css/productbox.css')}}")>
<script type="text/javascript" src="{{asset('js/autolink.js')}}"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('div .checkbox').click(function () { checkedState = $(this).attr('checked');
                  $(this).parent('div').children('.checkbox:checked').each(function () {
                      $(this).attr('checked', false);
                  });
                  $(this).attr('checked', checkedState);
              });


	});
</script>
@stop
@section('content')
<div class="container">
	<div class="alert alert-success alert-dismissible hidden cart-notification" role="alert">
	      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	      <strong class='cart-info'></strong>
	 </div>
	 {{-- ^ No need maybe? --}}

	 <div class="row">
		 <div class="col-md-1">
		 	 <div data-spy="scroll" style="display: none;" class="static-tab">
                        <div class="text-center tab-arrow">
                            <span class="fa fa-sort"></span>
                        </div>
                        <ul class="nav nav-pills nav-stacked">
                        	@foreach($section as $s)
                        		  <li class="floor-navigation" role="presentation"><a href="#{{$s}}">{{$s}}</a></li>
                        	@endforeach
                         

                        </ul>
                    </div>
		 </div>
		 <div class="col-md-11">
		 	<div class="row signboard">
		 		  @if( isset($signboard->id))
	            	<img style="height: 200px;width:100%" class="width-100 img-responsive" src="{{ asset('images/signboard/'.$signboard->id .'/' .$signboard->image) }}" alt="{{ $merchant->oshop_name }} Signboard" />
	        	@endif
		 	</div>
		 	<div class="margin-top">@include('oshopnavigation')</div>
		 	<?php $value=4;$av=12; $text=30; $o=3;?>
		 	
		 		@if( isset( $bunting->id ) )
		 			<div class="col-md-2">
		 			<?php $value=3;
		 				$av=10;
		 				$text=20;
		 				$o=4;
		 			 ?>
                        <img style="height: 400px;width:100%" class="img-responsive" src="{{ asset('images/bunting/'.$bunting->id . '/' .$bunting->image) }}" alt="{{ $merchant->oshop_name }} Bunting" />
                        	</div>
                    @endif
		
		 	{{-- Put products  under their section --}}
		 	<div class="col-md-{{$av}} container">
		 		@foreach($section as $name)
		 			
		 			<div class="row"><h3 class="title" id="#{{$name}}">{{$name}}</h3> </div>
		 			<div class="row"> 
		 			@foreach($products as $product)
		 				@if($product['section']->name==$name)
		 					<div class="col-md-{{$o}} column productbox">
						    <a href="{{ route('productconsumer', $product['product']['id']) }}">
						    <div class="image">
						    <img src="{{ URL::to('/') }}/images/product/{{$product['product']['id']}}/{{$product['product']['photo_1']}}" class="img simg img-responsive full-width"></a>
						    </div>
						    @if(strlen($product['product']->name)<30)
						    <div class="producttitle">{{$product['product']->name}}</div>
						    @else
						    	  <div class="producttitle" ><a href="#" style="color:inherit" data-toggle="tooltip" data-placement="bottom" title="{{$product['product']->name}}">{{substr($product['product']->name,0,$text)}} </a></div>
						    	 
						    @endif
						  
						  
							{!! Form::open(array('url'=>'cart/addtocart',"class"=>"reset-this")) !!}
                                            <input type="hidden" name="quantity" id="quantity" value="1"> 
                                            {{-- {!! Form::hidden('quantity', 1) !!} --}}

                                            {!! Form::hidden('id', $product['product']->id) !!}
                                            <input type="hidden" name="price" value="" 
                                            {!! Form::hidden('price', $product['product']->retail_price) !!}
						    <button href="#" class="btn btn-green cartBtn btn-xsmall" role="button"><i class="fa fa-plus"></i></button>
						    {!!Form::close()!!} 
						   {{--  <button class="btn-pink btn btn-xsmall ">
						    	 <a href="javascript:void(0)" rel="nofollow" class="add-to-wishlist" style="color:white;" data-item-id="{{ $product['product']['id'] }}">p
                                                <i class="fa fa-heartprod"></i>
                                            </a>
						    </button> --}}
						             <button class="btn-darkgreen btn btn-xsmall"><i class="fa fa-shopping-cart"></i></button>
						    		  <div class="productprice">
						    						    <div class="pricetext" style="font-size:1em;color:red;">
						 			@foreach($product['price'] as $p)

						 			<div><input type="checkbox" class="checkbox"> {{$p->unit}} units for MYR {{$p->price}}. <br></div>
						 			@endforeach
						    </div>
						    </div>
						</div>
						            				{{-- Product dimension --}}
		 				@endif
		 			@endforeach
		 			</div>

		 		@endforeach
		 	</div>
			{{-- V --}}
			 @if( isset( $profile->vbanner->id ) )
                            <div  id="video" class="col-xs-12 margin-top video-banner">
                                <div class="placeholder">
                                    <div id="block">
                                        <?php
                                        $path = explode(':',$profile->vbanner->image)[0];
                                        ?>
                                        <span style="display: none" class="videobanner">@if($path == 'http' || $path == 'https'){{$profile->vbanner->image}}@else{{ asset('/images/vbanner/'.$profile->vbanner->id.'/'.$profile->vbanner->image)}}@endif</span>
                                    </div>
                                </div>
                            </div>
                        @endif
		 </div> 
		 {{-- col-md-11 --}}

	 </div>
</div>
@stop