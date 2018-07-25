<?php

namespace App\Http\Model\Admin\Report;
use App\Http\Model\Common\AdminDB;
class Report extends AdminDB
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'data_report';
    public $timestamps = true;

}
