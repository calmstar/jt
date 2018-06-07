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
                        <h3>添加主观题</h3>          
                    </div>
                    <div class="ibox-content">
                        <div class="form-group">
                            <div class="col-sm-8 col-sm-offset-3">
                                <button id="setEditor" class="btn btn-info">     启用/禁用编辑器
                                </button>
                            </div>
                        </div>
                        <form class="form-horizontal m-t" id="subAdd" action="/manager.php/Question/sub_add" method="post">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">题目描述:
                                </label>
                                <div class="col-sm-8">
                                    <textarea id="descr" name="descr" style="height: 200px;width:100%;"></textarea>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">参考答案:
                                </label>
                                <div class="col-sm-8">
                                    <textarea id="right_answ" name="right_answ" style="height: 200px;width:100%;"></textarea>
                                </div>
                            </div>
							<div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">所属课程：</label>
                                <div class="col-sm-8">
                                    <select class="form-control" name="course_id">
                                        <?php if(is_array($cou_info)): foreach($cou_info as $key=>$v): ?><option value="<?php echo ($v["id"]); ?>"><?php echo ($v["name"]); ?></option><?php endforeach; endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">难度：</label>
                                <div class="col-sm-8">
                                    <select class="form-control" id="difficulty" name="difficulty">
                                        <option value="1">简单</option>
                                        <option value="2">一般</option>
                                        <option value="3">困难</option>
                                    </select> 
                                </div>   
                            </div>
                            <div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">关键字：</label>
                                    <div class="col-sm-8">
                                        <input id="keyword" name="keyword" class="form-control" type="text">
                                    </div>
                                </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">是否展示到练习题:
                                </label>
                                <div class="col-sm-8">
                                    <select class="form-control" name="is_show">
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
    <!--ueditor config一定要放在最前面-->
    <script src="/Public/Admin/js/plugins/ueditor/ueditor.config.js"></script>
    <script src="/Public/Admin/js/plugins/ueditor/ueditor.all.js"></script>
    <script src="/Public/Admin/js/plugins/ueditor/lang/zh-cn/zh-cn.js"></script>
    <script type="text/javascript">
        var i = 1; 
        // 启用/禁用编辑器
        $('#setEditor').on('click',function(){
            if(i%2 == 0){
                ue.destroy();
            }else{
                ue = UE.getEditor('descr', {
                    maximumWords:4500,
                    enableAutoSave:false,
                });
            }
            i++;
            //加载完再使用方法
            ue.ready(function() {
                ue.setHeight(400);
            });
        });
    </script>

</body>

</html>