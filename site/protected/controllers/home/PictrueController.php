<?php
ini_set('memory_limit', '100M');
Yii::import('application.extensions.image.Image');
class PictrueController extends FController{
    public $defaultAction = 'index';
    private $folder = '';

    public function actionIndex(){
        $request = Yii::app()->request;
        $no = $request->getParam('id');
        $from = $request->getParam('from');
        //$sp = $request->getParam('sp');
        $pic_datas = array('pic_type'=>'jpg', 'pic_content'=>'');
        if($no){
            $img_class = new ImageContent();
            $img_class->water = $from == 'm' ? true :false;
            if($img_class){
            	$img_class->sharpen = 2;
            	$img_class->quality = 70;
            }
            $size = $request->getParam('size') ? $request->getParam('size') : '';
            $pic_datas = $img_class->get_img_content_by_md5file($no, $size, 'original');
        }
    }
}