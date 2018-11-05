<?
$file = 'new.txt';
//file_put_contents( $file, array_unique( file($file) ) );

foreach(file('new.txt') as $str){
	echo '<p class="all">' . $str . '</p>';
}