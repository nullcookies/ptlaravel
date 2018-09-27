@extends("common.default")

@section('breadcrumbs', Breadcrumbs::render('SalesStaff'))

@section("content")
    <div class="container" style="margin-top:30px;">
	@include('admin/panelHeading')
            <div class="equal_to_sidebar_mrgn">

                <h3>Sales Staff:</h3>
                <hr>
                <p class="bg-success success-msg" style="display:none;padding: 15px;"></p>
                <button type="button" id="btn-add" class="btn btn-primary btn-lg">Add Sales Staff</button>
                <hr>
                <div class="table-wrapper">
                    <table class="table table-striped" cellspacing="0" width="100%" id="grid">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>User Id</th>
                            <th>Type</th>
                            <th>Target Merchant</th>
                            <th>Target Revenue</th>
                            <th>Commission</th>
                            <th>Bonus</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($salesStaff) && !empty($salesStaff))
                            @foreach($salesStaff as $staff)
                                <tr>
                                    <td>{{$staff->id}}</td>
                                    <td>{{$staff->users['first_name']}} {{$staff->users['last_name']}}</td>
                                    <td>{{$staff->type}}</td>
                                    <td>{{$staff->target_merchant}}</td>
                                    <td>{{$staff->target_revenue}}</td>
                                    <td>{{$staff->commission}}</td>
                                    <td>{{$staff->bonus}}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-sm btn-edit"
                                                id="data-edit-{{$staff->id}}"
                                                value="{{$staff->id}}">
                                            <span class="glyphicon glyphicon-pencil"></span>
                                        </button>

                                        <button type="button" class="btn btn-danger btn-sm btn-delete"
                                                id="data-delete-{{$staff->id}}"
                                                value="{{$staff->id}}">
                                            <span class="glyphicon glyphicon-trash"></span>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
                {{--Model Form Start--}}
                        <!-- Button trigger modal -->

                <!-- Modal -->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document" style="width: 80%">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Add Sales Staff</h4>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal" action="#" id="addSalesStaff">

                                    <div class="form-group">
                                        <label for="emp-user-id" class="col-sm-2 control-label">User Id</label>
                                        <div class="col-sm-4">
                                            <select class="bootstrap-select" id="staff-user-id">
                                                @foreach($users as $user)
                                                    <option value="{{$user->id}}">{{$user->first_name}} {{$user->last_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <label for="emp-position" class="col-sm-2 control-label">Type</label>
                                        <div class="col-sm-4">
                                            {{--<input type="text" class="form-control" id="staff-type"--}}
                                            {{--placeholder="Enter type">--}}

                                            <select class="bootstrap-select" id="staff-type">
                                                <option value="SMM">SMM</option>
                                                <option value="MCT">MCT</option>
                                                <option value="MCP">MCP</option>
                                                <option value="PSH">PSH</option>
                                                <option value="STR">STR</option>
                                            </select>
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label for="emp-visa-no" class="col-sm-2 control-label">Target Merchant</label>
                                        <div class="col-sm-4">
                                            <input type="number" class="form-control" id="staff-target-merchant"
                                            placeholder="Enter target merchant">
                                        </div>

                                        <label for="emp-socso-no" class="col-sm-2 control-label">Target Revenue</label>
                                        <div class="col-sm-4">
                                            <input type="number" min="0" class="form-control" id="staff-target-revenue"
                                                   placeholder="Enter target revenue">
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label for="emp-epf-no" class="col-sm-2 control-label">Commission</label>
                                        <div class="col-sm-4">
                                            <input type="number" min="0" step="any" class="form-control" id="staff-commission"
                                                   placeholder="Enter commission">
                                        </div>

                                        <label for="emp-pcb" class="col-sm-2 control-label">Bonus</label>
                                        <div class="col-sm-4">
                                            <input type="number" min="0" step="any" class="form-control" id="staff-bonus"
                                                   placeholder="Enter bonus">
                                        </div>

                                    </div>

                                    {{--<button type="submit" class="btn btn-default">Save</button>--}}
                                    <input type="hidden" id="staff-staff-id" value="">
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary btn-title">Save</button>
                            </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
            {{--Model Form End--}}
    </div>
    {{--</div>--}}
    <meta name="_token" content="{!! csrf_token() !!}"/>
    <script type="text/javascript">
        $(document).ready(function () {
            var formSubmitType = null;

            //Function To handle add button action
            $("#btn-add").click(function () {
                formSubmitType = "add";
                $(".modal-title").text("Add Staff");
                $("#addSalesStaff").trigger("reset");
                $("#myModal").modal("show");

            });

            //Function To Handle Edit Button action
            $(".btn-edit").click(function () {
                $("#addSalesStaff").trigger("reset");
                $("#myModal").modal("hide");
                alert("Edit");
                var val = $(this).attr('value');
                console.log(val);
                var url = "/admin/general/salesstaff/" + val;
                formSubmitType = "edit";
                $(".modal-title").text("Edit Sale Staff");

                $.ajax({
                    type: "GET",
                    url: url,
                    dataType: 'json',
                    success: function (data) {
                        console.log(data);
                        $("#myModal").modal("show");
                    },
                    error: function (error) {
                        console.log(error);
                    }

                });

            });

            //Delete Recored
            $(".btn-delete").click(function () {
                if (confirm('Are you sure you want to remove Staff Record?')) {
                    var id = $(this).attr("value");
                    var my_url = '/admin/general/salesstaff/' + id;
                    var method = "DELETE";

                    $.ajax({
                        type: method,
                        url: my_url,
                        dataType: 'json',
                        success: function (data) {
                            $(".success-msg").fadeIn();
                            $(".success-msg").text("Sale Staff successfully removed.");
                            $(".success-msg").fadeOut(4000);
                        },
                        error: function (error) {
                            console.log(error);
                        }

                    });

                }


            })

            //Handle Form Submit For Bothh Add and Edit
            $("#addSalesStaff").on('submit', function (event) {
                alert("On submit");
                var method = null;
                var my_url = null;
                var id = null;


                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                })
                event.preventDefault();


                if (formSubmitType == null) {
                    return false;
                }

                if (formSubmitType == "edit") {
                    id = $("#staff-staff-id").val();
                    method = 'PUT';
                    my_url = '/admin/general/salesstaff/' + id;
                }

                if (formSubmitType == "add") {
                    method = 'POST';
                    my_url = '/admin/general/openwish';
                }

                var formData = {
                    user_id: $("#staff-user-id").val(),
                    type: $("#staff-type").val(),
                    commission: $("#staff-commission").val(),
                    bonus: $("#staff-bonus").val(),
                    target_merchant: $("#staff-target-merchant").val(),
                    target_revenue: $("#staff-target-revenue").val(),
                }
                console.log(formData);
                $.ajax({
                    type: method,
                    url: my_url,
                    data: formData,
                    dataType: 'json',
                    success: function (data) {
//                        console.log(data);

                        $('#myModal').modal('hide');
                        $(".success-msg").fadeIn();
                        if (formSubmitType == 'edit') {
                            $(".success-msg").text("Sales Staff successfully updated.");
                        } else {
                            $(".success-msg").text("Sales Staff successfully added.");
                        }
                        $(".success-msg").fadeOut(4000);
                        formSubmitType = null;
                    },
                    error: function (error) {
                        console.log( error);
                    }

                });

            })
        });
    </script>
@stop
