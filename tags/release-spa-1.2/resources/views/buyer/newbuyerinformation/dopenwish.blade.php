{{-- Openwish --}}
<div class="col-md-12 col-xs-12 col-sm-12 col-lg-12" style="padding-left:0">
	<div class="alert alert-success alert-dismissible hidden cart-notification" role="alert">
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  <strong class='cart-info'></strong>
	</div>
	<div class="row hidden-xs" style="margin-left:0;margin-right:0">
		<div style="margin-left:0;margin-right:0">
		<button class="button" >
		<img src="{{asset('images/openwish_button.png')}}"
		style="width:40px;height:34px;">OpenWish</button></div>
		<br>
		<h4><em>New OpenWishes</em></h4>

	</div>
	<input type="hidden" id="info_toggler_buyer_ow" value="0">
	<div class="row visible-xs">
		<div class="col-xs-12">
			<h3 class="visible-xs mobile_click_info_show_ow text-center">OpenWish<small class="mobile_arrow_ow fa fa-angle-up" style="color: #34dabb;cursor: pointer;"></small></h3>
		</div>
	</div>
<script type="text/javascript">
$(document).ready(function(){
	$('.mobile_click_info_show_ow').click(function(){
		var $info_toggler=$('#info_toggler_buyer_ow').val();
		if ($info_toggler==0) {
		$('.mobile_info_ow').show(300);
		$('.mobile_arrow_ow').removeClass('fa-angle-down');
		$('.mobile_info_ow_active').hide();
		
		$('.mobile_arrow_ow').addClass('fa-angle-up');
		$('#info_toggler_buyer_ow').val(1);
		}else{
		$('.mobile_info_ow').hide(100);
		$('.mobile_arrow_ow').addClass('fa-angle-down');
		
		$('.mobile_info_ow_active').show(100);
		$('.mobile_arrow_ow').removeClass('fa-angle-up');
		$('#info_toggler_buyer_ow').val(0);
		}
	});

});
</script>

	<div class="row mobile_info_ow_active">
	<?php $hy = 0; ?>
	<?php $hyp = 0; ?>
	@foreach($openwishes as $openwish)
		<?php 
		// Price Calculations
		$price = $openwish->retail_price;
        
		if ($openwish->discounted_price != 0 and
			$openwish->discounted_price <  $openwish->retail_price) {

            $price =  $openwish->discounted_price;

		}
		
		?>
		@if($openwish->status == 'active')
			@if($hy == 0)
				@if($hyp == 0)
					<div id="p{{$hyp}}" class="pa">
				@else
					<div id="p{{$hyp}}" style="display: none;" class="pa">
				@endif
				<?php $hyp++; ?>
			@endif
			<?php $product_name = strlen($openwish->product_name);$name = substr($openwish->product_name,0,12);

			?>
			{{-- Mobile --}}
			<div class="visible-xs col-xs-6 ">
				<div class="row productbox">
					<div class="boxTile" style='border:1px solid  #d0d0d0'>
						<div class="square">
							<a href="{{asset('productconsumer/'.$openwish->product_id)}}">
								<img class=" img-responsive "
								style="object-fit:contain"
								src="{{asset('images/product/'.$openwish->folder_number.'/'.$openwish->photo_1)}}"
								title="{{$openwish->product_name}}" >
							</a>
						</div>
					</div>
					<div class="square" >
						{{-- TEXT --}}
						<span class="pull-left" style="cursor: hand;" title="{{$openwish->product_name}}" onclick="show_name('{{$openwish->product_name}}')">{{$name}}</span>
						<span class="pull-right">{{number_format($price / 100,2)}}&nbsp;{{$currentCurrency}}.</span>
						<hr style="border: 1px solid #000000;">
						<button class="btn btn-openwish btn-block show_openwish_modal" style="font-size: 1.2em;">BOOST</button>
						<span style="font-size: 0.8em;font-weight: bold;">
						<span class="pull-left">Accumulated</span>
						<span class="pull-right">{{number_format(($openwish->pledged_amt/100),2)}}&nbsp;{{$currentCurrency}}.</span>
						</span>
						<button style="font-size: 1.2em;" class="btn btn-buy btn-block" onclick='addToCartow({{$openwish->product_id}}{{','}}{{(number_format($openwish->retail_price / 100 , 2))}}{{','}}{{(number_format($openwish->pledged_amt / 100 , 2))}}{{','}}{{$openwish->id}})'>BUY</button>
						<span style="font-weight: bold;font-size: 0.8em;">
						<span class="pull-left">Balance</span>
						<span class="pull-right">{{number_format(($price / 100) - ($openwish->pledged_amt / 100) , 2)}}&nbsp;{{$currentCurrency}}.</span>
						</span>
					</div>

				</div>

			</div>
			{{-- Mobile Ends --}}
			<div class="hidden-xs col-sm-6 col-md-4 col-lg-3">
				<div class="row productbox">
					<div class="boxTile" style='border:1px solid  #d0d0d0'>
						<div class="square">
							<a href="{{asset('productconsumer/'.$openwish->product_id)}}">
								<img class=" img-responsive "
								style="object-fit:contain"
								src="{{asset('images/product/'.$openwish->folder_number.'/'.$openwish->photo_1)}}"
								title="{{$openwish->product_name}}" >
							</a>
						</div>
					</div>
					
					<div class="square" >
						<div class="text">
							<p id="name" class="pull-left name" style="cursor: hand;" title="{{$openwish->product_name}}" onclick="show_name('{{$openwish->product_name}}')"><b>{{$name}}</b></p>
							<p class="pull-right"><b>{{$currentCurrency . ' ' .number_format($price / 100,2)}}</b></p>
							<div class="clearfix"> </div>
						</div>
						{{-- <hr style="margin-top: 0px;margin-bottom:5px;border: 1px solid #d0d0d0;"> --}}
						<div class="pull-left "><b>Accumulated</b></div>
						<div class="pull-right "><a href="javascript:void(0)" rel="nofollow" data-item-id="{{ $openwish->product_id }}" style='font-size:0.9em; padding: 10px; border-radius: 5px;' class="show_openwish_modal  btn-pink"><span style="margin-left:3px;margin-right:3px">Ask for Help</span></a></div>
						<div class="clearfix"> </div>
						<div class="pull-left"><p style="margin-bottom:0px;">{{ $currentCurrency . ' '.number_format(($openwish->pledged_amt/100),2)}}</p></div>
						<div class="clearfix"> </div>

						<div class="pull-left "><p><b>Balance</b></p></div>
						<div class="pull-right "><a style='font-size:0.9em; padding: 10px; border-radius: 5px;' class="btn-darkgreen" onclick='addToCartow({{$openwish->product_id}}{{','}}{{(number_format($openwish->retail_price / 100 , 2))}}{{','}}{{(number_format($openwish->pledged_amt / 100 , 2))}}{{','}}{{$openwish->id}})'><span style="margin:3px;">&nbsp;Add to Cart&nbsp;</span></a></div>
						<div class="clearfix"> </div>
						<div class="pull-left"><p style="margin-top:-8px;margin-bottom:0px;">{{ $currentCurrency . ' '.number_format(($price / 100) - ($openwish->pledged_amt / 100) , 2)}}</p></div>
						<div class="clearfix"> </div>
					</div>

				</div><!--/row-->
			</div><!--/col-12-->
			<?php $hy++; ?>
			@if($hy == 12)
				</div>
				<?php $hy = 0; ?>
			@endif
		@endif	
	@endforeach
	@if($hy != 0)
		</div>
	@endif
	</div>
		@if($hyp > 1)
			<center>
				<nav aria-label="Page navigation">
				  <ul class="pagination">
				  	 <li>
					  <a href="javascript:void(0)" class="p_pagination" aria-label="Previous">
						<span aria-hidden="true">&laquo;</span>
					  </a>
					</li>
				  @for($w = 0; $w < $hyp; $w++)
					<li class="ah @if($w==0) active @endif"  id="liah{{$w}}"><a href="javascript:void(0)" rel="{{$w}}" class="active_pagination">{{$w + 1}}</a></li>
				  @endfor
					<li>
					  <a href="javascript:void(0)" class="n_pagination" aria-label="Next">
						<span aria-hidden="true">&raquo;</span>
					  </a>
					</li>				  
				  </ul>
				</nav>
			</center>
			<input type="hidden" id="current_p" value="0" />
			<input type="hidden" id="max_p" value="{{$hyp}}" />
		@endif
{{-- Row Ends --}}
<br>

<div style="margin-left:0;margin-right:0" class="row hidden-xs">
	<h4><em>History</em></h4>
</div>
{{-- Row --}}
<div class="row">
	<?php $hy = 0; ?>
	<?php $hyp = 0; ?>
	@foreach($openwishes as $openwish)
		@if($openwish->status != 'active')
			@if($hy == 0)
				@if($hyp == 0)
					<div id="ph{{$hyp}}" class="ph">
				@else
					<div id="ph{{$hyp}}" class="ph" style="display: none;">
				@endif
				<?php $hyp++; ?>
			@endif
			{{-- For Mobile --}}
			<article class="col-xs-6 mobile_info_ow"  style="display: none; margin: 0 !important;">
				<div class="row productbox">
					<div class="boxTile" style='border:1px solid  #d0d0d0'>
						<div class="square">
							<a href="{{asset('productconsumer/'.$openwish->product_id)}}">
							<img class="img-responsive" src="{{asset('images/product/'.$openwish->folder_number.'/'.$openwish->photo_1)}}"
								style="object-fit:contain"
								src="{{asset('images/product/'.$openwish->folder_number.'/'.$openwish->photo_1)}}"
								title="{{$openwish->product_name}}"
								>
							</a>
						</div>
						<div class="square info easeAni ">
							<div class="text" style="font-size: 0.8em !important;font-weight: bold;color: white!important;"> 
								{{$openwish->product_name}}<br>
								<span class="pull-left">PAID</span>
								<span class="pull-right">{{ $currentCurrency . ' '.number_format(($openwish->pledged_amt),2)}}</span><br>
								<span class="pull-left">TOPUP</span>
								<span class="pull-right">0.0</span>
							</div>
						</div>
						
					</div>
					<div class="square "  style="font-size:0.7em;"><?php $product_name = strlen($openwish->product_name);$name = substr($openwish->product_name,0,12);?>
							<div class="text">
								<span class="pull-left name" style="cursor: hand;" title="{{$openwish->product_name}}"><a href="javascript:void(0);" class="openwishinfo" rel-owid="{{$openwish->id}}">{{$name}}</a></span>
								<span class="pull-right"><b>{{ $currentCurrency .' '.number_format($openwish->retail_price / 100,2)}}</b></span>
							
							</div>
						</div>
				</div>
			</article>
			{{-- Mobile Ends --}}
			<article class="col-xs-6 col-sm-6 col-md-4 col-lg-3 hidden-xs" style="margin: 0px;">
				<a href="#">
					<div class="row productbox">
						<div class="boxTile" style='border:1px solid  #d0d0d0'>
							<div class="square">
								<a href="{{asset('productconsumer/'.$openwish->product_id)}}">
								<img src="{{asset('images/product/'.$openwish->folder_number.'/'.$openwish->photo_1)}}"
								style="object-fit:contain"
								src="{{asset('images/product/'.$openwish->folder_number.'/'.$openwish->photo_1)}}"
								title="{{$openwish->product_name}}"
								>
								</a>
							</div>
							<div class="square info easeAni ">
								<div class="text">
									<p>{{$openwish->product_name}}</p>
									<div class="pull-left "><p><b>PAID&nbsp;</b></p></div>
									<div class="pull-right"><p class="">{{ $currentCurrency . ' '.number_format(($openwish->pledged_amt),2)}}</p></div>
									<div class="clearfix"> </div>
									<div class="pull-left "><p><b>Top Up&nbsp;</b></p></div>
									<div class="pull-right"><p class="{{$openwish->product_id}}">0</p></div>
									<div class="clearfix"> </div>
									

								</div>
							</div>
						</div>
						<div class="square " ><?php $product_name = strlen($openwish->product_name);$name = substr($openwish->product_name,0,12);?>
							<div class="text">
								<p class="pull-left name" style="cursor: hand;" title="{{$openwish->product_name}}"><a href="javascript:void(0);" class="openwishinfo" rel-owid="{{$openwish->id}}">{{$name}}</a></p>
								<p class="pull-right"><b>{{ $currentCurrency . ' '.number_format($openwish->retail_price / 100,2)}}</b></p>
								<div class="clearfix"> </div>
							</div>
						</div>
					</div>
				</a>
			</article>


			<?php $hy++; ?>
			@if($hy == 12)
				</div>
				<?php $hy = 0; ?>
			@endif
		@endif
	@endforeach
	@if($hy != 0)
		</div>
	@endif
	
{{-- Row --}}
</div>
		@if($hyp > 1)
			<center>
				<nav aria-label="Page navigation">
				  <ul class="pagination">
				      <li>
					  <a href="javascript:void(0)" class="history_p_pagination" aria-label="Previous">
						<span aria-hidden="true">&laquo;</span>
					  </a>
					</li>
				  @for($w = 0; $w < $hyp; $w++)
					<li  class="lh @if($w==0) active @endif"  id="lih{{$w}}"><a href="javascript:void(0)" rel="{{$w}}" class="history_pagination">{{$w + 1}}</a></li>
				  @endfor
					<li>
					  <a href="javascript:void(0)" class="history_n_pagination" aria-label="Next">
						<span aria-hidden="true">&raquo;</span>
					  </a>
					</li>				  
				  </ul>
				</nav>
			</center>
			<input type="hidden" id="current_h" value="0" />
			<input type="hidden" id="max_h" value="{{$hyp}}" />

		@endif
</div>
<style type="text/css">
    .modal-dialog{
        width: 600px;
    }
</style>
<div id="socialModal_openwish" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->

    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">OpenWish</h4>
      </div>
      <div class="modal-body">
        <label>Please enter a custom message.
        <textarea class="form-control custom_message" id="custom_message" cols="100"></textarea>
        </label>
        <a class="btn btn-block btn-social btn-facebook reshare-owish-uniq" id="add-to-wishlist">
        <i class="fa fa-facebook"></i> Share on Facebook
      </a>
      </div>
      <input type="hidden" id="owish_product_id" value="">
     <input type="hidden" id="owish_type" value="">
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

{{-- AJAC CALL FOR SMM SAVE --}}
 <script type="text/javascript">
 $(document).ready(function(){
    $('.show_openwish_modal').click(function(){
        $('#socialModal_openwish').modal('show');
        $('#owish_product_id').val($(this).data('item-id'));
        
        $('#owish_type').val($(this).data('item-type'));
    });
        
 });
</script>
{{-- Col --}}
<script>
	$(document).ready(function () {
		$('.openwishinfo').click()
		$(".history_pagination").click(function(){
			var rel = parseInt($(this).attr("rel"));
			var nrel = rel + 1;
			$(".ph").hide();
			$(".lh").removeClass("active");
			$("#ph" + rel).show();
			$("#lih" + rel).addClass("active");
			$("#current_h").val(rel);
		});
		
		$(".history_n_pagination").click(function(){
			var rel = parseInt($("#current_h").val());
			var max = parseInt($("#max_h").val());
			var nrel = rel + 1;
			if(nrel >= max){
				
			} else {
				$(".ph").hide();
				$(".lh").removeClass("active");
				$("#ph" + nrel).show();
				$("#lih" + nrel).addClass("active");
				$("#current_h").val(nrel);				
			}

		});
		
		$(".history_p_pagination").click(function(){
			var rel = parseInt($("#current_h").val());
			var max = parseInt($("#max_h").val());
			var nrel = rel - 1;
			if(nrel < 0){
				
			} else {
				$(".ph").hide();
				$(".lh").removeClass("active");
				$("#ph" + nrel).show();
				$("#lih" + nrel).addClass("active");
				$("#current_h").val(nrel);				
			}

		});		
		
		$(".active_pagination").click(function(){
			var rel = parseInt($(this).attr("rel"));
			var nrel = rel + 1;
			$(".pa").hide();
			$(".ah").removeClass("active");
			$("#p" + rel).show();
			$("#liah" + rel).addClass("active");
			$("#current_p").val(rel);
		});		
		
		$(".n_pagination").click(function(){
			var rel = parseInt($("#current_p").val());
			var max = parseInt($("#max_p").val());
			var nrel = rel + 1;
			if(nrel >= max){
				
			} else {
				$(".pa").hide();
				$(".ah").removeClass("active");
				$("#p" + nrel).show();
				$("#liah" + nrel).addClass("active");
				$("#current_p").val(nrel);				
			}

		});
		
		$(".p_pagination").click(function(){
			var rel = parseInt($("#current_p").val());
			var max = parseInt($("#max_p").val());
			var nrel = rel - 1;
			if(nrel < 0){
				
			} else {
				$(".pa").hide();
				$(".ah").removeClass("active");
				$("#p" + nrel).show();
				$("#liah" + nrel).addClass("active");
				$("#current_p").val(nrel);				
			}

		});	
		$('.openwishinfo').click(function(){
			var owid=$(this).attr('rel-owid');
			var url=JS_BASE_URL+"/openwish/buyer/info/"+owid;
			$.ajax({
				url:url,
				type:'GET',
				success:function(r){
					if (r.status=="success") {
						$('#openwishinfoModal').find('#owinfoTBody').empty();
						$('#owinfoTBody').append(r.payload);
						$('#openwishinfoModal').modal('show');
					}else{
						toastr.warning(r.long_message);
					}
				},error:function(){
					toastr.warning('The OpenWish pledge information could not be fetched. Please contact OpenSupport');
				}
			});
			
		});		
	});
</script>
<div id="openwishinfoModal" class="modal fade" role="dialog">
<div class="modal-dialog modal-lg">

<!-- Modal content-->
<div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
   
  </div>
  <div class="modal-body">
    <table class="table">
        <thead>
            <tr style="color: black; background-color: #d7e748;" id="owModalTHeader">
            	<th>No.</th>
            	<th>Friend</th>
            	<th>Message</th>
            	<th>Value</th>
            	<th>Source</th>
            	<th>Date</th>
            </tr>
        </thead>
        <tbody id="owinfoTBody">
            
        </tbody>
    </table>
  </div>
  <div class="modal-footer">
    <a type="button" class="btn btn-default" data-dismiss="modal">Close</a>
  </div>
</div>

</div>
</div>
