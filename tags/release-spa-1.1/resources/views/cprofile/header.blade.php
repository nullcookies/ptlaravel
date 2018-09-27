<style>
	.innheader{
		width: 100%;
		padding: 10px;
		background-color: #244942;
	}

	.logoheader{
		width: 100%;
		padding: 10px;
		background-color: #333333;
	}
	
	body{
		margin: 0 !important;
	}
	@media only screen and (device-width: 768px){
	   .logoheader{
        width: 980px;
       }
       .innheader{
           width: 980px;
       }
	}
	@media (min-width: 481px) and (max-width: 767px) {
	   .logoheader{
        width: 980px;
       }
       .innheader{
           width: 980px;
       }
	}
	@media (min-width: 320px) and (max-width: 480px) {
	   .logoheader{
        width: 980px;
       }
       .innheader{
           width: 980px;
       }
    }
    @media only screen 
and (min-device-width : 320px) 
and (max-device-width : 480px) 
and (orientation : landscape) { 
.logoheader{
        width: 980px;
       }
       .innheader{
           width: 980px;
       }

}
</style>
<div class="innheader">
	<a href="{{URL::to('/')}}"><img style="margin-left: 55px;" src="/images/logo-white.png" width="160px" /></a>
</div>
<div class="logoheader">
	<a href="#" style="margin-left: 55px; background-color: transparent; border-radius: 5px; border: 2px solid white; padding: 15px;" class="btn btn-info" onclick="javascript:window.history.go(-1)">
		<span style="font-size: 18px;">Back</span>
		<!-- Safari requires history.go(-1) instead of history.back() -->
	</a>
	<a href="{{ route('jaguar') }}" ><img style="margin-left: 35px;" src="/images/cprofile/jaguar_icon.png" width="75px" /></a>
	<!--<a href="{{ route('flyingfox') }}" ><img style="margin-left: 20px;" src="/images/cprofile/flyingfox_icon.png" width="75px" /></a>
	<a href="#" ><img style="margin-left: 20px;" src="/images/cprofile/caiman_logo.png" width="75px" /></a> -->
</div>