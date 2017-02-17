<?php

namespace Admin\Model;

use \Think\Model;

class UserModel extends Model{
   //用户列表
    public function getList ($rows){
        //dump(I('get.'));
        if(''!==(I('phone'))){
           $map['phone'] = ['like','%'.I('phone').'%'];
        }
        
        if(!''!==(I('referrer'))){
           $map['referrer'] = ['like','%'.I('referrer').'%']; 
        }
        
        if(''!==(I('status'))){
           $map['status']=I('status');
           dump(I('status'));
        }
        
        if(''!==(I('ident'))){
           $map['ident']=I('ident'); 
        }
        
        if(''!==(I('grade'))){
           $map['grade']=I('grade'); 
        }
        $nowpage=I('page',1);
        $totalpage = ceil(($this->where($map)->count())/$rows);
        $list =  $this->where($map)->limit(($nowpage-1)*$rows,$rows)->select();
        foreach ($list as $k=>$v){
            $list[$k]['registertime'] = date('y-m-d',$v['registertime']);
            if($v['lasttime']){
                $list[$k]['lasttime'] = date('y-m-d',$v['lasttime']);
            }else{
                $list[$k]['lasttime'] = '该用户还未登录过';
            }
        }
        //$sql =$this->getLastSql();
        //dump($sql);die();
        return ['totalpage'=>$totalpage,'list'=>$list];
    }
    
    //用户编辑显示信息
    public function getInfo (){
        $info = $this->where(['id'=>I('id')])->find();
        $info['registertime'] = date('Y-m-d',$info['registertime']);
        $info['lasttime'] = date('Y-m-d',$info['lasttime']);
        return $info;
    }
    
}
