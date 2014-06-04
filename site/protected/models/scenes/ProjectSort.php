<?php
class ProjectSort extends Ydao
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
        return '{{project_sort}}';
    }
    
    public function get_by_sort_id($sort_id){
    	if(!$sort_id){
    		return false;
    	}
    	return $this->findByPk($sort_id);
    }
    
}