@extends("common.default")
@section("content")
@include('common.sellermenu')
<style type="text/css">
.voucher_list {
    background:#2a75ed;
}
.select2-container--default .select2-search--dropdown .select2-search__field{
    display: none !important;
}
.voucher_list {
    background:#2a75ed;
}
label{
    display: inline-flex !important;

}
.select2-container{
margin: 0px 5px !important;}

</style>
<div class="container" style="margin-top:30px;">
	<div class="table-responsive" style="margin-bottom: 28px;">
		<h2>Voucher Management
		</h2>
		<table class="table table-bordered" cellspacing="0"
		id="VoucherManagement" style="width:100% !important;">
            <thead style="color:white">
                <tr style="">
                    <td class="text-center bsmall no-sort voucher_list"
                    style="">No.</td>
                    <td style="color:white" class="text-center voucher_list"
                    >Product ID</td>
                    <td class="text-center voucher_list"
                    >Name</td>
                    <td class="text-center voucher_list"
                    >Qty</td>
                    <td class="text-center voucher_list"
                    >Nature</td>
                    
                </tr>
            </thead>
            <tbody>
                <?php $num = 0; ?>
                    @foreach($voucher_list as $voucher)
                    <?php $num++; ?>
                    <tr>
                        <td 
                        style="text-align: center;">{{ $num }}</td>
                        <td 
                        style="text-align: center;">{{!empty($voucher->product_id)?str_pad($voucher->product_id, 10, '0', STR_PAD_LEFT):"" }}</td>
                        <td
                        style="text-align: center;">{{ $voucher->name }}</td>
                        <td 
                        style="text-align: center;"><a data-toggle="modal" data-target="#voucherlist" href="#">{{ !empty($voucher->package_qty)?$voucher->package_qty:"" }}</a></td>
                        @if($voucher->nature == "paper")
                        <td 
                        style="text-align: center;"><a data-toggle="modal" data-target="#vouchermodel<?php echo $voucher->id; ?>" href="#">{{ucfirst($voucher->nature)}}</a></td>
                        @else
                        <td 
                        style="text-align: center;">{{ucfirst($voucher->nature)}}</td>
                        @endif
                    </tr>
<!-- Voucher Model -->
<div class="modal fade" id="vouchermodel<?php echo $voucher->id; ?>" role="dialog">
    <div class="modal-dialog maxwidth60">
        <!-- Modal content-->
        <div class="modal-content  modal-content-patty">
            <div class="modal-header">
                <h4 style="margin-bottom:0"><strong>Paper Voucher</strong></h4>
                <button type="button"
                style="position:relative;top:-20px"
                class="close" data-dismiss="modal">&times;</button>
            </div>
            <div id="pattymodalbody" class=" modal-body">
            <div style="display:grid;" class="pnl-content">               
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                           <p><?php if($voucher->created_at != null) {echo date('dMy H:i:s', strtotime(str_replace('-','/',  $voucher->created_at)));} ?></p>  
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                           <label>Staff ID</label>  
                        </div>
                        <div class="col-md-8">
                            {{sprintf('%010d',$selluser->id)}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                           <label>Staff Name</label>   
                        </div>
                        <div class="col-md-8">
                            {{$selluser->first_name}} {{$selluser->last_name}}  
                        </div>
                    </div>
                    <div style="margin-bottom: 5px;" class="row">
                        <div class="col-md-4">
                           <label>Doc. No.</label>
                        </div>
                        <div class="col-md-8">
                            {{$voucher->doc_no}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label>Platform</label>
                        </div>
                        <div class="col-md-8">
                            {{ucfirst($voucher->platform)}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label>Description</label>
                        </div>
                    </div>
                    <div class="row">
                        <div style="background-color:#f0f0f0;width:100%;height:50px" class="col-md-12">
                           {{$voucher->description}}
                        </div>
                    </div>
                    <br>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
                @endforeach

            </tbody>
        </table>
            </div>
        </div>
<div  class="modal fade" id="voucherlist" role="dialog">
    <div class="modal-dialog" style="width: auto;">
        <!-- Modal content-->
        <div class="modal-content  modal-content-patty">
            <div class="modal-header">
                <h4 style="margin-bottom:0"><strong>Voucher List</strong></h4>
                <button type="button"
                style="position:relative;top:-20px"
                class="close" data-dismiss="modal">&times;</button>
            </div>
            <div id="pattymodalbody" class=" modal-body">
            <div style="display:grid;" class="pnl-content">               
                <div class="table-responsive" style="margin-bottom: 28px;">
<!--         <h2>Voucher Management
        </h2>
 -->        <table class="table table-bordered" cellspacing="0"
        id="Voucher_lists" style="width:100% !important;">
            <thead style="color:white">
                <tr style="">
                    <td class="text-center bsmall no-sort voucher_list"
                    style="">No.</td>
                    <td style="color:white" class="text-center voucher_list"
                    >Voucher ID</td>
                    <td style="color:white" class="text-center voucher_list"
                    >Buyer ID</td>
                    <td class="text-center voucher_list"
                    >Issued</td>
                    <td class="text-center voucher_list"
                    >Left</td>
                    <td class="text-center voucher_list"
                    >Used</td>
                    <td class="text-center voucher_list"
                    >Status</td>
                    <td class="text-center voucher_list"
                    >Expiry</td>                    
                </tr>
            </thead>

            <tbody>
                    <tr>
                        <td 
                        style="text-align: center;">1</td>
                        <td 
                        style="text-align: center;">{{str_pad($voucher->id, 10, '0', STR_PAD_LEFT)}}</td>
                        <td
                        style="text-align: center;"></td>
                        <td 
                        style="text-align: center;">{{$voucher->issued}}</td>
                        <td 
                        style="text-align: center;">{{$voucher->vleft}}</td>
                        <td
                        style="text-align: center;"><a data-toggle="modal" data-target="#VoucherLedger<?php echo ""; ?>" href="#">{{$voucher->issued - $voucher->vleft}}</a></td>
                        <td 
                        style="text-align: center;">Active</td>
                        <td
                        style="text-align: center;"></td>
                    </tr>
            </tbody>
        </table>
    </div>
                    
                </div>
            </div>
            </div>
        </div>
    </div>
<div  class="modal fade" id="VoucherLedger<?php echo ""; ?>" role="dialog">
    <div class="modal-dialog" style="width: auto;">
        <!-- Modal content-->
        <div class="modal-content  modal-content-patty">
            <div class="modal-header">
                <h4 style="margin-bottom:0"><strong>Voucher Ledger</strong></h4>
                <button type="button"
                style="position:relative;top:-20px"
                class="close" data-dismiss="modal">&times;</button>
            </div>
            <div id="pattymodalbody" class=" modal-body">
            <div style="display:grid;" class="pnl-content">               
                <div class="table-responsive" style="margin-bottom: 28px;">
<!--         <h2>Voucher Management
        </h2>
 -->        <table class="table table-bordered" cellspacing="0"
        id="Voucher_ledger" style="width:100% !important;">
            <thead style="color:white">
                <tr style="">
                    <td class="text-center bsmall no-sort voucher_list"
                    style="">No.</td>
                    <td style="color:white" class="text-center voucher_list"
                    >Date</td>
                    <td style="color:white" class="text-center voucher_list"
                    >Branch</td>
                    <td class="text-center voucher_list"
                    >Staff Name</td>
                    <td class="text-center voucher_list"
                    >Staff ID</td>                  
                </tr>
            </thead>

            <tbody>
                    <tr>
                        <td 
                        style="text-align: center;">1</td>
                        <td 
                        style="text-align: center;"></td>
                        <td 
                        style="text-align: center;"></td>
                        <td
                        style="text-align: center;">{{$selluser->first_name}} {{$selluser->last_name}}</td>
                        <td 
                        style="text-align: center;">{{sprintf('%010d',$selluser->id)}}</td>
                    </tr>
            </tbody>
        </table>
    </div>
                    
                </div>
            </div>
            </div>
        </div>
    </div>
<script>
var table = $('#Voucher_lists').DataTable({

			});
var table1 = $('#VoucherManagement').DataTable({

});
var table2 = $('#Voucher_ledger').DataTable({
});
$('[name=VoucherManagement_length]').removeClass('select2');
$('.selection').empty();
</script>
 @yield("left_sidebar_scripts")
    @stop
