<?php
class ImageController extends Controller{
    public function actionSave(){
        $request = Yii::app()->request;
        $scene_id = $request->getParam('scene_id');
        $datas['scene_id'] = $scene_id;
        $this->check_scene_own($scene_id);
        $datas['pan'] = (int)$request->getParam('pan');
        $datas['tilt'] = (int)$request->getParam('tilt');
        $datas['fov'] = (int)$request->getParam('fov');
        $datas['file_id'] = (int)$request->getParam('file_id');
        $datas['type'] = 4;
        $datas['transform'] = 0;
        $datas['link_scene_id'] = 0;
        $msg['flag'] = 0;
        $msg['msg'] = '操作失败';
        if(!$datas['scene_id'] || !$datas['file_id']){
            $this->display_msg($msg);
        }
        $id = $this->add_img_hotspot($datas);
        if(!$id){
            $this->display_msg($msg);
        }
        $msg['flag'] = 1;
        $msg['msg'] = '操作成功';
        $this->display_msg($msg);
    }
    private function add_img_hotspot($datas){
    	$hotspot_db = new ScenesHotspot();
    	$hotspot_id =  $hotspot_db->add_hotsopt($datas);
    	if(!$hotspot_id){
    		return false;
    	}
    	return $this->save_hotspot_file($hotspot_id, $datas['file_id']);
    }
    private function save_hotspot_file($hotspot_id, $file_id){
    	$datas['hotspot_id'] = $hotspot_id;
    	$datas['file_id'] = $file_id;
    	$hotspot_file_db = new MpHotspotFile();
    	return $hotspot_file_db->add_imghotsopt($datas);
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