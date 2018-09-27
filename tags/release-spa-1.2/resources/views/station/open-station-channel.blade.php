@extends("common.default")
@section('content')
<style>
    table#station-open-channel
    {
        table-layout: fixed;
        max-width: none;
        width: auto;
        min-width: 100%;
    }
</style>
    <br/>
	@include('common.sellermenu')
    <div class="container">
        <div class="table-responsive" style="margin-bottom: 28px;">
			{!! Breadcrumbs::render('station.open-channel') !!}
            <h2>OpenChannel Merchant</h2>
            <table class="table table-bordered" cellspacing="0" id="station-open-channel" width="100%">
                <thead style="background-color: #db4249; color: white;">
                <tr>
                    <td colspan="3">Station</td>
                    <td colspan="4">Sales</td>
                    <td colspan="3">Inventory</td>
                    <td colspan="3">Connection</td>
                    <td colspan="4">Geographical</td>
                </tr>
                <tr style="background-color: #db4249; color: white;">
                    <td>No.</td>
                    <td>Station Id</td>
                    <td>Name</td>
                    <td>Since</td>
                    <td>YTD</td>
                    <td>MTD</td>
                    <td>Monthly Average</td>
                    <td>Item</td>
                    <td>High>30%</td>
                    <td>Low<30%</td>
                    <td>Distributor</td>
                    <td>Active</td>
                    <td>Passive</td>
                    <td>Country</td>
                    <td>State</td>
                    <td>City</td>
                    <td>Area</td>
                </tr>
                </thead>
                <tbody>
                <?php $num = 1; ?>
                @foreach($stations as $station)
                    @if(\App\Models\Merchant::getMerchant($station['user_id'])['oshop_name'])
                        <tr>
                            <td align="center">{{ $num }}</td>
                            <td>
                                <?php
                                $station_id = str_pad($station['id'], 10, '0', STR_PAD_LEFT);
                                ?>
                                 [{{$station_id}}]
                            </td>
                            <td align="left"><a class="merchant-name" href="#" id="data-station-{{$station->id}}" value="{{$station->id}}">{{ $station['station_name'] }}</a></td>
                            <td align="center">{{ date_format($station['created_at'],'dMy H:i') }}</td>
                            <td align="right">{{$currencyCode}}{{ number_format(\App\Models\POrder::getTransictionsPerYear($station['user_id'])/100 , 2) }}</td>
                            <td align="right">{{$currencyCode}}{{ number_format(\App\Models\POrder::getTransactionsCurrentMonth($station['user_id'])/100 , 2) }}</td>
                            <td align="right">{{$currencyCode}}{{ number_format(\App\Models\POrder::getTransictionsAverage($station['user_id'])/100 , 2) }}</td>
                            <td align="center"><a href="javascript:void(0)" class="prid" id="{{$station_id}}">{{ \App\Models\POrder::getItemsOfStation($station_id) }}</a></td>
                            <td align="center"></td>
                            <td align="center">{{ \App\Models\POrder::getLowItems($station['user_id']) }}</td>
                            <td align="center">100</td>
                            <td align="center">250</td>
                            <td align="center">50</td>
                            <?php $address = \App\Models\Merchant::getAddressOfMerchant($station['user_id']);
                                  $city = \App\Models\Merchant::getCity($address['city_id']); ?>
                            <td align="center">{{ \App\Models\Country::getCountryName($city['country_code']) }}</td>
                            <td align="center">{{ \App\Models\State::getStateName($city['state_code']) }}</td>
                            <td align="center">{{ $city['city_name'] }}</td>
                            <td align="center">{{ $address['area'] }}</td>
                        </tr>
                        <?php $num++; ?>
                    @endif
                @endforeach
                        </tbody>
            </table>
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
                        <table id="myTable4" class="table table-bordered myTable" style="width: 100%"></table>
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

            function pad (str, max) {
                str = str.toString();
                return str.length < max ? pad("0" + str, max) : str;
            }

            var table = $('#station-open-channel').DataTable({
                'scrollX':true,
                'autoWidth':false,
                "order": [],
                "columns": [
                    { "width": "20px", "orderable": false },
                    { "width": "85px" },
                    { "width": "130px" },
                    { "width": "120px" },
                    { "width": "120px" },
                    { "width": "120px" },
                    { "width": "120px" },
                    { "width": "120px" },
                    { "width": "120px" },
                    { "width": "120px" },
                    { "width": "120px" },
                    { "width": "120px" },
                    { "width": "120px" },
                    { "width": "120px" },
                    { "width": "85px" },
                    { "width": "85px" },
                    { "width": "85px" }
                ]
            });

            var table_modal;
            var table_modal2;
            var table_modal3;

                        var table_modal;

    $(".prid").click(function () {


        $('#modal-Tittle').html("");

        if(table_modal){
            table_modal.destroy();
            $('#myTable4').empty();
        }

        _this = $(this);

        var id_station= _this.attr('id');
        var pname= $('#pname' + id_station).val();
        var url = '/admin/master/getstationproduct/'+id_station;

        var urlbase = $('meta[name="base_url"]').attr('content');

        $.ajax({
            type: "GET",
            url: url,
            async:false,
            dataType: 'json',
            success: function (data) {
                //  console.log(data);

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

        $('#modal-Tittle').append("Station ID: "+id_station);
        $('#myTable4').append('<thead style="background-color: #604a7b; color: #fff;"><th class="no-sort">No</th><th>Product ID</th><th>Item</th><th>Left</th></thead>');


        table_modal = $('#myTable4').DataTable({
            "order": [],
            "columnDefs": [{
                "targets": 'no-sort',
                "orderable": false,
            },{ "targets": "large", "width": "120px" },{ "targets": "xlarge", "width": "300px" }],
            "fixedColumns":  true
        });

        $("#myModal2").modal("show");
		$(".dataTables_empty").attr("colspan","100%");
    });

            $('.merchant-name').on('click', function () {

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

                var my_url='/station/ochannel-station/statement/'+id;
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
                                $('#myTable1').append("<tr><td>"+h+"</td><td>["+pad(data[i].id,10)+"]</td><td>"+data[i].name+"</td><td align='center'>"+average.toFixed(2)+"</td><td align='center'>"+data[i].B+"</td><td align='center'>"+averageout.toFixed(2)+"</td><td align='center'>"+data[i].Y+"</td></tr>");
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
                                $('#myTable2').append("<tr><td>"+j+"</td><td>["+pad(data[i].id,10)+"]</td><td>"+data[i].name+"</td><td align='center'>"+average.toFixed(2)+"</td><td align='center'>"+data[i].B+"</td><td align='center'>"+averageout.toFixed(2)+"</td><td align='center'>"+data[i].Y+"</td></tr>");
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
                                $('#myTable3').append("<tr><td>"+k+"</td><td>["+pad(data[i].id,10)+"]</td><td>"+data[i].name+"</td><td align='center'>"+average.toFixed(2)+"</td><td align='center'>"+data[i].B+"</td><td align='center'>"+averageout.toFixed(2)+"</td><td align='center'>"+data[i].Y+"</td></tr>");
                                k++;
                            }
                        }

                        $('#myTable1').append('</tbody>');
                        $('#myTable2').append('</tbody>');
                        $('#myTable3').append('</tbody>');

                        table_modal = $('#myTable1').DataTable({
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
			
			$(".dataTables_empty").attr("colspan","100%");
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
