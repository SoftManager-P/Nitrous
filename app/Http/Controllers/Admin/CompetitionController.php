<?php namespace App\Http\Controllers\Admin;


use App\Competition;
use App\CompetitionAnswer;
use App\CompetitionTicket;
use App\CompetitionImg;
use Sentinel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CompetitionController extends Controller
{
    public function index()
    {
        $pageParam = $this->getPageParam();
        $search = $this->getParam("search", "");
        view()->share('search', $search);
        $model = new Competition();
        $where = array();
        $model = $model->where($where);
        $whereRaw = "find_in_set(status, '-1,0')";
        $model = $model->whereRaw($whereRaw);
        if($search != ''){
            $model = $model->whereRaw("name LIKE '%".$search."%'");
        }

        $count = $model->count();
        $list = $model->skip($pageParam["start"])->take($pageParam["perPageSize"])->get();
        $pageParam = $this->setPageParam($pageParam, $count);
        view()->share('pageParam', $pageParam);
        view()->share("list", $list);
        return view('admin_panel.competition.index');
    }

    public function getInfo($id){
        view()->share("id", $id);
        $info = Competition::find($id);
        if($id *1 > 0 && !isset($info['id'])) {return redirect("404");}
        if($id*1 == 0) {$info = new Competition();}
        $imgList = CompetitionImg::where(array("competition_id"=>$id))->orderBy("order_num")->get();
        $imgList1 = array();
        for($i=0;$i<12;$i++){
            $imgList1[$i] = '';
        }
        $k = 0;
        foreach($imgList as $item){
            $imgList1[$item['order_num']] = $item['img'];
            $k=$item['order_num'];
        }
        view()->share("imgList", $imgList1);
        view()->share("info", $info);
        view()->share("imgListMax", $k);
        $answerList = CompetitionAnswer::where("competition_id", $id)->get();
        view()->share("answerList", $answerList);
        return view('admin_panel.competition.info');
    }
    
    public function ajaxSaveInfo(Request $request){
        $id = $request->get("id");
        $info = Competition::find($id);
        $is_update = true;
        if(isset($info['id'])){
            $this->getBoClass($info, $request);
        }else{
            $info = new Competition();
            $ret = $this -> getBoClass($info,$request, 'tb_competition');
            $info = $ret['model'];
            $is_update = false;    
        }
          
        
        $info->save();
        $answerList = $request->get('answerList');
        $answerList = json_decode($answerList,1);
        foreach($answerList as $item){
            $answer = $item['answer'];
            if(strpos($answer, 'data:image/') !== false){
                $answer = $this->genImage($answer, "answer");
            }
            if($item['id']*1 == 0){
                $answerInfo = new CompetitionAnswer();
            }else{
                $answerInfo = CompetitionAnswer::find($item['id']);
            }
            $answerInfo['competition_id'] = $info['id'];
            $answerInfo['answer'] = $answer;
            $answerInfo['answer_type'] = $item['answer_type'];
            $answerInfo['is_true'] = $item['is_true'];
            $answerInfo->save();
        }
        $this->uploadProductImage($request,$info['id']);
        
        if(!$is_update){
            $competitionTicketModel = new CompetitionTicket();
            $competitionTicketModel->genTickets($info['id'], $info['total_num']);    
        }
        return json_encode(array('status'=>1));
    }

    public function uploadProductImage(Request $request, $competition_id){
        $mainProductImg_val = $request->get('mainProductImg_val','');
        $path = $mainProductImg_val;
        if($mainProductImg_val != '' && false !== strpos($mainProductImg_val, 'data:image/')){
            $path = $this->genImage($mainProductImg_val);
        }
        $competition = Competition::find($competition_id);
        $path = str_replace(url("/"), "",$path);
        $competition['main_image'] = $path;
        
        $competition->save();
        for($i=0; $i<12 ; $i++){
            $img = $request->get('mainProductImg'.$i.'_val', '');
            $path = $img;
            if($img != '' &&  strpos($img, 'data:image/') !== false){
                $path = $this->genImage($img);
            }
            $path = str_replace(url("/"), "",$path);
            
            if($path == ''){
                $info = CompetitionImg::where(array('competition_id'=>$competition_id, 'order_num'=>$i))->first();
                if(isset($info['main_image']) && $info['main_image'] != ''){
                    @unlink(public_path($info['main_image']));
                }
                CompetitionImg::where(array('competition_id'=>$competition_id, 'order_num'=>$i))->delete();
            }else{
                $competitonImg = CompetitionImg::where(array('competition_id'=>$competition_id, 'order_num'=>$i))->first();
                if(!isset($productImg['id'])){
                    $competitonImg = new CompetitionImg();
                }else{
                    if(isset($competitonImg['img']) && $competitonImg['img'] != ''){
                        @unlink(public_path($competitonImg['img']));
                    }
                }

                $competitonImg['competition_id'] = $competition_id;
                $competitonImg['img'] = $path;
                $competitonImg['order_num'] = $i;
                $competitonImg->save();
            }
        }
    }

    public function ajaxUpdateInfo(Request $request){
        $id = $request->get("id");
        $info = Competition::find($id);
        if(!isset($info['id'])){
            return json_encode(array("status"=>"0", "msg"=>"Not found information"));
        }
        $this->getBoClass($info, $request);
        $photo = $this->getParam("photo", "");
        if($photo != '' &&  strpos($photo, 'data:image/') !== false){
            $photo = $this->genImage($photo);
        }
        $info['photo'] = $photo;
        $info->save();
        return json_encode(array('status'=>1));
    }

    public function ajaxDeleteInfo(Request $request){
        $id = $request->get("id");
        $ret = Competition::isDelete($id);
        if($ret['result']*1){
            $competitionModel = new Competition();
            $competitionModel->competitionDelete($id);
            //Competition::where(array("id"=>$id))->delete();
            return json_encode(array('status' => 1));
        }else{
            return json_encode(array('status' => 0, 'msg'=> $ret['msg']));
        }
    }


    public function findWinner($competition_id)
    {
        view()->share("competition_id", $competition_id);
        $pageParam = $this->getPageParam();
        $search = $this->getParam("search", "");
        view()->share('search', $search);
        $model = new CompetitionTicket();
        $where = array("competition_id"=>$competition_id);
        $model = $model->where($where);
        if($search != ''){
            $model = $model->whereRaw("ticket_no LIKE '%".$search."%'");
        }

        $count = $model->count();
        $model->orderBy("id");
        $list = $model->skip($pageParam["start"])->take($pageParam["perPageSize"])->get();
        $pageParam = $this->setPageParam($pageParam, $count);
        view()->share('pageParam', $pageParam);
        view()->share("list", $list);
        return view('admin_panel.competition.find_winner');
    }
    
    public function setWinner(){
        $id = $this->getParam("id", "0");
        $info = CompetitionTicket::find($id);
        if(!isset($info['id'])){
            return json_encode(array('status' => '0', 'msg' => 'Not found ticket information'));
        }
        $info['is_winner'] = 1;
        $info->save();
        return json_encode(array('status' => '1', 'msg' => 'The operation is successful!'));
    }


    public function past()
    {
        $pageParam = $this->getPageParam();
        $search = $this->getParam("search", "");
        view()->share('search', $search);
        $model = new Competition();
        $where = array();
        $model = $model->where($where);
        $whereRaw = "find_in_set(status, '1,2')";
        $model = $model->whereRaw($whereRaw);
        if($search != ''){
            $model = $model->whereRaw("name LIKE '%".$search."%'");
        }

        $count = $model->count();
        $list = $model->skip($pageParam["start"])->take($pageParam["perPageSize"])->get();
        $pageParam = $this->setPageParam($pageParam, $count);
        view()->share('pageParam', $pageParam);
        view()->share("list", $list);
        return view('admin_panel.competition.past');
    }

    public function doing_edit($id){
        view()->share("id", $id);
        $info = Competition::find($id);
        if($id *1 > 0 && !isset($info['id'])) {return redirect("404");}
        if($id*1 == 0) {$info = new Competition();}
        view()->share("info", $info);
        return view('admin_panel.competition.doing_edit');
    }


}