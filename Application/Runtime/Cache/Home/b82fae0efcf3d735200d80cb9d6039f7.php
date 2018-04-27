<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>正在考试 - JMoocTest</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="">
    <meta name="description" content="">

    <link rel="shortcut icon" href="/Public/favicon.ico"> <!--网页图标-->
    <link href="/Public/Admin/css/bootstrap.min.css?v=3.3.6" rel="stylesheet">
    <link href="/Public/Admin/css/animate.css" rel="stylesheet">  <!--动画效果-->
    <link href="/Public/Admin/css/style.css?v=4.1.0" rel="stylesheet">
    <!-- 会把navbar原生效果重置掉 -->
    
    <style type="text/css">
        .bg{
            margin: 20px 5px 5px 5px;
            padding: 20px 5px;
            word-wrap:break-word;
            user-select: none;
            -moz-user-select:none;   /*火狐浏览器*/
            -webkit-user-select:none;  /*webkit浏览器*/
            -ms-user-select:none;  /*IE10*/
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
        /*重置style里面的css*/
        .navbar-fixed-top {
            min-height: 70px;
            line-height: 70px;
            position: fixed;
        }
        .well{
            margin-top: 70px;
        }

    </style>

</head>

<body class="bg-success" >

    <form action="/index.php/Test/answ" method="post">

    <!-- 正文 -->
    <div class="container-fluid">

        <nav class="navbar navbar-default navbar-fixed-top animated fadeInDown">
            <div class="container">
                <div class="row">
                    <div class="col-sm-2 text-center text-danger">
                        <span id="resttime" style="display:none"><?php echo ($resttime); ?></span>
                        <span style="font-size: 20px;">
                            <span id="hour_show">00</span>:
                            <span id="minute_show">00</span>:
                            <span id="second_show">00</span>
                        </span>
                    </div>
                    <div class="col-sm-8">
                        <div class="text-center">
                            <h2><?php echo ($info["name"]); ?></h2>
                        </div>
                    </div>
                    <div class="col-sm-2 text-center">
                        <input type="submit" id="finish" class="btn btn-danger btn-rounded" value="确认交卷">
                    </div>
                </div>
            </div>
        </nav>

        <div class="row">
            <div class="col-sm-8 col-sm-offset-2 animated fadeInUp">

                <div class="panel panel-success">

                    <!--缓存答案，随意修改后果自负-->
                    <input type="hidden" name="paper_id" value="<?php echo ($info["paper_id"]); ?>">
                    <input type="hidden" name="sin_num" value="<?php echo ($info["sin_num"]); ?>">
                    <input type="hidden" name="dou_num" value="<?php echo ($info["dou_num"]); ?>">
                    <input type="hidden" name="jud_num" value="<?php echo ($info["jud_num"]); ?>">
                    <input type="hidden" name="sub_num" value="<?php echo ($info["sub_num"]); ?>">
                    <input type="hidden" name="sin_score" value="<?php echo ($info["sin_score"]); ?>">
                    <input type="hidden" name="dou_score" value="<?php echo ($info["dou_score"]); ?>">
                    <input type="hidden" name="jud_score" value="<?php echo ($info["jud_score"]); ?>">

                    <div class="panel-body">
                        <!-- 提示信息 -->
                        <div class="well">
                            <div class="row">
                                <div class="col-sm-6 ">
                                    <h4>考试限时：<?php echo ($info["limittime"]); ?>分钟</h4>
                                </div>
                                <div class="col-sm-6 ">
                                    <h4>总分：<?php echo ($info["whole_score"]); ?></h4>
                                </div>
                                <div class="col-sm-6 ">
                                    <h4>所属课程：<?php echo ($info["course_name"]); ?></h4>
                                </div>
                                <div class="col-sm-6 ">
                                    <h4>出题人：<?php echo ($info["maker_name"]); ?></h4>
                                </div>
                            </div>
                            <p class="text-danger">
                                考生注意： 请在规定时间内作答完毕，点击右上角「提交考试」，未在规定时间内答题完毕系统将会自动提交试卷。若不小心关闭了本窗口或浏览器，请及时登录账号，并到回来继续进行考试，浪费的时间也算入倒计时中。
                            </p>
                        </div>
                        <!-- 单选题 -->
                        <div class="page-header text-success">
                            <h3>【单选题】<small>每道 <?php echo ($info["sin_score"]); ?> 分,共 <?php echo ($info["sin_num"]); ?> 道</small></h3>
                        </div>

                       <?php if(is_array($info[sin])): foreach($info[sin] as $key=>$v): ?><div class="bg-warning bg">
                            <?php echo ($i++); ?>. <?php echo (strip_tags(htmlspecialchars_decode($v["descr"]))); ?>
                        </div>
                        <div class="answ">
                            <div class="radio">
                                <label>
                                    <input type="radio" value="is_op<?php echo ($n[0]); ?>" name="<?php echo ($i-1); ?>"  <?php if($v['myansw'] == $n[0]): ?>checked='checked'<?php endif; ?> 
                                    ><?php echo ($v["op$n[0]"]); ?>
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" value="is_op<?php echo ($n[1]); ?>" name="<?php echo ($i-1); ?>" <?php if($v['myansw'] == $n[1]): ?>checked='checked'<?php endif; ?> ><?php echo ($v["op$n[1]"]); ?>
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" value="is_op<?php echo ($n[2]); ?>" name="<?php echo ($i-1); ?>" <?php if($v['myansw'] == $n[2]): ?>checked='checked'<?php endif; ?> ><?php echo ($v["op$n[2]"]); ?>
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" value="is_op<?php echo ($n[3]); ?>"  name="<?php echo ($i-1); ?>" <?php if($v['myansw'] == $n[3]): ?>checked='checked'<?php endif; ?> ><?php echo ($v["op$n[3]"]); ?>
                                </label>
                            </div>
                        </div><?php endforeach; endif; ?>

                        <div class="hr-line-dashed"></div>

                        <!-- 双选题 -->
                        <div class="page-header text-success">
                            <h3>【双选题】<small>每道 <?php echo ($info["dou_score"]); ?> 分,共 <?php echo ($info["dou_num"]); ?>道</small></h3>
                        </div>
                       
                       <?php if(is_array($info[dou])): foreach($info[dou] as $key=>$v): ?><div class="bg-warning bg" >
                            <?php echo ($i++); ?>. <?php echo (strip_tags(htmlspecialchars_decode($v["descr"]))); ?>
                        </div>
                        <div class="answ">                              
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="is_op<?php echo ($n[0]); ?>" name="<?php echo ($i-1); ?>[]"  <?php if(in_array($n['0'],$v[myansw])): ?>checked='checked'<?php endif; ?> >  <?php echo ($v["op$n[0]"]); ?>
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="is_op<?php echo ($n[1]); ?>" name="<?php echo ($i-1); ?>[]" <?php if(in_array($n[1],$v[myansw])): ?>checked='checked'<?php endif; ?> > <?php echo ($v["op$n[1]"]); ?>
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="is_op<?php echo ($n[2]); ?>" name="<?php echo ($i-1); ?>[]" <?php if(in_array($n[2],$v[myansw])): ?>checked='checked'<?php endif; ?> > <?php echo ($v["op$n[2]"]); ?>
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="is_op<?php echo ($n[3]); ?>"  name="<?php echo ($i-1); ?>[]" <?php if(in_array($n[3],$v[myansw])): ?>checked='checked'<?php endif; ?> > <?php echo ($v["op$n[3]"]); ?>
                                </label>
                            </div>
                        </div><?php endforeach; endif; ?>

                        <div class="hr-line-dashed"></div>

                        <!-- 判断题 -->
                        <div class="page-header text-success">
                            <h3>【判断题】<small>每道 <?php echo ($info["jud_score"]); ?> 分,共 <?php echo ($info["jud_num"]); ?> 道</small></h3>
                        </div>
                       
                        <?php if(is_array($info[jud])): foreach($info[jud] as $key=>$v): ?><div class="bg-warning bg" >
                            <?php echo ($i++); ?>. <?php echo (strip_tags(htmlspecialchars_decode($v["descr"]))); ?>
                        </div>
                        <div class="answ">
                            <div class="radio">
                                <label>
                                    <input type="radio" value="is_true" name="<?php echo ($i-1); ?>" <?php if($v['myansw'] == 1): ?>checked='checked'<?php endif; ?> >
                                    <i class="glyphicon glyphicon-ok"></i>
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" value="is_false" name="<?php echo ($i-1); ?>" <?php if( $v['myansw'] == '0' ): ?>checked='checked'<?php endif; ?> >
                                    <i class="glyphicon glyphicon-remove"></i>
                                </label>
                            </div>
                        </div><?php endforeach; endif; ?>

                        <div class="hr-line-dashed"></div>

                        <!-- 主观题 -->
                        <div class="page-header text-success">
                            <h3>【主观题】<small>每道 <?php echo ($info["sub_score"]); ?> 分,共 <?php echo ($info["sub_num"]); ?> 道</small></h3>
                        </div>
                        
                        <?php if(is_array($info[sub])): foreach($info[sub] as $key=>$v): ?><div class="bg-warning bg" >
                            <?php echo ($i++); ?>. <?php echo (strip_tags(htmlspecialchars_decode($v["descr"]))); ?>
                        </div>
                        <div style="padding-left: 25px">
                            <textarea class="form-control" style="height:250px; border:1px solid #ddd;" name="<?php echo ($i-1); ?>"><?php if($v['myansw'] != 'xx' ): echo ($v['myansw']); endif; ?></textarea>
                        </div><?php endforeach; endif; ?>
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

    </form>
    
    <script src="/Public/Admin/js/jquery.min.js?v=2.1.4"></script>  
    <script src="/Public/Admin/js/bootstrap.min.js?v=3.3.6"></script>
    <script src="/Public/Admin/js/plugins/layer/layer.js"></script>
    <script type="text/javascript">

        //倒计时
        var exam_time=$('#resttime').text();
        var intDiff = parseInt(exam_time);//倒计时总秒数,将获得的字符串变为数字型

        function timer(intDiff){

            window.setInterval(function(){
                var hour=00,
                    minute=00,
                    second=00;//时间默认值

                if(intDiff > 0){
                    // 考试限制为最多五个小时
                    day = Math.floor(intDiff / (60 * 60 * 24));
                    hour = Math.floor(intDiff / (60 * 60)) - (day * 24);
                    minute = Math.floor(intDiff / 60) - (day * 24 * 60) - (hour * 60);
                    second = Math.floor(intDiff) - (day * 24 * 60 * 60) - (hour * 60 * 60) - (minute * 60);
                }else if(intDiff == 0 ){ 
                      $('#finish').click();     
                }

                if (hour <= 9) hour = '0' + hour;
                if (minute <= 9) minute = '0' + minute;
                if (second <= 9) second = '0' + second;

                $('#hour_show').text(hour);
                $('#minute_show').text(minute);
                $('#second_show').text(second);
                intDiff--;

            },1000);//一秒执行一次
        }


        // 每隔十秒发送答案到数据库中
        function time_post(){
            window.setInterval(function(){
                $.ajax({
                    type:"POST",
                    url:"/index.php/Test/exam",
                    data:$("form").serialize(), //获取表单的所有数据
                });
            },10000);
        }

        $(function(){
            timer(intDiff);
            time_post();
        });
        

    </script>

</body>

</html>