<div style="width:1024px;height:600px;margin:0 auto">
<br>
<h3><?=$datas['scene_datas']['name']?></h3>

	<div id="scene_box" ></div>
</div>
<script>

var scene_xml_url = '<?=$this->createUrl('/salado/index/a/', array('id'=>$datas['scene_id']))?>';
load_scene('scene_box', scene_xml_url, player_url)
</script>