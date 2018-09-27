@extends('emails.common.layout')
<?php 
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\IdController;
?>
@section('content')
	<strong>Hi,</strong>
	<p style="font-family:Helvetica,sans-serif;font-size:13px;line-height:20px;color:#505050;font-weight:none;"">
		@if($type=="ops")The following merchant's account has been suspended @else Your following account has been suspended.@endif
			<table>
				<tr>
					<td>
						<strong>Merchant ID:</strong>
					</td>
					<td>{{IdController::nM($merchant->id)}}</td>
				</tr>
				<tr><td>
					<strong>Company Name:</strong>
				</td>
					<td>{{$merchant->company_name}}</td>
				</tr>
			</table>
	</p>
@stop