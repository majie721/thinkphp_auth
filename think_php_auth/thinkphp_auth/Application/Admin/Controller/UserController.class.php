<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Admin\Controller;

/**
 * Description of UserController
 *
 * @author Administrator
 */
class UserController extends CommonController{
    /**
     * 用户信息
     */
    Public function index (){
        $rows = 10; //设置分页,每页显示的条数
        $list = D('User')->getList($rows);
       // dump($list);
        $this->assign('list',$list['list']);
        $this->assign('totalpage',$list['totalpage']);
        $this->display();
    }
    
    public function  edit (){
        if(IS_POST){
            //用户编辑code
        }else{
            $info = D('User')->getInfo();
            $this->assign('info',$info);
            $this->display();
        }
    }
    
    public function excel(){
        //echo '1';
        $xlsData = M('User')->select();
        $xlsName = "用户信息表";
        $xlsCell = array(
            array('phone', '用户'),
            array('registertime', '注册时间'),
            array('lasttime', '最后登陆时间'),
            array('status', '状态'),
            array('grade', '等级'),
            array('referrer', '推荐账号'),
            array('ident', '认证状态'),
        );
        foreach ($xlsData as $v=>$k ){
            $xlsData[$v]['registertime'] = date('Y-m-d',$k['registertime']);
            if($k['lasttime']==''){
              $xlsData[$v]['lasttime'] = '未登录';  
            }else{
               $xlsData[$v]['lasttime'] = date('Y-m-d',$k['lasttime']); 
            }
             $xlsData[$v]['status'] = $v['status']==1?'正常':'禁用';
             $xlsData[$v]['ident'] = $v['ident']==1?'已认证':'未认证';
        }
        exportExcel($xlsName, $xlsCell, $xlsData);
    }
    
}
