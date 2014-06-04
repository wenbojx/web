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
                            'id'=>'', 'path'=>'', 'camera'=>'',
                    ),
                    'hotspots'=>array(
                            '1'=>array(
                            		'type'=>'2',
                            		'link_scene_id'=>3,
                                    's_attribute'=>array('id'=>'', 'path'=>'', 'location'=>'', 'mouse'=>''),
                                    'settings'=>array(
                                            's_attribute'=>array('id'=>'', 'path'=>'', 'mouseOver'=>'', 'mouseOut'=>''),
                                    )
                            ),
                            '2'=>array(
                            		'type'=>'1',
                                    's_attribute'=>array('id'=>'', 'path'=>'', 'location'=>'', 'handCursor'=>'', 'mouse'=>''),
                            )
                    ),
            ),

    );
    public function get_panorams_info($panorams){
        $panorams_str = '<panoramas>';
        if(is_array($panorams)){
        	foreach($panorams as $v){
            	$panorams_str .= $this->get_panoram($v);
        	}
        }
        $panorams_str .= "</panoramas>\n";
        return $panorams_str;
    }
    private function get_panoram($panoram){
    	//print_r($panoram['s_attribute']);
        $panoram_str = '<panorama';
        if( isset($panoram['s_attribute'])){
        	$camera = !isset($panoram['s_attribute']['camera']) ? '' : $panoram['s_attribute']['camera'];
        	$panoram['s_attribute']['camera'] = $this->pano_attribute_camera($camera);
            $panoram_str .= $this->build_attribute($panoram['s_attribute']);
        }
        if( isset($panoram['hotspots'])){
            $panoram_str .= $this->get_hotspot($panoram['hotspots']);
        }
        $panoram_str .= '</panorama>';
        return $panoram_str;
    }
    private function pano_attribute_camera($camera){
    	$default_fov = 90;
    	if(!$camera){
    		$camera = 'fov:'.$default_fov;
    	}
    	if(!strstr($camera, 'fov')){
    		$camera .= ','.'fov:'.$default_fov;
    	}
    	//$camera .= ','. 'maxPan:100,minPan:-100,maxTilt:30,minTilt:-30';
    	return $camera;
    }
    private function get_hotspot($hotspots){
        $hotspots_str = '';
        foreach($hotspots as $k=>$v){
            if($v['type'] == '2'){
                $hotspots_str .= $this->get_hotspot_swf($v);
            }
            else if($v['type'] == '1'){
                $hotspots_str .= $this->get_hotspot_img($v);
            }
            else if($v['type'] == '4'){
            	$hotspots_str .= $this->get_imghotspot_swf($v);
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
        $swf_str .= '</swf>';
        return $swf_str;
    }
    private function get_hotspot_img($img){
        $swf_str .= '<image';
        $swf_str .= $this->build_attribute($img['s_attribute']);
        $swf_str .= '</image>';
        return $swf_str;
    }
    private function get_imghotspot_swf($swf){
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
    	$swf_str .= '</swf>';
    	return $swf_str;
    }
}




