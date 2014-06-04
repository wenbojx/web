<?php

/**
 * This is the model class for table "{{datas}}".
 *
 * The followings are the available columns in table '{{datas}}':
 */
class ProjectExtendFang extends Ydao
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
        return '{{project_extend_fang}}';
    }
    public function get_by_project_id($project_id){
    	if(!$project_id){
    		return false;
    	}
    	return $this->findByPk($project_id);
    }

}







