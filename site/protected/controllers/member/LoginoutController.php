<?php

class LoginoutController extends NoLoginController{

    public $defaultAction = 'a';
    //public $layout = 'default';

    public function actionA(){
        unset(Yii::app()->session['userinfo']);
        $this->login_state();
    }

    private function login_state(){
    	$this->redirect(array('web/index'));
    	return false;
        /* if(Yii::app()->session['userinfo']){
            $this->redirect(array('web/index'));
        }
        $this->redirect(array('member/login'));
        return false; */
    }
}