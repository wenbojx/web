<?php
class SaladoActions extends SaladoPlayer{
    private $actions_datas = array(
            'child'=>array(
                's_attribute'=>array('id'=>'', 'content'=>''),
            ),
    );
    public function get_actions_info($actions){
        $action_str = '<actions>';
        if($actions['child']){
            $action_str .= $this->get_action($actions['child']);
        }
        $action_str .= '>';
        $action_str .= '</actions>';
        return $action_str;
    }
    private function get_action($action){
        $action_str = '<action';
        if(isset($action['s_attribute'])){
            $action_str .= $this->build_attribute($action['s_attribute']);
        }
        $action_str .= '</action>';
        return $action_str;
    }
}