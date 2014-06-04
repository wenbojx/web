<?php
class IndexController extends FController{
    public $defaultAction = 'a';
    public $layout = 'home';
    private $project_num = 3;
    private $scene_num = 8;
    private $baner_scene_id = '10001';
    public $pageName = '0';
    //private $baner_scene_id = '10';

    public function actionA(){
    	$projects = $this->get_last_project($this->project_num);
    	$datas['baner_scene_id'] = $this->baner_scene_id;
    	//$datas['scenes'] = $this->get_project_panos($this->scene_num, $projects);
    	$datas['total_num'] = $this->get_total_panos()+5270;
        $this->render('/web/index', array('datas'=>$datas));
    }
    /**
     * 获取景点总数
     */
    private function get_total_panos(){
    	$scene_db = new Scene();
    	return $scene_db->get_scene_total_num();
    }
    /*
     * 获取最新的3个项目
     */
    private function get_last_project($num = 3){
    	$project_db = new Project();
    	return $project_db->get_last_project($num, 3);
    }
    /**
     * 获取最新的8个全景
     */
    private function get_project_panos($num=4, $projects){
    	if(!$projects){
    		return false;
    	}
    	$scene_datas = array();
    	$scene_db = new Scene();
    	foreach($projects as $v){
    		$criteria=new CDbCriteria;
    		$criteria->order = 'id ASC';
    		$criteria->addCondition('status=1');
    		$criteria->addCondition('display=2');
    		$criteria->limit = $num;
    		$criteria->addCondition("project_id={$v['id']}");
    		$scene_data = $scene_db->findAll($criteria);
    		if($scene_data){
    			$scene_datas = array_merge($scene_datas, $scene_data);
    		}
    	}
    	return $scene_datas;
    }
}