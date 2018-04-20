<?php
/**
 * Created by PhpStorm.
 * User: 陈文星
 * Date: 2018/4/19
 * Time: 20:34
 */
namespace Admin\Controller;
use Think\Controller;

class EmptyController extends Controller {

    public function _empty () {
        $this->error("页面出错",'',5);
    }

}