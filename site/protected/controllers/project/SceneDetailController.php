<?php
class SceneDetailController extends Controller{
    public $defaultAction = 'detail';
    public $layout = 'scene';

    public function actionDetail(){
        $request = Yii::app()->request;
        $scene_id = $request->getParam('id');
        if(!$scene_id){
            exit('参数错误');
        }
        $datas = $this->get_scenes($scene_id);
        $this->render('/project/sceneDetail', array('datas'=>$datas));
    }
    /**
     * 获取场景信息
     */
    private function get_scenes($scene_id){
        $scene_db = new Scene();
        return  $scene_db->get_by_scene_id($scene_id);
    }
}