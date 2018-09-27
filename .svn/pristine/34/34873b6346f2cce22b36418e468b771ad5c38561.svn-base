@extends("common.default")
@section("content")
<style>
.closeBtn:hover {
	color: red;
}
.cat-img {
	padding-top: 0;
}
.p-box{
	min-height: 285px !important;
}

.cat-img img {
    object-fit: contain;
    height: 120px !important;
}

.discription {
    position: relative;line-height: 1.5em; height: 3em;overflow: hidden;
	font-weight:normal;
	color: #666;
   
    text-overflow: ellipsis;
    width: 100%;

}
</style>
<div class="alert alert-success alert-dismissible hidden cart-notification" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong class='cart-info'></strong>
</div>
<div class="col-sm-12" style="padding-left:0; min-height: 380px;">
<div class="col-sm-6" style="padding-left:0;">
	<h2>Likes</h2>
</div>
<div class="col-sm-6" style="padding-left:0;">
	<a href="javascript:void(0)" class="mywishlist pull-right" style="font-size:17px">Wishlist</a>
</div>
<input type="hidden" id="userjust_id" value="{{$user_id}}" />
<div class="col-md-12 col-xs-12" style="padding-left:0;padding-right:0;">
	<div class="cat-items">
		<?php $kwslk=0; ?>
		@foreach($product_likes as $row)
			<div class="p-box col-md-3 col-sm-4 col-xs-6"
				style="padding-right:2px;margin-bottom:20px;" id="box-{{$row->id}}">
				<div class="cat-img">
					<div class="ribbon-wrapper-green">
					<div class="ribbon-green">
						Liked {{$row->since}}
					</div></div>
					<div class="Xphoto closeBtn delete-like" rel="{{$row->id}}" style="cursor:pointer;
						display:block;
						width:20px;margin-top:2px">
						<span id="closeboton"
							class="fa fa-times-circle fa-lg "
							title="remove">
						</span>
					</div>					
					@if($row->available > 0)
						<a target="_blank" href="{{route('productconsumer', $row->id)}}">
					@else
						<a href="javascript:void(0)" class="wishlist" rel="{{$row->id}}">
					@endif
						<img class="img-responsive object-fit:contain" src="/images/product/{{$row->id}}/{{$row->photo_1}}">
					</a>
				</div>
				<div data-tooltip="{{$row->name}}"  class="mouseover">
				<div class="gradientEllipsis inside discription" style="margin-bottom: -18px; border-bottom:1px solid #dadada;" >
					{{$row->name}}
					<div class="dimmer"></div>
					</div>
					</div>

				@if (($row->discounted_price == $row->retail_price) || ($row->discounted_price == 0))
					@if ($row->retail_price > 0)

						<br/><strong style="font-size:1em;">
							{{$currentCurrency}} {{number_format($row->retail_price/100,2)}}</strong>
						<br>
						&nbsp;
					@endif
				@else

					<br/><strong style="color:black; font-size:1em;">{{$currentCurrency}}</strong><strike style="color:red"><span style="color:#333;">
						<strong style="color:black; font-size:1em;">
							{{number_format($row->retail_price/100,2)}}</strong></span>
					</strike>
					<strong style="color:red; font-size:1em;">
						{{number_format($row->discounted_price/100,2)}}</strong>
						<br>
					@if ($row->retail_price > 0 && $row->retail_price > $row->discounted_price)	
							<strong style="color:white;background:red; font-size:1em;"
							class="pull-right badgenew">
							
							Save {{number_format((($row->retail_price - $row->discounted_price)/$row->retail_price)*100,0)}}%
							</strong><br/>
					@else
						&nbsp;
					@endif

				@endif
			</div>

			<?php $kwslk++; ?>
			@if($kwslk == 2)
			<div class="clearfix"> </div>
			<?php $kwslk=0; ?> 
			@endif 

		@endforeach


		<div class="clearfix"></div>

	</div>
</div>
</div>
<div class="clearfix"></div>

<div class="modal fade" id="myModalWishlist" role="dialog" aria-labelledby="myModalRemarks">
	<div class="modal-dialog" role="remarks" style="width: 100%">
	<div class="modal-content" style="background-color: #FD188B; color: white;">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"
				aria-label="Close">
				<span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" align="center" id="myModalLabel">Add to Wishlist</h4>
		</div>
		<div class="modal-body">
			<div class="row" style="padding: 15px;">
				<div class="col-md-12" style="">
					<p>This product is no longer available, do you want to add it to your wishlist?</p>					
					<div class="col-md-2" style="">
						&nbsp;
					</div>
					<div class="col-md-2" style="">
						<p>Qty</p>
					</div>
					<div class="col-md-2" style="">
						<input type="text" class="form-control" value="1" id="wishlist_quantity" />
						<input type="hidden" value="" id="wishlist_id" />
						
					</div>
					<div class="col-md-2" style="">
					<a href="javascript:void(0);" class="btn btn-primary wish_btn" style="width:150px; background-color: #FD188B; color: white; border-color: #FFF">Add</a>
					<div class="clearfix"></div><br>
				</div>
			</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" style="background-color: #FD188B; color: white; border-color: #FFF" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		
	</div>
</div>
</div>
<div class="modal fade" id="myModalMyWishlist" role="dialog" aria-labelledby="myModalRemarks">
	<div class="modal-dialog" role="remarks" style="width: 98%">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"
				aria-label="Close">
				<span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" align="center" id="myModalLabel">My Wishlist</h4>
		</div>
		<div class="modal-body" id="wishmodalbody" style="margin-right: 0 !important; margin-left: 0 !important;">
			<div class="row" style="padding: 15px;">
				<div class="col-md-12" style="">
					
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		</div>
		
	</div>
</div>
</div>
<script type="text/javascript">
$(document).ready(function(){

    currency = $('#currency option:selected').text();
    $('.showCurrency').text(currency);

    $('#currency').on('change', function(){
        currency = $('#currency option:selected').text();
        $('.showCurrency').text(currency);
    })

	path = window.location.href;
   var url;
//   if(path.contains('public'))
   if(path.indexOf('public')>0)
   {
        url = '/OpenSupermall/public/cart/addtocart';
   }
   else {
        url = '/cart/addtocart';
   }
   
     $('.mywishlist').click(function(e){
		 var user_id = $("#userjust_id").val();
		 $.ajax({
			type: "POST",
			url: JS_BASE_URL+"/mywishlist",
			data: { user_id:user_id },
			beforeSend: function(){},
			success: function(response){
				$('#wishmodalbody').html(response);
				$('#wishmodalbody').attr('style','margin-right: 0 !important; margin-left: 0 !important;');
				$('#myModalMyWishlist').modal('toggle');
			}
		});
	 });
	 
     $('.wishlist').click(function(e){
	   e.preventDefault(); 
		var product_id = $(this).attr('rel');
		$("#wishlist_id").val(product_id);
		console.log(product_id);
		$("#myModalWishlist").modal('show');
   });
   
   $('.wish_btn').click(function(e){
	   e.preventDefault(); 
		var product_id = $("#wishlist_id").val();
		var user_id = $("#userjust_id").val();
		var quantity = $("#wishlist_quantity").val();
		console.log(product_id);
		$.ajax({
			  url: JS_BASE_URL + "/add_wishlist",
			  type: "post",
			  data: {
				'product_id':product_id,
				'user_id':user_id,
				'quantity':quantity
			  },
			  success: function(data){
				  toastr.info("Product Successfully Added");
				  $("#myModalWishlist").modal('toggle');
			  }
		});
   }); 
   
   $('.delete-like').click(function(e){
		e.preventDefault(); 
		var product_id = $(this).attr('rel');
		console.log(product_id);
		$.ajax({
			  url: JS_BASE_URL + "/delete_like",
			  type: "post",
			  data: {
				'product_id':product_id
			  },
			  success: function(data){
				  toastr.info("Like successfully deleted");
				  $("#box-" + product_id).hide();
			  }
		});				  
   }); 
   
  $('.cartBtn').click(function(e){

    e.preventDefault();
    var price = $(this).siblings('input[name=price]').val();

    $.ajax({
      url: url,
      type: "post",
      data: {
        'quantity':$(this).siblings('input[name=quantity]').val(),
        'id': $(this).siblings('input[name=id]').val(),
        'price': price
      },
      success: function(data){

        $('.alert').removeClass('hidden').fadeIn(3000).delay(5000).fadeOut(5000);
        $('.cart-info').text(data[1]+' '+currency+
			number_format(price/100,2)+ " Successfully added to the cart");

        if(data[0] < 1) {
            $('.cart-link').text('Cart is empty');
            $('.badge').text('0');
        } else {
            $('.cart-link').text('View Cart');
            $('.badge').text(data[0]);
        }
      }
    });
  });
});
</script>
@stop