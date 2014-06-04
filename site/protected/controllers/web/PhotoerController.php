<?php
class PhotoerController extends FController{
    public $defaultAction = 'a';
    public $layout = 'home';
    public function actionA(){
    	$datas = array();
        $this->render('/web/photoer', array('datas'=>$datas));
    }
}