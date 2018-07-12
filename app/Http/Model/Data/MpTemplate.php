<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/12
 * Time: 10:42
 */

namespace App\Http\Model\Data;


use Illuminate\Database\Eloquent\Model;

class MpTemplate extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'data_mptemplate';
    public $timestamps = false;

    /**
     *  关联公司信息
     */
    public function templateToCompanyTemplate()
    {
         return $this->belongsTo('App\Http\Model\Company\CompanyMpTemplate','id','datatemplateid');
    }
}