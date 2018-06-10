<?php
namespace Home\Model;
use Think\Model;


class Ques_subjModel extends Model{

    public function deal_info($info,$offset,$limit){
        foreach($info as $k => &$v){
            $v['xh'] = $offset+$k+1;
            $v['adddate'] = date('Y-m-d',$v['adddate']);
            $v['descr'] = strip_tags(htmlspecialchars_decode($v['descr']));
            $v['descr'] = msubstr($v['descr'],0,50);
            if($v['difficulty'] == 1){
                $v['difficulty']  = '*';
            }elseif ($v['difficulty'] == 2){
                $v['difficulty']  = '**';
            }else{
                $v['difficulty']  = '***';
            }
        }
        unset($v);
        return $info;
    }


}