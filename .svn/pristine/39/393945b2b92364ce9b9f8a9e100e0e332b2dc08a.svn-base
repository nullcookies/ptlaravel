@extends('common.default')
@section('extra-links')
{{--  <link rel="stylesheet" type="text/css" href="{{asset('css/inventory/inventory.css')}}"> --}}
<style type="text/css">

.text{
	font-size: 1.2em;
	text-align: center;
}
.panel{
	border: 2px solid black;
}
.productbox{
	padding-left: 10px;
}
.name{
	    width:100%;
    height:2.9em;
    display:block;
    border:1px solid red;
    padding:10px;
    overflow:hidden;
}
.text:before{
	content: "\00a0";
}
	.no-display{
		display: none
	}

	.display{
		display: visible;
		color:red !important	;
		size:2.2em;
		font-weight: 100;
	}
.warning{
	border: 4px solid red !important;
	font-weight: 400;
	color: red;
}
h4{
	text-align: center;
}
table {
  border-spacing: 10px;
}
</style>
@stop
@section('content')

{{-- NEW CODE --}}
<div class="container">
	<div class="col-xs-1"> </div>
	<div class="col-xs-11">
		<div class="row"> <h2>Inventory Update</h2></div>
		<div class="row"> <hr></div>

		{{-- One CAT BOX --}}
		<div class="row" id="singlecatbox">
			<div class="col-xs-6">
				<div class="panel">
					<div class="col-xs-6" id="sc_img"> 
						{{-- Image --}}
						<div class="panel-body">
						<img src="http://placehold.it/460x250/e67e22/ffffff&text=Subcat" class="img img-responsive">
						</div>
					</div>
					<div class="col-xs-6" id="sc_info">
						{{-- Infor --}}
						@foreach($subcats as $s)
						<table class="table" id="sub_{{$s->id}}" style="display:none">
							<tr>
								<td><h3>Category</h3></td>
								{{-- <td></td> --}}
								<td><h3>{{ucfirst($cat_name)}} </h3></td>
							</tr>
							<tr>
								<td><h4>Subcategory</h4></td>
								<td><h4 id="subcatname">{{$s->name}}</h4></td>
							</tr>
							<tr>
								<td><h4>Item</h4></td>
								<td><h4>Quantity</h4></td>
							</tr>
							<tr>
								<td><h4></h4></td>
								<td><h4></h4></td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="row" id="catbox">
			@foreach($subcats as $s)
				<div class="col-md-3">
					<div class="panel">
						<a href="{{url('inventory/update/'.$s->id)}}" id="s_{{$s->id}}" rel="c_{{$s->id}}"><img src="{{asset('images/.$s->logo')}}" alt="{{$s->name}}" class="img-responsive"> </a>
					</div>
				</div>
		@endforeach

		</div>
	</div>
	
</div>

@stop