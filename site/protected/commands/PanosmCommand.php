<?php
class PanosmCommand extends CConsoleCommand {
    //public $defaultAction = 'index'; //默认动作
    //public $find_path = '/mnt/hgfs/pics/suzhou/zzy'; //搜索全景图的目录
    public $find_path = "C:/mydatas/pic/hai";
	//public $find_path = "C:/Users/faashi/Desktop/pics/苏州/留园";
    public $panos_path = array();
    public $default_new_folder = 'panos';  //新的全景图目录
	public $default_lightroom = 'ligthroom';
    public $default_pano_name = 'Panorama.jpg'; //默认的搜索的全景图名称
    public $new_pano_name = 'Panorama-2.jpg';
    public $width = '1800';  //cube图的宽度
    public $swidth = '5800'; //sphere的宽度
    public $sheight = '2900'; //sphere的宽度
    public $error = array();
    public $split_file = '';
    public $cube_path = '';
    public $upload_path = 'upload';
    public $thumb_size = 'thumbx200.jpg';
    public $thumb_name = 'thumb.jpg';
    public $thumb_size800 = 'thumbx800.jpg';
    public $reduce_path = 'upload/201211/11';  //体积较少
    public $reduce_files = array();
	public $windows = true;
	public $win_shpere_path = 'c:/tmp/script-s.txt';
	public $cube_side = array('front'=>'o f4 y0 r0 p0 v360', 
							'left'=>'o f4 y90 r0 p0 v360',
							'back'=>'o f4 y-180 r0 p0 v360',
							'bottom'=>'o f4 y0 r0 p90 v360',
							'right'=>'o f4 y-90 r0 p0 v360',
							'top'=>'o f4 y0 r0 p-90 v360'
							);

    //一键执行
    public function actionRun(){
        $this->cube_path = $this->find_path.'/'.$this->default_new_folder;
        $this->actionFind();
        $this->new_pano_name = $this->default_pano_name;
        //手工处理生成的全景图
        $this->actionCube();
        $this->actionBottomOut();
        //手工处理cube底部图
        $this->actionBottomIn();
		
        $this->actionThumb();
        $this->actionUpload();
    }

    //归类需要上传的文件
    public function actionUpload(){
    	$upload_path = $this->find_path.'/'.$this->upload_path.'/';
    	$search_path = $this->find_path.'/'.$this->default_new_folder;
    	if(!file_exists($upload_path)){
    		mkdir($upload_path);
    	}
    	$this->myScanCubeDir($search_path);
    	$search_path .= '/';
    	$cubes = array('front', 'left', 'right', 'top', 'back', 'bottom');
    	foreach($this->panos_path as $v){
    		$fordle_explode = explode('/', $v);
    		$num = count($fordle_explode)-1;
    		$fordle = $fordle_explode[$num];
    		$new_fordle = $upload_path.$fordle.'/';
    		if(!file_exists($new_fordle)){
    			mkdir($new_fordle);
    		}
    		$source_path = $search_path.$fordle.'/';
    		echo "----move {$source_path}{$this->thumb_size} ----\n";
    		copy($source_path.$this->thumb_size, $new_fordle.$this->thumb_size);

    		echo "----move {$source_path}{$this->thumb_size800} ----\n";
    		copy($source_path.$this->thumb_size800, $new_fordle.$this->thumb_size800);

    		$cube_path = $source_path.'cube/';
    		foreach($cubes as $v1){
    			echo "----move {$cube_path}{$v1} ----\n";
    			copy($cube_path.$v1.'.jpg', $new_fordle.$v1.'.jpg');
    		}
    	}
    }
    //查找全景图
    public function actionFind() {
        $this->panos_path = array();
        $this->myscandir($this->find_path);
        $new_folder = $this->find_path. DIRECTORY_SEPARATOR .$this->default_new_folder;
        echo $new_folder;
        if(!file_exists($new_folder)){
            mkdir($new_folder);
        }
        $this->moveFiles();

        //print_r($this->panos_path);
    }
	//删除全景图
	public function actionDelpano(){
		//echo $this->find_path;
		$this->del_pano($this->find_path);
	}
	/**
     * 删除
     */
    public function del_pano($path){
        foreach(scandir($path) as $file){
			if($file != '.' && $file != '..'){
				$path2= $path.'/'.$file;
				//echo $path2."\r\n";
                if(is_dir($path2)){
                    $this->del_pano($path2);
                }
                else if($file == $this->default_pano_name){
                    //echo $path.'/'.$file."\r\n";
					$path3 = $path.'/'.$file;
					echo $path3."\r\n";
					unlink($path3);
                }
			}
            
        }
    }
    //全景图转为cube
    public function actionCube(){
    	//$this->default_pano_name = $this->new_pano_name;
    	$this->cube_path = $this->find_path.'/'.$this->default_new_folder;
    	$path = $this->cube_path;
    	$this->panos_path = array();
    	$this->myscandir($path);
    	//print_r($this->panos_path);
    	foreach ($this->panos_path as $v){
			$str = substr($v, strlen($v)-15, 2);
				if($str!='06'){
					//continue;
				}
    		echo "----deal file {$v} ----\r\n";
			if(!$this->windows){
				$this->cube($v);
				$this->split_file = $v;
				$this->exec_libpano();
			}
			else{
				
				$this->cube_win($v);
			}
    		echo "----end deal file {$v} ----\r\n";
    	}
    	print_r($this->error);
    }
	
    //归类cube中的bottom图
    public function actionBottomOut(){
        $this->cube_path = $this->find_path.'/'.$this->default_new_folder;
        $path = $this->cube_path.'/bottom';
        if(!file_exists($path)){
            mkdir($path);
        }
        $this->panos_path = array();
        $this->default_new_folder = 'bottom';
        $this->default_pano_name = 'bottom.JPG';
        $this->myscandir($this->cube_path);
        foreach($this->panos_path as $v){
			if($this->windows){
				$v = str_replace('\\', "/", $v);
			}
            $explode = explode('/', $v);
            $num = count($explode)-3;
            $new_path = $path.'/'.$explode[$num];
            $new_file = $new_path.'-bottom.JPG';
            echo "---- copying {$v} to {$new_file}----\n";
            copy($v, $new_file);
        }
        //print_r($this->panos_path);
    }
    //将处理过的bottom图归回
    public function actionBottomIn(){
        $this->cube_path = $this->find_path.'/'.$this->default_new_folder;
        $path = $this->cube_path.'/bottom';
        if(!file_exists($path)){
            return false;
        }
        $this->panos_path = array();
        //$this->default_pano_name = 'bottom.jpg';
        $this->myscandir($path, true);
        foreach($this->panos_path as $v){
			if($this->windows){
				$v = str_replace('\\', "/", $v);
			}
            $explode = explode('/', $v);
			echo $v;
            $num = count($explode)-1;
            $file = $explode[$num];
            $explode_file = explode('-', $file);
			
            $new_path = $this->cube_path.'/'.$explode_file[0].'/cube';
			
            if(!file_exists($new_path)){
                $this->error[] = $new_path;
            }
            $new_file = $new_path.'/bottom.jpg';
            echo "---- copying {$v} to {$new_file}----\n";
            //$back_file = $new_path .'/bottom_back.jpg';
            //copy($new_file, $back_file);
            copy($v, $new_file);
        }
        print_r($this->error);
    }
    //生成缩略图
    public function actionThumb(){
    	$this->cube_path = $this->find_path.'/'.$this->default_new_folder;
    	//$this->default_pano_name = $this->new_pano_name;
    	$path = $this->cube_path;
    	$this->panos_path = array();
    	$this->myscandir($path);
    	//print_r($this->panos_path);
    	$i = 0;
    	foreach ($this->panos_path as $v){
    		echo "----thumb file {$v} ----\n";
    		$old = $v;
    		$length = strlen($this->default_pano_name);
    		$new_path = substr($v, 0,strlen($v)-$length);
    		$new = $new_path.$this->thumb_name;
    		$myimage = new Imagick($old);
    		$myimage->cropimage(4000, 2000, 926, 300);
    		$myimage->writeImage($new);

    		$myimage->resizeimage(800, 400, Imagick::FILTER_LANCZOS, 1, true);
    		$new = $new_path.$this->thumb_size800;
    		$myimage->writeImage($new);

    		$myimage->resizeimage(200, 100, Imagick::FILTER_LANCZOS, 1, true);
    		$new = $new_path.$this->thumb_size;
    		$myimage->writeImage($new);
    		$myimage->clear();
    		$myimage->destroy();
    		$i++;
    		echo "----end thumb file {$v} ----\n";
    	}
    	print_r($this->error);
    }
    //cube to sphere
	
    public function actionSphere(){
        $this->cube_path = $this->find_path.'/'.$this->default_new_folder;
        $this->panos_path = array();
        $path = $this->cube_path;
        $this->myScanCubeDir($path);
		foreach($this->panos_path as $k=>$v){
			if($k!="8"){
				//continue;
			}
//echo $k.'--'.$v."\r\n";
        	$this->sphere($v);
		}
    }
    public function sphere($path){
		if($this->windows){
				$path = str_replace('\\', "/", $path);
		}
        $front = $path.'/cube/front.JPG';
        $left = $path.'/cube/left.JPG';
        $back = $path.'/cube/back.JPG';
        $right = $path.'/cube/right.JPG';
        $top = $path.'/cube/top.JPG';
        $bottom = $path.'/cube/bottom.JPG';
        $script = "p w{$this->swidth} h{$this->sheight} f2 v360 u0 n\"JPEG q95\"
i n\"{$front}\"
o f0 y0 r0 p0 v90
i n\"{$right}\"
o f0 y90 r0 p0 v90
i n\"{$back}\"
o f0 y-180 r0 p0 v90
i n\"{$left}\"
o f0 y-90 r0 p0 v90
i n\"{$top}\"
o f0 y0 r0 p90 v90
i n\"{$bottom}\"
o f0 y0 r0 p-90 v90";
        file_put_contents($this->win_shpere_path, $script);
		if($this->windows){
			$to = $path.'/Panorama.jpg';
			$this->exec_sphere_win($to);
		}
		else{
			$this->exec_sphere();
		}
		return  true;
    }
	/**
	归类需lightroom处理的图片
	*/
	public function actionLight(){
		$path = $this->find_path.'/'.$this->default_new_folder;
		$this->scan_light($path);
		if(!$this->panos_path){
			echo "no panoramas\r\n";
		}
		$new_path =  $path.'/'.$this->default_lightroom;
		if(!is_dir($new_path)){
			mkdir($new_path);
		}
		foreach($this->panos_path as $v){
			if($this->windows){
				$v = str_replace('\\', "/", $v);
			}
			$explodes = explode('/', $v);
			$count = count($explodes);
			$num = $explodes[$count-2];
			echo "/{$this->default_new_folder}/{$num}/\r\n";
			$new_file = str_replace("/{$this->default_new_folder}/{$num}/", "/{$this->default_new_folder}/{$this->default_lightroom}/{$num}_", $v);
			echo $new_file."\r\n";
			copy($v, $new_file);
			echo "-----copy {$new_file}-----\r\n ";
		}
		
	}
	
	//windows下处理
	public function cube_win($path){
		$path = str_replace('\\', "/", $path);
		$str = "p w{$this->width} h{$this->width} f0 v90 u20 n\"JPEG q100\"\r\n";
		$str .= "i n\"{$path}\"\r\n";
		foreach($this->cube_side as $k=>$v){
			$content = $str.$v;
			$file_txt = "c:/tmp/{$k}.txt";
			file_put_contents($file_txt, $content);
			$explod_a = explode('/', $path);
			
			$floder = '';
			for($i=0; $i<(count($explod_a)-1); $i++){
				$floder .= $explod_a[$i].'/';
			}
			$new_path = $floder.'cube/';
			if(!file_exists($new_path)){
				mkdir($new_path);
			}
			$to = $new_path.$k;
			$this->exec_to_cube_win($file_txt, $to);
		}
	}
	public function exec_to_cube_win($file, $to){
		$to = $to.'.jpg';
		$str = "c:\mydatas\soft\PTStitcherNG\PTStitcher.exe {$file} -o {$to}";
        echo "----sphere pano {$file}----\n";
		echo $str."\r\n";
		
        system($str);
		/*$file = substr($to, 0, strlen($to)-2).'tif';
		echo "\r\n";
		echo "\r\n";
		echo $file."\r\n";*/
		//echo $to;
		//copy($to, $file);
		//unlink($to);
		//exit();
        echo "----sphere pano down {$file}----\n";
		
	}
	public function exec_sphere_win($to){
        $str = "c:\mydatas\soft\PTStitcherNG\PTStitcher.exe {$this->win_shpere_path} -o {$to}";
		echo $str."\r\n";
        system($str);
		echo "-----end {$str}----\r\n";
	$this->lightness($to);
    }

    //提高亮度，加锐化
    public function lightness($to){
//$to = 'C:/mydatas/pic/hai/panos/01/Panorama.JPG';
    	$myimage = new Imagick($to);
    	$myimage->setImageFormat("jpeg");
    	//$myimage->setCompressionQuality( 60 );
    	$myimage->sharpenimage(1.5, 1.5);
    	$myimage->modulateImage(102, 100, 100);
    	$myimage->writeImage($to);
    	$myimage->clear();
    	$myimage->destroy();
    }
	
    public function exec_sphere(){
        $str = "/usr/local/libpano13/bin/PTmender script-s.txt";
        echo "----sphere pano {$this->split_file}----\n";
        system($str);
        echo "----sphere pano down {$this->split_file}----\n";
        $this->covert();
    }
    public function exec_libpano(){
        $str = "/usr/local/libpano13/bin/PTmender script.txt";
        echo "----cube pano {$this->split_file}----\n";
        system($str);
        echo "----cube pano down {$this->split_file}----\n";
        $this->covert();
    }
    public function covert(){
        $panos = array( 'pano0005'=>'bottom',
                        'pano0000'=>'front',
                        'pano0001'=>'right',
                        'pano0002'=>'back',
                        'pano0003'=>'left',
                        'pano0004'=>'top', );
        foreach($panos as $k=>$v){
            $old = $k.'.JPG';
            $new = $v.'.jpg';
            echo "----covering tifToJpg {$old}----\n";
            //$this->tifToJpg($old, $new);
            echo "----covering tifToJpg success {$old}----\n";
            $this->move_cube_file($new);
        }
    }
    public function move_cube_file($file){
        $explode = explode('/', $this->split_file);
        $num = count($explode)-2;
        $new_folder = $this->cube_path.'/'.$explode[$num].'/cube';
        $new_file = $new_folder.'/'.$file;
    	if(!file_exists($new_folder)){
    		mkdir($new_folder);
    	}

    	copy($file, $new_file);
    	unlink($file);
    	echo "....moving to {$new_file}\n";
    }
    public function tifToJpg($old, $new){
        if(!file_exists($old)){
            $this->error[] = $old;
            return false;
        }
        $myimage = new Imagick($old);
        $myimage->setImageFormat("jpeg");
        $myimage->setCompressionQuality( 100 );
        $myimage->writeImage($new);
        $myimage->clear();
        $myimage->destroy();
        if(!file_exists($new)){
            $this->error[] = $old;
            return false;
        }
    }
    public function cube($path){
        $script = "p w{$this->width} h{$this->width} f0 v90 u20 n\"TIFF_m\"\n
i n\"{$path}\"\n
o f4 y0 r0 p0 v360\n
i n\"{$path}\"\n
o f4 y-90 r0 p0 v360\n
i n\"{$path}\"\n
o f4 y-180 r0 p0 v360\n
i n\"{$path}\"\n
o f4 y90 r0 p0 v360\n
i n\"{$path}\"\n
o f4 y0 r0 p-90 v360\n
i n\"{$path}\"\n
o f4 y0 r0 p90 v360";
        return file_put_contents('script.txt', $script);
    }
    public function moveFiles(){
        if(!$this->panos_path){
            return false;
        }
        foreach($this->panos_path as $v){
            $path_explode = explode(DIRECTORY_SEPARATOR, $v);
            $num = count($path_explode)-3;
            $folder = $path_explode[$num];
            $path = $this->find_path. DIRECTORY_SEPARATOR . $this->default_new_folder. DIRECTORY_SEPARATOR. $folder;
            $new_file = $path.DIRECTORY_SEPARATOR.$this->default_pano_name;

            if(!file_exists($path)){
                mkdir($path);
                //copy($v, $dest)
            }
            if(file_exists($new_file)){
                continue;
            }
            if( !copy($v, $new_file)){
                echo 'error---'.$new_file."\n";
            }
            else{
                echo 'ok---'.$new_file."\n";
            }
        }
    }
    /**
     * 扫描目录
     */
    public function myscandir($path, $scan_default=false){
        if(!is_dir($path))  return;

        foreach(scandir($path) as $file){
            if($file!='.'  && $file!='..' && $file != $this->default_new_folder){
                $path2= $path.DIRECTORY_SEPARATOR.$file;
                if(is_dir($path2)){
                    $this->myscandir($path2);
                }
                else if($scan_default){
                    $this->panos_path[] = $path.DIRECTORY_SEPARATOR.$file;
                }
                else if($file == $this->default_pano_name){
                    $this->panos_path[] = $path.DIRECTORY_SEPARATOR.$file;
                }
            }
        }
    }

    /**
     * 扫描目录下的cube
     */
    public function myScanCubeDir($path){
    	if(!is_dir($path))  return;
    	foreach(scandir($path) as $file){
    		if($file!='.'  && $file!='..' && $file!='bottom'){
    			$path2= $path.DIRECTORY_SEPARATOR.$file;
    			if(is_dir($path2)){
    				$this->panos_path[] = $path2;
    			}
    		}
    	}
    }
	
	
	/**
	lightroom处理的图片归类
	*/
	private function scan_light($path){
		if(!is_dir($path))  return;
    	if($file!='.'  && $file!='..' ){
                $path2= $path.$file;
                if(is_dir($path2)){
                    $this->myscandir($path2);
                }
                else if($file == $this->default_pano_name){
                    $this->panos_path[] = $path.$file;
                }
            }
	}
    
    /**
     * 获取要减小的文件
     */
    public function actionReduce(){
    	$path = $this->reduce_path;
    	$this->get_reduce_file($path);
    	//print_r($this->reduce_files);
    	//print_r($reduce_path);
    	$i = 0;
    	foreach($this->reduce_files as $v){
    		if ($i>10){
    			//continue;
    		}

    		$file_size = filesize($v);
    		$quality = 80;
    		if($file_size <350000){
    			continue;
    		}
    		if($file_size >800000){
    			echo $v."---{$file_size}\n";
    			$quality = 45;
    		}
    		else if($file_size >700000){
    			echo $v."---{$file_size}\n";
    			$quality = 50;
    		}
    		else if($file_size >600000){
    			echo $v."---{$file_size}\n";
    			$quality = 55;
    		}
    		else if($file_size >500000){
    			echo $v."---{$file_size}\n";
    			$quality = 65;
    		}
    		else if($file_size >400000){
    			echo $v."---{$file_size}\n";
    			$quality = 75;
    		}
    		else if($file_size >350000){
    			echo $v."---{$file_size}\n";
    			$quality = 85;
    		}

    		$img = new Imagick();
			$img->readImage($v);
			$img->setImageCompression(imagick::COMPRESSION_JPEG);
			$img->setImageCompressionQuality($quality);
			$img->stripImage();
			$img->writeImage($v);
	    	$img->clear();
	    	$img->destroy();
	    	$i++;
    		//continue;

    	}
    }
	public function get_reduce_file($path){
    	if(!is_dir($path))  return;
        foreach(scandir($path) as $file){
            if($file!='.'  && $file!='..'){
                $path2= $path.DIRECTORY_SEPARATOR.$file;

                if(is_dir($path2)){
                    $this->get_reduce_file($path2);
                }
                else if($file == '1000x1000.jpg'){
                    $this->reduce_files[] = $path2;
                }
            }
        }
        return $this->reduce_files;
    }
}