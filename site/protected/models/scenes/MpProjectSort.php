<?php
class MpProjectSort extends Ydao
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
        return '{{mp_project_sort}}';
    }
    public function get_project_ids($sort_id){
    	if(!(int)$sort_id){
    		return false;
    	}
    	$criteria=new CDbCriteria;
    	$criteria->addCondition("sort_id={$sort_id}");
    	$criteria->addCondition("display=2");
    	if($order){
    		$criteria->order = $order;
    	}
    	//$criteria->addCondition("recommend=1");
    	$datas = $this->findAll($criteria);
    	$project_ids = array();
    	if($datas){
    		foreach($datas as $v){
    			$project_ids[] = $v['project_id'];
    		}
    	}
    	//rsort($project_ids);
    	return $project_ids;
    }
    /**
     * 根据分类信息获取项目详情
     */
    public function get_project_list($sort_id, $extend = 'fang'){
    	if(!$sort_id){
    		return false;
    	}
    	$project_ids = $this->get_project_ids($sort_id);
    	//print_r($project_ids);
    	$project_db = new Project();
    	return $project_db->get_by_project_ids($project_ids, $extend);
    }
}