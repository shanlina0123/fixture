<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/29
 * Time: 14:49
 */

namespace App\Http\Model\Company;


use Illuminate\Database\Eloquent\Model;

class CompanyWxTemplet extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'company_wxtemplet';
    public $timestamps = false;
}