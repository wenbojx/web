<?php
class PanoramDatas{
    public function get_panoram_datas($id = 0){
        $datas = array();
        if(!(int)$id){
            return $datas;
        }
        $position_db = ScenesPosition::model();
    }
}