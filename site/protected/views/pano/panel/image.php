<div class="panel_box_content" id="panel_image">
	<div class="panel_title">
		<div class="title-bar">
			<span>热点图片</span>
			<div class="title_tip">
				pan：<span id="imghotspot_info_pan">0</span>
				tilt：<span id="imghotspot_info_tilt">0</span>&nbsp;
				fov：<span id="imghotspot_info_fov">90</span>&nbsp;
			</div>
		</div>
		<div class="panel_close" onclick="hide_edit_panel();hide_hotspot_icon()">X</div>
	</div>
	<div class="panle_content" style="height:300px;width:350px;">
		<form method="post" class="form-horizontal" id="save_image_form" action="<?=$this->createUrl('/salado/modules/image/save/')?>">
		<input type="hidden" id="image_file_id" value="" />
		<div>
			<div>
				<table width="100%">
					<tr>
						<td align="left"><span class="label label-warning" id="image_box_upload"></span></td>
						<td align="right" valign="top">
						<div style="display:none" id="save_image_button_box">
						<button type="button" class="btn btn-primary" onclick="save_image_info()">保存信息</button>
						</div>
						</td>
					</tr>
				</table>
        	</div>
        	<div id="image_container"></div>
        </div>
        </form>
	</div>
</div>
<script>
var scene_id = '<?=$datas['scene_id']?>';
var project_id = '<?=$datas['project_id']?>';
var image_button_img = "<?=Yii::app()->baseUrl?>/style/img/image_upload_img.gif";
var image_upload_url='<?=$this->createUrl('/pano/upload/')?>';

image_box_upload();

</script>

