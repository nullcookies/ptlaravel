<?php 
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\IdController;
$total=0;
$c=1;
?>
@extends("common.default")
@section("content")
@include('common.sellermenu')
<div class="container" style="margin-top:30px;">
	<h2>Product Ledger</h2>
	<div class="row">
		<div class="col-xs-1 col-sm-1" style="margin-bottom:10px">
			<img src="{{asset('images/product/'.$product->id.'/'.$product->photo_1)}}" style="height:50px;width:50px;vertical-align: middle;">

		</div>
		<div class="col-sm-9">
			<h3>{{$product->name}} <small><a href="{{url("productconsumer",$product->id)}}" target="_blank">{{$product->nproduct_id}}</a></small></h3>
		</div>
		<div class="col-sm-2 ">
			<a href="javascript:void(0)"
				class="btn btn-primary pull-right locations bg-location">Product Location</a>
		</div>
	</div>

	<table id="producttrack" cellspacing="0" class="table table-bordered" style="width: 100%">
	    <thead>     
			<tr style="" class="bg-inventory">
				<th class='text-center'>No</th>
				<th class='text-center'>Report ID</th>
				<th class='text-center'>Type</th>
				<th class='text-center'>Last Update</th>		
				<th class="text-center" >Location</th>
				<th class="text-center" >Qty.</th>
				{{-- <th class="text-center" >Running Total</th> --}}

			</tr>
	    </thead>

	    <tbody>
	        @if(!is_null($data))
	        @foreach($data as $tracking)
	        <?php
	        	
	        	$quantity=$tracking->received;
	        	$rt=$tracking->opening_balance;
	        	$url=url("stockreport",$tracking->no);
	        	$background="white";
	        	switch ($tracking->ttype) {
	        		case 'tout':
	        			$quantity=(-1*$quantity);
	        			$rt=$rt+$quantity;
	        			break;
	        		case 'tin':
	        			$rt+=$quantity;
	        			break;
	        		case 'stocktake':
	        			$quantity=$tracking->received-$rt;
	        			
	        			break;
	        		case 'treport':
	        			# code...
	        			if ($tracking->creator_company_id==$tracking->checker_company_id) {
	        				$quantity=-1*$tracking->quantity;
	        			}elseif ($tracking->creator_company_id==$company_id) {
	        				$quantity=-1*$tracking->quantity;

	        			}else{
	        				$background="yellow";
	        			}
	        			break;
	        		case 'smemo':
	        			$quantity=$tracking->quantity;
	        			$quantity=(-1*$quantity);
	        			$url=url("salesmemo",$tracking->no);
	        			break;
	        		case 'wastage':
	        			//$quantity=$tracking->received-$rt;
	        			$quantity=(-1*$quantity);
	        			$rt=$rt+$quantity;
	        			break;
	        		default:
	        	}
	        ?>
			<tr>
				<td style="text-align: center; vertical-align: middle;">{{$c}}</td>

				<td style="text-align: center; vertical-align: middle;">

				   <a target="_blank" href="{{$url}}">{{UtilityController::nsid($tracking->no,10,"0")}}</a>
				</td>
				
				<td style="text-align: center; vertical-align: middle;">
					@if($tracking->ttype == 'treport')
						Tracking Report
					@elseif($tracking->ttype == 'tin')
						Stock In
					@elseif($tracking->ttype == 'tout')
						Stock Out
					@elseif($tracking->ttype == 'tou')
						Stock Out
					@elseif($tracking->ttype == 'smemo')
						Sales Memo
					@elseif($tracking->ttype == 'stocktake')
						Stock Take
					@elseif($tracking->ttype == 'wastage')
						Wastage
					@endif
				</td>
				
				<td style="text-align: center; vertical-align: middle;">
				   {{$tracking->date_created}}
				</td>
				
				<td style="text-align: center; vertical-align: middle;">
					{{$tracking->location}}
				</td>
				<td  style="text-align: center; vertical-align: middle;">{{$quantity}}</td>
				{{-- <td  style="text-align: center; vertical-align: middle;" >
				<a href="javascript:void(0)" class="locations" rel="{{$product->id}}">{{$rt}}</a>
				</td> --}}
			
			</tr>
			@if($tracking->ttype=="treport" && $tracking->status=="confirmed" && $tracking->creator_company_id==$tracking->checker_company_id)
			<?php 
				
			$c++;?>
				<tr>	
				<td style="text-align: center; vertical-align: middle;">{{$c}}</td>

				<td style="text-align: center; vertical-align: middle;">
				  <a target="_blank" href="{{$url}}">{{UtilityController::nsid($tracking->no,10,"0")}}</a>
				</td>
				
				<td style="text-align: center; vertical-align: middle;">
					Tracking Report
				</td>
				
				<td style="text-align: center; vertical-align: middle;">
				   {{$tracking->date_created}}
				</td>
				
				<td style="text-align: center; vertical-align: middle;">
					{{$tracking->location2}}
				</td>
				<td  style="text-align: center; vertical-align: middle;">

				{{($tracking->received)}}
			
				</td>
				
			
			</tr>
			@endif
			
		
			@if($tracking->ttype=="smemo" && $tracking->status=="voided")
				<?php $c++;?>
				<tr>	
				<td style="text-align: center; vertical-align: middle;">{{$c}}</td>

				<td style="text-align: center; vertical-align: middle;">
				   <a target="_blank" href="{{url("salesmemo",$tracking->no)}}">{{UtilityController::nsid($tracking->sequence,10,"0")}}</a>
				</td>
				
				<td style="text-align: center; vertical-align: middle;">
					Sales Memo (Voided)
				</td>
				
				<td style="text-align: center; vertical-align: middle;">
				   {{$tracking->date_created}}
				</td>
				
				<td style="text-align: center; vertical-align: middle;">
					{{$tracking->location}}
				</td>
				<td  style="text-align: center; vertical-align: middle;">
				

				{{(-1*$quantity)}}
			
				</td>
				{{-- <td  style="text-align: center; vertical-align: middle;" >
				<a href="javascript:void(0)" class="locations" rel="{{$product->id}}">{{$rt}}</a>
				</td> --}}
			
			</tr>
			@endif
			<?php $c++;?>
	        @endforeach
	        @endif
	    </tbody>
	</table>
</div>
<br><br>
<div class="modal fade" id="myModalLocation" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 50%">
        <div class="modal-content"
			style="padding-left:10px;padding-right:10px">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
				aria-label="Close">
				<span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Product Location</h4>
            </div>
            <div class="modal-body-locations">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>

        </div>
    </div>
</div>
<script type="text/javascript">
  $(document).ready(function(){
		$(document).delegate( '.locations', "click",function (event) {
			var id = $(this).attr('rel');
			$.ajax({
				url: "{{url("productlocations",[$product->id,$selluser->id])}}",
				cache: false,
				method: 'GET',
				success: function(result, textStatus, errorThrown) {
					$(".modal-body-locations").html(result);
					$("#myModalLocation").modal('show');
				}
			});	
		});		  	  
		var table = $('#producttrack').DataTable({
			"order": [],
			"columnDefs": [
				{"targets": 'no-sort', "orderable": false, },
				{"targets": "medium", "width": "80px" },
				{"targets": "large",  "width": "120px" },
				{"targets": "approv", "width": "180px"},
				{"targets": "blarge", "width": "200px"},
				{"targets": "bsmall",  "width": "20px"},
				{"targets": "clarge", "width": "250px"},
				{"targets": "xlarge", "width": "300px" }
			]
		});
		$(".dataTables_empty").attr("colspan","100%");
  });
</script>
@stop
