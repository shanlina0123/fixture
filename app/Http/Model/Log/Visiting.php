<?php

namespace App\Http\Model\Log;
use Illuminate\Database\Eloquent\Model;
class Visiting extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'log_visit';
    public $timestamps = true;
}
