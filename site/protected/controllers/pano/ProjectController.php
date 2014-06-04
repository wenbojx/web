<?php
class ProjectController extends Controller{
    public $defaultAction = 'list';
    public $layout = 'home';
    private $page_size = 5;
    public $madmin = true;

    public function actionList(){
        $request = Yii::app()->request;
        $datas = array();
        $member_id = $this->member_id;
        $datas = array();
        if($member_id){
            //获取项目列表
            $project_db = Project::model();
            $criteria=new CDbCriteria;
            $criteria->order = 'id DESC';
            $criteria->addCondition("member_id={$member_id}");
            $criteria->addCondition('status=1');
            $total = $project_db->count($criteria);
            if($total>0){
                $page = $request->getParam('page')?$request->getParam('page'):0;
                $offset = $page*$this->page_size;
                $pages=new CPagination($total);
                $pages->pageSize = $this->page_size;
                $pages->route = '/pano/project/list/';
                $criteria->limit = $this->page_size;
                $criteria->offset = $offset;
                $pages->applyLimit($criteria);
                $datas['pages'] = $pages;
                $datas['list'] = $project_db->findAll($criteria);
                $datas['thumb'] = array();
                if($datas['list']){
                	foreach($datas['list'] as $k=>$v){
                		//获取缩略图
                		$datas['thumb'][$v['id']] = $this->get_thumb_scene_id($v['id']);
                	}
                }
                //print_r($datas['thumb']);
            }
        }
        $datas['page_title'] = '项目列表';
        $this->render('/pano/projectList', array('datas'=>$datas));
    }
	public function actionAdd(){
		$request = Yii::app()->request;
		$datas = array();
		$datas['done'] = 'doAdd';
		$datas['page_title'] = '新增项目';
		$this->render('pano/projectEdit', array('datas'=>$datas));
	}
	public function actionDoAdd(){
		$request = Yii::app()->request;
		$datas['name'] = $request->getParam('name');
		$datas['desc'] = $request->getParam('desc');
		$datas['category_id'] = $request->getParam('category_id');
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
	public function actionPublish(){
		$request = Yii::app()->request;
		$project_id = $request->getParam('project_id');
		$this->check_project_owner($project_id);
		$msg['flag'] = 1;
		$msg['msg'] = '操作成功';
		$display = $request->getParam('display');
		
		if($display == '2'){
			$display = 3;
			if(!$this->check_thumb($project_id)){
				$msg['flag'] = 0;
				$msg['msg'] = '该项目没有发布场景，请先发布场景';
				$this->display_msg($msg);
			}
		}
		//$display = 3;
		$project_db = new Project();
		$datas = $project_db->update_dispaly($project_id, $display);
		if(!$datas){
			$msg['flag'] = 0;
			$msg['msg'] = '操作失败';
		}
		$this->display_msg($msg);
	}
	/**
	 * 获取项目的默认缩略图
	 */
	private function get_thumb_scene_id($project_id){
		if(!$project_id){
			return false;
		}
		$projectDB = new Project();
		return $projectDB->get_thumb_scene_id($project_id);
	}

	private function check_thumb($project_id){
		$scene_db = new Scene();
		$num = $scene_db->get_scene_num($project_id);
		if($num){
			return true;
		}
		return false;
	}
	private function add_project($datas){
		$project_db = new Project();
		$datas['member_id'] = $this->member_id;
		$datas['created'] = time();
		return $project_db->add_project($datas);
	}
	
	public function actionEdit(){
		$request = Yii::app()->request;
		$datas = array();
		$project_id = $request->getParam("id");
		
		$datas['done'] = 'doEdit';
		if(!$project_id){
			$datas['msg'] = "参数错误";
		}
		else{
			$datas['project'] = $this->get_project_info($project_id);
		}
		$datas['page_title'] = '编辑项目';
		$this->render('pano/projectEdit', array('datas'=>$datas));
	}
	private function get_project_info($id){
		if(!$id){
			return false;
		}
		$project_db = new Project();
		return $project_db->find_by_project_id($id);
	}
	public function actionDoEdit(){
		$request = Yii::app()->request;
		$datas['id'] = $request->getParam('id');
		$datas['name'] = $request->getParam('name');
		$datas['desc'] = $request->getParam('desc');
		$datas['category_id'] = $request->getParam('category_id');
		$msg['flag'] = 1;
		$msg['msg'] = '操作成功';
		if($datas['id'] == ''){
			$msg['flag'] = 0;
			$msg['msg'] = '操作失败';
			$this->display_msg($msg);
		}
		if($datas['name'] == ''){
			$msg['flag'] = 0;
			$msg['msg'] = '操作失败';
			$this->display_msg($msg);
		}
		$this->check_project_owner($datas['id']);
		if(!$id = $this->edit_project($datas)){
			$msg['flag'] = 0;
			$msg['msg'] = '操作失败';
		}
		$this->display_msg($msg);
	}
	private function edit_project($datas){
		$project_db = new Project();
		return $project_db->edit_project($datas);
	}
}