<style>
.container{
	background-size: auto;
	background-repeat: no-repeat;
	background-position: center center;
	background-image:url('/images/cprofile/target_bg.jpg');
}

h1{
	color: white;
	font-size: 55px;
}

p,h2,h3{
	color: white;
}

.firstrow{
	margin-top: 30px;
}

.fleft{
	float: left;
}

.merchant{
	margin-left: 90px;
}

.station{
	margin-left: 265px;
}

.buyer{
	margin-left: 270px;
}

.merchants{
	margin-left: 70px;
}

.stations{
	margin-left: 205px;
}

.buyers{
	margin-left: 175px;
}

.merchantsimg{
	margin-left: 60px;
}

.stationsimg{
	margin-left: 110px;
	margin-top: 42px;
}

.buyersimg{
	margin-left: 85px;
	margin-top: 10px;
}

.merchants2{
	color: black !important;
	margin-left: 85px;
	font-size: 18px;
	margin-top: -20px;
}

.stations2{
	color: black !important;
	margin-left: 135px;
	font-size: 18px;
	margin-top: -20px;
}

.buyers2{
	color: black !important;
	margin-left: 135px;
	font-size: 18px;
	margin-top: -20px;
}

.merchantsimg2{
	margin-left: 60px;
}

.stationsimg2{
	margin-top: -10px;
	margin-left: 180px;
}

.buyersimg2{
	margin-left: 155px;
}

.merchants3{
	color: black !important;
	margin-left: 5px;
	font-size: 18px;
	margin-top: -20px;
}

.stations3{
	color: black !important;
	margin-left: 80px;
	font-size: 18px;
	margin-top: -20px;
}

.buyers3{
	color: black !important;
	margin-left: 180px;
	font-size: 18px;
	margin-top: -20px;
}

.merchantsimg3{
	margin-left: 60px;
	margin-right: 760px;
}

.merchants4{
	color: white !important;
	margin-left: 100px;
	font-size: 18px;
	margin-top: -20px;
	margin-right: 760px;
}

.merchantsimg4{
	margin-left: 60px;
	margin-right: 760px;
}

.merchants5{
	margin-left: 125px;
	font-size: 18px;
	margin-top: -20px;
	margin-right: 760px;
}
</style>
@include("common.head")
<body>
	@include("cprofile.header")
	<div class="container" style="padding:0;width:980px !important; height: 1000px !important;">
		<h1 align="center"><b>5. Target Market</b></h1>
		<div class="firstrow">
			<h3 class="fleft merchant">Merchant</h3> <h3 class="fleft station">Station</h3> <h3 class="fleft buyer">Buyer</h3>
			
			<p class="fleft merchants">The merchant is a Seller</p> <p class="fleft stations">The Station is a B2B Buyer</p> <p class="fleft buyers">Buyer is product end user</p>
			
			<p class="fleft merchantsimg">
				<img src="/images/cprofile/factory.png"></p> 

			<p class="fleft stationsimg">
				<img src="/images/cprofile/market.png"></p> 

			<p class="fleft buyersimg">
				<img src="/images/cprofile/buyer.png"></p>
			
			<p class="fleft merchants2">Manufacturer</p>
			<p class="fleft stations2">Hyper Market/Super Market/ Mini Market</p>
			<p class="fleft buyers2">Buyer</p>

			<p class="fleft merchantsimg2">
				<img src="/images/cprofile/brand-owner.png"></p> 

			<p class="fleft stationsimg2">
				<img src="/images/cprofile/retail-store.png"></p> 

			<p class="fleft buyersimg2">
				<img src="/images/cprofile/group-buyer.png"></p>
			
			<p class="fleft merchants3">Brand Owner/Principal/Main Distributor</p>

			<p class="fleft stations3">Retail Outlet/Pharmacy</p>
				<p class="fleft buyers3">Group Buyer</p>
			
			<p class="fleft merchantsimg3">
				<img src="/images/cprofile/restaurant.png"></p> 

			<p class="fleft merchants4">Restaurant</p>
			
			<p class="fleft merchantsimg4">
				<img src="/images/cprofile/cafe.png"></p> 

			<p class="fleft merchants5">Caf&eacute;</p>
		</div>
		
	</div>
</body>
