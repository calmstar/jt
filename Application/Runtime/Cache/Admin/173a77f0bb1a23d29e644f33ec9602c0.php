<?php if (!defined('THINK_PATH')) exit();?> <!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>列表</title>
    <meta name="keywords" content="">
    <meta name="description" content="">

    <link rel="shortcut icon" href="/Publicfavicon.ico">
    <link href="/Public/Admin/css/bootstrap.min.css" rel="stylesheet">
    <link href="/Public/Admin/css/animate.css" rel="stylesheet">
    <link href="/Public/Admin/css/style.css" rel="stylesheet">

</head>

<body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h3>教师列表</h3>
                    </div>      
                    <div class="ibox-content table-responsive">
                        <div class="row">
                           <div class="col-sm-4">
                               <div class="btn-toolbar">
                               <div class="btn-group">
                                   <button type="button" class="btn btn-outline btn-default" id="deleAll">
                                       <i class="glyphicon glyphicon-trash" aria-hidden="true"></i> 批量删除
                                   </button>
                                   <button type="button" class="btn btn-outline btn-default" id="add">
                                       <i class="glyphicon glyphicon-plus" aria-hidden="true" ></i> 添加
                                   </button>           
                               </div>
                               </div>
                           </div>           
                        </div>
                        <table class="table table-striped table-hover table-responsive">
                            <thead>
                                <tr>    
                                    <th><input type="checkbox" title="全选" id="selectAll"> #</th>
                                    <th>名字</th>
                                    <th>所教课程</th>
                                    <th>邮箱账号</th>
                                    <th>注册日期</th>
                                    <th>电话</th>
                                    <th>状态</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(is_array($data)): foreach($data as $key=>$v): ?><tr>

                                    <td><input type="checkbox" value="<?php echo ($v["id"]); ?>"> <?php echo ($i++); ?></td>
                                    <td><?php echo ($v["name"]); ?></td>
                                    <td><?php echo ((isset($v["course_names"]) && ($v["course_names"] !== ""))?($v["course_names"]):'无'); ?></td>
                                    <td><?php echo ($v["email"]); ?></td>
                                    <td><?php echo (date('Y-m-d H:i:s',$v["rgdate"])); ?></td>
                                    <td><?php echo ($v["telphone"]); ?></td>
                                    <td id="status">
                                        <?php if($v["status"] == 1): ?><i class="glyphicon glyphicon-ok"></i>
                                        <?php else: ?>
                                        <i class="glyphicon glyphicon-remove"></i><?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-default" title="编辑/查看" id="edit" value="<?php echo ($v["id"]); ?>">
                                                <i class="glyphicon glyphicon-edit"></i>
                                            </button>
                                            <button class="btn btn-default" title="启用/禁用" id="isAble" value="<?php echo ($v["id"]); ?>">
                                                <?php if($v["status"] == 1): ?><i class="glyphicon glyphicon-remove"></i>
                                                <?php else: ?>
                                                <i class="glyphicon glyphicon-ok"></i><?php endif; ?>
                                            </button>
                                            <button class="btn btn-default" title="重置密码" id="reset" value="<?php echo ($v["id"]); ?>">
                                                <i class="glyphicon glyphicon-retweet"></i>
                                            </button>
                                            <button class="btn btn-default" title="删除" id="deleSingle" value="<?php echo ($v["id"]); ?>">
                                                <i class="glyphicon glyphicon-trash" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr><?php endforeach; endif; ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="/Public/Admin/js/jquery.min.js"></script>
    <script src="/Public/Admin/js/bootstrap.min.js"></script>
    <script src="/Public/Admin/js/content.js"></script>
    <script src="/Public/Admin/js/plugins/layer/layer.js"></script>
    <script type="text/javascript">
        $(function(){
            //编辑事件
            $('body').on('click','#edit',function(){
                var id = $(this).attr('value');
                location.href='/manager.php/Teacher/edit/id/'+id;
            });

            //添加事件
            $('#add').on('click',function(){
                location.href='/manager.php/Teacher/add';
            });

            //启用、禁用
            $('body').on('click','#isAble',function(){
                var status = $(this).parents('tr').find('#status');
                var selfButton = $(this);
                var id = $(this).attr('value');
                $.post('/manager.php/Teacher/isable',{"id":id},function(data){
                    if(data==1){
                        status.html('<i class="glyphicon glyphicon-ok"></i>');
                        selfButton.html('<i class="glyphicon glyphicon-remove"></i>');
                        layer.msg('状态已更改为启用');
                    }else if(data==2){
                        status.html('<i class="glyphicon glyphicon-remove"></i>');
                        selfButton.html('<i class="glyphicon glyphicon-ok"></i>');
                        layer.msg('状态已更改为禁用');
                    }else{
                        layer.msg('状态更改失败');
                    }
                    
                });
            });

            //重置密码
            $('body').on('click','#reset',function(){
                var id = $(this).attr('value');
                layer.confirm('密码将重置为“ 123456 ”，确认重置？', {btn: ['确定', '取消']}, 
                    function(index){
                        $.post('/manager.php/Teacher/reset',{"id":id},function(data){
                            if(data['status'] == 1){
                                layer.msg('重置密码成功');
                            }else{
                                layer.msg('重置密码失败');
                            }
                        });
                    }
                );
            });
         

            //删除单个记录
            $('body').on('click','#deleSingle',function(){
                var id = $(this).attr('value');
                layer.confirm('确认删除？', {btn: ['确定', '取消']},
                    function(index){
                        location.href='/manager.php/Teacher/dele/ids/'+id;
                    }
                );
            });

            //全选和全不选
            $('#selectAll').on('click',function(){       
                if(this.checked){   
                    $(":checkbox").prop("checked", true);  
                }else{   
                    $(":checkbox").prop("checked", false);
                }  
            });

            //选中批量删除事件
            $('#deleAll').on('click',function(){
                //整理数据
                var idObj = $('input:checked');
                var id = '';
                for(var i = 0; i < idObj.length; i++){
                    id += idObj[i].value + ',';
                }
                id = id.substring(0,id.length-1);

                if(id == ''){
                    layer.msg('没有选中数据');
                }else{
                    layer.confirm('确认删除？', {btn: ['确定', '取消']}, 
                        function(){   
                            //点击确定后的回调事件          
                            //ajax异步传值
                            $.post("/manager.php/Teacher/dele",{ids:id},
                                function(data){
                                    if(data['status'] == 1){
                                        //由于layer.alert无法暂停下面的刷新
                                        layer.confirm('批量删除成功',{btn: ['确定']},
                                            function(){
                                                window.location.reload(); 
                                            })
                                    }else{
                                        layer.msg('删除失败');
                                    }     
                                }
                            );
                        },
                        function(){
                            //点击取消的回调事件
                        }
                    );  
                }
            });

        });
    </script>
  
</body>
</html>