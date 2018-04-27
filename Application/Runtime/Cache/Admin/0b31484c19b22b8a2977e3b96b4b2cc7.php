<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title>查看试卷 - JMoocTest</title>
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
            padding-left: 25px;
        }
        .panel{
            border: none;
        }
        body{
            font-size: 15px;
        }
    </style>

</head>

<body class="gray-bg" >

<!-- 正文 -->
<div class="container-fluid">
    <form action="/manager.php/Mark/smark/tester_id/<?php echo ($sid); ?>/paper_id/<?php echo ($pid); ?>" method="post">
    <div class="row">
        <div class="col-sm-8 col-sm-offset-2 animated fadeInUp">

            <div class="panel panel-success">
                <div class="panel-heading" style="padding:20px 15px;font-size: 24px">
                    <div class="row">
                        <div class="col-sm-7">
                            <div class="text-right"><?php echo ($stu["pname"]); ?></div>
                        </div>
                        <div class="col-sm-5">
                            <div class="text-right"><button class="btn btn-danger btn-rounded">确定批改</button></div>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <!-- 提示信息 -->
                    <div class="well">
                        <div class="row">
                            <div class="col-sm-3">
                                <h4>姓名：<?php echo ($stu["name"]); ?></h4>
                            </div>
                            <div class="col-sm-3">
                                <h4>学号：<?php echo ($stu["xuehao"]); ?> </h4>
                            </div>
                            <div class="col-sm-3">
                                <h4>班级：<?php echo ($stu["stu_class"]); ?> </h4>
                            </div>
                            <div class="col-sm-3">
                                <h4>出卷类型：<?php if($stu["type"] == 1): ?>随机出卷<?php else: ?>指定出卷<?php endif; ?> </h4>
                            </div>
                        </div>
                        <p class="text-danger">
                            注意：此功能下，教师可随时修改考生客观题分数。
                        </p>
                    </div>
                    <div class="page-header text-success">
                        <h3>【主观题】<small>每道 <?php echo ($score_info["sub_score"]); ?> 分,共 <?php echo ($score_info["sub_num"]); ?> 道，<b>总得分：<?php echo ($score_info["get_score"]); ?></b></small></h3>
                    </div>
                    <input type="hidden" name="full_score" value="<?php echo ($score_info["sub_score"]); ?>">

                    <?php if(is_array($subj)): $k = 0; $__LIST__ = $subj;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($k % 2 );++$k;?><div class="bg-warning bg" >
                            <?php echo ($i++); ?>. <?php echo ($v["descr"]); ?>
                        </div>
                        <div class="answ">
                            <textarea class="form-control" style="height:250px; border:1px solid #ddd;"><?php echo ($v["myansw"]); ?></textarea>
                            <br>
                            <p class="bg-success">
                                参考答案：<?php echo ($v["right_answ"]); ?>
                            </p>
                            <p class="text-right">
                                得分：<input type="text" value="<?php echo ($v["myscore"]); ?>" name="<?php echo ($i-2); ?>">
                            </p>
                        </div><?php endforeach; endif; else: echo "" ;endif; ?>
                </div>

                <div class="panel-footer text-center">
                    <h3>
                        <i class="fa fa-copyright"></i>
                        EKA 2017
                    </h3>
                </div>
            </div>

        </div>
    </div>
    </form>

</div>

<script src="/Public/Admin/js/jquery.min.js?v=2.1.4"></script>
<script src="/Public/Admin/js/bootstrap.min.js?v=3.3.6"></script>

</body>

</html>