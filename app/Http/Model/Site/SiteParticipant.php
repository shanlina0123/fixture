<?php

namespace App\Http\Model\Site;

use Illuminate\Database\Eloquent\Model;

class SiteParticipant extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'site_participant';
    public $timestamps = true;
}
