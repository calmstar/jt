<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title> JMoocTest - 后台登录</title>
    <meta name="keywords" content="">
    <meta name="description" content="">

    <link rel="shortcut icon" href="/Public/favicon.ico"> 
    <link href="/Public/Admin/css/bootstrap.min.css?v=3.3.6" rel="stylesheet">
    <link href="/Public/Admin/css/font-awesome.css?v=4.4.0" rel="stylesheet">
    <link href="/Public/Admin/css/animate.css" rel="stylesheet">
    <link href="/Public/Admin/css/style.css?v=4.1.0" rel="stylesheet">
</head>

<body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeInDown">
        <div class="row">              
            <div class="col-sm-6 col-sm-offset-3">
                <div class="ibox">
                    <div class="text-center">
                        <h3 class="logo-name">J</h3>
                    </div>  
                    <br>
                    <h3 class="text-center">JMoocTest - 后台管理</h3>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-sm-10 col-sm-offset-1">
                            <form class="form-horizontal m-t" id="login" action="/manager.php/Public/login" method="post">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="mail">邮箱账号：</label>
                                    <div class="col-sm-8">
                                        <input id="mail" name="mail" class="form-control" type="text">         
                                    </div>
                                </div>
                                <br>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="password">用户密码：</label>
                                    <div class="col-sm-8">
                                        <input id="password" name="password" class="form-control" type="password">         
                                    </div>
                                </div>
                                <br>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="code">验证码：</label>
                                    <div class="col-sm-5" >
                                        <input id="code" name="code" class="form-control" type="text">
                                    </div>
                                    <div class="col-sm-3">
                                        <img src="/manager.php/Public/verifyImg" onclick="this.src='/manager.php/Public/verifyImg/'+Math.random()" style="cursor: pointer;" alt="验证码" width="120px" height="33px" class=" img-responsive" id="check_img">       
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-8 col-sm-offset-3">
                                        <input type="button" class="btn btn-primary" value="登录" id="denglu">
                                    </div>
                                </div>   
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>   
    </div>
</body>

    <!-- 全局js -->
    <script src="/Public/Admin/js/jquery.min.js?v=2.1.4"></script>
    <script src="/Public/Admin/js/bootstrap.min.js?v=3.3.6"></script>
    <!-- jQuery Validation plugin javascript-->
    <script src="/Public/Admin/js/plugins/validate/jquery.validate.min.js"></script>
    <script src="/Public/Admin/js/plugins/validate/messages_zh.min.js"></script> <!--validate的提示信息转换成中文插件-->
    <script src="/Public/Admin/js/demo/form-validate-demo.js"></script>
    <script src="/Public/Admin/js/plugins/layer/layer.js"></script>
    <script type="text/javascript">
        $(function(){
            $('#denglu').click(function(){
                $.ajax({
                    type:"POST",
                    url:'/manager.php/Public/login',
                    data:$('form').serialize(),
                    success:function(res){
                        if(res['status'] == 1){
                            window.location.href='/manager.php/Index/index';
                        }else{
                            layer.msg(res.info);
                            $('#check_img').trigger('click');
                            $('#code').val('');
                        }
                    }
                });
            });
        });
    </script>


</html>