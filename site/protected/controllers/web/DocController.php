<?php
class DocController extends FController{
    public $defaultAction = 'a';
    public $layout = 'home';
    public $pageName = '0';
    
    public function actionA(){
    	$datas = array();
        $this->render('/web/doc/doca', array('datas'=>$datas));
    }
    public function actionB(){
    	$datas = array();
    	$this->render('/web/doc/docb', array('datas'=>$datas));
    }
}