 <style type="text/css">
 	.purple{
 		background-color:purple !important;
 	}
 </style>
<div class="row">
 
<div class="col-sm-12">
<span style="width: 200px;font-size:2em;font-weight: bold">Order ID</span>

<span class="pull-right" style="font-size:2em;">{{$poid}}</span>
</div>
</div>
{{-- <p>&nbsp;</p> --}}
@if(!is_null($user) && count($user) > 0)
		
<!--Rec-->
<div class="panel panel-primary">

	<div class="panel-heading purple">
		<h3 class="panel-title"><i class="fa fa-2x"></i>&nbsp; Recipient</h3>
	</div>
	<div class="panel-body">
		<table class="table">
		<tr>
			<td><i class="fa fa-user "></i>&nbsp;Name</td>
			<td>{{$user->name}}</td>
			<td><i class="fa fa-globe "></i>&nbsp;Country</td>
			<td>{{$user->country or 'Malaysia'}}</td>
		</tr>
		<tr>
			<td><i class="fa fa-phone "></i>&nbsp;Contact</td>
			<td>{{$user->phone}}</td>
			<td><i class="fa fa-map-marker"></i>&nbsp;State</td>
			<td>{{$user->state }}</td>
		</tr>
		<tr >
			<td><i class="fa fa-location-arrow "></i>&nbsp;Address</td>
			<td colspan="1">{{$user->line1}}<br>
				{{$user->line2}}<br>
				{{$user->line3}}
			</td>
			<td><i class="fa fa-thumb-tack"></i>&nbsp;City</td>
			<td>{{$user->city }}</td>

		</tr>
		</table>
	</div>
</div>  

@endif

@if(!is_null($usersender) && count($usersender) > 0)
<div class="panel panel-primary" style="width: 100% !important;padding: 0px !important;margin: 0px!important;">

      <div class="panel-heading purple">
        <h3 class="panel-title"><i class="fa fa-2x"></i>&nbsp;Sender</h3>
      </div>
      <div class="panel-body">
     	<table class="table">
     		<tr>
     			<td><i class="fa fa-user "></i>&nbsp;Name</td>
     			<td>{{$usersender->name}}</td>
     			<td><i class="fa fa-globe "></i>&nbsp;Country</td>
     			<td>{{$usersender->country or 'Malaysia'}}</td>
     		</tr>
     		<tr>
     			<td><i class="fa fa-phone "></i>&nbsp;Contact</td>
     			<td>{{$usersender->phone}}</td>
     			<td><i class="fa fa-map-marker"></i>&nbsp;State</td>
     			<td>{{$usersender->state }}</td>
     		</tr>
     		<tr >
     			<td><i class="fa fa-location-arrow "></i>&nbsp;Address</td>
     			<td colspan="1">{{$usersender->line1}}<br>
     				{{$usersender->line2}}<br>
     				{{$usersender->line3}}
     			</td>
     			<td><i class="fa fa-thumb-tack"></i>&nbsp;City</td>
     			<td>{{$usersender->city }}</td>

     		</tr>
     	</table>
      </div>

</div>
@endif

@if(!is_null($usersender) && count($usersender) > 0)
<div class="panel panel-primary" style="width: 100% !important;padding: 0px !important;margin: 0px!important;">

      <div class="panel-heading purple">
        <h3 class="panel-title"><i class="fa fa-2x"></i>&nbsp;Measurement</h3>
      </div>
      <div class="panel-body">
     	<table class="table">
     		<tr>
     			<td><i class="fa "></i>&nbsp;Weight</td>
     			<td>{{$weight}}</td>
     			<td><i class="fa"></i>&nbsp;Volumetric Weight</td>
     			<td>{{$vweight}}</td>
     		</tr>

     	</table>
      </div>

</div>
@endif
	{{-- 	<div class="col-md-12">
			<h3>Measures</h3>
		</div>
		<div class="col-md-6">
			<div class="form-group">
			  <strong class="col-sm-4">Weight:</strong>
			  <div class="col-sm-8">
				<span style="font-size: {{$wsize}}; font-weight: {{$wweight}};">{{$weight}}</span>
			  </div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
			  <strong class="col-sm-7">Volumetric Weight:</strong>
			  <div class="col-sm-5">
				<span style="font-size: {{$vwsize}}; font-weight: {{$vwweight}};">{{$vweight}}</span>
			  </div>
			</div> --}}
		{{-- </div>		 --}}
	 {{-- </form> --}}
	{{-- </div>	
</div> --}}