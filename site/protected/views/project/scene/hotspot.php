<div>
    <div class="input-box">
        <li>
            pan: <span id="hotspot_info_d_pan">0</span>
            tilt: <span id="hotspot_info_d_tilt">0</span>
            fov: <span id="hotspot_info_d_fov">90</span>
        </li>
        <li><span>热点类型：</span></li>
        <li>
            <select name="type" id="hotspot_info_d_type">
                <option value="1">image</option>
                <option value="2" selected="selected">swf</option>
                <option value="3">video</option>
            </select>
        </li>
        <li><span>链接场景：</span></li>
        <li>
            <table>
                <tr>
                    <td valign="top">
                    <select name="link_scene_id" id="hotspot_info_d_link_scene_id" onchange="change_hotspot_select()">
                        <option value="0">选择场景</option>
                        <?php if($datas['link_scene']){ foreach($datas['link_scene'] as $v){?>
                        <option value="<?=$v['id']?>"><?=$v['name']?></option>
                        <?php }}?>
                    </select>
                    </td>
                    <td>
                    <img src="" id="hotspot_pano_thumb" width="240" height="120">
                    </td>
                </tr>
            </table>
        </li>

        <li class="input-box-save">
            <a style="" class="button" href="javascript:;" onclick="save_hotspot_detail(<?=$datas['scene_id']?>)">保  存</a>
        	<span id="hotspot_save_msg"></span>
        </li>
    </div>
</div>
<script>
$("#hotspot_info_d_pan").html($("#hotspot_info_pan").html());
$("#hotspot_info_d_tilt").html($("#hotspot_info_tilt").html());
$("#hotspot_info_d_fov").html($("#hotspot_info_fov").html());

function change_hotspot_select(){
    var id = $('#hotspot_info_d_link_scene_id').val();
    var url = '<?php echo Yii::app()->createUrl('/panos/thumb/pic/', array('size'=>'240x120.jpg', 'id'=>''));?>/'+id;
    $('#hotspot_pano_thumb').attr('src', url);
}
</script>


