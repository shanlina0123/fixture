<?php

namespace App\Http\Model\Dynamic;

use Illuminate\Database\Eloquent\Model;

class DynamicImages extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'dynamic_images';
    public $timestamps = false;
}
