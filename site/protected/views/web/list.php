<?php $this->pageTitle='全景，漫游，景点，风光，三维，上海';?>
<div class="list">
	<div class="hero-unit margin-top55">
		<div class="banner_box">
			<h2>足不出户 畅游中国</h2>
			<div class="r_index">
			<a style="color:#0088CC;" href="/">返回首页</a>
			</div>
		</div>
	</div>
	
	<div class="row project">
	<?php if($datas['projects']){ foreach($datas['projects'] as $v){?>
		<div class="span12">
			<div class="list_title">
				<h3 class="float_left title">
					<a href="<?=$this->createUrl('/web/view/a/', array('id'=>$v['project']['id']));?>">
					<?=$v['project']['name']?>
					</a>
					<span> (共 <?=$v['total_num']?> 个场景)</span>
				</h3>
				<span class="float_right info">
					<a href="<?=$this->createUrl('/web/view/a/', array('id'=>$v['project']['id']));?>">
					浏览更多...
					</a>
				</span>
				<div class="clear"></div>
			</div>
			<div class="row">
			<?php if ($v['scene']){ foreach($v['scene'] as $v1){?>
				<div class="span3">
					<div class="thumbnail">
					<a href="<?=$this->createUrl('/web/detail/a/', array('id'=>$v1['id']));?>">
						<img title="<?php echo $v1['name'];?>" src="<?=PicTools::get_pano_small($v1['id'], '200x100')?>"/>
					</a>
					</div>
				</div>
			<?php }}?>
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