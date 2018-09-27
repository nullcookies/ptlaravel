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

<div class="container" style="margin-top:30px;">
    <div class="table-responsive" style="margin-bottom: 28px;">
        <div class="col-md-12" style="margin-bottom:10px;padding-left:0px">
            <div class="col-md-10" style="padding-left:0px;width: 975px;">
                <div class="col-md-5">
                    <h2>Debit Note</h2>
                </div>
                <div class="col-md-5" style="padding-top:10px">
                   <!--  <h4>Staff Management</h4>
                    <h4>Staff Management</h4> -->

                </div>
            </div>

        </div>
        <table class="table table-bordered" cellspacing="0"
               id="debitnote" style="width:100% !important;">
            <thead style="background-color:#7D1747; color:white">
                <tr style="">
                    <td class="text-center bg-primarypurple">No</td>
                    <td class="text-center bg-primarypurple">Invoice No</td>
                    <td class="text-center bg-primarypurple">Merchant</td>
                </tr>
            </thead>
            <tbody>
                <?php $num = 0; ?>
                <tr>
                    <td style="text-align: center;">{{ ++$num }}</td>
                    <td class="text-center" style="vertical-align: middle">0003241212</td>
                    <td class="text-center" style="vertical-align: middle">abc jnjk</td>
                </tr>
            </tbody>
        </table>



    </div>
</div>
@stop
@section('scripts')
    <script>
        $('#debitnote').DataTable();
    </script>
@stop