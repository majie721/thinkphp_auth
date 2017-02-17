<?php

namespace Admin\Controller;

use Think\Controller;
/**
 * Description of CommonController
 *
 * @author Administrator
 */
class CommonController extends Controller{
    public function _initialize(){
        if(!session('?admin')){
            $this->redirect('Login/login'); //登录
        }
      
        
        
        $auth = new \Think\Auth();
        $res = $auth->check( CONTROLLER_NAME.'/'.ACTION_NAME, session('admin')['id']);
        if(!$res){
            $this->error('你没有权限');
        }
    }
    
    
    
}
