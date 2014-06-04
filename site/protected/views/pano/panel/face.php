
<style>
.uploadify-queue{
    position:absolute;
    top:0;
    right:0;
}
</style>
<div class="panel_box_content" id="panel_face">
<div class="panel_title">
	<div class="title-bar">上传全景图</div>
	<div class="panel_close" onclick="hide_edit_panel()">X</div>
</div>
<div class="panle_content" style="height:400px;width:485px;">
    <ul class="nav nav-tabs">
    <li class="active" id="pano_upload_tab">
    <a href="javascript:pano_upload_change(1)">上传全景图</a>
    </li>
    <!-- <li id="cube_upload_tab"><a href="javascript:pano_upload_change(2)">单图</a></li> -->
    <span>文件大小请不要超过20M</span>
    </ul>
    <div id="pano_upload"  class="pano_upload">
    	<div class="pano_upload_box">
    	<br>
    	
    		<button id="pano_upload_bt"  class="btn btn-warning">点击上传</button>
    		<br>
    		<div class="pano_show" id="pano_show">
    			<?php if( $datas['file_id'] ){ ?>
    				<img width="400"  height="200" src="<?=PicTools::get_pano_small($datas['scene_id'], '400x200')?>"/>
    			<?php }?>
    		</div>
    	</div>
    	<div>
    		
    	</div>
    </div>
    
    <div id="cube_upload_box" class="cube_upload_box">
	    <div id="pano_state" class="pano_state"  style="display:<?=$datas['pano_state']==='1' ? "" : "none"?>">
	    <br> <br>
	    	<h3 class="color_green">全景图转换中，请稍等...</h3>
	    	<br> <br>
	    	<img src="<?=Yii::app()->baseUrl?>/style/img/loading/loading_1.gif">
	    </div>
	    <div id="pano_none" class="pano_state"  style="display:<?=$datas['pano_state']==='2' ? "" : "none"?>">
	    <br> <br>
	    	<h3 class="color_green">您还没有上传全景图！</h3>
	    </div>
	    <div id="cube_upload" class="cube_upload"  style="display:<?=$datas['pano_state'] === '0' ? "" : "none"?>">
			<div class="box_open" >
			    <div class="box_side box_left" id="box_side_left"><img id="box_left" src="<?=PicTools::get_face_small($datas['scene_id'], 's_l' , '120x120');?>"/></div>
			    <div class="box_side box_right" id="box_side_right"><img id="box_right" src="<?=PicTools::get_face_small($datas['scene_id'], 's_r' , '120x120');?>"/></div>
			    <div class="box_side box_down" id="box_side_down"><img id="box_down" src="<?=PicTools::get_face_small($datas['scene_id'], 's_d' , '120x120');?>"/></div>
			    <div class="box_side box_up" id="box_side_up"><img id="box_up" src="<?=PicTools::get_face_small($datas['scene_id'], 's_u' , '120x120');?>"/></div>
			    <div class="box_side box_front" id="box_side_front"><img id="box_front" src="<?=PicTools::get_face_small($datas['scene_id'], 's_f' , '120x120');?>"/></div>
			    <div class="box_side box_back" id="box_side_back"><img id="box_back" src="<?=PicTools::get_face_small($datas['scene_id'], 's_b' , '120x120');?>"/></div>
			</div>
		</div>
	</div>
</div>
</div>

<script type="text/javascript">
var script_url='<?=$this->createUrl('/pano/upload/')?>';
var pano_state_url='<?=$this->createUrl('/ajax/panoInfo/')?>';
var scene_id = '<?=$datas['scene_id']?>';
var pano_small_path = '<?=PicTools::get_pano_small($datas['scene_id'], '400x200')?>';
var width = 120;
var height = 120;
<?php if (!$datas['pano_state']){?>
/* var box_left = "<?php //$datas['scene_files']['left'] ?>";
var box_right = "<?php //$datas['scene_files']['right']?>";
var box_down = "<?php //$datas['scene_files']['down']?>";
var box_up = "<?php //$datas['scene_files']['up']?>";
var box_front = "<?php //$datas['scene_files']['front']?>";
var box_back = "<?php //$datas['scene_files']['back']?>";

init_box_upload('left');
init_box_upload('right');
init_box_upload('down');
init_box_upload('up');
init_box_upload('front');
init_box_upload('back');*/
<?php }?>
var pano_button_img = "<?=Yii::app()->baseUrl?>/style/img/pano_upload_bt.gif";
pano_box_upload();

</script>


