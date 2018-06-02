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
    <div class="wrapper wrapper-content animated fadeInLeft">   
        <div class="row">       
			<div class="col-sm-10 col-sm-offset-1">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h3>修改学生</h3>          
                    </div>
                    <div class="ibox-content">
                        <form class="form-horizontal m-t" id="stu" action="/manager.php/Student/edit/id/208" method="post">
                            <input type="hidden" value="<?php echo ($info["id"]); ?>" name="sid">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">学号：</label>
                                <div class="col-sm-8">
                                    <input id="stuNumber" name="stuNumber" class="form-control" type="text" value="<?php echo ($info["xuehao"]); ?>">   
                                    <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 学号作为您的账号</span> 
                                </div>   
                            </div>
							<div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">名字：</label>
                                <div class="col-sm-8">
                                    <input id="username" name="username" class="form-control" type="text" value="<?php echo ($info["name"]); ?>">
                                    <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 请输入5个以内的字符</span>
                                </div>
                            </div>
							<div class="hr-line-dashed"></div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">所属学院：</label>
                                    <div class="col-sm-8">
                                        <select name="xueyuan" id="xueyuan" class="form-control">
                                            <option value="<?php echo ($info["college"]); ?>"><?php echo ($info["college"]); ?></option>
                                            <option value="数学学院">数学学院</option>
                                            <option value="物理与光信息科技学院">物理与光信息科技学院</option>
                                            <option value="化学与环境学院">化学与环境学院</option>
                                            <option value="文学院">文学院</option>
                                            <option value="外国语学院">外国语学院</option>
                                            <option value="生命科学学院">生命科学学院</option>
                                            <option value="政法学院">政法学院</option>
                                            <option value="地理科学与旅游学院">地理科学与旅游学院</option>
                                            <option value="经济与管理学院">经济与管理学院</option>
                                            <option value="电子信息工程学院">电子信息工程学院</option>
                                            <option value="计算机学院">计算机学院</option>
                                            <option value="土木工程学院">土木工程学院</option>
                                            <option value="美术学院">美术学院</option>
                                            <option value="体育学院">体育学院</option>
                                            <option value="音乐学院">音乐学院</option>
                                            <option value="教育科学学院">教育科学学院</option>
                                        </select>

                                    </div>
                                </div>
            
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">所属班级：</label>
                                <div class="col-sm-8">
                                    <input id="stuClass" name="stuClass" class="form-control" type="text" value="<?php echo ($info["stu_class"]); ?>">
                                    <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>
                                    前缀格式：数学，物理，化学，文学，外语，生科，政法，地理，经管，电子，计算机，土木，美术，体育，音乐，教科。<br> 
                                    请按照所给前缀添加上班级(5个字符)，如：计算机1504班</span>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">专业：</label>
                                <div class="col-sm-8">
                                    <input id="zhuanye" name="zhuanye" class="form-control" type="text" value="<?php echo ($info["major"]); ?>">
                                    <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 如：网络工程</span>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
							<div class="form-group">
                                <label class="col-sm-3 control-label">电话：</label>
                                <div class="col-sm-8">
                                    <input id="phone" name="phone" class="form-control" type="text" value="<?php echo ($info["telphone"]); ?>">
                                    <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 请输入常用手机号码</span>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">邮箱：</label>
                                <div class="col-sm-8">
                                    <input id="mail" name="mail" class="form-control" type="text" value="<?php echo ($info["email"]); ?>">
                                    <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 请输入常用邮箱</span>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">注册时间：</label>
                                <div class="col-sm-8">
                                    <span class="help-block m-b-none"><?php echo (date('Y-m-d H:i:s',$info["rgdate"])); ?></span>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">上次登录时间：</label>
                                <div class="col-sm-8">
                                    <span class="help-block m-b-none"><?php echo (date('Y-m-d H:i:s',$info["last_lgdate"])); ?></span>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">上次登录IP：</label>
                                <div class="col-sm-8">
                                    <span class="help-block m-b-none"><?php echo ($info["last_ip"]); ?></span>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">登录次数：</label>
                                <div class="col-sm-8">
                                    <span class="help-block m-b-none"><?php echo ($info["lg_num"]); ?></span>
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