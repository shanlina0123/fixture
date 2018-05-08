<?php

namespace App\Http\Model\Site;

use Illuminate\Database\Eloquent\Model;

class SiteFollowrecord extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'site_followrecord';


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * 观光团
     */
    public function followToOuristparty()
    {
        return $this->belongsTo('App\Http\Model\Ouristparty\Ouristparty','followuserid','id');
    }
}
