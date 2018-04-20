-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2018-04-11 14:19:32
-- 服务器版本： 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `jmooctest2`
--

-- --------------------------------------------------------

--
-- 表的结构 `jt_announce`
--

CREATE TABLE IF NOT EXISTS `jt_announce` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content` varchar(1000) NOT NULL,
  `pubdate` char(10) NOT NULL,
  `pub_id` int(10) unsigned NOT NULL COMMENT '发布者id',
  `top` tinyint(3) unsigned NOT NULL COMMENT '1为置顶，0否',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- 转存表中的数据 `jt_announce`
--

INSERT INTO `jt_announce` (`id`, `content`, `pubdate`, `pub_id`, `top`) VALUES
(15, '主观题的批改时间依各科老师不同，请考生注意查看公告。', '1504094429', 1, 1),
(16, '&lt;p&gt;考生须知：&lt;/p&gt;&lt;ol class=&quot; list-paddingleft-2&quot; style=&quot;list-style-type: decimal;&quot;&gt;&lt;li&gt;&lt;p&gt;登陆考试系统后，请仔细阅读考试规则及考生须知，考试过程中严格遵守考场纪律&lt;/p&gt;&lt;/li&gt;&lt;li&gt;&lt;p&gt;考生应在本场考试规定时间内作答，并在时间倒计时结束前进行交卷。迟交者，系统将做迟交处理。&lt;/p&gt;&lt;/li&gt;&lt;li&gt;&lt;p&gt;考生在考试过程中，若不小心关闭考试窗口或浏览器，请及时到回来登录账号，并进入考试。其浪费的时间也算入倒计时中。&lt;/p&gt;&lt;/li&gt;&lt;li&gt;&lt;p&gt;考生必须在考试规定时间段内进入考试，逾期后果自负&lt;br/&gt;&lt;/p&gt;&lt;/li&gt;&lt;/ol&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;', '1504094484', 1, 1),
(17, 'XHTML入门演练考试将于今日0点开始，明天0点结束，请各位考生尽快参加考试', '1523261506', 32, 0);

-- --------------------------------------------------------

--
-- 表的结构 `jt_authority`
--

CREATE TABLE IF NOT EXISTS `jt_authority` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(10) NOT NULL,
  `pid` int(10) unsigned NOT NULL,
  `auth_c` varchar(30) NOT NULL,
  `auth_a` varchar(30) NOT NULL,
  `auth_path` varchar(30) NOT NULL,
  `auth_level` tinyint(1) unsigned NOT NULL,
  `display` tinyint(3) unsigned NOT NULL COMMENT '是否展示，1展示',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=85 ;

--
-- 转存表中的数据 `jt_authority`
--

INSERT INTO `jt_authority` (`id`, `name`, `pid`, `auth_c`, `auth_a`, `auth_path`, `auth_level`, `display`) VALUES
(1, '个人中心', 0, '', '', '1', 0, 1),
(2, '其他设置', 0, '', '', '2', 0, 1),
(3, '用户管理', 0, '', '', '3', 0, 1),
(4, '题库管理', 0, '', '', '4', 0, 1),
(5, '试卷模块', 0, '', '', '5', 0, 1),
(6, '个人资料', 1, 'Personal', 'show', '1-6', 1, 1),
(7, '课程列表', 2, 'Course', 'showlist', '2-7', 1, 1),
(8, '公告列表', 2, 'Announce', 'showlist', '2-8', 1, 1),
(9, '删除公告', 2, 'Announce', 'dele', '2-9', 1, 0),
(10, '添加公告', 2, 'Announce', 'add', '2-10', 1, 0),
(11, '修改公告', 2, 'Announce', 'edit', '2-11', 1, 0),
(12, '角色列表', 2, 'Role', 'showlist', '2-12', 1, 1),
(13, '权限列表', 2, 'Authority', 'showlist', '2-13', 1, 1),
(14, '添加权限', 2, 'Authority', 'add', '2-14', 1, 0),
(15, '分配权限', 2, 'Role', 'distribute', '2-15', 1, 0),
(16, '删除权限', 2, 'Authority', 'dele', '2-16', 1, 0),
(17, '修改权限', 2, 'Authority', 'edit', '2-17', 1, 0),
(18, '教师列表', 3, 'Teacher', 'showlist', '3-18', 1, 1),
(19, '添加教师', 3, 'Teacher', 'add', '3-19', 1, 0),
(20, '删除教师', 3, 'Teacher', 'dele', '3-20', 1, 0),
(21, '修改教师', 3, 'Teacher', 'edit', '3-21', 1, 0),
(22, '学生列表', 3, 'Student', 'showlist', '3-22', 1, 1),
(23, '添加学生', 3, 'Student', 'add', '3-23', 1, 0),
(24, '删除学生', 3, 'Student', 'dele', '3-24', 1, 0),
(25, '修改学生', 3, 'Student', 'edit', '3-25', 1, 0),
(26, '管理员列表', 3, 'Admin', 'showlist', '3-26', 1, 1),
(27, '添加管理员', 3, 'Admin', 'add', '3-27', 1, 0),
(28, '删除管理员', 3, 'Admin', 'dele', '3-28', 1, 0),
(29, '修改管理员', 3, 'Admin', 'edit', '3-29', 1, 0),
(30, '单选题列表', 4, 'Question', 'sin_showlist', '4-30', 1, 1),
(31, '添加单选题', 4, 'Question', 'sin_add', '4-31', 1, 0),
(32, '修改单选题', 4, 'Question', 'sin_edit', '4-32', 1, 0),
(33, '删除单选题', 4, 'Question', 'sin_dele', '4-33', 1, 0),
(34, '双选题列表', 4, 'Question', 'dou_showlist', '4-34', 1, 1),
(35, '添加双选题', 4, 'Question', 'dou_add', '4-35', 1, 0),
(36, '删除双选题', 4, 'Question', 'dou_dele', '4-36', 1, 0),
(38, '修改双选题', 4, 'Question', 'dou_edit', '4-38', 1, 0),
(39, '判断题列表', 4, 'Question', 'jud_showlist', '4-39', 1, 1),
(40, '添加判断题', 4, 'Question', 'jud_add', '4-40', 1, 0),
(41, '删除判断题', 4, 'Question', 'jud_dele', '4-41', 1, 0),
(42, '修改判断题', 4, 'Question', 'jud_edit', '4-42', 1, 0),
(43, '主观题列表', 4, 'Question', 'sub_showlist', '4-43', 1, 1),
(44, '增加主观题', 4, 'Question', 'sub_add', '4-44', 1, 0),
(45, '删除主观题', 4, 'Question', 'sub_dele', '4-45', 1, 0),
(46, '修改主观题', 4, 'Question', 'sub_edit', '4-46', 1, 0),
(47, '试卷列表', 5, 'Paper', 'showlist', '5-47', 1, 1),
(48, '随机出卷', 5, 'Paper', 'add_random', '5-48', 1, 0),
(49, '修改试卷', 5, 'Paper', 'edit', '5-49', 1, 0),
(50, '删除试卷', 5, 'Paper', 'dele', '5-50', 1, 0),
(51, '添加角色', 2, 'Role', 'add', '2-51', 1, 0),
(52, '删除角色', 2, 'Role', 'dele', '2-52', 1, 0),
(53, '修改角色', 2, 'Role', 'edit', '2-53', 1, 0),
(54, '添加课程', 2, 'Course', 'add', '2-54', 1, 0),
(55, '删除课程', 2, 'Course', 'dele', '2-55', 1, 0),
(56, '修改课程', 2, 'Course', 'edit', '2-56', 1, 0),
(57, '更改教师状态', 3, 'Teacher', 'isable', '3-57', 1, 0),
(58, '重置教师密码', 3, 'Teacher', 'reset', '3-58', 1, 0),
(59, '更改学生状态', 3, 'Student', 'isable', '3-59', 1, 0),
(60, '重置学生密码', 3, 'Student', 'reset', '3-60', 1, 0),
(61, '更改管理员状态', 3, 'Admin', 'isable', '3-61', 1, 0),
(62, '重置管理员密码', 3, 'Admin', 'reset', '3-62', 1, 0),
(63, '修改个人资料', 1, 'Personal', 'basic_info', '1-63', 1, 0),
(64, '修改个人密码', 1, 'Personal', 'pass_info', '1-64', 1, 0),
(65, '导入单选题', 4, 'Question', 'sin_import', '4-65', 1, 0),
(66, '导入双选题', 4, 'Question', 'dou_import', '4-66', 1, 0),
(67, '导入判断题', 4, 'Question', 'jud_import', '4-67', 1, 0),
(68, '导入主观题', 4, 'Question', 'sub_import', '4-68', 1, 0),
(69, '更改试卷状态', 5, 'Paper', 'isable', '5-69', 1, 0),
(70, '指定出卷', 5, 'Paper', 'add_fixed', '5-70', 1, 0),
(71, '分配指定题目', 5, 'Paper', 'fixed_ques', '5-71', 1, 0),
(72, '监控与批改', 5, 'Mark', 'showlist', '5-72', 1, 1),
(73, '正在批改', 5, 'Mark', 'marking', '5-73', 1, 0),
(74, '试卷分析', 5, 'Analyze', 'showlist', '5-74', 1, 1),
(75, '查看考生列表', 5, 'Analyze', 'stu_list', '5-75', 1, 0),
(76, '查看考生试卷', 5, 'Analyze', 'see_paper', '5-76', 1, 0),
(77, '导出试卷分析', 5, 'Analyze', 'export', '5-77', 1, 0),
(78, '试卷图形分析', 5, 'Analyze', 'graph', '5-78', 1, 0),
(79, '公告置顶', 2, 'Announce', 'top', '2-79', 1, 0),
(80, '系统信息', 1, 'Personal', 'sys_info', '1-80', 1, 0),
(81, '试卷答案开放状态', 5, 'Paper', 'answ', '5-81', 1, 0),
(82, '重新考试', 5, 'Mark', 'reset', '5-82', 1, 0),
(83, '考生监控', 5, 'Mark', 'control', '5-83', 1, 0),
(84, '展示课程到练习题中', 2, 'course', 'disp', '2-84', 1, 0);

-- --------------------------------------------------------

--
-- 表的结构 `jt_course`
--

CREATE TABLE IF NOT EXISTS `jt_course` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `rgdate` char(10) NOT NULL,
  `display` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=156 ;

--
-- 转存表中的数据 `jt_course`
--

INSERT INTO `jt_course` (`id`, `name`, `rgdate`, `display`) VALUES
(147, '网络安全', '1523080566', 0),
(148, 'XHTML入门演练', '1523080596', 0),
(149, 'EKA招新', '1523080678', 0),
(151, '计算机导论', '1523081088', 0),
(152, '数据库系统导论', '1523084078', 0),
(155, '系统问答', '1523426418', 1);

-- --------------------------------------------------------

--
-- 表的结构 `jt_paper_basic`
--

CREATE TABLE IF NOT EXISTS `jt_paper_basic` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `course_id` int(10) unsigned NOT NULL,
  `maker_id` int(10) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  `review_status` tinyint(1) unsigned NOT NULL,
  `create_date` char(10) NOT NULL,
  `startdate` char(10) NOT NULL,
  `enddate` char(10) NOT NULL,
  `limittime` smallint(4) unsigned NOT NULL,
  `type` tinyint(3) unsigned NOT NULL COMMENT '试卷的出题规则类型，1为随机出卷，2为指定出卷',
  `answ_status` tinyint(3) unsigned NOT NULL COMMENT '答案开放状态，0不开放，1开放',
  PRIMARY KEY (`id`),
  KEY `course_id` (`course_id`),
  KEY `maker_id` (`maker_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=53 ;

--
-- 转存表中的数据 `jt_paper_basic`
--

INSERT INTO `jt_paper_basic` (`id`, `course_id`, `maker_id`, `name`, `review_status`, `create_date`, `startdate`, `enddate`, `limittime`, `type`, `answ_status`) VALUES
(50, 147, 32, '2017-2018学年第二学期网络安全中期测试', 1, '1523235487', '1523203200', '1525795200', 60, 2, 1),
(51, 148, 32, '公选课XHTML入门演练测试', 1, '1523236651', '1523289600', '1523462400', 90, 1, 1),
(52, 155, 31, '系统说明测试', 1, '1523427063', '1523376000', '1554912000', 60, 2, 1);

-- --------------------------------------------------------

--
-- 表的结构 `jt_paper_limit`
--

CREATE TABLE IF NOT EXISTS `jt_paper_limit` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `paper_id` int(10) unsigned NOT NULL,
  `limit_class` varchar(200) NOT NULL COMMENT '限制的班级，可多个',
  `limit_stu_status` tinyint(3) unsigned NOT NULL COMMENT '限制导入学号的状态，1是',
  PRIMARY KEY (`id`),
  KEY `paper_id` (`paper_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `jt_paper_limit`
--

INSERT INTO `jt_paper_limit` (`id`, `paper_id`, `limit_class`, `limit_stu_status`) VALUES
(2, 50, '计算机1603班', 0),
(3, 51, '', 1),
(4, 52, '', 0);

-- --------------------------------------------------------

--
-- 表的结构 `jt_paper_limit_stu`
--

CREATE TABLE IF NOT EXISTS `jt_paper_limit_stu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `paper_id` int(10) unsigned NOT NULL,
  `limit_xh` varchar(10) NOT NULL COMMENT '限制的学号',
  `stu_name` varchar(6) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `paper_id` (`paper_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `jt_paper_limit_stu`
--

INSERT INTO `jt_paper_limit_stu` (`id`, `paper_id`, `limit_xh`, `stu_name`) VALUES
(1, 51, '151110213', '陈文星'),
(2, 51, '161110176', '张文敏'),
(3, 51, '161110164', '何杰辉');

-- --------------------------------------------------------

--
-- 表的结构 `jt_paper_ques_fixed`
--

CREATE TABLE IF NOT EXISTS `jt_paper_ques_fixed` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `paper_id` int(10) unsigned NOT NULL,
  `whole_score` smallint(5) unsigned NOT NULL COMMENT '试卷总分',
  `limit_sin` varchar(200) NOT NULL,
  `limit_dou` varchar(200) NOT NULL,
  `limit_jud` varchar(200) NOT NULL,
  `limit_sub` varchar(200) NOT NULL,
  `sin_score` tinyint(3) unsigned NOT NULL,
  `dou_score` tinyint(3) unsigned NOT NULL,
  `jud_score` tinyint(3) unsigned NOT NULL,
  `sub_score` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `paper_id` (`paper_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=52 ;

--
-- 转存表中的数据 `jt_paper_ques_fixed`
--

INSERT INTO `jt_paper_ques_fixed` (`id`, `paper_id`, `whole_score`, `limit_sin`, `limit_dou`, `limit_jud`, `limit_sub`, `sin_score`, `dou_score`, `jud_score`, `sub_score`) VALUES
(50, 50, 100, '18,15,12,10', '18,15,12', '17,16,13,10', '11,8,5', 5, 10, 5, 10),
(51, 52, 100, '6,5,4,3,2,1', '11,10,9,8,7,6,5,4,3,2,1', '7,6,5,4,3,2,1', '4,3,2,1', 3, 5, 1, 5);

-- --------------------------------------------------------

--
-- 表的结构 `jt_paper_ques_random`
--

CREATE TABLE IF NOT EXISTS `jt_paper_ques_random` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `paper_id` int(10) unsigned NOT NULL,
  `whole_score` smallint(3) unsigned NOT NULL,
  `sin_score` tinyint(3) unsigned NOT NULL,
  `sin_easy_num` tinyint(3) unsigned NOT NULL,
  `sin_com_num` tinyint(3) unsigned NOT NULL,
  `sin_diff_num` tinyint(3) unsigned NOT NULL,
  `dou_score` tinyint(3) unsigned NOT NULL,
  `dou_easy_num` tinyint(3) unsigned NOT NULL,
  `dou_com_num` tinyint(3) unsigned NOT NULL,
  `dou_diff_num` tinyint(3) unsigned NOT NULL,
  `jud_score` tinyint(3) unsigned NOT NULL,
  `jud_easy_num` tinyint(3) unsigned NOT NULL,
  `jud_com_num` tinyint(3) unsigned NOT NULL,
  `jud_diff_num` tinyint(3) unsigned NOT NULL,
  `sub_score` tinyint(3) unsigned NOT NULL,
  `sub_easy_num` tinyint(3) unsigned NOT NULL,
  `sub_com_num` tinyint(3) unsigned NOT NULL,
  `sub_diff_num` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `paper_id` (`paper_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=52 ;

--
-- 转存表中的数据 `jt_paper_ques_random`
--

INSERT INTO `jt_paper_ques_random` (`id`, `paper_id`, `whole_score`, `sin_score`, `sin_easy_num`, `sin_com_num`, `sin_diff_num`, `dou_score`, `dou_easy_num`, `dou_com_num`, `dou_diff_num`, `jud_score`, `jud_easy_num`, `jud_com_num`, `jud_diff_num`, `sub_score`, `sub_easy_num`, `sub_com_num`, `sub_diff_num`) VALUES
(51, 51, 100, 5, 1, 1, 1, 10, 2, 1, 1, 5, 1, 1, 1, 10, 1, 1, 1);

-- --------------------------------------------------------

--
-- 表的结构 `jt_ques_double`
--

CREATE TABLE IF NOT EXISTS `jt_ques_double` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `course_id` int(10) unsigned NOT NULL,
  `descr` varchar(1000) NOT NULL,
  `op1` varchar(200) NOT NULL,
  `is_op1` tinyint(3) unsigned NOT NULL COMMENT 'op1是否正确，1为正确，0为错误',
  `op2` varchar(200) NOT NULL,
  `is_op2` tinyint(3) unsigned NOT NULL,
  `op3` varchar(200) NOT NULL,
  `is_op3` tinyint(3) unsigned NOT NULL,
  `op4` varchar(200) NOT NULL,
  `is_op4` tinyint(3) unsigned NOT NULL,
  `is_show` tinyint(3) unsigned NOT NULL COMMENT '是否展示到练习中，1为展示，0为否',
  `difficulty` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `course_id` (`course_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- 转存表中的数据 `jt_ques_double`
--

INSERT INTO `jt_ques_double` (`id`, `course_id`, `descr`, `op1`, `is_op1`, `op2`, `is_op2`, `op3`, `is_op3`, `op4`, `is_op4`, `is_show`, `difficulty`) VALUES
(1, 155, '为什么有些进行中的考试，我点击进去无法显示试卷页面，只有一些提示信息？', '系统的问题', 0, '试卷的考试对象被教师限制了，你在教师的限制范围外', 1, '人品的问题', 0, '你已参加过此场考试', 1, 1, 1),
(2, 155, '打开试卷页面进行考试时，需要注意什么？', '同一场考试不要打开两个考试页面窗口，否则缓存答案机制会在两个页面上进行', 1, '确保自己有足够的时间完成考试，因为考试一旦开始将无法停止倒计时', 1, '没有什么需要注意的，超过时间提交答案也无所谓', 0, '不小心关闭了考试窗口，做的答案就没了，也不到回考试页面进行查看', 0, 1, 2),
(3, 155, '系统中有两种出卷方式：随机出卷和指定出卷。它们有什么不同?', '不知道', 0, '不清楚', 0, '指定出卷由教师指定好考试题目，每个考生拿到的试卷是一样的', 1, '随机出卷由教师填好考试题目的参数（如：难度值，数量值），系统根据参数自动生成试卷，每个考生拿到的试卷都不一样', 1, 1, 2),
(4, 155, '为什么我跟我同学考的是同一张试卷，类型也是指定出卷，但是里面的题目却感觉不一样？', '系统出错', 0, '系统骗我', 0, '系统会将指定出卷的题目顺序随机打乱，选项随机打乱，但是整体的题目内容是一样的', 1, '没有不一样，只是被随机打乱了，这也是系统的防作弊措施', 1, 1, 1),
(5, 155, '如果我超过考试倒计时提交试卷，会怎么样？', '不会怎么样，答案还是提交了上去，不会缺考', 0, '提交的答案无效，分数将直接为0，但是不会缺考', 1, '在分数查询中（教师已开放答案的状态下）仍然可以看到，若是不提交就视为缺考，就看不到', 1, '在分数查询（教师已开放答案的状态下）中看不到', 0, 1, 1),
(6, 155, '为什么我不小心刷新考试页面后，每道题目的选项顺序会更改（自己选择的答案没变化）？这影响我的答题吗？', '影响，因为顺序变了', 0, '不影响，因为选中的答案没变化', 1, '影响，就之前考试的选ABCD一样的原理', 0, '不影响，此系统没有ABCD的概念', 1, 1, 2),
(7, 155, '“在线考试”模块分成三类：进行中，待开始，已结束。以下正确的是？', '“进行中”：当前时间在开放时间和结束时间之内的所有试卷都会在“进行中”展示，并按教师创建时间排倒序下来', 1, '“待开始，已结束”：当前时间不可考，按教师创建时间排倒序下来的前六张试卷', 1, '待开始和已结束的试卷也可以点击进去考试', 0, '准备考试前不应该去留意待开始考试的开放时间、结束时间、限时时间等', 0, 1, 2),
(8, 155, '我什么时候才能查看到自己的考试成绩及答题情况？', '必须要等到教师开放了考试答案后才能在“分数查询”中查看', 1, '答题情况可以通过点击“分数查询--查看试卷”中查看', 1, '再也看不到了', 0, '不想看，考差了', 0, 1, 2),
(9, 155, '在“分数查询”中为什么有些人的主观题显示未批改，有些人显示出分数？', '未批改：教师还未在后台批改到你的主观题', 1, '看到分数：教师批改了你的主观题', 1, '我是错误的', 0, '我来凑个数', 0, 1, 1),
(10, 155, '有时候因为网络或者其他不可抗力原因导致考试无法正常提交答案，应该怎么办？考生提交试卷成功的标志是什么？', '联系教师；点击“提交按钮”，显示“试卷提交成功”', 1, '联系管理员；显示“试卷提交成功”则成功，出现其他结果则为失败，此时应该立刻记录下页面上显示的错误信息', 1, '联系教师；显示“成功”', 0, '不管了', 0, 1, 1),
(11, 155, '为什么在某些浏览器下，页面样式会变化，有些按钮会点击没反应？', '系统使用了较新的插件和标签，所以建议使用火狐浏览器或谷歌浏览器。', 1, '系统使用了较新的插件和标签，所以建议使用360浏览器或IE浏览器。', 0, '多刷新几次，直到有反应', 0, '向管理员反馈', 1, 1, 3),
(12, 147, '请从下列四个答案中挑选正确答案', '网络安全这是选项1，我是正确的', 1, '网络安全这是选项2', 0, '网络安全这是选项3', 0, '444选项-正确', 1, 1, 1),
(13, 148, '挑选错误的答案', '选我', 1, '选我', 1, '不要选我啊', 0, '也不要选我', 0, 0, 2),
(14, 149, '选择正确的', '我是错误的', 0, '我是正确的', 1, '不选我', 0, '我正确的', 1, 1, 3),
(15, 147, '请从下列四个答案中挑选2正确答案', '网络安全这是选项1，我是正确的', 1, '网络安全这是选项2', 0, '网络安全这是选项3--正确', 1, '444选项', 0, 1, 3),
(16, 148, '挑选错误的答案2', '选我', 1, '要选我', 1, '不要选我啊', 0, '也不要选我', 0, 0, 1),
(17, 149, '选择正确的2', '我是错误的', 0, '我是正确的', 1, '不选我', 0, '我正确的', 1, 1, 2),
(18, 147, '请从下列四个答案中挑选一个正确答案', '网络安全这是选项1，我是正确的', 1, '网络安全这是选项2', 0, '网络安全这是选项3', 0, '444选项-正确', 1, 1, 2),
(19, 148, '挑选错误的答案3', '不要选我', 0, '选我', 1, '选我啊', 1, '也不要选我', 0, 0, 3),
(20, 149, '选择正确的3', '我是错误的', 0, '我是正确的', 1, '不选我', 0, '我正确的', 1, 1, 1),
(21, 148, 'xhtml选对的', '对的对的', 1, '错的', 0, '对', 1, '错', 0, 0, 1);

-- --------------------------------------------------------

--
-- 表的结构 `jt_ques_judge`
--

CREATE TABLE IF NOT EXISTS `jt_ques_judge` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `course_id` int(10) unsigned NOT NULL,
  `descr` varchar(1000) NOT NULL,
  `is_true` tinyint(1) unsigned NOT NULL COMMENT '答案为正确时，此值为1，否则为0',
  `is_false` tinyint(3) unsigned NOT NULL COMMENT '答案为错误时，此值为1，否则为0',
  `is_show` tinyint(1) unsigned NOT NULL COMMENT '0表示展示，1表示不展示到测试题中',
  `difficulty` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `course_id` (`course_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- 转存表中的数据 `jt_ques_judge`
--

INSERT INTO `jt_ques_judge` (`id`, `course_id`, `descr`, `is_true`, `is_false`, `is_show`, `difficulty`) VALUES
(1, 155, '开始考试前，应该去认真看看信息公告', 1, 0, 1, 1),
(2, 155, '学号为此系统登录的账号，不可以进行修改', 1, 0, 1, 1),
(3, 155, '在本系统修改的密码为本网站专用，正方系统密码不受影响', 1, 0, 1, 1),
(4, 155, '用户做完自我测试中的练习题后，系统会保存练习记录', 0, 1, 1, 2),
(5, 155, '没有提交答案的考生将视为缺考', 1, 0, 1, 3),
(6, 155, '考生在试卷开放时间和结束时间之间，找个自己比较有空的时间进行考试即可', 1, 0, 1, 2),
(7, 155, '进入了考试，可以关闭考试页面停止倒计时，跑去忙其他事情', 0, 1, 1, 3),
(8, 149, '这道题选‘勾’', 1, 0, 0, 1),
(9, 148, '请选择‘叉’哈哈', 0, 1, 0, 3),
(10, 147, '挑选‘勾’', 1, 0, 0, 2),
(11, 149, '这道题选‘勾’', 1, 0, 0, 3),
(12, 148, '请选择‘勾’', 1, 0, 0, 2),
(13, 147, '挑选‘勾’', 1, 0, 0, 1),
(14, 149, '这道题选‘勾’', 1, 0, 0, 2),
(15, 148, '请选择‘叉’', 0, 1, 0, 1),
(16, 147, '挑选‘勾’', 1, 0, 0, 2),
(17, 147, '网络安全--我是描述，选择‘勾’', 1, 0, 0, 1);

-- --------------------------------------------------------

--
-- 表的结构 `jt_ques_single`
--

CREATE TABLE IF NOT EXISTS `jt_ques_single` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `course_id` int(10) unsigned NOT NULL,
  `descr` varchar(1000) NOT NULL,
  `op1` varchar(200) NOT NULL,
  `is_op1` tinyint(3) unsigned NOT NULL COMMENT 'op1是否正确，1为正确，0为错误',
  `op2` varchar(200) NOT NULL,
  `is_op2` tinyint(3) unsigned NOT NULL,
  `op3` varchar(200) NOT NULL,
  `is_op3` tinyint(3) unsigned NOT NULL,
  `op4` varchar(200) NOT NULL,
  `is_op4` tinyint(3) unsigned NOT NULL,
  `is_show` tinyint(3) unsigned NOT NULL COMMENT '是否展示到练习中，1为展示，0为否',
  `difficulty` tinyint(3) unsigned NOT NULL COMMENT '难度依次递增',
  PRIMARY KEY (`id`),
  KEY `course_id` (`course_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

--
-- 转存表中的数据 `jt_ques_single`
--

INSERT INTO `jt_ques_single` (`id`, `course_id`, `descr`, `op1`, `is_op1`, `op2`, `is_op2`, `op3`, `is_op3`, `op4`, `is_op4`, `is_show`, `difficulty`) VALUES
(1, 155, '这是一道测试题目，让同学们熟悉下考试流程', '这个是错误的答案', 0, '这个是正确答案', 1, '这个是错误的', 0, '我是错误的', 0, 1, 1),
(2, 155, '以下是一些使用本系统需要注意的问题，请大家认真看看，提交后自己在 “分数查询” 中对下答案，好吗？', '好', 1, '不好', 0, '我就不做，你咬我啊', 0, '臣妾做不到', 0, 1, 1),
(3, 155, '首次登录本系统时需不需要先注册？', '需要', 0, '我又不是开发者，我怎么知道', 0, '不需要，首次登录直接使用正方账号和正方密码即可', 1, '不需要，此系统的账号密码永远跟正方教务系统的账号密码一样', 0, 1, 1),
(4, 155, '在本系统中修改了密码，但是后来忘记了怎么办？', '凉拌', 0, '不知道', 0, '在登录页面点击“忘记密码”，输入正方系统账号密码就可重置当前系统密码为正方密码', 1, '凭记忆把可能的密码一个个试过去', 0, 1, 1),
(5, 155, '在“个人资料----基础信息”中，发现自己的信息与真实情况不一致，该怎么办？', '点击“重新从正方系统导入”或告知老师', 1, '自己修改', 0, '视而不见', 0, '多大点的事情，不管了', 0, 1, 1),
(6, 155, '关于自我测试模块中的题目正确的是？', '是从教师指定的一些试题中抽取出来的；不排除考试出原题的可能', 1, '题目都是一成不变的了，不会再有更新变化', 0, '所有课程都会有练习题', 0, '有四种类型题可以练习', 0, 1, 1),
(10, 147, '请从下列四个答案中挑选一个正确答案', '网络安全这是选项1，我是正确的', 1, '网络安全这是选项2', 0, '网络安全这是选项3', 0, '444选项', 0, 1, 1),
(11, 149, '请从下列四个答案中挑选一个正确答案', '这是选项1，我是正确的', 1, '这是选项2', 0, '这是选项3', 0, '444选项', 0, 1, 1),
(12, 147, '请从下列四个答案中挑选一个正确答案', '网络安全这是选项1，我是正确的', 1, '网络安全这是选项2', 0, '网络安全这是选项3', 0, '444选项', 0, 1, 1),
(13, 148, '挑选错误的答案', '选我', 1, '不要选我', 0, '不要选我啊', 0, '也不要选我', 0, 0, 2),
(14, 149, '选择正确的', '我是错误的', 0, '我是正确的', 1, '不选我', 0, '我是错误的', 0, 1, 3),
(15, 147, '请从下列四个答案中挑选一个2正确答案', '网络安全这是选项1，我是正确的', 1, '网络安全这是选项2', 0, '网络安全这是选项3', 0, '444选项', 0, 1, 3),
(16, 148, '挑选错误的答案2', '选我', 1, '不要选我', 0, '不要选我啊', 0, '也不要选我', 0, 0, 1),
(17, 149, '选择正确的2', '我是错误的', 0, '我是正确的', 1, '不选我', 0, '我是错误的', 0, 1, 2),
(18, 147, '请从下列四个答案中挑选一个3正确答案', '网络安全这是选项1，我是正确的', 1, '网络安全这是选项2', 0, '网络安全这是选项3', 0, '444选项', 0, 1, 2),
(19, 148, '挑选错误的答案3', '不要选我', 0, '选我', 1, '不要选我啊', 0, '也不要选我', 0, 0, 3),
(20, 149, '选择正确的3', '我是错误的', 0, '我是正确的', 1, '不选我', 0, '我是错误的', 0, 1, 1);

-- --------------------------------------------------------

--
-- 表的结构 `jt_ques_subj`
--

CREATE TABLE IF NOT EXISTS `jt_ques_subj` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `course_id` int(10) unsigned NOT NULL,
  `descr` varchar(1000) NOT NULL,
  `right_answ` varchar(2500) NOT NULL,
  `difficulty` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `course_id` (`course_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- 转存表中的数据 `jt_ques_subj`
--

INSERT INTO `jt_ques_subj` (`id`, `course_id`, `descr`, `right_answ`, `difficulty`) VALUES
(1, 155, '使用完此系统后，你有什么好的建议反馈给开发者，帮开发者更好的完善这个系统？（可从页面交互，功能设置，bug反馈方面叙述）', '言之有理即可', 3),
(2, 155, '进入考试页面进行答卷，考生需要注意什么？', '1 不要双开考试页面，因为答案缓存机制会在两个页面上进行。\r\n2 注意查看倒计时，不要迟交或不提交试卷。\r\n3 一旦进入考试页面，倒计时无法停止，注意考试前确保自己有足够的时间答题。\r\n4 不小心关闭了考试页面，赶紧点击回进入考试页面。由于有答案缓存，之前做的答案会被保留下来。', 2),
(3, 155, '我什么时候才能查询到自己的分数？如何查看自己的答题情况？', '教师在后台将试卷答案状态设置为开放，考生即可查看。答题情况可从“分数查询--选中试卷---查看试卷”查看。', 3),
(4, 155, '进入了考试页面，但是超时提交和未提交分别有什么后果？', '① 超时提交：考生分数直接为0，提交的答案置为空，可在“分数查询”中查看到记录。\r\n② 未提交：考生分数直接为0，提交的答案置为空，在“分数查询”中查看不到记录（假设教师已开放试卷答案）。需要考生进入试卷页面提交，才能显示出此记录。', 3),
(5, 147, '说说你对网络安全的认识', '网络安全--言之有理即可', 1),
(6, 148, '说说你对XHTML入门演练的认识', 'XHTML入门演练--言之有理即可', 2),
(7, 149, '说说你对EKA的认识', 'EKA招新--言之有理即可', 3),
(8, 147, '学完网络安全有什么收获', '网络安全--言之有理即可', 3),
(9, 148, '学完XHTML入门演练有什么收获', 'XHTML入门演练--言之有理即可', 1),
(10, 149, '如果进入EKA，你会有什么收获', 'EKA招新--言之有理即可', 2),
(11, 147, '学完网络安全能做什么', '网络安全--言之有理即可', 2),
(12, 148, '学完XHTML入门演练能做什么', 'XHTML入门演练--言之有理即可', 3),
(13, 149, '如果进入EKA，你会做什么', 'EKA招新--言之有理即可', 1);

-- --------------------------------------------------------

--
-- 表的结构 `jt_role`
--

CREATE TABLE IF NOT EXISTS `jt_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(10) NOT NULL,
  `auth_ids` varchar(500) NOT NULL,
  `auth_ac` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- 转存表中的数据 `jt_role`
--

INSERT INTO `jt_role` (`id`, `name`, `auth_ids`, `auth_ac`) VALUES
(1, '教师', '1,6,63,64,2,8,9,10,11,79,4,30,31,32,33,34,35,36,38,39,40,41,42,43,44,45,46,65,66,67,68,5,47,48,49,50,69,70,71,72,73,74,75,76,77,78,81,82,83', 'Personal-show,Announce-showlist,Announce-dele,Announce-add,Announce-edit,Question-sin_showlist,Question-sin_add,Question-sin_edit,Question-sin_dele,Question-dou_showlist,Question-dou_add,Question-dou_dele,Question-dou_edit,Question-jud_showlist,Question-jud_add,Question-jud_dele,Question-jud_edit,Question-sub_showlist,Question-sub_add,Question-sub_dele,Question-sub_edit,Paper-showlist,Paper-add_random,Paper-edit,Paper-dele,Personal-basic_info,Personal-pass_info,Question-sin_import,Question-dou_import,Question-jud_import,Question-sub_import,Paper-isable,Paper-add_fixed,Paper-fixed_ques,Mark-showlist,Mark-marking,Analyze-showlist,Analyze-stu_list,Analyze-see_paper,Analyze-export,Analyze-graph,Announce-top,Paper-answ,Mark-reset,Mark-control'),
(17, '普通管理员', '1,6,63,64,2,7,8,9,10,11,12,13,14,15,16,17,51,52,53,54,55,56,79,84,3,18,19,20,21,22,23,24,25,26,27,28,29,57,58,59,60,61,62', 'Personal-show,Course-showlist,Announce-showlist,Announce-dele,Announce-add,Announce-edit,Role-showlist,Authority-showlist,Authority-add,Role-distribute,Authority-dele,Authority-edit,Teacher-showlist,Teacher-add,Teacher-dele,Teacher-edit,Student-showlist,Student-add,Student-dele,Student-edit,Admin-showlist,Admin-add,Admin-dele,Admin-edit,Role-add,Role-dele,Role-edit,Course-add,Course-dele,Course-edit,Teacher-isable,Teacher-reset,Student-isable,Student-reset,Admin-isable,Admin-reset,Personal-basic_info,Personal-pass_info,Announce-top,course-disp'),
(18, '题库管理员', '1,6,63,64,4,30,31,32,33,34,35,36,38,39,40,41,42,43,44,45,46,65,66,67,68,5,47,48,49,50,69,70,71,72,73,74,75,76,77,78,81,82,83', 'Personal-show,Question-sin_showlist,Question-sin_add,Question-sin_edit,Question-sin_dele,Question-dou_showlist,Question-dou_add,Question-dou_dele,Question-dou_edit,Question-jud_showlist,Question-jud_add,Question-jud_dele,Question-jud_edit,Question-sub_showlist,Question-sub_add,Question-sub_dele,Question-sub_edit,Paper-showlist,Paper-add_random,Paper-edit,Paper-dele,Personal-basic_info,Personal-pass_info,Question-sin_import,Question-dou_import,Question-jud_import,Question-sub_import,Paper-isable,Paper-add_fixed,Paper-fixed_ques,Mark-showlist,Mark-marking,Analyze-showlist,Analyze-stu_list,Analyze-see_paper,Analyze-export,Analyze-graph,Paper-answ,Mark-reset,Mark-control');

-- --------------------------------------------------------

--
-- 表的结构 `jt_stu`
--

CREATE TABLE IF NOT EXISTS `jt_stu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `xuehao` char(9) NOT NULL,
  `pwd` char(60) NOT NULL,
  `name` varchar(5) NOT NULL,
  `college` varchar(15) NOT NULL COMMENT '学院',
  `stu_class` varchar(15) NOT NULL COMMENT '班级',
  `major` varchar(20) NOT NULL COMMENT '主修专业',
  `status` tinyint(1) unsigned NOT NULL COMMENT '0为启用',
  `telphone` char(11) NOT NULL,
  `email` varchar(30) NOT NULL,
  `last_lgdate` char(10) NOT NULL,
  `last_ip` varchar(16) NOT NULL,
  `rgdate` char(10) NOT NULL,
  `lg_num` int(10) unsigned NOT NULL COMMENT '登录次数',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=29 ;

--
-- 转存表中的数据 `jt_stu`
--

INSERT INTO `jt_stu` (`id`, `xuehao`, `pwd`, `name`, `college`, `stu_class`, `major`, `status`, `telphone`, `email`, `last_lgdate`, `last_ip`, `rgdate`, `lg_num`) VALUES
(23, '151110213', '$2y$10$vlys.mB8MeeHiB0nhTqGZ.C8iEST53d9fYMw0pK2mzq8KzzysH6B.', '陈文星', '计算机学院', '计算机1504班', '网络工程', 0, '17875511965', '', '1523427180', '127.0.0.1', '1505989847', 65);

-- --------------------------------------------------------

--
-- 表的结构 `jt_stu_answ`
--

CREATE TABLE IF NOT EXISTS `jt_stu_answ` (
  ` id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `stu_id` int(10) unsigned NOT NULL,
  `paper_id` int(10) unsigned NOT NULL,
  `stime` char(10) NOT NULL COMMENT '开始考试时间',
  `etime` char(10) NOT NULL COMMENT '提交试卷时间',
  `single_answ` varchar(1000) NOT NULL,
  `double_answ` varchar(3000) NOT NULL,
  `judge_answ` varchar(1000) NOT NULL,
  `subj_answ` varchar(5000) NOT NULL,
  PRIMARY KEY (` id`),
  KEY `stu_id` (`stu_id`),
  KEY `paper_id` (`paper_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

-- --------------------------------------------------------

--
-- 表的结构 `jt_stu_answ_cache`
--

CREATE TABLE IF NOT EXISTS `jt_stu_answ_cache` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `stu_id` int(10) unsigned NOT NULL,
  `paper_id` int(10) unsigned NOT NULL,
  `single_answ` varchar(1000) NOT NULL,
  `double_answ` varchar(3000) NOT NULL,
  `judge_answ` varchar(1000) NOT NULL,
  `subj_answ` varchar(5000) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `stu_id` (`stu_id`),
  KEY `paper_id` (`paper_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='答案暂存表' AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- 表的结构 `jt_stu_paper`
--

CREATE TABLE IF NOT EXISTS `jt_stu_paper` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `stu_id` int(10) unsigned NOT NULL COMMENT '与paper_id为联合主键',
  `paper_id` int(10) unsigned NOT NULL,
  `single_ids` varchar(500) NOT NULL,
  `double_ids` varchar(500) NOT NULL,
  `judge_ids` varchar(500) NOT NULL,
  `subj_ids` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `stu_id` (`stu_id`),
  KEY `paper_id` (`paper_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- 表的结构 `jt_stu_score`
--

CREATE TABLE IF NOT EXISTS `jt_stu_score` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `stu_id` int(10) unsigned NOT NULL,
  `paper_id` int(10) unsigned NOT NULL,
  `all_score` smallint(5) unsigned NOT NULL,
  `single_score` smallint(5) unsigned NOT NULL,
  `double_score` smallint(5) unsigned NOT NULL,
  `judge_score` smallint(5) unsigned NOT NULL,
  `subj_score` smallint(5) unsigned NOT NULL,
  `mark_status` tinyint(3) unsigned NOT NULL COMMENT '1为已批改,0为未批改',
  `each_ms` varchar(200) NOT NULL COMMENT '每道主观题得分,按stu_paper中的主观题目顺序依次存入',
  PRIMARY KEY (`id`),
  KEY `stu_id` (`stu_id`),
  KEY `paper_id` (`paper_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

-- --------------------------------------------------------

--
-- 表的结构 `jt_user`
--

CREATE TABLE IF NOT EXISTS `jt_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(30) NOT NULL,
  `pwd` char(60) NOT NULL,
  `name` varchar(5) NOT NULL,
  `rgdate` char(10) NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  `telphone` char(11) NOT NULL,
  `course_ids` varchar(300) NOT NULL COMMENT '教师所担任的科目，管理员为空',
  `status` tinyint(1) unsigned NOT NULL,
  `last_ip` varchar(16) NOT NULL,
  `last_lgdate` char(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=36 ;

--
-- 转存表中的数据 `jt_user`
--

INSERT INTO `jt_user` (`id`, `email`, `pwd`, `name`, `rgdate`, `role_id`, `telphone`, `course_ids`, `status`, `last_ip`, `last_lgdate`) VALUES
(1, '494025451@qq.com', '$2y$10$PsO.hd5NKcCvSIXi0lF6VeUAKfP8QUp/h2EQu0oVxZ4O5OfRm70aW', '陈文星', '1501586745', 0, '17875511965', '', 1, '127.0.0.1', '1523427115'),
(29, '456@qq.com', '$2y$10$Bnqk4SfPAOb8x4JkUo4HPue/pxS45V9B0XmRaZMnV2EroOCdIkfJK', '普通', '1501587386', 17, '', '', 1, '', ''),
(30, '123@qq.com', '$2y$10$1RgiEMVsVrcG5FXH1wEAP./wGITJxXPrAUsgIocH9YFolnfl9DYp.', '题库', '1501587419', 18, '', '', 1, '127.0.0.1', '1514462437'),
(31, '123456@qq.com', '$2y$10$nqPRg36bTq06.cyP89/Yh.KApZ3YVmcVA1N6cJJ89NCR43eiSTWgi', 'EKA官方', '1523080879', 1, '', '149,155', 1, '127.0.0.1', '1523426950'),
(32, 'lyd@jyueka.com', '$2y$10$T2rLfXe3ckfpb.BiRZkYguv8sq81kVQZQWz.4P10TfhDAE28I1BFq', '罗予东', '1523080962', 1, '', '147,148,149', 1, '127.0.0.1', '1523320457'),
(34, '1234567@qq.com', '$2y$10$U0NeXfecc5BX7bnk5.4vwONsYg0E/iCgoR9RetEGa2s1gWAnDabg.', '钟秀玉', '1523084173', 1, '', '151,152', 1, '127.0.0.1', '1523361885');

--
-- 限制导出的表
--

--
-- 限制表 `jt_paper_basic`
--
ALTER TABLE `jt_paper_basic`
  ADD CONSTRAINT `jt_paper_basic_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `jt_course` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jt_paper_basic_ibfk_2` FOREIGN KEY (`maker_id`) REFERENCES `jt_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `jt_paper_limit`
--
ALTER TABLE `jt_paper_limit`
  ADD CONSTRAINT `jt_paper_limit_ibfk_1` FOREIGN KEY (`paper_id`) REFERENCES `jt_paper_basic` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `jt_paper_limit_stu`
--
ALTER TABLE `jt_paper_limit_stu`
  ADD CONSTRAINT `jt_paper_limit_stu_ibfk_1` FOREIGN KEY (`paper_id`) REFERENCES `jt_paper_basic` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `jt_paper_ques_fixed`
--
ALTER TABLE `jt_paper_ques_fixed`
  ADD CONSTRAINT `jt_paper_ques_fixed_ibfk_1` FOREIGN KEY (`paper_id`) REFERENCES `jt_paper_basic` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `jt_paper_ques_random`
--
ALTER TABLE `jt_paper_ques_random`
  ADD CONSTRAINT `jt_paper_ques_random_ibfk_1` FOREIGN KEY (`paper_id`) REFERENCES `jt_paper_basic` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `jt_ques_double`
--
ALTER TABLE `jt_ques_double`
  ADD CONSTRAINT `jt_ques_double_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `jt_course` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `jt_ques_judge`
--
ALTER TABLE `jt_ques_judge`
  ADD CONSTRAINT `jt_ques_judge_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `jt_course` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `jt_ques_single`
--
ALTER TABLE `jt_ques_single`
  ADD CONSTRAINT `jt_ques_single_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `jt_course` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `jt_ques_subj`
--
ALTER TABLE `jt_ques_subj`
  ADD CONSTRAINT `jt_ques_subj_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `jt_course` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `jt_stu_answ`
--
ALTER TABLE `jt_stu_answ`
  ADD CONSTRAINT `jt_stu_answ_ibfk_1` FOREIGN KEY (`stu_id`) REFERENCES `jt_stu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jt_stu_answ_ibfk_2` FOREIGN KEY (`paper_id`) REFERENCES `jt_paper_basic` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `jt_stu_answ_cache`
--
ALTER TABLE `jt_stu_answ_cache`
  ADD CONSTRAINT `jt_stu_answ_cache_ibfk_1` FOREIGN KEY (`stu_id`) REFERENCES `jt_stu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jt_stu_answ_cache_ibfk_2` FOREIGN KEY (`paper_id`) REFERENCES `jt_paper_basic` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `jt_stu_paper`
--
ALTER TABLE `jt_stu_paper`
  ADD CONSTRAINT `jt_stu_paper_ibfk_1` FOREIGN KEY (`stu_id`) REFERENCES `jt_stu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jt_stu_paper_ibfk_2` FOREIGN KEY (`paper_id`) REFERENCES `jt_paper_basic` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `jt_stu_score`
--
ALTER TABLE `jt_stu_score`
  ADD CONSTRAINT `jt_stu_score_ibfk_1` FOREIGN KEY (`stu_id`) REFERENCES `jt_stu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jt_stu_score_ibfk_2` FOREIGN KEY (`paper_id`) REFERENCES `jt_paper_basic` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
