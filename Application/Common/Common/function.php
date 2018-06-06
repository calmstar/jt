<?php

    //序号自动自增方法
    function icount(){
        $i=1;
        if($_GET['p']) //p为当前第几页
            if($_GET['p']==1){
            $i=1;
        }else{
            $i=1+($_GET['p']-1)*20;
        }
        return $i;
    }

    /**
     * Thinkphp默认分页样式转Bootstrap分页样式
     * @author H.W.H
     * @param string $page_html tp默认输出的分页html代码
     * @return string 新的分页html代码
     */
    function bootstrap_page_style($page_html){
        if ($page_html) {
            $page_show = str_replace('<div>','<nav><ul class="pagination">',$page_html);
            $page_show = str_replace('</div>','</ul></nav>',$page_show);
            $page_show = str_replace('<span class="current">','<li class="active"><a>',$page_show);
            $page_show = str_replace('</span>','</a></li>',$page_show);
            $page_show = str_replace(array('<a class="num"','<a class="prev"','<a class="next"','<a class="end"','<a class="first"'),'<li><a',$page_show);
            $page_show = str_replace('</a>','</a></li>',$page_show);
        }
        return $page_show;
    }

//    截取中文字符串
    function msubstr($str, $start=0, $length, $charset="utf-8", $suffix=false)
{
    if(function_exists("mb_substr")){
        if($suffix)
            return mb_substr($str, $start, $length, $charset)."...";
        else
            return mb_substr($str, $start, $length, $charset);
    }
    elseif(function_exists('iconv_substr')) {
        if($suffix)
            return iconv_substr($str,$start,$length,$charset)."...";
        else
            return iconv_substr($str,$start,$length,$charset);
    }
    $re['utf-8'] = "/[x01-x7f]|[xc2-xdf][x80-xbf]|[xe0-xef][x80-xbf]{2}|[xf0-xff][x80-xbf]{3}/";
    $re['gb2312'] = "/[x01-x7f]|[xb0-xf7][xa0-xfe]/";
    $re['gbk']  = "/[x01-x7f]|[x81-xfe][x40-xfe]/";
    $re['big5']  = "/[x01-x7f]|[x81-xfe]([x40-x7e]|xa1-xfe])/";
    preg_match_all($re[$charset], $str, $match);
    $slice = join("",array_slice($match[0], $start, $length));
    if($suffix) return $slice."…";
    return $slice;
}


