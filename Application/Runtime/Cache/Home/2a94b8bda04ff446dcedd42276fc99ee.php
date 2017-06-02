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
            防伪查询
        </div>
		<div class="fake-body txtcen bot1">
		<div style="display:none" id="container"></div>
			<div class="shop-body">
				<div class="fake-bg2"></div>
				<div class="fake-word">
					<div class="fs40 mat50">勐海龙园茶业</div>
					<p class="fs25 mat10">MengHai&nbsp;Longyuan&nbsp;Tea&nbsp;Industry</p>
					<div class="ma40-0" style="font-size:60px;">几棵树防伪查询系统</div>
				</div>
				<div class="fake-code"><input class="code_name" type="text" placeholder="输入十位防伪验证码" style="border: 1px solid #ccc;"/></div>
				<div class="fake-submit"><span class="postbtn">查询</span></div>
				
				<!--<div class="fake-footer fs35 footer1">
					<p>龙园茶业勐海龙园茶厂</p>
					<p><span>电话：0691-5170999</span></p>
					<p>滇ICP备15000438号</p>
				</div>-->
			</div>
		</div>
		<?php if($requri): ?><div id="loginimg" style="position:fixed;top:50%;left:50%;transform:translate(-50%,-50%)"></div><?php endif; ?>

    </body>
    
    <script src="https://s11.cnzz.com/z_stat.php?id=1261702682&web_id=1261702682" language="JavaScript"></script>
	<script charset="utf-8" src="https://map.qq.com/api/js?v=2.exp"></script>
	<script>
        $(".fake-submit").on('click',function () {
            var code_name = $(".code_name").val();
            if ( !/^\w{5}\d{5}$/.test(code_name) ) {
                alert("请输入合法的防伪码！");
                return;
            }else{
                window.location.href = '<?php echo U("Home/Qcode/findcode");?>/code_name/'+code_name;
            }
        })


		$(function () {
			var citylocation,map,marker = null;
            var init = function() {
                var center = new qq.maps.LatLng(39.916527,116.397128);
                map = new qq.maps.Map(document.getElementById('container'),{
                    center: center,
                    zoom: 13
                });
                //获取  城市位置信息查询 接口  
                citylocation = new qq.maps.CityService({
                    //设置地图
                    map : map,
                    complete : function(results){
                    	var latlng = results.detail.latLng;
                        console.log(latlng);
                        $.ajax({
                        	"url":"<?php echo U('User/upduser');?>",
                        	"type":"post",
                        	"dataType":"json",
                        	"data":{"lat":latlng.lat,"lng":latlng.lng,"provance":results.detail.name},
                        	"success":function ( res ) {
                        		console.log( res );		
                        	}
                        });
                    }
                });
                console.log(citylocation);
            }
            init();
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function( res ){
                    citylocation.searchCityByLatLng(new qq.maps.LatLng(res.coords.latitude, res.coords.longitude));
                });
            }
		});

	</script>

</html>