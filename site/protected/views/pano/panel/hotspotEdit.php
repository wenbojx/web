<style>
.uploadify-queue{
    float:left;
}
.uploadify{
    float:left;
}
</style>
<div class="panel_box_content" id="panel_hotspotEdit">
<form method="post" class="form-horizontal" id="del_hotspot" action="<?=$this->createUrl('/salado/modules/hotspot/del/')?>">
    <div class="panel_title">
        <div class="title-bar">
            <span>删除热点</span>
            <div class="title_tip">
            	<span id="hotspot_del_msg"></span>
                <span onclick="hotspot_del(<?=$datas['hotspot_id']?>)" class="label label-warning">删除</span>
            </div>
        </div>
        <div class="panel_close" onclick="hide_edit_panel()">X</div>
    </div>
    <div class="panle_content" style="height:100px;width:200px;">
        <div id="thumb_img">
            <?php if (isset($datas['thumb'])){?>
                <img alt="" src="<?=$datas['thumb']?>">
            <?php }?>
        </div>
    </div>
</form>
</div>

<script type="text/javascript">

</script>