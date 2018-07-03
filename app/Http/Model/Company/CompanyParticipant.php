<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/28
 * Time: 10:38
 */

namespace App\Http\Model\Company;


use Illuminate\Database\Eloquent\Model;

class CompanyParticipant extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'company_participant';
    public $timestamps = false;


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * 关联职位
     */
    public function participantToPosition()
    {
        return $this->belongsTo('App\Http\Model\Data\Position','positionid','id');
    }
}