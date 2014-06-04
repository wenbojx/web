<?php

/**
 * This is the model class for table "{{datas}}".
 *
 * The followings are the available columns in table '{{datas}}':
 */
class ProjectQueue extends Ydao
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
        return '{{project_queue}}';
    }

    public function add_queue($datas){
    	if (!$datas['project_id']){
    		return false;
    	}
    	$pano_datas = $this->find_by_project_id($datas['project_id']);
    	if($pano_datas){
    		return $this->update_state($datas['project_id'], 0);
    	}
    	else{
	    	$this->project_id = $datas['project_id'];
	    	$this->state = 0;
	    	$this->update_time = time();
	    	return $this->save();
    	}
    }

    public function find_by_project_id($project_id){
    	return $this->findByPk($project_id);
    }
    public function update_state($project_id, $state){
    	if(!$project_id){
    		return false;
    	}
    	return $this->updateByPk($project_id, array('state'=>$state, 'update_time'=>time()));
    }
	/**
	 * 获取需处理的队列
	 */
    public function get_undeal_list(){
    	
    	$criteria=new CDbCriteria;
    	$criteria->order = 'update_time ASC';
    	$criteria->limit = '1';
    	$criteria->addCondition('state=0');
    	$queue_datas = $this->find($criteria);
    	return $queue_datas;
    }

}







