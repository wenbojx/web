
<tour start="node_<?=$datas['scene_id']?>">
<?php 
$size = '600x600';
$i = 0;
if(isset($datas['scene_list']) && is_array($datas['scene_list'])){
foreach($datas['scene_list'] as $k=>$v){

?>

  <panorama id="node_<?=$k?>" hideabout="1">
    <view fovmode="0" pannorth="0">
      <start pan="<?=(0-$datas['scene_info'][$k]['pan'])?>" fov="<?=$datas['scene_info'][$k]['fov']?>" tilt="<?=$datas['scene_info'][$k]['tilt']?>"/>
      <min pan="0" fov="50" tilt="-90"/>
      <max pan="360" fov="90" tilt="90"/>
    </view>
    <userdata title="" datetime="" description="" copyright="" tags="" author="" source="" comment="" info="" longitude="" latitude=""/>
    <hotspots width="180" height="20" wordwrap="1">
    
      <label width="180" backgroundalpha="1" enabled="1" height="20" backgroundcolor="0xffffff" bordercolor="0x000000" border="1" textcolor="0x000000" borderalpha="1" borderradius="1" wordwrap="1" textalpha="1"/>
      <polystyle mode="0" backgroundalpha="0.2509803921568627" backgroundcolor="0x0000ff" bordercolor="0x0000ff" borderalpha="1"/>
      <?php if(isset($datas['hotspot'][$k])){
      foreach($datas['hotspot'][$k] as $k1=>$v1){
		if($v1['type'] != '2'){
			continue;
		}
      	?>
      <hotspot title="<?=$v1['title']?>" target="" pan="<?=(0-$v1['pan'])?>" skinid="" url="{node_<?=$v1['link_scene_id']?>}" id="Point<?=$k1?>_<?=$v1['link_scene_id']?>" tilt="<?=$v1['tilt']?>"/>
      <?php }}?>
    </hotspots>

    <input tile0url="<?=PicTools::get_face_small($k, 's_f' , $size)?>" tile5url="<?=PicTools::get_face_small($k, 's_d' , $size)?>" tilesize="600" tile4url="<?=PicTools::get_face_small($k, 's_u' , $size)?>" tile3url="<?=PicTools::get_face_small($k, 's_l' , $size)?>" tilescale="1.010940919037199" tile2url="<?=PicTools::get_face_small($k, 's_b' , $size)?>" tile1url="<?=PicTools::get_face_small($k, 's_r' , $size)?>"/>
    <autorotate speed="0.0600" nodedelay="75.00" startloaded="0" returntohorizon="0.000" delay="3.00"/>
    <control simulatemass="1" lockedmouse="0" lockedkeyboard="0" dblclickfullscreen="0" invertwheel="0" lockedwheel="0" invertcontrol="1" speedwheel="1" sensitivity="8"/>
  </panorama>
  <?php $i++; }}?>
</tour>
