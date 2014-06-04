<?php
Yii::import('application.extensions.image.Image');
class SaladoPlayer{
    private $modules_path = '';
    private $modules_media_path = '';
    private $admin = false;
    public $display_config = array();

    public function __construct(){
        $this->modules_path = Yii::app()->baseUrl.'/pages/salado/modules/';
        $this->modules_media_path = Yii::app()->baseUrl.'/pages/salado/media/';
    }
    public function set_modules_path($path = ''){
        if($path == ''){
            return false;
        }
        return $this->modules_path = $path;
    }
    public function get_modules_path(){
        return $this->modules_path;
    }
    public function set_modules_media_path($path = ''){
        if($path == ''){
            return false;
        }
        return $this->modules_media_path = $path;
    }
    public function get_modules_media_path(){
        return $this->modules_media_path;
    }
    public function build_attribute($attribute){
        if(!is_array($attribute)){
            return '>';
        }
        $str = ' ';
        if(is_array($attribute)){
            foreach ($attribute as $k=>$v){
                $str .= "{$k}='{$v}' ";
            }
        }
        $str = substr($str, 0, (strlen($str)-1));
        return $str.'>';
    }

    private function config_start(){
        $player_info = '<SaladoPlayer>';
        return $player_info;
    }
    private function config_end(){
        $player_info = '</SaladoPlayer>';
        return $player_info;
    }

    public function get_config_content($id, $admin=false){
    	if(!$id){
    		return false;
    	}
    	$content = $admin ? $this->get_admin_content($id) : $this->get_single_content($id);
        return $content;
    }
    public function get_single_config($id){
    	$content = $this->get_single_content($id);
    	return $content;
    }
    private function get_single_content($id){
    	$admin = 0;
    	$memcache_obj = new Ymemcache();
    	$key = $memcache_obj->get_pano_xml_key($id.'_s', false);
    	//$key = 0;
    	if( $content = $memcache_obj->get_mem_data($key)){
    		header('mcache: cached');
    		return $content;
    	}
    	else{
    		$panodatas_obj = new PanoSingleDatas();   		
    		$panodatas_obj->display_config = $this->display_config;
    		$panodatas = $panodatas_obj->get_panoram_datas($id);
    		$content = $this->config_start();
    		$content .= $this->config_global($panodatas['global']);
    		
    		$content .= $this->config_panoramas($panodatas['panorams']);
    		
    		$content .= $this->config_modules($panodatas['modules']);
    		
    		$content .= $this->config_actions($panodatas['actions']);
    		
    		$content .= $this->config_end();
    		//echo $content;
    		$memcache_obj->set_mem_data($key, $content, 0);
    	}
    	return $content;
    }
    private function get_user_content($id){
    	$admin = 0;
    	$memcache_obj = new Ymemcache();
    	$key = $memcache_obj->get_pano_xml_key($id, false);
    	if($content = $memcache_obj->get_mem_data($key)){
    		header('mcache: cached');
    		return $content;
    	}
    	else{
    		$panodatas_obj = new PanoramDatas();
    		$panodatas_obj->display_config = $this->display_config;
    		$panodatas = $panodatas_obj->get_panoram_datas($id);
    		$content = $this->config_start();
    		$content .= $this->config_global($panodatas['global']);
    		$content .= $this->config_panoramas($panodatas['panorams']);
    		$content .= $this->config_modules($panodatas['modules']);
    		$content .= $this->config_actions($panodatas['actions']);
    		$content .= $this->config_end();
    		$memcache_obj->set_mem_data($key, $content, 0);
    	}
    	return $content;
    }
    private function get_admin_content($id){
    	$memcache_obj = new Ymemcache();
    	$key = $memcache_obj->get_pano_xml_key($id, true);
    	if($content = $memcache_obj->get_mem_data($key)){
    		header('mcache: cached');
    		return $content;
    	}
    	else{
    		$panodatas_obj = new PanoramAdminDatas();
    		$panodatas = $panodatas_obj->get_panoram_datas($id);
    		//$this->admin = $admin;
    		$content = $this->config_start();
    		$content .= $this->config_global($panodatas['global']);
    		$content .= $this->config_panoramas($panodatas['panorams']);
    		$content .= $this->config_modules($panodatas['modules']);
    		$content .= $this->config_actions($panodatas['actions']);
    		$content .= $this->config_end();
    		$memcache_obj->set_mem_data($key, $content, 0);
    	}
    	return $content;
    }
    private function config_global($global){
        $global_str = '';
        if(!is_array($global) || count($global)<1){
            return $global_str;
        }
        //全局信息
        $global_obj = new SaladoGlobal();
        $global_str = $global_obj->get_global_info($global);
        return $global_str;
    }
    public function config_panoramas($panorams){
        $panoram_str = '';
        if(!is_array($panorams) || count($panorams)<1){
            return $panoram_str;
        }
        $panoram_obj = new SaladoPanoramas();
        $panoram_str = $panoram_obj->get_panorams_info($panorams);
        return $panoram_str;
    }
    public function config_modules($modules){
        $modules_str = '';
        if(!is_array($modules) || count($modules)<1){
            return $modules_str;
        }
        $modules_obj = new SaladoModules();
        $modules_obj->admin = $this->admin;
        $modules_str = $modules_obj->get_modules_info($modules);
        return $modules_str;
    }
    public function config_actions($actions){
        $actions_str = '';
        if(!is_array($actions) || count($actions)<1){
            return $actions_str;
        }
        $actions_obj = new SaladoActions();
        $actions_str = $actions_obj->get_actions_info($actions);
        return $actions_str;
    }
}
