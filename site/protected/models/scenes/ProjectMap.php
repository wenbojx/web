<?php
class ProjectMap extends Ydao
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
        return '{{project_map}}';
    }
    public function save_project_map($project_id, $file_id, $width, $height){
        if(!$project_id || !$file_id){
            return false;
        }
        $map_datas = $this->find_by_project_id($project_id);
        if($map_datas){
        	$id = $map_datas['id'];
        	$attributes = array('status'=>2);
        	$this->updateByPk($id, $attributes);
        }
        $this->project_id = $project_id;
        $this->file_id = $file_id;
        $this->width = (int) $width;
        $this->height = (int) $height;
        if(!$this->save()){
        	return false;
        }
        $id = $this->attributes['id'];
        return $id;
    }
    public function find_by_map_id($map_id){
    	if(!$map_id){
    		return false;
    	}
    	return $this->findByPk($map_id);
    }
    public function find_by_project_id($project_id, $status=1){
        $criteria=new CDbCriteria;
    	if(!$project_id){
    		return false;
    	}
    	if($status!==0){
    		$criteria->addCondition("status={$status}");
    	}
    	$criteria->addCondition("project_id={$project_id}");
    	$map_datas = $this->find($criteria);
    	return $map_datas;
    }
    public function get_map_info($project_id){
    	$map_datas = array();
    	if(!$project_id){
    		return false;
    	}
    	//获取地图信息
    	$map_datas['map'] = $this->find_by_project_id($project_id);
    	if(!$map_datas['map'] || !$map_datas['map'] ['id']){
    		return false;
    	}
    	//获取地图锚点信息
    	$map_datas['position'] = $this->get_map_position($map_datas['map']['id']);
    	$map_datas['link_scenes'] = array();
    	if($map_datas['position']){
    		$ids = array();
    		foreach($map_datas['position'] as $v){
    			$ids[$v['scene_id']] = $v['scene_id'];
    		}
    		if($ids){
    			$scene_db = new Scene();
    			$scene_datas = $scene_db->get_by_scene_ids($ids);
    			if($scene_datas){
    				foreach($scene_datas as $v){
    					$map_datas['link_scenes'][$v['id']] = $v;
    				}
    			}
    		}
    	}
    	return $map_datas;
    }
    private function get_map_position($map_id){
    	$map_positon_db = new ProjectMapPosition();
    	return $map_positon_db->find_by_map_id($map_id);
    }
}