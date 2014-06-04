<?php $this->pageTitle=$datas['page_title'].'---足不出户，畅游中国';?>
<div class="detail">
    <div class="hero-unit margin-top55">
        <h2>简单，易用</h2>
    </div>
    <ul class="breadcrumb">
        <li><?php echo CHtml::link('项目',array('pano/project/list'));?> <span class="divider">/</span></li>
        <li><?php echo CHtml::link('场景',array('pano/scene/list', 'id'=>$datas['pano']['project_id']));?><span class="divider">/</span></li>
        <li class="active"><?=$datas['pano']['name']?></li>
    </ul>
    <div class="row-fluid">
        <div class="span11">
            <div class="thumbnail">
                    <div class="pano-detail" id="pano-detail">
                        <div id="scene_box"></div>
                        <div id="pano_loading" class="pano_loading">
	                    	<img id="pano_loading_img" src="<?=Yii::app()->baseUrl . '/style/img/loading_4.gif'?>"/>
	                    </div>
                        <div id="hotspot_icon" class="hotspot_icon">
                        	<img id="hotspot_icon_img" src="<?=Yii::app()->baseUrl . '/style/img/hotspot/hotspot-10.png'?>"/>
                        </div>
                        <div id="imagehotspot_icon" class="hotspot_icon">
                        	<img id="hotspot_icon_img" src="<?=Yii::app()->baseUrl . '/style/img/imghotspot.png'?>"/>
                        </div>
                        <div id="compass_icon" class="hotspot_icon">
                        	<img id="compass_icon_img" src="<?=Yii::app()->baseUrl . '/style/img/compass.png'?>"/>
                        </div>
                    </div>
            </div>
        </div>
        <div class="span1">
            <div class="thumbnail">
                <div class="edit_box">
                    <div class="edit_relative">
                        <div class="edit_buttons">
                            <button class="btn btn-success" id="btn_review">刷新</button>
                            <button class="btn" id="btn_upload">上传</button>
                            <!-- <button class="btn" id="btn_position">位置</button> -->
                            <button class="btn" id="btn_thumb">缩略</button>
                            <button class="btn" id="btn_map">地图</button>
                            <button class="btn" id="btn_position">位置</button>
                            <button class="btn" id="btn_compass">方位</button>
                            <button class="btn" id="btn_camera">摄像</button>
                            <button class="btn" id="btn_perspect">视角</button>
                            <!-- <button class="btn">视角</button> -->
                            <button class="btn" id="btn_hotspot">热点</button>
                            <!-- <button class="btn" id="btn_image">图片</button> -->
                            <button class="btn" id="btn_music">音乐</button>
                            <!-- <button class="btn">按钮</button>
                            <button class="btn">导航</button> -->
                            
                        	<button class="btn btn-primary" id="btn_preview">预览</button>
                        	<!-- <button class="btn btn-primary" id="btn_pad">隐藏</button> -->
                        	<br><br><br>
                        	<button id="online_pano" class="btn btn-warning" style="<?=$datas['pano']['display'] == '1'?'':'display:none' ?>" onclick="publish_scene(<?=$datas['pano']['id']?>,2)">发布</button>
                            <button id="offline_pano" class="btn btn-warning" style="<?=$datas['pano']['display'] == '2'?'':'display:none' ?>" onclick="publish_scene(<?=$datas['pano']['id']?>,1)">下线</button>
                        </div>
                        <div class="edit_panel" id="edit_panel">
                            <div id="panel_box" class="panel_box">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="clear"></div>
<script>
var scene_id = '<?=$datas['pano']['id']?>';
var baseUrl = '<?=Yii::app()->baseUrl?>';
var clean_url = '<?=$this->createUrl('/pano/salado/edit/', array('id'=>$datas['pano']['id'], 'clean'=>1))?>';
var clean_single_url = '<?=$this->createUrl('/ajax/cacheclean/a/')?>';
var flash_url = baseUrl+'/pages/uploadify/uploadify.swf';
var session_id = '<?=session_id()?>';
var pic_url = '<?=$this->createUrl('/panos/imgOut/index/')?>';
var google_map_tip_url = baseUrl+'/style/img/dot-s-nomarl_16x24.png';
var save_module_datas_url = '<?=$this->createUrl('/salado/modules/')?>';
var preview_url = '<?=$this->createUrl('/web/single/a/', array('id'=>$datas['pano']['id'], 'clean'=>1))?>';

var scene_publish_url = '<?=$this->createUrl('/pano/scene/publish')?>';
</script>

<script type="text/javascript" src="<?=Yii::app()->baseUrl . "/style/js/common.js"?>"></script>
<script type="text/javascript" src="<?=Yii::app()->baseUrl . "/plugins/salado/scene.js"?>"></script>

<script>
var player_url = '<?=Yii::app()->baseUrl?>/plugins/salado/Player.swf';
var scene_xml_url = '<?=$this->createUrl('/salado/index/a/', array('id'=>$datas['pano']['id'],'from'=>'admin'))?>';
load_scene('scene_box', scene_xml_url, player_url, 'transparent');

var upload_pano_url = '<?=$this->createUrl('/pano/config/v/', array('t'=>'face', 'scene_id'=>$datas['pano']['id']))?>';
var position_url = '<?=$this->createUrl('/pano/config/v/', array('t'=>'position', 'scene_id'=>$datas['pano']['id']))?>';
//var preview_url = '<?=$this->createUrl('/pano/config/v/', array('t'=>'preview', 'scene_id'=>$datas['pano']['id']))?>';
var thumb_url = '<?=$this->createUrl('/pano/config/v/', array('t'=>'thumb', 'scene_id'=>$datas['pano']['id']))?>';
var compass_url = '<?=$this->createUrl('/pano/config/v/', array('t'=>'compass', 'scene_id'=>$datas['pano']['id']))?>';
var camera_url = '<?=$this->createUrl('/pano/config/v/', array('t'=>'camera', 'scene_id'=>$datas['pano']['id']))?>';
var perspect_url = '<?=$this->createUrl('/pano/config/v/', array('t'=>'perspect', 'scene_id'=>$datas['pano']['id']))?>';
var map_url = '<?=$this->createUrl('/pano/config/v/', array('t'=>'map', 'scene_id'=>$datas['pano']['id'],  'project_id'=>$datas['pano']['project_id']))?>';
var hotspot_url = '<?=$this->createUrl('/pano/config/v/', array('t'=>'hotspot', 'scene_id'=>$datas['pano']['id']))?>';
var image_url = '<?=$this->createUrl('/pano/config/v/', array('t'=>'image', 'scene_id'=>$datas['pano']['id']))?>';
var music_url = '<?=$this->createUrl('/pano/config/v/', array('t'=>'music', 'scene_id'=>$datas['pano']['id']))?>';
var hotspot_edit_url = '<?=$this->createUrl('/pano/config/v/', array('t'=>'hotspotEdit', 'scene_id'=>$datas['pano']['id']))?>';
var imghotspot_edit_url = '<?=$this->createUrl('/pano/config/v/', array('t'=>'imageEdit', 'scene_id'=>$datas['pano']['id']))?>';
</script>

<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
<script type="text/javascript" src="<?=Yii::app()->baseUrl . "/plugins/gmaps/gmaps.js"?>"></script>
