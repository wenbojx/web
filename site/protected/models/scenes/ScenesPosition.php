<?php
class ScenesPosition extends Ydao
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
        return '{{scene_position}}';
    }
    public function save_position($datas){
        if(!$datas || !$datas['scene_id']){
            return false;
        }
        if($this->get_by_scene_id($datas['scene_id'])){
            return $this->edit_position($datas);
        }
        else{
            return $this->add_position($datas);
        }
    }
    public function add_position($datas){
        $this->glat = $datas['glat'] ? $datas['glat'] : 0;
        $this->glng = $datas['glng'] ? $datas['glng'] : 0;
        $this->gzoom = $datas['gzoom'] ? $datas['gzoom'] : 12;
        $this->blat = $datas['blat'] ? $datas['blat'] : 0;
        $this->blng = $datas['blng'] ? $datas['blng'] : 0;
        $this->bzoom = $datas['bzoom'] ? $datas['bzoom'] : 12;
        $this->scene_id = $datas['scene_id'];
        unset($datas);
        return $this->save();
    }
    public function edit_position($datas){
        $insert['glat'] = $datas['glat'] ? $datas['glat'] : 0;
        $insert['glng'] = $datas['glng'] ? $datas['glng'] : 0;
        $insert['gzoom'] = $datas['gzoom'] ? $datas['gzoom'] : 12;
        $insert['blat'] = $datas['blat'] ? $datas['blat'] : 0;
        $insert['blng'] = $datas['blng'] ? $datas['blng'] : 0;
        $insert['bzoom'] = $datas['bzoom'] ? $datas['bzoom'] : 12;
        return $this->updateByPk($datas['scene_id'], $insert);
    }
    public function get_by_scene_id($scene_id){
        return $this->findByPk($scene_id);
    }
}