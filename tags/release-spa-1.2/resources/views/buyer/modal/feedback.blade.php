
<link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.min.css')}}">
<style type="text/css">
table.fixed { table-layout:fixed; }
table.fixed td { overflow: hidden; }
</style>
<?php  $i=0;
?>
<input type="hidden" id="foid" value="{{$oid}}">
<table class="table" width="100%">
@foreach ($products as $product) 
   
    {{-- <col width="40px" /> --}}
    <tr>
        <td >
            <?php 
            $img="images/product/".$product->id."/".$product->image;
            ?>
            <img src="{{asset($img)}}" height="108;" width="150">
        </td>
        <td>
            {{$product->name}}<br><textarea rel-id="{{$product->id}}"  class="form-control preview" placeholder="Review the product"></textarea>
        </td>
    </tr>
@endforeach
    <tr>
        <td><a type="a" class="btn btn-default pull-left" data-dismiss="modal" style="margin-left: -10px;">Close</a></td>
        <td ><a href="#" class=" noomp review btn btn-approval pull-right"><span class="glyphicon glyphicon-check"></span> Submit</a></td>
    </tr>
</table>

<script type="text/javascript">
    $(document).ready(function () {
        // body...
     
        $('.review').click(function(){
            var data=[];
            $('textarea').each(function(i,elem){
          
                var temp={};
                var val=$(elem).val();
                console.log($(elem).attr('rel-id'));
                if (val == "" || val=="undefined" ) {}
                else{
                    temp[$(elem).attr('rel-id')]=val;
                    console.log(temp);
                    data.push(temp);
                }
            });
            if (data.length <1) {toastr.warning("Please write review for atleast 1 product");}
            else{
                url="{{url('buyer/feedback/register')}}";
                var oid= $('#foid').val();
                $.ajax({
                    url:url,
                    type:'POST',
                    data:{'kv':data,'oid':oid},
                    success:function(r){
                        if (r.status=="success") {
                            // alert(r.long_message);
                            toastr.success("Your review was successful.");
                            $('.noomp').remove();
                            location.reload();
                        }
                        if (r.status=="failure") {
                            toastr.warning(r.long_message);
                        }
                    },
                    error:function(){
                        toastr.warning("Please try again later");
                    }
                });
            }


        });
    });
</script>