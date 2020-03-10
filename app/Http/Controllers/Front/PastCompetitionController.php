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

class PastCompetitionController extends JoshController
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
        $pageParam = $this->setPageParam($pageParam, $count, url("past"),"sortKey={$sortKey}");
        view()->share('pageInfo', $pageParam);
        view()->share("list", $list);
        $this->getDiffVal();
        return view("front/past-competitions");
    }
    
    
}