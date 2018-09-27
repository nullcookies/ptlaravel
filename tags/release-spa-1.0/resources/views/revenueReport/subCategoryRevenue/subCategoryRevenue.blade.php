

    <div class="container" style="margin-top:10px; height:auto;padding-left:0">
    
    
    <div class="row col-md-12" style="padding-left:0;margin-left:15px;">
    <div class="col-md-2" style="padding-left:0">
    <label>Year</label>
    <select name="year" class="form-control col-md-2">
        <option>2016</option>
        <option>2015</option>
        <option>2014</option>
    </select>
    </div>
    <div class="col-md-2" style="padding-left:0;">
    <label>Month</label>
    <select name="month" id="month" class="form-control col-md-6">
        <option value="01">January</option>
        <option value="02">February</option>
        <option value="07">March</option>
    </select>
    </div>
    <div class="col-md-3">
    <label>Categories</label>
    <select name="month" id="categoryd" class="form-control col-md-6" >
    @foreach($categories as $val)
        <option value="{{ $val->id}}"> {{ ucfirst($val->description) }}</option>
@endforeach
    </select>
    </div>
    </div>

<script>    
        $(document).ready(function(){

            $('#categoryd').on('change', function(e){
                var categoryId = e.target.value;
                var year=  $('select[name=year]').val();
                var month=  $('select[name=month]').val();
                console.log(month);

                $('#loadSubCategoryRevenueBody').load('{{URL::to("loadSubCategoryRevenue")}}'+'/'+ year+'/'+ month +'/'+ categoryId);
        
            });

        });

</script>

<div id="loadSubCategoryRevenueBody">
		
   </div>

</div>

