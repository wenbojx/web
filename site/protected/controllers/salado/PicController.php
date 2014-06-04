<?php
ini_set('memory_limit', '100M');
Yii::import('application.extensions.image.Image');
class PicController extends Controller{
    public $defaultAction = 'show';
    private $folder = '';

    public function actionShow(){
        $request = Yii::app()->request;
        $id = $request->getParam('id');
        //$pic_datas = array('pic_type'=>'jpg', 'pic_content'=>'');
        exit();
        if($id){
            $img_class = new Image();
            $size = isset($request->getParam('size')) ? $request->getParam('size') : '';
            $pic_datas = $img_class->get_img_content_by_id($id, $size);
        }
    }
    
}