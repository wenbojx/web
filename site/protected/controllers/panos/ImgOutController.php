<?php
ini_set('memory_limit', '100M');
class ImgOutController extends FController{
    public $defaultAction = 'index';
    private $folder = '';

    public function actionIndex(){
        $request = Yii::app()->request;
        $no = $request->getParam('id');
        $pic_datas = array('pic_type'=>'jpg', 'pic_content'=>'');
        if($no){
            $img_class = new ImageContent();
            $size = $request->getParam('size') ? $request->getParam('size') : '';
            $suffix = 'original';
            $pic_datas = $img_class->get_img_content_by_md5file($no, $size, $suffix);
        }
    }
}