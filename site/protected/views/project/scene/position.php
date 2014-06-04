<style type="text/css">
  @import url("http://www.google.com/uds/css/gsearch.css");
  @import url("http://www.google.com/uds/solutions/localsearch/gmlocalsearch.css");
</style>
<div class="google_tip">
<span class="google_tip_m"></span>
经度：<span id="span_lng"></span>
纬度：<span id="span_lat"></span>
视图高度：<span id="span_zoom"></span>
<a class="scene_detail_save" href="javascript:" onclick="save_position_detail(<?=$datas['scene_id']?>)">保存位置信息</a>
<span id="position_save_msg"></span>
</div>
<div id="map_canvas" style="width:700px; height:370px;"></div>
<script>
load_map();
</script>