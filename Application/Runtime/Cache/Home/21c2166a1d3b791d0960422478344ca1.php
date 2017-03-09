<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>某某店家</title>
        <!-- Sets initial viewport load and disables zooming  -->
        <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
        <!-- Makes your prototype chrome-less once bookmarked to your phone's home screen -->
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <link rel="stylesheet" href="/elem/Public/Home/css/public.css" />
        <link href="/elem/Public/Home/css/reset.css" rel="stylesheet"/>
        <script src="/elem/Public/Home/js/jquery.min.js"></script>
        <script type="text/javascript" src="/elem/Public/Home/js/yxMobileSlider.js" ></script>
        <script src="/elem/Public/Home/js/public.js"></script>
        <style>
        	
        </style>
    </head>
    <body>
    <body>
    	<header class="bgz colb">
    		<span class="left" linkto="javascript:history.go(-1)"></span>
    		编辑收货地址
    	</header>
		<div class="content" style="padding-top: 50px;">
		<form action="<?php echo U('Address/editadd');?>" method="post" name="form">
			<div class="formline mat20">
					<input type="hidden" name="oid" value="<?php echo ($_REQUEST['oid']); ?>" />
				<div>
					<span class="disib" style="width: 100px;">联系人：</span>
					<input type="text" placeholder="请填写姓名" name="name"/>
				</div>
				<div>
					<span class="disib" style="width: 100px;">联系电话：</span>
					<input type="tel" placeholder="请填写手机号码" name="tel"/>
				</div>
				<div>
					<span class="disib" style="width: 100px;">取货地址：</span>
					<input id="suggestId" type="text" placeholder="选择取货地址" name="address"/>
				</div>
				<div>
					<span class="disib" style="width: 100px;"></span>
					<input type="text" placeholder="详细地址门牌号等" name="housenum"/>
				</div>
				<div id="l-map" class="l-map disn"></div>
			</div>
		</form>
			<div class="big-btn bgbtn">确定</div>
		</div>
    </body>
	<script type="text/javascript" src="/elem/Public/Home/js/touch.min.js"></script>
	<script type="text/javascript">
		$(".big-btn").on('click',function(){
			document.form.submit();
		});
	</script>
	<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=gZedg9GnM3hGi68Z3YubDIyx57oU4GTf"></script>
	<script type="text/javascript">
		// 百度地图API功能
		function G(id) {
			return document.getElementById(id);
		}

		var map = new BMap.Map("l-map");
		map.centerAndZoom("天津",12);                   // 初始化地图,设置城市和地图级别。

		var ac = new BMap.Autocomplete(    //建立一个自动完成的对象
			{"input" : "suggestId"
			,"location" : map
		});

		ac.addEventListener("onhighlight", function(e) {  //鼠标放在下拉列表上的事件
		var str = "";
			var _value = e.fromitem.value;
			var value = "";
			if (e.fromitem.index > -1) {
				value = _value.province +  _value.city +  _value.district +  _value.street +  _value.business;
			}    
			str = "FromItem<br />index = " + e.fromitem.index + "<br />value = " + value;
			
			value = "";
			if (e.toitem.index > -1) {
				_value = e.toitem.value;
				value = _value.province +  _value.city +  _value.district +  _value.street +  _value.business;
			}    
			str += "<br />ToItem<br />index = " + e.toitem.index + "<br />value = " + value;
			// G("searchResultPanel").innerHTML = str;
		});

		var myValue;
		ac.addEventListener("onconfirm", function(e) {    //鼠标点击下拉列表后的事件
		var _value = e.item.value;
			myValue = _value.province +  _value.city +  _value.district +  _value.street +  _value.business;
			// G("searchResultPanel").innerHTML ="onconfirm<br />index = " + e.item.index + "<br />myValue = " + myValue;
			// setPlace();
		});

		function setPlace(){
			map.clearOverlays();    //清除地图上所有覆盖物
			function myFun(){
				var pp = local.getResults().getPoi(0).point;    //获取第一个智能搜索的结果
				map.centerAndZoom(pp, 18);
				map.addOverlay(new BMap.Marker(pp));    //添加标注
			}
			var local = new BMap.LocalSearch(map, { //智能搜索
			  onSearchComplete: myFun
			});
			local.search(myValue);
		}
	</script>
</html>