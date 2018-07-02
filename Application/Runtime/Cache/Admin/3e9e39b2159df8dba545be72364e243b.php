<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>列表</title>
    <meta name="keywords" content="">
    <meta name="description" content="">

    <link rel="shortcut icon" href="/Publicfavicon.ico">
    <link href="/Public/Admin/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .sj{
            text-indent: 2em;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <ul class="list-group">
            <li class="list-group-item "><b>请注意：</b></li>
            <li class="list-group-item sj">1. 上传前，请确保数据格式正确，格式参照下方所给图片。</li>
            <li class="list-group-item sj">2. 如果试题是复制到EXCEL中的，必须先复制到“记事本”以清除格式，然后再复制到EXCEL中。</li>
            <li class="list-group-item sj">3. 只能上传自己所教课程的题目，否则系统将报错，并需要您重新上传。</li>
        </ul>
    </div>
    <hr style="margin-top: 5px;margin-bottom: 10px;">

    <b>下载导入EXCEL格式示例：</b>  <a href="/Public/Admin/excel/jud_demo.xlsx">点击此处下载</a>
    <hr style="margin-top: 10px;margin-bottom: 20px;">

    <b>请选择文件：</b>
    <hr style="margin-top: 8px;margin-bottom: 10px;">
    <div class="row">
        <div class="col-sm-6">
            <form class="form-inline" role="form" method="post" action="/manager.php/Question/jud_import"  enctype="multipart/form-data">
                <div class="form-group">
                    <label class="sr-only" for="inputfile">文件输入</label>
                    <input type="file" id="inputfile" name="jud_file" >
                </div>
                <button type="submit" class="btn btn-danger btn-sm">导入</button>
                <span>【如果导入成功，请关闭此页面，然后刷新试题即可】</span>
            </form>
        </div>
    </div>
    <hr style="margin-top: 20px;margin-bottom: 20px;">
    <b>图片模板示例：</b>
    <img src="/Public/Admin/img/judge.png" alt="导入判断题模板示例"  >

</div>

<script src="/Public/Admin/js/jquery.min.js"></script>
<script src="/Public/Admin/js/bootstrap.min.js"></script>
</body>
</html>