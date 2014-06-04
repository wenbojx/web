<?php
class UploadFileController extends Controller{
    public $defaultAction = 'uploadFile';
    //public $layout = 'page';
    public $position = array('left'=>1,'right'=>2,'down'=>3,'up'=>4,'front'=>5,'back'=>6);
    private $images = array(
        'type'=>array('jpg','png','gif','JPG','PNG','GIF'),
        'size'=>5242880,
    );

    public function actionUploadFile(){
        $request = Yii::app()->request;
        $file_info = $this->upload();
        $response = array();
        $flag = true;
        if($file_info){
            $path_id = $this->save_file_path($file_info);
            if($path_id){
                $file_id = $this->save_file($this->member_id, $file_info['md5value']);
                if($file_id){
                	$scene_id = $request->getParam('scene_id');
                	//场景图
                    if($request->getParam('from') && $request->getParam('position')!='' &&
                    		$request->getParam('from')=='box_pic' && $scene_id>0){
                    	
                    	if(!$this->check_admin_scene($request->getParam('scene_id'), $this->member_id)){
                    		$flag = false;
                    	}
                        else{
                        	$flag_scene = $this->save_scene_file($file_id, $scene_id, $request->getParam('position'));
                        }
                    }
                    //场景缩略图
                    if($request->getParam('from')=='thumb_pic' && $scene_id>0){
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
        if(!$flag){
        	$response = array('status'=>0,'msg'=>'文件上传出错');
        }
        else{
        	$response = array('status'=>1,'msg'=>'', 'file'=>$file_info['md5value']);
        }

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
        $file_path_db->md5value = $file_info['md5value'];
        $file_path_db->folder = $file_info['folder'];
        $file_path_db->name = $file_info['name'];
        $file_path_db->size = $file_info['size'];
        $file_path_db->type = $file_info['type'];
        $file_path_db->created = time();
        return $file_path_db->save();
    }
    private function save_file($member_id, $md5file){
        $file_db = new File();
        $file_db->member_id = $member_id;
        $file_db->folder_id = 0;
        $file_db->md5file = $md5file;
        $file_db->created = time();
        if( !$file_db->save() ){
            return false;
        }
        return $file_db->attributes['id'];
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
    	$scene_file_db = new MpSceneFile();
    	//$position = $scene_file_db->map_position_num($position);
        $file_data = $scene_file_db->get_file_by_scene_position($scene_id, $position);
        if($file_data){
        	$mp_file_id = $file_data->id;
        	$flag = $scene_file_db->updateByPk($mp_file_id, array('file_id'=>$file_id));
        }
        else{
        	$position = $scene_file_db->map_position_num($position);
	        $scene_file_db->scene_id = $scene_id;
	        $scene_file_db->file_id = $file_id;
	        $scene_file_db->position = $position;
	        $scene_file_db->level = 1;
	        $scene_file_db->created = time();
        	$flag = $scene_file_db->save();
        }
        return $flag;
    }

    /**
     * 上传文件
     */
    private function upload(){
        if(!$_FILES['Filedata']){
            return false;
        }
        $pre = Yii::app()->params['file_pic_folder'].'/';
        $file_info['folder'] = date('Y',time()).date('m',time());
        $folder = $pre.$file_info['folder'].'/';
        if(!is_dir($folder)){
            mkdir($folder);
        }
        $day = date('d',time());
        $folder .= $day.'/';
        $file_info['folder'] .= $day;
        if(!is_dir($folder)){
            mkdir($folder);
        }
        $file = CUploadedFile::getInstanceByName('Filedata'); //获取表单名为filename的上传信息
        $md5file = $file->getTempName();
        $file_info['md5value'] = md5_file($md5file);
        $folder .= $file_info['md5value'].'/';
        if(!is_dir($folder)){
            mkdir($folder);
        }
        $file_info['name'] = $file->getName();//获取文件名
        $file_info['size'] = $file->getSize();//获取文件大小
        $file_info['type'] = strtolower($file->getExtensionName());//获取文件类型
        //$filename1=iconv("utf-8", "gb2312", $filename);//这里是处理中文的问题，非中文不需要
        $uploadfile = $folder.$file_info['name'];
        $flag = $file->saveAs($uploadfile,true);//上传操作
        if(!$flag){
            return false;
        }
        return $file_info;
    }
}





