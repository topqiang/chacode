<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>后台管理系统</title>
	<link rel="stylesheet" href="/chacode/Public/Admin/css/reset.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="/chacode/Public/Admin/css/style.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="/chacode/Public/Admin/css/invalid.css" type="text/css" media="screen" />
	<script type="text/javascript" src="/chacode/Public/Admin/js/jquery-1.9.1.min.js"></script>
</head>
<body>
<div id="main-content">
	<div class="content-box">
		<!--头部切换-->
		<div class="content-box-header">
			<h3>添加商品</h3>
			<ul class="content-box-tabs">
				<li><a href="<?php echo U('Goods/goodsList');?>">商品列表</a></li>
				<li><a href="<?php echo U('Goods/goodsAdd');?>" class="default-tab current">添加商品</a></li>
			</ul>
			<div class="clear"></div>
		</div>
		<div class="content-box-content">
			<div class="tab-content default-tab">
				<form action="<?php echo U('Goods/goodsAdd');?>" method="post" enctype="multipart/form-data">
					<fieldset>
						<p>
							<label>商品名称</label>
							<input class="text-input small-input" type="text" id="small-input" name="name" />
						</p>
						<p>
							<label>缩略图</label>
							<input type="file" name="pic" />
						</p>
						<p>
							<label>厂家名称</label>
							<input class="text-input small-input" type="text" name="company" />
						</p>
						<p>
							<label>批次</label>
							<input class="text-input small-input" type="number" name="creatcode" />
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
<script type="text/javascript">
	$("input[type='file']").on("change",function(){
		var filesize = this.files[0].size;
		if (filesize > 500*1024) {
			alert("请上传大小在500k以下的图片");
		};
	});
</script>
</html>