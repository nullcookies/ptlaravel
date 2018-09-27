@extends('emails.common.layout')
@section('content')
	<strong>Hi,</strong>
	<p style="font-family:Helvetica,sans-serif;font-size:13px;line-height:20px;color:#505050;font-weight:none;">
		Congratulations! You have been tagged as Customer by {{$company->company_name}}!
	</p>
	<p style="font-family:Helvetica,sans-serif;font-size:13px;line-height:20px;color:#505050;font-weight:none;">
		Since you don't have an account in OpenSupermall. Please go to <a href="{{url()}}/create_new_buyer" target="_blank" >OpenSupermall</a> to register.
	</p>
	<p>Thank you!</p>
@stop
