$(function(){

    $('#sin_table').bootstrapTable({
        showRefresh:true,  //刷新按钮
        search:true,   //搜索框
        showToggle:true, //与卡片视图的切换
        showColumns:true, //是否显示 内容列下拉框选项
        striped:true,  //隔行变色效果
        // height:900,  //表格高度
        sortName:'id', //默认的排序字段，默认顺序，可改sortOrder:desc
        sortOrder:'desc',
        clickToSelect:true, //最左边的选框 radio或checkbox由列决定
        toolbar:"#toolbar", //调整工具栏的位置
        cache: false, //设置为 false 禁用 AJAX 数据缓存

        //服务端分页
        //客户端分页
        pagination: true, 
        pageSize: 20,    //每页的记录行数
        pageNumber:1,  //初始化加载第一页，默认第一页
        pageList: [20,50,100,500], //可供选择的每页的行数
        
        columns: [{
            //只是用来做选框的列
            checkbox:'true',
        },{
            field: 'id',
            title: 'id',
        },{
            field: 'xh',
            title: '#',
            sortable: 'true', //此列可被排序
        },{
            field: 'course_name',
            title: '所属课程'
        }, {
            field: 'descr',
            title: '题目描述',
            class: "col-xs-4"
        },{
            field: 'op1',
            title: '选项一'
        },{
            field: 'op2',
            title: '选项二'
        },{
            field: 'op3',
            title: '选项三'
        },{
            field: 'op4',
            title: '选项四'
        },{
            field: 'right_answ',
            title: '正确选项'
        },{
            field: 'is_show',
            title: '是否当做练习题',
            sortable: 'true',
            
        },{
            field: 'difficulty',
            title: '难度',
            sortable: 'true',
            
        }],
        
    });
    $('#sin_table').bootstrapTable('hideColumn','id');


    //-----------双选题---------------------------------------------

    $('#dou_table').bootstrapTable({
        showRefresh:true,  //刷新按钮
        search:true,   //搜索框
        showToggle:true, //与卡片视图的切换
        showColumns:true, //是否显示 内容列下拉框选项
        striped:true,  //隔行变色效果
        // height:900,  //表格高度
        sortName:'id', //默认的排序字段，默认顺序，可改sortOrder:desc
        sortOrder:'desc',
        clickToSelect:true, //最左边的选框 radio或checkbox由列决定
        toolbar:"#toolbar", //调整工具栏的位置
        cache: false, //设置为 false 禁用 AJAX 数据缓存

        pagination: true, 
        pageSize: 20,    //每页的记录行数
        pageNumber:1,  //初始化加载第一页，默认第一页
        pageList: [20, 50, 100,500], //可供选择的每页的行数
        
        columns: [{
            //只是用来做选框的列
            checkbox:'true',
        },{
            field: 'id',
            title: 'id',
        },{
            field: 'xh',
            title: '#',
            sortable: 'true', //此列可被排序
        },{
            field: 'course_name',
            title: '所属课程'
        }, {
            field: 'descr',
            title: '题目描述',
            class: "col-xs-4"
        },{
            field: 'op1',
            title: '选项一'
        },{
            field: 'op2',
            title: '选项二'
        },{
            field: 'op3',
            title: '选项三'
        },{
            field: 'op4',
            title: '选项四'
        },{
            field: 'right_answ',
            title: '正确选项'
        },{
            field: 'is_show',
            title: '是否当做练习题',
            sortable: 'true',
            
        },{
            field: 'difficulty',
            title: '难度',
            sortable: 'true',
            
        }],
    });
    $('#dou_table').bootstrapTable('hideColumn','id');



    // ------- 判断题 -----------
    $('#jud_table').bootstrapTable({
        showRefresh:true,  //刷新按钮
        search:true,   //搜索框
        showToggle:true, //与卡片视图的切换
        showColumns:true, //是否显示 内容列下拉框选项
        striped:true,  //隔行变色效果
        // height:900,  //表格高度
        sortName:'id', //默认的排序字段，默认顺序，可改sortOrder:desc
        sortOrder:'desc',
        clickToSelect:true, //最左边的选框 radio或checkbox由列决定
        toolbar:"#toolbar", //调整工具栏的位置
        cache: false, //设置为 false 禁用 AJAX 数据缓存

        pagination: true, 
        pageSize: 20,    //每页的记录行数
        pageNumber:1,  //初始化加载第一页，默认第一页
        pageList: [20, 50, 100,500], //可供选择的每页的行数
        
        columns: [{
            //只是用来做选框的列
            checkbox:'true',
        },{
            field: 'id',
            title: 'id',
        },{
            field: 'xh',
            title: '#',
            sortable: 'true', //此列可被排序
        },{
            field: 'course_name',
            title: '所属课程'
        }, {
            field: 'descr',
            title: '题目描述',
            class: "col-xs-4"
        },{
            field: 'right_answ',
            title: '答案'
        },{
            field: 'is_show',
            title: '是否当做练习题',
            sortable: 'true',
            
        },{
            field: 'difficulty',
            title: '难度',
            sortable: 'true',
            
        }],
    });
    $('#jud_table').bootstrapTable('hideColumn','id');


    // ------- 主观题 -----------
    $('#sub_table').bootstrapTable({
        showRefresh:true,  //刷新按钮
        search:true,   //搜索框
        showToggle:true, //与卡片视图的切换
        showColumns:true, //是否显示 内容列下拉框选项
        striped:true,  //隔行变色效果
        // height:900,  //表格高度
        sortName:'id', //默认的排序字段，默认顺序，可改sortOrder:desc
        sortOrder:'desc',
        clickToSelect:true, //最左边的选框 radio或checkbox由列决定
        toolbar:"#toolbar", //调整工具栏的位置
        cache: false, //设置为 false 禁用 AJAX 数据缓存

        pagination: true, 
        pageSize: 20,    //每页的记录行数
        pageNumber:1,  //初始化加载第一页，默认第一页
        pageList: [20, 50, 100,500], //可供选择的每页的行数
        
        columns: [{
            //只是用来做选框的列
            checkbox:'true',
        },{
            field: 'id',
            title: 'id',
        },{
            field: 'xh',
            title: '#',
            sortable: 'true', //此列可被排序
        },{
            field: 'course_name',
            title: '所属课程'
        }, {
            field: 'descr',
            title: '题目描述',
            class: "col-xs-4"
        },{
            field: 'right_answ',
            title: '参考答案',
            class: "col-xs-4"
        },{
            field: 'difficulty',
            title: '难度',
            sortable: 'true',
            
        }],
    });
    $('#sub_table').bootstrapTable('hideColumn','id');


     // ------- 试卷 -----------
    $('#paper_table').bootstrapTable({
        showRefresh:true,  //刷新按钮
        search:true,   //搜索框
        showToggle:true, //与卡片视图的切换
        showColumns:true, //是否显示 内容列下拉框选项
        striped:true,  //隔行变色效果
        // height:900,  //表格高度
        sortName:'id', //默认的排序字段，默认顺序，可改sortOrder:desc
        sortOrder:'desc',
        clickToSelect:true, //最左边的选框 radio或checkbox由列决定
        toolbar:"#toolbar", //调整工具栏的位置
        cache: false, //设置为 false 禁用 AJAX 数据缓存

        pagination: true, 
        pageSize: 20,    //每页的记录行数
        pageNumber:1,  //初始化加载第一页，默认第一页
        pageList: [20, 50, 100,500], //可供选择的每页的行数
        
        columns: [{
            //只是用来做选框的列
            checkbox:'true',
        },{
            field: 'id',
            title: 'id',
        },{
            field: 'xh',
            title: '#',
            sortable: 'true', //此列可被排序
        },{
            field: 'type',
            title: '出卷规则',
            sortable: 'true',
        },{
            field: 'course_name',
            title: '所属课程'
        },{
            field: 'name',
            title: '试卷名称',
            class: "col-xs-3",
        },{
            field: 'maker',
            title: '创建者',
        },{
            field: 'create_date',
            title: '创建时间',
            sortable: 'true',
            class: "col-xs-2"
        },{
            field: 'limittime',
            title: '限制时间(分钟)',
            sortable: 'true',
        },{
            field: 'test_status',
            title: '考试状态',
            sortable: 'true',
        },{
            field: 'review_status',
            title: '审核状态',
            sortable: 'true',
        },{
            field: 'answ_status',
            title: '开放答案',
            sortable: 'true',
        }],
    });
    $('#paper_table').bootstrapTable('hideColumn','id');

    // ----批改主观题---
    $('#mark_subj').bootstrapTable({
        showRefresh:true,  //刷新按钮
        search:true,   //搜索框
        showToggle:true, //与卡片视图的切换
        showColumns:true, //是否显示 内容列下拉框选项
        striped:true,  //隔行变色效果

        sortName:'xh', //默认的排序字段，默认顺序，可改sortOrder:desc
        sortOrder:'desc',
        clickToSelect:true, //最左边的选框 radio或checkbox由列决定
        toolbar:"#toolbar", //调整工具栏的位置
        cache: false, //设置为 false 禁用 AJAX 数据缓存

        pagination: true, 
        pageSize: 20,    //每页的记录行数
        pageNumber:1,  //初始化加载第一页，默认第一页
        pageList: [20, 50, 100,500], //可供选择的每页的行数

        columns: [{
            //只是用来做选框的列
            radio:'true',
        },{
            field: 'paper_id',
            title: 'paper_id',
        },{
            field: 'xh',
            title: '#',
            sortable: 'true', //此列可被排序
        },{
            field: 'paper_name',
            title: '试卷名称',
            class: "col-xs-4",
        },{
            field: 'time',
            title: '考试时间段',
            //class: "col-xs-2",
        },{
            field: 'join_num',
            title: '参加考试',
            sortable: 'true',
        },{
            field: 'ok',
            title: '正常提交',
            sortable: 'true',
        },{
            field: 'overtime',
            title: '超时提交',
            sortable: 'true',
        },{
            field: 'no',
            title: '未提交',
            sortable: 'true',
        },{
            field: 'mark_num',
            title: '未批改',
            sortable: 'true',
        }],
    });
    $('#mark_subj').bootstrapTable('hideColumn','paper_id');
    $('#mark_subj').bootstrapTable('hideColumn','time');

    //---监控考生
    $('#tester_list').bootstrapTable({
        showRefresh:true,  //刷新按钮
        search:true,   //搜索框
        showToggle:true, //与卡片视图的切换
        showColumns:true, //是否显示 内容列下拉框选项
        striped:true,  //隔行变色效果

        sortName:'xh', //默认的排序字段，默认顺序，可改sortOrder:desc
        sortOrder:'desc',
        clickToSelect:true, //最左边的选框 radio或checkbox由列决定
        toolbar:"#toolbar", //调整工具栏的位置
        cache: false, //设置为 false 禁用 AJAX 数据缓存

        pagination: true,
        pageSize: 20,    //每页的记录行数
        pageNumber:1,  //初始化加载第一页，默认第一页
        pageList: [20, 50, 100,500], //可供选择的每页的行数

        columns: [{
            //只是用来做选框的列
            radio:'true',
        },{
            field: 'tester_id',
            title: 'tester_id',
        },{
            field: 'xh',
            title: '#',
            sortable: 'true',
        },{
            field: 'xuehao',
            title: '学号',
            sortable: 'true',
        },{
            field: 'tester_class',
            title: '考生班级',
        },{
            field: 'tester_name',
            title: '考生名字',
        },{
            field: 'stime',
            title: '进入试卷时间',
            sortable: 'true',
        },{
            field: 'etime',
            title: '提交试卷时间',
            sortable: 'true',
        },{
            field: 'sub_status',
            title: '提交状态',
            sortable: 'true',
        },{
            field: 'mark_status',
            title: '批改状态',
            sortable: 'true',
        },{
            field: 'cache_status',
            title: '答案缓存状态',
            sortable: 'true',
        }],
    });
    $('#tester_list').bootstrapTable('hideColumn','tester_id');
    $('#tester_list').bootstrapTable('hideColumn','xuehao');
    $('#tester_list').bootstrapTable('hideColumn','tester_class');


    // ----分析试卷---
    $('#analyze').bootstrapTable({
        showRefresh:true,  //刷新按钮
        search:true,   //搜索框
        showToggle:true, //与卡片视图的切换
        showColumns:true, //是否显示 内容列下拉框选项
        striped:true,  //隔行变色效果

        sortName:'xh', //默认的排序字段，默认顺序，可改sortOrder:desc
        sortOrder:'desc',
        clickToSelect:true, //最左边的选框 radio或checkbox由列决定
        toolbar:"#toolbar", //调整工具栏的位置
        cache: false, //设置为 false 禁用 AJAX 数据缓存

        pagination: true, 
        pageSize: 20,    //每页的记录行数
        pageNumber:1,  //初始化加载第一页，默认第一页
        pageList: [20, 50, 100,500], //可供选择的每页的行数

        columns: [{
            //只是用来做选框的列
            radio:'true',
        },{
            field: 'paper_id',
            title: 'paper_id',
        },{
            field: 'xh',
            title: '#',
            sortable: 'true', 
        },{
            field: 'paper_name',
            title: '试卷名称',
            class: "col-xs-3",
        },{
            field: 'whole_score',
            title: '试卷总分',
            sortable: 'true',
        },{
            field: 'bad',
            title: '不及格率',
            sortable: 'true',
        },{
            field: 'good',
            title: '良好率',
            sortable: 'true',
        },{
            field: 'exce',
            title: '优秀率',
            sortable: 'true',
        },{
            field: 'high',
            title: '最高分',
            sortable: 'true',
        },{
            field: 'low',
            title: '最低分',
            sortable: 'true',
        },{
            field: 'aver',
            title: '平均分',
            sortable: 'true',
        },{
            field: 'tested_num',
            title: '交卷人数',
        }],
    });
    $('#analyze').bootstrapTable('hideColumn','paper_id');

       // ----考生列表---
    $('#stu_list').bootstrapTable({
        showRefresh:true,  //刷新按钮
        search:true,   //搜索框
        showToggle:true, //与卡片视图的切换
        showColumns:true, //是否显示 内容列下拉框选项
        striped:true,  //隔行变色效果

        sortName:'xh', //默认的排序字段，默认顺序，可改sortOrder:desc
        sortOrder:'desc',
        clickToSelect:true, //最左边的选框 radio或checkbox由列决定
        toolbar:"#toolbar", //调整工具栏的位置
        cache: false, //设置为 false 禁用 AJAX 数据缓存

        pagination: true, 
        pageSize: 20,    //每页的记录行数
        pageNumber:1,  //初始化加载第一页，默认第一页
        pageList: [20, 50, 100,500], //可供选择的每页的行数

        columns: [{
            //只是用来做选框的列
            radio:'true',
        },{
            field: 'stu_id',
            title: 'stu_id',
        },{
            field: 'xh',
            title: '#',
            sortable: 'true', 
        },{
            field: 'xuehao',
            title: '学号',
            sortable: 'true',
        },{
            field: 'stu_name',
            title: '考生名字',
        },{
            field: 'stu_class',
            title: '考生班级',
        },{
            field: 'single_score',
            title: '单选题得分',
            sortable: 'true',
        },{
            field: 'double_score',
            title: '双选题得分',
            sortable: 'true',
        },{
            field: 'judge_score',
            title: '判断题得分',
            sortable: 'true',
        },{
            field: 'subj_score',
            title: '主观题得分',
            sortable: 'true',
        },{
            field: 'all_score',
            title: '所得总分',
            sortable: 'true',
        }],
    });
    $('#stu_list').bootstrapTable('hideColumn','stu_id');




    //------ 前台-我的试卷 ----------
    $('#myPaper').bootstrapTable({
        showRefresh:true,  //刷新按钮
        search:true,   //搜索框
        showToggle:true, //与卡片视图的切换
        showColumns:true, //是否显示 内容列下拉框选项
        striped:true,  //隔行变色效果
        // height:900,  //表格高度
        sortName:'id', //默认的排序字段，默认顺序，可改sortOrder:desc
        sortOrder:'desc',
        clickToSelect:true, //最左边的选框 radio或checkbox由列决定
        toolbar:"#toolbar", //调整工具栏的位置
        cache: false, //设置为 false 禁用 AJAX 数据缓存

        pagination: true, 
        pageSize: 20,    //每页的记录行数
        pageNumber:1,  //初始化加载第一页，默认第一页
        pageList: [20, 50, 100,500], //可供选择的每页的行数

        columns: [{
            radio:'true',
        },{
            field: 'paper_id',
            title: 'paper_id',
        },{
            field: 'xh',
            title: '#',
            sortable: 'true', //此列可被排序
        },{
            field: 'paper_name',
            title: '试卷名称',
            class: "col-xs-3",
        },{
            field: 'whole_score',
            title: '试卷总分',
            sortable: 'true',
        },{
            field: 'single_score',
            title: '单选题得分',
            sortable: 'true', 
        },{
            field: 'double_score',
            title: '双选题得分',
            sortable: 'true', 
        },{
            field: 'judge_score',
            title: '判断题得分',
            sortable: 'true', 
        },{
            field: 'subj_score',
            title: '主观题得分',
            sortable: 'true', 
        },{
            field: 'all_score',
            title: '共计得分',
            sortable: 'true',
        },{
            field: 'stime',
            title: '进入考试时间',
            class: "col-xs-2",
            sortable: 'true',
        }],
    });
    $('#myPaper').bootstrapTable('hideColumn','paper_id');
    $('#myPaper').bootstrapTable('hideColumn','stime');

});
    

    // showPaginationSwitch:true, //   是否显示数据条数选择框，分页信息等
    // 表参数：showHeader:false, //是否显示列头

    //列参数与上面搭配使用 switchable，默认为true，false为不可被取消
    //visible="false" 一开始不在列表中显示

   // detailView:true, // 设置为 true可以显示详细页面模式。
   // searchOnEnterKey:true, 
            //设置为 true时，按回车触发搜索方法，否则自动触发搜索方法
   // queryParams:"queryParams", 不懂
   //可发送给服务端的参数：limit->pageSize,offset->pageNumber,
        //search->searchText,sort->sortName(字段),order->sortOrder('asc'或'desc')  