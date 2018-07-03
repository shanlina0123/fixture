<?php

namespace App\Http\Model\Vip;

use Illuminate\Database\Eloquent\Model;

class LogVipupgrade extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'log_vipupgrade';
    public $timestamps = false;

}
