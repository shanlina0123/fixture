<?php

namespace App\Http\Model\Client;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'client';
    public $timestamps = false;


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * 关联状态
     */
    public function clientToStatus()
    {
        return $this->belongsTo('App\Http\Model\Data\ClientFollowStatus','followstatusid','id');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * 关联来源
     */
    public function clientToSource()
    {
        return $this->belongsTo('App\Http\Model\Data\Source','sourceid','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * 关连跟进表
     */
    public function clientToClientFollow()
    {
        return $this->hasMany('App\Http\Model\Client\ClientFollow','client_id','id');
    }
}
