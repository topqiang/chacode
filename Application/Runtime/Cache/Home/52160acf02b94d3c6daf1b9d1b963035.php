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
    		提现
    	</header>
		<div class="content" style="padding: 60px 10px 10px;">
			<div class="pad20 textcen bgb">
				<img src="/elem/Public/Home/img/result.png" class="mat20" style="width: 100px;height: 100px;"/>
				<div class="mat20 colr fs24">下单成功!</div>
				
				<div class="ovhid mat20">
					<span class="lmbtn bgbtn fr" linkto="<?php echo U('Order/orderlist');?>">订单列表</span>
					<span class="lmbtn bgbtn fl" linkto="<?php echo U('Index/index');?>">返回首页</span>
				</div>
			</div>
		</div>
    </body>
	<script type="text/javascript" src="/elem/Public/Home/js/touch.min.js"></script>
</html>