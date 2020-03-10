<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class UserBasketPromoCode extends Model {

    protected $table = 'tb_user_basket_promo_code';
    protected $guarded = ['id'];
    public  $timestamps = false;

    static public  function isDelete($id){
        return true;
    }
    
    public function isCheckPromoCode($userId, $codeId){
        $ret = array();
        $promoCode = PromoCode::find($codeId);
        $useCount = UserBasketPromoCode::where("user_id", $userId)->where("promo_code_id",$codeId)->count();
        if($useCount > $promoCode['times_per_user']*1){
            $ret['status'] = 0;
            $ret['msg'] = "You is overhead use";
            return $ret;
        }
        if(date("Y-m-d") > $promoCode['expire_date']){
            $ret['status'] = 0;
            $ret['msg'] = "The period  is over";
            return $ret;
        }
        
        if($promoCode['used_times']*1 >= $promoCode['available_times']){
            $ret['status'] = 0;
            $ret['msg'] = "The coupon do not use because max use is over";
            return $ret;
        }
        
        $ret['status'] = 1;
        return $ret;
        
    }
    
    public function  getPromoCodeInfo(){
        $promo_code_id = $this->promo_code_id;
        $promoCodeInfo = PromoCode::find($promo_code_id);
        if(!isset($promoCodeInfo['id'])){
            return array();
        }
        return $promoCodeInfo;
    }
    
    public function getOffPrice($price){
        $promo_code_id = $this->promo_code_id;
        $promoCodeInfo = PromoCode::find($promo_code_id);
        $ret = 0;
        if(!isset($promoCodeInfo['id'])){
            return $ret;
        }
        
        if($promoCodeInfo['code_type']*1 ==1){
            $ret = number_format($promoCodeInfo['amount_worth']*1);
            return $ret;
        }
        $ret = number_format($price*$promoCodeInfo['amount_worth']/100);
        return $ret;
    }
    
    
}
