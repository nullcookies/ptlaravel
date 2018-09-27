
<style type="text/css">
	.limiter{
		overflow-x: hidden;
		overflow-y: scroll;
		max-height: 250px;
	}

</style>
<?php
use App\Http\Controllers\UtilityController;
?>
<div class="col-sm-6 col-sm-offset-3">
	<h2>OpenCredit</h2>
<div class="panel-group" id="accordion">
	<div class="panel">

		<a data-toggle="collapse" data-parent="#accordion" href="#accordionOne">
		<div class="panel-heading bg-standard"> <!-- panel-heading -->
			<h4 class="panel-title">SMM &nbsp;
			   @if(isset($opencredit_log['SMM_total']))
					<span class="label label-style label-info">{{count($opencredit_log['SMM_log'])}}</span> 
				@endif
		   </h4>
		   <span class="pull-right">
		   <span class='tvalue'>
				{{number_format($opencredit_log['SMM_total']/100,2)}} Pts
		   </span></span>
		   
		</div>
		</a> 
		<!-- panel body -->
		<div id="accordionOne" class="panel-collapse collapse">
			<div class="panel-body">
				<div class="col-sm-12 limiter">
					<div class="row">
						@if(isset($opencredit_log['SMM_log']))
					
						@foreach($opencredit_log['SMM_log'] as $sprice)
						<div class="src-row">
							<div class="col-sm-4 col-xs-12 ocDateCol">
								<div>{{ $sprice->cdate }}</div>
							</div>
							<div class="col-sm-4 col-xs-12 ocPriceCol">
								<div class="pull-left ocpName">
									<span data-toggle="tooltip" data-placement="left" title="{{ ucfirst($sprice->nporder_id) }}">
									<a href="{{url('receipt',$sprice->id)}}" target="_blank">{{ ucfirst($sprice->nporder_id) }}</a>
									</span>
								</div>	
							</div>
							<div class="col-sm-4 col-xs-12 ocPriceCol">
								<div class="pull-left"></div>
								<div class="pull-right">@if($sprice->mode=="debit")-@endif{{ number_format($sprice->value/100,2) }} Pts</div>
							</div>
						</div>
						@endforeach
						@else
						<div class="src-row">
							<div class="col-sm-12 limiter">
								<span style="text-align: center; font-style: italic; color: #999"> No record found.
								</span>
							</div>
						</div>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="panel">
		<a data-toggle="collapse" data-parent="#accordion" href="#accordionTwo">
		<div class="panel-heading bg-standard"> <!-- panel-heading -->
			<h4 class="panel-title">OPENWISH &nbsp;
			   
					<span class="label label-style label-info">{{count($opencredit_log['OpenWish_log']) }}</span> 
				
		   </h4>
		   @if(isset($opencredit_log['OpenWish_total']))
		   
		   <span class="pull-right">
		   <span class='tvalue'>{{ number_format($opencredit_log['OpenWish_total']/100,2) }} Pts
		   </span></span>
		   @endif
		</div>
		</a> 
		<!-- panel body -->
		<div id="accordionTwo" class="panel-collapse collapse">
			<div class="panel-body">
				<div class="col-sm-12 limiter">
					<div class="row">
						@if(isset($opencredit_log['OpenWish_log']))
						@foreach($opencredit_log['OpenWish_log'] as $sprice)
						<div class="src-row">
							<div class="col-sm-4 col-xs-12 ocDateCol">
								<div>{{ $sprice->cdate }}</div>
							</div>
							<div class="col-sm-4 col-xs-12 ocPriceCol">
								<div class="pull-left ocpName">
									<span data-toggle="tooltip" data-placement="left" title="{{ ucfirst($sprice->nporder_id) }}">
									<a href="#" rel-owid="{{$sprice->porder_id}}" class="show_openwish_log">{{ ucfirst($sprice->nporder_id) }}</a>
									</span>
								</div>	
							</div>
							<div class="col-sm-4 col-xs-12 ocPriceCol">
								<div class="pull-left"></div>
								<div class="pull-right">@if($sprice->mode=="debit")-@endif{{ number_format($sprice->value/100,2) }} Pts</div>
							</div>
						</div>
						@endforeach
						@else
						<div class="src-row">
							<div class="col-sm-12 limiter">
								<span style="text-align: center; font-style: italic; color: #999"> No record found.
								</span>
							</div>
						</div>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="panel">
		<a data-toggle="collapse" data-parent="#accordion" href="#accordionThree">
		<div class="panel-heading bg-standard"> <!-- panel-heading -->
			<h4 class="panel-title">HYPER &nbsp;
			  
					<span class="label label-style label-info">0</span> 

				
		   </h4>
		   @if(isset($opencredit_log['Hyper_total']))
		   <span class="pull-right">
		   <span class='tvalue'>
				{{number_format($opencredit_log['Hyper_total']/100,2)}} Pts
		   </span></span>
		   @endif
		</div>
		</a> 
		<!-- panel body -->
		<div id="accordionThree" class="panel-collapse collapse">
			<div class="panel-body">
				<div class="col-sm-12 limiter">
					<div class="row">
						@if(isset($opencredit_log['Hyper_log']))
						@foreach($opencredit_log['Hyper_log'] as $sprice)
						<div class="src-row">
							<div class="col-sm-4 col-xs-12 ocDateCol">
								<div>{{ $sprice->cdate }}</div>
							</div>
							<div class="col-sm-4 col-xs-12 ocPriceCol">
								<div class="pull-left ocpName">
									<span data-toggle="tooltip" data-placement="left" title="{{ ucfirst($sprice->nporder_id) }}">
									{{ ucfirst($sprice->nporder_id) }}
									</span>
								</div>	
							</div>
							<div class="col-sm-4 col-xs-12 ocPriceCol">
								<div class="pull-left"></div>
								<div class="pull-right">@if($sprice->mode=="debit")-@endif{{ number_format($sprice->value/100,2) }} Pts</div>
							</div>
						</div>
						@endforeach
						@else
						<div class="src-row">
							<div class="col-sm-12 limiter">
								<span style="text-align: center; font-style: italic; color: #999"> No record found.
								</span>
							</div>
						</div>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="panel">
		<a data-toggle="collapse" data-parent="#accordion" href="#accordionFour">
		<div class="panel-heading bg-standard"> <!-- panel-heading -->
			<h4 class="panel-title">CRE &nbsp;
			   @if(isset($opencredit_log['CRE_total']))
					<span class="label label-style label-info">{{ count($opencredit_log['CRE_log']) }}</span> 
				@endif
		   </h4>
		   @if(isset($opencredit_log['CRE_total']))
		   <span class="pull-right">
		   <span class='tvalue'>
				{{number_format($opencredit_log['CRE_total']/100,2)}} Pts
		   </span></span>
		   @endif
		</div>
		</a> 
		<!-- panel body -->
		<div id="accordionFour" class="panel-collapse collapse">
			<div class="panel-body">
				<div class="col-sm-12 limiter">
					<div class="row">
						@if(isset($opencredit_log['CRE_log']))
						@foreach($opencredit_log['CRE_log'] as $sprice)
						<div class="src-row">
							<div class="col-sm-4 col-xs-12 ocDateCol">
								<div>{{ $sprice->cdate }}</div>
							</div>
							<div class="col-sm-4 col-xs-12 ocPriceCol">
								<div class="pull-left ocpName">
									<span data-toggle="tooltip" data-placement="left" title="{{ ucfirst($sprice->nporder_id) }}">
									<a href="{{url('receipt',$sprice->porder_id)}}" target="_blank">{{ ucfirst($sprice->nporder_id) }}</a>
									</span>
								</div>							
							</div>
							<div class="col-sm-4 col-xs-12 ocPriceCol">
								<div class="pull-left">Points</div>
								<div class="pull-right">@if($sprice->mode=="debit")-@endif{{ number_format($sprice->value/100,2) }}</div>
							</div>
						</div>
						@endforeach
						@else
						<div class="src-row">
							<div class="col-sm-12 limiter">
								<span style="text-align: center; font-style: italic; color: #999"> No record found.
								</span>
							</div>
						</div>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>

{{-- Porder --}}
		<div class="panel">
		<a data-toggle="collapse" data-parent="#accordion" href="#accordionFive">
		<div class="panel-heading bg-standard"> <!-- panel-heading -->
			<h4 class="panel-title">Purchase&nbsp;
			  {{--  @if(isset($opencredit_log['PURCHASE_total']))
 --}}					<span class="label label-style label-info">{{'0'}}</span> 
				{{-- @endif --}}
		   </h4>
		   {{-- @if(isset($opencredit_log['PURCHASE_total'])) --}}
		   <span class="pull-right">
		   <span class='tvalue'>
				{{number_format(0/100,2)}} Pts
		   </span></span>
		   {{-- @endif --}}
		</div>
		</a> 
		<!-- panel body -->
		<div id="accordionFive" class="panel-collapse collapse">
			<div class="panel-body">
				<div class="col-sm-12 limiter">
					<div class="row">
						@if(isset($opencredit_log['PURCHASE_log1']))
						@foreach($opencredit_log['PURCHASE_log1'] as $sprice)
						<div class="src-row">
							<div class="col-sm-4 col-xs-12 ocDateCol">
								<div>{{ $sprice->cdate }}</div>
							</div>
							<div class="col-sm-4 col-xs-12 ocPriceCol">
								<div class="pull-left ocpName">
									<span data-toggle="tooltip" data-placement="left" title="{{ ucfirst($sprice->nporder_id) }}">
									{{ ucfirst($sprice->nporder_id) }}
									</span>
								</div>							
							</div>
							<div class="col-sm-4 col-xs-12 ocPriceCol">
								<div class="pull-left"></div>
								<div class="pull-right">@if($sprice->mode=="debit")-@endif{{ number_format($sprice->value/100,2) }} Pts</div>
							</div>
						</div>
						@endforeach
						@else
						<div class="src-row">
							<div class="col-sm-12 limiter">
								<span style="text-align: center; font-style: italic; color: #999"> No record found.
								</span>
							</div>
						</div>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
	{{-- ENDS --}}
	<div class="bg-info" style="border-top:0px; border-bottom: 1px solid #ddd">
		<div class="src-row" style="padding: 8px 12px; border: 0px">
			<span class="pull-right">Total: <span id='tvalueTotall'>{{number_format(UtilityController::ocredit()['ocredit']/100,2)}} Pts</span></span>
		</div>
	</div>
	{{-- <div class="panel">
		<a data-toggle="collapse" data-parent="#accordion" href="#accordionFive">
		<div class="panel-heading bg-standard"> <!-- panel-heading -->
			<h4 class="panel-title" style="color: green">MERCHANT CREDIT &nbsp;
			   @if(isset($source_total['mcredit']) && $source_total['mcredit'] > 0)
					<span class="label label-style label-info">{{ $source_total['mcredit'] }}</span> 
				@endif
		   </h4>
		</div>
		</a> 
		<!-- panel body -->
		<div id="accordionFive" class="panel-collapse collapse">
			<div class="panel-body">
				<div class="col-sm-12 limiter">
					<div class="row">
						@if(isset($opencredit_log['mcredit']) && !empty($opencredit_log['mcredit']))
						@foreach($opencredit_log['mcredit'] as $sprice)
						<div class="col-sm-6">
							<span class="pull-left">Date :</span>
							<span class="pull-right">16 July, 2016</span>
						</div>
						<div class="col-sm-6">
							<span class="pull-left"></span>
							<span class="pull-right">{{ $sprice->value }} Pts</span>
						</div>
						@endforeach
						@else
						<div class="col-sm-12 limiter">
							<span style="text-align: center; font-style: italic; color: #999"> No record found.
							</span>
						</div>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div> --}}
</div>  
</div>


<div id="openwish_log_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">OpenWish Contributions</h4>
      </div>
      <div class="modal-body">
        <table class="table table-striped">
        	<thead>
        		<th>No.</th>
        		<th>Name</th>
        		<th>Amount</th>
        		<th>Date</th>
        	</thead>
        	<tbody id="openwish_log_table"></tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<script>
$(document).ready(function(){
    $('.show_openwish_log').click(function(){
    		var openwish_id=$(this).attr('rel-owid');
    		var url="{{url('openwish/log')}}"+"/"+openwish_id;
    		$.ajax({
    			url:url,
    			type:'GET',
    			success:function(r){
    				if (r.status=="success") {
    					var html="";
    					data=r.data;
    					for (var i =0; i < data.length; i++) {
    						// console.log(i);
    						var x=i+1;
    						html="<tr><td>"+x+"</td><td>"+data[i].name+"</td><td>"+data[i].amount+"</td><td>"+data[i].created_at+"</td></tr>";
    					}
    					$('#openwish_log_table').append(html);
    					$('#openwish_log_modal').modal('show');

    				}else{
    					toastr.error(r.long_message);
    				}
    			},
    			error:function(){
    				toastr.error("Cannot connet to the server. Please contact OpenSupport.");
    			}


    		});

    });
});
</script>
