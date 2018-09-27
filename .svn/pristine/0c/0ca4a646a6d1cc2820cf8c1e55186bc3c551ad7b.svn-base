<?php
use App\Http\Controllers\UtilityController;
?>
 <div class="container" style="margin-top:30px; height:auto;">

		<script type="text/javascript">
		$(document).ready(function() {
			Highcharts.setOptions({
     colors: ['#595959', '#FF0000', '#818E56', '#953822', '#538DD3', '#A5A8AD']
    });
			var options = {
				chart: {
	                renderTo: 'container',
	                plotBackgroundColor: null,
	                plotBorderWidth: null,
	                plotShadow: false
	            },
                   exporting: {
        buttons: {
            contextButtons: {
                enabled: false,
                menuItems: null
            }
        },
        enabled: true
    },
	            title: {
	                text: 'Merchant Revenue Pie- {{ date("Y")}}'
	            },
	            tooltip: {
	                formatter: function() {
	                    return '<b>'+ this.point.name +'</b>: '+ this.y+"("+(this.percentage.toFixed(2)+" %)");
	                }
	            },
	            plotOptions: {
	                pie: {
	                    allowPointSelect: true,
	                    cursor: 'pointer',
	                    showInLegend: true,
	                    dataLabels: {
	                        enabled: false,
	                        color: '#000000',
	                        connectorColor: '#000000',
	                        formatter: function() {
	                            return '<b>'+ this.point.name +'</b>';
	                        }
	                    }
	                }
	            },
	            legend: {
	                enabled: true,
	                layout: 'vertical',
	                align: 'right',
	                width: 200,
	                verticalAlign: 'middle',
	                useHTML: true,
	                labelFormatter: function() {
	                    return '<div style="text-align: left; width:100px;float:left;">' + this.name + '</div>';
					}
            },
            credits: {
      			enabled: false
  			},
	            series: [{
	                type: 'pie',
	                name: 'Browser share',
	                data: []
	            }]
	        }
	        
	        $.getJSON("{{ URL::to('/')}}/merchantRevenueJSON/json", function(json) {
				options.series[0].data = json;
	        	chart = new Highcharts.Chart(options);
	        });
	        

      	});   
		</script>


<div id="container" style="min-width: 500px; height: 300px;float:left;"></div>


	<table id="revenueDatatable" class="display table table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th  class="text-center no-sort" style="background-color:#000; color:#fff">No.</th>
                <th  class="text-center" style="background-color:#000; color:#fff">Merchant Id</th>
                <th  class="text-center" style="background-color:#000; color:#fff">{{ date('Y') }} -Company Name</th>
                <th  class="text-center" style="background-color:#595959; color:#fff">Subscription Fee</th>
                <th  class="text-center" style="background-color:#FF0000; color:#fff">Commission</th>
                <th  class="text-center" style="background-color:#818E56; color:#fff">Logistics</th>
                <th  class="text-center" style="background-color:#953822; color:#fff">Advertisement</th>
                <th  class="text-center" style="background-color:#538DD3; color:#fff">SMM</th>
                <th  class="text-center" style="background-color:#A5A8AD; color:#fff">Pusher</th>
                <th  class="text-center" style="background-color:#000; color:#fff">Total</th>
            </tr>
        </thead>

        <tbody>
         <?php
            $i=0;
            $totalSubscription=$totalCommission=0;
            $totalLogistic=$totalSmm=$totalAmount=0;
            $totalAdvertise=$totalPusher=0;
        ?>
        @foreach($data as $merchant=>$val)
        <tr>
        	<td class="text-center"><? echo ++$i; ?></td>
        	<td>{{UtilityController::s_id($val['merchant_id']) }}</td>
        	<td>{{ ucfirst($merchant) }}</td>
        	<td class="text-center">{{$currentCurrency}} {{ $val['subscription'] }}</td>
        	<td class="text-center">{{$currentCurrency}} {{ $val['commission'] }}</td>
            <td class="text-center">{{$currentCurrency}} {{ $val['logistic'] }}</td>
        	<td class="text-center">{{$currentCurrency}} {{ $val['advertise'] }}</td>
            <td class="text-center">{{$currentCurrency}} {{ $val['smm'] }}</td>
        	<td class="text-center">{{$currentCurrency}} {{ $val['pusher'] }}</td>
        	<td class="text-center">{{$currentCurrency}} {{ $total=$val['subscription']+$val['commission']+$val['logistic']+$val['smm']+$val['advertise']+$val['pusher'] }}</td>
        </tr>
        <?php 
        $totalSubscription+=$val['subscription'];
        $totalCommission+=$val['commission'];
        $totalLogistic+=$val['logistic'];
        $totalSmm+=$val['smm'];
        $totalAdvertise+=$val['advertise'];
        $totalPusher+=$val['pusher'];
        $totalAmount+=$total;

         ?>
        @endforeach
            
        </tbody>
        <tfoot>
            <tr>
                <th class="text-center">Total</th>
                <th></th> 
                <th> </th>
{{--                 <th>{{$currentCurrency}} </th> --}}
                <td class="text-right" style="padding-right:0;">{{$currentCurrency}} {{ number_format($totalSubscription,2) }}</td>
                <td class="text-right" style="padding-right:0;">{{$currentCurrency}} {{ number_format($totalCommission,2) }}</td>
                <td class="text-right">{{$currentCurrency}} {{ number_format($totalLogistic,2) }}</td>
                <td class="text-right">{{$currentCurrency}} {{ number_format($totalAdvertise,2) }}</td>
                <td class="text-right">{{$currentCurrency}} {{ number_format($totalSmm,2) }}</td>
                <td class="text-right">{{$currentCurrency}} {{ number_format($totalPusher,2) }}</td>
                <td class="text-right">{{$currentCurrency}} {{ number_format($totalAmount,2) }}</td>
            </tr>
        </tfoot>
    </table>
    <script type="text/javascript">
    	$(document).ready(function() {
    $('#revenueDatatable').DataTable({
        "pageLength":12
    });
} );
    </script>

   </div>


