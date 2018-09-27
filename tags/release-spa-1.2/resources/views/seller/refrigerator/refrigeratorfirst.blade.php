@extends("common.default")
@section("content")
@include('common.sellermenu')

<link href="{{url('assets/jqGrid/ui.jqgrid.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{url('css/datatable.css')}}" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="{{asset('/css/bootstrap.min.css')}}"/>
<style>
    .tab-pane{
        margin-top: 4em;
    }

    .top-margin{
        margin-top: -30px;
    }

    table#notproduct_details_table
    {
        /*  table-layout: fixed;*/
        max-width: none;
        width: auto;
        min-width: 100%;
    }

    table#product_details_table
    {
        table-layout: fixed;
        max-width: none;
        width: auto;
        min-width: 100%;
    }
    .aproducts{
        width: 100% !important;
    }
    .no-sort{
        width: 20px !important;
    }

    #upload-form{
        /*position: absolute;*/
        /*top: 50%;*/
        /*left: 50%;*/
        /*margin-top: -100px;*/
        /*margin-left: -250px;*/
        width: 500px;
        height: 200px;
        border: 4px dashed #333333;
    }
    .select2{display: none;}
    #upload-form .p-sty{
        width: 100%;
        height: 100%;
        text-align: center;
        line-height: 170px;
        color: #333333;
    }
    #upload-form .input-sty{
        position: absolute;
        margin: 0;
        padding: 0;
        width: 100%;
        height: 200px;
        outline: none;
        opacity: 0;
    }
    #upload-form .button-sty{
        margin: 0;
        color: #fff;
        background: #16a085;
        border: none;
        width: 508px;
        height: 35px;
        margin-top: -20px;
        margin-left: -4px;
        border-radius: 4px;
        border-bottom: 4px solid #117A60;
        transition: all .2s ease;
        outline: none;
    }
    #upload-form .button-sty:hover{
        background: #149174;
        color: #0C5645;
    }
    #upload-form .button-sty:active{
        border:0;
    }
    .logo-header {
        padding-left:0;
        padding-right:0;
    }
    body {
        font-family: Lato;
    }
    .navbar-inverse .navbar-nav>li>a {
        color:white;
    }

</style>

<section class="">
    <div class="container"><!--Begin main cotainer-->
        <div class="alert alert-success alert-dismissible hidden cart-notification" role="alert" id="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong class='cart-info'></strong>
        </div>
        <input type="hidden" value="" id="selluserid" />

        <div class="row">
            <div class="col-sm-12">
                <div class="row">
                    <div class="row">
                        @if(Session::has('success'))
                        <script type="text/javascript">
                            toastr.success("{{Session::get('success')}}");
                        </script>
                        @endif

                        @if(Session::has('error_message'))
                        <script type="text/javascript">
                            toastr.error("{{Session::get('error_message')}}");
                        </script>

                        @endif

                    </div>
                    {{-- Tabbed Nav --}}
                    <div class="panel with-nav-tabs panel-default " style="margin: 0 !important;">
                        <div class="panel-heading">
                            <h2 style="margin-top:10px">Refrigerator and Storage</h2>

                        </div>
                    </div>
                    {{--ENDS  --}}
                    <input type="hidden" value="" id="mmerchant_id" />
                    <input type="hidden" value="" id="msell_id" />
                    <div id="dashboard" class="row panel-body " style="padding: 0px 15px 15px 15px" >

                        <div class="tab-content top-margin" style="margin-top:-50px">

                            <div class="tab-pane fade in active" id="deliveryorder">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h3>Refrigerator and Storage Management</h3>
                                    </div>

                                </div>
                                <div class="row" style="padding: 0px 10px 0px 10px;">
                                    <table class="table table-bordered table-responsive" id="delivery-order-table" >
                                        <thead class="aproducts">

                                            <tr style="background-color: #6d9270; color: #FFF;">
                                                <th class="text-center no-sort" width="20px" style="width: 20px !important;">No</th>
                                                <th class="text-center">Product Name</th>
                                                <th class="text-center">Qty Used</th>
                                                <th class="text-center">Optimum(Average)</th>
                                                <th class="text-center">Qty Left</th>
                                                <th class="text-center">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>

                                    </table>
                                </div>
                            </div>



                            <div id="discardDoPopUp" class="modal fade" role="dialog">
                                <div class="modal-dialog">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Discard</h4>
                                        </div>
                                        <div class="modal-body" >
                                            <div class="row">
                                                <h2 style="text-align: center">Discard Delivery Order</h2>
                                            </div>
                                            <form action="{{route('discard.do')}}" method="POST">
                                                {{csrf_field()}}
                                                <input type="hidden" value="{{$user_id}}" name="user_id">
                                                <input type="hidden" name="discard_do_id" value="">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <h3 style="text-align: left">DO ID:</h3>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <h3 id="discard_do_id_no" style="text-align: left;padding: 0;"></h3>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <button id="yes_btn_href" type="submit" class="btn btn-success btn-lg btn-block">Confirm</button>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <button type="button" class="btn btn-danger btn-lg btn-block" data-dismiss="modal">Cancel</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>

                                </div>
                            </div>


                            <div id="importedstatus" class="modal fade" role="dialog">
                                <div class="modal-dialog">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Tracking Report</h4>
                                        </div>
                                        <div style="padding: 15px;" class="modal-body-importedstatus" >
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div id="issueDoPopUp" class="modal fade" role="dialog">
                                <div class="modal-dialog">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Delivery Order</h4>
                                        </div>
                                        <div class="modal-body" >
                                            <div class="row">
                                                <h2 style="text-align: center">Issue Delivery Order</h2>
                                            </div>
                                            <form action="{{route('issue.do')}}" method="POST">
                                                {{csrf_field()}}
                                                <input type="hidden" name="issue_do_id" value="">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <h3 style="text-align: left">DO ID:</h3>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <h3 id="issue_do_id_no" style="text-align: left;padding: 0;"></h3>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <h3 style="padding-left:15px">Select Deliveryman:</h3>
                                                </div>

                                                <?php $index = 1; ?>
                                                @foreach($delivery_men as $delivery_man)
                                                <div class="row">
                                                    <div class="col-md-2" style="text-align: right; padding: 0;">
                                                        <input type="radio" name="member_id" value="{{$delivery_man->id}}" @if($index == 1) required  <?php $index++ ?> @endif>
                                                    </div>
                                                    <div class="col-md-10" style="text-align: left">
                                                        <label for="">
                                                            @if($delivery_man->first_name != null && $delivery_man->last_name != null)
                                                            {{$delivery_man->first_name}} {{$delivery_man->last_name}}

                                                            @elseif($delivery_man->username != null)
                                                            {{$delivery_man->username}}
                                                            @else
                                                            {{$delivery_man->email}}
                                                            @endif


                                                        </label>
                                                    </div>
                                                </div>

                                                @endforeach
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <button id="yes_btn_href" href="" class="btn btn-success btn-lg btn-block">Confirm</button>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <button type="button" class="btn btn-danger btn-lg btn-block" data-dismiss="modal">Cancel</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>

                                </div>
                            </div>


                            <div id="trDoPopUp" class="modal fade" role="dialog">
                                <div class="modal-dialog">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Tracking Report</h4>
                                        </div>
                                        <div class="modal-body" >
                                            <div class="row">
                                                <h2 style="text-align: center">Attach With Tracking Report</h2>
                                            </div>
                                            <form action="{{route('tr.do')}}" method="POST">
                                                {{csrf_field()}}
                                                <input type="hidden" name="tr_do_id" value="">
                                                <input type="hidden" name="initial_location_id" value="">
                                                <div class="row">
                                                    <div class="col-md-5">
                                                        <h3 style="text-align: left">DO ID:</h3>
                                                    </div>
                                                    <div class="col-md-y">
                                                        <h3 id="tr_do_id_no" style="text-align: left;padding: 0;"></h3>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-5">
                                                        <h3 style="text-align: left">Initial Location:</h3>
                                                    </div>
                                                    <div style="padding-left: 0px;" class="col-md-7">
                                                        <h3 id="initial_location" style="text-align: left;padding: 0;"></h3>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-5">
                                                        <h3 style="text-align: left">Final Location:</h3>
                                                    </div>
                                                    <div style="padding-left: 0px;" class="col-md-7">
                                                        <h3 id="final_location" style="text-align: left;padding: 0;"></h3>
                                                    </div>
                                                </div>
                                                <div style="padding-left: 15px;    width: 48%;float: left;" class="row">
                                                    <h3>Select Deliveryman:</h3>
                                                </div>
                                                <div style="width: 50%;float: left;padding-top: 25px;margin-bottom: 25px;">
                                                    <?php $index = 1; ?>
                                                    @foreach($delivery_men as $delivery_man)
                                                    <div class="row">
                                                        <div class="col-md-1" style="text-align: right; padding: 0;float: left;">
                                                            <input type="radio" name="member_id" value="{{$delivery_man->id}}" @if($index == 1) required  <?php $index++ ?> @endif>
                                                        </div>
                                                        <div class="col-md-10" style="text-align: left">
                                                            <label for="">
                                                                @if($delivery_man->first_name != null && $delivery_man->last_name != null)
                                                                {{$delivery_man->first_name}} {{$delivery_man->last_name}}

                                                                @elseif($delivery_man->username != null)
                                                                {{$delivery_man->username}}
                                                                @else
                                                                {{$delivery_man->email}}
                                                                @endif
                                                            </label>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <button id="yes_btn_href" href="" class="btn btn-success btn-lg btn-block">Confirm</button>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <button type="button" class="btn btn-danger btn-lg btn-block" data-dismiss="modal">Cancel</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>

                                </div>
                            </div>


                            <div id="importModal" class="modal fade" role="dialog">
                                <div class="modal-dialog">

                                    <!-- Modal content-->
                                    <div class="modal-content" style="height: 350px !important;">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Delivery Order Import</h4>
                                        </div>
                                        <div class="modal-body text-center" >

                                            <form id="upload-form" action="{{route('import.do')}}" method="POST" enctype="multipart/form-data">
                                                <input type="hidden" value="{{$user_id}}" name="user_id">
                                                {{csrf_field()}}
                                                <input type="file" name="file" class="input-sty" multiple required>
                                                <p class="p-sty">click here to select a file.</p>
                                                <br>
                                                <button type="submit" class="button-sty">Upload</button>
                                            </form>
                                        </div>
                                        <div class="modal-footer" style="padding: 20px !important; border-top: none !important;">

                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div id="exportModal" class="modal fade" role="dialog">
                                <div class="modal-dialog">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Delivery Order Export</h4>
                                        </div>
                                        <div class="modal-body" >
                                            <div class="row">
                                                <h2 style="text-align: center">Export Delivery Orders</h2>
                                            </div>
                                            <form id="export_form" action="{{route('export.do')}}" method="POST">
                                                {{csrf_field()}}
                                                <input type="hidden" value="{{$user_id}}" name="user_id">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="">From</label>
                                                        <input id="from_date" type="date" class="form-control" name="from" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="">To</label>
                                                        <input id="to_date" type="date" class="form-control" name="to" required>
                                                    </div>
                                                </div>
                                                <br><br>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <button type="button" onclick="exportForm()" class="btn btn-success btn-lg btn-block">Confirm</button>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <button type="button" class="btn btn-danger btn-lg btn-block" data-dismiss="modal">Cancel</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>

                                </div>
                            </div>


                            <script>

                                                $(document).ready(function() {
                                                    $('link[rel=stylesheet][href~="{{asset(' / css / select2.min.css')}}"]').remove();
                                                    $('form .input-sty').change(function() {
                                                        $('form .p-sty').text(this.files.length + " file(s) selected");
                                                    });
                                                });
                                                $('#delivery-order-table').DataTable();
                                                function importedstatus(do_id) {
                                                    $.ajax({
                                                        url: JS_BASE_URL + "/importedstatus/" + do_id,
                                                        type: 'GET',
                                                        success: function(r) {
                                                            //console.log(r);
                                                            $('.modal-body-importedstatus').html(r);
                                                            $('#importedstatus').modal('show');
                                                        }
                                                    });
                                                }
                                                function issueDoModal(do_id_no, do_id) {

                                                    $('#issue_do_id_no').html(do_id_no);
                                                    $('input[name=issue_do_id]').val(do_id);
                                                    $('#issueDoPopUp').modal('show');
                                                }

                                                function trDoModal(do_id_no, do_id, inl_id, f_loc) {

                                                    $('#tr_do_id_no').html(do_id_no);
                                                    $('#initial_location').html($('#ini_loc' + inl_id + ' :selected').text());
                                                    $('#final_location').html(f_loc);
                                                    $('input[name=initial_location_id]').val($('#ini_loc' + inl_id).val());

                                                    $('input[name=tr_do_id]').val(do_id);
                                                    $('#trDoPopUp').modal('show');
                                                }

                                                function discardDoModal(do_id_no, do_id) {
                                                    $('#discard_do_id_no').html(do_id_no);
                                                    $('input[name=discard_do_id]').val(do_id);
                                                    $('#discardDoPopUp').modal('show');
                                                }

                                                function exportForm() {
                                                    var from_date = document.getElementById('from_date').value;
                                                    var to_date = document.getElementById('to_date').value;


                                                    if (from_date == "" || to_date == "") {
                                                        toastr.error("Please Select Both Date");
                                                    } else if (new Date(from_date) > new Date(to_date)) {
                                                        toastr.error("From Date must be earlier than To Date");
                                                    } else {
                                                        document.getElementById("export_form").submit();
                                                    }
                                                }




                            </script>


                            @stop

