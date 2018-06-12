<?php if (!defined('THINK_PATH')) exit();?> <!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>列表</title>
    <meta name="keywords" content="">
    <meta name="description" content="">

    <link rel="shortcut icon" href="/Publicfavicon.ico">
    <link href="/Public/Admin/css/bootstrap.min.css" rel="stylesheet">
    <link href="/Public/Admin/css/animate.css" rel="stylesheet">
    <link href="/Public/Admin/css/style.css" rel="stylesheet">
    <link href="/Public/Admin/css/plugins/bootstrap-table/bootstrap-table.min.css" rel="stylesheet">

</head>

<body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h3>学生列表</h3>
                    </div>      
                    <div class="ibox-content table-responsive">
                        <div class="row">
                           <div class="col-sm-12">
                               <div id="toolbar" class="btn-group">
                                   <button type="button" class="btn btn-outline btn-default" id="deleAll">
                                       <i class="glyphicon glyphicon-trash" aria-hidden="true"></i> 批量删除
                                   </button>
                                   <button type="button" class="btn btn-outline btn-default" id="add">
                                       <i class="glyphicon glyphicon-plus" aria-hidden="true" ></i> 添加
                                   </button>
                                   <button type="button" class="btn btn-outline btn-default" data-toggle="modal" href="#inputFile">
                                       <i class="glyphicon glyphicon-import" aria-hidden="true" ></i> EXCEL导入
                                   </button>
                               </div>
                               <table id="stu" data-url="/manager.php/Student/showlist.html"></table>
                           </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--弹出表单-->
    <div id="inputFile" class="modal fade" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6 b-r">
                            <h3 class="m-t-none m-b">请上传文件</h3>
                            <div class="hr-line-dashed"></div>
                            <form role="form" method="post" action="/manager.php/Student/import"  enctype="multipart/form-data">
                                <div class="form-group">
                                    <label>请选择：</label>
                                    <input type="file" name="stu_file">
                                </div>
                                <div>
                                    <button class="btn btn-sm btn-primary pull-right m-t-n-xs" type="submit"><strong>确定</strong>
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="col-sm-6">
                            <h4>请注意</h4>
                            <p>此功能一般用于系统的爬虫注册功能失效后使用！正常情况下，请尽量让学生通过爬虫注册登录本系统！</p>
                            <p>上传前，请确保格式正确！并仔细校对学生信息！确保学生未在此系统注册过！</p>
                            <h1 class="text-center">
                                <span class="glyphicon glyphicon-exclamation-sign" style="color:#F33"></span>
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="/Public/Admin/js/jquery.min.js"></script>
    <script src="/Public/Admin/js/bootstrap.min.js"></script>
    <script src="/Public/Admin/js/content.js"></script>
    <script src="/Public/Admin/js/plugins/layer/layer.js"></script>
    <!-- bootstrap-table -->
    <script src="/Public/Admin/js/plugins/bootstrap-table/bootstrap-table.min.js"></script>
    <script src="/Public/Admin/js/plugins/bootstrap-table/locale/bootstrap-table-zh-CN.js"></script>
    <script src="/Public/Admin/js/demo/bootstrap-table-demo1.js"></script>
    <script type="text/javascript">
        $(function(){
            //删除工具栏中的id
            $("input[data-field='id']").parents("ul").find('li').eq(0).empty();

            //添加事件
            $('#add').on('click',function(){
                location.href='/manager.php/Student/add';
            });

            // 批量删除
            $('#deleAll').on('click',function(){
                //整理数据
                var idObj = $("#stu").bootstrapTable('getSelections');
                var id = '';
                for(var i = 0; i < idObj.length; i++){
                    id += idObj[i].id + ',';
                }
                id = id.substring(0,id.length-1);

                if(id == ''){
                    layer.msg('没有选中数据');
                }else{
                    layer.confirm('确认删除？', {btn: ['确定', '取消']},
                        function(){
                            $.post("/manager.php/Student/dele",{ids:id},
                                function(data){
                                    if(data['status'] == 1){
                                        layer.confirm('批量删除成功',{btn: ['确定']},
                                            function(){
                                                window.location.reload();
                                            })
                                    }else{
                                        layer.msg('删除失败');
                                    }
                                }
                            );
                        }
                    );
                }
            });
        });

        window.operateEvents = {
            //编辑
            'click .edit': function (e, value, row, index) {
                var id = row['id'];
                location.href='/manager.php/Student/edit/id/'+id;
            },
            // 状态
            'click .isAble': function (e, value, row, index) {
                var id = row['id'];
                var status = $(this).parents('tr').find('td').eq(5);
                $.post('/manager.php/Student/isable',{"id":id},function(data){
                    if(data==1){
                        status.html('<i class="glyphicon glyphicon-remove">');
                        layer.msg('状态已更改为禁用');
                    }else if(data==2){
                        status.html('<i class="glyphicon glyphicon-ok">');
                        layer.msg('状态已更改为启用');
                    }else{
                        layer.msg('状态更改失败');
                    }
                });
            },
            // 重置密码
            'click .reset': function (e, value, row, index) {
                var id = row['id'];
                layer.confirm('密码将重置为“ 123456 ”，确认重置？', {btn: ['确定', '取消']},
                    function(){
                        $.post('/manager.php/Student/reset',{"id":id},function(data){
                            if(data['status'] == 1){
                                layer.msg('重置密码成功');
                            }else{
                                layer.msg('重置密码失败');
                            }
                        });
                    }
                );
            },
            //删除
            'click .deleSingle': function (e, value, row, index) {
                var id = row['id'];
                layer.confirm('确认删除？', {btn: ['确定', '取消']},
                    function(index){
                        location.href='/manager.php/Student/dele/ids/'+id;
                    }
                );
            },
        };
    </script>
  
</body>
</html>