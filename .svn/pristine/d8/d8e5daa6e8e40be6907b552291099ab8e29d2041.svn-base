<style>
.imagePreviewNeutral {
  width: 150px;
  height: 150px;
  background-position: center top;
  background-repeat: no-repeat;
  -webkit-box-shadow: 0 0 1px 1px rgba(0, 0, 0, .3);
  background-color: #e7e7e7;
  border: 1px solid;
  display: inline-block;
  margin-bottom: 5px;
  border-color: #d0d0d0;
}

hr{
	border-top-color: #5F6879;
	margin-top: 0px;

}
.imageautolink{
	cursor: pointer;
}
</style>
<div class="col-sm-12">
	<h2>AutoLink</h2>
	<span  id="error-messages">
    </span>		
	<br>
	{{-- zxcv --}}
	@if(! empty($autolinks))
		@foreach($autolinks as $link)
			<div id="div{{$link['id']}}">
				<div class="row"> 	
					<?php 
						if(isset($img)){
							unset($img);
						}
						$merchantp = DB::table('merchantproduct')->where('merchant_id',$link['merchant_id'])->first();
						if(!is_null($merchantp)){
							$pp = DB::table('product')->where('id',$merchantp->product_id)->first();
							$img = "images/product/" . $pp->id . "/" . $pp->photo_1;
						}	
					?>
					@if(isset($img))
					<div class="col-sm-3">
						<div class="imagePreviewNeutral imageautolink" id="imageautolink" rel="{{$link['merchant_id']}}"
							style="background-size:cover;
							background-position: center top;
							background-image: url('{{asset($img)}}');">
						</div>				
					</div>
					@else
					<div class="col-sm-3">
						<div class="imagePreviewNeutral imageautolink" id="imageautolink" rel="{{$link['merchant_id']}}"
							style="background-size:cover;
							background-position: center top;">
						</div>				
					</div>						
					@endif
					<div class="col-sm-4" style="height: 150px; padding: 45px 0;">
						<h3 style="vertical-align:middle;">{{$link['mname']}}</h3>
					</div>
					<div class="col-sm-1" style="height: 150px; padding: 45px 0;">
						@if ($link['status'] == 'linked')
							<h5>Linked</h5>
						@else
							<h5>Awaiting</h5>	
						@endif				
					</div>
					<div class="col-sm-4" style="height: 150px; padding: 45px 0;">
						<a class='btn btn-danger cancel_autolink' rel='{{$link["id"]}}' href='javascript:void(0)'> Cancel </a>
						<a class='btn btn-danger delete_autolink'  rel='{{$link["id"]}}' href='javascript:void(0)'> Remove </a>
					</div>			
				</div>	
				<hr>
			</div>
		@endforeach
	@else	
	<div id='alert' class="cart-alert alert alert-warning" role="alert" style="border-color: red;">
	<strong><h4><a href="#">
		<b style="color: red;">
			No autolinks to display
		</b></a></h4>
	</strong>
	</div>
	@endif
</div>
<script>
	$(document).ready(function () {
		window.setInterval(function(){
          $('#error-messages').empty();
        }, 10000);		
		
		$('.imageautolink').click(function(){

		var id=$(this).attr('rel');
		var check_url=JS_BASE_URL+"/admin/popup/lx/check/merchant/"+id;
		$.ajax({
			url:check_url,
			type:'GET',
			success:function (r) {
			console.log(r);
			
			if (r.status=="success") {
			var url=JS_BASE_URL+"/admin/popup/merchant/"+id;
				var w=window.open(url,"_blank");
				w.focus();
			}
			if (r.status=="failure") {
			var msg="<div class=' alert alert-danger'>"+r.long_message+"</div>";
			$('#error-messages').html(msg);
			}
			}
			});
		});			
		
		$(".cancel_autolink").click(function(){
			_this = $(this);
			var link_id = _this.attr('rel');
			var url = JS_BASE_URL + '/autolink/cancel/'+ link_id;
			$.ajax({
			  url: url,
			  type: "post",
			  data: {
					'link_id': link_id			  
			  },
			  success: function(data){
				//location.reload();
				toastr.info("Autolink successfully canceled");
				$("#div" + link_id).hide();
			  }
			});			
			
		});	
		$(".delete_autolink").click(function(){
			_this = $(this);
			var link_id = _this.attr('rel');
			var url = JS_BASE_URL + '/autolink/delete_autolink/'+ link_id;
			$.ajax({
			  url: url,
			  type: "post",
			  data: {
					'link_id': link_id			  
			  },
			  success: function(data){
				//location.reload();
				toastr.info("Autolink successfully deleted");
				$("#div" + link_id).hide();
			  }
			});			
			
		});			
	});
</script>