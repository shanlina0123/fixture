<?php

namespace App\Http\Model\Company;

use Illuminate\Database\Eloquent\Model;

class CompanyStageTemplate extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'company_stagetemplate';
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * 关联阶段
     */
    public function stageTemplateToTemplateTag()
    {
        return $this->hasMany('App\Http\Model\Company\CompanyStageTemplateTag','stagetemplateid','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * 关联工地
     */
    public function stageTemplateToSite()
    {
        return $this->hasMany('App\Http\Model\Site\Site','stagetemplateid','id');
    }
}
