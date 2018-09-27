<h2>Fair Mode</h2>
<div class="col-sm-2">
	<b>Fair Location</b>
</div>
<div class="col-sm-3">
	<select id="fairlocation">
		<option value="0">Choose Location</option>
		@foreach($locations as $location)
			<option value="{{$location->id}}">{{$location->location}}</option>
		@endforeach
	</select>
</div>
<div class="col-sm-2">
	<a href="javascript:void(0)" class='btn btn-info fairgo pull-right' style="background-color: #CFFD74; border-color: #CFFD50; color: black; margin-top: 5px;">Fair Mode</a>
</div>
<script type="text/javascript">
    $(document).ready(function(){
		console.log("Hello!")
		$("#fairlocation").select2();
			$(document).delegate( '.fairgo', "click",function (event) {
				var userid = $("#fairmerchant").val();
				var fairrecruiter = $("#fairrecruiter").val();
				window.open(JS_BASE_URL + '/fairmode/' + userid + '/' + fairrecruiter);	
			});	
    });
</script>	
