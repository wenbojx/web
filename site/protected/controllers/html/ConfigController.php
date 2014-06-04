<?php
class ConfigController extends FController{
    public $defaultAction = 'a';
    public $layout = 'htmlConfig';
    public $player = true;
    private $scene_db = null;

    public function actionA(){
    	$request = Yii::app()->request;
    	$scene_id = $request->getParam('id');
    	
    	$scene_datas = $this->get_scene_info($scene_id);
    	$project_id = 0;
    	if($scene_datas){
    		$project_id = $scene_datas['project_id'];
    	}

    	$memcache_obj = new Ymemcache();
    	$key = $memcache_obj->get_pano_html_xml_key($project_id, false);
    	//$key = 0;
    	$content = $memcache_obj->get_mem_data($key);
    	//print_r($datas);
    	if($content == '' || !$content || $content == null){
	    		$datas['scene_list'] = $this->get_pano_list($project_id);
	    		$scene_ids = array();
	    		if(is_array($datas['scene_list'])){
	    			$scene_ids = array_keys($datas['scene_list']);
	    		}
	    		$scene_info = $this->get_pano_infos($scene_ids);
	    		$datas['scene_info'] = array();
	    		if($datas['scene_list']){
	    			$datas['scene_info'] = $this->format_info($scene_info, $datas['scene_list']);
	    		}
	    		//print_r($datas['scene_info']);
	    		$hotspots = $this->get_hotspots($scene_ids);
	    		$datas['hotspot'] = $this->format_hotspot($datas['scene_list'], $hotspots);
	    		$content = serialize($datas);
	    		$memcache_obj->set_mem_data($key, $content, 0);
    	}
    	else{
    		header('mcache: cached');
    		$datas = unserialize($content);
    	}
    	$datas['scene_id'] = $scene_id;
    	
        $this->render('/html/config', array('datas'=>$datas));
    }
    /**
     * 获取project_id
     */
    private function get_scene_info($scene_id){
    	$scene_db = new Scene();
    	return $scene_db->get_by_scene_id($scene_id);
    }
    /**
     * 处理热点
     */
    private function format_hotspot($scene_list, $hotspots){
    	$hotspot_datas = array();
    	foreach($scene_list as $k=>$v){
    		//print_r($hotspots[$k]);
    		//$hotspot = $hotspots[$k];
    		if(isset($hotspots[$k])){
	    		foreach($hotspots[$k] as $k1=>$v1){
		    		//$hotspot_id = $hotspot[$k1]['id'];
		    		$hotspot_datas[$k][$k1]['pan'] = $v1['pan'];
		    		$hotspot_datas[$k][$k1]['tilt'] = $v1['tilt'];
		    		$hotspot_datas[$k][$k1]['type'] = $v1['type'];
		    		$hotspot_datas[$k][$k1]['link_scene_id'] = $v1['link_scene_id'];
		    		$title = '';
		    		if(isset($scene_list[$v1['link_scene_id']])){
		    			$title = $scene_list[$v1['link_scene_id']]['name'];
		    		}
		    		$hotspot_datas[$k][$k1]['title'] = $title;
	    		}
    		}
    	}
    	return $hotspot_datas;
    }
    /**
     * 处理数据
     */
    private function format_info($scene_info, $scene_list){
    	$scene_datas = array();
    	foreach ($scene_list as $k=>$v){
    		if(isset($scene_info[$k])){
    			$pano_info = $scene_info[$k];
    		}
    		$attribute = array();
    		$pan = 0;
    		$tilt = 0;
    		$fov = 90;
    		if (isset($pano_info['content']) && $pano_info['content']){
    			$attribute = @json_decode($pano_info['content'],true);
    			if(isset($attribute['s_attribute']['camera'])){
    				$explodes = explode(',', $attribute['s_attribute']['camera']);
    				foreach ($explodes as $v){
    					$explode_1 = explode(':', $v);
    					$$explode_1[0] = $explode_1[1];
    				}
    			}
    		}
    		
    		$scene_datas[$k]['pan'] = $pan;
    		$scene_datas[$k]['tilt'] = $tilt;
    		$scene_datas[$k]['fov'] = $fov;
    	}
    	//print_r($scene_datas);
    	return $scene_datas;
    }
    /**
     * 获取热点信息
     */
    private function get_hotspots($scene_ids){
    	$hotspot_db = new ScenesHotspot();
    	$hotspot_datas = $hotspot_db->find_by_scene_ids($scene_ids);
    	$datas = array();
		if($hotspot_datas){
	    	foreach($hotspot_datas as $v){
	    		$datas[$v['scene_id']][$v['id']] = $v;
	    	}
		}
    	return $datas;
    }
    /**
     * 获取场景信息
     */
    private function get_pano_infos($scene_ids){
    	if(!$scene_ids){
    		return false;
    	}
    	$panoram_db = new ScenesPanoram();
    	$panoram_datas = $panoram_db->find_by_scene_ids($scene_ids);
    	return $panoram_datas;
    }
    /**
     * 获取场景列表
     */
   private function get_pano_list($project_id){
   	$scene_db = new Scene();
   	$scene_datas = $scene_db->find_scene_by_project_id($project_id, 0, '', 0, 1, 2);
   	if(!$scene_datas){
   		return false;
   	}
   	//print_r($scene_datas);
   	return $scene_datas;
   }
}