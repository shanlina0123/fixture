<?php

namespace App\Http\Model\Company;

use Illuminate\Database\Eloquent\Model;

class CompanyStageTemplateTag extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'company_stagetemplate_tag';
    public $timestamps = false;
}
