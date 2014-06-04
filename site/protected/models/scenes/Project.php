<?php

/**
 * This is the model class for table "{{datas}}".
 *
 * The followings are the available columns in table '{{datas}}':
 */
class Project extends Ydao
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Datas the static model class
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
        return '{{project}}';
    }
    /**
     * 获取某用户所有项目
     */
    public function get_project_list_member($member_id, $page_size=2, $limit=0, $page_break=true){
        if(!$member_id){
            return false;
        }

        return $datas;
    }
    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('member_id, name', 'required'),
            array('member_id, created, status', 'numerical', 'integerOnly'=>true),
            array('name', 'length', 'max'=>60),
            array('desc', 'length', 'max'=>300),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, type, year, month, content', 'safe', 'on'=>'search'),
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
            'member_id' => 'Member_id',
            'name' => 'Name',
            'desc' => 'Desc',
            'created' => 'Created',
            'status' => 'Status',
        );
    }
    public function add_project($datas){
    	if($datas['name']==''){
    		return false;
    	}
    	$this->name = $datas['name'];
    	$this->desc = $datas['desc'];
    	$this->member_id = $datas['member_id'];
    	$this->created = $datas['created'];
    	$this->category_id = $datas['category_id'];
    	//print_r($datas);
    	if(!$this->save()){
    		return false;
    	}
    	return $this->attributes['id'];
    }
    public function edit_project($datas){
    	return $this->updateByPk($datas['id'], $datas);
    }
    public function find_by_project_id($project_id){
    	return $this->findByPk($project_id);
    }
    public function update_dispaly($project_id, $display){
    	if(!$project_id){
    		return false;
    	}
    	return $this->updateByPk($project_id, array('display'=>$display));
    }
    /**
     * 获取项目列表
     */
    public function get_project_list($limit=5, $order='', $offset=0, $display='', $category=0){
    	
    	$criteria=new CDbCriteria;
    	$criteria->order = 'id ASC';
    	if($order){
    		$criteria->order = $order;
    	}
    	if($limit){
    		$criteria->limit = $limit;
    	}
    	if($offset){
    		$criteria->offset = $offset;
    	}
    	if($category){
    		$criteria->addCondition("category_id={$category}");
    	}
    	if($display){
    		$criteria->addCondition("display={$display}");
    	}
    	$criteria->addCondition('status=1');
    	print_r($criteria);
    	$project_datas = $this->findAll($criteria);
    	return $project_datas;
    }
    /**
     * 获取项目列表
     */
    public function get_project_list_mid($limit=5, $order='', $offset=0, $display='',$m_id=0, $category=0){
    	 
    	$criteria=new CDbCriteria;
    	$criteria->order = 'id ASC';
    	if($order){
    		$criteria->order = $order;
    	}
    	if($limit){
    		$criteria->limit = $limit;
    	}
    	if($offset){
    		$criteria->offset = $offset;
    	}
    	if($m_id){
    		$criteria->addCondition("member_id={$m_id}");
    	}
    	if($category){
    		$criteria->addCondition("category_id={$category}");
    	}
    	if($display){
    		$criteria->addCondition("display={$display}");
    	}
    	$criteria->addCondition('status=1');
    	$project_datas = $this->findAll($criteria);
    	return $project_datas;
    }
    /**
     * 获取某项目的后N个项目
     */
    public function get_next_by_project_id($project_id=''){
    	$criteria=new CDbCriteria;
    	$criteria->order = 'id ASC';
    	$criteria->addCondition('status=1');
    	if($project_id){
    		$criteria->addCondition("id={$display}");
    	}
    	$criteria->limit = $num;
    	return $this->findAll($criteria);
    }
    /*
     * 获取最新的3个项目
    */
    public function get_last_project($num=3, $display=''){
    	$criteria=new CDbCriteria;
    	$criteria->order = 'id DESC';
    	$criteria->addCondition('status=1');
    	if($display){
    		$criteria->addCondition("display={$display}");
    	}
    	$criteria->limit = $num;
    	return $this->findAll($criteria);
    }
    /*
     * 获取景点数
    */
    public function get_project_num($display='', $category=1){

    	$criteria=new CDbCriteria;
    	$criteria->addCondition('status=1');
    	if($category){
    		$criteria->addCondition("category_id={$category}");
    	}
    	if($display){
    		$criteria->addCondition("display={$display}");
    	}
    	//print_r($criteria);
    	return $this->count($criteria);
    }
    /**
     * 获取项目的默认缩略图
     */
    public function get_thumb_scene_id($project_id){
    	$scene_ids = $this->get_project_scene_ids($project_id);
    	if(!$scene_ids){
    		return false;
    	}
    	$scene_ids_str = implode(',', $scene_ids);
    	if(!$scene_ids_str){
    		return false;
    	}
    	$sceneThumbDB = new ScenesThumb();
    	$criteria=new CDbCriteria;
    	$criteria->addCondition("scene_id in ({$scene_ids_str})");
    	//$criteria->addCondition("recommend=1");
    	$datas = $sceneThumbDB->findAll($criteria);
    	if(!$datas){
    		return $scene_ids[0];
    	}
    	foreach ($datas as $v){
    		if($v['recommend'] == '1'){
    			return $v['scene_id'];
    		}
    	}
    	return $datas[0]['scene_id'];
    }
    /**
     * 获取该项目所有有效场景ID
     */
    public function get_project_scene_ids($project_id){
    	if(!$project_id){
    		return false;
    	}
    	$sceneDB = new Scene();
    	$sceneDatas = $sceneDB->find_scene_by_project_id($project_id, 0, 0, 0, 1, 0);
    	//print_r($sceneDatas);
    	if(!$sceneDatas){
    		return false;
    	}
    	$scene_ids = array();
    	foreach($sceneDatas as $v){
    		$scene_ids[] = $v['id'];
    	}
    	return $scene_ids;
    }
    /**
     * 
     */
    public function get_by_project_ids($project_ids, $extends=false){
    	if(!is_array($project_ids) || count($project_ids)<1){
    		return false;
    	}
    	$project_ids_str = implode(',',$project_ids);
    	$criteria=new CDbCriteria;
    	if(!$project_ids_str){
    		return false;
    	}
    	$criteria->order = 'id DESC';
    	$criteria->addCondition("id in ({$project_ids_str})");
    	$datas = $this->findAll($criteria);
    	$project_datas = array();
    	if($datas){
    		foreach ($datas as $k=>$v){
    			$thumb = $this->get_default_thumb($v['id']);
    			$project_datas[$k]['id'] = $v['id'];
    			$project_datas[$k]['name'] = $v['name'];
    			$project_datas[$k]['desc'] = $v['desc'];
    			$project_datas[$k]['thumb'] = $thumb;
    			if($extends == 'fang'){
    				$project_datas[$k]['extend'] = $this->get_extend_fang($v['id']);
    			}
    		}
    	}
    	//print_r($project_datas);

    	return $project_datas;
    }
    /**
     * 项目扩展
     */
    private function get_extend_fang($project_id){
    	$extend_db = new ProjectExtendFang();
    	return $extend_db->get_by_project_id($project_id);
    }
    /**
     * 项目默认缩略图
     */
    private function get_default_thumb($project_id){
    	return $this->get_thumb_scene_id($project_id);
    }
}







