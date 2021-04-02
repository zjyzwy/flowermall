<?php
namespace app\admin\controller;

use think\Controller;
use think\Db;
use app\admin\model\Peisong;
use app\index\model\Myorder;

class Order extends Controller
{
    public function orderlist(){
        if(empty(session('username'))) {
            $this->error('请先登录！','adminlogin/login');
        }
        $peisongs=Peisong::all();
        $this->assign('peisongs',$peisongs);
        $orderlists=array();
        foreach($peisongs as $order){
            $shoplistitems=array();
            $showshoplists=Db::table('showshoplist')->where('orderID',$order->orderID)->order('orderID desc')->select();
            foreach($showshoplists as $shoplist){
                array_push($shoplistitems, $shoplist);
            }
            array_push($orderlists,$shoplistitems);
        }
        $this->assign('orderlists',$orderlists);
        return $this->fetch();
    }
    
    public function send(){
        $orderID = input('post.orderID/d');
        $order=Myorder::get($orderID);
        $order->kddh= input('post.kddh');
        $order->status='已发货';
        $order->cltime=date('Y-m-d H:i:s');
        $order->save();
        $this->redirect('order/orderlist');
    }
    
    public function evaluate(){
        $orderID = input('get.orderID/d');
        $data = Db::table('showshoplist')->where('orderID', $orderID)->select();
        $this->assign('results', $data);
        return $this->fetch();
    }
    
    public function doEvaluate(Request $request){
        $orderID = input('post.orderID/d');
        $datas = Shoplist::where('orderID', $orderID)->select();
        foreach ($datas as $shoplist) {
            $SLID=$shoplist->SLID;
            $shoplist->email = session('email');
            $shoplist->pjstar = $request->param('pjstar'.$SLID);
            $shoplist->pjcontent = $request->param('pjcontent'.$SLID);
            $shoplist->pjip = $request->ip();
            $shoplist->pjtime = date('Y-m-d H:i:s');
            $shoplist->save();
        }
        $order = Myorder::get($shoplist->orderID);
        $order->status = '已评价';
        $order->cltime = date('Y-m-d H:i:s');
        $order->save();
        $this->redirect('order/showorder');
    }
    
}

