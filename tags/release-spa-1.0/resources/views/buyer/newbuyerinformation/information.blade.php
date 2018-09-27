<?php 
use App\Http\Controllers\IdController;
?>
<div class="row col-md-12" style="margin-left:0;margin-right:0;padding-right:0;padding-left:0">
	<div class="col-md-3" style="padding-left:0">
	<h2 style="margin-bottom:10px">Information</h2>
	</div>

	<div class="col-md-9" style="padding-left:0;padding-right:0;margin-top:8px">
	@if(Auth::user()->id == $userjust_id)
		<a href="{{url('buyer/edit')}}"
			class="btn btn-success pull-right">
		<span class="glyphicon glyphicon-edit"></span>
		Personal Details</a>
	@endif
	</div>

</div>
<br>
<!-- <div class="col-md-12">
<div class="row">
	
	<div class="col-xs-3 no-padding no-margin">
		<div class="imagePreviewBig" id="imagePreview"
			style="height: 300px; background-size:cover;
			background-position: center top;
			background-image: url('{{asset($image[0])}}')">
		</div>
	</div>

	<div class="col-xs-3 no-padding no-margin">
		
		<div class="imagePreview" id="imagePreview1"
			style="height: 150px; margin-bottom: -2px;
			background-size:cover;
			background-position: center top;
			background-image: url('{{asset($image[1])}}');">
		</div>
		
		<div class="no-padding imagePreview" id="imagePreview2"
			style="height: 150px; margin-top: -2px;
			background-size:cover;
			background-position: center top;
			background-image: url('{{asset($image[2])}}');">
		</div>
	</div>

	<div class="col-xs-3 no-padding no-margin">
		
		<div class="imagePreview" id="imagePreview3"
			style="height: 150px; margin-bottom: -2px;
			background-size:cover;
			background-position: center top;
			background-image: url('{{asset($image[3])}}');">
		</div>
		
		<div class="no-padding imagePreview" id="imagePreview4"
			style="height: 150px; margin-top: -2px;
			background-size:cover;
			background-position: center top;
			background-image: url('{{asset($image[4])}}');">
		</div>
	</div>
	<div class="col-xs-3 no-padding no-margin">
		
		<div class="imagePreview" id="imagePreview5"
			style="height: 150px; margin-bottom: -2px;
			background-size:cover;
			background-position: center top;
			background-image: url('{{asset($image[5])}}');">
		</div>
		
		<div class="no-padding imagePreview" id="imagePreview6"
			style="height: 150px; margin-top: -2px;
			background-size:cover;
			background-position: center top;
			background-image: url('{{asset($image[6])}}');">
		</div>
	</div>
	</div>
</div> -->
<div class="col-md-3" style="padding-left:0">
	{{--<div class="wrapper"><img src="{{asset('/')}}{{$image}}" title="profile-image" class=" bg img-responsive"> </div>--}}
		<h3 style="text-align:left;" class="display-4 no-margin">{{$name}}</h3>
	<h5 class="no-margin"><span class="text-muted">User ID: </span>
	[{{sprintf('%010d',$user_id)}}]</h5>
	<h5 class="no-margin"><span class="text-muted">Member Since:</span> {{$member_since}}</h5>
	
	<?php 
		$qr = DB::table('buyerqr')->join('qr_management','qr_management.id','=','buyerqr.qr_management_id')
		->where('buyer_id',$buyerinformation->id)->orderBy('buyerqr.id','DESC')->first();
	?>
	@if(!is_null($qr))
		<img src="{{URL::to('/')}}/images/qr/buyer/{{$buyerinformation->id}}/{{$qr->image_path}}.png" width="120px" />
	@endif
</div>
<div class="col-md-9">
	<div class="row">
		<div class="panel" style="margin-top:10px">
			<div class="panel-heading1 panel-title bottom-margin-xs">Personal Details</div>
			<div class="panel-body border-con">
				<dl class="dl-horizontal text-muted">
					<dt>Age</dt>
					<dd>{{$age or 'NaN'}}</dd>
					<dt>Occupation:</dt>
					<dd>{{$occupation or 'NaN'}}</dd>
					{{-- <dt>User ID:</dt>
					<dd>{{$user->id}}</dd>
					<dt></dt> --}}

					<dt>Language</dt>
					<dd>
					@if(isset($language))
							<?php $string = "";?>
						@foreach ($language as $langua)
								<?php
								$string = $string.$langua->description.", ";
								?>
						@endforeach
						<?php
							$string = substr($string, 0, -2);
							$string .=".";

							?>
						{{$string}}
					@endif
					</dd>
					<dt>Annual</dt>
					<dd>{{$user->annual_income}}</dd>
				</dl>
			</div>
			<div class="afin"><span>&nbsp;</span></div>
			<div class="panel-heading1"> Interests</div>
			<div class="panel-body border-con text-muted">
				<p class="text-muted"><!-- Electronics, Fashion, Beauty, Health & Cosmatics --> {{$interests}}</p>
			</div>
		</div>
	</div>
</div>
