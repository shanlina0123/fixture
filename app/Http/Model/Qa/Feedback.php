<?php

namespace App\Http\Model\Qa;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'qa_feedback';
    public $timestamps = false;
}
