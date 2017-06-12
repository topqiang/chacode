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
				商品名称：<input type="text" name="name" class="text-input" value="<?php echo ($_REQUEST['name']); ?>">
				批次：<input type="text" name="creatcode" class="text-input" value="<?php echo ($_REQUEST['creatcode']); ?>">
				开始时间：<input class="text-input" type="date" name="b_time" value="<?php echo ($_REQUEST['b_time']); ?>"/>
				结束时间：<input class="text-input" type="date" name="e_time" value="<?php echo ($_REQUEST['e_time']); ?>"/>
				
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
							<th width="20%">生产日期</th>
							<th width="20%">防伪区间</th>
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
								<td><?php echo ($vo["ctime"]); ?></td>
								<td><?php echo ($vo["company"]); ?></td>
								<td><?php echo ($vo["creatcode"]); ?></td>
                                <td>
                                	<?php if(empty($vo['company'])): ?><a id="<?php echo ($vo['id']); ?>" gname="<?php echo ($vo["name"]); ?>" class="creatcode" title="生成防伪码">
	                                        <img src="/chacode/Public/Admin/images/icons/code.png" alt="生成防伪码" />
	                                    </a><?php endif; ?>
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
		<form>
		<div><input type="text" class="codenum text-input" placeholder="请输入初始编码"/></div>
		<div><input type="number" class="start text-input" placeholder="请输入起始序号"/></div>
		<div><input type="number" class="cnum text-input" placeholder="请输入生成数量"/></div>
		<div><input type="tel" class="ptest text-input" placeholder="省级经销商手机号"/></div>

		</form>
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
		var gname = $(this).attr("gname");

		var index = layer.open({
			type:1,
			title: '请输入防伪码',
			btn: ['生成'],
			yes: function () {
				var keywords = $(".codenum").val();
				var start = $(".start").val();
				var cnum = $(".cnum").val();
				var ptest = $(".ptest").val();
				var test = /^[1-9]\d{0,5}$/;
				console.log(parseInt(cnum)+parseInt(start)-1);
				if (!(test.test(start) && test.test(cnum) && test.test(parseInt(cnum)+parseInt(start)-1))) {
					layer.msg("请输入6位以内有效数字且相加后小于6位数！");
					return;
				}
				if ( !/^1{1}[3|4|5|7|8]{1}\d{9}$/.test(ptest) ) {
					layer.msg("请输入合法手机号！");
					return;
				}
				if (/^\w{4}$/.test(keywords)) {
					var load = layer.open({type:3});
					$.ajax({
						"url":"<?php echo U('Admin/Goods/qrcode');?>",
						"type":"post",
						"data":{"id":id,"codenum":keywords.toUpperCase(),"start":start,"cnum":cnum,"ptest":ptest,"gname":gname},
						"dataType":"json",
						"success":function ( res ) {
							layer.close(load);

							if (res.flag == "success") {
								//$("#codeimg").attr("src","/chacode"+res.data.code_pic);
								
								// layer.open({
								// 	type:1,
								// 	title:"右键另存为吧！",
								// 	content: $('#imgcode'),
								// 	area:["400px",""]
								// });
								layer.msg("生成成功！请去二维码列表下载，或通过ftp批量下载吧！");
								setTimeout(function () {
									window.location.reload();
								});
							}else{
								layer.msg(res.message);
							}
						}
					});
					//layer.msg("后台生成中！请稍后查看！");
					//layer.close( index );
				}else{
					layer.msg("初始编码应为4位数字");
				}
			},
			content: $('#sou'),
			area:["300px","auto"]
		});  
	});
</script>
</html>