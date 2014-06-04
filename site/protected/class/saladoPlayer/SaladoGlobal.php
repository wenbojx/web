<?php
class SaladoGlobal extends SaladoPlayer{
    private $global_datas = array(
            's_attribute'=>array('debug'=>'false', 'camera'=>'pan:0,tilt:0,fov:90'),
            'branding'=>array('s_attribute'=>array('visible'=>'false')),
            'control'=>array('s_attribute'=>array('autorotation'=>'enabled:true')),
    		'panoramas'=>array('s_attribute'=>array('firstPanorama'=>'33'))
    );
    public function get_global_info($global){
        $global_str = '<global';

        $global_str .= $this->build_attribute($global['s_attribute']);
        if(isset($global['branding'])){
            $global_str .= $this->get_branding($global['branding']);
        }
        if(isset($global['control'])){
            $global_str .= $this->get_control($global['control']);
        }
        if(isset($global['panoramas'])){
        	$global_str .= $this->get_panoramas($global['panoramas']);
        }
        $global_str .= "</global>\n";
        return $global_str;
    }
    private function get_panoramas($panoramas){
    	$panoramas_str = '<panoramas';
    	$panoramas_str .= $this->build_attribute($panoramas['s_attribute']);
    	$panoramas_str .= '</panoramas>';
    	return $panoramas_str;
    }
    private function get_branding($branding){
        $branding_str = '<branding';
        $branding_str .= $this->build_attribute($branding['s_attribute']);
        $branding_str .= '</branding>';
        return $branding_str;
    }
    private function get_control($control){
        $control_str = '<control';
        $control_str .= $this->build_attribute($control['s_attribute']);
        $control_str .= '</control>';
        return $control_str;
    }
}