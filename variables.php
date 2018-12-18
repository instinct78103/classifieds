<?
/* define(FILENEW, 'new.txt');
define(FILEOLD, 'old.txt'); */

$friday = new DateTime('friday');
$WeekNum = $friday->format('W');
define(FILENEW, $WeekNum . '.txt');
define(FILEOLD, 'old.txt');

function pre($arr){
	echo '<pre>';
	print_r($arr);
	echo '</pre>';
}