<style>
.uploadify-queue{
    position:absolute;
    top:0;
    right:0;
    bottom:0;
    left:0;
}
</style>
<div>

<div class="box_open">
    <div class="box_side box_left" id="box_side_left"><img id="box_left" src="<?=$datas['scene_files']['left']?>"/></div>
    <div class="box_side box_right" id="box_side_right"><img id="box_right" src="<?=$datas['scene_files']['right']?>"/></div>
    <div class="box_side box_down" id="box_side_down"><img id="box_down" src="<?=$datas['scene_files']['down']?>"/></div>
    <div class="box_side box_up" id="box_side_up"><img id="box_up" src="<?=$datas['scene_files']['up']?>"/></div>
    <div class="box_side box_front" id="box_side_front"><img id="box_front" src="<?=$datas['scene_files']['front']?>"/></div>
    <div class="box_side box_back" id="box_side_back"><img id="box_back" src="<?=$datas['scene_files']['back']?>"/></div>
</div>

</div>

<script type="text/javascript">
var script_url='<?=$this->createUrl('/project/uploadPano/')?>';
var scene_id = '<?=$datas['scene_id']?>';
var width = 120;
var height = 120;
init_box_upload('left');
init_box_upload('right');
init_box_upload('down');
init_box_upload('up');
init_box_upload('front');
init_box_upload('back');
</script>