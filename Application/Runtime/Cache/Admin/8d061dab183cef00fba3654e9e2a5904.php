<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title> 系统信息</title>

    <meta name="keywords" content="">
    <meta name="description" content="">

    <link rel="shortcut icon" href="/Public/favicon.ico"> 
    <link href="/Public/Admin/css/bootstrap.min.css?v=3.3.6" rel="stylesheet">
    <link href="/Public/Admin/css/font-awesome.css?v=4.4.0" rel="stylesheet">
    <link href="/Public/Admin/css/animate.css" rel="stylesheet">
    <link href="/Public/Admin/css/style.css?v=4.1.0" rel="stylesheet">
    <style type="text/css">
        .number{
            font-size: 5ex;
            color: red;
        }
        .s-number{
            font-size: 4ex;
            color: red;
        }
        .ss-number{
            font-size: 3ex;
        }
        .fix-height{
            height: 280px;
            overflow: auto;
        }
    </style>
</head>

<body class="gray-bg">

    <div class="container">

        <div class="row">
            <div class="col-sm-4">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        数据统计
                    </div>
                    <div class="panel-body fix-height">
                        <div class="row">
                            <div class="col-sm-6">
                                今日访问学生：<span class="ss-number"><?php echo ($sjtj["tod_view"]); ?></span>
                            </div>
                            <div class="col-sm-6">
                                今日新增学生：<span class="ss-number"><?php echo ($sjtj["tod_add"]); ?></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                历史访问次数：<span class="ss-number"><?php echo ($sjtj["hist_all"]); ?></span>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-6">
                                <i class="fa fa-user-secret fa-2x"></i>
                                管理员：<span class="ss-number"><?php echo ($sjtj["adm_num"]); ?></span>
                            </div>
                            <div class="col-sm-6">
                                <i class="fa fa-user fa-2x"></i>
                                教师用户：<span class="ss-number"><?php echo ($sjtj["tea_num"]); ?></span>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-6">
                                <i class="fa fa-users fa-2x"></i>
                                学生：<span class="ss-number"><?php echo ($sjtj["stu_num"]); ?></span>
                            </div>
                            <div class="col-sm-6">
                                <i class="fa fa-book fa-2x"></i>
                                课程：<span class="ss-number"><?php echo ($sjtj["cou_num"]); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        考试动态
                    </div>
                    <div class="panel-body fix-height">
                        <div class="row">
                            <div class="col-sm-6">
                                今日开始考试：<span class="number"><?php echo ($ksdt["tod_ing"]); ?></span>
                            </div>
                            <div class="col-sm-6">
                                今日截止考试：<span class="number"><?php echo ($ksdt["tod_ed"]); ?></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                共有试卷：<span class="number"><?php echo ($ksdt["all_num"]); ?></span>
                            </div>
                            <div class="col-sm-6">
                                今日新建试卷：<span class="number"><?php echo ($ksdt["new_paper"]); ?></span>
                            </div>
                        </div>
                        <hr>
                         已审核：<span class="s-number"><?php echo ($ksdt["check"]); ?></span>，未审核：<span class="s-number"><?php echo ($ksdt["non_check"]); ?></span>
                         <br>
                        进行中：<span class="s-number"><?php echo ($ksdt["ing"]); ?></span>，已结束：<span class="s-number"><?php echo ($ksdt["ed"]); ?></span>，未开始：<span class="s-number"><?php echo ($ksdt["soon"]); ?></span>
                        <br>
                        随机出卷：<span class="s-number"><?php echo ($ksdt["random"]); ?></span>，指定出卷：<span class="s-number"><?php echo ($ksdt["fixed"]); ?></span>
                    </div>
                  
                </div>
            </div>
            <div class="col-sm-4">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        试题信息
                    </div>
                    <div class="panel-body fix-height" >
                        <b>单选题</b>：<span class="ss-number"><?php echo ($info_sin["all_num"]); ?></span>
                        <br>
                        展示到练习题：<span class="ss-number"><?php echo ($info_sin["show"]); ?></span>，
                        不展示：<span class="ss-number"><?php echo ($info_sin["no_show"]); ?></span>
                        <br>
                        难度为简单：<span class="ss-number"><?php echo ($info_sin["easy"]); ?></span>，一般：<span class="ss-number"><?php echo ($info_sin["common"]); ?></span>，困难：<span class="ss-number"><?php echo ($info_sin["diff"]); ?></span>
                        <table class="table table-hover">
                            <th>课程</th>
                            <th>所含试题</th>
                            <?php if(is_array($info_sin["table"])): foreach($info_sin["table"] as $key=>$v): ?><tr>
                                <td><?php echo ($v["name"]); ?></td>
                                <td><?php echo ($v["num"]); ?></td>
                            </tr><?php endforeach; endif; ?>
                        </table>

                        <hr>

                        <b>双选题</b>：<span class="ss-number"><?php echo ($info_dou["all_num"]); ?></span>
                        <br>
                        展示到练习题：<span class="ss-number"><?php echo ($info_dou["show"]); ?></span>，
                        不展示：<span class="ss-number"><?php echo ($info_dou["no_show"]); ?></span>
                        <br>
                        难度为简单：<span class="ss-number"><?php echo ($info_dou["easy"]); ?></span>，一般：<span class="ss-number"><?php echo ($info_dou["common"]); ?></span>，困难：<span class="ss-number"><?php echo ($info_dou["diff"]); ?></span>
                        <table class="table table-hover">
                            <th>课程</th>
                            <th>所含试题</th>
                            <?php if(is_array($info_dou["table"])): foreach($info_dou["table"] as $key=>$v): ?><tr>
                                <td><?php echo ($v["name"]); ?></td>
                                <td><?php echo ($v["num"]); ?></td>
                            </tr><?php endforeach; endif; ?>
                        </table>

                        <hr>

                        <b>判断题</b>：<span class="ss-number"><?php echo ($info_jud["all_num"]); ?></span>
                        <br>
                        展示到练习题：<span class="ss-number"><?php echo ($info_jud["show"]); ?></span>，
                        不展示：<span class="ss-number"><?php echo ($info_jud["no_show"]); ?></span>
                        <br>
                        难度为简单：<span class="ss-number"><?php echo ($info_jud["easy"]); ?></span>，一般：<span class="ss-number"><?php echo ($info_jud["common"]); ?></span>，困难：<span class="ss-number"><?php echo ($info_jud["diff"]); ?></span>
                        <table class="table table-hover">
                            <th>课程</th>
                            <th>所含试题</th>
                            <?php if(is_array($info_jud["table"])): foreach($info_jud["table"] as $key=>$v): ?><tr>
                                <td><?php echo ($v["name"]); ?></td>
                                <td><?php echo ($v["num"]); ?></td>
                            </tr><?php endforeach; endif; ?>
                        </table>

                        <hr>

                        <b>主观题</b>：<span class="ss-number"><?php echo ($info_sub["all_num"]); ?></span>
                        <br>
                        难度为简单：<span class="ss-number"><?php echo ($info_sub["easy"]); ?></span>，一般：<span class="ss-number"><?php echo ($info_sub["common"]); ?></span>，困难：<span class="ss-number"><?php echo ($info_sub["diff"]); ?></span>
                        <table class="table table-hover">
                            <th>课程</th>
                            <th>所含试题</th>
                            <?php if(is_array($info_sub["table"])): foreach($info_sub["table"] as $key=>$v): ?><tr>
                                <td><?php echo ($v["name"]); ?></td>
                                <td><?php echo ($v["num"]); ?></td>
                            </tr><?php endforeach; endif; ?>
                        </table>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        管理员通讯录
                    </div>
                    <div class="panel-body fix-height" >
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                罗予东
                            </div>
                            <div class="col-sm-9">
                                手机：13751950588--650588
                            </div>
                            <div class="col-sm-9 col-sm-offset-3">
                                邮箱：lyd@jyueka.com
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                陈文星
                            </div>
                            <div class="col-sm-9">
                                手机：17875511965--691965
                            </div>
                            <div class="col-sm-9 col-sm-offset-3">
                                邮箱：494025451@qq.com
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        用户学院分布
                    </div>
                    <ul class="list-group fix-height">
                        <li class="list-group-item">
                            <span class="badge"><?php echo ((isset($yhxyfb["ji"]) && ($yhxyfb["ji"] !== ""))?($yhxyfb["ji"]):'0'); ?></span>
                            计算机学院
                        </li>
                        <li class="list-group-item">
                            <span class="badge"><?php echo ((isset($yhxyfb["shu"]) && ($yhxyfb["shu"] !== ""))?($yhxyfb["shu"]):'0'); ?></span>
                            数学学院
                        </li>
                        <li class="list-group-item">
                            <span class="badge"><?php echo ((isset($yhxyfb["wu"]) && ($yhxyfb["wu"] !== ""))?($yhxyfb["wu"]):'0'); ?></span>
                            物理与光信息科技学院
                        </li>
                        <li class="list-group-item">
                            <span class="badge"><?php echo ((isset($yhxyfb["hua"]) && ($yhxyfb["hua"] !== ""))?($yhxyfb["hua"]):'0'); ?></span>
                            化学与环境学院
                        </li>
                        <li class="list-group-item">
                            <span class="badge"><?php echo ((isset($yhxyfb["wen"]) && ($yhxyfb["wen"] !== ""))?($yhxyfb["wen"]):'0'); ?></span>
                            文学院
                        </li>
                        <li class="list-group-item">
                            <span class="badge"><?php echo ((isset($yhxyfb["wai"]) && ($yhxyfb["wai"] !== ""))?($yhxyfb["wai"]):'0'); ?></span>
                            外国语学院
                        </li>
                        <li class="list-group-item">
                            <span class="badge"><?php echo ((isset($yhxyfb["sheng"]) && ($yhxyfb["sheng"] !== ""))?($yhxyfb["sheng"]):'0'); ?></span>
                            生命科学学院
                        </li>
                        <li class="list-group-item">
                            <span class="badge"><?php echo ((isset($yhxyfb["zheng"]) && ($yhxyfb["zheng"] !== ""))?($yhxyfb["zheng"]):'0'); ?></span>
                            政法学院
                        </li>
                        <li class="list-group-item">
                            <span class="badge"><?php echo ((isset($yhxyfb["di"]) && ($yhxyfb["di"] !== ""))?($yhxyfb["di"]):'0'); ?></span>
                            地理科学与旅游学院
                        </li>
                        <li class="list-group-item">
                            <span class="badge"><?php echo ((isset($yhxyfb["jin"]) && ($yhxyfb["jin"] !== ""))?($yhxyfb["jin"]):'0'); ?></span>
                            经济与管理学院
                        </li>
                        <li class="list-group-item">
                            <span class="badge"><?php echo ((isset($yhxyfb["dian"]) && ($yhxyfb["dian"] !== ""))?($yhxyfb["dian"]):'0'); ?></span>
                            电子信息工程学院
                        </li>
                        <li class="list-group-item">
                            <span class="badge"><?php echo ((isset($yhxyfb["tu"]) && ($yhxyfb["tu"] !== ""))?($yhxyfb["tu"]):'0'); ?></span>
                            土木工程学院
                        </li>
                        <li class="list-group-item">
                            <span class="badge"><?php echo ((isset($yhxyfb["mei"]) && ($yhxyfb["mei"] !== ""))?($yhxyfb["mei"]):'0'); ?></span>
                            美术学院
                        </li>
                        <li class="list-group-item">
                            <span class="badge"><?php echo ((isset($yhxyfb["ti"]) && ($yhxyfb["ti"] !== ""))?($yhxyfb["ti"]):'0'); ?></span>
                            体育学院
                        </li>
                        <li class="list-group-item">
                            <span class="badge"><?php echo ((isset($yhxyfb["yin"]) && ($yhxyfb["yin"] !== ""))?($yhxyfb["yin"]):'0'); ?></span>
                            音乐学院
                        </li>
                        <li class="list-group-item">
                            <span class="badge"><?php echo ((isset($yhxyfb["jiao"]) && ($yhxyfb["jiao"] !== ""))?($yhxyfb["jiao"]):'0'); ?></span>
                            教育科学学院
                        </li>
                        <li class="list-group-item">
                            <span class="badge"><?php echo ((isset($yhxyfb["qi"]) && ($yhxyfb["qi"] !== ""))?($yhxyfb["qi"]):'0'); ?></span>
                            其他学院
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        运行信息
                    </div>
                    <div class="panel-body fix-height" >
                        <div class="row">
                            <div class="col-sm-4">
                                框架版本
                            </div>
                            <div class="col-sm-8">
                                <?php echo ($yx["tp_ver"]); ?>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-4">
                                站点域名
                            </div>
                            <div class="col-sm-8">
                                <?php echo ($yx["yuming"]); ?>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-4">
                                服务器信息
                            </div>
                            <div class="col-sm-8">
                                <?php echo ($yx["ser_info"]); ?>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-4">
                                数据库版本
                            </div>
                            <div class="col-sm-8">
                                <?php echo ($yx["mysql_ver"]); ?>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-4">
                                数据库大小
                            </div>
                            <div class="col-sm-8">
                                <?php echo ($yx["size"]); ?>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-4">
                                系统类型及版本号
                            </div>
                            <div class="col-sm-8">
                                <?php echo ($yx["os"]); ?>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        
    </div>

    <!-- 全局js -->
    <script src="/Public/Admin/js/jquery.min.js?v=2.1.4"></script>
    <script src="/Public/Admin/js/bootstrap.min.js?v=3.3.6"></script>
    <!-- 自定义js -->
    <script src="/Public/Admin/js/content.js?v=1.0.0"></script>


</body>

</html>