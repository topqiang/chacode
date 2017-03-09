<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>后台管理系统</title>
	<link rel="stylesheet" href="/elem/Public/Admin/css/reset.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="/elem/Public/Admin/css/style.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="/elem/Public/Admin/css/invalid.css" type="text/css" media="screen" />
	<script type="text/javascript" src="/elem/Public/Admin/js/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="/elem/Public/Admin/js/simpla.jquery.configuration.js"></script>
	<script type="text/javascript" src="/elem/Public/Admin/js/facebox.js"></script>
	<script type="text/javascript" src="/elem/Public/Admin/js/jquery.wysiwyg.js"></script>
	<script type="text/javascript" src="/elem/Public/Admin/js/jquery.datePicker.js"></script>
	<script type="text/javascript" src="/elem/Public/Admin/js/jquery.date.js"></script>
</head>
<body>
<div id="main-content">
	<div class="content-box">
		<!--头部切换-->
		<div class="content-box-header">
			<h3>管理员列表</h3>
			<ul class="content-box-tabs">
				<li><a href="<?php echo U('Admin/adminList');?>" class="default-tab">管理员列表</a></li>
				<li><a href="<?php echo U('Admin/adminAdd');?>">添加管理员</a></li>
			</ul>
			<div class="clear"></div>
		</div>
		<!--表格内容-->
		<div class="content-box-content">
			<div class="tab-content default-tab" id="tab1">
				<form action="<?php echo U('AdminBasic/delList',array('tname'=>'Admin'));?>" method="post">
					<table border="1">
						<!--标题-->
						<thead>
						<tr>
							<th width="5%">
								<input class="check-all" type="checkbox" />
							</th>
							<th width="10%">ID</th>
							<th width="20%">管理员名称</th>
							<th width="30%">创建时间</th>
							<th width="10%">操作</th>
						</tr>
						</thead>
						<!--内容-->
						<tbody>
						<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
								<td><input type="checkbox" name="aid[]" value="<?php echo ($vo['aid']); ?>"/></td>
								<td><?php echo ($vo["aid"]); ?></td>
								<td><?php echo ($vo["account"]); ?></td>
								<td><?php echo (date("Y-m-d",$vo["ctime"])); ?></td>
								<td>
									<a href="<?php echo U('Admin/adminEdit',array('aid'=>$vo['aid']));?>" title="编辑"><img src="/elem/Public/Admin/images/icons/pencil.png" alt="Edit" /></a>
									<a href="<?php echo U('Admin/adminDel',array('aid'=>$vo['aid']));?>" title="删除"><img src="/elem/Public/Admin/images/icons/cross.png" alt="Delete" /></a>
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
</body>
</html>