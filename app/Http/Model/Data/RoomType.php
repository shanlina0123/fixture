<?php

namespace App\Http\Model\Data;

use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'data_roomtype';
    public $timestamps = false;
}
