<style>
.btn-enable{background: lightblue;}
.btn-disable{background: #4d4d4d;color:white;}
</style>
<h2>Sales Memo</h2>
<div class="col-sm-2">
	<b>Location</b>
</div>
<div class="col-sm-3">
	<select id="saleslocation">
		@foreach($locations as $location)
			<option value="{{$location->id}}">{{$location->location}}</option>
		@endforeach
	</select>
</div>
<div class="col-sm-2">
	<a href="javascript:void(0)" class='btn btn-info salesgo pull-right' style="background-color: #7474FD; border-color: #747450; color: black; margin-top: 5px;">Sales Memo</a>
</div>
<div class="clearfix"></div>
<div class="statementmemo" style="">
	<h3 style="font-family: sans-serif">Sales Memo</h3>
	<div class="ym">
		{{--*/ $y = 1; $index = 0;/*--}}

		<?php if((is_null($myreturn)) || ($current_year == 0)){ $carbon = new Carbon();?>
            <div style="margin: 5px;">
				<span style="font-family: sans-serif;font-size: large;">
					{{date('Y')}}{{':'}}</span><br>
				@for($i = 0,$carbon->month = 1; $i < 12; $i++,
					$carbon->addMonth())
					@if($i == 6)
							<br>
						@endif
					<button class="btn-disable btn btn-sm primary-btn" style="width: 15%; @if($i >= 6) margin-top: 5px; @endif" disabled>
						{{$carbon->format('M')}}
					</button>
				@endfor
            </div>
        <?php } ?>
         
		@foreach($myreturn as $returned)
			{{--*/ $created_at = new Carbon\Carbon($returned->created_at); $carbon = new Carbon();
			$m = $years[$created_at->year]; sort($m);
			$month = $m[0]; $index = 0;/*--}}

			@if($y != $created_at->year)
				<div style="margin: 5px;">
					<span style="font-family: sans-serif;font-size: large;">{{$created_at->year}}</span>
					<br>
					@for($i = 0,$carbon->month = 1; $i < 12; $i++,$carbon->addMonth())
						@if($i == 6)
							<br>
						@endif
						@if(in_array($carbon->month, $m) )
							<button class="btn-enable btn btn-sm primary-btn"  style="width: 15%; @if($i >= 6) margin-top: 5px; @endif"
									onclick="statementmemo({{$id}}{{','}}{{$created_at->year}}{{','}}{{$carbon->month}});">
								<span id="hsa{{$created_at->year}}-{{$carbon->month}}">{{$carbon->format('M')}}</span>
								<span style="display: none;" id="isa{{$created_at->year}}-{{$carbon->month}}">...</span>
								</i>
							</button>
							{{--*/ if($index < count($m) - 1)$month = $m[++$index]; /*--}}
						@else
							<button class="btn-disable btn btn-sm primary-btn {{$i}}" style="width: 15%; @if($i >= 6) margin-top: 5px; @endif" disabled>
								{{$carbon->format('M')}}
							</button>
						@endif
					@endfor
				</div>
			@endif
			{{--*/ $y = $created_at->year; /*--}}
			<?php $i++;?>
		@endforeach
	</div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
		$("#saleslocation").select2();
		$(document).delegate( '.salesgo', "click",function (event) {
			var userid = $("#fairmerchant").val();
			var fairrecruiter = $("#fairrecruiter").val();
			var saleslocation = $("#saleslocation").val();
			window.location = JS_BASE_URL + '/salesmemo/' + userid + '/' + fairrecruiter + '/' + saleslocation;	
		});	
    });
</script>	
