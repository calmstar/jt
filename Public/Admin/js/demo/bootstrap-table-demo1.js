$(function(){

    $('#stu').bootstrapTable({
        showRefresh:true,
        search:true,
        showToggle:true,
        showColumns:true,
        striped:true,
        clickToSelect:true,
        toolbar:"#toolbar",
        cache: false,

        sidePagination: 'server',
        method: 'post',
        contentType: "application/x-www-form-urlencoded",
        pagination: true,
        pageList: [20, 50, 100],
        pageSize: 20,
        pageNumber: 1,
        sortName:'id',
        sortOrder:'desc',

        columns: [{
            checkbox:'true',
        },{
            field: 'id',
            title: 'id',
        },{
            field: 'xh',
            title: '#',
            sortable: true,
        },{
            field: 'name',
            title: '名字',
        }, {
            field: 'xuehao',
            title: '学号',
            sortable: true,
        },{
            field: 'stu_class',
            title: '班级'
        },{
            field: 'status',
            title: '状态',
            sortable: true,
            formatter: function(value,row,index){
                if(value == 1){
                    return '<i class="glyphicon glyphicon-remove">';
                }else{
                    return '<i class="glyphicon glyphicon-ok"></i>';
                }
            }
        },{
            field: 'major',
            title: '专业',
            visible:false,
        },{
            field: 'rgdate',
            title: '注册日期',
            visible:false,
        },{
            field: 'telphone',
            title: '电话'
        },{
            field: 'email',
            title: '邮箱'
        },{
            title: '操作',
            align: 'center',
            events: "operateEvents",
            formatter: function(){
                return [
                    '<button type="button" class="edit btn btn-default  btn-sm">编辑/查看</button>',
                    '<button type="button" class="isAble btn btn-default  btn-sm" >启用/禁用</button>',
                    '<button type="button" class="reset btn btn-default  btn-sm">重置密码</button>',
                    '<button type="button" class="deleSingle btn btn-default  btn-sm" >删除</button>',
                ].join('');
            }
        }],
    });
    $('#stu').bootstrapTable('hideColumn','id');

});
