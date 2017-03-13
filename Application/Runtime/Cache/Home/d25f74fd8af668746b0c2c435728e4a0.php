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
			<?php echo ($_REQUEST['provance']); ?>
		</div>
		<div class="fake-body bot1">
			<div class="shop-body">
				<div class="shop-list">
					<?php if(is_array($companylist)): $i = 0; $__LIST__ = $companylist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$comp): $mod = ($i % 2 );++$i;?><a class="shop-item" href="<?php echo U('Company/company',array('id'=>$comp['id']));?>">
							<span><?php echo ($comp["name"]); ?></span>
							<?php if($comp['class'] == 1): ?><i class="shop-item1"></i>
							<?php elseif($comp['class'] == 2): ?>
								<i class="shop-item2"></i>
							<?php elseif($comp['class'] == 3): ?>
								<i class="shop-item3"></i>
							<?php elseif($comp['class'] == 4): ?>
								<i class="shop-item4"></i>
							<?php elseif($comp['class'] == 5): ?>
								<i class="shop-item5"></i><?php endif; ?>
						</a><?php endforeach; endif; else: echo "" ;endif; ?>
				</div>	
			</div>
			<div class="fake-footer fs35">
				<p>云南西双版纳州古茶山茶业有限公司</p>
				<p>勐海龙园茶厂<span>电话：0691-5170999</span></p>
				<p>滇ICP备15000438号</p>
			</div>
		</div>

    </body>
    
</html>