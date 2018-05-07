<?php

namespace App\Http\Model\Data;

use Illuminate\Database\Eloquent\Model;

class StageTemplate extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'data_stagetemplate';
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * 关联阶段
     */
    public function stageTemplateToTemplateTag()
    {
        return $this->hasMany('App\Http\Model\Data\StageTemplateTag','stagetemplateid','id');
    }

}
