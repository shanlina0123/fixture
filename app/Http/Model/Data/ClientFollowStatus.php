<?php

namespace App\Http\Model\Data;

use Illuminate\Database\Eloquent\Model;

class ClientFollowStatus extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'data_client_followstatus';
    public $timestamps = false;

}
