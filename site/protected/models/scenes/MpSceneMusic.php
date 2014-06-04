<?php
class MpSceneMusic extends Ydao
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Fields the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{scene_music}}';
    }
    public function save_datas($datas){
    	if(!$datas['scene_id'] || !$datas['file_id']){
    		return false;
    	}
    	$flag = false;
    	//print_r($datas);
    	if($datas['music_id']){
    		$id = $datas['music_id'];
    		unset($datas['music_id']);
    		$flag = $this->updateByPk($id, $datas);
    		//echo $flag;
    		return $flag;
    	}
    	else{
	    	$this->scene_id = $datas['scene_id'];
	    	$this->file_id = $datas['file_id'];
	    	$this->volume = $datas['volume'];
	    	$this->loop = $datas['loop'];
	    	$this->state = $datas['state'];
	    	$flag = $this->save();
	    	return $this->attributes['id'];
    	}
    }
    public function get_by_scene_id($scene_id, $state='', $order=''){
    	$criteria=new CDbCriteria;
    	$criteria->order = 'id Desc';
    	if($order!=''){
    		$criteria->order = $order;
    	}
    	if($state!=''){
    		$criteria->addCondition("state={$state}");
    	}
    	$criteria->addCondition("scene_id={$scene_id}");
    	//print_r($criteria);
    	$music_datas = $this->find($criteria);
    	//print_r($music_datas);
    	if(!$music_datas){
    		return false;
    	}
    	return $music_datas;
    }
    public function get_by_scene_ids($scene_ids, $state='', $order=''){
    	if(!$scene_ids){
    		return false;
    	}
    	$criteria=new CDbCriteria;
    	$criteria->order = 'id ASC';
    	if($order!=''){
    		$criteria->order = $order;
    	}
    	if($state!=''){
    		$criteria->addCondition("state={$state}");
    	}
    	$scene_str = implode(',', $scene_ids);
    	
    	$criteria->addCondition("scene_id in ({$scene_str})");
    	//print_r($criteria);
    	$music_datas = $this->findAll($criteria);
    	//print_r($music_datas);
    	if(!$music_datas){
    		return false;
    	}
    	return $music_datas;
    }
}




