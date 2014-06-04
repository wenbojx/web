<?php
ini_set('memory_limit', '100M');
class UploadPanoController extends Controller{
    public $defaultAction = 'uploadFile';
    //public $layout = 'page';
    public $position = array('left'=>1,'right'=>2,'down'=>3,'up'=>4,'front'=>5,'back'=>6);
    private $images = array(
        'type'=>array('jpg','png','gif','JPG','PNG','GIF'),
        'size'=>5242880,
    );
    public $tile_info = array('11'=>2048, '10'=>1024, '9'=>512);

    public function actionUploadFile(){
        $request = Yii::app()->request;
        $from_box_pic = false;
        $from_thumb_pic = false;
        $scene_id = $request->getParam('scene_id');
        if($request->getParam('position')!='' && $request->getParam('from')=='box_pic' && $scene_id>0){
        	$from_box_pic = true;
        }
        if($request->getParam('from')=='thumb_pic' && $scene_id>0){
        	$from_thumb_pic = true;
        }
        
        $file_info = $this->upload($from_box_pic);
        $response = array();
        $flag = true;
        $flag_scene = false;
        if($file_info){
            $path_id = $this->save_file_path($file_info);
            if($path_id){
                $file_id = $this->save_file($this->member_id, $file_info['md5value']);
                if($file_id){
                    //场景图
                    if($from_box_pic){
                        if(!$this->check_admin_scene($request->getParam('scene_id'), $this->member_id)){
                        	$flag = false;
                        }
                        else{
                            $flag_scene = $this->save_scene_file($file_id, $scene_id, $request->getParam('position'));
                        }
                    }
                    //场景缩略图
                    if($from_thumb_pic){
                        if(!$this->check_admin_scene($scene_id, $this->member_id)){
                            $flag = false;
                        }
                        else{
                            $flag_scene =$this->save_scene_thumb($file_id,$scene_id);
                        }
                    }
                    if(!$flag_scene){
                        $flag = false;
                    }
                }
                else{
                    $flag = false;
                }
            }
            else{
                $flag = false;
            }
        }
        else{
            $flag = false;
        }
        if(!$flag){
            $response = array('status'=>0,'msg'=>'文件上传出错');
        }
        else{
            $response = array('status'=>1,'msg'=>'', 'file'=>$file_info['md5value']);
        }
//print_r($response);
        $str = json_encode($response);
        exit($str);
    }
    private function check_file(){

    }
    private function check_admin_scene($scene_id, $member_id){
        if(!$scene_id || !$member_id){
            return false;
        }
        $scene_db = new Scene();
        $datas = $scene_db->get_by_admin_scene($member_id, $scene_id);
        return $datas;
    }

    private function save_file_path($file_info){
        $file_path_db = new FilePath();
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
    private function save_scene_thumb($file_id,$scene_id){
        $scene_thumb_db = new ScenesThumb();
        $datas = $scene_thumb_db->save_pano_thumb($scene_id, $file_id);
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
    private function upload($from_box_pic = false){
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
        //$file_info['name']=iconv("utf-8", "gb2312", $file_info['name']);//这里是处理中文的问题，非中文不需要
        $uploadfile = $folder.$file_info['md5value'].'.'.$file_info['type'];
        $flag = $file->saveAs($uploadfile,true);//上传操作
        if(!$from_box_pic){
        	return $file_info;
        }
        //将文件处理成1024大小
        $this->resize_pano($uploadfile, $folder_pic, $file_info['type']);
        if(!$flag){
            return false;
        }
        return $file_info;
    }
    /**
     * 将文件处理成1024大小
     */
    public function resize_pano($file_path, $folder, $file_type){
        $folder_pano = $folder.'9/';
        if(!is_dir($folder_pano)){
            mkdir($folder_pano);
        }
        $folder_10 = $folder.'10/';
        if(!is_dir($folder_10)){
            mkdir($folder_10);
        }
        $image = Yii::app()->image->load($file_path);
        $width = $this->tile_info[9]/2;
        $image->resize($width, $width)->quality(30);
        $file_path = $folder_pano.$width.'x'.$width.'.'.$file_type;
        $image->save($file_path);
        $width = $this->tile_info[10];
        $image->resize($width, $width);
        $file_path = $folder_10.$width.'x'.$width.'.'.$file_type;
        $image->save($file_path);
        //切割图片
        $this->split_img($file_path, $folder,$file_type);
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
    public function split_img($src_file, $folder,$file_type){
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
                $file_path = $folder.'10/'.$i.'x'.$j.'.'.$file_type;
                //echo $file_path.'<br>';
                $quality = 70;
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
    }
}





