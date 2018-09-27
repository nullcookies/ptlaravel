<?php
$cf = new \App\lib\CommonFunction();
?>
<header>

    <!--Begin Logo Section -->
    <div class="top-header">
        <!--Begin Top Navigation-->
        <nav class="navbar navbar-inverse megamenu  navbar-static-top">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->

                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#top-menu">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <!-- Remove the Welcome User -->
                    <!-- <a class="navbar-brand" href="#">Welcome User!</a> -->
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->

                <div class="collapse navbar-collapse" id="top-menu">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="hide dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Language: English <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                @foreach($cf->getLanguage() as $lkey=>$lval)
                                    <li><a href="{{$lkey}}">{{$lval}}</a></li>
                                @endforeach
                            </ul>
                        </li>
                        <li class="hide dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Currency: MYR <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                @foreach($cf->getCurrency() as $ckey=>$cval)
                                    <li><a href="{{$ckey}}">{{$cval}}</a></li>
                                @endforeach
                            </ul>
                        </li>
                        <li><a href="{{url('buyerinformation')}}">My Page</a></li>
                        @if(!\Illuminate\Support\Facades\Auth::check())
                            <li>
                                <a href="{{url('buyerregistration')}}">SignUp</a>
                            </li>
                        @endif
                        <li>
                            @if(Auth::check())
                                <input type='hidden' value='1' id='loginConfirm'>
                                <a href="{{URL::to('auth/logout')}}">Logout</a>
                            @else
                                <a href="#" data-toggle="modal" data-target="#loginModal">Login</a>
                            @endif
                        </li>
                        <li>
                            <a href="#" data-toggle="modal"
                               data-target="#forgotModal">Forgot Password</a>
                        </li>
                        <li>
                            @if(Auth::check())
                                <a href="#">Welcome: {{Auth::user()->name == null ?
                                                        Auth::user()->first_name ." ".Auth::user()->last_name:
                                                        Auth::name}}
                                </a>
                            @endif
                        </li>
                    </ul>

                    <form class="navbar-form navbar-right" role="search">
                        <div class="form-group selectLang">
                            <label>Language: </label>
                            <select name="language" class="form-control">
                                @foreach($cf->getLanguage() as $lkey=>$lval)
                                    <option value="{{$lkey}}">{{$lval}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group selectCurr">
                            <label>Currency: </label>
                            <select id='currency' name="currency" class="form-control">
                                @foreach($cf->getCurrency() as $ckey=>$cval)
                                    <option value="{{$ckey}}">{{$cval}}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div><!-- /.navbar-collapse -->
            </div>
        </nav>
        <!--End Top Navigation-->
    </div>

    <div class="logo-header">
        <div class="container">
            <div class="row">
                <div class="col-sm-4 col-xs-6 logo-holder">
                    <a href="/"><img src="{{asset('images/logo.png')}}" class="img-responsive" alt="Logo"></a>
                </div>
                <div class="col-md-2 col-md-offset-6 col-sm-3 col-sm-offset-5 col-xs-6 cart-holder">
                    @if( Cart::totalItems() < 1)
                    <div class="cart">
                        <a href="{{URL::to('cart')}}" class='cart-link'> Cart is Empty  </a>
                        <i class="fa fa-shopping-cart"></i> <span class="badge badge-cart"> 0 </span>

                    </div>
                    @else
                    <div class="cart">
                        <a href="{{URL::to('cart')}}"> View Cart  </a>
                        <i class="fa fa-shopping-cart"></i> <span class="badge badge-cart"> {!! Cart::totalItems() !!} </span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!--Begin Top Navigation-->
    <nav class="navbar navbar-inverse megamenu  navbar-static-top">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->

            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#main-menu">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand hidden" href="#"></a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->

            {{--<form role="search" class="navbar-form navbar-right">--}}
            {{--<div class="input-group input-group-sm">--}}
            {{--<input type="text" placeholder="Search" class="form-control">--}}
            {{--<span class="input-group-btn">--}}
            {{--<button type="button" class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>--}}
            {{--</span>--}}
            {{--</div><!-- /input-group -->--}}
            {{--</form>--}}


            {!! Form::open(array('route' => 'search', 'class'=>'navbar-form navbar-right')) !!}
            <div class="input-group input-group-sm">
                {!! Form::text('search_key_word', null,array('required', 'class'=>'form-control','placeholder'=>'Search')) !!}
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span>
                    </button>
                </span>
            </div><!-- /input-group -->
            {!! Form::close() !!}


            <div class="collapse navbar-collapse" id="main-menu">
                <ul class="nav navbar-nav">
                    <li class="{{ $cf->set_active('/') }}"><a href="{{URL::to('/')}}">Home</a></li>
                    <li class="{{ $cf->set_active('category') }}"><a href="{{URL::to('/category')}}">Category</a></li>
                    <li class="{{ $cf->set_active('brand') }}"><a href="{{URL::to('/brand')}}">Brand</a></li>
                    <!-- change the title O Shop to O-Shop -->
                    <!-- <li class="{{ $cf->set_active('oshoplist') }}"><a href="/oshoplist">O Shop</a></li> -->
                    <li class="{{ $cf->set_active('oshoplist') }}"><a href="{{URL::to('/oshoplist')}}">O-Shop</a></li>
                    <li class="{{ $cf->set_active('SMM') }}"><a href="{{URL::to('/SMM')}}">SMM</a></li>
                    <li class="{{ $cf->set_active('owarehouselist') }}"><a href="{{URL::to('/owarehouselist')}}">O-Warehouse</a>

                    </li>

                    @if (Auth::check() && Auth::user()->hasRole('mer'))
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle"
                           data-toggle="dropdown" role="button"
                           aria-haspopup="true" aria-expanded="false">
                            Merchant<span class="caret"></span></a>

                        <ul class="dropdown-menu">
                            <li class="{{$cf->set_active('buyerinformation')}}">
                                <a href="{{route('edit-merchant')}}">
                                    Merchant Information</a>
                            </li>
                            <li class="{{$cf->set_active('album')}}">
                                <a href="{{URL::to('/album')}}">
                                    Album</a></li>

                            <!--<li role="separator" class="divider"></li>-->

                            <li class="{{$cf->set_active('profilesetting')}}">
                                <a href="{{URL::to('/profilesetting')}}">
                                    Profile Settings</a></li>

                            <!--<li role="separator" class="divider"></li>-->

                            <li class="{{$cf->set_active('merchantdashboard')}}">
                                <a href="{{URL::to('/merchant/dashboard')}}">
                                    Merchant Dashboard</a></li>
                        </ul>
                    </li>
                    @endif

                    @if (Auth::check() && Auth::user()->hasRole('sto'))
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle"
                           data-toggle="dropdown" role="button"
                           aria-haspopup="true" aria-expanded="false">
                            Station<span class="caret"></span></a>

                        <ul class="dropdown-menu">
                            <li class="{{$cf->set_active('buyerinformation')}}">
                                <a href="{{route('edit-merchant')}}">
                                    Station Information</a>
                            </li>
                            <li class="{{$cf->set_active('merchantdashboard')}}">
                                <a href="{{URL::to('/merchant/dashboard')}}">Station Dashboard</a></li>

                            <li class="{{$cf->set_active('stationopenchannel')}}">
                                <a href="{{URL::to('/merchant/dashboard')}}">OpenChannel</a></li>
                            <li class="{{$cf->set_active('stationorderview')}}">
                                <a href="{{URL::to('/station/order-view')}}">Order View List</a></li>
                            <li class="{{$cf->set_active('stationorderviewicon')}}">
                                <a href="#">Order View Icon</a></li>
                            <li class="{{$cf->set_active('stationinventoryreport')}}">
                                <a href="{{URL::to('/station/inventory-report')}}">Inventory Report</a></li>
                            <li class="{{$cf->set_active('stationinventoryupdate')}}">
                                <a href="#">Inventory Update</a></li>
                        </ul>
                    </li>
                    @endif

                </ul>

                {{-- For those users who are logged in, we test for the admin role --}}
                @if (Auth::check() && Auth::user()->hasRole('adm'))
                    <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                           aria-expanded="false">Admin<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li class="{{$cf->set_active('buyerinformation')}}">
                                <a href="#">Merchant Approval</a>
                            </li>
                            <li class="{{$cf->set_active('buyerinformation')}}">
                                <a href="{{route('tblmgmt')}}">
                                    Table Management</a>
                            </li>
                        </ul>
                    </li>
                </ul>
                @endif
            </div><!-- /.navbar-collapse -->
        </div>


    </nav>
    <!--End Top Navigation-->
    <!--Begin BreadCrumb-->
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                @yield('breadcrumbs')
            </div>
        </div>
    </div>
    <!--End BreadCrumb-->

</header>
<script>
    window.fbAsyncInit = function () {
        FB.init({
            appId: '198813647125028',
            xfbml: true,
            version: 'v2.5'
        });
    };

    (function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {
            return;
        }
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
