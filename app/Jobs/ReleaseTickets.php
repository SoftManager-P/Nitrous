<?php

namespace App\Jobs;

use App\UserBasket;
use App\CompetitionTicket;
use App\UserBasketPromoCode;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ReleaseTickets implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected  $user_id;
    protected  $competition_id;
    protected  $date;
    public function __construct($user_id, $competition_id, $date)
    {
        //
        $this->user_id = $user_id;
        $this->competition_id = $competition_id;
        $this->date = $date;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {   
//        $basketList = UserBasket::where("user_id",$this->user_id)->where("competition_id", $this->competition_id)->whereRaw("create_date <= '{$this->date}'")->get();
//        file_put_contents("job.txt", print_r($basketList,1));
        /* after 5 minutes delete code */
        //UserBasket::where("user_id",$this->user_id)->where("competition_id", $this->competition_id)->whereRaw("create_date <= '{$this->date}'")->delete();
        UserBasket::where("user_id",$this->user_id)->where("competition_id", $this->competition_id)->whereRaw("create_date <= '{$this->date}'")->delete();
        CompetitionTicket::where("selected_user_id",$this->user_id)->where("competition_id", $this->competition_id)->where("status", 1)->whereRaw("seleted_time <= '{$this->date}'")->update(['status'=>0, 'seleted_time'=>'0000-00-00 00:00:00', 'selected_user_id'=>0]);
        UserBasketPromoCode::where("user_id",$this->user_id)->delete();
    }
}
