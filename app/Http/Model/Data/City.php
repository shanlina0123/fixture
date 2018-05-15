<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/14
 * Time: 15:43
 */

namespace App\Http\Model\Data;


use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'data_city';
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * 关联省份
     */
    public function CityToProvince()
    {
        return $this->belongsTo('App\Http\Model\Data\Province','provinceid','id');
    }
}