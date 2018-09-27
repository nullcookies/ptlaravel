@extends('common.default')
@section('content')
@include('common.sellermenu')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
        <?php
        	$title="Buying Order"
        ?>
        @include('buyer.newbuyerinformation.orders')
        </div>
    </div>
</div>
@stop