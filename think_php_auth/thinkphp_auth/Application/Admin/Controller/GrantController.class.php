<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Admin\Controller;

use Think\Controller;

/**
 * 权限管理(管理员增删改查及权限的分配)
 *
 * @author Martain
 */
class GrantController extends CommonController
{
    
    /**
     * 管理员列表
     */
    public function adminInfo()
    {
        $info = M('Admin as a')->join('LEFT JOIN y_think_auth_group_access as b on a.id=b.uid')->join('LEFT JOIN y_think_auth_group as c on b.group_id=c.id')
        ->field("a.adminname,a.id,lasttime,a.status,title")->select();
        //dump($info);die();
        foreach ($info as $k => $v) {
            $info[$k]['lasttime'] = date('Y-m-d H:i:s', $v['lasttime']);
        }
        $this->assign('list', $info);
        $this->display();
    }
    
    public function adminEdit()
    {
        if (IS_AJAX) {
            $info = D('Admin')->edit();
            $this->ajaxReturn($info);
        } else {
            $info = D('Admin')->getInfo();
            $options = M('ThinkAuthGroup')->where(['status' => 1])->field('id,title')->select();
            if ($options) {
                $this->assign('options', $options);
            }
            $this->assign('info', $info);
            $this->display();
        }
    }
    
    public function adminAdd()
    {
        if (IS_AJAX) {
            $info = D('Admin')->adminAdd();
            $this->ajaxReturn($info);
        } else {
            $options = M('ThinkAuthGroup')->where(['status' => 1])->field('id,title')->select();
            if ($options) {
                $this->assign('options', $options);
            }
            $this->display();
        }
    }
    
    /**
     * 用户组列表
     */
    public function group()
    {
        if (IS_AJAX) {
            
        } else {
            $list = M('ThinkAuthGroup')->select();
//            $title = M('ThinkAuthRule')->getField('id,title');
//            foreach ($list as $k => $v){
//                $list[$k]['rules'] = explode(',', $v['rules']);
//                foreach ( $list[$k]['rules'] as $key => $val){
//                   $list[$k]['rules'][$key] = $title[$val];
//                }
//            }
            $this->assign('list', $list);
            $this->display();
        }
    }
    
    public function groupAdd()
    {
        if (IS_AJAX) {
            $info = D('Admin')->groupadd();
            $this->ajaxReturn($info);
        } else {
            $data = M('ThinkAuthRule')->field('id,title,mudel')->select();
            $list = [];
            foreach ($data as $k => $v) {
                $list[$v['mudel']][] = $v;
            }
            $this->assign('data', $list);
            $this->display();
        }
    }
    
    public function groupEdit()
    {
        if (IS_AJAX) {
            $info = D('Admin')->groupedit();
            $this->ajaxReturn($info);
        } else {
            $res = M('ThinkAuthGroup')->where(['id' => I('id')])->find();
            $res['rules'] = explode(',', $res['rules']);
            $data = M('ThinkAuthRule')->field('id,title,mudel')->select();
            $list = [];
            foreach ($data as $k => $v) {
                $list[$v['mudel']][] = $v;
            }
            $this->assign('info', $res);
            $this->assign('data', $list);
            $this->display();
        }
    }
    
    public function groupDel()
    {
        if (IS_AJAX) {
            $res = M('ThinkAuthGroup')->where(['id' => I('id')])->delete();
            $res1 = M('ThinkAuthGroupAccess')->where(['group_id'=>I('id')])->delete();
            if ($res&&$res1) {
                $this->ajaxReturn(1);
            } else {
                $this->ajaxReturn('删除失败,刷新再试!');
            }
        } else {
        }
    }
    
    
    /**
     * 权限列表
     */
    public function rules()
    {
        $res = D('Admin')->getRules(15);
         //dump($res);die();
        $this->assign('totalpage', $res['totalpage']);
        $this->assign('data', $res['list']);
        $this->display();
    }
    
    public function rulesAdd()
    {
        if (IS_AJAX) {
            $info = D('Admin')->ruleadd();
            $this->ajaxReturn($info);
        } else {
            $data = M('ThinkAuthRule')->field('mudel')->select();
            if ($data) {
                $array = [];
                foreach ($data as $k => $v) {
                    $array[] = $v['mudel'];
                }
            //   dump(array_unique( array_unique($array)));
                $this->assign('options', array_unique($array));
            }
            $this->display();
        }
    }
    
    public function rulesEdit()
    {
        if (IS_AJAX) {
            $info = D('Admin')->ruledit();
            $this->ajaxReturn($info);
        } else {
            $info = M('ThinkAuthRule')->where(['id'=>I('id')])->find();
            $data = M('ThinkAuthRule')->select();
            if ($data) {
                $array = [];
                foreach ($data as $k => $v) {
                    $array[] = $v['mudel'];
                }
                $this->assign('options', array_unique($array));
            }
            $this->assign('info',$info);
            //dump( array_unique($array));
            $this->display();
        }
    }
    
    public function ruleDel()
    {
        if (IS_AJAX) {
            $res = M('ThinkAuthRule')->where(['id' => I('id')])->delete();
            if ($res) {
                $this->ajaxReturn(1);
            } else {
                $this->ajaxReturn('删除失败,刷新再试!');
            }
        } else {
        }
    }
    
    
}
