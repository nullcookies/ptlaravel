<h2>Documents</h2>
<div class="statement" style="">
	<h3 style="font-family: sans-serif">Receipts/Tax Invoices</h3>
	<span class="row">{{$name or ''}}</span>
	<div class="ym">
		{{--*/ $y = 1; $index = 0;/*--}}

		<?php if((is_null($myreturn)) || ($current_year == 0)){ $carbon = new Carbon();?>
            <div style="margin: 5px;">
				<span style="font-family: sans-serif;font-size: large;">
					{{date('Y')}}{{':'}}</span>
				@for($i = 0,$carbon->month = 1; $i < 12; $i++,
					$carbon->addMonth())
					<button class="btn-disable btn btn-sm primary-btn" disabled>
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
					<span style="font-family: sans-serif;font-size: large;">{{$created_at->year}}{{':'}}</span>
					@for($i = 0,$carbon->month = 1; $i < 12; $i++,$carbon->addMonth())
						@if(in_array($carbon->month, $m) )
							<button class="btn-enable btn btn-sm primary-btn" 
									onclick="statement({{$id}}{{','}}{{$created_at->year}}{{','}}{{$carbon->month}});">
								<span id="h{{$created_at->year}}-{{$carbon->month}}">{{$carbon->format('M')}}</span>
								<span style="display: none;" id="i{{$created_at->year}}-{{$carbon->month}}">...</span>
								</i>
							</button>
							{{--*/ if($index < count($m) - 1)$month = $m[++$index]; /*--}}
						@else
							<button class="btn-disable btn btn-sm primary-btn {{$i}}" disabled>
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
