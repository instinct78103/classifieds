<?

require_once('variables.php');

function breakToParts($txt){
	//Функция, которая каждое объявление превращает в массив: 
	//[0] - код рубрики
	//[1] - текст объявления
	//[2] - номер телефона
	$arr = file($txt);
	foreach($arr as $item){
		$parts[] = explode('.', $item);
	}

	foreach($parts as $key=>$item){
		$last[$key] = array_pop($parts[$key]);
	}

	foreach($parts as $key=>$item){
		$parts[$key] = [implode('.', $parts[$key]), $last[$key]];
	}
	//Теперь отделить код рубрики
	foreach($parts as $key=>$item){
		foreach($parts[$key] as $num=>$str){
			$new[$key] = [trim(explode('	', $parts[$key][0])[0]), trim(explode('	', $parts[$key][0])[1]), trim($parts[$key][1])];
		}
	}
	return $new;
}

function showReps($txt){
	//Вывести на экран повторы
	$old = file($txt);
	$arr = breakToParts($txt);
	
	
	foreach($arr as $key=>$item){
		foreach($arr as $nkey=>$nitem){
			if($key != $nkey && $key < $nkey){
			
				if(
				//если кодировка совпадает
				$arr[$key][0] == $arr[$nkey][0] &&
				//если телефон совпадает
				$arr[$key][2] == $arr[$nkey][2] &&
				//если текст без знаков препинания совпадает
				mb_strlen(preg_replace('~[\s\,\.\+\-//\(\)]~', '', trim($arr[$key][1]))) == mb_strlen(preg_replace('~[\s\,\.\+\-//\(\)]~', '', trim($arr[$nkey][1])))
				/*   && mb_substr($arr[$key][2], 15) ==  mb_substr($arr[$nkey][2], 15) */
				){
					echo '<p id="' .$key . '">' . $old[$key] . '</p>' . '<p id="' .$nkey . '">' . $old[$nkey] . '</p>' . '<br><br>';
				}
			
			}
		}
	}
	
}

/* function str_split_unicode($str, $l = 0) {
    if ($l > 0) {
        $ret = [];
        $len = mb_strlen($str, "UTF-8");
        for ($i = 0; $i < $len; $i += $l) {
            $ret[] = mb_substr($str, $i, $l, "UTF-8");
        }
        return $ret;
    }
    return preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY);
} */

/* foreach($arr as $item){
	pre(str_split_unicode(preg_replace('~[\s\,\.\+\-//\(\)]~', '', trim($item))));
} */
?>

<!doctype html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="css/style.css">
	<title>CLC</title>
</head>
<body>
	<div id="found">
	<?
		showReps('old.txt');
		
	?>
	</div>	
</body>
</html>









