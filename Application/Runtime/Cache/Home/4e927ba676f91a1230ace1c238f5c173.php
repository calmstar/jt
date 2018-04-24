<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title>练习判断题 - JMoocTest</title>
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
    
    <!-- 正文 -->
    <div class="container-fluid">

        <div class="row">
            <div class="col-sm-10 col-sm-offset-1 animated fadeInUp" style="background: white;">
                <div class="page-header text-success">
                    <h3>【判断题】<small><?php echo ($cou_name); ?></small></h3>
                </div>

                <div class="bg-danger bg">
                     &nbsp;&nbsp;<?php echo ($p); ?>. <?php echo (strip_tags(htmlspecialchars_decode($info[0]["descr"]))); ?>
                </div>
                <div class="answ">
                    <div class="radio">
                        <label>
                            <input type="radio" name="jud" value="<?php echo ($info[0]["is_true"]); ?>" onclick="check(this.value)">
                            <i class="glyphicon glyphicon-ok"></i>
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="jud" value="<?php echo ($info[0]["is_false"]); ?>" onclick="check(this.value)">
                            <i class="glyphicon glyphicon-remove"></i>
                        </label>
                    </div>
                    
                    <span id="tips"></span>
                </div>
                

                <div class="hr-line-dashed"></div>
                <div class="row">
                    <div class="col-sm-6 col-sm-offset-6">
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
    <script type="text/javascript">

        function check(val){
            $('#tips').empty();

            $.ajax({
                type:"POST",
                url:"/index.php/Practice/check_jud",
                data:{jud:val}, //获取表单的所有数据
                success:function(data){
                    if(data['status'] == '1'){
                        $('#tips').append('答案正确');
                        $('#tips').css('color','green');
                    }else{
                        $('#tips').append('答案错误');
                        $('#tips').css('color','red');
                    }
                }
            });
        }
    </script>

</body>

</html>