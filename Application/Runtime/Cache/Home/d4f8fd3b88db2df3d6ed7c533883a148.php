<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewpoint" content="width=device-width,initial-scale=1,user-scalable=no,maximum-scale=1,minimum-scale=1"/>
        <link rel="stylesheet" href="/chacode/Public/Home/css/jx.css" />
        <script type="text/javascript" src="/chacode/Public/Home/js/jquery.js"></script>
        <script type="text/javascript" src="/chacode/Public/Home/js/jx.js"></script>
        <title>防伪查询</title>
        <style type="text/css">

        </style>
    </head>
    <body>
        
	<div class="fake-head pad732 fs40">
		<span></span>
		选择城市
	</div>
	<div class="fake-body bot1">
		<div style="display:none" id="container"></div>
	    <div class="shop-body">
			<div class="city-city fs35">
				<div class="city-location">
					定位城市：
					<span class="city0"></span>
				</div>
				<div class="city-hot">
					<p>热门城市</p>
					<ul>
						<li>北京</li>
						<li>上海</li>
						<li>广州</li>
						<li>深圳</li>
					</ul>
				</div>
			</div>
			<div class="city-select" style="padding: 30px;"> 
				<div class="select-item">
					<?php if(is_array($citylist)): $i = 0; $__LIST__ = $citylist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$city): $mod = ($i % 2 );++$i;?><p><?php echo ($city['provance']); ?></p><?php endforeach; endif; else: echo "" ;endif; ?>						
				</div>
			</div>
		</div>
		</div>
		<div class="fake-footer fs35">
			<p>云南西双版纳州古茶山茶业有限公司</p>
			<p>勐海龙园茶厂<span>电话：0691-5170999</span></p>
			<p>滇ICP备15000438号</p>
		</div>
	</div>

    </body>
    
	<script charset="utf-8" src="http://map.qq.com/api/js?v=2.exp"></script>
	<script>
		$(function () {
			var citylocation,map,marker = null;
            var init = function() {
                var center = new qq.maps.LatLng(39.916527,116.397128);
                var city = document.getElementById("city");
                map = new qq.maps.Map(document.getElementById('container'),{
                    center: center,
                    zoom: 13
                });
                //获取  城市位置信息查询 接口  
                citylocation = new qq.maps.CityService({
                    //设置地图
                    map : map,

                    complete : function(results){
                        console.log(results);
                        $(".city0").text(results.detail.name);
                    }
                });
            }
            init();
            citylocation.searchCityByIP("<?php echo ($ip); ?>");
		});

		function clickafter( txt ) {
			if (txt) {
				if (txt.indexOf('市') != -1 ) var txt = txt.substring(0,txt.length-1);
				window.location.href = "<?php echo U('Company/companylist');?>/provance/"+txt;
				
			}
		}

	</script>

</html>