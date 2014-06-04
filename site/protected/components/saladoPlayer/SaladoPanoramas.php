<?php
/**
 *
 <panorama  id="s" path="<?=$this->createUrl('/salado/index/a/', array('id'=>$datas['scene_id'], 'type'=>'xmlb'))?>/s_f.xml">
 <swf id="swf_A" location="pan:-20" path="<?=Yii::app()->baseUrl?>/pages/salado/modules/AdvancedHotspot-1.0.swf" mouse="onClick:helloA,onOver:show_gc_arrowGreen,onOut:hide_gc_arrowGreen">
 <settings path="<?=Yii::app()->baseUrl?>/pages/salado/media/arrow_floor.png" mouseOver="scale:2,time:1,transition:Linear.easeNone" mouseOut="time:1,transition:Expo.easeInOut"/>
 </swf>
 <swf id="swf_B" location="pan:0" path="<?=Yii::app()->baseUrl?>/pages/salado/modules/AdvancedHotspot-1.0.swf" mouse="onClick:helloB,onOver:show_gc_arrowGreen,onOut:hide_gc_arrowGreen">
 <settings path="<?=Yii::app()->baseUrl?>/pages/salado/media/arrow_floor.png" beat="false"/>
 </swf>
 </panorama>
 *
 */
class SaladoPanoramas extends SaladoPlayer{
    private $panoramas_datas = array(
            //'attribute'=>array('debug'=>false),
            '1'=>array(
                    's_attribute'=>array(
                            'id'=>'', 'path'=>''
                    ),
                    'hotspots'=>array(
                            'swf'=>array(
                                    's_attribute'=>array('id'=>'', 'path'=>'', 'location'=>'', 'mouse'=>''),
                                    'settings'=>array(
                                            's_attribute'=>array('path'=>'', 'mouseOver'=>'', 'mouseOut'=>''),
                                    )
                            ),
                            'image'=>array(
                                    's_attribute'=>array('id'=>'', 'path'=>'', 'location'=>'', 'handCursor'=>'', 'mouse'=>''),
                            )
                    ),
            ),

    );
    public function get_panorams_info($panorams){
        $panorams_str = '<panoramas>';
        if($panorams['child']){
            $panorams_str .= $this->get_panoram($panorams['child']);
        }
        $panorams_str .= '</panoramas>';
        return $panoram_str;
    }
    private function get_panoram($panorams){
        $panoram_str = '<panorama';
        if( isset($branding['s_attribute'])){
            $panoram_str .= $this->build_attribute($branding['s_attribute']);
        }
        if( isset($branding['hotspots'])){
            $panoram_str .= $this->get_hotspot($branding['hotspots']);
        }
        $panoram_str .= '</panorama>';
        return $panoram_str;
    }
    private function get_hotspot($hotspots){
        $hotspots_str = '';
        foreach($hotspots as $k=>$v){
            if($k == 'swf'){
                $hotspots_str .= $this->get_hotspot_swf($hotspots['swf']);
            }
            if($k == 'image'){
                $hotspots_str .= $this->get_hotspot_img($hotspots['image']);
            }
        }
        return $hotspots_str;
    }
    private function get_hotspot_swf($swf){
        $swf_str = '<swf';
        if(isset($swf['s_attribute'])){
            $swf_str .= $this->build_attribute($swf['s_attribute']);
        }
        if(isset($swf['settings'])){
            $swf_str .= '<settings';
            if(isset($swf['settings']['s_attribute'])){
                $swf_str .= $this->build_attribute($swf['settings']['s_attribute']);
            }
            $swf_str .= '</settings>';
        }
        $swf_str .= '<swf>';
        return $swf_str;
    }
    private function get_hotspot_img($img){
        $swf_str .= '<image';
        $swf_str .= $this->build_attribute($img['s_attribute']);
        return $swf_str;
    }
}




