
    <div class="container" style="margin-top:10px; height:auto;padding-left:0">
    
    <div class="row col-md-12" style="padding-left:0;margin-left:15px">
    <div class="col-md-2" style="padding-left:0">
    <label>Year</label>
    <select name="year" class="form-control col-md-2">
        <option>2016</option>
        <option>2015</option>
        <option>2014</option>
    </select>
    </div>
    <div class="col-md-2" style="padding-left:0">
    <label>Month</label>
    <select name="month" id="month" class="form-control col-md-6">
        <option value="01">January</option>
        <option value="02">February</option>
        <option value="03">March</option>
    </select>
    </div>
    </div>

<script>    
        $(document).ready(function(){

            $('#month').on('change', function(e){
                var month = e.target.value;
                var year=  $('select[name=year]').val();
                console.log(month);

                $('#loadCategoryRevenueBody').load('{{URL::to("loadCategoryRevenue")}}'+'/'+ year+'/'+ month);
        
            });

        });

</script>

<div id="loadCategoryRevenueBody">
		
   </div>

</div>

