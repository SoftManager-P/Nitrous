<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompetitionTicket extends Model {

    protected $table = 'tb_competition_ticket';
    protected $guarded = ['id'];
    public  $timestamps = false;

    static public  function isDelete($id){
        return true;
    }

    public function genTickets($competition_id, $num =1){
        for($i=1 ; $i <= $num; $i++){
            $info = new CompetitionTicket();
            $info['competition_id'] = $competition_id;
            $info['ticket_no'] = $i;
            $info['status'] = '0';
            $info->save();
        }
    }

    public function order_detail() {
        return $this->hasOne('App\OrderDetail', 'ticket_id', 'id');
    }
    
    
   
}
