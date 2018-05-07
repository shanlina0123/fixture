<?php

namespace App\Http\Model\Dynamic;

use Illuminate\Database\Eloquent\Model;

class Dynamic extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'dynamic';
    public $timestamps = false;


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * 关联评论
     */
    public function dynamicToFollo()
    {
        return $this->hasMany('App\Http\Model\Dynamic\DynamicComment','dynamicid','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * 关联图片
     */
    public function dynamicToImages()
    {
        return $this->hasMany('App\Http\Model\Dynamic\DynamicImages','dynamicid','id');
    }
}
