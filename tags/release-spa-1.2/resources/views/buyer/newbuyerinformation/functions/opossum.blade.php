<h2>OPOSsum</h2>
<div class="col-sm-2">
	<b>Select Terminal</b>
</div>
<div class="col-sm-3">
	<select class="form-control" id="terminals">
		@foreach($terminals as $terminal)
                <option value="{{$terminal->terminal_id}}">{{$terminal->terminal_id}} | {{$terminal->name}}</option>
                @endforeach
	</select>
</div>
<div class="col-sm-2">
	<a href="javascript:void(0)" class='btn btn-info stockgo' id="opossum_button" style="background-color: forestgreen; border-color: #747450; color: white;">Opossum</a>
</div>


<script>

$(function(){
    $("#opossum_button").on("click",function(){
        var terminal_id=$("#terminals").val();
        if(terminal_id!=null || terminal_id != undefined){
        window.open('{{url("/opossum")}}/'+terminal_id, '_blank');
    }
    
    })
})
</script>
