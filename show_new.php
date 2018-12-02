<?
require_once('variables.php');

foreach(file(FILENEW) as $str){
	echo '<p class="all">' . $str . '</p>';
}