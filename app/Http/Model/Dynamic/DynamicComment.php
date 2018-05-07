<?php

namespace App\Http\Model\Dynamic;

use Illuminate\Database\Eloquent\Model;

class DynamicComment extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'dynamic_comment';
    public $timestamps = false;
}
