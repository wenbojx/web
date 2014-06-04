<?php
class SaladoController extends Controller{
    public $defaultAction = 'edit';
    public $layout = 'home';
    public $editPano = false;

    public function actionEdit(){
        $request = Yii::app()->request;
        $this->editPano = true;
        $scene_id = $request->getParam('id');
        $clean = $request->getParam('clean');
        $this->check_scene_own_msg($scene_id);
        if(!$scene_id){
            exit('参数错误');
        }
        if($clean){
            $this->clean_cache($scene_id);
            exit();
        }
        $datas['pano'] = $this->get_scene($scene_id);
        ////获取场景对应文件信息
        //$datas['tag'] = $this->get_scene_file_tag($scene_id);
        
        //print_r($datas);
        $datas['page_title'] = '编辑全景图';
        $this->render('/pano/panoEdit', array('datas'=>$datas));
    }
    
    /**
     * 清理缓存并跳转
     */
    private function clean_cache($scene_id){
        $memcache_obj = new Ymemcache();
        $key = $memcache_obj->get_pano_xml_key($scene_id, true);
        $memcache_obj->rm_mem_datas($key);
        $key = $memcache_obj->get_pano_xml_key($scene_id, false);
        $memcache_obj->rm_mem_datas($key);
        $this->redirect(array('pano/salado/edit/','id'=>$scene_id));
    }
    
    /**
     * 获取场景信息
     */
    private function get_scene($scene_id){
        $scene_db = new Scene();
        return  $scene_db->get_by_scene_id($scene_id);
    }
}