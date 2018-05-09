<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title>正在批改 - JMoocTest</title>
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
        body{
            font-size: 15px;
        }
        
    </style>

</head>

<body class="gray-bg" >
    <form action="/manager.php/Mark/marking" method="post" id="marking">
    <input type="hidden" name="highest" value="<?php echo ($ns["sub_score"]); ?>">
    <!-- 正文 -->
    <div class="container-fluid">
        <div class="row">
            
            <div class="col-sm-4 animated fadeInDown">

                <div class="row">
                    <div class="panel panel-warning">
                        <div class="panel-heading">操作面板</div>
                        <div class="panel-body">
                            <div class="text-center">
                                <input class="btn btn-primary" type="submit" value="保存分数" name="save"> &nbsp;&nbsp;&nbsp;
                                <input class="btn btn-danger" type="submit" value="完成批改" name="save">
                            </div>
                            <div class="hr-line-dashed"></div>
                            <p>
                                1. 保存分数：没有批改完考生答题卡的，可以先保存分数后再退出（考生无法查阅主观题成绩）。
                                <br>
                                2. 完成批改：此试卷所有考生的主观题将被标志为已批改，<b>并不在此列表显示</b>；考生将可查阅到自己的主观题成绩；
                                <br>
                                3. 建议批改完主观题后进行保存，等到所有考生考完试后，即考试开放时间结束后，再点击完成批改按钮。
                            </p>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="panel panel-success">
                        <div class="panel-heading">试题信息面板</div>
                        <div class="panel-body">

                            <div class="well">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <h4>
                                        试卷名称：<?php echo ($ns["paper_name"]); ?>
                                        </h4>
                                    </div>
                                    <div class="col-sm-12">
                                        <h4>
                                        每道题目分数：<?php echo ($ns["sub_score"]); ?>
                                        </h4>
                                    </div>
                                    <div class="col-sm-12">
                                        <p>注：右边只显示未批改考生的答题卡</p>
                                        <p style="font-weight: bold;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;由于每个考生的试题顺序都为随机，所以答案的位置也不一样，请教师根据试题id进行批改</p>
                                    </div>
                                </div>
                            </div>

                            <?php if(is_array($sub_info)): foreach($sub_info as $key=>$x): ?><div class="bg-warning bg" >
                                <?php echo ($x["id"]); ?>. <?php echo ($x["descr"]); ?>
                            </div>
                            <p class="text-info">参考答案：<?php echo ($x["right_answ"]); ?></p><?php endforeach; endif; ?>

                        </div>
                    </div>
                </div>

            </div>

            <div class="col-sm-8 animated fadeInUp">

                <!-- 考生遍历 -->
                <?php if(is_array($info)): foreach($info as $key=>$v): ?><div class="panel panel-primary">
                    <div class="panel-heading">答题卡：考生<?php echo ($k++); ?></div>
                    <div class="panel-body">
                        <!-- 提示信息 -->
                        <div class="well">
                            <div class="row">
                                <div class="col-sm-2">
                                    姓名：<?php echo ($v["name"]); ?>
                                </div>
                                <div class="col-sm-3">
                                    学号：<?php echo ($v["xuehao"]); ?>
                                </div>
                                <div class="col-sm-3">
                                    班级：<?php echo ($v["stu_class"]); ?>
                                </div>
                                <div class="col-sm-4">
                                    交卷时间：<?php if($v["etime"] == '' ): ?>超时提交 <?php else: ?> <?php echo (date('Y-m-d H:i:s',$v["etime"])); endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- 考生题目遍历 -->
                        <?php if(is_array($v[myansw])): $kk = 0; $__LIST__ = $v[myansw];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vv): $mod = ($kk % 2 );++$kk;?><div class="answ">
                            <div class="bg-success bg" >
                                <?php echo ($vv['id']); ?>. <?php echo ($vv['answ']); ?>
                            </div>
                            <br>
                            <p class="text-right">
                                得分：<input type="text" name="<?php echo ($v["ssid"]); ?>[]" value="<?php echo ($vv['each_ms']); ?>" max="<?php echo ($ns["sub_score"]); ?>" class="digits">
                            </p>
                        </div><?php endforeach; endif; else: echo "" ;endif; ?>

                    </div>
                </div><?php endforeach; endif; ?>
                </div>
        </div>

        <div class="panel-footer text-center">
            <h3><i class="fa fa-copyright"></i> EKA 2017</h3>
        </div>

    </div>

    </form>
    
    <script src="/Public/Admin/js/jquery.min.js?v=2.1.4"></script>  
    <script src="/Public/Admin/js/bootstrap.min.js?v=3.3.6"></script>
    <script src="/Public/Admin/js/plugins/validate/jquery.validate.min.js"></script>
    <script src="/Public/Admin/js/plugins/validate/messages_zh.min.js"></script> 
    <script type="text/javascript">
        $('#marking').validate();
    </script>

</body>

</html>