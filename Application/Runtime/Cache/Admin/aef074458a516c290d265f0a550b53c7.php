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
                        <h3>权限列表</h3>
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
                                    <th>权限名称</th>
                                    <th>控制器</th>
                                    <th>操作方法</th>
                                    <th>是否展示</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(is_array($info)): foreach($info as $key=>$v): ?><tr>
                                    <td><input type="checkbox" value="<?php echo ($v["id"]); ?>"><?php echo ($i++); ?></td>
                                    <td><?php echo (str_repeat('&emsp;',$v["auth_level"]*2)); ?>
                                    <?php echo ($v["name"]); ?></td>
                                    <td><?php echo ($v["auth_c"]); ?></td>
                                    <td><?php echo ($v["auth_a"]); ?></td>
                                    <td> <?php if($v["display"] == 1): ?>是 <?php else: ?> 否<?php endif; ?> </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-default" title="编辑" id="edit" value="<?php echo ($v["id"]); ?>">
                                                <i class="glyphicon glyphicon-edit"></i>
                                            </button>
                                            <button class="btn btn-default" title="删除" id="deleSingle" value="<?php echo ($v["id"]); ?>">
                                                <i class="glyphicon glyphicon-trash" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr><?php endforeach; endif; ?>
                            </tbody>
                        </table>
                        <div class="text-center">
                            <?php echo ($page_show); ?>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 全局js -->
    <script src="/Public/Admin/js/jquery.min.js"></script>
    <script src="/Public/Admin/js/bootstrap.min.js"></script>
    <!-- 自定义js -->
    <script src="/Public/Admin/js/content.js"></script>
    <script src="/Public/Admin/js/plugins/layer/layer.js"></script>
    <script type="text/javascript">
        $(function(){
            //添加事件
            $('#add').on('click',function(){
                location.href="/manager.php/Authority/add";
            });

            //删除事件
            $('body').on('click','#deleSingle',function(){
                var id = $(this).attr("value");
                layer.confirm('确认删除？', function(index){
                  location.href="/manager.php/Authority/dele/ids/" + id;
                  layer.close(index);
                })  
                
            });

            //修改事件
            $('body').on('click','#edit',function(){
                var id = $(this).attr('value');
                location.href='/manager.php/Authority/edit/id/'+id;
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
                var id = ''; //
                for(var i = 0; i < idObj.length; i++){
                    id += idObj[i].value + ',';
                }
                id = id.substring(0,id.length-1);

                if(id == ''){
                    layer.msg('没有选中数据');
                }else{
                    layer.confirm('确认批量删除？', {btn: ['确定', '取消']}, 
                        function(){   
                            //点击确定后的回调事件          
                            //ajax异步传值
                            $.post("/manager.php/Authority/dele",{ids:id},
                                function(data){
                                    if(data){
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