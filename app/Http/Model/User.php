<?php

namespace App\Http\Model\User;
use Illuminate\Database\Eloquent\Model;
class User extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'user';
    public $timestamps = true;
}
    