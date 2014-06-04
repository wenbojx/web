<?php
class PanoSingleDatas{
    public $hotspots_info = array(); //热点信息
    public $scenes_info = array(); //当前场景包含的所有全景
    public $self_hotspots = array(); // 当前场景的热点
    public $pano_thumb_size = '240x120'; //全景图缩略图尺寸
    public $hotspots_num = 5;
    public $panoram_pre = 'pano_';
    public $hotspot_pre = 'hotspot_';
    public $imghotspot_pre = 'imghotspot_';
    public $link_open_pre = 'link_open_';
    public $link_open_id_pre = 'link_pano_';
    public $load_pano_pre = 'load_pano_';
    public $info_bubble_pre = 'info_bubble_';
    public $show_bubble_pre = 'show_';
    public $hide_bubble_pre = 'hide_bubble';
    
    public $module_type_link_open = 70; //link_open默认type值
    public $module_type_button_bar = 10; //button_bar默认type值
    public $module_type_menu_scroller = 40; //MenuScroller默认type值
    public $module_type_img_button = 20; //MenuScroller默认type值
    public $module_type_jsgateway = 60; //jsgateway默认type值
    public $module_type_mouse_cursor = 80; //jsgateway默认type值
    public $module_type_image_map = 90; //jsgateway默认type值
    public $module_type_info_bubble = 30; 
    public $module_type_music = 91;//BackgroundMusic
    
    public $prifix_js_id = 'js_'; //js模块ID前缀
    public $js_hotspot_loading = 'js_action_loading';
    public $js_hotspot_loaded = 'js_action_loaded';

    //public $actions_pre = 'act_';
    private $scene_id = 0;
    public $modules_datas = array(); //模块数据
    public $action_datas = array(); //动作数据
    public $global_datas = array(); //全局数据
    public $panoram_datas = array(); //图片数据
    public $project_id = 0;

    public $display_config = array(); //是否载入button_bar
    private $image_map_datas = array();
    private $infoBubble_datas = array();
    //private $info_sub_add = 0;
    private $scene_datas = array();
    private $map_flag = true;
    private $map_datas = array();
    
    public $music_module_exit = false;
    private $scene_ids = array();
    private $music_datas = array();

    public function get_panoram_datas($id = 0){
        $datas = array();
        if(!(int)$id){
            return $datas;
        }
        $this->scene_id = $id;
        $this->project_id = $this->get_project_id($id);
        $this->get_global_info();
        $this->get_panorams_info();
        $this->get_modules_info();
        $this->get_actions_info();
        $datas['global'] = $this->global_datas;
        $datas['panorams'] = $this->panoram_datas;
        $datas['modules'] = $this->modules_datas;
        $datas['actions'] = $this->action_datas;
        //print_r($datas);
        return $datas;
        //return $this->modules_datas;
    }
    /*
     * 获取项目信息
     */
    private function get_project_id($scene_id){
    	if(!$scene_id){
    		return false;
    	}
    	$scene_db = new Scene();
    	$scene_data = $scene_db->get_by_scene_id($scene_id);
    	if(!$scene_data){
    		return false;
    	}
    	return $scene_data['project_id'];
    }
    /**
     * 获取global信息
     */
    private function get_global_info(){
        $global_obj = new ScenesGlobal();
        $datas = $global_obj->find_by_scene_id($this->scene_id);
        if($datas['content']){
            $this->global_datas = @json_decode($datas['content'], true);
        }
        if(!isset($this->global_datas['s_attribute']['debug'])){
            $this->global_datas['s_attribute']['debug'] = 'false';
        }
       // $this->global_datas['s_attribute']['debug'] = 'true';
        // $this->global_datas['control']['s_attribute']['autorotation'] = 'enabled:false';
        $this->global_datas['control']['s_attribute']['autorotation'] = 'enabled:true,delay:5';
        if($this->display_config['auto']){
        	$this->global_datas['control']['s_attribute']['autorotation'] = 'enabled:true,delay:5';
        }
        $this->global_datas['branding']['s_attribute']['visible'] = 'false';
        $this->global_datas['panoramas']['s_attribute']['firstPanorama'] = $this->panoram_pre.$this->scene_id;
        
        $this->map_datas = $this->get_map_info();
        if(!$this->map_datas){
        	$this->map_flag = false;
        }
        if($this->map_flag){
        	$this->global_datas['panoramas']['s_attribute']['firstOnEnter'] = "mapOpen";
        }

        
        
        
        return $this->global_datas;
    }
    /**
     * 获取actions信息
     */
    public function get_actions_info(){
        //$actions_datas = array();
        return $this->action_datas;
    }
    /**
     *
     */
    public function add_single_action($id, $content){
        $this->action_datas[$id]['s_attribute']['id'] = $id;
        $this->action_datas[$id]['s_attribute']['content'] = $content;
        return $this->action_datas[$id];
    }
    /**
     * 场景xml文件地址
     */
    public function panoram_xml_path($id){
    	$key = $id%2 == 0? '0':'1';
    	//$key = 0;
    	//$pic_tools_obj = new PicTools();
    	//$tag = $pic_tools_obj->get_scene_file_tag($id);
        return PicTools::get_pano_path($id) . '/s_f.xml';
    }
    
    /**
     * 获取场景全景数信息
     */
    private function get_panorams_info(){
    	if(!$this->project_id){
    		return false;
    	}
    	$this->panoram_datas = array();
    	//获取项目下所有场景
    	$scene_db = new Scene();
    	$this->scene_datas = $scene_db->find_scene_by_project_id($this->project_id, 0, '', 0, 1, 0);
    	if(!$this->scene_datas){
    		return false;
    	}
    	//print_r($this->scene_datas);
    	$scene_ids = array();
    	foreach($this->scene_datas as $v){
    		$scene_ids[] = $v['id'];
    		
    		$datas[$v['id']]['s_attribute']['id'] = $this->panoram_pre.$v['id'];
    		$datas[$v['id']]['s_attribute']['path'] = $this->panoram_xml_path($v['id']);
    		$datas[$v['id']]['s_attribute']['onEnter'] = 'js_action_loaded';
    		$this->panoram_datas[$v['id']] = $v;
    	}
    	$this->scene_ids = $scene_ids;
    	$panoram_db = new ScenesPanoram();
    	$panoram_datas = $panoram_db->find_by_scene_ids($scene_ids);
    	if($panoram_datas){
    		foreach($scene_ids as $v){
    			$pano_attribute = array();
		    	if(isset($panoram_datas[$v])){
		    		if (isset($panoram_datas[$v]['content']) && $panoram_datas[$v]['content']){
		    			$pano_attribute = @json_decode($panoram_datas[$v]['content'],true);
		    		}
		    		if (is_array($pano_attribute) && isset($pano_attribute['s_attribute'])){
		    			//print_r($pano_attribute);
		    			/*
		    			if(isset($pano_attribute['s_attribute']['camera']) && $v != $this->scene_id ){
		    				//echo $v;
		    				unset($pano_attribute['s_attribute']['camera']);
		    			}
		    			*/
		    			$datas[$v]['s_attribute'] = array_merge($datas[$v]['s_attribute'], $pano_attribute['s_attribute']);
		    		}
		    	}
		    	
    		}
    	}
    	//print_r($this->panoram_datas);
    	//获取场景热点
    	$hotspot_db = new ScenesHotspot();
    	$hotspot_datas = $hotspot_db->find_by_scene_ids($scene_ids);

    	if($hotspot_datas){
	    	foreach($hotspot_datas as $v){
	    		$scene_id_snap = $v['scene_id'];
	    		$hotspots_info[$v['id']]['scene_id'] = $v['scene_id'];
	    		$hotspots_info[$v['id']]['link_scene_id'] = $v['link_scene_id'];
	    		
	    		$datas[$scene_id_snap]['hotspots'][$v['id']] = $this->get_hotspot_info($v);
	    		
	    	}
    	}
    	$this->hotspots_info = $hotspots_info;
    	if($hotspots_info){
    		$this->init_infobubble();
    		$this->add_hotspot_action($hotspots_info, $this->scene_id);

    	}
        $this->panoram_datas = $datas;
        return $datas;
    }
    /**
     * 初始化infobubble
     */
    private function init_infobubble(){
    	$type = $this->module_type_info_bubble;
    	$this->modules_datas[$type]['s_attribute']['path'] = $this->module_path('InfoBubble');
    	$this->modules_datas[$type]['bubbles']['text'] = array();
    	$this->modules_datas[$type]['styles'][1]['s_attribute']['id'] = 'buttonBar';
    	$this->modules_datas[$type]['styles'][1]['s_attribute']['content'] = 'bubblePadding:3,fontSize:12,borderSize:1';
    }
    /**
     * 添加infobubble text image
     */
    private function add_infobubble($id, $text, $style='buttonBar', $angle=1){
    	$type = $this->module_type_info_bubble;
    	$this->modules_datas[$type]['bubbles']['text'][$id]['s_attribute']['id'] = $id;
    	$this->modules_datas[$type]['bubbles']['text'][$id]['s_attribute']['text'] = $text;
    	$this->modules_datas[$type]['bubbles']['text'][$id]['s_attribute']['style'] = $style;
    	$this->modules_datas[$type]['bubbles']['text'][$id]['s_attribute']['angle'] = $angle;
    	$bub_id = $this->show_bubble_pre.$id;
    	$content = "InfoBubble.show({$id})";
    	$this->add_single_action($bub_id, $content);
    	
    	$id = $this->hide_bubble_pre;
    	$content = "InfoBubble.hide()";
    	$this->add_single_action($id, $content);
    	//print_r($this->modules_datas[$type]['bubbles']);
    	//$this->info_sub_add++;
    }
    /**
     * 添加hotspot模块的action
     */
    public function add_hotspot_action($hotspots_info, $scene_id){
    	//print_r($hotspots_info);
        foreach($hotspots_info as $k=>$v){
        	if(isset($this->scene_datas[$v['link_scene_id']])){
        		$this->add_infobubble($this->info_bubble_pre.$v['link_scene_id'], $this->scene_datas[$v['link_scene_id']]['name']);
        	}
        	
        	$id = $this->load_pano_pre.$v['link_scene_id'];
        	//添加外部JS loading事件
        	$content = "SaladoPlayer.advancedMoveToHotspot({$this->hotspot_pre}$k,NaN,40,Expo.easeIn)";
        	$content .= ';JSGateway.run(jsf_hotspot_loading)';
        	$content .= ';SaladoPlayer.loadPano('.$this->panoram_pre.$v['link_scene_id'].')';
            $this->add_single_action($id, $content);
            
        }
        return $this->action_datas;
    }
    /**
     * 处理hotspot数据
     */
    public function get_hotspot_info($datas){
        $hotspot = array();
        $hotspot_attribute = array();
        $hotspot['type'] = $datas['type'] ? $datas['type'] : 2;
        $hotspot['link_scene_id'] = $datas['link_scene_id'];
        $hotspot['s_attribute']['id'] = $this->hotspot_pre.$datas['id'];
        //$datas['fov'] = $datas['fov'] < 10 ? 90 : $datas['fov'];
        $hotspot['s_attribute']['location'] = "pan:{$datas['pan']},tilt:{$datas['tilt']}";

        if ($datas['content']){
            $hotspot_attribute = @json_decode($datas['content'],true);
        }
        //如果hotspot的链接在本场景内则load_pano
       // if (in_array($datas['link_scene_id'], $this->scenes_info)){
            $mouse = 'onClick:'.$this->load_pano_pre.$datas['link_scene_id'].',onOver:'.$this->show_bubble_pre.$this->info_bubble_pre.$datas['link_scene_id'].',onOut:'.$this->hide_bubble_pre;
        //}
        /* else{
            $mouse = 'onClick:'.$this->link_open_id_pre.$datas['link_scene_id'];
        } */
        //合并属性
        if(is_array($hotspot_attribute) && isset($hotspot_attribute['s_attribute']['mouse']) && $hotspot_attribute['s_attribute']['mouse']){
            $hotspot_attribute['s_attribute']['mouse'] .= ','.$mouse;
        }
        else{
            $hotspot_attribute['s_attribute']['mouse'] = $mouse;
        }
        if (is_array($hotspot_attribute) && $hotspot_attribute['s_attribute']){
            $hotspot['s_attribute'] = array_merge($hotspot['s_attribute'], $hotspot_attribute['s_attribute']);
        }
        //热点类型；
        if ($datas['type'] == '1'){
            $hotspot['s_attribute']['path'] = $this->module_hotspot_path($datas['transform']);
        }
        elseif ($datas['type'] == '2'){
            $hotspot['s_attribute']['path'] = $this->module_path('Hotspot');
            $hotspot['settings']['s_attribute']['path'] = $this->module_hotspot_path($datas['transform']);
            $hotspot['settings']['s_attribute']['beatUp'] = 'scale:0.7';
            $hotspot['settings']['s_attribute']['mouseOver'] = 'scale:1.1';
        }
        return $hotspot;
    }
    /**
     * 模块地址
     */
    public function module_path($name){
        $path['LinkOpener'] = Yii::app()->baseUrl.'/plugins/salado/modules/LinkOpener.swf';
        $path['Hotspot'] = Yii::app()->baseUrl.'/plugins/salado/modules/AdvancedHotspot-1.0.swf';
        //$path['Hotspot'] = Yii::app()->baseUrl.'/plugins/salado/modules/RED_ARROW.swf';
        $path['ButtonBar'] = Yii::app()->baseUrl.'/plugins/salado/modules/ButtonBar.swf';
        $path['MenuScroller'] = Yii::app()->baseUrl.'/plugins/salado/modules/MenuScroller.swf';
        $path['ImageButton'] = Yii::app()->baseUrl.'/plugins/salado/modules/ImageButton.swf';
        $path['JSGateway'] = Yii::app()->baseUrl.'/plugins/salado/modules/JSGateway.swf';
        $path['MouseCursor'] = Yii::app()->baseUrl.'/plugins/salado/modules/MouseCursor.swf';
        $path['ImageMap'] = Yii::app()->baseUrl.'/plugins/salado/modules/ImageMap.1.4.2.swf';
        $path['InfoBubble'] = Yii::app()->baseUrl.'/plugins/salado/modules/InfoBubble-1.3.2.swf';
        $path['BackgroundMusic'] = Yii::app()->baseUrl.'/plugins/salado/modules/BackgroundMusic-1.1.swf';
        if(!isset($path[$name])){
            return '';
        }
        return $path[$name];
    }
    /**
     * 模块默认素材地址
     */
    public function module_media_path($name){
        $path['button_bar'] = Yii::app()->baseUrl.'/plugins/salado/media/buttons_dark_30x30.png';
        $path['menu_scroller_show_btn'] = Yii::app()->baseUrl.'/plugins/salado/media/MenuScroller_show.png';
        $path['menu_scroller_hide_btn'] = Yii::app()->baseUrl.'/plugins/salado/media/MenuScroller_hide.png';
        $path['mousecursor'] = Yii::app()->baseUrl.'/plugins/salado/media/cursors_21x21.png';
        $path['image_map_close'] = Yii::app()->baseUrl.'/plugins/salado/media/imgemap_close.png';
        $path['image_map_viewer'] = Yii::app()->baseUrl.'/plugins/salado/media/navigation_black_20x20.png';
        $path['image_map_waypoints'] = Yii::app()->baseUrl.'/plugins/salado/media/waypoints_bubble_17x17.png';
        if(!isset($path[$name])){
            return '';
        }
        return $path[$name];
    }
    /**
     * 热点素材地址
     */
    public function module_hotspot_path($num=10){
    	$path = Yii::app()->baseUrl.'/plugins/salado/media/hotspot/hotspot-'.$num.'.png';
    	//$path = Yii::app()->baseUrl.'/plugins/salado/media/H6_1.swf';
    	return $path;
    }
    /**
     * 全景图缩略图地址
     */
    public function pano_thumb_path($id){
        //return Yii::app()->baseUrl.'/pages/images/thumbs/1.jpg';
        return Yii::app()->createUrl('/panos/thumb/pic/', array('id'=>$id, 'size'=>$this->pano_thumb_size.'.jpg'));
    }
    /**
     * 全景图显示地址
     */
    public function get_pano_address($id){
    	if($this->display_config['single']){
    		$auto = $this->display_config['auto'] ? '1' : '0';
    		$nobtb = $this->display_config['nobtb'] ? '1' : '0';
    		$w = $this->display_config['player_width'];
    		$h = $this->display_config['player_height'];
    		return Yii::app()->createUrl('/web/single/a/', array('id'=>$id,'w'=>$w,'h'=>$h,'auto'=>$auto,'nobtb'=>$nobtb));
    	}
        return Yii::app()->createUrl('/web/detail/a/', array('id'=>$id));
    }
    /**
     * 获取modules信息
     */
    public function get_modules_info(){
        $scene_id = $this->scene_id;
        $this->get_module_list($scene_id);
        //自动添加hotspots的action
        if($this->hotspots_info){
            $this->get_default_link($scene_id);
        }
        return $this->modules_datas;
    }
    /**
     * 获取场景使用的模块
     * @param int $id
     */
    public function get_module_list($scene_id){
        $module_db = new ScenesModule();
        $datas = $module_db->find_by_scene_id($scene_id);
        $no_button_bar = true;
        $no_menuscroller = true;
        if (is_array($datas)){
            foreach($datas as $v){
                if($v['content']){
                    $this->modules_datas[$v['type']] = @json_decode($v['content'], true);
                    //是否含有button_bar
                    if($v['type'] == $this->module_type_link_open){
                        $no_button_bar = false;
                    }
                    //是否含menu_scroller
                    if($v['type'] == $this->module_type_menu_scroller){
                        $no_menuscroller = false;
                    }
                }
            }
        }
        //$this->add_menuscroller_extend();
        if($no_menuscroller){
            //$this->get_default_menu_scroller($scene_id);
        }
        //添加js模块
        $this->get_js_gateway_module();
        
        if($this->map_flag){
        	//$this->image_map_datas = $datas;
        	$this->get_imagemap_module($this->map_datas);
        }
        
        
        //添加MouseCursor
        $this->get_mousecursor_module();
        //print_r($this->modules_datas);
        //添加imagemap
        //获取背景音乐信息
        $music_db = new MpSceneMusic();
        $music_datas = $music_db->get_by_scene_ids($this->scene_ids, 1);
        //print_r($music_datas);
        if($music_datas){
        	$this->add_music_module($music_datas);
        }
        
        if($this->display_config['nobtb']){
        	//获取默认button_bar
        	$this->get_default_button_bar();
        }
        
        return $this->modules_datas;
    }
    
    /**
     * 添加music模块
     */
	public function add_music_module($music_datas){
    	$type = $this->module_type_music;
    	$this->modules_datas[$type]['s_attribute']['path'] = $this->module_path('BackgroundMusic');
    	$this->modules_datas[$type]['settings']['s_attribute']['play'] = 'true';
    	$this->modules_datas[$type]['settings']['s_attribute']['onPlay'] = 'MusicSetActive';
    	$this->modules_datas[$type]['settings']['s_attribute']['onStop'] = 'MusicInSetActive';
    	
    	$file_path_db = new FilePath();
    	
    	foreach($music_datas as $v){
	    	$file_datas = $file_path_db->get_by_file_id($v['file_id']);
	    	
	    	$id = 'music_'.$v['scene_id'];
	    	$this->modules_datas[$type]['tracks'][$id]['s_attribute']['id'] = $id;
	    	$this->modules_datas[$type]['tracks'][$id]['s_attribute']['path'] = PicTools::get_pano_music($v['scene_id'], $file_datas['type']);
	    	$this->modules_datas[$type]['tracks'][$id]['s_attribute']['volume'] = $v['volume']/10;
	    	$this->modules_datas[$type]['tracks'][$id]['s_attribute']['loop'] = $v['loop']?'true':'false';
	
	    	$id = 'setTrack_'.$v['scene_id'];
	    	$content = "BackgroundMusic.setTrack(music_{$v['scene_id']});JSGateway.run(jsf_hotspot_loaded)";
	    	$this->add_single_action($id, $content);
	    	
	    	//$this->music_datas[$v['scene_id']] = $v['scene_id'];
	    	$this->panoram_datas[$v['scene_id']]['s_attribute']['onEnter'] = $id;
	    	/*
	    	$key = $this->load_pano_pre.$v['scene_id'];
	    	if(isset( $this->action_datas[$key] )){
	    		$this->action_datas[$key]['s_attribute']['content'] .= ";BackgroundMusic.setTrack(music_{$v['scene_id']})";
	    	}
	    	*/
    	}
    	
    	$this->music_module_exit = true;
    	$id = 'MusictogglePlay';
    	$content = 'BackgroundMusic.togglePlay()';
    	$this->add_single_action($id, $content);
    	
    	$id = 'MusicSetActive';
    	$content = 'ButtonBar.setActive(d,false)';
    	$this->add_single_action($id, $content);
    	
    	$id = 'MusicInSetActive';
    	$content = 'ButtonBar.setActive(d, true)';
    	$this->add_single_action($id, $content);
    	
    }
    
    public function get_imagemap_module($datas){
    	$type = $this->module_type_image_map;
    	$this->modules_datas[$type]['s_attribute']['path'] = $this->module_path('ImageMap');
    	$this->modules_datas[$type]['window']['s_attribute']['open'] = 'false';
    	$this->modules_datas[$type]['window']['s_attribute']['transition'] = 'type:slideRight';
    	$this->modules_datas[$type]['window']['s_attribute']['openTween'] = 'transition:Back.easeOut';
    	$this->modules_datas[$type]['window']['s_attribute']['onOpen'] = 'mapOpened';
    	$this->modules_datas[$type]['window']['s_attribute']['onClose'] = 'mapClosed';
    	$this->modules_datas[$type]['window']['s_attribute']['alpha'] = '0.9';
		//$this->modules_datas[$type]['window']['s_attribute']['minSize'] = 'width:300,height:200';
		//$this->modules_datas[$type]['window']['s_attribute']['maxSize'] = 'width:500,height:300';
		
    	//$this->modules_datas[$type]['window']['s_attribute']['margin'] = 'top:8,right:8';
    	
    	$this->modules_datas[$type]['close']['s_attribute']['path'] = $this->module_media_path('image_map_close');
    	$this->modules_datas[$type]['close']['s_attribute']['move'] = 'vertical:-10,horizontal:10';
    	$this->modules_datas[$type]['viewer']['s_attribute']['path'] = $this->module_media_path('image_map_viewer');
    	//$this->modules_datas[$type]['viewer']['s_attribute']['navMove'] = 'enabled:false';
    	//$this->modules_datas[$type]['viewer']['s_attribute']['navZoom'] = 'enabled:false';
    	
    	$this->modules_datas[$type]['map']['s_attribute']['id'] = 'imagemap1';
    	$this->modules_datas[$type]['map']['s_attribute']['path'] = PicTools::get_pano_map($this->project_id, $datas['map']['id']);
    	$this->modules_datas[$type]['map']['s_attribute']['onSet'] = 'onSetMap1';
    	$this->modules_datas[$type]['map']['waypoints']['s_attribute']['path'] = $this->module_media_path('image_map_waypoints');
    	$this->modules_datas[$type]['map']['waypoints']['s_attribute']['move'] = 'horizontal:0,vertical:-10';
    	$this->modules_datas[$type]['map']['waypoints']['s_attribute']['radar'] = 'showTilt:false,radius:40,color:#FFFFFF,borderSize:1,borderColor,#666666';
    	//$this->modules_datas[$type]['map']['waypoints']['s_attribute']['radar'] = 'radius:50';
    	
    	
    	foreach($datas['position'] as $k=>$v){
    		//$target_id = $datas['link_scenes'][$v['']]
    		$this->modules_datas[$type]['map']['waypoints']['waypoint'][$k]['s_attribute']['target'] = $this->panoram_pre.$v['scene_id'];
    		$this->modules_datas[$type]['map']['waypoints']['waypoint'][$k]['s_attribute']['position'] = "x:".($v['left']+10).",y:".($v['top']+45);
    		$this->modules_datas[$type]['map']['waypoints']['waypoint'][$k]['s_attribute']['mouse'] = 'onOver:'.$this->show_bubble_pre.$this->info_bubble_pre.$v['scene_id'].',onOut:'.$this->hide_bubble_pre;
    		//$this->modules_datas[$type]['map']['waypoints']['subPoint'][$k]['s_attribute']['mouse'] = 'onOver:showBubbleKiev,onOut:hideBubble';
    	}
    	
    	//添加相应action 
/*     	<action id="mapToggle" content="ImageMap.toggleOpen()"/>
    	<action id="mapOpen" content="ImageMap.setOpen(true)"/>
    	<action id="mapOpened" content="ImageButton.setOpen(mapIcon,false);ButtonBar.setActive(b,true);ImageButton.setOpen(buttonMenuMap,true)"/>
    	<action id="mapClosed" content="ImageButton.setOpen(mapIcon,true);ButtonBar.setActive(b,false);ImageButton.setOpen(buttonMenuMap,false)"/>
    	
    	<action id="setMap1" content="ImageMap.setMap(map1)"/>
    	<action id="setMap2" content="ImageMap.setMap(map2)"/>
    	<action id="onSetMap1" content="ImageButton.setActive(buttonMenuMap1,true);ImageButton.setActive(buttonMenuMap2,false)"/>
    	<action id="onSetMap2" content="ImageButton.setActive(buttonMenuMap2,true);ImageButton.setActive(buttonMenuMap1,false)"/> */
    	$id = 'mapToggle';
    	$content = 'ImageMap.toggleOpen()';
    	$this->add_single_action($id, $content);
    	
    	$id = 'mapOpen';
    	$content = 'ImageMap.setOpen(true)';
    	$this->add_single_action($id, $content);
    	
    	$id = 'mapOpened';
    	$content = 'ButtonBar.setActive(b,true)';
    	$this->add_single_action($id, $content);
    	$id = 'mapClosed';
    	$content = 'ButtonBar.setActive(b,false);';
    	$this->add_single_action($id, $content);
    	$id = 'onSetMap1';
    	$content = '';
    	$this->add_single_action($id, $content);
    	//echo 111;
    	//print_r($this->modules_datas[$type]['maps']);
    	
    	//$this->modules_datas[$type]['settings']['s_attribute']['path'] = $this->module_media_path('mousecursor');
    	return $this->modules_datas;
    }
    /**
     * 获取地图信息
     */
    private function get_map_info(){
    	if(!$this->project_id){
    		return false;
    	}
    	$map_db = new ProjectMap();
    	$map_datas = $map_db->get_map_info($this->project_id);
    	if(!$map_datas){
    		return false;
    	}
    	//print_r($map_datas);
    	return $map_datas;
    }
    /**
     * 添加mouseCursor模块
     */
    public function get_mousecursor_module(){
    	$type = $this->module_type_mouse_cursor;
    	$this->modules_datas[$type]['s_attribute']['path'] = $this->module_path('MouseCursor');
    	$this->modules_datas[$type]['settings']['s_attribute']['path'] = $this->module_media_path('mousecursor');
    	return $this->modules_datas;
    }
    /**
     * js gateway模块
     */
    public function get_js_gateway_module(){
        $type = $this->module_type_jsgateway;
        $this->modules_datas[$type]['s_attribute']['path'] = $this->module_path('JSGateway');
        $this->modules_datas[$type]['settings']['s_attribute']['callOnEnter'] = 'true';
        $this->modules_datas[$type]['settings']['s_attribute']['callOnTransitionEnd'] = 'true';
        $this->modules_datas[$type]['settings']['s_attribute']['callOnMoveEnd'] = 'true';
        $this->modules_datas[$type]['settings']['s_attribute']['callOnViewChange'] = 'true';

        $this->modules_datas[$type]['jsfunctions']['0s']['s_attribute']['id'] = 'jsf_hotspot_loading';
        $this->modules_datas[$type]['jsfunctions']['0s']['s_attribute']['name'] = 'hotspot_loading';
        $this->modules_datas[$type]['jsfunctions']['0s']['s_attribute']['text'] = '载入中';
        $this->modules_datas[$type]['jsfunctions']['1s']['s_attribute']['id'] = 'jsf_hotspot_loaded';
        $this->modules_datas[$type]['jsfunctions']['1s']['s_attribute']['name'] = 'hotspot_loaded';
        $this->modules_datas[$type]['jsfunctions']['1s']['s_attribute']['text'] = '载入完成';

        //添加action
/*         $id = $this->js_hotspot_loading;
        $content = "JSGateway.run(hotspot_loading)";
        $this->add_single_action($id, $content); */
        $id = $this->js_hotspot_loaded;
        $content = "JSGateway.run(jsf_hotspot_loaded)";
        $this->add_single_action($id, $content);

        return $this->modules_datas[$type];
    }
    /**
     * menu_scoller附加信息
     */
    public function add_menuscroller_extend(){
        $this->add_img_button_for_menu_scoller();
        $this->add_action_for_menu_scoller();
    }
    /**
     * 添加menu_scoller的按钮及action
     */
    public function add_img_button_for_menu_scoller(){
        $id = 'buttonMenuScroller_show';
        $path = $this->module_media_path('menu_scroller_show_btn');
        $action = 'menuScrollerOpen';
        $window['align'] = 'vertical:bottom,horizontal:right';
        $window['move'] = 'horizontal:-216,vertical:-6';
        $window['open'] = 'true';
        $this->add_single_img_button($id, $path, $action, $window);
        $id = 'buttonMenuScroller_hide';
        $path = $this->module_media_path('menu_scroller_hide_btn');
        $action = 'menuScrollerClose';
        $window['open'] = 'false';
        $this->add_single_img_button($id, $path,$action, $window);
    }
    public function add_action_for_menu_scoller(){
        $id = 'menuScrollerOpen';
        $content = 'MenuScroller.setOpen(true);ImageButton.setOpen(buttonMenuScroller_show,false);ImageButton.setOpen(buttonMenuScroller_hide,true)';
        $this->add_single_action($id, $content);
        $id = 'menuScrollerClose';
        $content = 'MenuScroller.setOpen(false);ImageButton.setOpen(buttonMenuScroller_show,true);ImageButton.setOpen(buttonMenuScroller_hide,true)';
        $this->add_single_action($id, $content);
        return false;
    }
    public $img_button_id_num = 100;
    /**
     * 添加单个img_button
     */
    public function add_single_img_button($id, $path, $action, $windows){
        $type = $this->module_type_img_button;
        if (!isset($this->modules_datas[$type]['s_attribute']['path'])){
            $this->modules_datas[$type]['s_attribute']['path'] = $this->module_path('ImageButton');
        }
        $num = $this->img_button_id_num;
        $this->modules_datas[$type]['buttons'][$num]['s_attribute']['id'] = $id;
        $this->modules_datas[$type]['buttons'][$num]['s_attribute']['path'] = $path;
        $this->modules_datas[$type]['buttons'][$num]['s_attribute']['action'] = $action;
        $this->modules_datas[$type]['buttons'][$num]['window']['s_attribute'] = $windows;
        $this->img_button_id_num++;
        return $this->modules_datas[$type];
    }
    /**
     * 获取默认的hotspot link_opener module
     */
    public function get_default_link($scene_id){

        foreach($this->hotspots_info as $k=>$v){
            if ($v['scene_id'] != $scene_id){
                $this->add_signle_link_open($v['link_scene_id']);
            }
        }
        return $this->modules_datas;
    }
    /**
     * 添加单个link_open
     */
    public function add_signle_link_open($link_scene_id, $target='_SELF'){
    	return false;
        $type = $this->module_type_link_open;
        $this->modules_datas[$type]['s_attribute']['path'] = $this->module_path('LinkOpener');
        $id = $this->link_open_pre.$link_scene_id;
        $this->modules_datas[$type]['links'][$id]['s_attribute']['id'] = $id;
        $this->modules_datas[$type]['links'][$id]['s_attribute']['content'] = $this->get_pano_address($link_scene_id);
        $this->modules_datas[$type]['links'][$id]['s_attribute']['target']=$target;
        return $this->modules_datas[$type];
    }
    /**
     * 获取默认menu_scroller
     */
    public function get_default_menu_scroller($scene_id){
        $type = $this->module_type_menu_scroller;
        $extend_panos = $this->get_extend_panos($scene_id);
        if(!$extend_panos){
            return false;
        }
        //print_r($extend_panos);
        $menu['s_attribute']['path'] = $this->module_path('MenuScroller');
        $menu['window']['s_attribute']['size'] = 'width:440,height:90';
        $menu['window']['s_attribute']['open'] = 'false';
        $menu['window']['s_attribute']['alpha'] = '0.5';
        $menu['window']['s_attribute']['align'] = 'horizontal:left,vertical:bottom';
        $menu['window']['s_attribute']['transition'] = 'type:slideLeft';

        $menu['scroller']['s_attribute']['scrollsVertical'] = 'false';
        $menu['scroller']['s_attribute']['sizeLimit'] = '70';
        if(is_array($extend_panos)){
            foreach($extend_panos as $k=>$v){
                if (in_array($v, $this->scenes_info)){
                    $menu['elements'][$k]['s_attribute']['target'] = $this->panoram_pre.$v;
                    $menu['elements'][$k]['s_attribute']['path'] = $this->pano_thumb_path($v);
                }
                else{
                    $menu['extraElements'][$k]['s_attribute']['id'] = 'extra_'.$k;
                    $menu['extraElements'][$k]['s_attribute']['path'] = $this->pano_thumb_path($v);
                    $menu['extraElements'][$k]['s_attribute']['action'] = $this->link_open_id_pre.$v;
                    $id = $this->link_open_id_pre.$v;
                    $this->action_datas[$id]['s_attribute']['id'] = $id;
                    $this->action_datas[$id]['s_attribute']['content'] = 'LinkOpener.open('.$this->link_open_pre.$v.')';
                    $this->add_signle_link_open($v);
                }
            }
        }
        //print_r($menu);
        $this->modules_datas[$type] = $menu;
    }
    /**
     * 获取相邻的场景
     */
    public function get_extend_panos($scene_id){
        $all_hotspots = array();
        if(is_array($this->hotspots_info)){
            foreach($this->hotspots_info as $v){
                if($v['link_scene_id'] != $scene_id){
                    $all_hotspots[] = $v['link_scene_id'];
                }
            }
            $all_hotspots = array_unique($all_hotspots);
        }
        $limit = $this->hotspots_num-count($all_hotspots);
        if($limit>0){
            $scene_db = new Scene();
            $panorams = $scene_db->find_extend_scene($scene_id, $all_hotspots, $limit);
            if($panorams){
                foreach($panorams as $v){
                    $all_hotspots[] = $v['id'];
                }
            }
        }
        return $all_hotspots;
    }
    /**
     * 获取默认的button_bar
     */
    public function get_default_button_bar(){
        $type = $this->module_type_button_bar;
        $this->modules_datas[$type]['s_attribute']['path'] = $this->module_path('ButtonBar');
        $this->modules_datas[$type]['window']['s_attribute']['align'] = 'horizontal:right,vertical:bottom';
        $this->modules_datas[$type]['window']['s_attribute']['alpha'] = '0.6';
        $this->modules_datas[$type]['buttons']['s_attribute']['path'] = $this->module_media_path('button_bar');
        if($this->map_flag){
        	//echo 111;
        	$this->modules_datas[$type]['buttons']['extraButton']['map']['s_attribute']['name'] = 'b';
        	$this->modules_datas[$type]['buttons']['extraButton']['map']['s_attribute']['action'] = 'mapToggle';
        }
        $this->modules_datas[$type]['buttons']['button']['1']['s_attribute']['name'] = 'autorotation';
        //$this->modules_datas[$type]['buttons']['button']['2']['s_attribute']['name'] = 'left';
        //$this->modules_datas[$type]['buttons']['button']['3']['s_attribute']['name'] = 'right';
        //$this->modules_datas[$type]['buttons']['button']['4']['s_attribute']['name'] = 'down';
       // $this->modules_datas[$type]['buttons']['button']['5']['s_attribute']['name'] = 'up';
        $this->modules_datas[$type]['buttons']['button']['6']['s_attribute']['name'] = 'out';
        $this->modules_datas[$type]['buttons']['button']['7']['s_attribute']['name'] = 'in';
        
        
        //$this->modules_datas[$type]['buttons']['extraButton']['map']['s_attribute']['mouse'] = 'onOver:showBubbleMap,onOut:hideBubble';
        
        //<extraButton name="b" action="mapToggle" mouse="onOver:showBubbleMap,onOut:hideBubble"/>
        $this->modules_datas[$type]['buttons']['button']['8']['s_attribute']['name'] = 'fullscreen';
        if($this->music_module_exit){
        	$this->modules_datas[$type]['buttons']['extraButton']['music']['s_attribute']['name'] = 'd';
        	$this->modules_datas[$type]['buttons']['extraButton']['music']['s_attribute']['action'] = 'MusictogglePlay';
        }
        //print_r($this->modules_datas[$type]);
        return $this->modules_datas[$type];
    }
    protected $extra_button_id_num = 1; //
    /**
    * 添加单个extra_button
    */
    public function add_single_extra_button($name, $action){
        $type = $this->module_type_button_bar;
        $num = $this->extra_button_id_num;
        $this->modules_datas[$type]['buttons']['extraButton'][$num]['s_attribute']['name'] = $name;
        $this->modules_datas[$type]['buttons']['extraButton'][$num]['s_attribute']['action'] = $action;
        $this->extra_button_id_num++;
    }
}

