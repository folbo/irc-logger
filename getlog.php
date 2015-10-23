<?php
	//print_r($_POST);
	$channel = $_POST["channel"];
	$date = $_POST["date"];
	$baselink = readlink('logs');
	$filename = "$baselink/$channel/$date.log";	
	$logfile = fopen($filename, "r") or die("Nie ma takiego logu.");
	
	$regex_link = '/(ftp|https?):\/\/(\w+:?\w*@)?(\S+)(:[0-9]+)?(\/([\w#!:.?+=&%@!\/-])?)?/';
	$regex_nick = '/\<[ \+\@][^\>]+\>/';
	$regex_timestamp = '/[0-9]{2}:[0-9]{2}/';

	while(!feof($logfile)) {
		$line = fgets($logfile);

		//skip irssi notifications
		$pos = strpos($line, "-!- Irssi:");
		if($pos !== false) {
			continue;
		}


		//define header containing timestamp and nick
		preg_match($regex_timestamp, $line, $matches);
		$timestamp = $matches[0];

		preg_match($regex_nick, $line, $matches, PREG_OFFSET_CAPTURE);
		$nick = $matches[0][0];
		$pos_start_content = $matches[0][1] + strlen($nick) + 1;

		//define content message
		$content = substr($line, $pos_start_content);

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
		print '<span class="timestamp">' . htmlspecialchars($timestamp) . '</span> ';
		print '<span class="nick">' . htmlspecialchars($nick) . '</span> ';
		print $content;
		print "<br>";
	}

	fclose($logfile);
?>
