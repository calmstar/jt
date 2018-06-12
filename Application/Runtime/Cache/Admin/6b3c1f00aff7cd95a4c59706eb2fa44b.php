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
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2 animated fadeInUp">

                <div class="panel panel-success">
                    <div class="panel-heading text-center" style="padding:20px 15px;font-size: 24px">
                            <?php echo ($info["name"]); ?>
                    </div>

                    <div class="panel-body">
                        <!-- 提示信息 -->
                        <div class="well">
                            <div class="row">
                                <div class="col-sm-6 ">
                                    <h4>考试限时：<?php echo ($info["limittime"]); ?>分钟</h4>
                                </div>
                                <div class="col-sm-6 ">
                                    <h4>总分：<?php echo ($info["whole_score"]); ?>，得分：<?php echo ($my_score["all_score"]); ?></h4>
                                </div>
                                <div class="col-sm-6 ">
                                    <h4>所属课程：<?php echo ($info["course_name"]); ?></h4>
                                </div>
                                <div class="col-sm-6 ">
                                    <h4>出题人：<?php echo ($info["maker_name"]); ?></h4>
                                </div>
                                <div class="col-sm-6 ">
                                    <h4>开放时间段：<?php echo (date('Y-m-d H:i:s',$info["startdate"])); ?>
                                    ----
                                    <?php echo (date('Y-m-d H:i:s',$info["enddate"])); ?></h4>
                                </div>
                                <div class="col-sm-6 ">
                                    <h4>出卷类型：<?php if($info["type"] == 1): ?>随机出卷<?php else: ?>指定出卷<?php endif; ?> </h4>
                                </div>
                                <div class="col-sm-6 ">
                                    <h4>进入试卷时间：<?php echo ($my_score["stime"]); ?> </h4>
                                </div>
                                <div class="col-sm-6 ">
                                    <h4>提交试卷时间：<?php if($my_score["etime"] == '' ): ?>超时提交<?php else: echo ($my_score["etime"]); endif; ?>
                                    </h4>
                                </div>
                                <div class="col-sm-4 ">
                                    <h4>学号：<?php echo ($stu_info["xuehao"]); ?>
                                    </h4>
                                </div>
                                <div class="col-sm-4 ">
                                    <h4>名字：<?php echo ($stu_info["name"]); ?>
                                    </h4>
                                </div>
                                <div class="col-sm-4 ">
                                    <h4>学院：<?php echo ($stu_info["college"]); ?>
                                    </h4>
                                </div>
                                <div class="col-sm-4 ">
                                    <h4>班级：<?php echo ($stu_info["stu_class"]); ?>
                                    </h4>
                                </div>
                                <div class="col-sm-4 ">
                                    <h4>电话：<?php echo ((isset($stu_info["telphone"]) && ($stu_info["telphone"] !== ""))?($stu_info["telphone"]):'未填写'); ?>
                                    </h4>
                                </div>
                                <div class="col-sm-4 ">
                                    <h4>邮箱：<?php echo ((isset($stu_info["email"]) && ($stu_info["email"] !== ""))?($stu_info["email"]):'未填写'); ?>
                                    </h4>
                                </div>

                            </div>
                            <p class="text-danger">
                                注意：蓝色背景加粗部分为正确答案，选中的为考生答案。
                            </p>
                        </div>
                        <!-- 单选题 -->
                        <div class="page-header text-success">
                            <h3>【单选题】<small>每道 <?php echo ($info["sin_score"]); ?> 分,共 <?php echo ($info["sin_num"]); ?> 道，<b>得分：<?php echo ($my_score["single_score"]); ?></b></small></h3>
                        </div>

                       <?php if(is_array($info[sin])): foreach($info[sin] as $key=>$v): ?><div class="bg-warning bg">
                            <?php echo ($i++); ?>. <?php echo ($v["descr"]); ?>
                        </div>
                        <div class="answ">
                            <div class="radio">
                                <label>
                                    <input type="radio"  <?php if($v['myansw'] == 1): ?>checked='checked'<?php endif; ?> disabled >
                                    <?php if($v[is_op1] == 1): ?><span class="bg-primary"><?php echo ($v["op1"]); ?></span>
                                    <?php else: echo ($v["op1"]); endif; ?>
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" <?php if($v['myansw'] == 2): ?>checked='checked'<?php endif; ?> disabled>
                                    <?php if($v[is_op2] == 1): ?><span class="bg-primary"><?php echo ($v["op2"]); ?></span>
                                    <?php else: echo ($v["op2"]); endif; ?>
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" <?php if($v['myansw'] == 3): ?>checked='checked'<?php endif; ?> disabled>
                                    <?php if($v[is_op3] == 1): ?><span class="bg-primary"><?php echo ($v["op3"]); ?></span>
                                    <?php else: echo ($v["op3"]); endif; ?>
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" <?php if($v['myansw'] == 4): ?>checked='checked'<?php endif; ?> disabled>
                                    <?php if($v[is_op4] == 1): ?><span class="bg-primary"><?php echo ($v["op4"]); ?></span>
                                    <?php else: echo ($v["op4"]); endif; ?>
                                </label>
                            </div>
                        </div><?php endforeach; endif; ?>

                        <div class="hr-line-dashed"></div>

                        <!-- 双选题 -->
                        <div class="page-header text-success">
                            <h3>【双选题】<small>每道 <?php echo ($info["dou_score"]); ?> 分,共 <?php echo ($info["dou_num"]); ?>道，<b>得分：<?php echo ($my_score["double_score"]); ?></b></small></h3>
                        </div>
                       
                       <?php if(is_array($info[dou])): foreach($info[dou] as $key=>$v): ?><div class="bg-warning bg" >
                            <?php echo ($i++); ?>. <?php echo ($v["descr"]); ?>
                        </div>
                        <div class="answ">                              
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" <?php if(in_array(1,$v[myansw])): ?>checked='checked'<?php endif; ?> disabled>
                                    <?php if($v[is_op1] == 1): ?><span class="bg-primary"><?php echo ($v["op1"]); ?></span>
                                    <?php else: echo ($v["op1"]); endif; ?>
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" <?php if(in_array(2,$v['myansw'])): ?>checked='checked'<?php endif; ?> disabled >
                                    <?php if($v[is_op2] == 1): ?><span class="bg-primary"><?php echo ($v["op2"]); ?></span>
                                    <?php else: echo ($v["op2"]); endif; ?>
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" <?php if(in_array(3,$v['myansw'])): ?>checked='checked'<?php endif; ?> disabled>
                                    <?php if($v[is_op3] == 1): ?><span class="bg-primary"><?php echo ($v["op3"]); ?></span>
                                    <?php else: echo ($v["op3"]); endif; ?>
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" <?php if(in_array(4,$v['myansw'])): ?>checked='checked'<?php endif; ?> disabled>
                                    <?php if($v[is_op4] == 1): ?><span class="bg-primary"><?php echo ($v["op4"]); ?></span>
                                    <?php else: echo ($v["op4"]); endif; ?>
                                </label>
                            </div>
                        </div><?php endforeach; endif; ?>

                        <div class="hr-line-dashed"></div>

                        <!-- 判断题 -->
                        <div class="page-header text-success">
                            <h3>【判断题】<small>每道 <?php echo ($info["jud_score"]); ?> 分,共 <?php echo ($info["jud_num"]); ?> 道，<b>得分：<?php echo ($my_score["judge_score"]); ?></b></small></h3>
                        </div>
                       
                        <?php if(is_array($info[jud])): foreach($info[jud] as $key=>$v): ?><div class="bg-warning bg" >
                            <?php echo ($i++); ?>. <?php echo ($v["descr"]); ?>
                        </div>
                        <div class="answ">
                            <div class="radio">
                                <label>
                                    <input type="radio" <?php if($v['myansw'] == 1): ?>checked='checked'<?php endif; ?> disabled >

                                    <?php if($v[is_true] == 1): ?><span class="bg-primary"><i class="glyphicon glyphicon-ok"></i></span>
                                    <?php else: ?>
                                    <i class="glyphicon glyphicon-ok"></i><?php endif; ?>
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" <?php if( $v['myansw'] == '0' ): ?>checked='checked'<?php endif; ?> disabled>

                                    <?php if($v[is_false] == 1): ?><span class="bg-primary"><i class="glyphicon glyphicon-remove"></i></span>
                                    <?php else: ?>
                                    <i class="glyphicon glyphicon-remove"></i><?php endif; ?>
                                </label>
                            </div>
                        </div><?php endforeach; endif; ?>

                        <div class="hr-line-dashed"></div>

                        <!-- 主观题 -->
                        <div class="page-header text-success">
                            <h3>【主观题】<small>每道 <?php echo ($info["sub_score"]); ?> 分,共 <?php echo ($info["sub_num"]); ?> 道，<b>总得分：<?php echo ($my_score["subj_score"]); ?></b></small></h3>
                        </div>
                        
                        <?php if(is_array($info[sub])): $k = 0; $__LIST__ = $info[sub];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($k % 2 );++$k;?><div class="bg-warning bg" >
                            <?php echo ($i++); ?>. <?php echo ($v["descr"]); ?>
                        </div>
                        <div class="answ">
                            <textarea class="form-control" style="height:250px; border:1px solid #ddd;"><?php echo ($v["myansw"]); ?></textarea>
                            <br>
                            <p class="bg-success">
                                参考答案：<?php echo ($v["right_answ"]); ?>
                            </p>
                            <p class="text-right">
                                得分：<input type="text" value="<?php echo ($each_ms[$k-1]); ?>" disabled="disabled">
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
    </div>

    <script src="/Public/Admin/js/jquery.min.js?v=2.1.4"></script>  
    <script src="/Public/Admin/js/bootstrap.min.js?v=3.3.6"></script>

</body>

</html>