<?php $this->pageTitle='服务，报价，全景，三维，上海';?>
	<style>
.index_banner{height:238px;}
.index_banner .click{padding:180px 0 0 0; font-size:24px}
.index_banner .tips{padding:10px 0 0 0; font-size:14px}
</style>
	<div class="hero-unit padding5" id="static_banner">
		<div class="banner_box">
			<div class="index_banner" style="background:url(<?=Yii::app()->baseUrl . '/style/banner/'.$datas['baner_scene_id'].'.jpg'?>)">
				<div class="click" onclick="show_banner_pano()">点击，拖动，开始奇妙之旅！</div>
				<div class="tips">享受不一样的视觉体验！</div>
			</div>
			
		</div>
	</div>
	<div class="hero-unit banner_box padding5 display_none" id="pano_banner">
		<div class="banner_box">
			<div>
				<iframe src="<?=$this->createUrl('/web/single/a/', array('id'=>$datas['baner_scene_id'],'w'=>'932','h'=>'500','title'=>'1'));?>" frameborder=0 width="930" height="500" scrolling="no">
				</iframe>
			</div>
			<p class="r_top">
				<a href="javascript::" onclick="show_banner_pic()">收起</a>
			</p>
		</div>
	</div>
	
	<div class="mini-layout">
        <div class="row-fluid show-grid">
        <div class="span12">
                <div class="span7">
	                <div style="color: #333333">
	                <br><br>
	                <!-- 
	              		<h3><span style="color: red">限时特惠</span></h3>
	              		<br>
	                	<strong>凡在3.1日至3.31日预约家居类室内全景摄影的客户(限上海地区)，
	                	即可享受<span style="color: red">超级特惠</span>服务</strong>
	                	<br><br>
	                	<h3>特惠内容</h3>
	              		<br>
	                	<span>1、价格，800元拍摄3个场景(原价2400元)，超出部分400元/场景</span><br><br>
	                	<span>2、为项目嵌入客户网站免费提供技术支持</span><br><br>
	                	<span>3、免费为项目添加客户自己的logo</span><br><br>
	                	
	                	<h3>报名方式</h3>
	              		<br>
	                	<span>如果您有意愿参加我们此次活动，请发送邮件至yiluhao@gmail.com 或联系QQ：1423795537</span>
	                	<br><br>
	                	邮件标题: 预约室内摄影<br>
	                	邮件内容: 您的姓名， 联系电话， 联系地址<br>
	                	附件：含全景的室内设计项目的图片一张或多张
	                	<br><br>
	                	<h3>注意事项</h3>
	              		<br>
	                	<span>1、收到您的预约后，我们会电话确认拍摄时间和地点，并安排专职摄影师实地拍摄。</span><br><br>
	                	<span>2、每位客户只能有一个项目参加优惠，如客户作品优秀，此条件可适当放宽</span><br><br>
	                	<span>3、我们以您发送邮件的日期为准，超过截止日期的不享受此优惠活动</span><br><br>
	                	
	                	<br><br>
 -->
	              		<h3>服务</h3>
	              		<br>
	                	<span>1、为客户提供全景摄影服务，适用行业(房产，酒店，旅游，学校...)</span>
	                	<br><br>
	                	<span>2、为客户提供全景后期制作服务，含(网页版，苹果手机版，android手机版)</span>
	                	<br><br>
	                	<h3>优势</h3>
	              		<br>
	                	<span>1、我们有专业的研发的团队，设计团队。</span><br><br>
	                	<span>2、自主开发出国内首个掌上全景播放器。</span>
	                	<br><br>
	                	<h3>报价</h3>
	              		<br>
	                	<span>1、全景拍摄及后期网页制作，800元/场景</span><br><br>
	                	<span>2、制作成手机版价格另议</span>
	                	<br><br>
	                	<h3>服务流程</h3>
	              		<br>
	                	<span>1、与客户确定具体全景解决方案</span><br><br>
	                	<span>2、安排专业摄影师上门拍摄取景，并收取总额50%预付款</span><br><br>
	                	<span>3、后期制作</span><br><br>
	                	<span>4、客户验收，收取剩余款项</span>
	                	<br><br>
	                <br>
	                <br>
	                </div>
                </div>
        </div>
        </div>
    </div>
