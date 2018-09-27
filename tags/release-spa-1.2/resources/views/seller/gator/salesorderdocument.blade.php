<?php
use App\Classes;
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\IdController;
?>
@extends("common.default")
@section('content')
@include("common.sellermenu")

<div class="modal-content">

	<div style="padding: 0px;" class="modal-body">
	<div id="sodisp">
@include("seller.gator.saleorder")
					</div>

				</div>
					<br>
					<br>
				
			</div>

		

	@yield("left_sidebar_scripts")
@stop
