<?php


namespace Admin\Controller;

use \Think\Controller;

class LoginController extends Controller
{
    public function _empty()
    {
        $this->redirect('Login/login');
    }
    public function login()
    {
        if (IS_AJAX) {
            $res = D('Admin')->login();
            if ($res['status'] == 1) {
                session('admin', $res['msg']);
                $this->ajaxReturn(['status' => 1, 'msg' => 'success']);
            } else {
                $this->ajaxReturn(['status' => 0, 'msg' => $res['msg']]);
            }
        } else {
            
            $this->display();
        }
    }
    
    public function verify()
    {
        $config = array(
            'fontSize' => 18,    // 验证码字体大小
            'length' => 3,     // 验证码位数
            'useNoise' => false, // 关闭验证码杂点
        );
        $Verify = new \Think\Verify($config);
        $Verify->entry();
    }
    
    public function logout()
    {
        session('admin', null);
        $this->redirect('Login/login');
    }
    
}
