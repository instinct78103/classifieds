<?
//если нет ошибок в полученных данных, добавляем новую строку в txt-Файл

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
	paste_str("backup/" . $WeekNum . "backup.txt", $str);
	//old.txt
	paste_str(FILEOLD, $str);

	echo 'Success! New line has been added!';
}

//$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD);
//if ($conn->connect_error){
//    die('Connection error');
//}
//
//if( mysqli_select_db($conn, DB_NAME) ) {
//    $sql = 'SELECT * FROM '. DB_NAME . '.old';
//}
//else{
//    $sql = 'CREATE DATABASE IF NOT EXISTS '. DB_NAME;
//    echo 'Database created successfully!';
//}
//
//$result = $conn->query($sql);
//$row = $result -> fetch_all(MYSQLI_ASSOC);
//pre(json_encode($row, JSON_UNESCAPED_UNICODE));
//var_dump($row);

//if($conn){
//    exit('Ошибка подключения к базе: ' . $conn->connect_error);
//}