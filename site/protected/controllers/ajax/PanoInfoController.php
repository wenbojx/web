<?php

class PanoInfoController extends Controller{

    public function actionPanoPicState(){
    	$request = Yii::app()->request;
    	$datas = array();
    	$scene_id = $request->getParam('scene_id');
    	if(!$scene_id){
    		$msg['state'] = '0';
    		$msg['msg'] = '参数错误';
    	}
    	$state = $this->get_pano_state($scene_id);
    	if($state === '0'){
    		$msg['state'] = '1';
    		$msg['msg'] = '全景图已生成';
    	}
    	else if($state === '1'){
    		$msg['state'] = '2';
    		$msg['msg'] = '全景图转换中';
    	}
    	else{
    		$msg['state'] = '3';
    		$msg['msg'] = '找不到全景图';
    	}
    	$this->display_msg($msg);
    }
    /**
     * 获取全景图状态
     */
    private function get_pano_state($scene_id){
    	if (!$scene_id){
    		return false;
    	}
    	$panoQueue = new PanoQueue();
    	$datas = $panoQueue->find_by_scene_id($scene_id);
    	if(!$panoQueue){
    		return false;
    	}
    	return $datas['state'];
    }
}





