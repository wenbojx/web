<?php
ini_set('memory_limit', '500M');
class PanoPicController extends FController{
	public $defaultAction = 'index';
	private $url = '';
	private $size = array('200x100', '150x110','200x150', '400x200', '1024x512', '1024x1024', '600x600', '512x512', '800x800');
	private $request = null;
	public $img_size = 1800;
	public $tile_size = 450;
	private $face_box = array ('s_f'=>'front', 's_r'=>'right', 's_l'=>'left', 's_b'=>'back', 's_u'=>'top', 's_d'=>'bottom');

	/**
	 * 获取全景图缩略图
	*/
	public function actionIndex(){
		$this->request = Yii::app()->request;
		$this->url = $this->request->requestUri;
		$this->url = $this->get_url_file_path();

		if(strstr($this->url, '/thumb/')){
			$this->get_pano_thumb();
		}
		else if (strstr($this->url, '/small/')){
			$this->get_pano_small();
		}
		elseif(strstr($this->url, '/fthumb/')){
			$this->get_face_thumb();
		}
		elseif(strstr($this->url, '/map/')){
			$this->get_pano_map();
		}
		elseif(strstr($this->url, '/hotimage/')){
			$this->get_pano_hotimage();
		}
		else if(strstr($this->url, '/music.')){
			$this->get_music();
		}
		else if(strstr($this->url, '.jpg')){
			$this->put_out_pano_face();
		}
		else if(strstr($this->url, '.xml')){
			$this->put_out_xmlb();

		}
	}
	/**
	 * 音乐
	 */
	private function get_music(){
		$explode_url = explode ('/', $this->url);
		//print_r($explode_url);
		$num = count($explode_url)-2;
		$scene_id = (int)$explode_url[$num];
		//获取场景对应的背景音乐
		$scene_music = new MpSceneMusic();
		$music_datas = $scene_music->get_by_scene_id($scene_id);
		if(!$music_datas){
			return false;
		}
		//获取原始文件信息
		$file_path_db = new FilePath();
		$file_path = $file_path_db->get_file_path($music_datas['file_id']);
		
		if(!$file_path || !is_file($file_path)){
			return false;
		}
		//echo $file_path;
		$type = substr($file_path, (strlen($file_path)-3), 3);
		$toPath = PicTools::get_pano_static_path($scene_id).'/music.'.$type;
		copy($file_path, $toPath);
	}
	/**
	 * 地图
	 */
	private function get_pano_map(){
		$explode_url = explode ('/', $this->url);
		$num = count($explode_url)-1;
		$file_name = $explode_url[$num];
		$map_id = substr($file_name, 0, -4);
		$project_id = $explode_url[$num-2];
		//echo $project_id;
		if(!$map_id){
			$this->show_default(3);
		}
		//获取文件
		$map_info = $this->get_map_file_id($map_id);
		if(!$map_info){
			$this->show_default(3);
		}
		$file_id = $map_info['file_id'];
		$flePathDB = new FilePath();
		//获取文件地址
		$path = $flePathDB->get_file_path ($file_id);
		if(!$path || !is_file($path)){
			return false;
		}
		
		$toPath = PicTools::get_pano_static_path($project_id.'/map');
		//echo $toPath;
		
		if(!$this->make_unexit_dir($toPath)){
			$this->show_default(3);
		}
		$toPath .= '/' . $map_id . '.jpg';
		$panoPicTools = new PanoPicTools();
		$sharpen = 0;
		$size = $map_info['width']. 'x'. $map_info['height'];
		if(!$panoPicTools->turnToStatic($path, $toPath, $size, '90', 0, $sharpen)){
			$this->show_default(3);
		} 
	}
	/**
	 * 热点图片
	 */
	private function get_pano_hotimage(){
		$explode_url = explode ('/', $this->url);
		$num = count($explode_url)-1;
		$file_name = $explode_url[$num];
		$hotspot_id = substr($file_name, 0, -4);
		$scene_id = $explode_url[$num-2];
		//echo $project_id;
		if(!$hotspot_id){
			$this->show_default(1);
		}
		//echo $scene_id.'--'.$hotspot_id;
		//获取文件
		$hotspot_info = $this->get_image_hotspot_file_id($hotspot_id);
		if(!$hotspot_info){
			$this->show_default(1);
		}
		$file_id = $hotspot_info['file_id'];
		$flePathDB = new FilePath();
		//获取文件地址
		$path = $flePathDB->get_file_path ($file_id);
		if(!$path || !is_file($path)){
			return false;
		}
		
		$toPath = PicTools::get_pano_static_path($scene_id.'/hotimage');
		//echo $toPath;
		
		if(!$this->make_unexit_dir($toPath)){
			$this->show_default(1);
		}
		$toPath .= '/' . $hotspot_id . '.jpg';
		$panoPicTools = new PanoPicTools();
		$sharpen = 0;
		$size = 800 .'x'. 0;
		if(!$panoPicTools->turnToStatic($path, $toPath, $size, '90', 0, $sharpen)){
			$this->show_default(1);
		}
	}
	private function get_image_hotspot_file_id($hotspot_id){
		if(!$hotspot_id){
			return false;
		}
		$imghotspot_db = new MpHotspotFile();
		return  $imghotspot_db->get_file_id($hotspot_id);

	}
	/**
	 * 根据map_id 获取对应的文件ID 
	 */
	private function get_map_file_id($map_id){
		$mapDB = new ProjectMap();
		return $mapDB->find_by_map_id($map_id);
	}
	/**
	 * 去掉图片后面的参数
	 */
	private function get_url_file_path(){
		if(!$this->url){
			return $this->url;
		}
		$start = strpos($this->url, '?');
		if($start){
			$end = 1-(strlen($this->url)-$start+1);
			//$end = substr($this->url, $start)
			return substr($this->url, 0, $end );
		}
		return $this->url;
	}
	/**
	 * 输出默认图片
	 */
	private function show_default($type){
		$panoPicTools = new PanoPicTools();
		return $panoPicTools->show_default_pic($type);
	}
	/**
	 * 输出全景图面图片缩略图
	 */
	private function get_face_thumb(){
		$explode_url = explode ('/', $this->url);
		$count = count($explode_url);
		$scene_id = (int) $explode_url[$count-4];
		$face = $explode_url[$count-3];
		$fileName = $explode_url[$count-1];
		$suffix = $explode_url[$count-2];
		$faceKeys = array_keys($this->face_box);
		if(!$scene_id || !in_array($face, $faceKeys)){
			$this->show_default($face);
		}
		$path = $this->get_pano_file_path($scene_id, $face);

		if(!$path || !file_exists($path)){
			$this->show_default($face);
		}

		$water = 0;
		$sharpen = 0;
		$quality = 80;
		$size = substr($fileName, 0, -4);
		if(!in_array($size, $this->size)){
			exit();
		}
		$toPath = PicTools::get_pano_static_path($scene_id) . '/'. $face. '/' . $suffix;
		//echo $toPath;
		if(!$this->make_unexit_dir($toPath)){
			$this->show_default($face);
		}

		$toPath .= "/{$fileName}";
		//echo $path."<br>";
		//echo $toPath."<br>";
		//echo $size;
		$panoPicTools = new PanoPicTools();

		if(!$panoPicTools->turnToStatic($path, $toPath, $size, $quality, $water, $sharpen)){
			$this->show_default($face);
		}
	}
	/**
	 * 输出全景图面图片
	 */
	private function put_out_pano_face(){
		$explode_url = explode ('/', $this->url);
		$count = count($explode_url);
		$scene_id = (int) $explode_url[$count-4];
		$face = $explode_url[$count-3];
		$suffix = $explode_url[$count-2];
		$fileName = $explode_url[$count-1];
		$faceKeys = array_keys($this->face_box);
		if(!$scene_id || !in_array($face, $faceKeys)){
			$this->show_default(2);
		}
		$path = $this->get_pano_file_path($scene_id, $face);
		if(!file_exists($path)){
			$this->show_default(2);
		}
		$water = 0;
		$sharpen = 0;
		$quality = 100;
		$size = $this->img_size/2;
		$toPath = PicTools::get_pano_static_path($scene_id) . '/'. $face. '/' . $suffix;

		if(!$this->make_unexit_dir($toPath)){
			$this->show_default(2);
		}
		$toPath .= "/{$fileName}";
		if($suffix == '9'){
			$size = '256x256';
			$quality = 40;
			$panoPicTools = new PanoPicTools();
			if(!$panoPicTools->turnToStatic($path, $toPath, $size, $quality, $water, $sharpen)){
				$this->show_default(2);
			}
		}
		elseif($suffix == '10'){
			//原图分解成4份
			$panoPicTools = new PanoPicTools();
			if(strstr($face, 's_l') || strstr($face, 's_b') || strstr($face, 's_u') || strstr($face, 's_d')){
				$rander = (rand(4,6)%3);
				if(strstr($fileName, '1_1') && $rander==0){
					$water =1;
				}
			}
			
			$panoPicTools->split_img_ten($path, $fileName, $toPath, $water);
		}
		
	}
	private function put_out_xmlb(){
		$explode_url = explode ('/', $this->url);
		$count = count($explode_url);
		$id = (int) $explode_url[$count-2];
		if(!$id){
			return false;
		}
		$datas['scene_id'] = $id;
		$datas['imgSize'] = $this->img_size;
		$datas['tileSize'] = $this->tile_size;
		$this->render('/salado/xmlb', array('datas'=>$datas));
	}
	/**
	 * 获取xml的参数
	 */
	private function get_xmla_params(){
		$nobtb = $this->request->getParam('nobtb'); //是否含button_bar
		$auto = $this->request->getParam('auto'); //是否自动转
		$single = $this->request->getParam('single'); //是否自动转
		$player_width = $this->request->getParam('w'); //是否自动转
		$player_height = $this->request->getParam('h'); //是否自动转
		$config['btb'] = $nobtb ? false :true;
		$config['auto'] = $auto ? true :false;
		$config['single'] = $single ? true :false;
		$config['player_width'] = $player_width ? $player_width : 1000;
		$config['player_height'] = $player_height ? $player_height : 500;
		return $config;
	}
	/**
	 * 创建不存在的目录
	 */
	private function make_unexit_dir ($path){
		if(!$path){
			return false;
		}
		$path_explode = explode ('/', $path);
		if(!is_array($path_explode)){
			return false;
		}
		if(count($path_explode)>7){
			return false;
		}
		$path = Yii::app()->params['pano_static_path'];
		for ($i=1; $i<count($path_explode); $i++){
			$path .= '/' . $path_explode[$i];
			//echo $path.'<br>';
			if(!is_dir($path)){
				mkdir($path);
			}
		}
		return true;
	}
	/**
	 * 获取全景图小图
	 */
	private function get_pano_small(){
		$explode_url = explode ('/', $this->url);
		$count = count($explode_url);
		$scene_id = (int) $explode_url[$count-3];
		if(!$scene_id){
			$this->show_default(3);
		}
		$file_name = $explode_url[$count-1];
		$size = substr($file_name, 0, strlen($file_name)-4);
		if(!in_array($size, $this->size)){
			$this->show_default(3);
		}
		if(!$scene_id){
			$this->show_default(3);
		}

		$file_id = $this->get_pano_file_id($scene_id);
		if(!$file_id){
			$this->show_default(3);
		}
		$flePathDB = new FilePath();
		//获取文件地址
		$path = $flePathDB->get_file_path ($file_id, 'small');

		$toPath = PicTools::get_pano_static_path($scene_id) . '/small';

		if(!$this->make_unexit_dir($toPath)){
			$this->show_default(3);
		}
		$toPath .= '/' . $size . '.jpg';
		$panoPicTools = new PanoPicTools();
		$sharpen = $size == $this->size[0] ? 0.6 : 0.4;
		//echo $path.'<br>'. $toPath.'<br>'. $size;
		//$sharpen = 0.8;
		 
		if(!$panoPicTools->turnToStatic($path, $toPath, $size, '90', 0, $sharpen)){
			$this->show_default(3);
		}
	}
	/**
	 * 获取全景图缩略图
	 */
	private function get_pano_thumb(){
		$explode_url = explode ('/', $this->url);
		$count = count($explode_url);
		$scene_id = (int) $explode_url[$count-3];
		if(!$scene_id){
			$this->show_default(1);
		}
		
		$file_name = $explode_url[$count-1];
		$size = substr($file_name, 0, strlen($file_name)-4);
		if(!in_array($size, $this->size)){
			$this->show_default(1);
		}
		$path = $this->get_pano_thumb_path($scene_id);
		if(!$path){
			$this->show_default(1);
		}
		$toPath = PicTools::get_pano_static_path($scene_id) . '/thumb';

		if(!$this->make_unexit_dir($toPath)){
			$this->show_default(1);
		}
		$toPath .= '/' . $size . '.jpg';
		$panoPicTools = new PanoPicTools();
		$sharpen = 0;
		$quality=90;
		if(!$panoPicTools->turnToStatic($path, $toPath, $size, $quality, 0, $sharpen)){
			$this->show_default(1);
		}
	}

	/**
	 * 获取全景图缩略图文件地址
	 */
	private function get_pano_thumb_path($scene_id){
		if(!$scene_id){
			return false;
		}
		$sceneThumbDB = new ScenesThumb();
		$thumbDatas = $sceneThumbDB->find_by_scene_id($scene_id);
		if(!$thumbDatas){
			return false;
		}
		$fileId = $thumbDatas['file_id'];
		//获取文件地址
		$path = $this->get_file_path($fileId);
		if(!file_exists($path)){
			return false;
		}
		return $path;
	}
	/**
	 * 根据file_id获取图片路径
	 */
	private function get_file_path ($file_id){
		$filePathDB = new FilePath();
		return $filePathDB->get_file_path($file_id);
	}
	/**
	 * 根据file_id获取图片目录
	 */
	private function get_file_floder ($file_id, $add_prx='cube'){
		$filePathDB = new FilePath();
		return $filePathDB->get_file_folder($file_id, $add_prx);
	}
	/**
	 * 获取全景图文件ID
	 */
	private function get_pano_file_id($scene_id){
		if(!$scene_id){
			return false;
		}
		$sceneDB = new Scene();
		$panoDatas = $sceneDB->get_by_scene_id($scene_id);
		if(!$panoDatas){
			return false;
		}
		$fileId = $panoDatas['file_id'];
		return $fileId;
	}
	/**
	 * 获取全景图对应文件信息
	 */
	private function get_pano_file_path($scene_id, $face){
		$file_id = $this->get_pano_file_id($scene_id);
		if(!$file_id){
			return false;
		}
		//获取文件地址
		$path = $this->get_file_floder ($file_id);
		//echo $path;
		if(!$path || !is_dir($path)){
			return false;
		}
		return $path . '/'. $this->face_box[$face] . '.jpg';
	}

}