<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title> 信息公告</title>
    <meta name="keywords" content="">
    <meta name="description" content="">

    <link rel="shortcut icon" href="/Publicfavicon.ico">
    <link href="/Public/Admin/css/bootstrap.min.css" rel="stylesheet">
    <link href="/Public/Admin/css/style.css" rel="stylesheet">
    <link href="/Public/Admin/css/animate.css" rel="stylesheet">
    <link href="/Public/Admin/css/font-awesome.css?v=4.4.0" rel="stylesheet">

</head>

<body class="gray-bg">
    <div class="wrapper wrapper-content animated flipInX">
        <div class="row">

            <div class="col-sm-10 col-sm-offset-1">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h3>信息公告</h3>
                    </div>
                    <div class="ibox-content">

                        <?php if(is_array($top_info)): foreach($top_info as $key=>$v): ?><div class="alert alert-danger">
                            <h4><?php echo (htmlspecialchars_decode($v["content"])); ?></h4>
                            <p class="text-right"><span class="badge badge-success">置顶</span> <?php echo (date('Y-m-d H:i:s',$v["pubdate"])); ?> ( <?php echo ($v["pubname"]); ?> )</p>
                        </div><?php endforeach; endif; ?>

                        <?php if(is_array($comm_info)): foreach($comm_info as $key=>$v): ?><div class="alert alert-success">
                            <h4><?php echo (htmlspecialchars_decode($v["content"])); ?></h4>
                            <p class="text-right"><?php echo (date('Y-m-d H:i:s',$v["pubdate"])); ?> ( <?php echo ($v["pubname"]); ?> )</p>
                        </div><?php endforeach; endif; ?>
                      
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="/Public/Admin/js/jquery.min.js"></script>
    <script src="/Public/Admin/js/bootstrap.min.js"></script>
    <script src="/Public/Admin/js/content.js"></script>

</body>

</html>