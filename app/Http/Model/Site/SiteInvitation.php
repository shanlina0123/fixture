<?php

namespace App\Http\Model\Site;

use Illuminate\Database\Eloquent\Model;

class SiteInvitation extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'site_invitation';
    public $timestamps = true;
}
