<?php

namespace App\Http\Model\Data;

use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'data_source';
    public $timestamps = false;
}
