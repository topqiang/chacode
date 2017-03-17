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
			<h3>经销商列表</h3>
			<ul class="content-box-tabs">
				<li><a href="<?php echo U('Company/companyList');?>" class="default-tab current">列表</a></li>
				<li><a href="<?php echo U('Company/companyAdd');?>">添加</a></li>
			</ul>
			<div class="clear"></div>
		</div>

		<div class="content-search" style="height: 40px;margin: 10px 0 0 10px;">
			<form action="<?php echo U('Company/companyList');?>" method="post">
				名称：<input type="text" name="name" class="text-input">
				城市：<input type="text" name="provance" class="text-input">
				<input type="submit" class="button search-btn" value="查询">
			</form>
		</div>
		
		<!--表格内容-->
		<div class="content-box-content">
			<div class="tab-content default-tab" id="tab1">
				<form action="<?php echo U('AdminBasic/delList',array('tname'=>'Company'));?>" method="post">
					<table border="1">
						<!--标题-->
						<thead>
						<tr>
							<th width="5%">
								<input class="check-all" type="checkbox" />
								ID
							</th>
							<th width="10%">经销商名称</th>
							<th width="10%">负责人</th>
							<th width="10%">门店图片</th>
							<!--<th width="10%">微信号</th>
							<th width="10%">email</th>-->
							<th width="5%">销售级别</th>
							<th width="10%">所处城市</th>
							<th width="15%">代理时间</th>
							<th width="15%">地址</th>
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
								<td><?php echo ($vo["boss"]); ?></td>
								<td><img src="/Uploads/<?php echo ($vo["tel"]); ?>" style="width:50px;"/></td>
								<!--<td><?php echo ($vo["wxcode"]); ?></td>
								<td><?php echo ($vo["email"]); ?></td>-->
								<td><?php echo ($vo["class"]); ?></td>
								<td><?php echo ($vo["provance"]); ?></td>
								<td><?php echo ($vo["b_time"]); ?>--<?php echo ($vo["e_time"]); ?></td>
								<td><?php echo ($vo["address"]); ?></td>
                                <td>
                                    <a href="<?php echo U('Company/companyEdit',array('id'=>$vo['id']));?>" title="编辑">
                                        <img src="/chacode/Public/Admin/images/icons/pencil.png" alt="Edit" />
                                    </a>
                                    <a href="<?php echo U('Company/companyDel',array('id'=>$vo['id']));?>" title="删除">
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