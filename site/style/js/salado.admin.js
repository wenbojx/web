$(document).ready(function() {
    bind_pano_btn();
})
var load_page_name = null;
function bind_pano_btn(){
    $('#btn_review').bind('click',function(){
        clean_pano_cache();
    });
    $('#btn_upload').bind('click',function(){
        load_page(upload_pano_url, 'face');
    });
    $('#btn_position').bind('click',function(){
        load_page(position_url, 'position');
    });
    $('#btn_thumb').bind('click',function(){
        load_page(thumb_url, 'thumb');
    });
    $('#btn_camera').bind('click',function(){
    	load_page(camera_url, 'camera');
    });
    $('#btn_perspect').bind('click',function(){
    	load_page(perspect_url, 'perspect');
    });
    $('#btn_compass').bind('click',function(){
    	load_page(compass_url, 'compass');
    	compass_click();
    });
    $('#btn_map').bind('click',function(){
        load_page(map_url, 'map');
    });
    $('#btn_hotspot').bind('click',function(){
        load_page(hotspot_url, 'hotspot');
        hotspot_click();
    });
    $('#btn_image').bind('click',function(){
        load_page(image_url, 'image');
        image_hotspot_click();
    });
    $('#btn_music').bind('click',function(){
        load_page(music_url, 'music');
    });
    $('#btn_pad').bind('click',function(){
    	if ($("#pano-detail").is(":hidden")){
    		$("#pano-detail").show();
    		$("#btn_pad").html("隐藏");
    	}
    	else{
    		$("#pano-detail").hide();
    		$("#btn_pad").html("展开");
    	}
    });
    $('#btn_preview').bind('click',function(){
    	//clean_cache();
    	jump_to(preview_url, 'blank');
    });

}
function clean_cache(){
    var data = {};
    data.sid = scene_id;
    data.type = 'single';
    var url = clean_single_url;
    save_datas(url, data, '', '', call_back);
    function call_back(datas){
    }
    
}
function pano_upload_change(type){
	if(type==1){
		$("#pano_upload").show();
		$("#cube_upload_box").hide();
		$("#cube_upload_tab").removeClass ("active");
		$("#pano_upload_tab").addClass ("active");
	}
	else{
		$("#pano_upload").hide();
		$("#cube_upload_box").show();
		$("#pano_upload_tab").removeClass ("active");
		$("#cube_upload_tab").addClass ("active");
	}
}

function clean_pano_cache(){
     window.location.href= clean_url;
}
function load_page(url, load_page){
    var ajax = {url: url, type: 'GET', dataType: 'html', cache: false, success: function(html) {
		    	if(load_page_name != load_page){
					$("#panel_"+load_page_name).hide();
				}
    			if($("#panel_"+load_page).attr('id')){
    				$("#panel_"+load_page).show();
    			}
    			else{
    				$("#panel_box").append(html);
    			}
    			
                show_edit_panel();
                load_page_name = load_page;
                return true;
            }
        };
    $.ajax(ajax);
}
function hide_edit_panel(){
    $('#edit_panel').hide();
}
function show_edit_panel(){
    $('#edit_panel').show();
}
var intervalProcess = null;
function pano_box_upload(){
    var post_datas = {'scene_id':scene_id,'from':'pano_pic','SESSION_ID':session_id};
    $("#pano_upload_bt").uploadify({
        'swf': flash_url,
        'uploader': script_url,
        'formData': post_datas,
        //'uploadLimit':1,
        'buttonText':'上传全景图',
        'debug':false,
        'width':76,
        'height':30,
        'fileSizeLimit':'20480KB',
        'fileTypeDesc' : 'jpg,png,gif格式',
        'fileTypeExts':'*.jpg;*.png;*.gif;',
        'buttonImage':pano_button_img,
        'multi': false,
        'removeTimeout':1,
        'auto': true,
        'onSelectError':function(file){
        },
        'onUploadError':function(file){
        	//alert(file.id);
        },
        'onUploadSuccess':function(file, data, response){
            var dataObj = eval("("+data+")");
            if(dataObj.flag == '0'){
                alert(dataObj.msg);
            }
            else if(response>0){
            	var url = pano_small_path;
            	//$("#pano_show").html('');
            	var timestamp=new Date().getTime();
            	//alert(url);
            	var img_str = '<img width="400" height="200" src="'+url+'?'+timestamp+'"/>';
            	$("#pano_show").html(img_str);
            	$("#pano_state").show();
            	$("#pano_none").hide();
            	$("#cube_upload").hide();
            	intervalProcess = setInterval("check_pano_turn_state()", 10000);
            }
        }
    });
}
function check_pano_turn_state(){
    var data = {};
    data.scene_id = scene_id;
    var url = pano_state_url+'/panoPicState';
    save_datas(url, data, '', '', call_back);
    function call_back(datas){
        if(datas.state == '0'){
        	alert(datas.msg);
        }
        else if (datas.state =='1'){
        	clearInterval(intervalProcess);
        	$("#box_left").attr('src', '');
        }
    }
}

var marker_obj = null;
function show_marker_comfirm(){
	$('#pano_marker').show();
	$('#marker_confirm').show();
	$("#marker_delete").hide();
	$("#marker_save").hide();
}
function save_marker(){
	var top = $(marker_obj).css('top');
	var left =  $(marker_obj).css('left');
	
	var msg = {};
    msg.error = '操作失败';
    msg.success = '操作成功';
    var data = {};
    
    var marker_id = $(marker_obj).attr('id');
	var id_split = marker_id.split('_');
	if(id_split[0] != 'marker'){
		return false;
	}
	data.link_scene_id = id_split[1];
	
    data.project_id = project_id;
    data.scene_id = scene_id;
    data.map_id = map_id;
    data.top = top.replace('px','');
    data.left = left.replace('px','');

    if(!data.map_id || !data.project_id){
    	alert('参数错误');
    	return false;
    }
    var url = save_map_marker_url+'/save/';
    save_datas(url, data, '', '', call_back);
    function call_back(datas){
        alert(datas.msg);
        show_marker_comfirm();
        if(datas.flag == '1'){
        	$(marker_obj).attr('id', 'markers_'+datas.id);
        }
    }
}
function del_marker(){
	if(!confirm("确定删除吗")){
		return false;
	}
	var data = {};
	var marker_id = $(marker_obj).attr('id');
	var id_split = marker_id.split('_');
	if(id_split[0] == 'marker'){
		del_marker_do();
		return false;
	}
	var position_id = id_split[1];
	if(!position_id){
		alert('参数错误');
		return false;
	}
	data.id = position_id;
	data.project_id = project_id;
	var url = save_map_marker_url+'/del/';
    save_datas(url, data, '', '', call_back);
    function call_back(datas){
    	//alert(datas.msg);
    	if(!datas.flag){
    		return false;
    	}
    	del_marker_do();
    }
}
function del_marker_do(){
	$(marker_obj).remove();
	$("#marker_save").hide();
	$("#marker_delete").hide();
}
function marker_del_save_display(){
	$("#pano_marker").hide();
	$("#marker_confirm").hide();
	$("#marker_delete").show();
	
	var marker_id = $(marker_obj).attr('id');
	var id_split = marker_id.split('_');
	if(id_split[0] == 'marker'){
		$("#marker_save").show();
	}
	else{
		$("#marker_save").hide();
	}
}


function map_box_upload(){
    var post_datas = {'scene_id':scene_id, 'project_id':project_id, 'from':'map_pic','SESSION_ID':session_id};
    $("#map_box_upload").uploadify({
        'swf': flash_url,
        'uploader': map_upload_url,
        'formData': post_datas,
        //'uploadLimit':1,
        'buttonText':'上传地图',
        'debug':false,
        'width':74,
        'height':28,
        'fileSizeLimit':'1024KB',
        'fileTypeDesc' : 'jpg,png,gif格式',
        'fileTypeExts':'*.jpg;*.png;*.gif;',
        'buttonImage':map_button_img,
        'multi': false,
        'removeTimeout':1,
        'auto': true,
        'onSelectError':function(file){
        },
        'onUploadError':function(file,data){
        },
        'onUploadSuccess':function(file, data, response){
            var dataObj = eval("("+data+")");
            if(dataObj.flag == '0'){
                alert(dataObj.msg);
            }
            else if(response>0){
            	map_width = dataObj.w;
            	map_height = dataObj.h;
                var url = pic_url+'/id/'+dataObj.file+'/size/'+map_width+'x'+map_height+'.'+dataObj.type;
                var img_str = '<img src="'+url+'" class="imgMap"/>';
                $("#map_tips").hide();
                $("#map_container").html(img_str);
                bind_map('scene_map');
                $("#add_marker").show();
                $("#map_container").show();
                map_id = dataObj.id;
            }
        }
    });
}


function image_box_upload(){
    var post_datas = {'scene_id':scene_id, 'project_id':project_id, 'from':'image_pic','SESSION_ID':session_id};
    $("#image_box_upload").uploadify({
        'swf': flash_url,
        'uploader': image_upload_url,
        'formData': post_datas,
        //'uploadLimit':1,
        'buttonText':'上传图片',
        'debug':false,
        'width':74,
        'height':28,
        'fileSizeLimit':'2048KB',
        'fileTypeDesc' : 'jpg,png,gif格式',
        'fileTypeExts':'*.jpg;*.png;*.gif;',
        'buttonImage':image_button_img,
        'multi': false,
        'removeTimeout':1,
        'auto': true,
        'onSelectError':function(file){
        },
        'onUploadError':function(file,data){
        },
        'onUploadSuccess':function(file, data, response){
            var dataObj = eval("("+data+")");
            if(dataObj.flag == '0'){
                alert(dataObj.msg);
            }
            else if(response>0){
            	max_size = 350;
            	map_width = dataObj.w;
            	map_height = dataObj.h;
            	if(map_width >= map_height){
            		zoom = max_size/map_width;
            		map_width = max_size;
            		map_height = map_height * zoom;
            	}
            	else{
            		zoom = max_size/map_height;
            		map_height = max_size;
            		map_width = map_width * zoom;
            	}
                var url = pic_url+'/id/'+dataObj.file+'/size/'+parseInt(map_width)+'x'+parseInt(map_height)+'.'+dataObj.type;
                //alert(url);
                var img_str = '<img src="'+url+'" class="imgMap"/>';
                $("#image_container").html(img_str);
                var file_id = dataObj.file_id;
                $("#image_file_id").val(file_id);
                $("#save_image_button_box").show();
            }
        }
    });
}

function music_box_upload(){
    var post_datas = {'scene_id':scene_id, 'project_id':project_id, 'from':'music','SESSION_ID':session_id};
    $("#music_box_upload").uploadify({
        'swf': flash_url,
        'uploader': music_upload_url,
        'formData': post_datas,
        //'uploadLimit':1,
        'buttonText':'上传音乐',
        'debug':false,
        'width':74,
        'height':28,
        'fileSizeLimit':'5120KB',
        'fileTypeDesc' : 'mp3,wav,wma格式',
        'fileTypeExts':'*.mp3;*.wav;*.wma',
        'buttonImage':music_button_img,
        'multi': false,
        'removeTimeout':1,
        'auto': true,
        'onSelectError':function(file){
        },
        'onUploadError':function(file,data){
        },
        'onUploadSuccess':function(file, data, response){
            var dataObj = eval("("+data+")");
            if(dataObj.flag == '0'){
                alert(dataObj.msg);
            }
            else if(response>0){
            	var file_id = dataObj.file_id;
            	$("#music_file_id").val(file_id);
            	$("#curent_music").html("当前音乐:"+dataObj.file_name);
            	$("#curent_music").show();
            }
        }
    });
}

function init_upload_box(){
	if(box_left != ""){
		$("#box_left").attr('src', box_left);
	}
	if(box_right != ""){
		$("#box_right").attr('src', box_right);
	}
	if(box_down != ""){
		$("#box_down").attr('src', box_down);
	}
	if(box_up != ""){
		$("#box_up").attr('src', box_up);
	}
	if(box_front != ""){
		$("#box_front").attr('src', box_front);
	}
	if(box_back != ""){
		$("#box_back").attr('src', box_back);
	}
	init_box_upload('left');
	init_box_upload('right');
	init_box_upload('down');
	init_box_upload('up');
	init_box_upload('front');
	init_box_upload('back');
}

function init_box_upload( position){
    //var img_w = 800;
    //var img_h = 800;
    var img_btn_w = 120;
    var img_btn_h = 120;
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
        'fileSizeLimit':'2048KB',
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
            if(dataObj.flag == '0'){
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
function hotspot_click(){
        var img_width = $("#hotspot_icon").css("width");
        var img_height = $("#hotspot_icon").css("height");
        var box_width = $("#pano-detail").css("width");
        var box_height = $("#pano-detail").css("height");
        img_width = img_width.replace('px','');
        img_height = img_height.replace('px','');
        img_width = 30;
        img_height = 30;

        box_width = box_width.replace('px','');
        box_height = box_height.replace('px','');
        
        var top = (parseInt(box_height)-parseInt(img_height) )/2;
        var left = (parseInt(box_width)-parseInt(img_width) )/2;
        $("#hotspot_icon").css("top",top+"px");
        $("#hotspot_icon").css("left",left+"px");
        $("#hotspot_icon").show();
        
        if($("#imagehotspot_icon") && !$("#imagehotspot_icon").is(":hidden")){
        	$("#imagehotspot_icon").hide();
        }
        if($("#compass_icon") && !$("#compass_icon").is(":hidden")){
        	$("#compass_icon").hide();
        }
}
function image_hotspot_click(){
	var img_width = $("#imagehotspot_icon").css("width");
    var img_height = $("#imagehotspot_icon").css("height");
    var box_width = $("#pano-detail").css("width");
    var box_height = $("#pano-detail").css("height");
    img_width = img_width.replace('px','');
    img_height = img_height.replace('px','');
    img_width = 30;
    img_height = 30;

    box_width = box_width.replace('px','');
    box_height = box_height.replace('px','');
    
    var top = (parseInt(box_height)-parseInt(img_height) )/2;
    var left = (parseInt(box_width)-parseInt(img_width) )/2;
    $("#imagehotspot_icon").css("top",top+"px");
    $("#imagehotspot_icon").css("left",left+"px");
    $("#imagehotspot_icon").show();
    if($("#hotspot_icon") && !$("#hotspot_icon").is(":hidden")){
    	$("#hotspot_icon").hide();
    }
    if($("#compass_icon") && !$("#compass_icon").is(":hidden")){
    	$("#compass_icon").hide();
    }
}
function compass_click(){
	var img_width = $("#compass_icon").css("width");
    var img_height = $("#compass_icon").css("height");
    var box_width = $("#pano-detail").css("width");
    var box_height = $("#pano-detail").css("height");
    img_width = img_width.replace('px','');
    img_height = img_height.replace('px','');
    img_width = 30;
    img_height = 30;

    box_width = box_width.replace('px','');
    box_height = box_height.replace('px','');
    
    var top = (parseInt(box_height)-parseInt(img_height) )/2;
    var left = (parseInt(box_width)-parseInt(img_width) )/2;
    $("#compass_icon").css("top",top+"px");
    $("#compass_icon").css("left",left+"px");
    $("#compass_icon").show();
    if($("#hotspot_icon") && !$("#hotspot_icon").is(":hidden")){
    	$("#hotspot_icon").hide();
    }
    if($("#imagehotspot_icon") && !$("#imagehotspot_icon").is(":hidden")){
    	$("#imagehotspot_icon").hide();
    }
}


function hide_hotspot_icon(){
    $("#hotspot_icon").hide();
}

function onViewChange(pan, tilt, fov, direction){
    if($("#hotspot_icon") && !$("#hotspot_icon").is(":hidden")){
        $("#hotspot_info_pan").html(pan);
        $("#hotspot_info_tilt").html(tilt);
        $("#hotspot_info_fov").html(fov);
    }
    if($("#imagehotspot_icon") && !$("#imagehotspot_icon").is(":hidden")){
        $("#imghotspot_info_pan").html(pan);
        $("#imghotspot_info_tilt").html(tilt);
        $("#imghotspot_info_fov").html(fov);
    }
    
    if($("#camera-info-pan")){
        $("#camera-info-pan").html(pan);
        $("#camera-info-tilt").html(tilt);
        $("#camera-info-fov").html(fov);
    }
    
    if($("#perspect-info-pan")){
        $("#perspect-info-pan").html(pan);
        $("#perspect-info-tilt").html(tilt);
    }
    
    if($("#compass-info-pan")){
    	if(pan>0){
    		pan = 360-pan;
    	}
    	else{
    		pan = 0-pan;
    	}
        $("#compass-info-pan").html(pan);
        //$("#compass-info-tilt").html(tilt);
       // $("#compass-info-fov").html(fov);
        
    }
    
}

function save_thumb_datas(){
	var pos = getcutpos();
	if(!pos){
		alert("数据出错");
		return false;
	}
	var recommend = $("#recommend").attr("checked") ? '1' : '0';
	 //var post_datas = {'scene_id':scene_id, 'from':'thumb_pic', 'pos':pos, 'recommend':recommend};
	 var msg = {};
	    msg.error = '操作失败';
	    msg.success = '操作成功';
	    var element_id = 'position_save_msg';
	    if(!scene_id){
	        done_error(element_id, msg.error);
	    }
	    var data = {};
	    data.from = 'thumb_pic';
	    data.pos = pos;
	    data.scene_id = scene_id;
	    data.recommend = recommend;

	    var url = thumb_upload_url;
	    save_datas(url, data, '', '', call_back);
	    function call_back(datas){
	    	if(datas.flag){
	    		var timestamp=new Date().getTime();
	    		$path = thumb_url + "?" +timestamp;
	    		$("#thumb_pic").attr('src', $path);
	    	}
	    	else{
	    		alert(datas.msg);
	    	}
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
    save_datas(url, data, '', '', call_back);
    function call_back(datas){
        alert(datas.msg);
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
    save_datas(url, data, '', '', call_back);
    function call_back(datas){
        alert(datas.msg);
    }
}
function save_perspect_detail(scene_id){
    var msg = {};
    msg.error = '操作失败';
    msg.success = '操作成功';
    var element_id = 'save_perspect_tip_flag';
    if(!scene_id){
        done_error(element_id, msg.error);
    }
    var data = {};
    data.maxPan = parseInt ($("#maxPan").val());
    data.minPan = parseInt ($("#minPan").val());
    data.maxTilt = parseInt ($("#maxTilt").val());
    data.minTilt = parseInt ($("#minTilt").val());
    if(data.maxPan<0 || data.maxPan>180){
    	alert("水平最大角度设置有误");
    	return false;
    }
    if(data.minPan>0 || data.minPan<-180){
    	alert("水平最小角度设置有误");
    	return false;
    }
    if(data.maxTilt<0 || data.maxTilt>90){
    	alert("垂直最大角度设置有误");
    	return false;
    }
    if(data.minTilt>0 || data.minTilt<-90){
    	alert("垂直最小角度设置有误");
    	return false;
    }
    data.scene_id = scene_id;

    var url = save_module_datas_url+'/global/perspect/';
    save_datas(url, data, '', '', call_back);
    function call_back(datas){
        alert(datas.msg);
    }
}
function save_compass_detail(scene_id){
    var msg = {};
    msg.error = '操作失败';
    msg.success = '操作成功';
    var element_id = 'compass_save_msg';
    if(!scene_id){
        done_error(element_id, msg.error);
    }
    var data = {};
    data.pan = parseInt ($("#compass-info-pan").html());
    data.scene_id = scene_id;

    var url = save_module_datas_url+'/global/compass/';
    save_datas(url, data, '', '', call_back);
    function call_back(datas){
        alert(datas.msg);
    }
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
    data.pan = parseInt ($("#hotspot_info_pan").html());
    data.tilt = parseInt ($("#hotspot_info_tilt").html());
    data.fov = parseInt ($("#hotspot_info_fov").html());
    data.type = $("#hotspot_info_d_type").val();
    data.transform = $("#hotspot_angle_select").val();
    data.link_scene_id = $("#hotspot_info_d_link_scene_id").val();
    data.scene_id = scene_id;
    if(data.link_scene_id == '0'){
    	alert('请选择目标场景');
    	return false;
    }
    var url = $("#save_hotspot").attr('action');
    save_datas(url, data, '', '', call_back);
    function call_back(datas){
        alert(datas.msg);
    }
}

function save_music_detail(scene_id){
    var msg = {};
    msg.error = '操作失败';
    msg.success = '操作成功';
    var element_id = 'save_music_tip_flag';
    if(!scene_id){
        done_error(element_id, msg.error);
    }
    var data = {};
    data.file_id = $("#music_file_id").val();
    data.volume = $("#volume").val();
    data.loop = $("#loop").val();
    data.state = $("#music_state").val();
    data.music_id = $("#music_id").val();
    data.scene_id = scene_id;
    if(data.link_scene_id == '0'){
    	alert('参数错误');
    	return false;
    }
    if(data.file_id == ''){
    	alert('请先上传背景音乐');
    	return false;
    }
    var url = $("#save_music").attr('action');
    save_datas(url, data, '', '', call_back);
    function call_back(datas){
        alert(datas.msg);
    }
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
    save_datas(url, data, '', '', call_back);
    function call_back(datas){
        alert(datas.msg);
        if(display == '2' && datas.flag){
        	$("#offline_pano").show();
        	$("#online_pano").hide();
        }
        if(display == '1' && datas.flag){
        	$("#online_pano").show();
        	$("#offline_pano").hide();
        }
    }
}

function publish_project(project_id, display){
	if(!project_id){
		alert("参数错误");
		return false;
	}
    var msg = {};
    msg.error = '操作失败';
    msg.success = '操作成功';

    var data = {};
    data.project_id = project_id;
    data.display = display;
    var url = project_publish_url;
    save_datas(url, data, '', '', call_back);
    function call_back(datas){
        alert(datas.msg);
        if(display == '2' && datas.flag){
        	$("#offline_project").show();
        	$("#online_project").hide();
        }
        if(display == '1' && datas.flag){
        	$("#online_project").show();
        	$("#offline_project").hide();
        }
    }
}

function change_hotspot_select(){
    var id = $('#hotspot_info_d_link_scene_id').val();
    
    //var url = panos_thumb_url+'/id/'+id+'/size/'+size;
    var url = pano_thumb_url_array[id];
    $('#hotspot_pano_thumb').attr('src', url);
}
function change_hotspot_angle(){
	var num = $("#hotspot_angle_select").val();
	var src = hotspot_img_pre+'hotspot-'+num+'.png';
	$("#hotspot_angle").attr("src", src);
	$("#hotspot_icon_img").attr("src", src);
}
function edit_hotspot(id){
	var edit_url = hotspot_edit_url+'/hotspot_id/'+id;
	load_page(edit_url, 'hotspotEdit');
}
function edit_imghotspot(id){
	var edit_url = imghotspot_edit_url+'/hotspot_id/'+id+'/scene_id/'+scene_id;
	load_page(edit_url, 'imageEdit');
}
function hotspot_del(hotspot_id){
	var msg = {};
    msg.error = '操作失败';
    msg.success = '操作成功';
    var element_id = 'hotspot_del_msg';
    var data = {};
    data.hotspot_id = hotspot_id;
    if(!data.hotspot_id){
    	alert('参数错误');
    	return false;
    }
    var url = $("#del_hotspot").attr('action');
    save_datas(url, data, '', '', call_back);
    function call_back(datas){
        alert(datas.msg);
    }
}
function image_hotspot_del(hotspot_id){
	var msg = {};
    msg.error = '操作失败';
    msg.success = '操作成功';
    var data = {};
    data.hotspot_id = hotspot_id;
    if(!data.hotspot_id){
    	alert('参数错误');
    	return false;
    }
    var url = $("#del_imghotspot").attr('action');
    save_datas(url, data, '', '', call_back);
    function call_back(datas){
        alert(datas.msg);
    }
}

function save_image_info(){
	var msg = {};
    msg.error = '操作失败';
    msg.success = '操作成功';
    //var element_id = 'hotspot_del_msg';
    var data = {};
    data.scene_id = scene_id;
    data.pan = parseInt ($("#imghotspot_info_pan").html());
    data.tilt = parseInt ($("#imghotspot_info_tilt").html());
    data.fov = parseInt ($("#imghotspot_info_fov").html());
    data.file_id = parseInt ($("#image_file_id").val());
    if(!data.scene_id){
    	alert('参数错误');
    	return false;
    }
    var url = $("#save_image_form").attr('action');
    save_datas(url, data, '', '', call_back);
    function call_back(datas){
        alert(datas.msg);
    }
}

