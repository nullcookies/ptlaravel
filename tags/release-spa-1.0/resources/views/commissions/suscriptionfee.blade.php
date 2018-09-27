@extends("common.default")

@section("content")

<div class="container" style="margin-top:30px;">
    @include('admin/panelHeading')

    <h2>Subscription Fee Commission</h2>
    <form action="/admin/commission/savesuscriptionfee" method="POST">
	    <div class="row">
		    <div class="col-xs-6" style="margin-top:10px">
				<div class="row">
			        <div class="col-xs-8" style="">
			            <label class="control-label margin-top">
						Merchant Annual Subscription Fee ({{$currentCurrency}})</label>
			        </div>
			        <div class="col-xs-4" style="margin-top: 10px;">
			        	<input type="text" required
							name="merchant_annual_subscription_fee"
							class="text-right form-control col-xs-12"
							value="{{number_format($fees['mfee']/100,2)}}">
			        </div>
			    </div>
 				<div class="row">
			        <div class="col-xs-8" style="">
			            <label class="control-label margin-top">
						Station Annual Subscription Fee ({{$currentCurrency}})</label>
			        </div>
			        <div class="col-xs-4" style="margin-top: 10px;">
			        	<input type="text" required
							name="station_annual_subscription_fee"
							class="text-right form-control col-xs-12"
							value="{{number_format($fees['sfee']/100,2)}}">
			        </div> 
				</div>
			    <div id="confirm" style="margin-top:20px; margin-bottom:40px; float: right;">
			        <input type="submit" class="btn btn-green btn-sm" value="Submit">
			    </div>
		    </div>
	    </div>
    </form>
</div>
<meta name="_token" content="{!! csrf_token() !!}"/>
<script type="text/javascript">
$(document).ready(function () {
	//
});
</script>
@stop
