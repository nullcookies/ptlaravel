<?php
use App\Http\Controllers\IdController;
?>
@extends('logistics.common')
@section('moreContent')
<?php $i=1;?>
<style>
.table>thead>tr>th {
    vertical-align: middle !important;
    border-bottom: 2px solid #ddd;
}
</style>
<h2>Logistic Professional Company Master</h2>
<table class="table table-bordered" cellspacing="0" width="100%" id="cre_details_table">
                <thead style="background-color: #6D9370;color: white;">
                <style type="text/css">
                                .sort{color: black;}              
                </style>
                    <tr style="">
                        <th rowspan="2" class="no-sort text-center no-sort">No</th>
                        <th rowspan="2" class="large">Logistic&nbsp;ID</th>
                        <th rowspan="2" class="xlarge">Name</th>
                        <th rowspan="2" class="large">Capability</th>
                        <th rowspan="2" class="large">Grade</th>
                        <th rowspan="2" class="large">Price</th>
                        <th rowspan="2" class="large">API</th>
                        <th class="xxlarge text-center" colspan="2">Delivery&nbsp;Order</th>
                        <th class="xxlarge text-center" colspan="2">Total</th>                    
                         <th class="large" style="background-color: black;">Outstanding</th>
                    </tr>
                    <tr class="text-center">
                                    	
                    	<th>Running</th>
                    	<th>Completed</th>
                    	<th>DO</th>
                    	<th>Amount</th>
                    	<th style="background-color: black;"></th>
                    </tr>
                <thead>
                <tbody>
                	@foreach($logs as $l)
                	<tr>
                		<td class="text-center">{{$i}}</td>
                		<td class="text-center"><a href="{{ route('logistic_dashboard', ['id' => $l->uid]) }}" target="_blank" >{{IdController::nS($l->station_id)}}</a> </td>
                		<?php 
							$lname = substr($l->lcompany_name,0,12);
							$lname =  str_replace(" ","&nbsp;",$lname);
							if(strlen($lname) > 12){
								$lname .= "...";
							}
						?>
                		<td class="text-center"><span title="{{$l->lcompany_name}}">{{$lname}}</span></td>
                		<td class="text-center"><a class="capability" rel-id="{{$l->id}}">Details</a></td>
						<td class="text-center">
							<select class="selectgrade" rel="{{$l->id}}">
								@foreach($lgrades as $lgrade)
									<?php 
										$lselected = "";
										if($lgrade->id == $l->lgrade_id){
											$lselected = "selected";
										}
									?>
									<option title="{{$lgrade->description}}" value="{{$lgrade->id}}" {{$lselected}}>{{$lgrade->grade}}</option>
								@endforeach
							</select>
						</td>
                		<td class="text-center"><a  class="showLPricing" rel-id="{{$l->id}}">Details</a></td>
                		<td class="text-center">
							@if($l->api == 1)
								Yes
							@else
								No
							@endif
						</td>
                        <td class="text-right"><a  class="showDos" rel-type="outstanding" rel-id="{{$l->id}}">{{$l->outstanding}}</a></td>
                        <td class="text-right"><a  class="showDos" rel-type="delivered" rel-id="{{$l->id}}">{{$l->delivered}}</a></td>
                        <td class="text-right"><a  class="showDos" rel-type="all" rel-id="{{$l->id}}">{{$l->dos}}</a></td>
                        <td class="text-right">MYR&nbsp;{{number_format($l->total_delivery/100,2)}}</td>
                        <td class="text-right">MYR&nbsp;{{number_format($l->total_delivery_up/100,2)}}</td>
                	</tr>
                	<?php $i++;?>

                	@endforeach				
                </tbody>
            </table>


<script type="text/javascript">
	$(document).ready(function(){
    $(".selectstatement").change(function()
    {
		window.open(window.location.protocol + "//" + window.location.host + "/"+$(this).val(),'_blank');
     //   document.location.href = window.location.protocol + "//" + window.location.host + "/"+$(this).val();
    });		
		
	var table = $('#cre_details_table').DataTable({
		"order": [],
		"scrollX": true,
		"columnDefs": [
			{"targets": "no-sort", "orderable": false},
		],
		"fixedColumns": {
			"leftColumns": 2
		}
	});

		$('.showLPricing').click(function(e){
            e.preventDefault();
   
            var lid=$(this).attr('rel-id');
            var url="{{url('lp/pricing')}}"+"/"+lid;
            $('#lModal').modal('show');
            $('#lModal').find('.modal-body').load(url);
        });
		
		$('.showDos').click(function(e){
            e.preventDefault();
   
            var lid=$(this).attr('rel-id');
            var type=$(this).attr('rel-type');
            var url="{{url('lp/dos')}}"+"/"+lid+"/"+type;
			console.log(url);
            $('#lModal').modal('show');
            $('#lModal').find('.modal-body').load(url);
        });		
		
		$(document).delegate( '.selectgrade', "change",function (event) {
			var lid = $(this).attr('rel');
			var val = $(this).val();
			$.ajax({
					type: "post",
					url:  JS_BASE_URL + '/lp/lgrade',
					data: {id: lid, grade: val},
					success: function (responseData, textStatus, jqXHR) {
						toastr.info('Grade successfully changed!');					
					},
					error: function (responseData, textStatus, errorThrown) {
						alert(errorThrown);
					}
				});
		}); 
		
		$('.capability').click(function(e){
            e.preventDefault();
   
            var lid=$(this).attr('rel-id');
            var url="{{url('lp/capability')}}"+"/"+lid;
            $('#lModal2').modal('show');
            $('#lModal2').find('.modal-body').load(url);
        });	
	});
</script>
@stop
