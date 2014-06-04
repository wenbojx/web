<?php 
ini_set('memory_limit', '100M');
class Pano2CubeCommand extends CConsoleCommand {
	
	public $width = '3724';  //cube
	public $swidth = '11700'; //sphere
	public $sheight = '5850'; //sphere
	public $windows = false;
	private $win_path_prefix = 'C:/mydatas/APMServ5.2.6/www/htdocs/home/home';
	private $win_pttool_path = 'c:\mydatas\soft\PTStitcherNG\PTStitcher.exe';
	//public $win_shpere_prefix = 'c:/tmp';
	
	private $linux_path_prefix = '/var/www/home/home';
	private $linux_pttool_path = '/usr/local/libpano13/bin/PTmender';
	//public $linux_shpere_prefix = '/tmp';
	private $script_num = '';
	private $script_path = '';
	
	public $cube_side = array('front'=>'o f4 y0 r0 p0 v360',
			'left'=>'o f4 y90 r0 p0 v360',
			'back'=>'o f4 y-180 r0 p0 v360',
			'bottom'=>'o f4 y0 r0 p90 v360',
			'right'=>'o f4 y-90 r0 p0 v360',
			'top'=>'o f4 y0 r0 p-90 v360'
	);
	
	public function actionRun(){
		
		$scene_ids = $this->get_queue_list();
		//print_r($scene_ids);
		if(!$scene_ids){
			return false;
		}
		
		$pano_pics = $this->get_pano_pic_path($scene_ids);
		//print_r($pano_pics);
		if(!$pano_pics){
			return false;
		}
		
		$num = $this->get_script_path();
		if(!$num){
			return false;
		}
		$this->script_num = $num;
		foreach($scene_ids as $v){
			$pano_queue = new PanoQueue();
			$pano_queue->update_lock($v, 1);
		}
		
		foreach($pano_pics as $k=>$v){
			$this->turn_to_cube($v);
			$this->update_item_state_lock($k);
		}
		if (file_exists($this->script_path)) {
			unlink ($this->script_path);
		}
	}
	/**
	 * 获取script 线程ID
	 */
	private function get_script_path(){
		$num = '';
		$prefix = '';
		$flag = false; //是否有位置
		if($this->windows){
			$prefix = $this->win_path_prefix . '/tmp';
		}
		else{
			$prefix = $this->linux_path_prefix . '/tmp';
		}
			$path_1 = $prefix . '/' . 'script-s-1';
			$path_2 = $prefix . '/' . 'script-s-2';
			//$path_3 = $prefix . '/' . 'script-s-3';
			
			if(!file_exists($path_1)){
				$num = 1;
				file_put_contents($path_1, 1);
				$this->script_path = $path_1;
			}
			elseif(!file_exists($path_2)){
				$num = 2;
				file_put_contents($path_2, 1);
				$this->script_path = $path_2;
			}
			/* elseif(!file_exists($path_3)){
				$num = 3;
				file_put_contents($path_3, 1);
				$this->script_path = $path_3;
			} */
		return $num;
	}
	/**
	 * 系统处理图片
	 */
	public function turn_to_cube($path){
		if($this->windows){
			$path = $this->win_path_prefix . "/". $path;
		}
		else{
			$path = $this->linux_path_prefix . "/". $path;
		}
		if($this->windows){
			$str = "p w{$this->width} h{$this->width} f0 v90 u20 n\"JPEG q70\"\r\n";
		}
		else{
			$str = "p w{$this->width} h{$this->width} f0 v90 u20 n\"TIFF_m q70\"\r\n";
		}
		$str .= "i n\"{$path}\"\r\n";
		$script_path_prefix = $this->windows ? $this->win_path_prefix : $this->linux_path_prefix;
		foreach($this->cube_side as $k=>$v){
			$content = $str.$v;
			
			$file_txt = "{$script_path_prefix}/tmp/{$this->script_num}/{$k}.txt";
			
			file_put_contents($file_txt, $content);
			$explod_a = explode('/', $path);
				
			$floder = '';
			for($i=0; $i<(count($explod_a)-2); $i++){
				$floder .= $explod_a[$i].'/';
			}
			$new_path = $floder.'cube/';
			echo $new_path."\r\n";
			if(!file_exists($new_path)){
				mkdir($new_path);
			}
			$to = $new_path.$k;
			$this->exec_to_cube_win($file_txt, $to);
		}
	}
	
	private function exec_to_cube_win($file, $to){
		if($this->windows){
			$to = $to.'.jpg';
		}
		else{
			$to = $to.'.tif';
		}
		if($this->windows){
			$str = "{$this->win_pttool_path} {$file} -o {$to}";
		}
		else{
			$str = "{$this->linux_pttool_path} {$file} -o {$to}";
		}
		echo "----sphere pano {$file}----\n";
		echo $str."\r\n";
		
	    system($str);
	    if($this->windows){
		    $move_to = strtolower($to);
		    rename($to, $move_to);
	    }
	    else{
	    	$move_to = substr($to, 0, strlen($to)-3) . '.jpg';
	    	$myimage = new Imagick($to);
	    	//$myimage->cropimage(4000, 2000, 926, 300);
	    	$myimage->writeImage($move_to);
	    	unlink($to);
	    	$myimage->clear();
	    	$myimage->destroy();
	    }

		echo "----sphere pano down {$file}----\n";
	}
	
	
	
	/**
	 * 获取需处理的队列
	 */
	private function get_queue_list(){
		$pano_queue = new PanoQueue();
		$queue_list = $pano_queue->get_undeal_list();
		if(!$queue_list){
			return false;
		}
		$scene_ids = array();
		foreach ($queue_list as $v){
			$scene_ids[] = $v['scene_id'];
		}
		return $scene_ids;
	}
	/**
	 * 更新队列项目状态
	 */
	private function update_item_state_lock ($scene_id){
		$pano_queue = new PanoQueue();
		return $pano_queue->update_state_locked($scene_id, 0, 0);
	}
	/**
	 * 更新队列项目锁定
	 */
	private function update_item_locked ($scene_id){
		$pano_queue = new PanoQueue();
		return $pano_queue->update_lock($scene_id, 0);
	}
	
	/**
	 * 获取需处理图片
	 */
	private function get_pano_pic_path($scene_ids){
		$scene = new Scene();
		$scene_datas = $scene->get_by_scene_ids($scene_ids);
		if(!$scene_datas){
			return false;
		}
		//print_r($scene_datas);
		$scene_file = array();
		foreach($scene_datas as $v){
			if($v['file_id']){
				$scene_file[$v['id']] = $v['file_id'];
			}
		}
		if(!$scene_file){
			return false;
		}
		$file_path = $this->get_path_by_file_ids($scene_file);
		return $file_path;
	}
	/**
	 * 获取图片地址
	 */
	private function get_path_by_file_ids ($file_ids){
		$file_path_db = new FilePath();
		$file_path = array();
		foreach($file_ids as $k=>$v){
			$file_path[$k] = $file_path_db->get_file_path($v, 'original');
		}
		return $file_path;
	}

}
?>

