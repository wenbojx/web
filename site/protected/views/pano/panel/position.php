<style>
#map_canvas {
	width: 815px;
	height: 400px;
}
#search-panel {
        position: absolute;
        top: 5px;
        left: 50%;
        margin-left: -180px;
        width: 350px;
        z-index: 5;
        background-color: #fff;
        padding: 5px;
        border: 1px solid #999;
      }
      #target {
        width: 345px;
      }
</style>
<div class="panel_box_content" id="panel_position">
	<div class="panel_title">
		<div class="title-bar">
			<span>地理位置</span>
			<div class="title_tip">
				经度：<span id="span_lng"><?=$datas['position']['glng']?> </span>&nbsp;
				纬度：<span id="span_lat"><?=$datas['position']['glat']?> </span>&nbsp;
				视图高度：<span id="span_zoom"><?=$datas['position']['gzoom']?> </span>&nbsp;&nbsp;&nbsp;&nbsp;
				<span id="position_save_msg"></span> <span
					class="label label-warning"
					onclick="save_position_detail(<?=$datas['scene_id']?>)">保存信息</span>

			</div>
		</div>
		<div class="panel_close" onclick="hide_edit_panel()">X</div>
	</div>
	<div class="panle_content" style="height: 400px; width: 815px;">
	
		<div id="map_canvas"></div>
	</div>
</div>

<script>
var glng = '<?=$datas['position']['glng']?>';
var glat = '<?=$datas['position']['glat']?>';
var gzoom = '<?=$datas['position']['gzoom']?>';
var map = null;
$(document).ready(function(){

	  
  map = new GMaps({
    div: '#map_canvas',
    lat: glat,
    lng: glng,
    zoom:parseInt(gzoom),
    width:815,
    height:400,
    
  	dragend: function(e) {
	  $('#span_lat').html(e.latLng.lat());
      $('#span_lng').html(e.latLng.lng());
      },
      zoom_changed: function(e){
          var zoom = e.getZoom();
          $("#span_zoom").html(zoom);
      }
  });

  
  marker = map.addMarker({
	  lat: glat,
	  lng: glng,
	  draggable: true
	});



	

});
</script>
