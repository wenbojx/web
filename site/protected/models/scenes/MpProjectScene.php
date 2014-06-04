<?php

/**
 * This is the model class for table "{{member}}".
 *
 * The followings are the available columns in table '{{member}}':
 * @property integer $id
 * @property string $username
 * @property string $passwd
 * @property integer $status
 */
class MpProjectScene extends Ydao
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Member the static model class
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
        return '{{mp_project_scene}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('project_id, scene_id', 'required'),
            array('status, project_id, scene_id', 'integerOnly'=>true),
            array('id, project_id, scene_id', 'safe', 'on'=>'search'),
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
            'project_id' => 'Project_id',
            'scene_id' => 'Scene_id',
            'status' => 'Status',
        );
    }

    public function get_scenes_by_project($project_id){
        if(!$project_id){
            return array();
        }
        $criteria=new CDbCriteria;
        $criteria->order = 'id DESC';
        $criteria->addCondition("project_id={$project_id}");
        $criteria->addCondition('status=1');
        return $this->findAll($criteria);
    }

}