<?php

namespace App\Http\Model\Client;

use Illuminate\Database\Eloquent\Model;

class ClientFollow extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'client_follow';
    public $timestamps = false;


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * 关联状态
     */
    public function clientFollowToStatus()
    {
        return $this->belongsTo('App\Http\Model\Data\ClientFollowStatus','followstatus_id','id');
    }

}
