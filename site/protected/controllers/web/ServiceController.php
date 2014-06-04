<?php
class ServiceController extends FController{
    public $defaultAction = 'a';
    public $layout = 'home';
    private $baner_scene_id = '10223';
    public $pageName = '10';
    
    public function actionA(){
    	$datas = array();
    	$datas['baner_scene_id'] = $this->baner_scene_id;
        $this->render('/web/service', array('datas'=>$datas));
    }
}