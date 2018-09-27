@extends('emails.common.layout')
@section('content')
	<strong>Hi,{{$user->name}}</strong>
	<p style="font-family:Helvetica,sans-serif;font-size:13px;line-height:20px;color:#505050;font-weight:none;">
		Stations are trying to buy Term Products from you but you don't have enough tokens! Please, buy new tokens and continue enjoing Term benefits!
	</p>
@stop