@extends('emails.common.layout')
@section('content')

<style type="text/css">
	td:nth-child(1){
	width:40%;
	}
</style>
<table>
	<tr>
		<td>Dear <strong>Ninja Van</strong>,</td>
	</tr>
	<tr><td>Please arrange for pickup from</td><td><strong>{{$mAdd->line1 or "--"}}</strong></td></tr>
	<tr><td></td>
	<td><strong><br>{{$mAdd->line2 or "--"}} {{$mAdd->line3 or "--"}}<br>{{$mAdd->city or "--"}} {{$mAdd->state or "--"}} {{$mAdd->postcode or "--"}}, Malaysia </strong></td>
	</tr>
	<tr><td>Contact number:</td>
	<td><strong> {{$mer->office_no or "--"}}</strong></td>
	</tr>
	<tr>
		<td>Contact person:</td>
		<td><strong>{{$mer->contact_person or "--"}}</strong></td>
	</tr>
	<tr><td>And deliver it to </td><td><strong>{{$bAdd->line1 or "--"}}</strong></td></tr>
	<tr><td></td>
	<td><strong>{{$bAdd->line2 or "--"}} {{$bAdd->line3 or "--"}}<br>{{$bAdd->city or "--"}} {{$bAdd->state or "--"}} {{$bAdd->postcode or "--"}}, Malaysia </strong></td>
	</tr>
	<tr><td>Contact number:</td>
	<td><strong>{{$user->mobile_no or "--"}}</strong></td></tr>
	<tr>
		<td>Contact person:</td>
		<td><strong>{{$user->name or "--"}} </strong></td>
	</tr>
	<tr>
		<td>Tracking ID: </td>
		<td><strong>{{$cn->nv_tracking_id or '--'}}</strong></td>
	</tr>
	<tr>
		<td>Any return shipments or inquiries please contact the details below 
	</td>
	</tr>
	<tr>
		<td>Shipper details: </td>
		<td><strong>{{$mer->company_name or "--"}}</strong></td>
	</tr>
	<tr>
		<td>Contact person:</td>
		<td><strong>{{$mer->contact_person or "--"}}</strong></td>
	</tr>
	<tr>
		<td>Contact email:</td>
		<td><strong>{{$mer->email or "--"}}</strong></td>
	</tr>
	<tr><td>Thank You</td></tr>
</table>
</span>
@stop