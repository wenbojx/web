<div class="panel_box_content" id="panel_perspect">
    <div class="panel_title">
        <div class="title-bar">
            <span>设置摄像机视角</span>
        </div>
        <div class="panel_close" onclick="hide_edit_panel()">X</div>
    </div>
    <div class="panle_content" style="height:150px;width:280px;">
            <p style="text-align: left">
                    pan: <span id="perspect-info-pan"><?=$datas['camera']['pan']?></span>
                    tilt: <span id="perspect-info-tilt"><?=$datas['camera']['tilt']?></span>
            </p>
        <div>
        	水平(pan): 
        	<input type="text" name="maxPan", id="maxPan" value="<?=$datas['perspect']['maxPan']?$datas['perspect']['maxPan']:'180'?>" style="width:50px;">(0,180) - 
        	<input type="text" name="minPan", id="minPan" value="<?=$datas['perspect']['minPan']?$datas['perspect']['minPan']:'-180'?>" style="width:50px;">(0,-180)<br>
        	垂直(tilt): 
        	<input type="text" name="maxTilt", id="maxTilt" value="<?=$datas['perspect']['maxTilt']?$datas['perspect']['maxTilt']:'90'?>" style="width:50px;">(0,90) - 
        	<input type="text" name="minTilt", id="minTilt" value="<?=$datas['perspect']['minTilt']?$datas['perspect']['minTilt']:'-90'?>" style="width:50px;">(0,-90)
        	<br>
            <button type="button" onclick="save_perspect_detail(<?=$datas['scene_id']?>)" class="btn btn-primary">保存视角信息</button>
            <span id="save_perspect_tip_flag"></span>
        </div>
    </div>
</div>