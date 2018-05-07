<?php

namespace App\Http\Model\Site;

use Illuminate\Database\Eloquent\Model;

class SiteStageschedule extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'site_stageschedule';
    public $timestamps = false;
}
