<?php 
use App\Http\Controllers\IdController;
?>
	<div id="lstatement" class="tab-pane fade">
		<h2>Documents</h2>
		<?php $e=1;

		?>
		<div class="row">
			<div class=" col-sm-12">
				<?php 
// use App\Http\Controllers\IdController;

?>
<style>
	.statement{
		background: #e6e6e6;
		width: 100%;
		padding: 10px;
		margin: 0 auto;
		border: 2px solid #e6e6e6;
		border-radius: 25px;
	}
	.ym{background: #c6c6c6;width: 100%;margin: 0 auto;padding: 5px;border-radius: 25px;}
	.btn-enable{background: lightblue;}
	.btn-disable{background: #4d4d4d;color:white;}

</style>
<div class="statement" style="">

	<div class="ym">
		{{--*/ $y = 1; $index = 0;/*--}}

		<?php if((is_null($myreturn)) || ($current_year == 0)){ $carbon = new Carbon();?>
			<div style="margin: 5px;">
					<span style="font-family: sans-serif;font-size: large;">{{date('Y')}}{{':'}}</span>
					@for($i = 0,$carbon->month = 1; $i < 12; $i++,$carbon->addMonth())
							<button class="btn-disable btn btn-sm primary-btn" disabled>
								{{$carbon->format('M')}}
							</button>
					@endfor
			</div>
		<?php } ?>
		@foreach($myreturn as $returned)
			{{--*/ $created_at = new Carbon\Carbon($returned->created_at); $carbon = new Carbon();
			$m = $years[$created_at->year]; sort($m);$month = $m[0]; $index = 0;/*--}}
			@if($y != $created_at->year)
				<div style="margin: 5px;">
					<span style="font-family: sans-serif;font-size: large;">{{$created_at->year}}{{':'}}</span>
					@for($i = 0,$carbon->month = 1; $i < 12; $i++,$carbon->addMonth())
						@if($carbon->month === $month )
							<button class="btn-enable btn btn-sm primary-btn"
									onclick="statement({{$created_at->year}}{{','}}{{$carbon->month}});">
								{{$carbon->format('M')}}
							</button>
							{{--*/ if($index < count($m) - 1)$month = $m[++$index]; /*--}}
						@else
							<button class="btn-disable btn btn-sm primary-btn" disabled>
								{{$carbon->format('M')}}
							</button>
						@endif
					@endfor
				</div>
			@endif
			{{--*/ $y = $created_at->year; /*--}}
		@endforeach
	</div>
</div>




{{-- <script src="{{url('js/jquery.dataTables.min.js')}}"></script> --}}
<script>

	function statement(year,month) {
		var id = $("#lpeid").val();
		var url="{{url()}}"+"/l/"+month+"/"+year+"/"+id;
		window.open(url);
	}
</script>




			</div>
		</div>    
	</div>

<script type="text/javascript">
	function validateEmail(email) {
		var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return re.test(email);
	}

    $(document).ready(function(){
	

    });
</script>
