<?php

namespace App\Http\Model\Filter;

use Illuminate\Database\Eloquent\Model;

class FilterRoleauthority extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'filter_roleauthority';
    public $timestamps = false;
}
