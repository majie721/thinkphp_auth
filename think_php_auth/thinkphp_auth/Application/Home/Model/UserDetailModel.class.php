<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Home\Model;

/**
 * app支付实名认证
 *
 * @author martain 2017.1.9
 */
class UserDetailModel extends Model {
    //实名认证的验证规则
    protected $_validate = array(
        array('pid','require','非法访问！'), 
        array('username','require','用户名不能为空！'),  
        array('idno','require','身份证号码不能为空！'),
        array('province','require','省份不能为空！'),
        array('address','require','地址不能为空！'),
        array('bankname','require','银行名称不能为空！'),
       // array('banchname','require','支行名称不能为空！'),  
        array('bankphone','require','银行预留手机号码不能为空！'),
        array('paypasswd','require','不能为空！'),
        array('address','require','不能为空！'),
        array('repaypasswd','paypasswd','确认密码不正确',0,'confirm'), 
        array('idno','checkIdent','身份证号码和姓名不匹配',1,'callback'),
        array('idno','checkBank','银行信息和预留手机号码不匹配',1,'callback'),
           );
    
    
    //身份证号码是否匹配
    public function checkIdent(){
        
    }
   
    //银行信息和预留手机
    public function checkBank(){
        
    }
    
    
    //实名认证
    public function  ident(){
        if(!$this->create()){
           return ['status'=>0,'info'=>($this->getError())]; 
        }else{
           //事物处理写进数据库 
            $map = I('post.');
            $map['city'] = htmlspecialchars($map['city']);
            $map['area'] = htmlspecialchars($map['area']);
            $this->startTrans();
            $res1 = $this->add($map);
            $bank = M('Userbank');
            $res2 = $bank->add($map);
            if($res1&&$res2){
                $this->commit();    //事务提交
                return ['status'=>1,'info'=>'实名认证成功'];
            }else{
                $this->rollback();  //事务回滚
                return ['status'=>0,'info'=>'实名认证失败,请稍后再试'];
            }
        }
    }
}
