<?php

namespace App\Http\Model\Data;

use Illuminate\Database\Eloquent\Model;

class RoomStyle extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'data_roomstyle';
    public $timestamps = false;
}
