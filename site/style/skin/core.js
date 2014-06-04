win = {};
win.system = {};
win.system.changeWidth = function(from,id){
	$("#"+id).css("width", $(from).val()+"px");
}
win.system.changeHeight = function(from,id){
	$("#"+id).css("height", $(from).val()+"px");
}

win.buttonBar = {};
win.buttonBar.initButtonBar = function(){
	$(".button_bar_icon").dblclick(function(){
		if(!$("#button_bar_window").attr("id")){
			
			var button_bar_win = $("<div></div>");
			
			$("#lpanel").append(button_bar_win);
			$(button_bar_win).attr("id", "button_bar_window");
			$(button_bar_win).attr("class", "button_bar_window");
			$( "#button_bar_window" ).draggable({cursor: "move", containment: "#lpanel", scroll: false});	
			$( "#button_bar_window" ).dblclick(win.buttonBar.windowClick);
		}
		var new_button_bar = $("<div></div>");
		var new_id = "r"+$(this).attr("id");
		$(new_button_bar).attr("id", new_id);
		$(new_button_bar).attr("class", $(this).attr("class"));
		$(new_button_bar).attr("style", $(this).attr("style"));
		
		$("#button_bar_window").append(new_button_bar);
		$("#"+new_id).click(win.buttonBar.buttonClick);
		
		$( "#"+new_id ).draggable({cursor: "move", containment: "#button_bar_window", scroll: false});
		$(this).unbind("dblclick");
		
	});
}
win.buttonBar.windowClick = function(){
	$( "#rselector_4" ).accordion({ active: 1 });
}
win.buttonBar.buttonClick = function(){
	$( "#rselector_4" ).accordion({ active: 2 });
}
