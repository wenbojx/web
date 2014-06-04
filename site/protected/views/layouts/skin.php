<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/style/skin/style.css"); ?>
 <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/style/js/jquery.min.js");?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/style/skin/jquery-ui-1.10.2.custom.min.js");?>

<title>main</title>
</head>
<body>

<?php echo $content;?>
</body>
</html>