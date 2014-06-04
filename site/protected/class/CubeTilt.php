<?php 
/**
 * 处理成静态图片
 */
class CubeTilt{
	public $myimage = null;
	public $scene_id = 0;
	private $maxSiz = 2048;
	private $mobileWidth = 1024;
	private $level = 2;
	private $startFolder = 9;
	public $folderPath = '';
	public $logStr = null;
	public $rootPath = '';
	public $face_box = array ('front'=>'s_f', 'right'=>'s_r', 'left'=>'s_l', 'back'=>'s_b', 'top'=>'s_u', 'bottom'=>'s_d');
	
	private $face = null;
	private $add_px = 3; //增加的像素
	public $water_pic_path = '';
	public $newObj = null;
	public $logs = '';
	/**
	 * 找出最佳尺寸
	 */
	private function BestSize (){
		$width = $this->myimage->getImageWidth();
		if($width >=4096){
			$this->maxSiz = 4096;
		}
		else if($width >=3600){
			$this->maxSiz = 3600;
		}
		else if($width>=2048){
			$this->maxSiz = 2048;
			$this->level = 2;
		}
		else if($width >=1800){
			$this->maxSiz = 1800;
			$this->level = 2;
		}
		else{
			$this->maxSiz=$width;
			$this->level = 1;
		}
	}
	/**
	 * 获取静态文件目录
	 */
	public function GetStaticFolder($scene_id){
		$picTools = new PicTools();
		$this->rootPath = dirname(__FILE__).'/../..';
		$this->water_pic_path = dirname(__FILE__).'/../../style/img/water.png';
		$path = $picTools->get_pano_static_path($scene_id);
		if($path){
			$this->folderPath = $this->rootPath. '/' .$path;
			return true;
		}
		return false;
	}

	public function DealPicObj ($obj, $scene_id, $face){
		
		$this->face = $face;
		if(!$obj || !$scene_id){
			return false;
		}
		if(!$this->GetStaticFolder($scene_id)){
			return false;
		}

		$this->scene_id= $scene_id;
		$this->myimage = $obj;
		//echo 1111;
		$this->Deal();
		//echo 22222;
		//生成移动图片
		//$this->make_fthumb($obj, $scene_id, $face);
		
		$this->newObj->clear();
		$this->newObj->destroy();

	}
	//生成移动图片
	public function make_fthumb($imgObj, $scene_id, $face){
		$path = $this->GetStaticFolder($scene_id);
		$path = $this->folderPath;
		//echo "makeFthumb=".$path."\r\n";
		if (!file_exists($path) || !$scene_id){
			return false;
		}
		$path = $path.'/'.$face.'/fthumb/';
		$this->make_unexit_dir($path);
		$sharpen = 0.2;
		$quality = 80;
		$imgObj->setImageFormat("jpeg");
		$imgObj->setImageCompression(imagick::COMPRESSION_JPEG);
		$imgObj->setImageCompressionQuality($quality);
		$imgObj->sharpenImage($sharpen, $sharpen);
		//echo "mobile===".$imgObj->getimagewidth()."\r\n";
		$imgObj->resizeimage($this->mobileWidth, $this->mobileWidth, Imagick::FILTER_LANCZOS, 1, true);
		$filePath = $path."{$this->mobileWidth}x{$this->mobileWidth}.jpg";
		//echo $filePath."\r\n";
		$imgObj->writeimage($filePath);
	}
	
	public function DealPicPath ($path='', $scene_id, $face){
		$this->face = $face;
		if (!file_exists($path) || !$scene_id){
			return false;
		}
		if(!$this->GetStaticFolder($scene_id)){
			return false;
		}
		$this->scene_id= $scene_id;
		$this->myimage = new Imagick($path);
		$this->myimage->setImageFormat("jpeg");
		
		$this->Deal();
		$this->myimage->clear();
		$this->myimage->destroy();
		$this->newObj->clear();
		$this->newObj->destroy();
	}
	/**
	 * 将图处理成各种尺寸的静态地址图
	 */
	private function Deal (){
		if(!$this->myimage || !$this->scene_id){
			return false;
		}
		for($i=($this->level); $i>=0; $i--){
			$this->averagePic($i);
		}
		//echo $this->logStr;
	}
	/**
	 * 分成$num等分
	 */
	private function averagePic($num){
		$x = 0;
		$y = 0;
		$round = pow(2, $num);
		
		$w_h = $this->maxSiz / pow(2, $this->level);
		$sharpen = 0.3;
		$quality = 90;
		if($round == 1){
			$quality = 10;
		}
		$this->myimage->setImageCompression(imagick::COMPRESSION_JPEG);
		$this->myimage->setImageCompressionQuality($quality);
		$this->myimage->sharpenImage($sharpen, $sharpen);
		
		$maxW = $this->maxSiz/pow(2, $this->level-$num);
		
		$this->myimage->resizeimage($maxW, $maxW, Imagick::FILTER_LANCZOS, 1, true);
		
		if($round != 1){
			$this->water_pic();
		}
		for($i=0; $i<$round; $i++){
			$y=0;
			$x = $i*$w_h;
			for($j=0; $j<$round; $j++){
				$add_x = 0;
				$add_y = 0;
				
				if($round>=2){
					$add_x = $this->add_px;
					$add_y = $this->add_px;
					if( $j == $round-1){
						$add_y = 0;
					}
					if( $i == $round-1){
						$add_x = 0;
					}
					
					/* if($i%2 == 0 ){
						$add_x = $this->add_px;
						if($j%2 == 0){
							$add_y = $this->add_px;
						}
					}
					else{
						if($j%2 == 0){
							$add_y = $this->add_px;
						}
					} */
				}
				
				$width = $w_h+$add_x;
				$height = $w_h+$add_y;

				$y = $j*$w_h;
				$name = $i . '_' . $j. '.jpg';
				/* if($this->CheckFileExit($num, $name)){
					continue;
				} */
				//$this->logStr .= "x={$x}--y={$y}\r\n";
				//$this->logStr .= "add_x={$add_x}--add_y={$add_y}\r\n";
				$this->newObj = $this->myimage->getimageregion($width, $height, $x, $y);
				
				$this->savePic( $num, $name);
				
			}
		}
	}
	/**
	 * 检查文件是否存在
	 */
	private function CheckFileExit($level, $name){
		$level = $level+$this->startFolder;
		$path = $this->folderPath . '/' . $this->face . '/' . $level . '/' . $name;
		if(file_exists($path)){
			return true;
		}
		return false;
	}
	/**
	 * 添加水印
	 * @return boolean
	 */
	public function water_pic(){
		return true;//关水印
		$rand = rand(0, 8);
		//$time = substr(time(), $rand, 2);
		$flag = (rand(4, 6)%3);
		if($flag!=0){
			return false;
		}
		$time = 100;
		$rand = rand(0, 8);
		$ox = $time*$rand;
		$rand = rand(0, 8);
		$oy = $time*$rand;
		 
		
		$water = new Imagick($this->water_pic_path);
		$dw = new ImagickDraw();
		$compose = $water->getImageCompose();
	
		$dw -> composite($compose, $ox, $oy, $water->getimagewidth(), $water->getimageheight(), $water);
		$this->myimage -> drawImage($dw);

		return true;
	}
	/**
	 * 保存图片
	 * $add_x宽度加像素，$add_y高度加像素
	 */
	private function savePic( $level, $name){
		$level = $level+$this->startFolder;
		if( !$name){
			return false;
		}
		$folder = $this->folderPath . '/' . $this->face . '/' . $level;

		if(!is_dir($folder)){
			$this->make_unexit_dir($folder);
			if(!is_dir($folder)){
				$str = "----error------- file {$newFile}\r\n";
				$this->logStr .= $str;
				return false;
			}
		}
		$newFile = $folder . '/' . $name;
		$str = "----save file {$newFile}\r\n";
		//$this->logStr .= $str;
		//$obj->resizeimage($width, $height, Imagick::FILTER_LANCZOS, 1, true);
		$this->newObj->writeImage($newFile);
		$this->newObj->clear();
		$this->newObj->destroy();
	}

	/**
	 * 创建不存在的目录
	 */
	private function make_unexit_dir ($path){
		if(!$path){
			return false;
		}

		$path = str_replace($this->rootPath.'/', '', $path);
		$path_explode = explode ('/', $path);
		//print_r($path_explode);
		if(!is_array($path_explode)){
			return false;
		}
		$path = $this->rootPath;
		for ($i=0; $i<count($path_explode); $i++){
			if(!$path_explode[$i]){
				continue;
			}
			$path .= '/' . $path_explode[$i];
			
			if(!is_dir($path)){
				mkdir($path);
			}
		}
		return true;
	}
}







?>