<?php namespace App\Http\Controllers\Front;

use App\Competition;
use App\CompetitionAnswer;
use App\CompetitionImg;
use App\CompetitionTicket;
use\App\Http\Controllers\JoshController;
use App\Http\Requests\ConfirmPasswordRequest;
use App\UserBasket;
use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Mail;
use Reminder;
use Sentinel;
use URL;
use Validator;
use View;
use App\Http\Requests\UserRequest;
use App\Http\Requests\ForgotRequest;
use stdClass;
use App\Mail\ForgotPassword;

use App\Product;
use App\ProductCategory;
use App\Brand;
use App\Banner;
use App\Jobs\ReleaseTickets;
use DB;
use Yajra\DataTables\DataTables;

class CompetitionController extends JoshController
{
    
    public function __construct()
    {
        parent::__construct();
        
    }
    public function index(){
        $sortKey = $this->getParam("sortKey", "");
        view()->share("sortKey", $sortKey);
        $perPageSize = $this->getParam("perPageSize", "20");
        $pageParam = $this->getPageParam($perPageSize*1);
        $model = new Competition();
        $model = $model->where("status", "0");
        switch($sortKey){
            case "name":
                $model = $model->orderBy("name");
                break;
            case "price":
                $model = $model->orderBy("price", "DESC");
                break;
            case "remain":
                $model = $model->orderByRaw("getCompetitionRemainCount(id)");
                break;    
            default:
                $model = $model->orderBy("id", "DESC");        
                break;
        }
        
        
        $count = $model->count();
        $list = $model->skip($pageParam["start"])->take($pageParam["perPageSize"])->get();
        $pageParam = $this->setPageParam($pageParam, $count, url("live-competitions"),"sortKey={$sortKey}");
        view()->share('pageInfo', $pageParam);
        view()->share("list", $list);
        $this->getDiffVal();
        return view("front/live-competitions");
    }
    
    public function info($id, Request $request){
        $info = Competition::find($id);
        if(!isset($info['id'])){
            return redirect("admin/404");
        }
        
        $imgList = CompetitionImg::where("competition_id", $id)->orderBy("order_num")->get();
        view()->share("imgList", $imgList);
        view()->share("info", $info);
        $ticketList = CompetitionTicket::where("competition_id", $id)->orderBy("id")->get();
        view()->share("ticketList", $ticketList);
        $availTicketList = CompetitionTicket::where("competition_id", $id)->whereRaw("status = 0")->orderBy("id")->get();
        view()->share("availTicketList", $availTicketList);
        $user_id = 0;
        $user = Sentinel::getUser(); 
        if($user){
            $user_id = $user['id'];
        }
        
        $cartTicketList = CompetitionTicket::where("selected_user_id", $user_id)->whereRaw("FIND_IN_SET(status, '1')")->where("competition_id", $id)->orderBy("ticket_no")->get();
        view()->share("cartTicketList", $cartTicketList);
        $ready_ticket_count = CompetitionTicket::where("selected_user_id", $user_id)->whereRaw("FIND_IN_SET(status, '1,2')")->where("competition_id", $id)->count();
        $sold_ticket_count = CompetitionTicket::where("selected_user_id", $user_id)->whereRaw("FIND_IN_SET(status, '2')")->where("competition_id", $id)->count();
        view()->share("ready_ticket_count",$ready_ticket_count);
        view()->share("sold_ticket_count",$sold_ticket_count);
        $this->getDiffVal();
        return view("front.competition-page");
        
    }
    
    public function ajaxSelectRandTicket(){
        $cnt = $this->getParam("cnt", "1");
        $competition_id = $this->getParam("competition_id", "0");
        $picket_tickets = $this->getParam("picketTickets", "");
        $competiotion_model = new Competition();
        $ret = $competiotion_model->selectRandTicket($cnt, $competition_id,$picket_tickets);
        return json_encode($ret,1);
    }
    
    public function ajaxAvailSelectTicket(){
        if(!Sentinel::getUser()){
            $ret = array();
            $ret['status'] = "-1";
            $ret['msg'] = "Please login !";
            return json_encode($ret);
        }
        $ticket_id = $this->getParam("ticket_id", "0");
        $ret = Competition::isAvailSelectTicket($ticket_id);
        return json_encode($ret,1);
    }
    
    public function ajaxInsertBasket(){
        if(!Sentinel::getUser()){
            $ret = array();
            $ret['status'] = "-1";
            $ret['msg'] = "Please login !";
            return json_encode($ret);
        }
        $user = Sentinel::getUser();
        $user_id = $user['id'];
        $competition_id = $this->getparam("competition_id", "0");
        $tickets = $this->getparam("tickets", "");
        $answerId = $this->getparam("answerId", "");
        $answerInfo = CompetitionAnswer::where("is_true", "1")->where("id", $answerId)->first();
        if(!isset($answerInfo['id'])){
            $ret = array();
            $ret['status'] = "0";
            $ret['msg'] = "Please select correct answer !";
            return json_encode($ret);
        }
        
        $userBasketModel = new UserBasket();
        $date = date("Y-m-d H:i:s");
        $ret = $userBasketModel->insertBasket($user_id,$competition_id,$tickets, $date);

        // for delete code after 5 minute 
        // ReleaseTickets::dispatch($user_id,$competition_id,$date)->delay(now()->addMinutes(5));
        return json_encode($ret);
        
    }
    
    
}