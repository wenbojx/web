<style>
.uploadify-queue{
    float:left;
}
.uploadify{
    float:left;
}
</style>
<div class="panel_box_content" id="panel_music">
    <div class="panel_title">
        <div class="title-bar">
            <span>设置背景音乐 -- 最大5M</span>
        </div>
        <div class="panel_close" onclick="hide_edit_panel()">X</div>
    </div>
    <div class="panle_content" style="height:240px;width:280px;">
    <form method="post" class="form-horizontal" id="save_music" action="<?=$this->createUrl('/salado/modules/music/save/')?>">
    	<div>
    	<span class="label label-warning" id="music_box_upload"></span>
    	
    	</div>
    	<div class="clear"></div>
    	<div>
    		<p id="curent_music" style="display:<?=$datas['music']['file_name']?'':'none'?>">当前音乐:<?=$datas['music']['file_name']?></p>
    		<p>
    		
    		<input type="hidden" id="music_file_id" name="file_id" value="<?=$datas['music']['file_id']?>">
    		<input type="hidden" id="music_id" name="music_id" value="<?=$datas['music']['id']?>">
    		设置音量:
    		<select name="volume" id="volume" class="form_dom_width_100">
    			<option value="0.1" <?=$datas['music']['volume']=='1'?'selected="selected"':''?>>0.1</option>
    			<option value="0.2" <?=$datas['music']['volume']=='2'?'selected="selected"':''?>>0.2</option>
    			<option value="0.3" <?=$datas['music']['volume']=='3'?'selected="selected"':''?>>0.3</option>
    			<option value="0.4" <?=$datas['music']['volume']=='4'?'selected="selected"':''?>>0.4</option>
    			<option value="0.5" <?=$datas['music']['volume']=='5'?'selected="selected"':''?>>0.5</option>
    			<option value="0.6" <?=$datas['music']['volume']=='6'?'selected="selected"':''?>>0.6</option>
    			<option value="0.7" <?=$datas['music']['volume']=='7'?'selected="selected"':''?>>0.7</option>
    			<option value="0.8" <?=$datas['music']['volume']=='8'?'selected="selected"':''?>>0.8</option>
    			<option value="0.9" <?=$datas['music']['volume']=='9'?'selected="selected"':''?>>0.9</option>
    			<option value="1.0" <?=$datas['music']['volume']=='10'?'selected="selected"':''?>>1.0</option>
    		</select>
    		</p>
    		<p>循环播放:
    			<select name="loop" id="loop" class="form_dom_width_100">
    				<option value="0" <?=$datas['music']['loop']=='0'?'selected="selected"':''?>>不循环</option>
    				<option value="1" <?=$datas['music']['loop']=='1'?'selected="selected"':''?>>循环</option>
    			</select>
    		</p>
    		<p>取消音乐:
    			<select name="state" id="music_state" class="form_dom_width_100">
    				<option value="1" <?=$datas['music']['state']=='1'?'selected="selected"':''?>>不取消</option>
    				<option value="0" <?=$datas['music']['state']=='0'?'selected="selected"':''?>>取消</option>
    			</select>
    		</p>
    	</div>
        <div>
            <button type="button" onclick="save_music_detail(<?=$datas['scene_id']?>)" class="btn btn-primary">保存</button>
            <span id="save_music_tip_flag"></span>
        </div>
    </form>
    </div>
</div>
<script>
var scene_id = '<?=$datas['scene_id']?>';
var project_id = '<?=$datas['project_id']?>';
var music_button_img = "<?=Yii::app()->baseUrl?>/style/img/pano_upload_bt.gif";
var music_upload_url='<?=$this->createUrl('/pano/upload/')?>';

music_box_upload();
</script>