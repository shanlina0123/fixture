<?php

namespace App\Http\Model\Conf;

use Illuminate\Database\Eloquent\Model;

class Pc extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'conf_pc';
    public $timestamps = true;

}
