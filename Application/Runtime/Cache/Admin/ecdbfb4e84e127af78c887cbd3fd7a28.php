<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
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
            <h3>监控考生列表 <small> --<?php echo ($name); ?></small></h3>
        </div>
        <div class="ibox-content">
            <div class="row row-lg">
                <div class="col-sm-12">
                    <div id="toolbar" class="btn-group">
                        <button id="reset" type="button" class="btn btn-default" title="重新考试">
                            <i class="glyphicon glyphicon-transfer"></i> 重新考试
                        </button>
                        <button id="remove" type="button" class="btn btn-default" title="删除考生">
                            <i class="glyphicon glyphicon-trash"></i> 删除考生
                        </button>
                        <button id="clear" type="button" class="btn btn-default" title="清除缓存答案">
                            <i class="glyphicon glyphicon-remove"></i> 清除缓存答案
                        </button>
                        <button id="smark" type="button" class="btn btn-default" title="批改主观题">
                            <i class="glyphicon glyphicon-pencil"></i> 批改主观题
                        </button>
                    </div>
                    <table id="tester_list" data-url="/manager.php/mark/control/paper_id/<?php echo ($paper_id); ?>"></table>
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
        //重新考试
        $('#reset').on('click',function(){
            //整理数据
            var idObj = $("#tester_list").bootstrapTable('getSelections');
            if(idObj.length == 0){
                layer.msg('没有选中数据');
            }else{
                layer.confirm('将清空该考生在本场考试的相关记录，考生可在考试规定时间内再次进入答题，请谨慎操作。<br>(注：将保留考生缓存答案)', {btn: ['确定', '取消']},
                        function(){
                            var paper_id = <?php echo ($paper_id); ?>; //assign进来
                            var tester_id = idObj[0].tester_id;
                            location.href = '/manager.php/mark/reset/tester_id/'+tester_id+'/paper_id/'+paper_id;
                        });
            }
        });

//        删除考生
        $('#remove').on('click',function(){
            //整理数据
            var idObj = $("#tester_list").bootstrapTable('getSelections');
            if(idObj.length == 0){
                layer.msg('没有选中数据');
            }else{
                layer.confirm('将完全删除学生的考试记录，学生相当于从未参加此考试！<br>(注：用于前期阶段，删除某些不相干考生)', {btn: ['确定', '取消']},
                        function(){
                            var paper_id = <?php echo ($paper_id); ?>; //assign进来
                            var tester_id = idObj[0].tester_id;
                            location.href = '/manager.php/mark/remove/tester_id/'+tester_id+'/paper_id/'+paper_id;
                        });
            }
        });

//        清除缓存答案
        $('#clear').on('click',function(){
            //整理数据
            var idObj = $("#tester_list").bootstrapTable('getSelections');
            if(idObj.length == 0){
                layer.msg('没有选中数据');
            }else{
                layer.confirm('将删除此考生的缓存答案', {btn: ['确定', '取消']},
                        function(){
                            var paper_id = <?php echo ($paper_id); ?>; //assign进来
                            var tester_id = idObj[0].tester_id;
                            location.href = '/manager.php/mark/clear/tester_id/'+tester_id+'/paper_id/'+paper_id;
                        });
            }
        });

        //逐个批改主观题
        $('#smark').on('click',function(){
            //整理数据
            var idObj = $("#tester_list").bootstrapTable('getSelections');
            if(idObj.length == 0){
                layer.msg('没有选中数据');
            }else{
                var paper_id = <?php echo ($paper_id); ?>; //assign进来
                var tester_id = idObj[0].tester_id;
                window.open('/manager.php/mark/smark/tester_id/'+tester_id+'/paper_id/'+paper_id);
            }
        });




        //删除工具栏中的tester_id
        $("input[data-field='tester_id']").parents("ul").find('li').eq(0).empty();
    });
</script>

</body>
</html>