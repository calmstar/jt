<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link href="/Public/Admin/css/bootstrap.min.css?v=3.3.6" rel="stylesheet">
</head>
<body>
    <table class="table table-hover">
        <th>#</th>
        <th>注册日期</th>
        <th>名字</th>
        <th>班级</th>
        <?php if(is_array($data)): foreach($data as $key=>$v): ?><tr>
            <td><?php echo ($i++); ?></td>
            <td><?php echo (date('Y-m_d H:i:s',$v["rgdate"])); ?></td>
            <td><?php echo ($v["name"]); ?></td>
            <td><?php echo ($v["stu_class"]); ?></td>
        </tr><?php endforeach; endif; ?>
    </table>

    <script src="/Public/Admin/js/jquery.min.js?v=2.1.4"></script>
    <script src="/Public/Admin/js/bootstrap.min.js?v=3.3.6"></script>

</body>
</html>