<?php namespace App\Http\Controllers\Front;

use App\Competition;
use App\CompetitionAnswer;
use App\CompetitionImg;
use App\CompetitionTicket;
use\App\Http\Controllers\JoshController;
use App\Http\Requests\ConfirmPasswordRequest;
use App\Jobs\ReleaseTickets;
use App\PromoCode;
use App\UserBasket;
use App\UserBasketPromoCode;
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
use App\paytriot;

class BasketController extends JoshController
{
    /**
     * @var paytriot\Payment
     */
    protected $payment;
    
    public function __construct(paytriot\Payment $payment)
    {
        parent::__construct();
        $this->payment = $payment;
        if(Sentinel::getUser()){
            $user = Sentinel::getUser();
            $user_id = $user['id'];
            $basketModel = new UserBasket();
            $ret = $basketModel->getUserBasketList($user_id);
            view()->share("diff", $ret['diff']);
        }else{
            view()->share("diff", "");
        }
    }
    public function cart($comp_id, Request $request){
        if(!Sentinel::getUser()){
            return redirect("login");
        }

//        $data = $this->payment->getData();
//        dd($data);

        $user = Sentinel::getUser();
        $user_id = $user['id'];
        $basketModel = new UserBasket();
        $ret = $basketModel->getUserBasketList($user_id);
        view()->share("list", $ret['list']);
        view()->share("diff", $ret['diff']);
        view()->share("curDate", date("Y-m-d H:i:s"));
        /*$job = (new ReleaseTickets("2","4",'2020-02-23 18:24:06'))->delay(60);
        $this->dispatch($job);*/
        $promoCodeInfo = UserBasketPromoCode::where("user_id", $user_id)->first();
        view()->share("promoCodeInfo",$promoCodeInfo);
        // for test 
        //ReleaseTickets::dispatch("2","4",'2020-02-23 18:24:06')->delay(now()->addMinutes(10));
        ReleaseTickets::dispatch($user_id, $comp_id, date("Y-m-d H:i:s"))->delay(now()->addMinutes(5));
        
        return view("front.cart");
    }
    
    public function deleteCartCompetition(){
        $competition_id = $this->getParam("competiotion_id", "0");
        if(!Sentinel::getUser()){
            return json_encode(array("status"=>"0", "msg" => "Please loign!"));
        }
        $user = Sentinel::getUser();
        $user_id = $user['id'];
        $list = UserBasket::where(array("user_id"=>$user_id, "competition_id"=>$competition_id))->get();
        foreach($list as $item){
            $ticket_id = $item['ticket_id'];
            $ticket = CompetitionTicket::find($ticket_id);
            $ticket['status'] = 0;
            $ticket['seleted_time'] = "0000-00-00 00:00:00" ;
            $ticket['selected_user_id'] = "0" ;
            $ticket->save();
        }
        UserBasket::where(array("user_id"=>$user_id, "competition_id"=>$competition_id))->delete();
        return json_encode(array("status"=>"1", "msg" => "The operation is successful!"));
    }
    
    public function applyCoupon(){
        $code = $this->getParam("code", "");
        if($code == ""){
            return Redirect::back()->with("error", "Please input coupon code!");
        }
        $user = Sentinel::getUser();
        if(!$user){
            return redirect("login");
        }
        $user_id = $user['id'];
        $promoCodeInfo = PromoCode::where("promo_code", $code)->first();
        if(!isset($promoCodeInfo['id'])){
            return Redirect::back()->with("error","The code information is incorrect!");  
        }
        
        $userBasketPromoCodeModel = new UserBasketPromoCode();
        $ret = $userBasketPromoCodeModel->isCheckPromoCode($user_id,$promoCodeInfo['id']);
        if($ret['status']*1 == 0){
            return Redirect::back()->with('error',$ret['msg']);
        }
        
        $userBasketPromoCode = new UserBasketPromoCode();
        $userBasketPromoCode['user_id'] = $user_id;
        $userBasketPromoCode['promo_code_id'] = $promoCodeInfo['id'];
        $userBasketPromoCode->save();
        return Redirect::back();
    }
    
    public function checkout(){
        if(!Sentinel::getUser()){
            return redirect("login");
        }
        $user = Sentinel::getUser();
        $user_id = $user['id'];
        $basketModel = new UserBasket();
        $ret = $basketModel->getUserBasketList($user_id);
        view()->share("list", $ret['list']);
        //view()->share("min_date", $ret['min_date']);
        view()->share("diff", $ret['diff']);
        view()->share("curDate", date("Y-m-d H:i:s"));
        $promoCodeInfo = UserBasketPromoCode::where("user_id", $user_id)->first();
        view()->share("promoCodeInfo",$promoCodeInfo);
        return view("front.checkout");
    }
    
    
    
    
}