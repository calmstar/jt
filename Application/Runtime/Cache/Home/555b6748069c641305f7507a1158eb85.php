<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title>练习双选题 - JMoocTest</title>
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
                    <h3>【双选题】<small><?php echo ($cou_name); ?></small></h3>
                </div>

                <div class="bg-danger bg">
                     &nbsp;&nbsp;<?php echo ($p); ?>. <?php echo (strip_tags(htmlspecialchars_decode($info[0]["descr"]))); ?>
                </div>
                <form>
                <div class="answ">                              
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="dou[]" value="<?php echo ($info[0]["is_op1"]); ?>" onclick="check(this.value)" ><?php echo ($info[0]["op1"]); ?>
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="dou[]" value="<?php echo ($info[0]["is_op2"]); ?>" onclick="check(this.value)"> <?php echo ($info[0]["op2"]); ?>
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="dou[]" value="<?php echo ($info[0]["is_op3"]); ?>" onclick="check(this.value)" ><?php echo ($info[0]["op3"]); ?>
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="dou[]" value="<?php echo ($info[0]["is_op4"]); ?>" onclick="check(this.value)" ><?php echo ($info[0]["op4"]); ?>
                        </label>
                    </div>
                    <span id="tips"></span>  
                </div>
                </form>

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
    <script type="text/javascript">

        function check(val){
            var xx = $("input:checked");
            var num = xx.length;

            if(num == '2'){
                $('#tips').empty();
                $.ajax({
                    type:"POST",
                    url:"/index.php/Practice/check_dou",
                    data:$("form").serialize(), //获取表单的所有数据

                    success:function(data){
                        if(data['status'] == '1'){
                            $('#tips').append('<i class="glyphicon glyphicon-ok text-success"></i>');
                        }else{
                            $('#tips').append('<i class="glyphicon glyphicon-remove text-danger"></i>');
                        }
                    }
                });
            }
            
        }
    </script>

</body>

</html>