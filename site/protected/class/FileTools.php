<?php
class FileTools{

/**
 * 清理某场景下的所有静态文件
 */
public function del_pano_static_files($scene_id, $add_prefix=''){
	if(!$scene_id){
		return false;
	}
	$path = PicTools::get_pano_static_path($scene_id);
	if($add_prefix!='' && !strstr($path, '../')){
		$path .= '/' . $add_prefix;
	}
	return $this->delFileUnderDir ($path);
}
private function delFileUnderDir( $dirName='' ){
		if(!$dirName || !is_dir($dirName) || !strstr($dirName, 'pp/')){
			return false;
		}
		if(count(explode('/', $dirName))<4){
			return false;
		}
		if ( $handle = opendir( "$dirName" ) ) {
			while ( false !== ( $item = readdir( $handle ) ) ) {
				if ( $item != "." && $item != ".." ) {
					if ( is_dir( "$dirName/$item" ) ) {
						$this->delFileUnderDir( "$dirName/$item" );
					} else {
						unlink( "$dirName/$item" );
					}
				}
			}
			closedir( $handle );
		}
	}
}