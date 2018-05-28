<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <meta name="keywords" content="">
    <meta name="description" content="">

    <link rel="shortcut icon" href="/Public/favicon.ico"> 
	<link href="/Public/Admin/css/bootstrap.min.css?v=3.3.6" rel="stylesheet">
    <link href="/Public/Admin/css/font-awesome.css?v=4.4.0" rel="stylesheet">
    <link href="/Public/Admin/css/animate.css" rel="stylesheet">
    <link href="/Public/Admin/css/style.css?v=4.1.0" rel="stylesheet">
    <!-- 表单向导 -->
    <link href="/Public/Admin/css/plugins/steps/jquery.steps.css" rel="stylesheet">

</head>

<body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeInLeft">  

        <div class="row">
            <div class="col-sm-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>随机出卷</h5>
                    </div>
                    <div class="ibox-content">
                        <h2>随机出卷向导</h2>
                        <p>请根据步骤及提醒内容按要求填写信息</p>
                        <form id="paper" action="/manager.php/Paper/add_random" class="wizard-big" method="post" enctype="multipart/form-data">

                            <h1>试卷基本信息</h1>
                            <fieldset>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <div class="form-group">
                                            <label>试卷名称</label>
                                            <input id="name" name="name" type="text" class="form-control" placeholder="如：2016-2017学年第二学期网络基础期中测试" required>
                                        </div>
                                        <div class="form-group">
                                            <label>所属课程：</label>
                                            <select class="form-control" name="course_id" id="course_id" required>
                                                <option value="">请选择</option>
                                                <?php if(is_array($cou_info)): foreach($cou_info as $key=>$v): ?><option value="<?php echo ($v["id"]); ?>"><?php echo ($v["name"]); ?></option><?php endforeach; endif; ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>创建者：</label>
                                            <select class="form-control" name="maker_id" id="maker_id" required>
                                                <option value="">请选择</option>
                                                <?php if(is_array($teac_info)): foreach($teac_info as $key=>$v): ?><option value="<?php echo ($v["id"]); ?>"><?php echo ($v["name"]); ?></option><?php endforeach; endif; ?>
                                            </select>
                                        </div>
                                        
                                    </div>
                                    <div class="col-sm-4 col-sm-offset-1">
                                        <div class="form-group">
                                            <label>考试限制时间(分钟)</label>
                                            <input id="limittime" name="limittime" type="text" class="form-control" placeholder="如：120">
                                        </div>
                                        <div class="form-group">
                                            <label>开始日期</label>
                                            <input class="form-control " id="startdate" name="startdate" type="text">
                                        </div>
                                        <div class="form-group">
                                            <label>结束日期</label>
                                            <input id="enddate" name="enddate" type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </fieldset>


                            <h1>试题信息</h1>
                            <fieldset>
                                <div class="row" id="ques_info">
                                    <div class="col-sm-2" id="sin">
                                        <div class="form-group">
                                            <label>每道单选题分数</label>
                                            <input id="sin_score" name="sin_score" type="text" class="form-control  required digits" max="100">
                                        </div>
                                        <div class="form-group">
                                            <label>简单 * 单选题数量</label>
                                            <input id="sin_easy_num" name="sin_easy_num" type="text" class="form-control required digits" >
                                        </div>
                                        <div class="form-group">
                                            <label>一般 * 单选题数量</label>
                                            <input id="sin_com_num" name="sin_com_num" type="text" class="form-control required digits" >
                                        </div>
                                        <div class="form-group">
                                            <label>困难 * 单选题数量</label>
                                            <input id="sin_diff_num" name="sin_diff_num" type="text" class="form-control required digits" >
                                        </div>
                                    </div>

                                    <div class="col-sm-2" id="dou">
                                        <div class="form-group">
                                            <label>每道双选题分数</label>
                                            <input id="dou_score" name="dou_score" type="text" class="form-control required digits" max="100">
                                        </div>
                                        <div class="form-group">
                                            <label>简单 * 双选题数量</label>
                                            <input id="dou_easy_num" name="dou_easy_num" type="text" class="form-control required digits" >
                                        </div>
                                        <div class="form-group">
                                            <label>一般 * 双选题数量</label>
                                            <input id="dou_com_num" name="dou_com_num" type="text" class="form-control required digits" >
                                        </div>
                                        <div class="form-group">
                                            <label>困难 * 双选题数量</label>
                                            <input id="dou_diff_num" name="dou_diff_num" type="text" class="form-control required digits">
                                        </div>
                                    </div>

                                    <div class="col-sm-2" id="jud">
                                        <div class="form-group">
                                            <label>每道判断题分数</label>
                                            <input id="jud_score" name="jud_score" type="text" class="form-control required digits" max="100">
                                        </div>
                                        <div class="form-group">
                                            <label>简单 * 判断题数量</label>
                                            <input id="jud_easy_num" name="jud_easy_num" type="text" class="form-control required digits" >
                                        </div>
                                        <div class="form-group">
                                            <label>一般 * 判断题数量</label>
                                            <input id="jud_com_num" name="jud_com_num" type="text" class="form-control required digits" >
                                        </div>
                                        <div class="form-group">
                                            <label>困难 * 判断题数量</label>
                                            <input id="jud_diff_num" name="jud_diff_num" type="text" class="form-control required digits" >
                                        </div>
                                    </div>

                                    <div class="col-sm-2" id="sub">
                                        <div class="form-group">
                                            <label>每道主观题分数</label>
                                            <input id="sub_score" name="sub_score" type="text" class="form-control required digits" max="100">
                                        </div>
                                        <div class="form-group">
                                            <label>简单 * 主观题数量</label>
                                            <input id="sub_easy_num" name="sub_easy_num" type="text" class="form-control required digits" >
                                        </div>
                                        <div class="form-group">
                                            <label>一般 * 主观题数量</label>
                                            <input id="sub_com_num" name="sub_com_num" type="text" class="form-control required digits" >
                                        </div>
                                        <div class="form-group">
                                            <label>困难 * 主观题数量</label>
                                            <input id="sub_diff_num" name="sub_diff_num" type="text" class="form-control required digits" >
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>总分</label>
                                            <input id="whole_score" name="whole_score" type="text" class="form-control required digits" placeholder="自动得出总分" readonly>
                                        </div>

                                        <p>
                                            1 若是不需要某种类型题，请将其填写为0
                                        </p>

                                        <p> 2 随机题目筛选要求：① 符合所选课程题目。 ② 属性为 ‘没有在练习题中展示’  。 ③ 各难度的题目数量 和 所填符合。<br>请确保题库中有足够的类型题数量后再填写。
                                        </p>

                                        <p>
                                        注：只有单选，双选，判断才有  “展示到练习题”  这个属性，主观题没有此属性。
                                        </p>
                                    </div>
                                </div>
                            </fieldset>

                            <h1>试卷的限制对象</h1>
                            <fieldset>
                                <h2>均为选填，不限制考试对象可跳过此步</h2>
                                <div class="row">
                                    <div class="col-sm-7">

                                        <div class="form-group">
                                            <label>限制班级</label>
                                            <input id="limit_class" name="limit_class" type="text" class="form-control" placeholder="选填。格式为：计算机1504班+经管1506班">
                                        </div>
                                        <p>
                                            <i class="fa fa-info-circle"></i> 学院名称格式：数学，物理，化学，文学，外语，生科，政法，地理，经管，电子，计算机，土木，美术，体育，音乐，教科。
                                            <br>
                                            请按照<b>所给学院</b>名称添加上班级，可填多个对象，对象之间用 加号 隔开。（对象 = 学院+班级）
                                        </p>

                                    </div>
                                    <div class="col-sm-5">
                                        <div class="form-group">
                                            <label>限制学生</label>
                                            <input id="limit_stu_status" name="limit_stu_status" type="file" class="form-control">
                                        </div>
                                        <p>
                                            <i class="fa fa-info-circle"></i> 选填，该功能需要导入学生名单，请严格按照格式导入
                                        </p>
                                    </div>
                                </div>
                            </fieldset>

                            <h1>完成</h1>
                            <fieldset>
                                <h2>请注意如下几点：</h2>
                                <p>① 试卷基本信息填写成功，确认无误后，请记得更改审核状态为‘通过’。</p>
                                <p>
                                    ② 若是填写失败，请重新填写信息。
                                </p>
                            </fieldset>
                        </form>
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
    <!-- jQuery Validation plugin javascript-->
    <script src="/Public/Admin/js/plugins/validate/jquery.validate.min.js"></script>
    <script src="/Public/Admin/js/plugins/validate/messages_zh.min.js"></script> 
    <!--validate的提示信息转换成中文插件-->
	<script src="/Public/Admin/js/demo/form-validate-demo.js"></script>
    <!-- Steps -->
    <script src="/Public/Admin/js/plugins/steps/jquery.steps.min.js"></script>
    <!-- layerDate plugin javascript -->
    <script src="/Public/Admin/js/plugins/layer/laydate/laydate.js"></script>

    <script>
        $(document).ready(function () {
            //steps
            $("#paper").steps({
                bodyTag: "fieldset",
                onStepChanging: function (event, currentIndex, newIndex) {
                    // Always allow going backward even if the current step contains invalid fields!
                    if (currentIndex > newIndex) {
                        return true;
                    }

                    // Forbid suppressing "Warning" step if the user is to young
                    if (newIndex === 3 && Number($("#age").val()) < 18) {
                        return false;
                    }

                    var form = $(this);

                    // Clean up if user went backward before
                    if (currentIndex < newIndex) {
                        // To remove error styles
                        $(".body:eq(" + newIndex + ") label.error", form).remove();
                        $(".body:eq(" + newIndex + ") .error", form).removeClass("error");
                    }

                    // Disable validation on fields that are disabled or hidden.
                    form.validate().settings.ignore = ":disabled,:hidden";

                    // Start validation; Prevent going forward if false
                    return form.valid();
                },
                onStepChanged: function (event, currentIndex, priorIndex) {
                    // Suppress (skip) "Warning" step if the user is old enough.
                    if (currentIndex === 2 && Number($("#age").val()) >= 18) {
                        $(this).steps("next");
                    }

                    // Suppress (skip) "Warning" step if the user is old enough and wants to the previous step.
                    if (currentIndex === 2 && priorIndex === 3) {
                        $(this).steps("previous");
                    }
                },
                onFinishing: function (event, currentIndex) {
                    var form = $(this);

                    // Disable validation on fields that are disabled.
                    // At this point it's recommended to do an overall check (mean ignoring only disabled fields)
                    form.validate().settings.ignore = ":disabled";

                    // Start validation; Prevent form submission if false
                    return form.valid();
                },
                onFinished: function (event, currentIndex) {
                    var form = $(this);

                    // Submit form input
                    form.submit();
                }
            }).validate({
                errorPlacement: function (error, element) {
                    element.before(error);
                },
                rules: {
                    limittime: {
                        required:true,
                        digits:true,
                        max:300,
                    },
                    startdate: {
                        required:true,
                    },
                    enddate: {
                        required:true,
                    },
                }
            });

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

            // 试题中自动得出总分(ques为第二步骤里面的input框)
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

            $("#course_id").change(function(){
                var course_id = $("#course_id").val();
                if (course_id != '') {
                    $.post("/manager.php/Paper/add_random",{cou_id:course_id},function(data){
                        $('#sin_easy_num').attr({placeholder:data['sin_eas'],max:data['sin_eas']});
                        $('#sin_com_num').attr({placeholder:data['sin_com'],max:data['sin_com']});
                        $('#sin_diff_num').attr({placeholder:data['sin_dif'],max:data['sin_dif']});

                        $('#dou_easy_num').attr({placeholder:data['dou_eas'],max:data['dou_eas']});
                        $('#dou_com_num').attr({placeholder:data['dou_com'],max:data['dou_com']});
                        $('#dou_diff_num').attr({placeholder:data['dou_dif'],max:data['dou_dif']});

                        $('#jud_easy_num').attr({placeholder:data['jud_eas'],max:data['jud_eas']});
                        $('#jud_com_num').attr({placeholder:data['jud_com'],max:data['jud_com']});
                        $('#jud_diff_num').attr({placeholder:data['jud_dif'],max:data['jud_dif']});

                        $('#sub_easy_num').attr({placeholder:data['sub_eas'],max:data['sub_eas']});
                        $('#sub_com_num').attr({placeholder:data['sub_com'],max:data['sub_com']});
                        $('#sub_diff_num').attr({placeholder:data['sub_dif'],max:data['sub_dif']});

                    });
                }
            });
           
        });
    </script>
   
 

</body>

</html>