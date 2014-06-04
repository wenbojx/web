<?php
class SaladoImport{
    public function analyze_file($xmlfile){
        if(!file_exists($xmlfile)){
            return false;
        }
        $xml = simplexml_load_file($xmlfile);
        if(!$xml){
        	return false;
        }
        $xmlTools_obj = new XmlTools();
        $xmlTools_obj->convertXmlObjToArr($xml, $arr);
		$pano_datas = $this->analyze_node( $arr );

    }

    private function analyze_node($datas){
    	$salado_datas = array();
    	foreach($datas as $k=>$v){
    		switch ($v['@name']){
    			case 'global':
    				$salado_datas['global'] = $this->analyze_global($v);
    				
    			break;
    			case 'panoramas':
    				$salado_datas['panoramas'] = $this->analyze_panorams($v);
    			break;
    			case 'modules':
    				$this->analyze_modules($v);
    			break;
    			case 'actions':
    				$salado_datas['actions'] = $this->analyze_actions($v);
    			break;
    		}
    	}
    	print_r($salado_datas);
    }

    private function analyze_global($datas){
    	$cfg_global = array();
    	if (!$datas){
    		return $cfg_global;
    	}
    	if ($datas['@attributes']){
    		$cfg_global['s_attribute'] = $datas['@attributes'];
    	}
    	if ($datas['@children']){
	    	foreach($datas['@children'] as $k=>$v){
	    		if ($v['@name'] == 'branding'){
			    	if ($v['@attributes']){
		    			$cfg_global['branding']['s_attribute'] = $v['@attributes'];
		    		}
	    		}
	    		if ($v['@name']=='control'){
	    		if ($v['@attributes']){
		    			$cfg_global['control']['s_attribute'] = $v['@attributes'];
		    		}
	    		}
	    	}
    	}
    	return $cfg_global;
    }
    private function analyze_actions($datas){
    	$cfg_actions = array();
    	if (!$datas){
    		return $cfg_actions;
    	}
    	if ($datas['@attributes']){
    		$cfg_global['s_attribute'] = $datas['@attributes'];
    	}
    	if ($datas['@children']){
    		foreach($datas['@children'] as $k=>$v){
    			$cfg_actions[$k] = $v['@attributes'];
    		}
    	}
    	return $cfg_actions;
    }
    private function analyze_panorams($datas){
    	$cfg_panorams = array();
    	if (!$datas){
    		return $cfg_panorams;
    	}
    	if ($datas['@attributes']){
    		$cfg_panorams['s_attribute'] = $datas['@attributes'];
    	}
    	//print_r($datas);
    	if ($datas['@children']){
    		$v = $datas['@children'][0];
    		//foreach($datas['@children'] as $k=>$v){
	    		if ($v['@attributes']){
		    		$cfg_panorams['s_attribute'] = $v['@attributes'];
		    	}
		    	if ($v['@children']){
		    		foreach ($v['@children'] as $k1=>$v1){
		    			if ($v1['@name'] == 'swf'){
		    				$cfg_panorams['hotspots'][$k1]['type'] = 'swf';
		    				$cfg_panorams['hotspots'][$k1]['s_attribute'] = $v1['@attributes'];
		    				if ($v1['@children']){
		    					$cfg_panorams['hotspots'][$k1]['settings'] = $v1['@children'][0]['@attributes'];
		    				}
		    			}
		    			if ($v1['@name'] == 'image'){
		    				$cfg_panorams['hotspots'][$k1]['type'] = 'image';
		    				$cfg_panorams['hotspots'][$k1]['s_attribute'] = $v1['@attributes'];
		    			}
		    		}
		    	}
    		//}
    	}
    	return $cfg_panorams;
    }
    private function analyze_modules($datas){
    	
    }
}