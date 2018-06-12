<?php
namespace Admin\Model;
use Think\Model;

class StuModel extends Model{
	protected $_map = array(
		'sid' => 'id',
		'stuNumber' => 'xuehao',
		'password' => 'pwd',
		'username' => 'name',
		'xueyuan' => 'college',
		'stuClass' => 'stu_class',
		'zhuanye' => 'major',
		'phone' => 'telphone',
		'mail' => 'email',
	);

	protected $patchValidate = false; 
	protected $_validate = array(
		//共用一个自动验证，所以考虑 修改和添加
		array('xuehao','require','学号必须填写'),
		array('xuehao','number','学号必须为数字'),
		array('xuehao','9','学号长度不正确',0,'length'),
		//添加时验证，？？unique这么智能？
		array('xuehao','','学号已存在',0,'unique',3),

		array('pwd','6,16','密码必须在6-16个字符内',0,'length'),
		//也可用来验证其他的表单字段
		array('checkPass','require','确认密码不能为空'), 
		array('checkPass','pwd','两次密码不一致',0,'confirm'),

		array('name','require','名字必须填写'),
		array('name','1,5','名字必须在5个字符内',0,'length'),
		array('xueyuan','require','学院必须填写'),
		
		//必须是字符映射后的字符，否则易出错
		array('stu_class','require','班级必须填写'),
		array('stu_class','check_class','班级格式不正确',1,'callback'),

		//值不为空时验证
		array('telphone','number','电话号码必须是纯数字',2),
		array('telphone','11','电话号码必须是11位数字',2,'length'),
		array('email','email','用户名邮箱格式不正确',2),
	);

	function check_class($stuClass){

        $arr = array("数学",'物理','化学','文学','外语','生科','政法','地理','经管','电子','计算机','土木','美术','体育','音乐','教科');  

        $xueyuan = mb_substr($stuClass,0,-5, 'utf-8');
        if(!in_array($xueyuan,$arr)){
            return false;
        } 

        $banji = mb_substr($stuClass,-5,5,'utf8');
        if(!preg_match("/\d{4}班/",$banji)){
            return false;
        }

        return true;     
    }


	function add_data($data){
		$data['pwd'] = password_hash($data['pwd'],PASSWORD_BCRYPT);
		$data['rgdate'] = time();
		
		return $this->add($data);
	}


//不同学院用户分布区分
	function check_coll($data){
		foreach ($data as $k => $v) {
			switch ($v['college']) {
				case '计算机学院':
					$info['ji'] = $v['sum'];
					break;
				case '数学学院':
					$info['shu'] = $v['sum'];
					break;
				case '物理与光信息科技学院':
					$info['wu'] = $v['sum'];
					break;
				case '化学与环境学院':
					$info['hua'] = $v['sum'];
					break;
				case '文学院':
					$info['wen'] = $v['sum'];
					break;
				case '外国语学院':
					$info['wai'] = $v['sum'];
					break;
				case '生命科学学院':
					$info['sheng'] = $v['sum'];
					break;
				case '政法学院':
					$info['zheng'] = $v['sum'];
					break;
				case '地理科学与旅游学院':
					$info['di'] = $v['sum'];
					break;
				case '经济与管理学院':
					$info['jin'] = $v['sum'];
					break;
				case '电子信息工程学院':
					$info['dian'] = $v['sum'];
					break;
				case '土木工程学院':
					$info['tu'] = $v['sum'];
					break;
				case '美术学院':
					$info['mei'] = $v['sum'];
					break;
				case '体育学院':
					$info['ti'] = $v['sum'];
					break;
				case '音乐学院':
					$info['yin'] = $v['sum'];
					break;
				case '教育科学学院':
					$info['jiao'] = $v['sum'];
					break;
				default:
					case '其他学院':
					$info['qi'] = $v['sum'];
					break;
			}
		}
		return $info;
	}

    function deal_file ($stu_file) {
        $tmp_file = $stu_file['tmp_name'];
        //将文件名拆分成一个数组，里面包含 名字和后缀名
        $file_types = explode (".",$stu_file['name'] );
        //取出后缀名
        $file_type = $file_types[count($file_types )-1];
        //判别是不是.xls文件，判别是不是excel文件
        if(strtolower($file_type) != "xls" && strtolower($file_type) != "xlsx"){
            return false;
        }
        //设置上传路径
        $savePath = WORKING_PATH.UPLOAD_ROOT_PATH.'stu/';
        //以时间来命名上传的文件
        $str = date ( 'Y-m-d H_i_s' );
        $file_name = $str . "." . $file_type;
        $all_path = $savePath . $file_name ;
        //是否上传成功
        if(!copy($tmp_file,$all_path)){
            return false;
        }
        return $all_path;
    }

    function deal_file_data ($data) {
        $arr = array("数学",'物理','化学','文学','外语','生科','政法','地理','经管','电子','计算机','土木','美术','体育','音乐','教科');
        foreach ($data as $k => $v) {
            // 检查是否有重复的学号
            $rep = $this->where("xuehao=$v[0]")->count();
            if($rep > 0){
                $info['status'] = 0;
                $info['msg'] = ($k+1).'行的学号已存在';
            }

            // 检查学院
            switch ($v['3']) {
                case '计算机学院':
                    break;
                case '数学学院':
                    break;
                case '物理与光信息科技学院':
                    break;
                case '化学与环境学院':
                    break;
                case '文学院':
                    break;
                case '外国语学院':
                    break;
                case '生命科学学院':
                    break;
                case '政法学院':
                    break;
                case '地理科学与旅游学院':
                    break;
                case '经济与管理学院':
                    break;
                case '电子信息工程学院':
                    break;
                case '土木工程学院':
                    break;
                case '美术学院':
                    break;
                case '体育学院':
                    break;
                case '音乐学院':
                    break;
                case '教育科学学院':
                    break;
                default:
                    $info['status'] = 0;
                    $info['msg'] = '学院错误';
            }

            // 检查班级
            $xueyuan = mb_substr($v['4'],0,-5, 'utf-8');
            if(!in_array($xueyuan,$arr)){
                $info['status'] = 0;
                $info['msg'] = '班级前缀错误';
            }

            $banji = mb_substr($v['4'],-5,5,'utf8');
            if(!preg_match("/\d{4}班/",$banji)){
                $info['status'] = 0;
                $info['msg'] = '班级错误';
            }

            if ($info['status'] == '0') {
                return $info;
            }

            // 封装进新的数组中，与数据字段一致
            $check_data[$k]['xuehao'] = $v['0'];
            $check_data[$k]['pwd'] = password_hash($v['1'],PASSWORD_BCRYPT);
            $check_data[$k]['name'] = $v['2'];
            $check_data[$k]['college'] = $v['3'];
            $check_data[$k]['stu_class'] = $v['4'];
            $check_data[$k]['major'] = $v['5'];
			$check_data[$k]['rgdate'] = time();
        }
        return $check_data;
    }


}