<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/14
 * Time: 15:43
 */

namespace App\Http\Model\Data;


use Illuminate\Database\Eloquent\Model;

class SelectDefault extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'data_select_default';
    public $timestamps = false;

}