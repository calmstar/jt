<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title></title>
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
			<div class="col-sm-10 col-sm-offset-1">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h3>添加权限</h3>          
                    </div>
                    <div class="ibox-content">
                        <form class="form-horizontal m-t" id="authority" action="/manager.php/Authority/add" method="post">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">权限名称：</label>
                                <div class="col-sm-8">
                                    <input id="authName" name="authName" class="form-control" type="text">   
                                    <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 请输入10个字符以内的中文</span> 
                                </div>   
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">选择父类权限：</label>
                                <div class="col-sm-8">
                                    <select class="form-control" name="authPid">
                                        <option value="0">无父类</option>
                                        <?php if(is_array($sele_info)): foreach($sele_info as $key=>$v): ?><option value="<?php echo ($v["id"]); ?>"><?php echo ($v["name"]); ?></option><?php endforeach; endif; ?>
                                    </select>
                                    <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>请选择</span> 
                                </div>
                            </div>
							<div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">权限控制器：</label>
                                <div class="col-sm-8">
                                    <input id="authController" name="authController" class="form-control" type="text" >
                                    <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>请输入英文</span>
                                </div>
                            </div>
							<div class="hr-line-dashed"></div>
							<div class="form-group">
                                <label class="col-sm-3 control-label">权限操作方法：</label>
                                <div class="col-sm-8">
                                    <input id="authAction" name="authAction" class="form-control" type="text" >
                                    <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 请输入英文或下划线</span>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">是否展示：</label>
                                <div class="col-sm-8">
                                    <select class="form-control" name="display">
                                        <option value="1">是</option>
                                        <option value="0">否</option>
                                    </select>
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

    <!-- <script type="text/javascript">
        $('.submit').on('click',function(){
            $('form').submit();
        });
    </script> button的type为submit时也是提交-->

</body>

</html>