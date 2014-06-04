<style>
.uploadify-queue{
    float:left;
}
.uploadify{
	float:left;
}
</style>
<div class="box_open">
    <div class="input-box">
        <li>
            <a style="" id="thumb_box_upload" class="button" href="javascript:;">上传缩略图</a>480x240
            
        </li>
        <li style="clear:both">
        	<div id="thumb_img">
        	<?php if (isset($datas['thumb'])){?>
        		<img alt="" src="<?=$datas['thumb']?>">
        	<?php }?>
        	</div>
        </li>
    </div>
</div>

<script type="text/javascript">
var thumb_upload_url='<?=$this->createUrl('/project/uploadPano/')?>';
var scene_id = '<?=$datas['scene_id']?>';
var thumb_button_img = "<?=Yii::app()->baseUrl?>/pages/images/upload_thumb.gif";
thumb_box_upload();
</script>