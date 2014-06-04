<?php
class ViewController extends FController{
    public $defaultAction = 'a';
    public $layout = 'home';
    public $num = 16; //每页显示的数
    public $scene_db = null;
    public $pageName = '1';

    public function actionA(){
    	$request = Yii::app()->request;
    	$project_id = $request->getParam('id');
    	$page = $request->getParam('page')?$request->getParam('page'):1;
    	$this->scene_db = new Scene();
    	$datas = array();
    	$datas['list'] = '';
    	//$datas['pages'] = '';
    	if($project_id){
    		$datas['project'] = $this->get_project_datas($project_id);
    		$this->pageName = $datas['project']['category_id'];
    		//$datas['list'] = $this->get_scene_datas($project_id);
    		$total = $this->scene_db->get_scene_num($project_id);
    		if($total>0){
    			$route = '/web/view/a';
    			$datas['pages'] = $this->page($page, $this->num, $total, $route);
    			$offset = ($page-1)*$this->num;
    			//获取场景信息
    			$datas['list'] = $this->get_scene_datas($project_id, $offset);
    		}
    	}
        $this->render('/web/view', array('datas'=>$datas));
    }
    
    private function get_project_datas($project_id){
    	$project_db = new Project();
    	return $project_db->find_by_project_id($project_id);
    }
    
    private function get_scene_datas($project_id, $offset){
    	$order = 'id ASC';
    	return $this->scene_db->find_scene_by_project_id($project_id, $this->num, $order, $offset);
    }
}