<?php

namespace App\Http\Model\Company;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'company';
    public $timestamps = true;

}
