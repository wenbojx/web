<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/style/css/bootstrap.css"); ?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/style/css/style.css"); ?>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/style/js/jquery.min.js");?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/style/js/bootstrap.min.js");?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/style/js/core.js");?>
<title><?=$this->pageTitle?></title>
</head>
<body style="background-image: url(<?=Yii::app()->baseUrl . "/style/img/single_bg.png"?>);">
<?php echo $content;?>
</body>
</html>