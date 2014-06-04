<?php
function microtime_float()
{
	list($usec, $sec) = explode(" ", microtime());
	return ((float)$usec + (float)$sec);
}

$time_start = microtime_float();

$yiic=dirname(__FILE__).'/../../framework/yiic.php';
$config=dirname(__FILE__).'/config/console.php';
@putenv('YII_CONSOLE_COMMANDS='. dirname(__FILE__).'/commands' );
require_once($yiic);

$time_end = microtime_float();
$time = $time_end - $time_start;

echo "Did nothing in $time seconds\n";