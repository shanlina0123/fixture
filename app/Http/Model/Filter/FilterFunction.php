<?php

namespace App\Http\Model\Filter;

use Illuminate\Database\Eloquent\Model;

class FilterFunction extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'filter_function';
    public $timestamps = false;
}
