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
                <h3>我的试卷 <small>待老师开放试卷答案后，才能看到该试卷的答案和分数</small> </h3>
            </div> 
            <div class="ibox-content">
                <div class="row row-lg">
                    <div class="col-sm-12">
                        <div id="toolbar" class="btn-group">
                            <button id="detail" type="button" class="btn btn-default" title="查看试卷">
                                <i class="glyphicon glyphicon-file"></i> 查看试卷
                            </button>
                        </div>
                        <!--使用了data-toggle='table' id就没效果-->
                        <table id="myPaper" data-url="/index.php/paper/show.html"></table>
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

            //查看试卷
            $('#detail').on('click',function(){
                //整理数据
                var idObj = $("#myPaper").bootstrapTable('getSelections');
                if(idObj.length == 0){
                    layer.msg('没有选中数据');
                }else if(idObj.length > 1){
                    layer.msg('只能选中一条数据');
                }else{
                    var id = idObj[0].paper_id;
                    // location.href='/index.php/paper/detail/id/'+id;
                    //打开新窗口
                    window.open("/index.php/paper/detail/id/"+id);
                }
                
            });

            // 删除工具栏中的id
            $("input[data-field='paper_id']").parents("ul").find('li').eq(0).empty();

        });
    </script>

</body>
</html>