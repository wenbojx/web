<?php header("Content-type: image/{$datas['pic_type']}"); ?>
<?php header("Cache-Control: max-age=315360000"); ?>
<?php header("Age: 1"); ?>
<?php echo $datas['pic_content']; ?>