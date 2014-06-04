<?php

/**
 * This is the model class for table "{{datas}}".
 *
 * The followings are the available columns in table '{{datas}}':
 */
class PanoQueue extends Ydao
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Datas the static model class
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
        return '{{pano_queue}}';
    }

    public function add_queue($datas){
    	if (!$datas['scene_id']){
    		return false;
    	}
    	$pano_datas = $this->find_by_scene_id($datas['scene_id']);
    	if($pano_datas){
    		return $this->update_state($datas['scene_id'], 1);
    	}
    	else{
	    	$this->scene_id = $datas['scene_id'];
	    	$this->state = 1;
	    	$this->update_time = time();
	    	return $this->save();
    	}
    }

    public function find_by_scene_id($scene_id){
    	return $this->findByPk($scene_id);
    }
    public function update_state($scene_id, $state){
    	if(!$scene_id){
    		return false;
    	}
    	return $this->updateByPk($scene_id, array('state'=>$state, 'update_time'=>time()));
    }
    public function update_state_locked($scene_id, $state, $locked=0){
    	if(!$scene_id){
    		return false;
    	}
    	return $this->updateByPk($scene_id, array('state'=>$state, 'locked'=>$locked, 'update_time'=>time()));
    }
    
    public function update_lock($scene_id, $locked){
    	if(!$scene_id){
    		return false;
    	}
    	return $this->updateByPk($scene_id, array('locked'=>$locked, 'update_time'=>time()));
    }
	/**
	 * 获取需处理的队列
	 */
    public function get_undeal_list(){
    	
    	$criteria=new CDbCriteria;
    	$criteria->order = 'update_time ASC';
    	$criteria->limit = '1';
    	$criteria->addCondition('state=1');
    	$criteria->addCondition('locked=0');
    	$queue_datas = $this->findAll($criteria);
    	return $queue_datas;
    }
    /**
     * 获取已处理的队列
     */
    public function get_deal_list(){
    	$criteria=new CDbCriteria;
    	$criteria->order = 'update_time ASC';
    	$criteria->addCondition('state=0');
    	$criteria->addCondition('locked=0');
    	$queue_datas = $this->findAll($criteria);
    	return $queue_datas;
    }
}







