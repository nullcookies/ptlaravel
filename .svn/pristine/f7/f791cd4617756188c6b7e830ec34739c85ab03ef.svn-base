<!--Begin Footer-->
<footer>
    <div class="logo-header">
        <div class="container">
            <div class="row">
                <div class="col-sm-4 col-xs-6">
                    <img class="img-responsive" alt="Logo" src="{{asset('/')}}images/footer-logo.png">
                </div>
            </div>
        </div>
    </div>
    <div class="container footer_top">
        <div class="row">

            <div class="col-sm-3">
                <!-- <h3>About Opensupermall</h3>-->
                <h3>About OpenSupermall</h3>
                <ul>
                    <li>
                        {!! link_to('/about_us','About Us') !!}
                    </li>
                    <li>
                        {!! link_to_route('job.index','Job') !!}
                    </li>
					<!--
                    <li>
                       {!! link_to_route('advertise.index','Advertise with Us') !!}
                    </li>
					-->
                    <li>
                        {!! link_to_route('terms_cond.index','Term & Conditions') !!}
                    </li>
                    <li>
                        {!! link_to_route('privacy.index','Privacy Policy') !!}
                    </li>
                </ul>
            </div>
            <div class="col-sm-2">
                <h3>Buy</h3>
                <ul>
                    <li><a href="/buyerregistration"> Buyer's Registration</a></li>
                    <li>
                        {!! link_to('howtobuy','How to Buy') !!}
                    </li>
                    <li><a>How to Return</a></li>
                </ul>
            </div>
            <div class="col-sm-2">
                <h3>Sell</h3>
                <ul>
                    <li>
                        {{--helping link
                        http://laravel-recipes.com/recipes/191/generating-a-html-link-to-a-controller-action--}}
                        {!! Html::linkAction('UserController@createMerchant', 'Merchant Registration') !!}

                    </li>
					<li><a href="/create_new_station"> Station Registration</a></li>
                    <li>
                        {!! link_to('howtosell','How to Sell') !!}
                    </li>
                </ul>
            </div>
            <div class="col-sm-2">
                <h3>Subscriptions</h3>
                <ul>
                    <li>
                        {!! link_to_route('newsletter.index',"News") !!}
                        <a></a>
                    </li>
                    <li>
                        {!! link_to_route('downloads.index',"Download Apps") !!}
                    </li>
                    <li><a>OpenWish</a></li>
                    <li><a>Social Media Marketeer</a></li>
                </ul>
            </div>
            <div class="col-sm-2 col-sm-offset-1">
                <h3>Help Center</h3>
                <ul>
                    <li>
                        {!! link_to_route('directory.index',"Directory") !!}
                    </li>
                    <li>
                        {!! link_to_route('buyerhelp.index',"Help the Buyer") !!}
                    </li>
                    <li>
                        {!! link_to_route('sellerhelp.index',"Help the Seller") !!}
                    </li>
                    <li>
                        {!! link_to_route('feedback.index',"Feedback") !!}
                    </li>
                    <li>
                        {!! link_to_route('contactus.index',"Contact Us") !!}
                    </li>
                </ul>
            </div>
            <div class="clearfix"></div>


            <div class="col-sm-4 social-links">
                <ul class="list-inline">
                    <li><a href="http://facebook.com/" target="_blank"><i class="fa fa-facebook"></i></a></li>
                    <li><a href="https://linkedin.com/" target="_blank"><i class="fa fa-linkedin"></i></a></li>
                    <li><a href="https://twitter.com/" target="_blank"><i class="fa fa-twitter"></i></a></li>
                    <li><a href="http://www.weixin.com/" target="_blank"><i class="fa fa-weixin"></i></a></li>
                    <li><a href="http://www.weibo.com/" target="_blank"><i class="fa fa-weibo"></i></a></li>
                </ul>
            </div>
            <div class="col-sm-8 copyright text-right"><p>&copy; Intermedius OpenSupermall Sdn Bhd <small>(1144993-D)</small> All Rights Reserved 2015.</p></div>
        </div>
    </div>
    <div class="footer_lower">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <p><em>We Accept:</em></p>
                    <div class="icons-footer">
                            {!! Html::image("images/tiny/visa.jpg", "Icon") !!}
                            {!! Html::image("images/tiny/master-card.jpg", "Icon") !!}
                            {!! Html::image("images/tiny/maybank-2-you.jpg", "Icon") !!}
                            {!! Html::image("images/tiny/paypal.jpg", "Icon") !!}
                            {!! Html::image("images/tiny/meps.jpg", "Icon") !!}
                            {!! Html::image("images/tiny/cimb-bank-clicks.jpg", "Icon") !!}
                            {!! Html::image("images/tiny/rhb-now.jpg", "Icon") !!}
                            {!! Html::image("images/tiny/american-express.jpg", "Icon") !!}
                            {!! Html::image("images/tiny/fpx.jpg", "Icon") !!}
                            {!! Html::image("images/tiny/public-bank.jpg", "Icon") !!}
                            {!! Html::image("images/tiny/web-cash.jpg", "Icon") !!}
                            {!! Html::image("images/tiny/hong-leong-connect.jpg", "Icon") !!}
                            {!! Html::image("images/tiny/bank-islam.jpg", "Icon") !!}
                            {!! Html::image("images/tiny/ambank.jpg", "Icon") !!}
                            {!! Html::image("images/tiny/alliance.jpg", "Icon") !!}
                            {!! Html::image("images/tiny/mobile-money.jpg", "Icon") !!}
                            {!! Html::image("images/tiny/affin.jpg", "Icon") !!}
                            {!! Html::image("images/tiny/bsn.jpg", "Icon") !!}
                            {!! Html::image("images/tiny/bank-rakyat.jpg", "Icon") !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>


<span id="top-link-block" class="hidden thumbnail">
    <a href="#top" class=" btn btn-lg btn-green"  onclick="$('html,body').animate({scrollTop:0},'slow');return false;">
        <i class="fa fa-angle-double-up fa-lg"></i>
    </a>
</span><!-- /top-link-block -->
@include('layout.login')
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="{{asset('/js/jquery.min.js')}}"></script>
<script src="{{asset('/js/order-view-icon.js')}}"></script>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="{{asset('/js/bootstrap.min.js')}}"></script>
<script src="{{asset('/js/bootstrapValidator.js')}}"></script>
{{--<script src="js/jquery.validate.min.js"></script>--}}
{{--<script src="{{asset('/datetimepicker/moment.js')}}"></script>--}}
{{--<script src="{{asset('/datetimepicker/bootstrap-datetimepicker.min.js')}}"></script>--}}
{{--<script src="{{asset('/colorpicker/colorpicker.js')}}"></script>--}}
{{--<script src="{{asset('/js/bootstrap-select.js')}}"></script>--}}
{{--<script src="{{asset('/js/jquery.easing.min.js')}}"></script>--}}
{{--<script src="{{asset('/tinymce/tinymce.min.js')}}"></script>--}}
{{--<script src="{{asset('/jqgrid/grid.locale-en.js')}}"></script>--}}
{{--<script src="{{asset('/jqgrid/jquery.jqGrid.min.js')}}"></script>--}}
{{--<script src="{{asset('/js/highcharts.js')}}"></script>--}}
{{--<script src="{{asset('/js/exporting.js')}}"></script>--}}
{{--<script src="{{asset('/js/jquery.number.min.js')}}"></script>--}}
{{--<script src="{{asset('/js/toastr.js')}}"></script>--}}
{{--<script src="{{asset('/js/custom.js')}}"></script>--}}

{{--<script src="{{asset('/js/timepicki.js')}}"></script>--}}

{{--<script src="{{asset('/js/select2.min.js')}}"></script>--}}
{{--<script src="{{asset('js/video.js')}}"></script>--}}
{{--<script src="{{asset('videoplayer/embed.js')}}"></script>--}}
{{--<script src="{{asset('/js/scripts.js')}}"></script>--}}
{{--<script src="{{asset('js/profilesetting.js')}}"></script>--}}
{{--<script src="{{asset('/js/account.min.js')}}"></script>--}}
{{--<script src="https://cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>--}}
{{--@yield('this-scripts')--}}

@yield('this-scripts')

<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>


<![endif]-->


<script>
    var JS_BASE_URL = '{{ url('/') }}';
</script>


