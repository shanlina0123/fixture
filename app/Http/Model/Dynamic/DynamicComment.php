<?php

namespace App\Http\Model\Dynamic;

use Illuminate\Database\Eloquent\Model;

class DynamicComment extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'dynamic_comment';
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * 关联用户
     */
    public function dynamicCommentToUser()
    {
        return $this->belongsTo('App\Http\Model\User\User','createuserid','id');
    }

}
