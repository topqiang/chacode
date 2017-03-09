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
    	<header class="bgz colb">
    		<span class="pfr mar10" linkto="<?php echo U('Order/orderlist');?>">订单</span>
    		<?php echo ($shop["title"]); ?>
    	</header>
		<div class="content">
			
			<div class="slider">
		      	<ul>
		      		<?php if(is_array($piclist)): $i = 0; $__LIST__ = $piclist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$pic): $mod = ($i % 2 );++$i;?><li><a href="<?php echo ($pic["linkto"]); ?>" target="_blank"><img src="<?php echo ($pic["picsrc"]); ?>" alt="" class="width"></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
		      	</ul>
		   	</div>		   	
		   	<div class="goods">

		   		<?php if(is_array($goods)): $i = 0; $__LIST__ = $goods;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$good): $mod = ($i % 2 );++$i;?><div class="good" goodid="<?php echo ($good["id"]); ?>">
		   			<div class="imgbag">
		   				<img src="<?php echo ($good["goodpic"]); ?>"/>
		   			</div>
		   			<div class="goodinfo zaocan">
		   				<div class="goodname">
		   					<?php echo ($good["goodname"]); ?>
		   				</div>
		   				<div class="level">
		   					<img src="/elem/Public/Home/img/xing.png" />
		   					<img src="/elem/Public/Home/img/xing.png" />
		   					<img src="/elem/Public/Home/img/xing.png" />
		   				</div>
		   				<div class="descrip cole">
		   					<?php echo ($good["gooddesc"]); ?>
		   				</div>
		   				<div class="payinfo">
		   					<div class="playgley fr mat5" goodprice="<?php echo ($good["price"]); ?>" goodname="<?php echo ($good["goodname"]); ?>" goodid="<?php echo ($good["id"]); ?>">
		   						<!---->
				   				<span class="iconjian disn"></span>
				   				<span class="iconmum disn">0</span>
				   				<span class="iconadd"></span>
				   			</div>
		   					<font class="fs16 colr">￥<?php echo ($good["price"]); ?></font>
		   				</div>
		   			</div>
		   		</div><?php endforeach; endif; else: echo "" ;endif; ?>
		   		
		   	</div>
		</div>
		<!--购物车遮罩层-->
		<div class="zhao disn">
			<div class="poab zhcon">
				<div class="gootitle pad0-10">
					<span class="fr cole icondel" style="padding-left:40px;">清除</span>
					<span class="bol5 pad0-10">已选列表</span>
				</div>
				<ul class="alrelist"></ul>
			</div>
		</div>
		<!--购物车     通过 类属性 on  激活购物车 -->
		<div class="gley">
			<div class="gleycon">
				<span class="icongley pore">
					<span class="poab subnum">1</span>
				</span>
				<font>
					￥<span class="money">0</span>
					<span class="nomsg fs14"> | 快来选择你喜爱的早餐吧~</span>
				</font>
			</div>
			<div class="gleybtn pfr submitbtn">
				选好了
			</div>
		</div>
    </body>
	<script type="text/javascript" src="/elem/Public/Home/js/touch.min.js"></script>
	<script type="text/javascript">
    		var w = document.documentElement?document.documentElement.clientWidth:document.body.clientWidth;
		$(".slider").yxMobileSlider({width:w,height:250,during:3000});
	</script>

	<script type="text/javascript">
		var totalnum = 0;
		var gley = {};
		var totalprice = 0;
		$(function(){
			//清空购物车
			$(".icondel").on('click',function(){
				totalnum =0;
				totalprice = 0;
				gley = {};
				freshgley();
				$(".alrelist").html("");
				$(".iconjian").addClass("disn");
				$(".iconmum").text(0).addClass("disn");
			});
			//订单提交
			$(".gleybtn").on('click',function(){
				if (totalnum == 0) {
					alert("所选商品不能为空哦！");
				}else if (totalprice == 0){
					alert("你很淘气哦！");
				}else{
					setorder();
				}
			});
			//调用绑定事件
			goodlistevent();
		});

		//提交订单
		function setorder(){
			$.ajax({
				"url":"<?php echo U('Order/addorder');?>",
				"type":"post",
				"data":{"totalprice" : totalprice/100,"gley":gley,"totalnum":totalnum},
				"dataType":"json",
				"success":function(res){
					res = JSON.parse(res);
					console.log(res.code);
					if (res.code == 0) {
						alert(res.msg);
					}else if(res.code == 1){
						window.location.href = "<?php echo U('Order/orderinfo');?>/id/"+res.oid;
					}
				}
			});
		}


		function goodlistevent(){
			$(".iconadd").off("click");
			$(".iconjian").off("click");
			$(".iconadd").on("click",function(){
				var $self = $(this);
				var goodid = $self.parent().attr("goodid");
				var goodname = $self.parent().attr("goodname");
				var goodprice = $self.parent().attr("goodprice")*100;
				if (gley[goodid] && gley[goodid] != 0) {
					gley[goodid] = gley[goodid] + 1;
				}else{
					gley[goodid] = 1;
					$self.siblings().removeClass("disn");
					putgley(goodid,goodprice,goodname);
				}
				totalprice += goodprice;
				++totalnum;
				$("[goodid="+goodid+"] .iconmum").text(gley[goodid]);
				freshgley();
			});
			$(".iconjian").on("click",function(){
				var $self = $(this);
				var goodid = $self.parent().attr("goodid");
				var goodprice = $self.parent().attr("goodprice")*100;
				if (gley[goodid] && gley[goodid] != 0) {
					gley[goodid] = gley[goodid] - 1;
					if (gley[goodid] == 0) {
						$("[goodid="+goodid+"]").find(".iconjian").addClass("disn");
						$("[goodid="+goodid+"]").find(".iconmum").addClass("disn");
						$(".alrelist [goodid="+goodid+"]").parents("li").remove();
						delete gley[goodid];
					}
					totalprice -= goodprice;
					--totalnum;
					$("[goodid="+goodid+"] .iconmum").text(gley[goodid]);
					freshgley();
				}
			});
		}
		//推进已选列表
		function putgley(goodid,goodprice,goodname){
			var str ='<div class="iconlu">'
							+'<span>'+goodname+'</span>'
							+'<div class="playgley fr" goodid="'+goodid+'" goodprice="'+(goodprice/100)+'" goodname="'+goodname+'">'
				   				+'<span class="iconjian"></span>'
				   				+'<span class="iconmum">'+gley[goodid]+'</span>'
				   				+'<span class="iconadd"></span>'
				   			+'</div>'
							+'<span class="fr mar60 colz">￥'+(goodprice/100)+'</span>'
						+'</div>';
			$("<li/>").html(str).appendTo(".alrelist");
			goodlistevent();
		}

		//更新购物车
		function freshgley(goodid){
			if (totalnum > 0) {
				$(".gley").addClass("on");
			}else{
				$(".zhao").addClass("disn");
				$(".gley").removeClass("on");
			}
			$(".money").text(totalprice/100);
			$(".subnum").text(totalnum);
		}
	</script>
</html>