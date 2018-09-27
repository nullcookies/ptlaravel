<!DOCTYPE html>
<html>
<head>
	<title>CRE Photos</title>
	 <link rel="stylesheet" href="{{asset('/css/bootstrap.min.css')}}"/>
	 <script type="text/javascript" src="{{asset('/js/jquery.min.js')}}"></script>
	 <script type="text/javascript" src="{{asset('/js/bootstrap.min.js')}}"></script>
	 <style type="text/css">
	 	.hide-bullets {
    list-style:none;
    margin-left: -40px;
    margin-top:20px;
}

.thumbnail {
    padding: 0;
}

.carousel-inner>.item>img, .carousel-inner>.item>a>img {
    width: 100%;
}
	 </style>
</head>
<body>

<div class="container">
	<h2>Images <small>CRE: {{$cre_id}}</small></h2>
    <div id="main_area">

        <!-- Slider -->
        <div class="row">
            <div class="col-sm-6" id="slider-thumbs">
                <!-- Bottom switcher of slider -->
                <ul class="hide-bullets">
                @if(!isset($cre_images))
                	<h1>No images to show</h1>
                @endif
                @if(isset($cre_images))
                	@if(count($cre_images)==0)
                    <h3>No image to show..</h3>
                    @endif
                    <?php $i=0;?>
                	
                    @foreach($cre_images as $c)

                		<li class="col-sm-3">
                			<a class="thumbnail" id="carousel-selector-{{$i}}">
                			<img src="{{asset('images/cre/'.$cre_id.'/'.$c)}}">
                			</a>
                		</li>
                	@endforeach
                @endif
                   
                </ul>
            </div>
            <div class="col-sm-6">
                <div class="col-xs-12" id="slider">
                    <!-- Top part of the slider -->
                    <div class="row">
                        <div class="col-sm-12" id="carousel-bounding-box">
                            <div class="carousel slide" id="creCarousel">
                                <!-- Carousel items -->
                                <div class="carousel-inner">
                                	@if(isset($cre_images))
                                		<?php $j=0;
                                		$active='';
                                			if ($j==0) {
                                				$active="active";
                                			}
                                		?>

                                		@foreach($cre_images as $c)
                                			<div class="{{$active}} item" date-slide-number="{{$j}}">
                                				<img src="{{asset('images/cre/'.$cre_id.'/'.$c)}}">
                                			</div>
                                		@endforeach
                                	@endif
                                </div>
                                <!-- Carousel nav -->
                                <a class="left carousel-control" href="#creCarousel" role="button" data-slide="prev">
                                    <span class="glyphicon glyphicon-chevron-left"></span>
                                </a>
                                <a class="right carousel-control" href="#creCarousel" role="button" data-slide="next">
                                    <span class="glyphicon glyphicon-chevron-right"></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/Slider-->
        </div>

    </div>
</div>
</body>
<script type="text/javascript">
	  jQuery(document).ready(function($) {
 
        $('#creCarousel').carousel({
                interval: 5000
        });
 
        //Handles the carousel thumbnails
        $('[id^=carousel-selector-]').click(function () {
        var id_selector = $(this).attr("id");
        try {
            var id = /-(\d+)$/.exec(id_selector)[1];
            console.log(id_selector, id);
            jQuery('#creCarousel').carousel(parseInt(id));
        } catch (e) {
            console.log('Regex failed!', e);
        }
    });
        // When the carousel slides, auto update the text
        $('#creCarousel').on('slid.bs.carousel', function (e) {
                 var id = $('.item.active').data('slide-number');
                $('#carousel-text').html($('#slide-content-'+id).html());
        });
});
</script>
</html>