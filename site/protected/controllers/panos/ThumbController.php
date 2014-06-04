<?php
ini_set('memory_limit', '100M');
class ThumbController extends FController{
    public $defaultAction = 'pic';
    private $folder = '';

    public function actionPic(){
        $request = Yii::app()->request;
        $id = $request->getParam('id');
        if($id){
            $thumb_datas = $this->get_pano_thumb($id);
            $img_class = new ImageContent();
            $size = $request->getParam('size') ? $request->getParam('size') : '';
            if(!$thumb_datas['file_id']){
                $default_img = 'style/img/thumb_default.jpg';
                $pic_datas = $img_class->get_default_img($default_img, 'jpg');
            }
            else {
            	$img_class->quality = 90;
            	$img_class->sharpen = 0;
                $pic_datas = $img_class->get_img_content_by_id($thumb_datas['file_id'], $size, 'original');
            }
        }
    }
    public function get_pano_thumb($scene_id){
        $thumb_db = new ScenesThumb();
        return $thumb_db->find_by_scene_id($scene_id);
    }
}