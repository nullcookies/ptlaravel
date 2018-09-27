@extends('emails.common.layout')
@section('content')
				<strong>Hi, {{$name or 'user'}}</strong>
				@if($status=="new")
				<p style="font-family:Helvetica,sans-serif;font-size:13px;line-height:20px;color:#505050;font-weight:none;">
					Thank you for creating a new account on OpenSupermall. To buy/sell on OpenSupermall you will need to verify the email address on your account by clicking the link below.
				</p>
				@elseif($status=="old")
				<p style="font-family:Helvetica,sans-serif;font-size:13px;line-height:20px;color:#505050;font-weight:none;">
					You have requested email change. To confirm email change, you will need to verify the email address on your account by clicking the link below.
				</p>
				@endif
				<h3 style="text-align:center;"><a href="{{$confirm_url or '#'}}" target="_blank">Confirm Email </a></h3>
				<div style="font-family:Helvetica,sans-serif;font-size:13px;line-height:20px;color:#505050;font-weight:none;text-align:center;">(This link will expire in {{$hours}} hours)</div>
@stop