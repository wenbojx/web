<?php

class InterfaceController extends Controller{
    public $defaultAction = 'run';
    public $month = '';
    public $year = '';

    public function actionRun(){
        $request = Yii::app()->request;
        $this->month = Yii::app()->session['userinfo']['month'];
        $this->year = Yii::app()->session['userinfo']['year'];
        if($request->getParam ( 'type' ) == 'add_field'){
            $params = $request->getParam('datas');
            $field = $request->getParam('field');
            $this->add_field($field, $params);
        }
        elseif($request->getParam ( 'type' ) == 'get_field'){
            $field = $request->getParam('field');
            $this->get_field($field);
        }
        elseif($request->getParam ( 'type' ) == 'save_lang'){
            $datas = $request->getParam('datas');
            $this->save_lang($datas);
            $this->show_result(1, '', '');
        }
        elseif ($request->getParam ( 'type' ) == 'get_lang'){
            $datas = $this->get_lang();
            if(!$datas){
                $this->show_result(0, '', 'error');
            }
            $this->show_result(1, $datas, '');
        }
        elseif ($request->getParam ( 'type' ) == 'get_sign_lang'){
            $lang = $request->getParam('lang');
            $field = $request->getParam('field');
            $datas = $this->get_sign_lang( $lang, $field);
            if(!$datas){
                $this->show_result(0, '', 'error');
            }
            $this->show_result(1, $datas, '');
        }

        $get_datas = $request->getParam ( 'datas' );
        $type = $request->getParam('data_type');
        if(!$this->month || !$this->year){
            $this->show_result(0, '', 'error');
        }
        if ($request->getParam ( 'type' ) == 'save'){
            $this->save_datas($get_datas, $type);
        }
        elseif($request->getParam ( 'type' ) == 'get'){
            $this->get_datas($type);
        }
    }
    private function get_sign_lang($lang, $field){
        if(!$lang || !$field || !$lang_datas = $this->get_lang()){
            return false;
        }
        //筛选数据
        if(!$lang_datas){
            return false;
        }
        $num = substr($field, 4, strlen($field));
        $map = array('6'=>'7','7'=>'8','8'=>'9','9'=>'9','10'=>'9','11'=>'9','12'=>'9','13'=>'9',
                '15'=>'10','16'=>'10','17'=>'10','18'=>'10','20'=>'12','21'=>'13','22'=>'14');
        $num = $map[$num];
        $langs = array();
        foreach($lang_datas as $k=>$v){
            $title = "{$lang}_lang_{$num}";
            $lable = "{$lang}_lang_{$field}";
            if($title == $k){
                $langs['title'] = $v;
            }
            if($lable == $k){
                $langs['lable'] = $v;
            }
        }
        return $langs;
    }
    private function get_lang(){
        $file = './protected/data/lang.inc';
        $str = file_get_contents($file);
        if(!$str){
            return false;
        }
        $datas = json_decode($str, true);
        if(!$datas){
            return false;
        }
        return $datas;
    }
    private function save_lang($datas){
        $file = './protected/data/lang.inc';
        unset($datas['save_lang']);
        $datas_str = json_encode($datas);
        file_put_contents($file, $datas_str);
    }
    private function get_field($field){
        if(!$field){
            $this->show_result(0, '', 'error');
        }
        $where['year'] = $this->year;
        $where['month'] = $this->month;
        $where['field'] = $field;
        //print_r($where);
        $datas = Fields::model()->findByAttributes($where);
        $datas = json_decode($datas['datas'], true);
        if(!$datas){
            $this->show_result(0, '', '');
        }
        $this->show_result(1, $datas, '');
    }
    private function add_field($field, $datas){
        if(!$datas || !$field){
            $this->show_result(0, '', 'error');
        }
        $in_datas = array();
        foreach ($datas as $k=>$v){
            $fields_key = explode('_', $k);
            $field_key = $fields_key[2];
            if($fields_key[1] == 'title'){
                $in_datas['title'][$field_key] = $v;
            }
            elseif($fields_key[1] == 'no'){
            	$in_datas['no'][$field_key] = $v;
            }
            else{
                $in_datas['price'][$field_key] = $v;
            }
        }
        $pirce_total = 0;
        foreach ($in_datas['title'] as $k=>$v){
            $pirce_total += $field_datas[$v];
        }
        $datas_str = json_encode($in_datas);
        $where['field'] = $field;
        $where['year'] = $this->year;
        $where['month'] = $this->month;

        if( $get_datas = Fields::model()->findByAttributes($where) ){
            $id = $get_datas->id;
            Fields::model()->updateByPk($id, array('datas'=>$datas_str)) ;
        }
        else{
            $field_mod = new Fields();
            $field_mod->field = $field;
            $field_mod->datas = $datas_str;
            $field_mod->month = $this->month;
            $field_mod->year = $this->year;
            if(!$id = $field_mod->save()){
                $this->show_result(0, '', 'error');
            }
        }
        unset($datas);
        $datas = array();
        if($id){
            $list_datas = Fields::model()->findByPk($id);
            if($list_datas && $list_datas['datas']){
                $datas = json_decode($list_datas['datas'], true);
            }
        }
        $this->show_result(1, $datas, $pirce_total);
    }
    /**
     * 保存数据
     */
    private function save_datas($datas, $type){
        if(!$type){
            $this->show_result(0, '', 'error');
        }
        $where['type'] = $type;
        $where['year'] = $this->year;
        $where['month'] = $this->month;
        $datas_str = json_encode($datas);
        if( $get_datas = Datas::model()->findByAttributes($where) ){
            $id = $get_datas->id;
            Datas::model()->updateByPk($id, array('content'=>$datas_str)) ;
        }
        else{
            $datas_mod = new Datas();
            $datas_mod->type = $type;
            $datas_mod->month = $this->month;
            $datas_mod->year = $this->year;
            $datas_mod->content = $datas_str;
            if(!$id = $datas_mod->save()){
                $this->show_result(0, '', 'error');
            }
        }
        unset($datas);
        $datas = array();
        if($id){
            $list_datas = Datas::model()->findByPk($id);
            //echo $list_datas->content;
            if($list_datas && $list_datas['content']){
                $datas = json_decode($list_datas['content'], true);
            }
        }
        $this->show_result(1, $datas, '');
    }
    /**
     * 获取数据
     */
    private function get_datas($type){
        if($type == 'all'){
            return $this->get_all_datas();
        }
        $where['year'] = $this->year;
        $where['month'] = $this->month;
        $where['type'] = $type;
        $datas = Datas::model()->findByAttributes($where);
        $datas = json_decode($datas['content'], true);
        if(!$datas){
            $this->show_result(0, '', '');
        }
        $this->show_result(1, $datas, '');
    }
    private function get_all_datas(){
        $where['year'] = $this->year;
        $where['month'] = $this->month;
        $datas = Datas::model()->findByAttributes($where);
        if(!$datas){
            $this->show_result(0, '', '');
        }
        $all_datas = array();
        foreach($datas as $v){
            $all_datas[$v['type']] = json_decode($v['content'], true);
        }
        //$return['']
    }
    /**
     * 输出结果
     */
    private function show_result($result, $datas, $msg){
        $data['result'] = $result;
        $data['msg'] = $msg;
        $data['datas'] = $datas;
        echo json_encode($data);
        exit;
    }
}