<?php
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\IdController;
use App\Classes;
 $cStatus=["completed","reviewed","commented"];
define('MAX_COLUMN_TEXTvw', 20);
?>

<div class=" " > <!-- col-sm-12 -->
<h2>Album Products</h2>
<br>
	<div id="thetable2">
		<table class="table table-bordered" id="notproduct_details_table" >
			<thead class="aproducts">

			<tr style="background-color: #F29FD7; color: #FFF;">
				<th class="text-center no-sort" width="20px" style="width: 20px !important;">No</th>
				<th class="text-center" >Product&nbsp;ID</th>
				<th class="text-center">Name</th>
				<th class="text-center ">&nbsp;<input type="checkbox" class="allnotproducts" />&nbsp;</th>
			</tr>
			</thead>
			<tbody>
			
			@if(isset($notproducts))
				@foreach($notproducts as $p)
					<tr>
						 <td style="text-align: center;">{{$i}}</td>
						 <td style="text-align: center;">{{IdController::nP($p->id)}}</td>
						 <td style="text-align: left;"><img src="{{URL::to('/')}}/images/product/{{$p->parent_id}}/{{$p->real_photo_1}}" width="30" height="30" style="padding-top:0;margin-top:4px">{{$p->name}}</td>
						 <td style="text-align: center;"><input type="checkbox" class="notproducts" rel="{{$p->id}}" /></td>
					</tr>
					<?php $i++; ?>
				@endforeach
			@endif
			</tbody>

		</table>
	</div>
	<br>
	<button class="btn-sub add-btn pull-right" style="height: 40px !important; background-color: #F29FD7 !important; color: #FFF;">
		Add Products
	</button>
	<input type="hidden" id="thesell" value="{{$selluser->id}}" />
</div>