<?php
use App\Classes;
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\IdController;
?>
@extends("common.default")
@section('content')
<style>
</style>
	<br/>
	@include("common.sellermenu")
	<div class="container">
		
		<div class="table-responsive" style="margin-bottom: 28px;">
			{!! Breadcrumbs::render('station.open-channel') !!}
			<h2>Station OpenChannel</h2>
			<table class="table table-bordered" style="width:1520px !important;" id="supplier-open-channel">
				<thead style="background-color: #101010; color: white;">
				<tr>
					<td class="text-center" colspan="3">Merchant</td>
					@if(Auth::user()->hasRole('adm'))
						<td class="text-center" colspan="3">Sales</td>
					@endif
					<td class="text-center" colspan="3">Inventory</td>
					<td class="text-center" colspan="1">Geographical</td>
					@if(Auth::user()->hasRole('sto'))
						<td class="text-center medium" style="background-color: #F29FD7">Term</td>
					@endif
				</tr>
				<tr>
					<td class='text-center no-sort bsmall'>No</td>
					<td class='text-center bmedium'>Merchant&nbsp;ID</td>
					<td class='text-center blarge'>Name</td>
					@if(Auth::user()->hasRole('adm'))
						<td class='text-center bmedium'>Since</td>
						<td class='text-center bmedium'>YTD</td>
						<td class='text-center bmedium'>MTD</td>
					@endif
					<td class='text-center bmedium'>Items</td>
					<td class='text-center bmedium'>High>30%</td>
					<td class='text-center bmedium'>Low<30%</td>
					<td class='text-center bmedium'>State</td>
					@if(Auth::user()->hasRole('sto'))
						<td class="text-center medium" style="background-color: #F29FD7">&nbsp;</td>
					@endif
				</tr>
				</thead>
				<tbody>
				<?php $num = 1; ?>
				@foreach($suppliers as $supplier)
						<tr>
							<td align="center">{{ $num }}</td>
							<td align="center">
								{{ IdController::nM($supplier->merchantid) }}	
							</td>
							<td>@if(Auth::user()->hasRole('adm')) <a href="javascript:void(0)" class="station-terms" data-id="{{ $supplier->supplier_user_id}}"> @endif {{ $supplier->name }} @if(Auth::user()->hasRole('adm'))</a> @endif </td>
							@if(Auth::user()->hasRole('adm'))
								<td align="right"> {{$currencyCode}} {{number_format($supplier->since_sum/100 , 2) }}</td>
								<td align="right">{{$currencyCode}} {{number_format($supplier->YTD/100 , 2) }}</td>
								<td align="right">{{$currencyCode}} {{number_format($supplier->MTD/100 , 2) }}</td>
							@endif
							<td align="center"><a href="{{route('inventoryAll', ['merchantid' => $supplier->merchantid,'stationid'=>$station_id])}}" target="_blank" id="{{$station_id}}">{{ \App\Models\POrder::getItemsOfmStation($station_id, $supplier->merchantid) }}</a></td>
							<td align="center"><a href="{{route('inventoryHigh', ['merchantid' => $supplier->merchantid,'stationid'=>$station_id])}}" target="_blank" id="{{$station_id}}">{{ \App\Models\POrder::getmHighItems($station_id, $supplier->merchantid) }}</a></td>
							<td align="center"><a href="{{route('inventoryLow', ['merchantid' => $supplier->merchantid,'stationid'=>$station_id])}}" target="_blank" id="{{$station_id}}">{{ \App\Models\POrder::getmLowItems($station_id, $supplier->merchantid) }}</a></td>
							<?php
								$addretxt = $supplier->line1; 
								if($supplier->line2 != "" && !is_null($supplier->line2) && sizeof($supplier->line2) > 0){
									$addretxt .= $supplier->line2;
								}
								$addretxt .= "," . $supplier->cityname . "," . $supplier->statename . ", Malaysia";
							?>
							<td align="center"><a href="javascript:void(0)" class="openchannel_address" rel-address="{{$addretxt}}" country="Malaysia" state="{{ $supplier->statename }}" city="{{ $supplier->cityname }}" marea="{{ $supplier->areaname }}">{{ $supplier->statename }}</a></td>
							@if(Auth::user()->hasRole('sto'))
								<td align="center"><a href="javascript:void(0)" class="station-terms" data-id="{{ $supplier->supplier_user_id}}">Term</a></td>
							@endif
						</tr>
						<?php $num++; ?>
				@endforeach
				</tbody>
		</table>
	</div>
</div>
        <div id="termsModal" class="modal fade" role="dialog">
          <div class="modal-dialog" style="width:600px;">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Terms</h4>
              </div>
              <div class="modal-body" style="height: 170px !important;">
				<div class="form-group">
					<label class="col-sm-4">Credit Term</label>
					<div class="col-sm-6"><input type="text" id="term_days" value="" class="form-control" placeholder="Credit Term" disabled /></div>
					<div class="col-sm-2">days</div>
				</div>
				<div class="form-group" >
					<label class="col-sm-4" style="margin-top: 15px;">Credit Limit ({{$currentCurrency}})</label>
					<div class="col-sm-6" style="margin-top: 15px;"><input type="text" id="term_limit" value="" class="form-control" placeholder="Credit Limit ({{$currentCurrency}})" disabled /></div>
					<div class="col-sm-2" style="margin-top: 15px;">&nbsp;</div>
				</div>
				<input type="hidden" id="term_station_id" value="0" />
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>

          </div>
        </div>
		<input type="hidden" id="selluser" value="{{$selluser->id}}" />
		<?php $ostation_id = DB::table('station')->where('user_id',$selluser->id)->first()->id; ?>
		<input type="hidden" id="ostation_id" value="{{$ostation_id}}" />


        <div id="addressModal" class="modal fade" role="dialog">
          <div class="modal-dialog" style="width:800px;">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Address</h4>
              </div>
              <div class="modal-body">
                    <table id="myTable" class="table table-bordered myTable">
						<tr style="background-color: black; color: white;">
							<th>Country</th>
							<th>State</th>
							<th>City</th>
							
							<th>Area</th>
						</tr>
						<tr>
							<td id="modalcountry"></td>
							<td id="modalstate"></td>
							<td id="modalcity"></td>
							
							<td id="modalarea"></td>						
						</tr>
					</table>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>

          </div>
        </div>

	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="merchantModalLabel">
		<div class="modal-dialog" style="width: 75%">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Statement C</h4>
				</div>
				<div class="table-responsive">
					<div class="panel-group" id="accordion">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a id="modal-Tittle1" data-toggle="collapse" data-parent="#accordion" href="#collapse1"></a>
								</h4>
							</div>
							<div id="collapse1" class="panel-collapse collapse">
								<div class="modal-body" style="padding: 15px;">
									<div class="table-responsive">
										<table id="myTable1" class="table table-bordered myTable"></table>
									</div>
								</div>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a id="modal-Tittle2" data-toggle="collapse" data-parent="#accordion" href="#collapse2"></a>
								</h4>
							</div>
							<div id="collapse2" class="panel-collapse collapse">
								<div class="modal-body" style="padding: 15px;">
									<div class="table-responsive">
										<table id="myTable2" class="table table-bordered myTable"></table>
									</div>
								</div>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a id="modal-Tittle3" data-toggle="collapse" data-parent="#accordion" href="#collapse3"></a>
								</h4>
							</div>
							<div id="collapse3" class="panel-collapse collapse in">
								<div class="modal-body" style="padding: 15px;">
									<div class="table-responsive">
										<table id="myTable3" class="table table-bordered myTable"></table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->


<!-- Modal -->
<div class="modal fade" id="myModal2" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 50%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Statement D</h4>
            </div>
            <div class="modal-body">
                <h3 id="modal-Tittle"></h3>
                <div class="table-responsive">
                    <table id="myTable4" style="width: 100%" class="table table-bordered myTable"></table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>

        </div>
    </div>
</div>

	<script src="{{url('js/jquery.dataTables.min.js')}}"></script>
	<script src="{{url('jqgrid/jquery.jqGrid.min.js')}}"></script>

	<script>
		$(document).ready(function(){
		$("#term_days").number(true,0,".","");
		$("#term_limit").number(true,2,".","");
		$('.station-terms').click(function(){
			var selluser = $(this).attr('data-id');
			var ostation_id = $("#ostation_id").val();
			$.ajax({
                url: JS_BASE_URL + "/stationterm",
                type:'GET',
				data: {station_id: ostation_id, selluser: selluser},
                success:function (r) {
					$("#term_limit").val(r.term_limit/100);
					$("#term_days").val(r.term_days);
				//	$("#term_station_id").val(ostation_id);
					$("#termsModal").modal('show');
                }
            });			

			
		});		
		
			$(document).delegate( '.openchannel_address', "click",function (event) {
				var country = $(this).attr('country');
				var state = $(this).attr('state');
				var city = $(this).attr('city');
				var area = $(this).attr('marea');
				$("#modalcountry").html(country);
				$("#modalcity").html(city);
				$("#modalstate").html(state);
				$("#modalarea").html(area);
				$("#addressModal").modal('show');
			});		
		
			function pad (str, max) {
				str = str.toString();
				return str.length < max ? pad("0" + str, max) : str;
			}

			var table_modal;

	$(".prid").click(function () {


		$('#modal-Tittle').html("");

		if(table_modal){
			table_modal.destroy();
			$('#myTable4').empty();
		}

        _this = $(this);

        var id_merchant= _this.attr('id');
        var pname= $('#pname' + id_merchant).val();
        var url = '/admin/master/getmerchantproduct/'+id_merchant;

        var urlbase = $('meta[name="base_url"]').attr('content');

        $.ajax({
            type: "GET",
            url: url,
            async:false,
            dataType: 'json',
            success: function (data) {
                //	console.log(data);

                $('#myTable4').append('<tbody>');
                for(i=0;i<data.length;i++){

                    var pr = "";
                        pr = '[' + pad(data[i].id,10) + ']';

                    var urlid = data[i].id;

                    $('#myTable4').append('<tr><td align="center">'+ (i+1) +'</td><td align="center"><a href="'+urlbase+'/productconsumer/'+urlid+'">'+ pr +'</a></td><td>'+data[i].name+'</td><td align="center">'+data[i].available+'</td></tr>');
                }
                $('#myTable4').append('</tbody>');


            },
            error: function (error) {
                console.log(error);
            }
        });

        $('#modal-Tittle').append("Merchant ID: "+id_merchant);
        $('#myTable4').append('<thead style="background-color: #604a7b; color: #fff;"><th class="no-sort">No</th><th>Product ID</th><th>Item</th><th>Left</th></thead>');


        table_modal = $('#myTable4').DataTable({
        	'scrollX':false,
            "order": [],
            "columnDefs": [{
                "targets": 'no-sort',
                "orderable": false,
            },{ "targets": "large", "width": "120px" },{ "targets": "xlarge", "width": "300px" }],
            "fixedColumns":  true
        });

        $("#myModal2").modal("show");
    });

			var table = $('#supplier-open-channel').DataTable({
				'scrollX':true,
				'bScrollCollapse': true,
                'scrollX':true,
                'autoWidth':false,
				"columnDefs": [
					{"targets": 'no-sort', "orderable": false, },
					{"targets": "medium", "width": "80px" },
					{"targets": "bmedium", "width": "10px" },
					{"targets": "large",  "width": "120px" },
					{"targets": "approv", "width": "180px"},
					{"targets": "blarge", "width": "200px"},
					{"targets": "bsmall",  "width": "20px"},
					{"targets": "clarge", "width": "250px"},
					{"targets": "xlarge", "width": "300px" }
				]
			});

			var table_modal;
			var table_modal2;
			var table_modal3;

			$('.station-name').on('click', function () {

				if(table_modal){
					table_modal.destroy();
					$('#myTable1').empty();
					$('#modal-Tittle1').empty();
				}
				if(table_modal2){
					table_modal2.destroy();
					$('#myTable2').empty();
					$('#modal-Tittle2').empty();
				}
				if(table_modal3){
					table_modal3.destroy();
					$('#myTable3').empty();
					$('#modal-Tittle3').empty();
				}

				var id = $(this).attr("value");
				var year=new Date().getFullYear();
				var year1=year;
				$('#modal-Tittle3').append(year1);
				--year;
				var year2=year;
				$('#modal-Tittle2').append(year2);
				--year;
				var year3=year;
				$('#modal-Tittle1').append(year3);

				var my_url='/station/ochannel-supplier/statement/'+id;
				var method = 'GET';
				$.ajax({
					type: method,
					url: my_url,
					dataType: 'json',
					success: function (data) {
						$('#myTable1').append("<thead style='background-color: #FF0000; color: #fff;'><th colspan='3'>Product</th> <th colspan='2'>In</th><th colspan='2'>Out</th><tr><th>No</th><th>Product ID</th><th>Item</th><th>Average Price</th><th>Qty</th><th>Average Price</th><th>Qty</th></tr></thead>");
						$('#myTable1').append('<tbody>');
						$('#myTable2').append("<thead style='background-color: #FF0000; color: #fff;'><th colspan='3'>Product</th> <th colspan='2'>In</th><th colspan='2'>Out</th><tr><th>No</th><th>Product ID</th><th>Item</th><th>Average Price</th><th>Qty</th><th>Average Price</th><th>Qty</th></tr></thead>");
						$('#myTable2').append('<tbody>');
						$('#myTable3').append("<thead style='background-color: #FF0000; color: #fff;'><th colspan='3'>Product</th> <th colspan='2'>In</th><th colspan='2'>Out</th><tr><th>No</th><th>Product ID</th><th>Item</th><th>Average Price</th><th>Qty</th><th>Average Price</th><th>Qty</th></tr></thead>");
						$('#myTable3').append('<tbody>');
						var h=1;
						var j=1;
						var k=1;
						for (var i=0; i<data.length; i++) {
							var array_fecha = data[i].date.split("-");
							var ano = parseInt(array_fecha[0]);
							console.log(year);
							if(year3==ano){
								if(data[i].B!=0) {
									var average = data[i].A/data[i].B;
								}else{
									average=0;
								}
								if(data[i].Y!=0) {
									var averageout = data[i].X / data[i].Y;
								}else{
									averageout=0;
								}
								$('#myTable1').append("<tr><td>"+h+"</td><td align='center'>["+pad(data[i].id,10)+"]</td><td>"+data[i].name+"</td><td align='center'>"+average.toFixed(2)+"</td><td align='center'>"+data[i].B+"</td><td align='center'>"+averageout.toFixed(2)+"</td><td align='center'>"+data[i].Y+"</td></tr>");
								h++;
							}
							if(year2==ano){
								if(data[i].B!=0) {
									var average = data[i].A/data[i].B;
								}else{
									average=0;
								}
								if(data[i].Y!=0) {
									var averageout = data[i].X / data[i].Y;
								}else{
									averageout=0;
								}
								$('#myTable2').append("<tr><td>"+j+"</td><td align='center'>["+pad(data[i].id,10)+"]</td><td>"+data[i].name+"</td><td align='center'>"+average.toFixed(2)+"</td><td align='center'>"+data[i].B+"</td><td align='center'>"+averageout.toFixed(2)+"</td><td align='center'>"+data[i].Y+"</td></tr>");
								j++;
							}
							if(year1==ano){
								if(data[i].B!=0) {
									var average = data[i].A/data[i].B;
								}else{
									average=0;
								}
								if(data[i].Y!=0) {
									var averageout = data[i].X / data[i].Y;
								}else{
									averageout=0;
								}
								$('#myTable3').append("<tr><td>"+k+"</td><td align='center'>["+pad(data[i].id,10)+"]</td><td>"+data[i].name+"</td><td align='center'>"+average.toFixed(2)+"</td><td align='center'>"+data[i].B+"</td><td align='center'>"+averageout.toFixed(2)+"</td><td align='center'>"+data[i].Y+"</td></tr>");
								k++;
							}
						}

						$('#myTable1').append('</tbody>');
						$('#myTable2').append('</tbody>');
						$('#myTable3').append('</tbody>');

						table_modal = $('#myTable1').DataTable({
							'scrolly':false,
							'autoWidth':false,
							"order": [],
							"iDisplayLength": 10,
							"columns": [
								{ "width": "20px", "orderable": false },
								{ "width": "65px" },
								{ "width": "105px" },
								{ "width": "55px" },
								{ "width": "20px" },
								{ "width": "55px" },
								{ "width": "20px" }
							]
						});

						table_modal2 = $('#myTable2').DataTable({
							'scrolly':false,
							'autoWidth':false,
							"order": [],
							"iDisplayLength": 10,
							"columns": [
								{ "width": "20px", "orderable": false },
								{ "width": "65px" },
								{ "width": "105px" },
								{ "width": "55px" },
								{ "width": "20px"},
								{ "width": "55px"},
								{ "width": "20px"}

							]
						});

						table_modal3 = $('#myTable3').DataTable({
							'autoWidth':false,
							"order": [],
							"iDisplayLength": 10,
							"columns": [
								{ "width": "20px", "orderable": false },
								{ "width": "65px" },
								{ "width": "105px" },
								{ "width": "55px" },
								{ "width": "20px" },
								{ "width": "55px" },
								{ "width": "20px" }
							]
						});

						$("#myModal").modal("show");
					},
					error: function (error) {
						console.log( error);
					}
				});
			});
		});

	</script>
	@yield("left_sidebar_scripts")
@stop

{{--
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Modal title</h4>
      </div>
      <div class="modal-body">
        <p>One fine body&hellip;</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
--}}
