<?php
class ScenesAction extends Ydao
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
		return '{{scene_action}}';
	}
	public function find_by_scene_id($scene_id){
		return $this->findAllByPk($scene_id);
	}
}