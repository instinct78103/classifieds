<?
require_once('variables.php');
$arr = file(FILEOLD);

//Отделить текст объявления от номеров телефонов >>>
foreach($arr as $item){
	$parts[] = explode('.', $item);
}

foreach($parts as $key=>$item){
	$last[$key] = array_pop($parts[$key]);
}

foreach($parts as $key=>$item){
	$parts[$key] = [implode('.', $parts[$key]), $last[$key]];
}
// <<<



//Теперь отделить код рубрики
foreach($parts as $key=>$item){
	foreach($parts[$key] as $num=>$str){
		$new[$key] = [trim(explode('	', $parts[$key][0])[0]), trim(explode('	', $parts[$key][0])[1]), trim($parts[$key][1])];
	}
}

pre($new);

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
}

foreach($arr as $item){
	pre(str_split_unicode(preg_replace('~[\s\,\.\+\-//\(\)]~', '', trim($item))));
} */
