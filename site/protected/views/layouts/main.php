<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/pages/css/common.css"); ?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/pages/css/main.css"); ?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/pages/css/boxy.css"); ?>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/pages/js/jquery172.min.js");?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/pages/js/jquery.boxy.js");?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/pages/js/core.js");?>

<title>main</title>
</head>
<body>
<div id="js_page_side" class="frame-side">
    <div id="js_user_nav_box" class="user-nav"><i class="arrow"></i>
        <div onclick="" class="user-head"> <img alt="" src=""> </div>
        <div class="user-name">sunbob83</div>
        <dl style="display:none;" class="nav-menu">
            <dt>
            <span>2729815</span>
            <a href="">退出</a>
            </dt>
            <dd>
                <ul>
                    <!--<li><a onclick="" href="javascript:;"><i class="ico-user iu-info"></i>个人资料</a></li>
                    <li><a onclick="" href="javascript:;"><i class="ico-user iu-setting"></i>网盘设置</a></li>
                    <li><a onclick="" href="javascript:;"><i class="ico-user iu-friend"></i>好友管理</a></li>
                    <li><a onclick="" href="javascript:;"><i class="ico-user iu-safe"></i>帐号安全</a></li>
                    <li><a onclick="" href="javascript:;"><i class="ico-user iu-app"></i>应用市场</a></li>
                    <li id="js_wan_open_li_dom"><a onclick="" href="javascript:;"><i class="ico-user iu-game"></i>游戏中心</a></li>
                    <li><a onclick="" href="javascript:;"><i class="ico-user iu-vip"></i>VIP服务</a></li>
                    <li><a onclick="" href="javascript:;"><i class="ico-user iu-money"></i>推广赚钱</a></li>
                --></ul>
            </dd>
        </dl>
    </div>
    <!--网盘分类目录-->
    <div class="directory-menu">
        <div class="dir-menu-side">
            <ul>
                <li class="focus"><a onclick=""><i class="ico-dm dm-cloud"></i><span>项目</span></a></li>
                <li><a onclick="" href="javascript:;"><i class="ico-dm dm-notebook"></i><span>场景</span></a></li>
                <li><a onclick="" href="javascript:;"><i class="ico-dm dm-circle"></i><span>文件</span><em style="display:none;" id="js_qmsg_recv_count"></em></a></li>
                <li><a onclick="" href="javascript:;"><i class="ico-dm dm-message"></i><span>回收站</span><em style="display:none;" id="js_msg_recv_count"></em></a></li>

            </ul>
        </div>
    </div>
</div>
<div id="js_iframe_content" class="frame-contents">
<?php echo $content;?>
</div>

</body>
</html>