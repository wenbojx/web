<?php
Yii::import('application.extensions.image.Image');
class ImageContent {
	public $quality = 100;
	public $sharpen = 0;
	public $water = false;
	public $myimage = null;
	public $water_pic_path = 'style/img/water.png';

    private function show_pics($pic_datas){
        if(!$pic_datas || !$pic_datas['path'] ){
            return false;
        }
        //header cache
        $cache_time = '2592000';
        header('Cache-Control: max-age='.$cache_time);
        header('Pragma: cache');
        $created = strtotime(date('Y-m-d',time()));
        //print_r($pic_datas);
        $pic_datas['created'] = isset($pic_datas['created']) ? $pic_datas['created'] : $created;
        HttpCache::lastModified($pic_datas['created']);
        $pic_datas['md5value'] = isset($pic_datas['md5value']) ? $pic_datas['md5value'] : $pic_datas['path'];
        $pic_datas['size'] = isset($pic_datas['size']) ? $pic_datas['size'] : $created;
        $etag = md5($pic_datas['md5value'].'-yiluhao.com'.$pic_datas['size']);
        HttpCache::etag($etag);
        HttpCache::expires($cache_time); //默认缓存一月

        $this->show($pic_datas['path'], 75);
        exit();
    }
	// 输出到浏览器
    public function show($resource,  $quality=100){

    	$this->myimage = new Imagick($resource);
    	$this->myimage->setImageCompression(imagick::COMPRESSION_JPEG);
		$ext = strtolower( $this->myimage->getImageFormat() );
		$this->myimage->setImageFormat($ext);
		$this->water_pic();
		if($this->quality && $this->quality !=100){
			$quality = $this->quality;
		}
		$this->myimage->setImageCompressionQuality($quality);
		if($this->sharpen){
			$this->myimage->sharpenImage($this->sharpen, $this->sharpen);
		}

		header( 'Content-Type: '.$this->_extensionToMime($ext) );

		echo $this->myimage->getImagesBLOB();

		$this->myimage->clear();
    	$this->myimage->destroy();
    	return true;
    }
    //添加水印
    public function water_pic(){
        if(!$this->water){
	        return false;
        }
        $rand = rand(0, 8);
	    $time = substr(time(), $rand, 2);
	    $rand = rand(0, 5);
	    $ox = $time*$rand;
	    $rand = rand(0, 5);
	    $oy = $time*$rand;
	    $water = new Imagick($this->water_pic_path);
	    $dw = new ImagickDraw();
	    $dw -> composite($water->getImageCompose(),$ox,$oy,50,0,$water);
    	$this->myimage -> drawImage($dw);

    	$water->clear();
    	$water->destroy();
	    return true;
    }

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


    public function get_default_img($path, $type='gif'){
        $pic_datas = array( 'type'=>$type, 'pic_content'=>'' );
        if(!is_file($path)){
            return false;
        }
        //$pic_datas = $this->get_image_type($type);
        $pic_datas['path'] = $path;

        $this->show_pics($pic_datas);
    }
    /**
     * 根据file_id获取文件信息
     */
    public function get_img_content_by_id($id, $size, $suffix='', $file = ''){
        if(!$id){
            return false;
        }
        $datas = $this->get_file_info_by_id($id);
        $pic_datas = $this->get_img_info($datas, $size, $suffix, $file);
        $this->show_pics($pic_datas);
    }
    /**
     * 根据md5获取图片
     * @param unknown_type $no
     * @param unknown_type $size
     * @return boolean
     */
    public function get_img_content_by_md5file($no, $size, $suffix=''){
        if(!$no){
            return false;
        }
        $datas = $this->get_file_info_by_md5file($no);
        if(!$datas || !$datas[0]){
            return false;
        }
        $pic_datas = $this->get_img_info($datas[0], $size, $suffix);
        $this->show_pics($pic_datas);
    }

    /*
     * $id =file_id
     * $size like 200x200.jpg
     */
    public function get_img_info($datas, $size, $suffix='', $add_suffix = false){
        $pic_datas = array();
        if(!$datas){
            return false;
        }
        $pic_type = $datas->type;
        $path = $this->get_file_path($datas);
        $path_original = $path;
        if($suffix){
            $path_original = $path.$suffix.'/';
        }
        //$path .= $datas['name'];
        if($add_suffix){
            $path = $path_original;
        }
        $path_new = $path.$size;
            if(!is_file($path_new)){
                $explode_1 = explode('.', $size);
                $explode_2 = explode('x', $explode_1[0]);
                $path_original .= $datas['md5value'].'.'.$datas['type'];
                if(!is_file($path_original)){
                    return false;
                }
                //echo $path_original;
                $this->resize($path_original, $path_new, (int)$explode_2[0], (int)$explode_2[1]);
            }
            $path = $path_new;
        //$pic_datas = $this->get_image_type($pic_type);
        $pic_datas['path'] = $path;
        $pic_datas['created'] = $datas['created'];
        $pic_datas['md5value'] = $datas['md5value'];
        $pic_datas['size'] = $size;
       	//print_r($pic_datas);
        return $pic_datas;
    }

    /**
     * 缩小图片大小
     */
    private function resize($input, $output, $width, $height){

        $myimage = new Imagick($input);
        $ext = strtolower( $myimage->getImageFormat() );
        $myimage->setImageFormat($ext);
        
        $myimage->resizeimage($width, $height, Imagick::FILTER_LANCZOS, 1, true);
        //$myimage->setCompressionQuality($this->quality);
        $myimage->writeImage($output);
        $myimage->clear();
    	$myimage->destroy();
    	return true;
    }

    private function get_file_path($datas){
        $year_month = substr($datas->folder, 0, 6);
        $day = substr($datas['folder'], -2);
        $path = Yii::app()->params['file_pic_folder'].'/'.$year_month.'/'.$day.'/'.$datas['md5value'].'/';
        return $path;
    }
    private function get_file_info_by_md5file($no){
        $memcache_obj = new Ymemcache();
        $key = $memcache_obj->get_img_no_key($no);
        if(!$datas = $memcache_obj->get_mem_data($key)){
            $file_path_db = new FilePath();
            $datas = $file_path_db->get_file_by_no($no);
            $memcache_obj->set_mem_data($key, $datas, 0);
        }
        return $datas;
    }
    private function get_file_info_by_id($id){
        $memcache_obj = new Ymemcache();
        $key = $memcache_obj->get_img_id_key($id);
        if(!$datas = $memcache_obj->get_mem_data($key)){
            $file_path_db = new FilePath();
            $datas = $file_path_db->get_by_file_id($id);
            $memcache_obj->set_mem_data($key, $datas, 0);
        }
        return $datas;
    }

}