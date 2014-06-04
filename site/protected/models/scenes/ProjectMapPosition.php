<?php
class ProjectMapPosition extends Ydao
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
        return '{{project_map_position}}';
    }
    public function save_map_position($datas){
        if(!$datas['map_id'] || !$datas['scene_id']){
            return false;
        }
        $this->map_id = $datas['map_id'];
        $this->scene_id = $datas['scene_id'];
        $this->left = $datas['left'];
        $this->top = $datas['top'];
        //print_r($datas);
        if(!$this->save()){
        	return false;
        }
        $id = $this->attributes['id'];
        return $id;
    }
    public function del_marker($id){
    	if(!$id){
    		return false;
    	}
    	return $this->updateByPk($id, array('status'=>2));
    }
    public function find_by_map_id($map_id){
    	if(!$map_id){
    		return false;
    	}
        $criteria=new CDbCriteria;
    	if(!$map_id){
    		return false;
    	}
    	$criteria->addCondition('status=1');
    	$criteria->addCondition("map_id={$map_id}");
    	$position_datas = $this->findAll($criteria);
    	return $position_datas;
    }

}