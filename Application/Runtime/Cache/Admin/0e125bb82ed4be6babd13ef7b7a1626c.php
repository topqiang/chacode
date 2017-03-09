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
			<h3>编辑商品</h3>
			<div class="clear"></div>
		</div>
		<div class="content-box-content">
			<div class="tab-content default-tab">
				<form action="<?php echo U('Goods/goodsEdit',array('id'=>$id));?>" method="post" enctype="multipart/form-data">
					<fieldset>
						<p>
							<label>商品名称(ID:<?php echo ($info["id"]); ?>)</label>
							<input value="<?php echo ($info["name"]); ?>" class="text-input small-input" type="text" id="small-input" name="name" />
						</p>
						<p>
							<label>商品图</label>
							<img src="/chacode/<?php echo ($info["pic"]); ?>" width="100" height="100"/>
							<input type="file" name="pic"/>
						</p>
						<p>
							<label>厂家名称</label>
							<input class="text-input small-input" type="text" name="company" value="<?php echo ($info["company"]); ?>"/>
						</p>
						<p>
							<label>批次</label>
							<input class="text-input small-input" type="number" name="creatcode" value="<?php echo ($info["creatcode"]); ?>"/>
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
</script>
</body>
</html>