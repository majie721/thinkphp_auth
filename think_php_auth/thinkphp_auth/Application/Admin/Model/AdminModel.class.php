<?php

namespace Admin\Model;

use Think\Model;

/**
 * Description of AdminModel
 *
 * @author Administrator
 */
class AdminModel extends Model {
    public  function login (){
       $res = $this->check_verify(I('post.vercode')); 
       if(!$res){
           return ['status'=>0,'msg'=>'验证码错误'];
       }
       $res = $this->where(['adminname'=>I('post.username'),'status'=>1])->find();
       if($res['passwd'] == md5(I('post.passwd'))){
           $this->where(['adminname'=>I('post.username'),'status'=>1])->save(['lasttime'=>time()]);
           return ['status'=>1,'msg'=>$res];
       }else{
           return ['status'=>0,'msg'=>'用户或者密码错误'];
       }
    }
    
    function check_verify($code, $id = ''){
        $verify = new \Think\Verify();
        return $verify->check($code, $id);
    }
    
    public function getInfo (){
        $res = $this->where(['id'=>I('id')])->find();
        $group = M('ThinkAuthGroupAccess')->join('LEFT JOIN y_think_auth_group  on y_think_auth_group_access.group_id = y_think_auth_group.id ')->where(['uid'=>I('id'),'status'=>1])->field('id,title')->find();
        if(!$group['id']){
           $res['groupid']=null;
           $res['grouptitle']='未分配';
        }
        return $res;
    }
    
    public function edit (){
        $map = I('post.');
        if(!$map['passwd']){
            unset($map['passwd']);
        }
        $this->save($map);
        if($map['group_id']){
        $res = M('ThinkAuthGroupAccess')->where(['uid'=>$map['id']])->find();
            $gmap['group_id'] = $map['group_id'];
            $gmap['uid'] = $map['id'];
            if($res){
                $res1 = M('ThinkAuthGroupAccess')->where(['uid'=>$map['id']])->save($gmap);
            }else{
                $res1 = M('ThinkAuthGroupAccess')->add($gmap);
            }
            if($res1){
                return 1;
            }else{
                return 0;
            }
        }else{
            return 1;
        }
    }
    
    public function adminadd () {
        $map = I('post.');
        $res = $this->where(['adminname'=>$map['adminname']])->find();
        if($res){
            return '该用户名已经存在';
        }
        
        if(!$map['passwd']) {
            return '密码不能为空';
        }
        
        $map['passwd'] = md5($map['passwd']);
        $this->add($map);
        if($map['group_id']){
            $gmap['group_id'] = $map['group_id'];
            $gmap['uid'] = $map['id'];
            $res1 = M('ThinkAuthGroupAccess')->add($gmap);
        }
        return 1;
    }
    
    public function groupadd () {
        $map = I('post.');
        if(!$map['title']) {
            return '权限组名不能为空';
        }
        $res = M('ThinkAuthGroup')->where(['title'=>$map['title']])->find();
        if($res){
            return '该用权限组已经存在'.$res;
        }
        
        if(M('ThinkAuthGroup')->add($map)){
            return 1;
        }else{
            return '服务器error';
        }
    }
    
    public function groupedit () {
        $map = I('post.');
        if(!$map['title']) {
            return '权限组名不能为空';
        }
        //dump($map);die();
        if(M('ThinkAuthGroup')->save($map)){
            return 1;
        }else{
            $res = M('ThinkAuthGroup')->getLastSql();
            return '服务器error'.$res;
        }
    }
    
    /**
     * @param $rows 分页每页显示的条数
     * @return array
     */
    public  function getRules ($rows) {
        if(''!==(I('title'))){
            $map['title'] = ['like','%'.I('title').'%'];
        }
        $nowpage=I('page',1);
        $totalpage = ceil((M('ThinkAuthRule')->where($map)->count())/$rows);
        $data =  M('ThinkAuthRule')->where($map)->limit(($nowpage-1)*$rows,$rows)->select();
        $list = [];
        foreach ($data as $k => $v) {
            $list[$v['mudel']][] = $v;
        }
        return ['totalpage'=>$totalpage,'list'=>$list];
    }
    
    public function ruleadd () {
        $map = I('post.');
        if(!$map['title']) {
            return '节点名不能为空';
        }
        if(!$map['name']) {
            return '节点不能为空';
        }
        if(!($map['mudel']||$map['mselect'])) {
            return '模块名不能为空';
        }
        $res = M('ThinkAuthRule')->where(['title'=>$map['title']])->find();
        if($res){
            return '该节点名已经存在';
        }
        $res = M('ThinkAuthRule')->where(['name'=>$map['name']])->find();
        if($res){
            return '该节点已经存在'.$res;
        }
        if($map['mselect']){
            $map['mudel'] = $map['mselect'];
        }
        
        if(M('ThinkAuthRule')->add($map)){
            return 1;
        }else{
            return '服务器error';
        }
    }
    
    /**
     * @return int|string
     */
    public function ruledit (){
        $map = I('post.');
        $data = M('ThinkAuthRule')->select();
        if ($data) {
            $array = [];
            foreach ($data as $k => $v) {
                $array[] = $v['mudel'];
            }
            $array = array_unique($array);
        }
        if(in_array($map['mudel'],$array)){
            $map['mudel'] = $map['mradio'];
        }
       // dump($map);die();
        $res = M('ThinkAuthRule')->save($map);
        if($res){
            return 1;
        }else{
            return '服务器error'.M('ThinkAuthRule')->getLastSql();
        }
    }
}
