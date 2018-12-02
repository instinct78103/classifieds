<?
require_once('variables.php');
echo count(array_count_values(file(FILEOLD))) . '<br>';
foreach(array_count_values(file(FILEOLD)) as $key=>$item){
	if($item > 1){
		echo $key . '<br>';
	}
}