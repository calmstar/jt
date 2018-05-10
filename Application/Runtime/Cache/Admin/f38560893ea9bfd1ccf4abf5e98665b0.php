<?php if (!defined('THINK_PATH')) exit();?> <!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>修改</title>
    <meta name="keywords" content="">
    <meta name="description" content="">

    <link rel="shortcut icon" href="/Publicfavicon.ico">
    <link href="/Public/Admin/css/bootstrap.min.css" rel="stylesheet">
    <link href="/Public/Admin/css/font-awesome.css?v=4.4.0" rel="stylesheet">
    <link href="/Public/Admin/css/animate.css" rel="stylesheet">
    <link href="/Public/Admin/css/style.css" rel="stylesheet">
    <link href="/Public/Admin/css/plugins/bootstrap-table/bootstrap-table.min.css" rel="stylesheet">
    <style type="text/css">
        /*将多出来的字以省略号形式表示*/
        table{
            table-layout:fixed;
        }
        td{  
            overflow:hidden;
            text-overflow:ellipsis;
            white-space:nowrap;
        }
    </style>
</head>

<body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeInRight">
        <!-- 基本信息 -->
        <form action="/manager.php/Paper/edit/id/58" method="post" id="basic">
        <div class="row">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>试卷基本信息 <small>请填写如下信息，每项必填</small></h5>
                    <div class="ibox-tools">
                        <input class="btn btn-primary" type="submit" name="basic">
                    </div>
                </div>
                
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-5">
                            <input type="hidden" name="id" value="<?php echo ($basic_info["id"]); ?>">
                            <div class="form-group">
                                <label>试卷名称</label>
                                <input id="name" name="name" type="text" class="form-control required" placeholder="如：2016-2017学年第二学期网络基础期中测试" value="<?php echo ($basic_info["name"]); ?>">
                            </div>
                            <div class="form-group">
                                <label>所属课程：</label>
                                <select class="form-control" name="course_id" id="course_id" required>
                                    <option value="<?php echo ($basic_info["course_id"]); ?>"><?php echo ($basic_info["course_name"]); ?></option>
                                    <?php if(is_array($cou_info)): foreach($cou_info as $key=>$v): ?><option value="<?php echo ($v["id"]); ?>"><?php echo ($v["name"]); ?></option><?php endforeach; endif; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>创建者：</label>
                                <select class="form-control" name="maker_id" id="maker_id" required>
                                    <option value="<?php echo ($basic_info["maker_id"]); ?>"><?php echo ($basic_info["maker_name"]); ?></option>
                                    <?php if(is_array($teac_info)): foreach($teac_info as $key=>$v): ?><option value="<?php echo ($v["id"]); ?>"><?php echo ($v["name"]); ?></option><?php endforeach; endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-5 col-sm-offset-1">
                            <div class="form-group">
                                <label>考试限制时间(分钟)</label>
                                <input id="limittime" name="limittime" type="text" class="form-control required digits" max="300" placeholder="如：120" value="<?php echo ($basic_info["limittime"]); ?>">
                            </div>
                            <div class="form-group">
                                <label>开始日期</label>
                                <input class="form-control " id="startdate" name="startdate" type="text" required value="<?php echo (date('Y/m/d H:i:s',$basic_info["startdate"])); ?>">
                            </div>
                            <div class="form-group">
                                <label>结束日期</label>
                                <input id="enddate" name="enddate" type="text" class="form-control" required value="<?php echo (date('Y/m/d H:i:s',$basic_info["enddate"])); ?>">
                            </div>
                        </div> 
                    </div> 
                </div>
            </div>
        </div>
        </form>

        <div class="row">
            <div class="col-sm-8">
                <div class="row">
                    <!-- 考试限制对象 -->
                    <div class="col-sm-12">
                        <form action="/manager.php/Paper/edit/id/58" method="post" enctype="multipart/form-data" id="limit">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>试卷限制对象 <small>以下皆为选填</small></h5>
                                <div class="ibox-tools">
                                    <input class="btn btn-primary" type="submit" name="limit">
                                </div>
                            </div>
                            <div class="ibox-content">
                                <input type="hidden" name="id" value="<?php echo ($basic_info["id"]); ?>">
                                <div class="form-group">
                                    <label>限制班级</label>
                                    <input id="limit_class" name="limit_class" type="text" class="form-control" placeholder="选填。格式为：计算机1504班+经管1506班" value="<?php echo ($limit_info["limit_class"]); ?>">
                                </div>
                                <p>
                                    <i class="fa fa-info-circle"></i> 学院名称格式：数学，物理，化学，文学，外语，生科，政法，地理，经管，电子，计算机，土木，美术，体育，音乐，教科。
                                    <br>
                                    请按照<b>所给学院</b>名称添加上班级，可填多个对象，对象之间用 加号 隔开。（对象 = 学院+班级）
                                </p>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <label>限制学生：
                                        <br>
                                        <small>
                                            ( 限制学生名单如右所示，若修改请重新选择文件；修改时系统会自动把之前旧学生名单清空，再导入该新的名单。)
                                        </small>
                                    </label>
                                    <input id="limit_stu_status" name="limit_stu_status" type="file" class="form-control">
                                </div>
                                <p>
                                    <i class="fa fa-info-circle"></i>

                                    选填，该功能需要导入学生名单，请严格按照格式导入
                                </p>
                                <div class="hr-line-dashed"></div>
                                <p>注：如果既限制了班级又限制了考生，则限制效果为两者的逻辑与</p>

                            </div>
                        </div>
                        </form>
                    </div>
                    <!-- 试题信息 -->
                    <div class="col-sm-12">
                        <form action="/manager.php/Paper/edit/id/58" method="post" id="ques">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>试题信息 <small>每项必填</small></h5>
                                <div class="ibox-tools">
                                    <input class="btn btn-primary" type="submit" name="ques">
                                </div>
                            </div>
                            <div class="ibox-content" id="ques_info">
                                <input type="hidden" name="id" value="<?php echo ($basic_info["id"]); ?>">
                                <div class="row">
                                    <div class="col-sm-3" id="sin">
                                        <div class="form-group">
                                            <label>每道单选题分数</label>
                                            <input id="sin_score" name="sin_score" type="text" class="form-control required digits" max="100" value="<?php echo ($ques_info["sin_score"]); ?>">
                                        </div>
                                        <!-- 判断为随机出卷时才显示 -->
                                        <?php if($basic_info['type'] == 1): ?><div class="form-group">
                                                <label>简单 * 单选题数量</label>
                                                <input id="sin_easy_num" name="sin_easy_num" type="text" class="form-control required digits" max="100" value="<?php echo ($ques_info["sin_easy_num"]); ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>一般 * 单选题数量</label>
                                                <input id="sin_com_num" name="sin_com_num" type="text" class="form-control required digits" max="100" value="<?php echo ($ques_info["sin_com_num"]); ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>困难 * 单选题数量</label>
                                                <input id="sin_diff_num" name="sin_diff_num" type="text" class="form-control required digits" max="100" value="<?php echo ($ques_info["sin_diff_num"]); ?>">
                                            </div><?php endif; ?>
                                    </div>

                                    <div class="col-sm-3" id="dou">
                                        <div class="form-group">
                                            <label>每道双选题分数</label>
                                            <input id="dou_score" name="dou_score" type="text" class="form-control required digits" max="100" value="<?php echo ($ques_info["dou_score"]); ?>">
                                        </div>
                                        <?php if($basic_info['type'] == 1): ?><div class="form-group">
                                                <label>简单 * 双选题数量</label>
                                                <input id="dou_easy_num" name="dou_easy_num" type="text" class="form-control required digits" max="100" value="<?php echo ($ques_info["dou_easy_num"]); ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>一般 * 双选题数量</label>
                                                <input id="dou_com_num" name="dou_com_num" type="text" class="form-control required digits" max="100" value="<?php echo ($ques_info["dou_com_num"]); ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>困难 * 双选题数量</label>
                                                <input id="dou_diff_num" name="dou_diff_num" type="text" class="form-control required digits" max="100" value="<?php echo ($ques_info["dou_diff_num"]); ?>">
                                            </div><?php endif; ?>
                                    </div>

                                    <div class="col-sm-3" id="jud">
                                        <div class="form-group">
                                            <label>每道判断题分数</label>
                                            <input id="jud_score" name="jud_score" type="text" class="form-control required digits" max="100" value="<?php echo ($ques_info["jud_score"]); ?>">
                                        </div>
                                        <?php if($basic_info['type'] == 1): ?><div class="form-group">
                                                <label>简单 * 判断题数量</label>
                                                <input id="jud_easy_num" name="jud_easy_num" type="text" class="form-control required digits" max="100" value="<?php echo ($ques_info["jud_easy_num"]); ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>一般 * 判断题数量</label>
                                                <input id="jud_com_num" name="jud_com_num" type="text" class="form-control required digits" max="100" value="<?php echo ($ques_info["jud_com_num"]); ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>困难 * 判断题数量</label>
                                                <input id="jud_diff_num" name="jud_diff_num" type="text" class="form-control required digits" max="100" value="<?php echo ($ques_info["jud_diff_num"]); ?>">
                                            </div><?php endif; ?>
                                    </div>

                                    <div class="col-sm-3" id="sub">
                                        <div class="form-group">
                                            <label>每道主观题分数</label>
                                            <input id="sub_score" name="sub_score" type="text" class="form-control required digits" max="100" value="<?php echo ($ques_info["sub_score"]); ?>">
                                        </div>
                                        <!-- 判断为随机出卷时才显示 -->
                                        <?php if($basic_info['type'] == 1): ?><div class="form-group">
                                                <label>简单 * 主观题数量</label>
                                                <input id="sub_easy_num" name="sub_easy_num" type="text" class="form-control required digits" max="100" value="<?php echo ($ques_info["sub_easy_num"]); ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>一般 * 主观题数量</label>
                                                <input id="sub_com_num" name="sub_com_num" type="text" class="form-control required digits" max="100" value="<?php echo ($ques_info["sub_com_num"]); ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>困难 * 主观题数量</label>
                                                <input id="sub_diff_num" name="sub_diff_num" type="text" class="form-control required digits" max="100" value="<?php echo ($ques_info["sub_diff_num"]); ?>">
                                            </div><?php endif; ?>
                                    </div>
                                </div>
                                <?php if($basic_info['type'] == 1): ?><!--随机出卷显示总分-->
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <div class="form-group">
                                                <label>当前总分</label>
                                                <input id="whole_score" name="whole_score" type="text" class="form-control digits" placeholder="自动得出总分" readonly value="<?php echo ($ques_info["whole_score"]); ?>">
                                            </div>
                                            <p>若是不需要某种类型题，请将其填写为0</p>
                                        </div>
                                    </div>
                                    <?php else: ?>
                                    <!--指定出卷显示总分-->
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <div class="form-group">
                                                <label>当前总分:</label>
                                                <span style="color:red;font-size: 18px"><?php echo ($ques_info["whole_score"]); ?></span>
                                            </div>
                                        </div>
                                    </div><?php endif; ?>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <!--学生名单-->
            <div class="col-sm-4">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>学生名单</h5>
                        <div class="ibox-tools">
                            <button class="btn btn-primary" id="clear_stu" value="<?php echo ($basic_info["id"]); ?>">
                                清空学生名单
                            </button>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <table class="table table-striped table-hover table-responsive">
                            <thead>
                                <tr>  
                                    <th>序号</th> 
                                    <th>名字</th>
                                    <th>学号</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(is_array($limit_info["stu"])): foreach($limit_info["stu"] as $key=>$v): ?><tr>
                                    <td><?php echo ($i++); ?></td>
                                    <td><?php echo ($v["stu_name"]); ?></td>
                                    <td><?php echo ($v["limit_xh"]); ?></td>
                                </tr><?php endforeach; endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- 判断为 指定出卷 才显示-->
        <?php if($basic_info['type'] == 2): ?><!--四种类型题表格-->
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>
                    所选题目如下
                </h5>
                <div class="ibox-tools">
                    <button class="btn btn-primary" role="button" id="change_table" value="<?php echo ($basic_info["id"]); ?>">修改</button>
                </div>
            </div>

            <div class="ibox-content">
                <div class="row row-lg">
                    <div class="col-sm-12">

                        <div class="tabs-container">
                            <ul class="nav nav-tabs">
                                <!-- 此处的改成tab_sin,否则有冲突 -->
                                <li class="active"><a data-toggle="tab" href="#tab_sin" aria-expanded="true">单选题</a>
                                </li>
                                <li class=""><a data-toggle="tab" href="#tab_dou" aria-expanded="false">双选题</a>
                                </li>
                                <li class=""><a data-toggle="tab" href="#tab_jud" aria-expanded="false">判断题</a>
                                </li>
                                <li class=""><a data-toggle="tab" href="#tab_sub" aria-expanded="false">主观题</a>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <div id="tab_sin" class="tab-pane active">
                                    <div class="panel-body">
                                        <table id="sin_table" data-url="/manager.php/Paper/edit?id=<?php echo ($basic_info["id"]); ?>&sin=sin"></table>
                                    </div>
                                </div>
                                <div id="tab_dou" class="tab-pane">
                                    <div class="panel-body">
                                        <table id="dou_table" data-url="/manager.php/Paper/edit?id=<?php echo ($basic_info["id"]); ?>&dou=dou"></table>
                                    </div>
                                </div>
                                <div id="tab_jud" class="tab-pane">
                                    <div class="panel-body">
                                        <table id="jud_table" data-url="/manager.php/Paper/edit?id=<?php echo ($basic_info["id"]); ?>&jud=jud"></table>
                                    </div>
                                </div>
                                <div id="tab_sub" class="tab-pane">
                                    <div class="panel-body">
                                        <table id="sub_table" data-url="/manager.php/Paper/edit?id=<?php echo ($basic_info["id"]); ?>&sub=sub"></table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div><?php endif; ?>

    </div>


    <script src="/Public/Admin/js/jquery.min.js"></script>
    <script src="/Public/Admin/js/bootstrap.min.js"></script>
    <script src="/Public/Admin/js/content.js"></script>
    <!-- bootstrap-table -->
    <script src="/Public/Admin/js/plugins/bootstrap-table/bootstrap-table.min.js"></script>
    <script src="/Public/Admin/js/plugins/bootstrap-table/locale/bootstrap-table-zh-CN.js"></script>
    <script src="/Public/Admin/js/demo/bootstrap-table-demo.js"></script>
    <!-- layerDate plugin javascript -->
    <script src="/Public/Admin/js/plugins/layer/laydate/laydate.js"></script>
    <!-- layer -->
    <script src="/Public/Admin/js/plugins/layer/layer.js"></script>
    <!-- jQuery Validation plugin javascript-->
    <script src="/Public/Admin/js/plugins/validate/jquery.validate.min.js"></script>
    <script src="/Public/Admin/js/plugins/validate/messages_zh.min.js"></script>
    <script src="/Public/Admin/js/demo/form-validate-demo.js"></script>

    <script type="text/javascript">

        

        $(function(){
            //删除工具栏中的id,有四个表格，每次只能删除一个
            $("input[data-field='id']").parents("ul").find('li').eq(0).empty();
            $("input[data-field='id']").parents("ul").find('li').eq(0).empty();
            $("input[data-field='id']").parents("ul").find('li').eq(0).empty();
            $("input[data-field='id']").parents("ul").find('li').eq(0).empty();
            //隐藏course_name
            $('#sin_table').bootstrapTable('hideColumn','course_name');
            $('#dou_table').bootstrapTable('hideColumn','course_name');
            $('#jud_table').bootstrapTable('hideColumn','course_name');
            $('#sub_table').bootstrapTable('hideColumn','course_name');

            //去掉复选框 (后面的为自动增长)
            // var i = $(":checkbox");
            // console.log(i.length);
            // $("input[name='btSelectAll']").remove();
            
            // $('.bs-checkbox').remove();

            // $("td[class='bs-checkbox']").remove();

            // $(":checkbox").remove();

            // $('#sin_table').ajaxComplete(function(){
            //     var j = $("input[name='btSelectItem']");
            //     console.log(j);
            // });



            //layerdate日期范围限制
            var startdate = {
                elem: '#startdate',
                format: 'YYYY/MM/DD hh:mm:ss',
                min: laydate.now(), //设定最小日期为当前日期
                max: '2099-06-16 23:59:59', //最大日期
                istime: true,
                istoday: true,
                choose: function (datas) {
                    enddate.min = datas; //开始日选好后，重置结束日的最小日期
                    enddate.start = datas //将结束日的初始值设定为开始日
                }
            };
            var enddate = {
                elem: '#enddate',
                format: 'YYYY/MM/DD hh:mm:ss',
                min: laydate.now(),
                max: '2099-06-16 23:59:59',
                istime: true,
                istoday: true,
                choose: function (datas) {
                    startdate.max = datas; //结束日选好后，重置开始日的最大日期
                }
            };
            laydate(startdate);
            laydate(enddate);

            // 试题中自动得出总分(ques_info为第二步骤里面的input框)
            $('#ques_info').find(':input').on('change',function(){
                var ss = $('#sin_score').val();
                var sen = $('#sin_easy_num').val();
                var scn = $('#sin_com_num').val(); 
                var sdn = $('#sin_diff_num').val();
                var ds = $('#dou_score').val();
                var den = $('#dou_easy_num').val();
                var dcn = $('#dou_com_num').val(); 
                var ddn = $('#dou_diff_num').val();
                var js = $('#jud_score').val();
                var jen =  $('#jud_easy_num').val();
                var jcn = $('#jud_com_num').val(); 
                var jdn = $('#jud_diff_num').val();
                var sus = $('#sub_score').val();
                var suen = $('#sub_easy_num').val();
                var sucn = $('#sub_com_num').val(); 
                var sudn = $('#sub_diff_num').val();
                //转成number
                // (ss == '') ? ss = 0 : ss = parseInt(ss); 与下面判断冲突
                (sen == '') ? sen = 0 : sen = parseInt(sen);
                (scn == '') ? scn = 0 : scn = parseInt(scn);
                (sdn == '') ? sdn = 0 : sdn = parseInt(sdn);
                // (ds == '') ? ds = 0 : ds = parseInt(ds);
                (den == '') ? den = 0 : den = parseInt(den);
                (dcn == '') ? dcn = 0 : dcn = parseInt(dcn);
                (ddn == '') ? ddn = 0 : ddn = parseInt(ddn);
                // (js == '') ? js = 0 : js = parseInt(js);
                (jen == '') ? jen = 0 : jen = parseInt(jen);
                (jcn == '') ? jcn = 0 : jcn = parseInt(jcn);
                (jdn == '') ? jdn = 0 : jdn = parseInt(jdn);
                // (sus == '') ? sus = 0 : sus = parseInt(sus);
                (suen == '') ? suen = 0 : suen = parseInt(suen);
                (sucn == '') ? sucn = 0 : sucn = parseInt(sucn);
                (sudn == '') ? sudn = 0 : sudn = parseInt(sudn);
                //计算总分
                var score = ss * (sen + scn + sdn) + ds * (den + dcn + ddn) + js * (jen + jcn + jdn) + sus * (suen + sucn + sudn)
                $('#whole_score').attr('value',score);

                //若某种题型分数为0，该题型有关的其他选项内容为0
                if(ss == '0'){
                    $('#sin').find(':input').val('0');
                }
                if(ds == '0'){
                    $('#dou').find(':input').val('0');
                }
                if(js == '0'){
                    $('#jud').find(':input').val('0');
                }
                if(sus == '0'){
                    $('#sub').find(':input').val('0');
                }
            });

            //清空学生名单
            $('#clear_stu').on('click',function(){
                var paper_id = $('#clear_stu').attr('value');
                layer.confirm('清空后，限制学生功能将不启用',{btn: ['确定', '取消']},
                    function(){ 
                        // 清空该试卷的学生名单，修改limit_stu_status,全面修改
                        $.post("/manager.php/Paper/edit/id/58",{'clear_stu':1,'paper_id':paper_id},function(data){
                                if(data){
                                    window.location.reload();
                                }else{
                                    layer.msg('清空失败');
                                }
                            },
                        );

                    },
                );
            });

            //点击修改题目按钮，跳转到fixed_ques
            $('#change_table').on('click',function(){
                //获取paper_id跳转fixed_ques
                var paper_id = $('#change_table').attr('value');
                layer.confirm('需要重新勾选题目',{btn: ['确定', '取消']},
                    function(){ 
                        window.location.href='/manager.php/Paper/fixed_ques/paper_id/'+paper_id;
                });
                
            });

            //开启validate校验在form-validate-demo.js中

        });
    </script>

</body>
</html>