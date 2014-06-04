<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/pages/css/style.css"); ?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/pages/js/jquery172.min.js"); ?>
<title>login page</title>
</head>

<body>
    <div class="container">
        <div class="col_left">
            <h1 class="logo">
                <a href="">115，改变分享</a>
            </h1>
            <div class="left_menu">
                <div class="left-menu-side">
                    <ul id="left_tab_list">
                        <li class="focus">
                            <a href="javascript:;">
                                <i class="ico-dm dm-cloud"></i>
                                <span>网盘</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="javascript:;">
                                <i class="ico-dm dm-notebook"></i>
                                <span>记事本</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="javascript:;">
                                <i class="ico-dm dm-circle"></i>
                                <span>圈子</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="javascript:;">
                                <i	class="ico-dm dm-message"></i>
                                <span>消息</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col_right">
            <div class="right-sub-header">客户端下载</div>
            <div class="client-link">
                <ul>
                    <li><a href=""><i class="ico-client ic-windows"></i>Windows 版</a></li>
                    <li><a href=""><i class="ico-client ic-mac"></i>Mac 版</a></li>
                    <li><a href=""><i class="ico-client ic-android"></i>Android 版</a></li>
                    <li><a href=""><i class="ico-client ic-iphone"></i>iPhone 版</a></li>
                    <li><a href=""><i class="ico-client ic-ipad"></i>iPad 版</a></li>
                    <li><a href=""><i class="ico-client ic-wphone"></i>Windows Phone 版</a></li>
                </ul>
            </div>
        </div>
        <div class="col_center">
            <?php echo $content;?>
            <div class="footer">
                <p>&copy; 2012 yiluhao.com 沪ICP备********号  <a target="_blank" href="">增值电信业务经营许可证沪B2-20120370</a></p>
                <p>
                    <a rel="nofollow" target="_blank" href="http://www.sh.gov.cn/">上海</a> •
                    <a rel="nofollow" target="_blank" href="http://www.sh.gov.cn/">东莞</a> •
                    <a rel="nofollow" target="_blank" href="">陆家嘴</a>&#12288;&#12288;
                    <a rel="nofollow" target="_blank" href="">**</a> •
                    <a rel="nofollow" target="_blank" href="">**</a>&#12288;&#12288;
                    <a href="" target="_blank" rel="nofollow">关于一路好</a> •
                    <a href="" target="_blank" rel="nofollow">诚征英才</a>
               </p>
            </div>
        </div>

    </div>
</body>
</html>
