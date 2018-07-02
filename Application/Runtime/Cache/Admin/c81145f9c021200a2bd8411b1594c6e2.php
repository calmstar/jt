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
    <style type="text/css">
        /*将多出来的字以省略号形式表示*/
        table{
            table-layout:fixed;
        }
        td{  
            overflow:hidden;
            text-overflow:ellipsis;
            white-space:nowrap;
        }
    </style>
</head>

<body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="ibox">
            <div class="ibox-title">
                <h3>单选题</h3>  
            </div> 
            <div class="ibox-content">
                <div class="row row-lg">
                    <div class="col-sm-12">
                        <div id="toolbar" class="btn-group">
                            <button id="dele" type="button" class="btn btn-default" title="删除题目">
                                <i class="glyphicon glyphicon-trash"></i> 删除
                            </button>
                            <button id="add" type="button" class="btn btn-default" title="添加题目">
                                <i class="glyphicon glyphicon-plus"></i> 添加
                            </button>
                            <button id="edit" type="button" class="btn btn-default" title="编辑/查看题目">
                                <i class="glyphicon glyphicon-edit"></i> 编辑/查看
                            </button>
                            <a id="import" type="button" class="btn btn-default" title="导入单选题" onclick="import_sin()">
                                <i class="glyphicon glyphicon-import"></i> EXCEL导入
                            </a>
                        </div>
                        <table id="sin_table" data-url="/manager.php/Question/sin_showlist.html"></table>
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
    <!--bootstrap-table-demo-->
    <script src="/Public/Admin/js/demo/bootstrap-table-demo.js"></script>
    <script type="text/javascript">
        $(function(){
            //添加
            $('#add').on('click',function(){
                location.href="/manager.php/Question/sin_add";
            });

            //删除
            $('#dele').on('click',function(){
                //整理数据
                var idObj = $("#sin_table").bootstrapTable('getSelections');
                var ids = '';
                for(var i = 0; i < idObj.length; i++ ){
                    ids += idObj[i].id + ',';
                }
                ids = ids.substring(0,ids.length-1);

                if(ids == ''){
                    layer.msg('没有选中数据');
                }else{
                    layer.confirm('确认删除？', {btn: ['确定', '取消']}, 
                        function(){   
                            $.post("/manager.php/Question/sin_dele",{ids:ids},
                                function(data){
                                    if(data['status'] == 1){
                                        //由于layer.alert无法暂停下面的刷新
                                        layer.confirm('删除成功',{btn: ['确定']},
                                            function(){
                                                window.location.reload(); 
                                            })
                                    }else{
                                        layer.msg('删除失败');
                                    }     
                                }
                            );
                        },
                    );  
                }
            });

            //编辑
            $('#edit').on('click',function(){
                //整理数据
                var idObj = $("#sin_table").bootstrapTable('getSelections');
                if(idObj.length == 0){
                    layer.msg('没有选中数据');
                }else if(idObj.length > 1){
                    layer.msg('编辑只能选中一条数据');
                }else{
                    var id = idObj[0].id;
                    location.href='/manager.php/Question/sin_edit/id/'+id;
                }
                
            });

            //删除工具栏中的id
            $("input[data-field='id']").parents("ul").find('li').eq(0).empty();
        });

        //导入单选题
        function import_sin() {
            layer.open({
                title: '导入单选题',
                type: 2,
                area: ['900px', '600px'],
                fixed: false, //不固定
                maxmin: true,
                content: '/manager.php/Question/sin_import',
            });
        }
    </script>

</body>
</html>