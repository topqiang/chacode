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
		<div class="content pore" style="padding-bottom: 20px;">
		  	<div class="selftop bgz" style="height: 150px;">
		  		<div class="selftext">
		  			<span class="rightb fr"></span>
		  			<div class="disib fl pad0-20">
			  			<img src="<?php echo ($shopinfo["logopic"]); ?>" />
			  		</div>
			  		<div class="menutext lh20 pad20">
			  			<div class="colb"><?php echo ($shopinfo["title"]); ?></div>
			  			<div class="colb fs12"><?php echo ($shopinfo["tel"]); ?></div>
			  		</div>
		  		</div>
		  	</div>
		  	<div class="intime disf iconvoline">
		   		<div>
		   			<div class="colr"><?php echo ($shopinfo["money"]); ?>元</div>
		   			<div class="cole">余额</div>
		   		</div>
		   		<div>
		   			<div class="colg"><?php echo ($ordernum); ?>单</div>
		   			<div class="cole">单数</div>
		   		</div>
		   	</div>
		  	

		   	<?php if(is_array($ordinfo)): $i = 0; $__LIST__ = $ordinfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$order): $mod = ($i % 2 );++$i;?><div class="order mat10 bgb ovhid">
			  		<div class="oname" linkto="<?php echo U('Index/orderinfo');?>/id/<?php echo ($order["id"]); ?>">
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
			  		<?php if(is_array($order['goods'])): $i = 0; $__LIST__ = $order['goods'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$good): $mod = ($i % 2 );++$i;?><div class="oinfo ovhid">
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
			  		
			  		<div class="fs14 lh45 borb31 mar10 textrig">
			  			<span class="">共<?php echo ($order["num"]); ?>件商品 合计：<span class="fs16">￥<?php echo ($order["paymoney"]); ?></span></span>
			  		</div>
			  		
			  		<div class="btnarea">
			  		<?php if($order['type'] == 0): ?><span class="borbtnh fr mat10 fs12 mar10" ordid="<?php echo ($order["id"]); ?>" gotype="9">取消订单</span>
			  		<?php elseif($order['type'] == 1): ?>	
			  			<span class="borbtnh fr mat10 fs12 mar10" ordid="<?php echo ($order["id"]); ?>" gotype="2">接单</span>
			  		<?php elseif($order['type'] == 2): ?>
			  			<span class="borbtnh fr mat10 fs12 mar10" ordid="<?php echo ($order["id"]); ?>" gotype="3">配送</span><?php endif; ?>
			  		</div>
			  	</div><?php endforeach; endif; else: echo "" ;endif; ?>
		</div>
		<footer>
	   		<div class="on">
	   			<span>订单</span>
	   		</div>
	   		<div linkto="<?php echo U('Goods/goodlist');?>">
	   			<span>商品</span>
	   		</div>
		</footer>
    </body>
	<script type="text/javascript" src="/elem/Public/Home/js/touch.min.js"></script>
	<script type="text/javascript">
		$("[ordid]").on('click',function(){
			var id = $(this).attr("ordid");
			var type = $(this).attr("gotype");
			if (id && type && id != "" && type != "") {
				$.ajax({
					"url" : "<?php echo U('Index/updorder');?>",
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
		});
	</script>
</html>