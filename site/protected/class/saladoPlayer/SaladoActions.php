<?php
class SaladoActions extends SaladoPlayer{
    private $actions_datas = array(
            'id'=>array(
                's_attribute'=>array('id'=>'', 'content'=>''),
            ),
    );
    public function get_actions_info($actions){
    	//print_r($actions);
        $action_str = '<actions>';
        if($actions){
        	foreach ($actions as $k=>$v){
            	$action_str .= $this->get_action($v);
        	}
        }
        $action_str .= "</actions>\n";
        return $action_str;
    }
    private function get_action($action){
        $action_str = '<action';
        $action_str .= $this->build_attribute($action['s_attribute']);
        $action_str .= '</action>';
        return $action_str;
    }
}