<?php

namespace App\Http\Model\Site;

use Illuminate\Database\Eloquent\Model;

class SiteFollowrecord extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'site_followrecord';
    public $timestamps = false;


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * 关联工地
     */
    public function followToSite()
    {
        return $this->belongsTo('App\Http\Model\Site\Site','siteid','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * 关联数据统计
     */
    public function followToDynamicStatistics()
    {
        return $this->belongsTo('App\Http\Model\Dynamic\DynamicStatistics','siteid','siteid');
    }

    public function followToUser()
    {
        return $this->belongsTo('App\Http\Model\User\User','userid','id');
    }
}
