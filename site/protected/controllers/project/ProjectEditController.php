<?php
class ProjectEditController extends Controller{
	public $defaultAction = 'add';
	//public $layout = 'page';

	public function actionAdd(){
		$request = Yii::app()->request;
		$datas = array();
		$this->render('project/projectEdit', $datas);
	}
	public function actionDoAdd(){
		$request = Yii::app()->request;
		$datas['name'] = $request->getParam('name');
		$datas['desc'] = $request->getParam('desc');
		$msg['flag'] = 1;
		$msg['msg'] = '操作成功';
		if($datas['name'] == ''){
			$msg['flag'] = 0;
			$msg['msg'] = '操作失败';
			$this->display_msg($msg);
		}
		if(!$id = $this->add_project($datas)){
			$msg['flag'] = 0;
			$msg['msg'] = '操作失败';
		}
		$this->display_msg($msg);
	}
	public function add_project($datas){
		$project_db = new Project();
		$datas['member_id'] = $this->member_id;
		$datas['created'] = time();
		return $project_db->add_project($datas);
	}
}