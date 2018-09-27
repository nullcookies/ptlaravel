<?php use App\Http\Controllers\IdController;?>
<?php
use App\Http\Controllers\UtilityController;
use App\Classes;
?>
@extends("common.default")
@section("content")
<style>
.imagePreviewNeutral {
  width: 50px;
  height: 50px;
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

</style>
<div class="col-sm-12" style="padding-left:1; padding-right:0; min-height: 500px;">
	<h2 align="center">AutoLink</h2>
	<span  id="error-messages">
    </span>	
	<br>
	{{-- zxcv --}}
	@if(! empty($autolinks))
		@foreach($autolinks as $link)
			<div id="div{{$link['id']}}">
				<div class="row"> 	
					<?php 
						$ourl="";
						if(isset($img)){
							unset($img);
						}
						$merchanto = DB::table('merchantoshop')->where('merchant_id',$link['merchant_id'])->first();
						$merchantp = DB::table('merchantproduct')->where('merchant_id',$link['merchant_id'])->first();
						$osid = 0;
						if(!is_null($merchantp)){
							$pp = DB::table('product')->where('id',$merchantp->product_id)->first();
							$img = "images/product/" . $pp->id . "/" . $pp->photo_1;
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
					<div class="col-xs-2">
						<a href="{{route('oshop.one',['url'=>$ourl])}}" target="_blank"><div class="imagePreviewNeutral imageautolink" id="imageautolink" rel="{{$link['merchant_id']}}"
							style="background-size:cover;
							background-position: center top;
							background-image: url('{{asset($img)}}');">
						</div>	</a>			
					</div>
					@else
					<div class="col-xs-2">
						<a href="{{route('oshop.one',['url'=>$ourl])}}" target="_blank"><div class="imagePreviewNeutral imageautolink" id="imageautolink" rel="{{$link['merchant_id']}}"
							style="background-size:cover;
							background-position: center top;">
						</div></a>					
					</div>						
					@endif
					<div class="col-xs-6">
						<h5 style="vertical-align:middle;">{{$link['mname']}}</h5>
						@if ($link['status'] == 'linked')
							<h5 style="color: green;">Linked</h5>
						<?php
								echo "Since: ".
									UtilityController::s_datenotime($link['linked_since']);
						?>							
						@else
							<h5 style="color: red;">Awaiting</h5>
						@endif						
					</div>
					<div class="col-xs-4">
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
	@else	
	<div id='alert' class="cart-alert alert alert-warning" role="alert" style="border-color: red;">
	<strong><h4><a href="#">
		<b style="color: red;">
			No autolinks to display
		</b></a></h4>
	</strong>
	</div>
	@endif
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
		
		
    var signal = 'red';
    var intervalId = 1;
    var currentElement;
    var url;
    $(document).on("click", ".role_status_button_autolink", function () {
        currentElement = $(this);
        var doStatus = $(currentElement).attr('do_status');
        var role = $(currentElement).attr('role');

        if (role == 'autolink') {
            url = JS_BASE_URL + '/admin/master/approveAutolinkb';
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
								$("#div" + role_id).hide();
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
			
	});
</script>
@stop