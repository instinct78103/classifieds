<?
require_once('variables.php');

if(file_exists(FILENEW)){
	foreach(file(FILENEW) as $str){
		echo '<p class="all">' . $str . '</p>';
	}
}