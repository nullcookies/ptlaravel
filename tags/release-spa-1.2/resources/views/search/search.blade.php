@extends('common.default')
<?php
use App\Http\Controllers\IdController;
use App\Models\Product;
?>
@section('content')
<style type="text/css">
    .container { margin-top: 20px; }
.mb20 { margin-bottom: 20px; } 

hgroup { padding-left: 15px; border-bottom: 1px solid #ccc; }
hgroup h1 { font: 500 normal 1.625em "Roboto",Arial,Verdana,sans-serif; color: #2a3644; margin-top: 0; line-height: 1.15; }
hgroup h2.lead { font: normal normal 1.125em "Roboto",Arial,Verdana,sans-serif; color: #2a3644; margin: 0; padding-bottom: 10px; }

.search-result .thumbnail { border-radius: 0 !important; }
.search-result:first-child { margin-top: 0 !important; }
.search-result { margin-top: 20px; }
.search-result .col-md-2 { border-right: 1px dotted #ccc; min-height: 140px; }
.search-result ul { padding-left: 0 !important; list-style: none;  }
.search-result ul li { font: 400 normal .85em "Roboto",Arial,Verdana,sans-serif;  line-height: 30px; }
.search-result ul li i { padding-right: 5px; }
.search-result .col-md-7 { position: relative; }
.search-result h3 { font: 500 normal 1.375em "Roboto",Arial,Verdana,sans-serif; margin-top: 0 !important; margin-bottom: 10px !important; }
.search-result h3 > a, .search-result i { color: #248dc1 !important; }
.search-result p { font: normal normal 1.125em "Roboto",Arial,Verdana,sans-serif; } 
.search-result span.plus { position: absolute; right: 0; top: 126px; }
.search-result span.plus a { background-color: #248dc1; padding: 5px 5px 3px 5px; }
.search-result span.plus a:hover { background-color: #414141; }
.search-result span.plus a i { color: #fff !important; }
.search-result span.border { display: block; width: 97%; margin: 0 15px; border-bottom: 1px dotted #ccc; }
.fontsize{ font-size: 18px;}
</style>

<div class="container">

    <hgroup class="mb20">
        <h1>Search Results</h1>
        <h2 class="lead"><strong class="text-danger">{{sizeof($matchedProductIds)}}</strong> results were found for the search for <strong class="text-danger">{{$query}}</strong></h2>                               
    </hgroup>
	<?php $page = 0; ?>
	<?php $products = 0; ?>
    <section class="col-xs-12 col-sm-6 col-md-12">
        @foreach($matchedProductIds as $pid)
            <?php $p=Product::find($pid);
            $src="images/product/".$p->parent_id."/thumb/".$p->thumb_photo;
           
            ?>
			@if($products == 0) <div id="page{{$page}}" class="pages" @if($page > 0) style="display: none;" @endif> @endif
			 <article class="search-result row">
				<div class="col-xs-12 col-sm-12 col-md-3">
					<a href="{{url('productconsumer',$pid)}}" title="{{$p->name}}" class="thumbnail" target="_blank"><img src="{{$src}}" alt="Product Image" /></a>
				</div>

				<div class="col-xs-12 col-sm-12 col-md-7 excerpet">
					<h3><a href="{{url('productconsumer',$pid)}}" title="" target="_blank">{{$p->name}}</a></h3><p>{{$p->description}}</p>                        
		  
				</div>
				<span class="clearfix borda"></span>
			</article>
			<?php $products++; ?>
			@if($products >=6 )
				<?php $products = 0; ?>
				<?php $page++; ?>
				</div>
			@endif
        @endforeach
         @if($products > 0 )
				</div>
		 @endif
		<center >
			@if($page > 0 )
				<ul class="pagination">
					<li><a href="javascript:void(0)" class="first_page fontsize"><<</a></li>
					<li><a href="javascript:void(0)" class="prev_page fontsize">< Previous</a></li>
					<li><span  class="last_ellipsis fontsize" style="display: none;">...</span><li>
					@for($pp = 0; $pp <= $page; $pp++)
						@if($pp > 10 && $pp == $page)
							<li><span  class="ellipsis fontsize">...</span><li>
						@endif
							<li><a href="javascript:void(0)" id="apage{{ $pp }}" rel="{{$pp}}" class="fontsize apage @if($pp == 0) selecteda @endif" @if($pp >= 10 && $pp != $page ) style="display: none;" @endif>{{$pp + 1}}</a></li>						
					@endfor
					<li><a href="javascript:void(0)" class="next_page fontsize"> Next ></a></li>
					<li><a href="javascript:void(0)" class="last_page fontsize">>></a></li>
				</ul>
	
				<input type="hidden" value="{{$page}}" id="page_count" />
				<input type="hidden" value="0" id="current_page" />
			@endif
		</center>
    </section>
</div>
@stop



