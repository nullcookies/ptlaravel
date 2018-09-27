@extends("common.default")

@section("content")

    <div class="row">

        <div class="col-sm-12 text-center">
        <!-- <img alt="Profile Logo" src="images/Al-halabi.jpg" width="100%"> -->
		<!-- <img alt="Profile Logo" src="/images/kleensocert.jpg" width="100%"> -->
        <img width="100%" class="width-100 img-responsive" src="{{ asset('images/signboard/'.$profile->signboard->id .'/' .$profile->signboard->image) }}" alt="the-leather-house" />


        </div>
        <div class="clearfix"></div>
    </div>

   <!--<section class="oshop-certificate-body"> -->
	    <section class="categorylist">

        <div class="profile-setting-navigation">
            <nav class="navbar navbar-static-top">
                <div class="container">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#profile-setting-navbar" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand hidden" href="#"></a>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="profile-setting-navbar">
                        <ul class="nav navbar-nav">
                            <!--<li class="active"><a style="color: #000; font-size:25px;" href="/profilesettingaboutus">About</a></li>
                            <li><a style="color: #000; font-size:25px;" href="/profilesettingcertificate">Certificate</a></li> 
                            <li><a style="color: #000; font-size:25px;" href="#">Supplier</a></li>-->
							<li class="active"><a style="color: #000; font-size:25px;" href="#">About</a></li>
                            <li><a style="color: #000; font-size:25px;" href="#">Certificate</a></li>
							<li><a style="color: #000; font-size:25px;" href="#">Dealer</a></li>
							<li><a style="color: #000; font-size:25px;" href="#">O-Warehouse</a></li>
							 <li><a style="color: #000; font-size:25px;" href="#">OEM</a></li>
                        </ul>

                        <ul class="nav navbar-nav navbar-right">
                           <!-- <li><a href="#" class="btn btn-green"><i class="fa fa-lg fa-link"></i> AutoLink</a></li>
                            <li><a style="color:#000; font-size: 23px; href="#"><strong><em>OFFICIAL SHOP</em></strong></a></li>
                            <li><a href="#"><img src="images/malaysia.png" width="100%" alt="flag"></a></li> -->
							<li ><button style="background:rgb(0,99,98);border:none; padding: 10px;margin-top:5px" class=""><a style="color:white; text-decoration:none" href=""><strong><i class="fa fa-link fa-lg"></i></strong>&nbsp;&nbsp;&nbsp;Auto Link&nbsp;&nbsp;&nbsp;&nbsp;</a></button></li>
                            <li><a style="color:#000; font-size: 23px;margin-top:5px" herf="">OFFICIAL SHOP</a></li>
							<li  style="color:white; margin-top:15px"><img style="width:30px; height:20px" src="{{ asset('images/malaysia.png') }}">&nbsp;</li>
                            <!--<li><a href="#" class="btn btn-pink">Like</a></li> -->
							<li  style="background:rgb(224,40,120); color:white; margin-top:17px">&nbsp;&nbsp; &nbsp;Like &nbsp; &nbsp;&nbsp; &nbsp;</li>

                        </ul>
                    </div><!-- /.navbar-collapse -->
                </div><!-- /.container-fluid -->
            </nav>

        </div>


        <div class="oshop-certificate-content"><!--Begin main cotainer-->
            <div class="container">

                <div class="row nopadding padding-inner">

                    <?php
                    $numItems = count($certificates); $i = 0; ?>
                    @foreach($certificates as $certificate)

                        <div class="col-md-2">
                           <!-- <img src="images/{{ $certificate->logo }}" alt="" width="100%"/> -->
<img class="img-responsive" src="/images/{{ $certificate->logo }}" alt="" />
                        </div>
                        <div class="col-md-10 nopadding">
                            <div class="padding-top-30">
                                <h4 style="color:black;" class="padding-top-10">{{ $certificate->name }} </h4><br/>
                                <span class="fontStyle">{{ $certificate->awarded }}</span>
                                <p class="padding-top-10">
                                    *{{ $certificate->description }}.
                                </p>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <br>
                        @if(++$i !== $numItems)
                                <div class="col-md-12"><hr /></div>
                        @endif

                    @endforeach

                </div>
            </div>
        </div><!--End main cotainer-->
    </section>

@stop
