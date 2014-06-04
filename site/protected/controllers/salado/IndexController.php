<?php
ini_set('memory_limit', '50M');
class IndexController extends FController{
    public $defaultAction = 'a';
    //public $layout = 'scene';
    public $img_size = 1000;
    public $tile_size = 1000;
    public $request = null;

    public function actionA(){
        $request = Yii::app()->request;
        $id = $request->getParam('id');
        $from = $request->getParam('from');
        
        $nobtb = $request->getParam('nobtb'); //是否含button_bar
        $auto = $request->getParam('auto'); //是否自动转
        $single = $request->getParam('single'); //是否自动转
        $player_width = $request->getParam('w'); //是否自动转
        $player_height = $request->getParam('h'); //是否自动转
        $config['nobtb'] = $nobtb ? false :true;
        $config['auto'] = $auto ? true :false;
        $config['single'] = $single ? true :false;
        $config['player_width'] = $player_width;
        $config['player_height'] = $player_height;
        
        if(!$id){
            exit('');
        }
        $this->actionXmla($id, $from, $config);
    }
    public function actionB(){
        $this->request = Yii::app()->request;
        $id = $this->request->getParam('id');
        $file = '500x500.jpg';
        $water_flag = false;
        if($this->request->getParam('s_f')){
        	$suffix = $this->request->getParam('s_f');
        	if($suffix == '10'){
        		$file = $this->get_tilt_folder();
        	}
            //$this->actionImage($id, 'front', $suffix, $file);
        }
        elseif($this->request->getParam('s_r')){
        	$suffix = $this->request->getParam('s_r');
        	if($suffix == '10'){
        		$file = $this->get_tilt_folder();
        	}
            $this->actionImage($id, 'right', $suffix, $file);
        }
        elseif($this->request->getParam('s_b')){
        	$suffix = $this->request->getParam('s_b');
        	if($suffix == '10'){
        		$file = $this->get_tilt_folder();
        		$rand = rand(0, 10);
        		$water_flag = $rand%2==0 ? true:false;
        	}

            $this->actionImage($id, 'back', $suffix, $file, $water_flag);
        }
        elseif($this->request->getParam('s_l')){
        	$suffix = $this->request->getParam('s_l');
        	if($suffix == '10'){
        		$file = $this->get_tilt_folder();
        		$rand = rand(0, 10);
        		$water_flag = $rand%2==0 ? true:false;
        	}

            $this->actionImage($id, 'left', $suffix, $file, $water_flag);
        }
        elseif($this->request->getParam('s_u')){
        	$suffix = $this->request->getParam('s_u');
        	if($suffix == '10'){
        		$file = $this->get_tilt_folder();
        		$rand = rand(3, 5);
        		$water_flag = $rand%2==0 ? false:true;
        	}

            $this->actionImage($id, 'up', $suffix, $file, $water_flag);
        }
        elseif($this->request->getParam('s_d')){
        	$suffix = $this->request->getParam('s_d');
        	if($suffix == '10'){
        		$file = $this->get_tilt_folder();
        	}
        	$rand = rand(2, 3);
        	$water_flag = $rand%2==0 ? false:true;
            $this->actionImage($id, 'down', $suffix, $file, $water_flag);
        }
        else{
            $this->actionXmlb($id);
        }
    }
    public function actionS(){
    	$request = Yii::app()->request;
    	$id = $request->getParam('id');
    	$from = $request->getParam('from');
    
    	$nobtb = $request->getParam('nobtb'); //是否含button_bar
    	$auto = $request->getParam('auto'); //是否自动转
    	$single = $request->getParam('single'); //是否自动转
    	$player_width = $request->getParam('w'); //是否自动转
    	$player_height = $request->getParam('h'); //是否自动转
    	//$cache = $request->getParam('cache'); //是否自动转
    	$config['nobtb'] = $nobtb ? false :true;
    	$config['auto'] = $auto ? true :false;
    	$config['single'] = $single ? true :false;
    	$config['player_width'] = $player_width;
    	$config['player_height'] = $player_height;
    
    	if(!$id){
    		exit('');
    	}
    	$this->actionXmls($id, $from, $config);
    }
    private function actionXmla($id, $from, $config){
        //获取全景信息
        $player_obj = new SaladoPlayer();
        $datas['scene_id'] = $id;
        $admin = false;
        if($from == 'admin'){
            $admin = true;
        }
        $player_obj->display_config = $config;
        $datas['content'] = $player_obj->get_config_content($id, $admin);
        $this->render('/salado/xmla', array('datas'=>$datas));
    }
    private function actionXmlb($id){
        $datas['scene_id'] = $id;
        $datas['imgSize'] = $this->img_size;
        $datas['tileSize'] = $this->tile_size;
        $this->render('/salado/xmlb', array('datas'=>$datas));
    }
    private function actionXmls($id, $from, $config){
    	//获取全景信息
    	$player_obj = new SaladoPlayer();
    	$datas['scene_id'] = $id;
    	$admin = false;
    	$player_obj->display_config = $config;
    	$datas['content'] = $player_obj->get_single_config($id);
    	$this->render('/salado/xmla', array('datas'=>$datas));
    	exit();
    }
    private function actionImage($id, $position, $suffix='', $file = '', $water= false){
        $flag = true;
        $pic_datas = array();
        if( $id && $position){
            $scene_file_db = new MpSceneFile();
            $scene_file_datas = $scene_file_db->get_file_by_scene_position($id, $position);
            if (!$scene_file_datas || !$file_id = $scene_file_datas['file_id']){
                $flag = false;
            }
            $size = $file;
        }
        else{
            $flag = false;
        }
        $img_class = new ImageContent();
        if($flag){
        	$img_class->water = $water;
        	$pic_datas = $img_class->get_img_content_by_id($file_id, $size, $suffix, true);
        }
        if(!$pic_datas){
        	//获取默认图片
        	$default_img = 'plugins/salado/default.jpg';
        	$pic_datas = $img_class->get_default_img($default_img, 'jpg');
        }
    }

}