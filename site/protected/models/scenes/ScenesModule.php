<?php
class ScenesModule extends Ydao
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
		return '{{scene_module}}';
	}

	public function find_by_scene_id($scene_id){
		if(!$scene_id){
			return false;
		}
		$criteria=new CDbCriteria;
		$criteria->addCondition("scene_id=({$scene_id})");
		$criteria->order = 'type ASC';
		return $this->findAll($criteria);
	}
}