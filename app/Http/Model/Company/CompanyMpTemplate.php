<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/11
 * Time: 14:21
 */

namespace App\Http\Model\Company;


use Illuminate\Database\Eloquent\Model;

class CompanyMpTemplate extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'company_mptemplate';
    public $timestamps = true;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * 关联用户
     */
    public function companyToUserTemplate()
    {
        return $this->belongsTo('App\Http\Model\User\UserMpTemplate','datatemplateid','datatemplateid');
    }
}