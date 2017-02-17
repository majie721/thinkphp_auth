<?php
namespace Home\Model;

use Think\Model;

class UserModel extends Model {
        //自动验证规则
        protected $_validate = array(
           array('phone','','帐号名称已经存在！',0,'unique',1),
           array('repasswd','passwd','确认密码不正确',0,'confirm'), 
        );
    
    
    public function verCode(){
        //dump(I('phone'));die();
        if(!preg_match('#^13[\d]{9}$|^14[5,7]{1}\d{8}$|^15[^4]{1}\d{8}$|^17[0,6,7,8]{1}\d{8}$|^18[\d]{9}$#', I('phone'))){
            return ['status'=>0,'info'=>'电话号码格式不正确!'];
        }else{
            $code = rand(1111, 9999);
            $apikey = "24e7610cd7671f26f44a210e9804ea51"; //修改为您的apikey(https://www.yunpian.com)登录官网后获取
            $mobile = I('phone'); //请用手机号代替
            $text = "【小味到】您的验证码是" . $code;
            // 发送短信
            $data = array('text' => $text, 'apikey' => $apikey, 'mobile' => $mobile);
            $array = sendsms($data);
            if($array['code']==0){
                $map['phone'] = $mobile;
                $map['vercode'] = $code;
                $map['losttime'] = time()+600;
                $map['phone'] = $mobile;
                if(I('type')==1){
                    M('Register')->add($map); //type==1 是注册用户首次生成验证吗
                }else{
                    M('Register')->save($map); //用于密码找回等
                }
                return ['status'=>1,'info'=>'短信发送成功!'];
            }else{
                //return $array;
                return ['status'=>1,'info'=>'短信发送不成功稍后再试!'];
            }
        }
    }
    
    public function register (){
        //判断验证是否存在
        $res = M('Register')->where(['phone'=>I('phone')])->order('id desc')->find();
        if(!$res){
             return ['status'=>0,'info'=>'请先申请验证'];
        }
        
        //判断验证吗是否正确
        if($res['vercode']!=I('vercode')){
            return ['status'=>0,'info'=>'验证码错误'];
        }
        
        //判断短信验证是否过期
        if($res['losttime']<time()){
            return ['status'=>0,'info'=>'验证码已经过期'];
        }
        
        
        //自动验证
        if(!$this->create()){
            return ['status'=>0,'info'=>$this->getError()];
        }else{
            if(I('referrerphone')){
                $refid = M('User')->where(['phone'=>I('referrerphone')])->getField('id');
            }
            $map['phone'] = I('phone');
            $map['passwd'] = md5(I('passwd'));
            $map['registertime'] = time();
            $map['referrer'] = isset($refid)?$refid:'';
            $res = $this->add($map);
            if($res){
                return ['status'=>1,'info'=>'注册成功'];
            }else{
                return ['status'=>0,'info'=>'服务器忙稍后再试'];
            }
        }
        
    }
    
    public function resetPasswd (){
        //判断验证是否存在
        $res = M('Register')->where(['phone'=>I('phone')])->order('id desc')->find();
        if(!$res){
             return ['status'=>0,'info'=>'用户不存在'];
        }
        
        //判断验证吗是否正确
        if($res['vercode']!=I('vercode')){
            return ['status'=>0,'info'=>'验证码错误'];
        }
        
        //判断短信验证是否过期
        if($res['losttime']<time()){
            return ['status'=>0,'info'=>'验证码已经过期'];
        }
        $map['phone'] = I('phone');
        $map['passwd'] = md5(I('passwd'));
        $res = $this->where(['phone'=>I('phone')])->save($map);
        if($res){
           return ['status'=>1,'info'=>'修改密码成功']; 
        }else{
           return ['status'=>0,'info'=>'服务器忙,稍后再试']; 
        }
    }
}
