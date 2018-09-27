@extends('emails.common.layout')
@section('content')
	<strong>Hi, {{$user->name}}</strong>
	<p style="font-family:Helvetica,sans-serif;font-size:13px;line-height:20px;color:#505050;font-weight:none;">
		You have received a new Purchase Order: Order ID {{$forder_id}}. Please check the <a href={{url("merchantinvoice/".$order_id)}}>order</a> for more information.
	</p>
@stop
