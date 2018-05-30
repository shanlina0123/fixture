<?php

namespace App\Http\Model\Activity;

use Illuminate\Database\Eloquent\Model;

class ActivityInrecord extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'activity_inrecord';
    public $timestamps = false;


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * 关联活动
     */
    public function activityToInrecord()
    {
        return $this->belongsTo('App\Http\Model\Activity\Activity','activityid','id');
    }

}
