<?php

namespace App\Http\Model\Dynamic;

use Illuminate\Database\Eloquent\Model;

class DynamicStatistics extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'dynamic_statistics';
    public $timestamps = false;
}
