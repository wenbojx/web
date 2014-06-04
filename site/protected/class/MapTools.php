<?php
Yii::import('application.extensions.curl.Curl');
class MapTools{
    /**
     * 从google地图转换为百度地图坐标
     * @param array $latlng
     * @return array 失败返回cur错误信息
     */
    public function convert($latlng) {
        $result = array();
        $url = "http://api.map.baidu.com/ag/coord/convert?from=2&to=4&x={$latlng['glng']}&y={$latlng['glat']}";
        $curl_obj = new Curl();
        $response = $curl_obj->run($url);
        if($response) {
            $rt = json_decode($response, true);
            if($rt['error'] == 0) {
                $result['blng'] = base64_decode($rt['x']);
                $result['blat'] = base64_decode($rt['y']);
                return $result;
            }
        } else {
            return false;
        }
    }
}