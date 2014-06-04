<?php
class GlobalController extends Controller{
    public function actionCamera(){
        $request = Yii::app()->request;
        $scene_id = $request->getParam('scene_id');
        $this->check_scene_own($scene_id);
        $camera['pan'] = $request->getParam('pan');
        $camera['tilt'] = $request->getParam('tilt');
        $camera['fov'] = $request->getParam('fov');

        $msg['flag'] = 1;
        $msg['msg'] = '操作成功';
        $id = $this->save_camera($camera, $scene_id);
        if(!$id){
            $msg['flag'] = 0;
            $msg['msg'] = '操作失败';
            $this->display_msg($msg);
        }
        $this->display_msg($msg);
    }
    private function save_camera($camera, $scene_id){
    	$global_db = new ScenesGlobal();
    	$datas['s_attribute']['debug'] = 'false';
    	$global_db->save_global($datas, $scene_id);
    	unset($datas);
    	$panorams_db = new ScenesPanoram();
    	
    	$attribute = $panorams_db->find_by_scene_id($scene_id);
    	$datas = array();
    	if($attribute['content']){
    		$datas = json_decode($attribute['content'], true);
    	}
    	$newCamera = array();
    	if($datas['s_attribute']['camera'] !=''){
    		$newCamera = $this->explodeCamera($datas['s_attribute']['camera']);
    	}
    	
    	$newCamera['pan'] = $camera['pan'] ? $camera['pan'] : '0';
    	$newCamera['tilt'] = $camera['tilt'] ? $camera['tilt'] : '0';
    	$newCamera['fov'] = $camera['fov'] ? $camera['fov'] : '90';
    	
    	$datas['s_attribute']['camera'] = $this->implodeCamera($newCamera);
    	return $panorams_db->save_camera($datas, $scene_id);
    }
    private function explodeCamera($camera){
    	$explode_1 = explode(',', $camera);
    	$newCamera = array();
    	foreach($explode_1 as $v){
    		if(!$v){
    			continue;
    		}
    		$explode_2 = explode(':', $v);
    		$newCamera[$explode_2[0]] = $explode_2[1];
    	}
    	return $newCamera;
    }
    private function implodeCamera($camera){
    	//print_r($camera);
    	if(!$camera){
    		return false;
    	}
    	$str = '';
    	foreach($camera as $k=>$v){
    		if($v==''){
    			continue;
    		}
    		$str .= $k.':'.$v.',';
    	}
    	return substr($str, 0, strlen($str)-1);
    }
    public function actionCompass(){
    	$request = Yii::app()->request;
    	$scene_id = $request->getParam('scene_id');
    	$this->check_scene_own($scene_id);
    	$compass = $request->getParam('pan');
    	
    	$msg['flag'] = 1;
    	$msg['msg'] = '操作成功';
    	$id = $this->save_compass($compass, $scene_id);
    	if(!$id){
    		$msg['flag'] = 0;
    		$msg['msg'] = '操作失败';
    		$this->display_msg($msg);
    	}
    	$this->display_msg($msg);
    }
    public function save_compass($compass, $scene_id){
    	if(!$scene_id){
    		return false;
    	}
    	$panorams_db = new ScenesPanoram();
    	$attribute = $panorams_db->find_by_scene_id($scene_id);
    	$datas = array();
    	if($attribute['content']){
    		$datas = json_decode($attribute['content'], true);
    	}
    	$datas['s_attribute']['direction'] = $compass;
    	//print_r($datas);
    	return $panorams_db->save_camera($datas, $scene_id);
    }
    public function actionPerspect(){
    	$request = Yii::app()->request;
    	$scene_id = $request->getParam('scene_id');
    	$this->check_scene_own($scene_id);
    	$perspect['maxPan'] = $request->getParam('maxPan');
    	$perspect['minPan'] = $request->getParam('minPan');
    	$perspect['maxTilt'] = $request->getParam('maxTilt');
    	$perspect['minTilt'] = $request->getParam('minTilt');
    	
    	$msg['flag'] = 1;
    	$msg['msg'] = '操作成功';
    	$id = $this->save_perspect($perspect, $scene_id);
    	if(!$id){
    		$msg['flag'] = 0;
    		$msg['msg'] = '操作失败';
    		$this->display_msg($msg);
    	}
    	$this->display_msg($msg);
    }
    public function save_perspect($perspect, $scene_id){
    	if(!$scene_id){
    		return false;
    	}
    	$panorams_db = new ScenesPanoram();
    	$attribute = $panorams_db->find_by_scene_id($scene_id);
    	$datas = array();
    	if($attribute['content']){
    		$datas = json_decode($attribute['content'], true);
    	}
    	if($datas['s_attribute']['camera'] !=''){
    		$newCamera = $this->explodeCamera($datas['s_attribute']['camera']);
    	}
    	
    	$newCamera['maxPan'] = $perspect['maxPan']!='' ? $perspect['maxPan'] : '';
    	$newCamera['minPan'] = $perspect['minPan']!='' ? $perspect['minPan'] : '';
    	$newCamera['maxTilt'] = $perspect['maxTilt']!='' ? $perspect['maxTilt'] : '';
    	$newCamera['minTilt'] = $perspect['minTilt']!='' ? $perspect['minTilt'] : '';

    	$datas['s_attribute']['camera'] = $this->implodeCamera($newCamera);

    	//print_r($datas);
    	return $panorams_db->save_camera($datas, $scene_id);
    }
}









