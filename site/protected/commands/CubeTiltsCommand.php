<?php 
class CubeTiltsCommand extends CConsoleCommand{
	private $rootPath = '';
	
	public function actionRun(){
		$cubeTile = new CubeTilt();
		$this->rootPath = dirname(__FILE__).'/../..';
		//获取已处理的场景
		$panoQueueDB = new PanoQueue();
		$panoList = $panoQueueDB->get_deal_list();
		$flePathDB = new FilePath();
		foreach($panoList as $v){
			//获取项目原图目录
			$file_id = $this->get_pano_file_id($v['scene_id']);
			if(!$file_id){
				return false;
			}
			//获取文件地址
			$path = $this->rootPath. '/' . $flePathDB->get_file_folder ($file_id, 'cube');
			foreach ($cubeTile->face_box as $k=>$v1){
				$filePath = "{$path}/{$k}.jpg";
				$cubeTile->DealPicPath($filePath, $v['scene_id'], $v1);
			}
		}
	}
	public function actionSmall(){
		$this->rootPath = dirname(__FILE__).'/../..';
		//获取已处理的场景
		$panoQueueDB = new PanoQueue();
		$panoList = $panoQueueDB->get_deal_list();
		$flePathDB = new FilePath();
		foreach($panoList as $v){
			//获取项目原图目录
			$file_id = $this->get_pano_file_id($v['scene_id']);
			if(!$file_id){
				return false;
			}
			//获取文件地址
			$path = $this->rootPath. '/' . $flePathDB->get_file_folder ($file_id, '');
			if(!is_dir($path.'small')){
				mkdir($path.'small');
			}
			$md5 = substr($path, strlen($path)-33, 32);
			$from = $path . 'original/'. $md5 .'.jpg';
			$to = $path . 'small/'. $md5 .'.jpg';
			echo $from."\r\n";
			echo $to."\r\n";
			$myimage = new Imagick($from);
			$myimage->resizeimage(4000, 2000, Imagick::FILTER_LANCZOS, 1, true);
			$myimage->writeImage($to);
			$myimage->clear();
			$myimage->destroy();
		}
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
}

?>