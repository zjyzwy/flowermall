<?php
namespace app\index\controller;
use think\Controller;

class Captcha extends Controller
{
    public function index(){
        return $this->fetch();
    }
}
