<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en" xml:lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta content="text/html; charset=utf-8" http-equiv="content-type" />
	<title> Log Reader | Plagiarism Checker </title>
	<link href = "assets/css/bootstrap.css" rel="stylesheet" media="screen">
	<script src = "assets/js/jquery.js"></script>
	<script src = "assets/js/bootstrap.min.js"></script>
	<style>
		input:focus 
		{
    		outline:0px !important;
    		-webkit-appearance:none;
        }
        a:focus 
		{
    		outline:0px !important;
    		-webkit-appearance:none;
        }
        button:focus 
		{
    		outline:0px !important;
    		-webkit-appearance:none;
        }
	</style>
	<script>
	function getLogs()
	{
		var filename = "";
		<?php
			if(empty($_GET['file']))
			{
				echo "clearInterval(getLogsID);
				return;";
			}
			else
			{
				echo "var filename = '".$_GET['file']."';";
				$timestamp = substr($_GET['file'], 4);
			}
		?>
		var xmlhttp;
		if(window.XMLHttpRequest)
		{
			xmlhttp = new XMLHttpRequest();
		}
		else
		{
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
		 		if(xmlhttp.responseText.indexOf('stop') != -1)
		 		{
		 			var parts = xmlhttp.responseText.split('stop');
		 			var subparts = parts[0].split("~");
		 			document.getElementById("logDiv").innerHTML=subparts[0];
		 			document.getElementById('statusDiv').innerHTML=subparts[1]+"<input type=button class='btn btn-large btn-primary span3' value='Statistics' onclick='redirectStats()'><br><br>";
		 			clearInterval(getLogsID);
		 			return;
		 		}
		 		var subparts = xmlhttp.responseText.split("~");
		 		document.getElementById("logDiv").innerHTML=subparts[0];
		 		document.getElementById("statusDiv").innerHTML=subparts[1];
		 	}
		}
		xmlhttp.open("GET","readLogs.php?file="+filename,true);
		xmlhttp.send();
	}

	function redirectStats()
	{
		window.location = "stats.php?file=output_"+<?php echo "\"$timestamp\""; ?>;
	}

	var getLogsID = setInterval(getLogs,500);

	</script>
</head>
<body>
	<div class='hero-unit'>
		<?php 
			if(empty($_GET['file']))
			{
				echo "<h1> File not selected <small> Enter a file name as a GET parameter </small></h1>";
				exit();
			}
		?>
		<h1> Processing <small><?php echo $_GET['file']; ?> </small></h1>
	</div>
	<div class='well' id='logDiv' style='margin:20px'>
	</div>

	<div class='well' id='statusDiv' style='margin:20px' align='center'>
	</div>
</body>
</html>