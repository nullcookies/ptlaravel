<?php
use App\Classes;
use App\Http\Controllers\IdController;
use App\Http\Controllers\UtilityController;
?>
@extends("common.default")
@section("content")
@include('common.sellermenu')
<script type="text/javascript">
    function removecontent(contentid) {
        $('#form'+contentid).html("");
    }
    function submitform(formid) {
        $('#form'+formid).submit();
    }
    function submitdefaultform(defaultform) {
        $('#'+defaultform).submit();
    }
</script>
<style type="text/css">
.dateformcontrol{
    width: 65% !important;
    margin-left: 10% !important;
    margin-top: 10px !important;
    float: left !important;
}
.print_qr{
    width: 70px;
    height: 70px;
    border-radius: 5px;
    text-align: center;
    vertical-align: middle;
    float: right;
    font-size: 15px;
    cursor: pointer;
    margin-right: 8px;
    margin-bottom: 5px;
}
#chk{
    width: 20%;
    margin-top: 17px !important;
    height: 21px !important;
}
.sellerbutton{
    width: 70px;
    height: 70px;
    padding-top: 26px;
    text-align: center;
    vertical-align: middle;
    float: left;
    font-size: 13px;
    cursor: pointer;
    margin-right: 5px;
    margin-bottom: 5px;
    border-radius: 5px;
}

.sellerbuttontwo{
    padding-top: 18px;
}

.sellerbuttonthree{
    padding-top: 7px;
    padding-left: 2px;
    margin-left: 0;
    margin-right: 0;
}

</style>
<div class="container" style="margin-top:30px;">
    <div class="table-responsive" style="margin-bottom: 28px;">
        <h2>Merchant Inventory
            <small>
                <button class="sellerbutton sellerbuttonthree btn btn-default btn-primary pull-right"
                onclick="autobarcode()" 
                style="margin-left: 5px;" 
                id="autobarcode">&nbsp;&nbsp;Map<br>&nbsp;&nbsp;Default<br>&nbsp;&nbsp;&#8239;Barcode</button>

                <button class="sellerbutton sellerbuttonthree btn btn-default btn-primary pull-right"
                id="freeze_modal_show">&nbsp;&nbsp;End<br>SalesMemo<br>&nbsp;&nbsp;Voidance</button>
            </small>
        </h2>
        <table class="table table-bordered" cellspacing="0"
        id="merchant-inventory" style="width:100% !important;">
        <thead style="color:white">
            <tr style="">
                <td class="text-center bsmall no-sort bg-inventory"
                style="">No.</td>
                <td class="text-center bg-inventory"
                style="padding-left:5%; padding-right:5%;">Product Name</td>
                {{-- <td class="text-center"
                style="background-color: #4A452A; padding-left:5%; padding-right:5%; display: none;">ID</td> --}}
                {{-- <td class="text-center"
                style="background-color: #4A452A; padding-left:5%; padding-right:5%; display: none;">Category</td> --}}
                {{-- <td class="text-center"
                style="background-color: #4A452A; padding-left:5%; padding-right:5%; display: none;">Subcategory</td> --}}
                <td class="text-center bg-beige" style="">Online</td>
                    <!--    <td class="text-center "
                            style="background-color:#7F7F7F;">B2B</td>
                        <td class="text-center "
                        style="background-color:#2F4177;">Hyper</td>-->
                        <td class="text-center bg-inventory" style="">Offline</td>
                    {{--<td class="text-center "
                        style="background-color:#ABE2C2;">Warehouse</td>
                    <td class="text-center "
                    style="background-color:#4A452A;">Last&nbsp;Update</td>--}}
                    <td class="text-center "
                    style="background-color: #4A452A;">Mapped</td>
                    <td class="text-center "
                    style="background-color: #4A452A;">Cost</td>
                    <td class="text-center "
                    style="background-color: #4A452A;">Total</td>
                    {{--
                    <td class="text-center "
                        style="background-color: #4A452A; display: none;">SKU</td>
                        --}}
                    </tr>
                </thead>

                <tbody>
                    <?php $num = 1; ?>
                    @foreach($merchant_pro as $product)
                    <tr>
                        <td style="vertical-align:middle"
                        align="center">{{ $num }}</td>
                        <?php
                        $limit = 60;
                        $pname = $product->name;
                        if(strlen($pname) > $limit){
                            $pname = substr($pname, 0, $limit-3);
                            $pname .= "...";
                        }
                        ?>
                        <td align="left">
                            <a href="{{url()}}/productconsumer/{{$product->id}}"
                                target="_blank">
                                <img src="{{asset('/')}}images/product/{{$product->id}}/thumb/{{$product->photo_1}}"
                                width="30" height="30"
                                style="padding-top:0;margin-top:4px">
                                <span style="vertical-align: middle;"
                                title="{{$product->name}}">&nbsp;{{$pname}}</span></a>
                            </td>
                            {{-- <td align="left" style="display: none;">
                                {{IdController::nP($product->id)}}
                            </td> --}}
                            {{-- <td align="left" style="display: none;">
                                {{$product->categorydesc}}
                            </td> --}}
                            {{-- <td align="left" style="display: none;">
                                @if(!is_null($product->slevel1))
                                {{$product->slevel1}}
                                @endif
                                @if(!is_null($product->slevel2))
                                {{$product->slevel2}}
                                @endif
                                @if(!is_null($product->slevel2))
                                {{$product->slevel2}}
                                @endif
                            </td> --}}
                            <?php
                            $totalb2b = 0;
                            $b2b = 0;
                            $term = 0;
                            $hyper = 0;
                            if(!is_null($product->availableb2b)){ $b2b= $product->availableb2b; }
                            if(!is_null($product->warehouse_available)){ $term= $product->warehouse_available; }
                            if(!is_null($product->availablehyper)){ $hyper= $product->availablehyper; }
                            $totalb2b = $b2b + $term;
                            $totaldef = $b2b + $term + $hyper + $product->available;
                            ?>
                            <td style="vertical-align:middle" align="center">
                                <a href="javascript:void(0);" class="avb2b" rel-hyper="{{$hyper}}" rel-b2b="{{$b2b}}" rel-b2c="{{$product->available}}" rel-term="{{$term}}" rel-total="{{$totaldef}}">{{$totaldef}}</a>
                            </td>

                    <!--    <td align="right"><a href="javascript:void(0);" class="avb2b" rel-b2b="{{$b2b}}" rel-term="{{$term}}" rel-total="{{$totalb2b}}">{{$totalb2b}}</td>
                        <td align="right">@if(!is_null($product->availablehyper)) {{$product->availablehyper}} @else 0 @endif</td> -->

                        <td style="vertical-align:middle"  align="center">
                            <a target="_blank" href="{{URL::to('/') . '/producttracking/' . $product->id . '/' . $selluser->id}}" rel="{{$product->id}}">{{$product->consignment_total or '0'}}</a>
                        </td>

                        {{--
                        <td style="vertical-align:middle;display:none"
                            align="center">
                        <span class="warehouse_qty"
                            id="warehouse_qtyspan{{$product->id}}"
                            rel="{{$product->id}}">0
                        </span></td>

                        <td align="center">
                            @if(isset($product->last_updated))
                                @if(!is_null($product->last_updated))
                                <a href="javascript:void(0)" class="trackings"
                                rel="{{$product->id}}">
                                {{UtilityController::s_datenotime($product->last_updated)}}</a>
                                @endif
                            @endif
                        </td>
                        --}}
                        <?php
                        $totalavailable =
                        $product->available + $totalb2b +
                        $product->availablehyper;

                        $totalavailable += $product->consignment_total;
                        ?>
                        <td style="vertical-align:middle" class="text-center">
                            <a href="javascript:void(0);" class="mapping"
                            rel="{{$product->id}}">
                            @if (is_null($product->bc_management_id) or
                            (!is_null($product->pbdeleted_at)))
                            N
                            @else
                            Y
                            @endif
                        </a>
                    </td>
                    <td class="text-right" style="vertical-align:middle">
                    @if(isset($avg[$product->id]) &&
                        !empty($avg[$product->id]))
                        <a onclick="inventorydetails({{$product->id}})"> 
                            {{$currentCurrency}}
                            {{number_format($avg[$product->id]/100,2)}}
                        </a>
                        @else
                        {{$currentCurrency}}
                        {{number_format(0,2)}}

                        @endif
                    </td>
                    <td style="vertical-align:middle" align="center">
                        <span id="totalavailable{{$product->id}}">
                        {{$totalavailable}}</span>
                    </td>
                        {{--
                        <td align="right" style="display: none;">
                            {{$product->sku}}</td>
                            --}}
                        </tr>
                        <?php $num++; ?>
                        @endforeach

                        @foreach($merchant_prot as $tproduct)
                        <tr>
                            <td align="center">{{ $num }}</td>
                            <?php
                            $pname = $tproduct->name;
                            if(strlen($pname) > 20){
                                $pname = substr($pname, 0, 17);
                                $pname .= "...";
                            }
                            ?>
                            <td align="left">
                                <span style="vertical-align: middle;">{{$pname}}</span>
                            </td>
                            <td align="left" style="display: none;">

                            </td>
                            <td align="left" style="display: none;">

                            </td>
                            <td align="left" style="display: none;">

                            </td>
                            <td align="right">{{$tproduct->available}}</td>

                            <td align="right">0</td>

                        {{--
                        <td align="right">
                        <span class="twarehouse_qty"
                        id="twarehouse_qtyspan{{$tproduct->id}}"
                        rel="{{$tproduct->id}}">0</span>
                        <input style="display:none;" type="text" size="6"
                        class="twarehouse_qty_input form-control"
                        id="twarehouse_qty{{$tproduct->id}}"
                        rel="{{$tproduct->id}}" b2crel="0" b2brel="0"
                        hyperrel="0" consrel="0" value="{{$tproduct->available}}"/></td>
                        --}}

                        <?php
                        $totalavailable = $tproduct->available;
                        ?>
                        <td class="text-center">N.A</td>
                        <td class="text-center">
                            @if(isset($avg[$tproduct->id]))
                            {{$avg[$tproduct->id]}}
                            @endif
                            {{$tproduct->id}}
                        </td>
                        <td align="right">
                            <span id="ttotalavailable{{$tproduct->id}}">
                            {{$totalavailable}}</span></td>
                        </tr>
                        <?php $num++; ?>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="modal fade" id="freeze_modal" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document" style="width: 20%">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>

                        </div>
                        <div class="modal-body-tracking">
                            <p class="text-warning"
                            style="padding:10px;"
                            >Are you sure, you want to freeze all sales memos till this date and time? This action cannot be undone.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="freeze_salesmemo" class="btn btn-default btn-primary pull-left " data-dismiss="modal">Yes</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

        <div class="modal fade" id="qrModal" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">QR Content</h4>
                    </div>
                    <div class="modal-body" style="overflow-y:scroll;height:400px;">
                        <form id="qrsettingform" method="post" target="_blank" action="{{route('qrsetting')}}">

                            <table class="table tableqrbc table-responsive ">
                                <thead>
                                    <tr>
                                        <td style="width: 45% !important;height:50px !important;">
                                            <div onclick="submitdefaultform(`qrsettingform`)" id="defaultqr" rel-pid="0"></div>
                                            <br><span style="float: left;    margin-top: -10px;/* margin-left: 22%; */">Click on QR image to Print</span>
                                        </td>
                                        <td style="width:100px !important;height:50px !important;vertical-align:middle !important;">
                                            <input hidden="hidden" type="text" value="1" name="default"
                                            placeholder="Default">

                                        </td>

                                        <td style="vertical-align:middle">
                                            <button style="background: black;color: white; " type="button" class="btn print_qr btn-default add_new_qr btn-primary pull-right">+QR</button>
                                        </td>
                                    </tr>
                                </thead>
                            </table>
                            <table style="margin-bottom: 0"
                            class="table tableqrbc table-responsive ">
                            <thead>
                                <div id="newcontenthtml">
                                    <tr id="newqrcontent" style="display:none;">
                                        <td style='width: 79px !important;height:50px !important;'>
                                            <div id="defaultqr" rel-pid=""></div>
                                        </td>

                                        <td style='width: 65% !important;height:50px !important;vertical-align:middle !important;'>
                                            <span>Please Select Date</span>
                                            <input type="date" placeholder="Expiry" class="form-control "   id="newqrcontentvalue">
                                        </td>
                                        <td style='   width: 3px;'>
                                        </td>
                                        <td style='vertical-align:middle;width:50px !important;' >

                                        </td>
                                    </tr>
                                </div>

                            </thead>
                            {{ csrf_field() }}
                            <input id="setpid" type="number" name="product_id" hidden="hidden" value="">
                            <tbody id="oldqrcontent">
                            </tbody>

                        </table>


                        <div style="padding-left: 7px;" class="modal-footer">
                            <div id="addedcontenthtml">

                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="inventorydetailsmodel" role="dialog"
        aria-labelledby="inventorydetailsmodel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title" id="myModalLabel">
                    Historical Purchase Cost</h3>
                </div>
                <div style="padding-left: 7px;" class="modal-footer">
                    <div id="addedinventorydetailcontent">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="myModalccc" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document" style="width: 50%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">E-Commerce Inventory</h4>
                    </div>
                    <div class="modal-body">
                        <h3 id="modal-Tittle1"></h3>
                        <h3 id="modal-Tittle"></h3>
                        <div class="table-responsive">
                            <table id="myTable" class="table table-bordered myTable">
                                <tr>
                                    <td style="background-color: #808080; color: white; text-align: center;" >
                                        B2C
                                    </td>
                                    <td style="background-color: #808080; color: white; text-align: center;" >
                                        B2B PaymentGateway
                                    </td>
                                    <td style="background-color: #F396D4; color: white; text-align: center;">
                                        B2B Credit Term
                                    </td>
                                    <td style="background-color: #2F4177; color: white; text-align: center;">
                                        Hyper
                                    </td>
                                <!--    <td style="background-color: #948A54; color: white; text-align: center;">
                                        Total
                                    </td> -->
                                </tr>
                                <tr>
                                    <td style="text-align: right;">
                                        <span id="b2cspan"  style="text-align: right;"></span>
                                    </td>
                                    <td style="text-align: right;">
                                        <span id="b2bspan"  style="text-align: right;"></span>
                                    </td>
                                    <td style="text-align: right;">
                                        <span id="termspan" style="text-align: right;"></span>
                                    </td>
                                    <td style="text-align: right;">
                                        <span id="hyperspan"  style="text-align: right;"></span>
                                    </td>
                                <!--<td style="text-align: right;">
                                    <span id="totalspan" ></span>
                                </td> -->
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>

        </div>
    </div>
</div>

<div class="modal fade" id="myModalTracking" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 90%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Product Tracking</h4>
                </div>
                <div class="modal-body-tracking">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>

        </div>
    </div>
</div>

<div class="modal fade" id="myModalMapping" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 70%">
        <div class="modal-content">

            <div class="modal-body-mapping">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>


        </div>
    </div>
</div>

<div class="modal fade" id="myModalLocation" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 60%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Product Location</h4>
            </div>
            <div class="modal-body-locations">
            </div>
            <div style="padding-left: 7px;" class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </form>

    </div>

</div>
</div>

<input type="hidden" id="selluser" value="{{$selluser->id}}" />
<script type="text/javascript" src="{{asset('js/barcode.js')}}"></script>
<script>
    function inventorydetails(id) {
        $.ajax({
            url:JS_BASE_URL + '/inventorydetails/'+id,
            type:"GET",
            success:function(r){
                $('#addedinventorydetailcontent').html(r);
                $('#inventorydetailsmodel').modal('show');
            }

        });
    }

    $(document).ready(function(){


        $("#freeze_modal_show").click(function(){
            $("#freeze_modal").modal("show");
        });
        $('#freeze_salesmemo').click(function(){
            $(this).prop("disabled",true);
            url="{{url("salesmemo/freeze")}}";
            $.ajax({
                url:url,
                type:"GET",
                success:function(r){
                    if (r.status=="success") {toastr.info("Sales Memo to this date has been frozen")}
                        else{
                            console.log(r.short_message);
                            toastr.warning("Failed to perform action");
                        }
                    },
                    error:function(){toastr.warning("Failed to connect to server");}
                });
        })

            /*$('.print_qr').click(function(){
             if(jQuery('#qrsettingform input[type=checkbox]:checked').length)
             {
             $('#qrsettingform').submit();

             }
             else
             {
             toastr.warning("Please Select checkbox first");

             }

            });*/
            $(".add_new_qr").click(function(){
                $("#newqrcontent").show();
            });
            $("#newqrcontentvalue").change(function(){
                $("#newqrcontent").hide();
                var pid = $('#getpid').val();
                //$('#setpid').val(pid);
                $('input[name=product_id]').val(pid);

                var rand = Math.floor((Math.random() * 100) + 1);
                content=$("#newqrcontentvalue").val();
                var htmlcontent = `<div style="width:100%;float: left;">
                <form id="form`+rand+`" method="post" target="_blank" action="{{route('qrsetting')}}">
                {{ csrf_field() }}
                <tr id=tr_qrbc_`+content+`>
                <td  style='width:50px !important;height:50px !important;' >

                <div style="float: left;" onclick="submitform(`+rand+`)" class='qr' id=qrbc_id_`+rand+` rel-content='`+content+`'></div>
                </td>
                <td style='width:100px !important;height:50px !important;vertical-align:middle !important;'>
                <input type='date' name="product[`+pid+`]" class="form-control dateformcontrol" 
                value='`+content+`'></td>
                <td style='vertical-align:middle;width:100px;'>
                </td>
                <td style='vertical-align:middle;width:50px !important;'>
                <span style="margin-right: 3%;font-size:25px;margin-top:10px;border-radius:20px;    padding: 0px 10px; margin-bottom: 0;" type="button" onclick="removecontent(`+rand+`)" class="btn btn-danger">&times;</span>
                </td>
                </tr>
                </form></div><br>`;

                $('#addedcontenthtml').prepend(htmlcontent);
                $("#qrbc_id_"+rand).qrcode({height:50,width:50,text:pid+';'+content});
            });

            /*$("#newqrcontentvalue").change(function(){
             $("#newqrcontent").hide();

             content=$("#newqrcontentvalue").val();
             if (content==""||content==null||content==undefined) {
             return;
             }
             pid=$("#newqrcontentvalue").attr("rel-pid");
             url=JS_BASE_URL+"/qrbccontent";
             data={
             type:"expiry",
             content:content,
             mode:"qr",
             product_id:product_id,
             action:"save_data"
             };
             $.ajax({
             url:url,
             type:"POST",
             data:data,
             success:function(r){
             var myhtml=`<tr id=tr_qrbc_`+r.qrbc_id+`><td style='width:50px !important;height:50px !important;' >
             <div class='qr' id=qrbc_id_`+r.qrbc_id+` rel-content='`+content+`'>
             </td>
             <td style='width:100px !important;height:50px !important;vertical-align:middle !important;'>
             <input type='date' class='' disabled='disabled'
             value='`+content+`'></td>
             <td style='vertical-align:middle;width:100px;'>
             <input class="form-control" id="chk" type='checkbox' name='qr[]' value='`+r.qrbc_id+`' class='form-control'
             style='margin-top:0;height:15px;' rel-content='`+content+`'></td>
             <td style='vertical-align:middle;width:50px !important;'>
             </td>
             </tr>`;

             $("#oldqrcontent").prepend(myhtml);
             $("#qrbc_id_"+r.qrbc_id).qrcode({height:50,width:50,text:content});
             },
             error:function(){
             toastr.warning("Could not save QR");
             }
             })
            });*/

            var table = $('#merchant-inventory').DataTable({
                "order": [],
                "deferRender": true,
                "columnDefs": [
                {"targets": 'no-sort', "orderable": false, },
                {"targets": "medium", "width": "80px" },
                {"targets": "large",  "width": "120px" },
                {"targets": "approv", "width": "180px"},
                {"targets": "blarge", "width": "200px"},
                {"targets": "bsmall",  "width": "20px"},
                {"targets": "clarge", "width": "250px"},
                {"targets": "xlarge", "width": "300px" }
                ]
            });

            $(document).delegate( '.mapping', "click",function (event) {
                console.log("Product Mapping: 'Y/N' is pressed!");
                var id = $(this).attr('rel');
                /*$("#b2bspan").html($(this).attr('rel-b2b'));
                 $("#termspan").html($(this).attr('rel-term'));
                 $("#totalspan").html($(this).attr('rel-total'));*/
                 var selluser = $("#selluser").val();
                 $.ajax({
                    url: JS_BASE_URL + '/productmapping/' + selluser + '/' + id,
                    cache: false,
                    method: 'GET',
                    success: function(result, textStatus, errorThrown) {
                        $(".modal-body-mapping").html(result);
                        $("#myModalMapping").modal('show');
                        newBarcode($("#np_id").val());
                        $("#qr_img").qrcode({height:80,width:80,text:$("#np_id").val()});
                    }
                 });
                });

            $(document).delegate( '.trackings', "click",function (event) {
                console.log("Product trackings!");
                var id = $(this).attr('rel');
                /*$("#b2bspan").html($(this).attr('rel-b2b'));
                 $("#termspan").html($(this).attr('rel-term'));
                 $("#totalspan").html($(this).attr('rel-total'));*/

                 $.ajax({
                    url: JS_BASE_URL + '/producttracking/' + id,
                    cache: false,
                    method: 'GET',
                    success: function(result, textStatus, errorThrown) {
                        $(".modal-body-tracking").html(result);
                        $("#myModalTracking").modal('show');
                    }
                 });
                });

            $(document).delegate( '.locations', "click",function (event) {
                var id = $(this).attr('rel');
                $.ajax({
                    url: JS_BASE_URL + '/productlocations/' + id,
                    cache: false,
                    method: 'GET',
                    success: function(result, textStatus, errorThrown) {
                        $(".modal-body-locations").html(result);
                        $("#myModalLocation").modal('show');
                    }
                });
            });

            $(document).delegate( '.avb2b', "click",function (event) {
                console.log("HI");
                $("#b2bspan").html($(this).attr('rel-b2b'));
                $("#b2cspan").html($(this).attr('rel-b2c'));
                $("#termspan").html($(this).attr('rel-term'));
                $("#hyperspan").html($(this).attr('rel-hyper'));
                $("#totalspan").html($(this).attr('rel-total'));
                $("#myModalccc").modal('show');
            });

            $(document).delegate( '.warehouse_qty_input', "blur",function (event) {
                var objThis = $(this);
                var id = objThis.attr('rel');
                var b2c = parseInt(objThis.attr('b2crel'));
                var b2b = parseInt(objThis.attr('b2brel'));
                var hyper = parseInt(objThis.attr('hyperrel'));
                var cons = parseInt(objThis.attr('consrel'));
                var value = parseFloat(objThis.val());
                var qty = parseFloat($("#warehouse_qty" + id).val());
                /*$("#b2b_qty" + id).hide();
                 $("#b2b_qtyspan" + id).text(qty);
                 $("#b2b_qtyspan" + id).show(); */
                 $.ajax({
                    url: JS_BASE_URL + '/product_warehouse_qty',
                    cache: false,
                    method: 'POST',
                    data: {id: id, qty: qty},
                    success: function(result, textStatus, errorThrown) {
                        //  objThis.hide();
                        var totalavailable = b2c + b2b + hyper + cons + parseInt(result.result);
                        $("#warehouse_qty" + id).hide();
                        $("#warehouse_qtyspan" + id).text(result.result);
                        $("#totalavailable" + id).text(totalavailable);
                        $("#warehouse_qtyspan" + id).show();
                    }
                });
                });

            $(document).delegate( '.warehouse_qty', "click",function (event) {
                var objThis = $(this);
                objThis.hide();
                var id = objThis.attr('rel');
                $("#warehouse_qty" + id).show();
            });

            $(document).delegate( '.twarehouse_qty_input', "blur",function (event) {
                var objThis = $(this);
                var id = objThis.attr('rel');
                var b2c = parseInt(objThis.attr('b2crel'));
                var b2b = parseInt(objThis.attr('b2brel'));
                var hyper = parseInt(objThis.attr('hyperrel'));
                var cons = parseInt(objThis.attr('consrel'));
                var value = parseFloat(objThis.val());
                var qty = parseFloat($("#twarehouse_qty" + id).val());
                /*$("#b2b_qty" + id).hide();
                 $("#b2b_qtyspan" + id).text(qty);
                 $("#b2b_qtyspan" + id).show(); */
                 $.ajax({
                    url: JS_BASE_URL + '/tproduct_warehouse_qty',
                    cache: false,
                    method: 'POST',
                    data: {id: id, qty: qty},
                    success: function(result, textStatus, errorThrown) {
                        //  objThis.hide();
                        var totalavailable = b2c + b2b + hyper + cons + parseInt(result.result);
                        $("#twarehouse_qty" + id).hide();
                        $("#twarehouse_qtyspan" + id).text(result.result);
                        $("#ttotalavailable" + id).text(totalavailable);
                        $("#twarehouse_qtyspan" + id).show();
                    }
                });
                });

            $(document).delegate( '.twarehouse_qty', "click",function (event) {
                var objThis = $(this);
                objThis.hide();
                var id = objThis.attr('rel');
                $("#twarehouse_qty" + id).show();
            });
        });
function autobarcode() {
    url="{{url('seller/autobarcode',$selluser->id)}}";
    $.ajax({
        url,
        type:"GET",
        success:function(r){
            if (r.status=="success") {
                toastr.success("Auto barcode generated")
            }else{
                toastr.warning("Auto barcode generation failed")
            }
        },
        error:function(){
            toastr.danger("Failed to connect to the server.")
        }
    })
}
function newBarcode(valx) {
            //Convert to boolean

            $("#barcode").JsBarcode(
                valx, {
                    "background":"white", //Transparent bg-> undefined, no quotes
                    "lineColor":"black",
                    "fontSize": 10,
                    "height":70,
                    "width": 1,
                    "margin":0,
                    "textMargin": 5,
                    "font": 5,
                    "textAlign":5,
                    "valid": function(valid){
                        if(valid){
                            $("#barcode").show();
                        } else{
                            $("#barcode").hide();
                        }
                    }
                });
        };

    </script>
    @yield("left_sidebar_scripts")
    @stop
