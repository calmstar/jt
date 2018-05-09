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
                <h3>分析列表<small> 有考生交卷后，才会出现该试卷的分析记录（最终结果以批改完主观题为准）</small></h3>
            </div> 
            <div class="ibox-content">
                <div class="row row-lg">
                    <div class="col-sm-12">
                        <div id="toolbar" class="btn-group">
                            <button id="graph" type="button" class="btn btn-default" title="图形分析">
                                <i class="glyphicon glyphicon-info-sign"></i> 图形分析
                            </button>
                            <button id="export" type="button" class="btn btn-default" title="将试卷信息导出到Excel">
                                <i class="glyphicon glyphicon-export"></i> 导出Excel
                            </button>
                            <button id="stu" type="button" class="btn btn-default" title="查看考生">
                                <i class="glyphicon glyphicon-user"></i> 查看考生
                            </button>
                        </div>

                        <!--使用了data-toggle='table' id就没效果-->
                        <table id="analyze" data-url="/manager.php/Analyze/showlist.html"></table>
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

            //查看考生
            $('#stu').on('click',function(){
                //整理数据
                var idObj = $("#analyze").bootstrapTable('getSelections');
                if(idObj.length == 0){
                    layer.msg('没有选中数据');
                }else{
                    var paper_id = idObj[0].paper_id;
                    window.location.href='/manager.php/Analyze/stu_list/paper_id/'+paper_id;
                }
                
            });

            //导出到Excel
            $('#export').on('click',function(){
                //整理数据
                var idObj = $("#analyze").bootstrapTable('getSelections');
                if(idObj.length == 0){
                    layer.msg('没有选中数据');
                }else{
                    layer.confirm('试题信息将导出至Excel',{btn:['确定','取消']},function(index){
                            //idObj是一个二维数组 即json对象(json对象通过序列化后变成json字符串)
                            //由于只能选中一个，所以传递一个一维数组即可
                            idObj = JSON.stringify(idObj[0]);
                            window.location.href="/manager.php/Analyze/export?info="+idObj;
                            layer.close(index); //function中必须有index参数
                    });
                }
                
            });

            //图形分析
            $('#graph').on('click',function(){
                //整理数据
                var idObj = $("#analyze").bootstrapTable('getSelections');
                if(idObj.length == 0){
                    layer.msg('没有选中数据');
                }else{
                    var paper_id = idObj[0].paper_id;
                    window.location.href='/manager.php/Analyze/graph/paper_id/'+paper_id;
                }
                
            });

            //删除工具栏中的paper_id
            $("input[data-field='paper_id']").parents("ul").find('li').eq(0).empty();

        });
    </script>

</body>
</html>