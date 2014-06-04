<?php header("Content-type: text/xml");?>
<?php echo '<?xml version="1.0" encoding="utf-8" ?>';?>
<?php echo '<Image TileSize="'.$datas['tileSize'].'" Overlap="1"  Format="jpg" ServerFormat="Default" xmnls="http://schemas.microsoft.com/deepzoom/2009">
<Size Width="'.$datas['imgSize'].'" Height="'.$datas['imgSize'].'" />
</Image>';?>