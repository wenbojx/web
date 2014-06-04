<div class="panel_box_content" id="panel_hotspot">
	<div class="panel_title">
		<div class="title-bar">
			<span>热点</span>
			<div class="title_tip">
				pan：<span id="hotspot_info_pan">0</span>
				tilt：<span id="hotspot_info_tilt">0</span>&nbsp;
				fov：<span id="hotspot_info_fov">90</span>&nbsp;
			</div>
		</div>
		<div class="panel_close" onclick="hide_edit_panel();hide_hotspot_icon()">X</div>
	</div>
	<div class="panle_content" style="height:220px;width:250px;">
	<div class="panel_form">
	<form method="post" class="form-horizontal" id="save_hotspot" action="<?=$this->createUrl('/salado/modules/hotspot/save/')?>">
		<div class="control-group">
            <label for="hotspot_info_d_type" class="control-label">热点类型</label>
            <div class="controls" >
              	<select name="type" id="hotspot_info_d_type">
              		<option value="2" selected="selected">swf</option>
	                <!-- <option value="1">image</option>
	                <option value="3">video</option> -->
	            </select>
            </div>
          </div>
          <div class="control-group">
            <label for="hotspot_info_d_link_scene_id" class="control-label">场景列表</label>
            <div class="controls">
              	<select name="link_scene_id" id="hotspot_info_d_link_scene_id" onchange="change_hotspot_select()">
	            	<option value="0">选择场景</option>
	                <?php if($datas['link_scene']){ foreach($datas['link_scene'] as $v){?>
	                <option value="<?=$v['id']?>"><?=$v['name']?></option>
	                <?php }}?>
	            </select>
	            
            </div>
          </div>
          <div class="hotspot_save_btn">
	        <table width="220">
		        <tr>
		        <td>
				<select onclick="change_hotspot_angle()" id="hotspot_angle_select" class="hotspot_angle_select">
                <option value="10">正上方</option>
                <option value="11">右上方</option>
                <option value="12">正右方</option>
                <option value="13">右下方</option>
                <option value="14">正下方</option>
                <option value="15">左下方</option>
                <option value="16">正左方</option>
                <option value="17">左上方</option>
              </select>
				&nbsp;
				<img id="hotspot_angle" src="<?=Yii::app()->baseUrl . '/style/img/hotspot/hotspot-10.png'?>"/>	    
	          	</td>
	          	<td align="right">
		          	<button type="button" onclick="save_hotspot_detail(<?=$datas['scene_id']?>)" class="btn btn-primary">新增热点</button>
		          	<span id="save_hotspot_tip_flag"></span>
			      </td>
			      </tr>
		      </table>
          </div>
	    	<img src="<?=Yii::app()->baseUrl . '/style/img/thumb_default.jpg'?>" id="hotspot_pano_thumb" width="200" height="100">
		</form>
		</div>
	</div>
</div>
<script>
var hotspot_img_pre = '<?=Yii::app()->baseUrl . '/style/img/hotspot/'?>';
var size = '200x100.jpg';
var pano_thumb_url_array = {};
<?php if($datas['link_scene']){ foreach($datas['link_scene'] as $v){?>
pano_thumb_url_array[<?=$v['id']?>] = '<?php echo PicTools::get_pano_small($v['id'], '200x100');?>';
<?php }}?>
</script>


