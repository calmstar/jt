<?php
/**
 * Created by PhpStorm.
 * User: 陈文星
 * Date: 2018/4/19
 * Time: 20:08
 */
namespace Home\Controller;
use Think\Controller;

class EmptyController extends Controller {

    public function _empty () {
        $this->error("似乎来到了火星",'',5);
    }

}