@extends('common.default')
<?php
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\IdController;
use App\Classes;
$i = 1;
?>
@section('content')
@include("common.sellermenu")
<script>
    // in this demo, it is triggered by a click event
// you may use any trigger in your apps    
    $(function(){
        
        var toast=function(message) {
    // Get the snackbar DIV
    var x = document.getElementById("snackbar");
$("#snackbar").html(message);
    // Add the "show" class to DIV
    x.className = "show";

    // After 3 seconds, remove the show class from DIV
    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
}
        var load=function(percentComplete){
  if ($("#progress").length === 0) {
    // inject the bar..
    $("body").append($("<div class='loader_top'><b></b><i></i></div>").attr("id", "progress"));
    
    // animate the progress..
//    console.log(percentComplete);
    $("#progress").width(percentComplete+"%").delay(800).fadeOut(1000, function() {
      // ..then remove it.
      $(this).remove();
    });  
  }
  }

        
 $("body #terminalClickable").on("click",function(){
// toast("started");
   var terminal_id=$(this).closest("tr").attr("term-id");
        
        $("#TerminalModal").find("#id").val(terminal_id);
        $("#terminal_modal_id").html("<h3 style='margin-top:0;margin-bottom:0'>Terminal ID: "+$(this).html()+"</h3>");

        var url_="{{url('/open-terminal/get-terminal-user-data')}}";
        load(100);
      $.ajax({
           async : true,
           type: "GET",
           url:url_,
            xhr: function() {
        var xhr = new window.XMLHttpRequest();

        // Upload progress
        xhr.upload.addEventListener("progress", function(evt){
            if (evt.lengthComputable) {
               var percentComplete = evt.loaded / evt.total;
              console.log(percentComplete)
                //Do something with upload progress
              load(100);
            }
       }, false);

       // Download progress
       xhr.addEventListener("progress", function(evt){
           if (evt.lengthComputable) {
                 var percentComplete = evt.loaded / evt.total;
              
               // Do something with download progress
                 load(100);
           }
       }, false);

       return xhr;
    },
           data:{
               id:terminal_id
           },
           success: function(data) {
	var selected_users =Object.values(data.selected_users);
//               console.log($.inArray(user.id,selected_users)>-1) 
       $("#TerminalModal #hardware_addr").val(data.terminal_data!=null?data.terminal_data.hardware_addr:"");
               $("#TerminalModal #ip_addr").val(data.terminal_data!=null?data.terminal_data.ip_addr:"");
              var add;
               $("#user").html(""); 
                 $.each(data.user_data,function(index,user){
//                                    console.log(user.user_id)
			if(user.email!=null){
				add=`<div><input class="form-check-input" type="checkbox" name="user_id[]" id="user_id"
				value="${user.user_id}" ${($.inArray(user.user_id,selected_users)>-1?"checked":"")}><label>
				&nbsp;&nbsp;${
				(user.name)}</label> <span >${user.email!=null?" &lt;"+user.email:""}></span></div>`;
				""
				$("#user").append(add);  
				}
				})
							   
			$("#TerminalModal").modal("show");
               
               
            }, error:function(xhar,error){
                console.log(xhar);
                console.log(error);
                
            }
       });   
        
    });
    
    $("body #terminal_user_form").on("submit",function(e){
    e.preventDefault();
    var url_="{{url('/open-terminal/save-terminal-user-data')}}";
        var data=$("#TerminalModal form").serializeArray();
        console.log(data);
       load(100);
      $.ajax({
           async : true,
           type: "GET",
           url:url_,
            xhr: function() {
        var xhr = new window.XMLHttpRequest();

        // Upload progress
        xhr.upload.addEventListener("progress", function(evt){
            if (evt.lengthComputable) {
               var percentComplete = evt.loaded / evt.total;
              console.log(percentComplete)
                //Do something with upload progress
              load(100);
            }
       }, false);

       // Download progress
       xhr.addEventListener("progress", function(evt){
           if (evt.lengthComputable) {
                 var percentComplete = evt.loaded / evt.total;
              
               // Do something with download progress
                 load(100);
           }
       }, false);

       return xhr;
    },
           data:data,
           success: function(data) {
//             console.log(data)                                           
      
          $("#TerminalModal").modal("toggle");
               toast(data.message);
               
               
            }
            , error:function(xhar,error){
                console.log(xhar);
                console.log(error);   
            }
       });   
       
       
    });

    $("body #terminal_data_form").on("submit",function(e){
    e.preventDefault();
    // alert("clicked terminal data form")
    var url_="{{url('/open-terminal/save-terminal-data')}}";
        var data=$(this).serializeArray();
        
       load(100);
      $.ajax({
           async : true,
           type: "GET",
           url:url_,
            xhr: function() {
        var xhr = new window.XMLHttpRequest();

        // Upload progress
        xhr.upload.addEventListener("progress", function(evt){
            if (evt.lengthComputable) {
               var percentComplete = evt.loaded / evt.total;
              console.log(percentComplete)
                //Do something with upload progress
              load(100);
            }
       }, false);

       // Download progress
       xhr.addEventListener("progress", function(evt){
           if (evt.lengthComputable) {
                 var percentComplete = evt.loaded / evt.total;
              
               // Do something with download progress
                 load(100);
           }
       }, false);

       return xhr;
    },
           data:data,
           success: function(data) {
            // console.log(data)                                           
        //   $("#TerminalModal").modal("toggle");
               toast(data.message);
    }
            , error:function(xhar,error){
                console.log(xhar);
                console.log(error);   
            }
       });   
       
       
    });
    
    $("body #subcat_model_button").on("click",function(){
      var terminal_id=$(this).closest("tr").attr("term-id");
        $("#SubCatModal").find("#id").val(terminal_id);
        $("#subcat_terminal_id").html("<b>Total Sub Categories: </b>"+$(this).html()
                +"<br><b>Terminal ID:</b>"+terminal_id);
        load(100);
        $.ajax({
            method:"get",
            url:"{{ url('/open-terminal/get-sub-cateogires') }}",
             xhr: function() {
        var xhr = new window.XMLHttpRequest();

        // Upload progress
        xhr.upload.addEventListener("progress", function(evt){
            if (evt.lengthComputable) {
               var percentComplete = evt.loaded / evt.total;
              console.log(percentComplete)
                //Do something with upload progress
              load(100);
            }
       }, false);

       // Download progress
       xhr.addEventListener("progress", function(evt){
           if (evt.lengthComputable) {
                 var percentComplete = evt.loaded / evt.total;
              
               // Do something with download progress
                 load(100);
           }
       }, false);

       return xhr;
    },
            success:function(data){
                 $("#SubCatModal").modal("show");
                var table;
                $('.subcat-datatable tbody').html("");
                var sr=1;
                $.each(data.data,function(index,value){
                    
                    table=`<tr>
                    <td>${sr++}</td>
            <td>${value.subcat_name}</td>
            <td>${value.total_product}</td>
                <td><input type='checkbox' name='cateogyr_id[]' ></td>
                </tr>`;
                    $('.subcat-datatable tbody').append(table);
                })
      $('.subcat-datatable').DataTable();
            }
        }) 
            });  
        
    
    
    
    $("body #subcat_terminal_form").on("submit",function(e){
        e.preventDefault();
        load(100);
     
        $.ajax({
            method:"get",
            url:"{{ url('/open-terminal/save-terminal-sub-cateogires') }}",
             xhr: function() {
        var xhr = new window.XMLHttpRequest();

        // Upload progress
        xhr.upload.addEventListener("progress", function(evt){
            if (evt.lengthComputable) {
               var percentComplete = evt.loaded / evt.total;
              console.log(percentComplete)
                //Do something with upload progress
              load(100);
            }
       }, false);

       // Download progress
       xhr.addEventListener("progress", function(evt){
           if (evt.lengthComputable) {
                 var percentComplete = evt.loaded / evt.total;
              
               // Do something with download progress
                 load(100);
           }
       }, false);

       return xhr;
    },
            success:function(data){
                 $("#SubCatModal").modal("show");
                var table;
                $('.subcat-datatable tbody').html("");
                var sr=1;
                $.each(data.data,function(index,value){
                    
                    table=`<tr>
                    <td>${sr++}</td>
            <td>${value.subcat_name}</td>
            <td>${value.total_product}</td>
                <td><input type='checkbox' name='cateogyr_id[]' ></td>
                </tr>
`;
                    $('.subcat-datatable tbody').append(table);
                    
                })
                
      $('.subcat-datatable').DataTable();
    
            }
        }) 
		
            
            });  
        
});
</script>
    <style>
		.table-sections{padding-top: 20px;padding-bottom: 20px}
		.sellerbutton{
		min-width: 70px;
		min-height: 70px;
		padding-top: 26px;
		text-align: center;
		vertical-align: middle;
		float: left;
		font-size: 13px;
		cursor: pointer;
		margin-right: 5px;
		margin-bottom: 5px;
		border-radius: 5px;
		border: none;
	}
	.bg-primaryii{
		background-color: #02d4f9;
		color: #f6f6f6;
	}
	.bg-primaryorange{
		background-color: #ea6c06;
		color: #f6f6f6;
	}

	.sellerbuttons{
		min-width: 70px;
		min-height: 70px;
		padding-top: 4px;
		text-align: center;
		vertical-align: middle;
		float: left;
		font-size: 13px;
		cursor: pointer;
		margin-right: 5px;
		margin-bottom: 5px;
		border-radius: 5px;
		box-shadow: none;
		background-color: #6d9370;
		border: 0;
		color: #dadada;
	}
     


#progress {
  position: fixed;
  z-index: 1;
  top: 0;
  left: -6px;
  width: 1%;
  height: 3px;
  background-color: #ce0000;
  -moz-border-radius: 1px;
  -webkit-border-radius: 1px;
  border-radius: 1px;
  -moz-transition: width 600ms ease-out, opacity 500ms linear;
  -ms-transition: width 600ms ease-out, opacity 500ms linear;
  -o-transition: width 600ms ease-out, opacity 500ms linear;
  -webkit-transition: width 600ms ease-out, opacity 500ms linear;
  transition: width 1000ms ease-out, opacity 500ms linear;
}
#progress b,
#progress i {
  position: absolute;
  top: 0;
  height: 3px;
  -moz-box-shadow: #777777 1px 0 6px 1px;
  -ms-box-shadow: #777777 1px 0 6px 1px;
  -webkit-box-shadow: #777777 1px 0 6px 1px;
  box-shadow: #777777 1px 0 6px 1px;
  -moz-border-radius: 100%;
  -webkit-border-radius: 100%;
  border-radius: 100%;
}
#progress b {
  clip: rect(-6px, 22px, 14px, 10px);
  opacity: .6;
  width: 20px;
  right: 0;
}
#progress i {
  clip: rect(-6px, 90px, 14px, -6px);
  opacity: .6;
  width: 180px;
  right: -80px;
}
/* The snackbar - position it at the bottom and in the middle of the screen */
#snackbar {
    visibility: hidden; /* Hidden by default. Visible on click */
    min-width: 250px; /* Set a default minimum width */
    margin-left: -125px; /* Divide value of min-width by 2 */
    background-color: #333; /* Black background color */
    color: #fff; /* White text color */
    text-align: center; /* Centered text */
    border-radius: 2px; /* Rounded borders */
    padding: 16px; /* Padding */
    position: fixed; /* Sit on top of the screen */
    z-index: 1; /* Add a z-index if needed */
    left: 50%; /* Center the snackbar */
    bottom: 30px; /* 30px from the bottom */
}

/* Show the snackbar when clicking on a button (class added with JavaScript) */
#snackbar.show {
    visibility: visible; /* Show the snackbar */

/* Add animation: Take 0.5 seconds to fade in and out the snackbar. 
However, delay the fade out process for 2.5 seconds */
    -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
    animation: fadein 0.5s, fadeout 0.5s 2.5s;
}

/* Animations to fade the snackbar in and out */
@-webkit-keyframes fadein {
    from {bottom: 0; opacity: 0;} 
    to {bottom: 30px; opacity: 1;}
}

@keyframes fadein {
    from {bottom: 0; opacity: 0;}
    to {bottom: 30px; opacity: 1;}
}

@-webkit-keyframes fadeout {
    from {bottom: 30px; opacity: 1;} 
    to {bottom: 0; opacity: 0;}
}

@keyframes fadeout {
    from {bottom: 30px; opacity: 1;}
    to {bottom: 0; opacity: 0;}
}


    </style>
    <div class="modal fade" id="TerminalModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<form id="terminal_user_form">
					
					<input type="hidden" name="id" id="id">
				<div class="modal-header bg-default">
<!--					<h2 class="modal-title"
					id="exampleModalTerminalId">Terminal Details</h2>-->
  <h2 class="modal-title" id="exampleModalTerminalId">Terminal Details<br>
                                            </h2>
<!--                                        <button type="button" class="close" style="margin-top:-32px;" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>-->
                                    </div>
                                    <div class="modal-body text-left"
									style="margin-left:15px;margin-right:15px;padding-top:5px;margin-bottom:20px">
                                       
                                        <div class="col-xs-10"
										style="padding-left:0">
                                            
                                            <sub style="margin-left:-30px;" id="terminal_modal_id"></sub>
                                        </div>
                                         <div class="col col-xs-2">
                                            <input type="submit" id="save_terminal_data" style="height:70px;width:70px;border-radius:5px;position:relative;right:-5px;border-color:#0cc0e8;background-color:#0cc0e8" class="btn btn-primary" value="Save">
                                        </div>
                                            <div class="form-group">
                                                <label for="address">Media Access Control Hardware Address</label>
                                       <input type="text" id="hardware_addr" name="hardware_addr" value="" placeholder="02:8F:48:22:88:BB" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="address">Device IP Address</label>
                                                <input type="text" id="ip_addr" name="ip_addr" value="" placeholder="192.168.0.1" class="form-control">
                                            </div>
                                            <h3>OPOSsum Authorized Users</h3>
                                            <div class="form-check" id="user">
                                            </div>
                                            {{--<div class="form-group"><input type="text" class="form-control">&nbsp;<label for="address">Jane</label></div>--}}
                                            {{--<div class="form-group"><input type="text" class="form-control">&nbsp;<label for="address">May</label></div>--}}
                                            {{--<div class="form-group"><input type="text" class="form-control">&nbsp;<label for="address">Raechal</label></div>--}}
                                    </div>
                                    
									<!--
                                    <div class="modal-footer">
                                        
                                        
                                        <!--<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>-->
                                            
                                    </div>
									-->
                                </form>
                                </div>
                            </div>
                        </div>
    
    
    
    
    
    
    
     <div class="modal fade" id="SubCatModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabele" aria-hidden="true">
          <form id="subcat_terminal_form">                   
         <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <!--<button class="bg-primaryorange sellerbutton pull-right" id="product-adding"><i class="fa fa-plus"></i>&nbsp;Add Product</button>-->
                                        <h4>Sub Category<br>
                                            <sub id="subcat_terminal_id"></sub></h4>
                                           
                                                <input type="hidden" name="id">
                                            <table style="width:100%;" class="table table-bordered subcat-datatable">
                                            <thead class="thead-dark">
                                            <tr>
                                                <th scope="col" class="bg-primaryii text-center">Sr No.</th>
                                                <th scope="col" class="bg-primaryii text-center">Subcategory /Menu</th>
                                                <th scope="col" class="bg-primaryii text-center">Product</th>
                                                <th scope="col" class="bg-primaryii text-center">Check</th>

                                            </tr>
                                            </thead>
                                            <tbody class="addressing-section">
                                          

							<label for="address">Media Access Control Hardware Address</label>
				   <input type="text" id="hardware_addr" name="hardware_addr" value="" placeholder="02:8F:48:22:88:BB" class="form-control">
						</div>
						<div class="form-group">
							<label for="address">Device IP Address</label>
							<input type="text" id="ip_addr" name="ip_addr" value="" placeholder="192.168.0.1" class="form-control">
						</div>
						<h3>OPOSsum Authorized Users</h3>
						<div class="form-check" id="user">
						</div>

						{{--<div class="form-group"><input type="text" class="form-control">&nbsp;<label for="address">Jane</label></div>--}}
						{{--<div class="form-group"><input type="text" class="form-control">&nbsp;<label for="address">May</label></div>--}}
						{{--<div class="form-group"><input type="text" class="form-control">&nbsp;<label for="address">Raechal</label></div>--}}
				</div>
				<div class="modal-footer">
				<input type="submit" id="save_terminal_data" class="btn btn-primary" value="Save">
				</div>
			</form>
			</div>
		</div>
	</div>

<div class="modal fade" id="SubCatModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabele" aria-hidden="true">
	<form id="subcat_terminal_form">                   
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-body">
					<!--<button class="bg-primaryorange sellerbutton pull-right" id="product-adding"><i class="fa fa-plus"></i>&nbsp;Add Product</button>-->
					<h4>Sub Category<br>
						<sub id="subcat_terminal_id"></sub></h4>
					   
							<input type="hidden" name="id">
						<table style="width:100%;" class="table table-bordered subcat-datatable">
						<thead class="thead-dark">
						<tr>
							<th scope="col" class="bg-primaryii text-center">Sr No.</th>
							<th scope="col" class="bg-primaryii text-center">Subcategory /Menu</th>
							<th scope="col" class="bg-primaryii text-center">Product</th>
						</tr>
						</thead>
						<tbody class="addressing-section">
						</tbody>
					</table>
					   
				</div>
				<div style="margin-bottom:10px" class="modal-footer">
				<!--
					<button type="button" class="btn btn-secondary"
					data-dismiss="modal">Close</button>
				-->
					<input type="submit" value="Save" class="btn btn-primary">
				</div>
			</div>
		</div>
	</form>
</div>

    <section class="">
        
        <div class="container table-sections">
            <label>
                @if($errors->any())
                <div class="alert alert-danger">
<h4>{{$errors->first()}}</h4>
            </div>
@endif
            </label>
            <a href="{{url("/open-terminal/add-without-values/$id")}}"
				style="color:white;padding-top:27px"
				class=" sellerbuttons pull-right" >
				<i class="fa fa-plus"></i>&nbsp;Terminal</a>
            <h2>Terminal Definition</h2>
          
             <form id='terminal_data_form'>
            <table id="editable-datatable" class="table table-bordered" style="width:100% !important">
                <thead>
                <td class="text-center bg-primaryii">No.</td>
                <td class="text-center bg-primaryii">Terminal&nbsp;ID</td>
                <td class="text-center bg-primaryii">Terminal Name</td>
                <td class="text-center bg-primaryii">Counter</td>
                <td class="text-center bg-primaryii">SubCategory/Menu</td>
                <td class="text-center bg-primaryii">Start</td>
                <td class="text-center bg-primaryii">Close</td>
                <td class="text-right bg-primaryii">&nbsp;&nbsp;</td>
                </thead>
                <tbody id="new-terminal">
                    <?php 
                    $i=1;
                    ?>
                @foreach($terminal as $term)
                <tr term-id="{{$term->id}}">
                    <td class="text-center" style="vertical-align: middle" ><span >{{$i++}}</span></td>
                    <td class="text-center " style="vertical-align: middle"><a id="terminalClickable" href="#" data-toggle="modal" >{{sprintf("%05d",$term->id)}}</a>
                       
                    </td>
                    <td class="text-center" style="vertical-align:middle"><input type="text" name="terminal_d[{{$term->id}}][name]" class="form-control" value="{{$term->name}}"></td>
                    <td class="text-center" style="vertical-align:middle"><input type="text" name="terminal_d[{{$term->id}}][counter]" class="form-control" value="{{$term->counter}}"></td>
                    <td class="text-center" style="vertical-align:middle">
                       <!--  <a href="#" data-toggle="modal" data-target="" id="subcat_model_button">3</a> -->
                        <a href="#" data-toggle="modal" data-target="" onclick="subcat_model('{{$id}}')">{{ $subcat_count }}</a>
                        
                    </td>
                    <td class="text-center" style="vertical-align:middle"> 
                        <div class="bootstrap-timepicker">
            <input id="timepicker5" name="terminal_d[{{$term->id}}][start_work]" value="{{$term->start_work}}" type="text" class="input-small">
            <i class="icon-time"></i>
        </div>
                        
                       </td>
                    <td class="text-center" style="vertical-align:middle">
                     <div class="bootstrap-timepicker">
            <input id="timepicker6" name="terminal_d[{{$term->id}}][end_work]" value="{{$term->end_work}}" type="text" class="input-small">
            <i class="icon-time"></i>
                    </td>
                    <td class="text-center" style="vertical-align:middle">
					<a class="btn-sm"
					style="background-color:red;color:white;font-size:15px;border-radius:5px"
					href="{{url("/open-terminal/delete/$term->id")}}" class="text-danger">
					&times;
					</a></td>
                </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                <td colspan='5'></td>
                <td colspan="3"><input type='submit' value='UPDATE' class="btn btn-danger form-control" ></td>
                </tr>
                </tfoot>
            </table>
            </form>
        </div>
        <div class="modal fade" id="subcatModal" role="dialog">
            <div class="modal-dialog maxwidth60" style="width:50%">
                <!-- Modal content-->
              <div class="modal-content modal-content-sku">
                  <div class="modal-header">
                      
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h2>Branch Subcategory</h2>
                  </div>
                  <!-- Temporarily disable the modal due to UGLY ERROR -->
                  <div id="subcatbody"
                      style="padding-left:0;padding-right:0"
                      class="modal-body"></div>
                  </div>
            </div>
        </div>
    </section>
    <div id="snackbar">Some text some message..</div>
    
    <script>
      function subcat_model(location_id)
      {
        var url =  JS_BASE_URL+"/branch/subcat/"+location_id;
        $.ajax({
            type: "GET",
            url: url,
            beforeSend: function(){},
            success: function(response){
                $('#subcatbody').html(response);
                $('#subcatModal').modal('show');
            }
        });          
        }

        $(document).ready(function() {
            $('#editable-datatable').DataTable();
			var number = 2;
			$('#product-adding').on('click',function () {
				$('.addressing-section').append("<tr><th scope='row' class='text-center'>Fish</th><td class='text-center'><a href='/product-defination-page'>15</a></td></tr>")
			})
		});
    </script>
    
    <script type="text/javascript">
		$('body #timepicker5').timepicker({ 'timeFormat': 'H:i:s' });
		 $('body #timepicker6').timepicker({ 'timeFormat': 'H:i:s' });
	</script>
        
        <script>
    var getExternalIP = new Promise(function(resolve, reject) {
      var ips = [];
      var ip_dups = {};
    
      //compatibility for firefox and chrome
      var RTCPeerConnection = window.RTCPeerConnection
        || window.mozRTCPeerConnection
        || window.webkitRTCPeerConnection;
      var useWebKit = !!window.webkitRTCPeerConnection;
    
      //bypass naive webrtc blocking using an iframe
      if(!RTCPeerConnection){
        //NOTE: you need to have an iframe in the page right above the script tag
        //
        //<iframe id="iframe" sandbox="allow-same-origin" style="display: none"></iframe>
        //<script>...getIPs called in here...
        //
        var win = iframe.contentWindow;
        RTCPeerConnection = win.RTCPeerConnection
          || win.mozRTCPeerConnection
          || win.webkitRTCPeerConnection;
        useWebKit = !!win.webkitRTCPeerConnection;
      }
    
      //minimal requirements for data connection
      var mediaConstraints = {
        optional: [{RtpDataChannels: true}]
      };
    
      var servers = {iceServers: [{urls: "stun:stun.services.mozilla.com"}]};
    
      //construct a new RTCPeerConnection
      var pc = new RTCPeerConnection(servers, mediaConstraints);
    
      function handleCandidate(candidate){
        //match just the IP address
        var ip_regex = /([0-9]{1,3}(\.[0-9]{1,3}){3}|[a-f0-9]{1,4}(:[a-f0-9]{1,4}){7})/
        var result = ip_regex.exec(candidate);
    
        if(!result) return;
        var ip_addr = result[1];
    
        //remove duplicates
        if(ip_dups[ip_addr] === undefined)
          ips.push(ip_addr);
    
        ip_dups[ip_addr] = true;
      }
    
      //listen for candidate events
      pc.onicecandidate = function(ice){
    
        //skip non-candidate events
        if(ice.candidate)
          handleCandidate(ice.candidate.candidate);
      };
    
      //create a bogus data channel
      pc.createDataChannel("");
    
      //create an offer sdp
      pc.createOffer(function(result){
    
        //trigger the stun server request
        pc.setLocalDescription(result, function(){}, function(){});
    
      }, function(){});
    
      //wait for a while to let everything done
      setTimeout(function(){
        //read candidate info from local description
        var lines = pc.localDescription.sdp.split('\n');
    
        lines.forEach(function(line){
          if(line.indexOf('a=candidate:') === 0)
            handleCandidate(line);
        });
    
        resolve( ips.pop() );
      }, 1000);
    });
    
    getExternalIP.then(function(ip){
    console.log(ip);
        });
    </script>
@stop
