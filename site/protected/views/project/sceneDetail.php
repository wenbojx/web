<div id="js_cantain_box" class="col-main">
        <div style="z-index:9998;" class="directory-path">
                <div rel="page_local" class="path-contents">
                    <?php echo CHtml::link('项目',array('project/projectList'));?>
                    <i>»</i>
                    <?php echo CHtml::link('场景',array('project/SceneList/list/', 'id'=>$datas['pano']['project_id']));?>
                    <i>»</i>
                    <a title="<?=$datas['name']?>" href="javascript:;"><?=$datas['name']?></a>
                    <em>&nbsp;</em>
                </div>
                <div id="js_fileter_box" class="list-filter">
                    <ul>
                    </ul>
                </div>
        </div>
        <div id="js_data_list_outer" class="page-detail">
            <div id="scene_box" class="scene_box"></div>
            <div id="detail-hotspot" class="detail-hotspot"></div>
            <div id="detail-hotspot-tip" class="pano-detail-tip">
                <div id="detail-hotspot-info">
                    pan: <span id="hotspot_info_pan">0</span>
                    tilt: <span id="hotspot_info_tilt">0</span>
                    fov: <span id="hotspot_info_fov"></span>
                </div>
                <div>将需要放置热点的位置拖动到全景图中间的图标位置</div>
                <div>
                    <a class="scene_detail_save" id="scene_conf_hotspot_btn" href="javascript:">新增热点</a>

                </div>
            </div>
            <div id="detail-pano-camera" class="pano-detail-tip">
                <div id="detail-camera-info">
                    pan: <span id="camera-info-pan"></span>
                    tilt: <span id="camera-info-tilt"></span>
                    fov: <span id="camera-info-fov"></span>
                </div>
                <div>旋转全景图至你需要的位置，并调整摄像机视角</div>
                <div>
                    <a class="scene_detail_save" href="javascript:" onclick="save_camera_detail(<?=$datas['id']?>)">保存摄像机信息</a>
                    <span id="camera_save_msg"></span>
                </div>
            </div>
        </div>

        <div class="page-footer"></div>

    </div>
    <div class="col-sub">
        <div style="text-align:center; margin:10px 0 0 0;">
            <a onclick="loadModalWin('showmodel','<?=$this->createUrl('/project/scene/uploadPhoto/show/', array('scene_id'=>$datas['id']))?>', '上传全景图', 605, 450)" style="" class="button btn-orange" href="javascript:;">上传全景图</a>
        </div>
        <div style="width:120px; text-align:center; margin:10px auto">
            <a id="scene_conf_positon" style="" title="定位" class="button btn-gray" href="javascript:;">位</a>
            <a id="scene_conf_thumb" style="" title="缩略图" class="button btn-gray" href="javascript:;">缩</a>
            <!-- <a id="scene_conf_basic" style="" title="尺寸" class="button btn-gray" href="javascript:;">尺</a> -->
            <!-- <a id="scene_conf_preview" style="" title="预览图" class="button btn-gray" href="javascript:;">览</a> -->
            <a id="scene_conf_camera" style="" title="摄像机" class="button btn-gray" href="javascript:;">摄</a>
            <a id="scene_conf_hotspot" style="" title="热点" class="button btn-gray" href="javascript:;">热</a>
            <a id="scene_conf_button" style="" title="按钮" class="button btn-gray" href="javascript:;">按</a>
            <a id="scene_conf_navigat" style="" title="导航" class="button btn-gray" href="javascript:;">导</a>

            <a id="scene_conf_map" style="" title="地图" class="button btn-gray" href="javascript:;">图</a>

            <!-- <a id="scene_conf_radar" style="" title="雷达" class="button btn-gray" href="javascript:;">眩</a>
            <a id="scene_conf_html" style="" title="Html" class="button btn-gray" href="javascript:;">链</a>
            <a id="scene_conf_rightkey" style="" title="右键" class="button btn-gray" href="javascript:;">方</a>
            <a id="scene_conf_link" style="" title="场景链接" class="button btn-gray" href="javascript:;">方</a>
            <a id="scene_conf_flare" style="" title="眩光" class="button btn-gray" href="javascript:;">方</a>
            <a id="scene_conf_action" style="" title="定义方法" class="button btn-gray" href="javascript:;">方</a> -->
        </div>
        <div style="text-align:center; margin:10px 0 0 0;">
            <a onclick="location.reload()" class="button btn-orange" href="javascript:;">预         览</a>

        </div>
        <div style="text-align:center; margin:10px 0 0 0;">
            <a onclick="publish_scene(<?=$datas['id']?>,2)" class="button btn-orange" href="javascript:;">发布</a>
            <a onclick="publish_scene(<?=$datas['id']?>,1)" class="button btn-orange" href="javascript:;">下线</a>
            <br><span id="publish_scene_msg"></span>
    </div>
<script type="text/javascript">
var player_url = baseUrl+'/pages/salado/Player.swf';
var scene_xml_url = '<?=$this->createUrl('/salado/index/a/', array('id'=>$datas['id'], 'from'=>'admin'))?>';
var id = 'scene_box';
load_scene(id, scene_xml_url, player_url, 'transparent');
var position_url = '<?=$this->createUrl('/project/scene/config/v/', array('t'=>'position', 'scene_id'=>$datas['id']))?>';
var basic_url = '<?=$this->createUrl('/project/scene/config/v/', array('t'=>'basic', 'scene_id'=>$datas['id']))?>';
var preview_url = '<?=$this->createUrl('/project/scene/config/v/', array('t'=>'preview', 'scene_id'=>$datas['id']))?>';
var thumb_url = '<?=$this->createUrl('/project/scene/config/v/', array('t'=>'thumb', 'scene_id'=>$datas['id']))?>';
//var view_url = '<?=$this->createUrl('/project/scene/config/v/', array('t'=>'view', 'scene_id'=>$datas['id']))?>';
var hotspot_url = '<?=$this->createUrl('/project/scene/config/v/', array('t'=>'hotspot', 'scene_id'=>$datas['id']))?>';
var button_url = '<?=$this->createUrl('/project/scene/config/v/', array('t'=>'button', 'scene_id'=>$datas['id']))?>';
var map_url = '<?=$this->createUrl('/project/scene/config/v/', array('t'=>'map', 'scene_id'=>$datas['id']))?>';
var navigat_url = '<?=$this->createUrl('/project/scene/config/v/', array('t'=>'navigat', 'scene_id'=>$datas['id']))?>';
var radar_url = '<?=$this->createUrl('/project/scene/config/v/', array('t'=>'radar', 'scene_id'=>$datas['id']))?>';
var html_url = '<?=$this->createUrl('/project/scene/config/v/', array('t'=>'html', 'scene_id'=>$datas['id']))?>';
var rightkey_url = '<?=$this->createUrl('/project/scene/config/v/', array('t'=>'rightkey', 'scene_id'=>$datas['id']))?>';
var link_url = '<?=$this->createUrl('/project/scene/config/v/', array('t'=>'link', 'scene_id'=>$datas['id']))?>';
var flare_url = '<?=$this->createUrl('/project/scene/config/v/', array('t'=>'flare', 'scene_id'=>$datas['id']))?>';
var action_url = '<?=$this->createUrl('/project/scene/config/v/', array('t'=>'action', 'scene_id'=>$datas['id']))?>';
bind_scene_btn();
</script>
<div id="showmodel_positon" style="display: none"></div>
<div id="showmodel_basic" style="display: none"></div>
<div id="showmodel_preview" style="display: none"></div>
<div id="showmodel_thumb" style="display: none"></div>
<div id="showmodel_view" style="display: none"></div>
<div id="showmodel_hotspot" style="display: none"></div>
<div id="showmodel_button" style="display: none"></div>
<div id="showmodel_map" style="display: none"></div>
<div id="showmodel_navigat" style="display: none"></div>
<div id="showmodel_radar" style="display: none"></div>
<div id="showmodel_html" style="display: none"></div>
<div id="showmodel_rightkey" style="display: none"></div>
<div id="showmodel_link" style="display: none"></div>
<div id="showmodel_flare" style="display: none"></div>
<div id="showmodel_action" style="display: none"></div>



