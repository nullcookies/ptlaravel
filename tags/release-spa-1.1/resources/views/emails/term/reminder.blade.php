@extends('emails.common.layout')
@section('content')
	<strong>Greetings, {{$name}}!</strong>
	<p style="font-family:Helvetica,sans-serif;font-size:13px;line-height:20px;color:#505050;font-weight:none;">
		You have a pending payment of {{$currentCurrency}} {{number_format($total_owed,2)}} for the order <a href="{{URL::to('/')}}/invoice/{{$oid}}">{{$porderid}}</a> that you need to pay in {{$days}} day(s). Please pay on time to avoid a late payment. Thank you.
	</p>
@stop
