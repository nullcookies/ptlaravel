<style type="text/css">
	.smmBox:hover{
		cursor: pointer;
	}
	.mobile_table td, .mobile_table th {
    border: none !important;
}
</style>
<?php
use App\Http\Controllers\IdController;
use App\Http\Controllers\SMMController;
$fbusername=DB::table('oauth_session')->where('user_id',Auth::user()->id)
->where('smedia_id',1)->pluck('username');
?>
{{-- class=" mobile_arrow visible-xs fa fa-angle-up" --}}
<div class="row ">
	<div class="col-sm-12 col-xs-12">
		<h2 class="hidden-xs">Social&nbsp;Media&nbsp;Marketer</h2>
		{{-- For Mobile --}}
		 <h3 class="visible-xs mobile_click_info_show text-center">Social&nbsp;Media&nbsp;Marketer&nbsp;<small class="mobile_arrow fa fa-angle-up" style="color: #34dabb;cursor: pointer;"></small></h3>
	</div>
</div>
<div class="row hidden-xs">
	<p>&nbsp;</p>
</div>

{{-- For Mobile Only View --}}
<div class="row  mobile_info" style="background-color:#000000;opacity:0.8;color:#34dabb;position: absolute;z-index: 9999999999;width: 100%; display:none;">
	<input type="hidden" id="info_toggler_buyer_smm" value="0">
	<div class="col-xs-12">
		<table class=" mobile_table table" style="border: none !important" >
			<tr><td><h4>Sales</h4></td><td><h5>
			{{$currentCurrency}} {{number_format($arrperformace['smms']/100,2),0.00 }}
			</h5></td></tr>
			<tr><td colspan="2"><h4>Points Earned Since</h4></td></tr>
			<tr><td>YTD</td>
			<td>{{number_format($arrperformace['ytdsale'],2)}} Pts
			</td></tr>
			<tr><td>MTD</td>
			<td>{{number_format($arrperformace['smm'],2) , '0.00'  }} Pts
			</td></tr>
			<tr><td>Facebook</td><td>{{$fbusername}}</td></tr>
			<tr><td>Friends</td><td>{{$connections or 0}}</td></tr>
			<tr><td>Shared</td> <td>{{$arrperformace['smm_shared']}}</td></tr>
			<tr><td>Clicked</td> <td>{{$view_count}}</td></tr>
			
		</table>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('.mobile_click_info_show').click(function(){
		var $info_toggler=$('#info_toggler_buyer_smm').val();
		if ($info_toggler==0) {
		$('.mobile_info').show(300);
		$('.mobile_arrow').removeClass('fa-angle-down');
		
		$('.mobile_arrow').addClass('fa-angle-up');
		$('#info_toggler_buyer_smm').val(1);
		}else{
		$('.mobile_info').hide(100);
		$('.mobile_arrow').addClass('fa-angle-down');
		
	
		$('.mobile_arrow').removeClass('fa-angle-up');
		$('#info_toggler_buyer_smm').val(0);
		}
	});

});
</script>
{{-- Mobile Only View Ends --}}
<div class="row">
	<div class="col-sm-12 col-xs-12 col-md-4 col-lg-4 hidden-xs">
		<dl class="dl-horizontal">
			<dt>Sales</dt>
			<dd>{{$currentCurrency}} {{number_format($arrperformace['smms']/100,2),0.00 }}
			</dd>
			<dt>&nbsp;</dt><dd></dd>
			<dt>&nbsp;</dt><dd></dd>
			<dt>Points Earned Since</dt><dd></dd>
			<dt>YTD</dt><dd>{{number_format($arrperformace['ytdsale'],2)}} Pts</dd>
			<dt>MTD</dt><dd>{{number_format($arrperformace['smm'],2) , '0.00'  }} Pts</dd>
			<dt>&nbsp;</dt><dd></dd>
			<dt>&nbsp;</dt><dd></dd>
			<dt>Facebook</dt><dd>{{$fbusername}}</dd>
			<dt>Friends</dt><dd>{{$connections or 0}}</dd>
			<dt>Shared</dt> <dd>{{$arrperformace['smm_shared']}}</dd>
			<dt>Clicked</dt> <dd>{{$view_count}}</dd>
			
		</dl>
	</div>
	<div class="col-md-8 col-xs-12 col-sm-12 col-lg-8">
		@foreach($smmProducts as $product)
				<?php 
				$smmStatus=$product->smm_selected;
				$comm=SMMController::getCommission($product->product_id);

				$smmMessage="Click to blast";
				if ($smmStatus ==  false ) {
					$smmMessage="This product is no longer available for SMM";
				}
				if($product->pstatus != 'active'){
					$smmMessage="This product is currently not active";
				}
				if($product->mstatus != 'active'){
					$smmMessage="Product's merchant is currently not active";
				}
				?>
				<div class="col-xs-6 col-sm-4 col-md-4 col-lg-3" style="padding: 5px; border: 1px solid #e0e0e0;">
							<img style="padding-bottom: 5px;" class="dholder" src="{{ asset('/images/product/'.$product->product_id.'/'.$product->photo_1) }}"  height="150" width="160"
							
							>
							<a href="javascript:void(0);" class="smmBox btn btn-sm btn-info pull-left" rel-sout="{{$product->id}}">Info</a>
							@if($smmStatus == true and $comm>0 and $product->pstatus == 'active' and $product->mstatus == 'active')
							<a href="javascript:void(0);" class="btn btn-sm btn-success btn-info blast-none pull-right" data-pid="{{$product->product_id}}" data-uid="{{$product->user_id}}"
							style="background:rgb(0,100,100);" 
							>Send</a>
							@else
							<a href="javascript:void(0);" class="btn btn-sm btn-success btn-info pull-right smm-disabled"
							style="background:rgb(0,99,99);color: lightgray;opacity: 4;cursor: not-allowed;" 
							 title="{{$smmMessage}}" data-toggle="tooltip" >Send</a>
							@endif

				</div>
		
	
		@endforeach
	</div>

</div>

<div id="smmModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
        <table class="table  table-striped table-condensed" id="smmInfo" width="10%;"
        style="font-size: 0.9em;" 
        >	
        <col width="100">
         {{-- <col width="150"> --}}

        				<tr>
        					<th class="added ">Product&nbsp;Name</th>
        					<th class="added pname"></th>
        				</tr>
        				<tr>
        					<th class="added">Product&nbsp;ID</th>
        					<td class="added pid"></td>
        				</tr>
						<tr >
							<th class="added">Shared</th>
							<td class="added shared"></td>
						</tr>
						<tr>
							<th class="added">Clicked</th>
							<td class="added clicked"></td>

						</tr>
						<tr>
							<th class="added">Sales</th>
						
							<td class="added sales"></td>
						</tr>
						<tr>
							<th class="added">Units sold</th>
							<td class="added usold" ></td>
						</tr>
						<tr>
							<th class="added">Price per unit</th>
							<td class="added ppu">Pts</td>
						</tr>
						
					</table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$('.smmBox').click(function(){
			var sout=$(this).attr('rel-sout');
        	var url="{{url('smm/trans')}}"+"/"+sout;
			$elem=$(this).siblings('.dholder');
			$.ajax({
				type:"GET",
				url:url,
				error:function(){toastr.warning("Could retrieve smm info. Please contact OpenSupport");},
				success:function(r){
					if (r.status=="failure") {
						toastr.warning(r.long_message);
					}
					if (r.status == "success") {
						$('#smmInfo').find('.shared').text(r.shares);
					$('#smmInfo').find('.clicked').text(r.view_clicks);
					if (r.sales == null) {
						r.sales=0;
					}
					$('#smmInfo').find('.sales').text('Points '+r.sales);
					$('#smmInfo').find('.usold').text(r.quantity);
					$('#smmInfo').find('.ppu').text('Points '+r.price);
					// $('#smmInfo').find('.shared').text($elem.attr(''));
					$('#smmInfo').find('.pname').text(r.product_name);
					$('#smmInfo').find('.pid').text(r.pid);
					// $('#smmInfo').children().each(function(){$(this).text( $(this).text().replace('null','0') )});
					$('#smmModal').modal('show');
					}
				}
			});
			// Populate Modal
			
		});
	});
</script>
<script type="text/javascript">
	$(document).ready(function(){
	// $('.blast').click(function(){

 //        var product_id=$(this).attr('data-pid');
 //        $.ajax({
 //                url: JS_BASE_URL + '/smedia/marketer',
 //                type: 'GET',
 //                data: {product_id: product_id},
 //                success:function(response){
 //                    if (response==-1) {
 //                     var newresponse= "You have not registered for SMM services. <br>Would you like to register now? <br><button type='button' id='smmyes' class='btn btn-success'>Yes</button> <button class='btn' id='smmno'>No </button>";
 //                            toastr.info(newresponse);
 //                            	$('#smmno').click(function(){
 //                            		dt.children('i').addClass('hidden');
 //                            		toastr.clear();
 //                            	});
 //                                $('#smmyes').click(function(){
 //                                    // alert("Yeyy you clocled");
 //                                    newwindow = window.open("{{URL::route('fbtoken')}}", 'Link Token', 'height=400,width=auto');
 //                                    if (window.focus) {
 //                                        newwindow.focus()
 //                                    }
 //                                    dt.children('i').addClass('hidden');
 //                                    return false;
 //                                    });

 //                    }
 //                    else{
 //                        toastr.info(response);
 //                        dt.children('i').addClass('hidden');
 //                    };

 //                }
 //        });
 //    });
	$('.smm-disabled').hover(function(){
		// $(this).removeClass('disabled');
		$(this).tooltip();
		// $(this).addClass('disabled');
	});
	});
</script>
