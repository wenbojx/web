<?php
class ConfigController extends Controller{
    public $defaultAction = 'v';
    public $defaultType = array(
            'position', 'basic', 'preview', 'view', 'hotspot',
            'button', 'map', 'navigat', 'radar',
            'html', 'rightkey', 'link', 'flare','action','thumb'
            );
    private $pano_thumb_size = '480x240';

    public function actionV(){
        $request = Yii::app()->request;
        $datas = array();
        $scene_id = $request->getParam('scene_id');
        if(!$scene_id){
            exit('参数错误');
        }
        $datas['scene_id'] = $scene_id;
        $type = $request->getParam('t');
        if ($type == 'hotspot'){
            $datas['link_scene'] = $this->get_link_scenes($scene_id);
        }
        elseif ($type == 'thumb'){
            $datas['thumb'] = $this->get_thumb($scene_id);
        }
        if(!in_array($type, $this->defaultType)){
            exit();
        }
        $this->render('/pano/panel/'.$type, array('datas'=>$datas));
    }
    /**
     * 获取场景缩略图
     */
    private function get_thumb($scene_id){
        $thumb_db = new ScenesThumb();
        if($thumb_db->find_by_scene_id($scene_id)){
            return $this->createUrl('/panos/thumb/pic/', array('id'=>$scene_id, 'size'=>$this->pano_thumb_size.'.jpg'));
        }
        return false;
    }
    /**
     * 获取项目中的其他场景列表
     */
    private function get_link_scenes($scene_id){
        $scene_datas = array();
        if(!$scene_id){
            return $scene_datas;
        }
        //获取project_id
        $scene_db = new Scene();
        $scene_data = $scene_db->get_by_scene_id($scene_id);
        if(!$scene_data || !$scene_data->project_id){
            return $scene_datas;
        }
        $project_id = $scene_data->project_id;
        $criteria=new CDbCriteria;
        $criteria->order = 'id ASC';
        $criteria->addCondition("project_id={$project_id}");
        $criteria->addCondition("id!={$scene_id}");
        $criteria->addCondition('status=1');
        $scene_datas = $scene_db->findAll($criteria);
        return $scene_datas;
    }

}