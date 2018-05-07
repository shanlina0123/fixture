<?php

namespace App\Http\Model\Filter;

use Illuminate\Database\Eloquent\Model;

class FilterAuthorityoperation extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'filter_authorityoperation';
    public $timestamps = true;
}
