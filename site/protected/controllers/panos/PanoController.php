<?php
class PanoController extends FController{
	public $defaultAction = 'show';
	public $layout = 'pano';
	
	public function actionShow(){
		$request = Yii::app()->request;
		$datas['scene_id'] = $request->getParam('id');
		if(!$datas['scene_id']){
			exit('数据错误');
		}
		$datas['scene_datas'] = $this->get_pano_info($datas['scene_id']);
		$this->render('/panos/pano', array('datas'=>$datas));
	}
	public function get_pano_info($scene_id){
		if(!$scene_id){
			return false;
		}
		$scene_db = new Scene();
		return $scene_db->get_by_scene_id($scene_id);
	}
}