<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/pages/css/common.css"); ?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/pages/css/page.css"); ?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/pages/css/boxy.css"); ?>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/pages/js/jquery172.min.js");?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/pages/js/jquery.boxy.js");?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/pages/js/core.js");?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/pages/js/salado.admin.js");?>
<title>content</title>
</head>
<body>
<div class="container">
<?php echo $content;?>
</div>
</body>
</html>