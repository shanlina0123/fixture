<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/11
 * Time: 17:49
 */

namespace App\Http\Model\User;


use Illuminate\Database\Eloquent\Model;

class UserMpTemplate extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'user_mptemplate';
    public $timestamps = true;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * 关联公司信息
     */
    public function userToCompanyTemplate()
    {
        return $this->belongsTo('App\Http\Model\Company\CompanyMpTemplate','companytempid','id');
    }
}