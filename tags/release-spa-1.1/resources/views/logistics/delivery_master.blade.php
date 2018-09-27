@extends("common.default")

@section("content")
    <div class="container" style="margin-top:30px;">
	@include('admin/panelHeading')
            <div class="margin-top">
				<h2>Delivery Master</h2><br>

                <div class="row">

                    <div class="col-md-2 col-md-offset-6">

                        <select id="filter-type">
                            <option value="">Filter By</option>
                            <option value="wordwide">Wordwide</option>
                            <option value="country">Country/State</option>
                            <option value="merchant">Merchant</option>
                            <option value="merchant-consultant">Merchant Consultant</option>
                            <option value="buyer">Buyer</option>
                            <option value="courier">Courier</option>
                        </select>

                    </div>

                    <div id="container-filter-option-1" class="col-md-2" style="display:none;">

                        <select id="filter-option-1">
                        </select>

                    </div>

                    <div id="container-filter-option-2" class="col-md-2" style="display:none;">

                        <select id="filter-option-2">
                        </select>

                    </div>

                </div>

                <br />
                <br />

                <div class="row">
                    <div class="col-md-12">
                        <div class="tableData">
                            <div class="table-responsive">
                                <table id="datatable" class="table table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr style="background-color:rgb(64,49,82); color: white;">
                                            <td class="text-center no-sort">No</td>
                                            <td class="text-center no-sort">Date</td>
                                            <td class="text-center">Order&nbsp;ID</td>
                                            <td class="text-center">Merchant&nbsp;ID</td>
                                            <td class="text-center">Logistics&nbsp;ID</td>
                                            <td class="text-center">Dimension</td>
                                            <td class="text-center">Sender</td>
                                            <td class="text-center">Receipient</td>
                                            <td class="text-center">Status</td>
                                            <td class="text-center">Fee</td>
                                        </tr>
                                    </thead>
                                    <tbody id="datatable_tbody">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Order Details</h4>
            </div>
            <div class="modal-body orderDetails">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="orderDetailModal" tabindex="-1" role="dialog" aria-labelledby="order-details-label">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Order Details</h4>
            </div>
            <div class="modal-body orderDetails">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="merchantModal" tabindex="-1" role="dialog" aria-labelledby="merchantModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Order Details</h4>
            </div>
            <div class="modal-body merchantDetails">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@stop

<script src="{{ asset('js/jquery.min.js') }}"></script>
<script type="text/javascript">

    var table_data;

    function pad (str, max) {
      str = str.toString();
      return str.length < max ? pad("0" + str, max) : str;
    }

    function newDataTable(){
        return  $('#datatable').DataTable({
                    "order":[],
                    'scrollX':true,
                    'autoWidth':false,
                    "aoColumnDefs" : [ {
                        "bSortable" : false,
                        "width" : "10%",
                        "aTargets" : [ "no-sort" ]
                    } ]
                });
    }

    function rowData(data){
        var newRowContent = "";
        var num = 1;
        for(var i = 0 ; i < data.length ; i++) {
            var orderId = pad(data[i].id,10);
            var merchantId = pad(data[i].merchant_id,10)
            newRowContent += '<tr>';
            newRowContent += '<td align="center" class="no-sort">'+num+'</td>';
            newRowContent += '<td align="center" class="date" date="'+data[i].created_at+'">'+data[i].created_at+'</td>';
            newRowContent += '<td align="center" class="order-details" order_id="'+data[i].id+'"><p style="color: darkblue;"><a target="_blank" href="../../../../deliveryorder/'+data[i].id+'" class="update" data-id="'+data[i].id+'">['+orderId+']</a></p></td>';
            newRowContent += '<td align="center" class="merchant-details" merchant_id="'+data[i].merchant_id+'"><p style="color: darkblue;"><a target="_blank" href="../../popup/merchant/'+data[i].merchant_id+'" class="update" data-id="'+data[i].merchant_id+'">['+merchantId+']</a></p></td>';
            newRowContent += '<td align="center" class="courier-details" courier_id="'+data[i].courier_id+'"><p style="color: darkblue;"><a target="_blank" href="../../../../deliveryorder/'+data[i].id+'" class="update" data-id="'+data[i].courier_id+'">['+data[i].courier_id+']</a></p></td>';
            newRowContent += '<td align="center" >Dimension</td>';
            newRowContent += '<td align="center" class="sender">\n\
                                    <a>'+data[i].sender_city+'</a>\n\
                                    <input type="hidden" class="mobile_no" value ="'+data[i].office_no+'">\n\
                                    <input type="hidden" class="address" value ="'+data[i].merchant_address+'">\n\
                                    <input type="hidden" class="name" value ="'+data[i].merchant_name+'">\n\
                                </td>';
            newRowContent += '<td align="center" class="user">\n\
                                <a>'+data[i].user_city+'</a>\n\
                                \n\<input type="hidden" class="mobile_no" value ="'+data[i].mobile_no+'">\n\
                                <input type="hidden" class="address" value ="'+data[i].user_address+'">\n\
                                <input type="hidden" class="name" value ="'+data[i].user_name+'">\n\
                            </td>';
            newRowContent += '<td align="left">'+data[i].status+'</td>';
            newRowContent += '<td align="center" >{{$currentCurrency}} 5.50</td>';
            newRowContent += '</tr>';

            num++;
        }
        return newRowContent;
    }

    $(document).ready(function () {

        $(document).on("click", ".sender", function(){
            var detail = '<b>Sender Name : </b>'+$(this).find('.name').val()+'<br/>'+
                    '<b> Contact : </b>'+$(this).find('.mobile_no').val()+'<br/>'+
                    '<b> Address : </b>'+$(this).find('.address').val();
            doModal('Sender Details',detail);
        });
        $(document).on("click", ".user", function(){
            var detail = '<b>Receipient Name : </b>'+$(this).find('.name').val()+'<br/>'+
                    '<b> Contact : </b>'+$(this).find('.mobile_no').val()+'<br/>'+
                    '<b> Address : </b>'+$(this).find('.address').val();
            doModal('Receipient Details',detail);
        });
        $("#filter-type").on('change',function(){
            // var filter_1,filter_2;
            $('#container-filter-option-1').css('display','none');
            $('#container-filter-option-2').css('display','none');
            $('#filter-option-1').empty();
            $('#filter-option-1').val("");

            switch($(this).val()){
                case 'wordwide':
                                // $('.tableData').empty();
                                $.ajax({
                                    url: '{{ route('get_delivery') }}',
                                    cache: false,
                                    method: 'GET',
                                    beforeSend: function() {
                                    },
                                    success: function(result) {
                                        table_data.destroy();
                                        $('#datatable_tbody').empty();
                                        $("#datatable_tbody").append(rowData(result));
                                        table_data = newDataTable();
                                    }
                                });

                                break;
                case 'country':
                                $.ajax({
                                    url: '{{ route('shipping:country') }}',
                                    cache: false,
                                    method: 'GET',
                                    beforeSend: function() {
                                    },
                                    success: function(result) {
                                        $('#filter-option-1').append($( "<option></option>" )
                                                             .attr( "value","country" )
                                                             .text( "Select Country")
                                                             .prop('selected', true) );
                                        for(var i = 0 ; i < result.length ; i++) {
                                           // console.log(result[i]);
                                           $('#filter-option-1')
                                                 .append($( "<option></option>" )
                                                            .attr( "value",result[i].code )
                                                            .text( result[i].name) );
                                        }
                                        $('#container-filter-option-1').css('display','block');
                                        $('#filter-option-1').val("country");
                                    }
                                });
                                break;
                case 'merchant':
                                $.ajax({//merchantId
                                    url: '{{ route('shipping:merchant') }}',
                                    cache: false,
                                    method: 'GET',
                                    beforeSend: function() {
                                    },
                                    success: function(result) {
                                        $('#filter-option-1').append($( "<option></option>" )
                                                             .attr( "value","merchant" )
                                                             .text( "Select Merchant")
                                                             .prop('selected', true) );
                                        for(var i = 0 ; i < result.length ; i++) {
                                           $('#filter-option-1')
                                                 .append($( "<option></option>" )
                                                            .attr( "value",result[i].id )
                                                            .text( result[i].company_name) );
                                        }
                                        $('#container-filter-option-1').css('display','block');
                                        $('#filter-option-1').val("merchant");
                                    }
                                });
                                break;
                case 'merchant-consultant':
                                $.ajax({
                                    url: '{{ route('shipping:merchant-consultant') }}',
                                    cache: false,
                                    method: 'GET',
                                    beforeSend: function() {
                                    },
                                    success: function(result) {
                                        //console.log(result);
                                        $('#filter-option-1').append($( "<option></option>" )
                                                             .attr( "value","merchant" )
                                                             .text( "Select Merchant Consultant")
                                                             .prop('selected', true) );
                                        for(var i = 0 ; i < result.length ; i++) {
                                           $('#filter-option-1')
                                                 .append($( "<option></option>" )
                                                            .attr( "value",result[i].id )
                                                            .text( result[i].name) );
                                        }
                                        $('#container-filter-option-1').css('display','block');
                                        $('#filter-option-1').val("merchant");
                                    }
                                });
                                break;
                case 'buyer':
                                $.ajax({
                                    url: '{{ route('shipping:buyer') }}',
                                    cache: false,
                                    method: 'GET',
                                    beforeSend: function() {
                                    },
                                    success: function(result) {
                                        $('#filter-option-1').append($( "<option></option>" )
                                                             .attr( "value","buyer" )
                                                             .text( "Select Buyer")
                                                             .prop('selected', true) );
                                        for(var i = 0 ; i < result.length ; i++) {
                                           $('#filter-option-1')
                                                 .append($( "<option></option>" )
                                                            .attr( "value",result[i].id )
                                                            .text( result[i].name) );
                                        }
                                        $('#container-filter-option-1').css('display','block');
                                        $('#filter-option-1').val("buyer");
                                    }
                                });
                                break;
                case 'courier':
                                $.ajax({
                                    url: '{{ route('shipping:courier') }}',
                                    cache: false,
                                    method: 'GET',
                                    beforeSend: function() {
                                    },
                                    success: function(result) {
                                        $('#filter-option-1').append($( "<option></option>" )
                                                             .attr( "value","courier" )
                                                             .text( "Select Courier")
                                                             .prop('selected', true) );
                                        for(var i = 0 ; i < result.length ; i++) {
                                           $('#filter-option-1')
                                                 .append($( "<option></option>" )
                                                            .attr( "value",result[i].id )
                                                            .text( result[i].name) );
                                        }
                                        $('#container-filter-option-1').css('display','block');
                                        $('#filter-option-1').val("courier");
                                    }
                                });
                                break;
                default: //Do Nothing
            }
        });

        $("#filter-option-1").on('change',function(){
            $('#filter-option-2').empty();
            switch($("#filter-type").val()){
                case 'country':
                                //sales-by-country
                                // $('.tableData').empty();
                                var countryCode = $('#filter-option-1 option:selected').val();
                                $.ajax({
                                    url: '{{ route('sales-by-country') }}',
                                    cache: false,
                                    method: 'GET',
                                    data: {countryCode: countryCode},
                                    beforeSend: function() {
                                    },
                                    success: function(result) {
                                        table_data.destroy();
                                        $('#datatable_tbody').empty();
                                        $("#datatable_tbody").append(rowData(result));
                                        table_data = newDataTable();
                                    }
                                });
                                $.ajax({
                                    url: '{{ route('states-by-country') }}',
                                    cache: false,
                                    method: 'GET',
                                    data: {countryCode: countryCode},
                                    beforeSend: function() {
                                    },
                                    success: function(result) {
                                        //console.log(result);
                                        $('#filter-option-2').append($( "<option></option>" )
                                                             .attr( "value","country" )
                                                             .text( "Select State")
                                                             .prop('selected', true) );
                                        for(var i = 0 ; i < result.length ; i++) {
                                           //console.log(result[i]);
                                           $('#filter-option-2')
                                                 .append($( "<option></option>" )
                                                            .attr( "value",result[i].code )
                                                            .text( result[i].name) );
                                        }
                                        $('#container-filter-option-2').css('display','block');
                                        $('#filter-option-2').val("");
                                    }
                                });
                                break;
                case 'merchant':
                                // Get Merchants
                                var merchantId = $('#filter-option-1 option:selected').val();
                                $.ajax({
                                    url: '{{ route('sales-by-merchant') }}',
                                    cache: false,
                                    method: 'GET',
                                    data: {merchantId: merchantId},
                                    beforeSend: function() {
                                    },
                                    success: function(result) {
                                        table_data.destroy();
                                        $('#datatable_tbody').empty();
                                        $("#datatable_tbody").append(rowData(result));
                                        table_data = newDataTable();
                                    }
                                });
                                break;
                case 'merchant-consultant':
                                var merchantId = $('#filter-option-1 option:selected').val();
                                $.ajax({
                                    url: '{{ route('sales-by-merchant-consultant') }}',
                                    cache: false,
                                    method: 'GET',
                                    data: {merchantId: merchantId},
                                    beforeSend: function() {
                                    },
                                    success: function(result) {
                                        table_data.destroy();
                                        $('#datatable_tbody').empty();
                                        $("#datatable_tbody").append(rowData(result));
                                        table_data = newDataTable();
                                    }
                                });
                                break;
                case 'buyer':
                                var buyerId = $('#filter-option-1 option:selected').val();
                                $.ajax({
                                    url: '{{ route('sales-by-buyer') }}',
                                    cache: false,
                                    method: 'GET',
                                    data: {buyerId: buyerId},
                                    beforeSend: function() {
                                    },
                                    success: function(result) {
                                        table_data.destroy();
                                        $('#datatable_tbody').empty();
                                        $("#datatable_tbody").append(rowData(result));
                                        table_data = newDataTable();
                                    }
                                });
                                break;
                case 'courier':
                                var courierId = $('#filter-option-1 option:selected').val();
                                $.ajax({
                                    url: '{{ route('sales-by-courier') }}',
                                    cache: false,
                                    method: 'GET',
                                    data: {courierId: courierId},
                                    beforeSend: function() {
                                    },
                                    success: function(result) {
                                        table_data.destroy();
                                        $('#datatable_tbody').empty();
                                        $("#datatable_tbody").append(rowData(result));
                                        table_data = newDataTable();
                                    }
                                });
                                break;
                default: //Do Nothing
            }
        });

        $("#filter-option-2").on('change',function(){
            var stateCode = $('#filter-option-2 option:selected').val();
            $.ajax({
                url: '{{ route('sales-by-state') }}',
                cache: false,
                method: 'GET',
                data: {stateCode: stateCode},
                beforeSend: function() {
                },
                success: function(result) {
                    table_data.destroy();
                    $('#datatable_tbody').empty();
                    $("#datatable_tbody").append(rowData(result));
                    table_data = newDataTable();
                }
            });
        });

        $.ajax({
            url: '{{ route('get_delivery') }}',
            cache: false,
            method: 'GET',
            beforeSend: function() {
            },
            success: function(result) {
                // $('.tableData').html(result);
                $('#datatable_tbody').empty();
                $("#datatable_tbody").append(rowData(result));
                table_data = newDataTable();
            }
        });
    });
    $('.order-details').on('click', function () {
        var orderId = $(this).attr('order_id');
        $('#myModal').modal('show');
        $.ajax({
            url: '{{route('load:orderDetails')}}',
            cache: false,
            method: 'GET',
            data: {orderId: orderId},
            beforeSend: function () {
            },
            success: function (result) {
                $('.orderDetails').html(result);
            }
        });
    });
    $('.merchant-details').on('click', function () {
        var merchantId = $(this).attr('merchant_id');
        $('#merchantModal').modal('show');
        $.ajax({
            url: '{{route('load:merchantDetails')}}',
            cache: false,
            method: 'GET',
            data: {merchantId: merchantId},
            beforeSend: function () {
            },
            success: function (result) {
                $('.merchantDetails').html(result);
            }
        });
    });
    function doModal(heading, formContent) {
        html =  '<div id="dynamicModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="confirm-modal" aria-hidden="true">';
        html += '<div class="modal-dialog">';
        html += '<div class="modal-content">';
        html += '<div class="modal-header">';
        html += '<a class="close" data-dismiss="modal">×</a>';
        html += '<h4>'+heading+'</h4>'
        html += '</div>';
        html += '<div class="modal-body">';
        html += formContent;
        html += '</div>';
        html += '<div class="modal-footer">';
        html += '<span class="btn btn-primary" data-dismiss="modal">Close</span>';
        html += '</div>';  // content
        html += '</div>';  // dialog
        html += '</div>';  // footer
        html += '</div>';  // modalWindow
        $('body').append(html);
        $("#dynamicModal").modal();
        $("#dynamicModal").modal('show');

        $('#dynamicModal').on('hidden.bs.modal', function (e) {
            $(this).remove();
        });

    }
</script>
