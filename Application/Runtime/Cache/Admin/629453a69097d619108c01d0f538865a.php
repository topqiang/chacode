<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>后台管理系统</title>
    <link rel="stylesheet" href="/chacode/Public/Admin/css/reset.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="/chacode/Public/Admin/css/style.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="/chacode/Public/Admin/css/invalid.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="/chacode/Public/Admin/css/expand.css" type="text/css" media="screen" />
    <script type="text/javascript" src="/chacode/Public/Admin/js/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="/chacode/Public/Admin/js/facebox.js"></script>
    <script type="text/javascript" src="/chacode/Public/Admin/js/jquery.wysiwyg.js"></script>
    <script type="text/javascript" src="/chacode/Public/Admin/js/trivial.jquery.js"></script>
    <script type="text/javascript" src="/chacode/Public/Admin/js/simpla.jquery.configuration.js"></script>
    <script type="text/javascript" src="/chacode/Public/Admin/js/ajax_operate.js"></script>
</head>
<body>
<!--主页面-->
<div id="main-content">
    <div class="content-box">
        <!--提示-->
        <div class="notification success png_bg" style="display:none">
            <div></div>
        </div>
        <div class="notification error png_bg n-error" style="display:none">
            <div></div>
        </div>
        <!--头部切换-->
        <div class="content-box-header">
            <h3>菜单列表</h3>
            <ul class="content-box-tabs">
                <li><a href="#tab1" class="default-tab">列表</a></li>
                <li><a href="#tab2">新增</a></li>
            </ul>
            <div class="clear"></div>
        </div>
        <!--表格内容-->
        <div class="content-box-content">
            <!--内容表格 start-->
            <div class="tab-content default-tab" id="tab1">
                <form action="<?php echo U('WeiXinArticle/doCreateMenu');?>" method="post">
                <table border="1">
                    <!--标题 start-->
                    <thead>
                    <tr>
                        <th width="">显示顺序</th>
                        <th width="">菜单名称</th>
                        <th width="">关联关键词</th>
                        <th width="">外链URL</th>
                        <th width="">父级菜单</th>
                        <th width="10%">操作</th>
                    </tr>
                    </thead>
                    <!--标题 end-->
                    <!--内容 start-->
                    <tbody>
                    <?php if(is_array($menu_list)): $i = 0; $__LIST__ = $menu_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i;?><tr>
                            <td><?php echo ($menu['sort']); ?></td>
                            <td>
                                <?php echo ($menu['name']); ?>
                            </td>
                            <td>
                                <?php echo ($menu['keywords']); ?>
                            </td>
                            <td>
                                <?php echo ($menu['url']); ?>
                            </td>
                            <td>
                                <?php if($menu['parent_id'] == '0'): ?>一级菜单
                                <?php else: ?>
                                    <?php echo ($menu['parent_id']); endif; ?>
                            </td>
                            <td>
                                <a href="<?php echo U('WeiXinArticle/editMenu',array('id'=>$menu['id']));?>" title="编辑">
                                    <img src="/chacode/Public/Admin/images/icons/pencil.png" width="16" height="18" alt="编辑" />
                                </a>&nbsp;
                                <a href="###" class="del" title="删除">
                                    <img src="/chacode/Public/Admin/images/icons/cross.png" alt="删除" />
                                </a><input type="hidden" value="<?php echo U('WeiXinArticle/delMenu',array('id'=>$menu['id']));?>">
                            </td>
                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                    </tbody>
                    <!--内容 end-->
                    <!--表尾 start-->
                    <tfoot>
                    <tr>
                        <td colspan="10" style="padding: 20px 0 20px 0">
                            AppId：<input class="text-input small-input" type="text" name="AppId" value="<?php echo ($access_token['app_id']); ?>"/>　　　
                            AppSecret：<input class="text-input small-input" type="text" name="AppSecret" value="<?php echo ($access_token['app_secret']); ?>"/><a></a>
                            　　<span style="color: red">服务号才能获得AppId和AppSecret</span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="10">
                            <input class="button add-btn" type="submit" value="生成自定义菜单" />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="20">
                            <div class="bulk-actions align-left" style="color: red">
                                注：&nbsp;第一步：添加菜单<br>　　
                               第二步：必须填写【AppId】【 AppSecret】<br>　　
                               第三步：点击生成!<br>　　
                               注　意：1级菜单最多只能开启3个，2级子菜单最多开启5个。官方说明：修改后，需要重新关注，或者最迟隔天才会看到修改后的效果！<br>
                               　　 重　要：请勿频繁生成自定义菜单，否则会影响您的服务号的使用
                            </div>
                            <div class="clear"></div>
                        </td>
                    </tr>
                    </tfoot>
                    <!--表尾 end-->
                </table>
                </form>
            </div>
            <!--内容表格 end-->

            <!--表单 start-->
            <div class="tab-content form" id="tab2">
                <form action="<?php echo U('WeiXinArticle/createMenu');?>" method="post" class="form">
                    <fieldset>
                        <p>
                            <span class="label">父级菜单：　　</span>
                            <select name="parent_id">
                                <option value="0">一级菜单</option>
                                <?php if(is_array($sel_menu_list)): $i = 0; $__LIST__ = $sel_menu_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i;?><option value="<?php echo ($menu['id']); ?>"><?php echo ($menu['name']); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                        </p>
                        <p>
                            <span class="label">菜单名称：　　</span>
                            <input class="text-input medium-input datepicker" type="text" name="name" /><br>
                        </p>
                        <p>
                            <span class="label">关联关键词：　</span>
                            <input class="text-input medium-input datepicker" type="text" name="keywords" /><br>
                            　　　　　　　　<span style="color:#EC5B4D">关联关键词和外链URL选填一项，外链URL的优先级高</span>
                        </p>
                        <p>
                            <span class="label">外链URL：&nbsp;&nbsp;&nbsp;&nbsp;</span>
                            <input class="text-input medium-input datepicker" type="text" name="url" /><br>
                            <span style="color:#EC5B4D">　　　　　　　　请在这里填写网址(例如：http://baidu.com，记住必须有http://)</span>
                        </p>
                        <p>
                            <span class="label">排序：　　　　</span>
                            <input class="text-input medium-input datepicker" type="text" name="sort" /><br>
                            　　　　　　　　<span style="color:#EC5B4D">数值越大越靠前</span>
                        </p>
                        <p>
                            <input class="button add-btn" type="submit" value="保　存" />
                        </p>
                    </fieldset>
                    <div class="clear"></div>
                </form>
            </div>
            <!--表单 end-->
        </div>
    </div>
</div>
</body>
<script type="text/javascript">
    $(document).ready(function(){
        //删除类型
        $('.del').click(function(){
            if(confirm('确定要删除吗')){
                window.location.href = $(this).next('input').val();
            }
        });
    });
</script>
</html>