<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompetitionImg extends Model {

    protected $table = 'tb_competition_img';
    protected $guarded = ['id'];
    public  $timestamps = false;

    static public  function isDelete($id){
        return true;
    }

   
}
