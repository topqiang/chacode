<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
    <title>后台管理中心</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
</head>
<frameset rows="0,*"  frameborder="NO" border="0" framespacing="0">
    <frame src="<?php echo U('Index/top');?>" noresize="noresize" frameborder="NO" name="topFrame" scrolling="no" marginwidth="0" marginheight="0" target="main" />
    <frameset cols="200,*" id="frame">
        <frame src="<?php echo U('Index/left');?>" name="leftFrame" noresize="noresize" marginwidth="0" marginheight="0" frameborder="0" scrolling="no" target="main" />
        <frame src="<?php echo U('User/userlist');?>" name="main" marginwidth="0" marginheight="0" frameborder="0" scrolling="auto" target="_self" />
    </frameset>
</frameset>
<noframes>
<body></body>
</noframes>
</html>