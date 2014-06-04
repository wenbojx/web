<div class="content">
	<div class="left_side float_left">
		<div class="ltitle">
			
			<div class="lmenu">
				<select name="menu" id="menu">
					<option value="1">全局设置</option>
					<option value="2">热点</option>
					<option value="3">背景音乐</option>
					<option value="4">按钮</option>
					<option value="5">指南针</option>
					<option value="6">图片按钮</option>
					<option value="7">图片地图</option>
					<option value="8">提示框</option>
					<option value="9">地图</option>
					<option value="10">眩光</option>
					<option value="11">链接</option>
					<option value="12">缩略图</option>
					<option value="13">鼠标样式</option>
					<option value="14">缩放</option>
				</select>
			</div>
		</div>
		<div class="lpanel" id="lpanel">
			
		</div>
	</div>
	<div class="right_side float_left">
		<div class="rselector">
			<div id="rselector_4">
				<h3>素材</h3>
				<div>
					<div id="rselector_4_1_1" class="button_bar_icon" style="width:40px; height: 40px; background-position:0 0;"></div>
					<div id="rselector_4_1_2" class="button_bar_icon" style="width:40px; height: 40px; background-position:-41px 0;"></div>
					<div id="rselector_4_1_3" class="button_bar_icon" style="width:40px; height: 40px; background-position:-82px 0;"></div>
					<div id="rselector_4_1_4" class="button_bar_icon" style="width:40px; height: 40px; background-position:-123px 0;"></div>
					<div id="rselector_4_1_5" class="button_bar_icon" style="width:40px; height: 40px; background-position:-164px 0;"></div>
					<div id="rselector_4_1_6" class="button_bar_icon" style="width:40px; height: 40px; background-position:-205px 0;"></div>
					<div id="rselector_4_1_7" class="button_bar_icon" style="width:40px; height: 40px; background-position:-246px 0;"></div>
					<div id="rselector_4_1_8" class="button_bar_icon" style="width:40px; height: 40px; background-position:-287px 0;"></div>
					<div id="rselector_4_1_9" class="button_bar_icon" style="width:40px; height: 40px; background-position:-328px 0;"></div>
					<div id="rselector_4_1_10" class="button_bar_icon" style="width:40px; height: 40px; background-position:0 -82px;"></div>
					<div id="rselector_4_1_11" class="button_bar_icon" style="width:40px; height: 40px; background-position:-41px -82px;"></div>
					<div id="rselector_4_1_12" class="button_bar_icon" style="width:40px; height: 40px; background-position:-82px -82px;;"></div>
					<div id="rselector_4_1_13" class="button_bar_icon" style="width:40px; height: 40px; background-position:-123px -82px;;"></div>
					<div id="rselector_4_1_14" class="button_bar_icon" style="width:40px; height: 40px; background-position:-164px -82px;;"></div>
					<div id="rselector_4_1_15" class="button_bar_icon" style="width:40px; height: 40px; background-position:-205px -82px;;"></div>
					<div id="rselector_4_1_16" class="button_bar_icon" style="width:40px; height: 40px; background-position:-246px -82px;;"></div>
					<div id="rselector_4_1_17" class="button_bar_icon" style="width:40px; height: 40px; background-position:-287px -82px;;"></div>
					<div id="rselector_4_1_18" class="button_bar_icon" style="width:40px; height: 40px; background-position:-328px -82px;;"></div>
				</div>
				<h3>窗口</h3>
				<div>
					<ul id="buttonBarWinClick" >
						<li>
						宽度：<input type="text" class="width_50" value="400" onchange="win.system.changeWidth(this,'button_bar_window')"/>px
						</li>
						<li>
						高度：<input type="text" class="width_50" value="42" onchange="win.system.changeHeight(this,'button_bar_window')"/>px
						</li>
						<li>
						水平对齐：
						<select>
							<option>顶部</option>
							<option>中间</option>
							<option>底部</option>
						</select>
						</li>
						<li>
						垂直对齐：
						<select>
							<option>顶部</option>
							<option>中间</option>
							<option>底部</option>
						</select>
						</li>
						
						<li>
						水平偏移：<input type="text" class="width_50" value="0" onchange="win.system.changeHeight(this,'button_bar_window')"/>px
						</li>
						<li>
						垂直偏移：<input type="text" class="width_50" value="0" onchange="win.system.changeHeight(this,'button_bar_window')"/>px
						</li>
					</ul>
				</div>
				<h3>元素</h3>
				<div>
					<ul id="buttonBarButtonClick">
						
						<li>
						水平偏移：<input type="text" class="width_50" value="0" onchange="win.system.changeHeight(this,'button_bar_window')"/>px
						</li>
						<li>
						垂直偏移：<input type="text" class="width_50" value="0" onchange="win.system.changeHeight(this,'button_bar_window')"/>px
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="/style/skin/core.js"></script>

 <script>
$(function() {
	$( "#rselector_4" ).accordion({
		collapsible: true,
		heightStyle: "content"
	});
});
win.buttonBar.initButtonBar()
//$( "#lselector_4" ).accordion({ active: 1 });
</script>




