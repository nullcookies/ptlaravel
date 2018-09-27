@include("common.head")
<style>
.people_contai{
margin-right:0;
padding:0;
width:980px;
}
.people_contai_img{
    margin-right:-6px;
    margin-left:0;
    padding-left:0;
    width:490px;
    height:660px;
    background:url('/images/cprofile/people-a4.jpg');
    background-size:cover;
    padding-right:0;
}
.contai{
    padding-left:40px;
    padding-right:30px;
    width:490px;
    border:1px solid white;
}

@media only screen and (device-width: 768px){
  .people_contai_img{
    width: 100%;
   height: 565px;
   }
   .people_contai {
   /*width: 100%;*/
   }
   .contai{
     width: 50%;
   }
   .logoheader{
        width: 980px;
   }
   .innheader{
       width: 980px;
   }
}
@media (min-width: 481px) and (max-width: 767px) {
 .people_contai_img{
    width: 100%;
    height: 565px;
   }
   .people_contai {
    /*width: 100%;*/
   }
   .contai{
     width: 50%;
   }
  
}
@media (min-width: 320px) and (max-width: 480px) {
 .people_contai_img{
    width: 100%;
    height: 566px;
   }
   .people_contai {
    /*width: 100%;*/
   }
   .contai{
     width: 50%;
   
   }
  
}
</style>
<body>
	@include("cprofile.header")
	<div class="container people_contai" style="">

	<div class="col-xs-6 contai" style="">
    	<div class="row">
        	<br style="margin-top:0">
        	<h1 style="margin-top:30px;font-family:LatoLatin">1. People</h1>
        	<h3 style="margin-top:20px;font-weight:bold">CEO</h3>
        	<h4 style="font-weight:bold">Julian Hiew, Co-Founder</h4>
        	<p style="margin-bottom:40px">
        	Although he has a financial training, Julian, being the founder, has embraced ICT and Internet technology naturally and eagerly. As the CEO, he has overall responsibilities of the company’s bottom line and market offerings. He is also actively creating awareness of conducting business online within the SME industry in the hopes of helping local business community embrace Internet technologies which would help them propel their business to the next level. Julian also designed and architected OpenSupermall, in addition to creating original concepts such as SMM Army, OpenWish and the Credit Term System.
        	</p>
        
        	<h3 style="margin-top:20px;font-weight:bold">CTO</h3>
        	<h4 style="font-weight:bold">Chia Wai Sun, Co-Founder</h4>
        	<p style="margin-bottom:10px">
        	As the co-founder, Wai-Sun has over two decades of experience in the ICT industrial and had worked for almost all major IT multinationals, last one being with Hewlett-Packard for almost a decade. Wai-Sun has an engineering background with an additional Master in Computers. He is tasked with the build and engineering of the OpenSupermall system and oversees the development and support effort of the product engineering.
        	</p>
    	</div>	
	</div> 

	<div class="col-xs-6" style="">
	<div class="row">
		<div class="people_contai_img"></div>
	</div>
	</div>
	</div>
</body>
