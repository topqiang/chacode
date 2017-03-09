<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>易盒文化</title>
        <!-- Sets initial viewport load and disables zooming  -->
        <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
        <!-- Makes your prototype chrome-less once bookmarked to your phone's home screen -->
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <link rel="stylesheet" href="/elem/Public/Home/css/public.css" />
        <link href="/elem/Public/Home/css/reset.css" rel="stylesheet"/>
        <script src="/elem/Public/Home/js/jquery.min.js"></script>
        <script src="/elem/Public/Home/js/public.js"></script>
        <style>
        	
        </style>
    </head>
    <body>
    	<div class="pore bgb textcen lh45">
    		登陆
    	</div>
		<div class="conbg">
			
		   	<div class="mat10 pad20 bgb">
		   		<div class="pad0-20">
		   			<div class="blinput borad4 iconuser"><input id="username" type="text" name="username" placeholder="请输入您的手机号"/></div>
		   			<div class="blinput borad4 mat20 iconpwd"><input id="password" type="password" name="password" placeholder="请输入您的密码"/></div>
		   		</div>
		   	</div>

		   	<div class="big-btn bgbtn login">登陆</div>
		   	<div class="mat20 textrig">
		   		<span class="colr msg"></span>
		   	</div>
		</div>
    </body>
	<script type="text/javascript" src="/elem/Public/Home/js/touch.min.js"></script>
	<script type="text/javascript">
    $(".login").on('click',function() {
        var username = $("#username").val();
        var password = $("#password").val();
        if (username != "" && password != "") {
            $.ajax({
                url : "<?php echo U('User/login');?>",
                type : "post",
                data : { "username" : username, "password" : password},
                dataType : "json",
                success : function(res){
                		var ajaxjson = JSON.parse(res);
                    if(ajaxjson.code == "1"){
                        console.log(res);
                        $(".msg").html(ajaxjson.msg);
                    	window.location.href = "<?php echo U('Index/self');?>";
                    }else{
                    	$(".msg").html(ajaxjson.msg);
                    }
                }
            });
        }else{
            alert("用户名或密码不能为空！");
        }
    });
	</script>
</html>