<?php
class ConfigController extends Controller{
    public $defaultAction = 'v';
    public $defaultType = array(
            'face', 'position', 'basic', 'camera', 'view', 'hotspot','hotspotEdit',
            'button', 'map', 'navigat', 'radar',
            'html', 'rightkey', 'link', 'flare','action','thumb','image','imageEdit','compass','music','perspect'
            );
    private $pano_thumb_size = '200x100';

    public function actionV(){
        $request = Yii::app()->request;
        $datas = array();
        $scene_id = $request->getParam('scene_id');
        if(!$scene_id){
            exit('参数错误');
        }
        $datas['scene_id'] = $scene_id;
        $type = $request->getParam('t');
        if ($type == 'hotspot'){
            $datas['link_scene'] = $this->get_link_scenes($scene_id);
        }
        elseif ($type == 'thumb'){
            $datas['thumb'] = $this->get_thumb_path($scene_id);
            $data['pano_info'] = $this->get_pano_info($scene_id);
            $datas['file_id'] = '';
            if($data['pano_info'] || $data['pano_info']['file_id']>0){
            	$datas['file_id'] = $data['pano_info']['file_id'];
            	//获取缩略图信息
            	$datas['thumb_info'] = $this->get_thumb_info($scene_id);
            	//print_r($datas['thumb_info']);
            	unset($data['pano_info']);
            }
        }
        elseif ($type == 'face'){
        	$data['pano_info'] = $this->get_pano_info($scene_id);
        	$datas['file_id'] = '';
        	if($data['pano_info'] || $data['pano_info']['file_id']>0){
        		$datas['file_id'] = $data['pano_info']['file_id'];
        		unset($data['pano_info']);
        	}
        	$datas['pano_state'] = $this->get_pano_state($scene_id);
        	
        	if( $datas['pano_state'] === '0'  ){
        		//$scene_files = $this->get_scene_pic($scene_id);
        		//$datas['scene_files'] = $this->get_file_url($scene_files);
        		$datas['pano_state'] = '0';
        	}
        	else if ( $datas['pano_state'] === '1'  ){
        		$datas['pano_state'] = '1';
        	}
        	else {
        		$datas['pano_state'] = '2'; //全景图不存在
        	}
        }
        elseif($type=='position'){
        	$datas['position'] = $this->get_position($scene_id);
        }
        elseif ($type == 'camera'){
        	$datas['camera'] = $this->get_camera_info($scene_id);
        	//print_r($datas['camera']);
        }
        elseif ($type == 'perspect'){
        	$datas['perspect'] = $this->get_camera_info($scene_id);
        	//print_r($datas['camera']);
        }
        elseif ($type == 'compass'){
        	$datas['compass'] = $this->get_compass_info($scene_id);
        	//print_r($datas['compass']);
        }
        elseif ($type == 'map'){
        	$datas['project_id'] = $request->getParam('project_id');
        	$datas['map'] = $this->get_map_info($datas['project_id']);
        	//print_r($datas['map']['link_scenes']);
        	$datas['scene_list'] = $this->get_link_scenes($scene_id, false);
        }
        elseif($type == 'hotspotEdit'){
        	$datas['hotspot_id'] = $request->getParam('hotspot_id');
        	$datas['thumb'] = $this->get_thumb_by_hotspot($datas['hotspot_id']);
        }
        elseif($type == 'image'){
        	$datas['project_id'] = $request->getParam('project_id');
        }
        elseif($type == 'imageEdit'){
        	
        	$datas['hotspot_id'] = $request->getParam('hotspot_id');
        }
        elseif ($type == 'music'){
        	$datas['music'] = $this->get_music_info($datas['scene_id']);
        	//print_r($datas['music']);
        }
        if(!in_array($type, $this->defaultType)){
            exit();
        }
        $this->render('/pano/panel/'.$type, array('datas'=>$datas));
    }
    
    /**
     * 获取场景地理位置
     */
    private function get_position($scene_id){
    	$position = array('glng'=>'121.4759159', 'glat'=>'31.2243531', 'gzoom'=>12);
    	$position_db = new ScenesPosition();
    	$datas = $position_db->findByPk($scene_id);
    	if(!$datas){
    		return $position;
    	}
    	return $datas;
    }
    /**
     * 获取背景音乐文件信息
     * 
     */
    private function get_music_info($scene_id){
    	if(!$scene_id){
    		return false;
    	}
    	$scene_music_db = new MpSceneMusic();
    	$music_datas = $scene_music_db->get_by_scene_id($scene_id);
    	//print_r($music_datas);
    	if(!$music_datas){
    		return false;
    	}
    	$file_id = $music_datas['file_id'];
    	if(!$file_id){
    		return false;
    	}
    	//获取文件信息
    	$file_path_db = new FilePath();
    	$file_datas = $file_path_db->get_by_file_id($file_id);
    	if(!$file_datas){
    		return false;
    	}
    	//$music_datas['file'] = $file_datas;
    	$datas['id'] = $music_datas['id'];
    	$datas['scene_id'] = $music_datas['scene_id'];
    	$datas['file_id'] = $file_id;
    	$datas['file_name'] = $file_datas['name'];
    	$datas['volume'] = $music_datas['volume'];
    	$datas['loop'] = $music_datas['loop'];
    	$datas['state'] = $music_datas['state'];

    	return $datas;
    }
    /**
     * 获取场景文件信息
     */
    private function get_pano_info($scene_id){
    	if (!$scene_id){
    		return false;
    	}
    	$sceneDB = new Scene();
    	return $sceneDB->get_by_scene_id($scene_id);
    }
    /**
     * 获取全景图状态
     */
    private function get_pano_state($scene_id){
    	if (!$scene_id){
    		return false;
    	}
    	$panoQueue = new PanoQueue();
    	$datas = $panoQueue->find_by_scene_id($scene_id);
    	if(!$panoQueue){
    		return false;
    	}
    	return $datas['state'];
    }
    /**
     * 获取地图信息
     */
    private function get_map_info($project_id){
    	$map_db = new ProjectMap();
    	$map_datas = $map_db->get_map_info($project_id);
    	if(!$map_datas){
    		return false;
    	}
    	
    	/* //获取图片名
    	$file_path_db = new FilePath();
    	$file_path = $file_path_db->get_file_path($map_datas['map']['file_id'], 'original');
    	if(is_file($file_path)){
    		$myimage = new Imagick($file_path);
    		$map_datas['img']['width'] = $myimage->getImageWidth();
    		$map_datas['img']['height'] = $myimage->getImageHeight();
    		$file_info = $file_path_db->get_by_file_id($map_datas['map']['file_id']);
    		$map_datas['img']['md5'] = $file_info['md5value'];
    	}
    	else{
    		$map_datas['img']['width'] = '0';
    		$map_datas['img']['height'] = '0';
    	} */
    	
    	return $map_datas;
    }
    
    /**
     * 获取摄像机信息
     */
    private function get_camera_info($scene_id){
    	$panoram_db = new ScenesPanoram();
    	return $panoram_db->get_camera_info($scene_id);
    }
    private function get_compass_info($scene_id){
    	$panoram_db = new ScenesPanoram();
    	return $panoram_db->get_compass_info($scene_id);
    }
    /**
     * 获取图片地址
     */
    private function get_file_url($scene_files){
        $file_url = array();
        $pic_name = '120x120.jpg';
        $default_scene = array('left', 'right', 'down', 'up', 'front', 'back');
        foreach ($default_scene as $v){
            $file_url[$v] = isset($scene_files[$v]) && $scene_files[$v] ? $this->createUrl('/home/pictrue/index/', array('id'=>$scene_files[$v], 'size'=>$pic_name)) : $this->get_default_url($v);
        }
        unset($scene_files);
        return $file_url;
    }
    /*
     * 获取全景图
    */
/*     private function get_scene_pic($scene_id){
        $pics = array();
        if(!$scene_id){
            return $pics;
        }
        $scene_file_db = new MpSceneFile();
        return $scene_file_db->get_scene_list($scene_id);
    } */
    /**
     * 获取默认图片地址
     */
    private function get_default_url($position){
    	return "";
        //return Yii::app()->baseUrl."/pages/images/box_{$position}.gif";
    }
    /**
     * 获取热点链接的缩略图
     */
    private function get_thumb_by_hotspot($hotspot_id){
    	if(!$hotspot_id){
    		return false;
    	}
    	$hotspot_db = new ScenesHotspot();
    	$hotspot_datas = $hotspot_db->get_by_hotspot_id($hotspot_id);
    	if(!$hotspot_datas){
    		return false;
    	}
    	return $this->get_thumb_path($hotspot_datas['link_scene_id']);
    }
    /**
     * 获取场景缩略图
     */
    private function get_thumb_path($scene_id){
        return PicTools::get_pano_small($scene_id, '200x100');
        return false;
    }
    /**
     * 获取场景缩略图信息
     */
    private function get_thumb_info($scene_id){
    	$thumbDB = new ScenesThumb();
    	return $thumbDB->find_by_scene_id($scene_id);
    }
    /**
     * 获取项目中的其他场景列表
     */
    private function get_link_scenes($scene_id, $self=true){
        $scene_datas = array();
        if(!$scene_id){
            return $scene_datas;
        }
        //获取project_id
        $scene_db = new Scene();
        $scene_data = $scene_db->get_by_scene_id($scene_id);
        if(!$scene_data || !$scene_data->project_id){
            return $scene_datas;
        }
        $project_id = $scene_data->project_id;
        $criteria=new CDbCriteria;
        $criteria->order = 'id ASC';
        $criteria->addCondition("project_id={$project_id}");
        if($self){
        	$criteria->addCondition("id!={$scene_id}");
        }
        $criteria->addCondition('status=1');
        $scene_datas = $scene_db->findAll($criteria);
        return $scene_datas;
    }

}