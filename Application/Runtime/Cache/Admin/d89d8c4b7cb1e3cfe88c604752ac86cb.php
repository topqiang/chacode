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
			<h3>举报列表</h3>
			<div class="clear"></div>
		</div>

		<div class="content-search" style="height: 40px;margin: 10px 0 0 10px;">
			<form action="<?php echo U('Report/reportlist');?>" method="post">
				举报人姓名：<input type="text" name="name" class="text-input" value="<?php echo ($_REQUEST['name']); ?>">
				电话：<input type="text" name="tel" class="text-input" value="<?php echo ($_REQUEST['tel']); ?>">
				状态：<select name="status">
						<option></option>
						<option value="2">未处理</option>
						<option value="1">已处理</option>
					</select>
				<input type="submit" class="button search-btn" value="查询">
			</form>
		</div>
		
		<!--表格内容-->
		<div class="content-box-content">
			<div class="tab-content default-tab">
				<form action="<?php echo U('AdminBasic/delList',array('type'=>'real','tname'=>'Report'));?>" method="post">
					<table border="1">
						<!--标题-->
						<thead>
						<tr>
							<th width="5%">
								<input class="check-all" type="checkbox" />
								ID
							</th>
							<th width="10%">举报人姓名</th>
							<th width="15%">联系电话</th>
							<th width="10%">备注</th>
							<th width="15%">图片</th>
							<th width="10%">状态</th>
							<th width="10%">创建时间</th>
							<th width="15%">修改时间</th>
							<th width="10%">操作</th>
						</tr>
						</thead>
						<!--内容-->
						<tbody>
						<?php if(empty($list)): ?><tr><td colspan="10">没有符合条件的结果</td></tr><?php endif; ?>
						<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
								<td>
									<input type="checkbox" name="id[]" value="<?php echo ($vo['id']); ?>"/><?php echo ($vo["id"]); ?>
								</td>
								<td><?php echo ($vo["name"]); ?></td>
								<td><?php echo ($vo["tel"]); ?></td>
								<td><?php echo ($vo["remark"]); ?></td>
								<td><img src="<?php echo ($vo["pic"]); ?>" style="width:50px;"/></td>
								<td>
									<?php if($vo['status'] == 0): ?>未处理
									<?php else: ?>已处理<?php endif; ?>
								</td>
								<td><?php echo (date("y-m-d H:m:i",$vo["c_time"])); ?></td>
								<td><?php echo (date("y-m-d H:m:i",$vo["u_time"])); ?></td>
								<td>
                                    <a href="<?php echo U('Report/reportedit',array('id'=>$vo['id']));?>" title="处理">
                                        <img src="/chacode/Public/Admin/images/icons/pencil.png" alt="处理" />
                                    </a>
                                    <a href="<?php echo U('Report/reportdel',array('id'=>$vo['id']));?>" title="删除">
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
</body>
</html>