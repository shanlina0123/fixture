<?php

namespace App\Http\Model\Dynamic;

use Illuminate\Database\Eloquent\Model;

class Dynamic extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'dynamic';
    public $timestamps = false;
}
