<?php
class MusicController extends Controller{
	public $defaultAction = 'save';
    public function actionSave(){
        $request = Yii::app()->request;
        $datas['scene_id'] = $request->getParam('scene_id');
        $datas['file_id'] = $request->getParam('file_id');
        $datas['loop'] = $request->getParam('loop')?$request->getParam('loop'):0;
        $datas['volume'] = $request->getParam('volume')?$request->getParam('volume'):0.5;
        $datas['state'] = $request->getParam('state');
        $datas['music_id'] = $request->getParam('music_id');
        $this->check_scene_own($datas['scene_id']);
        $msg['flag'] = 0;
        $msg['msg'] = '操作失败';
        if(!$datas['file_id'] || !$datas['scene_id']){
        	$this->display_msg($msg);
        }
        $this->check_file_chang($datas['file_id'], $datas['scene_id']);
        $id = $this->save_scene_music($datas);
        //echo $id;
        if(!$id){
        	$this->display_msg($msg);
        }
        $msg['flag'] = 1;
        $msg['msg'] = '操作成功';
        $msg['id'] = $id;
        $this->display_msg($msg);
    }
    private function save_scene_music($datas){
    	$scene_music_db = new MpSceneMusic();
    	$datas['volume'] = $datas['volume']*10;
    	return $scene_music_db->save_datas($datas);
    }
    private function check_file_chang($file_id, $scene_id){
    	
    	$scene_musc_db = new MpSceneMusic();
    	$music_datas = $scene_musc_db->get_by_scene_id($scene_id);
    	if($music_datas['file_id'] && $music_datas['file_id'] == $file_id){
    		return true;
    	}
    	
    	$file_path_db = new FilePath();
    	$file_path = $file_path_db->get_file_path($file_id);
    	
    	if(!$file_path || !is_file($file_path)){
    		return false;
    	}
    	//echo $file_path;
    	$type = substr($file_path, (strlen($file_path)-3), 3);
    	//获取文件
    	$toPath = PicTools::get_pano_static_path($scene_id).'/music.'.$type;
    	if(file_exists($toPath)){
    		unlink($toPath);
    	}
    	copy($file_path, $toPath);
    }
}