<?php
include('base.php');

$C = new base();
if( isset($_REQUEST['text']) ) {
	if ($_REQUEST['text']==''){	echo 1;	exit;}
	$s = $C->SetText($_REQUEST['text']);
	$a = array();
	$a = $C->SetSentence($s);
	if($a[0]=='☻'){	echo 2;	exit;}
	unset($C);
	$z=1;
	foreach($a as $tp)
	{
		$C = new base();
		if(!$C->J($tp)) echo 'در جمله شماره '.$z.' خطا یافت شد.<br>';
		unset($C);
	}











	var_dump ($a);
}else
	echo 'دسترسی غیر مجاز';

?>