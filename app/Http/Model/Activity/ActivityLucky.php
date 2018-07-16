<?php

namespace App\Http\Model\Activity;

use Illuminate\Database\Eloquent\Model;

class ActivityLucky extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'activity_lucky';
    public $timestamps = false;


    /***
     * 关联门店
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function luckyToStore()
    {
        return $this->belongsTo('App\Http\Model\Store\Store','storeid','id');
    }
    /***
     * 关联用户
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function luckyToUser()
    {
        return $this->belongsTo('App\Http\Model\User\User','userid','id');
    }


}
