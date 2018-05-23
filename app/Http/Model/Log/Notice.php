<?php

namespace App\Http\Model\Log;
use Illuminate\Database\Eloquent\Model;
class Notice extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'log_notice';
    public $timestamps = true;
}
    