<?php 
use App\Http\Controllers\IdController;
?>
@extends("common.default")
@section("content")
<div class="row col-md-12" style="margin-left:0;margin-right:0;padding-right:0;padding-left:0">
	<div class="col-md-3" style="padding-left:0">
	<h2 style="margin-bottom:10px" align="center">Information</h2>
	</div>

	<div class="col-md-9" style="padding-left:0;padding-right:0;margin-top:8px">
	@if(Auth::user()->id == $user_id)
		<a href="{{url('buyer/mobedit')}}"
			class="btn btn-success pull-right">
		<span class="glyphicon glyphicon-edit"></span>
		Edit Personal Details</a>
	@endif
	</div>

</div>
<br>
<div class="col-md-3">
	{{--<div class="wrapper"><img src="{{asset('/')}}{{$image}}" title="profile-image" class=" bg img-responsive"> </div>--}}
		<h3 style="text-align:left;" class="display-4 no-margin">{{$name}}</h3>
	<h5 class="no-margin"><span class="text-muted">User ID: </span> {{IdController::nB($user_id)}}</h5>
	<h5 class="no-margin"><span class="text-muted">Member Since:</span> {{$member_since}}</h5>
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
@stop