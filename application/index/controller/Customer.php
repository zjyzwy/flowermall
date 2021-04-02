<?php
namespace app\index\controller;

use think\Controller;
use think\Db;
use app\index\model\Customer as CustomerModel;

class Customer extends Controller
{

    public function addCustomer()
    {
        $email = session('email');
        $sname = input('post.addName');
        $mobile = input('post.addPhone');
        $address = input('post.address');
        $newcustomer = new CustomerModel();
        $newcustomer->email = $email;
        if (! empty($sname)) {
            $newcustomer->sname = $sname;
        }
        if (! empty($mobile)) {
            $newcustomer->mobile = $mobile;
        }
        if (! empty($address)) {
            $newcustomer->address = $address;
        }
        $customers = CustomerModel::where('email', $email)->select();
        if (! empty($customers)) {
            $newcustomer->cdefault = '0';
        } else {
            $newcustomer->cdefault = '1';
        }
        $newcustomer->save();
        $search = "sname='" . $sname . "' and email='" . $email . "' and mobile='" . $mobile . "' and address='" . $address . "'";
        $customer = CustomerModel::where($search)->find();
        return $customer->custID;
    }

    public function editCustomer(){
        $custID = input('post.custID');
        $sname = input('post.addName');
        $mobile = input('post.addPhone');
        $address = input('post.address');
        
        $cust = CustomerModel::get($custID);
        if (!empty($sname)) {
            $cust->sname = $sname;
        }
        if (! empty($mobile)) {
            $cust->mobile = $mobile;
        }
        if (! empty($address)) {
            $cust->address = $address;
        }
        $cust->save();
        return 'success';
        
    }

    public function deleteCustomer(){
        $custID = input('post.custID');
        $customer = CustomerModel::get($custID);
        if($customer){
            $customer->delete();
            return 'success';
        }
        
    }

    public function setDefault(){
        $custID = input('post.custID');
        $originalID = input('post.originalID/d');
        $oldDefault = CustomerModel::get($originalID);
        
        $oldDefault->cdefault = '0';
        $oldDefault->save();
        
        $newDefault = CustomerModel::get($custID);
        $newDefault->cdefault = '1';
        $newDefault->save();
        
        return 'success';
    }
}

?>
