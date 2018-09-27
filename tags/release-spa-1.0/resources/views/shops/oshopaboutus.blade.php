@extends("common.default")

@section("content")

   <section class="categorylist">

        <img width="100%" class="width-100 img-responsive"
		@if (isset($profile->signboard->image))
			src="{{ asset('images/signboard/'.$profile->signboard->id .
				'/' .$profile->signboard->image) }}"
		@else
			src="#"
		@endif
		alt="{{$merchant->oshop_name}}'s Signboard"/>

            <div class="container">
                <div class="row" style=" margin-top: 10px; margin-bottom: 10px;">
                    <div  class="navbar-collapse collapse ">
                        <ul class="nav navbar-nav">
                     <!--       <li><a style="color: #000; font-size:25px;" href="/" class="active">About</a></li> -->
				<li><a style="color: #000; font-size:25px;" href="{{route('oshopaboutus',[$merchant->id])}}">About</a></li>
                       <!--     <li><a style="color: #000; font-size:25px;" href="#">Certificate</a></li> -->
<li><a style="color: #000; font-size:25px;" href="{{route('oshopcertificate',[$merchant->id])}}">Certificate</a></li>
                            <li><a style="color: #000; font-size:25px;" href="#">Dealer</a></li>
                           <!-- <li><a style="color: #000; font-size:25px;" href="#">Group</a></li>
                            <li><a style="color: #000; font-size:25px;" href="#">OEM</a></li> -->
 <li><a style="color: #000; font-size:25px;" href="{{route('owarehouse',[$merchant->id])}}">O-Warehouse</a></li>
                        <li><a style="color: #000; font-size:25px;" href="{{route('oshopoem',[$merchant->id])}}">OEM</a></li>
                        </ul>
                        <ul class="nav navbar-nav pull-right">
                            <li ><button style="background:rgb(0,99,98);border:none; padding: 10px;margin-top:5px" class=""><a style="color:white; text-decoration:none" href=""><strong><i class="fa fa-link fa-lg"></i></strong>&nbsp;&nbsp;&nbsp;Auto Link&nbsp;&nbsp;&nbsp;&nbsp;</a></button></li>
                            <li><a style="color:#000; font-size: 23px;" herf="">OFFICIAL SHOP</a></li>
                            <li  style="color:white; margin-top:15px"><img style="width:30px; height:20px" src="{{ asset('images/malaysia.png') }}">&nbsp;</li>
                            <li  style="background:rgb(224,40,120); color:white; margin-top:17px">&nbsp;&nbsp; &nbsp;Like &nbsp; &nbsp;&nbsp; &nbsp;</li>
                        </ul>
                    </div>
                </div>

                <div class="row" style="margin-top:10px; margin-bottom: 10px">
                        <img class="img-responsive" src="{{ asset('images/ads/26/ads1.jpg') }}" alt="the-leather-house" />
                </div>
        </div><!-- End Container -->

        <div class="oshop-aboutus-content" style="margin-top:30px;"><!--Begin main cotainer-->
        <div class="container padding-20">
            <div class="row">

                <div style="color:black;" class="page-header">
                    <h3>About Us</h3>
                </div>
            </div>
            <br/>
            <div class="row nomargin">
                <div class="col-md-12 padding-inner">
                    <p>
                        <span class="paragraph-header" style="color:black;font-size:15px;">Our History</span><br/>
                    </p>
                    <br/>
                    
                   <span style="font-size:15px;"> {!! $merchant->history !!} </span>

                </div>
            </div>
            <div class="row nopadding">
                <hr />
            </div>

            <div class="row nomargin">
                <div style="color:black;" class="col-md-12 padding-inner;">
                    <p>
                        <span class="paragraph-header" style="color:black;font-size:15px;">Description</span>
                    </p>
                    <br/>
                    <span style="font-size:15px;">{!! $merchant->description !!}</span>
                </div>
            </div>

            <br>

			<!-- This is the descimage.descphoto -->
            <div class="row">
            <img width="100%"
			@if (isset($profile->vbanner->image))
				src="{{ asset('images/vbanner/'.$profile->vbanner->id.
				'/'.$profile->vbanner->image) }}"
			@else
				src="#"
			@endif
			alt="{{$merchant->oshop_name}}'s DescImage"/>
            </div>

            <div class="row nopadding">
                <hr />
            </div>
            <div class="row nopadding padding-inner">
                <div class="col-md-12">
                    <p><span class="paragraph-header">Our Team</span></p>
                </div>

                @foreach ($merchant->teams as $team)
                    <div class="col-md-2">
                        <img src="{{ asset('images/team/'.$team->id."/".$team->photo) }}"
						alt="{{$team->full_name}}" width="100%"/>
                    </div>           

                    <div class="col-md-10 nopadding">
                        <h4 style = "color:black;">{{ $team->full_name }}</h4><br/>
                        <span style="color:grey;" class="fontStyle">{{ $team->post }}</span>
                        <p class="padding-top-10">
                           <span style ="color:black;font-size:15px;"> "{{ $team->description }}"</span>
                        </p>
                    </div>
                    <div class="clearfix"></div>
                @endforeach
                <br>
            </div>
        </div>

    </div><!--End main cotainer-->
    <br/><br/>

    </section>


@stop
