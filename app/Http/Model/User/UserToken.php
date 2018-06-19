<?php

namespace App\Http\Model\User;
use Illuminate\Database\Eloquent\Model;
class UserToken extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'user_token';
    public $timestamps = true;
    protected $hidden = [
        'created_at','updated_at','password','type'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * 关联用户表
     */
    public function tokenToUser()
    {
        return $this->belongsTo('App\Http\Model\User\User','userid','id');
    }

}
    