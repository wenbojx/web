<?php
class MainController extends Controller{
    public $defaultAction = 'main';
    public $layout = 'main';

    /* public function __construct(){
        $this->check_admin();
        $this->month = Yii::app()->session['userinfo']['month'];
        $this->year = Yii::app()->session['userinfo']['year'];
        //print_r(Yii::app()->session['userinfo']);
        $this->language = Yii::app()->session['userinfo']['language'];
    } */

    public function actionMain(){
        $datas = array();
        $this->render('/home/main', array('datas'=>$datas));
    }

    private function get_in_datas($year, $month, $page){

    }
}