<?php namespace App\Http\Controllers\Front;

use App\Competition;
use\App\Http\Controllers\JoshController;
use App\Http\Requests\ConfirmPasswordRequest;
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

class HomeController extends JoshController
{
    
    public function __construct()
    {
        parent::__construct();
    }
    public function index(){
        $liveCompetitions = Competition::where("status", "0")->paginate(10);
        view()->share("liveCompetiotions", $liveCompetitions);
        
        $where = "photo !=''";
        $pastCompetitions = Competition::whereRaw($where)->paginate(10);
        view()->share("pastCompetitions", $pastCompetitions);
        $this->getDiffVal();
        return view("front/index");
    }
}