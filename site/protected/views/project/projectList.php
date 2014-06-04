<div id="js_cantain_box" class="col-main">
        <div style="z-index:9998;" class="directory-path">
                <div rel="page_local" class="path-contents">
                    <a title="项目" href="javascript:;">项目</a>
                    <i>»</i><em>&nbsp;</em>
                </div>
        </div>
                <div id="js_data_list_outer" class="page-list">
                    <div id="js_data_list" style="min-height: 100%; cursor: default; background: none repeat scroll 0% 0% rgb(255, 255, 255);">
                    <ul style="overflow: hidden;_zoom: 1;" id="js_data_list_inner" rel="list">
                        <?php if(isset($datas['list'])){ foreach($datas['list'] as $v){?>
                            <li title="" index="1">
                                <input type="checkbox" style="" value="2161672">
                                <div class="checkbox"></div>
                                <div style="position:absolute;top:0;left:0;width:34px;height:50px;"></div>
                                <i class="file-type tp-folder"></i>
                                <div class="file-name">
                                   <?php echo CHtml::link($v['name'],array('project/SceneList/list','id'=>$v['id']));?>
                                </div>
                                <div class="file-info"><em>2012-07-30</em> </div>
                                <!-- <div class="file-opt">
                                    <a title="分享"  class="i-share" href="javascript:;">分享</a>
                                    <a title="更多" menu="more_btn" class="i-more" href="javascript:;">更多</a>
                                </div> -->
                            </li>
                        <?php }}?>
                        </ul>
                    </div>
                </div>
                <div class="page-footer">
                    <div class="pagination">
                    <?php if(isset($datas['pages'])){  $this->widget('CLinkPager',array(
                        'header'=>'',
                        'firstPageLabel' => '首页',
                        'lastPageLabel' => '末页',
                        'prevPageLabel' => '上一页',
                        'nextPageLabel' => '下一页',
                        'pages' => $datas['pages'],
                        'maxButtonCount'=>10
                        )
                    );}?>
                    </div>
                </div>
    </div>
    <div class="col-sub">
        <div class="new-p-btn">
        <a onclick="loadModalWin('showmodel_project','<?=$this->createUrl('/project/projectEdit/add/')?>', '新建项目', 300, 280)" href="javascript:;">新建项目</a>
        </div>
    </div>
<div id="showmodel_project" style="display: none"></div>


