<?php
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "test";
	$conn = new mysqli($servername, $username, $password, $dbname);
	mysqli_query($conn, "SET NAMES utf8");
	function multiexplode($delimiters, $string) {
		$ready = str_replace($delimiters, $delimiters[0], $string);
		$launch = explode($delimiters[0], $ready);
		return $launch;
	}
	
	$text = 'چکیده';
	$text = str_replace(array("
", "\n", "'", "\"", "«", "ـ", "»", "،", "/", "[", "{", "]", "}", ",", ".", "|", ":", "؛", "1", "2", "3", "4", "5", "6", "7", "8", "9", "0", "٠", "١", "٢", "٣", "۴", "۵", "۶", "٧", "٨", "٩", "٠", "١", "۱", "٢", "٣", "٤", "٥", "٦", "٧", "٨", "٩", ")", "(", "-", "!", "؟", "‌"), ' ', $text);
	$exploded = multiexplode(array(" ", ".", "|", ":"), $text);
	
	foreach ($exploded as $a) {
		if (trim($a) != '') {
			$sql = "INSERT INTO dic set word='" . trim($a) . "'";
			$conn->query($sql);
		}
	}
	echo 'OK';
	//var_dump($exploded);
