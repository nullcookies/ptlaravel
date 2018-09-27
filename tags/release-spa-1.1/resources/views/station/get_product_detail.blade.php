<script src="{{asset('/js/jquery.min.js')}}"></script>
<script src="{{asset('/js/order-view-icon.js')}}"></script>
<div class="selectedProduct no-padding">
    {!! Form::open(array('onsubmit'=>'return false','data-id'=>$productDetail->id,'id'=>'selectProductForm','action' => 'StationController@productadd')) !!}
    <div class="col-sm-3 no-padding">
        <img class="img-responsive"
             src="{{asset('/images/product/'.$productDetail->id.'/'.$productDetail->photo_1)}}"
             alt="<?php echo $productDetail->name ?>">
    </div>
    <?php $baseName = 'product[' . $productDetail->id . ']'; ?>
    <div class="col-sm-9 no-rightpadding table-reponsive">
        <table class="table table-bordered">
            <tbody>
                <tr class="titleTr">
                    <td class="title">
                        <?php echo 'Product ID' ?>
                    </td>
                    <td class="value">
                        <?php
                        $pId = str_pad($productDetail->id, 10, "0", STR_PAD_LEFT);
                        ?>
                        {!! Form::hidden($baseName . "[p_id]", $pId) !!}
                        {!! Form::hidden($baseName ."[id]", $productDetail->id) !!}
                        [{{ $pId }}]
                    </td>
                </tr>
                <tr class="nameTr">
                    <td class="title">
                        <?php echo 'Name' ?>
                    </td>
                    <td class="value">
                        {!! Form::hidden($baseName .'[name]', $productDetail->name) !!}
                        {!! Form::hidden($baseName .'[image]', $productDetail->photo_1) !!}
                        {!! Form::hidden($baseName .'[whole_price]', 1) !!}
                        {{ $productDetail->name }}
                    </td>
                </tr>
                <tr class="priceTr">
                    <td class="title">
                        <?php echo 'Retail Price' ?>
                    </td>
                    <td class="value">
                        {!! Form::hidden($baseName .'[retail_price]', 1) !!}
                        {{$currentCurrency}} <span>
                            <?php echo number_format(($productDetail->retail_price/100),2);?>
                        </span>

                    </td>
                </tr>
                <tr class="wholePriceTr">
                    <td class="title">
                        <?php echo 'Whole Price' ?>
                    </td>
                    <td class="value">
                        {!! Form::hidden($baseName .'[whole_price]', $productDetail->retail_price) !!}
                        {{$currentCurrency}} <span>
                            <?php echo number_format(($productDetail->retail_price/100),2);?>
                            
                        </span>

                    </td>
                </tr>
                <tr class="specialPriceTr">
                    <td class="title">
                        <?php echo 'Special Price' ?>
                    </td>
                    <td class="value">
                        {!! Form::hidden($baseName .'[special_price]', $productDetail->retail_price) !!}
                        {{$currentCurrency}} <span>
                            <?php echo number_format(($productDetail->retail_price/100),2);?>
                        </span>
                    </td>
                </tr>
                <tr class="qtyTr">
                    <td class="title">
                        <?php echo 'Quantity' ?>
                    </td>
                    <td class="value">
                        {!! Form::input('number',$baseName .'[qty]', 1,['onkeyup'=>'changePrice(this.value)']) !!}
                    </td>
                </tr>
            </tbody>
        </table>
        {!! Form::submit("Select",["class"=>"btn btn-primary pull-right"]) !!}
        <!--<button class="" onclick="addProductToOrder()"></button>-->
    </div>
    {!! Form::close() !!}
</div>
<script type="text/javascript">
var wholeSalePrice = <?php echo $wholeSaleJson; ?>;
var specialPrice = <?php echo $specialPriceJson; ?>;
var prodId = '<?php echo $productDetail->id; ?>';
if (jQuery('.order_' + prodId).length == 0) {
    changePrice(1);
}

function changePrice(curQty)
{
    var count = 0;
    var pQty = 0;
    var fPrice = 0;
    var lPrice = 0;
    var maximQty = 0;
    jQuery.each(specialPrice, function (maxQty, price) {
        if (count == 0) {
            pQty = maxQty;
            fPrice = price;
        } else {

            if (curQty <= maxQty && curQty > pQty) {
                fPrice = price;
            }
            pQty = maxQty;
            lPrice = price;
        }
        count++;
    });
    curQty = parseInt(curQty);
    pQty = parseInt(pQty);
    if (curQty >= pQty) {
        fPrice = lPrice;
    }
    fPrice = fPrice / 100;
    fPrice = fPrice.toFixed(2);
    jQuery('.selectedProduct .specialPriceTr td.value span').html(fPrice);


    count = 0;
    pQty = 0;
    fPrice = 0;
    lPrice = 0;
    maximQty = 0;
    jQuery.each(wholeSalePrice, function (maxQty, price) {
        if (count == 0) {
            pQty = maxQty;
            fPrice = price;
        } else {

            if (curQty <= maxQty && curQty > pQty) {
                fPrice = price;
            }
            pQty = maxQty;
            lPrice = price;
        }
        count++;
    });
    curQty = parseInt(curQty);
    pQty = parseInt(pQty);
    if (curQty >= pQty) {
        fPrice = lPrice;
    }
    fPrice = fPrice / 100;
    fPrice = fPrice.toFixed(2);
    jQuery('.selectedProduct .wholePriceTr td.value span').html(fPrice);

}
jQuery(document).ready(function () {
    jQuery('#selectProductForm').on('submit', function (e) {
        e.preventDefault();
        var pId = jQuery(this).data('id');
        var html = '<tr class="orderTr order_' + pId + '">';
        var flag = false;// true;
        if (jQuery('.order_' + pId).length != 0) {
            flag = confirm('Product already exists.If you want than overwrite?');
            html = '';
        } else {
            flag = true;
        }
        if (flag) {
            srNo = jQuery('tr.orderTr').length;
            srNo = srNo + 1;
            html += '<td class="firstTd"><span class="srnoSpan">' + (srNo);
            html += '</span><div class="hidden">';
            html += jQuery('#selectProductForm .specialPriceTr td.value').html();
            $totalQty = parseFloat(jQuery('#selectProductForm .qtyTr input').val());
            $name = jQuery('#selectProductForm .qtyTr input').attr('name');
            html += '<input type="number" class="qtyNumber" name="' + $name + '" value="' + $totalQty + '">';
            html += '</div></td>';
            html += '<td>' + jQuery('#selectProductForm .titleTr td.value').html();
            html += '</td>';
            html += '<td>' + jQuery('#selectProductForm .nameTr td.value').html();
            html += '</td>';
            html += '<td>' + parseFloat(jQuery('#selectProductForm .qtyTr input').val());
            html += '</td>';
            html += '<td>' + jQuery('#selectProductForm .priceTr td.value').html();
            html += '</td>';
            var total = parseFloat(jQuery('#selectProductForm .priceTr td.value span').html())
                    * parseFloat(jQuery('#selectProductForm .qtyTr input').val());
            total = total.toFixed(2);
            html += '<td>{{$currentCurrency}} <span class="totalPriceSpan">' + total;
            html += '</span></td>';
            html += '<td><button class="btn btn-danger" onclick="removeProduct(this)">X</button>';
            html += '</td>';
            if(jQuery('.order_' + pId).length != 0)
            {
                jQuery('.order_' + pId).html(html);
            }else{
                html += '</tr>';
                jQuery('.confirmOrder table tbody').append(html);
            }
            jQuery('#productDiv_' + pId).addClass('disabled');
            jQuery('#selectProductForm input').attr('disabled', 'disabled');
            jQuery('#selectProductForm input').attr('disabled', 'disabled');
        }
        refreshTable();
    });
});
</script>