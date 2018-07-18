<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/18
 * Time: 10:06
 */

namespace App\Http\Model\User;


use Illuminate\Database\Eloquent\Model;

class UserDynamicGive extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'user_dynamic_give';
    public $timestamps = true;
    protected $hidden = [
        'created_at','updated_at'
    ];
}