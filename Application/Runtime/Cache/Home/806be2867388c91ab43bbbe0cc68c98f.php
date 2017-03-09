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
    		订单
    	</header>
		<div class="content" style="padding-top: 50px;">
			<!-- <div class="shopbar fs14">
		   		<div>全部</div>
		   		<div class="on">待付款</div>
		   		<div>待配送</div>
		   		<div>待评价</div>
		   		<div>已完成</div>
		   </div> -->
			<?php if(is_array($ordinfo)): $i = 0; $__LIST__ = $ordinfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$order): $mod = ($i % 2 );++$i;?><div class="order mat10 bgb ovhid">
			  		<div class="oname" linkto="<?php echo U('Order/orderinfo');?>/id/<?php echo ($order["id"]); ?>">
			  			<span class="fr colr mar10">
			  				<?php if($order['type'] == 0): ?>待付款
			  				<?php elseif($order['type'] == 1): ?>
			  					待接单
			  				<?php elseif($order['type'] == 2): ?>
			  					待配送
			  				<?php elseif($order['type'] == 3): ?>
			  					待收货
			  				<?php elseif($order['type'] == 4): ?>
			  					已完成
			  				<?php elseif($order['type'] == 9): ?>
			  					已取消<?php endif; ?>
			  			</span>
			  			<span class="pad0-20 bol5"><?php echo ($order["address"]); ?></span>
			  		</div>
			  		<?php if(is_array($order['goods'])): $i = 0; $__LIST__ = $order['goods'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$good): $mod = ($i % 2 );++$i;?><div class="oinfo ovhid" linkto="<?php echo U('Order/orderinfo');?>/id/<?php echo ($order["id"]); ?>">
				  			<div class="fl">
				  				<img src="<?php echo ($good["goodpic"]); ?>" />
				  			</div>
				  			<div class="ginfo">
				  				<div class=""><?php echo ($good["goodname"]); ?></div>
				  				<div class="fs16">
				  					<span class="cole fr">X<?php echo ($good["num"]); ?></span>
				  					<span class="colr">￥<?php echo ($good["price"]); ?></span>
				  				</div>
				  			</div>
				  		</div><?php endforeach; endif; else: echo "" ;endif; ?>
			  		
			  		<div class="fs14 lh45 borb31 mar10">
			  			<span class="fr">共<?php echo ($order["totalnum"]); ?>件商品 合计：<span class="fs16">￥<?php echo ($order["paymoney"]); ?></span></span>
			  		</div>
			  		
			  		<div class="btnarea">
						<?php if($order['type'] == 0): ?><span class="borbtnh fr mat10 fs12 mar10" ordid="<?php echo ($order["id"]); ?>" gotype="9">取消订单</span>
				  			<span class="borbtnh fr mat10 fs12 mar10" ordid="<?php echo ($order["id"]); ?>" gotype="1">立即支付</span>
				  		<?php elseif($order['type'] == 3): ?>	
				  			<span class="borbtnh fr mat10 fs12 mar10" ordid="<?php echo ($order["id"]); ?>" gotype="4">确认收货</span><?php endif; ?>
			  		</div>
			  	</div><?php endforeach; endif; else: echo "" ;endif; ?>
		</div>
    </body>
	<script type="text/javascript" src="/elem/Public/Home/js/touch.min.js"></script>
	<script type="text/javascript">
		$("[ordid]").on('click',function(){
			var id = $(this).attr("ordid");
			var type = $(this).attr("gotype");
			if (id && type && id != "" && type != "") {
				if (type == 1) {
					window.location.href = "<?php echo U('Order/updorder');?>/id/"+id+"/type/1";
				}else{
					$.ajax({
						"url" : "<?php echo U('Order/updorder');?>",
						"type" : "post",
						"data" : {"id" :id,"type":type},
						"dataType" : "json",
						"success" : function( res ){
							var resjson = JSON.parse(res);
							if (resjson.code == 1) {
								alert(resjson.msg);
								window.location.reload();
							}else{
								alert("修改失败！");
							}					
						}
					});
				}
			}
		});
	</script>
</html>