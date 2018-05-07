<?php

namespace App\Http\Model\Data;

use Illuminate\Database\Eloquent\Model;

class Participatory extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'data_participatory';
    public $timestamps = false;


    public  function  aaa()
    {
        return 1;
    }
}
