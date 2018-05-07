<?php

namespace App\Http\Model\Data;

use Illuminate\Database\Eloquent\Model;

class StageTemplateTag extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'data_stagetemplate_tag';
    public $timestamps = false;
}
