<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/pages/css/common.css"); ?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/pages/css/page.css"); ?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/pages/css/boxy.css"); ?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/pages/uploadify/uploadify.css"); ?>

<script type="text/javascript">
var baseUrl = '<?=Yii::app()->baseUrl?>';
var flash_url = baseUrl+'/pages/uploadify/uploadify.swf';
var session_id = '<?=session_id()?>';
var pic_url = '<?=$this->createUrl('/panos/imgOut/index/')?>';
var google_map_tip_url = baseUrl+'/pages/images/dot-s-nomarl_16x24.png';
var save_module_datas_url = '<?=$this->createUrl('/salado/modules/')?>';
var scene_publish_url = '<?=$this->createUrl('/project/sceneEdit/publish')?>';

</script>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/pages/js/jquery172.min.js");?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/pages/js/jquery.boxy.js");?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/pages/js/core.js");?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/pages/js/salado.admin.js");?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/pages/js/google_map.js");?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/pages/salado/scene.js");?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/pages/uploadify/jquery.uploadify-3.1.js");?>
<title>content</title>
</head>
<body onResize="on_reset_windows()">
<div class="container">
<?php echo $content;?>
</div>
<div id="showmodel" style="display:none;"></div>
<script type="text/javascript" src="http://ditu.google.cn/maps?file=api&v=2.95&sensor=false&key=<?=Yii::app()->params['google_map_key']?>"></script>
<script type="text/javascript" src="http://www.google.com/uds/api?file=uds.js&v=1.0&key=<?=Yii::app()->params['google_map_key']?>"></script>
<script type="text/javascript" src="http://www.google.com/uds/solutions/localsearch/gmlocalsearch.js"></script>
</body>
</html>