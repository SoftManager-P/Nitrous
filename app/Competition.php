<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Sentinel;

class Competition extends Model {

    protected $table = 'tb_competition';
    protected $guarded = ['id'];
    public  $timestamps = true;

    static public  function isDelete($id){
        $cnt = OrderDetail::where("competition_id", $id)->count();
        $ret = array();
        if($cnt>0){
            $ret['result'] = 0;
            $ret['msg'] = "While exist order information You can not delete competition";    
        }else{
            $ret['result'] = 1;
        }
        return $ret;
    }
    
    public function selectRandTicket($cnt, $competition_id,$picket_tickets){
        $user = Sentinel::getUser();
        $picket_tickets_a = explode(",",$picket_tickets);
        if($picket_tickets == ""){
            $picket_tickets_a = array();
        }
        if(!$user){
            $ret = array();
            $ret['status'] = "-1";
            return $ret;
        }
        $userId = $user['id'];
        $competitionInfo = Competition::find($competition_id);
        if(!isset($competitionInfo['id'])){
            $ret = array();
            $ret['status'] = "0";
            $ret['msg'] = "The competiotion information is incorrect";
            return $ret;
        }
        $max_per_user = $competitionInfo['max_per_user'];
        $ready_count = CompetitionTicket::where("selected_user_id", $userId)->where("status", "2")->where("competition_id", $competition_id)->count();
        $ready_count += count($picket_tickets_a);
        $avail_count = CompetitionTicket::where("status", "0")->whereRaw("!FIND_IN_SET(id,'{$picket_tickets}')")->where("competition_id", $competition_id)->count();
        
        if($ready_count > $max_per_user*1){
            $ret = array();
            $ret['status'] = "0";
            $ret['msg'] = "You can not selected because you ready have selected max tickets counts";
            return $ret;
        }
        if($cnt + $ready_count > $max_per_user){
            $ret = array();
            $ret['status'] = "0";
            $cnt1 = $max_per_user-$ready_count;
            $ret['msg'] = "You can  selected while you ready have selected {$cnt1} tickets counts";
            return $ret;
        }
        if($cnt > $avail_count){
            $ret = array();
            $ret['status'] = "0";
            $ret['msg'] = "The competition remaining tickets number is {$avail_count}. You can  selected while you ready have selected {($avail_count)} tickets counts";
            return $ret;
        }
        
        $availTicketList = CompetitionTicket::where("competition_id", $competition_id)->where("status", "0")->get();
        $sel_tickets = array();
        $sel_tickets_ids= array();
        while(count($sel_tickets) < $cnt){
            $total_cnt = count($availTicketList);
            $rnd = rand(0,$total_cnt-1);
            $is_exist = false;
            foreach($sel_tickets_ids as $item){
                if($item == $rnd){
                    $is_exist = true;
                }
            }
            if(!$is_exist){
                array_push($sel_tickets, $availTicketList[$rnd]['id']);
                array_push($sel_tickets_ids,$rnd);
            }
        }
        
        $ret = array();
        $ret['status'] = "1";
        $ret['rndIds'] = implode(",", $sel_tickets);
        return $ret;
          
    }
    
    public function competitionDelete($id){
        $info = Competition::find($id);
        if(!isset($info['id'])){
            return;
        }
        $file_name = str_replace(" ", "_",$info['name'])."_".date("Y_m_d");
        //mkdir("uploads/del_competition");
        $text_file_content = $this->genTextFileContents($id);
        $text_file_path = $file_name.".txt";
        file_put_contents($text_file_path, print_r($text_file_content,1));
        $path_name = "uploads/del_competition/".$file_name.".zip";
        $this->createFileZip($path_name, $id, $text_file_path);
        
        Competition::where("id", $id)->delete();
        CompetitionImg::where("competition_id", $id)->delete();
        CompetitionTicket::where("competition_id", $id)->delete();
        CompetitionAnswer::where("competition_id", $id)->delete();
        
    }

    public function createFileZip($path_name, $id, $text_path){
        $zip_name = $path_name;
        $zip = new \ZipArchive();
        $zip->open($zip_name, \ZipArchive::CREATE);
        $del_file_a = array();
        array_push($del_file_a, $text_path);
        $zip->addFile($text_path);
        $info = Competition::find($id);
        if($info['main_image'] != ''){
            $info['main_image']  = str_replace("/uploads", "uploads",$info['main_image']  );
            //copy($info['main_image'], basename($info['main_image']));
            rename($info['main_image'], basename($info['main_image']));
            $zip->addFile(basename($info['main_image']));
            array_push($del_file_a, basename($info['main_image']));
        }
        if($info['photo'] != ''){
            //copy($info['photo'], basename($info['photo']));
            $info['photo']  = str_replace("/uploads", "uploads",$info['photo'] );
            rename($info['photo'], basename($info['photo']));
            $zip->addFile(basename($info['main_image']));
            array_push($del_file_a,basename($info['main_image']));
        }
        $imgList = CompetitionImg::where("competition_id", $id)->orderBy("order_num")->get();
        foreach($imgList as $img){
            
            rename($img['img'], basename($img['img']));
            //copy($img['img'], basename($img['img']));
            $zip->addFile(basename($img['img']));
            array_push($del_file_a, basename($img['img']));
        }
        
        $answerList = CompetitionAnswer::where("competition_id", $id)->get();
        foreach($answerList as $answer){
            if($answer['answer_type']*1 == 1){
                $answer['answer']  = str_replace("/uploads", "uploads",$answer['answer']);
                rename($answer['answer'], basename($answer['answer']));
                $zip->addFile(basename($answer['answer']));
                array_push($del_file_a, basename($answer['answer']));
            }
        }
        $zip->close();
        
        foreach($del_file_a as $item){
            unlink($item);
        }
        /*$headers = array('Content-Type'        => 'application/zip',
            'Content-Disposition' => 'attachment; filename="' .$zip_name. '"');
        return response()->download(public_path($zip_name), $zip_name, $headers);*/
    }
    
    
    public function genTextFileContents($id){
        $ret = "Competition Information";
        $info = Competition::find($id);
        $info_a = $info->attributesToArray();
        foreach ($info_a as $key=>$val){
            $ret .= "\r\n".$key.":".$val." ";    
        }
        $ret .= "\r\n";
        $ret .= "\r\n";
        $ret .= "Competition Answer Information";
        $list = CompetitionAnswer::where("competition_id", $id)->orderBy("id")->get();
        foreach($list as $info){
            $ele = "type:".($info['answer_type']*1==0?"text":"image")."  answer:".$info['answer']." is_true:".($info['is_true']*1==1? "TRUE":"FALSE");
            $ret.= "\r\n".$ele;
        }
        
        return $ret;
    }
    
    
    
    
    
    public function getDashboardCompetitionCount(){
        $curdate = date("Y-m-d H:i:s");
        $predate1 = getBeforeTime($curdate, 24);
        $predate2 = getBeforeTime($predate1, 24);
        $select = "SELECT COUNT(id) cnt FROM tb_competition ";
        $sql = $select . " WHERE created_at <= '$curdate' AND created_at > '{$predate1}'";
        $info = DB::select($sql);
        $curCount = $info[0]->cnt;

        $sql = $select . " WHERE created_at <= '$predate1' AND created_at > '{$predate2}'";
        $info = DB::select($sql);
        $preCount = $info[0]->cnt;
        
        if($preCount*1 >0){
            $curCountPro = number_format(($curCount-$preCount)*100/$preCount);   
        }else{
            $curCountPro = number_format(($curCount-$preCount));    
        }
        
        $ret = array();
        
        $ret['curCount'] = $curCount;
        $ret['curCountPro'] = $curCountPro;
        
        return $ret;
    }
    
    public function getDashboardActiveList(){
        $where = "1=1";
        $list = $this->whereRaw($where)->orderBy("id", "desc")->get();
        return $list;
    }

    public function getSoldCount(){
        return CompetitionTicket::where(array("status"=>2,'competition_id'=>$this->id))->count();
    }
    
    public function getRemainCount(){
        $soldCount = $this->getSoldCount();
        return $this->total_num - $soldCount > 0 ? $this->total_num - $soldCount : 0; 
    }
    
    public function getSoldPro(){
        $soldCount = $this->getSoldCount();
        $ret = number_format($soldCount*100/$this->total_num);
        return $ret;
    }
    
    public function anwers(){
        return $this->hasMany('App\CompetitionAnswer', 'competition_id', 'id');
    } 
    
    public function getPurchasedTicketList(){
        return OrderDetail::where("competition_id", $this->id)->get();
    }
    
    public static function isAvailSelectTicket($ticket_id){
        $ret = array();
        $ret['status'] = "1";
        $info = OrderDetail::where("ticket_id", $ticket_id)->first();
        if(isset($info['id'])){
            $ret['status'] = "0";
            $ret['msg'] = 'this ticket has selected with another';
            return $ret;
        }
        $user = Sentinel::getUser();
        $user_id = $user['id'];
        $info = UserBasket::where("ticket_id", $ticket_id)->first();
        
        if(isset($info['id'])){
            if($user_id != $info['user_id']){
                $ret['status'] = "0";
                $ret['msg'] = 'this ticket has selected with another';
                return $ret;    
            }
        }
        return $ret;
    }
}
