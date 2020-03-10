<?php namespace App\Http\Controllers\Admin;


use App\Competition;
use App\Order;
use App\CompetitionTicket;
use App\OrderDetail;
use Sentinel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $pageParam = $this->getPageParam();
        $search = $this->getParam("search", "");
        view()->share('search', $search);
        $model = new Order();
        $where = array();
        $model = $model->where($where);
        if($search != ''){
            $model = $model->whereRaw("order_number LIKE '%".$search."%'");
        }
        
        $start_date = $this->getParam("start_date", "");
        view()->share('start_date', $start_date);
        if($start_date != ''){
            $model = $model->whereRaw("date_format(order_time, '%Y-%m-%d') >= '{$start_date}'");
        }

        $end_date = $this->getParam("end_date", "");
        view()->share('end_date', $end_date);
        if($end_date != ''){
            $model = $model->whereRaw("date_format(order_time, '%Y-%m-%d') <= '{$end_date}'");
        }
        
        $count = $model->count();
        $list = $model->skip($pageParam["start"])->take($pageParam["perPageSize"])->get();
        $pageParam = $this->setPageParam($pageParam, $count);
        view()->share('pageParam', $pageParam);
        view()->share("list", $list);
        return view('admin_panel.order.index');
    }
    
    

    public function info($id){
        view()->share("id", $id);
        $info = Order::find($id);
        if(!isset($info['id'])) {return redirect("404");}
        view()->share("info", $info);
        $detailList = OrderDetail::where("order_id", $id)->get();
        view()->share("detailList", $detailList);
        return view('admin_panel.order.info');
    }
    
    public function ajaxSaveInfo(Request $request){
        $id = $request->get("id");
        $info = Order::find($id);
        
        if(isset($info['id'])){
            $this->getBoClass($info, $request);
        }else{
            return json_encode(array('status'=>0, "msg"=> "Not found information"));
        }
        
        $info->save();
        return json_encode(array('status'=>1));
    }

    

    public function ajaxDeleteInfo(Request $request){
        $id = $request->get("id");
        if(Order::isDelete($id)){
            Order::where(array("id"=>$id))->delete();
            return json_encode(array('status' => 1));
        }else{
            return json_encode(array('status' => 0, 'msg'=> 'Can not delete this item'));
        }
    }


    


}