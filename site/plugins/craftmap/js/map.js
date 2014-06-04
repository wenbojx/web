var map_container = "imgContent";
	var map_width = 1000;
	var map_height = 800;
function bind_map(class_name, click){
	return $('.'+class_name).craftmap({
		image: {
			width: map_width,
			height: map_height
		},
		container: {
			name: map_container,
			id: map_container
		},
		marker: {
			name: 'marker',
			center: false,
			popup: false,
			move: false,
			onClick: function(marker, popup){
				jump_to_new_scene(marker);
			},
		}
	});
}
function move_to_marker(id){
	var markers = $("div[id^='markers_"+id+"_']");
	var marker = null;
	$(markers).each(function(){
		marker = $(this);
	});
	if(!$(markers).attr('id')){
		return false;
	}
	var data_coords = $(marker).attr('data-coords');
	if(!data_coords){
		return false;
	}
	
	var position_split = data_coords.split(',');
	var left = position_split[0];
	var top = position_split[1];
	
	var container_left = $("#"+map_container).css('left').replace('px','');
	var container_top = $("#"+map_container).css('top').replace('px','');
	
	var container_width =  $("#"+map_container).css('width').replace('px','');
	var container_height =  $("#"+map_container).css('height').replace('px','');
	var box_width = $("#"+box_marker).css('width').replace('px','');
	var box_height = $("#"+box_marker).css('height').replace('px','');

	left = -parseInt(left)+parseInt(box_width)/2;
	top = -parseInt(top)+parseInt(box_height)/2-10;
	var minWidth = container_width - box_width;
	var minHeight = container_height - box_height;
	
	if(left<-minWidth){
		left = -minWidth;
	}
	if(top<-minHeight){
		top = -minHeight;
	}
	if(top>0){
		top = 0;
	}
	if(left>0){
		left = 0;
	}
	
	animate = {
			top: top,
			left: left
		};
	change_marker_style(id);
	$("#"+map_container).animate(animate);
	
	
}
function change_marker_style(scene_id){
	var all_markers = $("div[id^='markers_']");
	$(all_markers).each(function(){
		$(this).addClass('marker');
		$(this).removeClass('marker_red');
	});
	var resent_markers = $("div[id^='markers_"+scene_id+"_']");
	$(resent_markers).each(function(){
		$(this).addClass('marker_red');
		$(this).removeClass('marker');
	});
}
function jump_to_new_scene(marker){
	var id_str = $(marker).attr('id');
	if(!id_str){
		return false;
	}
	var id_str_split = id_str.split('_');
	var id = id_str_split[1];
	if(id){
		var url = page_url+'/id/'+id+'/map/1';
		if(mobile){
			url = page_url+'/s/'+id+'/?m=1';
		}
		jump_to(url);
	}
}


