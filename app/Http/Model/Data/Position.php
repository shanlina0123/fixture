<?php

namespace App\Http\Model\Data;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'data_position';
    public $timestamps = false;
}
