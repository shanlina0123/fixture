<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/20
 * Time: 16:07
 */

namespace App\Http\Model\Site;


use Illuminate\Database\Eloquent\Model;

class SiteEvaluate extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'site_evaluate';
    public $timestamps = true;
}