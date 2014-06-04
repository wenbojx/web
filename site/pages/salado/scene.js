function load_scene(box_id, scene_xml, player_url,wmode ){
	if(!wmode){
		wmode = 'Window';
	}
    var flashvars = {};
    flashvars.xml = scene_xml;
    var params = {};
    params.menu = "false";
    params.quality = "high";
    params.wmode = wmode;
    params.allowfullscreen = "true";
    swfobject.embedSWF(player_url, box_id, "100%", "100%", "10.1.0", "", flashvars, params);
}