<?php

class RegisterController extends FController{

    public $defaultAction = 'a';
    public $layout = 'home';
    private $member_db = null;

    public function actionA(){
        $request = Yii::app()->request;
        
        $datas['page']['title'] = '免费注册';
        if($this->member_id){
        	$this->redirect(array('/pano/project'));
        }
        $this->render('/member/register', array('datas'=>$datas));
    }
    public function actionReg(){
        $request = Yii::app()->request;
        $datas['email'] = $request->getParam('email');
        $datas['passwd'] = $request->getParam('passwd');
        $datas['repasswd'] = $request->getParam('repasswd');
        $datas['nickname'] = $request->getParam('nickname');
       // $datas['code'] = $request->getParam('code');
        
        $msg['flag'] = '1';
        if($datas['email']== ''){
            $msg['flag'] = 0;
            $msg['field']['email'] = '0';
        }
        if($datas['passwd']== ''){
            $msg['flag'] = 0;
            $msg['field']['passwd'] = '0';
        }
        if($datas['repasswd'] != $datas['passwd']){
            $msg['flag'] = 0;
            $msg['field']['repasswd'] = '0';
        }
        /* if($datas['code']== ''){
            $msg['flag'] = 0;
            $msg['field']['code'] = '0';
        } */
        if($datas['nickname']== ''){
        	$msg['flag'] = 0;
        	$msg['field']['nickname'] = '0';
        }
        if($this->check_email($datas['email'])){
            $msg['flag'] = 0;
            $msg['field']['email'] = '1'; //已存在
        }
        if($this->check_nickname($datas['nickname'])){
        	$msg['flag'] = 0;
        	$msg['field']['nickname'] = '1'; //已存在
        }
        /* $code_flag = $this->check_code($datas['code']);
        if($code_flag != '1'){
            $msg['flag'] = 0;
            $msg['field']['code'] = $code_flag; //错误
        } */
        if($msg['flag']){
            $flag = $this->add_user($datas);
            if($flag){
                $msg['flag'] = 1;
                $msg['url'] = $this->createUrl('/member/login');
                //$this->overdue_code($datas['code']);
            }
            else{
                $msg['flag'] = 0;
                $msg['msg'] = 0;
            }
        }
        $this->display_msg($msg);

    }
    private function overdue_code($code){
        $code_db = new ModRegCode();
        return $code_db->overdue_code($code);
    }
    private function check_code($code=''){
        if(!$code){
            return 2;
        }
        $code_db = new ModRegCode();
        $datas = $code_db->check_code($code);
        if($datas){
            if($datas[0]['state'] ==2){
                return '3';
            }
            return '1';
        }
        return '2'; //不存在
    }
    private function check_nickname($nickname){
    	if(!$nickname){
    		return false;
    	}
    	$datas = $this->get_member_db()->find_by_nickname($nickname);
    	if($datas){
    		return true;
    	}
    	return false;
    }
    private function check_email($email = ''){
        if(!$email){
            return false;
        }
        $datas = $this->get_member_db()->find_by_email($email);
        if($datas){
            return true;
        }
        return false;
    }
    private function add_user($datas){
        return $this->get_member_db()->add_user($datas);
    }
    /**
     * @return Member
     */
    private function get_member_db(){
        if(!$this->member_db){
            $this->member_db = new Member();
        }
        return $this->member_db;
    }

}