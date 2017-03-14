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
            防伪查询
        </div>
	<div class="fake-body bot1">
	    <div class="">
			<div class="query-body">
				<div class="query-code">
					<input class="code_name" type="text" value="<?php echo ($_REQUEST['code_name']); ?>" placeholder="请输入防伪码"/>
				    <span class="postbtn">查询</span>
				</div>
				<div class="query-note fs35 result-note">
					<?php if(!empty($res)): ?><div class="result-head">查询结果</div>
						<div class="result-detail">
							<div class="result-img">
								<img src="/chacode/<?php echo ($res["code_pic"]); ?>"/>
							</div>
							<p>您输入的“<?php echo ($res['codenum']); ?>”是“<?php echo ($res["name"]); ?>”产品，产品为正品。</p>
						</div>
						<div class="result-intro">
							<p>
								<span>批次</span>
								<?php echo ($res["creatcode"]); ?>
							</p>
							<p>
								<span>品名</span>
								<?php echo ($res["name"]); ?>
							</p>
							<p>
								<span>生产日期</span>
								<?php echo (date("Y/m/d",$res["ctime"])); ?>
							</p>
							<p>
								<span>厂家</span>
								<?php echo ($res["name"]); ?>
							</p>
						</div>
						<?php else: ?>
						<span class="" style="padding:20px;display:block">您输入的”<?php echo ($_REQUEST['code_name']); ?>“没有对应的产品信息，请谨防假冒。
						<a href="<?php echo U('Report/report');?>">举报</a></span><?php endif; ?>


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
		$(".postbtn").on('click',function () {
			var code_name = $(".code_name").val();
			if (code_name == "") {
				alert("防伪码不能为空！");
			}else{
				window.location.href = '<?php echo U("Home/Qcode/findcode");?>/code_name/'+code_name;
			}
		})

	</script>

</html>