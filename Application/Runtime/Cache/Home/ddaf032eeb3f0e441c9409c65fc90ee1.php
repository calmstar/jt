<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>登录 - JMoocTest</title>
    <link rel="shortcut icon" href="/Public/favicon.ico"> 
    <link rel="stylesheet" href="/Public/Admin/plugins/layui/css/layui.css">
    <link rel="stylesheet" href="/Public/Admin/css/login.css">
    <link href="/Public/Admin/css/bootstrap.min.css?v=3.3.6" rel="stylesheet">
    <link href="/Public/Admin/css/style.css?v=4.1.0" rel="stylesheet">
</head>

<body>
    <canvas id="dot"></canvas>

    <form class="layui-form login">
        <h1>JMoocTest</h1>

        <div class="layui-form-item">
            <input type="text" name="stuNumber"  required lay-verify="required|num|xuehao" placeholder="正方学号" autocomplete="off" class="layui-input">
        </div>

        <div class="layui-form-item">
            <input type="password" name="password"  required lay-verify="required|pass" placeholder="密码" autocomplete="off" class="layui-input">
        </div>

        <div class="layui-form-item">
            <div class="layui-input-inline captcha-input">
                <input type="text" name="code"  required lay-verify="required" placeholder="验证码" autocomplete="off" class="layui-input">
            </div>
            <div class="layui-input-inline captcha-img">
                <img src="/index.php/public/verifyImg" alt="验证码加载失败" title="点击刷新验证码">
            </div>
        </div>

        <div class="layui-form-item">
            <button class="layui-btn submit_btn" lay-submit lay-filter="login">登录</button>
        </div>

        <div class="layui-form-item" >
            <div style="float:left;"> <a id="about"> 关于注册 </a> </div>
            <div style="float:right;"><a data-toggle="modal" href="#forget"> 忘记密码>>  </a></div>
        </div>

    </form>

    <!--弹出表单-->
    <div id="forget" class="modal fade" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6 b-r">
                            <h3 class="m-t-none m-b"> 重置为正方密码</h3>
                            <div class="hr-line-dashed"></div>
                            <form role="form" method="post" action="/index.php/public/forgetpwd">
                                <div class="form-group">
                                    <label>正方学号：</label>
                                    <input type="text" name="fnumb">
                                </div>
                                <div class="form-group">
                                    <label>正方密码：</label>
                                    <input type="password" name="fpwd">
                                </div>
                                <div>
                                    <button class="btn btn-sm btn-primary pull-right m-t-n-xs" type="submit"><strong>确定</strong>
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="col-sm-6">
                            <h4>请注意</h4>
                            <p>JMoocTest需要您提供正方学号及密码，用来<b>替换当前系统的密码</b>。</p>
                            <p>重置成功后，即可使用正方密码登录本系统。</p>
                            <h1 class="text-center">
                                <span class="glyphicon glyphicon-exclamation-sign" style="color:#F33"></span>
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="/Public/Admin/js/jquery.min.js?v=2.1.4"></script>
    <script src="/Public/Admin/js/bootstrap.min.js?v=3.3.6"></script>
    <script src="/Public/Admin/plugins/layui/layui.js"></script>
    <script src="/Public/Admin/plugins/dot/js/dot.min.js"></script>
    <script type="text/javascript">
        // 加载点线动画
        Dot("dot", {
            cW: window.screen.width,
            cH: window.screen.height
        });

        layui.use(['form', 'layer'], function () {
            var form = layui.form
                , layer = layui.layer
                , $ = layui.jquery;

            //登录按钮事件
            form.on('submit(login)', function (data) {
                $.post('/index.php/Public/login', data.field, function (res) {
                    if (res.status == 1) {
                        window.location = '/index.php/index/index';
                    } else {
                        layer.msg(res.info, { icon: 5, time: 800 });
                        $('.login .captcha-img img').trigger('click');
                        $("input[name='code']").val('');
                    }
                });
                return false;
            });

            // 点击图片刷新验证码
            $('.login .captcha-img img').click(function () {
                this.src = '/index.php/public/verifyImg/' + Math.random();
            });

            form.verify({
              num:[
                /^[\d]{9}$/
                ,'学号必须9位数字'
              ]
               ,xuehao: function(value, item){ //value：表单的值、item：表单的DOM对象
                  if(value < 130000000){
                    return '学号错误';
                  }
                }
              ,pass: [
                /^[\S]{6,16}$/
                ,'密码必须6到16位'
              ] 
            });

            //关于注册的信息
            $('#about').click(function(){
                layer.alert('本系统无需注册，首次登录只需输入学校的正方系统账号密码即可。');
            });

        });
    </script>

</body>

</html>