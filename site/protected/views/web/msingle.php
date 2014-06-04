<?php $this->pageTitle=$datas['scene']['name'].'，全景，三维，上海';?>
<?php $flag = $datas['map']['map']? true:false;?>
<script
	type="text/javascript"
	src="<?=Yii::app()->baseUrl . "/plugins/html5/player/player.js"?>"></script>
<script
	type="text/javascript"
	src="<?=Yii::app()->baseUrl . "/plugins/html5/player/skin.js"?>"></script>
<script
	type="text/javascript"
	src="<?=Yii::app()->baseUrl . "/plugins/html5/player/setting.js"?>"></script>
<div id="container" style="width: 100%; height: 100%;">This content
	
</div>
<div id="mapTip" class="mapTip" style="display:<?=$datas['map_flag']?'none':'block'?>">
	<img width="60" onclick="showMap()" src="<?=PicTools::get_pano_map($datas['project']['id'], $datas['map']['map']['id'])?>">
</div>
<div id="scroll_map" class="scroll_map" style="display:<?=$datas['map_flag']?'block':'none'?>">
	<div class="marker_map" id="marker_map">
		<?php if($flag){?>
		<img
			src="<?=PicTools::get_pano_map($datas['project']['id'], $datas['map']['map']['id'])?>"
			class="imgMap" />
		<?php }?>
		<?php if($datas['map']['position']){
foreach($datas['map']['position'] as $v){?>
		<div title="<?=$datas['map']['link_scenes'][$v['scene_id']]['name']?>"
			class="marker" id="markers_<?=$v['scene_id']?>_<?=$v['id']?>"
			data-coords="<?=$v['left']?>,<?=$v['top']?>">
			<h3>
				<?=$datas['map']['link_scenes'][$v['scene_id']]['name']?>
			</h3>
		</div>
		<?php }
}?>
	</div>
	<div style="text-align:center">
	<button onclick='showMap()'>关 闭</button>
	</div>
</div>
<script>
var mobile = true;
</script>
<script type="text/javascript" src="<?=Yii::app()->baseUrl . "/style/js/core.js"?>"></script>
<script type="text/javascript" src="<?=Yii::app()->baseUrl . "/style/js/jquery.min.js"?>"></script>
<script type="text/javascript" src="<?=Yii::app()->baseUrl . "/plugins/craftmap/js/craftmap.js"?>"></script>
<script type="text/javascript" src="<?=Yii::app()->baseUrl . "/plugins/craftmap/js/map.js"?>"></script>
<script >

//alert($('#titleTip', parent.document).html());

function move_to_marker_player(id){
	var datas = id.split("_");
	sid = datas[1];
	move_to_marker(sid);
}
function showMap(){
	if($("#scroll_map").is(":hidden")){
		$("#mapTip").hide();
		$("#scroll_map").show();
		
	}
	else{
		$("#mapTip").show();
		$("#scroll_map").hide();
	}
}
var scene_id = '<?=$datas['scene_id']?>';
<?php if($flag){?>
var page_url = '';
map_width = '<?=$datas['map']['map']['width']?>';
map_height = '<?=$datas['map']['map']['height']?>';
var box_marker = 'marker_map';

bind_map(box_marker, false);
move_to_marker(scene_id);
<?php }?>
</script>

<script type="text/javascript">

			// create the panorama player with the container
			pano=new pano2vrPlayer("container");
			// add the skin object
			skin=new pano2vrSkin(pano,'/plugins/html5/');
			// load the configuration
			pano.readConfigUrl("config.xml");
			// hide the URL bar on the iPhone
			hideUrlBar();
			// add gyroscope controller
			gyro=new pano2vrGyro(pano,"container");
		</script>
<noscript>
	<p>
		<b>您的浏览器不支持js</b>
	</p>
</noscript>
-->
