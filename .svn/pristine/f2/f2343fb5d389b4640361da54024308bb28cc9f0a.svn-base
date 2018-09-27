
<link href="{{URL::to('opposum_libs/css/app.css')}}" rel="stylesheet">
<link href="{{URL::to('opposum_libs/css/style.css')}}" rel="stylesheet">
<?php
//$bfunction="spa";
?>
<style>
#voidstamp{
    color: red;
    position: absolute;
    z-index: 2;
    font-size: 133px;
    font-weight: 500;
    margin-top: 311px;
    margin-left: 42px;
    transform: rotate(30deg);
    display:none;
}

</style>

<div id="confirmModal" style="z-index:1234;" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      
      <div class="modal-body">
        <p id="confirmModalMessage"></p>
      </div>
      <div class="modal-footer">
      
        <button type="button" class="btn btn-default" id='yes' data-dismiss="modal" >Yes</button>
        <button type="button" class="btn btn-default" id='no'  data-dismiss="modal" >No</button>
      </div>
    </div>

  </div>
</div>

<script>
var output=false;
function confirmInput(message,type,callback){
    if(type!=="confirm"){
            $("#yes").html("OK");
            $("#no").html("Close");
    }else{
        $("#yes").html("Yes");
            $("#no").html("No");
    }
        $("#confirmModalMessage").html(message); 
        $("#confirmModal").modal("show");
   document.getElementById("yes").onclick=function(){
    $("#confirmModal").modal("hide");
                    callback(true);         
   }
   document.getElementById("no").onclick=function(){
    $("#confirmModal").modal("hide");
                    callback(false);         
   }
}
</script>

<div  id="receiptmodal" role="dialog">

    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
<div class="text-center "><h2 id="voidstamp">Void</h2></div>

            <div id="style"></div>
            <div style="padding:0" class="modal-body">
                <div style="padding-left:5px" class="">
                    <div id="invoice-container" class="invoice-container"
                         style="padding-left:5px">
                        <h3 class="rheader">Receipt</h3>
                        <h4 class="company_name">{{!empty($company->dispname)?$company->dispname:""}}</h4>
                        <p class="company_addr">{{!empty($company->line1)?$company->line1:""}}</p>
                        <p class="company_addr">{{!empty($company->line2)?$company->line2:""}}</p>
                        <p class="company_addr">{{!empty($company->line3)?$company->line3:""}}</p>
                        <p class="company_addr"> GST No:{{!empty($company->gst)?$company->gst:""}}</p>
                        <p class="company_addr">
                        {{Carbon::now()->format('dMy H:i:s')}}</p>

                        <p class="float-left invoice-title"
                           style="margin-top:5px;margin-left:10px;font-weight:bold">Receipt No:</p>
                        <span id="invoiceno"
                            class="float-left bold invoice-title">{{sprintf("%010d",$receiptInfo->receipt_no)}}</span>
                        <br>
                         <form id="recsaveform" name="recsaveform" method="post">
                        <table class="table ">
                            <thead class="white">
                            <tr>
                                <th class="text-left theader-font"
                                    style="padding-top:3px;padding-bottom:3px;padding-left:10px">
                                    Description</th>
                                <th class="text-center theader-font"
                                    style="padding-top:3px;padding-bottom:3px;padding-left:5px">
                                    Qty</th>
                                <th class="text-right theader-font"
                                    style="padding-top:3px;padding-bottom:3px;padding-left:5px">
                                    Price</th>
                                <th class="text-right theader-font"
                                    style="padding-top:3px;padding-bottom:3px;padding-left:5px">
                                    Disc</th>
                                <th class="width-30 text-right theader-font"
                                    style="padding-top:3px;padding-bottom:3px;padding-left:5px">
                                    Total</th>
                            </tr>
                            </thead>
                            
                                <?php $total = 0; ?>

                                <tbody style="" id="receipt_tbody">
                                @foreach($receipts as $receipt)
                                <tr id="rec_row">
                                    <td id="recepit_des" class="float-left rec-product-font">
                                        {{$receipt->name}}
                                    </td>
                                    <td id="recepit_qty" class="text-center item-font">
                                        {{$receipt->quantity}}</td>
                                    <td id="recepit_price" class="text-right item-font">
                                        {{number_format($receipt->price/100,2)}}
                                    </td>
                                    <td> <div class="text-center"><span class="getdiscountid" id="rec_discount">{{$receipt->discount}}</span><span id="percentsign">%</span> </button></div> </td>
                                    <td id="recepit_amount" class="text-right item-font">
                                         <?php $total+=((($receipt->price)-($receipt->price*($receipt->discount/100)))*$receipt->quantity)/100; ?>
                                        {{number_format(((($receipt->price)-($receipt->price*($receipt->discount/100)))*$receipt->quantity)/100,2)}}
                                    </td>
                                </tr>
                            @endforeach
                                </tbody>
                        </table>
                            </form>

                        <div class="float-left invoice-table-div">
                            <p style="margin-top:3px" class="total-font float-right ftotal reset0" id="recp_ftotal"></p>
                            <p style="margin-top:3px;margin-right:0" class="float-right total-font">Total {{$currentCurrency}} {{number_format($total,2)}}</p>
                        </div>
                        <div class="width100 float-left">
                            <p class="total-font float-right reset0" id="recp_gst"></p>
                            <p class="margin-right-3 float-right total-font">
                                Total include {{$gst_rate}}% GST {{$currentCurrency}} {{"0.00"}}</p>
                        </div>
                        <div style="margin-bottom:5px" class="width100 float-left">
                            <p class="total-font float-right reset0" id="recp_gtotal"></p>
                            <p class="float-right total-font">Item Total {{$currentCurrency}} {{number_format($total,2)}} </p>
                        </div>
                        <br>
                        <div style="border-top:1px solid #e0e0e0;margin-left:10px"
                             class="total total-font rec-staf width100">
                            <div style="line-height: 1.2;" class="calculation-heading" >
                                <p class="float-left margin-top5">OpenCredit</p><br>
                                <p class="float-left margin-top5">Other Points</p>
                                <br>
                            </div>
                            <div style="line-height: 1.2;" class="calculation-heading" >
                                <p class="float-left margin-top5 ">Pts</p><br>
                                <p class="float-left margin-top5 ">Pts</p>
                            </div>
                            <div style="line-height:1.2; width:auto"
                                 class="calculation-heading total-details" >
                                <p id="rec-opencredit" class="margin-top5 total-font reset0">0.00</p>
                                <p id="rec-otherpoints" class="margin-top5 total-font reset0">0.00</p>
                            </div>
                        </div>
                        <div style="margin-left:10px;margin-bottom:10px" class="total total-font rec-staf width100">
                            <div class="calculation-heading" style="flex-direction: column;display: flex;" >
                                <p class="float-left">Final Total</p>
                                <p class="float-left">Cash Received</p>
                                <p class="float-left">Change </p>

                            </div>
                            <div>
                                <p class="float-left ">{{$currentCurrency}}</p><br>
                                <p class="float-left ">{{$currentCurrency}}</p><br>
                                <p class="float-left ">{{$currentCurrency}}</p>
                            </div>
                            <div  class="total-details widthauto" >
                                <p id="" class="float-right total-font ftotal reset0 ">{{number_format($total,2)}}</p><br>
                                <p id="on_receipt_cash_received" class="float-right total-font cash_received reset0">{{number_format($receiptInfo->cash_received/100,2)}}</p><br>
                                <p id="change" class="float-right total-font change reset0 ">@if($receiptInfo->cash_received>0)({{number_format(
                                    ($receiptInfo->cash_received/100-$total),2
                                )}})@else(0.00)@endif</p>
                            </div>
                        </div>
                        <div style="margin-left:10px;margin-bottom:10px" class="total total-font rec-staf width100">
                        <p class="float-left reset" id="payment_method_on_receipt">
                            @if($receiptInfo->cash_received>0)
                            This bill is paid by Cash.
                            @else
                            <p style="text-align: left;
    padding-left: 0px;
    margin-left: -50px;">
                            Credit Card                        
                          XXXX-XXXX-XXXX-{{!empty($receiptInfo->creditcard_no)?$receiptInfo->creditcard_no:""}}
                            </p>
                             @endif

                        </p>
                     
                        </div>
                        <table style="border-top:1px solid #e0e0e0;margin-left:10px;width: 94%;" class="">
                            @if($bfunction == 'spa')
                            <tr style="padding-top:5px" class="total-font">
                                <td style="padding-top:5px" colspan="3" class="text-left">Key&nbsp;No.</td>
                                <td style="padding-top:5px" colspan="1" class="text-right reset lockerkey"  id="">
                                    
                                    {{sprintf('%05d',$key->fnumber)}}
                                </td>
                            </tr>

                            <!--
                            <tr style="padding-top:5px" class="total-font">
                                <td style="padding-top:5px" colspan="3" class="text-left">Spa Room&nbsp;No.</td>
                                <td style="padding-top:5px" colspan="1" class="text-right reset sparoomn  id=""></td>
                            </tr>
                            -->
                            @elseif($bfunction=='table')
                            <tr class="total-font">
                                <td colspan="3" class="text-left">Table No.</td>
                                <td colspan="1" class="text-right reset table">
                               {{--  {{sprintf('%05d',9)}} --}}</td>
                            </tr>
                            @elseif($bfunction=='hotel')
                            <tr class="total-font">
                                <td colspan="3" class="text-left">Hotel&nbsp;Room&nbsp;No.</td>
                                <td colspan="1" class="text-right reset hotelroom">
                               {{--  {{sprintf('%05d',9)}} --}}</td>
                            </tr>
                            @endif
                            <tr class="total-font">
                                <td colspan="3" class="text-left">Branch</td>
                                <td colspan="1" class="text-right" id="branch_name">{{$location->location}}</td>
                            </tr>
                            <tr class="total-font">
                                <td colspan="3" class="text-left">Terminal&nbsp;ID</td>
                                
                                <td colspan="1" class="text-right" id="terminal_id">
                                {{sprintf('%05d', $receiptInfo->terminal_id)}}
                                
                                </td>
                            </tr>
                            <tr class="total-font">
                                <td colspan="3" class="text-left">Staff ID</td>
                                <td colspan="1" class="text-right" id="staffid">
                                {{sprintf('%010d',!empty($receiptInfo->staff_id)?$receiptInfo->staff_id:"0")}}
                                </td>
                            </tr>
                            <!-- Receipt Modal -->
                            <tr class="total-font">
                                <td colspan="3" class="text-left">Staff Name</td>
                                <td colspan="1" class="text-right" id="staffname">
                                {{$receiptInfo->staff_name_concat or $receiptInfo->staff_name}}
                                </td>
                            </tr>
                        </table>
                        <br>
                        <div class="invoice-control">
                            <button onclick ="print_qz()"
                                class="invoice-control-btn center bold blue btn">
                                <h5 style="margin:0">Print</h5></button>
                            <button id="red_void"

                                receipt_id="{{$receiptInfo->id}}"
                                class="invoice-control-btn center bold red btn">
                                <h5 style="margin:0">Void</h5></button>
                            <button 
                                
                                style="line-height:20px"
                                class="invoice-control-btn center crossbtn btn black">
                                &times
                            </button>
                            <div id="qr"
                                class="center qr invoice-control-btn center" >
                            </div>
                        </div>
                        <div class="center" >
                            <canvas id="barcode"></canvas></div>
                        <span id="barcodenumber"
                            class="width100 float-left text-center"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
<div class="modal fade" id="opsLokerKeyDataModal" role="dialog">
    <div class="modal-dialog " style="width:385px !important">
        <!-- Modal content-->
        <div class="modal-content modal-content-sku">
            <div class="modal-header">
                <h2 id="opslokerdatatitle"></h2>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Temporarily disable the modal due to UGLY ERROR -->
            <div id="opslokerdatabody"
                style="padding-left:0;padding-right:0"
                class="modal-body"></div>
        </div>
    </div>
</div>

 <script src="{{URL::to('opposum_libs/js/jquery-2.2.4.min.js')}}"></script>
 <script type="text/javascript" src="{{asset('opposum_libs/js/bootstrap.js')}}"></script>
 <script type="text/javascript" src="{{asset('js/qr.js')}}"></script>
 <script type="text/javascript" src="{{asset('js/barcode.js')}}"></script>
 <script type="text/javascript">

@if(!empty($receiptInfo->status) && $receiptInfo->status=="voided")
document.querySelector("#voidstamp").style.display="block";
document.querySelector("#red_void").style.display="none";
@endif
 var JS_BASE_URL="{{url()}}"
 var newBarcode = function(value) {
            //Convert to boolean
           // value=$('#invoiceno').text();
            $("#barcode").JsBarcode(
                value, {
                    "background":"white", //Transparent bg-> undefined, no quotes
                    "lineColor":"black",
                    "fontSize": 20,
                    "height": 50,
                    "width": 1.5,
                    "margin":2,
                    "textMargin":0,
                    //"displayValue":value,
                    "font":"monospace",
                    "fontOptions":"",
                    "textAlign":"center",
                    "price":"",
                    //"description":value,
                    "valid": function(valid){
                        if(valid){
                            $("#barcode").show();
                            $('#barcodenumber').html(value);
                        } else{
                            $("#barcode").hide();
                        }
                    }
                }
            );
        };
     $(document).ready(function(){
        /*Void*/
        $("#red_void").click(function(){
            var message="Confirm voiding receipt?";
            var response=confirmInput(message,"confirm",function(confirm){
				if(!confirm){
					return false;
				}
            url="{{url('opossum/transaction/receiptvoid')}}"
            type="POST";
            data={
                receipt_id:"{{$receiptInfo->id}}"
            }
            success=function(r){
                var response=confirmInput(r,"popup",function(confirm){ 
                    
document.querySelector("#red_void").style.display="none";
$(".void-stamp").slideDown("fast");
                });
            }
            error=(error)=>{
                alert("Failed to connect to server error");
            }
            $.ajax({
                url,
                data,
                type,
                success,
                error
            })

            });  
        });


        $('#qr').html('');
        $('#qr').qrcode({height:70,width:70,text:"{{$receiptInfo->receipt_no}}"});
            newBarcode({{$receiptInfo->receipt_no or 123}});
        $(document.body).on('click','.lockerkey',function(){
            lockerkey=$(this).text();
            var url=JS_BASE_URL+"/opossum/lokerkeydat";
            var v_activekey = $("#v_activekey").val();
            if(lockerkey != ''){ 
                $.ajax({
                    type: "POST",
                    url: "{{URL('/lokerkeydata')}}",
                    data:{lockerkey:lockerkey,v_activekey:v_activekey},
                    success: function(data) {
                        $('#opslokerdatatitle').html('Key No '+lockerkey);
                        $('#opslokerdatabody').html(data);
                        $('#opsLokerKeyDataModal').modal('show');
                    }
                });
            }
        });
     })
 </script>
