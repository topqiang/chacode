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
			<h3>商品列表</h3>
			<ul class="content-box-tabs">
				<li><a href="<?php echo U('Goods/goodsList');?>" class="default-tab current">商品列表</a></li>
				<li><a href="<?php echo U('Goods/goodsAdd');?>">添加商品</a></li>
			</ul>
			<div class="clear"></div>
		</div>

		<div class="content-search" style="height: 40px;margin: 10px 0 0 10px;">
			<form action="<?php echo U('Goods/goodsList');?>" method="post">
				商品名称：<input type="text" name="name" class="text-input">
				<input type="submit" class="button search-btn" value="查询">
			</form>
		</div>
		
		<!--表格内容-->
		<div class="content-box-content">
			<div class="tab-content default-tab" id="tab1">
				<form action="<?php echo U('AdminBasic/delList',array('tname'=>'Good'));?>" method="post">
					<table border="1">
						<!--标题-->
						<thead>
						<tr>
							<th width="5%">
								<input class="check-all" type="checkbox" />
								ID
							</th>
							<th width="15%">商品名称</th>
							<th width="10%">缩略图</th>
							<th width="20%">生成时间</th>
							<th width="20%">厂家名称</th>
							<th width="20%">批次</th>
							<th width="10%">操作</th>
						</tr>
						</thead>
						<!--内容-->
						<tbody>
						<?php if(empty($list)): ?><tr><td colspan="10">没有符合条件的结果</td></tr><?php endif; ?>
						<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
								<td>
									<input type="checkbox" name="id[]" value="<?php echo ($vo['gid']); ?>"/>
									<?php echo ($vo["id"]); ?>
								</td>
								<td>
									<?php echo ($vo["name"]); ?>
								</td>
								<td><img src="/chacode/<?php echo ($vo["pic"]); ?>" height="30" /></td>
								<td><?php echo (date("y-m-d H:m:i",$vo["ctime"])); ?></td>
								<td><?php echo ($vo["company"]); ?></td>
								<td><?php echo ($vo["creatcode"]); ?></td>
                                <td>
                                	<a id="<?php echo ($vo['id']); ?>" class="creatcode" title="生成防伪码">
                                        <img src="/chacode/Public/Admin/images/icons/code.png" alt="生成防伪码" />
                                    </a>
                                    <a href="<?php echo U('Goods/goodsEdit',array('id'=>$vo['id']));?>" title="编辑">
                                        <img src="/chacode/Public/Admin/images/icons/pencil.png" alt="Edit" />
                                    </a>
                                    <a href="<?php echo U('Goods/goodsDel',array('id'=>$vo['id']));?>" title="删除">
                                        <img src="/chacode/Public/Admin/images/icons/cross.png" alt="Delete" />
                                    </a>
								</td>
							</tr><?php endforeach; endif; else: echo "" ;endif; ?>
						<!--表尾-->
						</tbody>
						<tfoot>
						<tr>
							<td colspan="20">
								<div class="bulk-actions align-left">
									<input type="submit" value="批量删除" class="button"/>
								</div>
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
<div id="sou" style="text-align:center;display:none;">
	<div style="padding:20px;">
		<div><input type="text" class="codenum" placeholder="请输入防伪码"/></div>
	</div>
</div>
<div id="imgcode" style="text-align:center;display:none;">
	<div style="padding:20px;">
		<img id="codeimg" style="width:100%;"/>
	</div>
</div>
</body>
<script type="text/javascript" src="/chacode/Public/Admin/js/layer/layer.js"></script>
<script type="text/javascript">

	$(".creatcode").on('click',function(){
		var id = $(this).attr("id");
		var index = layer.open({
			type:1,
			title: '请输入防伪码',
			btn: ['生成'],
			yes: function () {
				var keywords = $(".codenum").val();
				if (keywords) {
					$.ajax({
						"url":"<?php echo U('Admin/Goods/qrcode');?>",
						"type":"post",
						"data":{"id":id,"codenum":keywords},
						"dataType":"json",
						"success":function ( res ) {
							if (res.flag == "success") {
								$("#codeimg").attr("src","/chacode"+res.data.code_pic);
								layer.close(index);
								layer.open({
									type:1,
									title:"右键另存为吧！",
									content: $('#imgcode'),
									area:["400px",""]
								});
							}else{
								alert(res.message);
							}
						}
					});
				}else{
					alert("关键词为空！");
				}
			},
			content: $('#sou'),
			area:["200px","auto"]
		});  
	});
</script>
</html>