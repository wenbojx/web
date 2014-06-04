<div class="panel_box_content" id="panel_compass">
    <div class="panel_title">
        <div class="title-bar">
            <span>设置方位角</span>
        </div>
        <div class="panel_close" onclick="hide_edit_panel()">X</div>
    </div>
    <div class="panle_content" style="height:100px;width:200px;">
            <p style="text-align: left">
                    pan: <span id="compass-info-pan"><?=$datas['compass']['pan']?$datas['compass']['pan']:0?></span>
                    
            </p>
            <p style="text-align: left">设定全景图的方位角，拖动图片指到地图上方的方向</p>
        <div>
            <button type="button" onclick="save_compass_detail(<?=$datas['scene_id']?>)" class="btn btn-primary">保存方位</button>
            <span id="save_compass_tip_flag"></span>
        </div>
    </div>
</div>