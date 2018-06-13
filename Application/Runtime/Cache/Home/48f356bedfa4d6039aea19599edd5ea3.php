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
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1 animated fadeInUp" style="background: white;">
            <div class="page-header text-success">
                <h3>【主观题】
                    <small>
                        <?php echo ($data["cname"]); ?> --- <?php echo ((isset($data["keyword"]) && ($data["keyword"] !== ""))?($data["keyword"]):'无'); ?>
                        (难度：
                        <?php if($data['difficulty'] == '1'): ?>*
                        <?php elseif($data['difficulty'] == 2): ?> **
                        <?php else: ?>***<?php endif; ?>
                        )
                        &nbsp;&nbsp;[ <a href="javascript:history.go(-1)">返回上一步</a> ]
                    </small>
                </h3>
            </div>
            <div class="bg-danger bg">
                题目描述：
                <hr>
                &nbsp;&nbsp;<?php echo (htmlspecialchars_decode($data["descr"])); ?>
            </div>
            <div class="bg-warning bg answ" id="answ">
                参考答案：
                <hr>
                    <?php echo ($data["right_answ"]); ?>
            </div>
            <div style="float:right;margin-right: 5px;">
                <button class="btn btn-danger" id="see">查看答案</button>
            </div>
            <div style="clear: both;"></div>
            <hr>
            推荐题目：
            <hr style="margin-top:5px; ">
            <div style="padding:5px 20px;">
                <?php if(is_array($other)): foreach($other as $key=>$v): ?><div style="height:30px;margin:10px;float:left; ">
                    <a href="/index.php/Practice/sub_detail/cid/<?php echo ($v['course_id']); ?>/id/<?php echo ($v['id']); ?>">

                        <?php if($v['id'] == $data['id'] ): ?><span class="badge badge-primary">
                            <?php else: ?>
                            <span class="badge badge-danger"><?php endif; ?>

                                <?php if($v['keyword']!='' ): echo ($v['keyword']); ?>
                                    <?php else: ?>
                                    <?php echo (msubstr(strip_tags(htmlspecialchars_decode($v['descr'])),0,15,'utf-8',false)); endif; ?>
                            </span>
                    </a>
                </div><?php endforeach; endif; ?>
                <div style="clear: both;"></div>
            </div>
            <hr>
            <div class="text-center"><h3><i class="fa fa-copyright"></i> EKA 2017</h3> </div>
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