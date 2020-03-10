<?php namespace App\Http\Controllers\Admin;


use App\Competition;
use App\CompetitionAnswer;
use App\CompetitionTicket;
use App\CompetitionImg;
use App\PromoCode;
use Sentinel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PromoCodeController extends Controller
{
    public function index()
    {
        $pageParam = $this->getPageParam();
        $search = $this->getParam("search", "");
        view()->share('search', $search);
        $model = new PromoCode();
        $where = array();
        $model = $model->where($where);
        if($search != ''){
            $model = $model->whereRaw("promo_code LIKE '%".$search."%'");
        }
        $count = $model->count();
        $list = $model->skip($pageParam["start"])->take($pageParam["perPageSize"])->get();
        $pageParam = $this->setPageParam($pageParam, $count);
        view()->share('pageParam', $pageParam);
        view()->share("list", $list);
        return view('admin_panel.promo_code.index');
    }

    public function info($id){
        view()->share("id", $id);
        $info = PromoCode::find($id);
        if($id *1 > 0 && !isset($info['id'])) {return redirect("404");}
        if($id*1 == 0) {$info = new Competition();}
        view()->share("info", $info);
        return view('admin_panel.promo_code.info');
    }
    
    public function ajaxSaveInfo(Request $request){
        $id = $request->get("id");
        $info = PromoCode::find($id);
        if(isset($info['id'])){
            $this->getBoClass($info, $request);
        }else{
            $info = new PromoCode();
            $ret = $this -> getBoClass($info,$request, 'tb_promo_code');
            $info = $ret['model'];
        }
          
        
        $info->save();
        return json_encode(array('status'=>1));
    }

    public function ajaxDeleteInfo(Request $request){
        $id = $request->get("id");
        if(PromoCode::isDelete($id)){
            PromoCode::where(array("id"=>$id))->delete();
            return json_encode(array('status' => 1));
        }else{
            return json_encode(array('status' => 0, 'msg'=> 'Can not delete this item'));
        }
    }


    


}