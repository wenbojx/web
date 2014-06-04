<?php
class SaladoModules extends SaladoPlayer{
    private $map_type = array(
            '1'=>'ButtonBar','2'=>'ImageButton','3'=>'InfoBubble',
            '4'=>'MenuScroller','5'=>'JSGateway','6'=>'JSGateway',
            '7'=>'LinkOpener'
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
    );
    public function get_modules_info($modules){
        $modules_str = '<modules>';
        if (!is_array($modules)){
            return $modules_str;
        }
        foreach ($modules as $k=>$v){
            $type_name = $this->map_type[$v['type']];
            $method = 'get_'.$type_name;
            $modules_str .= $this->$method($v);
        }
        $modules_str .= '</modules>';
        return $modules_str;
    }
    private function get_ButtonBar($buttonBar){
        $string = '<ButtonBar';
        if (isset($buttonBar['s_attribute'])){
            $string .= ' ';
            $string .= $this->build_attribute($buttonBar['s_attribute']);
        }
        $string .= '>';
        if (isset($buttonBar['window'])){
            $string .= '<window';
            $string .= ' ';
            $string .= $this->build_attribute($buttonBar['window']);
        }
        $string .= '>';
        if (isset($buttonBar['buttons'])){
            $string .= '<buttons';
            if (isset($buttonBar['buttons']['s_attribute'])){
                $string .= ' ';
                $string .= $this->build_attribute($buttonBar['buttons']['s_attribute']);
            }
            $string .= '>';
            if (isset($buttonBar['buttons']['button'])){
                $button = $buttonBar['buttons']['button'];
                $string .= '<button';
                foreach ($button as $k=>$v){
                    $string .= ' ';
                    $string .= $this->build_attribute($button['s_attribute']);
                }
                $string .= '>';
                $string .= '</button>';
            }
            if (isset($buttonBar['buttons']['extraButton'])){
                $extraButton = $buttonBar['buttons']['extraButton'];
                $string .= '<extraButton';
                foreach ($extraButton as $k=>$v){
                    $string .= ' ';
                    $string .= $this->build_attribute($extraButton['s_attribute']);
                }
                $string .= '>';
                $string .= '</extraButton>';
            }
            $string .= '</buttons>';
        }
        $string .= '</ButtonBar>';
        return $string;
    }

    private function get_ImageButton($imageButton){
        $string = '<ImageButton';
        if (isset($imageButton['s_attribute'])){
            $string .= ' ';
            $string .= $this->build_attribute($imageButton['s_attribute']);
        }
        $string .= '>';
        if (isset($imageButton['buttons'])){
            foreach ($imageButton['buttons'] as $k=>$v){
                $string .= '<button';
                if (isset($v['s_attribute'])){
                    $string .= ' ';
                    $string .= $this->build_attribute($v['s_attribute']);
                }
                $string .= '>';
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
        $string .= '</ImageButton>';
        return $string;
    }
    private function get_InfoBubble($infoBubble){
        $string = '<InfoBubble';
        if (isset($infoBubble['s_attribute'])){
            $string .= ' ';
            $string .= $this->build_attribute($infoBubble['s_attribute']);
        }
        $string .= '>';
        if (isset($infoBubble['settings'])){
            $string .= '<settings';
            $string .= $this->build_attribute($infoBubble['settings']);
            $string .= '</settings>';
        }
        if (isset($infoBubble['styles'])){
            $string .= '<styles>';
            foreach ($infoBubble['styles'] as $k=>$v){
                $string .= '<style';
                $string .= $this->build_attribute($infoBubble['styles']);
                $string .= '</style>';
            }
            $string .= '</styles>';
        }
        if (isset($infoBubble['bubbles'])){
            $string .= '<bubbles';
            $string .= $this->build_attribute($infoBubble['bubbles']['s_attribute']);
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
        $string .= '</InfoBubble>';
        return $string;
    }
    private function get_MenuScroller($menuScroller){
        $string = '<MenuScroller';
        if (isset($menuScroller['s_attribute'])){
            $string .= $this->build_attribute($menuScroller['s_attribute']);
        }
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
        if (isset($menuScroller['elements']) || isset($menuScroller['extraElements'])){
            $string .= '<elements>';
            if (isset($menuScroller['elements'])){
                foreach ($menuScroller['elements'] as $k=>$v){
                    $string .= '<element';
                    $string .= $this->build_attribute($v['s_attribute']);
                    $string .= '</element>';
                }
            }
            if (isset($menuScroller['extraElement'])){
                foreach ($menuScroller['extraElement'] as $k=>$v){
                    $string .= '<extraElement';
                    $string .= $this->build_attribute($v['s_attribute']);
                    $string .= '</extraElement>';
                }
            }
            $string .= '</elements>';
        }
        $string .= '</MenuScroller>';
        return $string;
    }
    private function get_JSGateway($jsGateway){
        $string = '<JSGateway';
        if (isset($jsGateway['s_attribute'])){
            $string .= $this->build_attribute($jsGateway['s_attribute']);
        }
        if (isset($jsGateway['settings'])){
            $string .= '<settings';
            $string .= $this->build_attribute($jsGateway['settings']);
            $string .= '</settings>';
        }
        if (isset($jsGateway['jsfunctions'])){
            $string .= '<jsfunctions>';
            foreach ($jsGateway['jsfunctions'] as $k=>$v){
                $string .= '<jsfunction';
                $string .= $this->build_attribute($v['s_attribute']);
                $string .= '</jsfunction>';
            }
            foreach ($jsGateway['asfunctions'] as $k=>$v){
                $string .= '<asfunction';
                $string .= $this->build_attribute($v['s_attribute']);
                $string .= '</asfunction>';
            }
            $string .= '</jsfunctions>';
        }
        $string .= '</JSGateway>';
        return $string;
    }
    private function get_LinkOpener($linkOpener){
        $string = '<LinkOpener ';
        if (isset($linkOpener['s_attribute'])){
            $string .= $this->build_attribute($linkOpener['s_attribute']);
        }
        if (isset($linkOpener['links'])){
            $string .= '<links>';
            foreach ($linkOpener['links'] as $k=>$v){
                $string .= '<link';
                $string .= $this->build_attribute($linkOpener['links']);
                $string .= '</link>';
            }
            $string .= '</links>';
        }
        $string .= '</LinkOpener>';
        return $string;
    }
}








