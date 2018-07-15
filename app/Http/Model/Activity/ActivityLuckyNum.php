<?php

namespace App\Http\Model\Activity;

use Illuminate\Database\Eloquent\Model;

class ActivityLuckyNum extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'activity_luck_num';
    public $timestamps = false;

    /**
     * 关联客户表
     */
    public function LuckyNumToClient()
    {
        return $this->belongsTo('App\Http\Model\Client\Client','clientid','id');
    }
}
