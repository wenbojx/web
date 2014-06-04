<?php
class ScenesHotspot extends Ydao
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
        return '{{scene_hotspot}}';
    }
    public function add_hotsopt($datas){
        $this->pan = $datas['pan'] ? $datas['pan'] : 0;
        $this->tilt = $datas['tilt'] ? $datas['tilt'] : 0;
        $this->fov = $datas['fov'] ? $datas['fov'] : 90;
        $this->type = $datas['type'] ? $datas['type'] : 2;
        $this->transform = $datas['transform'] ? $datas['transform'] : 10;
        $this->content = isset( $datas['content'] ) ? $datas['content'] : '0';
        $this->link_scene_id = $datas['link_scene_id'] ? $datas['link_scene_id'] : 0;
        $this->scene_id = $datas['scene_id'];
        unset($datas);
        if (!$this->insert()){
        	return false;
        }
        return $this->attributes['id'];
    }
    public function find_by_scene_id($scene_id, $status=1){
        return $this->findAllByAttributes(array('scene_id'=>$scene_id, 'status'=>$status));
    }
    public function get_scene_hotspots($scene_id){
    	$datas = $this->find_by_scene_id($scene_id);
    	if(!$datas){
    		return array();
    	}
    	$hotspots = array();
    	$k = 0;
    	$img_hotspots = array();
    	foreach($datas as $v){
    		$hotspots[$k]['id'] = $v['id'];
    		$hotspots[$k]['scene_id'] = $v['scene_id'];
    		$hotspots[$k]['link_scene_id'] = $v['link_scene_id'];
    		$hotspots[$k]['tilt'] = $v['tilt'];
    		$hotspots[$k]['pan'] = $v['pan'];
    		$hotspots[$k]['type'] = $v['type'];
    		$hotspots[$k]['transform'] = $v['transform'];
    		$k++;
    		if($v['type'] == "4"){
    			$img_hotspots[] = $v['id'];
    		}
    	}
    	/* if($img_hotspots){
    		$hotspot_file_db = new MpHotspotFile();
    		
    		$imgHotspots = $hotspot_file_db->find_by_hotspot_ids($img_hotspots);
    		if($imgHotspots){
    			foreach ($hotspots as $k=>$v){
    				if($v['type'] == "4"){
    					$hotspots[$k]['file_id'] = $imgHotspots[$v['id']];
    				}
    			}
    		}
    	}
    	print_r($hotspots); */
    	return $hotspots;
    }
    public function get_by_hotspot_id($hotspot_id){
    	return $this->findByPk($hotspot_id);
    }
    public function find_by_scene_ids($scene_ids){
        if(!$scene_ids){
            return false;
        }
        $scene_ids_str = implode(',', $scene_ids);
        $criteria=new CDbCriteria;
        $criteria->addCondition("scene_id in ({$scene_ids_str})");
        $criteria->addCondition("status=1");
        return $this->findAll($criteria);
    }
    public function edit_hotspot($id, $datas){
        if(!$id){
            return false;
        }
        return $this->updateByPk($id, $datas);
    }
}




