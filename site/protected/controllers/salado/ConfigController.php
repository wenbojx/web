<?php
class ConfigController extends Controller{
    public $defaultAction = 'xml';
    //public $layout = 'scene';

    public function actionXml(){
        $request = Yii::app()->request;
        $datas = array('content'=>0);
        $scene_id = $request->getParam('id');
        $this->render('/salado/xml', array('datas'=>$datas));
    }
    public function actionXml2(){
        $request = Yii::app()->request;
        $datas = array('content'=>0);
        $scene_id = $request->getParam('id');
        $this->render('/salado/xml2', array('datas'=>$datas));
    }

}