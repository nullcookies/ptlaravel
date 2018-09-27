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
	                text: 'Product A Revenue Pie- {{ date("Y")}}'
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
	        
	        $.getJSON("{{ URL::to('/')}}/productARevenueJSON/json", function(json) {
				options.series[0].data = json;
                console.log(options.series[0].data);
	        	chart = new Highcharts.Chart(options);
	        });
	        

      	});   
		</script>

<div id="container" style="min-width: 500px; height: 300px;float:left;"></div>


	<table id="revenueDatatable" class="display table table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th style="background-color:#000; color:#fff">Sl</th>
                <th style="background-color:#000; color:#fff">Product Id</th>
                <th style="background-color:#000; color:#fff">Name</th>
                <th style="background-color:#595959; color:#fff">Subscription Fee</th>
                <th style="background-color:#FF0000; color:#fff">Commission</th>
                <th style="background-color:#818E56; color:#fff">Logistics</th>
                <th style="background-color:#953822; color:#fff">Advertisement</th>
                <th style="background-color:#538DD3; color:#fff">SMM</th>
                <th style="background-color:#A5A8AD; color:#fff">Pusher</th>
                <th style="background-color:#000; color:#fff">Total</th>
            </tr>
        </thead>

        <tbody>
        <?php $i=0; $totalSubscription=$totalCommission=$totalLogistic=$totalSmm=$totalAmount=$totalAdvertise=$totalPusher=0; ?>
        @foreach($data as $product_name=>$val)
        <tr>
        	<td><? echo ++$i; ?></td>
        	<td>{{ $val['product_id'] }}</td>
        	<td>{{ $product_name }}</td>
        	<td>{{ $val['subscription'] }}</td>
        	<td>{{ $val['commission'] }}</td>
            <td>{{ $val['logistic'] }}</td>
        	<td>{{ $val['advertise'] }}</td>
            <td>{{ $val['smm'] }}</td>
        	<td>{{ $val['pusher'] }}</td>
        	<td>{{ $total=$val['subscription']+$val['commission']+$val['logistic']+$val['smm']+$val['advertise']+$val['pusher'] }}</td>
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
                <th>Total</th>
                <th><span>&nbsp;&nbsp;&nbsp;</span> </th>
                <th><span>&nbsp;&nbsp;&nbsp;</span> </th>
                <td><span>RM&nbsp;&nbsp;&nbsp;</span>{{ number_format($totalSubscription,2) }}</td>
                <td><span>RM&nbsp;&nbsp;&nbsp;</span> {{ number_format($totalCommission,2) }}</td>
                <td><span>RM&nbsp;&nbsp;&nbsp;</span> {{ number_format($totalLogistic,2) }}</td>
                <td><span>RM&nbsp;&nbsp;&nbsp;</span> {{ number_format($totalAdvertise,2) }}</td>
                <td><span>RM&nbsp;&nbsp;&nbsp;</span> {{ number_format($totalSmm,2) }}</td>
                <td><span>RM&nbsp;&nbsp;&nbsp;</span> {{ number_format($totalPusher,2) }}</td>
                <td><span>RM&nbsp;&nbsp;&nbsp;</span> {{ number_format($totalAmount,2) }}</td>
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


