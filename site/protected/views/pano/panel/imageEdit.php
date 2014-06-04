<style>
.uploadify-queue{
    float:left;
}
.uploadify{
    float:left;
}
</style>
<div class="panel_box_content" id="panel_imageEdit">
<form method="post" class="form-horizontal" id="del_imghotspot" action="<?=$this->createUrl('/salado/modules/image/del/')?>">
    <div class="panel_title">
        <div class="title-bar">
            <span>删除图片</span>
            <div class="title_tip">
            	<span id="hotspot_del_msg"></span>
                <span onclick="image_hotspot_del(<?=$datas['hotspot_id']?>)" class="label label-warning">删除</span>
            </div>
        </div>
        <div class="panel_close" onclick="hide_edit_panel()">X</div>
    </div>
    <div class="panle_content" style="height:300px;width:350px;">
        <div id="imageHotspot">
        <img width="350" src="<?=PicTools::get_img_hotspot_path($datas['scene_id'], $datas['hotspot_id'])?>"/>
        </div>
    </div>
</form>
</div>

<script type="text/javascript">

</script>