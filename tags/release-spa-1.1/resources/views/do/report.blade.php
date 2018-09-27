<style type="text/css" media="screen">
.table > tbody > tr > td,th{
    border-top:none !important;
}
.tracking_info{
    font-weight: bold;
}    
</style>
@extends("common.default")
<?php use App\Http\Controllers\UtilityController;
use App\Http\Controllers\IdController;

?>
@section("content")
@include('common.sellermenu')
    <div class="container"><!--Begin main cotainer-->
        <div class="row">
			<div class="col-sm-12">
			<br>
			{{-- Tracking Information section --}}
			<table class="table tracking_info">    
			<tr> 
				<td style="padding:4px">Date Created</td>  
				<td style="padding:4px;font-weight:normal;">   
					@if($report_data->created_at!="-0001-11-30 00:00:00" && $report_data->created_at!="" && $report_data->created_at!="0000-00-00 00:00:00")
					{{UtilityController::s_date($report_data->created_at,true)}} 
					@endif
				</td>
				<td style="padding:4px" width="20%">&nbsp;</td>
				<td style="padding:4px">Date Checked</td>
				<td style="padding:4px;font-weight:normal;">
					@if($report_data->checked_on!="-0001-11-30 00:00:00" && $report_data->checked_on!="" && $report_data->checked_on!="0000-00-00 00:00:00")
					{{UtilityController::s_date($report_data->checked_on,true)}} 
					@endif
				</td>
			</tr>
			<tr>
				<td style="padding:4px;font-weight:bold">From Creator</td> 
				<td style="padding:4px;font-weight:normal">
					{{ $report_data->creator->first_name or '' }} {{ $report_data->creator->last_name or '' }}  {{ $report_data->creator->mobile_no or '' }}
				</td>
				<td style="padding:4px" width="20%">&nbsp;</td>
				<td style="padding:4px">To Checker</td> 
				<td style="padding:4px;font-weight:normal">
				{{ $report_data->checker->first_name or '' }} {{ $report_data->checker->last_name or '' }} {{ $report_data->checker->mobile_no or '' }} 
			</td>
			
			</tr>
			{{-- <tr>
				<td>{{ $report_data->creator->first_name or '' }} {{ $report_data->creator->mobile_no or '' }}</td>
				<td>{{ $report_data->checker->first_name or '' }} {{ $report_data->checker->mobile_no or '' }}</td>
			</tr> --}}
			<tr>
				<td style="padding:4px">Sender&nbsp;Company</td> 
				<td style="padding:4px;font-weight:normal">
				{{ $report_data->creator_company->company_name or '' }} </td>
				<td style="padding:4px" width="20%">&nbsp;</td>
				<td style="padding:4px">Recipient&nbsp;Company</td>
				<td style="padding:4px;font-weight:normal">
					{{ $report_data->checker_company->company_name or '' }} </td>
			</tr>

			<tr>
				<td style="padding:4px">Location</td>
				<td style="padding:4px;font-weight:normal">
				{{ $report_data->creator_location->location or '' }} </td>
				<td width="20%">&nbsp;</td>
				<td style="padding:4px">Location</td> 
				<td style="padding:4px;font-weight:normal">
				{{ $report_data->checker_location->location or '' }} </td>
			</tr>
			</table>
			{{-- Tracking Information section --}}
			</div>

			<?php
				$title="Tracking Report";
				$column="Creator";
				$column2="Lost";

				switch ($report_data->ttype) {
					case 'tin':
						$title="Stock In Report";
						break;
					case 'tout':
						# code...
						$title="Stock Out Report";
						break;
					case 'stocktake':
						$title="Stock Take Report";
						$column="O/B";
						$column2="Lost";
						break;
					case 'wastage':
						$title="Wastage Report";
						$column="O/B";
						$column2="Lost";
						break;
						break;
					default:
						// $title=ucfirst($report_data->ttype);
						break;
				}
			?>

			<div class="col-sm-12">
				<table class="table tracking_report">
					<tr>
						<th colspan="2" style="font-size:25px">
						{{$title}}</th>
						<th colspan="2" class="text-right"
							style="font-size:25px">
							<div style="font-weight:normal;display:inline">
							Report ID.</div>
							{{UtilityController::nsid($report_data->id,10,"0")}}</th>
					</tr>    
					<tr style="border-bottom: 1px solid #ddd;">
						<th class="text-center" style="background-color: #948A54; color: white;">No</th>
						<th class="text-center" style="background-color: #948A54; color: white;">Product&nbsp;ID</th>
						<th class="" style="background-color: #948A54; color: white;">Name</th>
						<th class="text-center"
						style="width:200px;background-color: #31859c; color: white;">
						Disposed Qty</th>
						<!--<th class="text-center" style="background-color: #984807; color: white;">Checker</th>-->
						<!--<th class="text-center" style="background-color: #F79646; color: white;">{{$column2}}</th>-->
					</tr>
					@if(isset($report_data->report_products) && !empty($report_data->report_products))

						@foreach($report_data->report_products as $key => $products)
						<?php
						$quantity=$products->quantity;
						$received=$products->received;
						$opening_balance=$products->opening_balance;
						$lost=$quantity-$received;
						switch ($report_data->ttype) {
							case 'stocktake':
								if ($opening_balance>$quantity) {
									$lost=$opening_balance-$quantity;
									$quantity=$opening_balance;
								}
								break;

							case 'wastage':
								if ($opening_balance>$quantity) {
									$lost=$opening_balance-$quantity;
									$quantity=$opening_balance;
								}
								break;

							default:
								# code...
								break;
						}
						?>
						<tr style="border:1px solid #a0a0a0">
							<td style="vertical-align:middle" class="text-center">{{ $key+1 }}</td>
							<td style="vertical-align:middle" class="text-center">{{ IdController::nP($products->product->id) }}</td>
							<td class="" style="vertical-align:middle;"><img src="{{asset('/')}}images/product/{{$products->product->parent_id}}/{{$products->product->photo_1}}" width="30" height="30" style="padding-top:0;margin-top:0">&nbsp;&nbsp;{{ $products->product->name }}</td>
							<td style="vertical-align:middle" class="text-center">{{ $quantity or '' }}</td>
							<!--<td style="vertical-align:middle" class="text-center">{{ $received or '' }}</td>-->
							<!--<td style="vertical-align:middle" class="text-center">{{ $lost }}</th>-->
						</tr>
						@endforeach
					@endif
				</table>
			</div>
        </div>
    </div>
<br>
@stop
