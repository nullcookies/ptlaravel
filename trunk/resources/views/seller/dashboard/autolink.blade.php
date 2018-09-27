<?php
use App\Http\Controllers\UtilityController;
use App\Classes;
?>
<style>
.imagePreviewNeutral {
  width: 150px;
  height: 150px;
  background-position: center top;
  background-repeat: no-repeat;
  -webkit-box-shadow: 0 0 1px 1px rgba(0, 0, 0, .3);
  background-color: #e7e7e7;
  border: 1px solid;
  display: inline-block;
  margin-bottom: 5px;
  border-color: #d0d0d0;
}

hr{
	border-top-color: #5F6879;
	margin-top: 0px;

}
.imageautolink{
	cursor: pointer;
}
<style type="text/css">
.action_buttons{
	display: flex;
}
.role_status_button_autolink{
	margin: 10px 0 0 10px;
	width: 85px;
}
</style>
<div class="modal fade" id="myModalRemarks" role="dialog" aria-labelledby="myModalRemarks">
	<div class="modal-dialog" role="remarks" style="width: 50%">
		<div class="modal-content">
			<div class="row" style="padding: 15px;">
				<div class="col-md-12" style="">
					<form id="remarks-form">
						<fieldset>
							<h2>Remarks</h2>
							<br>
							<textarea style="width:100%; height: 250px;" name="name" id="status_remarks" class="text-area ui-widget-content ui-corner-all">
							</textarea>
							<br>
							<input type="button" id="save_remarks_autolink" class="btn btn-primary" value="Save Remarks">
							<input type="hidden" id="current_role_roleId" remarks_role="" >
							<input type="hidden" id="current_status" value="" >
						</fieldset>
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>				
		</div>			
	</div>	
</div>
<div style="display: none;" class="removeable alert">
    <strong id='alert_heading'></strong><span id='alert_text'></span>
</div>
<div class="col-sm-12" style="padding-left:0">
	<h2>AutoLink</h2>
	<span  id="error-messages">
    </span>		
	<br>
	{{-- zxcv --}}
    <?php 
    $station=null;
    ?>
	@if(! empty($autolinks))
		@foreach($autolinks as $link)
		<?php 
			if(is_null($link->photo_1) || $link->photo_1 == ""){
				$img = null; 
			} else {
				$img = "images/users/" . $link->user_id . "/" . $link->photo_1; 
			}
		?>
		<div id="div{{$link->id}}">
		<div class="row"> 	
			<?php 
				$station = null;
				$merchant = null;
				$sproperty = null;
				$rel = $link->user_id;
				$drel = 1;
				$merchant = DB::table('merchant')->where('user_id',$link->user_id)->first();
				if(!is_null($merchant)){
					$rel = $merchant->id;
					$drel = 2;
					$merchantp = DB::table('merchantproduct')->where('merchant_id',$merchant->id)->first();
					if(!is_null($merchantp)){
						$pp = DB::table('product')->where('id',$merchantp->product_id)->first();
						$img = "images/product/" . $pp->id . "/" . $pp->photo_1;
					}					
				} else {
					$station = DB::table('station')->where('user_id',$link->user_id)->first();
					if(!is_null($station)){
						$rel = $station->id;
						$drel = 3;						
						$stationp = DB::table('sproduct')->join('stationsproduct','stationsproduct.sproduct_id','=','sproduct.id')->where('stationsproduct.station_id',$station->id)->first();
						if(!is_null($stationp)){
							$pp = DB::table('product')->where('id',$stationp->product_id)->first();
							$img = "images/product/" . $pp->id . "/" . $pp->photo_1;
						}					
					} 					
				}
				

	
			?>
			@if(isset($img) && !is_null($img))
			<div class="col-sm-3">
				<div class="imagePreviewNeutral imageautolink" id="imageautolink" rel="{{$rel}}" drel="{{$drel}}"
					style="background-size:cover;
					background-position: center top;
					background-image: url('{{asset($img)}}');">
				</div>				
			</div>
			@else
			<div class="col-sm-3">
				<div class="imagePreviewNeutral imageautolink" id="imageautolink" rel="{{$rel}}" drel="{{$drel}}"
					style="background-size:cover;
					background-position: center top;">
				</div>				
			</div>						
			@endif		
			<div class="col-sm-5" style="height: 150px; padding: 45px 0;">
				@if(is_null($link->sproperty_id))
					<h3 style="vertical-align:middle;">
					@if($ishybrid)
						<span style="color: green"><b>[In]</b></span>
					@endif
					{{$link->first_name}} {{$link->last_name}}</h3>
					<?php
						if (!is_null($station) &&
							!is_null($station->station_name)) {
							echo "<h4>$station->station_name</h4>";
						}
						if ($link->created_at != "0000-00-00 00:00:00") {
							echo "Since: ".
								UtilityController::s_datenotime($link->created_at);
						}
					?>
				@else
					<?php
						$sproperty = DB::table('sproperty')->where('id',$link->sproperty_id)->first();
						if(!is_null($sproperty)){				
						
					?>
					<h3 style="vertical-align:middle;">
						@if($ishybrid)
							<span style="color: green"><b>[In]</b></span>
						@endif					
						{{$sproperty->prop_owner_first_name}} {{$sproperty->prop_owner_last_name}}</h3>
						<h4>{{$sproperty->outlet_name}}</h4>
					<?php 
						}
						if ($link->created_at != "0000-00-00 00:00:00") {
							echo "Since: ".
								UtilityController::s_datenotime($link->created_at);
						}						
					?>
				@endif
			</div>
			<div class="col-sm-4" style="height: 150px; padding: 45px 0;">
				<div class="action_buttons">
					<?php
						echo Classes\Approval::autolink($link->status, 'autolink',$link->id);
					?>
				</div>		
			</div>	
			</div>		
			<hr>
		</div>				
		@endforeach
	@endif
	@if(! empty($autolinksb))
		@foreach($autolinksb as $link)
			<div id="div{{$link['id']}}">
				<div class="row"> 	
					<?php 
						if(isset($img)){
							unset($img);
						}
						$merchanto = DB::table('merchantoshop')->where('merchant_id',$link['merchant_id'])->first();
						$merchantp = DB::table('merchantproduct')->where('merchant_id',$link['merchant_id'])->first();
						$osid = 0;
						if(!is_null($merchantp)){
							$pp = DB::table('product')->where('id',$merchantp->product_id)->first();
							if(!is_null($pp)){
								$img = "images/product/" . $pp->id . "/" . $pp->photo_1;
							}
						}	
						if(!is_null($merchanto)){
							$osid = $merchanto->oshop_id;
							$realoshop = DB::table('oshop')->where('id',$osid)->first();
							$ourl = "error";
							if(!is_null($realoshop)){
								$ourl = $realoshop->url;
							}
						}
					?>
					@if(isset($img))
					<div class="col-sm-3">
						<a href="{{route('oshop.one',['url'=>$ourl])}}" target="_blank"><div class="imagePreviewNeutral imageautolink" id="imageautolink" rel="{{$link['merchant_id']}}"
							style="background-size:cover;
							background-position: center top;
							background-image: url('{{asset($img)}}');">
						</div>	</a>			
					</div>
					@else
					<div class="col-sm-3">
						<a href="{{route('oshop.one',['url'=>$ourl])}}" target="_blank"><div class="imagePreviewNeutral imageautolink" id="imageautolink" rel="{{$link['merchant_id']}}"
							style="background-size:cover;
							background-position: center top;">
						</div></a>					
					</div>						
					@endif
					<div class="col-sm-5" style="height: 150px; padding: 45px 0;">
						<h3 style="vertical-align:middle;">
							@if($ishybrid)
								<span style="color: blue"><b>[Out]</b></span>
							@endif
							{{$link['mname']}}
						</h3>
						@if($link['status'] == 'linked')
							<h5 style="color: green;" id="status{{$link['id']}}">Linked</h5>
						<?php
								echo "<span id='since". $link['id'] ."'>Since: ".
									UtilityController::s_datenotime($link['linked_since']) . "</span>";
						?>	
						@elseif($link['status'] == 'suspended')
							<h5 style="color: red;" id="status{{$link['id']}}">Suspended</h5>
						<?php
								echo "<span id='since". $link['id'] ."' style='display: none;'>Since: ".
									UtilityController::s_datenotime($link['linked_since']) . "</span>";
						?>						
						@else
							<h5 style="color: red;">Awaiting</h5>
						@endif							
					</div>
					<div class="col-sm-4" style="height: 150px; padding: 45px 0;">
						<div class="action_buttons">
							<?php
								echo Classes\Approval::autolinkb($link['status'], 'autolink',$link['id']);
							?>
						</div>		
					</div>	
				</div>	
				<hr>
			</div>		
		@endforeach
	@endif	
	@if(empty($autolinksb) && empty($autolinks))	
	<div id='alert' class="cart-alert alert alert-warning" role="alert" style="border-color: red;">
	<strong><h4><a href="#">
		<b style="color: red;">
			No AutoLinks to display
		</b></a></h4>
	</strong>
	</div>
	@endif
	<?php 
		$isadmin = 0;
		if(Auth::user()->hasRole('adm')){
			$isadmin = 1;
		}
	?>
	<input type="hidden" value="{{$isadmin}}" id="isadmin" />
</div>

<script>
	$(document).ready(function () {
		window.setInterval(function(){
          $('#error-messages').empty();
        }, 10000);		
		
	/*	$('.imageautolink').click(function(){

		var id=$(this).attr('rel');
		var check_url=JS_BASE_URL+"/admin/popup/lx/check/merchant/"+id;
		$.ajax({
			url:check_url,
			type:'GET',
			success:function (r) {
			console.log(r);
			
			if (r.status=="success") {
			var url=JS_BASE_URL+"/admin/popup/merchant/"+id;
				var w=window.open(url,"_blank");
				w.focus();
			}
			if (r.status=="failure") {
			var msg="<div class=' alert alert-danger'>"+r.long_message+"</div>";
			$('#error-messages').html(msg);
			}
			}
			});
		});		*/			
	});
</script>
<script type="text/javascript">
	$(document).ready(function () {
		
		window.setInterval(function(){
          $('#error-messages').empty();
        }, 10000);		
		
		$('.imageautolink_changed').click(function(){

			var id=$(this).attr('rel');
			var role=$(this).attr('drel');
			if(role == 1){
				var url=JS_BASE_URL+"/admin/popup/user/"+id;
					var w=window.open(url,"_blank");
					w.focus();			
			} else if(role == 2){
				var check_url=JS_BASE_URL+"/admin/popup/lx/check/merchant/"+id;
				$.ajax({
					url:check_url,
					type:'GET',
					success:function (r) {
					console.log(r);
					
					if (r.status=="success") {
					var url=JS_BASE_URL+"/admin/popup/merchant/"+id;
						var w=window.open(url,"_blank");
						w.focus();
					}
					if (r.status=="failure") {
					var msg="<div class=' alert alert-danger'>"+r.long_message+"</div>";
					$('#error-messages').html(msg);
					}
					}
				});				
			} else if(role == 3){
				var check_url=JS_BASE_URL+"/admin/popup/lx/check/station/"+id;
				var isadmin = parseInt($("#isadmin").val());
				$.ajax({
					url:check_url,
					type:'GET',
					success:function (r) {
						if (r.status=="success") {
							if(isadmin == 0){
								var url=JS_BASE_URL+"/admin/popup/infostation/"+id;
							} else {
								var url=JS_BASE_URL+"/admin/popup/station/"+id;
							}
						
						var w=window.open(url,"_blank");
						w.focus();
						}
						if (r.status=="failure") {
							var msg="<div class='alert alert-danger'>"+r.long_message+"</div>";
							$('#station-error-messages').html(msg);
						}
					}
				});				
			}

		});			
		
    var signal = 'red';
    var intervalId = 1;
    var currentElement;
    var url;
    $(document).on("click", ".role_status_button_autolink", function () {
        currentElement = $(this);
        var doStatus = $(currentElement).attr('do_status');
        var role = $(currentElement).attr('role');

        if (role == 'autolink') {
            url = JS_BASE_URL + '/admin/master/approveAutolink';
        }

        var role_id = $(currentElement).attr('current_role_id');

        $('#current_role_roleId').val(role_id);
        $('#current_status').val(doStatus);
        $('#current_role_roleId').attr('remarks_role', role);
		
        //$("#myModalRemarks").modal('toggle');
		approveAutolink(role_id, doStatus, role, url, currentElement)

    });

    function approveAutolink(role_id, doStatus, role, url, currentElement) {
        //dialog.dialog("open");
        //intervalId = setInterval(function () {
            //if (signal == 'green') {
                //clearInterval(intervalId);
                $.ajax({
                    url: url,
                    type: 'POST',
                    dataType: 'json',
                    data: {id: role_id, doStatus: doStatus, role: role},
                    success: function (response) {
                        if (response.success == 'TRUE') {
                            var statusColumn = $(currentElement).parent('.action_buttons').parent('td').siblings('#status_column').children('#status_column_text');
                            $(currentElement).parent('.action_buttons').fadeOut(2000, function () {
                                $(currentElement).parent('.action_buttons').html(response.view);
                                $(statusColumn).fadeOut('fast');
                                doStatus = doStatus.toLowerCase().replace(/\b[a-z]/g, function (letter) {
                                    return letter.toUpperCase();
                                });
                                $(statusColumn).text(doStatus);
                                $(statusColumn).fadeIn(2000);
                                $('#overlay_spinner_'+role_id).hide();
                                $('#alert_heading').text('Success! ');
                                $('#alert_text').text('Status Changed Successfully');
                                $('.removeable').removeClass('alert-danger');
                                $('.removeable').addClass('alert-success');
                            });
							console.log(doStatus);
							if(doStatus == "unlinked"){
								$("#div" + role_id).fadeOut(2000, function () {
									
								});
							} else if(doStatus == "suspended"){
								$("#status" + role_id).fadeOut(2000, function () {
									$(this).html("Suspended");
									$(this).attr("style","color: red;");
									$(this).fadeIn(2000, function () {});
								});
								$("#since" + role_id).fadeOut(4000, function () {
								});
							}else if(doStatus=="remove"){
								$("#div" + role_id).fadeOut(2000, function () {
									
								});
							}

							else if(doStatus == "linked"){
								$("#status" + role_id).fadeOut(2000, function () {
									$(this).html("Linked");
									$(this).attr("style","color: green;");
									$(this).fadeIn(2000, function () {});
								});
								$("#since" + role_id).fadeIn(4000, function () {
								});
							}
                            $(currentElement).parent('.action_buttons').fadeIn(2000);
                        } else if (response.success == 'False') {
                            $('#alert_heading').text('Error!');
                            $('#alert_text').text('Unable to change stauts');
                            $('.removeable').removeClass('alert-success');
                            $('.removeable').addClass('alert-danger');
                        }

                    }, complete: function () {
                        $('.removeable').show();
                        setTimeout(removeMessage, 5000);
                    }
                });
            //}
        //}, 500);
    }

    function suspendOrRejectAutolink(role_id, doStatus, role, url, currentElement) {
        //dialog.dialog("open");
        //intervalId = setInterval(function () {
            //console.log("pas2s");
            checkSignalAutolink(role_id, doStatus, role, url, currentElement)
        //}, 500);
    }

    function checkSignalAutolink(role_id, doStatus, role, url, currentElement) {
        //if (signal == 'green') {
            //clearInterval(id);

            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                data: {id: role_id, doStatus: doStatus, role: role},
                error: function(response){
                    console.log(response);
                },
                success: function (response) {

                    if (response.success == 'TRUE') {
                        var statusColumn = $(currentElement).parent('.action_buttons').parent('td').siblings('#status_column').children('#status_column_text');
                        var remarksColumn = $(currentElement).parent('.action_buttons').parent('td').siblings('#remarks_column').children('#remarks_text');
                        $(currentElement).parent('.action_buttons').fadeOut(2000, function () {
                            $(currentElement).parent('.action_buttons').html(response.view);
                            $(statusColumn).fadeOut('fast');
                            $(remarksColumn).fadeOut('fast');
                            doStatus = doStatus.toLowerCase().replace(/\b[a-z]/g, function (letter) {
                                return letter.toUpperCase();
                            });
                            $(statusColumn).text(doStatus);
                            $(remarksColumn).text(response.roleData.remarks);
                            $(statusColumn).fadeIn(2000);
                            $(remarksColumn).fadeIn(2000);
                            $('#overlay_spinner_'+role_id).hide();
                            $('#alert_heading').text('Success!');
                            $('#alert_text').text('Staus Changed Successfully');
                            $('.removeable').removeClass('alert-danger');
                            $('.removeable').addClass('alert-success');
                        });
                        $(currentElement).parent('.action_buttons').fadeIn(2000);
                    } else if (response.success == 'False') {
                        $('#alert_heading').text('Error!');
                        $('#alert_text').text('Unable to change stauts');
                        $('.removeable').removeClass('alert-success');
                        $('.removeable').addClass('alert-danger');
                    }

                }, complete: function () {
                    $('.removeable').show();
                    setTimeout(removeMessage, 5000);
                    //signal = 'red';
                }
            });
        //}
    }

    function removeMessage() {
        $('.removeable').hide();
    }

    $('#save_remarks_autolink').click(function () {
        if (!$.trim($('#status_remarks').val())) {
            alert('Enter Remarks Please');
            return false;
        } else {
            var roleId = $('#current_role_roleId').val();
            var dostatus = $('#current_status').val();
            var role = $('#current_role_roleId').attr('remarks_role');
            var remarks = $('#status_remarks').val();
            var url2;
            if (role == 'autolink') {
                url2 = JS_BASE_URL + '/admin/master/saveAutolinkRemarks';
            }
            $.ajax({
                url: url2,
                type: 'POST',
                dataType: 'json',
                data: {id: roleId, remarks: remarks, role: role, status: dostatus},
                success: function (response) {
                    $("#myModalRemarks").modal('toggle');
					$('#overlay_spinner_'+roleId).show();
                    //signal = 'green';
                    $('#mcrid_'+roleId).html(remarks);
                    $('#remarks-form')[0].reset();
                }
            });
            if (dostatus == 'unlinked') {
                suspendOrRejectAutolink(roleId, dostatus, role, url, currentElement);
            } else {
                approveAutolink(roleId, dostatus, role, url, currentElement);
            }

        }
    });

    var dialog = $("#dialog-form-autolink").dialog({
        autoOpen: false,
        height: 400,
        width: 650,
        modal: true,
        close: function () {
            dialog.dialog("close");
            //$('#dialog-form-autolink')[0].reset();
        }
    });

    $(document).on('click', '.ui-dialog-titlebar-close', function () {
        $('#overlay_spinner').hide();
        $('#remarks-form')[0].reset();
    });

    $(document).delegate( '.mcrid', "click",function (event) {
        _this = $(this);
        var id_autolink= _this.attr('rel');

        $('#modal-Tittle2').html("Remarks");

        var url = '/admin/master/autolink_remarks/'+ id_autolink;
        $.ajax({
            type: "GET",
            url: url,
            dataType: 'json',
            success: function (data) {
                //console.log(data);
                var html = "<table class='table table-bordered' cellspacing='0' width='100%' ><tr style='background-color: #FF4C4C; color: white;'><th class='text-center'>No</th><th class='text-center'>Merchant&nbsp;ID</th><th class='text-center'>Status</th><th class='text-center'>Admin&nbsp;User&nbsp;ID</th><th class='text-center'>Remarks</th><th class='text-center'>DateTime</th></tr>";
                for (i=0; i < data.length; i++) {
                    var obj = data[i];
                    html += "<tr>";
                    html += "<td class='text-center'>"+(i+1)+"</td>";
                    html += "<td class='text-center'><a href='../../admin/popup/merchant/"+id_autolink+"' class='update' data-id='"+id_autolink+"'>["+pad(id_autolink.toString(),10)+"]</a></td>";
                    html += "<td class='text-center'>"+ucfirst(obj.status)+"</td>";
                    html += "<td class='text-center'><a href='../../admin/popup/user/"+obj.user_id+"' class='update' data-id='"+obj.user_id+"'>["+pad(obj.user_id.toString(),10)+"]</td>";
                    html += "<td>"+obj.remark+"</td>";
                    html += "<td class='text-center'>"+obj.created_at+"</td>";
                    html += "</tr>";
                }
                html = html + "</table>";
                $('#myBody2').html(html);
                $("#myModal2").modal("show");
            }
        });
    });	
});

</script>
