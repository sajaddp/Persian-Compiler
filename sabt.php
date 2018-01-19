<?php
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "test";
	$conn = new mysqli($servername, $username, $password, $dbname);
	mysqli_query($conn, "SET NAMES utf8");
	$debug = true;
	$error = 'متن اشتباه';
	function multiexplode($delimiters, $string) {
		$ready = str_replace($delimiters, $delimiters[0], $string);
		$launch = explode($delimiters[0], $ready);
		return $launch;
	}
	
	if (isset($_REQUEST['dic'])) {
		$NewDic = array();
		$NewDic2 = array();
		$NewDic = explode(' ', $_REQUEST['dic']);
		foreach ($NewDic as $a) {
			if (trim($a) != '') {
				$sql = "INSERT INTO dic set word='" . trim($a) . "'";
				if ($conn->query($sql)) $NewDic2[] = trim($a);
			}
		}
		
		echo 'لغات تایید شده شما جهت افزودن به برنامه:<br>';
		var_dump($NewDic2);
	}
	if (isset($_REQUEST['text'])) {
		if ($_REQUEST['text'] == '') {
			echo 1;
			exit;
		}
		$s = $_REQUEST['text'];
		$s = preg_replace('/\n/ ', ' ', $s);
		$s = preg_replace('/؟!/ ', '!', $s);
		$a = array();
		$a[] = '▼';
		//$x=0;
		$z = 0;
		for ($i = 0; $i < strlen($s); $i++) {
			$a[$z] .= $s[$i];
			if ($s[$i] == '.' || $s[$i] == '؟' || $s[$i] == '?' || $s[$i] == '!' || $s[$i] == ':') {
				$a[$z] = preg_replace('/▼/', '', $a[$z]);
				$a[] = '▼';
				$z++;
			}
			
		}
		
		$dic = array();
		$s2 = str_replace(array("'", "\"", "«", "ـ", "»", "،", "/", "[", "{", "]", "}", ",", ".", "|", ":", "؛", "1", "2", "3", "4", "5", "6", "7", "8", "9", "0", "٠", "١", "٢", "٣", "۴", "۵", "۶", "٧", "٨", "٩", "٠", "١", "۱", "٢", "٣", "٤", "٥", "٦", "٧", "٨", "٩", ")", "(", "-", "!", "؟", "‌"), ' ', $s);
		$exploded = explode(' ', $s2);
		$exploded = multiexplode(array(" ", ".", "|", ":"), $s2);
		foreach ($exploded as $tmp) {
			if (trim($tmp) != '') {
				$dic[] = trim($tmp);
			}
		}
		$dic = array_unique($dic);
		
		$NotInDic = false;
		$NotInDicList = array();
		foreach ($dic as $tmp) {
			$find = $conn->query("SELECT * FROM dic WHERE word='" . trim($tmp) . "' LIMIT 1");
			if (mysqli_num_rows($find) == 0) {
				$NotInDic = true;
				$NotInDicList[] = $tmp;
			}
			//echo mysqli_num_rows($find);
		}
		$NotInDicList = array_unique($NotInDicList);
		
		if ($NotInDic) {
			echo 'متاسفانه عبارات زیر در دایره لغات برنامه یافت نشد:<br>';
			var_dump($NotInDicList);
			
		}
		
		
		echo 'لغات شناسایی شده:<br>';
		var_dump($dic);
		if ($debug) {
			echo 'دیباگ:<br>';
			var_dump($s);
			var_dump($a);
		}
	} else
		echo 'دسترسی غیر مجاز';

?>