<?php

namespace app\index\controller;
use think\Controller;
use think\Db;
use app\index\Controller\Member as MemberModel;

class Member extends Controller{
    
    public function editMember(){
        $email = session('email');
        if(empty($email)){
            $this->error('请先登录!','login/login');
        }
        $mname = input('post.name');
        $mobile = input('post.phone');
        $member = MemberModel::get($email);
        $member->mname=$mname;
        $member->mobile=$mobile;
        $member->save();
    }
    
}
?>
