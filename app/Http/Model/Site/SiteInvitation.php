<?php

namespace App\Http\Model\Site;

use Illuminate\Database\Eloquent\Model;

class SiteInvitation extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'site_invitation';
    public $timestamps = false;


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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * 关联用户
     */
    public function invitationToUser()
    {
        return $this->belongsTo('App\Http\Model\User\User','joinuserid','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * 关联店铺
     */
    public function invitationToStore()
    {
        return $this->belongsTo('App\Http\Model\Store\Store','storeid','id');
    }
}
