<?php

namespace App\Http\Model\Site;

use Illuminate\Database\Eloquent\Model;

class SiteFollowrecord extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'site_followrecord';
    public $timestamps = true;
}
