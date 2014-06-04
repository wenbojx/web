<?php
class tools{
    /**
     * 从google地图转换为百度地图坐标
     * @param array $latlng
     * @return array 失败返回cur错误信息
     */
    public static function convert($latlng) {
        $result = array();
        apf_require_class('APF_Http_Client_Curl');
        $curl = new APF_Http_Client_Curl();
        $url = "http://api.map.baidu.com/ag/coord/convert?from=2&to=4&x={$latlng['glng']}&y={$latlng['glat']}";
        $curl->set_url($url);
        $rs = $curl->execute();
        if($rs) {
            $response = $curl->get_response_text();
            $rt = json_decode($response, true);
            if($rt['error'] == 0) {
                $result['blng'] = base64_decode($rt['x']);
                $result['blat'] = base64_decode($rt['y']);
                return $result;
            }
        } else {
            return -1;
        }
    }
    public static function truncate_utf8_string($string, $length, $etc = '...')
    {
    	$result = '';
    	$string = html_entity_decode(trim(strip_tags($string)), ENT_QUOTES, 'UTF-8');
    	$strlen = strlen($string);
    	for ($i = 0; (($i < $strlen) && ($length > 0)); $i++)
    	{
    	if ($number = strpos(str_pad(decbin(ord(substr($string, $i, 1))), 8, '0', STR_PAD_LEFT), '0'))
    	{
    	if ($length < 1.0)
    	{
    		break;
    	}
    	$result .= substr($string, $i, $number);
    		$length -= 1.0;
    		$i += $number - 1;
    	}
    	else
    	{
    		$result .= substr($string, $i, 1);
    		$length -= 0.5;
    	}
    	}
    	$result = htmlspecialchars($result, ENT_QUOTES, 'UTF-8');
    	if ($i < $strlen)
    	{
    	$result .= $etc;
    	}
    	return $result;
    }
}