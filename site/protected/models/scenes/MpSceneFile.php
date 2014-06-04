<?php

/**
 * This is the model class for table "{{fields}}".
 *
 * The followings are the available columns in table '{{fields}}':
 */
class MpSceneFile extends Ydao
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
        return '{{mp_scene_file}}';
    }
    public function map_position_num($position){
    	$positions = array('left'=>1,'right'=>2,'down'=>3,'up'=>4,'front'=>5,'back'=>6);
    	if(!isset($positions[$position])){
    		return 0;
    	}
    	return $positions[$position];
    }
    public function map_num_position($num){
    	$positions = array('1'=>'left','2'=>'right','3'=>'down','4'=>'up','5'=>'front','6'=>'back');
    	if(!isset($positions[$num])){
    		return 0;
    	}
    	return $positions[$num];
    }
    /**
     * 获取场景位置图信息
     */
    public function get_file_by_scene_position($scene_id, $position){
    	$position = $this->map_position_num($position);
    	if(!$scene_id || !$position){
    		return false;
    	}
    	return $this->findByAttributes(array('scene_id'=>$scene_id, 'position'=>$position));
    }
    /**
     * 获取场景图片信息
     */
    public function get_scene_list($scene_id){
    	$no_datas = array();
    	$scene_files = $this->findAllByAttributes(array('scene_id'=>$scene_id));
    	if(!$scene_files){
    		return $no_datas;
    	}
    	$file_ids = array();
    	foreach ($scene_files as $v){
    		$file_ids[] = $v->file_id;
    	}
    	$file_db = new File();
    	$file_datas = $file_db->findAllByPk($file_ids);
    	if(!$file_datas){
    		return $no_datas;
    	}
    	$file_datas_short = array();
    	foreach ($file_datas as $v){
    		$id = $v->id;
    		$file_datas_short[$id] = $v->md5file;
    	}
    	$scene_file_datas = array();
    	foreach ($scene_files as $v){
    		$position = $this->map_num_position($v->position);
    		$scene_file_datas[$position] = $file_datas_short[$v->file_id];
    	}
    	return $scene_file_datas;
    }
    public function save_scene_file($file_id, $scene_id, $position){
    	if(!$file_id || !$scene_id){
    		return false;
    	}
    	$file_data = $this->get_file_by_scene_position($scene_id, $position);
    	if($file_data){
    		$mp_file_id = $file_data['id'];
    		$flag = $this->updateByPk($mp_file_id, array('file_id'=>$file_id));
    	}
    	else{
    		$position = $this->map_position_num($position);
    		$this->scene_id = $scene_id;
    		$this->file_id = $file_id;
    		$this->position = $position;
    		$this->level = 1;
    		$this->created = time();
    		$flag = $this->save();
    	}
    	return $flag;
    }
    
    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('scene_id, file_id, position, level, created', 'required'),
            array('scene_id, file_id, position, level, created', 'numerical', 'integerOnly'=>true),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'scene_id' => 'scene_id',
            'file_id' => 'file_id',
            'position' => 'position',
        	'level' => 'level',
        	'created' => 'created',
            'status' => 'Status',
        );
    }

}