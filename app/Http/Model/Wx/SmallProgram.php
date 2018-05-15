<?php

namespace App\Http\Model\Wx;

use Illuminate\Database\Eloquent\Model;

class SmallProgram extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'small_program';
    public $timestamps = true;

}
