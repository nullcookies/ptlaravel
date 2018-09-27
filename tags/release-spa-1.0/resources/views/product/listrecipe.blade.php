<!-- <form id="form1"> -->
    <a href="#" style="background-color: #02d4f9;color:white;padding-top:27px" class=" sellerbuttons pull-right" onclick="saverawmaterial();">Save</a>
    <a href="#" data-toggle="modal" style="background-color: #ea6c06;color:white;padding-top:27px" data-target="" class="sellerbuttons pull-right" onclick="showrecipematerial()">
    + Material</a>
    <a href="#" data-toggle="modal" style="background-color: #ea6c06;color:white;padding-top:27px" data-target="" class="sellerbuttons pull-right" onclick="recipeq1()">Q1</a>
    <form id="rawmaterialform">
        <input type="hidden" name="item_product_id" value="{{$product_id}}">
    <div class='raw-datatable_td'>
    <table id="raw-datatable" class="table table-bordered" style="width:100%">
        <thead>
            <tr>
                <td class="text-center bg-primaryorange">No</td>
                <td class="text-center bg-primaryorange">Raw&nbsp;Material&nbsp;ID</td>
                <td class="text-center bg-primaryorange">Raw Material</td>
                <td class="text-center bg-primaryorange">Measurement</td>
                <td class="text-center bg-primaryorange">Unit</td>
            </tr>
        </thead>
        <tbody id="new-material">    
        </tbody>
    </table>
    </div>
    </form>

<script>
    $(document).ready(function() {
        $('#raw-datatable').DataTable();
    });
</script>
