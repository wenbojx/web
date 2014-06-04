<?php
class PositionController extends Controller{
    public function actionSave(){
        $request = Yii::app()->request;
        $scene_id = $request->getParam('scene_id');
        $datas['scene_id'] = $scene_id;
        $this->check_scene_own($scene_id);
        $datas['glat'] = $request->getParam('glat');
        $datas['glng'] = $request->getParam('glng');
        $datas['gzoom'] = $request->getParam('zoom');
        //百度地址
        $datas_baidu = $this->get_baidu_position($datas);
        $datas['blng'] = $datas_baidu['blng'];
        $datas['blat'] = $datas_baidu['blat'];
        $datas['bzoom'] = $datas['gzoom'];
        $id = $this->save_datas($datas);
        $msg['flag'] = 1;
        $msg['msg'] = '操作成功';
        if(!$id){
            $msg['flag'] = 0;
            $msg['msg'] = '操作失败';
            $this->display_msg($msg);
        }
        $this->display_msg($msg);
    }
    private function save_datas($datas){
        $position_db = new ScenesPosition();
        return $position_db->save_position($datas);
    }
    private function get_baidu_position($datas){
        $baidu_position = array('blng'=>0, 'blat'=>0);
        $map_obj = new MapTools();
        $datas = $map_obj->convert($datas);
        if(!$datas){
            return $baidu_position;
        }
        $baidu_position['blng'] = $datas['blng'];
        $baidu_position['blat'] = $datas['blat'];
        return $baidu_position;
    }
}