<?php
class ContactController extends FController{
    public $defaultAction = 'a';
    public $layout = 'home';
    public $pageName = '12';
    
    public function actionA(){
    	$datas = array();
        $this->render('/web/contact', array('datas'=>$datas));
    }
}