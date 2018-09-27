<h2>Debit Note</h2>

    <form method="post" action="{{route('returnquantity')}}">

<table class="table table-bordered" id="table-idstatus" >
    <thead class="aproducts">

    <tr style="background-color: #F29FD7; color: #FFF;">
        <th class="text-center">No.</th>
        <th class="text-center" >Product&nbsp;ID</th>
        <th style="text-align: left;">Name</th>
        <th class="text-center">Quantity</th>
        <th class="text-center">Price</th>
        <th class="text-center">Select</th>

        
    </tr>
    </thead>
   <?php  $count = 1; ?>
    <tbody>

      @if(isset($data))
        @foreach($data as $key => $value)
        <?php
                foreach ($value as $k => $ordertproduct) {
                $maxquantity = 0;

                    foreach ($ordertproduct as $index => $pro) {
                       $maxquantity = $maxquantity + $pro->qty;
                    }
                    
                    
                    $price = $k; 
                    $index++;
                    $p_price = number_format($price/100,2);

                
         
         ?>
    <tr>
        <td style="text-align: center;">{{$count}}</td>
        <td style="text-align: center;">

           {{--  <a href="{{url("productconsumer/$ordertproduct[0]->tproduct_id")}}">{{$ordertproduct[0]->ntproduct_id}}</a> --}}
            {{$ordertproduct[0]->ntproduct_id}}
        </td>
        <td style="text-align: left;">{{$ordertproduct[0]->name}}</td>

        <td style="width: 15%;">


            <div class="input-group">
            <span class="input-group-btn">
                <button onclick="plus({{$ordertproduct[0]->ordertproductid}},{{$maxquantity}})" type="button" class="quantity-right-plus btn btn-primary btn-number" data-type="plus" data-field="">
                    <span class="glyphicon glyphicon-plus"></span>
                </button>
            </span>
                     <input type="number" value="1" id="i{{$ordertproduct[0]->ordertproductid}}" name="productqty[{{$ordertproduct[0]->ordertproductid}}]" class="form-control text-center quantity-control input-number" min="1" >
            
            <span class="input-group-btn">
                <button onclick="minus({{$ordertproduct[0]->ordertproductid}})" type="button" class="quantity-left-minus btn btn-primary btn-number"  data-type="minus" data-field="">
                  <span class="glyphicon glyphicon-minus"></span>
                </button>
            </span>
        </div>
        </td>
        
        <td style="text-align: right; border-left:none;"><div style="width: 40%;  float: left; text-align: right;">{{$currency->code}}</div>{{$p_price}}</td>
     
        <td style="text-align: center;"><input style="width: 20px; height: 20px;" type="checkbox" name="product[{{$ordertproduct[0]->ordertproductid}}]"></td>
        
    </tr>
    <?php  $count++; 
   
}?>

    @endforeach
      @endif
    </tbody>

</table>
<button type="Submit"  class="btn-sub add-btn pull-right" style="height: 40px !important; background-color: #F29FD7 !important; color: #FFF;">
    Submit
</button>
</form>
<br>

    <style>
        .naddTproduct:hover {
            background-color: #CCC !important;
            border-color: #CCC !important;
        }
        .center{
        width: 150px;
          margin: 40px auto;
          
        }
        .btn-qty{
            float: right;
            margin-top: -33px;
        }
        .text-center{
            text-align: center;
        }
        .naddTproduct {
            background-color: #CCC !important;
            border-color: #CCC !important;
        }
    </style>
    <script type="text/javascript">
     var quantitiy=0;
   function plus(index,max) {
    
        // Stop acting like a button
        
        // Get the field name
        var quantity = $('#i'+index).val();
       
        if(quantity<max){
            
            $('#i'+index).attr("value", ++quantity);
            
          }
            // Increment
        
    }

     function minus(index) {
        // Stop acting like a button
       
        // Get the field name
        var quantity = $('#i'+index).val();
        
        // If is not undefined
      
            // Increment
            if(quantity>1){

            $('#i'+index).attr("value", --quantity);
               
            }
    }


    $('#table-idstatus').DataTable({
                "order": [],
                
            }); 
    /*function returnrequest() {
        var formData = new FormData(document.querySelector('form'))
        
        var formdata = $('form').serializeArray();
        alert(formdata);
        $.ajax({
                type: "POST",
                url:'returnquantity',
                data: {JSON.stringify(formdata)},
                success: function (responseData) {
                    alert(responseData);
                }
            }); 
    }*/

     
    </script>
