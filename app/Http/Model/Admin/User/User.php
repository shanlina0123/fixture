<?php

namespace App\Http\Model\Admin\User;
use App\Http\Model\Common\AdminDB;

class User extends AdminDB
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'user';
    public $timestamps = true;
    protected $hidden = [
        'created_at','updated_at','password'
    ];


}
    