<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Home\Model;

/**
 * app 登录生成token
 *
 * @author Martain  2017.1.9
 */
class TokenModel  extends Model{
    public function setToken (){
        $res = $this->where(['userphone'=>I('phone')])->find();
        $map['userphone'] = I('phone');
        $map['losttime'] = time()+14400; //token生存期为4个小时
        $map['ip'] = (getClientIP()=='Unknow')?'Unknow':ip2long(getClientIP());   
        $token = md5($map['userphone'].time().$map['ip'].rand(11111,99999)); //token不能重复
        while ($this->where(['token'=>$token])->find()){
            $token = md5($map['userphone'].time().$map['ip'].rand(11111,99999));
        }
        
        if($res){
            $this->where(['userphone'=>I('phone')])->save();
            return ['status'=>1,'info'=>'登录成功','token'=>$token];
        }else{
            $this->add();
            return ['status'=>1,'info'=>'登录成功','token'=>$token];
        }
    }
    
  
}
