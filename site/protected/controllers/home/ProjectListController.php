<?php
class ProjectListController extends Controller{
    public $defaultAction = 'list';
    public $layout = 'page';

    /* public function __construct(){
        $this->check_admin();
        $this->month = Yii::app()->session['userinfo']['month'];
        $this->year = Yii::app()->session['userinfo']['year'];
        //print_r(Yii::app()->session['userinfo']);
        $this->language = Yii::app()->session['userinfo']['language'];
    } */

    public function actionList(){
        $datas = array();
        $member_id = $this->member_id;
        //获取项目列表
        $datas['list'] = Project::model()->get_project_list($member_id);
        $count = Project::model()->count;

        $pager = new CPagination($count);
        $pager->pageSize = 10;
        $pager->applyLimit(2);
        $datas['pager'] = $pager;

        //var_dump($datas);
        $this->render('/home/projectList', array('datas'=>$datas));
    }
}