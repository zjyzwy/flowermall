<?php
namespace app\index\controller;

use think\Controller;
use think\Db;

class Index extends Controller
{
    public function index()
    {
        $fclass = Db::table('flower')->distinct('true')->field('fclass')->select();
        $this->assign('fclasses',$fclass);
        
        $fname=input('post.fname');
        $fcls=input('post.fclass');
        $minprice = input('post.minprice');
        $maxprice = input('post.maxprice');
        if(empty($maxprice)){
            $maxprice=100000;
        }
        if(empty($minprice)){
            $minprice=0;
        }
        
        $searchstr = 'yourprice between '. $minprice.' and '.$maxprice;
        if(!empty($fcls)){
            $searchstr.=" and fclass='".$fcls ."'";
        }
        if(!empty($fname)){
            $searchstr.=" and fname like '%" . $fname . "%'";
        }
        $result=Db::table('flower')->where($searchstr)->order('SelledNum desc')->select();
        $this->assign('result',$result);
        //$page=$result->render();
        //$this->assign('page',$page);
        return $this->fetch();
    }
    
//     public function showflower(){
//         $data = Db::table('flower')->order('SelledNum','desc')->select();
//         $this->assign('result',$data);
//         return $this->fetch();
//     }

    public function showflower(){
        $data = Db::table('flower')->order('SelledNum','desc')->paginate(5);
        $this->assign('result',$data);
        $page=$data->render();
        $this->assign('page',$page);
        return $this->fetch();
    }
    
    public function flowerdetail(){
        
    }
    
}

