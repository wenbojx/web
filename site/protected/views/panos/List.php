<div class="panolist">
<br>
<h3>全景列表</h3>
<?php if(isset($datas['list'])){ foreach($datas['list'] as $v){?>
    <div class="panodetail">
    	<a href="<?=$this->createUrl('/panos/pano/show/', array('id'=>$v['id']));?>" target="_blank">
    	<img src="<?=$this->createUrl('/panos/thumb/pic/', array('id'=>$v['id'], 'size'=>'240x120.jpg'));?>" width="240"/>
    	</a>
    	<?=$v['name']?>
	</div>
<?php }}?>
</div>