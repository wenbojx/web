var map_container = "imgContent";
	var map_width = 1000;
	var map_height = 800;

	function add_marker(){
		var scene_id = $("#scenes_list").val();
		var half_w = parseInt($("#map_container").css('width'))/2;
		var half_h = parseInt($("#map_container").css('height'))/2;
		var con_top = 0-parseInt($("#"+map_container).css('top'))-20;
		var con_left = 0-parseInt($("#"+map_container).css('left'));
		var top = half_h+con_top;
		var left = half_w+con_left;
		var title = $("#scenes_list").find("option:selected").text();
		var marker = $('<div />').attr('title', title).attr('id','marker_'+scene_id).addClass('marker_green').attr('data-coords', top+", "+left);
		$(marker).css('position','absolute').css('z-index', 2).css('top', top).css('left', left);
		$("#"+map_container).prepend(marker);
		marker_obj = marker;	
		marker_del_save_display();
		
		$(marker).bind({
			mousedown: function(e){
				currentElement = this;
				xmousedown(e);
				var marker_obj = $(this);
				marker_mousedown(marker);
				//S.marker.mouseDown.call(this, marker_obj);
			},
			mousemove: function(e){
				xmousemove(e);
				
				return false;
			},
			mouseup: function(e){
				var pos = xmouseup(e);
				var marker_obj = $(this);
				return false;
			}
		});
	}

function marker_mousedown(marker){
	$(marker).addClass('marker_green');
	$(marker).removeClass('marker');
	var id = $(marker).attr('id');
	if(marker_obj && $(marker_obj).attr('id')!=$(marker).attr('id')){
		$(marker_obj).addClass('marker');
		$(marker_obj).removeClass('marker_green');
	}
	//$(marker).css('cursor','move');
	marker_obj = marker;
	marker_del_save_display();
	return true;
}
function marker_mouseup(marker){
	//$(marker).addClass('marker');
	//$(marker).removeClass('marker_green');
	//$(marker).css('cursor','pointer');
}


function bind_map(class_name){
	$('.'+class_name).craftmap({
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
			move: true,
			onClick: function(marker, popup){
				//alert($(marker).attr('id'));
			},
			mouseDown: function(marker){
				marker_mousedown(marker);
			},
			mouseUp: function(marker, pos){
				//marker_mouseup(marker);
			}
		}
	});
}
