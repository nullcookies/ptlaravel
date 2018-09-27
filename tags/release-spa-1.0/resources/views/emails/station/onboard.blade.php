@extends('emails.common.layout')
@section('content')
	<strong>Hi, {{$user->name}}</strong>
	<p style="font-family:Helvetica,sans-serif;font-size:13px;line-height:20px;color:#505050;font-weight:none;">
		Thank you for registering with us. Your approval is under process, please wait for 1-3 working days.
		You will need to verify the email address on your account by clicking the link below.
		For any questions/comments contact support.
	</p>
	<h3 style="text-align:center;"><a href="{{$confirm_url or '#'}}" target="_blank">Confirm Email </a></h3>
	<div style="font-family:Helvetica,sans-serif;font-size:13px;line-height:20px;color:#505050;font-weight:none;text-align:center;">(This link will expire in {{$hours}} hours)</div>	
@stop
