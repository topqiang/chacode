<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
 
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>驾车线路搜索</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <script charset="utf-8" src="http://map.qq.com/api/js?v=2.exp"></script>
    <style type="text/css">
        html,
        body {
            height: 100%;
            margin: 0px;
            padding: 0px;
            width:100%;
            overflow:hidden;
        }
        #container {
            width: 100%;
            height: 100%
        }
        #panel {
            position: absolute;
            top: 5px;
            left: 50%;
            margin-left: -180px;
            z-index: 5;
            background-color: #fff;
            padding: 5px;
            border: 1px solid #999;
        }
    </style>
</head>
 
<body>
    <div id="container" style="width:100%;height:300px"></div>
    <div style='width: 500px; height: 180px' id="infoDiv"></div>
    </div>
    <script>

    	var start;
    	var drivingService;
    	var option = JSON.parse(sessionStorage.getItem("end"));
        var end = new qq.maps.LatLng(option['lat'],option['lnt']);
        console.log(end);
        function callback( res ){
        	start = new qq.maps.LatLng(res.coords.latitude, res.coords.longitude);
        	var map = new qq.maps.Map(document.getElementById("container"), {
	            center: start
	        });
	         //设置获取驾车线路方案的服务
	        drivingService = new qq.maps.DrivingService({
	            map: map,
	            //展现结果
	            panel: document.getElementById('infoDiv')
	 
	        });
	        search();
        }


         //设置搜索地点信息、驾车方案等属性
        function search( ) {
        	var type = ["LEAST_TIME","LEAST_DISTANCE","AVOID_HIGHWAYS","REAL_TRAFFIC","PREDICT_TRAFFIC"];
        	/**
        	*	<option value="LEAST_TIME">最少时间</option>
            *	<option value="LEAST_DISTANCE">最短距离</option>
            *	<option value="AVOID_HIGHWAYS">避开高速</option>
            *	<option value="REAL_TRAFFIC">实时路况</option>
            *	<option value="PREDICT_TRAFFIC">预测路况</option>
			*/
            //设置驾车方案
            drivingService.setPolicy(qq.maps.DrivingPolicy[type[0]]);
            //设置驾车的区域范围
            drivingService.setLocation("天津");
            //设置回调函数
            drivingService.setComplete(function(result) {
                if (result.type == qq.maps.ServiceResultType.MULTI_DESTINATION) {
                    alert("起终点不唯一");
                }
            });
            //设置检索失败回调函数
            drivingService.setError(function(data) {
                alert(data);
            });
            //设置驾驶路线的起点和终点
            drivingService.search(start, end);
        }

        window.onload=function () {
			if (navigator.geolocation) {
	    		navigator.geolocation.getCurrentPosition(callback,function () {
	    			alert("获取路线失败！");
	    		});
	    	}
        }

    </script>
 
</body>
 
</html>