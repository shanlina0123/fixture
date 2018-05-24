<?php

namespace App\Http\Model\Activity;

use Illuminate\Database\Eloquent\Model;

class ActivityLuckyRecord extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'activity_lucky_record';
    public $timestamps = false;

}
