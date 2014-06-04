<?php
class MapController extends Controller{
	public $defaultAction = 'save';
	public $default_width = 500;
	public $default_height = 300;
    public function actionSave(){
        $request = Yii::app()->request;
        $scene_id = $request->getParam('scene_id');
        $project_id = $request->getParam('project_id');
        $datas['map_id'] = $request->getParam('map_id');
        $datas['scene_id'] = $request->getParam('link_scene_id');
        $datas['left'] = $request->getParam('left');
        $datas['top'] = $request->getParam('top');
        $this->check_project_owner($project_id);
        $msg['flag'] = 0;
        $msg['msg'] = '操作失败';
        if(!$datas['map_id'] || !$datas['scene_id']){
        	$this->display_msg($msg);
        }
        $id = $this->add_marker($datas);
        if(!$id){
        	$this->display_msg($msg);
        }
        $msg['flag'] = 1;
        $msg['msg'] = '操作成功';
        $msg['id'] = $id;
        $this->display_msg($msg);
    }
    private function add_marker($datas){
    	$map_position_db = new ProjectMapPosition();
    	return $map_position_db->save_map_position($datas);
    }
    public function actionDel(){
    	$request = Yii::app()->request;
    	$project_id = $request->getParam('project_id');
    	$this->check_project_owner($project_id);
    	$id = $request->getParam('id');
    	$msg['flag'] = 0;
    	$msg['msg'] = '操作失败';
    	$id = $this->del_marker($id);
        if(!$id){
        	$this->display_msg($msg);
        }
        $msg['flag'] = 1;
        $msg['msg'] = '操作成功';
        $this->display_msg($msg);
    }
    private function del_marker($id){
    	$map_position_db = new ProjectMapPosition();
    	return $map_position_db->del_marker($id);
    }
}