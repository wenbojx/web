var config = {"gmap_city":{"11":{"lng":121.4759159,"lat":31.2243531,"zoom":14},"12":{"lng":113.341527,"lat":23.1270407,"zoom":14},"13":{"lng":114.0577948,"lat":22.5442297,"zoom":14},"14":{"lng":116.3979471,"lat":39.9081726,"zoom":14},"15":{"lng":104.07794952393,"lat":30.657221654396,"zoom":14},"16":{"lng":118.7977409,"lat":32.0556449,"zoom":14},"17":{"lng":117.2523808,"lat":39.1038561,"zoom":14},"18":{"lng":120.1729739,"lat":30.2739768,"zoom":14},"19":{"lng":120.6249154,"lat":31.3109409,"zoom":14},"20":{"lng":106.548425,"lat":29.5549144,"zoom":14},"21":{"lng":121.849365,"lat":39.050119,"zoom":14},"22":{"lng":121.614771,"lat":38.913779,"zoom":14},"23":{"lng":116.994914,"lat":36.665282,"zoom":12},"24":{"lng":113.121315,"lat":23.02172,"zoom":12},"25":{"lng":120.303027,"lat":31.566147,"zoom":12},"26":{"lng":113.624863,"lat":34.747284,"zoom":12},"27":{"lng":112.938827,"lat":28.228528,"zoom":12},"28":{"lng":114.514864,"lat":38.04232,"zoom":12},"30":{"lng":120.382771,"lat":36.066348,"zoom":12},"31":{"lng":108.944265,"lat":34.26488,"zoom":12},"32":{"lng":121.54399,"lat":29.868336,"zoom":12},"33":{"lng":117.286983,"lat":31.865779,"zoom":12},"34":{"lng":113.751766,"lat":23.020536,"zoom":12},"35":{"lng":119.296579,"lat":26.074286,"zoom":12},"36":{"lng":102.722125,"lat":25.037283,"zoom":12},"37":{"lng":106.633375,"lat":26.645931,"zoom":12},"38":{"lng":112.550737,"lat":37.870554,"zoom":12},"51":{"lng":109.522771,"lat":18.257776,"zoom":12},"52":{"lng":114.410658,"lat":23.11354,"zoom":12},"40":{"lng":120.98119854927,"lat":31.384908949364,"zoom":14}}};

config.version = "2.156";
config.version2 = "2.95";
config.mapbar_delta = {"lat":-0.00226,"lng":0.004406};
config.big_china = {"latFrom":4,"latTo":53,"lngFrom":73,"lngTo":135};
config.gmap_city = {"11":{"lng":121.4759159,"lat":31.2243531,"zoom":16},"12":{"lng":113.341527,"lat":23.1270407,"zoom":16}};

var city_id = "11";
var latlng = {"lat":"39.988695016047","lng":"116.32822036743"};
var googlemap = null;
var spot_id = '420';
function load_map(){
        var base_info = {
            lat:parseFloat(latlng.lat),
            lng:parseFloat(latlng.lng),
            zoom:12        };
        googlemap = jQuery.googlemap(config,base_info,city_id);
        googlemap.init();
}

jQuery.extend( {
    googlemap : function(config, base_info, city_id) {
        var canvas = document.getElementById('map_canvas');
        var map = null;
        var center_point = null;
        var zoom = base_info.zoom;
        var geocoder = null;
        var moveing_marker = null;
        var city_lat = null;
        var search_options = null;


        function init () {
            map = new GMap2(canvas)
            geocoder = new GClientGeocoder();
            city_lat = config.gmap_city[city_id].lat;
            city_lng = config.gmap_city[city_id].lng;
            city_zoom = config.gmap_city[city_id].zoom;
            search_options = {
                    onSearchCompleteCallback: search_complete
            };
            map.setMapType(G_SATELLITE_MAP);

            map.addControl(new GLargeMapControl());
            map.addControl(new GOverviewMapControl());
            map.addControl(new google.maps.LocalSearch(search_options));
            map.enableContinuousZoom();

            point = new GLatLng(city_lat,city_lng);
            map.setCenter(point, city_zoom);

            //地图缩放时改变高度
            GEvent.addListener(map,'zoomend',function (oldzoom,newzoom) {
                jQuery('#span_zoom').html(newzoom);
            });

            set_init_marker(0);
        }

        function search_complete (searcher) {
            if (searcher.results.length > 0) {
                var first_result = searcher.results[0];
                var point = new GLatLng(first_result.lat,first_result.lng);
                redraw_marker(point);
            }
            //console.log(searcher.results);
        }
        function set_init_marker (iscancel) {
            //检查以前设置过坐标没
            if (base_info['lat'] && base_info['lng']) {
                // 如果已经设置了坐标
                point = new GLatLng(base_info.lat, base_info.lng);
                zoom = parseInt(base_info.zoom);
                zoom = zoom > 0 ? zoom : map.getZoom();
                redraw_marker(point,zoom);
            }
        }

        function redraw_marker (point,zoom) {
            zoom = zoom > 0 ? zoom : map.getZoom();
            if (moveing_marker != null) {
                moveing_marker.setLatLng(point);
            } else {
                var icon = new GIcon(G_DEFAULT_ICON, google_map_tip_url);
                moveing_marker = new GMarker(point, {
                    draggable : true,
                    icon: icon
                });
                map.addOverlay(moveing_marker);
            }

            map.setCenter(point,zoom);
            set_values(point,zoom);

            GEvent.addListener(moveing_marker,'drag',function () {
                var point = moveing_marker.getLatLng();
                set_values(point);
            });
        }

        //设置页面变量
        function set_values(point,zoom) {
            zoom = zoom > 0 ? zoom : map.getZoom();
            jQuery('#span_lat').html(point.lat());
            jQuery('#span_lng').html(point.lng());
            jQuery('#span_zoom').html(zoom);
        }

        //放弃 返回列表页
        function cancel () {
            window.location.href = back_url;
        }

        return {
            init: init,
            cancel: cancel
        };
    }
});