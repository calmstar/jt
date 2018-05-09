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
                <h3>分析考生列表<small> --<?php echo ($name); ?> （最终结果以批改完主观题为准；未提交答卷的考生将不会在此处显示）</small></h3>
            </div> 
            <div class="ibox-content">
                <div class="row row-lg">
                    <div class="col-sm-12">
                        <div id="toolbar" class="btn-group">
                            <button id="see_paper" type="button" class="btn btn-default" title="查看试卷">
                                <i class="glyphicon glyphicon-file"></i> 查看试卷
                            </button>
                        </div>
                        <table id="stu_list" data-url="/manager.php/Analyze/stu_list/paper_id/<?php echo ($paper_id); ?>"></table>
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
            $('#see_paper').on('click',function(){
                //整理数据
                var idObj = $("#stu_list").bootstrapTable('getSelections');
                if(idObj.length == 0){
                    layer.msg('没有选中数据');
                }else{
                    var paper_id = <?php echo ($paper_id); ?>; //assign进来
                    var stu_id = idObj[0].stu_id;
                    window.open('/manager.php/Analyze/see_paper/stu_id/'+stu_id+'/paper_id/'+paper_id);
                }
                
            });
            //删除工具栏中的stu_id
            $("input[data-field='stu_id']").parents("ul").find('li').eq(0).empty();
        });
    </script>

</body>
</html>