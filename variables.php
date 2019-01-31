<?
define(CODES, 
[
'[1][1-5][0-8]',
'[2][1-4][1-4]',
'[2][5][1-3]',
'[3][1-2][1-5]',
'[4][1-4][1-6]',
'[5][0-2][0]',
'[6][1-2][0]'
]);

$friday = new DateTime('friday');
$WeekNum = $friday->format('Y__W');
define(FILENEW, $WeekNum . '.txt');
define(FILEOLD, 'old.txt');

function pre($arr){
	echo '<pre>';
	print_r($arr);
	echo '</pre>';
}