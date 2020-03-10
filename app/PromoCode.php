<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class PromoCode extends Model {

    protected $table = 'tb_promo_code';
    protected $guarded = ['id'];
    public  $timestamps = false;

    static public  function isDelete($id){
        return true;
    }
    
    
}
