
<?php use App\Http\Controllers\IdController; ?>
<div class="col-sm-12">
	<h2>Cancellation, Return &amp; Exchange </h2>
    <div class="tableData">
        <div class="table-responsive1">
            <table class="table table-bordered" cellspacing="0" width="100%" id="cre_details_table">
                <thead>
                <style type="text/css">
                                .sort{color: black;}              
                </style>
                    <tr style="background-color:#D8E26D; color: black;">
                        <th class="no-sort text-center no-sort">NO.</th>
                        <th>CRE&nbsp;ID</th>
                        <th>Order&nbsp;ID</th>
                        <th>Product&nbsp;ID</th>
                        <th>Buyer&nbsp;ID</th>
                        <th>Name</th>
                        <th>Contact</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>I&nbsp;wish&nbsp;to</th>
                        <th>Reason</th>
                        <th>Photo</th>
                    </tr>
                <thead>
                <tbody>
                @if(isset($cre))
                    @foreach($cre as $record)
                    <tr>
                        <td style="text-align: center;">
                            {{$i++}}
                        </td>
						<td>{{ $record->id }}</td>
						<td>{{ IdController::nO($record->porder_id)}}</td>
						<td>{{ IdController::nP($record->product_id)}}</td>
						<td>{{ IdController::nB($record->user_id)}}</td>
						<td>{{ $record->name }}</td>
						<td>{{ $record->phone }}</td>
						<td>{{ $record->email }}</td>
						<td>{{ ucfirst($record->status)}}</td>
						<td>{{ ucfirst($record->iwishto)}}</td>
						<td>{{ ucfirst($record->reason_text)}}</td>
						<td>
						  <a href="javascript:void(0);" class="view-cre-gallery-modal" data-cre-id="{{$record->id}}">Photo</a>
						</td>
                    </tr>
                    @endforeach
                  @endif
                </tbody>
            </table>
        </div>
        <script type="text/javascript">
            $(document).ready(function(){
                $('.view-cre-gallery-modal').click(function () {
                    var cre_id=$(this).attr('data-cre-id');
                    var url=JS_BASE_URL+"/admin/master/cre/reasons/"+cre_id+"/images";
                    var w=window.open(url,"_blank");
                    w.focus();
                });
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
        </script>

    </div>
</div>