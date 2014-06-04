<?php $this->pageTitle=$datas['page_title'].'---足不出户，畅游中国';?>
<?php 
$display = array('1'=>'待发布', '2'=>'待审核', '3'=>'已发布')
?>
<div class="detail">
    <div class="hero-unit margin-top55">
        <h2>简单，易用</h2>
    </div>
    <ul class="breadcrumb">
        <li class="active">项目</li>
    </ul>
    <div class="row-fluid">
        <div class="span9">
            <div class="thumbnail">
            	<div class="project_list">
            	<?php if(isset($datas['list'])){ foreach($datas['list'] as $v){?>
            	   <div class="scene_single">
            			<div class="previe_img">
	            			<a href="<?=$this->createUrl('pano/scene/list', array('id'=>$v['id']));?>">
	            			<?php $thumb = PicTools::get_pano_thumb($datas['thumb'][$v['id']] , '150x110');?>
	            			<img width="150" src="<?=$thumb?$thumb:'/style/img/default-2.gif'?>"/>
	            			</a>
            			</div>
            			<div class="scene_title">
            				<div class="title_line">
            					<?php echo CHtml::link($v['name'],array('pano/scene/list','id'=>$v['id']));?>&nbsp&nbsp&nbsp&nbsp<span style="font-size:12px">项目ID:<?=$v['id']?></span>
            				</div>
            				<div class="scene_desc">
            					<?=tools::truncate_utf8_string(strip_tags($v['desc']),110)?>
            					<br>
            					
                    			<?php echo CHtml::link("编辑",array('pano/project/edit','id'=>$v['id']));?>
                    			&nbsp;| <?=$display[$v['display']];?>
                    			&nbsp;| 分类：[<?=Yii::app()->params['panoCategory'][$v['category_id']]?>]
                    		</div>
                    	</div>
                    </div>
                    <div class="clear"></div>
   <!--          		<div class="scene_single">
            			<div class="previe_img">
	            			<a href="<?=$this->createUrl('/pano/salado/edit/', array('id'=>1));?>">
	            			<img width="150" src="<?=PicTools::get_pano_thumb(1, '150x110')?>"/>
	            			</a>
            			</div>
            			
            			<div class="float_left title">
                    	<?php //echo $v['id'];?>  <?php echo CHtml::link($v['name'],array('pano/scene/list','id'=>$v['id']));?>
                    	</div>
                    	<div class="float_right tools">
                    	<?=$display[$v['display']];?>&nbsp;|
                    	<?php echo CHtml::link("编辑",array('pano/project/edit','id'=>$v['id']));?>
                    	</div>
                    </div> -->
                <?php }} else { ?>
                	<div class="margin-top10">
					<strong>您还没有项目，点击右侧"新建项目"按钮，建立您的第一个项目</strong>
					</div>
				<?php }?>
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
        </div>
        <div class="span3">
            <div class="thumbnail">
                <div class="list_box">
                <br>
                	<button class="btn btn-success" onclick="jump_to('<?=$this->createUrl('/pano/project/add/');?>')">新建项目</button>
                <br>
                </div>
            </div>
        </div>
    </div>
</div>

