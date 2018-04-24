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
                <h3>监控与批改 <small>有考生进入试卷进行考试后，才会出现该试卷的监控记录</small> </h3>
            </div> 
            <div class="ibox-content">
                <div class="row row-lg">
                    <div class="col-sm-12">
                        <div id="toolbar" class="btn-group">
                            <button id="control" type="button" class="btn btn-default" title="监控考生状态">
                                <i class="glyphicon glyphicon-console"></i> 监控考生
                            </button>
                            <button id="mark" type="button" class="btn btn-default" title="批改主观题">
                                <i class="glyphicon glyphicon-pencil"></i> 批量批改
                            </button>
                        </div>

                        <!--使用了data-toggle='table' id就没效果-->
                        <table id="mark_subj" data-url="/manager.php/Mark/showlist.html"></table>
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

            //批改主观题
            $('#mark').on('click',function(){
                //整理数据
                var idObj = $("#mark_subj").bootstrapTable('getSelections');
                if(idObj.length == 0){
                    layer.msg('没有选中数据');
                }else{
                    var paper_id = idObj[0].paper_id;
                    window.open('/manager.php/mark/marking/paper_id/'+paper_id);
                }
            });

            //监控考生
            $('#control').on('click',function(){
                //整理数据
                var idObj = $("#mark_subj").bootstrapTable('getSelections');
                if(idObj.length == 0){
                    layer.msg('没有选中数据');
                }else{
                    var paper_id = idObj[0].paper_id;
                    location.href='/manager.php/mark/control/paper_id/'+paper_id;
                }
            });

            //删除工具栏中的paper_id
            $("input[data-field='paper_id']").parents("ul").find('li').eq(0).empty();

        });
    </script>

</body>
</html>