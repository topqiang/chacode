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
			<div class="shop-body">
				<div class="fake-bg2"></div>
				<div class="fake-word">
					<div class="fs40 mat50">勐海龙园茶业</div>
					<p class="fs25 mat10">MengHai&nbsp;Longyuan&nbsp;Tea&nbsp;Industry</p>
					<div class="fs40 ma40-0">几棵树防伪查询系统</div>
				</div>
				<div class="fake-code"><input class="code_name" type="text" placeholder="输入十位防伪验证码"/></div>
				<div class="fake-submit"><span class="postbtn">查询</span></div>
				
				<div class="fake-footer fs35 footer1">
					<p>云南西双版纳州古茶山茶业有限公司</p>
					<p>勐海龙园茶厂<span>电话：0691-5170999</span></p>
					<p>滇ICP备15000438号</p>
				</div>
			</div>
		</div>		

    </body>
    
	<script type="text/javascript">
		$(".postbtn").on('click',function () {
			if ( !/^[a-zA-Z0-9]{10}$/.test(code_name) ) {
			var code_name = $(".code_name").val();
				alert("请输入合法的防伪码！");
				return;
			}
			if (code_name == "") {
				alert("防伪码不能为空！");
			}else{
				window.location.href = '<?php echo U("Home/Qcode/findcode");?>/code_name/'+code_name;
			}
		})

	</script>

</html>