<?php
ini_set('memory_limit', '500M');
class TestImageCommand extends CConsoleCommand {
	private $file = "/var/www/home/home/html/test.jpg";
	private $files = "C:/mydatas/APMServ5.2.6/www/htdocs/www/home/tmp/right.jpg";
	
	public function actionImage(){
		$image = Yii::app()->image->load($this->file);
		$maxW =2048;
		$maxH = 1024;
		$image->resize($maxW, $maxH)->quality(70);
		$new_file = "/var/www/home/home/html/image.jpg";
		$image->save($new_file);
		
	}
	public function actionAb(){
		$myimage = new Imagick($this->files);
		$quality = 85;
		$myimage->setImageCompression(imagick::COMPRESSION_JPEG);
		$myimage->setImageCompressionQuality($quality);
		/* $myimage->setImageCompression(imagick::COMPRESSION_JPEG);
		$myimage->setImageFormat("jpeg");
		$myimage->setImageCompressionQuality( 80 );
		$maxW =1024;
		$maxH = 1024;
		$myimage->resizeimage($maxW, $maxH, Imagick::FILTER_LANCZOS, 1, true);
		$new_file = "C:/mydatas/APMServ5.2.6/www/htdocs/www/home/tmp/right1.jpg";
		//$myimage->setImageCompressionQuality( 50 ); */
		
		$p_width = $myimage->getImageWidth();
		$p_height = $myimage->getImageHeight();
		//重置尺寸
		$maxW=898;
		$myimage->resizeimage($maxW, $maxW, Imagick::FILTER_LANCZOS, 1, true);
		$sharpen = 0.6;
		$myimage->sharpenImage($sharpen, $sharpen);
		//$sharpen = 0.5;
		//$myimage->sharpenImage($sharpen, $sharpen);
		$file_name='1_0.jpg';
		
		$x = 0 ;
		$y = 0;
		$half_x = $p_width/2;
		$half_y = $p_height/2;
		
		$half_x = 449;
		$half_y = 449;
		
		if(strstr($file_name, '1_0')){
			$x = $half_x;
		}
		else if(strstr($file_name, '0_1')){
			$y = $half_y;
		}
		else if(strstr($file_name, '1_1')){
			$x = $half_x;
			$y = $half_y;
		}
		
		$myimage->cropimage($half_x, $half_y, $x, $y);
		//$myimage->resizeimage($maxW, $maxW, Imagick::FILTER_LANCZOS, 1, true);

		$new_file = "C:/mydatas/APMServ5.2.6/www/htdocs/www/home/tmp/right1.jpg";
		$myimage->writeImage($new_file);
		$myimage->clear();
		$myimage->destroy();
	}

	public function actionImagick(){
		$myimage = new Imagick($this->files);
		$myimage->setImageFormat("jpeg");
		$myimage->setCompressionQuality( 70 );
		
		$maxW =3600;
		$maxH = 3600;
		//$myimage->resizeimage($maxW, $maxH, Imagick::FILTER_LANCZOS, 1, true);
		//$new_file = "C:/mydatas/APMServ5.2.6/www/htdocs/www/home/tmp/1.jpg";
		//$myimage->writeImage($new_file);
		
		$maxW =1800;
		$maxH = 1800;
		
		$myimage->resizeimage($maxW, $maxH, Imagick::FILTER_LANCZOS, 1, true);
		$new_file = "C:/mydatas/APMServ5.2.6/www/htdocs/www/home/tmp/2.jpg";
		$myimage->writeImage($new_file);
		
		$myimage->clear();
		$myimage->destroy();
	}
	public function actionImagickSingle(){
		$myimage = new Imagick($this->file);
		$myimage->setImageFormat("jpeg");
		//$myimage->setCompressionQuality( 70 );
		//$maxW =2048;
		//$maxH = 1024;
		//$myimage->resizeimage($maxW, $maxH, Imagick::FILTER_LANCZOS, 1, true);
		$new_file = "/var/www/home/home/html/imagick.jpg";
		$myimage->writeImage($new_file);
		$myimage->clear();
		$myimage->destroy();
	}
}
?>

