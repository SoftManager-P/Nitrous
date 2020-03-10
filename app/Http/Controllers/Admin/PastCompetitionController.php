<?php namespace App\Http\Controllers\Admin;


use App\Competition;
use App\CompetitionAnswer;
use App\CompetitionTicket;
use App\CompetitionImg;
use Sentinel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PastCompetitionController extends Controller
{
    
    public function index()
    {
        $pageParam = $this->getPageParam();
        $search = $this->getParam("search", "");
        view()->share('search', $search);
        $model = new Competition();
        $where = array();
        $model = $model->where($where);
        $whereRaw = "1=1 AND photo != ''";
        $model = $model->whereRaw($whereRaw);
        if($search != ''){
            $model = $model->whereRaw("name LIKE '%".$search."%'");
        }

        $count = $model->count();
        $list = $model->skip($pageParam["start"])->take($pageParam["perPageSize"])->get();
        $pageParam = $this->setPageParam($pageParam, $count);
        view()->share('pageParam', $pageParam);
        view()->share("list", $list);
        return view('admin_panel.past_competition.index');
    }

    public function info($id){
        view()->share("id", $id);
        $info = Competition::find($id);
        if($id *1 > 0 && !isset($info['id'])) {return redirect("404");}
        if($id*1 == 0) {
            $competitionList = Competition::get();
            view()->share("competitionList", $competitionList);
            return view('admin_panel.past_competition.add');
        }else{
            view()->share("info", $info);
        }
        
        return view('admin_panel.past_competition.info');
    }

    public function ajaxUpdateInfo(Request $request){
        $id = $request->get("id");
        $info = Competition::find($id);
        if(!isset($info['id'])){
            return json_encode(array("status"=>"0", "msg"=>"Not found information"));
        }
        $this->getBoClass2($info, $request);
        $photo = $this->getParam("photo", "");
        if($photo != '' &&  strpos($photo, 'data:image/') !== false){
            $photo = $this->genImage($photo);
        }
        $info['photo'] = $photo;
        $info->save();
        return json_encode(array('status'=>1));
    }

    public function ajaxDeleteInfo(Request $request, $id){
        //$id = $request->get("id");
        $info = Competition::find($id);
        if(!isset($info['id'])){
            return redirect("admin/past");
            //return json_encode(array("status"=>"0", "msg"=>"Not found information"));
        }
        $key_a = array("delivery_video_ur1","draw_video_url","winner_user_name","ticket_number","photo");
        foreach($key_a as $key){
            $info[$key] = '';
        }
        $info->save();
        return redirect("admin/past");
        //return json_encode(array('status'=>1));
    }


}