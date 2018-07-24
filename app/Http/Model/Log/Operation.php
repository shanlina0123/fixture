<?php

namespace App\Http\Model\Log;
use Illuminate\Database\Eloquent\Model;
class Operation extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'log_operation';
    public $timestamps = true;
}
