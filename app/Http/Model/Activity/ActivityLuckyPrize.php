<?php

namespace App\Http\Model\Activity;

use Illuminate\Database\Eloquent\Model;

class ActivityLuckyPrize extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'activity_lucky_prize';
    public $timestamps = false;



}
