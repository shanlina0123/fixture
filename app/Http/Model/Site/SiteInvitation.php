<?php

namespace App\Http\Model\Site;

use Illuminate\Database\Eloquent\Model;

class SiteInvitation extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'site_invitation';
    public $timestamps = true;


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * 关联工地
     */
    public function invitationToSite()
    {
        return $this->belongsTo('App\Http\Model\Site\Site','siteid','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * 关联数据统计
     */
    public function invitationToDynamicStatistics()
    {
        return $this->belongsTo('App\Http\Model\Dynamic\DynamicStatistics','siteid','siteid');
    }
}
