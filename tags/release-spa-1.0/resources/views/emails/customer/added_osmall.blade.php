@extends('emails.common.layout')
@section('content')
	<strong>Hi {{$user->first_name}}</strong>,
	<p style="font-family:Helvetica,sans-serif;font-size:13px;line-height:20px;color:#505050;font-weight:none;">
		Congratulations! You have been tagged as Customer by OpenSupermall!
	</p>
	<p>Thank you!</p>
@stop
