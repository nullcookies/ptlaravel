@extends('emails.common.layout')
@section('content')
	<strong>Hi, {{$user->name}}</strong>
	<p style="font-family:Helvetica,sans-serif;font-size:13px;line-height:20px;color:#505050;font-weight:none;">
		Thank you for buying from us. Your order id is <a href="#"> {{$forder_id}} </a>.</p>
		<div style="background-color:#e0e0e0">
		<br>
		Your order password is <b><a href="#">{{$receipt_password}}</b> 
		<br>
			<img src="{{$receipt_qr}}" height="200" width="200" style="vertical-align: middle;">
		</a>
		<br>
		</div>
	<p style="font-family:Helvetica,sans-serif;font-size:13px;line-height:20px;color:#505050;font-weight:none;">
		You would be asked to input this password at the time of delivery.
		<br>This password is confidential.&nbsp;Please do not share it with anyone. 
		<br>
		Please check the full <a href={{url("receipt/".$order_id)}}>receipt</a> for more information. A copy of the receipt/tax invoice has been attached.
	</p>
@stop
