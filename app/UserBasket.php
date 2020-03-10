<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Sentinel;
use DB;

class UserBasket extends Model {

    protected $table = 'tb_user_basket';
    protected $guarded = ['id'];
    public  $timestamps = false;

    static public  function isDelete($id){
        return true;
    }

    public function insertBasket($user_id, $competition_id, $tickets, $date){
        $tickets_a = explode(",", $tickets);
        $is_fail_ids = "";
        $where = array();
        $where['user_id'] = $user_id;
        $where['competition_id'] = $competition_id;
        
        $old_buskect_list = UserBasket::where($where)->get();
        foreach($old_buskect_list as $item){
            $ticket_id = $item['ticket_id'];
            $ticketInfo = CompetitionTicket::find($ticket_id);
            if(isset($ticketInfo['id'])){
                $ticketInfo['status'] = 0;
                $ticketInfo['seleted_time'] = "0000-00-00 00:00:00";
                $ticketInfo['selected_user_id'] = "0";
                $ticketInfo['is_winner'] = "0";
                $ticketInfo->save();
            }
            $item->delete();
        }
	
        
        foreach($tickets_a as $ticket){
            $cnt1 = $this->where("ticket_id", $ticket)->count();
            $cnt2 = OrderDetail::where("ticket_id", $ticket)->count();
            if($cnt1 > 0 || $cnt2 > 0){
                $is_fail_ids .= ("" == $is_fail_ids?"":",").$ticket;
            }
            
            if($cnt1 == 0 && $cnt2 == 0){
                $busket = new UserBasket();
                $busket['user_id'] = $user_id;
                $busket['competition_id'] = $competition_id;
                $busket['ticket_id'] = $ticket;
                $busket['immeditaly_type'] = "0";
                $busket['create_date'] = $date;
                $busket->save();
                $competitionTicket = CompetitionTicket::find($ticket);
                if(isset($competitionTicket['id'])){
                    $competitionTicket['status'] = 1;
                    $competitionTicket['selected_user_id'] = $user_id;
                    $competitionTicket['seleted_time'] = $date;
                    $competitionTicket->save();
                }
            }
        }
        
        if($is_fail_ids != "" && count(explode(",",$is_fail_ids))==count($tickets_a)){
            $ret = array();
            $ret['status'] = "0";
            $ret['msg'] = "You buy your selected tickets while another has buy, Please waiting minutes try again!";
            return $ret;
        }
        
        if($is_fail_ids != ""){
            $ret = array();
            $ret['status'] = "1";
            $ret['msg'] = "If you wanted some tickets is missed, please check in checkout page, therefore pay! ";
            return $ret;
        }
        
        $ret = array();
        $ret['status'] = "1";
        $ret['msg'] = "The operation is successfully !";
        return $ret;
    }
    
    public function getUserBasketList($user_id){
        $select = "GROUP_CONCAT(ticket_id) tickets ,competition_id, DATE_ADD(MIN(create_date),INTERVAL 5 MINUTE) min_create_date, MAX(create_date) max_create_date";
        $list = $this->where("user_id", $user_id)->groupBy("competition_id")->orderBy("competition_id")->select(DB::raw($select))->get();
        $ret = array();
        //$min_date = "";
        $max_date = "";
        foreach($list as $item){
            $competition = Competition::find($item->competition_id);
            if(!isset($competition['id'])){
                continue;
            }
            $tickets = $item['tickets'];
            if($tickets == ""){
                continue;
            }
            $competitionTicketModel = new CompetitionTicket();
            $where = "FIND_IN_SET(id, '{$tickets}')";
            $select = "GROUP_CONCAT(ticket_no) ticketsNo ";
            $ticket = $competitionTicketModel->whereRaw($where)->select(DB::raw($select))->first();
            if(isset($ticket->ticketsNo)){
                $competition['ticketNo'] =  $ticket->ticketsNo;
                array_push($ret,$competition);
                /*if($min_date==""){
                    $min_date = $item->min_create_date;
                }else{
                    if($min_date > $item->min_create_date){
                        $min_date = $item->min_create_date;
                    }
                }*/

                if($max_date==""){
                    $max_date = $item->max_create_date;
                }else{
                    if($max_date < $item->max_create_date){
                        $max_date = $item->max_create_date;
                    }
                }
                
            }
        }
        $result = array();
        $result['list'] = $ret;
        //$result['min_date'] = $min_date;
        if($max_date == ""){
            $result['diff'] = "";
        }else{
            $diff = (strtotime(date("Y-m-d H:i:s")) - strtotime($max_date));
            $result['diff'] = 5*60-$diff;    
        }
        
        return $result;
        
    }
    
    public function createOrder($user_id, $otherInfo = array()){

        $user = Sentinel::getUser();
        $total_price = $this->getBusketTotalPrice($user_id);
        if($total_price*1 == 0){
            $ret = array();
            $ret['status'] = "0";
            $ret['msg'] = "Basket information incorrect!, please you check";
            return $ret;
        }
        $order_number = newOrderNo($user_id);
        $order = new Order();
        $order['user_id'] = $user_id;
        $order['order_number'] = $order_number;
        $order['total_price'] = $total_price;
        $order['first_name'] = isset($otherInfo['first_name'])?$otherInfo['first_name']:"";
        $order['last_name'] = isset($otherInfo['last_name'])?$otherInfo['last_name']:"";
        $order['user_name'] = isset($otherInfo['user_name'])?$otherInfo['user_name']:$order['first_name'].' '.$order['last_name'];
        $order['address'] = isset($otherInfo['address'])?$otherInfo['address']:"";
        $order['address1'] = isset($otherInfo['address1'])?$otherInfo['address1']:"";
        $order['address2'] = isset($otherInfo['address2'])?$otherInfo['address2']:"";
        $order['city'] = isset($otherInfo['city'])?$otherInfo['city']:"";
        $order['postcode'] = isset($otherInfo['postcode'])?$otherInfo['postcode']:"";
        $order['country'] = isset($otherInfo['country'])?$otherInfo['country']:"";
        $order['county'] = isset($otherInfo['county'])?$otherInfo['county']:"";
        $order['phone'] = isset($otherInfo['phone'])?$otherInfo['phone']:"";
        $order_time = date("Y-m-d H:i:s");
        $order['order_time'] = $order_time;
        $order['status'] = "0";
        
        $userBasketPromoCode = UserBasketPromoCode::where("user_id", $user_id)->first();
        $order['diff_price'] = 0;
        $order['real_price'] = $total_price;
        if(isset($userBasketPromoCode['id'])){
            $order['diff_price'] = $userBasketPromoCode->getOffPrice($total_price);
            $order['real_price'] -= $order['diff_price'];
        }
        
        UserBasketPromoCode::where("user_id", $user_id)->delete();
        
        $order->save();

        $ret = array();
        $ret['status'] = "1";
        $ret['msg'] = "The operation is successful";
        $ret['order_info'] = $order;
        
//        $userBasket = new UserBasket();
//        $userBasket->where("user_id",$user_id)->delete();
        return $ret;
    }
    
    
    public function getBusketTotalPrice($user_id){
        $userBasketModel = new UserBasket();
        $select = "GROUP_CONCAT(ticket_id) tickets ,competition_id, DATE_ADD(MIN(create_date),INTERVAL 5 MINUTE) min_create_date";
        $list = $userBasketModel->where("user_id", $user_id)->groupBy("competition_id")->orderBy("competition_id")->select(DB::raw($select))->get();
        $total_price = 0;
        foreach($list as $item){
            $competition = Competition::find($item->competition_id);
            if(!isset($competition['id'])){
                continue;
            }
            $elePrice = $competition['price'];
            $tickets = $item['tickets'];
            if($tickets == ""){
                continue;
            }
            $competitionTicketModel = new CompetitionTicket();
            $where = "FIND_IN_SET(id, '{$tickets}')";
            $select = "GROUP_CONCAT(ticket_no) ticketsNo ";
            $ticket = $competitionTicketModel->whereRaw($where)->select(DB::raw($select))->first();
            if(isset($ticket->ticketsNo)){
                $total_price += $elePrice*count(explode(",",$ticket->ticketsNo));
            }
        }
        return $total_price;
    }

    
}
