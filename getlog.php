<?php
	//print_r($_POST);
	$channel = $_POST["channel"];
	$date = $_POST["date"];
	$baselink = readlink('logs');
	$filename = "$baselink/$channel/$date.log";	
	$logfile = fopen($filename, "r") or die("Nie ma takiego logu.");
	
	$regex_link = '/(ftp|https?):\/\/(\w+:?\w*@)?(\S+)(:[0-9]+)?(\/([\w#!:.?+=&%@!\/-])?)?/';
	
	while(!feof($logfile)) {
		$line = fgets($logfile);

		//skip irssi notifications
		$pos = strpos($line, "-!- Irssi:");
		if($pos !== false) {
			continue;
		}

		//define header containing timestamp and nick
		$pos = strpos($line, ">") + 1;
		$header = explode(" ", substr($line, 0, $pos));

		//define content message
		$content = substr($line, $pos + 1);

		//parse urls
		preg_match_all($regex_link, $content, $matches, PREG_OFFSET_CAPTURE);
		if($matches){
			foreach($matches[0] as $match){
				$position = $match[1];
				$length = strlen($match[0]);
				$content = substr($content, 0, $position) . '<a href="' . htmlspecialchars(substr($content, $position, $length)) . '">' . htmlspecialchars(substr($content, $position, $length)) . '</a>' . substr($content, $position + $length) ;
			}
		}

		//print output
		print '<span class="timestamp">' . htmlspecialchars($header[0]) . '</span> ';
		print '<span class="nick">' . htmlspecialchars($header[1]) . '</span> ';
		print $content;
		print "<br>";
	}

	fclose($logfile);
?>
