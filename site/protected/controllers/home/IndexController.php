<?php
class IndexController extends Controller{
    public $defaultAction = 'index';
    public $layout = 'page';

    /* public function __construct(){
        $this->check_admin();
        $this->month = Yii::app()->session['userinfo']['month'];
        $this->year = Yii::app()->session['userinfo']['year'];
        //print_r(Yii::app()->session['userinfo']);
        $this->language = Yii::app()->session['userinfo']['language'];
    } */

    public function actionIndex(){
        $datas = array();
        $this->render('/home/index', array('datas'=>$datas));
    }

    private function get_in_datas($year, $month, $page){

    }
}