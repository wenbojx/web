<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?=$this->pageTitle?></title>

<meta name="viewport"
	content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<script type="text/javascript"
	src="<?=Yii::app()->baseUrl . "/plugins/html5/player/base.js"?>"></script>
<script type="text/javascript">
window.addEventListener("load", hideUrlBar);
window.addEventListener("resize", hideUrlBar);
//window.addEventListener("orientationchange", hideUrlBar);
</script>
<style type="text/css" title="Default">
/* fullscreen */
html {
	height: 100%;
}

body {
	height: 100%;
	margin: 0px;
	overflow: hidden; /* disable scrollbars */
}

body {
	font-size: 10pt;
	background: #ffffff;
}

.warning {
	font-weight: bold;
}
.scroll_map{
	border:1px solid #DDDDDD;
	filter: alpha(opacity=10); 
	opacity: 0.9;
	z-index:9999;
	position:absolute; 
	top:5px; 
	right:2px;
	height:300px;
	width:350px;
}
.mapTip{
filter: alpha(opacity=10); 
	opacity: 0.7;
	z-index:9998;
	position:absolute; 
	top:5px; 
	right:2px;
}
.marker_map {

	float:left;
	width:350px;
	height:300px;
	-moz-box-shadow:0 0 5px #ddd;
	-webkit-box-shadow:0 0 5px #ddd;
	box-shadow:0 0 5px #ddd;
}
.marker {
display:block;
text-indent:-9999px;
width:40px;
height:40px;
outline:none;
background:url(../../plugins/craftmap/images/marker_green.png) no-repeat;
cursor:pointer;
}

.marker_red {
display:block;
text-indent:-9999px;
width:40px;
height:40px;
outline:none;
background:url(../../plugins/craftmap/images/marker_red.png) no-repeat;
cursor:pointer;
}
.marker_yellow {
display:block;
text-indent:-9999px;
width:40px;
height:40px;
outline:none;
background:url(../../plugins/craftmap/images/marker_yellow.png) no-repeat;
cursor:pointer;
}
/* fix for scroll bars on webkit & Mac OS X Lion */
::-webkit-scrollbar {
	background-color: rgba(0, 0, 0, 0.5);
	width: 0.75em;
}

::-webkit-scrollbar-thumb {
	background-color: rgba(255, 255, 255, 0.5);
}
</style>
</head>
<body>
	<?php echo $content;?>
	<div style="display: none">
	<script type="text/javascript">
var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3F9805da3aa6c6c7c215ccf3f709789543' type='text/javascript'%3E%3C/script%3E"));
</script>
	</div>
</body>
</html>
