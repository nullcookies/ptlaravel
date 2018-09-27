<html>
<head>
	<title></title>
	<!-- Latest compiled and minified CSS & JS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<script src="//code.jquery.com/jquery.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</head>

<body>
	
	<?php 

	$base_url = \DB::table('global')->select('jc_ars_url')->first()->jc_ars_url;

	

	?>

	<div class="container-fluid" style="margin-top:20px">
		<button type="button" class="btn btn-success" id="test">Test Now!!</button>
	</div>

<script type="text/javascript">
	function padLeft(nr, n, str){
		return Array(n-String(nr).length+1).join(str||'0')+nr;
	}
	
	function genVeriCode(id, msisdn, denom, ndate, ntime) {
		var vc1 = parseInt(msisdn.substr(msisdn.length-4)) * 5;
		var vc2 = parseInt(id);
		var vc3 = parseInt(ndate.substr(ndate.length-5));
		var vc4 = parseInt(ntime.substr(ntime.length-4));
		return vc1+vc2+vc3+vc4;
	}


	$(function(){
		var td = new Date();
		var syr  = td.getFullYear().toString();
		var smth = padLeft(td.getMonth()+1,2);
		var sdt  = td.getDate().toString();

		var shr  = padLeft(td.getHours(),2);
		var smin = padLeft(td.getMinutes(),2); 
		var ssec = padLeft(td.getSeconds(),2); 

		var id   = '12345';
		var msisdn = '60102892866';
		var denom = 5;
		var tdate = syr+smth+sdt;
		var ttime = shr+smin+ssec;

		
		var data = {
			dealerID : 'intermedius',
			transTYPE : 'TP',
			transID : id,
			targetMSISDN : msisdn,
			//telcoCODE : 'DG',
			telcoCODE : 'CC',
			tpDENOM : denom,
			transDATE : tdate,
			transTIME : ttime,
			veriCODE : genVeriCode(id,msisdn,denom,tdate,ttime)
		};

		$('#test').on('click', function(){
			$.post('', data, function(res){
				console.log(res);
			});
		});
	});

</script>
</body>
</html>
