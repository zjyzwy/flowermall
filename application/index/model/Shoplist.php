<?php
namespace app\index\model;

use think\Model;

class Shoplist extends Model
{
    public function showorder(){
        return $this->belongsTo('showorder');
    }
    
}

