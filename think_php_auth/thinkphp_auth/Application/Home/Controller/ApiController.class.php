<?php
namespace Home\Controller;

use Think\Controller;

/*
 * APP 接口文件
 */

class ApiController extends Controller
{
    /**
     * 测试
     */
    public function index()
    {
        echo 'iddex';
    }
    
    /**
     * 获取验证码
     */
    public function verCode()
    {
        if (IS_AJAX) {
            $res = D('User')->verCode();
            $this->ajaxReturn($res);
        } else {
            $this->ajaxReturn(['status' => 0, 'info' => '非法访问!']);
        }
    }
    
    /**
     * 注册
     */
    public function register()
    {
        if (IS_AJAX) {
            $res = D('User')->register();
            $this->ajaxReturn($res);
        } else {
            $this->ajaxReturn(['status' => 0, 'info' => '非法访问!']);
        }
    }
    
    /**
     * 登录
     */
    public function login()
    {
        if (IS_AJAX) {
            $code = M('User')->where(['phone' => I('username'), 'status' => 1])->getField('passwd');
            if ($code == md5(I('passwd'))) {
                //生成token
                $res = D('Token')->setToken();
                $this->ajaxReturn($res);
            } else {
                $this->ajaxReturn(['status' => 0, 'info' => '用户名或密码错误!']);
            }
        } else {
            $this->ajaxReturn(['status' => 0, 'info' => '非法访问!']);
        }
    }
    
    /**
     * 退出
     */
    public function logout()
    {
        if (IS_AJAX) {
            //session('user',null);
            $this->ajaxReturn(['status' => 1, 'info' => '退出成功!']);
        } else {
            $this->ajaxReturn(['status' => 0, 'info' => '非法访问!']);
        }
    }
    
    /*
     * 邀请注册
     */
    public function invite()
    {
        $this->checkToken();
        if (IS_AJAX) {
            $this->ajaxReturn(['status' => 1, 'info' => "http://ywm.xwdcook.com/index.php/api/register?refferrer=" . session('user')]);
        } else {
            $this->ajaxReturn(['status' => 0, 'info' => '非法访问!']);
        }
    }
    
    /*
     * 重置密码
     */
    public function resetPasswd()
    {
        $this->checkToken();
        if (IS_AJAX) {
            $res = D('User')->resetPasswd();
            $this->ajaxReturn($res);
        } else {
            $this->ajaxReturn(['status' => 0, 'info' => '非法访问!']);
        }
    }
    
    /**
     * 实名认证首页面
     */
    public function identIndex()
    {
        $this->checkToken();
        if (IS_AJAX) {
            
        } else {
            
        }
    }
    
    /**
     * 实名认证
     */
    public function identification()
    {
        $this->checkToken();
        if (IS_AJAX) {
            $res = D('UserDetail')->ident();
            $this->ajaxReturn($res);
        } else {
            $this->ajaxReturn(['status' => 0, 'info' => '非法访问!']);
        }
    }
    
    
    /**
     * 验证token
     */
    protected function checkToken()
    {
        $token = I('token');
        $userInfo = M('Token')->where(['token' => $token])->find();
        if ($userphone) {
            if ($userInfo['losttime'] < time()) {
                $this->ajaxReturn(['status' => 0, 'info' => '登录信息过期,请重新登录!']);
            }
        } else {
            $this->ajaxReturn(['status' => 0, 'info' => '非法访问!']);
        }
    }
    
}