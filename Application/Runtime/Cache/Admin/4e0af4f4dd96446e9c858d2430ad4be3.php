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
            <h3>文本回复</h3>
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
                <table border="1">
                    <!--标题 start-->
                    <thead>
                    <tr>
                        <th width="10%">编号</th>
                        <th width="20%">关键词</th>
                        <th width="40%">回答</th>
                        <th width="10%">匹配类型</th>
                        <th width="10%">时间</th>
                        <th width="10%">操作</th>
                    </tr>
                    </thead>
                    <!--标题 end-->
                    <!--内容 start-->
                    <tbody>
                    <?php if(is_array($text_back_list)): $i = 0; $__LIST__ = $text_back_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$text_back): $mod = ($i % 2 );++$i;?><tr>
                            <td><?php echo ($text_back['wxa_id']); ?></td>
                            <td>
                                <?php echo ($text_back['wxa_keywords']); ?>
                            </td>
                            <td>
                                <?php echo ($text_back['wxa_description']); ?>
                            </td>
                            <td>
                                <?php if($text_back['wxa_keywords_type'] == 1): ?>完全匹配
                                <?php else: ?>
                                    包含匹配<?php endif; ?>
                            </td>
                            <td>
                                <?php echo (date('Y-m-d',$text_back['ctime'])); ?>
                            </td>
                            <td>
                                <a href="<?php echo U('WeiXinArticle/editTextBack',array('wxa_id'=>$text_back['wxa_id']));?>" title="编辑">
                                    <img src="/chacode/Public/Admin/images/icons/pencil.png" width="16" height="18" alt="编辑" />
                                </a>&nbsp;
                                <a href="###" class="del" title="删除">
                                    <img src="/chacode/Public/Admin/images/icons/cross.png" alt="删除" />
                                </a><input type="hidden" value="<?php echo U('WeiXinArticle/delWeiXinArticle',array('wxa_id'=>$text_back['wxa_id']));?>">
                            </td>
                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                    </tbody>
                    <!--内容 end-->
                    <!--表尾 start-->
                    <tfoot>
                    <tr>
                        <td colspan="20">
                            <div class="bulk-actions align-left">
                            </div>
                            <div class="pagination">
                                <?php echo ($page); ?>
                            </div>
                            <div class="clear"></div>
                        </td>
                    </tr>
                    </tfoot>
                    <!--表尾 end-->
                </table>
            </div>
            <!--内容表格 end-->

            <!--表单 start-->
            <div class="tab-content form" id="tab2">
                <form action="<?php echo U('WeiXinArticle/addTextBack');?>" method="post" class="form">
                    <fieldset>
                        <p>
                            <span class="label">关键词：　　</span>
                            <input class="text-input medium-input datepicker" type="text" name="wxa_keywords" /><br>
                            　　　　　　　<span style="color:#EC5B4D">多个关键词用空格隔开</span>
                        </p>
                        <p>
                            <span class="label">关键词类型：</span>
                            <input type="radio" name="wxa_keywords_type" value="1" checked/>完全匹配
                            <input type="radio" name="wxa_keywords_type" value="0"/>包含匹配
                        </p>
                        <p>
                            <span class="label">回答内容：　</span>
                            <textarea class="text-input textarea" name="wxa_description"></textarea><br>
                            　　　　　　　<span style="color:#EC5B4D">请不要多于1000字。超链接范例：
                            <input class="text-input medium-input" type="text" value='<a href="http://www.baidu.com">百度</a>' style="border:none;color:#EC5B4D" disabled/>
                        </span>
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