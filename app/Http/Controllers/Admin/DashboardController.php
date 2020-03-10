<?php namespace App\Http\Controllers\Admin;

use App\Competition;
use App\Http\Controllers\JoshController;
use App\Http\Requests\UserRequest;
use App\Order;
use App\User;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use File;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Redirect;
use Sentinel;
use URL;
use View;
use Yajra\DataTables\DataTables;
use Validator;
Use App\Mail\Restore;
use stdClass;


class DashboardController extends JoshController
{

    /**
     * Show a list of all the users.
     *
     * @return View
     */

    public function index()
    {
        // Show the page
        
        $competitionModel = new Competition();
        $activeList = $competitionModel->getDashboardActiveList()->take(10);
        view()->share("activeList", $activeList);
        
        $competitionData = $competitionModel->getDashboardCompetitionCount();
        view()->share("competitionData", $competitionData);
        
        $orderModel = new Order();
        $orderData = $orderModel->getDashboardOrderCount();
        view()->share("orderData", $orderData);
        
        return view('admin_panel.dashboard.index');
    }
    
    public function getChartData(){
        $result = array();
        $result['status'] = "1";
        $orderModel = new Order(); 
        $data = $orderModel->getRecentlyChartData();
        $result['data'] = $data;
        $totalCount = 0;
        $totalPrice = 0;
        foreach($data as $item){
            $totalCount += $item['a'];
            $totalPrice += $item['b'];
        }
        
        $result['price'] = $totalPrice;
        $result['cnt'] = $totalCount;
        return json_encode($result,1);
    }
}
