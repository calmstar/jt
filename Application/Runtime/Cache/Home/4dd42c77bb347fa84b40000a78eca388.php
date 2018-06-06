<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>练习单选题 - JMoocTest</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="">
    <meta name="description" content="">

    <link rel="shortcut icon" href="/Public/favicon.ico"> <!--网页图标-->
    <link href="/Public/Admin/css/bootstrap.min.css?v=3.3.6" rel="stylesheet">
    <link href="/Public/Admin/css/font-awesome.min.css?v=4.4.0" rel="stylesheet"> <!--字体矢量图标，引入此行即可-->
    <link href="/Public/Admin/css/animate.css" rel="stylesheet">  <!--动画效果-->
    <link href="/Public/Admin/css/style.css?v=4.1.0" rel="stylesheet">
    <style type="text/css">
        .bg{
            margin: 20px 5px 5px 5px;
            padding: 20px 5px;
            word-wrap:break-word;
        }
        .answ{
            display: none;
        }
        body{
            font-size: 15px;
        }
    </style>

</head>

<body class="gray-bg" >

<!-- 正文 -->
<div class="container-fluid">

    <div class="row">
        <div class="col-sm-10 col-sm-offset-1 animated fadeInUp" style="background: white;">
            <!-- 单选题 -->
            <div class="page-header text-success">
                <h3>【主观题】<small><?php echo ($cou_name); ?></small></h3>
            </div>

            <div class="bg-danger bg">
                &nbsp;&nbsp;<?php echo ($p); ?>. <?php echo (htmlspecialchars_decode($info[0]["descr"])); ?>
            </div>

            <div class="bg-warning bg answ" id="answ">
                参考答案：<?php echo ($info[0]["right_answ"]); ?>
            </div>
            <div style="float:right;margin-right: 5px;">
                <button class="btn btn-danger" id="see">查看答案</button>
            </div>
            <div style="clear: both;"></div>

            <div class="hr-line-dashed"></div>
            <div class="row">
                <div class="text-center">
                    <?php echo ($page_show); ?>
                </div>
            </div>
            <hr>
            <div class="text-center">
                <h3>
                    <i class="fa fa-copyright"></i>
                    EKA 2017
                </h3>
            </div>

        </div>
    </div>
</div>

<script src="/Public/Admin/js/jquery.min.js?v=2.1.4"></script>
<script src="/Public/Admin/js/bootstrap.min.js?v=3.3.6"></script>
<script>
    var judge = 1;
    $('#see').click(function(){
        $('#answ').slideToggle();
        if(judge){
            $('#see').text('收起答案');
            judge = 0;
        }else{
            $('#see').text('查看答案');
            judge = 1;
        }
    });
</script>

</body>

</html>