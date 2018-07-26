<?php

namespace App\Http\Model\Activity;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'activity';
    public $timestamps = false;

    /***
     * 关联门店
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ActivityToStore()
    {
        return $this->belongsTo('App\Http\Model\Store\Store','storeid','id');
    }
    /***
     * 关联用户
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ActivityToUser()
    {
        return $this->belongsTo('App\Http\Model\User\User','userid','id');
    }

    /***
     * 活动参与方式关联
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ActivityToParticipatory()
    {
        return $this->belongsTo('App\Http\Model\Data\Participatory','participatoryid','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * 关联活动图片
     */
    public function ActivityToImg()
    {
        return $this->hasMany('App\Http\Model\Activity\ActivityImg','activityid','id');
    }

}
