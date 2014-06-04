<?php $this->pageTitle=$datas['project']['name'].'，全景，三维，上海';?>
<?php 
$widhtHeight = $widhtHeight = 90;
$chl = urlencode("http://m.yiluhao.com/l/{$datas['project']['id']}/");

?>
<div class="view">
	<div class="hero-unit margin-top55">
		<div class="banner_box">
			<h2>全新视觉体验</h2>
			<div class="r_index">
				<a style="color:#0088CC;" href="/">返回首页</a>
				
			</div>
		</div>
	</div>
	
	<div class="row about">
		<div class="span9">
		<?php if($datas['project']){?>
			<h3><?=$datas['project']['name']?></h3>
			<p>
				<?=tools::truncate_utf8_string(strip_tags($datas['project']['desc']),150)?>
			</p>
		<?php }?>
	 	</div>
	 	<div class="span3" style="text-align:right">
			<?php echo '<img title="手机访问请扫描二维码" src="http://chart.apis.google.com/chart?chs='.$widhtHeight.'x'.$widhtHeight.'&cht=qr&chld=L|0&chl='.$chl.'" alt="QR code" widhtHeight="'.$widhtHeight.'" widhtHeight="'.$widhtHeight.'"/>';?>

	 	</div>
	</div>
	<hr class="line3">
	<div class="row project view">
	<?php if($datas['list']){ foreach ($datas['list'] as $v){?>
		<div class="span3">
			<div class="thumbnail">
				<a href="<?=$this->createUrl('/web/detail/a/', array('id'=>$v['id']));?>">
				<img title="<?php echo $v['name'];?>" src="<?=PicTools::get_pano_small($v['id'], '200x100')?>"/>
				</a>
			</div>
		</div>
		
	<?php }}?>
	</div>
	
	<div class="page-footer">
					<div class="pagination">
                    <?php if(isset($datas['pages'])){  $this->widget('CLinkPager',array(
                        'header'=>'',
                        //'firstPageLabel' => '首页',
                        //'lastPageLabel' => '末页',
                        'prevPageLabel' => '上一页',
                        'nextPageLabel' => '下一页',
                        'pages' => $datas['pages'],
                        'maxButtonCount'=>10
                        )
                    );}?>
	</div>
            	</div>
</div>