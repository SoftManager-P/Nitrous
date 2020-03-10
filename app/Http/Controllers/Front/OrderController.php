<?php namespace App\Http\Controllers\Front;

use App\Competition;
use App\CompetitionAnswer;
use App\CompetitionImg;
use App\CompetitionTicket;
use\App\Http\Controllers\JoshController;
use App\Http\Requests\ConfirmPasswordRequest;
use App\Order;
use App\OrderDetail;
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
use App\paytriot;

class OrderController extends JoshController
{
  /**
 * @var paytriot\Payment
 */
    protected $payment;
    
    public function __construct(paytriot\Payment $payment)
    {
        parent::__construct();
        $this->payment = $payment;
    }
    
    public function createOrder(){
        if(!Sentinel::getUser()){
            $ret = array();
            $ret['status'] = "0";
            $ret['msg'] = "Please login!";
            return json_encode($ret,1);
        }
        
        
        $user = Sentinel::getUser();
        $user_id = $user['id'];
        $basketModel = new UserBasket();
        $otherInfo = array();
        $key_a = array("user_name", "address","city","postcode", "country","county","phone", "address1", "address2","first_name", "last_name");
        foreach($key_a as $key){
            $otherInfo[$key] = $this->getParam($key, "");
        }
        $ret = $basketModel->createOrder($user_id,$otherInfo);
        return json_encode($ret,1);
    }
    
    
    public function paymentProcess($order_number){
        $user = Sentinel::getUser();
        $order = Order::whereRaw("order_number = '".$order_number."'")->first();
        $data = array(
            'amount'=>$order->total_price*100,
            'orderRef'=>'NITROUS - Ticket Booking',
            'customerName'=>$order->first_name.' '.$order->last_name,
            'customerAddress'=>$order->address1,
            'customerTown'=>$order->address2,
            'customerCounty'=>$order->country,
            'customerPostcode'=>$order->postcode,
            'zip'=>$order->postcode,
            'customerEmail'=>$user->email,
            'customerOrderRef'=>$user->id,
            'formResponsive'=>'Y',
            'transactionUnique'=>$order->order_number,
        );
        $this->payment->setData($data);

        $process_form = $this->payment->buildForm();

        view()->share("process_form", $process_form);
        return view("front.payment_process");
    }
    
    public function payCallback(){
        $params = $_POST;
        $user = Sentinel::getUser();
        $user_id = $user->id;
        $order_number = $params['transactionUnique'];
        $exist = Order::whereRaw("order_number = '".$order_number."'")->first();

        if(empty($exist) || $params['responseStatus'] != 0){
            $error = ($params['responseMessage'])?$params['responseMessage']:'Invalid payment transaction.';
            view()->share("error", $error);

            if(!empty($exist)){

                $order_id = $exist->id;
                $order = Order::find($order_id);
                $order->delete();
            }

            return view("front.payment_failure");
        }else{
            $order_id = $exist->id;
            $order = Order::find($order_id);
            $date = date("Y-m-d H:i:s");
            $transCode = $params['xref'];
            $order->status = 1;
            $order->trans_code = $transCode;
            $order->trans_time = $date;
//            $order->callbackResponse = json_encode($params);
            $order->save();
            view()->share("detail", $params);
            //dd($params);

            //update ticket to sold
            $order_id = $order['id'];
            $order_time = date("Y-m-d H:i:s");

            $basketList = UserBasket::where("user_id", $user_id)->orderBy("competition_id")->orderBy("ticket_id")->get();
            foreach($basketList as $item){
                $order_detail = new OrderDetail();
                $order_detail['order_id'] = $order_id;
                $order_detail['competition_id'] = $item['competition_id'];
                $order_detail['ticket_id'] = $item['ticket_id'];
                $competition = Competition::find($item['competition_id']);
                $price = 0;
                if(isset($competition['id'])){
                    $price = $competition['price'];
                }
                $order_detail['price'] = $price;
                $competitionTicket = CompetitionTicket::find($item['ticket_id']);
                if(isset($competitionTicket['id'])){
                    //set ticket to sold
                    $competitionTicket['status'] = 2;
                    $competitionTicket['selected_user_id'] = $user_id;
                    $competitionTicket['seleted_time'] = $order_time;
                    $competitionTicket->save();
                    $order_detail->save();
                }
            }
            $userBasket = new UserBasket();
            $userBasket->where("user_id",$user_id)->delete();

            return view("front.payment_success");
        }



    }
    
    public function timeout($order_number){
        //remove order if timeout
        $user = Sentinel::getUser();
        $user_id = $user->id;

        if($order_number){
            $exist = Order::whereRaw("order_number = '".$order_number."'")->first();
            if(!empty($exist)){
                $order_id = $exist->id;
                $order = Order::find($order_id);
                $order->delete();
            }
        }


        return view("front.payment_timeout");
    }

    public function paySuccess(){
        $order_id = $this->getParam("order_id", "0");
        $order = Order::find($order_id);
        $date = date("Y-m-d H:i:s");
        $transCode = "PK".date("YmdHis").rand(11111,9999);
        $order['status'] = 1;
        $order['trans_code'] = $transCode;
        $order['trans_time'] = $date;
        $order->save();
        return json_encode(array("status"=>"1"));
    }
    
    public function orderDetails($id){
        $order = Order::find($id);
        view()->share("order", $order);
        $orderDetail = new OrderDetail();
        $detailList = $orderDetail->orderDetailList($id);
        view()->share("detailList", $detailList);
        return view("front.order-details");
    }
    
   
    
    
}