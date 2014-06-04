<?php
class SceneEditController extends Controller{
	public $defaultAction = 'add';
	//public $layout = 'page';

	public function actionAdd(){
		$request = Yii::app()->request;
		$project_id = $request->getParam('project_id');
		$datas['project_id'] = $project_id;
		$this->render('project/sceneEdit', array('datas'=>$datas));
	}
	public function actionDoAdd(){
		$request = Yii::app()->request;
		$msg['flag'] = 1;
		$msg['msg'] = '操作成功';
		
		$datas['name'] = $request->getParam('name');
		$datas['desc'] = $request->getParam('desc');
		$datas['project_id'] = $request->getParam('project_id');
		$datas['photo_time'] = $request->getParam('photo_time');
		if($datas['name'] == '' || !$datas['project_id'] || !$this->check_project_owner($datas['project_id'])){
			$msg['flag'] = 0;
			$msg['msg'] = '操作失败';
			$this->display_msg($msg);
		}
		
		if(!$id = $this->add_scene($datas)){
			$msg['flag'] = 0;
			$msg['msg'] = '操作失败';
		}
		$this->display_msg($msg);
	}
	public function actionPublish(){
		$request = Yii::app()->request;
		$scene_id = $request->getParam('scene_id');
		$this->check_scene_own($scene_id);
		$msg['flag'] = 1;
		$msg['msg'] = '操作成功';
		$display = $request->getParam('display');
		$scene_db = new Scene();
		$datas = $scene_db->update_scene_dispaly($scene_id, $display);
		if(!$datas){
			$msg['flag'] = 0;
			$msg['msg'] = '操作失败';
		}
		$this->display_msg($msg);
	}
	public function add_scene($datas){
		$scene_db = new Scene();
		$datas['member_id'] = $this->member_id;
		$datas['created'] = $datas['photo_time'] ? strtotime($datas['photo_time']) : '0';
		return $scene_db->add_scene($datas);
	}
	private function check_project_owner($project_id){
		if(!$project_id){
			return false;
		}
		$project_db = new Project();
		$project_datas = $project_db->find_by_project_id($project_id);
		if(!$project_datas || $project_datas->member_id != $this->member_id){
			return false;
		}
		return true;
	}
}