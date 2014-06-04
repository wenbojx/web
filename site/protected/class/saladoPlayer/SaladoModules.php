<?php
class SaladoModules extends SaladoPlayer{
    private $map_type = array(
            '10'=>'ButtonBar','20'=>'ImageButton','30'=>'InfoBubble',
            '40'=>'MenuScroller','50'=>'JSGateway','60'=>'JSGateway',
            '70'=>'LinkOpener','80'=>'MouseCursor','90'=>'ImageMap','91'=>'BackgroundMusic'
    );
    private $modules_datas = array(
            //'attribute'=>array('debug'=>false),
            'ButtonBar'=>array(
                    's_attribute'=>array('path'=>''),
                    'window'=>array(
                            's_attribute'=>array('align'=>''),
                    ),
                    'buttons'=>array(
                            's_attribute'=>array('path'=>''),
                            'button'=>array(
                                    '1'=>array('s_attribute'=>array('name'=>'','move'=>'')),
                                    '2'=>array('s_attribute'=>array('name'=>'','move'=>'')),
                            ),
                            'extraButton'=>array(
                                    '1'=>array('s_attribute'=>array('name'=>'','action'=>'','move'=>'')),
                                    '2'=>array('s_attribute'=>array('name'=>'','action'=>'','move'=>'')),
                            )
                    ),
            ),
            'ImageButton'=>array(
                    's_attribute'=>array('path'=>''),
                    'buttons'=>array(
                            '1'=>array(
                                    's_attribute'=>array('id'=>'','path'=>'','name'=>'','action'=>'','move'=>''),
                                    'window'=>array(
                                            's_attribute'=>array('transition'=>'','align'=>'','move'=>'','openTween'=>'','closeTween'=>'')
                                    ),
                                    'subButton'=>array(
                                            '1'=>array(
                                                's_attribute'=>array('id'=>'','path'=>'','move'=>'','action'=>'','mouse'=>'','singleState'=>''),
                                            ),
                                    ),
                            ),
                            '2'=>array(
                                    's_attribute'=>array('id'=>'','path'=>'','name'=>'','action'=>'','move'=>''),
                                    'window'=>array(
                                            's_attribute'=>array('transition'=>'','align'=>'','move'=>'','openTween'=>'','closeTween'=>'')
                                    ),
                                    'subButton'=>array(
                                            '1'=>array(
                                                's_attribute'=>array('id'=>'','path'=>'','move'=>'','action'=>'','mouse'=>'','singleState'=>''),
                                            ),
                                    ),
                            ),
                    ),
            ),
    		'ImageMap'=>array(
    				's_attribute'=>array('path'=>''),
    				'window'=>array('s_attribute'=>array('open'=>'', 'transition'=>'', 'openTween'=>'', 'onOpen'=>'', 'onClose'=>'', 'alpha'=>'')),
    				'close'=>array('s_attribute'=>array('path'=>'', 'move'=>'')),
    				'viewer'=>array('s_attribute'=>array('path'=>'')),
    				'maps'=>array('s_attribute'=>array('id'=>'', 'path'=>'', 'onSet'=>'')),
    				'maps'=>array(
    						'waypoints'=> array('s_attribute'=>array('path'=>'', 'mov'=>'', 'radar'=>'')),
    						'waypoints'=> array( 'waypoint' => array(
    								'0'=>array('s_attribute'=>array('target'=>'', 'position'=>'', 'mouse'=>'')),
    								'1'=>array('s_attribute'=>array('target'=>'', 'position'=>'', 'mouse'=>'')),
								)
    						)
    				)
    		
    		),
            'InfoBubble'=>array(
                    's_attribute'=>array('path'=>''),
                    'settings'=>array('s_attribute'=>array('enabled'=>'true','onEnable'=>'','onDisable'=>'')),
                    'bubbles'=>array(
                            's_attribute'=>array(),
                            'text'=>array(
                                    '1'=>array('s_attribute'=>array('id'=>'','text'=>'','style'=>'')),
                                    '2'=>array('s_attribute'=>array('id'=>'','text'=>'','style'=>'')),
                            ),
                            'image'=>array(
                                    '1'=>array('s_attribute'=>array('id'=>'','path'=>'')),
                                    '2'=>array('s_attribute'=>array('id'=>'','path'=>'')),
                            )
                    ),
                    'styles'=>array(
                            '1'=>array('s_attribute'=>array('id'=>'','content'=>'')),
                            '2'=>array('s_attribute'=>array('id'=>'','content'=>'')),
                    )
            ),
            'MenuScroller'=>array(
                    's_attribute'=>array('path'=>''),
                    'window'=>array('s_attribute'=>array('size'=>'','align'=>'','transition'=>'')),
                    'close'=>array('s_attribute'=>array('path'=>'','move'=>'')),
                    'scroller'=>array('s_attribute'=>array('scrollsVertical'=>'false')),
                    'elements'=>array(
                            '1'=>array('s_attribute'=>array('target'=>'','path'=>'')),
                    ),
                    'extraElements'=>array(
                            '1'=>array('s_attribute'=>array('id'=>'','action'=>'','path'=>'')),
                    ),

            ),
            'JSGateway'=>array(
                    's_attribute'=>array('path'=>''),
                    'settings'=>array(
                            's_attribute'=>array(
                                    'callOnEnter'=>'true',
                                    'callOnTransitionEnd'=>'true',
                                    'callOnMoveEnd'=>'true',
                                    'callOnViewChange'=>'true',
                            )
                    ),
                    'jsfunctions'=>array(
                            '1'=>array('s_attribute'=>array('id'=>'','name'=>'','text'=>'')),
                    ),
                    'asfunctions'=>array(
                            '1'=>array('s_attribute'=>array('name'=>'','callback'=>'')),
                    ),
            ),
            'LinkOpener'=>array(
                    's_attribute'=>array('path'=>''),
                    'links'=>array(
                            '1'=>array('s_attribute'=>array('id'=>'','content'=>'')),
                    ),
            ),
    		'MouseCursor'=>array(
    				's_attribute'=>array('path'=>''),
    				'settings'=>array(
                            's_attribute'=>array(
                                    'path'=>'true'
                            )
                    ),
    		),
    		'BackgroundMusic' => array(
    				's_attribute'=>array('path'=>''),
    				'settings'=>array(
    						's_attribute'=>array(
    								'play'=>'false'
    						)
    				),
    				'tracks'=>array( 'tracks'=>array(
    						's_attribute'=>array(
    								'id'=>'id',
    								'path'=>'path',
    								'volume'=>'0.5',
    								'loop'=>'false'
    						)
    					)
    				),
    		)
    );
    public function get_modules_info($modules){
    	//print_r($modules);
        $modules_str = '<modules>';
        if (!is_array($modules)){
            return $modules_str;
        }
        foreach ($modules as $k=>$v){
            $type_name = $this->map_type[$k];
            $method = 'get_'.$type_name;
            //echo $method;
            $modules_str .= $this->$method($v);
        }
        $modules_str .= '</modules>';
        return $modules_str;
    }
    private function get_BackgroundMusic($music){
    	//print_r($music);
    	$string = '<BackgroundMusic';
    	$string .= $this->build_attribute($music['s_attribute']);
        if (isset($music['settings'])){
            $string .= '<settings';
            $string .= $this->build_attribute($music['settings']['s_attribute']);
            $string .= '</settings>';
        }
        if (isset($music['tracks'])){
        	//echo 111;
        	$string .= '<tracks';
        	$string .= $this->build_attribute($music['tracks']['s_attribute']);
        		foreach($music['tracks'] as $v){
        			//print_r($v);
        			$string .= '<track';
        			$string .= $this->build_attribute($v['s_attribute']);
        			$string .= '</track>';
        		}
        	$string .= '</tracks>';
        }
        $string .= '</BackgroundMusic>';
        return $string;
    }
    private function get_ImageMap($imageMap){
    	$string = '<ImageMap';
    	$string .= $this->build_attribute($imageMap['s_attribute']);
    	if (isset($imageMap['window'])){
    		$string .= '<window';
    		$string .= $this->build_attribute($imageMap['window']['s_attribute']);
    		$string .= '</window>';
    	}
    	if (isset($imageMap['close'])){
    		$string .= '<close';
    		$string .= $this->build_attribute($imageMap['close']['s_attribute']);
    		$string .= '</close>';
    	}
    	//viewer
    	if (isset($imageMap['viewer'])){
    		$string .= '<viewer';
    		$string .= $this->build_attribute($imageMap['viewer']['s_attribute']);
    		$string .= '</viewer>';
    	}
    	if (isset($imageMap['map'])){
    		$string .= '<maps>';
    		$string .= '<map';
    		$string .= $this->build_attribute($imageMap['map']['s_attribute']);
    		$string .='<waypoints';
    		$string .= $this->build_attribute($imageMap['map']['waypoints']['s_attribute']);
    		
    		if(isset($imageMap['map']['waypoints']['waypoint']) && is_array($imageMap['map']['waypoints']['waypoint'])){
    			foreach($imageMap['map']['waypoints']['waypoint'] as $v){
    				$string .= '<waypoint';
    				$string .= $this->build_attribute($v['s_attribute']);
    				$string .= '</waypoint>';
    			}
    		}
    		
    		$string .='</waypoints>';
    		$string .='</map>';
    		$string .= '</maps>';
    	}
    	$string .='</ImageMap>';
    	return $string;
    }
    private function get_ButtonBar($buttonBar){
        $string = '<ButtonBar';
        $string .= $this->build_attribute($buttonBar['s_attribute']);
        if (isset($buttonBar['window'])){
            $string .= '<window';
            $string .= $this->build_attribute($buttonBar['window']['s_attribute']);
            $string .= '</window>';
        }
        if (isset($buttonBar['buttons'])){
            $string .= '<buttons';
            if (isset($buttonBar['buttons']['s_attribute'])){
                $string .= $this->build_attribute($buttonBar['buttons']['s_attribute']);
            }
            
            if(isset($buttonBar['buttons']) && is_array($buttonBar['buttons'])){
            	foreach($buttonBar['buttons'] as $k=>$v){
            		if($k == 'button'){
            			foreach($v as $v1){
	            			$string .= '<button';
	            			$string .= $this->build_attribute($v1['s_attribute']);
	            			$string .= '</button>';
            			}
            		}
            		else if($k=='extraButton'){
            			foreach($v as $v1){
	            			$string .= '<extraButton';
	            			$string .= $this->build_attribute($v1['s_attribute']);
	            			$string .= '</extraButton>';
            			}
            		}
            	}
            }
            
            $string .= '</buttons>';
        }
        $string .= "</ButtonBar>\n";
        return $string;
    }

    private function get_ImageButton($imageButton){
        $string = '<ImageButton';
        $string .= $this->build_attribute($imageButton['s_attribute']);
        if (isset($imageButton['buttons'])){
            foreach ($imageButton['buttons'] as $k=>$v){
                $string .= '<button';
                $string .= $this->build_attribute($v['s_attribute']);
                if (isset($v['window'])){
                    $string .= '<window';
                    $string .= $this->build_attribute($v['window']['s_attribute']);
                    $string .= '</window>';
                }
                if (isset($v['subButtons'])){
                    $string .= '<subButtons>';
                    foreach ($v['subButtons'] as $k1=>$v1){
                        $string .= '<subButton';
                        $string .= $this->build_attribute($v1['s_attribute']);
                        $string .= '</subButton>';
                    }
                    $string .= '</subButtons>';
                }
                $string .= '</button>';
            }
        }
        $string .= "</ImageButton>\n";
        return $string;
    }
    private function get_InfoBubble($infoBubble){
    	//print_r($infoBubble);
        $string = '<InfoBubble';
        if(isset($infoBubble['s_attribute'])){
       		$string .= $this->build_attribute($infoBubble['s_attribute']);
        }
        if (isset($infoBubble['settings'])){
            $string .= '<settings';
            $string .= $this->build_attribute($infoBubble['settings']);
            $string .= '</settings>';
        }
        if (isset($infoBubble['styles'])){
            $string .= '<styles>';
            foreach ($infoBubble['styles'] as $k=>$v){
                $string .= '<style';
                $string .= $this->build_attribute($v['s_attribute']);
                $string .= '</style>';
            }
            $string .= '</styles>';
        }
        if (isset($infoBubble['bubbles'])){
            $string .= '<bubbles';
            if(isset($infoBubble['bubbles']['s_attribute'])){
            	$string .= $this->build_attribute($infoBubble['bubbles']['s_attribute']);
            }
            else {
            	$string .= '>';
            }
            if (isset($infoBubble['bubbles']['text'])){
                foreach ($infoBubble['bubbles']['text'] as $k=>$v){
                    $string .= '<text';
                    $string .= $this->build_attribute($v['s_attribute']);
                    $string .= '</text>';
                }
            }
            if (isset($infoBubble['bubbles']['image'])){
                foreach ($infoBubble['bubbles']['image'] as $k=>$v){
                    $string .= '<image';
                    $string .= $this->build_attribute($v['s_attribute']);
                    $string .= '</image>';
                }
            }
            $string .= '</bubbles>';
        }
        $string .= "</InfoBubble>\n";
        return $string;
    }
    private function get_MenuScroller($menuScroller){
        if(!$menuScroller){
            return '';
        }
        $string = '<MenuScroller';
        $string .= $this->build_attribute($menuScroller['s_attribute']);
        if (isset($menuScroller['window'])){
            $string .= '<window';
            $string .= $this->build_attribute($menuScroller['window']['s_attribute']);
            $string .= '</window>';
        }
        if (isset($menuScroller['close'])){
            $string .= '<close';
            $string .= $this->build_attribute($menuScroller['close']['s_attribute']);
            $string .= '</close>';
        }
        if (isset($menuScroller['scroller'])){
            $string .= '<scroller';
            $string .= $this->build_attribute($menuScroller['scroller']['s_attribute']);
            $string .= '</scroller>';
        }
        //print_r($menuScroller['elements']);
        if (isset($menuScroller['elements']) || isset($menuScroller['extraElements'])){
            $string .= '<elements>';
            if (isset($menuScroller['elements'])){
                foreach ($menuScroller['elements'] as $k=>$v){
                    $string .= '<element';
                    $string .= $this->build_attribute($v['s_attribute']);
                    $string .= '</element>';
                }
            }
            if (isset($menuScroller['extraElements'])){
                foreach ($menuScroller['extraElements'] as $k=>$v){
                    $string .= '<extraElement';
                    $string .= $this->build_attribute($v['s_attribute']);
                    $string .= '</extraElement>';
                }
            }
            $string .= '</elements>';
        }
        $string .= "</MenuScroller>\n";
        return $string;
    }
    private function get_JSGateway($jsGateway){
        $string = '<JSGateway';
        if (isset($jsGateway['s_attribute'])){
            $string .= $this->build_attribute($jsGateway['s_attribute']);
        }
        if (isset($jsGateway['settings'])){
            $string .= '<settings';
            $string .= $this->build_attribute($jsGateway['settings']['s_attribute']);
            $string .= '</settings>';
        }
        if (isset($jsGateway['jsfunctions'])){
            $string .= '<jsfunctions>';
            foreach ($jsGateway['jsfunctions'] as $k=>$v){
                $string .= '<jsfunction';
                $string .= $this->build_attribute($v['s_attribute']);
                $string .= '</jsfunction>';
            }
            $string .= '</jsfunctions>';
        }
        if (isset($jsGateway['asfunctions'])){
        	$string .= '<asfunctions>';
            foreach ($jsGateway['asfunctions'] as $k=>$v){
                $string .= '<asfunction';
                $string .= $this->build_attribute($v['s_attribute']);
                $string .= '</asfunction>';
            }
            $string .= '</asfunctions>';
        }
        $string .= "</JSGateway>\n";
        return $string;
    }
    private function get_LinkOpener($linkOpener){
        $exit_link = array();
        //print_r($linkOpener);
        $string = '<LinkOpener';
        $string .= $this->build_attribute($linkOpener['s_attribute']);
        if (isset($linkOpener['links'])){
            $string .= '<links>';
            foreach ($linkOpener['links'] as $k=>$v){
                $attr = false;
                if (isset ($v['s_attribute']) && $v['s_attribute']['id']){
                    if (in_array($v['s_attribute']['id'], $exit_link)){
                        continue;
                    }
                    $attr = true;
                }
                $string .= '<link';
                if(!isset($v['s_attribute']['target'])){
                    $v['s_attribute']['target'] = '_self';
                }
                $string .= $this->build_attribute($v['s_attribute']);
                $string .= '</link>';
                if($attr){
                    $exit_link[] = $v['s_attribute']['id'];
                }
            }
            $string .= '</links>';
        }
        $string .= "</LinkOpener>\n";
        return $string;
    }
    private function get_MouseCursor($mouseCursor){
    	$string = '<MouseCursor';
    	if (isset($mouseCursor['s_attribute'])){
    		$string .= $this->build_attribute($mouseCursor['s_attribute']);
    	}
    	if (isset($mouseCursor['settings'])){
    		$string .= '<settings';
    		$string .= $this->build_attribute($mouseCursor['settings']['s_attribute']);
    		$string .= '</settings>';
    	}
    	$string .= "</MouseCursor>\n";
    	return $string;
    }
}








