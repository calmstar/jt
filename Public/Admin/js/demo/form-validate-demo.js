//以下为修改jQuery Validation插件兼容Bootstrap的方法，没有直接写在插件中是为了便于插件升级
        $.validator.setDefaults({
            highlight: function (element) {
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
            },
            success: function (element) {
                element.closest('.form-group').removeClass('has-error').addClass('has-success');
            },
            errorElement: "span",
            errorPlacement: function (error, element) {
                if (element.is(":radio") || element.is(":checkbox")) {
                    error.appendTo(element.parent().parent().parent());
                } else {
                    error.appendTo(element.parent());
                }
            },
            errorClass: "help-block m-b-none",
            validClass: "help-block m-b-none"

        });


        var icon = "<i class='fa fa-times-circle'></i> ";
        //额外加的方法：检测是否为汉字  
        jQuery.validator.addMethod("isZh", function(value, element) {  
            var regName = /[^\u4e00-\u9fa5]/g;  
            return this.optional(element) || !regName.test( value );    
        }, icon + "只能输入中文");
        // 注正则表达式开头的^为相反，后面判断！也为相反了

        jQuery.validator.addMethod("strCheck", function(value, element) {  
            var regName = /^[a-zA-Z][a-zA-Z0-9_]*$/;  
            return this.optional(element) || regName.test( value );    
        }, icon + "只能以英文开头，其余只能含有数字或下划线");

        jQuery.validator.addMethod("controllerCheck", function(value, element) {  
            var regName = /^[A-Za-z]+$/;  
            return this.optional(element) || regName.test( value );    
        }, icon + "权限控制器必须为英文");

        jQuery.validator.addMethod("actionCheck", function(value, element) {  
            var regName = /^[a-zA-Z][A-Za-z_]*$/;  
            return this.optional(element) || regName.test( value );    
        }, icon + "权限操作方法必须以英文开头，其余只能为英文或下划线");

        // 手机号码验证
        jQuery.validator.addMethod("isMobile", function(value, element) {
        var length = value.length;
        var mobile = /^(13[0-9]|17[0-9]|14[5|7]|15[0|1|2|3|5|6|7|8|9]|18[0|1|2|3|5|6|7|8|9])\d{8}$/;
        return this.optional(element) || (length == 11 && mobile.test(value));
        }, icon +"请正确填写您的手机号码");

        //复选框必须选中两个
        // jQuery.validator.addMethod("atCheck", function(value, element) {  
        //     return this.optional(element) || regName.test( value );    
        // }, icon + "复选框必须选中两个");



        //以下为官方示例
        $().ready(function () {
            // validate signup form on keyup and submit
            $("#personalInfo").validate({
                rules:{
                    mail:{
                        required:true,
                        email:true,
                   },
                    username:{
                        required:true,
                        rangelength:[1,5],

                   },
                    phone:{
                        required:true,
                        number:true,
                        maxlength:11,
                        minlength:11,
                   },
                }
                
            });

            $("#changePWD").validate({
                rules:{
                    oldPass:{
                        required:true,
                        rangelength:[6,16],
                       // remote:"path/check.php",
                    },
                    password:{
                        required:true,
                        rangelength:[6,16],
                    },
                    checkPass:{
                        required:true,
                        equalTo:"#password",
                    },
                }
            });

            $("#login").validate({
                rules:{
                    mail:{
                        required:true,
                        email:true,
                    },
                    password:{
                        required:true,
                        rangelength:[6,16],
                    },
                    code:{
                        required:true,
                        maxlength:4,
                        minlength:4,
                    }
                    
                }
            });

            $('#authority').validate({
                rules:{
                    authName:{required:true,isZh:true,maxlength:10,},
                    authController:{controllerCheck:true,},
                    authAction:{actionCheck:true,},
                },
            });

            $('#user').validate({
                rules:{
                    mail:{
                        required:true,
                        email:true
                    },
                    password:{
                        required:true,
                        rangelength:[6,16],
                    },
                    checkPass:{
                        required:true,
                        equalTo:"#password",
                    },
                    // course:{
                    //     required:true,
                    //     minlength:1,
                    // },
                    username:{
                        required:true,
                        maxlength:5,
                    },
                    phone:{
                        digits:true,
                        isMobile:true,
                    },
                },
            });

            $('#stu').validate({
                rules:{
                    stuNumber:{
                        required:true,
                        digits:true,
                        maxlength:9,
                        minlength:9,
                        min:130000000,
                    },
                    password:{
                        required:true,
                        rangelength:[6,16],
                    },
                    checkPass:{
                        required:true,
                        equalTo:"#password",
                    },
                    username:{
                        required:true,
                        maxlength:5,
                    },
                    xueyuan:{
                        required:true,
                    },
                    stuClass:{
                        required:true,
                        minlength:4,
                    },
                    zhuanye:{
                        minlength:2,
                    },
                    phone:{
                        digits:true,
                        isMobile:true,
                    },
                    mail:{
                        email:true,
                    },
                },

            });

            $('#sinAdd').validate({
                rules:{
                    descr:{
                        required:true,
                    },
                    op1:{
                        required:true,
                    },
                    op2:{
                        required:true,
                    },
                    op3:{
                        required:true,
                    },
                    op4:{
                        required:true,
                    },
                }
            });

            $('#douAdd').validate({
                rules:{
                    descr:{
                        required:true,
                    },
                    op1:{
                        required:true,
                    },
                    op2:{
                        required:true,
                    },
                    op3:{
                        required:true,
                    },
                    op4:{
                        required:true,
                    },
                    right_answ:{
                        required:true,
                    },
                   
                }
            });

            $('#judAdd').validate({
                rules:{
                    descr:{
                        required:true,
                    },
                    right_answ:{
                        required:true,
                    },
                   
                }
            });

            $('#subAdd').validate({
                rules:{
                    descr:{
                        required:true,
                    },
                    right_answ:{
                        required:true,
                    },
                }
            });

            //Paper-edit中开启三个表单的校验（add已写在其网页里）
            $('#basic').validate();
            $('#limit').validate();
            $('#ques').validate();


            // ------------前台------------
            $("#fgLogin").validate({
                rules:{
                    stuNumber:{
                        required:true,
                        digits:true,
                        maxlength:9,
                        minlength:9,
                        min:130000000,
                    },
                    password:{
                        required:true,
                    },
                    code:{
                        required:true,
                    }
                    
                }
            });

            $("#changePass").validate({
                rules:{
                    oldPass:{
                        required:true,
                    },
                    password:{
                        required:true,
                        rangelength:[6,16],
                    },
                    checkPass:{
                        required:true,
                        equalTo:"#password",
                    },
                }
            });

            $("#changeExtra").validate({
                rules:{
                    phone:{
                        digits:true,
                        isMobile:true,
                    },
                    mail:{
                        email:true,
                    },
                }
            });

        });
