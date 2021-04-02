<?php
namespace app\index\controller;

use think\Controller;
use think\Db;

class Login extends Controller{
    public function login(){
        return view();
    }
    
    public function doLogin(){
        //获取表单元素
        $param = input('post.');
        //判断是否输入邮箱
        if(empty(input('post.email'))){
            $this->error('email不能为空');
        }
        //判断是否输入密码
        if(empty(input('post.passw'))){
            $this->error('密码不能为空');
        }
        //查找数据库，看输入的email地址是否存在
        $rs = db('tb_member')->where('email', $param['email'])->find();
        if(empty($rs)){
            $this->error('用户名错误');
        }
        //如果email存在，则判断密码是否匹配
        if($rs['password'] != md5($param['passw'])){
            $this->error('密码错误');
        }
        //如果用户名和密码正确，则将登录的邮箱存入session
        session('email',$rs['email']);
        //跳转到主页
        $this->redirect(url('index/index'));
        
    }
    
    public function logOut(){
        session('email',null);
        $this->redirect(url('index/index'));
    }
}
?>