<?php
class ScenesThumb extends Ydao
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
        return '{{scene_thumb}}';
    }
    public function save_pano_thumb($scene_id, $file_id, $recommend=0, $pos=0){
        if(!$scene_id){
            return false;
        }
        if (!$scene_datas = $this->find_by_scene_id($scene_id)){
            $this->scene_id = $scene_id;
            $this->file_id = $file_id;
            $this->pos = $pos;
            $this->recommend = $recommend == '1' ? 1 : 0;
            return $this->insert();
        }
        else{
        	$recommend = $recommend == '1' ? 1 : 0;
            $attributes = array('file_id'=>$file_id, 'recommend'=>$recommend, 'pos'=>$pos);
            return $this->updateByPk($scene_id, $attributes);
        }
    }
    public function find_by_scene_id($scene_id){
        return $this->findByPk($scene_id);
    }
    public function find_by_scene_ids($scene_ids){
        if(!is_array($scene_ids) || !$scene_ids){
            return false;
        }
        $scene_id_str = implode(',', $scene_ids);
        if(!$scene_id_str){
            return false;
        }
        $criteria=new CDbCriteria;
        $criteria->addCondition("scene_id in ({$scene_id_str})");
        return $this->findAll($criteria);
    }

}