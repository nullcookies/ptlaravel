<h2>Stock Take</h2>
<div class="col-sm-2">
	<b>Station Location</b>
</div>
<div class="col-sm-3">
	<select id="stocklocation">
		@foreach($locations as $location)
			<option value="{{$location->id}}">{{$location->location}}</option>
		@endforeach
	</select>
</div>
<div class="col-sm-2">
	<a href="javascript:void(0)" class='btn btn-info stockgo' style="background-color: #7474FD; border-color: #747450; color: black;">Stock Take</a>
</div>
<script type="text/javascript">
    $(document).ready(function(){
		$("#stocklocation").select2();
		$(document).delegate( '.stockgo', "click",function (event) {
			var userid = $("#fairmerchant").val();
			var fairrecruiter = $("#fairrecruiter").val();
			var stocklocation = $("#stocklocation").val();
			window.open(JS_BASE_URL + '/stocktake/' + userid + '/' + fairrecruiter + '/' + stocklocation, '_blank');	
		});	
    });
</script>	
