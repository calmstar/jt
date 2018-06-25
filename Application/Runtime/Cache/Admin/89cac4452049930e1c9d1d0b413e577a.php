<?php if (!defined('THINK_PATH')) exit();?> <!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title></title>
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
                        <h3>权限分配 ( <?php echo ($role_name); ?> ) </h3>
                    </div>      
                    <div class="ibox-content table-responsive">
                    <form method="post" action="/manager.php/Role/distribute/id/<?php echo ($id); ?>">
                        <table class="table table-striped table-hover table-responsive">
                                <?php if(is_array($auth_infoA)): foreach($auth_infoA as $key=>$v): ?><tr>
                                    <td style="border-right:1px solid gray; width:100px">
                                        <input type="checkbox" name="authid[]" value="<?php echo ($v["id"]); ?>" id="allItem"  <?php if(in_array($v[id],$have_authids)): ?>checked='checked'<?php endif; ?> >
                                        <?php echo ($v["name"]); ?>
                                    </td>

                                    <?php if(is_array($auth_infoB)): foreach($auth_infoB as $key=>$vv): if($v["id"] == $vv["pid"] ): ?><td style="float:left;width:150px;"> 
                                        <input name="authid[]" type="checkbox" value="<?php echo ($vv["id"]); ?>" id="singleItem" <?php if(in_array($vv[id],$have_authids)): ?>checked='checked'<?php endif; ?> >
                                        <?php echo ($vv["name"]); ?>        
                                    </td><?php endif; endforeach; endif; ?>

                                </tr><?php endforeach; endif; ?>
                        </table>
                        <div class="form-group">
                            <div class="col-sm-3 col-sm-offset-5">
                                <button class="btn btn-primary" type="submit">提交</button>
                            </div>
                        </div>
                        <div class="col-sm-5 col-sm-offset-3">
                            （注意：勾选了右边小模块，其所对应的左边大模块也应该勾选）
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="/Public/Admin/js/jquery.min.js"></script>
    <script src="/Public/Admin/js/bootstrap.min.js"></script>
    <script src="/Public/Admin/js/content.js"></script>
    <script type="text/javascript">
        $(function(){
            //点击大模块，里面的小模块全选
            $('body').on('click','#allItem',function(){
                if(this.checked){
                    $(this).parents('tr').find('#singleItem').prop("checked",true);
                }else{
                    $(this).parents('tr').find('#singleItem').prop("checked",false);
                }
            });

            //点击小模块，大模块必须选择
            $('body').on('click','#singleItem',function(){
                var allItem = $(this).parents('tr').find('#allItem');
                if(allItem != 'checked'){
                    allItem.prop("checked",true);
                }
            });

        });
    </script>
  
</body>
</html>