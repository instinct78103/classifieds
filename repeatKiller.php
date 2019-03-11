<?
require_once('variables.php');

$arr = txt_cleaner(FILEOLD);
echo 'Удалено повторов: '  . (count($arr) - count(array_count_values($arr)));

file_put_contents(FILEOLD, null);
foreach(array_unique($arr) as $item){
	file_put_contents(FILEOLD, $item, FILE_APPEND);
}