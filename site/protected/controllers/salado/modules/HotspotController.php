<?php
class HotspotController extends Controller{
    public function actionSave(){
        $request = Yii::app()->request;
        $scene_id = $request->getParam('scene_id');
        $datas['scene_id'] = $scene_id;
        $this->check_scene_own($scene_id);
        $datas['pan'] = (int)$request->getParam('pan');
        $datas['tilt'] = (int)$request->getParam('tilt');
        $datas['fov'] = (int)$request->getParam('fov');
        $datas['type'] = $request->getParam('type');
        $datas['transform'] = $request->getParam('transform');
        $datas['link_scene_id'] = $request->getParam('link_scene_id');
        $msg['flag'] = 0;
        $msg['msg'] = '操作失败';
        if($datas['link_scene_id'] == '0' || $datas['link_scene_id'] == ''){
            $this->display_msg($msg);
        }
        $id = $this->add_hotspot($datas);
        if(!$id){
            $this->display_msg($msg);
        }
        $msg['flag'] = 1;
        $msg['msg'] = '操作成功';
        $this->display_msg($msg);
    }
    private function add_hotspot($datas){
    	$hotspot_db = new ScenesHotspot();
    	return $hotspot_db->add_hotsopt($datas);
    }
    public function actionDel(){
    	$request = Yii::app()->request;
    	$hotspot_id = $request->getParam('hotspot_id');
    	$msg['flag'] = 0;
    	$msg['msg'] = '操作失败';
    	//获取热点信息
    	$hotspot_info = $this->get_hotspot_info($hotspot_id);
    	if(!$hotspot_info){
    		$this->display_msg($msg);
    	}
    	$this->check_scene_own($hotspot_info['scene_id']);
    	//删除热点
    	if(!$this->del_hotspot($hotspot_id)){
    		$this->display_msg($msg);
    	}
    	$msg['flag'] = 1;
    	$msg['msg'] = '操作成功';
    	$this->display_msg($msg);
    }
    private function del_hotspot($hotspot_id){
    	if(!$hotspot_id){
    		return false;
    	}
    	$hotspot_db = new ScenesHotspot();
    	$datas['status'] = 2;
    	return $hotspot_db->edit_hotspot($hotspot_id, $datas);
    }
    private function get_hotspot_info($hotspot_id){
    	if(!$hotspot_id){
    		return false;
    	}
    	$hotspot_db = new ScenesHotspot();
    	return $hotspot_db->get_by_hotspot_id($hotspot_id);
    }
    
}