<?php

namespace App\Http\Model\Filter;

use Illuminate\Database\Eloquent\Model;

class FilterUserauth extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'filter_userauth';
    public $timestamps = false;
}
