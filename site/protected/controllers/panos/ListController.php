<?php
class ListController extends FController{
    public $defaultAction = 'list';
    public $layout = 'panoList';
    private $page_size = 30;

    public function actionList(){
    	$request = Yii::app()->request;
    	$datas = array();
    	//$project_id = $request->getParam('id');
    	$datas = array();
    	//if($project_id){
    		//获取场景列表
    		$scene_db = new Scene();
    		$criteria=new CDbCriteria;
    		$criteria->order = 'id ASC';
    		//$criteria->addCondition("project_id={$project_id}");
    		$criteria->addCondition('status=1');
    		$criteria->addCondition('display=2');
    		$total = $scene_db->count($criteria);
    		$datas['list'] = array();
    		if($total>0){
    			$page = $request->getParam('page')?$request->getParam('page'):0;
    			$offset = $page*$this->page_size;
    			$pages=new CPagination($total);
    			$pages->pageSize = $this->page_size;
    			$pages->route = '/panos/list/list';
    			$criteria->limit = $this->page_size;
    			$criteria->offset = $offset;
    			$pages->applyLimit($criteria);
    			$datas['pages'] = $pages;
    			//获取场景信息
    			$datas['list'] = $scene_db->findAll($criteria);
    		}
    	//}
    	$this->render('/panos/List', array('datas'=>$datas));
    }

}