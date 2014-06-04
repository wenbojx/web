<?php $this->pageTitle='全景，漫游，三维，上海，免费，发布平台';?>
<div class="hero-unit padding5" id="static_banner">
	<div class="banner_box">
		<div class="index_banner" style="background:url(<?=Yii::app()->baseUrl . '/style/banner/'.$datas['baner_scene_id'].'.jpg'?>)">
			<div class="click" onclick="show_banner_pano()">点击，拖动，开始奇妙之旅！</div>
			<div class="tips">享受不一样的视觉体验！</div>
		</div>
		<p class="r_top"><a target="_blank" href="http://weibo.com/yiluhao">关注微博</a></p>
	</div>
</div>
<div class="hero-unit banner_box padding5 display_none" id="pano_banner">
	<div class="banner_box">
		<div>
			<iframe src="<?=$this->createUrl('/web/single/a/', array('id'=>$datas['baner_scene_id'],'w'=>'932','h'=>'400','title'=>'1'));?>" frameborder=0 width="930" height="400" scrolling="no">
			</iframe>
		</div>
		<p class="r_top">
			<a href="javascript::" onclick="show_banner_pic()">收起 | </a>
			<a target="_blank" href="http://weibo.com/yiluhao">关注微博</a>
		</p>
	</div>
</div>

<div class="row about">
	<div class="span6">
		<h3><a href="#">免费全景制作平台</a></h3>
		<div class="margin-top10">
			<p>1、免费全景播放器，功能实用，可定制</p>
			<p>2、轻松在线制作全景项目，漫游，地图等等不在话下</p>
			<p>3、一次制作，发布无忧，网页，手机，平板，一键搞定</p>
		</div>
 	</div>
	<div class="span6">
		<h3>基本信息</h3>
		<div class="margin-top10">
			<h4><a href="<?=$this->createUrl('/member/register/a');?>">还等什么？ 马上发布全景图</a></h4>
			<p></p>
			<p>自主研发移动端全景播放器，速度，效率，兼容性一流</p>
			<p>当前系统共有 (<a class="color_red" href="<?=$this->createUrl('/web/list/a');?>"><?=$datas['total_num']?></a>) 个场景，
			<a target="_blank" href="http://weibo.com/yiluhao">关注微博</a>获取最新研发动态..
				 <!-- <a href="<?=$this->createUrl('/web/list/a');?>">查看全部</a> -->
			</p>
		</div>
	</div>
</div>
<br>
<div class="row case">
<div class="content_center"><img src="<?=Yii::app()->baseUrl . '/style/img/yingdao.jpg'?>"/></div>
</div>