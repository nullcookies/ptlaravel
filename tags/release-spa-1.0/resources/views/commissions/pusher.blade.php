<h2>Professional Integrator Commission Master</h2>
<div class="table-responsive">
	<table class="table table-bordered" cellspacing="0" width="100%" id="grid6c">
		<thead style="background-color: #cc99ff; color: #fff;">
			<tr>
				<th class="text-center">No</th>
				<th class="text-center">PI&nbsp;ID</th>
				<th class="text-center">Name</th>
				<th class="text-center">Commission</th>
			</tr>
		</thead>
		<tbody>
			@foreach($merchantpusher as $merchantp)
			<tr>
				<td class="text-cener">
					{{$i++}}
				</td>

				<td class="text-cener">
					<?php $formatted_merchantp_id = str_pad($merchantp->id, 10, '0', STR_PAD_LEFT); ?>
					<a class="pusherm" id="{{$merchantp->id}}" href="javascript:void(0)">[{{$formatted_merchantp_id}}]</a>
				</td>

				<td>
					{{$merchantp->first_name}} {{$merchantp->last_name}}
				</td>

				<td class="text-center">
					 Variable
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 50%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Merchants</h4>
            </div>
            <div class="modal-body">
                <h3 id="modal-Tittle"></h3>
                <div class="table-responsive">
                    <table id="myTable" class="table table-bordered myTable"></table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>

        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="myModal2" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 50%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Products</h4>
            </div>
            <div class="modal-body">
                <h3 id="modal-Tittle2"></h3>
                <div class="table-responsive">
                    <table id="myTable2" class="table table-bordered myTable2"></table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>

        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function () {
	function pad (str, max) {
	  str = str.toString();
	  return str.length < max ? pad("0" + str, max) : str;
	}
	
	$('#grid6c').DataTable({
		'scrollX':true,
		 'autoWidth':false,
		 "order": [],
		 "columns": [
			{ "width": "20px", "orderable": false },
			{ "width": "85px" },
			null,
			{ "width": "85px" }
		  ]
	});	
	
	var table_modal;

	$(".pusherm").click(function () {

		$('#modal-Tittle').html("");

		if(table_modal){
			table_modal.destroy();
			$('#myTable').empty();
		}

		_this = $(this);

		var id_pusher= _this.attr('id');
		
		var url = '/admin/commission/pushermerchants/'+ id_pusher;

		$.ajax({
			type: "GET",
			url: url,
			dataType: 'json',
			success: function (data) {
				$('#modal-Tittle').append("PI ID: i"+pad(id_pusher,10)+"]");
				console.log(data);
				$('#myTable').append('<thead style="background-color: #cc99ff; color: #fff;"><th class="text-center">No</th><th class="text-center">Merchant ID</th><th>Name</th><th>Commission</th></thead>');
				$('#myTable').append('<tbody>');
				for (i=0; i < data.length; i++) {
					var obj = data[i];
					$('#myTable').append('<tr><td class="text-center">'+(i+1)+'</td><td class="text-center"><a id="'+obj.mid+'" class="mproducts" href="javascript:void(0)">['+pad(obj.mid,10)+']</a></td><td>'+obj.mname+'</td><td><p>Variable</p></td></tr>');
				}
				$('#myTable').append('</tbody>');

				table_modal = $('#myTable').DataTable({
					'autoWidth':false,
					 "order": [],
					 "iDisplayLength": 10,
					 "columns": [
						{ "width": "20px", "orderable": false },
						{ "width": "85px" },
						{ "width": "85px" },
						{ "width": "85px" }
					  ]
				});

				$("#myModal").modal("show");	

				var table_modal2;
				
				$(".mproducts").click(function () {

					$('#modal-Tittle2').html("");
					
							if(table_modal2){
								table_modal2.destroy();
								$('#myTable2').empty();
							}

							_this = $(this);

							var id_merchant= _this.attr('id');
							
							var url = '/admin/commission/merchantpusher/'+id_merchant;
							
							var urlbase = $('meta[name="base_url"]').attr('content');

							$.ajax({
								type: "GET",
								url: url,
								dataType: 'json',
								success: function (data) {

									$('#modal-Tittle2').append("Merchant ID: "+id_merchant);
									console.log(data);
									$('#myTable2').append('<thead style="background-color: #cc99ff; color: #fff;"><th>No</th><th>Product ID</th><th>Name</th><th>Commission</th><th>Edit</th></thead>');
									$('#myTable2').append('<tbody>');
									for (i=0; i < data.length; i++) {
										var obj = data[i];
										$('#myTable2').append('<tr><td>'+(i+1)+'</td><td><a href="'+urlbase+'/productconsumer/'+obj.pid+'">['+pad(obj.pid,10)+']</a></td><td>'+obj.pname+'</td><td><p id="mv_p'+ obj.pid +'">'+obj.osmall_commission+'%</p><p id="mv_i'+ obj.pid +'" style="display:none;"><input type="text" value="'+obj.osmall_commission+'" id="mv_c'+ obj.pid +'" size="2"/>% <a class="btn btn-primary mv_btnedit" href="javascript:void(0)" rel="'+ obj.pid +'" > Save</a></p></td><td><a rel="'+obj.pid+'" class="mv_edit" href="javascript:void(0)">Edit</a></td></tr>');
									}
									$('#myTable2').append('</tbody>');

									table_modal2 = $('#myTable2').DataTable({
										'autoWidth':false,
										 "order": [],
										 "iDisplayLength": 10,
										 "columns": [
											{ "width": "20px", "orderable": false },
											{ "width": "85px" },
											{ "width": "85px" },
											{ "width": "55px" },
											{ "width": "55px" }
										  ]
									});

									$("#myModal2").modal("show");
									
									$(".mv_edit").click(function(){
										_this = $(this);
										var mv_id= _this.attr('rel');
										$("#mv_p" + mv_id).hide();
										$("#mv_i" + mv_id).show();
									});
									
									$('.mv_btnedit').click(function(){
										_this = $(this);
										var mv_id= _this.attr('rel');
										var commission = $('#mv_c' + mv_id).val();
										if($.isNumeric(commission)){
											var url = '/admin/commission/productpusheredit/'+ mv_id;
											$.ajax({
											  url: url,
											  type: "post",
											  data: {'commission': commission},
											  success: function(data){
												$("#mv_p" + mv_id).show();
												$("#mv_i" + mv_id).hide();
												$("#mv_p" + mv_id).text(commission + "%");
											  }
											});				
										} else {
											alert("Invalid Number!");
										}      
									});	
								},
								error: function (error) {
									console.log(error);
								}
							});	
						});	
									
			},
			error: function (error) {
				console.log(error);
			}

		});
	});		
});
</script>
