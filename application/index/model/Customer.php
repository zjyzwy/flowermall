<?php
namespace app\index\model;

use think\Model;

class Customer extends Model
{
    protected $table = 'tb_customer';
    public function member()
    {
        return $this->belongsTo('member');
    }
}

