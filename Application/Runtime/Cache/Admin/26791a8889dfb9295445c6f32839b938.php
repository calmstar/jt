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
        <div class="ibox">
            <div class="ibox-title">
                <h3>试卷列表</h3>  
            </div> 
            <div class="ibox-content">
                <div class="row row-lg">
                    <div class="col-sm-12">
                        <div id="toolbar" class="btn-group">
                            <button id="dele" type="button" class="btn btn-default" title="删除试卷">
                                <i class="glyphicon glyphicon-trash"></i> 删除
                            </button>
                            <button id="edit" type="button" class="btn btn-default" title="编辑/查看试卷">
                                <i class="glyphicon glyphicon-edit"></i> 编辑/查看
                            </button>
                            <button id="add_random" type="button" class="btn btn-default" title="随机出卷">
                                <i class="glyphicon glyphicon-plus"></i> 随机出卷
                            </button>
                            <button id="add_fixed" type="button" class="btn btn-default" title="指定出卷">
                                <i class="glyphicon glyphicon-plus-sign"></i> 指定出卷
                            </button>
                            <button id="isable" type="button" class="btn btn-default" title="更改审核状态">
                                <i class="glyphicon glyphicon-adjust"></i> 审核状态
                            </button>
                            <button id="answ" type="button" class="btn btn-default" title="是否开放试卷答案">
                                <i class="glyphicon glyphicon-eye-open"></i> 答案状态
                            </button>
                        </div>
                        <!--使用了data-toggle='table' id就没效果-->
                        <table id="paper_table" data-url="/manager.php/Paper/showlist.html"></table>
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
            //随机出卷
            $('#add_random').on('click',function(){
                location.href="/manager.php/paper/add_random";
            });

            //指定出卷
            $('#add_fixed').on('click',function(){
                location.href="/manager.php/paper/add_fixed";
            });

            //删除
            $('#dele').on('click',function(){
                //整理数据
                var idObj = $("#paper_table").bootstrapTable('getSelections');
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
                            $.post("/manager.php/paper/dele",{ids:ids},
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
                var idObj = $("#paper_table").bootstrapTable('getSelections');
                if(idObj.length == 0){
                    layer.msg('没有选中数据');
                }else if(idObj.length > 1){
                    layer.msg('编辑只能选中一条数据');
                }else{
                    var id = idObj[0].id;
                    location.href='/manager.php/paper/edit/id/'+id;
                }
                
            });

            //开放试卷答案
            $('#answ').on('click',function(){
                //整理数据
                var idObj = $("#paper_table").bootstrapTable('getSelections');
                if(idObj.length == 0){
                    layer.msg('没有选中数据');
                }else if(idObj.length > 1){
                    layer.msg('监控只能选中一条数据');
                }else{
                    var id = idObj[0].id;
                    location.href='/manager.php/paper/answ/id/'+id;
                }
                
            });


            //状态启用，禁用
            $('#isable').on('click',function(){
                //整理数据
                var idObj = $("#paper_table").bootstrapTable('getSelections');
                if(idObj.length == 0){
                    layer.msg('没有选中数据');
                }else if(idObj.length > 1){
                    layer.msg('只能选中一条数据');
                }else{
                    layer.confirm('若为正在进行中的试卷，随意改变审核状态将影响考生考试，请谨慎操作', {btn: ['确定', '取消']}, 
                        function(){
                            var id = idObj[0].id;
                            location.href='/manager.php/paper/isable/id/'+id;
                        });
                }
                
            });

            //删除工具栏中的id
            $("input[data-field='id']").parents("ul").find('li').eq(0).empty();

        });
    </script>

</body>
</html>