<?

require_once('variables.php');

$json = file_get_contents('php://input');
$_POST = json_decode($json, true);

if(isset($_POST['str'])){
	$array = file('old.txt');
	unset($array[$_POST['str']]);
	file_put_contents('old.txt', null);
	foreach($array as $key=>$item){
		file_put_contents('old.txt', $item, FILE_APPEND);
	}
}


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
				
				){
					$new[$key][$nkey] = $old[$nkey];
					unset($old[$nkey]);

					/* echo '<p>' . $key . ': ' . $old[$key] . '<p>';
					echo '<p>' . $nkey . ': ' . $old[$nkey] . '<p><br><br>'; */
				}
			
			}
		}
	}
	
	foreach($new as $key=>$item){
		foreach($item as $nkey=>$nitem){
			if(empty($new[$key][$nkey])){
				unset($new[$key]);
			}
		}
		
	}
	
	return $new;
	
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
?>

<!doctype html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="css/style.css">
	<style>
		img.delete{
			position: absolute;
			display: none;
			height: 15px;
			margin-left: 10px;
		}
		p:hover img{
			display: inline;
		}
		.dublicate{
			font-family: "Courier";
		}
	</style>
	<title>CLC</title>
</head>
<body>
	<div id="found">
	<?
		$array = file('old.txt');
		foreach(showReps('old.txt') as $key=>$item){
			echo "<p class=\"dublicate\" style=\"font-weight: bold\" id=\"$key\">$array[$key]<img class=\"delete\" src=\"https://img.icons8.com/flat_round/64/000000/delete-sign.png\"></p>";
			foreach($item as $nkey=>$nitem){
				echo "<p class=\"dublicate\" id=\"$nkey\">$nitem<img class=\"delete\" src=\"https://img.icons8.com/flat_round/64/000000/delete-sign.png\"></p>";
			}
			echo '<br><br>';
		}
		
		
	?>
	</div>
	<script>
		trashes = document.querySelectorAll('.delete');
		for(let i = 0; i < trashes.length; i++){
			trashes[i].onclick = function(){
				//console.log(trashes[i].parentElement.id);
				let str = JSON.stringify({
					"str": trashes[i].parentElement.id
				});
				console.log(str);
				
				let xhr = new XMLHttpRequest();
				xhr.open('POST', 'test.php');
				xhr.setRequestHeader('Content-type', 'application/json; charset=utf-8');
				xhr.send(str);
			}
		}
	</script>
</body>
</html>









