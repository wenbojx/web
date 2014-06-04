<?php

class CacheCleanController extends Controller{

    public function actionA(){
    	$request = Yii::app()->request;
    	$datas = array();
    	$type = $request->getParam('type');
    	$sid = $request->getParam($sid);
    	if($type=="single"){
    		$this->clean_single($sid);
    	}
    }
    /**
     * 获取全景图状态
     */
    private function clean_single($scene_id){
    	if (!$scene_id){
    		return false;
    	}
    	$memcache_obj = new Ymemcache();
    	$key = $memcache_obj->get_pano_xml_key($scene_id.'_s', false);
    	echo $key;
    	$memcache_obj->set_mem_data($key, "", 0);
    }
}





