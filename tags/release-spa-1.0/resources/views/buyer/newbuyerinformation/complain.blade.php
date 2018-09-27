<div class="row">
			{{-- <center><h2>Complain Form</h2></center> --}}
        {{-- <div class="col-md-2"></div> --}}
        <div class="col-md-12" style="margin-left: -15px;">
            <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="col-md-12 row" style="padding:0px;margin-bottom:10px;">
                            
                        {{--     <div class="col-md-2">
                                
                            </div> --}}
                            <div class="col-md-12">
                                
                                <center><p style="padding-left:-5px;font-size:1.2em;"><strong>Order ID : {{$porder_id}}</strong></p></center>
                                <br>
                                <div id="cMessage" style="text-align: center;"></div>
                            </div>
                            
                            
                        </div>

                        <form id='complaintForm'>
                        	<input type="hidden" name="porder_id" value="{{$raw_porder_id}}">
                            
                            <table class="table" id="complainttable123">
                                <tr>
                                    <td>
                                        <input type="email" class="form-control"  id="mailtip2" value="{{$email}}" disabled="disabled" name="email">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                    	<!-- <h5>Your complaint is regarding</h5> -->
                                    	<select class="form-control " id="complaint_reason_id" name="complaint_reason_id">
                                    		<option value="" selected="selected">Select a reason for complain</option>
                             
                                            @foreach($complain_reasons as $cr)
                                            <option value="{{$cr->id}}">{{$cr->description}}</option>
                                            @endforeach
                                    	</select>
                                        <small class="warning" id="scw"></small>
                                      
                                    </td>
                                </tr>
                                <tr>
                                	<td>
                                		  <input class="form-control" type="text" placeholder="Reference Number (optional)" name="reference">
                                	</td>
                                </tr>
                                <tr>
                                    <td>
                                        <textarea class="form-control" rows="4" placeholder="Message text . . ." id="description" name="description"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <button class="btn btn-danger btn-sm" style="width: 100%;" id="registerComplaint"><i class="fa fa-envelope-o " style="padding-right: 5px;"></i> Send</button>
                                    </td>
                                </tr>
                            </table>

                        </form>
                    </div>
                </div>

            </div>
		</div>

        <script type="text/javascript">
    $(document).ready(function(){

        $('#complaintForm').bootstrapValidator({
            framework: 'bootstrap',
                // Feedback icons
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields:{
                description:{
                    validators:{
                        notEmpty:{
                            message:"Please write something to better describe your problem."
                        }
                    }
                },
                complaint_reason_id:{
                    validators:{
                        notEmpty:{
                            message:"Please chose a valid reason."
                        }
                    }
                }
            }
            ,
            onSuccess:function(){
                // alert("Yey");
                // $("#complaintForm").submit(function(e){
                    // e.preventDefault();
                    url="{{url('buyer/complaint/register')}}";
                    $.ajax({
                        type:'POST',
                        data:$('#complaintForm').serialize(),
                        url:url,
                        success:function(r){
                            if (r.status=='success') {
                                var complaint_id= r.complaint_id;

                                $('#complainttable123').empty();
                                $('#cMessage').append(r.long_message);
                            }
                        },
                        error:function(){

                        }
                    });
                // });
 
            }
        });
        // $('#registerComplaint').click(function(event){
        //         event.preventDefault();
        //         // alert($('#complaintForm').serialize());
        //         // data={
        //         //              'porder_id':$('#porder_id').val(),
        //         //              'description':$('description').val(),
        //         //              'complaint_reason_id':$('complaint_reason_id').val()
                                
        //         //          };
        //         if ($('#complaint_reason_id'==''))
        //         {
        //             $('#scw').text('Please select an option');
        //         } 
        //         else {
        //             url="{{url('buyer/complaint/register')}}";
        //             $.ajax({
        //                 type:'POST',
        //                 data:$('#complaintForm').serialize(),
        //                 url:url,
        //                 success:function(r){
        //                     if (r.status=='success') {
        //                         var complaint_id= r.complaint_id;

        //                         $('#table').empty();
        //                         $('#table').append(html)
        //                     }
        //                 },
        //                 error:function(){

        //                 }
        //             });
        //         }
        // });

    });
</script>