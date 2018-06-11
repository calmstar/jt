<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">

    <title> JMoocTest</title>

    <meta name="keywords" content="">
    <meta name="description" content="">

    <link rel="shortcut icon" href="/Public/favicon.ico"> <!--网页图标-->
	<link href="/Public/Admin/css/bootstrap.min.css?v=3.3.6" rel="stylesheet">
    <link href="/Public/Admin/css/font-awesome.min.css?v=4.4.0" rel="stylesheet"> <!--字体矢量图标，引入此行即可-->
    <link href="/Public/Admin/css/animate.css" rel="stylesheet">  <!--动画效果-->
    <link href="/Public/Admin/css/style.css?v=4.1.0" rel="stylesheet">
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
                                        <strong class="font-bold">JmoocTest</strong>
                                    </span>
                                </span>
                            </a>
                        </div>
                        <div class="logo-element">JMoocTest</div>
                    </li>

                    <!-- 导航栏目开始 -->
                    <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">
                        <span class="ng-scope">个人中心</span>
                    </li>
                    <li>
                        <a class="J_menuItem" href="<?php echo U('Announce/show');?>">
                            <i class="fa fa-info-circle"></i>
                            <span class="nav-label">信息公告</span>
                        </a>
                    </li>
                    <li>
                        <a class="J_menuItem" href="<?php echo U('Personal/show');?>">
                            <i class="fa fa-user"></i>
                            <span class="nav-label">个人资料</span>
                        </a>
                    </li>
                    <li class="line dk"></li>
                    <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">
                        <span class="ng-scope">我的考务</span>
                    </li>
                    <li>
                        <a class="J_menuItem" href="<?php echo U('Test/show');?>">
                            <i class="fa fa-hourglass-half"></i>
                            <span class="nav-label">在线考试</span>
                        </a>
                    </li>
                    <li>
                        <a class="J_menuItem" href="<?php echo U('Paper/show');?>">
                            <i class="fa fa-search"></i>
                            <span class="nav-label">分数查询</span>
                        </a>
                    </li>
                    <li class="line dk"></li>
                    <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">
                        <span class="ng-scope">自我测试</span>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fa fa-pencil"></i>
                            <span class="nav-label">练习单选题</span>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level">
                            <?php if(is_array($cou_info)): foreach($cou_info as $key=>$v): ?><li>
                                <?php if( $v["sin_status"] == 1 ): ?><a class="J_menuItem" href="/index.php/Practice/sin_show/cou_id/<?php echo ($v["id"]); ?>"><?php echo ($v["name"]); ?></a><?php endif; ?>
                            </li><?php endforeach; endif; ?>
                        </ul>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fa fa-pencil-square"></i>
                            <span class="nav-label">练习双选题</span>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level">
                            <?php if(is_array($cou_info)): foreach($cou_info as $key=>$v): ?><li>
                                <?php if( $v["dou_status"] == 1 ): ?><a class="J_menuItem" href="/index.php/Practice/dou_show/cou_id/<?php echo ($v["id"]); ?>"><?php echo ($v["name"]); ?></a><?php endif; ?>
                            </li><?php endforeach; endif; ?>
                        </ul>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fa fa-pencil-square-o"></i>
                            <span class="nav-label">练习判断题</span>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level">
                            <?php if(is_array($cou_info)): foreach($cou_info as $key=>$v): ?><li>
                                <?php if( $v["jud_status"] == 1 ): ?><a class="J_menuItem" href="/index.php/Practice/jud_show/cou_id/<?php echo ($v["id"]); ?>"><?php echo ($v["name"]); ?></a><?php endif; ?>
                            </li><?php endforeach; endif; ?>
                        </ul>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fa fa-pencil-square-o"></i>
                            <span class="nav-label">练习主观题</span>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level">
                            <?php if(is_array($cou_info)): foreach($cou_info as $key=>$v): ?><li>
                                <?php if( $v["sub_status"] == 1 ): ?><a class="J_menuItem" href="/index.php/Practice/sub_show/cou_id/<?php echo ($v["id"]); ?>"><?php echo ($v["name"]); ?></a><?php endif; ?>
                            </li><?php endforeach; endif; ?>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
        <!--左侧导航结束-->
        <!--右边部分开始-->
        <div id="page-wrapper" class="gray-bg dashbard-1">
			<!--右上部分开始-->
            <div class="row border-bottom">
                <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                    <div class="navbar-header">
                        <a class="navbar-minimalize minimalize-styl-2 btn btn-info " href="#">
                            <sapn class="glyphicon glyphicon-home"></sapn>
                        </a>
                    </div>
                    <ul class="nav navbar-top-links navbar-right">	
                        <li> 欢迎你，<?php echo ($stu["name"]); ?>（<?php echo ($stu["xuehao"]); ?>）</li>&nbsp;&nbsp;    
                        <li> 
                            <a href="<?php echo U('Public/loginout');?>">
                                退出登录 
                            </a>
                        </li> 	
                    </ul>
                </nav>
            </div>
			<!--右上部分结束-->

			<!--右下部分开始-->
            <div class="row J_mainContent" id="content-main">
                <iframe id="J_iframe" width="100%" height="100%" src="<?php echo U('Announce/show');?>" frameborder="0" data-id="personal.html" seamless></iframe>
            </div>
			<!--右下部分结束-->
        </div>
		<!--上面部分结束-->
        
    </div>
    <!-- 全局js -->
    <script src="/Public/Admin/js/jquery.min.js?v=2.1.4"></script>
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