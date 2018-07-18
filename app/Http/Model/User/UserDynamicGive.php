<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/18
 * Time: 10:06
 */

namespace App\Http\Model\User;


class UserDynamicGive
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'fixture_user_dynamic_give';
    public $timestamps = false;
    protected $hidden = [
        'created_at'
    ];
}