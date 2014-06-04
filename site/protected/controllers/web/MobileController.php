<?php
class MobileController extends FController{
    public $defaultAction = 'a';
    public $layout = 'home';
    public $pageName = '11';
    
    public function actionA(){
    	$datas = array();
    	
        $this->render('/web/mobile', array('datas'=>$datas));
    }
}