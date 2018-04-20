$(function(){

    //添加事件
    $('#add').on('click',function(){
        var name; 
        layer.prompt(
            {
                title:'请输入添加信息',
                maxlength: 10,
            },
            function(val, index){ 
                name = val;   
                layer.close(index);  
                
                $.ajax({ 
                    url: "__CONTROLLER__/add",
                    data:{name:name},
                    type:"POST",
                    datatype:'text',
                    success:function(data){  
                        if(data){  
                            layer.confirm('添加成功',{btn:['确定']},
                                function(index){
                                    //克隆含有文本元素的第二个
                                    var clone = $('tr:parent').eq(1).clone();
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
            {title:'请输入编辑信息',maxlength:10,value:name},
            function(val,index){
                name = val;
                layer.close(index);
                $.post("__CONTROLLER__/edit",{name:name,id:id},
                    function(data){
                        if(data){
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
                $.post("__CONTROLLER__/dele",{ids:value},function(data){
                    if(data){
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
                    $.post("__CONTROLLER__/dele",{ids:id},
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