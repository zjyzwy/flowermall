<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
class Cart extends Controller
{

    public function index()
    {
        if (empty(session('email'))) {
            $this->error('请先登录!', 'login/login');
        }
        $data = Db::table('vcart')->where('email', session('email'))->select();
        
        $this->assign('result', $data);
        return $this->fetch();
    }
    
    public function addCart()
    {
        //判断是否登录（获取登录的session信息，并判断是否为empty）
        $param = input('get.');
        if (empty(session('email'))) {
            $this->error('请先登录!', 'login/login');
        }
        
        //判断是否选择商品
        if(empty('get.flowerID')){
            $this->error('请选择商品!', 'index/index');
        }
        //判断购物车是否存放了该用户所选的商品，如果不存在，则将该商品放入购物车,如果存在，则把原来数量加1
        $data = Db::table('cart')->where('email', session('email'))
            ->where('flowerID', $param['flowerID'])
            ->find();
        // $data = Db::table('cart')->where("email='".session('email')."' and flowerID='".$param['flowerID']."'")->find();
        if (empty($data)) {
            $result = Db::execute("insert into cart(cartID,email,flowerID,num) values(null,'" . session('email') . "','" . $param['flowerID'] . "',1)");
            //dump($result);
        } else {
            $result = Db::execute("update cart set num=num+1 where email='" . session('email') . "' and flowerID='" . $param['flowerID'] . "'");
            //dump($result);
        }
        // 跳转
        $this->redirect(url('cart/index'));
        
    }
    
    public function clearCart(){
        $result=Db::execute("delete from cart where email='" .session('email'). "'");
        $this->redirect(url('cart/index'));
    }
    
    public function deleteCart(){
        $param = input('get.');
        $result=Db::execute("delete from cart where cartID=".$param['cartID']);
        $this->redirect(url('cart/index'));
    }
    
    public function updateCart(){
        $param = input('get.');
        $result=Db::execute("update cart set num=".$param['num']." where cartID=".$param['cartID']);
        $this->redirect(url('cart/index'));
    }
}

?>