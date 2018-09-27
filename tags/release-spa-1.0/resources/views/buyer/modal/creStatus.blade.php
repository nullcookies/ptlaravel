<?php 
$i=1;
use App\Http\Controllers\IdController;

?>
<table class="table" width="100%" style="table-layout: fixed;">
    <thead>
        <tr style="background-color: black;color: white;">
            <th style="width:50px;" class="text-center">No.</th>
            <th class="text-center" style="width:150px;">Product&nbsp;ID</th>
            <th class="text-center" style="width:350px;">Product&nbsp;Name</th>
            <th class="text-center">CRE&nbsp;Reason</th>
            <th class="text-center" style="width:70px;">Approve</th>
            <th class="text-center" style="width:70px;">Reject</th>
        </tr>
    </thead>
    <tbody>
        <input type="hidden" name="oidcre" id="oidcre" value="{{$oid}}">
        @foreach($cre as $c)
            <tr>
                <td>{{$i}}</td>
                <td class="text-left">{{IdController::nP($c->pid)}}</td>
                <td class="text-center"><a title="{{$c->product_name}}" class="truncate">{{$c->product_name}}
                </a></td>
                <td class="text-center">{{$c->reason}}</td>
                @if($c->status =="rejected")
                <td><input type="radio" class="form-control disabled" disabled="disabled" ></td>
                <td><input class="form-control disabled" type="radio" checked="checked" disabled="disabled"></td>
                @else
                 <td><input type="radio" class="form-control disabled" checked="checked" disabled="disabled" ></td>
                <td><input class="form-control disabled" type="radio" disabled="disabled"></td>
                @endif
            </tr>
            <?php $i++;?>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td><a type="a btn-warning" id="zxcv" class="btn btn-default pull-left " data-dismiss="modal">Close</a></td>
            @if($status ==1)
            <td colspan="5">
                <button  class="btn btn-info prfee pull-right" rel-oid="{{$oid}}">Pay</button>
            </td>
            @else
            <td></td>
            @endif
        </tr>
    </tfoot>
</table>


<script type="text/javascript">
$(document).ready(function(){
    $('.view-cre-gallery-modal').click(function () {
        var cre_id=$(this).attr('data-cre-id');
        var url=JS_BASE_URL+"/cre/images/"+cre_id;
        var w=window.open(url,"_blank");
        w.focus();
    });
    $('.truncate').each(function(i,elem){
        var text=$(this).text();
    
        text=text.substring(0,28)+"...";
        $(elem).text(text);
    });
    $('.prfee').click(function(){

            var oid=$(this).attr('rel-oid');
            var $this=$(this);
            $(this).prop('disabled',true);
            $.ajax({
                type:'POST',
                url:"{{url('buyer/pay/rfee')}}",
                data:{"oid":oid},
                success:function(r){
                    if (r.status=="failure") {
                        toastr.warning(r.long_message);
                        $this.prop('disabled',false);
                    }
                    if (r.status == "success") {
                        toastr.success(r.long_message);
                        $this.prop('disabled',true);
                        location.reload();
                    }
                    $('.badge').text(r.cartTotalItems);
                },
                error:function(){
                    toastr.warning("Some error happened. Please contact OpenSupport");
                    $this.prop('disabled',false);
                }
            });
        });
});
</script>