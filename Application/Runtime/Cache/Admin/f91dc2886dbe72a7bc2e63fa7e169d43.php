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
			<h3>防伪列表</h3>
			<div class="clear"></div>
		</div>

		<div class="content-search" style="height: 40px;margin: 10px 0 0 10px;">
			<form action="<?php echo U('Qcode/qcodeList');?>" method="post">
				商品名称：<input type="text" name="name" class="text-input" value="<?php echo ($_REQUEST['name']); ?>">
				防伪码：<input type="text" name="codenum" class="text-input" value="<?php echo ($_REQUEST['codenum']); ?>">
				批次：<input type="text" name="creatcode" class="text-input" value="<?php echo ($_REQUEST['creatcode']); ?>">
				<input type="submit" class="button search-btn" value="查询">
			</form>
		</div>


		<!--表格内容-->
		<div class="content-box-content">
			<div class="tab-content default-tab" id="tab1">
				<form action="<?php echo U('AdminBasic/delList',array('tname'=>'Qcode','type'=>'real'));?>" method="post">
					<table border="1">
						<!--标题-->
						<thead>
						<tr>
							<th width="10%">
								<!-- <input class="check-all" type="checkbox" /> -->
								ID
							</th>
							<th width="10%">商品名称</th>
							<th width="20%">公司名</th>
							<th width="10%">批次</th>
							<th width="20%">防伪码</th>
							<th width="10%">创建时间</th>
							<th width="10%">二维码</th>
							<th width="10%">操作</th>
						</tr>
						</thead>
						<!--内容-->
						<tbody>
						<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
								<td>
									<!-- <input type="checkbox" name="id[]" value="<?php echo ($vo['id']); ?>"/> -->
									<?php echo ($vo["id"]); ?>
								</td>
								<td><?php echo ($vo["name"]); ?></td>
								<td><?php echo ($vo["company"]); ?></td>
								<td><?php echo ($vo["creatcode"]); ?></td>
								<td><?php echo ($vo["codenum"]); ?></td>
								<td><?php echo (date('Y-m-d H:m:i',$vo["ctime "])); ?></td>

								<td><img class="imgcode" src="/chacode<?php echo ($vo["code_pic"]); ?>" style="width:30px"/></td>
								<td>
									<a href="<?php echo U('Qcode/qcodeEdit',array('id'=>$vo['id']));?>" title="编辑"><img src="/chacode/Public/Admin/images/icons/pencil.png" alt="Edit" /></a>
									<a href="<?php echo U('Qcode/qcodeDel',array('id'=>$vo['id']));?>" title="删除"><img src="/chacode/Public/Admin/images/icons/cross.png" alt="Delete" /></a>
								</td>
							</tr><?php endforeach; endif; else: echo "" ;endif; ?>
						<!--表尾-->
						</tbody>
						<tfoot>
						<tr>
							<td colspan="20">
								<!-- <div class="bulk-actions align-left">
									<input type="submit" value="批量删除" class="button"/>
								</div> -->
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
<div id="imgcode" style="text-align:center;display:none;">
	<div style="padding:20px;">
		<img id="codeimg" style="width:100%;"/>
	</div>
</div>
</body>

<script type="text/javascript" src="/chacode/Public/Admin/js/layer/layer.js"></script>
<script type="text/javascript">
$(".imgcode").on('click',function () {
	$("#codeimg").attr("src",$(this).attr("src"));
	layer.open({
		type:1,
		title:"右键另存为吧！",
		content: $('#imgcode'),
		area:["400px","auto"]
	});
});
</script>
</html>