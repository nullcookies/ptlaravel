@extends("common.default")
@section("content")
<style>
.btn-enable{background: lightblue;}
.btn-disable{background: #4d4d4d;color:white;}
</style>
<h2>Documents</h2>
<div class="statement" style="min-height: 380px;">
	<h4 style="font-family: sans-serif">Buyer Monthly Receipts/Tax Invoices</h4>
	<span class="row">{{$name or ''}}</span>
	<div class="ym">
		{{--*/ $y = 1; $index = 0;/*--}}

		<?php if((is_null($myreturn)) || ($current_year == 0)){ $carbon = new Carbon();?>
            <div style="margin: 5px;">
				<span style="font-family: sans-serif;font-size: large;">
					{{date('Y')}}{{':'}}</span>
					<br>
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
					<span style="font-family: sans-serif;font-size: large;">{{$created_at->year}}{{':'}}</span>
					<br>
					@for($i = 0,$carbon->month = 1; $i < 12; $i++,$carbon->addMonth())
						@if($i == 6)
							<br>
						@endif
						@if(in_array($carbon->month, $m) )
							<button class="btn-enable btn btn-sm primary-btn" style="width: 15%; @if($i >= 6) margin-top: 5px; @endif" 
									onclick="statement({{$id}}{{','}}{{$created_at->year}}{{','}}{{$carbon->month}});">
								<span id="h{{$created_at->year}}-{{$carbon->month}}">{{$carbon->format('M')}}</span>
								<span style="display: none;" id="i{{$created_at->year}}-{{$carbon->month}}">...</span>
								</i>
							</button>
							{{--*/ if($index < count($m) - 1)$month = $m[++$index]; /*--}}
						@else
							<button class="btn-disable btn btn-sm primary-btn {{$i}}" style="width: 15%;@if($i >= 6) margin-top: 5px; @endif"   disabled>
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
<div class="modal fade" id="stModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document" style="width:98%">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h2 class="modal-title" id="myModalLabel2">Remarks</h2>
			</div>
			<div class="modal-body" id="stmodalbody" style="margin-left: 0px !important;">
			<textarea class="form-control" id="long-remark"></textarea>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal" id="initajax" style="min-width: 60px;">Close</button>
			</div>
		</div>
	</div>
</div>
<script>
function statement(id,year,month) {
	//get the merchant data from the backend and render on the modal
	console.log(month);
	$("#h" + year + "-" + month).hide();
	$("#i" + year + "-" + month).show();
	$.ajax({
		type: "POST",
		url: JS_BASE_URL+"/statement/buyerdetail",
		data: { id:id,year:year,month:month },
		beforeSend: function(){},
		success: function(response){
			$('#stmodalbody').html(response);
			$('#stModal').modal('toggle');
			$("#h" + year + "-" + month).show();
			$("#i" + year + "-" + month).hide();
		}
	});
}
</script>
@stop