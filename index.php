<!DOCTYPE html>
<html>
	<head>
		<title>SliverNet logs</title>
		<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
        <link rel="stylesheet" type="text/css" href="css/bootstrap-datepicker.min.css">
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css">
		<link rel="stylesheet" type="text/css" href="css/styles.css">
	</head>

	<body>
		<div style="float: left; width: 800px;">
			<div>
				<div class="affix" style="float: left; height: 100vh; background-color: #DADADA;">	
					<h2 class="text-center">hi</h2>
						<ul class="nav nav-pills nav-stacked" style="margin-bottom: 50px">
							<?php
							foreach(glob('logs/*', GLOB_ONLYDIR) as $dir) {
								$dir = str_replace('logs/', '', $dir);
								
								if(strpos($dir,"#") === false) 
									continue;

								//skip private channels
								if($dir == "#portalalkolpriv")
									continue;
								
								echo "<li><a data-target=\"#\" data-toggle=\"pill\" href=\"#\" onclick=\"changeChannel('$dir')\">$dir</a></li>";
							}
							?>
						</ul> 
						<div id="datepicker" style="clear: both"></div>
				</div>
			</div>

			<div id="log" style="float: left; margin-left: 240px; margin-top: 20px; width: auto">
			</div>
		</div>

		<script src="js/jquery-1.11.3.min.js"></script>
		<script src="js/jquery-ui.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/bootstrap-datepicker.min.js"></script>
		<script src="js/bootstrap-datepicker.pl.min.js"></script>
		
		<script>
		function changeChannel(c) {
			channel=c;
			change();
		}
		
		function changeDate(d) {
			date=d;
			change();
		}
		
		function change() {
			var http = new XMLHttpRequest();
			http.open("POST", "getlog.php", true);
			http.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			var params = "channel=" + channel + "&date=" + date; // probably use document.getElementById(...).value
			http.send(params);
			http.onload = function() {
				document.getElementById('log').innerHTML  = http.responseText;
			}
		}
		
		$(document).ready( function(){
			$('#datepicker').datepicker({
				format: 'dd-mm-yyyy',
				language: 'pl'
			});

			$("#datepicker").on("changeDate", function(event) {
				var formattedDate = $("#datepicker").datepicker('getFormattedDate').split('-');
				isoDate = formattedDate[2] + "-" + formattedDate[1]  + "-" + formattedDate[0];
				changeDate(isoDate);
			});		
		});
		</script>
	</body>
</html>
