@extends("common.default")
@section('content')
@include("common.sellermenu")
<script type="text/javascript">
    var resultcomplete="";
    var aux = 1;
    var total =0;
    var oTable=null;
    var aux2=0;
    var array;

    function Add(res) {

                    var autoincrement = $("#autoincrement").val();
                  /*var html = "<tr>"
                      html +=   "<td align = center>"+aux+"</td>";
                      html +=   "<td align = center>"+res[0].id+"</td>";
                      html +=   "<td>"+res[0].name+"</td>";
                      html +=   "<td>"+res[0].order_qty+"</td>";
                      html +=   "<td>"+res[0].special_price+"</td>";
                      html +=   "<td id='price-"+autoincrement+"'>"+res[0].price+"</td>";
                      html +=   "<td><a rel='"+autoincrement+"'style='color:red;' id='eliminar' class='del glyphicon glyphicon-remove'></td>";
                      html +=   "</tr>";*/
                      //console.log(total);

                      var x = "<a rel='"+autoincrement+"'style='color:red;' id='eliminar' class='del glyphicon glyphicon-remove'>";
                         oTable.row.add([aux,
                            res[0].id,
                            res[0].name,
                            res[0].order_qty,
                            res[0].special_price,
                            res[0].price,
                            x
                            ]).draw(true);


                        aux++;
                        autoincrement = parseInt(autoincrement)+1;
                        $("#autoincrement").val(autoincrement);
                        total=total + res[0].price;

                        var html2 =   "<span class='pull-right'>Total:&nbsp;&nbsp;&nbsp;<span class='h2'>{{$currentCurrency}} <span class='totalRs'>"+total.toFixed(2)+"</span></span></span><br><br>";

                        var column = oTable.column( 0 );

                        $( column.footer()).html(html2);
                        //console.log(html);
/*                        oTable.destroy();
                        $("#bodytable").append(html);

                        oTable = $('#tableicon').DataTable({
                            "order": [],
                            "scrollx": true,
                            "columndefs": [
                                {"targets": "no-sort", "orderable": false},
                                {"targets": "medium", "width": "80px"},
                                {"targets": "large",  "width": "120px"},
                                {"targets": "approv", "width": "180px"},
                                {"targets": "blarge", "width": "200px"},
                                {"targets": "clarge", "width": "250px"},
                                {"targets": "xlarge", "width": "300px"},
                            ],
                            "fixedcolumns": { "leftcolumns": 2 }
                        });*/

                      //$('#footable').show();


            }
</script>

<section class="orderViewIcon">
    <div class="container"><!--Begin main cotainer-->
        <div class="row">
			{!! Breadcrumbs::renderIfExists() !!}
            <h2 class="heading">Order View Icon</h2>
        </div>
        <input type="hidden" value="0" id="autoincrement" />
        <div class="row">
            {{--Add selected product from below listing--}}
            <div class="col-sm-12 col-md-5 orderSelectDiv">
                <div hidden id="photo" class="col-sm-12 col-md-6">
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="col-sm-12 col-md-5 no-margin no-padding">
                    <span hidden id="idt"><b>Id:</b></span>
                    </div>
                    <div class="col-sm-12 col-md-7 no-margin no-padding">
                    <span hidden id="idn"> </span>
                    </div><br></br>
                    <div class="col-sm-12 col-md-5 no-margin no-padding">
                    <span hidden id="namet"><b>Name:</b></span>
                    </div>
                    <div class="col-sm-12 col-md-7 no-margin no-padding">
                    <span hidden id="name"></span>
                    </div><br></br>
                    <div class="col-sm-12 col-md-5 no-margin no-padding">
                    <span hidden id="pricet"><b>Whole price:</b></span>
                    </div>
                    <div class="col-sm-12 col-md-7  no-margin no-padding">
                    <span hidden id="price"></span>
                    </div><br></br>
                    <div class="col-sm-12 col-md-5 no-margin no-padding">
                    <span hidden id="spricet"><b>Special price:</b></span>
                    </div>
                    <div class="col-sm-12 col-md-7 no-margin no-padding">
                    <span hidden id="sprice"></span>
                    </div><br></br>
                    <div class="col-sm-12 col-md-5 no-margin no-padding">
                    <span hidden id="quant"><b>Quantity:</b></span>
                    </div>
                    <div class="col-sm-12 col-md-7 no-margin no-padding">
                    <span hidden id="quan"></span>
                    </div><br></br>
                </div>
                <div hidden class="pull-right" id="confirm">
                                    <input type="button" id="enviar" onclick="Add(resultcomplete);" class="btn btn-green btn-lg add_result" value="Select">
                </div>
            </div>
            <div class="col-sm-12 col-md-7 confirmOrder table-reponsive" style="padding-bottom:5.4%;">
                {!! Form::open(array('url'=>'/cart/muladdtocart','id'=>'confirmOrderForm')) !!}
                {{--Item List--}}
                <table id="tableicon" class="table table-condensed" width="100%">
                    <thead>
                        <tr>
                            <th class="no-sort">
                                No
                            </th>
                            <th>
                                Product ID
                            </th>
                            <th>
                                Item
                            </th>
                            <th>
                                Qty
                            </th>
                            <th>
                                Unit
                            </th>
                            <th>
                                Price
                            </th>
                            <th class="no-sort"></th>
                        </tr>
                    </thead>
                    <tbody id="bodytable">

                    </tbody>
                    <tfoot width="100%">
                        <tr>
                            <td colspan="6">
                                <span class="pull-right">Total:&nbsp;&nbsp;&nbsp;<span class="h2">{{$currentCurrency}} <span id="total" class="totalRs">0.00</span></span></span><br><br>
                            </td>
                        </tr>
                        <tr>

                            <td colspan="6">
                                <button class="btn btn-primary pull-right" type="submit">Confirm</button>
                            </td>

                        </tr>
                    </tfoot>
                </table>

                {!! Form::close() !!}
            </div>
        </div>
        <div class="row marginTop25">
            @if(count($categories))
            <div class="panel with-nav-tabs panel-default font18">
                <div class="panel-heading">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        @foreach($categories as $key => $category)
                        <li role="presentation"  class="<?php echo (empty($key) ? 'active' : '') ?>">
                            <a href="#cat<?php echo $key; ?>" aria-controls="home" role="tab" data-toggle="tab">
                                <?php echo ucfirst($category->name); ?>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Tab panes -->
                <div class="tab-content">
                    @foreach($categories as $key => $category)
                    <div role="tabpanel" class="tab-pane <?php echo (empty($key) ? 'active' : '') ?>" id="cat<?php echo $key; ?>">
                        <div class="row" style="margin:15px">
                            @foreach($category->subCatLevel1 as $key1 => $subcategory)
                            <div class="mainDiv col-md-12">
                                <div class="col-md-12 innerDiv">
                                    <?php echo ucfirst($subcategory->description); ?>
                                    <br style="margin-bottom:10px">
                                    <div class="col-md-12">
                                        <div class="row">
                                            @if(!count($subcategory->product))
                                            <div class="col-md-12 noAnyProduct">
                                                0 products found
                                            </div>
                                            @else
                                            @foreach($subcategory->product as $key2 => $productDetail)
                                            <div class="col-md-2 productDetailDiv" id='productDiv_<?php echo $productDetail->id ?>'>
                                                <a href="javascript:void(0)" class="thumbnail productLink" rel='<?php echo $productDetail->id ?>'>
                                                    <img class="img-responsive"
                                                         src="{{asset('/images/product/'.$productDetail->id.'/'.$productDetail->photo_1)}}"
                                                         alt="<?php echo $productDetail->name ?>" width="171px" height="180px">

                                                </a>
                                            </div>
                                            @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @foreach($category->subCatLevel2 as $key1 => $subcategory)
                            <div class="mainDiv col-md-12">
                                <div class="col-md-12 innerDiv">
                                    <?php echo ucfirst($subcategory->name); ?>
                                    <hr>
                                    <div class="col-md-12">
                                        <div class="row">
                                            @if(!count($subcategory->product))
                                            <div class="col-md-12 noAnyProduct">
                                                0 products found
                                            </div>
                                            @else
                                            @foreach($subcategory->product as $key2 => $productDetail)
                                            <div class="col-md-2" id='productDiv_<?php echo $productDetail->id ?>'>
                                                <a href="javascript:void(0)" class="thumbnail productLink" rel='<?php echo $productDetail->id ?>'>
                                                    <img class="img-responsive"
                                                         src="{{asset('/images/product/'.$productDetail->id.'/'.$productDetail->photo_1)}}"
                                                         alt="<?php echo $productDetail->name ?>" width="171px" height="180px">
                                                </a>
                                            </div>
                                            @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @else
            <div> 0 products found </div>
            @endif

        </div>
        <div class="row">
        <div class="col-sm-12 no-padding">
            <h3 class="heading">Recommended Items</h3>
        </div>
    </div>

    <div class="row table-bordered" style="padding-top:15px; ">
        @foreach($recommandedItems as $itemDetail)
        <div class="col-sm-2">
            <a href="{{ route('productconsumer', $itemDetail->id) }}" class="thumbnail productLink">
                <img class="img-responsive"
                     src="{{asset('/images/product/'.$itemDetail->id.'/'.$itemDetail->photo_1)}}"
                     alt="<?php echo $itemDetail->name ?>">
            </a>
        </div>
        @endforeach
    </div>
    </div>


</div>


<div class="row">
    {{--@foreach($category->subCatLevel1->product as $product)--}}
    <div class="col-sm-2">
        {{--<img class="img-responsive" src="{{asset('/images/500x500_A90-5-MFE-CRT.jpg')}}"--}}
        {{--alt="">--}}
        {{--{{$product->name}}--}}
    </div>
    {{--@endforeach--}}
</div>


</div>
</section>


<script type="text/javascript">
$(document).ready(function () {


    oTable = $('#tableicon').DataTable({
        "order": [],
        "scrollX": true,
        "columnDefs": [
            {"targets": "no-sort", "orderable": false},
            {"targets": "medium", "width": "80px"},
            {"targets": "large",  "width": "120px"},
            {"targets": "approv", "width": "180px"},
            {"targets": "blarge", "width": "200px"},
            {"targets": "clarge", "width": "250px"},
            {"targets": "xlarge", "width": "300px"},
        ],
        "fixedColumns": { "leftColumns": 2 },
    });


    $(document).delegate( '.del', "click",function (event) {
        var target_row = $(this).closest("tr").get(0); // this line did the trick

        $(target_row).find('td').each(function(index,val){
            if(index === 5) value= ($(val).html());
        });

            oTable.row(target_row).remove().draw();



        total = parseFloat(total) - parseFloat(value);


        var html2 =   "<span class='pull-right'>Total:&nbsp;&nbsp;&nbsp;<span class='h2'>{{$currentCurrency}} <span class='totalRs'>"+total.toFixed(2)+"</span></span></span><br><br>";
        var oTable2 = $('#tableicon').DataTable();
        var column = oTable2.column( 0 );

        $(column.footer()).html(html2);



        //var aPos = oTable.fnGetPosition(target_row);

        //oTable.fnDeleteRow(aPos);
    });

    $('.productLink').on('click', function () {

    var productId = $(this).attr('rel');
    //alert(productId);
    //$('#myModal').modal('show');

    resultcomplete="";


    var url = '/station/getProductIcon/'+productId;

        var oTable3 = $('#tableicon').DataTable();


        $.ajax({
            Type: 'GET',
            url: url,
            cache: false,
            async:false,
            dataType: 'json',
            beforeSend: function () {
            },
            success: function (result) {
               // console.log(result);

                var html="<img class='img-responsive thumbnail' src='"+JS_BASE_URL+"/images/product/"+result[0].id+"/"+result[0].photo_1+"' alt='"+result[0].photo_1+"'>";
                $('#photo').html(html);
                $('#photo').show();
                $('#idn').html(result[0].id);
                $('#idn').show();
                $('#idt').show();
                $('#name').html(result[0].name);
                $('#name').show();
                $('#namet').show();
                $('#price').html(result[0].price);
                $('#price').show();
                $('#pricet').show();
                $('#sprice').html(result[0].special_price);
                $('#sprice').show();
                $('#spricet').show();
                $('#quan').html(result[0].order_qty);
                $('#quan').show();
                $('#quant').show();
                $('#confirm').show();

                resultcomplete=result;

            }
        });
    });
});
</script>


@stop


