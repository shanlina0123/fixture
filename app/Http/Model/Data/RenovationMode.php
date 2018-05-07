<?php

namespace App\Http\Model\Data;

use Illuminate\Database\Eloquent\Model;

class RenovationMode extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'data_renovationmode';
    public $timestamps = false;
}
