<!DOCTYPE html>
<html>
<head>
	<title></title>

    <link rel="stylesheet" href="{{asset('/css/bootstrap.min.css')}}"/>
    <style type="text/css">
    	.close{
    		color: red;
    	}
    	tr{
    		margin-bottom: 15px;
    	}
    	    .btn-file {
        position: relative;
        overflow: hidden;
    }
    .zxcv{
        position: absolute;
        top: 0;
        right: 0;
        min-width: 100%;
        min-height: 100%;
        font-size: 100px;
        text-align: right;
        filter: alpha(opacity=0);
        opacity: 0;
        outline: none;
        background: white;
        cursor: inherit;
        display: block;
    }
    label {
  display: block;
  padding-left: 15px;
  text-indent: -15px;
}
input {
  width: 13px;
  height: 13px;
  padding: 0;
  margin:0;
  vertical-align: bottom;
  position: relative;
  top: -1px;
  *overflow: hidden;
}

    </style>
</head>
<body>
<div class="container">
<div class="row">
<div class="col-md-6">
	{{-- <h1>{{str_random(3)}}</h1> --}}
	<span id="returnmessage">{{$message or ''}} </span>
	<input type="hidden" name="order_id" value="{{$order_id}}">
	<table class="" style="border:none;" id="uparea">
	
		
		<tr ><th style="text-align: left;">Check Products to return</th>
		<th>&nbsp;</th>	
			<th style="text-align: left;">Reason for return</th>
			
		</tr>
	
	@foreach($products as $p)
	<tr>
		<td >
		<div>
		<label >
			<input type="checkbox" class="pids" name="product_id[]" value="{{$p->id}}" id="{{$p->id}}"> 
	        {{ucfirst($p->name)}}
        </label>
        </div>
        </td>
		
			
			<td></td><td>
			<select class="chose_a_reason {{'reason_'.$p->id}} select2">
				
					@foreach($cre_reasons as $c)
					<option value="{{$c->id}}">{{ucfirst($c->reason_text)}}</option>
					@endforeach
			</select>
			
		</td>
	</tr>
	@endforeach
	<tr style="margin: 10px;">
	<div class="form-group">
    &nbsp;
</div>
</tr>
<tr>
	<td><p>&nbsp;</p></td>
</tr>
	{{-- Comment Block --}}
	<tr>
		<td><strong>Please explain why you are returning the products.</strong>
	</tr>
	<tr>
		<td colspan="2"><textarea class="form-control" name="rcomment" id="rcomment"></textarea></td>
	</tr>
	{{-- Image Upload Block --}}

	<tr>
		<td>
			<p>&nbsp</p>
			<button class="btn btn-primary addmorep">Add more images</button>
			<p>&nbsp</p>
		</td>
	</tr>
	
	<input type="hidden" id="photo_counter" value="1">
	{{-- <span id="uparea"> --}}
		<tr id="tr-1">
			<td>
			<div class="input-group" >
			<span class="input-group-btn">
			<button class="btn btn-default btn-danger removep" type="button"  ref="#tr-1"><span class="glyphicon glyphicon-remove"></span>&nbsp</button>
			
			<span class="btn btn-default btn-file ">Browse<input type="file" id="photo_1" ref="fn_1" class="photo zxcv"></span>
			</span>
			</div>
			</td>
			<td><span class="filename" id="fn_1"></span></td>
		</tr>
	{{-- </span> --}}

	
	</table>
	<div id="uparea">
		
	</div>
	<table class="table">
		<tr><td><a type="a" class="btn btn-default pull-left" data-dismiss="modal" style="margin-left: -10px;">Close</a><button class="btn btn-approval pull-right" id="init_return">Confirm </button></td></tr>
	</table>


 
</div>
</div>
</div>
	
</body>
</html>









<script type="text/javascript">
	$('#init_return').click(function () {
		// alert("lol");
			// var url= JS_BASE_URL+'/return/products';
			var oid="{{$order_id}}";
			var data={};
			$('.pids').each(function(){
				if ($(this). prop("checked") == true) {
					var pid= $(this).val();
					var reason_Class=".reason_"+pid;
					data[pid]=$(reason_Class).val();

				}
			});
			
			if ($.isEmptyObject(data)==false) {
				
				data= JSON.stringify(data);
				var return_url=JS_BASE_URL+"/return/product";
				var type='POST';

				var form_data= new FormData();
				form_data.append('oid',oid);
				
				form_data.append('p_r_a',data);
				var photo_counter= $('#photo_counter').val();

				// console.log(photo_counter);
				for (var i = 0; i < photo_counter; i++) {

						x= i+1;
						// console.log($('#photo_'+x));
						var photo= $('#photo_'+x)[0].files[0];
						// console.log(photo);

						form_data.append('photo_'+x,photo);
					
				}

				
				form_data.append('photo_counter',photo_counter);
				form_data.append('comment',$('#rcomment').val());
				$.ajax({
					url:return_url,
					type:type,
					data:form_data,
					processData: false,
    				contentType: false,
    				async:false,
					success:function(r){
						if (r.status=="success") {
							$('#returnmessage').empty();
							$('#returnmessage').text(r.long_message)
							$('#uparea').remove();
							// $('#init_return').text('Close');
							// $('#init_return').addClass('close');
							location.reload();
							// $('tr').each(function(i,elem){
							// 	$(elem).remove();

							// });
						}
						if (r.status=="failure") {
								$('#returnmessage').empty();
							$('#returnmessage').text(r.long_message)
						}
					}
				});
			}
							else{
					toastr.warning("Please select a product to return");
				}

			
	})
</script>

<script type="text/javascript">
	
		$('body').on('click','.removep',function(){
			
			
			var td=$(this).attr('ref');
			var inputf=$(this);
			var pcount=parseInt($('#photo_counter').val());
			if (pcount>1) {

				$(inputf).remove();
				$(td).remove();
				pcount=pcount-1;
				// alert(pcount);
				$('#photo_counter').val(pcount);
			}
			else{
				
			}
			
		});
		$('.addmorep').click(function(){
			
			var pcount=parseInt($('#photo_counter').val())+1;
		
			var rawhtml='<tr id="tr-'+pcount+'" style="margin:5px;"><td><div class="input-group" ><span class="input-group-btn"><button class="btn btn-default btn-danger removep" type="button"  ref="#tr-'+pcount+'"><span class="glyphicon glyphicon-remove"></span>&nbsp</button><span class="btn btn-default btn-file">Browse<input type="file" id="photo_'+pcount+'" class="photo zxcv" ref="fn_'+pcount+'"></span></span></div></td><td><span id="fn_'+pcount+'"></span></td></tr>';
			$('#uparea').append(rawhtml);
			// $('#test').append(rawhtml);
			$('#photo_counter').val(pcount);
		});

   

		$('body').on('change','input:file',function(){
			var elem=$(this);
			// console.log(elem);
		
			var n = $(elem).attr('ref');
			$('#'+n).text($(elem).val());
			// console.log(n);
			
		})
	    

</script>