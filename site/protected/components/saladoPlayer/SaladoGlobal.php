<?php
class SaladoGlobal extends SaladoPlayer{
    private $global_datas = array(
            's_attribute'=>array('debug'=>'false'),
            'branding'=>array('s_attribute'=>array('visible'=>'false')),
            'control'=>array('s_attribute'=>array('autorotation'=>'enabled:true')),
    );
    public function get_global_info($global){
        $global_str = '<global';
        if( isset($global['s_attribute'])){
            $global_str .= $this->build_attribute($global['s_attribute']);
        }
        if(isset($global['branding'])){
            $global_str .= $this->get_branding($global['branding']);
        }
        if(isset($global['control'])){
            $global_str .= $this->get_branding($global['control']);
        }
        $global_str .= '</global>';
        return $global_str;
    }
    private function get_branding($branding){
        $branding_str = '<branding';
        if( isset($branding['s_attribute'])){
            $branding_str .= $this->build_attribute($branding['s_attribute']);
        }
        $branding_str .= '</branding>';
        return $branding_str;
    }
    private function get_control($control){
        $control_str = '<control';
        if( isset($control['s_attribute'])){
            $control_str .= $this->build_attribute($control['s_attribute']);
        }
        $control_str .= '</branding>';
        return $control_str;
    }
}