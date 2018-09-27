@extends('emails.common.layout')
@section('content')

<style type="text/css">
	td:nth-child(1){
	width:40%;
	}
</style>
<table>
	<tr>
		<td>Dear <strong>City-Link Express</strong>,</td>
	</tr>
	<tr><td>Please arrange for pickup from</td><td>{{$bAdd->line1 or "--"}}</td></tr>
	<tr><td></td>
	<td><strong>{{$bAdd->line2 or "--"}} {{$mAdd->line3 or "--"}}<br>{{$bAdd->city or "--"}} {{$bAdd->state or "--"}} {{$bAdd->postcode or "--"}}, Malaysia </strong></td>
	</tr>
	<tr><td>Contact number:</td>
	<td><strong> {{$user->mobile_no or "--"}}</strong></td>
	</tr>
	<tr>
		<td>Contact person:</td>
		<td><strong>{{$user->name or "--"}}</strong></td>
	</tr>
	<tr>
		<td>Preferred time:</td>
		<td><strong>{{$cn->ctl_pref_hour or "--"}}:{{$cn->ctl_pref_min or "--"}} {{$cn->ctl_pref_date or "--"}}</strong></td>
	</tr>
	<tr>
		<td>No. of pickup:</td>
		<td><strong>{{$cn->ctl_package_quantity or "--"}}</strong></td>
	</tr>
	<tr><td>And deliver it to </td><td>{{$mAdd->line1 or "--"}}</td></tr>
	<tr><td></td>
	<td><strong>{{$mAdd->line2 or "--"}} {{$mAdd->line3 or "--"}}<br>{{$mAdd->city or "--"}} {{$mAdd->state or "--"}} {{$mAdd->postcode or "--"}}, Malaysia </strong></td>
	</tr>
	<tr><td>Contact number:</td>
	<td><strong>{{$mer->office_no or "--"}}</strong></td></tr>
	<tr>
		<td>Contact person:</td>
		<td><strong>{{$mer->contact_person  or "--"}} </strong></td>
	</tr>
	<tr>
		<td>Consignment number: </td>
		<td><strong>{{$cn->ctl_consignment_number or '--'}}</strong></td>
	</tr>
	<tr>
		<td>Any return shipments or inquiries please contact the details below 
	</td>
	</tr>
	<tr>
		<td>Shipper details: </td>
		<td><strong>{{$user->name or "--"}}</strong></td>
	</tr>
	<tr>
		<td>Contact person:</td>
		<td><strong>{{$user->name  or "--"}}</strong></td>
	</tr>
	<tr>
		<td>Contact email:</td>
		<td><strong>{{$user->email or "--"}}</strong></td>
	</tr>
	<tr><td>Thank You</td></tr>
</table>
</span>
@stop