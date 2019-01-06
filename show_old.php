<?php
require_once('variables.php');

//Поиск среди свежих объявлений, они будут выделены красным
$fileArrNew = file_exists(FILENEW) ? file(FILENEW) : [];
$fileArrNew = array_values(array_filter($fileArrNew, "trim"));

foreach($fileArrNew as $key=>$str){
	$fileArrNew[$key] = trim(iconv("windows-1251", "utf-8", $str));
	if( $_POST['find'] && preg_match("~{$_POST['find']}~ui", $str) ){
		echo '<p class="matches already">' . $str . '</p>';
	}
}


//Поиск среди старых объявлений
$fileArr = file(FILEOLD);
$fileArr = array_values(array_filter($fileArr, "trim"));

foreach($fileArr as $key=>$str){
	$fileArr[$key] = trim(iconv("windows-1251", "utf-8", $str));
	if( $_POST['find'] && preg_match("~{$_POST['find']}~ui", $str) ){
		echo '<p class="matches">' . $str . '</p>';
	}
}




?>