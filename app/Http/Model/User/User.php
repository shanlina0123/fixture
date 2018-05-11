<?php

namespace App\Http\Model\User;
use Illuminate\Database\Eloquent\Model;
class User extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'user';
    public $timestamps = true;
    protected $hidden = [
        'created_at','updated_at','password'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * 关联角色
     */
    public function dynamicToRole()
    {
        return $this->belongsTo('App\Http\Model\Filter\FilterRole','roleid','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * 关联门店
     */
    public function dynamicToStore()
    {
        return $this->belongsTo('App\Http\Model\Store\Store','storeid','id');
    }

}
    