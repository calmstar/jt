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
                        <h3>公告列表<small> （置顶功能一般用于：长期提醒学生使用本系统的注意事项~）</small></h3>
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
                                       <i class="glyphicon glyphicon-plus" aria-hidden="true" ></i> 发布公告
                                   </button>           
                               </div>
                               </div>
                           </div>           
                        </div>
                        <table class="table table-striped table-hover table-responsive">
                            <thead>
                                <tr>    
                                    <th><input type="checkbox" title="全选" id="selectAll"> #</th>
                                    <th>公告内容</th>
                                    <th>发布者</th>
                                    <th>发布日期</th>
                                    <th>是否置顶</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(is_array($data)): foreach($data as $key=>$v): ?><tr>

                                    <td>
                                        <input type="checkbox" value="<?php echo ($v["id"]); ?>"> <?php echo ($i++); ?>
                                    </td>
                                    <td><?php echo (mb_substr(strip_tags(htmlspecialchars_decode($v["content"])),0,30,'utf-8')); ?></td>
                                    <td><?php echo ($v["name"]); ?></td>
                                    <td><?php echo (date('Y-m-d H:i:s',$v["pubdate"])); ?></td>
                                    <td>
                                        <?php if($v['top'] == 1): ?>是<?php else: ?>否<?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-default" title="编辑/查看" id="edit" value="<?php echo ($v["id"]); ?>">
                                                <i class="glyphicon glyphicon-edit"></i>
                                            </button>
                                            <button class="btn btn-default" title="删除" id="deleSingle" value="<?php echo ($v["id"]); ?>">
                                                <i class="glyphicon glyphicon-trash" aria-hidden="true"></i>
                                            </button>
                                            <button class="btn btn-default" title="置顶/取消置顶" id="top" value="<?php echo ($v["id"]); ?>">
                                                <i class="glyphicon glyphicon-arrow-up" aria-hidden="true"></i>
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
                window.location.href='/manager.php/announce/add';
            });

            
            //编辑事件,由于是动态生成的所以要更改如下
            $('body').on('click','#edit',function(){
                var id = this.value;
                window.location.href='/manager.php/announce/edit/id/'+id;
            });

            $('body').on('click','#top',function(){
                var id = this.value;
                window.location.href='/manager.php/announce/top/id/'+id;
            });


            //删除单个记录
            $('body').on('click','#deleSingle',function(){
                //alert($('#deleSingle/this').attr('value'));  alert(this.value);
                var value = this.value;
                layer.confirm('确认删除?',{btn:['确定','取消']}, 
                    function(){
                        $.post("/manager.php/announce/dele",{ids:value},function(data){
                            if(data['status'] == 1){
                                window.location.reload();
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
                            $.post("/manager.php/announce/dele",{ids:id},
                                function(data){
                                    if(data['status'] == 1){
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
                    );  
                }
            });

        });
    </script>
  
</body>
</html>