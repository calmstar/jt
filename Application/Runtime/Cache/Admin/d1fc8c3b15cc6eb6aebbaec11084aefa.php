<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title> - 个人资料</title>
    <meta name="keywords" content="">
    <meta name="description" content="">

    <link rel="shortcut icon" href="/Public/favicon.ico"> 
	<link href="/Public/Admin/css/bootstrap.min.css?v=3.3.6" rel="stylesheet">
    <link href="/Public/Admin/css/font-awesome.css?v=4.4.0" rel="stylesheet">
    <link href="/Public/Admin/css/animate.css" rel="stylesheet">
    <link href="/Public/Admin/css/style.css?v=4.1.0" rel="stylesheet">

</head>

<body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeInRight">   
        <div class="row">       
            <div class="col-sm-6">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h3>基础信息</h3>          
                    </div>
                    <div class="ibox-content">
                        <form class="form-horizontal m-t" id="personalInfo" action="/manager.php/Personal/basic_info" method="post">
                            <input type="hidden" value="<?php echo ($user_info["id"]); ?>" name="uid">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">邮箱账号：</label>
                                <div class="col-sm-8">
                                    <input id="mail" name="mail" class="form-control" type="text" value="<?php echo ($user_info["email"]); ?>">         
                                </div>
                            </div>
							<div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" >名字：</label>
                                <div class="col-sm-8">
                                    <input id="username" name="username" class="form-control" type="text" value="<?php echo ($user_info["name"]); ?>">
                                </div>
                            </div>
							<div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">电话：</label>
                                <div class="col-sm-8">
                                    <input id="phone" name="phone" class="form-control" type="text" value="<?php echo ($user_info["telphone"]); ?>">
                                </div>
                            </div>
							<div class="hr-line-dashed"></div>             
							<div class="form-group">
                                <label class="col-sm-3 control-label">角色：</label>
                                <div class="col-sm-8">
                                    <p class="form-control-static">
                                    <?php echo ($user_info["role_name"]); ?>
                                    <?php if($user_info["role_id"] == 1): ?>（任教课程： <?php echo ($user_info["cou_name"]); ?>）<?php endif; ?>
                                    </p>
                                </div>
                            </div>
							<div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">注册日期：</label>
                                <div class="col-sm-8">
                                    <p class="form-control-static">
                                    <?php echo (date('Y-m-d H:i:s',$user_info["rgdate"])); ?>
                                    </p>
                                </div>
                            </div>
							<div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">上次登录IP：</label>
                                <div class="col-sm-8">
                                    <p class="form-control-static"><?php echo ($last_ip); ?></p>
                                </div>
                            </div>
							<div class="hr-line-dashed"></div>
							<div class="form-group">
                                <label class="col-sm-3 control-label">上次登录时间：</label>
                                <div class="col-sm-8">
                                    <p class="form-control-static"><?php echo (date('Y-m-d H:i:s',$last_lgdate)); ?>
                                    </p>
                                </div>
                            </div>     
							<div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <div class="col-sm-8 col-sm-offset-3">
                                    <button class="btn btn-primary" type="submit">提交</button>
                                </div>
                            </div>
							
                        </form>
                    </div>
                </div>
            </div>
			<div class="col-sm-6">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h3>修改密码</h3>          
                    </div>
                    <div class="ibox-content">
                        <form class="form-horizontal m-t" id="changePWD" action="/manager.php/Personal/pass_info" method="post">
                            <input type="hidden" name="uid" value="<?php echo ($user_info["id"]); ?>">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">现有密码：</label>
                                <div class="col-sm-8">
                                    <input id="oldPass" name="oldPass" class="form-control" type="password">   
                                    <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 请输入您的登录密码</span> 
                                </div>   
                            </div>
							<div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">新的密码：</label>
                                <div class="col-sm-8">
                                    <input id="password" name="password" class="form-control" type="password" >
                                    <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>请再次输入6-16位新密码</span>
                                </div>
                            </div>
							<div class="hr-line-dashed"></div>
							<div class="form-group">
                                <label class="col-sm-3 control-label">确认密码：</label>
                                <div class="col-sm-8">
                                    <input id="checkPass" name="checkPass" class="form-control" type="password" >
                                    <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 请再次确认您的密码</span>
                                </div>
                            </div>
							<div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <div class="col-sm-8 col-sm-offset-3">
                                    <button class="btn btn-primary" type="submit">提交</button>
                                </div>
                            </div>
							
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <!-- 全局js -->
    <script src="/Public/Admin/js/jquery.min.js?v=2.1.4"></script>
    <script src="/Public/Admin/js/bootstrap.min.js?v=3.3.6"></script>
    <!-- 自定义js -->
    <script src="/Public/Admin/js/content.js?v=1.0.0"></script>
    <!-- jQuery Validation plugin javascript-->
    <script src="/Public/Admin/js/plugins/validate/jquery.validate.min.js"></script>
    <script src="/Public/Admin/js/plugins/validate/messages_zh.min.js"></script> <!--validate的提示信息转换成中文插件-->
	<script src="/Public/Admin/js/demo/form-validate-demo.js"></script>

</body>

</html>