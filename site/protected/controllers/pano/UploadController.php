<?php
ini_set('memory_limit', '100M');
class UploadController extends Controller{
    public $defaultAction = 'uploadFile';
    //public $layout = 'page';
    public $position = array('left'=>1,'right'=>2,'down'=>3,'up'=>4,'front'=>5,'back'=>6);
    private $images_info = array(
        'type'=>array('jpg','png','gif','JPG','PNG','GIF'),
        'size'=>5242880,
    );
    private $music_info = array(
    		'type'=>array('mp3','mav','wma'),
    		'size'=>5120,
    );
    
    private $image_width = '';
    private $image_height = '';
    private $scene_id = ''; 
    private $from_music = false;

    public function actionUploadFile(){
        $request = Yii::app()->request;
        $from_box_pic = false;
        $from_thumb_pic = false;
        $from_map_pic = false;
        $from_pano_pic = false;
        $from_image_pic = false;
       // $from_music = false;

        $scene_id = $request->getParam('scene_id');
        $this->scene_id = $scene_id;
        $msg = array('flag'=>0,'msg'=>'文件上传出错');
        if(!$scene_id){
        	$this->display_msg($msg);
        }
        if ($request->getParam('position')!='' && $request->getParam('from')=='box_pic' && $scene_id>0){
        	$from_box_pic = true;
        }
        elseif ($request->getParam('from')=='thumb_pic' && $scene_id>0){
        	$from_thumb_pic = true;
        }
        elseif ($request->getParam('from')=='map_pic' && $scene_id>0){
        	$from_map_pic = true;
        }
	    else if ($request->getParam('from')=='pano_pic' && $scene_id>0 ){
	    	$from_pano_pic = true;
	    }
	    else if ($request->getParam('from')=='image_pic' && $scene_id>0 ){
	    	$from_image_pic = true;
	    }
	    else if ($request->getParam('from')=='music' && $scene_id>0 ){
	    	$this->from_music = true;
	    }

        $this->check_scene_own($scene_id);
        if($from_thumb_pic){
        	$pos = $request->getParam('pos');
        	if(!$pos){
        		$this->display_msg($msg);
        	}
        	$file_info = $this->get_thumb_pic($scene_id, $pos);
        }
        else {
        	$file_info = $this->upload($from_box_pic, $from_pano_pic);
        }
        //print_r($file_info);
        $flag = true;
        $flag_scene = false;
        if(!$file_info){
        	$this->display_msg($msg);
        }
        $file_id = $this->save_file($this->member_id, $file_info['md5value']);
        if(!$file_id){
        	$this->display_msg($msg);
        }
        $path_id = $this->save_file_path($file_info, $file_id);
        if(!$path_id){
        	$this->display_msg($msg);
        }
        
        //场景图
        if($from_box_pic){
        	$flag_scene = $this->save_scene_file($file_id, $scene_id, $request->getParam('position'));
        }
        //场景缩略图
        elseif($from_thumb_pic){
        	$recommend = $request->getParam('recommend');
        	$flag_scene =$this->save_scene_thumb($file_id, $scene_id, $recommend, $pos);
        }
        //地图
        elseif($from_map_pic){
        	$project_id = $request->getParam('project_id');
        	$flag_scene =$this->save_project_map($file_id,$project_id);
        }
        elseif($from_pano_pic){
        	$flag_scene =$this->save_scene_pano($file_id,$scene_id);
        }
        elseif ($from_image_pic){
        	$flag_scene = true;
        }
        elseif($this->from_music){
        	$flag_scene = true;
        }
        if(!$flag_scene){
        	$this->display_msg($msg);
        }
        //echo 111;
        $file_info['width'] = $this->image_width;
        $file_info['height'] = $this->image_height;
        //$file_info['file_id'] = $file_id;
        $msg = array('flag'=>1,'msg'=>'', 
        		'id'=>$flag_scene, 
        		'file_id'=>$file_id, 
        		'type'=>$file_info['type'], 
        		'w'=>$file_info['width'], 
        		'h'=>$file_info['height'], 
        		'file'=>$file_info['md5value'],
        		'file_name'=>$file_info['name']
        		
        		);
        $this->display_msg($msg);
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
     * 保存缩略图
     */
    private function get_thumb_pic($scene_id, $pos){
    	$file_id = $this->get_pano_file_id($scene_id);
    	if(!$file_id){
    		return false;
    	}
    	$flePathDB = new FilePath();
    	//获取文件地址
    	$file_path = $flePathDB->get_file_path ($file_id, 'small');
    	
    	if(!file_exists($file_path)){
    		return false;
    	} 
    	//$file_path = PicTools::get_pano_static_path($scene_id).'/small/1024x512.jpg';

    	$myimage = new Imagick($file_path);
    	$ext = strtolower( $myimage->getImageFormat() );
    	$myimage->setImageFormat($ext);
    	$pic_width = $myimage->getimagewidth();
    	
    	$explode = explode(',', $pos);
    	$x = $explode[0];
    	$y = $explode[1];
    	$scale = $explode[2]/540;
    	$zoom = 1/$scale;
    	$p_zoom = $pic_width/540;
    	
    	$x = $x*$zoom*$p_zoom;
    	$y = $y*$zoom*$p_zoom;
    	
    	$width = 150*(1/$scale)*$p_zoom;
    	$height = 110*(1/$scale)*$p_zoom;

    	$myimage->cropimage($width, $height, $x, $y);
    	
    	$pre = Yii::app()->params['file_pic_folder'].'/';
    	$file_info['folder'] = date('Y',time()).date('m',time());
    	$folder_pic = $pre.$file_info['folder'].'/';
    	if(!is_dir($folder_pic)){
    		mkdir($folder_pic);
    	}
    	$day = date('d',time());
    	$folder_pic .= $day.'/';
    	$file_info['folder'] .= $day;
    	if(!is_dir($folder_pic)){
    		mkdir($folder_pic);
    	}
    	$myimage->resizeimage(250, 155, Imagick::FILTER_LANCZOS, 1, true);
    	$sharpen = 0.1;
    	$myimage->sharpenImage($sharpen, $sharpen);
    	
    	$md5 = md5($myimage->getImagesBLOB());
    	$file_info['md5value'] = $md5;
    	$folder_pic = $folder_pic . '/'. $md5;
    	if(!is_dir($folder_pic)){
    		mkdir($folder_pic);
    	}
    	$folder = $folder_pic.'/original/';
    	if(!is_dir($folder)){
    		mkdir($folder);
    	}
    	$file_name = 'thumb.jpg';
    	$file_info['name'] = $file_name;//获取文件名
    	$file_info['size'] = $myimage->getImageSize();//获取文件大小
    	$file_info['type'] = 'jpg';//获取文件类型

    	$to = $folder.$md5.'.jpg';
    	$myimage->writeImage($to);
    	$myimage->clear();
    	$myimage->destroy();
    	//清理静态文件
    	$fileTools = new FileTools();
    	$add_prefix = 'thumb';
    	$fileTools->del_pano_static_files($this->scene_id, $add_prefix);
    	
    	//print_r($file_info);
    	return $file_info;
    }
    private function save_scene_pano($file_id,$scene_id){
    	$scene = new Scene();
    	$flag = $scene->update_scene_pano ($file_id,$scene_id);
    	$panoQueue = new PanoQueue();
    	$data['scene_id'] = $scene_id;
    	$panoQueue->add_queue ($data);
    	return $flag;
    }
    private function save_project_map($file_id,$project_id){
    	$map_db = new ProjectMap();
    	//获取图片的宽高信息
    	$flePathDB = new FilePath();
    	//获取文件地址
    	$path = $flePathDB->get_file_path ($file_id);
    	if(!is_file($path)){
    		return false;
    	}
    	$myimage = new Imagick($path);
    	$width = $myimage->getImageWidth();
    	$height = $myimage->getImageHeight();
    	
    	$datas = $map_db->save_project_map($project_id, $file_id, $width, $height);
    	return $datas;
    }

    private function save_file_path($file_info, $file_id){
        $file_path_db = new FilePath();
        $file_info['file_id'] = $file_id;
        return $file_path_db->save_file_path($file_info);
    }
    private function save_file($member_id, $md5file){
        if(!$member_id || !$md5file){
            return false;
        }
        $file_db = new File();
        return $file_db->save_file($member_id, $md5file);
    }
    /**
     * 保存缩略图
     */
    private function save_scene_thumb($file_id,$scene_id, $recommend=0, $pos=0){
        $scene_thumb_db = new ScenesThumb();
        $datas = $scene_thumb_db->save_pano_thumb($scene_id, $file_id, $recommend, $pos);
        return $datas;
    }
    /*
     * 保存场景全景图关系
     */
    private function save_scene_file($file_id, $scene_id, $position){
        if(!$file_id || !$scene_id){
            return false;
        }
        $scene_file_db = new MpSceneFile();
        return $scene_file_db->save_scene_file($file_id, $scene_id, $position);
    }

    /**
     * 上传文件
     */
    private function upload($from_box_pic = false, $from_pano_pic=false){
        if(!$_FILES['Filedata']){
            return false;
        }
        $pre = Yii::app()->params['file_pic_folder'].'/';
        $file_info['folder'] = date('Y',time()).date('m',time());
        $folder_pic = $pre.$file_info['folder'].'/';
        if(!is_dir($folder_pic)){
            mkdir($folder_pic);
        }
        $day = date('d',time());
        $folder_pic .= $day.'/';
        $file_info['folder'] .= $day;
        if(!is_dir($folder_pic)){
            mkdir($folder_pic);
        }
        $file = CUploadedFile::getInstanceByName('Filedata'); //获取表单名为filename的上传信息
        $md5file = $file->getTempName();
        $file_info['md5value'] = md5_file($md5file);
        $folder_pic .= $file_info['md5value'].'/';
        if(!is_dir($folder_pic)){
            mkdir($folder_pic);
        }
        $folder = $folder_pic.'original/';
        if(!is_dir($folder)){
            mkdir($folder);
        }
        $file_info['name'] = $file->getName();//获取文件名
        $file_info['size'] = $file->getSize();//获取文件大小
        $file_info['type'] = strtolower($file->getExtensionName());//获取文件类型
        if($this->from_music){
        	if(!in_array($file_info['type'], $this->music_info['type'])){
        		return false;
        	}
        }
        else{
	        if(!in_array($file_info['type'], $this->images_info['type'])){
	        	return false;
	        }
        }
        //$file_info['name']=iconv("utf-8", "gb2312", $file_info['name']);//这里是处理中文的问题，非中文不需要
        $uploadfile = $folder.$file_info['md5value'].'.'.$file_info['type'];
        $flag = $file->saveAs($uploadfile,true);//上传操作
        
        if($this->from_music){
        	if(!$flag){
        		return false;
        	}
        	return $file_info;
        }
        $myimage = new Imagick($uploadfile);
        $this->image_width = $myimage->getImageWidth();
        $this->image_height = $myimage->getImageHeight();
        if($from_pano_pic){
        	//创建目录
        	$small_path = $folder.'../small';
        	if(!is_dir($small_path)){
        		mkdir($small_path);
        	}
        	$myimage->resizeimage(4000, 2000, Imagick::FILTER_LANCZOS, 1, true);
        	$to = $small_path . '/' .$file_info['md5value'].'.'.$file_info['type'];
        	$myimage->writeImage($to);
        	//清理静态文件
        	//$fileTools = new FileTools();
        	//$fileTools->del_pano_static_files($this->scene_id);
        	//unlink($sc)
        }
        $myimage->clear();
        $myimage->destroy();
        if(!$from_box_pic){
        	return $file_info;
        }
        $pano_pic_tools = new PanoPicTools();
        //将文件处理成1000大小
        $pano_pic_tools->resize_pano($uploadfile, $folder_pic, $file_info['type']);
        if(!$flag){
            return false;
        }
        return $file_info;
    }

}





