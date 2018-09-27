<?php 
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\IdController;
use App\Classes;
?>
<?php $i = 0;$c = 1;?>
<style>
    th , td{
        text-align: center;
    }
    .p{
        text-align: right;
    }
    thead{
        margin: 5px;
}
</style>
     <div id="" class="tab-content">
         <div id="sell" class="tab-pane fade in active">
            <table class="table-bordered"  id="wishtTable" width="100%">
                <thead style="background-color: #F29FD7;color:white">
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Product&nbsp;ID</th>
                        <th class="text-center">Name&nbsp;Date</th>       
                        <th class="text-center">Quantity</th>
                    </tr>
                </thead>
                <tbody>   
                    @foreach($wishlist as $wish)
                            <tr>
                                <td class="text-center">{{$c++}}</td>
								<td class="text-center">
									{{IdController::nP($wish->id)}}</td>
                                <td class="text-center">
									{{$wish->name}}</td>
                                <td class="text-right p">
									{{$wish->wish}}</td>
                            </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
     </div>	
<script>
$(document).ready(function () {
	$("#myModalLabel2").text("Station Invoices");
	$("#sell").show();
	$("#buy").css("position" ,"absolute");
	$("#buy").show();
	$('#wishtTable').dataTable().fnDestroy();
	$('#wishtTable').DataTable({
	"order": [],
	"columnDefs": [ {
	"targets" : 0,
	"orderable": false
	}]
   });

	$("#b_tab").click(function(){
		$("#buy").css("position" ,"relative");
	});
	$("#s_tab").click(function(){
		$("#buy").css("position" ,"absolute");
	});
});
</script>	 
