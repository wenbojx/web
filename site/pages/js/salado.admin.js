function thumb_box_upload(){
    var post_datas = {'scene_id':scene_id,'from':'thumb_pic','SESSION_ID':session_id};
    $("#thumb_box_upload").uploadify({
        'swf': flash_url,
        'uploader': thumb_upload_url,
        'formData': post_datas,
        //'uploadLimit':1,
        'buttonText':'上传全景图',
        'debug':false,
        'width':107,
        'height':34,
        'fileSizeLimit':'5242880KB',
        'fileTypeDesc' : 'jpg,png,gif格式',
        'fileTypeExts':'*.jpg;*.png;*.gif;',
        'buttonImage':thumb_button_img,
        'multi': false,
        'removeTimeout':1,
        'auto': true,
        'onSelectError':function(file){
        },
        'onUploadError':function(file){
        },
        'onUploadSuccess':function(file, data, response){
            var dataObj = eval("("+data+")");
            if(dataObj.status == '0'){
                alert(dataObj.msg);
            }
            else if(response>0){
                var url = pic_url+'/id/'+dataObj.file+'/size/480x240.jpg';
                var img_str = '<img width="480" height="240" src="'+url+'"/>';
                $("#thumb_img").html(img_str);
            }
        }
    });
}
function init_box_upload( position){
    //var img_w = 800;
    //var img_h = 800;
    var img_btn_w = 150;
    var img_btn_h = 150;
    var button_img = $("#box_"+position).attr('src');
    var post_datas = {'position':position,'scene_id':scene_id,'from':'box_pic','SESSION_ID':session_id};
    $("#box_"+position).uploadify({
        'swf': flash_url,
        'uploader': script_url,
        'formData': post_datas,
        //'uploadLimit':1,
        'buttonText':'上传',
        'debug':false,
        'width':img_btn_w,
        'height':img_btn_h,
        'fileSizeLimit':'5242880KB',
        'fileTypeDesc' : 'jpg,png,gif格式',
        'fileTypeExts':'*.jpg;*.png;*.gif;',
        'buttonImage':button_img,
        'multi': false,
        'removeTimeout':1,
        'auto': true,
        'onSelect':function(file){
            change_z_index(500,400);
        },
        'onSelectError':function(file){
            change_z_index(400,500);
        },
        'onUploadError':function(file){
            change_z_index(400,500);
        },
        'onUploadSuccess':function(file, data, response){
            var dataObj = eval("("+data+")");
            if(dataObj.status == '0'){
                alert(dataObj.msg);
            }
            else if(response>0){
                var url = pic_url+'/id/'+dataObj.file+"/size/"+img_btn_w+"x"+img_btn_h+'.jpg';
                //button_img = url;
                $("#"+file.id).hide();
                var img_str = '<img width="'+img_btn_w+'" height="'+img_btn_h+'" id="box_'+position+'" src="'+url+'"/>';
                $("#box_side_"+position).html(img_str);
                init_box_upload(position);
                $("#box_"+position+"-queue").hide();
            }
            change_z_index(400,500);
        }
    });
    function change_z_index(cap1, cap2){
        $("#box_"+position+"-queue").css('z-index', cap1);
        $("#box_"+position).css('z-index', cap2);
    }
}
function on_reset_windows(){
    hotspot_click();
}
function save_project(url){
    var msg = {};
    msg.error = '操作失败';
    msg.success = '操作成功';
    var element_id = 'save_project_msg';
    var data = {};
    data.name = $("#project_name").val();
    if(!data.name){
        done_error(element_id, '请输入项目名称')
        return false;
    }
    data.desc = $("#project_desc").val();
    save_datas(url, data, element_id, msg);
    //location.reload();
}
function save_scene(url){
    var msg = {};
    msg.error = '操作失败';
    msg.success = '操作成功';
    var element_id = 'save_scene_msg';
    var data = {};
    data.name = $("#scene_name").val();
    data.project_id = $("#project_id").val();
    if(!data.name){
        done_error(element_id, '请输入场景名称')
        return false;
    }
    if(!data.project_id){
        done_error(element_id, '参数错误')
        return false;
    }
    data.desc = $("#scene_desc").val();
    data.photo_time = $("#scene_photo_time").val();
    save_datas(url, data, element_id, msg);
}
function bind_scene_btn(){
    $('#scene_conf_positon').bind('click',function(){
        loadModalWin('showmodel_positon',position_url, '位置', 700, 400);
    });
    $('#scene_conf_basic').bind('click',function(){
        loadModalWin('showmodel_basic',basic_url, '基本信息', 200, 150);
    });
    $('#scene_conf_preview').bind('click',function(){
        loadModalWin('showmodel_preview',preview_url, '预览', 400, 300);
    });
    $('#scene_conf_thumb').bind('click',function(){
        loadModalWin('showmodel_thumb',thumb_url, '缩略图', 500, 320);
    });
    $('#scene_conf_camera').bind('click',function(){
        //loadModalWin('showmodel_view',view_url, '视图', 400, 300);
        pano_camera_click();
    });
    $('#scene_conf_hotspot_btn').bind('click',function(){
        loadModalWin('showmodel_hotspot',hotspot_url, '热点', 400, 300);
    });
    $('#scene_conf_hotspot').bind('click',function(){
        hotspot_click();
    });
    $('#scene_conf_button').bind('click',function(){
        loadModalWin('showmodel_button',button_url, '按钮', 400, 300);
    });
    $('#scene_conf_map').bind('click',function(){
        loadModalWin('showmodel_map',map_url, '地图', 400, 300);
    });
    $('#scene_conf_navigat').bind('click',function(){
        loadModalWin('showmodel_navigat',navigat_url, '导航', 400, 300);
    });
    $('#scene_conf_radar').bind('click',function(){
        loadModalWin('showmodel_radar',radar_url, '雷达', 400, 300);
    });
    $('#scene_conf_html').bind('click',function(){
        loadModalWin('showmodel_html',html_url, 'Html', 400, 300);
    });
    $('#scene_conf_rightkey').bind('click',function(){
        loadModalWin('showmodel_rightkey',rightkey_url, '右键', 400, 300);
    });
    $('#scene_conf_link').bind('click',function(){
        loadModalWin('showmodel_link',link_url, '场景链接', 400, 300);
    });
    $('#scene_conf_flare').bind('click',function(){
        loadModalWin('showmodel_flare',flare_url, '眩光', 400, 300);
    });
    $('#scene_conf_action').bind('click',function(){
        loadModalWin('showmodel_action',action_url, '动作', 400, 300);
    });
}

function onViewChange(pan, tilt, fov, direction){
    if(!$("#detail-hotspot").is(":hidden")){
        $("#hotspot_info_pan").html(pan);
        $("#hotspot_info_tilt").html(tilt);
        $("#hotspot_info_fov").html(fov);
        if($("#hotspot_info_d_pan")){
            $("#hotspot_info_d_pan").html(pan);
            $("#hotspot_info_d_tilt").html(tilt);
            $("#hotspot_info_d_fov").html(fov);
        }
    }

    $("#camera-info-pan").html(pan);
    $("#camera-info-tilt").html(tilt);
    $("#camera-info-fov").html(fov);
}

function hotspot_click(){
    if($("#detail-hotspot").is(":hidden")){
        var img_width = $("#detail-hotspot").css("width");
        var img_height = $("#detail-hotspot").css("height");
        var box_width = $("#js_data_list_outer").css("width");
        var box_height = $("#js_data_list_outer").css("height");
        var top = (parseInt(box_height)-parseInt(img_height) )/2;
        var left = (parseInt(box_width)-parseInt(img_width) )/2;
        $("#detail-hotspot").css("top",top+"px");
        $("#detail-hotspot").css("left",left+"px");
        pano_hide_other("detail-hotspot");
        $("#detail-hotspot").show();
        $("#detail-hotspot-tip").show();
    }
    else{
        $("#detail-hotspot").hide();
        $("#detail-hotspot-tip").hide();
    }
}
function pano_camera_click(){
    if($("#detail-pano-camera").is(":hidden")){
        pano_hide_other("detail-pano-camera");
        $("#detail-pano-camera").show();
    }
    else{
        $("#detail-pano-camera").hide();
    }
}
function pano_hide_other(node){
    if(node == 'detail-pano-camera'){
        $("#detail-hotspot").hide();
        $("#detail-hotspot-tip").hide();
    }
    if(node == 'detail-hotspot'){
        $("#detail-pano-camera").hide();
    }
}

function save_position_detail(scene_id){
    var msg = {};
    msg.error = '操作失败';
    msg.success = '操作成功';
    var element_id = 'position_save_msg';
    if(!scene_id){
        done_error(element_id, msg.error);
    }
    var data = {};
    data.glng = parseFloat ($("#span_lng").html());
    data.glat = parseFloat ($("#span_lat").html());
    data.zoom = parseInt ($("#span_zoom").html());
    data.scene_id = scene_id;

    var url = save_module_datas_url+'/position/save/';
    save_datas(url, data, element_id, msg, add_info);
    function add_info(){
        alert(1);
    }
}
function save_camera_detail(scene_id){
    var msg = {};
    msg.error = '操作失败';
    msg.success = '操作成功';
    var element_id = 'camera_save_msg';
    if(!scene_id){
        done_error(element_id, msg.error);
    }
    var data = {};
    data.pan = parseInt ($("#camera-info-pan").html());
    data.tilt = parseInt ($("#camera-info-tilt").html());
    data.fov = parseInt ($("#camera-info-fov").html());
    data.scene_id = scene_id;

    var url = save_module_datas_url+'/global/camera/';
    save_datas(url, data, element_id, msg);
}
function save_hotspot_detail(scene_id){
    var msg = {};
    msg.error = '操作失败';
    msg.success = '操作成功';
    var element_id = 'hotspot_save_msg';
    if(!scene_id){
        done_error(element_id, msg.error);
    }
    var data = {};
    data.pan = parseInt ($("#hotspot_info_d_pan").html());
    data.tilt = parseInt ($("#hotspot_info_d_tilt").html());
    data.fov = parseInt ($("#hotspot_info_d_fov").html());
    data.type = $("#hotspot_info_d_type").val();
    data.link_scene_id = $("#hotspot_info_d_link_scene_id").val();
    data.scene_id = scene_id;
    var url = save_module_datas_url+'/hotspot/save/';
    save_datas(url, data, element_id, msg);
}
function publish_scene(scene_id, display){
    var msg = {};
    msg.error = '操作失败';
    msg.success = '操作成功';
    var element_id = 'publish_scene_msg';
    if(!scene_id){
        done_error(element_id, msg.error);
    }
    var data = {};
    data.scene_id = scene_id;
    data.display = display;
    var url = scene_publish_url;
    save_datas(url, data, element_id, msg);
}










