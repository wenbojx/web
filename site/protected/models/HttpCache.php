<?php
class HttpCache{
	public static function etag($etag, $notModifiedExit = true)
	{
		if ($notModifiedExit && isset($_SERVER['HTTP_IF_NONE_MATCH']) && $etag == $_SERVER['HTTP_IF_NONE_MATCH']) {
			header('HTTP/1.0 304 Not Modified');
			exit();
		}
		header('Etag: ' . $etag);
	}
	
	public static function lastModified($modifiedTime, $notModifiedExit = true)
	{
		$modifiedTime = date('D, d M Y H:i:s', $modifiedTime) . ' GMT';
		if ($notModifiedExit && isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && $modifiedTime == $_SERVER['HTTP_IF_MODIFIED_SINCE']) {
			header('HTTP/1.0 304 Not Modified');
			exit();
		}
		header("Last-Modified: $modifiedTime");
	}
	
	public static function expires($seconds = 1800)
	{
		$time = date('D, d M Y H:i:s', time() + $seconds) . ' GMT';
		header("Expires: $time");
	}
}