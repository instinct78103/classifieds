<?php
$fileArr = file('old.txt');
$fileArr = array_values(array_filter($fileArr, "trim"));

foreach($fileArr as $key=>$str){
	$fileArr[$key] = trim(iconv("windows-1251", "utf-8", $str));
	if( $_POST['find'] &&  preg_match("~{$_POST['find']}~ui", $str) ){
		echo '<p class="matches">' . $str . '</p>';
	}
}
?>