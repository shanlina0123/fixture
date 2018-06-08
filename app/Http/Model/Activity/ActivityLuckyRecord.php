<?php

namespace App\Http\Model\Activity;

use Illuminate\Database\Eloquent\Model;

class ActivityLuckyRecord extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'activity_lucky_record';
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * 关联活动
     */
    public function luckyRecordToLucky()
    {
        return $this->belongsTo('App\Http\Model\Activity\ActivityLucky','activityluckid','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * 关联用户
     */
    public function luckyRecordToClient()
    {
        return $this->belongsTo('App\Http\Model\Client\Client','clientid','id');
    }
}
