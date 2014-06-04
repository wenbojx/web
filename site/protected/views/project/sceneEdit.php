<div>
	<div class="input-box">
		<li><span>场景名称：</span></li>
		<li>
			<input name="project_id" type="hidden" value="<?=$project_id?>" id="project_id">
    		<input name="name" type="text" tabindex="1" id="scene_name">
    	</li>
    	<li><span>场景简介：</span></li>
    	<li>
    		<textarea tabindex="2" name="desc" id="scene_desc" style="height:80px;"></textarea>
    	</li>
    	<li><span>拍摄时间：</span></li>
    	<li>
    		<input type="text" name="photo_time" tabindex="3" id="scene_photo_time">
    	</li>
    	<li>
    		<a style="" class="button" href="javascript:;" onclick="save_scene('<?=$this->createUrl('/project/SceneEdit/DoAdd')?>')">保  存</a>
    	</li>
    	<li><span id="save_scene_msg"></span></li>
    </div>
</div>