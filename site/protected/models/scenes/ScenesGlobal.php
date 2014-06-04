<?php
class ScenesGlobal extends Ydao
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
		return '{{scene_global}}';
	}
	public function save_global($datas, $scene_id){
		if(!$scene_id){
			return false;
		}
		$content = json_encode($datas);
		if (!$scene_datas = $this->find_by_scene_id($scene_id)){
			$this->scene_id = $scene_id;
			$this->content = $content;
			return $this->insert();
		}
		else{
			$attributes = array('content'=>$content);
			return $this->updateByPk($scene_id, $attributes);
		}
	}
	public function find_by_scene_id($scene_id){
		return $this->findByPk($scene_id);
	}
	
}




