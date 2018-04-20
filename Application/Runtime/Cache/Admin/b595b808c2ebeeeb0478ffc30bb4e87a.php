<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">

    <title> JMoocTest - 后台</title>

    <meta name="keywords" content="">
    <meta name="description" content="">

    <link rel="shortcut icon" href="/Public/favicon.ico"> <!--网页图标-->
	<link href="/Public/Admin/css/bootstrap.min.css?v=3.3.6" rel="stylesheet">
    <link href="/Public/Admin/css/font-awesome.min.css?v=4.4.0" rel="stylesheet"> <!--字体矢量图标，引入此行即可-->
    <link href="/Public/Admin/css/animate.css" rel="stylesheet">  <!--动画效果-->
    <link href="/Public/Admin/css/style.css?v=4.1.0" rel="stylesheet">
    <style>
        .navbar-header{
            width:40%;
        }
    </style>
</head>

<body class="fixed-sidebar full-height-layout gray-bg" style="overflow:hidden">
    <div id="wrapper">
        <!--左侧导航开始-->
        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="nav-close"><i class="fa fa-times-circle"></i>
            </div>
            <div class="sidebar-collapse">
                <ul class="nav" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="##">
                                <span class="clear">
                                    <span class="block m-t-xs" style="font-size:20px;">
                                        <i class="fa fa-area-chart"></i>
                                        <strong class="font-bold">JmoocTest</strong>
                                    </span>
                                </span>
                            </a>
                        </div>
                        <div class="logo-element">JMoocTest</div>
                    </li>

                    <?php if(is_array($auth_info1)): foreach($auth_info1 as $key=>$v): ?><li class="hidden-folded padder m-t m-b-sm text-muted text-xs">
                        <span class="ng-scope"><?php echo ($v["name"]); ?></span>
                    </li>
                    <?php if(is_array($auth_info2)): foreach($auth_info2 as $key=>$vv): if( $v["id"] == $vv["pid"] ): ?><li>
                        <a class="J_menuItem" href="/manager.php/<?php echo ($vv["auth_c"]); ?>/<?php echo ($vv["auth_a"]); ?>.html">
                            <i class="fa fa-home"></i>
                            <span class="nav-label"><?php echo ($vv["name"]); ?></span>
                        </a>
                    </li><?php endif; endforeach; endif; ?>                  
                    <li class="line dk"></li><?php endforeach; endif; ?>
                </ul>
            </div>
        </nav>
        <!--左侧导航结束-->
        <!--右边部分开始-->
        <div id="page-wrapper" class="gray-bg dashbard-1">
			<!--右上部分开始-->
            <div class="row border-bottom">
                <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                    <div class="navbar-header"><a class="navbar-minimalize minimalize-styl-2 btn btn-info " href="#"><i class="fa fa-bars"></i> </a>
                        <form role="search" class="navbar-form-custom" method="post" action="#">
                            <div class="form-group">
                                <input type="text" placeholder="请输入您需要查找的内容 …" class="form-control" name="top-search" id="top-search">
                            </div>
                        </form>
                    </div>
                    <ul class="nav navbar-top-links navbar-right">	
                        <li>
                            <?php echo ($username); ?>（<?php echo ($rolename); ?>）
                        </li>
                        <li>
                            <a href="/index.php/Public/login" target="_blank">前台首页</a>
                        </li>
                        <li>
                            <a href="<?php echo U('Personal/sys_info');?>">系统信息</a>
                        </li>
                        <li>
                            <a href="<?php echo U('Public/loginout');?>">退出登录</a>
                        </li>
                    </ul>
                </nav>
            </div>
			<!--右上部分结束-->

			<!--右下部分开始-->
            <div class="row J_mainContent" id="content-main">
                <iframe id="J_iframe" width="100%" height="100%" src="<?php echo U('Personal/show');?>" frameborder="0" data-id="personal.html" seamless></iframe>
            </div>
			<!--右下部分结束-->
        </div>
		<!--上面部分结束-->
        
    </div>

    <!-- 全局js -->
    <script src="/Public/Admin/js/jquery.min.js?v=2.1.4"></script>  <!--？后面表示 避免客户端缓存脚本,导致无法更新-->
    <script src="/Public/Admin/js/bootstrap.min.js?v=3.3.6"></script>
    <script src="/Public/Admin/js/plugins/metisMenu/jquery.metisMenu.js"></script> <!-- 导航栏的插件 -->
    <script src="/Public/Admin/js/plugins/slimscroll/jquery.slimscroll.min.js"></script> <!--滚动条插件 -->
    <script src="/Public/Admin/js/plugins/layer/layer.js"></script> <!--弹出框插件 -->

    <!-- 自定义js -->
    <script src="/Public/Admin/js/hAdmin.js?v=4.1.0"></script>
    <script type="text/javascript" src="/Public/Admin/js/index.js"></script>
    <!-- 第三方插件 -->
    <script src="/Public/Admin/js/plugins/pace/pace.min.js"></script> <!--进度条插件-->

</body>
</html>