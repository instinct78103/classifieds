<?

require_once('variables.php');

$json = file_get_contents('php://input');
$_POST = json_decode($json, true);

//Код
if($_POST['code'] == '' || $_POST['textAndPhone'] == ''){
	echo 'Заполните все поля!' . '<br>';
}
elseif( strlen($_POST['code']) !== 3 || preg_match('~\D~ui', $_POST['code']) ){
	echo 'Только 3 цифры в коде!' . '<br>';
}
elseif( strlen($_POST['code']) == 3 && preg_match('~([0-9])([0-9])([0-9])~', $_POST['code'], $matches) ){
	//pre($matches);
	if($matches[1] == 1 && $matches[2] >= 1 && $matches[2] <= 5 && $matches[3] >= 0 && $matches[3] <= 8){
		$code = $_POST['code'];
	}
	elseif($matches[1] == 2 && $matches[2] >= 1 && $matches[2] <= 5 && $matches[3] >= 1 && $matches[3] <= 5){
		$code = $_POST['code'];
	}
	elseif($matches[1] == 3 && $matches[2] >= 1 && $matches[2] <= 2 && $matches[3] >= 1 && $matches[3] <= 5){
		$code = $_POST['code'];
	}
	elseif($matches[1] == 4 && $matches[2] >= 1 && $matches[2] <= 4 && $matches[3] >= 1 && $matches[3] <= 6){
		$code = $_POST['code'];
	}
	elseif($matches[1] == 5 && $matches[2] >= 0 && $matches[2] <= 2 && $matches[3] == 0){
		$code = $_POST['code'];
	}
	elseif($matches[1] == 6 && $matches[2] >= 1 && $matches[2] <= 2 && $matches[3] == 0){
		$code = $_POST['code'];
	}
	else{
		echo 'Ошибка в коде!' . '<br>';
	}
}

//Текст
if( mb_strlen(trim($_POST['textAndPhone']), 'UTF8') < 7 ){
	echo 'Не менее 7 символов в тексте!' . '<br>';
}
else{
	$textAndPhone = trim($_POST['textAndPhone']);
	$textAndPhone = preg_replace('~[.,!?]+$~ui', '', $textAndPhone);
}

if( isset($code) && isset($textAndPhone) ){
	$str = $code . "\t" . $textAndPhone . "\r\n";
	
	//$WeekNum.txt
	$toNew = file_exists(FILENEW) ? $str . file_get_contents(FILENEW) : $str;
	file_put_contents(FILENEW, $toNew);
	
	//backup	
	$toBackup = file_exists("backup\\" . $WeekNum . "backup.txt") ? $str . file_get_contents("backup\\" . $WeekNum . "backup.txt") : $str;
	file_put_contents("backup\\" . $WeekNum . "backup.txt", $toBackup);
	
	echo '1';
}

?>