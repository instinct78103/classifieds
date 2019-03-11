<?
require_once('variables.php');
$json = file_get_contents('php://input');
$_POST = json_decode($json, true);

$errors = [];
if($_POST['code'] == '' || $_POST['textAndPhone'] == ''){
	$errors[] = 'Заполните все поля';
}
else{
	//Код
	preg_match("~^" . implode('|', CODES) . "$~", $_POST['code']) ?: $errors[] = 'Ошибка в коде';
	//Текст
	$_POST['textAndPhone'] = preg_replace( '~[.,!?//-]+$~ui', '', trim($_POST['textAndPhone']) );
	$_POST['textAndPhone'] = preg_replace( '~\s{2,}~', ' ', $_POST['textAndPhone'] );
	if( mb_strlen($_POST['textAndPhone'], 'UTF8') < 7 ){
		$errors[] = 'Не менее 7 символов';
	}
}

if(!empty($errors)){
	echo array_shift($errors);
}
else{
	$code = $_POST['code'];
	$textAndPhone = $_POST['textAndPhone'];
	$str = $code . "\t" . $textAndPhone . "\r\n";
	
	//$WeekNum.txt
	paste_str(FILENEW, $str);
	//backup
	paste_str("backup\\" . $WeekNum . "backup.txt", $str);
	//old.txt
	paste_str(FILEOLD, $str);
	
	echo '1';
}