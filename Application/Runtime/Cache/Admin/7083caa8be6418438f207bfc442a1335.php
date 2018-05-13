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
                        <h3>角色列表</h3>
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
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(is_array($data)): foreach($data as $key=>$v): ?><tr>

                                    <td id="box">
                                    <input type="checkbox" value="<?php echo ($v["id"]); ?>"   <?php if($v[id] == 1): ?>disabled<?php endif; ?> >
                                    <span><?php echo ($i++); ?></span>
                                    </td>
                                    <td id="tname"><?php echo ($v["name"]); ?></td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-default" title="分配权限" id="distribute" value="<?php echo ($v["id"]); ?>">
                                                <i class="glyphicon glyphicon-list-alt"></i>
                                            </button>
                                            <?php if($v[id] != 1): ?><button class="btn btn-default   " title="编辑" id="edit" value="<?php echo ($v["id"]); ?>">
                                                <i class="glyphicon glyphicon-edit"></i>
                                            </button>
                                            <button class="btn btn-default   " title="删除" id="deleSingle" value="<?php echo ($v["id"]); ?>">
                                                <i class="glyphicon glyphicon-trash" aria-hidden="true"></i>
                                            </button><?php endif; ?>
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
            //分配权限
            $('body').on('click','#distribute',function(){
                var id = $(this).attr('value');
                location.href = '/manager.php/Role/distribute/id/'+id;
            });

            //添加事件
            $('#add').on('click',function(){
                var name; 
                layer.prompt(
                    {
                        title:'添加角色名称',
                        maxlength: 10,
                    },
                    function(val, index){ 
                        name = val;   
                        layer.close(index);  
                        
                        $.ajax({ 
                            url: "/manager.php/Role/add",
                            data:{name:name},
                            type:"POST",
                            datatype:'text',
                            success:function(data){  
                                if(data['status'] == 1){  
                                    layer.confirm('添加成功',{btn:['确定']},
                                        function(index){
                                            //克隆含有文本元素的第三个
                                            var clone = $('tr:parent').eq(2).clone();
                                            clone.find("td:first").html("<input type='checkbox' value='data[id]'>"+"<span>"+data['num']+"</span>").next().text(name);

                                            clone.find('input').attr('value',data['id']);
                                            clone.find('button').attr('value',data['id']);

                                            clone.appendTo('tbody');
                                            layer.close(index);
                                        })
                                }else{
                                    layer.msg("添加失败");
                                }
                                 
                            },
                            error:function(){
                                layer.msg("不知名异常！"); 
                            }
                        });
                    }
                );  

            });

            //编辑事件
            $('body').on('click','#edit',function(){
                 var nameGet = $(this).parents('tr').find("#tname");
                 var id = this.value;
                 var name = nameGet.text(); 

                layer.prompt(
                    {title:'编辑角色名称',maxlength:10,value:name},
                    function(val,index){
                        name = val;
                        layer.close(index);
                        $.post("/manager.php/Role/edit",{name:name,id:id},
                            function(data){
                                if(data['status'] == 1){
                                     layer.msg('编辑成功');
                                     nameGet.html(name);
                                }else{
                                    layer.msg('编辑失败');
                                }
                        });
                    }
                );
            });

            //删除单个记录
            $('body').on('click','#deleSingle',function(){
                var tr = $(this).parents('tr'); //必须先获取父节点
                var value = this.value;
                layer.confirm('确认删除?',{btn:['确定','取消']}, 
                    function(){
                        $.post("/manager.php/Role/dele",{ids:value},function(data){
                            if(data['status'] == 1){
                                tr.empty();
                                var xuhao = $('tr:parent').children('#box').children('span');
                                xuhao.each(function(i){
                                     $(this).text(i+1);  
                                });
                                layer.msg('删除成功');
                            }else{
                                layer.msg('删除失败');
                            }
                        });
                    }
                )
            });

            //全选和全不选
            $('#selectAll').on('click',function(){       
                if(this.checked){   
                    $(":checkbox:enabled").prop("checked", true);  
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
                            $.post("/manager.php/Role/dele",{ids:id},
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