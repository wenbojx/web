<?php
class PanoPicTools{
    public $tile_info = array('11'=>1800, '10'=>900, '9'=>450);
    private $myimage = null;
    public $water_pic_path = 'style/img/water.png';
    private $default_thumb_img = 'style/img/thumb_default.gif';
    private $default_thumb_pano = 'style/img/thumb_pano.gif';
    private $default_face_img = 'style/img/default_face.jpg';
    private $face_box = array ('s_f'=>'style/img/box_front.gif', 's_r'=>'style/img/box_right.gif', 's_l'=>'style/img/box_left.gif', 's_b'=>'style/img/box_back.gif', 's_u'=>'style/img/box_up.gif', 's_d'=>'style/img/box_down.gif');

    private function _extensionToMime($ext){
		static $mime = array(
			'png' => 'image/png',
            'jpe' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp',
            'ico' => 'image/vnd.microsoft.icon',
            'tiff' => 'image/tiff',
            'tif' => 'image/tiff',
            'svg' => 'image/svg+xml',
            'svgz' => 'image/svg+xml',
		);
		if( !array_key_exists( $ext, $mime ) ){
			exit('error');
		}
		return $mime[$ext];
	}
	/**
	 * 输出默认图片
	 */
	public function show_default_pic($type = 1){
		if($type == '2'){
			$path = $this->default_face_img;
		}
		else if($type =='1'){
			$path = $this->default_thumb_img;
		}
		else if($type == '3'){
			$path = $this->default_thumb_pano;
		}
		else {
			$path = $this->face_box[$type];
		}
		$myimage = new Imagick($path);
		$ext = strtolower( $myimage->getImageFormat() );
		$myimage->setImageFormat($ext);

		header( 'Content-Type: '.$this->_extensionToMime($ext) );
		echo $myimage->getImagesBLOB();

		$myimage->clear();
		$myimage->destroy();
		exit();
	}
    /**
     * 添加水印
     * @return boolean
     */
    public function water_pic(){
    	$rand = rand(0, 8);
    	$time = substr(time(), $rand, 2);
    	$rand = rand(0, 5);
    	$ox = $time*$rand;
    	$rand = rand(0, 5);
    	$oy = $time*$rand;
    	
    	$water = new Imagick($this->water_pic_path);
    	$dw = new ImagickDraw();
    	$compose = $water->getImageCompose();

    	$dw -> composite($compose, $ox, $oy, $water->getimagewidth(), $water->getimageheight(), $water);
    	$this->myimage -> drawImage($dw);
    	$water->clear();
    	$water->destroy();
    	return true;
    }
/**
 * 生成静态图片 imagick
 */
    public function turnToStatic ($from, $to, $size, $quality=100, $water=1, $sharpen=0){
    	if(!file_exists($from) || !$to || !$size){
    		return false;
    	}
    	$size_explode = explode ('x', $size);
    	$width = (int) $size_explode[0];
    	$height = (int) $size_explode[0];
    	/* if(!$width || !$height){
    		return false;
    	} */
    	$this->myimage = new Imagick($from);
    	$ext = strtolower( $this->myimage->getImageFormat() );
    	
    	$this->myimage->setImageFormat($ext);
    	$imgWidth = $this->myimage->getimagewidth();
    	$imgHeight = $this->myimage->getimageheight();
    	//图片质量
    	if( $quality && $quality != 100){
    		$this->myimage->setImageCompression(imagick::COMPRESSION_JPEG);
    		$this->myimage->setImageCompressionQuality($quality);
    	}
    	$max_size = $width > $height ? $width : $height;
    	if($width >$imgWidth){
    		$width = $imgWidth;
    	}
    	if($height > $imgHeight){
    		$height = $imgHeight;
    	}
    	//重置尺寸
    	$this->myimage->resizeimage($width, $height, Imagick::FILTER_LANCZOS, 1, true);
    	if($sharpen){
    		$this->myimage->sharpenImage($sharpen, $sharpen);
    	}
    	if($water){
    		$this->water_pic();
    	}

    	$this->myimage->writeImage($to);

    	header( 'Content-Type: '.$this->_extensionToMime($ext) );
		echo $this->myimage->getImagesBLOB();

    	$this->myimage->clear();
    	$this->myimage->destroy();
    	exit();
    }
    /**
     * 生成静态图片 GD
     */
    public function turnToStaticGD ($from, $to, $size, $quality=100, $water=0, $sharpen=0){
    	if(!file_exists($from) || !$to || !$size){
    		return false;
    	}
    	$size_explode = explode ('x', $size);
    	$width = (int) $size_explode[0];
    	$height = (int) $size_explode[0];
    	if(!$width || !$height){
    		return false;
    	}
    	$image = Yii::app()->image->load($from);
		//$image->quality(70);
		//$image->save($new);
    	//重置尺寸
    	$image->resize($width, $height);
    	//$this->myimage->resizeimage($width, $height, Imagick::FILTER_LANCZOS, 1, true);
    	//图片质量
    	if( $quality && $quality != 100){
    		//$this->myimage->setImageCompression(imagick::COMPRESSION_JPEG);
    		//$this->myimage->setImageCompressionQuality($quality);
    		$image->quality($quality);
    	}

    	if($sharpen){
    		$image->sharpen($sharpen*10);
    	}
    	 
    	$image->save($to);
    	//打水印
    	$this->myimage = new Imagick($to);
    	$ext = strtolower( $this->myimage->getImageFormat() );
    	$this->myimage->setImageFormat($ext);
    	if($water){
    		$this->water_pic();
    	}
    	$this->myimage->writeImage($to);
    	
    	$image = Yii::app()->image->load($to);
    	$image->quality(80);
    	$image->render();
    }

    public function get_exif_imagetype($file_path){
        if ( ( list($width, $height, $type, $attr) = getimagesize( $file_path ) ) !== false ) {
            return $type;
        }
        return false;
    }
    /**
     * 切割图片
     */
    public function split_img($src_file, $file_name, $file_type='jpg'){
    	
    	$folder = substr($src_file, 0, strlen($src_file)-4);
    	if(!is_dir($folder)){
    		mkdir($folder);
    	}
    	$folder .= '/10';
    	if(!is_dir($folder)){
    		mkdir($folder);
    	}
    	
    	$maxW = $maxH = $this->tile_info[10]/2;
    	if ( !function_exists( 'exif_imagetype' ) ) {
    		$type = $this->get_exif_imagetype($src_file);
    	}
    	else{
    		$type = exif_imagetype($src_file);
    	}
    	
    	$support_type=array(IMAGETYPE_JPEG , IMAGETYPE_PNG , IMAGETYPE_GIF);
    	//Load image
    	switch($type) {
    		case IMAGETYPE_JPEG :
    			$src_img = imagecreatefromjpeg($src_file);
    			break;
    		case IMAGETYPE_PNG :
    			$src_img = imagecreatefrompng($src_file);
    			break;
    		case IMAGETYPE_GIF :
    			$src_img = imagecreatefromgif($src_file);
    			break;
    	}
    	list($width, $height, $type, $attr) = getimagesize($src_file);
    	$widthnum=ceil($width/$maxW);
    	$heightnum=ceil($height/$maxH);
    	$iOut = imagecreatetruecolor ($maxW,$maxH);
    	for ($i=0;$i < $heightnum;$i++) {
    		for ($j=0;$j < $widthnum;$j++) {
    			imagecopy($iOut,$src_img,0,0,($j*$maxW),($i*$maxH),$maxW,$maxH);//复制图片的一部分
    			//imagejpeg($iOut,"images/".$i."_".$j.".jpg"); //输出成0_0.jpg,0_1.jpg这样的格式
    			$file_path = $folder.'/'.$i.'x'.$j.'.'.$file_type;
    			//echo $file_path.'<br>';
    			$quality = 100;
    			switch($type) {
    				case IMAGETYPE_JPEG :
    					imagejpeg($iOut, $file_path,$quality); // 存储图像
    					break;
    				case IMAGETYPE_PNG :
    					imagepng($iOut,$file_path,$quality);
    					break;
    				case IMAGETYPE_GIF :
    					imagegif($iOut,$file_path,$quality);
    					break;
    			}
    			//$image = Yii::app()->image->load($file_path);
    			//$image->quality(85);
    			//$image->save($file_path);
    		}
    	}
    	imagedestroy($iOut);
    }
    /**
     * 切割图片
     */
    public function split_img_ten($src_file, $file_name, $toPath, $water){
    	$file_type='jpg';
        $maxW = $maxH = $this->tile_info[10]/2;

        $this->myimage = new Imagick($src_file);
        $ext = strtolower( $this->myimage->getImageFormat() );
        $this->myimage->setImageFormat($ext);
        
        $quality = 80;
        $sharpen = 0.4;
        $this->myimage->setImageCompression(imagick::COMPRESSION_JPEG);
        $this->myimage->setImageCompressionQuality($quality);
        $this->myimage->sharpenImage($sharpen, $sharpen);
        $maxW = $this->tile_info[10];
        $this->myimage->resizeimage($maxW, $maxW, Imagick::FILTER_LANCZOS, 1, true);
        $p_width = $this->myimage->getImageWidth();
        $p_height = $this->myimage->getImageHeight();

        $x = 0 ;
        $y = 0;
        $add_px = 3;
        $half_x = $this->tile_info[9];
        $half_y = $half_x;
        if(strstr($file_name, '1_0')){
        	$x = $half_x;
        	$half_y += $add_px;
        }
        else if(strstr($file_name, '1_1')){
        	$x = $half_x;
        	$y = $half_y;
        }
        else if(strstr($file_name, '0_1')){
        	$y = $half_y;
        	$half_x += $add_px;
        }
        else {
        	$half_x += $add_px;
        	$half_y += $add_px;
        }

		$this->myimage->cropimage($half_x, $half_y, $x, $y);
		if($water){
			$this->water_pic();
		}
		$this->myimage->writeImage($toPath);
		
		header( 'Content-Type: '.$this->_extensionToMime($ext) );
		echo $this->myimage->getImagesBLOB();
		
		$this->myimage->clear();
		$this->myimage->destroy();
		exit();


    }
}