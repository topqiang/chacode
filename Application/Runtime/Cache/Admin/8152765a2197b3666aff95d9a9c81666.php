<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>后台管理系统</title>
	<link rel="stylesheet" href="/chacode/Public/Admin/css/reset.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="/chacode/Public/Admin/css/style.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="/chacode/Public/Admin/css/invalid.css" type="text/css" media="screen" />
	<script type="text/javascript" src="/chacode/Public/Admin/js/jquery-1.9.1.min.js"></script>
</head>
<body>
<div id="main-content">
	<div class="content-box">
		<!--头部切换-->
		<div class="content-box-header">
			<h3>订单列表</h3>
			<!-- <ul class="content-box-tabs">
                <li><a href="<?php echo U('Order/orderList',array('type'=>'2'));?>" <?php if(($tab_type) == "4"): ?>class="default-tab"<?php endif; ?>>今日未完成订单</a></li>
                <li><a href="<?php echo U('Order/orderList');?>" <?php if(($tab_type) == "1"): ?>class="default-tab"<?php endif; ?>>未完成订单</a></li>
                <li><a href="<?php echo U('Order/oldList',array('type'=>'1'));?>" <?php if(($tab_type) == "3"): ?>class="default-tab"<?php endif; ?>>今日已完成</a></li>
                <li><a href="<?php echo U('Order/oldList');?>" <?php if(($tab_type) == "2"): ?>class="default-tab"<?php endif; ?>>已完成订单</a></li>
			</ul> -->
			<div class="clear"></div>
		</div>

		<div class="content-search" style="height: 40px;margin: 10px 0 0 10px;">
			<form action="<?php echo U('Order/orderlist');?>" method="post">
				订单号：<input type="text" name="ordname" class="text-input" value="<?php echo ($_REQUEST['ordname']); ?>">
				订单人姓名：<input type="text" name="addname" class="text-input" value="<?php echo ($_REQUEST['addname']); ?>">
				订单人电话：<input type="text" name="tel" class="text-input" value="<?php echo ($_REQUEST['tel']); ?>">
				订单状态：
				<select name="type">
					<option value="" <?php if(empty($_REQUEST)): ?>selected<?php endif; ?>>不限</option>
					<option value="1" <?php if($_REQUEST['type'] == 1): ?>selected<?php endif; ?>>待发货</option>
					<option value="2" <?php if($_REQUEST['type'] == 2): ?>selected<?php endif; ?>>待收货</option>
					<option value="3" <?php if($_REQUEST['type'] == 3): ?>selected<?php endif; ?>>已完成</option>
					<option value="4" <?php if($_REQUEST['type'] == 4): ?>selected<?php endif; ?>>已评价</option>
				</select>
				<input type="submit" class="button search-btn" value="查询">
			</form>
		</div>
		
		<!--表格内容-->
		<div class="content-box-content">
			<div class="tab-content default-tab" id="tab1">
				<form action="<?php echo U('AdminBasic/delList',array('tname'=>''));?>" method="post">
					<table border="1">
						<!--标题-->
						<thead>
						<tr>
							<th width="5%">订单号</th>
							<th width="5%">姓名</th>
							<th width="8%">电话</th>
							<th width="17%">地址</th>
							<th width="6%">付款方式</th>
							<th width="5%">状态</th>
							<th width="5%">总价</th>
							<th width="6%">配送方式</th>
							<th width="18%">预约时间</th>
							<th width="10%">备注</th>
							<th width="15%">操作</th>
						</tr>
						</thead>
						<!--内容-->
						<tbody>
						<?php if(empty($orders)): ?><tr><td colspan="11">没有符合条件的结果</td></tr><?php endif; ?>
						<?php if(is_array($orders)): $i = 0; $__LIST__ = $orders;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$order): $mod = ($i % 2 );++$i;?><tr>
								<td><?php echo ($order["ordname"]); ?></td>
								<td><?php echo ($order["addname"]); ?></td>
								<td><?php echo ($order["tel"]); ?></td>
								<td><?php echo ($order["detailadd"]); ?></td>
                                <td>
                                	<?php if($order['paytype'] == 1): ?>微信支付
                                	<?php elseif($order['paytype'] == 0): ?>货到付款<?php endif; ?>
                                </td>
                                 <td>
                                	<?php if($order['type'] == 0): ?><font style="color:red">待付款</font>
										<?php elseif($order['type'] == 1): ?><font style="color:#ff37bf">待发货</font>
										<?php elseif($order['type'] == 2): ?><font style="color:blue">待收货</font>
										<?php elseif($order['type'] == 3): ?><font style="color:green">已完成</font>
										<?php else: ?>已评价<?php endif; ?>
                                </td>
                                 <td>
                                	￥<?php echo ($order["paymoney"]); ?>
                                </td>
								<td>
									<?php if($order['delivertype'] == 1): ?>送货上门
                                		<?php elseif($order['delivertype'] == 0): ?>到店自提<?php endif; ?>
								</td>
								<td><?php echo ($order["delidate"]); ?></td>
								<td><?php echo ($order["remark"]); ?></td>
								<td class="playorder">
									<?php if($order['type'] == 1): ?><a oid="<?php echo ($order["oid"]); ?>" type="2" title="发货" class="button ">发货</a>
									<?php elseif(($order['type'] == 2) AND ($order['delivertype'] == 0)): ?>
										<a oid="<?php echo ($order["oid"]); ?>" type="3" title="发货" class="button">提货</a>
										<?php elseif($order['type'] == 0): ?>
										<a oid="<?php echo ($order["oid"]); ?>" type="9" title="取消" class="button">取消</a><?php endif; ?>
                                    <a oid="<?php echo ($order["oid"]); ?>" title="详情" class="button getinfo">详情</a>
								</td>
							</tr><?php endforeach; endif; else: echo "" ;endif; ?>
						<!--表尾-->
						</tbody>
						<tfoot>
						<tr>
							<td colspan="20">
								<div class="pagination">
									<?php echo ($page); ?>
								</div>
								<div class="clear"></div>
							</td>
						</tr>
						</tfoot>
					</table>
				</form>
			</div>
		</div>
	</div>
</div>
<div class="goodslist" style="padding:10px;display:none">
</div>
</body>
<script type="text/javascript" src="/chacode/Public/Admin/js/layer/layer.js"></script>
<script type="text/javascript">
	$(function(){
		$(".playorder a[type]").on("click",function(){
			var self = $(this);
			var id = self.attr("oid");
			var type = self.attr("type");
			var order = {"id" :id ,"type" :type};
			if (type == 3) {
				var getcode = prompt("提货码","请输入提货码");
				order.getcode = $.trim(getcode);
			};
			if (type == 9) {
				var flag = confirm("您确认要取消该订单吗？取消后将不能恢复！");
				if (!flag) {
					return;
				};
			};
			$.ajax({
				"url" : "<?php echo U('Order/updorder');?>",
				"type" : "post",
				"data" : {"order" :order},
				"dataType" : "json",
				"success" : function(data){
					console.log(data);
					if (data != "error") {
						location.reload();
					}
				}
			})
		});

		$(".getinfo").on( 'click' ,function(){
			var self = $(this);
			var oid = self.attr('oid');
			$.ajax({
				url : "<?php echo U('Order/getinfo');?>",
				data : {"oid" : oid},
				type : "post",
				dataType : "json",
				success : function(goods){
					if (goods != "error") {
						var jsonlist = JSON.parse(goods);
						var goods = $(".goodslist").html("");
						var str = '<tr><th>名称</th><th>数量</th><th>价格</th><th>详情</th><th>备注</th></tr>';
						var length = jsonlist.length;
						for(var i = 0 ; i < length ; i++){
							var good = jsonlist[i];
							str += '<tr><td>'+good.name+'</td><td>'+good.gnum+'</td><td>'+good.gprice+'</td><td>'+good.constituent+'</td><td>'+good.remark+'</td></tr>';
						}
						$("<table/>").html(str).appendTo(goods);
						layer.open({
							"title" : false,
							"type" : 1,
							"area" : ['400px','auto'],
							"content": goods
						});
					}else{
						alert("查询失败！");
					}
				}
			});

		});
	});
</script>
</html>