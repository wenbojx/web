<?php

class MController extends FController{
	private $domin = 'http://www.yiluhao.com';
	private $panoFaceSize = '1024x1024';
	private $i =1;
	private $fileList = array();
	private $totalSize = 0;
	/**
	 * 获取用户项目列表
	 */
	public function actionPU(){
		$request = Yii::app()->request;
		$datas = array();
		$mid = $request->getParam('id');
		$msg['state'] = '0';
		if(!$mid){
			$this->display_msg($msg);
		}
		
		$project = $this->get_project_list($project_id, $mid);
		if(!$project){
			$this->display_msg($msg);
		}
		$msg['project'] = $project;
		$msg['state'] = '1';
		$this->display_msg($msg);
	}
	private function getUserId($userName){
		if(!$userName){
			return false;
		}
		$memberDB = new Member();
		return $memberDB->find_by_email($userName);

	}
	/**
	 * 获取用户信息
	 */
	public function actionUser(){
		$request = Yii::app()->request;
		$datas = array();
		$user_name = $request->getParam('u');
		$msg['state'] = '0';
		if(!$user_name){
			$this->display_msg($msg);
		}
		//获取用户id
		$userDatas = $this->getUserId($user_name);
		if(!$userDatas){
			$this->display_msg($msg);
		}
		$msg['state'] = '1';
		$msg['m_id'] = $userDatas['id'];
		$msg['userName'] = $userDatas['email'];
		$msg['nickname'] = $userDatas['nickname'];
		$this->display_msg($msg);
	}
	/**
	 * 项目列表
	 */
    public function actionPS(){
    	$request = Yii::app()->request;
    	$datas = array();
    	$project_id = $request->getParam('id');
    	if(!$project_id){
    		//$msg['state'] = '0';
    		//$msg['msg'] = '参数错误';
    	}
    	$msg['project'] = $this->get_project_list($project_id);
    	$this->display_msg($msg);
    }
    private function addDownFile($url, $size){
    	if(!$url){
    		return false;
    	}
    	//echo $size."<br>";
    	$i = $this->i;
    	$this->fileList[$i]['url'] = $url;
    	$this->fileList[$i]['size'] = $size;
    	$this->fileList[$i]['state'] = '1'; //1未开始，2下载中，3下载完
    	$this->i++;
    	$this->totalSize += $size;
    }
    /**
     * 项目大小及下载文件，用于下载
     */
    public function actionPD(){
    	$request = Yii::app()->request;
    	$datas = array();
    	$project_id = $request->getParam('id');
    	if(!$project_id){
    		$this->display_msg($msg);
    	}
    	$mapSize = 0;
    	$thumbSize = 0;
    	$musicSize = 0;
    	$panoFaceSize = 0;
    	$fileList = array();
    	//地图文件
    	$mapConfig = 'http://mb.yiluhao.com/ajax/m/pm/id/'.$project_id;
    	$this->addDownFile($mapConfig, 0); //地图配置文件
    	
    	$map = $this->get_scene_map($project_id);
    	$mapSize = $this->getFileSize($map);
    	$this->addDownFile($map, $mapSize); //地图图片
    	
    	$panos = $this->get_scene_list($project_id);
    	if($panos){
    		foreach ($panos as $v){
    			$panoConfig = 'http://mb.yiluhao.com/ajax/m/pv/id/'.$v['id'];
    			$this->addDownFile($panoConfig, 0);
    			
    			$thumbSize = $this->getFileSize($v['thumb']);
    			$this->addDownFile($v['thumb'], $thumbSize);
    			
    			$musicPath = $this->sceneMusic($v['id']);
    			$musicSize = $this->getFileSize($musicPath);
    			$this->addDownFile($musicPath, $musicSize);
    			
    			$size = $this->panoFaceSize;
    			$s_f = PicTools::get_face_small($v['id'], 's_f' , $size);
    			$s_r = PicTools::get_face_small($v['id'], 's_r' , $size);
    			$s_b = PicTools::get_face_small($v['id'], 's_b' , $size);
    			$s_l = PicTools::get_face_small($v['id'], 's_l' , $size);
    			$s_u = PicTools::get_face_small($v['id'], 's_u' , $size);
    			$s_d = PicTools::get_face_small($v['id'], 's_d' , $size);
    			$sfSize = $this->getFileSize($s_f);
    			$this->addDownFile($s_f, $sfSize);
    			
    			$srSize = $this->getFileSize($s_r);
    			$this->addDownFile($s_r, $srSize);
    			
    			$sbSize = $this->getFileSize($s_b);
    			$this->addDownFile($s_b, $sbSize);
    			
    			$slSize = $this->getFileSize($s_l);
    			$this->addDownFile($s_l, $slSize);
    			
    			$suSize = $this->getFileSize($s_u);
    			$this->addDownFile($s_u, $suSize);
    			
    			$sdSize = $this->getFileSize($s_d);
    			$this->addDownFile($s_d, $sdSize);
    			
    		}
    	}
    	$msg['size'] = $this->totalSize;
    	$msg['files'] = $this->fileList;
    	$msg['state'] = 1;
    	$this->display_msg($msg);
    }
    public function getFileSize($url){
    	$size = 0;
    	if(!$url){
    		return $size;
    	}
    	$filePath = str_replace($this->domin, '.', $url);
    	if(!file_exists($filePath)){
    		return $size;
    	}
    	$size = filesize($filePath);
    	return $size;
    }
    /**
     * 场景列表
     */
    public function actionPL(){
    	$request = Yii::app()->request;
    	$datas = array();
    	$project_id = $request->getParam('id');
    	$msg['panos'] = array();
    	//$msg['map'] = '';
    	if(!$project_id){
    		$this->display_msg($msg);
    	}
    	$msg['panos'] = $this->get_scene_list($project_id);
    	//$msg['map'] = $this->get_scene_map($project_id);
    	$project_datas = $this->getProjectInfo($project_id);
    	$msg['info'] = $project_datas['desc'];
    	$msg['level'] = $project_datas['level'];
    	//$msg['display'] = 
    	//print_r($msg);
    	$this->display_msg($msg);
    }
    /**
     * 场景详细
     */
    public function actionPV(){
    	$request = Yii::app()->request;
    	$datas = array();
    	$scene_id = $request->getParam('id');
    	$msg['pano'] = array();
    	if(!$scene_id){
    		$this->display_msg($msg);
    	}
    	$msg['pano'] = $this->get_scene_data($scene_id);
    	$msg['hotspots'] = $this->get_scene_hotspots($scene_id);
    	$msg['camera'] = $this->getCameraInfo($scene_id);
    	$msg['music'] = $this->sceneMusic($scene_id);
    	//print_r($msg);
    	$this->display_msg($msg);
    }
    private function getCameraInfo($scene_id){
    	$panoramDB = new ScenesPanoram();
    	$panoramDatas = $panoramDB->find_by_scene_id($scene_id);
    	$camera = array('vlookat'=>0);
    	$camera = array('hlookat'=>0);
    	$camera = array('atvmin'=>-90);
    	$camera = array('atvmax'=>90);
    	$camera = array('athmin'=>-180);
    	$camera = array('athmax'=>180);
    	$datas = array();
    	if($panoramDatas && $panoramDatas['content']){
    		$data = json_decode($panoramDatas['content'], true);
    		//print_r($data);
    		if($data['s_attribute']['camera']){
    			$explode_1 = explode(',', $data['s_attribute']['camera']);
    			if($explode_1){
	    			foreach ($explode_1 as $v){
	    				$explode_2 = explode(':', $v);
	    				$datas[$explode_2[0]] = $explode_2[1];
	    			}
    			}
    			$camera['vlookat'] = $datas['tilt'] && $datas['tilt']!='NaN'?$datas['tilt']:0;
    			$camera['hlookat'] = $datas['pan'] && $datas['pan']!='NaN' ?$datas['pan']:0;
    			$camera['atvmin'] = $datas['minTilt']&& $datas['minTilt']!='NaN' ?$datas['minTilt']:-90;
    			$camera['atvmax'] = $datas['maxTilt']&& $datas['maxTilt']!='NaN' ?$datas['maxTilt']:90;
    			$camera['athmin'] = $datas['minPan']&& $datas['minPan']!='NaN' ?$datas['minPan']:-180;
    			$camera['athmax'] = $datas['maxPan']&& $datas['maxPan']!='NaN' ?$datas['maxPan']:180;
    		}
    	}
    	return $camera;
    }
    private function sceneMusic($scene_id){
    	
    	$music_db = new MpSceneMusic();
    	$music_datas = $music_db->get_by_scene_id($scene_id, 1);
    	//print_r($music_datas);
    	$file_id = $music_datas['file_id'];
    	if(!$file_id){
    		return '';
    	}
    	$file_path_db = new FilePath();
    	$file_datas = $file_path_db->get_by_file_id($file_id);
    	//print_r($file_datas);
    	return PicTools::get_pano_music($scene_id, $file_datas['type']);
    }
    /**
     * 地图json
     */
    public function actionPM(){
    	$request = Yii::app()->request;
    	$datas = array();
    	$project_id = $request->getParam('id');
    	if($project_id){
    		$datas['coords'] = $this->get_map_position($project_id, 'json');
    		$datas['map'] = $this->get_scene_map($project_id);
    	}
    	//print_r($datas);
    	$this->display_msg($datas);
    }
    /**
     * 地图XML
     */
    public function actionMP(){
    	$request = Yii::app()->request;
    	$datas = array();
    	$project_id = $request->getParam('id');
    	$str = '<?xml version="1.0" encoding="utf-8"?><maps><map name="map">';
    	if($project_id){
    		$str .= $this->get_map_position($project_id);
    	}
    	$str .= '</map></maps>';

    	echo $str;
    }
    /**
     * 获取项目信息
     */
    private function getProjectInfo($project_id){
    	$projectDB = new Project();
    	$projectData = $projectDB->find_by_project_id($project_id);
    	if(!$projectData){
    		return '';
    	}
    	return $projectData;
    }
    private function get_map_position($project_id, $type="xml"){
    	$str = '';
    	$map_db = new ProjectMap();
    	$map_datas = $map_db->get_map_info($project_id);
    	$map_positon = $map_datas['position'];
    	$positionData = array();
    	if(!$map_positon){
    		return $type=='xml' ? $str : $positionData;
    	}
    	$positionData = array();
    	$i = 0;
    	foreach($map_positon as $v){
    		$p11 = $v['left'] -15;
    		$p12 = $v['top'] - 20;
    		$p21 = $v['left'] +15;
    		$p22 = $v['top'] -20;
    		$p31 = $v['left'] -15;
    		$p32 = $v['top'] +20;
    		$p41 = $v['left'] +15;
    		$p42 = $v['top'] +20;
    		if ($type == 'xml'){
    			$str .= "<area shape=\"poly\" link=\"{$v['scene_id']}\" coords=\"{$p11},{$p12},{$p21},{$p22},{$p41},{$p42},{$p31},{$p32}\" id=\"@+id/area{$v['id']}\" name = \"{$map_datas['link_scenes'][$v['scene_id']]['name']}\"/>";
    		}
    		else{
    			$positionData[$i]['linkScene'] = $v['scene_id'];
    			$positionData[$i]['linkTitle'] = $map_datas['link_scenes'][$v['scene_id']]['name'];
    			$positionData[$i]['coords'] = "{$p11},{$p12},{$p21},{$p22},{$p41},{$p42},{$p31},{$p32}";
    			$i++;
    		}
    		
    	}
    	return $type=='xml' ? $str : $positionData;
    }
    /**
     * 获取场景信息
     */
    private function get_scene_data($scene_id){
    	$sceneDB = new Scene();
    	$datas = $sceneDB->get_by_scene_id($scene_id);
    	if(!$datas){
    		return false;
    	}
    	$sceneData = array();
    	$sceneData['id'] = $datas['id'];
    	$sceneData['id'] = $datas['id'];
    	$sceneData['title'] = $datas['name'];
    	$sceneData['info'] = $datas['desc'];
    	$sceneData['state'] = 1;
    	$size = $this->panoFaceSize;
    	$sceneData['s_f'] = PicTools::get_face_small($scene_id, 's_f' , $size);
    	$sceneData['s_r'] = PicTools::get_face_small($scene_id, 's_r' , $size);
    	$sceneData['s_b'] = PicTools::get_face_small($scene_id, 's_b' , $size);
    	$sceneData['s_l'] = PicTools::get_face_small($scene_id, 's_l' , $size);
    	$sceneData['s_u'] = PicTools::get_face_small($scene_id, 's_u' , $size);
    	$sceneData['s_d'] = PicTools::get_face_small($scene_id, 's_d' , $size);
    	return $sceneData;
    }
    /**
     * 获取地图
     */
    private function get_scene_map($project_id){
    	$map_db = new ProjectMap();
    	$map_datas = $map_db->get_map_info($project_id);
    	if(!$map_datas){
    		return "nomap";
    	}
    	$map_id = $map_datas['map']['id'];
    	$mapUrl = PicTools::get_pano_map($project_id, $map_id);
    	//echo $mapUrl;
    	//echo 111;
    	if($mapUrl){
    		return $mapUrl;
    	}
    	else{
    		return "nomap";
    	}
    }
    /**
     * 获取场景热点
     */
    private function get_scene_hotspots($scene_id){
    	$hotspots = array();
    	if(!$scene_id){
    		return $hotspots;
    	}
    	$hotspotsDB = new ScenesHotspot();
    	$hotspots = $hotspotsDB->get_scene_hotspots($scene_id);
    	//print_r($hotspots);
    	if(!$hotspots){
    		return array();
    	}
    	foreach($hotspots as $k=>$v){
    		if($v['type'] == 4){
    			$hotspots[$k]['file_path'] = PicTools::get_img_hotspot_path($v['scene_id'], $v['id']);
    		}
    	}
    	return $hotspots;
    }
    /**
     * 获取场景信息
     */
    private function get_scene_list($project_id){
    	$order = 'id ASC';
    	$sceneDB = new Scene();
    	$datas =  $sceneDB->find_scene_by_project_id($project_id, 0, $order, 0);
    	if(!$datas){
    		return array();
    	}
    	$sceneDatas = array();
    	$i = 0;
    	foreach($datas as $v){
    		$sceneDatas[$i]['id'] = $v['id'];
    		$sceneDatas[$i]['title'] = $v['name'];
    		$sceneDatas[$i]['info'] = $v['desc'];
    		$sceneDatas[$i]['created'] = date(' Y-m-d H : i ', $v['created']);
    		//$sceneDatas[$i]['thumb'] = PicTools::get_pano_small($v['id'] , '200x100');
    		$sceneDatas[$i]['thumb']  = PicTools::get_pano_thumb($v['id'] , '150x110');
    		
    		$sceneDatas[$i]['thumb-w'] = 150;
    		$sceneDatas[$i]['thumb-h'] = 110;
    		$sceneDatas[$i]['state'] = 1;
    		$size = 2;
    		$sceneDatas[$i]['size'] = $size;
    		$i++;
    	}
    	return $sceneDatas;
    }
    /**
     * 获取全景图状态
     */
    private function get_project_list($project_id, $m_id=0){
    	$projectDB = new Project();
    	$order = 'id desc';
    	if(!$m_id){
    		$project_list = $projectDB->get_project_list(10, $order, 0, 3);
    	}
    	else{
    		$project_list = $projectDB->get_project_list_mid(0, $order, 0, 3, $m_id, 0);
    	}
    	//print_r($project_list);
    	if(!$project_list){
    		return false;
    	}
    	$datas = array();
    	$i = 0;
    	foreach($project_list as $v){
    		$datas[$i]['id'] = $v['id'];
    		$datas[$i]['title'] = $v['name'];
    		//$datas[$i]['info'] = $v['desc'];
    		$datas[$i]['created'] = date(' Y 年 m 月 d 日', $v['created']);
    		$datas[$i]['state'] = 1;
    		$datas[$i]['count'] = $this->get_scene_num($v['id']);
    		$thumb_scene_id = $this->get_thumb_scene_id($v['id']);
    		$datas[$i]['thumb'] = PicTools::get_pano_thumb($thumb_scene_id , '150x110');
    		$i++;
    	}
    	//print_r($datas);
    	return $datas;
    }
    private function get_scene_num($project_id){
    	if(!$project_id){
    		return 0;
    	}
    	$scene_db = new Scene();
    	return $scene_db->get_scene_num($project_id);
    }
    /**
     * 获取项目的默认缩略图
     */
    private function get_thumb_scene_id($project_id){
    	if(!$project_id){
    		return false;
    	}
    	$projectDB = new Project();
    	return $projectDB->get_thumb_scene_id($project_id);
    }
}





