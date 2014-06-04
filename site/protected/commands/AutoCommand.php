<?php
ini_set('memory_limit', '100M');
class AutoCommand extends CConsoleCommand {

    public $panos_path = array();
    //public $search_path = '/mnt/hgfs/pics/upload/chm0824';
    public $search_path = '/mnt/hgfs/pics/upload/xihu';
    public $thumb_size200 = 'thumbx200.jpg';
    public $cubes = array('front', 'left', 'right', 'top', 'back', 'bottom');
    public $default_m_id = 1;
    public $default_project_name = 'test4';

    public function actionRun(){
        $this->default_project_name = date('Y-m-dH', time());
        $this->myScanCubeDir($this->search_path);
        //print_r($this->panos_path);
        $project_id = $this->add_project();
        //添加项目
        foreach ($this->panos_path as $v){
            $fordle_explode = explode('/', $v);
            $num = count($fordle_explode)-1;
            $fordle = $fordle_explode[$num];
            $scene_id = $this->add_scene($project_id, $fordle);
            $this->save_datas($scene_id, $v, $this->thumb_size200, true, '');
            foreach ($this->cubes as $v1){
                $this->save_datas($scene_id, $v, $v1.'.jpg', false, $v1);
            }
        }
    }
    private function save_datas($scene_id, $path, $file, $thumb_flag = false, $position){
        $file_info = $this->move_pics( $path, $file, $thumb_flag);
            $path_id = $this->save_file_path($file_info);
            if(!$path_id){
                continue;
            }
            $file_id = $this->save_file($this->default_m_id, $file_info['md5value']);
            if(!$file_id){
                continue;
            }
            if($thumb_flag){
                $flag_scene =$this->save_scene_thumb($file_id,$scene_id);
            }
            else{
                if($position == 'bottom'){
                    $position = 'down';
                }
                if($position == 'top'){
                    $position = 'up';
                }
                $flag_scene = $this->save_scene_file($file_id, $scene_id, $position);
            }

    }
    private function move_pics( $path, $file_name, $thumb_flag=false){
        $pre = Yii::app()->params['file_pic_folder'].'/';
        $file_info['folder'] = date('Y',time()).date('m',time());
        $folder_pic = $pre.$file_info['folder'].'/';
        if(!is_dir($folder_pic)){
            echo "-----mkdir {$folder_pic} -----\n";
            mkdir($folder_pic);
        }
        $day = date('d',time());
        $folder_pic .= $day.'/';
        $file_info['folder'] .= $day;
        if(!is_dir($folder_pic)){
            echo "-----mkdir {$folder_pic} -----\n";
            mkdir($folder_pic);
        }
        $file = $path.'/'.$file_name;
        $file_info['md5value'] = md5_file($file);
        $folder_pic .= $file_info['md5value'].'/';
        if(!is_dir($folder_pic)){
            echo "-----mkdir {$folder_pic} -----\n";
            mkdir($folder_pic);
        }
        $folder = $folder_pic.'original/';
        if(!is_dir($folder)){
            echo "-----mkdir {$folder} -----\n";
            mkdir($folder);
        }

        $file_info['name'] = $file_name;//获取文件名
        $file_info['size'] = filesize($file);//获取文件大小
        $file_info['type'] = 'jpg';//获取文件类型
        $uploadfile = $folder.$file_info['md5value'].'.'.$file_info['type'];
        copy($file, $uploadfile);
        if($thumb_flag){
            return $file_info;
        }
        $pano_pic_tools = new PanoPicTools();
        //将文件处理成1024大小
        $pano_pic_tools->resize_pano($uploadfile, $folder_pic, $file_info['type']);

        return $file_info;
    }
    //添加项目
    private function add_project(){
        $project_db = new Project();
        $datas['name'] = $this->default_project_name;
        $datas['desc'] = '';
        $datas['member_id'] = $this->default_m_id;
        $datas['created'] = time();
        if(!$id = $project_db->add_project($datas)){
            return false;
        }
        return $id;
    }
    //添加场景
    private function add_scene($project_id ,$name){
        $scene_db = new Scene();

        $datas['name'] = $name;
        $datas['desc'] = '';
        $datas['member_id'] = $this->default_m_id;
        $datas['project_id'] = $project_id;
        $datas['created'] = time();
        if(!$id = $scene_db->add_scene($datas)){
            return false;
        }
        return $id;
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
     * 扫描目录下的cube
     */
    public function myScanCubeDir($path){
        if(!is_dir($path))  return;

        foreach(scandir($path) as $file){
            if($file!='.'  && $file!='..' ){
                $path2= $path.DIRECTORY_SEPARATOR.$file;
                if(is_dir($path2)){
                    $this->panos_path[] = $path2;
                }
            }
        }
    }
}