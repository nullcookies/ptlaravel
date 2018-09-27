<?php 
use App\Controllers\IdController;
?>
@extends('emails.common.layout')
@section('content')
<strong>Hi, {{$user->name or 'user'}}</strong>
<p style="font-family:Helvetica,sans-serif;font-size:13px;line-height:20px;color:#505050;font-weight:none;">
You have cancelled your order <b>{{$orderId}}</b>. Your order has been refunded as OpenCredit Points.
</p>
		
@stop
