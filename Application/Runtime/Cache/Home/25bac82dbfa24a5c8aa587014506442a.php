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
    		订单详情
    	</header>
    	<div class="content" style="padding: 50px 0px 10px;">
    		<div class="ordaddress" linkto="<?php echo U('Address/editadd');?>/oid/<?php echo ($order["id"]); ?>">
    			<span class="right fr" style="margin-top: 13px;"></span>
    			<?php if(empty($order['addname']) || empty($order['address']) || empty($order['addtel'])): ?><div class="ediadd cole" style="line-height: 60px;">
	    				请填写取货信息
	    			</div>
	    			<?php else: ?>
	    			<div class="ediadd">
	    				<div>
	    					收货人：<?php echo ($order["addname"]); ?>
	    					<span class="fr mar5"><?php echo ($order["addtel"]); ?></span>
	    				</div>
	    				<div>收货地址：<?php echo ($order["address"]); ?></div>
	    			</div><?php endif; ?>
    		</div>
    		<div class="getfootime bol5 mat10">
		  		<div class="fr rcontent">
		  			<span class="smbtn bge">今日</span>
		  			<div>30分钟</div>
		  		</div>
		  		<div class="">
		  			预计送达时间
		  		</div>
		  	</div>
		  	<div class="orderline">
		  		<div><span class="fr pad0-20 fs14 cole">在线支付</span>支付方式</div>
		  	</div>
		  	
		  	<div class="mat10 bgb pad10">
		  		<div class="pad0-10 bol5">订单详情</div>
		  	</div>
		  	
	    	<div class="formline pad0-10">
	    		<?php if(is_array($goods)): $i = 0; $__LIST__ = $goods;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$good): $mod = ($i % 2 );++$i;?><div><?php echo ($good["goodname"]); ?><span class="fr">￥<?php echo ($good["price"]); ?></span><span class="fr mar60">X<?php echo ($good["num"]); ?></span></div><?php endforeach; endif; else: echo "" ;endif; ?>
	    	</div>
	    	<div class="pad10 bgb textrig" style="border-top: 1px solid #E1E1E1;">
	    		<span class="">待支付￥<?php echo ($order["paymoney"]); ?></span>
	    	</div>
	    	<div class="formline pad0-10 mat10">
				<div>备注</div>
				<div class="cole fs12"><input type="text" class="width remark" name="remark" placeholder="您可以在这输入您的特殊要求！"></div>
			</div>
    	</div>
    	
    	<!--确认订单-->
    	<div class="gley on" null="stop">
		<div class="gleycon">
			<font>待支付：￥<span class="money"><?php echo ($order["paymoney"]); ?></span></font>
		</div>
		<div class="gleybtn pfr">
			支付订单
		</div>
	</div>
    </body>
    <script type="text/javascript">
    	$(".gleybtn").on('click',function(){
    		var remark = $.trim($(".remark").val());
    		if (remark != "") {
    			window.location.href = "<?php echo U('Order/updorder');?>/id/<?php echo ($order["id"]); ?>/type/1/remark/"+remark;
    		}else{
    			window.location.href = "<?php echo U('Order/updorder');?>/id/<?php echo ($order["id"]); ?>/type/1";
    		}
    	});
    </script>
</html>