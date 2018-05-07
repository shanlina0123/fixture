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
     * 活动参与方式关联
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function participatory()
    {
        return $this->belongsTo('App\Http\Model\Data\Participatory','participatoryid','id');
    }

}
