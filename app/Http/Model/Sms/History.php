<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/11
 * Time: 11:24
 */

namespace App\Http\Model\Sms;
use Illuminate\Database\Eloquent\Model;
class History extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'sms_history';
    public $timestamps = false;
}