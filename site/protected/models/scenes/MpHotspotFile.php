<?php
class MpHotspotFile extends Ydao
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
        return '{{mp_hotspot_file}}';
    }
    public function add_imghotsopt($datas){
        $this->hotspot_id = $datas['hotspot_id'] ? $datas['hotspot_id'] : 0;
        $this->file_id = $datas['file_id'] ? $datas['file_id'] : 0;
        $this->is_del = 0;
        
        unset($datas);
        if (!$this->save()){
        	return false;
        }
        return $this->attributes['hotspot_id'];
    }
 
    public function edit_imghotspot($id, $datas){
        if(!$id){
            return false;
        }
        return $this->updateByPk($id, $datas);
    }
    public function find_by_hotspot_ids($hotspot_ids){
    	if(!$hotspot_ids){
    		return false;
    	}
    	$hotspot_ids_str = implode(',', $hotspot_ids);
    	$criteria=new CDbCriteria;
    	$criteria->addCondition("hotspot_id in ({$hotspot_ids_str})");
    	$img_hotspot = $this->findAll($criteria);
    	if(!$img_hotspot){
    		return false;
    	}
    	$hotspots_file = array();
    	foreach($img_hotspot as $v){
    		$hotspots_file[$v['hotspot_id']] = $v['file_id'];
    	}
    	return $hotspots_file;
    }
    public function get_file_id($hotspot_id){
    	if(!$hotspot_id){
    		return false;
    	}
    	return $this->findByPk($hotspot_id);
    }
}




