<?php
class UploadPhotoController extends Controller{
    public $defaultAction = 'show';
    private $default_pic_url = '';
    //public $layout = 'page';

    public function actionShow(){
        $request = Yii::app()->request;
        $datas['scene_id'] = $request->getParam('scene_id');
        $scene_files = $this->get_scene_pic($datas['scene_id']);
        $datas['scene_files'] = $this->get_file_url($scene_files);
        //print_r($datas['scene_files']);
        $this->render('project/scene/uploadPhoto', array('datas'=>$datas));
    }
    /**
     * 获取图片地址
     */
    private function get_file_url($scene_files){
    	$file_url = array();
    	$pic_name = '150x150.jpg';
    	$default_scene = array('left', 'right', 'down', 'up', 'front', 'back');
    	foreach ($default_scene as $v){
    		$file_url[$v] = isset($scene_files[$v]) && $scene_files[$v] ? $this->createUrl('/home/pictrue/index/', array('id'=>$scene_files[$v], 'size'=>$pic_name)) : $this->get_default_url($v);
    	}
    	unset($scene_files);
    	return $file_url;
    }
    /**
     * 获取默认图片地址
     */
    private function get_default_url($position){
    	return Yii::app()->baseUrl."/pages/images/box_{$position}.gif";
    }
    /*
     * 获取全景图
     */
    private function get_scene_pic($scene_id){
    	$pics = array();
    	if(!$scene_id){
    		return $pics;
    	}
    	$scene_file_db = new MpSceneFile();
    	return $scene_file_db->get_scene_list($scene_id);
    }
}