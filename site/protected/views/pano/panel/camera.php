<div class="panel_box_content" id="panel_camera">
    <div class="panel_title">
        <div class="title-bar">
            <span>初始摄像机</span>
        </div>
        <div class="panel_close" onclick="hide_edit_panel()">X</div>
    </div>
    <div class="panle_content" style="height:110px;width:240px;">
            <p style="text-align: left">
                    pan: <span id="camera-info-pan"><?=$datas['camera']['pan']?></span>
                    tilt: <span id="camera-info-tilt"><?=$datas['camera']['tilt']?></span>
                    fov: <span id="camera-info-fov"><?=$datas['camera']['fov']?></span>
            </p>
            <p style="text-align: left">调整摄像机初始位置及焦距</p>
           
        <div>
            <button type="button" onclick="save_camera_detail(<?=$datas['scene_id']?>)" class="btn btn-primary">保存摄像机</button>
            <span id="save_camera_tip_flag"></span>
        </div>
    </div>
</div>