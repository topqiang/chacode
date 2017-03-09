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
			<h3>编辑商品</h3>
			<div class="clear"></div>
		</div>
		<div class="content-box-content">
			<div class="tab-content default-tab">
				<form action="<?php echo U('Company/companyEdit',array('id'=>$id));?>" method="post" enctype="multipart/form-data">
					<fieldset>
						<p>
							<label>商品名称(ID:<?php echo ($info["id"]); ?>)</label>
							<input value="<?php echo ($info["name"]); ?>" class="text-input small-input" type="text" id="small-input" name="name" />
						</p>
						<p>
							<label>地址</label>
							<input class="text-input small-input" type="text" name="address" id="address" onchange="codeAddress()" value="<?php echo ($info["address"]); ?>"/>
						</p>
						<p>
							<label>省份</label>
							<input class="text-input small-input" type="text" name="provance"  value="<?php echo ($info["provance"]); ?>"/>
						</p>
						<p>
							<label>老板</label>
							<input class="text-input small-input" type="text" name="boss" value="<?php echo ($info["boss"]); ?>"/>
						</p>
						<p>
							<label>电话</label>
							<input class="text-input small-input" type="tel" name="tel" value="<?php echo ($info["tel"]); ?>"/>
						</p>

						<p>
							<label>微信号</label>
							<input class="text-input small-input" type="text" name="wxcode" value="<?php echo ($info["wxcode"]); ?>"/>
						</p>
						<p>
							<label>邮箱</label>
							<input class="text-input small-input" type="text" name="email" value="<?php echo ($info["email"]); ?>"/>
						</p>
						<p>
							<label>销售商级别</label>
							<input class="text-input small-input" type="text" name="class" value="<?php echo ($info["class"]); ?>"/>
							<input type="hidden" name="lat" class="lat" value="<?php echo ($info["lat"]); ?>"/>
							<input type="hidden" name="lnt" class="lnt" value="<?php echo ($info["lnt"]); ?>"/>
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
<script charset="utf-8" src="http://map.qq.com/api/js?v=2.exp"></script>
<script type="text/javascript">
	function ajax(){
		var filesize = this.files[0].size;
		if (filesize > 500*1024) {
			alert("请上传大小在500k以下的图片");
			return false;
		};
		var self = $(this);
		var files = this.files;
		var reader = new FileReader();
		reader.onload = function(e){
			var src = e.target.result;
			self.prev().attr("src",src);
		}
		reader.readAsDataURL(files[0]);
	}
	$("input[type='file']").on('change',ajax);


	var geocoder,map,marker = null;
	var init = function() {
	    var center = new qq.maps.LatLng(parseFloat("<?php echo ($info["lat"]); ?>"),parseFloat("<?php echo ($info["lnt"]); ?>"));
	    map = new qq.maps.Map(document.getElementById('map'),{
	        center: center,
	        zoom: 15
	    });
	    //调用地址解析类
	    geocoder = new qq.maps.Geocoder({
	        complete : function(result){
	        	var loca = result.detail.location;
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
</body>
</html>