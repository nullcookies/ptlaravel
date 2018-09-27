<?php
use App\Classes;
use App\Classes\Approval;
use App\Http\Controllers\IdController;
use App\Http\Controllers\UtilityController;
// use DB;
$global=DB::table('global')->first();
?>
<link rel="stylesheet" type="text/css" href="{{asset('css/socialbutton')}}">
@extends("common.default")

@section("content")
    <style type="text/css">
        .overlay{
            background-color: rgba(1, 1, 1, 0.7);
            bottom: 0;
            left: 0;
            position: fixed;
            right: 0;
            top: 0;
            z-index: 1001;
        }
        .overlay p{
            color: white;
            font-size: 72px;
            font-weight: bold;
            margin: 300px 0 0 55%;
        }

        .action_buttons{
            display: flex;
        }
        .role_status_button{
            margin-top: 10px;
            width: 100px;
        }
        .small-act-link:hover{
            text-decoration: underline;
        }
    </style>
    <?php $i=1; ?>
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
								<input type="button" id="save_remarks" class="btn btn-primary" value="Save Remarks">
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

    <div class="overlay" style="display:none;">
        <p><span style="position: relative;" class="all-filter-fa"><i class="fa-li fa fa-spinner fa-spin fa fa-fw"></i></span></p>
    </div>
    <div style="display: none;" class="removeable alert">
        <strong id='alert_heading'></strong><span id='alert_text'></span>
    </div>

    <div class="container" style="margin-top:30px; margin-bottom:30px;">
        @include('admin/panelHeading')
                

                        <h2>Social Media Marketeer Master &nbsp;<small style="font-size:.4em;" class="small-act-link"><a href="javascript:void(0);" class="smm-mode-change" data-id="1" >Refresh</a></small></h2>
<?php $i=1;?><table class="table table-bordered" cellspacing="0" width="2500px;" id="product_details_table">
                                <thead style="background-color:#558ED5; color:#fff;">
                                {{-- <tr>
                                    <th colspan="4">Social Media Marketeer Master</th>
                                    <th colspan="7">Network Information</th>
                                    <th colspan="3">Geographical</th>
                                    <th colspan="3">Others</th>
                                </tr> --}}
                                <tr>
                                    <th class='no-sort'>No</th>
                                    <th>Buyer&nbsp;ID</th>
                                    <th style="width:200px;">Name</th>
                                    <th>Friends</th>
                                  
                                    {{-- <th>Clicked</th> --}}
                                  
                                    <th style="width:120px;">Last&nbsp;Share</th>
                                 
                                    {{-- <th>Source</th> --}}
                                    <th>Country</th>
                                    
                               <!--     <th class="xlarge" style="background-color:#008000;color:#fff">Remarks</th> -->
                                    <th style="background-color:#008000;color:#fff">Status</th>
                               <!--      <th style="background-color:#008000;color:#fff">Approval</th> -->
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($smmastereport as $report)
                                @if($report['user_id']==null)
                                <?php continue;?>
                                @endif
                                <tr>

                                    <td style="text-align: center;">
                                        {{$i++}}
                                    </td>
                                    <td>
                                     
                                            <a href="javascript:void(0);" class="view-user-modal" data-us-id="{{$report['user_id']}}">{{IdController::nB($report['user_id'])}}</a>
                                    </td>
                                    <td>
                                        {{$report['first_name']}} {{$report['last_name']}}
                                    </td>
                                    <td style="text-align: center;">
                                       <a href="javascript:void(0);" fb="{{$report['friends']}}" class="friends">{{$report['friends']}} </a>
                                    </td>
                                   
                                  {{--   <td style="text-align: center;">
                                        <a href="javascript:void(0);" class="clicked" uid="{{$report['user_id']}}" >{{$report['trans']['click']}}</a>
                                    </td> --}}
                                    <td style="text-align: center;">
                                    <a href="javascript:void(0);" class="share" uid="{{$report['user_id']}}" smmid="{{$report['user_id']}}">
                                    {{UtilityController::s_date($report['trans']['last_share'])}}
                                    {{-- {{ date('dMy h:m', strtotime($report['trans']['last_share'])) }} --}}
                                    </a>
                                    </td>
                               
                                   {{--  <td style="text-align: center;">
                                        {{$report['trans']['sme']}}
                                    </td> --}}

                                    <td style="text-align: center;">
                                        <a href="javascript:void(0);" class="country" state="{{$report['geo']['state']}}" city="{{$report['geo']['city']}}" area=" {{$report['geo']['area']}}">
                                        {{$report['geo']['country']}}</a>
                                    </td>

                                    <td id="status_column" class="text-center">
                                        <span id="status_column_text">
                                           <a target="_blank"  href="{{route('smmApproval', ['id' => $report['user_id']])}}"> {{ucfirst($report['status'])}} </a>
                                        </span>
                                    </td>


                                </tr>
                                @endforeach
                                </tbody>
                            </table>

<script type="text/javascript">
    $(document).ready(function(){
        $('.view-user-modal').click(function () {
            var user_id= $(this).attr('data-us-id');
            url=JS_BASE_URL+"/admin/popup/user/"+user_id;
            var w= window.open(url,"_blank");
            w.focus();
        });
    });
</script>
               
    </div>


    <div class="modal fade" id="myModal2" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document" style="width: 50%">
            <div class="modal-content" style='max-height: 500px; overflow-y: scroll;'>
                <div class="modal-body">
                  
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
                </form>

            </div>
        </div>
    </div>
<!-- Country Modal -->
<div class="modal fade" id="countryModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 50%">
        <div class="modal-content" style='max-height: 500px; overflow-y: scroll;'>
            <div class="modal-body">
             <table class="table">
                 <thead style="background-color:#558ED5; color:#fff;">
                 <tr>
                     <th>State</th>
                    <th style="width:120px;">City</th>
                    <th>Area</th>
                 </tr>
                 </thead>
                 <tbody>
                     <tr>
                         <td class="state"></td>
                         <td class="city"></td>
                         <td class="area"></td>
                     </tr>
                 </tbody>
             </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>

        </div>
    </div>
</div>
<!-- Friends Modal -->
<div class="modal fade" id="friendsModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 400px;">
        <div class="modal-content" style='max-height: 500px; overflow-y: scroll;'>
            <div class="modal-body">
            <table class="table">
                <tr>
                    <td style="background:#3b5998;color: #fff">
                        <span><span style="vertical-align: middle;">Facebook</span><span class="fb pull-right" style="padding-right: 10px;vertical-align: middle;"></span>
                    </td>
                </tr>
                 <tr>
                    <td style="background:#4dc247;color: #fff">
                        <span><span style="vertical-align: middle;">Whatsapp</span><span class=" pull-right" style="padding-right: 10px;vertical-align: middle;">0</span>
                    </td>
                </tr>
                 <tr>
                    <td style="background:#4dc247;color: #fff">
                        <span><span style="vertical-align: middle;">WeChat</span><span class=" pull-right" style="padding-right: 10px;vertical-align: middle;">0</span>
                    </td>
                </tr>
                <tr>
                    <td style="background:#E3AE57 ;color: #fff;">
                        <span>Total</span></i><span class=" pull-right fb" style="padding-right: 10px;vertical-align: middle;">0</span>
                    </td>
                </tr>
            </table>
               {{--  <dl class="dl-horizontal" style="">
                <dt style="background-color:#558ED5; color:#fff;padding: 10px; "><i class="fa fa-facebook"></i><span class="fb"></span></dt><dd></dd>
                <dt style="background-color:#558ED5; color:#fff;padding: 10px; text-align: center;">Whatsapp</dt><dd style="padding: 9px;border: 1px solid black;">0</dd>
                <dt style="background-color:#558ED5; color:#fff;padding: 10px; text-align: center;">Wechat</dt><dd style="padding: 9px;border: 1px solid black;">0</dd>
                <dt style="background-color:#558ED5; color:#fff;padding: 10px; text-align: center;">Total</dt><dd class="fb" style="padding: 9px;border: 1px solid black;"></dd> 
                </dl> --}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>

        </div>
    </div>
</div>
<!-- Status Modal -->
<div class="modal fade" id="statusModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 50%">
        <div class="modal-content" style='max-height: 500px; overflow-y: scroll;'>
            <div class="modal-body">
                <h3 id="modal-Tittle2"></h3>
                <div id="myBody2">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>

        </div>
    </div>
</div>
<!-- Clicked Modal -->
<div class="modal fade" id="clickedModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style='max-height: 500px; overflow-y: scroll;'>
            <div class="modal-body">
             <table class="table">
                 <thead style="background-color:#558ED5; color:#fff;">
                 <tr>
                 
                    <th>No.</th>
                    <th>Shared&nbsp;Date</th>
                    <th>Buyer&nbsp;ID</th>
                    <th>Source&nbsp;IP</th>
                    <th>Source</th>
                    <th>Revenue</th>
                    <th>Commission</th>
                    <th>Point</th>
                  {{--  --}}
                  {{--   <th>No.</th>
                    <th>Source</th>
                    <th>Source&nbsp;IP</th>
                    <th>Date</th>
                    <th>Commission</th>
                    <th>Points</th>
                    <th>Buyer&nbsp;ID</th>
                    <th>Revenue</th>
                 </tr> --}}
                 </thead>
                 <tbody>
                     
                 </tbody>
             </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>

        </div>
    </div>
</div>
<!-- Last Share  Modal-->
<div class="modal fade" id="shareModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 80%">
        <div class="modal-content" style='max-height: 500px; overflow-y: scroll;'>
            <div class="modal-body">
               <table class="table">
                 <thead style="background-color:#558ED5; color:#fff;">
                 <tr>
                    <th>No.</th>
                    <th>SMM ID</th>
                     <th>Shared&nbsp;Item</th>
                    <th>Clicked</th>
                    <th>Qty&nbsp;Sold</th>
                    <th>Total&nbsp;Sold</th>
                    <th>Shared on</th>
                 </tr>
                 </thead>
                 <tbody>
                     
                 </tbody>
             </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>

        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        var table = $('#product_details_table').DataTable({
                "scrollX": true,
                "order": [],
                "columnDefs": [{
                "targets": 'no-sort',
                "orderable": false,
                    },          
                    {"targets": "medium", "width": "80px"},
                    {"targets": "bmedium", "width": "100px"},
                    {"targets": "large",  "width": "120px"},
                    {"targets": "bsmall",  "width": "20px"},
                    {"targets": "approv", "width": "180px"}, //Approval buttons
                    {"targets": "blarge", "width": "200px"}, // *Names
                    {"targets": "clarge", "width": "250px"},
                    {"targets": "xlarge", "width": "300px"},], //Remarks + Notes ],
                    "fixedColumns":  true
                });
        $('.friends').click(function(){
            $('#friendsModal').find('.fb').text($(this).attr('fb'));
            $('#friendsModal').modal('show');
        });
        $('.country').click(function(){
            $('#countryModal').find('.state').text($(this).attr('state'));
            $('#countryModal').find('.city').text($(this).attr('city'));
            $('#countryModal').find('.area').text($(this).attr('area'));
            $('#countryModal').modal('show');
        });
        $('.share').click(function(){
            // Get content
            var uid=$(this).attr('uid');
            var smmid=$(this).attr('smmid');
            var url="{{url('admin/master/smm/info')}}"+"/"+uid+"/"+smmid;
            $.ajax({
                url:url,
                type:'GET',
                success:function(r){
                    $('#shareModal').find('tbody').empty();
                    $('#shareModal').find('tbody').append(r);
                     $('#shareModal').modal('show');
                },
                error:function(){
                    toastr.warning("Failed to retrieve data.Contact OpenSupport");
                }
            });
           
        });
    });
    $('body').on('click','.clicked',function(e){
        var uid=$(this).attr('uid');
        var smmout_id=$(this).attr('soutid');
        var url="{{url('admin/master/smm/info/clicked')}}"+"/"+uid+"/"+smmout_id;
        $.ajax({
            url:url,
            type:'GET',
            success:function(r){
                $('#clickedModal').find('.modal-body').find('tbody').empty();
                $('#clickedModal').find('.modal-body').find('tbody').append(r);

            },
        });
        $('#shareModal').modal('hide');
        $('#clickedModal').modal('show');

        });
</script>
    @yield("left_sidebar_scripts")
@stop
