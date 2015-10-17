<?php
	//print_r($_POST);
	$channel = $_POST["channel"];
	$date = $_POST["date"];
	$baselink = readlink('logs');
	$filename = "$baselink/$channel/$date.log";	
	$logfile = fopen($filename, "r") or die("Nie ma takiego logu.");
	
	print "<div>";

	while(!feof($logfile)) {
		$line = fgets($logfile);

		//skip irssi notifications
		$pos = strpos($line, "-!- Irssi:");
		if($pos !== false) {
			continue;
		}
	  print htmlspecialchars($line);
	  print "<br>";
	}

	print "</div>";
	fclose($logfile);
?>
