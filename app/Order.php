<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Order extends Model {

    protected $table = 'tb_order';
    protected $guarded = ['id'];
    public  $timestamps = false;

    static public  function isDelete($id){
        return true;
    }

    public function getOrderDetailCount(){
        $cnt = OrderDetail::where("order_id", $this->id)->count();
        return $cnt;
    }

    public function user(){
        return $this->hasOne("App\User", "id", "user_id");
    }

    public function getDashboardOrderCount(){
        $curdate = date("Y-m-d H:i:s");
        $predate1 = getBeforeTime($curdate, 24);
        $predate2 = getBeforeTime($predate1, 24);
        $select = "SELECT COUNT(DISTINCT(a.id)) orderCnt, IFNULL(SUM(price),0) totalPrice FROM tb_order_detail a LEFT JOIN tb_order b ON a.order_id = b.id";
        $sql = $select . " WHERE b.order_time <= '$curdate' AND b.order_time > '{$predate1}'";
        $info = DB::select($sql);
        $curCount = $info[0]->orderCnt;
        $curPrice = $info[0]->totalPrice;

        $sql = $select . " WHERE b.order_time <= '$predate1' AND b.order_time > '{$predate2}'";
        $info = DB::select($sql);
        $preCount = $info[0]->orderCnt;
        $prePrice = $info[0]->totalPrice;
        if($preCount*1 ==0){
            $curCountPro = number_format(($curCount-$preCount));
            $curPricePro = number_format(($curPrice-$prePrice));
        }else{
            $curCountPro = number_format(($curCount-$preCount)*100/$preCount);
            $curPricePro = number_format(($curPrice-$prePrice)*100/$prePrice);    
        }
        
        $ret = array();

        $ret['curCount'] = $curCount;
        $ret['curPrice'] = $curPrice;
        $ret['curCountPro'] = $curCountPro;
        $ret['curPricePro'] = $curPricePro;
        
        return $ret;
    }
    
    public function getRecentlyChartData(){
        $date = date("Y-m-d");
        $ret = array();
        $select = "SELECT COUNT(DISTINCT(a.id)) orderCnt, IFNULL(SUM(price),0) totalPrice FROM tb_order_detail a LEFT JOIN tb_order b ON a.order_id = b.id "; 
        for($i=6; $i>=0; $i--){
            $log_date = getBeforeDay($date, $i);
            $sql = $select." WHERE DATE_FORMAT(b.order_time, '%Y-%m-%d') = '$log_date' ";
            $sql .= " GROUP BY DATE_FORMAT(b.order_time, '%Y-%m-%d') ";
            $info = DB::select($sql);
            $ele = array();
            $ele['y'] = date("m-d", strtotime($log_date));
            if(count($info) ==0){
                $ele['a'] = 0;
                $ele['b'] = 0;
            }else{
                $ele['a'] = $info[0]->orderCnt;
                $ele['b'] = $info[0]->totalPrice;     
            }
            array_push($ret, $ele);
        }
        return $ret;
    }
}
