<?

require_once('variables.php');


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
if( mb_strlen(trim($_POST['textAndPhone']), 'UTF8') == 1 ){
	echo 'Один символ не допускается!' . '<br>';
}
else{
	$textAndPhone = trim($_POST['textAndPhone']);
	$textAndPhone = preg_replace('~[.,!?]+$~ui', '', $textAndPhone);
}

if( isset($code) && isset($textAndPhone) ){
	$ready = $code . "\t" . $textAndPhone . "\r\n";
	$ready .= file_get_contents(FILENEW) . "\n";
	file_put_contents(FILENEW, $ready . "\n");
	echo '1';
}
?>