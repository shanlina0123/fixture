<?php

namespace App\Http\Model\Vip;

use Illuminate\Database\Eloquent\Model;

class ConfVipfunctionpoint extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'conf_vipfunctionpoint';
    public $timestamps = true;

}
