<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>练习主观题 - JMoocTest</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="">
    <meta name="description" content="">

    <link rel="shortcut icon" href="/Public/favicon.ico"> <!--网页图标-->
    <link href="/Public/Admin/css/bootstrap.min.css?v=3.3.6" rel="stylesheet">
    <link href="/Public/Admin/css/animate.css" rel="stylesheet">  <!--动画效果-->
    <link href="/Public/Admin/css/style.css?v=4.1.0" rel="stylesheet">
    <link href="/Public/Admin/css/plugins/bootstrap-table/bootstrap-table.min.css" rel="stylesheet">
</head>

<body class="gray-bg" >
    <div class="container-fluid">
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1 animated fadeInUp" style="background: white;">
            <div class="page-header text-success">
                <h3>【主观题】<small><?php echo ($cou_name); ?></small></h3>
            </div>
            <div>
                <div id="toolbar" class="btn-group">
                    <button id="see" type="button" class="btn btn-default" title="进入试题">
                        <i class="glyphicon glyphicon-file"></i> 查看试题
                    </button>
                </div>
                <table id="prac_sub" data-url="/index.php/Practice/sub_show/cou_id/147"></table>
            </div>
            <hr>
            <div class="text-center"><h3><i class="fa fa-copyright"></i>EKA 2017</h3> </div>
        </div>
    </div>
</div>

    <script src="/Public/Admin/js/jquery.min.js?v=2.1.4"></script>
    <script src="/Public/Admin/js/bootstrap.min.js?v=3.3.6"></script>
    <script src="/Public/Admin/js/plugins/layer/layer.js"></script>
    <!-- bootstrap-table -->
    <script src="/Public/Admin/js/plugins/bootstrap-table/bootstrap-table.min.js"></script>
    <script src="/Public/Admin/js/plugins/bootstrap-table/locale/bootstrap-table-zh-CN.js"></script>
    <!--bootstrap-table-demo-->
    <script src="/Public/Admin/js/demo/bootstrap-table-demo.js"></script>
    <script>
        $(function(){
            $('#see').on('click',function(){
                //整理数据
                var idObj = $("#prac_sub").bootstrapTable('getSelections');
                if(idObj.length == 0){
                    layer.msg('没有选中数据');
                }else if(idObj.length > 1){
                    layer.msg('只能选中一条数据');
                }else{
                    var id = idObj[0].id;
                    location.href="/index.php/Practice/sub_detail/cid/<?php echo ($cid); ?>/id/"+id;
                }
            });
            // 删除工具栏中的id
            $("input[data-field='id']").parents("ul").find('li').eq(0).empty();
        });
    </script>

</body>

</html>