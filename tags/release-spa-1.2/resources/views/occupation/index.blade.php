@extends("common.default")

@section("content")
    <div class="container" style="margin-top:30px;">
	@include('admin/panelHeading')
            <div class="equal_to_sidebar_mrgn">

                <h3>Occupations:</h3>
                <hr>
                <p class="bg-success success-msg" style="display:none;padding: 15px;"></p>
                <button type="button" id="btn-add" class="btn btn-primary btn-lg">Add Occupation</button>
                <hr>
                <div class="table-wrapper">
                    <table class="table" id="grid">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($occupations) && !empty($occupations))
                            @foreach($occupations as $occupation)
                                <tr>
                                    <td>{{$occupation->id}}</td>
                                    <td>{{$occupation->name}}</td>
                                    <td>{{$occupation->description}}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-sm btn-edit"
                                                id="data-edit-{{$occupation->id}}"
                                                value="{{$occupation->id}}">
                                            <span class="glyphicon glyphicon-pencil"></span>
                                        </button>

                                        <button type="button" class="btn btn-danger btn-sm btn-delete"
                                                id="data-delete-{{$occupation->id}}"
                                                value="{{$occupation->id}}">
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
                                <h4 class="modal-title" id="myModalLabel">Add Occupation</h4>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal" action="#" id="addOccupation">

                                    <div class="form-group">
                                        <label for="occupation-name" class="col-sm-2 control-label">Name</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" id="occupation-name"
                                                   placeholder="Enter target revenue">
                                        </div>

                                        <label for="occupation-description" class="col-sm-2 control-label">Description</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" id="occupation-description"
                                                   placeholder="Enter description">
                                        </div>
                                    </div>

                                    {{--<button type="submit" class="btn btn-default">Save</button>--}}
                                    <input type="hidden" id="occupation-occupation-id" value="">
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

            //Handle Check Box Change
//            $("input[type='checkbox']").on("change", function () {
//                if ($(this).is(":checked"))
//                    $(this).val("1");
//                else
//                    $(this).val("0");
//            });

            //Function To handle add button action
            $("#btn-add").click(function () {
                formSubmitType = "add";
                $(".modal-title").text("Add Occupation");
                $("#addOccupation").trigger("reset");
                $("#myModal").modal("show");

            })

            //Function To Handle Edit Button action
            $(".btn-edit").click(function () {
                $("#addOccupation").trigger("reset");
                $("#myModal").modal("hide");

                var val = $(this).attr('value');
                console.log(val);
                var url = "/admin/general/occupations/" + val + "/edit";
                formSubmitType = "edit";
                $(".modal-title").text("Edit Occupation");

                $.ajax({
                    type: "GET",
                    url: url,
                    dataType: 'json',
                    success: function (data) {
                        console.log(data);
                        $("#occupation-name").val(data["name"]);
                        $("#occupation-description").val(data["description"]);
                        $("#occupation-occupation-id").val(data["id"]);

                        $("#myModal").modal("show");
                    },
                    error: function (error) {
                        console.log("Error :" + error);
                    }

                });

            })

            //Delete Recored
            $(".btn-delete").click(function () {
                if (confirm('Are you sure you want to remove Occupation Record?')) {
                    var id = $(this).attr("value");
                    var my_url = '/admin/general/occupations/' + id;
                    var method = "DELETE";

                    $.ajax({
                        type: method,
                        url: my_url,
                        dataType: 'json',
                        success: function (data) {
                            $(".success-msg").fadeIn();
                            $(".success-msg").text("Occupation successfully removed.");
                            $(".success-msg").fadeOut(4000);
                        },
                        error: function (error) {
                            console.log("Error :" + error);
                        }

                    });

                }


            })

            //Handle Form Submit For Bothh Add and Edit
            $("#addOccupation").on('submit', function (event) {

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
                    id = $("#occupation-occupation-id").val();
                    method = 'PUT';
                    my_url = '/admin/general/occupations/' + id;
                }

                if (formSubmitType == "add") {
                    method = 'POST';
                    my_url = '/admin/general/occupations';
                }

                var formData = {
                    name: $("#occupation-name").val(),
                    description: $("#occupation-description").val(),

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
                            $(".success-msg").text("Occupation successfully updated.");
                        } else {
                            $(".success-msg").text("Occupation successfully added.");
                        }
                        $(".success-msg").fadeOut(4000);
                        formSubmitType = null;
                    },
                    error: function (error) {
                        console.log("Error :" + error);
                    }

                });

            })
        });
    </script>
@stop
