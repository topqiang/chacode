<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>后台管理系统</title>
	<link rel="stylesheet" href="/chacode/Public/Admin/css/reset.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="/chacode/Public/Admin/css/style.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="/chacode/Public/Admin/css/invalid.css" type="text/css" media="screen" />
	<script type="text/javascript" src="/chacode/Public/Admin/js/jquery-1.9.1.min.js"></script>
	<style>
		.contan{
			position:fixed;
			top: 100px;
			right: 50px;
		}
		#map{
			width:300px;
			height:300px;
			margin-top:200px;
		}
	</style>
</head>
<body>
<div class="contan"><div id="map"></div></div>
<div id="main-content">
	<div class="content-box">
		<!--头部切换-->
		<div class="content-box-header">
			<h3>添加销售商</h3>
			<ul class="content-box-tabs">
				<li><a href="<?php echo U('Company/companyList');?>">商品列表</a></li>
				<li><a href="<?php echo U('Company/companyAdd');?>" class="default-tab current">添加商品</a></li>
			</ul>
			<div class="clear"></div>
		</div>
		<div class="content-box-content">
			<div class="tab-content default-tab">
				<form action="<?php echo U('Company/companyAdd');?>" method="post" enctype="multipart/form-data">
					<fieldset>
						<p>
							<label>商品名称</label>
							<input class="text-input small-input" type="text" id="small-input" name="name" />
						</p>
						<p>
							<label>地址</label>
							<input class="text-input small-input" onchange="codeAddress()" type="text" name="address" id="address"/>
						</p>
						<p>
							<label>省份</label>
							<input class="text-input small-input" type="text" name="provance" />
						</p>
						<p>
							<label>老板</label>
							<input class="text-input small-input" type="text" name="boss" />
						</p>
						<p>
							<label>电话</label>
							<input class="text-input small-input" type="tel" name="tel" />
						</p>

						<p>
							<label>微信号</label>
							<input class="text-input small-input" type="text" name="wxcode" />
						</p>
						<p>
							<label>邮箱</label>
							<input class="text-input small-input" type="text" name="email" />
						</p>
						<p>
							<label>销售商级别</label>
							<input class="text-input small-input" type="text" name="class" />
							<input type="hidden" class="lat" name="lat" />
							<input type="hidden" class="lnt" name="lnt" />
						</p>
						<p>
							<input class="button" type="submit" value="保存" />
						</p>
					</fieldset>
					<div class="clear"></div>
				</form>
			</div>
		</div>
	</div>
</div>
</body>
<script charset="utf-8" src="http://map.qq.com/api/js?v=2.exp"></script>
<script type="text/javascript">
	$("input[type='file']").on("change",function(){
		var filesize = this.files[0].size;
		if (filesize > 500*1024) {
			alert("请上传大小在500k以下的图片");
		};
	});
	var geocoder,map,marker = null;
	var init = function() {
	    var center = new qq.maps.LatLng(39.916527,116.397128);
	    map = new qq.maps.Map(document.getElementById('map'),{
	        center: center,
	        zoom: 15
	    });
	    //调用地址解析类
	    geocoder = new qq.maps.Geocoder({
	        complete : function(result){
	        	var loca = result.detail.location;
	        	console.log(loca);
	        	$(".lat").val(loca.lat);
	        	$(".lnt").val(loca.lng);
	            map.setCenter(result.detail.location);
	            var marker = new qq.maps.Marker({
	                map:map,
	                position: result.detail.location
	            });
	        }
	    });
	}
	$(function () {
		init();
	});
	function codeAddress() {
	    var address = document.getElementById("address").value;
	    //通过getLocation();方法获取位置信息值
	    geocoder.getLocation(address);
	}
	
</script>
</html>