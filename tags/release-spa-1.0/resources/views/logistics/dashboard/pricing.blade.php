<style type="text/css">

    #pTable{
        font-size: 1.1em;
    }
    table.table>thead >tr>th {
        background-color: black;
        color:white;

    }
    table.table>thead >tr>select.eachInput{
        /*line-height: 1.5em;*/
        height: 1.5em;
    } 
    .no{
        width: 20px;
    }
    .eachInput{
        width: 100px;
    }
    .delInput{
        width: 50px;
    }	
	.fa-2x {
    font-size: 1.5em !important;
	}
</style>

<div id="pricing-table" class="tab-pane fade in">
	<div class="row">

		<div class="col-sm-8">      <h2 style="float: left; margin-top: 0 !important;">Pricing Table</h2> &nbsp;&nbsp; 
			@if(Auth::check())
				@if(Auth::user()->hasRole('adm'))
					@if(count($slabs) > 0)
						@if($slabs[0]->locked == 1)
						   <a href="javascript:void(0)" style="display:none" class="btn btn-danger" id="lockPrincing">
						   &nbsp;&nbsp;Lock&nbsp;&nbsp;</a> 
						   <a href="javascript:void(0)" class="btn btn-danger" id="unlockPrincing">
						   &nbsp;Unlock&nbsp;</a> 
						@else
							<a href="javascript:void(0)" class="btn btn-danger" id="lockPrincing">
						   &nbsp;&nbsp;Lock&nbsp;&nbsp;</a> 
						   <a href="javascript:void(0)" style="display:none" class="btn btn-danger" id="unlockPrincing">
						   &nbsp;Unlock&nbsp;</a> 

						@endif
					@else
					   <a href="javascript:void(0)" class="btn btn-danger" id="lockPrincing">
					   &nbsp;&nbsp;Lock&nbsp;&nbsp;</a> 
					   <a href="javascript:void(0)" style="display:none" class="btn btn-danger" id="unlockPrincing">
					   &nbsp;Unlock&nbsp;</a> 						
					@endif
				@endif
			@endif
		&nbsp;&nbsp;</div>

		<div class="col-sm-1"><strong style="vertical-align: middle;" class="pull-right">Volfactor</strong></div>
		<div class="col-sm-1"><input type="text" name="volfactor" style="width: 100px;" class="volfactor" id="volfactor" value="{{$volfactor or 0}}"></div>
		<div class="col-sm-2">
<a href="javascript:void(0)" class="btn btn-primary btn-primary pull-right" id="addMore">
                  <span class="glyphicon glyphicon-plus "></span>
                   Add More</a>
                   </div>

    </div>  {{--Row Ends--}}
      <table class="table bordered" id="pTable" width="100%">
          <thead>
              <tr>
                  <th width="15px;" class="text-center">No</th>
                  <th class="text-center">Weight&nbsp;(g)</th>
                  <th class="text-center">Length&nbsp;(cm)</th>
                  <th class="text-center">Width&nbsp;(cm)</th>
                  <th class="text-center">Height&nbsp;(cm)</th>
                  <th class="text-center">Base&nbsp;Price ({{$currentCurrency}})</th>
                  <th class="text-center">Interval&nbsp;Pricing ({{$currentCurrency}})</th>
                  <th class="text-center">Interval&nbsp;Unit&nbsp;(g)</th>
                  <th class="text-center">Location</th>
                  <th class="text-center"></th>
              </tr>
          </thead>
          <tbody class="content">
			<?php $counter = 1; ?>
			<?php $isdisabled = 0; ?>
			<?php $locked = 0; ?>
			
			@if(count($slabs) > 0)
			  @foreach($slabs as $slab)
			  <?php
				$disabled = "";
				if($slab->locked == 1 && !Auth::user()->hasRole('adm')){
					$disabled = "disabled";
					$isdisabled = 1;
					$locked = 1;
				}
			  ?>
			  <tr class="Input input{{$counter}}">
					<td class="no text-center">{{$counter}}</td>
					 <td class="eachInput" style="display:none;"> <input type="hidden" name="ids" value="{{$slab->id}}" /> </td>
					<td class="eachInput">
					  <input type="number" name="weight" {{$disabled}} value="{{$slab->weight}}" class="form-control weight text-center" min="10">
					</td>
					<td class="eachInput">
					  <input type="text" name="length"  {{$disabled}} value="{{$slab->length}}" class="form-control length text-center" min="10">
					</td>
					<td class="eachInput">
					  <input type="text" name="width"  {{$disabled}} value="{{$slab->width}}" class="form-control width text-center" min="10">
					</td>
					<td class="eachInput">
					  <input type="text" name="height"  {{$disabled}} value="{{$slab->height}}" class="form-control height text-center" min="10">
					</td>
					<td class="eachInput">
					  <input type="text" name="price"  {{$disabled}} value="{{number_format($slab->base_price/100,2,'.','')}}" class="form-control price text-right" required="required">
					</td>
					<td class="eachInput">
					  <input type="text" name="ip" {{$disabled}} value="{{number_format($slab->incremental_price/100,2,'.','')}}" class="form-control ip text-right" >
					</td>
					<td class="eachInput">
					  <input type="number" name="iu" {{$disabled}} value="{{$slab->incremental_unit}}" class="form-control iu text-center">
					</td>
					<td class="eachInput">
					  <select class="select" {{$disabled}}>Coverage Area
							<option s value="all">All</option>
						</select>
					</td>
					<td class="delInput text-center">
						<?php
							$hide_del = "";
							if($counter != count($slabs)){
								$hide_del = "display: none;";
							}
						?>
						@if($isdisabled == 0)
							<a  href="javascript:void(0);" class="text-danger removerow rem{{$counter}}" style="{{$hide_del}}"><i class="fa fa-minus-circle fa-2x"></i></a>
						@endif
					</td>				
					  
				</tr>	
				@if($counter != count($slabs))
					<?php $counter++; ?>
				@endif
			 @endforeach
			@else
			  <tr class="Input input1">
					<td class="no text-center">1</td>
					<td class="eachInput" style="display:none;"><input type="hidden" name="ids" value="0" /></td>
					<td class="eachInput">
					  <input type="number" name="weight" class="form-control weight text-center" min="10">
					</td>
					<td class="eachInput">
					  <input type="text" name="length" class="form-control length text-center" min="10">
					</td>
					<td class="eachInput">
					  <input type="text" name="width" class="form-control width text-center" min="10">
					</td>
					<td class="eachInput">
					  <input type="text" name="height" class="form-control height text-center" min="10">
					</td>
					<td class="eachInput">
					  <input type="text" name="price" class="form-control price text-right" required="required">
					</td>
					<td class="eachInput">
					  <input type="text" name="ip" class="form-control ip text-right" >
					</td>
					<td class="eachInput">
					  <input type="number" name="iu" class="form-control iu text-center">
					</td>
					<td class="eachInput">
					  <select class="select">Coverage Area
							<option s value="all">All</option>
						</select>
					</td>
					<td class="delInput">
					  
					</td>				
					  
				</tr>
            @endif
          </tbody>
			  <?php
				$isdisabledfm = 0;
				if($locked == 1 && Auth::user()->hasRole('adm')){
					$isdisabledfm = 1;
				}
			  ?>		  
		  <input type="hidden" value="{{$counter}}" id="lcounter" />
		  <input type="hidden" value="{{$isdisabled}}" id="isdisabled" />
		  <input type="hidden" value="{{$isdisabledfm}}" id="isdisabledfm" />
		  <input type="hidden" value="{{$logistic->id}}" id="lpid" />
          <tfoot>
              <tr>
                  <td colspan="8"></td>
                   
                   <td colspan="2"><a href="javascript:void(0);" style="background-color: #27a98a !important; border-color: #27a98a !important;" class="btn btn-primary btn-success pull-right" id="saveR">
                   <span class="glyphicon glyphicon-ok"></span>
                    Save</a></td>
              </tr>
          </tfoot>
      </table>                         
</div>
<script type="text/javascript">
 $('body').on('DOMNodeInserted', 'select', function () {
            $(this).select2();
        });
var counter={{$counter}};
    $(document).ready(function(){
			var isdisabled = parseInt($("#isdisabled").val());
			if(isdisabled == 1){
				$("#saveR").hide();
				$("#addMore").hide();
				$("#lockPrincing").hide();
				$("#unlockPrincing").show();
			}
			var isdisabledfm= parseInt($("#isdisabledfm").val());
			if(isdisabledfm == 1){
				$("#lockPrincing").hide();
				$("#unlockPrincing").show();
			}
				$(".price").number(true,2,'.','');
				$(".ip").number(true,2,'.','');
				$(".length").number(true,1,'.','');
				$(".width").number(true,1,'.','');
				$(".height").number(true,1,'.','');
			$(document).delegate( '.removerow', "click",function (event) {
				$(".input" + counter).remove();
				counter--;
				$(".rem" + counter).show();
			});		
			
			$('#lockPrincing').click(function(){
				var lpid = $("#lpid").val();
				$('#lockPrincing').html("Locking...");
				console.log(lpid);
				$.ajax({
					url:"{{url("lp/pricing/lock")}}",
					type:"POST",
					data:{"lpid":lpid},
					success:function(r){
						toastr.info("Pricing table succesfully locked");
						//$(".eachInput :input").attr("disabled", true);
						$('#lockPrincing').html("Lock");
					/*	$("#saveR").hide();
						$("#addMore").hide();
						
						$(".removerow").hide();*/
						$("#lockPrincing").hide();
						$("#unlockPrincing").show();
					},
					error:function(){
						toastr.warning("Server error.Contact OpenSupport.");
					}
				});				
			});	
			
			$('#unlockPrincing').click(function(){
				var lpid = $("#lpid").val();
				var counter = $("#lcounter").val();
				$('#unlockPrincing').html("Unlocking...");
				$.ajax({
					url:"{{url("lp/pricing/unlock")}}",
					type:"POST",
					data:{"lpid":lpid},
					success:function(r){
						toastr.info("Pricing table succesfully unlocked");
						$(".eachInput :input").attr("disabled", false);
						$('#unlockPrincing').html("Unlock");
						$("#saveR").show();
						$("#addMore").show();
						$("#lockPrincing").show();
						$("#rem" + counter).show();
						$("#unlockPrincing").hide();
					},
					error:function(){
						toastr.warning("Server error.Contact OpenSupport.");
					}
				});				
			});			
			
          $('#addMore').click(function(){
          //   alert("lol");
			$('.rem' + counter).hide();
            counter++;
            var content=' <tr class="Input input'+counter+'">\
                <td class="no text-center">'+counter+'</td>\
				<td class="eachInput" style="display:none;"><input type="hidden" name="ids" value="0" /></td>\
                <td class="eachInput">\
                  <input type="number" name="weight" class="form-control weight text-center" min="10">\
                </td>\
                <td class="eachInput">\
                  <input type="text" name="length" class="form-control length text-center" min="10"></td>\
                <td class="eachInput">\
                  <input type="text" name="width" class="form-control width text-center" min="10">\
                </td>\
                <td class="eachInput">\
                  <input type="text" name="height" class="form-control height text-center" min="10">\
                </td>\
				<td class="eachInput">\
                  <input type="text" name="price" class="form-control price text-right" required="required">\
                </td>\
                <td class="eachInput">\
                  <input type="text" name="ip" class="form-control ip text-right" >\
                </td>\
                <td class="eachInput">\
                  <input type="number" name="iu" class="form-control iu text-center">\
                </td>\
                <td class="eachInput">\
                  <select class="select">Coverage Area\
                        <option s value="all">All</option>\
                    </select>\
                </td>\
				<td class="delInput text-center">\
				<a  href="javascript:void(0);" class="text-danger removerow rem'+counter+'" ><i class="fa fa-minus-circle fa-2x"></i></a>\
				</td>\</tr>';
            $('.content').append(content);
			$('.select').select2();
			$(".price").number(true,2,'.','');
			$(".ip").number(true,2,'.','');
			$(".length").number(true,1,'.','');
			$(".width").number(true,1,'.','');
			$(".height").number(true,1,'.','');
        });
        $('#saveR').click(function(){
            //alert("lol");

            data=[];

            $('.Input').each(function (i,elem) {
                var temp={};
                
                $(elem).find('.eachInput').each(function(j,obj){
                    var v=$(obj).find('input').val();
                    var n=$(obj).find('input').attr('name');
                    if (v=='undefined') {
                        v=99999999999999999999;
                    }
                    temp[n]=v;
                });
                data.push(temp);
            });
			// console.log(data);
			var lpid = $("#lpid").val();
            $.ajax({
                url:"{{url("lp/pricing/check")}}",
                type:"GET",
                data:{"lpid": lpid},
                success:function(r){
                    if (r.status=="success") {
                      $.ajax({
							url:"{{url("lp/pricing/add")}}",
							type:"POST",
							data:{"data":data, "lpid": lpid,'volfactor':$('#volfactor').val()},
							success:function(r){
								if (r.status=="success") {
									toastr.info(r.long_message);
								}
								if (r.status=="failure") {
									toastr.warning(r.long_message);
								}
							},
							error:function(){
								toastr.warning("Server error.Contact OpenSupport.");
							}
						});
                    }
                    if (r.status=="failure") {
                        toastr.warning(r.long_message);
                    }
                },
                error:function(){
                    toastr.warning("Server error.Contact OpenSupport.");
                }
            });
			
        });
    });
</script>
