<?php
$cf = new \App\lib\CommonFunction();
use App\Http\Controllers\IdController;
$selectListForBusinessType =  $cf->getBusinessType();
use App\Classes;
// {!! Form::select('country', $cf->country(), null, ['class' => 'form-control']) !!}
?>

@extends("common.default")
@section("content")
@include('common.sellermenu')
<style type="text/css">
   .table-sections{padding-top: 20px;padding-bottom: 20px}
        .sellerbutton{
            min-width: 70px;
            min-height: 70px;
            padding-top: 26px;
            text-align: center;
            vertical-align: middle;
            float: left;
            font-size: 13px;
            cursor: pointer;
            margin-right: 5px;
            margin-bottom: 5px;
            border-radius: 5px;
            border: none;
        }
        .bg-primaryii{
            background-color: #02d4f9;
            color: #f6f6f6;
        }
        .bg-primarypurple{
            background-color: #2a75ed;
            color: #f6f6f6;
        }
        .bg-black{
            background-color: rgb(0,0,0);
            color: #f6f6f6;
        }

        .sellerbuttons{
            min-width: 70px;
            min-height: 70px;
            padding-top: 4px;
            text-align: center;
            vertical-align: middle;
            float: left;
            font-size: 13px;
            cursor: pointer;
            margin-right: 5px;
            margin-bottom: 5px;
            border-radius: 5px;
            box-shadow: none;
            /*background-color: #6d9370;*/
            border: 0;
            /*color: #dadada;*/
        }
       .select2-container{
           width: 45px !important;
       }
</style>

<div class="container" >

    <div class="row" style="margin-top: 10px;">
        <div class="col-sm-6">
            <h2>Repair & Warranty Management</h2>
        </div>
        <div class="col-sm-6">
            <!--  <h4>Staff Management</h4>
             <h4>Staff Management</h4> -->

        </div>
    </div>


    <div class="row">
        <div class="table-responsive" style="padding-left:15px">
        <table class="table table-bordered" cellspacing="0"
               id="StaffManagement" style="width:100% !important;">
            <thead style="color:white">
                <tr style="">
                    <td class="text-center" style="background-color: #DFF14F; color:black;">No</td>
                    <td class="text-center" style="background-color: #DFF14F; color:black;">Raw ID</td>
                    <td class="text-center" style="background-color: #DFF14F; color:black;">Product</td>
                    <td class="text-center" style="background-color: #DFF14F; color:black;">Product Name</td>
                    <td class="text-center" style="background-color: #DFF14F; color:black;">Service</td>
                    <td class="text-center" style="background-color: #DFF14F; color:black;">Warranty</td>
                    <td class="text-center" style="background-color: #DFF14F; color:black;">Authentication</td>
                    <td class="text-center" style="background-color: #0B5EC6;">Center</td>
                </tr>
            </thead>
            <tbody>
                <?php $num = 0; ?>
                <tr>
                    <td style="text-align: center;">{{ ++$num }}</td>
                    <td class="text-center" style="vertical-align: middle">1</td>
                    <td class="text-center" style="vertical-align: middle">Vending machine</td>
                    <td class="text-center" style="vertical-align: middle">Japanise vending machine</td>
                    <td class="text-center" style="vertical-align: middle"><a onclick="service_repair_book()" href="#">12/12/18 12:12</a></td>
                    <td class="text-center" style="vertical-align: middle"><a onclick="show_warrenty()" href="#">12/12/18</a></td>
                    <td class="text-center" style="vertical-align: middle">Block chain for IV bag</td>
                    <td><a onclick="show_chitno()" href="#">12</a></td>
                </tr>
            </tbody>
        </table>
        </div>
    </div>


        <div class="modal fade" id="show_warrentyModal" role="dialog">
            <div class="modal-dialog maxwidth60" style="width:50%">
                <!-- Modal content-->
              <div class="modal-content modal-content-sku">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h2>Warranty</h2>
                  </div>
                    <div id="show_warrentyBody" style="padding-left:0;padding-right:0" class="modal-body"></div>
                  </div>
            </div>
        </div>


        <div class="modal fade" id="service_repair_bookModal" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2>Service and Repair Book</h2>
                    </div>
                    <div class="modal-body text-center" >
                        <div id="service_repair_bookBody"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="showchit_noModal" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2>Centre-Kajang</h2>
                    </div>
                    <div class="modal-body text-center" >
                        <div id="showchit_noBody"></div>
                    </div>
                </div>
            </div>
        </div>




</div>
@stop

@section('scripts')
<script>

   $('#StaffManagement').DataTable();

   function show_warrenty()
   {
    $.ajax({
            type: "GET",
            url: JS_BASE_URL+"/raw/show_warranty",
            success: function( data ) {
                $("#show_warrentyBody").html(data);
                $('#show_warrentyModal').modal('show');
            }
        });
   }

   function service_repair_book()
   {
       $.ajax({
           type: "GET",
           url: JS_BASE_URL+"/raw/service_repair_book",
           success: function( data ) {
               $("#service_repair_bookBody").html(data);
               $('#service_repair_bookModal').modal('show');
           }
       });
   }

   function show_chitno()
   {
       $.ajax({
           type: "GET",
           url: JS_BASE_URL+"/raw/show_chitno",
           success: function( data ) {
               $("#showchit_noBody").html(data);
               $('#showchit_noModal').modal('show');
           }
       });
   }
</script>
@stop

