<?php $this->pageTitle=$datas['project']['name'].'，全景，三维，上海';?>
<?php $flag = $datas['map']['map']? true:false;?>
<div class="detail">
    <div class="hero-unit margin-top55">
        <div class="banner_box">
			<h2>拖动图片，开始体验</h2>
			<div class="r_index">
			<a style="color:#0088CC;" href="/">返回首页</a>
			</div>
		</div>
    </div>
    <div class="row-fluid">
        <div class="span12" style="width:900px; margin:0 20px">
            <div class="thumbnail">
                <div class="pano-detail" id="pano-detail" style="height:520px;">
                	<div id="scene_box"></div>
                	<div id="pano_loading" class="pano_loading">
                    	<img id="pano_loading_img" src="<?=Yii::app()->baseUrl . '/style/img/loading_4.gif'?>"/>
                    </div>
                    <div id="hotspot_loading" class="hotspot_loading">
                    	<img id="hotspot_loading_img" src="<?=Yii::app()->baseUrl . '/style/img/loading_5.gif'?>"/>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="row-fluid margin-top10">
        <div class="span10">
        <h3><!-- 足迹： --></h3>
        <div id="editor">
        </div>
        </div>
        <div class="span2">
        </div>
    </div>
</div>
<script type="text/javascript">
var page_url = '<?=$this->createUrl('/web/detail/a/');?>'
var scene_id = '<?=$datas['scene_id']?>';
var box_marker = 'marker_map';
</script>
<script type="text/javascript" src="<?=Yii::app()->baseUrl . "/style/js/common.js"?>"></script>
<script type="text/javascript" src="<?=Yii::app()->baseUrl . "/plugins/salado/scene.js"?>"></script>
<script type="text/javascript" src="<?=Yii::app()->baseUrl . "/plugins/craftmap/js/craftmap.js"?>"></script>
<script type="text/javascript" src="<?=Yii::app()->baseUrl . "/plugins/craftmap/js/map.js"?>"></script>
<script >
var scene_box = 'scene_box';
var player_url = '<?=Yii::app()->baseUrl?>/plugins/salado/Player.swf';
var scene_xml_url = '<?=$this->createUrl('/salado/index/a/', array('id'=>$datas['scene_id']))?>';
load_scene(scene_box, scene_xml_url, player_url, 'transparent');
<?php if($flag){?>
map_width = '<?=$datas['map']['map']['width']?>';
map_height = '<?=$datas['map']['map']['height']?>';

bind_map(box_marker, true);
<?php }?>
</script>

