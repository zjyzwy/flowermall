<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
class Showflower extends Controller
{
    public function flowerdetail(){
        $flowerID = input('get.flowerID');
        $flower=Flower::get($flowerID);
        $this->assign('flower',$flower);
        $shoplists=Shoplist::where("flowerID='".$flowerID."' and pjstar is not null")->select();
        $this->assign('shoplists',$shoplists);
        return $this->fetch('flowerdetail');
    }
    
}
