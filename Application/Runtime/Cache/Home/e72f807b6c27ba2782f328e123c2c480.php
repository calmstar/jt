<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title> - 考试模块</title>
    <meta name="keywords" content="">
    <meta name="description" content="">

    <link rel="shortcut icon" href="/Public/favicon.ico"> <!--网页图标-->
    <link href="/Public/Admin/css/bootstrap.min.css?v=3.3.6" rel="stylesheet">
    <link href="/Public/Admin/css/font-awesome.min.css?v=4.4.0" rel="stylesheet"> <!--字体矢量图标，引入此行即可-->
    <link href="/Public/Admin/css/animate.css" rel="stylesheet">  <!--动画效果-->
    <link href="/Public/Admin/css/style.css?v=4.1.0" rel="stylesheet">

</head>

<body class="gray-bg">


    <div class="wrapper wrapper-content animated fadeInRight">
        <!-- 进行中 -->
        <h3>进行中 <small>请确保有足够的空闲时间答题，进入考试将无法暂停~</small></h3>
        <div class="row">
            <?php if(is_array($start_info)): foreach($start_info as $key=>$v): ?><div class="col-sm-4">
                <div class="contact-box" style="height: 235px;">
                    <div class="col-sm-12 text-center">
                        <h3><strong><?php echo ($v["name"]); ?></strong></h3>
                        <p><i class="fa fa-user"></i> 出题人：<?php echo ($v["maker_name"]); ?></p>
                        <p><i class="fa fa-clock-o"></i> 考试限时：<?php echo ($v["limittime"]); ?>分钟</p>

                        <p>
                            <i class="fa fa-hourglass-start"></i> 
                            开放时间：<?php echo (date('Y-m-d H:i:s',$v["startdate"])); ?>
                        </p>
                        <p>
                            <i class="fa fa-hourglass-end"></i> 
                            结束时间：<?php echo (date('Y-m-d H:i:s',$v["enddate"])); ?>
                        </p>
                        
                        <a class="btn btn-default" type="button" href="/index.php/Test/exam/id/<?php echo ($v["id"]); ?>" target="_blank">
                            <i class="fa fa-check"></i>&nbsp;
                            <strong>进入考试 </strong>
                        </a>

                    </div>
                    <div class="clearfix"></div>
                </div>
            </div><?php endforeach; endif; ?>
        </div>
        <hr style="border: 1px solid #e4b9b9;">
        <!-- 待开始 -->
        <h3>待开始 <small>请耐心等待，注意考试开放时间~</small></h3>
        <div class="row">
            <?php if(is_array($wait_info)): foreach($wait_info as $key=>$v): ?><div class="col-sm-4">
                <div class="contact-box" style="height: 230px;">
                    <div class="col-sm-12 text-center">
                        <h3><strong><?php echo ($v["name"]); ?></strong></h3>
                        <p><i class="fa fa-user"></i> 出题人：<?php echo ($v["maker_name"]); ?></p>
                        <p><i class="fa fa-clock-o"></i> 考试限时：<?php echo ($v["limittime"]); ?>分钟</p>
                        <p>
                            <i class="fa fa-hourglass-start"></i> 
                            开放时间：<?php echo (date('Y-m-d H:i:s',$v["startdate"])); ?>
                        </p>
                        <p>
                            <i class="fa fa-hourglass-end"></i> 
                            结束时间：<?php echo (date('Y-m-d H:i:s',$v["enddate"])); ?>
                        </p>
                        
                        <button class="btn btn-default" type="button" disabled="disabled">
                            <i class="fa fa-minus"></i>&nbsp;
                            <strong>待开始 </strong>
                        </button>

                    </div>
                    <div class="clearfix"></div>
                </div>
            </div><?php endforeach; endif; ?>
        </div>
        <hr style="border: 1px solid #e4b9b9;">
        <!-- 已结束 -->
        <h3>已结束 <small>已过结束时间，不可进入考试~</small></h3>
        <div class="row">
            <?php if(is_array($end_info)): foreach($end_info as $key=>$v): ?><div class="col-sm-4">
                <div class="contact-box" style="height: 230px;">
                    <div class="col-sm-12 text-center">
                        <h3><strong><?php echo ($v["name"]); ?></strong></h3>
                        <p><i class="fa fa-user"></i> 出题人：<?php echo ($v["maker_name"]); ?></p>
                        <p><i class="fa fa-clock-o"></i> 考试限时：<?php echo ($v["limittime"]); ?>分钟</p>
                        <p>
                            <i class="fa fa-hourglass-start"></i> 
                            开放时间：<?php echo (date('Y-m-d H:i:s',$v["startdate"])); ?>
                        </p>
                        <p>
                            <i class="fa fa-hourglass-end"></i> 
                            结束时间：<?php echo (date('Y-m-d H:i:s',$v["enddate"])); ?>
                        </p>
                        
                        <button class="btn btn-default" type="button" disabled="disabled">
                            <i class="fa fa-close"></i>&nbsp;
                            <strong>已结束 </strong>
                        </button>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div><?php endforeach; endif; ?>
        </div>
    </div>

    <script src="/Public/Admin/js/jquery.min.js?v=2.1.4"></script>  
    <script src="/Public/Admin/js/bootstrap.min.js?v=3.3.6"></script>
    <!-- 不是在iframe页时显示小图标，点击跳回主页 -->
    <script src="/Public/Admin/js/content.js?v=1.0.0"></script>
    <script>
        $(document).ready(function () {
            //鼠标放上的效果pulse
            $('.contact-box').each(function () {
                animationHover(this, 'pulse');
            });
        });
    </script>

</body>

</html>