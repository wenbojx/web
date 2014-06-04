<style>
.uploadify-queue{
    float:left;
}
.uploadify{
    float:left;
}
</style>
<div class="panel_box_content" id="panel_thumb" style="height:365px;width:575px;">
    <div class="panel_title">
        <div class="title-bar">
            <span>缩略图</span>
            <!-- <div class="title_tip">
                <span class="label label-warning" id="thumb_box_upload"></span>
                200x100
            </div> -->
        </div>
        <div class="panel_close" onclick="hide_edit_panel()">X</div>
    </div>
    <div class="panle_content">
    <?php if( $datas['file_id'] ){ ?>
        <div id="thumb_upload"  class="pano_small_thumb">
        	
        	<div id="cut_div" style="width:554px; height:266px; overflow:hidden; position:relative; top:0px; left:0px; margin:4px 0 0 0px; cursor:pointer;">
				 <table style="border-collapse: collapse; z-index: 10; filter: alpha(opacity=75); position: relative; left: 0px; top: 0px; width: 560px;  height: 266px; opacity: 0.75;" unselectable="on" border="0" cellpadding="0" cellspacing="0">
				 <tbody><tr>
				   <td style="background: #cccccc; height: 76px;" colspan="3"></td>
				 </tr>
				 <tr>
				   <td style="background: #cccccc; width: 202px;"></td>
				   <td style="border: 1px solid #ffffff; width: 150px; height:112px;"></td>
				   <td style="background: #cccccc; width: 202px;"></td>
				 </tr>
				 <tr>
				   <td style="background: #cccccc; height: 70px;" colspan="3"></td>
				 </tr>
				 </tbody></table>
				 <img id="cut_img" style="position: absolute; top: 1px; left: 6px;" src="<?=PicTools::get_pano_small($datas['scene_id'], '1024x512')?>" height="270" width="540">
			
			</div>
			
			<div align="center">
				<img class="img_track_left"  src="<?=Yii::app()->baseUrl?>/style/img/cutthumb/_h.gif" alt="图片缩小" onmouseover="this.src='<?=Yii::app()->baseUrl?>/style/img/cutthumb/_c.gif'" onmouseout="this.src='<?=Yii::app()->baseUrl?>/style/img/cutthumb/_h.gif'" onclick="imageresize(false)">
				<img id="img_track" class="img_track"  src="<?=Yii::app()->baseUrl?>/style/img/cutthumb/track.gif"></td>
				<img class="img_track_right" src="<?=Yii::app()->baseUrl?>/style/img/cutthumb/h.gif" alt="图片放大" onmouseover="this.src='<?=Yii::app()->baseUrl?>/style/img/cutthumb/c.gif'" onmouseout="this.src='<?=Yii::app()->baseUrl?>/style/img/cutthumb/h.gif'" onclick="imageresize(true)">
				 <img id="thumb_pic"  class="thumb_img"  src="<?=PicTools::get_pano_thumb($datas['scene_id'], '150x110')?>">
				<img id="img_grip" style="position: absolute; z-index: 100; left: 906.642px; top: 560px; cursor: pointer;" src="<?=Yii::app()->baseUrl?>/style/img/cutthumb/grip.gif"> 
			</div>
			
			<div style="padding-top:30px; padding-left:5px;" align="center">
				<input name="recommend"  id="recommend" type="checkbox" value="1"  <?=$datas['thumb_info']['recommend']=='1' ? 'checked' : ''?>> 选为项目缩略图&nbsp;&nbsp;&nbsp;&nbsp;
				<input value=" 保存缩略图" class="up_submit" type="button"  onclick="save_thumb_datas()">
				<input name="cut_pos" id="cut_pos" value="" type="hidden">
			</div>
        </div>
        <?php } else {?>
        <div class="pano_small_thumb">
        <br><h3>请先上传场景图</h3>
        </div>
        <?php }?>
    </div>
</div>

<script type="text/javascript">
var thumb_upload_url='<?=$this->createUrl('/pano/upload/')?>';
var scene_id = '<?=$datas['scene_id']?>';
var thumb_url = '<?=PicTools::get_pano_thumb($datas['scene_id'], '150x110')?>';
$.getScript("<?=Yii::app()->baseUrl?>/style/js/cutthumb/cover.js");

//var thumb_button_img = "<?=Yii::app()->baseUrl?>/style/img/upload_thumb.gif";
///thumb_box_upload();
</script>