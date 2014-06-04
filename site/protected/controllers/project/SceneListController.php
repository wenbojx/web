<?php
class SceneListController extends Controller{
    public $defaultAction = 'list';
    public $layout = 'page';
    private $page_size = 5;

    public function actionList(){
        $request = Yii::app()->request;
        $datas = array();
        $project_id = $request->getParam('id');
        $datas = array();
        if($project_id){
            //获取场景列表
            $scene_db = new Scene();
            $criteria=new CDbCriteria;
            $criteria->order = 'id ASC';
            $criteria->addCondition("project_id={$project_id}");
            $criteria->addCondition('status=1');
            $total = $scene_db->count($criteria);
            if($total>0){
                $page = $request->getParam('page')?$request->getParam('page'):0;
                $offset = $page*$this->page_size;
                $pages=new CPagination($total);
                $pages->pageSize = $this->page_size;
                $pages->route = '/project/sceneList/list';
                $criteria->limit = $this->page_size;
                $criteria->offset = $offset;
                $pages->applyLimit($criteria);
                $datas['pages'] = $pages;

                //获取场景信息
                $datas['list'] = $scene_db->findAll($criteria);

            }
        }
        $this->render('/project/sceneList', array('datas'=>$datas, 'project_id'=>$project_id));
    }
    /**
     * 获取场景列表
     */
    /* private function get_scenes_by_mp($project_list){
        $datas = array();
        $scene_ids = array();
        if(!is_array($project_list) || count($project_list)<=0){
            return $datas;
        }
        foreach ($project_list as $v){
            $scene_ids[] = $v['scene_id'];
        }
        $scene_db = Scene::model();
        $datas = $scene_db->findAllByPk($scene_ids, array('order'=>'id desc'));
        //print_r($datas);
        return $datas;
    }  */
}