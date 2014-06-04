<?php
class IndexController extends Controller{
    public $defaultAction = 'a';
    public $layout = 'skin';
    public $editPano = false;

    public function actionA(){
        $request = Yii::app()->request;
        
        $datas['page_title'] = '编辑皮肤';
        $this->render('/skin/index', array('datas'=>$datas));
    }
 
}