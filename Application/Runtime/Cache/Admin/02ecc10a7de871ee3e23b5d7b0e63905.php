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
    <link href="/Public/Admin/css/animate.css" rel="stylesheet">
    <link href="/Public/Admin/css/style.css?v=4.1.0" rel="stylesheet">

</head>

<body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeInLeft">   
        <div class="row">       
			<div class="col-sm-10 col-sm-offset-1">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h3>修改公告</h3>          
                    </div>
                    <div class="ibox-content">
                        <div class="form-group">
                            <div class="col-sm-8 col-sm-offset-3">
                                <button id="setEditor" class="btn btn-info">     启用/禁用编辑器
                                </button>
                            </div>
                        </div>
                        <form class="form-horizontal m-t" action="/manager.php/announce/edit/id/16" method="post">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">题目描述:
                                </label>
                                <div class="col-sm-8">
                                    <input type="hidden" name="id" value="<?php echo ($id); ?>">
                                    <textarea id="descr" name="descr" style="height: 200px;width:100%;"><?php echo ($content); ?></textarea>
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

    </div>

    <!-- 全局js -->
    <script src="/Public/Admin/js/jquery.min.js?v=2.1.4"></script>
    <script src="/Public/Admin/js/bootstrap.min.js?v=3.3.6"></script>
    <!-- 自定义js -->
    <script src="/Public/Admin/js/content.js?v=1.0.0"></script>
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
                    toolbars: [
                        ['fullscreen', 'source','bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist']
                    ],
                    maximumWords:800,
                    enableAutoSave:false,
                });
            }
            i++;
            //加载完再使用方法
            ue.ready(function() {
                ue.setHeight(200);
            });
        });
    </script>

</body>

</html>