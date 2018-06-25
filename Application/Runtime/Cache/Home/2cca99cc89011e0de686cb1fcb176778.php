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
            <!-- 基本信息 -->
            <div class="col-sm-6">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h3>
                            基础信息 
                            <small>
                                (若基本信息与您的实际情况不符合，请选择重新导入)
                            </small> 
                        </h3>  
                    </div>
                    <div class="ibox-content">
                        <form class="form-horizontal m-t">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">学号：</label>
                                <div class="col-sm-8">
                                    <input id="stuNumber" name="stuNumber" class="form-control" type="text" value="<?php echo ($stu_info["xuehao"]); ?>" disabled="disabled">   
                                </div>   
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">名字：</label>
                                <div class="col-sm-8">
                                    <input id="username" name="username" class="form-control" type="text" value="<?php echo ($stu_info["name"]); ?>" disabled="disabled">
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">所属学院：</label>
                                <div class="col-sm-8">
                                    <input id="xueyuan" name="xueyuan" class="form-control" type="text" value="<?php echo ($stu_info["college"]); ?>" disabled="disabled">
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">所属班级：</label>
                                <div class="col-sm-8">
                                    <input id="stuClass" name="stuClass" class="form-control" type="text" value="<?php echo ($stu_info["stu_class"]); ?>" disabled="disabled">
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">专业：</label>
                                <div class="col-sm-8">
                                    <input id="zhuanye" name="zhuanye" class="form-control" type="text" value="<?php echo ($stu_info["major"]); ?>" disabled="disabled">
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div> 
                            <div class="form-group">
                                <label class="col-sm-3 control-label">上次登录IP：</label>
                                <div class="col-sm-8">
                                    <p class="form-control-static"><?php echo ($stu_info["last_ip"]); ?></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">上次登录时间：</label>
                                <div class="col-sm-8">
                                    <p class="form-control-static"><?php echo (date('Y-m-d H:i:s',(isset($stu_info["last_lgdate"]) && ($stu_info["last_lgdate"] !== ""))?($stu_info["last_lgdate"]):'无')); ?>
                                    </p>
                                </div>
                            </div>   
                            <div class="form-group">
                                <label class="col-sm-3 control-label">登录次数：</label>
                                <div class="col-sm-8">
                                    <p class="form-control-static"><?php echo ($stu_info["lg_num"]); ?>
                                    </p>
                                </div>
                            </div>  
                            <div class="form-group">
                                <label class="col-sm-3 control-label">注册日期：</label>
                                <div class="col-sm-8">
                                    <p class="form-control-static"><?php echo (date('Y-m-d H:i:s',$stu_info["rgdate"])); ?>
                                    </p>
                                </div>
                            </div>  
                            <div class="form-group">
                                <div class="col-sm-8 col-sm-offset-3">
                                    <a class="btn btn-primary" data-toggle="modal" href="#importBasic">重新从正方系统导入</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

			<div class="col-sm-6">
                <!-- 修改密码 -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h3>修改密码
                                <small> 
                                    (修改的密码为本网站专用，正方系统密码不受影响)
                                </small>
                                </h3>          
                            </div>
                            <div class="ibox-content">
                                <form class="form-horizontal m-t" id="changePass" action="/index.php/Personal/pass_info" method="post">
                                    <input type="hidden" name="sid" value="<?php echo ($stu_info["id"]); ?>">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">现有密码：</label>
                                        <div class="col-sm-8">
                                            <input id="oldPass" name="oldPass" class="form-control" type="password"
                                            placeholder="请输入您的登录密码">   
                                        </div>   
                                    </div>
        							<div class="hr-line-dashed"></div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">新的密码：</label>
                                        <div class="col-sm-8">
                                            <input id="password" name="password" class="form-control" type="password" 
                                            placeholder="请输入新密码">
                                        </div>
                                    </div>
        							<div class="hr-line-dashed"></div>
        							<div class="form-group">
                                        <label class="col-sm-3 control-label">确认密码：</label>
                                        <div class="col-sm-8">
                                            <input id="checkPass" name="checkPass" class="form-control" type="password"  placeholder="请确认您的新密码">
                                        </div>
                                    </div>
        							<div class="hr-line-dashed"></div>
                                    <div class="form-group">
                                        <div class="col-sm-8 col-sm-offset-3">
                                            <button class="btn btn-primary" type="submit">修改</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 修改补充信息 -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h3>
                                修改补充信息
                                <small>(方便老师及时联系~)</small>
                                </h3>          
                            </div>
                            <div class="ibox-content">
                                <form class="form-horizontal m-t" id="changeExtra" action="/index.php/Personal/extra_info" method="post">
                                    <input type="hidden" name="sid" value="<?php echo ($stu_info["id"]); ?>">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">电话：</label>
                                        <div class="col-sm-8">
                                            <input id="phone" name="phone" class="form-control" type="text" value="<?php echo ($stu_info["telphone"]); ?>">
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">邮箱：</label>
                                        <div class="col-sm-8">
                                            <input id="mail" name="mail" class="form-control" type="text" value="<?php echo ($stu_info["email"]); ?>">
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
        </div>
    </div>

    <!--弹出表单-->
    <div id="importBasic" class="modal fade" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6 b-r">
                            <h3 class="m-t-none m-b">重新校正基本信息</h3>
                            <div class="hr-line-dashed"></div>
                            <form  id="import_form" method="post" onkeydown="if(event.keyCode==13) return false;" >
                                <input type="hidden" name="stuNumber" value="<?php echo ($stu_info["xuehao"]); ?>">
                                <input type="hidden" name="sid" value="<?php echo ($stu_info["id"]); ?>">
                                <div style="text-align: center;height: 30px;display: none;" id="deal">
                                </div>
                                <div class="form-group">
                                    <label>正方密码：</label>
                                    <input type="password" name="password">
                                </div>
                                <div class="form-group" style="padding-left: 25px;">
                                    <label>线路：</label>
                                    <input type="radio" name="line" value="116" checked="checked">116 &nbsp;
                                    <input type="radio" name="line" value="118" >118
                                </div>
                                <div>
                                    <button class="btn btn-sm btn-primary pull-right m-t-n-xs" id="import_butt" type="button"><strong>确定</strong>
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="col-sm-6">
                            <h4>请注意</h4>
                            <p>JMoocTest需要您提供学校正方系统的正方学号相对应的正方密码，用来获取更新您的姓名、学院、专业、班级等信息。</p>
                            <h1 class="text-center">
                                <span class="glyphicon glyphicon-exclamation-sign" style="color:#F33"></span>
                            </h1>
                        </div>
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
    <script src="/Public/Admin/js/plugins/layer/layer.js"></script>
    <!-- jQuery Validation plugin javascript-->
    <script src="/Public/Admin/js/plugins/validate/jquery.validate.min.js"></script>
    <script src="/Public/Admin/js/plugins/validate/messages_zh.min.js"></script> <!--validate的提示信息转换成中文插件-->
	<script src="/Public/Admin/js/demo/form-validate-demo.js"></script>
    <script type="text/javascript">
        $(function(){
            $('#import_butt').on('click',function(){
                $('#deal').css({display:'block'});
                var xhr = $.ajax({
                    type:"POST",
                    url:"/index.php/Personal/import_basic",
                    data:$("#import_form").serialize(),
                    timeout:8000,
                    beforeSend:function (){
                        $('#deal').html('<span class="badge badge-danger">...处理中,请稍候...</span>');
                    },
                    success:function(data){
                        if(data['status'] == 1){
                            $('#deal').html('<span class="badge badge-success">'+data['info']+'</span>');
                        }else{
                            $('#deal').html('<span class="badge badge-danger">'+data['info']+'</span>');
                        }
                    },
                    complete: function (XMLHttpRequest,status) {
                        if(status == 'timeout') {
                            xhr.abort();    // 超时后中断请求
                            $('#deal').html('<span class="badge badge-danger">...请求超时,请稍后重试或更换线路...</span>');
                        }
                    }
                });

            });
        });
    </script>

</body>

</html>