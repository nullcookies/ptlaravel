<?php 
$cf = new \App\lib\CommonFunction(); 
use App\Http\Controllers\UtilityController;
$glob = DB::table('global')->first();

	/* Convert to MYR for all money parameters
	   List all the money parameters below to make sure
	   it's properly displayed */
	$moneyKeys = [
		"min_merchant_token_value",
		"min_station_token_value",
		"merchant_annual_subscription_fee",
		"station_annual_subscription_fee",
		"station_min_order",
		"delivery_administration_fee",
		"order_administration_fee",
		"agreement_stamping_fee",
		"fpx_commission_b2c_fixed",
		"fpx_commission_b2b_fixed",
		"jpay_commission_fixed",
		"jpay_commission_ccard_fixed",
		"jpay_real_time_notification"
	];

	foreach ($moneyKeys as $key => $value) {
		//dump("BEFORE:".$globals->$value);
		$globals->$value = number_format($globals->$value/100,2);
		//dump('AFTER: $globals->'.$value."=".$globals->$value);
	}
	
	//dd($currentCurrency);
?>

@extends('common.default')
@section('content')
<style media="screen">
	legend {
		color: #27A98A;
		height: 55px;
		padding-top: 5px;
	}
	.form-group {
		margin-bottom: 5px;
	}
	.globals-wrapper {
		padding-bottom: 60px;
	}
	.pmrb-table {
	    width: 95%;
	}
	.pmrb-table td, .pmrb-table th {
		border: none;
		margin: 0;
		padding: 2px;
	}
	.custom-btn { margin-top: -6px }
	
	.pmrb-save-success {
		font-size: 15px;
		margin-top: 6px;
		padding-right: 19px;
		display: none;
	}
	.block-element {
		display: block;
		float: left;
		clear: both;
	}
	
	#pmrb-table .form-group {
		margin-bottom: 0;
	}

	.page-header {
		border:none;
	}
	
	fieldset {
		padding-left: 15px;
		padding-right: 15px;
	}
</style>
<div class="container globals-wrapper">
	@include('admin/panelHeading')

	<div class="row">
		<div class="col-md-12">
			<div style="padding-top:0;margin-top:0;margin-bottom:0"
				class="page-header">
				<h1>CAPS</h1>
				<h2>Global Control</h2>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<ul class="nav nav-tabs">
				<li role="presentation" class="active"><a data-toggle="tab" href="#gbl-general">General</a></li>
				<li role="presentation"><a data-toggle="tab" href="#currency">Currency</a></li>
				<li role="presentation"><a data-toggle="tab" href="#pmrb-table">PMRB Table</a></li>
				<li role="presentation"><a data-toggle="tab" href="#merchant-agreement">Merchant Agreement</a></li>
				<li role="presentation"><a data-toggle="tab" href="#station-agreement">Station Agreement</a></li>
				<li role="presentation"><a data-toggle="tab" href="#token">Token</a></li>
				<li role="presentation"><a data-toggle="tab" href="#logisticstab">Logistics</a></li>
				<li role="presentation"><a data-toggle="tab" href="#gateway">Payment&nbsp;Gateway</a></li>
			</ul>
		</div>
	</div>
	{!! Form::model($globals, ['url' => route('admin.general.globals.update', $globals->id), 'method' => 'PUT', 'id' => 'update-globals']) !!}
	<div class="tab-content">
		<div class="row tab-pane fade" id="gateway">

			<fieldset>
				<legend><h3>MyClear FPX</h3></legend>	
 				<div class="row">
					{!! Form::label('fpx_prd_seller_id', 'PRD FPX Seller ID',
						['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						{!! Form::text('fpx_prd_seller_id', null,
							['class' => 'form-control quick-edit', 'disabled']) !!}
					</div>
				</div>
				<div class="row">
					{!! Form::label('fpx_prd_exchange_id', 'PRD FPX Exchange ID',
						['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						{!! Form::text('fpx_prd_exchange_id', null,
							['class' => 'form-control quick-edit','disabled']) !!}
					</div>
				</div> 
 				<div class="row">
					{!! Form::label('fpx_prd_url', 'PRD Primary URL',
						['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						{!! Form::text('fpx_prd_url', null,
							['class' => 'form-control quick-edit','disabled']) !!}
					</div>
				</div>
				<div class="row">
					{!! Form::label('fpx_prd_be_url', 'PRD Bank Enquiry URL',
						['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						{!! Form::text('fpx_prd_be_url', null,
							['class' => 'form-control quick-edit','disabled']) !!}
					</div>
				</div>
				<div class="row">
					{!! Form::label('fpx_prd_ae_url', 'PRD Authorization Enquiry URL',
						['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						{!! Form::text('fpx_prd_ae_url', null,
							['class' => 'form-control quick-edit','disabled']) !!}
					</div>
				</div> 
				<div class="row">
					{!! Form::label('fpx_seller_id', 'UAT FPX Seller ID',
						['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						{!! Form::text('fpx_seller_id', null,
							['class' => 'form-control quick-edit', 'disabled']) !!}
					</div>
				</div>
				<div class="row">
					{!! Form::label('fpx_exchange_id', 'UAT FPX Exchange ID',
						['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						{!! Form::text('fpx_exchange_id', null,
							['class' => 'form-control quick-edit','disabled']) !!}
					</div>
				</div>
				<div class="row">
					{!! Form::label('fpx_uat_url', 'UAT Primary URL',
						['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						{!! Form::text('fpx_uat_url', null,
							['class' => 'form-control quick-edit','disabled']) !!}
					</div>
				</div>
				<div class="row">
					{!! Form::label('fpx_uat_be_url', 'UAT Bank Enquiry URL',
						['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						{!! Form::text('fpx_uat_be_url', null,
							['class' => 'form-control quick-edit','disabled']) !!}
					</div>
				</div>
				<div class="row">
					{!! Form::label('fpx_uat_ae_url', 'UAT Authorization Enquiry URL',
						['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						{!! Form::text('fpx_uat_ae_url', null,
							['class' => 'form-control quick-edit','disabled']) !!}
					</div>
				</div>

 				<div class="row">
					{!! Form::label('fpx_commission_b2c',
					'FPX Commission B2C (per transaction)', 
					['class' => 'col-md-3']) !!}
  					<div class="form-group col-md-3">
 						<div class="input-group">
						<div class="input-group-addon">{{$currentCurrency}}</div>
						{!! Form::text('fpx_commission_b2c_fixed', null,
						['class' => 'form-control quick-edit required number','disabled'])
						!!}
						</div> 
					</div>   
  					<div class="form-group col-md-2">
						<div class="input-group">
						{!! Form::text('fpx_commission_b2c', null,
						['class' => 'form-control quick-edit required number','disabled']
						)!!}
						<div class="input-group-addon">&#37;</div>
						</div>
					</div>   
				</div> 
  				<div class="row">
					{!! Form::label('fpx_commission_b2b',
					'FPX Commission B2B (per transaction)',
					['class' => 'col-md-3']) !!}
					<div class="form-group col-md-3">
 						<div class="input-group">
						<div class="input-group-addon">{{$currentCurrency}}</div>
						{!! Form::text('fpx_commission_b2b_fixed', null,
						['class' => 'form-control quick-edit required number','disabled'])
						!!}
						</div> 
					</div>   
  					<div class="form-group col-md-2">
						<div class="input-group">
						{!! Form::text('fpx_commission_b2b', null,
						['class' => 'form-control quick-edit required number','disabled']
						)!!}
						<div class="input-group-addon">&#37;</div>
						</div>
					</div>   
				</div>  
			</fieldset>
			<!-- End FPX -->			
  			<fieldset>
				<legend><h3>MyClear JomPay</h3></legend>
				<div class="row">
 					{!! Form::label('jpay_commission_fixed',
					'JomPay Commission CASA (per txn)',
					['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
 						<div class="input-group">
						<div class="input-group-addon">{{$currentCurrency}}</div>
						{!! Form::text('jpay_commission_fixed', null,
						['class' => 'form-control quick-edit required number','disabled'])
						!!}
						</div> 
					</div>   
				</div> 
   				<div class="row">
					{!! Form::label('jpay_commission_ccard',
					'JomPay Commission Credit Card (per txn)',
					['class' => 'col-md-3']) !!}
					<div class="form-group col-md-3">
 						<div class="input-group">
						<div class="input-group-addon">{{$currentCurrency}}</div>
						{!! Form::text('jpay_commission_ccard_fixed', null,
						['class' => 'form-control quick-edit required number','disabled'])
						!!}
						</div> 
					</div>   
  					<div class="form-group col-md-2">
						<div class="input-group">
						{!! Form::text('jpay_commission_ccard', null,
						['class' => 'form-control quick-edit required number','disabled']
						)!!}
						<div class="input-group-addon">&#37;</div>
						</div>
					</div>   
				</div>   
 				<div class="row">
 					{!! Form::label('jpay_real_time_notification',
					'JomPay Real-Time Notification (per txn)',
					['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
 						<div class="input-group">
						<div class="input-group-addon">{{$currentCurrency}}</div>
						{!! Form::text('jpay_real_time_notification', null,
						['class' => 'form-control quick-edit required number','disabled'])
						!!}
						</div> 
					</div>   
				</div>  
			</fieldset>
			<!-- End JomPay -->
   			<fieldset>
				<legend><h3>OCBC Visa/Master</h3></legend>
				<div class="row">
 					{!! Form::label('ocbc_mdr_creditcard',
					'OCBC MDR Credit Card (per transaction)',
					['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
 						<div class="input-group">
						{!! Form::text('ocbc_mdr_creditcard', null,
						['class' => 'form-control quick-edit required number','disabled'])
						!!}
						<div class="input-group-addon">&#37;</div>
						</div> 
					</div>   
				</div> 
 				<div class="row">
 					{!! Form::label('ocbc_mdr_debitcard',
					'OCBC MDR Debit Card (per transaction)',
					['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
 						<div class="input-group">
						{!! Form::text('ocbc_mdr_debitcard', null,
						['class' => 'form-control quick-edit required number','disabled'])
						!!}
						<div class="input-group-addon">&#37;</div>
						</div> 
					</div>   
				</div>  
 				<div class="row">
 					{!! Form::label('ocbc_mdr_prepaidcard',
					'OCBC MDR Credit Card (per transaction)',
					['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
 						<div class="input-group">
						{!! Form::text('ocbc_mdr_prepaidcard', null,
						['class' => 'form-control quick-edit required number','disabled'])
						!!}
						<div class="input-group-addon">&#37;</div>
						</div> 
					</div>   
				</div>  

			</fieldset> 
			<!-- End OCBC Visa/Mastercard -->
 			<fieldset>
				<legend><h3>iPay88</h3></legend>
				<div class="row">
					{!! Form::label('ipay88_merchant_code', 'iPay88 merchant code', ['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						{!! Form::text('ipay88_merchant_code', null, ['class' => 'form-control quick-edit', 'disabled']) !!}
					</div>
				</div>
				<div class="row">
					{!! Form::label('ipay88_merchant_key', 'iPay88 merchant key', ['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						{!! Form::text('ipay88_merchant_key', null, ['class' => 'form-control quick-edit', 'disabled']) !!}
					</div>
				</div>
				<div class="row">
					{!! Form::label('payment_gateway_commission', 'iPay88 commission', ['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						<div class="input-group">
							{!! Form::text('payment_gateway_commission', null, ['class' => 'form-control quick-edit required number','disabled']) !!}
							<div class="input-group-addon">&#37;</div>
						</div>
					</div>
				</div>
			</fieldset>
			<!-- End iPay88 --> 
			<!-- End Payment Gateway --> 
		</div>
		<div class="row tab-pane fade" id="logisticstab">
			<fieldset>
				<legend><h3>CityLink API</h3></legend>
				<div class="row">
					{!! Form::label('ctl_companycode', 'CTL Company Code',
						['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						{!! Form::text('ctl_companycode', null,
							['class' => 'form-control quick-edit','disabled']) !!}
					</div>
				</div>
				<div class="row">
					{!! Form::label('ctl_account', 'CTL Account',
						['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						{!! Form::text('ctl_account', null,
							['class' => 'form-control quick-edit','disabled']) !!}
					</div>
				</div>
				<div class="row">
					{!! Form::label('ctl_meternumber', 'CTL Meter Number',
						['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						{!! Form::text('ctl_meternumber', null,
							['class' => 'form-control quick-edit','disabled']) !!}
					</div>
				</div>
			</fieldset>
			<!-- End CityLink API -->		
			<fieldset>
				<legend><h3>NinjaVan API</h3></legend>
 				<div class="row">
					{!! Form::label('nv_prd_client_id', 'PRD Client ID',
						['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						{!! Form::text('nv_prd_client_id', null,
							['class' => 'form-control quick-edit','disabled']) !!}
					</div>
				</div>
				<div class="row">
					{!! Form::label('nv_prd_client_secret', 'PRD Client Secret',
						['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						{!! Form::text('nv_prd_client_secret', null,
							['class' => 'form-control quick-edit','disabled']) !!}
					</div>
				</div>
 				<div class="row">
					{!! Form::label('nv_prd_base_uri', 'PRD Base URI',
						['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						{!! Form::text('nv_prd_base_uri', null,
							['class' => 'form-control quick-edit','disabled']) !!}
					</div>
				</div>  
 				<div class="row">
					{!! Form::label('nv_client_id', 'UAT Client ID',
						['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						{!! Form::text('nv_client_id', null,
							['class' => 'form-control quick-edit','disabled']) !!}
					</div>
				</div>
				<div class="row">
					{!! Form::label('nv_client_secret', 'UAT Client Secret',
						['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						{!! Form::text('nv_client_secret', null,
							['class' => 'form-control quick-edit','disabled']) !!}
					</div>
				</div>
 				<div class="row">
					{!! Form::label('nv_base_uri', 'UAT Base URI',
						['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						{!! Form::text('nv_base_uri', null,
							['class' => 'form-control quick-edit','disabled']) !!}
					</div>
				</div>  
				<div class="row">
					{!! Form::label('nv_webhook_log', 'Webhook Log',
						['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						{!! Form::text('nv_webhook_log', null,
							['class' => 'form-control quick-edit','disabled']) !!}
					</div>
				</div>

				<div class="row">
					{!! Form::label('nv_auth_api', 'Authentitication API',
						['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						{!! Form::text('nv_auth_api', null,
							['class' => 'form-control quick-edit','disabled']) !!}
					</div>
				</div>
				<!--
				<div class="row">
					{!! Form::label('nv_subshipper_api', 'Subshipper API',
						['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						{!! Form::text('nv_subshipper_api', null,
							['class' => 'form-control quick-edit','disabled']) !!}
					</div>
				</div>
				-->
				<div class="row">
					{!! Form::label('nv_order_api', 'Order API',
						['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						{!! Form::text('nv_order_api', null,
							['class' => 'form-control quick-edit','disabled']) !!}
					</div>
				</div>
				<!--
				<div class="row">
					{!! Form::label('nv_ms_order_api', 'Multi-Shipper Order API',
						['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						{!! Form::text('nv_ms_order_api', null,
							['class' => 'form-control quick-edit','disabled']) !!}
					</div>
				</div>
				-->
				<div class="row">
					{!! Form::label('nv_search_api', 'Search API',
						['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						{!! Form::text('nv_search_api', null,
							['class' => 'form-control quick-edit','disabled']) !!}
					</div>
				</div>
				<div class="row">
					{!! Form::label('nv_cancel_api', 'Cancel API',
						['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						{!! Form::text('nv_cancel_api', null,
							['class' => 'form-control quick-edit','disabled']) !!}
					</div>
				</div>
				<div class="row">
					{!! Form::label('nv_track_api', 'Track API',
						['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						{!! Form::text('nv_track_api', null,
							['class' => 'form-control quick-edit','disabled']) !!}
					</div>
				</div>
			</fieldset>
			<!-- End NinjaVan API -->					
		</div>
		<div class="row tab-pane fade" id="token">
			<!-- End System -->
			<fieldset>
				<legend><h3>Token Global Values</h3></legend>
				<div class="row">
					{!! Form::label('min_merchant_token_value', 'Merchant Min Token', ['class' => 'col-md-3']) !!}
					<div class="col-md-5">
						<div class="form-group">
							<div class="input-group">
								<div class="input-group-addon">{{$currentCurrency}}</div>
								{!! Form::text('min_merchant_token_value', null, ['class' => 'form-control quick-edit number required']) !!}
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					{!! Form::label('min_station_token_value', 'Station Min Token', ['class' => 'col-md-3']) !!}
					<div class="col-md-5">
						<div class="form-group">
							<div class="input-group">
								<div class="input-group-addon">{{$currentCurrency}}</div>
								{!! Form::text('min_station_token_value', null, ['class' => 'form-control quick-edit number required']) !!}
							</div>
						</div>
					</div>
				</div>		
				<div class="row">
					<div class="col-md-2">
						&nbsp;
					</div>
					<div class="col-md-3">
						{!! Form::label('label', 'Name', []) !!}
					</div>
					<div class="col-md-3">
						{!! Form::label('label', 'Description', []) !!}
					</div>
					<div class="col-md-2">
						{!! Form::label('label', 'Value', []) !!}
					</div>
					<div class="col-md-2">
						{!! Form::label('label', 'Price', []) !!}
					</div>
				</div>
				@if(!is_null($product1))
					<div class="row">
						{!! Form::label('token_product_1', 'Token Product #1', ['class' => 'col-md-2']) !!}
						<div class="form-group col-md-3">
							<div class="input-group">
								{!! Form::text('token_product_name1', $product1->name, ['class' => 'form-control quick-editproduct', 'rel'=>$product1->id, 'fieldrel'=>'name']) !!}
							</div>
						</div>
						<div class="form-group col-md-3">
							<div class="input-group">
								{!! Form::text('token_product_description1', $product1->description, ['class' => 'form-control quick-editproduct', 'rel'=>$product1->id, 'fieldrel'=>'description']) !!}
							</div>
						</div>
						<div class="form-group col-md-2">
							<div class="input-group">
								{!! Form::text('token_product_retail1', number_format($product1->retail_price/100,2,'.',''), ['class' => 'form-control quick-editproduct number', 'rel'=>$product1->id, 'fieldrel'=>'retail_price']) !!}
							</div>
						</div>
						<div class="form-group col-md-2">
							<div class="input-group">
								<div class="input-group-addon">{{$currentCurrency}}</div>
								{!! Form::text('token_product_discount1', number_format($product1->discounted_price/100,2,'.',''), ['class' => 'form-control quick-editproduct number', 'rel'=>$product1->id, 'fieldrel'=>'discounted_price']) !!}
							</div>
						</div>
					</div>	
				@endif
				@if(!is_null($product2))
					<div class="row">
						{!! Form::label('token_product_2', 'Token Product #2', ['class' => 'col-md-2']) !!}
						<div class="form-group col-md-3">
							<div class="input-group">
								{!! Form::text('token_product_name2', $product2->name, ['class' => 'form-control quick-editproduct', 'rel'=>$product2->id, 'fieldrel'=>'name']) !!}
							</div>
						</div>
						<div class="form-group col-md-3">
							<div class="input-group">
								{!! Form::text('token_product_description2', $product2->description, ['class' => 'form-control quick-editproduct', 'rel'=>$product2->id, 'fieldrel'=>'description']) !!}
							</div>
						</div>
						<div class="form-group col-md-2">
							<div class="input-group">
								{!! Form::text('token_product_retail2', number_format($product2->retail_price/100,2,'.',''), ['class' => 'form-control quick-editproduct number', 'rel'=>$product2->id, 'fieldrel'=>'retail_price']) !!}
							</div>
						</div>
						<div class="form-group col-md-2">
							<div class="input-group">
								<div class="input-group-addon">{{$currentCurrency}}</div>
								{!! Form::text('token_product_discount2', number_format($product2->discounted_price/100,2,'.',''), ['class' => 'form-control quick-editproduct number', 'rel'=>$product1->id, 'fieldrel'=>'discounted_price']) !!}
							</div>
						</div>
					</div>	
				@endif
				@if(!is_null($product3))
					<div class="row">
						{!! Form::label('token_product_1', 'Token Product #3', ['class' => 'col-md-2']) !!}
						<div class="form-group col-md-3">
							<div class="input-group">
								{!! Form::text('token_product_name3', $product3->name, ['class' => 'form-control quick-editproduct', 'rel'=>$product3->id, 'fieldrel'=>'name']) !!}
							</div>
						</div>
						<div class="form-group col-md-3">
							<div class="input-group">
								{!! Form::text('token_product_description3', $product3->description, ['class' => 'form-control quick-editproduct', 'rel'=>$product3->id, 'fieldrel'=>'description']) !!}
							</div>
						</div>
						<div class="form-group col-md-2">
							<div class="input-group">
								{!! Form::text('token_product_retail3', number_format($product3->retail_price/100,2,'.',''), ['class' => 'form-control quick-editproduct number', 'rel'=>$product3->id, 'fieldrel'=>'retail_price']) !!}
							</div>
						</div>
						<div class="form-group col-md-2">
							<div class="input-group">
								<div class="input-group-addon">{{$currentCurrency}}</div>
								{!! Form::text('token_product_discount3', number_format($product3->discounted_price/100,2,'.',''), ['class' => 'form-control quick-editproduct number', 'rel'=>$product1->id, 'fieldrel'=>'discounted_price']) !!}
							</div>
						</div>
					</div>	
				@endif
				@if(!is_null($product4))
					<div class="row">
						{!! Form::label('token_product_1', 'Token Product #4', ['class' => 'col-md-2']) !!}
						<div class="form-group col-md-3">
							<div class="input-group">
								{!! Form::text('token_product_name4', $product4->name, ['class' => 'form-control quick-editproduct', 'rel'=>$product4->id, 'fieldrel'=>'name']) !!}
							</div>
						</div>
						<div class="form-group col-md-3">
							<div class="input-group">
								{!! Form::text('token_product_description4', $product4->description, ['class' => 'form-control quick-editproduct', 'rel'=>$product4->id, 'fieldrel'=>'description']) !!}
							</div>
						</div>
						<div class="form-group col-md-2">
							<div class="input-group">
								{!! Form::text('token_product_retail4', number_format($product4->retail_price/100,2,'.',''), ['class' => 'form-control quick-editproduct number', 'rel'=>$product4->id, 'fieldrel'=>'retail_price']) !!}
							</div>
						</div>
						<div class="form-group col-md-2">
							<div class="input-group">	
								<div class="input-group-addon">{{$currentCurrency}}</div>
								{!! Form::text('token_product_discount4', number_format($product4->discounted_price/100,2,'.',''), ['class' => 'form-control quick-editproduct number', 'rel'=>$product1->id, 'fieldrel'=>'discounted_price']) !!}
							</div>
						</div>
					</div>	
				@endif				
			</fieldset>
			<!-- End Term -->			
		</div>
		<div class="row tab-pane fade in active" id="gbl-general">
			<fieldset>
				<legend><h3>Basic</h3></legend>
				<div class="row">

					{!! Form::label('merchant_annual_subscription_fee',
					'Merchant Subscription Fee',
					['class' => 'col-md-3']) !!}
					<div class="col-md-5">
						<div class="form-group">
							<div class="input-group">
								<div class="input-group-addon">{{$currentCurrency}}</div>
								{!! Form::text('merchant_annual_subscription_fee', null, ['class' => 'form-control quick-edit number required']) !!}
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-3">
						{!! Form::label('station_annual_subscription_fee', 'Station Subscription Fee') !!}
					</div>
					<div class="col-md-5">
						<div class="form-group">
							<div class="input-group">
								<div class="input-group-addon">{{$currentCurrency}}</div>
								{!! Form::text('station_annual_subscription_fee', null, ['class' => 'form-control quick-edit required number']) !!}
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-3">
						{!! Form::label('humancap_fee', 'HumanCap Fee') !!}
					</div>
					<div class="col-md-5">
						<div class="form-group">
							<div class="input-group">
								<div class="input-group-addon">{{$currentCurrency}}</div>
								{!! Form::text('humancap_fee', null,
								['class' => 'form-control quick-edit required number','disabled']) !!}
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					{!! Form::label('openque_fee', 'OpenQue Fee',
					['class' => 'col-md-3']) !!}
					<div class="col-md-5">
						<div class="form-group">
							<div class="input-group">
								<div class="input-group-addon">{{$currentCurrency}}</div>
								{!! Form::text('openque_fee', null,
								['class' => 'form-control quick-edit required number','disabled']) !!}
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					{!! Form::label('opentv_commission', 'OpenTV Commission', ['class' => 'col-md-3']) !!}
					<div class="col-md-5">
						<div class="form-group">
							<div class="input-group">
								{!! Form::text('opentv_commission', '',
								['class' => 'form-control quick-edit required number','disabled']) !!}
								<span class="input-group-addon">&#37;</span>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						{!! Form::label('order_administration_fee', 'Administration Fee') !!}
					</div>
					<div class="col-md-5">
						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon">{{$currentCurrency}}</span>
								{!! Form::text('order_administration_fee', null, ['class' => 'form-control quick-edit required number']) !!}
							</div>
						</div>
					</div>
				</div>

			</fieldset>
			<!-- End Basic -->
			<fieldset>
				<legend><h3>Merchant</h3></legend>
				<div class="row">
					{!! Form::label('gst_rate', 'GST Rate', ['class' => 'col-md-3']) !!}
					<div class="col-md-5">
						<div class="form-group">
							<div class="input-group">
								{!! Form::text('gst_rate', null, ['class' => 'form-control quick-edit required number']) !!}
								<span class="input-group-addon">&#37;</span>
							</div>
						</div>
					</div>
				</div>
			</fieldset>
			<!-- End Merchant -->
			<fieldset>
				<legend><h3>Employment</h3></legend>
				<div class="row">
					<div class="col-md-3">
						<label>SOSCO (&lt; 60 y.o.)</label>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<div class="input-group">
								<div class="input-group-addon">Employer</div>
								{!! Form::text('socso_less60_employer', null, ['class' => 'form-control quick-edit required number']) !!}
								<div class="input-group-addon">
									&#37;
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<div class="input-group">
								<div class="input-group-addon">Employee</div>
								{!! Form::text('socso_less60_employee', null, ['class' => 'form-control quick-edit required number']) !!}
								<div class="input-group-addon">
									&#37;
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-3">
						<label>SOSCO (&gt; 60 y.o.)</label>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<div class="input-group">
								<div class="input-group-addon">Employer</div>
								{!! Form::text('socso_more60_employer', null, ['class' => 'form-control quick-edit required number']) !!}
								<div class="input-group-addon">
									&#37;
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-3">
						<label>EPF Employee (&lt; {{$currentCurrency}}5,000)</label>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon">A</span>
								{!! Form::text('epf_less5k_employee_A', null, ['class' => 'form-control quick-edit required number']) !!}
								<span class="input-group-addon">&#37;</span>
							</div>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon">B</span>
								{!! Form::text('epf_less5k_employee_B', null, ['class' => 'form-control quick-edit required number']) !!}
								<span class="input-group-addon">&#37;</span>
							</div>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon">C</span>
								{!! Form::text('epf_less5k_employee_C', null, ['class' => 'form-control quick-edit required number']) !!}
								<span class="input-group-addon">&#37;</span>
							</div>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon">D</span>
								{!! Form::text('epf_less5k_employee_D', null, ['class' => 'form-control quick-edit required number']) !!}
								<span class="input-group-addon">&#37;</span>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-3">
						<label>EPF Employer (&lt; {{$currentCurrency}}5,000)</label>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon">A</span>
								{!! Form::text('epf_less5k_employer_A', null, ['class' => 'form-control quick-edit required number']) !!}
								<span class="input-group-addon">&#37;</span>
							</div>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon">B</span>
								{!! Form::text('epf_less5k_employer_B', null, ['class' => 'form-control quick-edit required number']) !!}
								<span class="input-group-addon">&#37;</span>
							</div>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon">C</span>
								{!! Form::text('epf_less5k_employer_C', null, ['class' => 'form-control quick-edit required number']) !!}
								<span class="input-group-addon">&#37;</span>
							</div>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon">D</span>
								{!! Form::text('epf_less5k_employer_D', null, ['class' => 'form-control quick-edit required number']) !!}
								<span class="input-group-addon">&#37;</span>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-3">
						<label>EPF Employee (&gt; {{$currentCurrency}}5,000)</label>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon">A</span>
								{!! Form::text('epf_more5k_employee_A', null, ['class' => 'form-control quick-edit required number']) !!}
								<span class="input-group-addon">&#37;</span>
							</div>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon">B</span>
								{!! Form::text('epf_more5k_employee_B', null, ['class' => 'form-control quick-edit required number']) !!}
								<span class="input-group-addon">&#37;</span>
							</div>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon">C</span>
								{!! Form::text('epf_more5k_employee_C', null, ['class' => 'form-control quick-edit required number']) !!}
								<span class="input-group-addon">&#37;</span>
							</div>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon">D</span>
								{!! Form::text('epf_more5k_employee_D', null, ['class' => 'form-control quick-edit required number']) !!}
								<span class="input-group-addon">&#37;</span>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-3">
						<label>EPF Employer (&gt; {{$currentCurrency}}5,000)</label>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon">A</span>
								{!! Form::text('epf_more5k_employer_A', null, ['class' => 'form-control quick-edit required number']) !!}
								<span class="input-group-addon">&#37;</span>
							</div>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon">B</span>
								{!! Form::text('epf_more5k_employer_B', null, ['class' => 'form-control quick-edit required number']) !!}
								<span class="input-group-addon">&#37;</span>
							</div>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon">C</span>
								{!! Form::text('epf_more5k_employer_C', null, ['class' => 'form-control quick-edit required number']) !!}
								<span class="input-group-addon">&#37;</span>
							</div>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon">D</span>
								{!! Form::text('epf_more5k_employer_D', null, ['class' => 'form-control quic-edit required number']) !!}
								<span class="input-group-addon">&#37;</span>
							</div>
						</div>
					</div>
				</div>
			</fieldset>
			<!-- End Employment -->
			<fieldset>
				<legend><h3>Restaurant</h3></legend>
				<div class="row">
					<div class="col-md-3">
						{!! Form::label('', 'Restaurant') !!}
					</div>
					<div class="col-md-5">
						{!! Form::text('placeholder', '',
						['class' => 'form-control quick-edit required','disabled']) !!}
					</div>
				</div>
			</fieldset>
			<!-- End Restaurant -->
			<fieldset>
				<legend><h3>CarPark</h3></legend>
				<div class="row">
					{!! Form::label('', 'CarPark Subscription Fee',
					['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						<div class="input-group">
							<div class="input-group-addon">{{$currentCurrency}}</div>
							{!! Form::text('placeholder', '',
							['class' => 'form-control quick-edit required','disabled']) !!}
						</div>
					</div>
				</div>
				<div class="row">
					{!! Form::label('', 'CarPark Number Rate',
					['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						<div class="input-group">
							{!! Form::text('placeholder', '',
							['class' => 'form-control quick-edit required','disabled']) !!}
							<div class="input-group-addon">&#37;</div>
						</div>
					</div>
				</div>
				<div class="row">
					{!! Form::label('', 'CarPark Fine Commission',
					['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						<div class="input-group">
							{!! Form::text('placeholder', '',
							['class' => 'form-control quick-edit required','disabled']) !!}
							<div class="input-group-addon">&#37;</div>
						</div>
					</div>
				</div>
				<div class="row">					
					{!! Form::label('', 'CarPark Clamp Commission',
					['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						<div class="input-group">
							{!! Form::text('placeholder', '',
							['class' => 'form-control quick-edit required','disabled']) !!}
							<div class="input-group-addon">&#37;</div>
						</div>
					</div>
				</div>
			</fieldset>
			<!-- End CarPark -->
			<fieldset>
				<legend><h3>Delivery</h3></legend>
				<div class="row">
					{!! Form::label('delivery_sop', 'Delivery SOP', ['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						<div class="input-group">
							{!! Form::text('delivery_sop', null, ['class' => 'form-control quick-edit required number']) !!}
							<span class="input-group-addon">days</span>
						</div>
					</div>
				</div>
				<div class="row">
					{!! Form::label('delivery_administration_fee', 'Delivery Administration Fee', ['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						<div class="input-group">
							<span class="input-group-addon">{{$currentCurrency}}</span>
							{!! Form::text('delivery_administration_fee', null, ['class' => 'form-control quick-edit required number']) !!}
						</div>
					</div>
				</div>
			</fieldset>
			<!-- End Delivery -->
			<fieldset>
				<legend><h3>Social Media Marketeer</h3></legend>
				<div class="row">
					{!! Form::label('smm_quota_max', 'SMM Product Quota Max',
						['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						<div class="input-group">
							{!! Form::text('smm_quota_max', null,
							['class' => 'form-control quick-edit required number']) !!}
							<span class="input-group-addon">products</span>
						</div>
					</div>
				</div>
				<div class="row">
					{!! Form::label('smm_max_post ', 'SMM Max Post per day',
						['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						<div class="input-group">
							{!! Form::text('smm_max_post', null,
							['class' => 'form-control quick-edit required number']) !!}
							<span class="input-group-addon">posts</span>
						</div>
					</div>
				</div>
				<div class="row">
					{!! Form::label('smm_min_duration', 'SMM Min Duration',
					['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						<div class="input-group">
							{!! Form::text('smm_min_duration', null,
							['class' => 'form-control quick-edit required number']) !!}
							<div class="input-group-addon">hours</div>
						</div>
					</div>
				</div>
				<div class="row">
					{!! Form::label('smm_active_duration', 'SMM Active Duration', ['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						<div class="input-group">
							{!! Form::text('smm_active_duration', null, ['class' => 'form-control quick-edit required number']) !!}
							<div class="input-group-addon">days</div>
						</div>
					</div>
				</div>
			</fieldset>
			<!-- End Social Media Marketeer -->			
			<fieldset>
				<legend><h3>Bank</h3></legend>
				<div class="row">
					{!! Form::label('ocbc_company_cif', 'OCBC Company CIF', ['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						{!! Form::text('ocbc_company_cif', null, ['class' => 'form-control quick-edit', 'disabled']) !!}
					</div>
				</div>
				<div class="row">
					{!! Form::label('ocbc_company_ac_no', 'OCBC Company Acct No.', ['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						{!! Form::text('ocbc_company_ac_no', null, ['class' => 'form-control quick-edit', 'disabled']) !!}
					</div>
				</div>
				<div class="row">
					{!! Form::label('ocbc_branch', 'OCBC Branch', ['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						{!! Form::text('ocbc_branch', null, ['class' => 'form-control quick-edit', 'disabled']) !!}
					</div>
				</div>
				<div class="row">
					{!! Form::label('ocbc_company_name', 'OCBC Company Name', ['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						{!! Form::text('ocbc_company_name', null, ['class' => 'form-control quick-edit', 'disabled']) !!}
					</div>
				</div>
				<div class="row">
					{!! Form::label('bank_transfer_fee', 'Giro Transfer Fee', ['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						<div class="input-group">
							<span class="input-group-addon">{{$currentCurrency}}</span>
							{!! Form::text('bank_transfer_fee', null, ['class' => 'form-control quick-edit required number']) !!}
						</div>
					</div>
				</div>
			</fieldset>
			<!-- End Bank -->
			<fieldset>
				<legend><h3>J &amp; C</h3></legend>
				<div class="row">
					{!! Form::label('jc_ars_url', 'Production Server', ['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						{!! Form::text('jc_ars_url', null, ['class' => 'form-control quick-edit required full_url']) !!}
					</div>
				</div>
			</fieldset>
			<!-- End J&C -->
			<fieldset>
				<legend><h3>Hyper & OpenWish</h3></legend>
				<div class="row">
					{!! Form::label('hyper_duration', 'Hyper Duration',
					['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						<div class="input-group">
							{!! Form::text('hyper_duration', null,
							['class' => 'form-control quick-edit required number']) !!}
							<span class="input-group-addon">days</span>
						</div>
					</div>
				</div>
				<div class="row">
					{!! Form::label('openwish_duration', 'OpenWish Duration',
					['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						<div class="input-group">
							{!! Form::text('openwish_duration', null,
							['class' => 'form-control quick-edit required number']) !!}
							<span class="input-group-addon">days</span>
						</div>
					</div>
				</div>
			</fieldset>
			<!-- End Hyper -->
			<fieldset>
				<legend><h3>CRE</h3></legend>
				<div class="row">
					{!! Form::label('buyer_cancellation_window', 'Buyer Cancellation Window', ['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						<div class="input-group">
							{!! Form::text('buyer_cancellation_window', null, ['class' => 'form-control quick-edit required number']) !!}
							<span class="input-group-addon">min</span>
						</div>
					</div>
				</div>
				<div class="row">
					{!! Form::label('buyer_return_window', 'Buyer Return Window', ['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						<div class="input-group">
							{!! Form::text('buyer_return_window', null, ['class' => 'form-control quick-edit required number']) !!}
							<spa class="input-group-addon">days</span>
						</div>
					</div>
				</div>
				<div class="row">
					{!! Form::label('merchant_approve_cre_window', 'Merchant Approve CRE Window', ['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						<div class="input-group">
							{!! Form::text('merchant_approve_cre_window', null, ['class' => 'form-control quick-edit required number']) !!}
							<span class="input-group-addon">days</span>
						</div>
					</div>
				</div>
			</fieldset>
			<!-- End CRE -->
			<fieldset>
				<legend><h3>Commission</h3></legend>
				<div class="row">
					{!! Form::label('pri_commission_constraint', 'Primary Commission Constraint', ['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						<div class="input-group">
							{!! Form::text('pri_commission_constraint', null, ['class' => 'form-control quick-edit required number']) !!}
							<span class="input-group-addon">&#37;</span>
						</div>
					</div>
				</div>
				<div class="row">
					{!! Form::label('osmall_commission', 'OpenSupermall Commission', ['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						<div class="input-group">
							{!! Form::text('osmall_commission', null, ['class' => 'form-control quick-edit required number']) !!}
							<span class="input-group-addon">&#37;</span>
						</div>
					</div>
				</div>
				<div class="row">
					{!! Form::label('commission_type', 'OpenSupermall Commission Type', ['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						<div class="input-group">
							{!! Form::select('commission_type', array('std' => 'Standard', 'var' => 'Variable'), null, ['class' => 'form-control quick-edit required']) !!}
							<span class="input-group-addon">type</span>
						</div>
					</div>
				</div>					
				<div class="row">
					{!! Form::label('b2b_osmall_commission', 'OpenSupermall B2B Commission', ['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						<div class="input-group">
							{!! Form::text('b2b_osmall_commission', null, ['class' => 'form-control quick-edit required number']) !!}
							<span class="input-group-addon">&#37;</span>
						</div>
					</div>
				</div>	
				<div class="row">
					{!! Form::label('b2b_commission_type', 'OpenSupermall B2B Commission Type', ['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						<div class="input-group">
							{!! Form::select('b2b_commission_type', array('std' => 'Standard', 'var' => 'Variable'), null, ['class' => 'form-control quick-edit required']) !!}
							<span class="input-group-addon">type</span>
						</div>
					</div>
				</div>					
				<div class="row">
					{!! Form::label('mc_sales_staff_commission', 'Merchant Consultant Commission', ['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						<div class="input-group">
							{!! Form::text('mc_sales_staff_commission', null, ['class' => 'form-control quick-edit required number']) !!}
							<span class="input-group-addon">&#37;</span>
						</div>
					</div>
				</div>
				<div class="row">
					{!! Form::label('mc_with_ref_sales_staff_commission', 'Merchant Consultant with Referral Commission Fraction', ['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						{!! Form::text('mc_with_ref_sales_staff_commission', null, ['class' => 'form-control quick-edit required number']) !!}
					</div>
				</div>
				<div class="row">
					{!! Form::label('referral_sales_staff_commission', 'Referral Commission Fraction', ['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						{!! Form::text('referral_sales_staff_commission', null, ['class' => 'form-control quick-edit required number']) !!}
					</div>
				</div>
				<div class="row">
					{!! Form::label('mcp1_sales_staff_commission', 'Merchant Professional 1 Commission', ['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						{!! Form::text('mcp1_sales_staff_commission', null, ['class' => 'form-control quick-edit required number']) !!}
					</div>
				</div>
				<div class="row">
					{!! Form::label('mcp2_sales_staff_commission', 'Merchant Professional 2 Commission', ['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						{!! Form::text('mcp2_sales_staff_commission', null, ['class' => 'form-control quick-edit required number']) !!}
					</div>
				</div>
				<div class="row">
					{!! Form::label('smm_sales_staff_commission', 'SMM Allocation Commission', ['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						<div class="input-group">
							{!! Form::text('smm_sales_staff_commission', null, ['class' => 'form-control quick-edit required number']) !!}
							<span class="input-group-addon">&#37;</span>
						</div>
					</div>
				</div>
				<div class="row">
					{!! Form::label('psh_sales_staff_commission', 'Professional Integrator Allocation Commission', ['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						<div class="input-group">
							{!! Form::text('psh_sales_staff_commission', null, ['class' => 'form-control quick-edit required number']) !!}
							<span class="input-group-addon">&#37;</span>
						</div>
					</div>
				</div>
				<div class="row">
					{!! Form::label('ow_commission', 'OpenWish Commission', ['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						<div class="input-group">
							{!! Form::text('ow_commission', null, ['class' => 'form-control quick-edit required number']) !!}
							<span class="input-group-addon">&#37;</span>
						</div>
					</div>
				</div>
				<div class="row">
					{!! Form::label('logistic_commission', 'Logistic Commission', ['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						<div class="input-group">
							{!! Form::text('logistic_commission', null, ['class' => 'form-control quick-edit required number']) !!}
							<span class="input-group-addon">&#37;</span>
						</div>
					</div>
				</div>
			</fieldset>
			<!-- End Commission -->
			{{--
			<fieldset>
				<legend><h3>Subscription Fee</h3></legend>
				<div class="row">
					{!! Form::label('merchant_annual_subscription_fee', 'Merchant Annual Subscription Fee', ['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						<div class="input-group">
							<span class="input-group-addon">{{$currentCurrency}}</span>
							{!! Form::text('merchant_annual_subscription_fee', null, ['class' => 'form-control quick-edit required number']) !!}
						</div>
					</div>
				</div>
				<div class="row">
					{!! Form::label('station_annual_subscription_fee', 'Station Annual Subscription Fee', ['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						<div class="input-group">
							<span class="input-group-addon">{{$currentCurrency}}</span>
							{!! Form::text('station_annual_subscription_fee', null, ['class' => 'form-control quick-edit required number']) !!}
						</div>
					</div>
				</div>
			</fieldset>
			<!-- End Subscription Fee -->
			--}}
			<fieldset>
				<legend><h3>Station</h3></legend>
				<div class="row">
					{!! Form::label('station_min_order', 'Station Minimum Order', ['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						<div class="input-group">
							<span class="input-group-addon">{{$currentCurrency}}</span>
							{!! Form::text('station_min_order', null, ['class' => 'form-control quick-edit required number']) !!}
						</div>
					</div>
				</div>
			</fieldset>
			<!-- Ens Station -->
			<!-- End Delivery Pricing -->
			<fieldset>
				<legend><h3>Email Confirmation Duration</h3></legend>
				<div class="row">
					{!! Form::label('email_confirmation_duration', 'Email Confirmation Duration', ['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						{!! Form::text('email_confirmation_duration', null, ['class' => 'form-control quick-edit required']) !!}
					</div>
				</div>
			</fieldset>			
			<fieldset>
				<legend><h3>Delivery Pricing</h3></legend>
				<div class="row">
					{!! Form::label('cms_pricing', 'Dimension Pricing Factor', ['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						{!! Form::text('cms_pricing', null, ['class' => 'form-control quick-edit required number']) !!}
					</div>
				</div>
				<div class="row">
					{!! Form::label('grs_pricing', 'Weight Pricing Factor', ['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						{!! Form::text('grs_pricing', null, ['class' => 'form-control quick-edit required number']) !!}
					</div>
				</div>
				<div class="row">
					{!! Form::label('mts_pricing', 'MTS Pricing Factor', ['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						{!! Form::text('mts_pricing', null, ['class' => 'form-control quick-edit required number']) !!}
					</div>
				</div>
			</fieldset>
			<!-- End Delivery Pricing -->
			<fieldset>
				<legend><h3>Account Suspension Notification</h3></legend>
				<div class="row">
					{!! Form::label('ceo_log_email', 'CEO Log Email', ['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						{!! Form::text('ceo_log_email', null, ['class' => 'form-control quick-edit required email']) !!}
					</div>
				</div>
				<div class="row">
					{!! Form::label('cto_log_email', 'CTO Log Email', ['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						{!! Form::text('cto_log_email', null, ['class' => 'form-control quick-edit required email']) !!}
					</div>
				</div>
			</fieldset>
			<!-- End Account Suspension Notification -->
			<fieldset>
				<legend><h3>System</h3></legend>
				<div class="row">
					{!! Form::label('max_video_size', 'Max Video Size', ['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						<div class="input-group">
							{!! Form::text('max_video_size', null, ['class' => 'form-control quick-edit required number']) !!}
							<span class="input-group-addon">MB</span>
						</div>
					</div>
					</div>
					<div class="row">
					{!! Form::label('max_img_size', 'Max Image Size', ['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						<div class="input-group">
							{!! Form::text('max_img_size', null, ['class' => 'form-control quick-edit required number']) !!}
							<span class="input-group-addon">MB</span>
						</div>
					</div>	
				
					</div>
					<div class="row">
					{!! Form::label('max_img_size', 'Max Password Failures', ['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						<div class="input-group">
							{!! Form::text('max_password_fail', null, ['class' => 'form-control quick-edit required number']) !!}
							<span class="input-group-addon">Attempts</span>
						</div>
					</div>	
			</fieldset>		
			<!--<div class="form-group">
				<button type="submit" name="create" class="btn btn-primary">
					Create
				</button>
			</div>-->
			<fieldset>
				<legend><h3>Term</h3></legend>
				<div class="row">
					{!! Form::label('term_reminder_period', 'Term Reminder Period', ['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						<div class="input-group">
							{!! Form::text('term_reminder_period', null, ['class' => 'form-control quick-edit required number']) !!}
							<span class="input-group-addon">Weeks</span>
						</div>
					</div>
				</div>
			</fieldset>				

		</div>
		<div class="row tab-pane fade" id="merchant-agreement">
			<div>
				<fieldset>
				<legend>
					<h3>
						Merchant Agreement 
						<div class="pull-right">
							<a href="javascript:void(0)"
							class="summernote-edit btn btn-primary custom-btn"
							data-editable-area="#merchant-agreement-wrapper">
							Edit</a>
							<a href="javascript:void(0)"
							class="summernote-save btn btn-primary custom-btn"
							data-field="merchant_agreement"
							data-editable-area="#merchant-agreement-wrapper">
							Save</a>
						</div>
					</h3>
				</legend>
				<div id="merchant-agreement-wrapper">
					{!! $globals->merchant_agreement !!}</div>
				</fieldset>
			</div>
		</div>
		<div class="row tab-pane fade" id="station-agreement">
			<div>
				<fieldset>
				<legend>
					<h3>
						Station Agreement 
						<div class="pull-right">
							<a href="javascript:void(0)"
							class="summernote-edit btn btn-primary custom-btn"
							data-editable-area="#station-agreement-wrapper">
							Edit</a>
							<a href="javascript:void(0)"
							class="summernote-save btn btn-primary custom-btn"
							data-field="station_agreement"
							data-editable-area="#station-agreement-wrapper">
							Save</a>
						</div>
					</h3>
				</legend>
				<div id="station-agreement-wrapper">
					{!! $globals->station_agreement !!}</div>
				</fieldset>
			</div>
		</div>
		<div class="row tab-pane fade" id="currency">
 			<fieldset>
				<legend><h3>Global Currency Change</h3></legend>
				<div class="row">
					{!! Form::label('currency', 'Global Currency',
						['class' => 'col-md-3']) !!}
					<div class="form-group col-md-5">
						{!! Form::select('currency',$worldcurrency, $currentCurrency, ['class' => 'form-control quick-edit-curr']) !!}
					</div>
				</div>
			</fieldset>
		</div>
		<div class="row tab-pane fade" id="pmrb-table">
			<fieldset>
				<legend>
					<h3>Employee Master: PMRB Table
						<a href="javascript:void(0)"
						style="margin-top:-4.0px"
						class="pull-right btn btn-primary" 
						id="save-pmrb-table">Save</a> <span class="text-success pmrb-save-success pull-right"> </span></h3>
				</legend>
				<?php
				// get json data from pmrb_table table
				$pmrb_table = json_decode($globals->pmrb_table, true);
				?>
				<table class="pmrb-table" width="100%">
					<thead>
					<tr>
						<th class="text-center" style="width: 196px">P (RM)</th>
						<th class="text-center">M (RM)</th>
						<th class="text-center">R &#37;</th>
						<th class="text-center">B Category 1 &amp; 3 (RM)</th>
						<th class="text-center">B Category 2 (RM)</th>
					</tr>
					</thead>
					<tbody>
						@for ($i = 0; $i <= 9; $i ++)
							<tr>
								<td style="width:30%">
									<div class="form-group">
										<div class="input-group">						
											@if ($i < 9)
											<input type="text" id="pmrb-p1-{{$i}}" value="{{@$pmrb_table[$i]['pmrb_p_1']}}"	class="text-center form-control required number">
											<div class="input-group-addon"> &mdash; </div>
											@else
											<div class="input-group-addon"> Exceeding </div>
											@endif
											<input type="text" id="pmrb-p2-{{$i}}" value="{{@$pmrb_table[$i]['pmrb_p_2']}}"	class="text-center form-control required number">						
										</div>
									</div>
								</td>
								<td>
									<div class="form-group">
										<input type="text" id="pmrb-m-{{$i}}" value="{{$pmrb_table[$i]['pmrb_m']}}" class="text-center form-control required number">
									</div>
								</td>
								<td>
									<div class="form-group">
										<input type="text" id="pmrb-r-{{$i}}" value="{{$pmrb_table[$i]['pmrb_r']}}"	class="text-center form-control required number">
									</div>
								</td>
								<td>
									<div class="form-group">
										<input type="text" id="pmrb-b1-{{$i}}" value="{{@$pmrb_table[$i]['pmrb_b1']}}" class="text-center form-control required number">						
									</div>
								</td>
								<td>
									<div class="form-group">
										<input type="text" id="pmrb-b2-{{$i}}" value="<?php echo @$pmrb_table[$i]['pmrb_b2'] ?>" class="text-center form-control required number">
									</div>
								</td>
							</tr>
						@endfor
					</tbody>
				</table>
			</fieldset>
		</div>
	</div>
	{!! Form::close() !!}
</div>
@section('scripts')
    <script type="text/javascript" src="{{ url('js/jquery.validate.min.js') }}"></script>
@endsection
<script type="text/javascript">
	jQuery(document).ready(function($) {
		
		jQuery('#token_merchant_id').change(function () {
			var id = jQuery(this).val();
			jQuery.ajax({
				type: "post",
				url: JS_BASE_URL + '/merchantproducts',
				data: {id: id},
				cache: false,
				success: function (responseData, textStatus, jqXHR) {
					if (responseData != "") {
						$('#token_product_id1').html(responseData);
						console.log(responseData);
					}
					else {
						$('#token_product_id1').empty();
						$('#select2-token_product_id1-container').empty();
					}
					document.getElementById('token_product_id1').disabled = false;
				},
				error: function (responseData, textStatus, errorThrown) {
					alert(errorThrown);
				}
			});
		});
		
		jQuery.validator.addClassRules({
			required: {
				required: true
			},
			number: {
			  number: true
			},
			full_url: {
				url: true
			},
			email: {
				email: true
			}
		});
		
		jQuery.validator.addMethod('float', function (value) {
			return (value.toString().indexOf('.') !== -1 )
		}, 'The value of this element should be a float');
		
		
		// start form validation
		var globalValidation = $('#update-globals').validate({
			errorPlacement: function (error, element) {
				error.addClass('block-element');
				var parent = $(element).closest('.form-group');
				if (parent.length) {
					$(element).closest('.form-group').append(error);
				}
				else {
					$(element).parent().append(error);
				}
			}
		});
		
		// Comment this code to use form's natural behaviour
		$('#update-globals').submit(function () {
			return false;
		});

		$('.summernote-edit').click(function () {
			var editableArea = $(this).data('editable-area');
			$(editableArea).summernote({focus: true});
		});

		$('.summernote-save').click(function () {
			var editableArea = $(this).data('editable-area');
			var saveField = $(this).data('field');
			var markup = $(editableArea).summernote('code');
			$(editableArea).summernote('destroy');

			var data = {};
			data[saveField] = markup;
			$.ajax({
				method: 'PUT',
				url: '<?php echo route('admin.general.globals.update', $globals->id) ?>',
				data: data
			});
			//console.log(markup);
		});

		// .quick-edit Quick edit any field if you add this CSS class
		
		$('.quick-editproduct').change(function () {
			var data = {},
			currentElement = $(this);
			data['val'] = currentElement.val();
			data['pid'] = currentElement.attr('rel');
			data['field'] = currentElement.attr('fieldrel');
			if(data['field'] == 'discounted_price' || data['field'] == 'retail_price'){
				data['val'] = parseFloat(data['val']) * 100;
			}
			console.log(data);
			//if ($('#' + elementId).valid() == false) return false;
			if (currentElement.valid() == false) return false;
			
			$.ajax({
				method: 'POST',
				url: '<?php echo route('globalupdatetoken') ?>',
				data: data,
			    success: function () {
					successMessage = '<span class="text-success '+ currentElement.attr('name') +'">The field was updated successfuly</span>';
					currentElement.closest('.form-group').append(successMessage);
					$('.' + currentElement.attr('name')).delay(3000).hide('slow');
					setTimeout(function () {
						$('.' + currentElement.attr('name')).remove();
					}, 5000);
			    },
			   error: function () {
				   errorMessage = '<span class="text-danger '+ currentElement.attr('name') + '">There was an error updating the field </span>';
					currentElement.closest('.form-group').append(errorMessage);
					$('.' + currentElement.attr('name')).delay(3000).hide('slow');
					setTimeout(function () {
						$('.' + currentElement.attr('name')).remove();
					}, 5000);
			   }
			});
		});
		
		$('.quick-edit').change(function () {
			var data = {},
				currentElement = $(this);
			data[currentElement.attr('name')] = currentElement.val();
			console.log(data);
			//if ($('#' + elementId).valid() == false) return false;
			if (currentElement.valid() == false) return false;
			
			$.ajax({
				method: 'PUT',
				url: '<?php echo route('admin.general.globals.update', $globals->id) ?>',
				data: data,
			    success: function () {
					successMessage = '<span class="text-success '+ currentElement.attr('name') +'">The field was updated successfuly</span>';
					currentElement.closest('.form-group').append(successMessage);
					$('.' + currentElement.attr('name')).delay(3000).hide('slow');
					setTimeout(function () {
						$('.' + currentElement.attr('name')).remove();
					}, 5000);
			    },
			   error: function () {
				   errorMessage = '<span class="text-danger '+ currentElement.attr('name') + '">There was an error updating the field </span>';
					currentElement.closest('.form-group').append(errorMessage);
					$('.' + currentElement.attr('name')).delay(3000).hide('slow');
					setTimeout(function () {
						$('.' + currentElement.attr('name')).remove();
					}, 5000);
			   }
			});
		});
				
		$('.quick-edit-curr').change(function () {
			console.log("AAAAAAAAAAAAAAAAAAA");
			var data = {},
			currentElement = $(this);
			data['val'] = currentElement.val();
			//if ($('#' + elementId).valid() == false) return false;
			if (currentElement.valid() == false) return false;
			
			$.ajax({
				method: 'POST',
				url: '<?php echo route('globalupdatecurrency') ?>',
				data: data,
			    success: function () {
					successMessage = '<span class="text-success '+ currentElement.attr('name') +'">The field was updated successfuly</span>';
					currentElement.closest('.form-group').append(successMessage);
					$('.' + currentElement.attr('name')).delay(3000).hide('slow');
					setTimeout(function () {
						$('.' + currentElement.attr('name')).remove();
					}, 5000);
			    },
			   error: function () {
				   errorMessage = '<span class="text-danger '+ currentElement.attr('name') + '">There was an error updating the field </span>';
					currentElement.closest('.form-group').append(errorMessage);
					$('.' + currentElement.attr('name')).delay(3000).hide('slow');
					setTimeout(function () {
						$('.' + currentElement.attr('name')).remove();
					}, 5000);
			   }
			});
		});	
		
		$('#save-pmrb-table').click(function () {
			var pmrb_json_table = [];
			var hasErrors = false;
			for (var i = 0; i <= 9; i ++) {
				if (i < 9) {
					if ($('#pmrb-p1-' + i).valid() == false) hasErrors = true;
				}
				if ($('#pmrb-p2-' + i).valid() == false) hasErrors = true;
				if ($('#pmrb-m-' + i).valid() == false) hasErrors = true;
				if ($('#pmrb-r-' + i).valid() == false) hasErrors = true;
				if ($('#pmrb-b1-' + i).valid() == false) hasErrors = true;
				if ($('#pmrb-b2-' + i).valid() == false) hasErrors = true;
				
				
				if (hasErrors) {
					$('.pmrb-save-success')
						.show()
						.addClass('text-danger')
						.html('The table was not saved due to errors')
						.delay(3000)
						.fadeOut('slow');
					$('.form-control').removeClass('error');
					$('label.error').remove();
					
					return false;
				}
				
				if (i < 9) {
					pmrb_p_1 = $('#pmrb-p1-' + i).val();
				}
				else {
					pmrb_p_1 = "";
				}
				
				pmrb_json_table.push({
					"pmrb_p_1"  : pmrb_p_1,
					"pmrb_p_2"  : $('#pmrb-p2-' + i).val(),
					"pmrb_m"  : $('#pmrb-m-' + i).val(),
					"pmrb_r"  : $('#pmrb-r-' + i).val(),
					"pmrb_b1" : $('#pmrb-b1-' + i).val(),
					"pmrb_b2" : $('#pmrb-b2-' + i).val()
					
				});
			}
			
			$.ajax({
				method: 'PUT',
				url: '<?php echo route('admin.general.globals.update', $globals->id) ?>',
				data: { "pmrb_table": JSON.stringify(pmrb_json_table) },
				success: function () {
					$('.pmrb-save-success')
						.removeClass('text-danger')
						.show()
						.html("The table was saved successfuly")
						.delay(3000)
						.fadeOut('slow');
				}
			});
			
		});
	});
</script>
@endsection
