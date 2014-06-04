<?php $this->pageTitle=$datas['page_title'].'---足不出户，畅游中国';?>
<?php 
$state = array('1'=>'待发布', '2'=>'已发布');
$widhtHeight = $widhtHeight = 100;
$chl = urlencode("http://m.yiluhao.com/l/{$datas['project']['id']}/");
?>
<div class="detail">
    <div class="hero-unit margin-top55">
        <h2>简单，易用</h2>
    </div>
    <ul class="breadcrumb">
        <li><?php echo CHtml::link('项目',array('pano/project/list'));?> <span class="divider">/</span></li>
        <li class="active"><?=$datas['project']['name']?></li>
    </ul>
    <div class="row-fluid">
        <div class="span9">
            <div class="thumbnail">
            	<div class="scene_list">
            	<?php if(isset($datas['list'])){ foreach($datas['list'] as $v){?>
            		<div class="scene_single">
            			<div class="previe_img">
	            			<a href="<?=$this->createUrl('/pano/salado/edit/', array('id'=>$v['id']));?>">
	            			<img width="150" src="<?=PicTools::get_pano_thumb($v['id'], '150x110')?>"/>
	            			</a>
            			</div>
            			<div class="scene_title">
            				<div class="title_line">
            					<?php echo CHtml::link($v['name'],array('pano/salado/edit','id'=>$v['id']));?>
            					&nbsp;&nbsp;&nbsp;&nbsp;
            					<a style="float:right" href="<?=$this->createUrl('/web/single/a/', array('id'=>$v['id']));?>" target="_blank">
            					短域名
            					</a>
            				</div>
            				<div class="scene_desc">
            					<?=tools::truncate_utf8_string(strip_tags($v['desc']),110)?>
            					<br>
            					<?php echo CHtml::link('编辑',array('pano/scene/edit','id'=>$v['id']));?>
            					 | <?php echo $state[$v['display']];?>
                    		</div>
                    	</div>
                    </div>
                    <div class="clear"></div>
                <?php }} else { ?>
                	<div class="margin-top10">
					<strong>您还没有场景，点击右侧"新建场景"按钮，建立您的第一个场景</strong>
					</div>
				<?php }?>
            	</div>
            	<div class="page-footer">
					<div class="pagination">
                    <?php if(isset($datas['pages'])){ $this->widget('CLinkPager',array(
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
                	<button class="btn btn-success" onclick="jump_to('<?=$this->createUrl('/pano/scene/add/', array('id'=>$project_id));?>')">新建场景</button>
                	<br>
                	<button id="online_project" class="btn btn btn-warning" style="<?=$datas['project']['display'] == '1'?'':'display:none' ?>" onclick="publish_project(<?=$project_id?>, 2)">上线项目</button>
                	<button id="offline_project" class="btn btn btn-warning" style="<?=$datas['project']['display'] == '3'?'':'display:none' ?>" onclick="publish_project(<?=$project_id?>, 1)">下线项目</button>
                	
                	
                </div>
                
            </div>
            <br>
            <div class="thumbnail">
                <div class="list_box">
                <br><br>
                	<?php echo '<img src="http://chart.apis.google.com/chart?chs='.$widhtHeight.'x'.$widhtHeight.'&cht=qr&chld=L|0&chl='.$chl.'" alt="QR code" widhtHeight="'.$widhtHeight.'" widhtHeight="'.$widhtHeight.'"/>';?>
                	
                <br><br>
                手机访问请扫描二维码
                </div>
            </div>
        </div>
    </div>
</div>
<script>
var project_publish_url = '<?=$this->createUrl('/pano/project/publish/', array('id'=>$project_id));?>';

</script>
