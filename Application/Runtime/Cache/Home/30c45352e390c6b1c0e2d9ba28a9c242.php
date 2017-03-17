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
        
	<div class="fake-head pad732 fs40 bom1">
		<i class="submit">提交</i>
		<span></span>
		举报
	</div>
	<div class="fake-body bot1">
		<div class="shop-body">
				<div class="report-cont">
					姓名：
					<input type="text" class="name" placeholder="您的姓名">
				</div>
				<div class="report-cont">
					手机：
					<input type="tel" class="tel" placeholder="您的手机号">
				</div>
				<div class="report-cont1">
					<span>备注：</span>
					<textarea placeholder="购买渠道" class="remark" name="remark"></textarea>
					<div class="photoimg">
						<input type="file" name="pic"/>
					</div>
					<img class="showimg hid0" width="200" height="200"/>
				</div>
				
			</div>
		<div class="fake-footer fs35">
			<p>云南西双版纳州古茶山茶业有限公司</p>
			<p>勐海龙园茶厂<span>电话：0691-5170999</span></p>
			<p>滇ICP备15000438号</p>
		</div>
	</div>

    </body>
    
	<script type="text/javascript">
	var pic = "";
	$(".submit").on('click',function () {
		var name = $(".name").val();
		var tel = $(".tel").val();
		if (name == "" || tel == "") {
			alert("姓名和手机号不能为空！");
			return;
		}
		if (!/^(13[0-9]|14[5|7]|15[0|1|2|3|5|6|7|8|9]|18[0|1|2|3|5|6|7|8|9])\\d{8}$/.test(tel)) {
			alert("请输入合法的手机号！");
			return;
		}

		var remark = $(".remark").val();
		$.ajax({
			"url" : "<?php echo U('Report/addReport');?>",
			"type" : "post",
			"data" :{"name":name,"tel":tel,"remark":remark,"pic":pic},
			"dataType": "json",
			"success" : function (res) {
				if (res.flag == "success") {
					alert(res.message);
					window.location.href = "<?php echo U('Index/index');?>";
				}
			}
		})

	});
	function ajax(){
		var filesize = this.files[0].size;
		if (filesize > 500*1024) {
			alert("请上传大小在500k以下的图片");
			return false;
		};
		var self = $(this);
		var files = this.files;
		var picname = files[0].name;
		var reader = new FileReader();
		reader.onload = function(e){
			var src = e.target.result;
			$.ajax({
                type:"post",
                url:"<?php echo U('Report/uploadPic');?>",
                data: {"pic":src,"pic_name":picname},
                dataType : "json",
                success : function(res){
                	if (res.flag == "success") {
                		pic =res.data;
                		console.log(pic);
                    	$(".showimg").show().attr("src","/"+pic);
                	}else{
                		alert(res.message);
                	}
                	
                }
            });
		}
		reader.readAsDataURL(files[0]);
	}
	$("input[type='file']").on('change',ajax);
	</script>

</html>