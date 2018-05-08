<?php

namespace App\Http\Model\Filter;

use Illuminate\Database\Eloquent\Model;

class FilterRoleFunction extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'filter_role_function';
    public $timestamps = true;
}
