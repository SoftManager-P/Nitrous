<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class OrderDetail extends Model {

    protected $table = 'tb_order_detail';
    protected $guarded = ['id'];
    public  $timestamps = false;

    static public  function isDelete($id){
        return true;
    }

    public function order() {
        return $this->hasOne('App\Order', 'id', 'order_id');
    }
    
    public function competition(){
        return $this->hasOne('App\Competition', 'id', 'competition_id');
    }
    public function ticket(){
        return $this->hasOne('App\CompetitionTicket', 'id', 'ticket_id');
    }
    
    public function orderDetailList($orderId){
        $select = "GROUP_CONCAT(ticket_id) tickets ,competition_id";
        $list = OrderDetail::where("order_id", $orderId)->groupBy("competition_id")->orderBy("competition_id")->select(DB::raw($select))->get();
        $ret = array();
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
            }
        }
        
        return $ret;
    }
    
    
}
