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
            /*@media only screen and (min-width: 768px){
                .shop-body{
                    min-height: 1168px;
                }
            }
            @media only screen and (min-width: 412px){
                .shop-body{
                    min-height: 1030px;
                }
            }*/
            /*@media only screen and (min-width: 400px){
                .shop-body{
                    min-height: 1430px;
                }
            }*/
            /*@media only screen and (min-width: 360px){
                .shop-body{
                    min-height: 1200px;
                }
            }*/
        </style>
    </head>
    <body>
        
		<div class="fake-head pad732 fs40">
			<span></span>
			<?php echo ($company["name"]); ?>
		</div>
		<div class="fake-body bot1">
			<div class="shop-body">
				<div class="result-intro shop-intro">
					<p>
						<span>地址</span>
						<?php echo ($company["address"]); ?>
					</p>
					<p>
						<span>负责人</span>
						<?php echo ($company["boss"]); ?>
					</p>
					<p>
						<span>电话</span>
						<?php echo ($company["tel"]); ?>
					</p>
					<p>
						<span>微信号</span>
						<?php echo ($company["wxcode"]); ?>
					</p>
					<p>
						<span>电子邮件</span>
						<?php echo ($company["email"]); ?>
					</p>
					<p>
						<span>经销商级别</span>
						<?php if($company['class'] == 1): ?>一级
						<?php elseif($company['class'] == 2): ?>
							二级
						<?php elseif($company['class'] == 3): ?>
							三级
						<?php elseif($company['class'] == 4): ?>
							四级
						<?php elseif($company['class'] == 5): ?>
							五级<?php endif; ?>
					</p>
				</div>
				<div class="go-there">
					<div class="go-center">
						<i></i>
						<span>带我去这里</span>
					</div>					
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
		<?php echo ($company['lat']); ?>
		<?php echo ($company['lnt']); ?>
	</script>

</html>